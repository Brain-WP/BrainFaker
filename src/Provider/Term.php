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

namespace Brain\Faker\Provider;

use Brain\Monkey;

class Term extends Provider
{
    /**
     * @param array $properties
     * @return \WP_Term
     */
    public function __invoke(array $properties = []): \WP_Term
    {
        $id = $properties['term_id'] ?? $properties['id'] ?? null;
        $ttId = $properties['term_taxonomy_id'] ?? $properties['tt_id'] ?? null;
        ($id && !$ttId) and $ttId = $id;
        ($ttId && !$id) and $id = $ttId;

        $id or $id = $this->uniqueGenerator->numberBetween(1, 99999999);
        $ttId or $ttId = $id;
        $name = $this->generator->sentence($this->generator->numberBetween(1, 3));

        $defaults = [
            'name' => ucwords(strtolower($name)),
            'slug' => preg_replace('/[^a-z0-9_-]/i', '-', $name),
            'term_group' => '',
            'taxonomy' => array_rand(Taxonomy::BUILT_IN),
            'description' => $this->generator->sentence,
            'parent' => $this->generator->numberBetween(0, 99999),
            'count' => $this->generator->numberBetween(0, 99999),
            'filter' => $this->generator->randomElement(['raw', null]),
        ];

        $term = \Mockery::mock(\WP_Term::class);
        $term->term_id = (int)$id;
        $term->term_taxonomy_id = (int)$ttId;

        $toArray = ['term_id' => (int)$id, 'term_taxonomy_id' => (int)$ttId];
        foreach ($defaults as $key => $value) {
            $field = array_key_exists($key, $properties) ? $properties[$key] : $value;
            $toArray[$key] = $field;
            $term->{$key} = $field;
        }

        /** @var \Mockery\MockInterface $term */
        $term->data = (object)$toArray;
        $term->shouldReceive('to_array')->andReturn($toArray);

        Monkey\Functions\expect('get_term')
            ->zeroOrMoreTimes()
            ->with($id, $term->taxonomy)
            ->andReturn($term);

        Monkey\Functions\expect('get_term_by')
            ->zeroOrMoreTimes()
            ->with('slug', $term->slug, $term->taxonomy)
            ->andReturn($term);

        Monkey\Functions\expect('get_term_by')
            ->zeroOrMoreTimes()
            ->with('name', $term->name, $term->taxonomy)
            ->andReturn($term);

        Monkey\Functions\expect('get_term_by')
            ->zeroOrMoreTimes()
            ->with('id', \Mockery::anyOf($id, (string)$id), $term->taxonomy)
            ->andReturn($term);

        Monkey\Functions\expect('get_term_by')
            ->zeroOrMoreTimes()
            ->with('term_taxonomy_id', \Mockery::anyOf($ttId, (string)$ttId), $term->taxonomy)
            ->andReturn($term);

        Monkey\Functions\expect('get_term_by')
            ->zeroOrMoreTimes()
            ->with('term_taxonomy_id', \Mockery::anyOf($ttId, (string)$ttId))
            ->andReturn($term);

        return $term;
    }
}
