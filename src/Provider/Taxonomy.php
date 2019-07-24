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

namespace Brain\Faker\Provider;

use Brain\Monkey;

class Taxonomy extends Provider
{
    public const BUILT_IN = [
        'category' => [
            'name' => 'category',
            'label' => 'Categories',
            'labels' => [
                'name' => 'Categories',
                'singular_name' => 'Category',
                'search_items' => 'Search Categories',
                'popular_items' => null,
                'all_items' => 'All Categories',
                'parent_item' => 'Parent Category',
                'parent_item_colon' => 'Parent Category:',
                'edit_item' => 'Edit Category',
                'view_item' => 'View Category',
                'update_item' => 'Update Category',
                'add_new_item' => 'Add New Category',
                'new_item_name' => 'New Category Name',
                'separate_items_with_commas' => null,
                'add_or_remove_items' => null,
                'choose_from_most_used' => null,
                'not_found' => 'No categories found.',
                'no_terms' => 'No categories',
                'items_list_navigation' => 'Categories list navigation',
                'items_list' => 'Categories list',
                'most_used' => 'Most Used',
                'back_to_items' => '← Back to Categories',
                'menu_name' => 'Categories',
                'name_admin_bar' => 'category',
            ],
            'description' => '',
            'public' => true,
            'publicly_queryable' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_quick_edit' => true,
            'show_admin_column' => true,
            'meta_box_cb' => 'post_categories_meta_box',
            'meta_box_sanitize_cb' => 'taxonomy_meta_box_sanitize_cb_checkboxes',
            'object_type' => ['post'],
            'cap' => [
                'manage_terms' => 'manage_categories',
                'edit_terms' => 'edit_categories',
                'delete_terms' => 'delete_categories',
                'assign_terms' => 'assign_categories',
            ],
            'rewrite' => [
                'with_front' => true,
                'hierarchical' => true,
                'ep_mask' => 512,
                'slug' => 'category',
            ],
            'query_var' => 'category_name',
            'update_count_callback' => '',
            'show_in_rest' => true,
            'rest_base' => 'categories',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            '_builtin' => true,
        ],
        'post_tag' => [
            'name' => 'post_tag',
            'label' => 'Tags',
            'labels' => [
                'name' => 'Tags',
                'singular_name' => 'Tag',
                'search_items' => 'Search Tags',
                'popular_items' => 'Popular Tags',
                'all_items' => 'All Tags',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit Tag',
                'view_item' => 'View Tag',
                'update_item' => 'Update Tag',
                'add_new_item' => 'Add New Tag',
                'new_item_name' => 'New Tag Name',
                'separate_items_with_commas' => 'Separate tags with commas',
                'add_or_remove_items' => 'Add or remove tags',
                'choose_from_most_used' => 'Choose from the most used tags',
                'not_found' => 'No tags found.',
                'no_terms' => 'No tags',
                'items_list_navigation' => 'Tags list navigation',
                'items_list' => 'Tags list',
                'most_used' => 'Most Used',
                'back_to_items' => '← Back to Tags',
                'menu_name' => 'Tags',
                'name_admin_bar' => 'post_tag',
            ],
            'description' => '',
            'public' => true,
            'publicly_queryable' => true,
            'hierarchical' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_quick_edit' => true,
            'show_admin_column' => true,
            'meta_box_cb' => 'post_tags_meta_box',
            'meta_box_sanitize_cb' => 'taxonomy_meta_box_sanitize_cb_input',
            'object_type' => ['post'],
            'cap' => [
                'manage_terms' => 'manage_post_tags',
                'edit_terms' => 'edit_post_tags',
                'delete_terms' => 'delete_post_tags',
                'assign_terms' => 'assign_post_tags',
            ],
            'rewrite' =>
                [
                    'with_front' => true,
                    'hierarchical' => false,
                    'ep_mask' => 1024,
                    'slug' => 'tag',
                ],
            'query_var' => 'tag',
            'update_count_callback' => '',
            'show_in_rest' => true,
            'rest_base' => 'tags',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            '_builtin' => true,
        ],
        'nav_menu' => [
            'name' => 'nav_menu',
            'label' => 'Navigation Menus',
            'labels' => [
                'name' => 'Navigation Menus',
                'singular_name' => 'Navigation Menu',
                'search_items' => 'Search Tags',
                'popular_items' => 'Popular Tags',
                'all_items' => 'Navigation Menus',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit Tag',
                'view_item' => 'View Tag',
                'update_item' => 'Update Tag',
                'add_new_item' => 'Add New Tag',
                'new_item_name' => 'New Tag Name',
                'separate_items_with_commas' => 'Separate tags with commas',
                'add_or_remove_items' => 'Add or remove tags',
                'choose_from_most_used' => 'Choose from the most used tags',
                'not_found' => 'No tags found.',
                'no_terms' => 'No tags',
                'items_list_navigation' => 'Tags list navigation',
                'items_list' => 'Tags list',
                'most_used' => 'Most Used',
                'back_to_items' => '← Back to Tags',
                'menu_name' => 'Navigation Menus',
                'name_admin_bar' => 'Navigation Menu',
                'archives' => 'Navigation Menus',
            ],
            'description' => '',
            'public' => false,
            'publicly_queryable' => false,
            'hierarchical' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'show_in_quick_edit' => false,
            'show_admin_column' => false,
            'meta_box_cb' => 'post_tags_meta_box',
            'meta_box_sanitize_cb' => 'taxonomy_meta_box_sanitize_cb_input',
            'object_type' => ['nav_menu_item',],
            'cap' => [
                'manage_terms' => 'manage_categories',
                'edit_terms' => 'manage_categories',
                'delete_terms' => 'manage_categories',
                'assign_terms' => 'edit_posts',
            ],
            'rewrite' => false,
            'query_var' => false,
            'update_count_callback' => '',
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
            '_builtin' => true,
        ],
        'link_category' => [
            'name' => 'link_category',
            'label' => 'Link Categories',
            'labels' => [
                'name' => 'Link Categories',
                'singular_name' => 'Link Category',
                'search_items' => 'Search Link Categories',
                'popular_items' => null,
                'all_items' => 'All Link Categories',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit Link Category',
                'view_item' => 'View Tag',
                'update_item' => 'Update Link Category',
                'add_new_item' => 'Add New Link Category',
                'new_item_name' => 'New Link Category Name',
                'separate_items_with_commas' => null,
                'add_or_remove_items' => null,
                'choose_from_most_used' => null,
                'not_found' => 'No tags found.',
                'no_terms' => 'No tags',
                'items_list_navigation' => 'Tags list navigation',
                'items_list' => 'Tags list',
                'most_used' => 'Most Used',
                'back_to_items' => '← Back to Link Categories',
                'menu_name' => 'Link Categories',
                'name_admin_bar' => 'Link Category',
                'archives' => 'All Link Categories',
            ],
            'description' => '',
            'public' => false,
            'publicly_queryable' => false,
            'hierarchical' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => true,
            'show_in_quick_edit' => true,
            'show_admin_column' => false,
            'meta_box_cb' => 'post_tags_meta_box',
            'meta_box_sanitize_cb' => 'taxonomy_meta_box_sanitize_cb_input',
            'object_type' => ['link',],
            'cap' => [
                'manage_terms' => 'manage_links',
                'edit_terms' => 'manage_links',
                'delete_terms' => 'manage_links',
                'assign_terms' => 'manage_links',
            ],
            'rewrite' => false,
            'query_var' => false,
            'update_count_callback' => '',
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
            '_builtin' => true,
        ],
        'post_format' => [
            'name' => 'post_format',
            'label' => 'Formats',
            'labels' => [
                'name' => 'Formats',
                'singular_name' => 'Format',
                'search_items' => 'Search Tags',
                'popular_items' => 'Popular Tags',
                'all_items' => 'Formats',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit Tag',
                'view_item' => 'View Tag',
                'update_item' => 'Update Tag',
                'add_new_item' => 'Add New Tag',
                'new_item_name' => 'New Tag Name',
                'separate_items_with_commas' => 'Separate tags with commas',
                'add_or_remove_items' => 'Add or remove tags',
                'choose_from_most_used' => 'Choose from the most used tags',
                'not_found' => 'No tags found.',
                'no_terms' => 'No tags',
                'items_list_navigation' => 'Tags list navigation',
                'items_list' => 'Tags list',
                'most_used' => 'Most Used',
                'back_to_items' => '← Back to Tags',
                'menu_name' => 'Formats',
                'name_admin_bar' => 'Format',
                'archives' => 'Formats',
            ],
            'description' => '',
            'public' => true,
            'publicly_queryable' => true,
            'hierarchical' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'show_in_quick_edit' => false,
            'show_admin_column' => false,
            'meta_box_cb' => 'post_tags_meta_box',
            'meta_box_sanitize_cb' => 'taxonomy_meta_box_sanitize_cb_input',
            'object_type' => ['post',],
            'cap' => [
                'manage_terms' => 'manage_categories',
                'edit_terms' => 'manage_categories',
                'delete_terms' => 'manage_categories',
                'assign_terms' => 'edit_posts',
            ],
            'rewrite' => [
                'with_front' => true,
                'hierarchical' => false,
                'ep_mask' => 0,
                'slug' => 'type',
            ],
            'query_var' => 'post_format',
            'update_count_callback' => '',
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
            '_builtin' => true,
        ],
    ];

