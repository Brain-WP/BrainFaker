<?php # -*- coding: utf-8 -*-
/*
 * This file is part of the BrainFaker package.
 *
 * (c) Giuseppe Mazzapica
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */

declare(strict_types=1);

namespace Brain\Faker;

/**
 * @codeCoverageIgnore
 * phpcs:disable
 */
class MonkeyWpUser
{
    /**
     * @return \WP_User|\Mockery\MockInterface|MonkeyWpUser
     */
    public function __monkeyMakeCurrent()
    {
    }
}
