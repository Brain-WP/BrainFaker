<?php # -*- coding: utf-8 -*-

declare(strict_types=1);

namespace Brain\Faker\Provider;

trait CountableFunctionMockerProviderTrait
{
    use FunctionMockerProviderTrait;

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

    abstract private function countEntityEntries(array $query): bool;
}
