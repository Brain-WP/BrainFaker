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
     *
     * phpcs:disable Inpsyde.CodeQuality.FunctionLength.TooLong
     */
    public function __invoke(array $properties = []): \WP_Error
    {
        // phpcs:enable Inpsyde.CodeQuality.FunctionLength.TooLong

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

        $error->shouldReceive('has_errors')
            ->andReturnUsing(
                static function () use (&$error) { // phpcs:ignore
                    return isset($error->errors) && $error->errors;
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_codes')
            ->andReturnUsing(
                static function () use (&$error) { // phpcs:ignore
                    return $error->has_errors() ? array_keys($error->errors) : [];
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_code')
            ->andReturnUsing(
                static function () use (&$error) {  // phpcs:ignore
                    return $error->get_error_codes()[0] ?? '';
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_messages')
            ->withNoArgs()
            ->andReturnUsing(
                static function () use (&$error) { // phpcs:ignore
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
                static function ($code) use (&$error) { // phpcs:ignore
                    if (!$code) {
                        return $error->get_error_messages();
                    }

                    return $error->errors[$code] ?? [];
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_message')
            ->withNoArgs()
            ->andReturnUsing(
                static function () use (&$error) { // phpcs:ignore
                    return $error->errors[$error->get_error_code()][0] ?? '';
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_message')
            ->with(\Mockery::type('scalar'))
            ->andReturnUsing(
                static function ($code) use (&$error) { // phpcs:ignore
                    return $error->errors[$code ?: $error->get_error_code()][0] ?? '';
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_data')
            ->withNoArgs()
            ->andReturnUsing(
                static function () use (&$error) { // phpcs:ignore
                    return $error->error_data[$error->get_error_code()] ?? null;
                }
            )
            ->byDefault();

        $error->shouldReceive('get_error_data')
            ->with(\Mockery::type('scalar'))
            ->andReturnUsing(
                static function ($code) use (&$error) { // phpcs:ignore
                    return $error->error_data[$code ?: $error->get_error_code()] ?? null;
                }
            )
            ->byDefault();

        $error->shouldReceive('add')
            ->with(\Mockery::type('scalar'), \Mockery::type('string'))
            ->andReturnUsing(
                static function ($code, $message) use (&$error) { // phpcs:ignore
                    array_key_exists($code, $error->errors) or $error->errors[$code] = [];
                    $error->errors[$code][] = $message;
                }
            )
            ->byDefault();

        $error->shouldReceive('add')
            ->with(\Mockery::type('scalar'), \Mockery::type('string'), \Mockery::any())
            ->andReturnUsing(
                static function ($code, $message, $data) use (&$error) { // phpcs:ignore
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
                static function ($data) use (&$error) { // phpcs:ignore
                    $code = $error->get_error_code();
                    array_key_exists($code, $error->error_data) or $error->error_data[$code] = [];
                    $error->error_data[$code] = $data;
                }
            )
            ->byDefault();

        $error->shouldReceive('add_data')
            ->with(\Mockery::any(), \Mockery::type('scalar'))
            ->andReturnUsing(
                static function ($data, $code) use (&$error) { // phpcs:ignore
                    array_key_exists($code, $error->error_data) or $error->error_data[$code] = [];
                    $error->error_data[$code] = $data;
                }
            )
            ->byDefault();

        $error->shouldReceive('remove')
            ->with(\Mockery::type('scalar'))
            ->andReturnUsing(
                static function ($code) use (&$error) { // phpcs:ignore
                    unset($error->errors[$code]);
                    unset($error->error_data[$code]);
                }
            )
            ->byDefault();

        return $error;
    }
}
