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

use Brain\Faker\Provider\Provider;
use Faker\Factory;

abstract class ProviderTestCase extends TestCase
{
    private $providers = [];

    private $functions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->functions = new \ArrayObject();
    }

    protected function tearDown(): void
    {
        $this->functions = null;

        /** @var  Provider$provider */
        foreach ($this->providers as $provider) {
            $provider->reset();
        }

        parent::tearDown();
    }

    /**
     * @param string $class
     * @return Provider
     */
    protected function factoryProvider(string $class): Provider
    {
        /** @var Provider $provider */
        $provider = new $class(Factory::create(), $this->functions);
        $this->providers[] = $provider;

        return $provider;
    }

    /**
     * @param string $formatString
     * @return \DateTime|null
     */
    protected function dateByMySql(string $formatString): ?\DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $formatString) ?: null;
    }
}
