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

class Term extends FunctionMockerProvider
{
    use CountableFunctionMockerProviderTrait;
    
    /**
     * @var array[]
     */
    private $terms = [];

    /**
     * @param \WP_Term $term
     * @return callable
     */
    public static function withSame(\WP_Term $term): callable
    {
        return function (\WP_Term $theTerm) use ($term): bool {
            return (int)$theTerm->term_id === (int)$term->term_id;
        };
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->terms = [];
        parent::reset();
    }

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

        $slug = strtolower($this->uniqueGenerator->slug($this->generator->numberBetween(1, 2)));

        $defaults = [
            'name' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
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
        $term->shouldReceive('to_array')->andReturn($toArray)->byDefault();

        $this->terms[$term->term_id] = $toArray;
        $this->mockFunctions();

        return $term;
    }

    /**
     * @return void
     */
    private function mockFunctions(): void
    {
        if (!$this->canMockFunctions()) {
            return;
        }

        $this->functionExpectations->mock('get_term')
            ->zeroOrMoreTimes()
            ->andReturnUsing(
                function (...$args) { //phpcs:ignore
                    return $this->mockedGetTerm(...$args);
                }
            );

        $this->functionExpectations->mock('get_term_by')
            ->zeroOrMoreTimes()
            ->andReturnUsing(
                function (...$args) { //phpcs:ignore
                    return $this->mockedGetTermBy(...$args);
                }
            );

        $this->functionExpectations->mock('get_terms')
            ->zeroOrMoreTimes()
            ->with(\Mockery::any())
            ->andReturnUsing($this->getCountableEntityEntries(...));

        $this->functionExpectations->mock('get_tags')
            ->zeroOrMoreTimes()
            ->with(\Mockery::any())
            ->andReturnUsing($this->getTags(...));

        $this->functionExpectations->mock('get_categories')
            ->zeroOrMoreTimes()
            ->with(\Mockery::any())
            ->andReturnUsing($this->getCategories(...));

        $this->stopMockingFunctions();
    }

    /**
     * @param array<string,mixed> $query
     */
    private function countEntityEntries(array $query): bool
    {
        return ($query['count'] ?? false) && $query['fields'] === 'count';
    }

    /**
     * @param array<string,mixed> $query
     */
    private function getTags(array $query): array|int
    {
        return $this->getCountableEntityEntries(
            [
                ...$query,
                'taxonomy' => 'post_tag',
            ]
        );
    }

    /**
     * @param array<string,mixed> $query
     */
    private function getCategories(array $query): array|int
    {
        return $this->getCountableEntityEntries(
            [
                ...$query,
                'taxonomy' => 'category',
            ]
        );
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    private function getDataEntries(): array
    {
        return $this->terms;
    }

    private function retrieveIDs(array $query): bool
    {
        return ($query['fields'] ?? null) === 'ids';
    }

    /**
     * @param array<string,mixed> $query
     */
    private function getPaginationLimit(array $query): int
    {
        return $query['number'] ?? 0;
    }

    /**
     * @return array<int|string,string>
     */
    private function getFilterableProperties(): array
    {
        return [
            'taxonomy',
            'parent',
            'slug',
        ];
    }

    /**
     * @param $term
     * @param string $taxonomy
     * @param string $output
     * @return array|\WP_Term|null
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration
     * phpcs:disable Inpsyde.CodeQuality.ReturnTypeDeclaration
     */
    private function mockedGetTerm($term, $taxonomy = '', $output = 'OBJECT')
    {
        // phpcs:enable Inpsyde.CodeQuality.ArgumentTypeDeclaration
        // phpcs:enable Inpsyde.CodeQuality.ReturnTypeDeclaration

        $termId = is_object($term) ? $term->term_id ?? null : $term;
        if (!$termId || !is_numeric($termId)) {
            return null;
        }

        $data = $this->terms[(int)$termId] ?? null;
        if (!$data || ($taxonomy && $taxonomy !== $data['taxonomy'])) {
            return null;
        }

        $termObj = $this->__invoke($data);

        if ($output === 'ARRAY_A') {
            return $termObj->to_array();
        } elseif ($output === 'ARRAY_N') {
            return array_values($termObj->to_array());
        }

        return $termObj;
    }

    /**
     * @param $field
     * @param $value
     * @param string $taxonomy
     * @param string $output
     * @return array|\WP_Term|bool
     *
     * phpcs:disable Inpsyde.CodeQuality.ArgumentTypeDeclaration
     * phpcs:disable Inpsyde.CodeQuality.ReturnTypeDeclaration
     */
    private function mockedGetTermBy($field, $value, $taxonomy = '', $output = 'OBJECT')
    {
        // phpcs:enable Inpsyde.CodeQuality.ArgumentTypeDeclaration
        // phpcs:enable Inpsyde.CodeQuality.ReturnTypeDeclaration

        if (!in_array($field, ['id', 'term_taxonomy_id', 'slug', 'name'], true)) {
            return false;
        }

        $id = $field === 'id' ? $value : null;
        if ($id === null) {
            $isTtId = $field === 'term_taxonomy_id';
            if (($isTtId && !is_numeric($value))
                || (!$isTtId && (!is_string($value) || !$taxonomy))
            ) {
                return false;
            }

            $isTtId and $value = (int)$value;
            if ($field === 'slug') {
                $value = preg_replace('/[^a-z0-9_-]/i', '-', strtolower($value));
            }

            $values = array_column($this->terms, $field, 'term_id');
            $id = array_search($value, $values, true);
        }

        return $id && is_numeric($id)
            ? ($this->mockedGetTerm($id, $taxonomy, $output) ?: false)
            : false;
    }
}
