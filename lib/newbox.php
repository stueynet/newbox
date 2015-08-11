<?php

add_action('nav_menu_css_class', 'newbox_current_nav_class', 10, 2 );

function newbox_current_nav_class($classes, $item) {

	// Getting the current post details
	global $post;

	// Getting the post type of the current post
	$current_post_type = get_post_type_object(get_post_type($post->ID));
	$current_post_type_slug = $current_post_type->rewrite[slug];

	// Getting the URL of the menu item
	$menu_slug = strtolower(trim($item->url));

	// If the menu item URL contains the current post types slug add the current-menu-item class
	if (strpos($menu_slug,$current_post_type_slug) !== false) {

		$classes[] = 'active';

	}

	// Return the corrected set of classes to be added to the menu item
	return $classes;

}


add_filter( 'post_thumbnail_html', 'newbox_post_thumbnail_default', 10, 3 );

function newbox_post_thumbnail_default( $html, $post_id, $post_image_id ) {

	if($html == ''){
		$html = '<img data-src="holder.js/400x400/random/auto">';
	}

	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}


function newbox_post_thumbnail($id, $size = 'large'){
	if(!has_post_thumbnail($id))
		return 'holder.js/400x400/random/auto';

	$thumb_id = get_post_thumbnail_id($id);
	$thumb_url_array = wp_get_attachment_image_src($thumb_id, $size, true);
	$thumb_url = $thumb_url_array[0];
	return $thumb_url;
}


add_filter( 'mce_buttons_2', 'newbox_mce_editor_buttons' );
function newbox_mce_editor_buttons( $buttons ) {

	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

add_filter( 'tiny_mce_before_init', 'newbox_mce_before_init' );

function newbox_mce_before_init( $settings ) {

	$style_formats = array(
		array(
			'title' => 'Big (Lead) Text',
			'selector' => 'p',
			'classes' => 'lead'
		),
		array(
			'title' => 'Modal Image',
			'selector' => 'a',
			'classes' => 'imagepop'
		),
		array(
			'title' => 'Modal Video',
			'selector' => 'a',
			'classes' => 'videopop'
		)
	);

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;

	/*
	 * $style_formats = array(
        array(
            'title' => 'Download Link',
            'selector' => 'a',
            'classes' => 'download'
            ),
        array(
            'title' => 'My Test',
            'selector' => 'p',
            'classes' => 'mytest',
        ),
        array(
            'title' => 'AlertBox',
            'block' => 'div',
            'classes' => 'alert_box',
            'wrapper' => true
        ),
        array(
            'title' => 'Red Uppercase Text',
            'inline' => 'span',
            'styles' => array(
                'color'         => 'red', // or hex value #ff0000
                'fontWeight'    => 'bold',
                'textTransform' => 'uppercase'
            )
        )
	 */
}

function newbox_posts_per_page( $query ){
	if( !is_admin() && $query->is_main_query() ) {
		if(is_post_type_archive( 'people' ) || is_post_type_archive( 'project' ))
			$query->set( 'posts_per_page', '-1' );
	}
}
add_action( 'pre_get_posts', 'newbox_posts_per_page' );



// Next previous



function newbox_get_adjacent_id($id, $type = 'people', $prev = false, $full = false){
	// get_posts in same custom taxonomy
	$args = array(
		'posts_per_page'  => -1,
//		'orderby'         => 'date',
//		'order'           => 'DESC',
		'post_type'       => $type,
	);

	if($full){
		$full_array = array(
			'meta_key'		=> 'full',
			'meta_value'		=> '1'
		);

		$args = array_merge($args, $full_array);
	}

	$postlist = get_posts( $args );

// get ids of posts retrieved from get_posts
	$ids = array();
	foreach ($postlist as $thepost) {
		$ids[] = $thepost->ID;
	}

// get and echo previous and next post in the same taxonomy
	$thisindex = array_search($id, $ids);
	$previd = $ids[$thisindex-1];
	$nextid = $ids[$thisindex+1];
	if ( $prev ) {
		return $nextid;
	} else {
		return $previd;
	}
}

function newbox_post_nav($id){
	$post_type = get_post_type($id);
	$next_post = newbox_get_adjacent_id($id, $post_type, true, false);
	$previous_post = newbox_get_adjacent_id($id, $post_type, false, false);
	if (!empty( $previous_post )): ?>
		<a href="<?php echo get_the_permalink($previous_post); ?>" class="nextprev pull-left">
			<!--			<div class="inner">-->
			<!--				<i class="fa fa-arrow-left fa-2x"></i>-->
			<!--				<p><strong>-->
			Previous
			<!--				</strong> <br>--><?php //echo get_the_title($previous_post); ?><!--</p>-->
			<!--			</div>-->
		</a>
	<?php endif; ?>
	<?php if (!empty( $next_post )): ?>
		<a href="<?php echo get_the_permalink($next_post); ?>"class="nextprev pull-right">
			<!--			<div class="inner">-->
			<!--				<i class="fa fa-arrow-right fa-2x"></i>-->
			<!--				<p><strong>-->
			Next
			<!--					</strong><br>--><?php //echo get_the_title($next_post); ?><!--</p>-->
			<!---->
			<!--			</div>-->
		</a>
	<?php endif;
}



// get filtered content by ID
function the_content_by_id($content_id) {
	$page_data = get_page($content_id);
	if ( $page_data )
		return apply_filters('the_content',$page_data->post_content);
	return false;
}


function fb_add_query_vars_filter( $vars ){
	$vars[] = "submissionGuid";
	return $vars;
}
//add_filter( 'query_vars', 'fb_add_query_vars_filter' );



/**
 * A few helpers for this
 */

function newbox_category($id, $taxonomy = 'category', $column = 'name', $linked = false, $parent = 0){
	$terms = get_the_terms( $id, $taxonomy );

	if($terms){
		foreach($terms as $term){
			if($term->parent == $parent){
				if($linked){
					$html = '<a href="'.get_term_link($term->term_id, $taxonomy).'">'.$term->$column.'</a>';

				} else {
					$html = $term->$column;
				}
			}
		}
		return $html;
	}

	return '&nbsp';
}


function newbox_is_blog_related(){
	if(is_home() || is_singular('post') || is_category() || is_author()){
		return true;
	}
	return false;
}