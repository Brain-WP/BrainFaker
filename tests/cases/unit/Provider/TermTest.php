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

namespace Brain\Faker\Tests\Unit\Provider;

use Brain\Faker\Tests\ProviderTestCase;
use Brain\Faker\Provider;

class TermTest extends ProviderTestCase
{
    /**
     * phpcs:disable Inpsyde.CodeQuality.FunctionLength.TooLong
     */
    public function testNoPropertiesCreation()
    {
        /** @var Provider\Term $factory */
        $factory = $this->factoryProvider(Provider\Term::class);
        $term = $factory();

        static::assertInstanceOf(\WP_Term::class, $term);

        static::assertIsInt($term->term_id);
        static::assertGreaterThanOrEqual(1, $term->term_id);
        static::assertIsInt($term->term_taxonomy_id);
        static::assertGreaterThanOrEqual(1, $term->term_taxonomy_id);
        static::assertIsString($term->name);
        static::assertIsString($term->slug);
        static::assertSame('', $term->term_group);
        static::assertArrayHasKey($term->taxonomy, Provider\Taxonomy::BUILT_IN);
        static::assertIsString($term->description);
        static::assertIsInt($term->parent);
        static::assertGreaterThanOrEqual(0, $term->parent);
        static::assertIsInt($term->count);
        static::assertGreaterThanOrEqual(0, $term->count);
        static::assertContains($term->filter, ['raw', null]);
        static::assertInstanceOf(\stdClass::class, $term->data);
        static::assertSame($term->term_id, $term->data->term_id);

        $expectedArray = [
            'term_id' => $term->term_id,
            'term_taxonomy_id' => $term->term_taxonomy_id,
            'name' => $term->name,
            'slug' => $term->slug,
            'term_group' => $term->term_group,
            'taxonomy' => $term->taxonomy,
            'description' => $term->description,
            'parent' => $term->parent,
            'count' => $term->count,
            'filter' => $term->filter,
        ];

        $actualArray = $term->to_array();
        $arr = $actualArray;

        ksort($expectedArray);
        ksort($actualArray);

        static::assertSame($expectedArray, $actualArray);

        $id = $term->term_id;
        $ttId = $term->term_taxonomy_id;
        $tax = $term->taxonomy;

        static::assertSame($arr, get_term($id, $tax)->to_array());
        static::assertSame($arr, get_term((string)$id, $tax)->to_array());
        static::assertSame($arr, get_term_by('slug', $term->slug, $tax)->to_array());
        static::assertSame($arr, get_term_by('slug', $term->name, $tax)->to_array());
        static::assertSame($arr, get_term_by('name', $term->name, $tax)->to_array());
        static::assertSame($arr, get_term_by('id', $id, $tax)->to_array());
        static::assertSame($arr, get_term_by('term_taxonomy_id', $ttId, $tax)->to_array());
        static::assertSame($arr, get_term_by('term_taxonomy_id', (string)$ttId, $tax)->to_array());
        static::assertSame($arr, get_term_by('term_taxonomy_id', $ttId)->to_array());
        static::assertSame($arr, get_term_by('term_taxonomy_id', (string)$ttId)->to_array());
        static::assertFalse(get_term_by('slug', $term->slug));
        static::assertFalse(get_term_by('name', $term->name));
        static::assertFalse(get_term_by('name', $term->slug, $tax));
    }

    public function testCreateWithFixedId()
    {
        /** @var Provider\Term $factory */
        $factory = $this->factoryProvider(Provider\Term::class);
        $term = $factory(['id' => 123]);

        static::assertInstanceOf(\WP_Term::class, $term);
        static::assertSame(123, $term->term_id);
        static::assertSame(123, $term->term_taxonomy_id);
    }

    public function testCreateWithFixedIdAndTermTaxId()
    {
        /** @var Provider\Term $factory */
        $factory = $this->factoryProvider(Provider\Term::class);
        $term = $factory(['id' => 123, 'tt_id' => 456]);

        static::assertInstanceOf(\WP_Term::class, $term);
        static::assertSame(123, $term->term_id);
        static::assertSame(456, $term->term_taxonomy_id);
    }

    public function testCreateWithFixedTaxonomy()
    {
        /** @var Provider\Term $factory */
        $factory = $this->factoryProvider(Provider\Term::class);
        $term = $factory(['taxonomy' => 'category']);

        static::assertSame('category', $term->taxonomy);
    }

    public function testIdUniqueness()
    {
        /** @var Provider\Term $factory */
        $factory = $this->factoryProvider(Provider\Term::class);

        $ids = [];
        for ($i = 0; $i < 200; $i++) {
            $ids[] = $factory()->term_id;
        }

        static::assertSame($ids, array_unique($ids));
    }

    public function testFunctionsForManyTerms()
    {
        /** @var Provider\Term $factory */
        $factory = $this->factoryProvider(Provider\Term::class);

        $terms = [];
        for ($i = 0; $i < 1000; $i++) {
            $terms[] = $factory();
        }

        $ids = [];
        /** @var \WP_Term $term */
        foreach ($terms as $term) {
            $ids[] = $term->term_id;
            $arr = $term->to_array();
            $tax = $term->taxonomy;
            $ttId = $term->term_taxonomy_id;

            static::assertSame($arr, get_term($term->term_id, $tax)->to_array());
            static::assertSame($arr, get_term_by('slug', $term->slug, $tax)->to_array());
            static::assertSame($arr, get_term_by('name', $term->name, $tax)->to_array());
            static::assertSame($arr, get_term_by('id', $term->term_id, $tax)->to_array());
            static::assertSame($arr, get_term_by('term_taxonomy_id', $ttId, $tax)->to_array());
            static::assertSame($arr, get_term_by('term_taxonomy_id', $ttId)->to_array());
        }

        $badId = (int)(max($ids) + 1);
        static::assertNull(get_term($badId));
        static::assertFalse(get_term_by('id', $badId));
    }
}
