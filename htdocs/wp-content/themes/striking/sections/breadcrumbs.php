<?php
/**
 * The default template for displaying breadcrumbs in the pages
 */
function theme_section_breadcrumbs($post_id = NULL){
	$output = '';
	
	if(function_exists('is_woocommerce') && is_woocommerce()){
		$disable = theme_is_enabled(theme_get_option('advanced','woocommerce_disable_breadcrumb'), theme_get_option('general','disable_breadcrumb'));

		if((!$post_id && !$disable) ||
			($post_id && !theme_is_enabled(get_post_meta($post_id, '_disable_breadcrumb', true), $disable)) 
		){
			if ( function_exists('yoast_breadcrumb') ) {
				$output = yoast_breadcrumb('<section id="breadcrumbs">','</section>',false);
			} else {
				ob_start();
				woocommerce_breadcrumb();
				$output .= ob_get_clean();
			}
			
		}
	} else if( (!$post_id && !theme_get_option('general','disable_breadcrumb')) ||
		($post_id && !theme_is_enabled(get_post_meta($post_id, '_disable_breadcrumb', true), theme_get_option('general','disable_breadcrumb'))) 
	){
		if ( function_exists('yoast_breadcrumb') ) {
			$output = yoast_breadcrumb('<section id="breadcrumbs">','</section>',false);
		} else {
			$output = breadcrumbs_plus(array(
				'prefix' => '<section id="breadcrumbs">',
				'suffix' => '</section>',
				'title' => false,
				'home' => __( 'Home', 'theme_front' ),
				'sep' => '&raquo;',
				'front_page' => false,
				'bold' => false,
				'blog' => __( 'Blog', 'theme_front' ),
				'echo' => false
			));
		}
	}
	return $output;
}