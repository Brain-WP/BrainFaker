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

namespace Brain\Faker\Tests\Unit\Provider;

use Brain\Faker\Tests\FactoryTestCase;
use Brain\Faker\Provider;

class CommentTest extends FactoryTestCase
{
    public function testNoPropertiesCreation()
    {
        $factory = $this->factoryProvider(Provider\Comment::class);
        $comment = $factory();

        static::assertInstanceOf(\WP_Comment::class, $comment);

        static::assertIsInt($comment->comment_ID);
        static::assertGreaterThanOrEqual(1, $comment->comment_ID);
        static::assertIsInt($comment->comment_post_ID);
        static::assertGreaterThanOrEqual(1, $comment->comment_post_ID);
        static::assertIsString($comment->comment_author);
        static::assertTrue((bool)filter_var($comment->comment_author_email, FILTER_VALIDATE_EMAIL));
        static::assertIsString($comment->comment_author_url);
        static::assertIsString($comment->comment_author_url);
        static::assertIsString($comment->comment_author_IP);
        static::assertTrue((bool)filter_var($comment->comment_author_IP, FILTER_VALIDATE_IP));
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($comment->comment_date));
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($comment->comment_date_gmt));
        static::assertIsString($comment->comment_content);
        static::assertSame(0, $comment->comment_karma);
        static::assertTrue(in_array($comment->comment_approved, Provider\Comment::STATUSES));
        static::assertIsString($comment->comment_agent);
        static::assertIsString($comment->comment_type);
        static::assertIsInt($comment->comment_parent);
        static::assertGreaterThanOrEqual(0, $comment->comment_parent);
        static::assertIsInt($comment->user_id);
        static::assertGreaterThanOrEqual(0, $comment->user_id);

        $expectedArray = [
            'comment_ID' => $comment->comment_ID,
            'comment_post_ID' => $comment->comment_post_ID,
            'comment_author' => $comment->comment_author,
            'comment_author_email' => $comment->comment_author_email,
            'comment_author_url' => $comment->comment_author_url,
            'comment_author_IP' =>  $comment->comment_author_IP,
            'comment_date' => $comment->comment_date,
            'comment_date_gmt' => $comment->comment_date_gmt,
            'comment_content' => $comment->comment_content,
            'comment_karma' => $comment->comment_karma,
            'comment_approved' => $comment->comment_approved,
            'comment_agent' => $comment->comment_agent,
            'comment_type' => $comment->comment_type,
            'comment_parent' => $comment->comment_parent,
            'user_id' => $comment->user_id,
        ];

        $actualArray = $comment->to_array();

        ksort($expectedArray);
        ksort($actualArray);

        static::assertSame($expectedArray, $actualArray);
    }

    public function testCreateWithFixedId()
    {
        $factory = $this->factoryProvider(Provider\Comment::class);
        $comment = $factory(['id' => 123]);

        static::assertInstanceOf(\WP_Comment::class, $comment);
        static::assertSame(123, $comment->comment_ID);
    }

    public function testCreateWithFixedType()
    {
        $factory = $factory = $this->factoryProvider(Provider\Comment::class);
        $comment = $factory(['type' => 'pingback']);

        static::assertInstanceOf(\WP_Comment::class, $comment);
        static::assertSame('pingback', $comment->comment_type);
    }

    public function testIdUniqueness()
    {
        $factory = $this->factoryProvider(Provider\Comment::class);

        $ids = [];
        for ($i = 0; $i < 200; $i++) {
            $ids[] = $factory()->comment_ID;
        }

        static::assertSame($ids, array_unique($ids));
    }
}