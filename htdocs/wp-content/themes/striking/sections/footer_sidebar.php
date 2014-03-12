<?php
/**
 * The default template for displaying footer sidebar in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_footer_sidebar(){
	return sidebar_generator('get_footer_sidebar');
}