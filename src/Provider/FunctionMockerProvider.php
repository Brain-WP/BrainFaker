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

use Brain\Faker\FunctionExpectations;
use Faker\Generator;

abstract class FunctionMockerProvider extends Provider
{
    /**
     * @var bool
     */
    private $functionsMocked = false;

    /**
     * @var FunctionExpectations
     */
    protected $functionExpectations;

    /**
     * @param Generator $generator
     * @param FunctionExpectations $expectations
     */
    public function __construct(Generator $generator, FunctionExpectations $expectations)
    {
        parent::__construct($generator);
        $this->functionExpectations = $expectations;
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->functionsMocked = false;
        parent::reset();
    }

    /**
     * @return bool
     */
    public function canMockFunctions(): bool
    {
        return !$this->functionsMocked;
    }

    /**
     * @return void
     */
    public function stopMockingFunctions(): void
    {
        $this->functionsMocked = true;
    }
}
