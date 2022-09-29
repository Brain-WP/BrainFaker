<?php # -*- coding: utf-8 -*-

declare(strict_types=1);

namespace Brain\Faker\Provider;

trait CreateWPErrorMockerProviderTrait
{
    private function createWPError(string $code, string $message): \WP_Error
    {
        return (new Error($this->generator))->__invoke([
            'code' => $code,
            'message' => $message,
        ]);
    }
}
