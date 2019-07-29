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

use Brain\Faker\Provider;
use Brain\Faker\Tests\ProviderTestCase;

class PostTest extends ProviderTestCase
{
    public function testNoPropertiesCreation()
    {
        $factory = $this->factoryProvider(Provider\Post::class);
        $post = $factory();

        static::assertInstanceOf(\WP_Post::class, $post);

        static::assertIsInt($post->ID);
        static::assertGreaterThanOrEqual(1, $post->ID);
        static::assertIsNumeric($post->post_author);
        static::assertGreaterThanOrEqual(1, (int)$post->post_author);
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($post->post_date));
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($post->post_date_gmt));
        static::assertIsString($post->post_content);
        static::assertIsString($post->post_title);
        static::assertIsString($post->post_excerpt);
        static::assertTrue(in_array($post->post_status, ['publish', 'draft', 'future']));
        static::assertTrue(in_array($post->comment_status, ['open', 'closed']));
        static::assertTrue(in_array($post->ping_status, ['open', 'closed']));
        static::assertIsString($post->post_password);
        static::assertIsString($post->post_name);
        static::assertSame('', $post->to_ping);
        static::assertSame('', $post->pinged);
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($post->post_modified));
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($post->post_modified_gmt));
        static::assertIsString($post->post_content_filtered);
        static::assertSame($post->post_content_filtered, trim(strip_tags($post->post_content)));
        static::assertIsInt($post->post_parent);
        static::assertGreaterThanOrEqual(0, $post->post_parent);
        static::assertTrue((bool)filter_var($post->guid ,FILTER_VALIDATE_URL));
        static::assertIsInt($post->menu_order);
        static::assertGreaterThanOrEqual(0, $post->menu_order);
        static::assertTrue(in_array($post->post_type, ['post', 'page']));
        static::assertSame('', $post->post_mime_type);
        static::assertSame('0', $post->comment_count);
        static::assertTrue(in_array($post->filter, ['raw', null]));
        static::assertSame([], $post->ancestors);
        static::assertSame('', $post->page_template);
        static::assertSame([], $post->post_category);
        static::assertSame([], $post->tags_input);

        $expectedArray = [
            'ID' => $post->ID,
            'post_author' => $post->post_author,
            'post_date' => $post->post_date,
            'post_date_gmt' => $post->post_date_gmt,
            'post_content' => $post->post_content,
            'post_title' => $post->post_title,
            'post_excerpt' => $post->post_excerpt,
            'post_status' => $post->post_status,
            'comment_status' => $post->comment_status,
            'ping_status' => $post->ping_status,
            'post_password' => $post->post_password,
            'post_name' => $post->post_name,
            'to_ping' => $post->to_ping,
            'pinged' => $post->pinged,
            'post_modified' => $post->post_modified,
            'post_modified_gmt' => $post->post_modified_gmt,
            'post_content_filtered' => $post->post_content_filtered,
            'post_parent' => $post->post_parent,
            'guid' => $post->guid,
            'menu_order' => $post->menu_order,
            'post_type' =>  $post->post_type,
            'post_mime_type' =>  $post->post_mime_type,
            'comment_count' => $post->comment_count,
            'filter' => $post->filter,
            'ancestors' => $post->ancestors,
            'page_template' => $post->page_template,
            'post_category' => $post->post_category,
            'tags_input' => $post->tags_input,
        ];

        $actualArray = $post->to_array();

        ksort($expectedArray);
        ksort($actualArray);

        static::assertSame($expectedArray, $actualArray);

        static::assertSame($post->to_array(), get_post($post->ID)->to_array());
        static::assertSame($post->to_array(), get_post((string)$post->ID)->to_array());
        static::assertSame($post->to_array(), get_post($post)->to_array());

        foreach ($expectedArray as $key => $value) {
            static::assertSame($value ?? '', get_post_field($key, $post->ID));
            static::assertSame($value ?? '', get_post_field($key, $post));
        }
    }

    public function testCreateWithId()
    {
        $factory = $this->factoryProvider(Provider\Post::class);
        $post = $factory(['id' => 123]);

        static::assertSame(123, $post->ID);
    }

    public function testCreateWithAttachmentType()
    {
        $factory = $this->factoryProvider(Provider\Post::class);
        $post = $factory(['type' => 'attachment']);

        static::assertSame('attachment', $post->post_type);
        static::assertTrue(in_array($post->post_mime_type, Provider\Post::MIME_TYPES, true));
    }

    public function testFuturePost()
    {
        $factory = $this->factoryProvider(Provider\Post::class);
        $post = $factory(['date' => '+1 year']);

        $gmt = new \DateTimeZone('GMT');
        $postDateGmt = \DateTime::createFromFormat('Y-m-d H:i:s', $post->post_date_gmt, $gmt);

        $compare = (new \DateTime('now', $gmt))->modify('+1 year')->modify('-1 day');

        static::assertSame('future', $post->post_status);
        static::assertGreaterThan($compare->getTimestamp(), $postDateGmt->getTimestamp());
    }

    public function testWithFixedDateTime()
    {
        $factory = $this->factoryProvider(Provider\Post::class);

        $gmt = new \DateTimeZone('GMT');
        $now = new \DateTime('now', $gmt);

        $post = $factory(['date_gmt' => $now]);

        $postDateGmt = \DateTime::createFromFormat('Y-m-d H:i:s', $post->post_date_gmt, $gmt);

        static::assertSame($now->getTimestamp(), $postDateGmt->getTimestamp());
    }

    public function testTrashedPost()
    {
        $factory = $this->factoryProvider(Provider\Post::class);

        $post = $factory(['status' => 'trash']);

        static::assertSame('trash', $post->post_status);
    }

    public function testFunctionWithMultipleObjects()
    {
        /** @var Provider\Post $factory */
        $factory = $this->factoryProvider(Provider\Post::class);

        $posts = [];
        for ($i = 0; $i < 100; $i++) {
            $posts[] = $factory();
        }

        /** @var \WP_Post $post */
        foreach ($posts as $post) {
            /** @var \WP_Post $compare */
            $compare = get_post($post->ID);
            static::assertSame($post->to_array(), $compare->to_array());
        }
    }
}