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

namespace Brain\Faker\Tests\Unit;

use Brain\Faker\Provider\Post;
use Brain\Faker\Providers;
use Brain\Faker\Tests\TestCase;
use Faker\Factory;

class ProvidersInitTest extends TestCase
{
    public function testWpMethodRequiresInitialization()
    {
        $this->expectExceptionMessageRegExp('/initialized/');

        $provider = new Providers(Factory::create());
        $provider->wp();
    }

    public function testCallMethodRequiresInitialization()
    {
        $this->expectExceptionMessageRegExp('/initialized/');

        $provider = new Providers(Factory::create());
        /** @noinspection PhpUndefinedMethodInspection */
        $provider->test();
    }

    /**
     * @runInSeparateProcess
     */
    public function testResetUniqueness()
    {
        $provider = new Providers(Factory::create());

        $php = <<<'PHP'
namespace Brain\Faker\Tests\Unit;

class ExampleClass extends \Brain\Faker\Provider\Provider {
    public function __invoke(array $args = []) {
        return (object)['digit' => $this->uniqueGenerator->randomDigitNotNull];
    }
}
PHP;
        eval($php); // phpcs:ignore

        /** @noinspection PhpUndefinedClassInspection */
        $provider->__addProviderClass(ExampleClass::class, 'thing', 'things');

        $exceptionHappened = false;

        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $provider->wp()->things(10);
        } catch (\OverflowException $exception) {
            $exceptionHappened = true;
        }

        static::assertTrue($exceptionHappened);

        $provider->wp()->__resetUnique();

        static::assertIsInt($provider->wp()->thing->digit);
    }
}
