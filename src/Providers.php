<?php # -*- coding: utf-8 -*-
/*
 * This file is part of the BrainFaker package.
 *
 * (c) Giuseppe Mazzapica
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Brain\Faker;

use Brain\Faker\Provider\Provider;
use Faker\Generator;

/**
 * @method \WP_Post post(array $data = [])
 * @method \WP_Post[] posts(int $howMany, array $data = [])
 * @method MonkeyWpUser user(array $data = [])
 * @method MonkeyWpUser[] users(int $howMany, array $data = [])
 * @method \WP_Comment comment(array $data = [])
 * @method \WP_Comment[] comments(int $howMany, array $data = [])
 * @method \WP_Post_Type postType(array $data = [])
 * @method \WP_Post_Type[] postTypes(int $howMany, array $data = [])
 * @method \WP_Term term(array $data = [])
 * @method \WP_Term[] terms(int $howMany, array $data = [])
 * @method \WP_Taxonomy taxonomy(array $data = [])
 * @method \WP_Taxonomy[] taxonomies(int $howMany, array $data = [])
 * @method \WP_Site site(array $data = [])
 * @method \WP_Site[] sites(int $howMany, array $data = [])
 * @method \WP_Error error(array $data = [])
 * @method \WP_Error[] errors(int $howMany, array $data = [])
 *
 * @property \WP_Post post
 * @property \WP_Post[] posts
 * @property MonkeyWpUser user
 * @property MonkeyWpUser[] users
 * @property \WP_Comment comment
 * @property \WP_Comment[] comments
 * @property \WP_Post_Type postType
 * @property \WP_Post_Type[] postTypes
 * @property \WP_Term term
 * @property \WP_Term[] terms
 * @property \WP_Taxonomy taxonomy
 * @property \WP_Taxonomy[] taxonomies
 * @property \WP_Site site
 * @property \WP_Site[] sites
 * @property \WP_Error error
 * @property \WP_Error[] errors
 */
class Providers
{
    private const ONE = 'one';
    private const MANY = 'many';

    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var array<string, array<string, string>>
     */
    private $methods = [
        self::ONE => [],
        self::MANY => [],
    ];

    /**
     * @var array<string, Provider>
     */
    private $providers = [];

    /**
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param string $method
     * @param array $args
     * @return object|object[]
     */
    public function __call(string $method, array $args = [])
    {
        $atLeast = null;
        $atMost = null;
        $methods = implode('|', array_map('preg_quote', array_keys($this->methods[self::MANY])));
        if (preg_match("/^atLeast([0-9]+)({$methods})$/", $method, $matches)) {
            $atLeast = (int)$matches[1];
            $method = $matches[2];
        }
        if (preg_match("/^atMost([0-9]+)({$methods})$/", $method, $matches)) {
            $atMost = (int)$matches[1];
            $method = $matches[2];
        }

        [$object, $isMany] = $this->factoryProvider($method);

        if (!$isMany) {
            return $object(...$args);
        }

        $min = $atLeast ?? 0;
        $max = $atMost ?? $min + $this->generator->numberBetween(1, 10);

        $num = null;
        if ($atLeast === null && $atMost === null) {
            $num = $args ? array_shift($args) : $this->generator->numberBetween(0, 10);
            is_numeric($num) or $this->bailForCallManyWithNoNumber($method);
        }

        $params = $args ? reset($args) : [];
        if (!is_array($params)) {
            $this->bailForCallManyWithBadParams($method);
        }

        isset($num) or $num = $min === $max ? $min : $this->generator->numberBetween($min, $max);
        if ($num < 1) {
            return [];
        }

        $objects = [];
        for ($i = 0; $i < $num; $i++) {
            $objects[] = $object(...$args);
        }

        return $objects;
    }

    /**
     * @param string $method
     * @return mixed
     */
    public function __get(string $method)
    {
        return $this->__call($method);
    }

    /**
     * @param string $providerClass
     * @param string $methodOne
     * @param string $methodMany
     * @return Providers
     */
    public function addProviderClass(
        string $providerClass,
        string $methodOne,
        string $methodMany
    ): Providers {

        $reflection = null;

        if (!is_subclass_of($providerClass, Provider::class)) {
            $this->bailForInvalidClass($providerClass);
        }

        try {
            $reflection = new \ReflectionClass($providerClass);
        } catch (\Throwable $throwable) {
           $this->bailForInvalidClass($providerClass, $throwable);
        }

        /** \ReflectionClass $reflection */
        if (!$reflection->isInstantiable()) {
            $this->bailForInvalidClass($providerClass);
        }

        if ($methodOne === 'wp' || substr($methodOne, 0, 2) === '__') {
            $this->bailForReservedMethod($methodOne);
        }

        if ($methodMany === 'wp' || substr($methodMany, 0, 2) === '__') {
            $this->bailForReservedMethod($methodOne);
        }

        $this->methods[self::ONE][$methodOne] = $providerClass;
        $this->methods[self::MANY][$methodMany] = $providerClass;
        unset($this->providers[$providerClass]);

        return $this;
    }

    /**
     * @return Providers
     */
    public function __resetUnique(): Providers
    {
        /** @var Provider $provider */
        foreach ($this->providers as $provider) {
            $provider->resetUnique();
        }

        return $this;
    }

    /**
     * @return Providers
     */
    public function wp(): Providers
    {
        return $this;
    }

    /**
     * @param string $method
     * @return array
     */
    private function factoryProvider(string $method): array
    {
        $isOne = array_key_exists($method, $this->methods[self::ONE]);
        $isMany = array_key_exists($method, $this->methods[self::MANY]);

        if (!$isOne && !$isMany) {
            $this->bailForInvalidMethod($method);
        }

        if ($isOne && $isMany) {
            $this->bailForNotUniquelyIdentifiedClass($method);
        }

        $class = $isMany ? $this->methods[self::MANY][$method] : $this->methods[self::ONE][$method];

        if (empty($this->providers[$class])) {
            $this->providers[$class] = new $class($this->generator, $this->generator->unique());
        }

        return [$this->providers[$class], $isMany];
    }

    /**
     * @param string $class
     * @param \Throwable|null $previous
     */
    private function bailForInvalidClass(string $class, \Throwable $previous = null): void
    {
        throw new \Error("{$class} is not a valid provider class.", 0, $previous);
    }

    /**
     * @param string $method
     */
    private function bailForInvalidMethod(string $method): void
    {
        throw new \Error(sprintf('Call to undefined method %s::%s()', __CLASS__, $method));
    }

    /**
     * @param string $method
     */
    private function bailForNotUniquelyIdentifiedClass(string $method): void
    {
        throw new \Error(
            "Impossible to uniquely identify provider class for \$faker->wp()->{$method}()."
        );
    }

    /**
     * @param string $method
     */
    private function bailForReservedMethod(string $method): void
    {
        throw new \Error(
            "'{$method}' is a reserved method name, can't be used for \$faker->wp()->{$method}()."
        );
    }

    /**
     * @param string $method
     */
    private function bailForCallManyWithNoNumber(string $method): void
    {
        throw new \Error("\$faker->wp()->{$method}() first argument must be a number.");
    }

    /**
     * @param string $method
     */
    private function bailForCallManyWithBadParams(string $method): void
    {
        throw new \Error("\$faker->wp()->{$method}() requires options provided as array.");
    }
}