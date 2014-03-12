<?php
/**
 * The default template for displaying blog author info in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_blog_author_info(){
	if(theme_get_option('blog','author_link_to_website')){
		$author = get_the_author_link();
	}else{
		$author = get_the_author_posts_link();
	}
	$output = '<section id="about_the_author">'.
	'<h3>'.__('About the author','striking_front').'</h3>'.
	'<div class="author_content">'.
	'<div class="gravatar">'.get_avatar( get_the_author_meta('user_email'), '60' ).'</div>'.
	'<div class="author_info">'.
		'<div class="author_name">'.$author.'</div>'.
		'<p class="author_desc">'.get_the_author_meta('description').'</p>'.
	'</div>'.
	'<div class="clearboth"></div>'.
	'</div>'.
	'</section>';
	return $output;
}