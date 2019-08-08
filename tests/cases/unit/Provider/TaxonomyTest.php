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

class TaxonomyTest extends ProviderTestCase
{
    public function testNoPropertiesCreation()
    {
        /** @var Provider\Taxonomy $factory */
        $factory = $this->factoryProvider(Provider\Taxonomy::class);
        $taxonomy = $factory();

        static::assertInstanceOf(\WP_Taxonomy::class, $taxonomy);

        static::assertArrayHasKey($taxonomy->name, Provider\Taxonomy::BUILT_IN);
        static::assertIsString($taxonomy->label);
        static::assertInstanceOf(\stdClass::class, $taxonomy->labels);
        static::assertIsString($taxonomy->labels->name);
        static::assertIsString($taxonomy->description);
        static::assertIsBool($taxonomy->public);
        static::assertIsBool($taxonomy->publicly_queryable);
        static::assertIsBool($taxonomy->hierarchical);
        static::assertIsBool($taxonomy->show_ui);
        static::assertIsBool($taxonomy->show_in_menu);
        static::assertIsBool($taxonomy->show_in_nav_menus);
        static::assertIsBool($taxonomy->show_tagcloud);
        static::assertIsBool($taxonomy->show_in_quick_edit);
        static::assertIsBool($taxonomy->show_in_quick_edit);
        static::assertIsBool($taxonomy->show_admin_column);
        static::assertIsBool($taxonomy->show_in_rest);
        static::assertIsArray($taxonomy->object_type);
        static::assertInstanceOf(\stdClass::class, $taxonomy->cap);
        static::assertIsString($taxonomy->cap->manage_terms);
        static::assertTrue(is_array($taxonomy->rewrite) || $taxonomy->rewrite === false);
        static::assertTrue(is_string($taxonomy->query_var) || $taxonomy->query_var === false);
        static::assertTrue(is_string($taxonomy->rest_base) || is_bool($taxonomy->rest_base));

        $controller = $taxonomy->rest_controller_class;
        static::assertTrue(is_string($controller) || is_bool($controller));

        $cb = $taxonomy->meta_box_cb;
        $cb_esc = $taxonomy->meta_box_sanitize_cb;
        $cb_upd = $taxonomy->update_count_callback;
        static::assertTrue(is_null($cb) || is_bool($cb) || is_callable($cb, true));
        static::assertTrue(is_null($cb_esc) || is_callable($cb_esc, true));
        static::assertTrue(is_null($cb_upd) || is_callable($cb_upd, true));

        static::assertTrue($taxonomy->_builtin);

        static::assertInstanceOf(\WP_Taxonomy::class, get_taxonomy($taxonomy->name) );
        static::assertSame($taxonomy->name, get_taxonomy($taxonomy->name)->name);
        static::assertEquals($taxonomy->labels, get_taxonomy($taxonomy->name)->labels);
        static::assertEquals($taxonomy->cap, get_taxonomy($taxonomy->name)->cap);
        static::assertSame($taxonomy->rewrite, get_taxonomy($taxonomy->name)->rewrite);
        static::assertTrue(taxonomy_exists($taxonomy->name));
    }

    public function testWithBuiltInType()
    {
        $factory = $this->factoryProvider(Provider\Taxonomy::class);
        $type = $factory(['name' => 'category']);

        static::assertSame('Categories', $type->label);
        static::assertSame('Category', $type->labels->singular_name);
        static::assertTrue($type->hierarchical);
        static::assertTrue($type->_builtin);
    }

    public function testWithNameAndHierarchical()
    {
        $factory = $this->factoryProvider(Provider\Taxonomy::class);
        $tax = $factory(['name' => 'foo', 'hierarchical' => true, 'labels' => ['name' => 'Foo']]);

        static::assertSame('Foo', $tax->label);
        static::assertSame('Foo', $tax->labels->name);
        static::assertSame('Category', $tax->labels->singular_name);
        static::assertTrue($tax->hierarchical);
        static::assertFalse($tax->_builtin);
    }

    public function testWithNameAndLabel()
    {
        $factory = $this->factoryProvider(Provider\Taxonomy::class);
        $type = $factory(['name' => 'bar', 'label' => 'Bar']);

        static::assertSame('Bar', $type->label);
        static::assertSame('Bar', $type->labels->name);
        static::assertSame('Tag', $type->labels->singular_name);
        static::assertFalse($type->hierarchical);
        static::assertFalse($type->_builtin);
    }

    public function testWithNameAndLabelAndCap()
    {
        $factory = $this->factoryProvider(Provider\Taxonomy::class);
        $type = $factory(
            [
                'name' => 'product',
                'label' => 'Product',
                'cap' => ['manage_terms' => 'manage_products'],
            ]
        );

        static::assertSame('Product', $type->label);
        static::assertSame('Product', $type->labels->name);
        static::assertSame('Tag', $type->labels->singular_name);
        static::assertSame('manage_products', $type->cap->manage_terms);
        static::assertSame('assign_post_tags', $type->cap->assign_terms);
        static::assertFalse($type->hierarchical);
        static::assertFalse($type->_builtin);
    }

    public function testWithPublic()
    {
        /** @var Provider\Taxonomy $factory */
        $factory = $this->factoryProvider(Provider\Taxonomy::class);
        $tax = $factory(['name' => 'product', 'label' => 'Product', 'public' => true]);

        static::assertSame('Product', $tax->label);
        static::assertSame('Product', $tax->labels->name);
        static::assertTrue($tax->public);
        static::assertTrue($tax->publicly_queryable);
        static::assertTrue($tax->show_in_menu);
        static::assertTrue($tax->show_in_nav_menus);
        static::assertTrue($tax->show_in_rest);
        static::assertTrue($tax->show_ui);
        static::assertFalse($tax->_builtin);
    }

    public function testFunctionWithMultipleObjects()
    {
        /** @var Provider\Taxonomy $factory */
        $factory = $this->factoryProvider(Provider\Taxonomy::class);

        $taxonomies = [];
        for ($i = 0; $i < 50; $i++) {
            $taxonomies[] = $factory();
        }

        /** @var \WP_Taxonomy $taxonomy */
        foreach ($taxonomies as $taxonomy) {
            /** @var \WP_Taxonomy $compare */
            $compare = get_taxonomy($taxonomy->name);
            static::assertInstanceOf(\WP_Taxonomy::class, $compare);
            static::assertSame($taxonomy->name, $compare->name);
            static::assertSame($taxonomy->label, $compare->label);
            static::assertSame($taxonomy->rewrite, $compare->rewrite);
            static::assertSame($taxonomy->description, $compare->description);
            static::assertEquals($taxonomy->labels, $compare->labels);
            static::assertEquals($taxonomy->cap, $compare->cap);
        }
    }

    public function testUnicityUpToPossible()
    {
        /** @var Provider\Taxonomy $factory */
        $factory = $this->factoryProvider(Provider\Taxonomy::class);

        $names = [];
        for ($i = 0; $i < count(Provider\Taxonomy::BUILT_IN); $i++) {
            $names[] = $factory()->name;
        }

        static::assertSame($names, array_unique($names));
    }
}