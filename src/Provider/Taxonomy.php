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

class Taxonomy extends FunctionMockerProvider
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
            'rewrite' => [
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
            'object_type' => ['nav_menu_item'],
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
            'object_type' => ['link'],
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
            'object_type' => ['post'],
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
     * @var array[]
     */
    private $taxonomies = [];

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->taxonomies = [];
        parent::reset();
    }

    /**
     * @param array $properties
     * @return \WP_Taxonomy|\Mockery\MockInterface
     */
    public function __invoke(array $properties = []): \WP_Taxonomy
    {
        $properties = array_change_key_case($properties, CASE_LOWER);
        $customName = array_key_exists('name', $properties) ? $properties['name'] : null;
        $name = $customName;

        if ($name === null) {
            $buildInKeys = array_keys(self::BUILT_IN);
            $notDoneBuildIn = array_diff($buildInKeys, array_keys($this->taxonomies));
            $name = $this->generator->randomElement($notDoneBuildIn ?: $buildInKeys);
        }

        $public = array_key_exists('public', $properties)
            ? (bool)filter_var($properties['public'], FILTER_VALIDATE_BOOLEAN)
            : null;

        /** @var string $name */

        $loadedProperties = $this->maybeLoadProperties($name, $properties);
        if (is_array($loadedProperties)) {
            return $this->createTaxonomy($loadedProperties, [], $name);
        }

        $builtIn = array_key_exists($name, self::BUILT_IN);
        $baseName = $builtIn ? $name : array_rand(self::BUILT_IN);

        if (!$builtIn && ($customName || (is_bool($public) && $public))) {
            $hierarchical = !empty($properties['hierarchical']);
            $baseName = $hierarchical ? 'category' : 'post_tag';
        }

        $defaults = $builtIn ? self::BUILT_IN[$name] : self::BUILT_IN[$baseName];
        $properties['_builtin'] = $builtIn;

        $taxonomy = $this->createTaxonomy($defaults, $properties, $name, $public);
        $this->mockFunctions();

        return $taxonomy;
    }

    /**
     * @param string $name
     * @param array $properties
     * @return array|null
     */
    private function maybeLoadProperties(string $name, array $properties): ?array
    {
        if (!isset($this->taxonomies[$name])) {
            return null;
        }

        $diffKeys = ['labels' => '', 'cap' => '', 'rewrite' => '', 'name' => ''];

        $savedProperties = $this->taxonomies[$name];
        $savedScalars = array_diff_key($savedProperties, $diffKeys);
        $savedLabels = $savedProperties['labels'] ?? [];
        $savedCaps = $savedProperties['cap'] ?? [];
        $savedRewrite = $savedProperties['rewrite'] ?? false;
        $savedRewrite and $savedRewrite = (array)$savedRewrite;

        $newScalars = $properties ? array_diff_key($properties, $diffKeys) : [];
        $newLabels = (array)($properties['labels'] ?? []);
        $newCaps = (array)($properties['cap'] ?? []);
        $newRewrite = $properties['rewrite'] ?? false;
        $newRewrite and $newRewrite = (array)$newRewrite;

        $savedScalars and ksort($savedScalars);
        $savedLabels and ksort($savedLabels);
        $savedCaps and ksort($savedCaps);
        $savedRewrite and ksort($savedRewrite);

        $newScalars and ksort($newScalars);
        $newLabels and ksort($newLabels);
        $newCaps and ksort($newCaps);
        $newRewrite and ksort($newRewrite);

        if (($newScalars && $newScalars !== $savedScalars)
            || ($newLabels && $newLabels !== $savedLabels)
            || ($newCaps && $newCaps !== $savedCaps)
            || ($newRewrite && $newRewrite !== $savedRewrite)
        ) {
            throw new \Error("Taxonomy {$name} was already faked with different properties.");
        }

        return $savedProperties;
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
        ?bool $public = null
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

        $reloading = isset($this->taxonomies[$name]);
        $data = [];

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
                $reloading or $data[$key] = $field;
            }
        }

        $labels = (array)($properties['labels'] ?? $defaults['labels'] ?? []);
        $caps = (array)($properties['cap'] ?? $defaults['cap'] ?? []);
        $buildIn = array_key_exists($name, self::BUILT_IN);

        $baseType = $taxonomy->hierarchical ? 'category' : 'post_tag';
        $baseData = $buildIn ? self::BUILT_IN[$name] : self::BUILT_IN[$baseType];

        $data['labels'] = array_merge($baseData['labels'], $labels);
        $taxonomy->labels = (object)$data['labels'];

        $data['cap'] = array_merge($baseData['cap'], $caps);
        $taxonomy->cap = (object)$data['cap'];

        if (empty($properties['label']) && !empty($properties['labels']['name'])) {
            $taxonomy->label = $taxonomy->labels->name;
            $reloading or $data['label'] = $taxonomy->labels->name;
        }

        if (empty($properties['labels']['name']) && !empty($properties['label'])) {
            $taxonomy->labels->name = $taxonomy->label;
            $reloading or $data['labels']['name'] = $taxonomy->label;
        }

        $reloading or $this->taxonomies[$name] = $data;

        return $taxonomy;
    }

    /**
     * @return void
     */
    private function mockFunctions(): void
    {
        if (!$this->canMockFunctions()) {
            return;
        }

        $this->functionExpectations->mock('get_taxonomy')
            ->zeroOrMoreTimes()
            ->andReturnUsing(
                function ($name) { // phpcs:ignore
                    if (!is_scalar($name) || !isset($this->taxonomies[$name])) {
                        return null;
                    }

                    return $this->__invoke($this->taxonomies[$name]);
                }
            );

        $this->functionExpectations->mock('taxonomy_exists')
            ->zeroOrMoreTimes()
            ->zeroOrMoreTimes()
            ->andReturnUsing(
                function ($name) { // phpcs:ignore
                    return is_scalar($name) && array_key_exists($name, $this->taxonomies);
                }
            );

        $this->stopMockingFunctions();
    }
}
