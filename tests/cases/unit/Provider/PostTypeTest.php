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

class PostTypeTest extends ProviderTestCase
{
    public function testNoPropertiesCreation()
    {
        $factory = $this->factoryProvider(Provider\PostType::class);
        $type = $factory();

        static::assertInstanceOf(\WP_Post_Type::class, $type);

        static::assertArrayHasKey($type->name, Provider\PostType::BUILT_IN);
        static::assertIsString($type->label);
        static::assertTrue((bool)$type->label);
        static::assertInstanceOf(\stdClass::class, $type->labels);
        static::assertIsString($type->labels->name);
        static::assertIsString($type->description);
        static::assertIsBool($type->public);
        static::assertIsBool($type->hierarchical);
        static::assertIsBool($type->exclude_from_search);
        static::assertIsBool($type->publicly_queryable);
        static::assertIsBool($type->show_ui);
        static::assertIsBool($type->show_in_menu);
        static::assertIsBool($type->show_in_nav_menus);
        static::assertIsBool($type->show_in_admin_bar);
        static::assertTrue(is_int($type->menu_position) || is_null($type->menu_position));
        static::assertNull($type->menu_icon);
        static::assertIsString($type->capability_type);
        static::assertIsBool($type->map_meta_cap);
        static::assertNull($type->register_meta_box_cb);
        static::assertIsArray($type->taxonomies);
        static::assertIsBool($type->has_archive);
        static::assertTrue(is_bool($type->query_var) || is_string($type->query_var));
        static::assertIsBool($type->can_export);
        static::assertTrue(is_bool($type->delete_with_user) || is_null($type->delete_with_user));
        static::assertIsString($type->_edit_link);
        static::assertInstanceOf(\stdClass::class, $type->cap);
        static::assertTrue(is_array($type->rewrite) || ($type->rewrite === false));
        static::assertIsBool($type->show_in_rest);
        static::assertTrue(is_string($type->rest_base) || is_bool($type->rest_base));
        static::assertTrue(is_string($type->rest_controller_class) || is_bool($type->rest_controller_class));

        static::assertTrue($type->_builtin);

        static::assertSame($type, get_post_type_object($type->name));
        static::assertTrue(post_type_exists($type->name));
    }

    public function testWithBuiltInType()
    {
        $factory = $this->factoryProvider(Provider\PostType::class);
        $type = $factory(['name' => 'page']);

        static::assertSame('Pages', $type->label);
        static::assertSame('Page', $type->labels->singular_name);
        static::assertTrue($type->hierarchical);
        static::assertTrue($type->_builtin);
    }

    public function testWithNameAndHierarchical()
    {
        $factory = $this->factoryProvider(Provider\PostType::class);
        $type = $factory(['name' => 'foo', 'hierarchical' => true, 'labels' => ['name' => 'Foo']]);

        static::assertSame('Foo', $type->label);
        static::assertSame('Foo', $type->labels->name);
        static::assertSame('Page', $type->labels->singular_name);
        static::assertTrue($type->hierarchical);
        static::assertFalse($type->_builtin);
    }

    public function testWithNameAndLabel()
    {
        $factory = $this->factoryProvider(Provider\PostType::class);
        $type = $factory(['name' => 'bar', 'label' => 'Bar']);

        static::assertSame('Bar', $type->label);
        static::assertSame('Bar', $type->labels->name);
        static::assertSame('Post', $type->labels->singular_name);
        static::assertFalse($type->hierarchical);
        static::assertFalse($type->_builtin);
    }

    public function testWithNameAndLabelAndCap()
    {
        $factory = $this->factoryProvider(Provider\PostType::class);
        $type = $factory(
            [
                'name' => 'product',
                'label' => 'Product',
                'cap' => ['edit_post' => 'edit_product'],
            ]
        );

        static::assertSame('Product', $type->label);
        static::assertSame('Product', $type->labels->name);
        static::assertSame('Post', $type->labels->singular_name);
        static::assertSame('edit_product', $type->cap->edit_post);
        static::assertSame('publish_posts', $type->cap->publish_posts);
        static::assertSame('edit_posts', $type->cap->create_posts);
        static::assertFalse($type->hierarchical);
        static::assertFalse($type->_builtin);
    }

    public function testWithPublic()
    {
        $factory = $this->factoryProvider(Provider\PostType::class);
        $type = $factory(['name' => 'product', 'label' => 'Product', 'public' => true]);

        static::assertSame('Product', $type->label);
        static::assertSame('Product', $type->labels->name);
        static::assertFalse($type->exclude_from_search);
        static::assertTrue($type->show_in_admin_bar);
        static::assertTrue($type->show_in_menu);
        static::assertTrue($type->show_in_nav_menus);
        static::assertTrue($type->show_in_rest);
        static::assertTrue($type->show_ui);
        static::assertFalse($type->_builtin);
    }
}