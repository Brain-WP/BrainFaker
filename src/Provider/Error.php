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

class Error extends Provider
{
    /**
     * @param array $properties
     * @return \WP_Error
     */
    public function __invoke(array $properties = []): \WP_Error
    {
        $properties = array_change_key_case($properties, CASE_LOWER);

        $errors = (array)($properties['errors'] ?? []);
        $errorData = (array)($properties['errors_data'] ?? $properties['data'] ?? []);

        $single = $properties['message'] ?? $properties['error'] ?? null;
        if (is_string($single)) {
            $code = isset($properties['code']) && is_scalar($properties['code'])
                ? $properties['code']
                : $this->generator->word;
            $errors[$code] = [$single];
            unset($properties['message'], $properties['error'], $properties['code']);
        }

        $error = \Mockery::mock(\WP_Error::class);
        $error->errors = $errors;
        $error->error_data = $errorData;

        $error->shouldReceive('get_error_codes')
            ->andReturnUsing(
                function () use (&$error) {
                    return $error->errors ? array_keys($error->errors) : [];
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_code')
            ->andReturnUsing(
                function () use (&$error) {
                    return $error->errors ? array_keys($error->errors)[0] : '';
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_messages')
            ->withNoArgs()
            ->andReturnUsing(
                function () use (&$error) {
                    $allMessages = [];
                    foreach ($error->errors as $codeMessages) {
                        $allMessages = array_merge($allMessages, $codeMessages);
                    }

                    return $allMessages;
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_messages')
            ->with(\Mockery::type('scalar'))
            ->andReturnUsing(
                function ($code) use (&$error) {
                    return $error->errors[$code] ?? [];
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_message')
            ->withNoArgs()
            ->andReturnUsing(
                function () use (&$error) {
                    $code = $error->errors ? array_keys($error->errors)[0] : '';

                    return $error->errors[$code][0] ?? '';
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_message')
            ->with(\Mockery::type('scalar'))
            ->andReturnUsing(
                function ($code) use (&$error) {
                    return $error->errors[$code][0] ?? '';
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_data')
            ->withNoArgs()
            ->andReturnUsing(
                function () use (&$error) {
                    $code = $error->error_data ? array_keys($error->error_data)[0] : null;

                    return $code === null ? null : ($this->error_data[$code] ?? null);
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_data')
            ->with(\Mockery::type('scalar'))
            ->andReturnUsing(
                function ($code) use (&$error) {
                    return $error->error_data[$code] ?? null;
                }
            )
            ->byDefault();

        $error->shouldReceive('has_errors')
            ->andReturnUsing(
                function () use (&$error) {
                    return (bool)$error->errors;
                }
            )
            ->byDefault();

        $error->shouldReceive('add')
            ->with(\Mockery::type('scalar'), \Mockery::type('string'))
            ->andReturnUsing(
                function ($code, $message) use (&$error) {
                    array_key_exists($code, $error->errors) or $error->errors[$code] = [];
                    $error->errors[$code][] = $message;
                }
            )
            ->byDefault();

        $error->shouldReceive('add')
            ->with(\Mockery::type('scalar'), \Mockery::type('string'), \Mockery::any())
            ->andReturnUsing(
                function ($code, $message, $data) use (&$error) {
                    array_key_exists($code, $error->errors) or $error->errors[$code] = [];
                    $error->errors[$code][] = $message;
                    if (!$data) {
                        return;
                    }
                    array_key_exists($code, $error->error_data) or $error->error_data[$code] = [];
                    $error->error_data[$code] = $data;
                }
            )
            ->byDefault();

        $error->shouldReceive('add_data')
            ->with(\Mockery::any())
            ->andReturnUsing(
                function ($data) use (&$error) {
                    $code = $error->errors ? array_keys($error->errors)[0] : '';
                    array_key_exists($code, $error->error_data) or $error->error_data[$code] = [];
                    $error->error_data[$code] = $data;
                }
            )
            ->byDefault();

        $error->shouldReceive('add_data')
            ->with(\Mockery::any(), \Mockery::type('scalar'))
            ->andReturnUsing(
                function ($data, $code) use (&$error) {
                    array_key_exists($code, $error->error_data) or $error->error_data[$code] = [];
                    $error->error_data[$code] = $data;
                }
            )
            ->byDefault();

        $error->shouldReceive('remove')
            ->with(\Mockery::type('scalar'))
            ->andReturnUsing(
                function ($code) use (&$error) {
                    unset($error->errors[$code]);
                    unset($error->error_data[$code]);
                }
            )
            ->byDefault();

        return $error;
    }
}