    /**
     * @param array $properties
     * @return \WP_Taxonomy|\Mockery\MockInterface
     */
    public function __invoke(array $properties = []): \WP_Taxonomy
    {
        $properties = array_change_key_case($properties, CASE_LOWER);
        $customName = array_key_exists('name', $properties) ? $properties['name'] : null;
        $randomName = array_rand(self::BUILT_IN);
        $public = array_key_exists('public', $properties)
            ? (bool)filter_var($properties['public'], FILTER_VALIDATE_BOOLEAN)
            : null;

        $name = (string)($customName ?? $randomName);
        $builtIn = array_key_exists($name, self::BUILT_IN);
        $baseName = $builtIn ? $name : $randomName;

        if (!$builtIn && ($customName || (is_bool($public) && $public))) {
            $hierarchical = !empty($properties['hierarchical']);
            $baseName = $hierarchical ? 'category' : 'post_tag';
        }

        $defaults = $builtIn ? self::BUILT_IN[$name] : self::BUILT_IN[$baseName];
        $properties['_builtin'] = $builtIn;

        $taxonomy = $this->createTaxonomy($defaults, $properties, $name, $public);

        Monkey\Functions\expect('get_taxonomy')
            ->zeroOrMoreTimes()
            ->with($taxonomy->name)
            ->andReturn($taxonomy);

        Monkey\Functions\expect('taxonomy_exists')
            ->zeroOrMoreTimes()
            ->with($taxonomy->name)
            ->andReturn(true);

        return $taxonomy;
    }

