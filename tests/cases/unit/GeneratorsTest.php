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

use Brain\Faker\Generators;
use Brain\Faker\Providers;
use Brain\Faker\Tests\TestCase;

class GeneratorsTest extends TestCase
{
    public function testInstantiation()
    {
        $generatorIt = Generators::create('it_IT');
        $generatorDefault = Generators::create();
        $generatorItAgain = Generators::create('it_IT');
        $generatorDefaultAgain = Generators::create();

        static::assertSame($generatorIt, $generatorItAgain);
        static::assertSame($generatorDefault, $generatorDefaultAgain);
        static::assertNotSame($generatorIt, $generatorDefault);

        Generators::reset();

        $generatorItThirdTime = Generators::create('it_IT');
        $generatorItFourthTime = Generators::create('it_IT');

        static::assertSame($generatorItThirdTime, $generatorItFourthTime);
        static::assertNotSame($generatorIt, $generatorItThirdTime);
    }

    public function testWpMethodReturnProvider()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        static::assertInstanceOf(Providers::class, Generators::create()->wp());
    }
}
