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
}
