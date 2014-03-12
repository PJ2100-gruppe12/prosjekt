<?php
/**
 * The default template for displaying menu in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_menu(){
	if (theme_get_option('general','enable_nav_menu') && has_nav_menu( 'primary-menu' ) ) {
		return wp_nav_menu( array( 
			'theme_location' => 'primary-menu',
			'container' => 'nav',
			'container_id' => 'navigation',
			'container_class' => 'jqueryslidemenu',
			'fallback_cb' => '',
			'walker' => new Theme_Walker_Nav_Menu
		));
	}else{
		$excluded_pages_with_childs = theme_get_excluded_pages();
		
		$active_class = (is_front_page()) ? 'class="current_page_item"' : '';
		
		$output = '<nav id="navigation" class="jqueryslidemenu">';
		$output .= '<ul id="menu-navigation" class="menu">';
		$output .= '<li ' .$active_class. '><a href="' .get_bloginfo('url'). '">'.__('Home','striking_front').'</a></li>';
		$output .= wp_list_pages("sort_column=menu_order&exclude=$excluded_pages_with_childs&title_li=&echo=0&depth=4");
		$output .= '</ul>';
		$output .= '</nav>';
		
		return $output;
	}
}