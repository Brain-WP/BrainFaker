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
use Brain\Monkey\Expectation\Expectation;
use Brain\Monkey\Functions;
use Faker\Generator;

/**
 * @method \WP_Post post(array $data = [])
 * @method \WP_Post[] posts(int $howMany, array $data = [])
 * @method \WP_Post[] atLeastOnePost(array $data = [])
 * @method \WP_Post[] atLeastTwoPosts(array $data = [])
 * @method \WP_Post[] atLeastThreePosts(array $data = [])
 * @method \WP_Post[] atLeastFourPosts(array $data = [])
 * @method \WP_Post[] atLeastFivePosts(array $data = [])
 * @method \WP_Post[] atMostOnePost(array $data = [])
 * @method \WP_Post[] atMostTwoPosts(array $data = [])
 * @method \WP_Post[] atMostThreePosts(array $data = [])
 * @method \WP_Post[] atMostFourPosts(array $data = [])
 * @method \WP_Post[] atMostFivePosts(array $data = [])
 * @method MonkeyWpUser|\WP_User user(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] users(int $howMany, array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atLeastOneUser(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atLeastTwoUsers(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atLeastThreeUsers(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atLeastFourUsers(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atLeastFiveUsers(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atMostOneUser(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atMostTwoUsers(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atMostThreeUsers(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atMostFourUsers(array $data = [])
 * @method MonkeyWpUser[]|\WP_User[] atMostFiveUsers(array $data = [])
 * @method \WP_Comment comment(array $data = [])
 * @method \WP_Comment[] comments(int $howMany, array $data = [])
 * @method \WP_Comment[] atLeastOneComment(array $data = [])
 * @method \WP_Comment[] atLeastTwoComments(array $data = [])
 * @method \WP_Comment[] atLeastThreeComments(array $data = [])
 * @method \WP_Comment[] atLeastFourComments(array $data = [])
 * @method \WP_Comment[] atLeastFiveComments(array $data = [])
 * @method \WP_Comment[] atMostOneComment(array $data = [])
 * @method \WP_Comment[] atMostTwoComments(array $data = [])
 * @method \WP_Comment[] atMostThreeComments(array $data = [])
 * @method \WP_Comment[] atMostFourComments(array $data = [])
 * @method \WP_Comment[] atMostFiveComments(array $data = [])
 * @method \WP_Post_Type postType(array $data = [])
 * @method \WP_Post_Type[] postTypes(int $howMany, array $data = [])
 * @method \WP_Post_Type[] atLeastOnePostType(array $data = [])
 * @method \WP_Post_Type[] atLeastTwoPostTypes(array $data = [])
 * @method \WP_Post_Type[] atLeastThreePostTypes(array $data = [])
 * @method \WP_Post_Type[] atLeastFourPostTypes(array $data = [])
 * @method \WP_Post_Type[] atLeastFivePostTypes(array $data = [])
 * @method \WP_Post_Type[] atMostOnePostType(array $data = [])
 * @method \WP_Post_Type[] atMostTwoPostTypes(array $data = [])
 * @method \WP_Post_Type[] atMostThreePostTypes(array $data = [])
 * @method \WP_Post_Type[] atMostFourPostTypes(array $data = [])
 * @method \WP_Post_Type[] atMostFivePostTypes(array $data = [])
 * @method \WP_Term term(array $data = [])
 * @method \WP_Term[] terms(int $howMany, array $data = [])
 * @method \WP_Term[] atLeastOneTerm(array $data = [])
 * @method \WP_Term[] atLeastTwoTerms(array $data = [])
 * @method \WP_Term[] atLeastThreeTerms(array $data = [])
 * @method \WP_Term[] atLeastFourTerms(array $data = [])
 * @method \WP_Term[] atLeastFiveTerms(array $data = [])
 * @method \WP_Term[] atMostOneTerm(array $data = [])
 * @method \WP_Term[] atMostTwoTerms(array $data = [])
 * @method \WP_Term[] atMostThreeTerms(array $data = [])
 * @method \WP_Term[] atMostFourTerms(array $data = [])
 * @method \WP_Term[] atMostFiveTerms(array $data = [])
 * @method \WP_Taxonomy taxonomy(array $data = [])
 * @method \WP_Taxonomy[] taxonomies(int $howMany, array $data = [])
 * @method \WP_Taxonomy[] atLeastOneTaxonomy(array $data = [])
 * @method \WP_Taxonomy[] atLeastTwoTaxonomies(array $data = [])
 * @method \WP_Taxonomy[] atLeastThreeTaxonomies(array $data = [])
 * @method \WP_Taxonomy[] atLeastFourTaxonomies(array $data = [])
 * @method \WP_Taxonomy[] atLeastFiveTaxonomies(array $data = [])
 * @method \WP_Taxonomy[] atMostOneTaxonomy(array $data = [])
 * @method \WP_Taxonomy[] atMostTwoTaxonomies(array $data = [])
 * @method \WP_Taxonomy[] atMostThreeTaxonomies(array $data = [])
 * @method \WP_Taxonomy[] atMostFourTaxonomies(array $data = [])
 * @method \WP_Taxonomy[] atMostFiveTaxonomies(array $data = [])
 * @method \WP_Site site(array $data = [])
 * @method \WP_Site[] sites(int $howMany, array $data = [])
 * @method \WP_Site[] atLeastOneSite(array $data = [])
 * @method \WP_Site[] atLeastTwoSites(array $data = [])
 * @method \WP_Site[] atLeastThreeSites(array $data = [])
 * @method \WP_Site[] atLeastFourSites(array $data = [])
 * @method \WP_Site[] atLeastFiveSites(array $data = [])
 * @method \WP_Site[] atMostOneSite(array $data = [])
 * @method \WP_Site[] atMostTwoSites(array $data = [])
 * @method \WP_Site[] atMostThreeSites(array $data = [])
 * @method \WP_Site[] atMostFourSites(array $data = [])
 * @method \WP_Site[] atMostFiveSites(array $data = [])
 * @method \WP_Error error(array $data = [])
 * @method \WP_Error[] errors(int $howMany, array $data = [])
 * @method \WP_Error[] atLeastOneError(array $data = [])
 * @method \WP_Error[] atLeastTwoErrors(array $data = [])
 * @method \WP_Error[] atLeastThreeErrors(array $data = [])
 * @method \WP_Error[] atLeastFourErrors(array $data = [])
 * @method \WP_Error[] atLeastFiveErrors(array $data = [])
 * @method \WP_Error[] atMostOneError(array $data = [])
 * @method \WP_Error[] atMostTwoErrors(array $data = [])
 * @method \WP_Error[] atMostThreeErrors(array $data = [])
 * @method \WP_Error[] atMostFourErrors(array $data = [])
 * @method \WP_Error[] atMostFiveErrors(array $data = [])
 *
 * @property \WP_Post post
 * @property \WP_Post[] posts
 * @property \WP_Post[] atLeastOnePost
 * @property \WP_Post[] atLeastTwoPosts
 * @property \WP_Post[] atLeastThreePosts
 * @property \WP_Post[] atLeastFourPosts
 * @property \WP_Post[] atLeastFivePosts
 * @property \WP_Post[] atMostOnePost
 * @property \WP_Post[] atMostTwoPosts
 * @property \WP_Post[] atMostThreePosts
 * @property \WP_Post[] atMostFourPosts
 * @property \WP_Post[] atMostFivePosts
 * @property MonkeyWpUser|\WP_User user
 * @property MonkeyWpUser[]|\WP_User[] users
 * @property MonkeyWpUser[]|\WP_User[] atLeastOneUser
 * @property MonkeyWpUser[]|\WP_User[] atLeastTwoUsers
 * @property MonkeyWpUser[]|\WP_User[] atLeastThreeUsers
 * @property MonkeyWpUser[]|\WP_User[] atLeastFourUsers
 * @property MonkeyWpUser[]|\WP_User[] atLeastFiveUsers
 * @property MonkeyWpUser[]|\WP_User[] atMostOneUser
 * @property MonkeyWpUser[]|\WP_User[] atMostTwoUsers
 * @property MonkeyWpUser[]|\WP_User[] atMostThreeUsers
 * @property MonkeyWpUser[]|\WP_User[] atMostFourUsers
 * @property MonkeyWpUser[]|\WP_User[] atMostFiveUsers
 * @property \WP_Comment comment
 * @property \WP_Comment[] comments
 * @property \WP_Comment[] atLeastOneComment
 * @property \WP_Comment[] atLeastTwoComments
 * @property \WP_Comment[] atLeastThreeComments
 * @property \WP_Comment[] atLeastFourComments
 * @property \WP_Comment[] atLeastFiveComments
 * @property \WP_Comment[] atMostOneComment
 * @property \WP_Comment[] atMostTwoComments
 * @property \WP_Comment[] atMostThreeComments
 * @property \WP_Comment[] atMostFourComments
 * @property \WP_Comment[] atMostFiveComments
 * @property \WP_Post_Type postType
 * @property \WP_Post_Type[] postTypes
 * @property \WP_Post_Type[] atLeastOnePostType
 * @property \WP_Post_Type[] atLeastTwoPostTypes
 * @property \WP_Post_Type[] atLeastThreePostTypes
 * @property \WP_Post_Type[] atLeastFourPostTypes
 * @property \WP_Post_Type[] atLeastFivePostTypes
 * @property \WP_Post_Type[] atMostOnePostType
 * @property \WP_Post_Type[] atMostTwoPostTypes
 * @property \WP_Post_Type[] atMostThreePostTypes
 * @property \WP_Post_Type[] atMostFourPostTypes
 * @property \WP_Post_Type[] atMostFivePostTypes
 * @property \WP_Term term
 * @property \WP_Term[] terms
 * @property \WP_Term[] atLeastOneTerm
 * @property \WP_Term[] atLeastTwoTerms
 * @property \WP_Term[] atLeastThreeTerms
 * @property \WP_Term[] atLeastFourTerms
 * @property \WP_Term[] atLeastFiveTerms
 * @property \WP_Term[] atMostOneTerm
 * @property \WP_Term[] atMostTwoTerms
 * @property \WP_Term[] atMostThreeTerms
 * @property \WP_Term[] atMostFourTerms
 * @property \WP_Term[] atMostFiveTerms
 * @property \WP_Taxonomy taxonomy
 * @property \WP_Taxonomy[] taxonomies
 * @property \WP_Taxonomy[] atLeastOneTaxonomy
 * @property \WP_Taxonomy[] atLeastTwoTaxonomies
 * @property \WP_Taxonomy[] atLeastThreeTaxonomies
 * @property \WP_Taxonomy[] atLeastFourTaxonomies
 * @property \WP_Taxonomy[] atLeastFiveTaxonomies
 * @property \WP_Taxonomy[] atMostOneTaxonomy
 * @property \WP_Taxonomy[] atMostTwoTaxonomies
 * @property \WP_Taxonomy[] atMostThreeTaxonomies
 * @property \WP_Taxonomy[] atMostFourTaxonomies
 * @property \WP_Taxonomy[] atMostFiveTaxonomies
 * @property \WP_Site site
 * @property \WP_Site[] sites
 * @property \WP_Site[] atLeastOneSite
 * @property \WP_Site[] atLeastTwoSites
 * @property \WP_Site[] atLeastThreeSites
 * @property \WP_Site[] atLeastFourSites
 * @property \WP_Site[] atLeastFiveSites
 * @property \WP_Site[] atMostOneSite
 * @property \WP_Site[] atMostTwoSites
 * @property \WP_Site[] atMostThreeSites
 * @property \WP_Site[] atMostFourSites
 * @property \WP_Site[] atMostFiveSites
 * @property \WP_Error error
 * @property \WP_Error[] errors
 * @property \WP_Error[] atLeastOneError
 * @property \WP_Error[] atLeastTwoErrors
 * @property \WP_Error[] atLeastThreeErrors
 * @property \WP_Error[] atLeastFourErrors
 * @property \WP_Error[] atLeastFiveErrors
 * @property \WP_Error[] atMostOneError
 * @property \WP_Error[] atMostTwoErrors
 * @property \WP_Error[] atMostThreeErrors
 * @property \WP_Error[] atMostFourErrors
 * @property \WP_Error[] atMostFiveErrors
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
     * @var \ArrayObject
     */
    private $functionExpectations;

    /**
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
        $this->functionExpectations = new \ArrayObject();
    }

    /**
     * @param string $method
     * @param array $args
     * @return object|object[]
     */
    public function __call(string $method, array $args = [])
    {
        $this->bailWhenNotInitialized(sprintf('$faker->wp()->%s', $method));

        /**
         * @var bool $forceMany
         * @var string $method
         * @var bool|null $atLeast
         * @var bool|null $atMost
         */
        [$forceMany, $method, $atLeast, $atMost] = $this->extractAtLeastArMost($method);

        /**
         * @var callable $object
         * @var bool $isMany
         */
        [$object, $isMany] = $this->factoryProvider($method);

        if (!$isMany && !$forceMany) {
            return $object(...$args);
        }

        $min = $atLeast ?? 0;
        $max = $atMost ?? ($min + $this->generator->numberBetween(1, 10));

        $num = null;
        if ($atLeast === null && $atMost === null) {
            $num = $args ? array_shift($args) : $this->generator->numberBetween(0, 10);
            is_numeric($num) or $this->bailForCallManyWithNoNumber($method);
        }

        $params = $args ? reset($args) : [];
        if (!is_array($params)) {
            $this->bailForCallManyWithBadParams($method);
        }

        if ($num === null) {
            $num = $min === $max ? $min : $this->generator->numberBetween($min, $max);
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
    public function __addProviderClass(
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
     * @param string $function
     * @return Expectation
     */
    public function __monkeyFunction(string $function): Expectation
    {
        if (isset($this->functionExpectations[$function])) {
            /** @var Expectation $expectation */
            $expectation = $this->functionExpectations[$function];
            /** @noinspection PhpUndefinedMethodInspection */
            $expectation->byDefault();

            return $expectation->andAlsoExpectIt();
        }

        return Functions\expect($function);
    }

    /**
     * @return Providers
     */
    public function __reset(): Providers
    {
        $this->functionExpectations = new \ArrayObject();

        /** @var Provider $provider */
        foreach ($this->providers as $provider) {
            $provider->reset();
        }

        return $this;
    }

    /**
     * @return Providers
     */
    public function wp(): Providers
    {
        $this->bailWhenNotInitialized(__METHOD__);

        return $this;
    }

    /**
     * @param string $method
     * @return array
     */
    private function extractAtLeastArMost(string $method): array
    {
        $numWords = [
            'One' => 1,
            'Two' => 2,
            'Three' => 3,
            'Four' => 4,
            'Five' => 5,
        ];

        $prefixExp = 'atLeast|atMost|between';
        $numExp = '(?:[0-9]+)|(?:' . implode('|', array_keys($numWords)) . ')';
        $dynamicMethod = preg_match(
            "/^(?P<prefix>{$prefixExp})(?<n1>{$numExp})(?:And(?P<n2>{$numExp}))?(?P<method>.+)\$/",
            $method,
            $matches
        );

        if (!$dynamicMethod) {
            return [false, $method, null, null];
        }

        $minOrMax = $matches['prefix'] !== 'between' && empty($matches['n2']);
        $between = $matches['prefix'] === 'between' && !empty($matches['n2']);

        if (!$minOrMax && !$between) {
            return [false, $method, null, null];
        }

        if ($minOrMax) {
            $isNum = is_numeric($matches['n1']);
            $atNum = $isNum ? (int)$matches['n1'] : $numWords[$matches['n1']];
            $maybeMethod = lcfirst($matches['method']);
            if (($atNum === 1 && array_key_exists($maybeMethod, $this->methods[self::ONE]))
                || array_key_exists($maybeMethod, $this->methods[self::MANY])
            ) {
                $atLeast = $matches['prefix'] === 'atLeast' ? $atNum : null;
                $atMost = $matches['prefix'] === 'atLeast' ? null : $atNum;

                return [true, $maybeMethod, $atLeast, $atMost];
            }

            return [false, $method, null, null];
        }

        $isNumMin = is_numeric($matches['n1']);
        $isNumMax = is_numeric($matches['n2']);
        $maybeMethod = lcfirst($matches['method']);

        if (array_key_exists($maybeMethod, $this->methods[self::MANY])) {
            $min = $isNumMin ? (int)$matches['n1'] : $numWords[$matches['n1']];
            $max = $isNumMax ? (int)$matches['n2'] : $numWords[$matches['n2']];
            $atLeast = min($min, $max);
            $atMost = max($min, $max);

            return [true, $maybeMethod, $atLeast, $atMost];
        }

        return [false, $method, null, null];
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
            /** @var Provider $provider */
            $provider = new $class($this->generator, $this->functionExpectations);
            $this->providers[$class] = $provider;
        }

        return [$this->providers[$class], $isMany];
    }

    /**
     * @param string $method
     */
    private function bailWhenNotInitialized(string $method): void
    {
        if (!empty($this->methods[self::ONE])) {
            return;
        }

        throw new \Error(
            sprintf(
                "Can't call '%s()' before %s has been initialized.",
                $method,
                __CLASS__
            )
        );
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