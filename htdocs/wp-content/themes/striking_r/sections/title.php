<?php
/**
 * The default template for displaying title in the pages
 */
function theme_section_title(){
	global $page, $paged;
	if(defined('WPSEO_FILE')){
		return wp_title('',false);
	}

	$output =  wp_title( '|', false, 'right' );

	// Add the blog name.
	$output .=  get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( !empty($site_description) && is_front_page() )
		$output .=  " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$output .= ' | ' . sprintf( __( 'Page %s', 'theme_front' ), max( $paged, $page ) );

	return $output;
}