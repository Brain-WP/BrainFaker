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
use Brain\Monkey;

class SiteTest extends FactoryTestCase
{
    public function testNoPropertiesCreation()
    {
        /** @var Provider\Site $factory */
        $factory = $this->factoryProvider(Provider\Site::class);
        $site = $factory();

        static::assertInstanceOf(\WP_Site::class, $site);

        static::assertIsString($site->blog_id);
        static::assertIsNumeric($site->blog_id);
        static::assertGreaterThanOrEqual(1, (int)$site->blog_id);
        static::assertIsString($site->domain);
        static::assertIsString($site->path);
        static::assertIsString($site->site_id);
        static::assertIsNumeric($site->site_id);
        static::assertGreaterThanOrEqual(1, (int)$site->site_id);
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($site->registered));
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($site->last_updated));
        static::assertIsString($site->public);
        static::assertIsNumeric($site->public);
        static::assertContains($site->public, ['0', '1']);
        static::assertIsString($site->archived);
        static::assertIsNumeric($site->archived);
        static::assertContains($site->archived, ['0', '1']);
        static::assertIsString($site->mature);
        static::assertIsNumeric($site->mature);
        static::assertContains($site->mature, ['0', '1']);
        static::assertIsString($site->spam);
        static::assertIsNumeric($site->spam);
        static::assertContains($site->spam, ['0', '1']);
        static::assertIsString($site->deleted);
        static::assertIsNumeric($site->deleted);
        static::assertContains($site->deleted, ['0', '1']);
        static::assertIsString($site->lang_id);
        static::assertIsNumeric($site->lang_id);
        static::assertContains($site->lang_id, ['0', '1']);

        $expectedArray = [
            'blog_id' => $site->blog_id,
            'domain' => $site->domain,
            'path' => $site->path,
            'site_id' => $site->site_id,
            'registered' => $site->registered,
            'last_updated' => $site->last_updated,
            'public' => $site->public,
            'archived' => $site->archived,
            'mature' => $site->mature,
            'spam' => $site->spam,
            'deleted' => $site->deleted,
            'lang_id' => $site->lang_id,
        ];

        $actualArray = $site->to_array();

        ksort($expectedArray);
        ksort($actualArray);

        static::assertSame($expectedArray, $actualArray);
        static::assertSame($site->blog_id, $site->id);
        static::assertSame($site->site_id, $site->network_id);
        static::assertIsString($site->blogname);
        static::assertTrue((bool)filter_var($site->siteurl, FILTER_VALIDATE_URL));
        static::assertTrue((bool)filter_var($site->home, FILTER_VALIDATE_URL));
        static::assertIsInt($site->post_count);
        static::assertGreaterThan(0, $site->post_count);
        static::assertSame($site, get_site($site->blog_id));
        static::assertSame($site, get_site((int)$site->blog_id));
    }

    public function testWithGivenId()
    {
        /** @var Provider\Site $factory */
        $factory = $this->factoryProvider(Provider\Site::class);
        $site = $factory(['id' => 123]);

        static::assertSame('123', $site->blog_id);
        static::assertSame('123', $site->id);
    }

    public function testWithGivenUrl()
    {
        /** @var Provider\Site $factory */
        $factory = $this->factoryProvider(Provider\Site::class);
        $site = $factory(['url' => 'example.com/blog/']);

        static::assertSame('http://example.com/blog/', $site->home);
        static::assertSame('http://example.com/blog/', $site->siteurl);
        static::assertSame('/blog', $site->path);
    }

    /**
     * @runInSeparateProcess
     */
    public function testDoesNotCreateOnSingleSite()
    {
        Monkey\Functions\when('is_multisite')->justReturn(false);

        $this->expectExceptionMessageRegExp('/multisite/');
        $this->factoryProvider(Provider\Site::class)();
    }
}