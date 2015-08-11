<?php

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Site Options',
        'menu_title'	=> 'Site Options',
        'menu_slug' 	=> 'fb-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> true
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'General Settings',
        'menu_title'	=> 'General Settings',
        'parent_slug'	=> 'fb-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Homepage Settings',
        'menu_title'	=> 'Homepage Settings',
        'parent_slug'	=> 'fb-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Footer Settings',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'fb-settings',
    ));

}
