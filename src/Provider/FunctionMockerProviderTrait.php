<?php # -*- coding: utf-8 -*-

declare(strict_types=1);

namespace Brain\Faker\Provider;

trait FunctionMockerProviderTrait
{
    private function escSql(string|array $data): string|array
    {
        return $data;
    }

    /**
     * @param int[]|array<int,array<string,mixed>> $entries Either post IDs or data arrays
     * @param array<string,mixed> $query
     * @return int[]|array<int,array<string,mixed>>
     */
    private function paginatePosts(array $entries, array $query): array
    {
        $offset = (int) ($query['offset'] ?? 0);
        $limit = (int) ($query['posts_per_page'] ?? 10);
        if ($limit > 0) {
            return array_slice(
                $entries,
                $offset,
                $limit,
                true,
            );
        }
        if ($offset !== 0) {
            return array_slice(
                $entries,
                $offset,
                null,
                true,
            );
        }
        return $entries;
    }

    private function filterDataEntriesByProperty(array $dataEntries, string $property, string|int|array $propertyValueOrValues): array
    {
        $propertyValues = is_array($propertyValueOrValues) ? $propertyValueOrValues : [$propertyValueOrValues];
        return array_filter(
            $dataEntries,
            fn (array $postDataEntry): bool => in_array($postDataEntry[$property] ?? null, $propertyValues),
        );
    }
}
