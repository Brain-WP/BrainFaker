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

use Brain\Monkey;
use Brain\Faker\Provider;
use Brain\Faker\Tests\ProviderTestCase;

class UserTest extends ProviderTestCase
{
    public function testNoPropertiesCreation()
    {
        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);
        $user = $factory();

        static::assertInstanceOf(\WP_User::class, $user);

        static::assertIsInt($user->ID);
        static::assertGreaterThan(1, $user->ID);
        static::assertInstanceOf(\stdClass::class, $user->data);
        static::assertSame($user->ID, $user->data->ID);
        static::assertIsArray($user->caps);
        static::assertIsString($user->cap_key);
        static::assertIsArray($user->roles);
        static::assertIsArray($user->allcaps);
        static::assertContains($user->filter, ['raw', null]);

        static::assertIsString($user->user_login);
        static::assertIsString($user->user_pass);
        static::assertIsString($user->user_nicename);
        static::assertTrue((bool)filter_var($user->user_email, FILTER_VALIDATE_EMAIL));
        static::assertTrue((bool)filter_var($user->user_url, FILTER_VALIDATE_URL));
        static::assertInstanceOf(\DateTime::class, $this->dateByMySql($user->user_registered));
        static::assertIsString($user->user_activation_key);
        static::assertIsString($user->user_status);
        static::assertIsNumeric($user->user_status);
        static::assertIsString($user->display_name);

        static::assertIsString($user->user_description);
        static::assertSame($user->user_description, $user->description);
        static::assertIsString($user->user_firstname);
        static::assertSame($user->user_firstname, $user->first_name);
        static::assertIsString($user->user_lastname);
        static::assertSame($user->user_lastname, $user->last_name);
        static::assertIsInt($user->user_level);
        static::assertIsString($user->nickname);
        static::assertIsString($user->spam);
        static::assertIsString($user->deleted);
        static::assertIsString($user->locale);
        static::assertContains($user->rich_editing, ['true', 'false']);
        static::assertContains($user->syntax_highlighting, ['true', 'false']);

        $expectedArray = [
            'ID' => $user->ID,
            'user_login' => $user->user_login,
            'user_pass' => $user->user_pass,
            'user_nicename' => $user->user_nicename,
            'user_email' => $user->user_email,
            'user_url' => $user->user_url,
            'user_registered' => $user->user_registered,
            'user_activation_key' => $user->user_activation_key,
            'user_status' => $user->user_status,
            'display_name' => $user->display_name,
        ];

        $actualArray = $user->to_array();

        ksort($expectedArray);
        ksort($actualArray);

        static::assertSame($expectedArray, $actualArray);

