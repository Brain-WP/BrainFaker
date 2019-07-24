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

use Brain\Faker\Tests\FactoryTestCase;
use Brain\Faker\Provider;

class TermTest extends FactoryTestCase
{
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

        ksort($expectedArray);
        ksort($actualArray);

        static::assertSame($expectedArray, $actualArray);

        $id = $term->term_id;
        $ttId = $term->term_taxonomy_id;

        static::assertSame($term, get_term($id, $term->taxonomy));
        static::assertSame($term, get_term((string)$id, $term->taxonomy));
        static::assertSame($term, get_term_by('slug', $term->slug, $term->taxonomy));
        static::assertSame($term, get_term_by('name', $term->name, $term->taxonomy));
        static::assertSame($term, get_term_by('id', $id, $term->taxonomy));
        static::assertSame($term, get_term_by('term_taxonomy_id', $ttId, $term->taxonomy));
        static::assertSame($term, get_term_by('term_taxonomy_id', (string)$ttId, $term->taxonomy));
        static::assertSame($term, get_term_by('term_taxonomy_id', $ttId));
        static::assertSame($term, get_term_by('term_taxonomy_id', (string)$ttId));
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
}