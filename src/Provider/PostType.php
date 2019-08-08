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

class PostType extends FunctionMockerProvider
{
    public const BUILT_IN = [
        'post' => [
            'name' => 'post',
            'label' => 'Posts',
            'labels' => [
                'name' => 'Posts',
                'singular_name' => 'Post',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Post',
                'edit_item' => 'Edit Post',
                'new_item' => 'New Post',
                'view_item' => 'View Post',
                'view_items' => 'View Posts',
                'search_items' => 'Search Posts',
                'not_found' => 'No posts found.',
                'not_found_in_trash' => 'No posts found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'All Posts',
                'archives' => 'Post Archives',
                'attributes' => 'Post Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter posts list',
                'items_list_navigation' => 'Posts list navigation',
                'items_list' => 'Posts list',
                'item_published' => 'Post published.',
                'item_published_privately' => 'Post published privately.',
                'item_reverted_to_draft' => 'Post reverted to draft.',
                'item_scheduled' => 'Post scheduled.',
                'item_updated' => 'Post updated.',
                'menu_name' => 'Posts',
                'name_admin_bar' => 'Post',
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'menu_icon' => null,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => true,
            'delete_with_user' => true,
            '_builtin' => true,
            '_edit_link' => 'post.php?post=%d',
            'cap' => [
                'edit_post' => 'edit_post',
                'read_post' => 'read_post',
                'delete_post' => 'delete_post',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_others_posts',
                'publish_posts' => 'publish_posts',
                'read_private_posts' => 'read_private_posts',
                'read' => 'read',
                'delete_posts' => 'delete_posts',
                'delete_private_posts' => 'delete_private_posts',
                'delete_published_posts' => 'delete_published_posts',
                'delete_others_posts' => 'delete_others_posts',
                'edit_private_posts' => 'edit_private_posts',
                'edit_published_posts' => 'edit_published_posts',
                'create_posts' => 'edit_posts',
            ],
            'rewrite' => false,
            'show_in_rest' => true,
            'rest_base' => 'posts',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        ],
        'page' => [
            'name' => 'page',
            'label' => 'Pages',
            'labels' => [
                'name' => 'Pages',
                'singular_name' => 'Page',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Page',
                'edit_item' => 'Edit Page',
                'new_item' => 'New Page',
                'view_item' => 'View Page',
                'view_items' => 'View Pages',
                'search_items' => 'Search Pages',
                'not_found' => 'No pages found.',
                'not_found_in_trash' => 'No pages found in Trash.',
                'parent_item_colon' => 'Parent Page:',
                'all_items' => 'All Pages',
                'archives' => 'Page Archives',
                'attributes' => 'Page Attributes',
                'insert_into_item' => 'Insert into page',
                'uploaded_to_this_item' => 'Uploaded to this page',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter pages list',
                'items_list_navigation' => 'Pages list navigation',
                'items_list' => 'Pages list',
                'item_published' => 'Page published.',
                'item_published_privately' => 'Page published privately.',
                'item_reverted_to_draft' => 'Page reverted to draft.',
                'item_scheduled' => 'Page scheduled.',
                'item_updated' => 'Page updated.',
                'menu_name' => 'Pages',
                'name_admin_bar' => 'Page',
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 20,
            'menu_icon' => null,
            'capability_type' => 'page',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => true,
            'delete_with_user' => true,
            '_builtin' => true,
            '_edit_link' => 'post.php?post=%d',
            'cap' => [
                'edit_post' => 'edit_page',
                'read_post' => 'read_page',
                'delete_post' => 'delete_page',
                'edit_posts' => 'edit_pages',
                'edit_others_posts' => 'edit_others_pages',
                'publish_posts' => 'publish_pages',
                'read_private_posts' => 'read_private_pages',
                'read' => 'read',
                'delete_posts' => 'delete_pages',
                'delete_private_posts' => 'delete_private_pages',
                'delete_published_posts' => 'delete_published_pages',
                'delete_others_posts' => 'delete_others_pages',
                'edit_private_posts' => 'edit_private_pages',
                'edit_published_posts' => 'edit_published_pages',
                'create_posts' => 'edit_pages',
            ],
            'rewrite' => false,
            'show_in_rest' => true,
            'rest_base' => 'pages',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        ],
        'attachment' => [
            'name' => 'attachment',
            'label' => 'Media',
            'labels' => [
                'name' => 'Media',
                'singular_name' => 'Media',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Post',
                'edit_item' => 'Edit Media',
                'new_item' => 'New Post',
                'view_item' => 'View Attachment Page',
                'view_items' => 'View Posts',
                'search_items' => 'Search Posts',
                'not_found' => 'No posts found.',
                'not_found_in_trash' => 'No posts found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'Media',
                'archives' => 'Media',
                'attributes' => 'Attachment Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter posts list',
                'items_list_navigation' => 'Posts list navigation',
                'items_list' => 'Posts list',
                'item_published' => 'Post published.',
                'item_published_privately' => 'Post published privately.',
                'item_reverted_to_draft' => 'Post reverted to draft.',
                'item_scheduled' => 'Post scheduled.',
                'item_updated' => 'Post updated.',
                'menu_name' => 'Media',
                'name_admin_bar' => 'Media',
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => true,
            'menu_position' => null,
            'menu_icon' => null,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => true,
            'delete_with_user' => true,
            '_builtin' => true,
            '_edit_link' => 'post.php?post=%d',
            'cap' => [
                'edit_post' => 'edit_post',
                'read_post' => 'read_post',
                'delete_post' => 'delete_post',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_others_posts',
                'publish_posts' => 'publish_posts',
                'read_private_posts' => 'read_private_posts',
                'read' => 'read',
                'delete_posts' => 'delete_posts',
                'delete_private_posts' => 'delete_private_posts',
                'delete_published_posts' => 'delete_published_posts',
                'delete_others_posts' => 'delete_others_posts',
                'edit_private_posts' => 'edit_private_posts',
                'edit_published_posts' => 'edit_published_posts',
                'create_posts' => 'upload_files',
            ],
            'rewrite' => false,
            'show_in_rest' => true,
            'rest_base' => 'media',
            'rest_controller_class' => 'WP_REST_Attachments_Controller',
        ],
        'revision' => [
            'name' => 'revision',
            'label' => 'Revisions',
            'labels' => [
                'name' => 'Revisions',
                'singular_name' => 'Revision',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Post',
                'edit_item' => 'Edit Post',
                'new_item' => 'New Post',
                'view_item' => 'View Post',
                'view_items' => 'View Posts',
                'search_items' => 'Search Posts',
                'not_found' => 'No posts found.',
                'not_found_in_trash' => 'No posts found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'Revisions',
                'archives' => 'Revisions',
                'attributes' => 'Post Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter posts list',
                'items_list_navigation' => 'Posts list navigation',
                'items_list' => 'Posts list',
                'item_published' => 'Post published.',
                'item_published_privately' => 'Post published privately.',
                'item_reverted_to_draft' => 'Post reverted to draft.',
                'item_scheduled' => 'Post scheduled.',
                'item_updated' => 'Post updated.',
                'menu_name' => 'Revisions',
                'name_admin_bar' => 'Revision',
            ],
            'description' => '',
            'public' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'menu_position' => null,
            'menu_icon' => null,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => false,
            'delete_with_user' => true,
            '_builtin' => true,
            '_edit_link' => 'revision.php?revision=%d',
            'cap' => [
                'edit_post' => 'edit_post',
                'read_post' => 'read_post',
                'delete_post' => 'delete_post',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_others_posts',
                'publish_posts' => 'publish_posts',
                'read_private_posts' => 'read_private_posts',
                'read' => 'read',
                'delete_posts' => 'delete_posts',
                'delete_private_posts' => 'delete_private_posts',
                'delete_published_posts' => 'delete_published_posts',
                'delete_others_posts' => 'delete_others_posts',
                'edit_private_posts' => 'edit_private_posts',
                'edit_published_posts' => 'edit_published_posts',
                'create_posts' => 'edit_posts',
            ],
            'rewrite' => false,
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
        ],
        'nav_menu_item' => [
            'name' => 'nav_menu_item',
            'label' => 'Navigation Menu Items',
            'labels' => [
                'name' => 'Navigation Menu Items',
                'singular_name' => 'Navigation Menu Item',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Post',
                'edit_item' => 'Edit Post',
                'new_item' => 'New Post',
                'view_item' => 'View Post',
                'view_items' => 'View Posts',
                'search_items' => 'Search Posts',
                'not_found' => 'No posts found.',
                'not_found_in_trash' => 'No posts found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'Navigation Menu Items',
                'archives' => 'Navigation Menu Items',
                'attributes' => 'Post Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter posts list',
                'items_list_navigation' => 'Posts list navigation',
                'items_list' => 'Posts list',
                'item_published' => 'Post published.',
                'item_published_privately' => 'Post published privately.',
                'item_reverted_to_draft' => 'Post reverted to draft.',
                'item_scheduled' => 'Post scheduled.',
                'item_updated' => 'Post updated.',
                'menu_name' => 'Navigation Menu Items',
                'name_admin_bar' => 'Navigation Menu Item',
            ],
            'description' => '',
            'public' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'menu_position' => null,
            'menu_icon' => null,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => true,
            'delete_with_user' => false,
            '_builtin' => true,
            '_edit_link' => '',
            'cap' => [
                'edit_post' => 'edit_post',
                'read_post' => 'read_post',
                'delete_post' => 'delete_post',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_others_posts',
                'publish_posts' => 'publish_posts',
                'read_private_posts' => 'read_private_posts',
                'read' => 'read',
                'delete_posts' => 'delete_posts',
                'delete_private_posts' => 'delete_private_posts',
                'delete_published_posts' => 'delete_published_posts',
                'delete_others_posts' => 'delete_others_posts',
                'edit_private_posts' => 'edit_private_posts',
                'edit_published_posts' => 'edit_published_posts',
                'create_posts' => 'edit_posts',
            ],
            'rewrite' => false,
            'supports' => [],
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
        ],
        'custom_css' => [
            'name' => 'custom_css',
            'label' => 'Custom CSS',
            'labels' => [
                'name' => 'Custom CSS',
                'singular_name' => 'Custom CSS',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Post',
                'edit_item' => 'Edit Post',
                'new_item' => 'New Post',
                'view_item' => 'View Post',
                'view_items' => 'View Posts',
                'search_items' => 'Search Posts',
                'not_found' => 'No posts found.',
                'not_found_in_trash' => 'No posts found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'Custom CSS',
                'archives' => 'Custom CSS',
                'attributes' => 'Post Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter posts list',
                'items_list_navigation' => 'Posts list navigation',
                'items_list' => 'Posts list',
                'item_published' => 'Post published.',
                'item_published_privately' => 'Post published privately.',
                'item_reverted_to_draft' => 'Post reverted to draft.',
                'item_scheduled' => 'Post scheduled.',
                'item_updated' => 'Post updated.',
                'menu_name' => 'Custom CSS',
                'name_admin_bar' => 'Custom CSS',
            ],
            'description' => '',
            'public' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'menu_position' => null,
            'menu_icon' => null,
            'capability_type' => 'post',
            'map_meta_cap' => false,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => true,
            'delete_with_user' => false,
            '_builtin' => true,
            '_edit_link' => '',
            'cap' => [
                'edit_post' => 'edit_css',
                'read_post' => 'read',
                'delete_post' => 'edit_theme_options',
                'edit_posts' => 'edit_css',
                'edit_others_posts' => 'edit_css',
                'publish_posts' => 'edit_theme_options',
                'read_private_posts' => 'read',
                'delete_posts' => 'edit_theme_options',
                'delete_published_posts' => 'edit_theme_options',
                'delete_private_posts' => 'edit_theme_options',
                'delete_others_posts' => 'edit_theme_options',
                'edit_published_posts' => 'edit_css',
                'create_posts' => 'edit_css',
            ],
            'rewrite' => false,
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
        ],
        'customize_changeset' => [
            'name' => 'customize_changeset',
            'label' => 'Changesets',
            'labels' => [
                'name' => 'Changesets',
                'singular_name' => 'Changeset',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Changeset',
                'edit_item' => 'Edit Changeset',
                'new_item' => 'New Changeset',
                'view_item' => 'View Changeset',
                'view_items' => 'View Posts',
                'search_items' => 'Search Changesets',
                'not_found' => 'No changesets found.',
                'not_found_in_trash' => 'No changesets found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'All Changesets',
                'archives' => 'All Changesets',
                'attributes' => 'Post Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter posts list',
                'items_list_navigation' => 'Posts list navigation',
                'items_list' => 'Posts list',
                'item_published' => 'Post published.',
                'item_published_privately' => 'Post published privately.',
                'item_reverted_to_draft' => 'Post reverted to draft.',
                'item_scheduled' => 'Post scheduled.',
                'item_updated' => 'Post updated.',
                'menu_name' => 'Changesets',
                'name_admin_bar' => 'Changeset',
            ],
            'description' => '',
            'public' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'menu_position' => null,
            'menu_icon' => null,
            'capability_type' => 'customize_changeset',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => false,
            'delete_with_user' => false,
            '_builtin' => true,
            '_edit_link' => '',
            'cap' => [
                'edit_post' => 'customize',
                'read_post' => 'customize',
                'delete_post' => 'customize',
                'edit_posts' => 'customize',
                'edit_others_posts' => 'customize',
                'publish_posts' => 'customize',
                'read_private_posts' => 'customize',
                'read' => 'read',
                'delete_posts' => 'customize',
                'delete_private_posts' => 'customize',
                'delete_published_posts' => 'customize',
                'delete_others_posts' => 'customize',
                'edit_private_posts' => 'customize',
                'edit_published_posts' => 'do_not_allow',
                'create_posts' => 'customize',
            ],
            'rewrite' => false,
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
        ],
        'oembed_cache' => [
            'name' => 'oembed_cache',
            'label' => 'oEmbed Responses',
            'labels' => [
                'name' => 'oEmbed Responses',
                'singular_name' => 'oEmbed Response',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Post',
                'edit_item' => 'Edit Post',
                'new_item' => 'New Post',
                'view_item' => 'View Post',
                'view_items' => 'View Posts',
                'search_items' => 'Search Posts',
                'not_found' => 'No posts found.',
                'not_found_in_trash' => 'No posts found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'oEmbed Responses',
                'archives' => 'oEmbed Responses',
                'attributes' => 'Post Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter posts list',
                'items_list_navigation' => 'Posts list navigation',
                'items_list' => 'Posts list',
                'item_published' => 'Post published.',
                'item_published_privately' => 'Post published privately.',
                'item_reverted_to_draft' => 'Post reverted to draft.',
                'item_scheduled' => 'Post scheduled.',
                'item_updated' => 'Post updated.',
                'menu_name' => 'oEmbed Responses',
                'name_admin_bar' => 'oEmbed Response',
            ],
            'description' => '',
            'public' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'menu_position' => null,
            'menu_icon' => null,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => false,
            'delete_with_user' => false,
            '_builtin' => true,
            '_edit_link' => '',
            'cap' => [
                'edit_post' => 'edit_post',
                'read_post' => 'read_post',
                'delete_post' => 'delete_post',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_others_posts',
                'publish_posts' => 'publish_posts',
                'read_private_posts' => 'read_private_posts',
                'read' => 'read',
                'delete_posts' => 'delete_posts',
                'delete_private_posts' => 'delete_private_posts',
                'delete_published_posts' => 'delete_published_posts',
                'delete_others_posts' => 'delete_others_posts',
                'edit_private_posts' => 'edit_private_posts',
                'edit_published_posts' => 'edit_published_posts',
                'create_posts' => 'edit_posts',
            ],
            'rewrite' => false,
            'supports' => [],
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
        ],
        'user_request' => [
            'name' => 'user_request',
            'label' => 'User Requests',
            'labels' => [
                'name' => 'User Requests',
                'singular_name' => 'User Request',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Post',
                'edit_item' => 'Edit Post',
                'new_item' => 'New Post',
                'view_item' => 'View Post',
                'view_items' => 'View Posts',
                'search_items' => 'Search Posts',
                'not_found' => 'No posts found.',
                'not_found_in_trash' => 'No posts found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'User Requests',
                'archives' => 'User Requests',
                'attributes' => 'Post Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter posts list',
                'items_list_navigation' => 'Posts list navigation',
                'items_list' => 'Posts list',
                'item_published' => 'Post published.',
                'item_published_privately' => 'Post published privately.',
                'item_reverted_to_draft' => 'Post reverted to draft.',
                'item_scheduled' => 'Post scheduled.',
                'item_updated' => 'Post updated.',
                'menu_name' => 'User Requests',
                'name_admin_bar' => 'User Request',
            ],
            'description' => '',
            'public' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'menu_position' => null,
            'menu_icon' => null,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => false,
            'can_export' => false,
            'delete_with_user' => false,
            '_builtin' => true,
            '_edit_link' => '',
            'cap' => [
                'edit_post' => 'edit_post',
                'read_post' => 'read_post',
                'delete_post' => 'delete_post',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_others_posts',
                'publish_posts' => 'publish_posts',
                'read_private_posts' => 'read_private_posts',
                'read' => 'read',
                'delete_posts' => 'delete_posts',
                'delete_private_posts' => 'delete_private_posts',
                'delete_published_posts' => 'delete_published_posts',
                'delete_others_posts' => 'delete_others_posts',
                'edit_private_posts' => 'edit_private_posts',
                'edit_published_posts' => 'edit_published_posts',
                'create_posts' => 'edit_posts',
            ],
            'rewrite' => false,
            'supports' => [],
            'show_in_rest' => false,
            'rest_base' => false,
            'rest_controller_class' => false,
        ],
        'wp_block' => [
            'name' => 'wp_block',
            'label' => 'Blocks',
            'labels' => [
                'name' => 'Blocks',
                'singular_name' => 'Block',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Block',
                'edit_item' => 'Edit Block',
                'new_item' => 'New Block',
                'view_item' => 'View Block',
                'view_items' => 'View Posts',
                'search_items' => 'Search Blocks',
                'not_found' => 'No blocks found.',
                'not_found_in_trash' => 'No blocks found in Trash.',
                'parent_item_colon' => null,
                'all_items' => 'All Blocks',
                'archives' => 'All Blocks',
                'attributes' => 'Post Attributes',
                'insert_into_item' => 'Insert into post',
                'uploaded_to_this_item' => 'Uploaded to this post',
                'featured_image' => 'Featured Image',
                'set_featured_image' => 'Set featured image',
                'remove_featured_image' => 'Remove featured image',
                'use_featured_image' => 'Use as featured image',
                'filter_items_list' => 'Filter blocks list',
                'items_list_navigation' => 'Blocks list navigation',
                'items_list' => 'Blocks list',
                'item_published' => 'Block published.',
                'item_published_privately' => 'Block published privately.',
                'item_reverted_to_draft' => 'Block reverted to draft.',
                'item_scheduled' => 'Block scheduled.',
                'item_updated' => 'Block updated.',
                'menu_name' => 'Blocks',
                'name_admin_bar' => 'Block',
            ],
            'description' => '',
            'public' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'menu_position' => null,
            'menu_icon' => null,
            'capability_type' => 'block',
            'map_meta_cap' => true,
            'register_meta_box_cb' => null,
            'taxonomies' => [],
            'has_archive' => false,
            'query_var' => 'wp_block',
            'can_export' => true,
            'delete_with_user' => null,
            '_builtin' => true,
            '_edit_link' => 'post.php?post=%d',
            'cap' => [
                'edit_post' => 'edit_block',
                'read_post' => 'read_block',
                'delete_post' => 'delete_block',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_others_posts',
                'publish_posts' => 'publish_blocks',
                'read_private_posts' => 'read_private_blocks',
                'read' => 'edit_posts',
                'delete_posts' => 'delete_blocks',
                'delete_private_posts' => 'delete_private_blocks',
                'delete_published_posts' => 'delete_published_posts',
                'delete_others_posts' => 'delete_others_posts',
                'edit_private_posts' => 'edit_private_blocks',
                'edit_published_posts' => 'edit_published_posts',
                'create_posts' => 'publish_posts',
            ],
            'rewrite' => false,
            'show_in_rest' => true,
            'rest_base' => 'blocks',
            'rest_controller_class' => 'WP_REST_Blocks_Controller',
        ],
    ];

    /**
     * @var array[]
     */
    private $types = [];

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->types = [];
        parent::reset();
    }

    /**
     * @param array $properties
     * @return \WP_Post_Type
     */
    public function __invoke(array $properties = []): \WP_Post_Type
    {
        $properties = array_change_key_case($properties, CASE_LOWER);
        $customName = array_key_exists('name', $properties) ? $properties['name'] : null;
        $name = $customName;

        if ($name === null) {
            $buildInKeys = array_keys(self::BUILT_IN);
            $notDoneBuildIn = array_diff($buildInKeys, array_keys($this->types));
            $name = $this->generator->randomElement($notDoneBuildIn ?: $buildInKeys);
        }

        $public = array_key_exists('public', $properties)
            ? (bool)filter_var($properties['public'], FILTER_VALIDATE_BOOLEAN)
            : null;

        /** @var string $name */

        $loadedProperties = $this->maybeLoadProperties($name, $properties);
        if (is_array($loadedProperties)) {
            return $this->createType($loadedProperties, [], $name);
        }

        $builtIn = array_key_exists($name, self::BUILT_IN);
        $baseName = $builtIn ? $name : array_rand(self::BUILT_IN);

        if (!$builtIn && ($customName || (is_bool($public) && $public))) {
            $hierarchical = !empty($properties['hierarchical']);
            $baseName = $hierarchical ? 'page' : 'post';
        }

        $defaults = $builtIn ? self::BUILT_IN[$name] : self::BUILT_IN[$baseName];
        $properties['_builtin'] = $builtIn;

        $type = $this->createType($defaults, $properties, $name, $public);
        $this->mockFunctions();

        return $type;
    }

    /**
     * @param string $name
     * @param array $properties
     * @return array|null
     */
    private function maybeLoadProperties(string $name, array $properties) : ?array
    {
        if (!isset($this->types[$name])) {
            return null;
        }

        $diffKeys = ['labels' => '', 'cap' => '', 'name' => ''];

        $savedProperties = $this->types[$name];
        $savedScalars = array_diff_key($savedProperties, $diffKeys);
        $savedLabels = $savedProperties['labels'];
        $savedCaps = $savedProperties['cap'];

        $newScalars = $properties ? array_diff_key($properties, $diffKeys) : [];
        $newLabels = (array)($properties['labels'] ?? []);
        $newCaps = (array)($properties['cap'] ?? []);

        $savedScalars and ksort($savedScalars);
        $savedLabels and ksort($savedLabels);
        $savedCaps and ksort($savedCaps);

        $newScalars and ksort($newScalars);
        $newLabels and ksort($newLabels);
        $newCaps and ksort($newCaps);

        if (($newScalars && $newScalars !== $savedScalars)
            || ($newLabels && $newLabels !== $savedLabels)
            || ($newCaps && $newCaps !== $savedCaps)
        ) {
            throw new \Error("Post type {$name} was already faked with different properties.");
        }

        return $savedProperties;
    }

    /**
     * @param array $defaults
     * @param array $properties
     * @param string $name
     * @param bool|null $public
     * @return \WP_Post_Type
     */
    private function createType(
        array $defaults,
        array $properties,
        string $name,
        ?bool $public = null
    ): \WP_Post_Type {

        $type = \Mockery::mock(\WP_Post_Type::class);

        $publicKeys = [
            'publicly_queryable',
            'show_in_rest',
            'exclude_from_search',
        ];

        $showUi = $properties['show_ui'] ?? $public;

        $uiKeys = [
            'show_ui',
            'show_in_menu',
            'show_in_nav_menus',
            'show_in_admin_bar',
        ];

        $reloading = isset($this->types[$name]);
        $data = [];

        foreach ($defaults as $key => $value) {
            $custom = array_key_exists($key, $properties);
            $field = $custom ? $properties[$key] : $value;
            if (!$custom && is_bool($public) && in_array($key, $publicKeys, true)) {
                $field = $key === 'exclude_from_search' ? !$public : $public;
            }

            if (!$custom && is_bool($showUi) && in_array($key, $uiKeys, true)) {
                $field = $showUi;
            }

            if (!in_array($key, ['labels', 'cap'], true)) {
                $type->{$key} = $field;
                $reloading or $data[$key] = $field;
            }
        }

        $labels = (array)($properties['labels'] ?? $defaults['labels'] ?? []);
        $caps = (array)($properties['cap'] ?? $defaults['cap'] ?? []);
        $buildIn = array_key_exists($name, self::BUILT_IN);

        $baseType = $type->hierarchical ? 'page' : 'post';
        $baseData = $buildIn ? self::BUILT_IN[$name] : self::BUILT_IN[$baseType];

        $data['labels'] = array_merge($baseData['labels'], $labels);
        $type->labels = (object)$data['labels'];

        $data['cap'] = array_merge($baseData['cap'], $caps);
        $type->cap = (object)$data['cap'];

        if (empty($properties['label']) && !empty($properties['labels']['name'])) {
            $type->label = $type->labels->name;
            $reloading or $data['label'] = $type->label;
        }

        if (empty($properties['labels']['name']) && !empty($properties['label'])) {
            $type->labels->name = $type->label;
            $reloading or $data['labels']['name'] = $type->label;
        }

        $reloading or $this->types[$name] = $data;

        return $type;
    }

    /**
     * @retun void
     */
    private function mockFunctions(): void
    {
        if (!$this->canMockFunctions()) {
            return;
        }

        $this->functionExpectations->mock('get_post_type_object')
            ->zeroOrMoreTimes()
            ->andReturnUsing(
                function ($name) { // phpcs:ignore
                    if (!is_scalar($name) || !isset($this->types[$name])) {
                        return null;
                    }

                    return $this->__invoke($this->types[$name]);
                }
            );

        $this->functionExpectations->mock('post_type_exists')
            ->zeroOrMoreTimes()
            ->andReturnUsing(
                function ($name) { // phpcs:ignore
                    return is_scalar($name) && array_key_exists($name, $this->types);
                }
            );

        $this->stopMockingFunctions();
    }
}
