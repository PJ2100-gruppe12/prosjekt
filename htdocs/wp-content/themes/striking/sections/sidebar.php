<?php
/**
 * The default template for displaying sidebar in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_sidebar(){
	return sidebar_generator('get_sidebar',get_queried_object_id());
}