    /**
     * @param array $defaults
     * @param array $properties
     * @param string $name
     * @param bool|null $public
     * @return \WP_Taxonomy
     */
    private function createTaxonomy(
        array $defaults,
        array $properties,
        string $name,
        ?bool $public
    ): \WP_Taxonomy {

        $showUi = $properties['show_ui'] ?? $public;

        $publicKeys = [
            'publicly_queryable',
            'show_in_rest',
        ];

        $uiKeys = [
            'show_ui',
            'show_in_menu',
            'show_in_nav_menus',
            'show_tagcloud',
            'show_in_quick_edit',
            'show_in_rest',
        ];

        $taxonomy = \Mockery::mock(\WP_Taxonomy::class);

        foreach ($defaults as $key => $value) {
            $custom = array_key_exists($key, $properties);
            $field = $custom ? $properties[$key] : $value;
            if (!$custom && is_bool($public) && in_array($key, $publicKeys, true)) {
                $field = $public;
            }

            if (!$custom && is_bool($showUi) && in_array($key, $uiKeys, true)) {
                $field = $showUi;
            }

            if (!in_array($key, ['labels', 'cap'], true)) {
                $taxonomy->{$key} = $field;
            }
        }

        $labels = (array)($properties['labels'] ?? $defaults['labels'] ?? []);
        $caps = (array)($properties['cap'] ?? $defaults['cap'] ?? []);
        $buildIn = array_key_exists($name, self::BUILT_IN);

        $baseType = $taxonomy->hierarchical ? 'category' : 'post_tag';
        $baseData = $buildIn ? self::BUILT_IN[$name] : self::BUILT_IN[$baseType];

        $taxonomy->labels = (object)array_merge($baseData['labels'], $labels);
        $taxonomy->cap = (object)array_merge($baseData['cap'], $caps);

        if (empty($properties['label']) && !empty($properties['labels']['name'])) {
            $taxonomy->label = $taxonomy->labels->name;
        }

        if (empty($properties['labels']['name']) && !empty($properties['label'])) {
            $taxonomy->labels->name = $taxonomy->label;
        }

        return $taxonomy;
    }
}