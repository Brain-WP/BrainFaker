<?php # -*- coding: utf-8 -*-

declare(strict_types=1);

namespace Brain\Faker\Provider;

trait FunctionMockerProviderTrait
{
    /**
     * @param int[]|array<int,array<string,mixed>> $entries Either entity IDs, or the endity data arrays
     * @return int[]|array<int,array<string,mixed>>
     */
    private function paginate(array $entries, int $limit, int $offset): array
    {
        return array_slice(
            $entries,
            $offset,
            $limit > 0 ? $limit : null,
            true,
        );
    }

    private function filterDataEntriesByProperty(array $dataEntries, string $property, string|int|array $propertyValueOrValues): array
    {
        $propertyValues = is_array($propertyValueOrValues) ? $propertyValueOrValues : [$propertyValueOrValues];
        return array_filter(
            $dataEntries,
            fn (array $postDataEntry): bool => in_array($postDataEntry[$property] ?? null, $propertyValues),
        );
    }

    /**
     * @param array<string,mixed> $query
     */
    private function getEntityEntries(array $query): array
    {
        $retrieveIDs = $this->retrieveIDs($query);
        $dataEntries = $this->getDataEntries();

        /**
         * If providing the IDs to retrieve, re-generate exactly those objects.
         */
        $ids = $this->getIncludedIDs($query);
        if ($ids !== []) {
            // Make sure those IDs exist
            $ids = array_values(array_intersect(
                $ids,
                array_keys($dataEntries)
            ));
            $ids = $this->paginate(
                $ids,
                $this->getPaginationLimit($query),
                $this->getPaginationOffset($query),
            );
            if ($retrieveIDs) {
                return $ids;
            }
            return array_map(
                fn (int $id) => $this->__invoke($dataEntries[$id]),
                $ids
            );
        }

        /**
         * If provided in the query, filter the entities that have some
         * property with some value
         */
        foreach ($this->getFilterableProperties() as $maybeQueryProperty => $dataProperty) {
            $queryProperty = is_numeric($maybeQueryProperty) ? $dataProperty : $maybeQueryProperty;
            if (!isset($query[$queryProperty])) {
                continue;
            }
            $dataEntries = $this->filterDataEntriesByProperty(
                $dataEntries,
                $dataProperty,
                $query[$queryProperty]
            );
        }
        $dataEntries = $this->paginate(
            $dataEntries,
            $this->getPaginationLimit($query),
            $this->getPaginationOffset($query),
        );
        if ($retrieveIDs) {
            return array_keys($dataEntries);
        }
        return array_values(array_map(
            $this->__invoke(...),
            $dataEntries
        ));
    }

    abstract private function retrieveIDs(array $query): bool;

    /**
     * @return int[]
     */
    private function getIncludedIDs(array $query): array
    {
        /** @var array|string|int|null */
        $idOrIDs = $query['include'] ?? null;
        if (empty($idOrIDs)) {
            return [];
        }
        if (is_string($idOrIDs)) {
            return array_map(
                fn (string $id) => (int) trim($id),
                explode(',', $idOrIDs)
            );
        }
        return is_array($idOrIDs) ? $idOrIDs : [$idOrIDs];
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    abstract private function getDataEntries(): array;

    /**
     * @param array<string,mixed> $query
     */
    abstract private function getPaginationLimit(array $query): int;

    /**
     * @param array<string,mixed> $query
     */
    private function getPaginationOffset(array $query): int
    {
        return $query['offset'] ?? 0;
    }

    /**
     * @return array<int|string,string>
     */
    private function getFilterableProperties(): array
    {
        return [];
    }

    /**
     * @param array<string,mixed> $query
     */
    private function getCountableEntityEntries(array $query): array|int
    {
        $entityEntries = $this->getEntityEntries($query);
        if ($this->countEntityEntries($query)) {
            return count($entityEntries);
        }
        return $entityEntries;
    }

    private function countEntityEntries(array $query): bool
    {
        return false;
    }
}
