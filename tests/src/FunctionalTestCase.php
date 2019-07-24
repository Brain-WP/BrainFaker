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

namespace Brain\Faker\Tests;

use Brain;
use Faker\Generator;

abstract class FunctionalTestCase extends TestCase
{
    /**
     * @var Generator
     */
    protected $faker;

    /**
     * @var Brain\Faker\Providers
     */
    protected $wpFaker;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Brain\faker();

        /** @noinspection PhpUndefinedMethodInspection */
        $this->wpFaker = $this->faker->wp();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Brain\fakerReset();
        parent::tearDown();
    }
}
