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

use ArrayObject;
use Brain\Monkey;
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
     * @var ArrayObject
     */
    protected $functionExpectations;

    /**
     * @param Generator $generator
     * @param ArrayObject $functionExpectations
     */
    final public function __construct(Generator $generator, ArrayObject $functionExpectations)
    {
        $this->generator = $generator;
        $this->uniqueGenerator = $generator->unique(true);
        $this->functionExpectations = $functionExpectations;
    }

    /**
     * @return void
     */
    final public function resetUnique(): void
    {
        $this->uniqueGenerator = $this->generator->unique(true);
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->resetUnique();
    }

    /**
     * @param array $args
     * @return object
     */
    abstract public function __invoke(array $args = []);

    /**
     * @param string $function
     * @return Monkey\Expectation\Expectation
     */
    protected function monkeyMockFunction(string $function): Monkey\Expectation\Expectation
    {
        $this->functionExpectations[$function] = Monkey\Functions\expect($function);

        return $this->functionExpectations[$function];
    }
}
