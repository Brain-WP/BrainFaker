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

use Faker\Generator;
use Faker\UniqueGenerator;

abstract class Provider
{
    /**
     * @var Generator
     */
    protected $generator;

    /**
     * @var UniqueGenerator|Generator
     */
    protected $uniqueGenerator;

    /**
     * @param Generator $generator
     */
    final public function __construct(Generator $generator) {
        $this->generator = $generator;
        $this->uniqueGenerator = $generator->unique(true);
    }

    /**
     * @return void
     */
    final public function resetUnique(): void
    {
        $this->uniqueGenerator = $this->generator->unique(true);
    }

    /**
     * @param array $args
     * @return object
     */
    abstract public function __invoke(array $args = []);
}
