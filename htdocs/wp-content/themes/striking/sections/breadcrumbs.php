<?php
/**
 * The default template for displaying breadcrumbs in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_breadcrumbs($post_id = NULL){
	$output = '';
	if( (!$post_id && !theme_get_option('general','disable_breadcrumb')) ||
		($post_id && !theme_is_enabled(get_post_meta($post_id, '_disable_breadcrumb', true), theme_get_option('general','disable_breadcrumb')))
	){
		$output = breadcrumbs_plus(array(
			'prefix' => '<section id="breadcrumbs">',
			'suffix' => '</section>',
			'title' => false,
			'home' => __( 'Home', 'striking_front' ),
			'sep' => '&raquo;',
			'front_page' => false,
			'bold' => false,
			'blog' => __( 'Blog', 'striking_front' ),
			'echo' => false
		));
	}
	return $output;
}