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

use Brain\Faker\Provider;
use Brain\Faker\Tests\FactoryTestCase;

class ErrorTest extends FactoryTestCase
{
    public function testNoPropertiesCreation()
    {
        $factory = $this->factoryProvider(Provider\Error::class);
        $error = $factory();

        static::assertInstanceOf(\WP_Error::class, $error);
        static::assertTrue(is_wp_error($error));
        static::assertSame([], $error->errors);
        static::assertSame([], $error->error_data);
        static::assertFalse($error->has_errors());
        static::assertSame('', $error->get_error_code());
        static::assertSame([], $error->get_error_codes());
        static::assertNull($error->get_error_data());
        static::assertSame('', $error->get_error_message());
        static::assertSame([], $error->get_error_messages());
    }

    public function testWithError()
    {
        $factory = $this->factoryProvider(Provider\Error::class);
        $error = $factory(['error' => 'Ahi!']);

        $code = $error->get_error_code();

        static::assertInstanceOf(\WP_Error::class, $error);

        static::assertIsString($code);
        static::assertSame('Ahi!', $error->get_error_message());
        static::assertSame('Ahi!', $error->get_error_message($code));
        static::assertSame(['Ahi!'], $error->get_error_messages());
        static::assertSame(['Ahi!'], $error->get_error_messages($code));
        static::assertTrue($error->has_errors());
    }

    public function testWithErrorAndCode()
    {
        $factory = $this->factoryProvider(Provider\Error::class);
        $error = $factory(['error' => 'Ahi!', 'code' => 'foo']);

        static::assertInstanceOf(\WP_Error::class, $error);

        static::assertSame('foo', $error->get_error_code());
        static::assertSame('Ahi!', $error->get_error_message());
        static::assertSame('Ahi!', $error->get_error_message('foo'));
        static::assertSame(['Ahi!'], $error->get_error_messages());
        static::assertSame(['Ahi!'], $error->get_error_messages('foo'));
        static::assertTrue($error->has_errors());
    }

    public function testAddError()
    {
        $factory = $this->factoryProvider(Provider\Error::class);
        $error = $factory();

        static::assertInstanceOf(\WP_Error::class, $error);

        static::assertFalse($error->has_errors());

        $error->add('foo', 'One');
        $error->add('foo', 'Two');
        $error->add('bar', 'Three', 'some data');

        static::assertSame('foo', $error->get_error_code());
        static::assertSame(['foo', 'bar'], $error->get_error_codes());
        static::assertSame('One', $error->get_error_message());
        static::assertSame('One', $error->get_error_message('foo'));
        static::assertSame('Three', $error->get_error_message('bar'));
        static::assertSame(['One', 'Two', 'Three'], $error->get_error_messages());
        static::assertSame(['One', 'Two'], $error->get_error_messages('foo'));
        static::assertSame(['Three'], $error->get_error_messages('bar'));
        static::assertNull($error->get_error_data('foo'));
        static::assertNull($error->get_error_data());
        static::assertSame('some data', $error->get_error_data('bar'));

        static::assertTrue($error->has_errors());
    }

    public function testAddErrorData()
    {
        /** @var Provider\Error $factory */
        $factory = $this->factoryProvider(Provider\Error::class);
        $error = $factory();

        $error->add_data('Data before');

        static::assertSame('Data before', $error->get_error_data());
        static::assertSame('Data before', $error->get_error_data(''));

        $error->add('x', 'One');

        $error->add_data('Data after');
        $error->add_data('Data foo', 'foo');

        static::assertSame('Data after', $error->get_error_data());
        static::assertSame('Data after', $error->get_error_data(''));
        static::assertSame('Data after', $error->get_error_data('x'));
        static::assertSame('Data foo', $error->get_error_data('foo'));
    }

    public function testRemove()
    {
        /** @var Provider\Error $factory */
        $factory = $this->factoryProvider(Provider\Error::class);
        $error = $factory();

        $error->add('code', 'msg', 'data');

        static::assertSame('code', $error->get_error_code());
        static::assertSame('msg', $error->get_error_message());
        static::assertSame('data', $error->get_error_data());

        $error->remove('code');

        static::assertSame('', $error->get_error_code());
        static::assertSame('', $error->get_error_message());
        static::assertNull($error->get_error_data());
    }

}