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

namespace Brain;

use Faker\Factory;
use Faker\Generator;

/**
 * @phpcs:disable Inpsyde.CodeQuality.ReturnTypeDeclaration.GeneratorReturnTypeWithoutYield
 */

/**
 * @param string $locale
 * @return Generator
 */
function faker(string $locale = Factory::DEFAULT_LOCALE): Generator
{
    return Faker\Generators::create($locale);
}

/**
 * @return void
 */
function fakerReset(): void
{
    Faker\Generators::reset();
}
