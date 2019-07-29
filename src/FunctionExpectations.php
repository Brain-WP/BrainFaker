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

namespace Brain\Faker;

use Brain\Monkey\Expectation\Expectation;
use Brain\Monkey\Functions;

class FunctionExpectations
{
    /**
     * @var Expectation[]
     */
    private $functionExpectations = [];

    /**
     * @param string $function
     * @return Expectation
     */
    public function mock(string $function): Expectation
    {
        $this->functionExpectations[$function] = Functions\expect($function);

        return $this->functionExpectations[$function];
    }

    /**
     * @param string $function
     * @return Expectation
     */
    public function replace(string $function): Expectation
    {
        if (isset($this->functionExpectations[$function])) {
            /** @var Expectation $expectation */
            $expectation = $this->functionExpectations[$function];
            /** @noinspection PhpUndefinedMethodInspection */
            $expectation->byDefault();

            return $expectation->andAlsoExpectIt();
        }

        return Functions\expect($function);
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        foreach ($this->functionExpectations as $expectation) {
            /** @noinspection PhpUndefinedMethodInspection */
            $expectation->byDefault();
        }

        $this->functionExpectations = [];
    }
}
