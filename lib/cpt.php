<?php

/**
 * Register Custom Post Types and Custom taxonomies.
 *
 * from Custom Post Type Generator Plugins.
 */

add_action( 'init', 'cptg_custom_post_types' );
function cptg_custom_post_types()
{
	$labels = array(
		'name' => 'Portfolio Items',
		'singular_name' => 'Portfolio Items',
		'menu_name' => 'Portfolio Items',
		'name_admin_bar' => 'Portfolio Items',
		'all_items' => 'All Posts',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Post',
		'edit_item' => 'Edit Post',
		'new_item' => 'New Post',
		'view_item' => 'View Post',
		'search_items' => 'Search Posts',
		'not_found' =>  'No posts found.',
		'not_found_in_trash' => 'No posts found in Trash.',
		'parent_item_colon' => 'Parent Page',
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'has_archive' => true,
		'menu_position' => null,
		'menu_icon' => null,
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'work', 'with_front' => true,'feeds' => false,'pages' => true ),
		'query_var' => true,
		'can_export' => true,
		'supports' => array( 'title','editor','thumbnail','excerpt','custom-fields' ),
	);
	register_post_type( 'portfolio_item', $args );
}

add_action( 'after_switch_theme', 'cptg_rewrite_flush' );
function cptg_rewrite_flush()
{
	flush_rewrite_rules();
}