        static::assertIsInt($user->get_site_id());
        static::assertGreaterThanOrEqual(1, $user->get_site_id());
    }

    public function testGet()
    {
        $keys = [
            'ID',
            'user_login',
            'user_pass',
            'user_nicename',
            'user_email',
            'user_url',
            'user_registered',
            'user_activation_key',
            'user_status',
            'user_description',
            'description',
            'user_firstname',
            'first_name',
            'user_lastname',
            'last_name',
            'user_level',
            'nickname',
            'spam',
            'deleted',
            'locale',
            'rich_editing',
            'syntax_highlighting',
        ];

        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);
        $user = $factory();

        foreach ($keys as $key) {
            $value = $user->get($key);
            static::assertSame((string)$user->{$key}, $value);
        }
    }

    public function testFunctions()
    {
        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);
        $user = $factory();

        $this->compareUser($user, get_userdata($user->ID));
        $this->compareUser($user, get_user_by('ID', $user->ID));
        $this->compareUser($user, get_user_by('id', $user->ID));
        $this->compareUser($user, get_user_by('ID', (string)$user->ID));
        $this->compareUser($user, get_user_by('id', (string)$user->ID));
        $this->compareUser($user, get_user_by('slug', $user->user_nicename));
        $this->compareUser($user, get_user_by('email', $user->user_email));
        $this->compareUser($user, get_user_by('login', $user->user_login));

        static::assertFalse(get_userdata($user->ID + 1));
        static::assertFalse(get_user_by('id', $user->ID + 1));
        static::assertFalse(get_user_by('slug', 'x' . $user->user_nicename));
        static::assertFalse(get_user_by('email', $user->user_email . 'x'));
        static::assertFalse(get_user_by('login', 'x' . $user->user_login));
        static::assertFalse(get_user_by('login ', $user->user_login));
    }

    public function testFunctionsForManyUsers()
    {
        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);

        $users = [];
        for ($i = 0; $i < 1000; $i++) {
            $users[] = $factory();
        }

        $ids = [];
        /** @var \WP_User $user */
        foreach ($users as $user) {
            $ids[] = $user->ID;
            $this->compareUser($user, get_userdata($user->ID));
            $this->compareUser($user, get_user_by('slug', $user->user_nicename));
        }

        $badId = (int)(max($ids) + 1);
        static::assertFalse(get_userdata($badId));
    }

    public function testFixedData()
    {
        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);
        $user = $factory(
            [
                'id' => 123,
                'login' => 'itsme',
                'email' => 'me@example.com',
                'password' => 's3cr3t',
            ]
        );

        static::assertSame(123, $user->ID);
        static::assertSame('itsme', $user->user_login);
        static::assertSame('me@example.com', $user->user_email);
        static::assertSame('s3cr3t', $user->user_pass);
    }

    public function testFixedRole()
    {
        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);
        $user = $factory(['role' => 'editor']);

        static::assertSame(['editor'], $user->roles);
        static::assertTrue($user->caps['editor']);
        static::assertSame(7, $user->user_level);
        static::assertTrue($user->allcaps['level_7']);
        static::assertTrue($user->allcaps['level_6']);
        static::assertTrue($user->allcaps['level_5']);
        static::assertTrue($user->allcaps['level_4']);
        static::assertTrue($user->allcaps['level_3']);
        static::assertTrue($user->allcaps['level_2']);
        static::assertTrue($user->allcaps['level_1']);
        static::assertTrue($user->allcaps['level_0']);
        static::assertTrue($user->allcaps['manage_categories']);

        static::assertTrue($user->has_cap('editor'));
        static::assertTrue($user->has_cap('level_7'));
        static::assertTrue($user->has_cap('level_6'));
        static::assertTrue($user->has_cap('level_5'));
        static::assertTrue($user->has_cap('level_4'));
        static::assertTrue($user->has_cap('level_3'));
        static::assertTrue($user->has_cap('level_2'));
        static::assertTrue($user->has_cap('level_1'));
        static::assertTrue($user->has_cap('level_0'));
        static::assertTrue($user->has_cap('manage_categories'));
        static::assertFalse($user->has_cap('level_8'));
        static::assertFalse($user->has_cap('level_9'));
        static::assertFalse($user->has_cap('level_10'));
        static::assertFalse($user->has_cap('administrator'));
        static::assertFalse($user->has_cap('switch_themes'));

        static::assertTrue(user_can($user, 'manage_categories'));
        static::assertTrue(user_can($user->ID, 'editor'));
        static::assertFalse(user_can($user, 'administrator'));
        static::assertFalse(user_can($user->ID, 'switch_themes'));
    }

    public function testRoleByLevel()
    {
        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);
        $user = $factory(['level' => 5]);

        static::assertSame(['author'], $user->roles);
        static::assertTrue($user->caps['author']);
        static::assertSame(5, $user->user_level);
        static::assertTrue($user->allcaps['level_5']);
        static::assertTrue($user->allcaps['level_4']);
        static::assertTrue($user->allcaps['level_3']);
        static::assertTrue($user->allcaps['level_2']);
        static::assertTrue($user->allcaps['level_1']);
        static::assertTrue($user->allcaps['level_0']);
        static::assertTrue($user->allcaps['upload_files']);

        static::assertTrue($user->has_cap('author'));
        static::assertTrue($user->has_cap('level_5'));
        static::assertTrue($user->has_cap('level_4'));
        static::assertTrue($user->has_cap('level_3'));
        static::assertTrue($user->has_cap('level_2'));
        static::assertTrue($user->has_cap('level_1'));
        static::assertTrue($user->has_cap('level_0'));
        static::assertTrue($user->has_cap('upload_files'));
        static::assertFalse($user->has_cap('level_6'));
        static::assertFalse($user->has_cap('level_7'));
        static::assertFalse($user->has_cap('level_8'));
        static::assertFalse($user->has_cap('level_9'));
        static::assertFalse($user->has_cap('level_10'));
        static::assertFalse($user->has_cap('editor'));
        static::assertFalse($user->has_cap('manage_categories'));

        static::assertTrue(user_can($user, 'upload_files'));
        static::assertTrue(user_can($user->ID, 'author'));
        static::assertTrue(user_can((string)$user->ID, 'level_5'));
        static::assertFalse(user_can($user, 'editor'));
        static::assertFalse(user_can($user->ID, 'manage_categories'));
    }

    public function testGetFailWithLowercaseId()
    {
        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);
        $user = $factory();

        $this->expectExceptionMessageRegExp('/WP_User::ID/');

        $user->get('id');
    }

    public function testMakeUserCurrent()
    {
        Monkey\Functions\expect('wp_safe_redirect')->once();

        /** @var Provider\User $factory */
        $factory = $this->factoryProvider(Provider\User::class);
        $factory(['id' => 123, 'first_name' => 'Jane', 'role' => 'author'])->__monkeyMakeCurrent();

        $this->expectOutputString('Jane rocks!');

        $rocks = static function (\WP_User $user) {
            if (array_intersect(['editor', 'author'], $user->roles)) {
                print "{$user->user_firstname} rocks!";
            }

            return $user;
        };

        if (get_current_user_id() === 123 && current_user_can('edit_published_posts')) {
            $user = $rocks(wp_get_current_user());
            if (filter_var($user->user_url, FILTER_VALIDATE_URL)) {
                wp_safe_redirect($user->user_url);
            }
        }
    }

    /**
     * @param \WP_User $left
     * @param \WP_User $right
     */
    private function compareUser($left, $right): void
    {
        static::assertInstanceOf(\WP_User::class, $left);
        static::assertInstanceOf(\WP_User::class, $right);
        static::assertSame($left->to_array(), $right->to_array());
        static::assertSame($left->allcaps, $right->allcaps);
        static::assertSame($left->caps, $right->caps);
        static::assertSame($left->roles, $right->roles);
    }
}