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

use Faker\Factory as FakerFactory;
use Faker\Generator;

class Generators
{
    private const PROVIDERS = [
        Provider\Post::class => ['post', 'posts'],
        Provider\User::class => ['user', 'users'],
        Provider\PostType::class => ['postType', 'postTypes'],
        Provider\Term::class => ['term', 'terms'],
        Provider\Taxonomy::class => ['taxonomy', 'taxonomies'],
        Provider\Comment::class => ['comment', 'comments'],
        Provider\Site::class => ['site', 'sites'],
        Provider\Error::class => ['error', 'errors'],
    ];

    /**
     * @var array<Generator>
     */
    private static $generators = [];

    /**
     * @param string $locale
     * @return Generator
     */
    public static function create(string $locale = FakerFactory::DEFAULT_LOCALE): Generator
    {
        return static::fromGenerator(FakerFactory::create($locale), $locale);
    }

    /**
     * @param Generator $faker
     * @param string $locale
     * @return Generator
     */
    public static function fromGenerator(
        Generator $faker,
        string $locale = FakerFactory::DEFAULT_LOCALE
    ): Generator {

        if (array_key_exists($locale, static::$generators)) {
            return static::$generators[$locale];
        }

        $provider = new Providers($faker);

        foreach (self::PROVIDERS as $className => [$methodOne, $methodMany]) {
            $provider->__addProviderClass($className, $methodOne, $methodMany);
        }

        $faker->addProvider($provider);

        static::$generators[$locale] = $faker;

        return $faker;
    }

    /**
     * @return void
     */
    public static function reset(): void
    {
        static::$generators = [];
    }
}
