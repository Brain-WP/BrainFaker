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

namespace Brain\Faker\Tests\Functional;

use Brain\Monkey;
use Brain\Faker\Tests\FunctionalTestCase;

/**
 * @coversNothing
 */
class BrainFakerTest extends FunctionalTestCase
{
    public function testPostAndUser()
    {
        $this->wpFaker->post(['id' => 123, 'author' => 456]);
        $this->wpFaker->user(['id' => 456, 'role' => 'editor'])->__monkeyMakeCurrent();

        static::assertSame('It works!', $this->productionCode(123));
    }

    public function testPostAndUserNoRole()
    {
        $this->wpFaker->post(['id' => 123, 'author' => 456]);
        $this->wpFaker->user(['id' => 456, 'role' => 'subscriber'])->__monkeyMakeCurrent();

        static::assertSame('Can\'t edit pages', $this->productionCode(123));
    }

    public function testPostAndUserNoPost()
    {
        $this->wpFaker->post(['id' => 123, 'author' => 456]);
        $this->wpFaker->user(['id' => 456, 'role' => 'subscriber'])->__monkeyMakeCurrent();

        static::assertSame('No post', $this->productionCode(124));
    }

    public function testPostAndUserNoCurrentUser()
    {
        $this->wpFaker->post(['id' => 123, 'author' => 457]);
        $this->wpFaker->user(['id' => 456, 'role' => 'subscriber'])->__monkeyMakeCurrent();

        static::assertSame('No user ID', $this->productionCode(123));
    }

    public function testPostAndUserNotExists()
    {
        $this->wpFaker->post(['id' => 123, 'author' => 456]);
        $this->wpFaker->user(['id' => 456, 'role' => 'subscriber'])
            ->__monkeyMakeCurrent()
            ->shouldReceive('exists')
            ->once()
            ->andReturn(false);

        static::assertSame('Bad user', $this->productionCode(123));
    }

    public function testWithoutBrainFaker()
    {
        $post = \Mockery::mock(\WP_Post::class);
        $post->post_author = 456;

        $user = \Mockery::mock(\WP_User::class);
        $user->shouldReceive('exists')->andReturn(true);
        $user->shouldReceive('has_cap')->with('edit_others_pages')->andReturn(true);
        $user->ID = 456;
        $user->user_email = 'me@example.com';
        $user->user_url = 'http://example.com';

        Monkey\Functions\expect('get_post')->with(123)->andReturn($post);
        Monkey\Functions\expect('user_can')->with($user, 'upload_files')->andReturn(true);
        Monkey\Functions\expect('get_current_user_id')->andReturn(456);
        Monkey\Functions\expect('get_userdata')->with(456)->andReturn($user);
        Monkey\Functions\expect('wp_get_current_user')->andReturn($user);

        static::assertSame('It works!', $this->productionCode(123));
    }

    /**
     * @param int $postId
     * @return string
     */
    private function productionCode(int $postId): string
    {
        $post = get_post($postId);

        if (!$post instanceof \WP_Post) {
            return 'No post';
        }

        $callback = static function (\WP_User $user) {
            if (wp_get_current_user()->ID !== $user->ID) {
                return "No current user";
            }

            if (!user_can($user, 'upload_files')) {
                return "Can't upload";
            }

            if (filter_var($user->user_email, FILTER_VALIDATE_EMAIL)
                && filter_var($user->user_url, FILTER_VALIDATE_URL)
            ) {
                return 'It works!';
            }

            return 'Bad email or URL';
        };

        $authorId = (int)$post->post_author;

        if ($authorId === get_current_user_id()) {
            $user = get_userdata($authorId);
            if (!$user->exists()) {
                return 'Bad user';
            }

            if ($user->has_cap('edit_others_pages')) {
                return $callback($user);
            }

            return "Can't edit pages";
        }

        return 'No user ID';
    }
}