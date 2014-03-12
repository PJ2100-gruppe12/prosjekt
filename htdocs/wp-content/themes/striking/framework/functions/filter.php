<?php
function theme_more_link($more_link, $more_link_text) {
	
	$more_link = '[raw]' . $more_link . '[/raw]';
	if(theme_get_option('blog','read_more_button')){
		$more_link='[raw]<a class="read_more_link '.apply_filters( 'theme_css_class', 'button' ).' small" href="'.get_permalink().'"><span>'.wpml_t(THEME_NAME, 'Blog Post Read More Button Text',stripslashes(theme_get_option('blog','read_more_text'))).'</span></a>[/raw]';
	}
	return '<div class="read_more_wrap">'.str_replace('more-link', 'read_more_link', $more_link).'</div>';
}
add_filter('the_content_more_link', 'theme_more_link', 10, 2);

function theme_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'theme_excerpt_more');

function theme_exclude_category_feed() {
	$exclude_cats = theme_get_option('blog','exclude_categorys');
	if(is_array($exclude_cats)){
		foreach ($exclude_cats as $key => $cat) {
			$exclude_cats[$key] = -$cat;
		}
		if ( is_feed() ) {
			set_query_var("cat", implode(",",$exclude_cats));
		}
	}
}
add_filter('nav_menu_css_class' , 'theme_nav_add_has_children_class' , 10 , 3);

function theme_nav_add_has_children_class($classes, $item,$args = null){
	if ( (is_object($args) && isset($args->has_children) && $args->has_children) ||
		(is_array($args) && isset($args['has_children']) && $args['has_children']) ) {
		$classes[] = "has-children";
     }
     return $classes;
}
add_filter('page_css_class' , 'theme_page_add_has_children_class' , 10 , 4);
function theme_page_add_has_children_class($classes, $item,$depth  = null, $args = null){
	if (is_array($args) && isset($args['has_children']) && $args['has_children'] ) {
		$classes[] = "has-children";
     }
     return $classes;
}
add_filter('pre_get_posts', 'theme_exclude_category_feed');
if( theme_get_option('advanced','show_post_thumbnail_on_feed')){
	function theme_show_post_thumbnail_on_feeds($content) {
		global $post;
		if(has_post_thumbnail($post->ID)) {
			$content = $content . '<div><a href="' . get_permalink($post->ID) . '">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</a></div>';
		}
		return $content;
	}
	add_filter('the_excerpt_rss', 'theme_show_post_thumbnail_on_feeds');
	add_filter('the_content_feed', 'theme_show_post_thumbnail_on_feeds');
}
/*
 * Remove Blog categories from category widget
 */
function theme_exclude_category_widget($cat_args)
{
	$exclude_cats = theme_get_option('blog','exclude_categorys');

	if(is_array($exclude_cats)){
		$cat_args['exclude'] = implode(",",$exclude_cats);
	}
 	return $cat_args;
}
add_filter('widget_categories_args', 'theme_exclude_category_widget');

function theme_exclude_archives_widget($args)
{
	$exclude_cats = theme_get_option('blog','exclude_categorys');

	if(is_array($exclude_cats)){
		$args['exclude'] = $exclude_cats;
	}

 	return $args;
}
add_filter('widget_archives_args', 'theme_exclude_archives_widget');
add_filter('widget_archives_dropdown_args', 'theme_exclude_archives_widget');

function theme_exclude_archive_where($where,$args){

	global $wpdb;

	if(isset($args['exclude']) && !empty($args['exclude'])){
		$where .= $wpdb->prepare(" AND ID NOT IN (SELECT DISTINCT object_id FROM {$wpdb->term_relationships} WHERE term_taxonomy_id IN ('" . join("', '", $args['exclude'] ) . "'))");
	}
	return $where;
}
add_filter('getarchives_where', 'theme_exclude_archive_where',10,2);

function theme_exclude_the_categorys($thelist,$separator=' ') {
	if(!defined('WP_ADMIN') && !empty($separator)) {
		//Category IDs to exclude
		$exclude = theme_get_option('blog','exclude_categorys');

		$exclude2 = array();
		foreach($exclude as $c) {
			$exclude2[] = get_cat_name($c);
		}

		$cats = explode($separator,$thelist);
		$newlist = array();
		foreach($cats as $cat) {
			$catname = trim(strip_tags($cat));
			if(!in_array($catname,$exclude2))
				$newlist[] = $cat;
		}
		return implode($separator,$newlist);
	} else {
		return $thelist;
	}
}
add_filter('the_category','theme_exclude_the_categorys',10,2);

/*
 * add a span element for style in the page
 */
function theme_comment_style($return) {
	return str_replace($return, "<span></span>$return", $return);
}
add_filter('get_comment_author_link', 'theme_comment_style');

function theme_widget_title_remove_space($return){
	$return = trim($return);
	if('&nbsp;' == $return){
		return '';	
	}else{
		return $return;
	}
}
add_filter('widget_title', 'theme_widget_title_remove_space');

function theme_widget_text_shortcode($content) {
	$content = do_shortcode($content);
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	
	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= do_shortcode($piece);
		}
	}

	return $new_content;
}
// Allow Shortcodes in Sidebar Widgets
add_filter('widget_text', 'theme_widget_text_shortcode');

if(theme_get_option('advanced','complex_class')){
	function theme_complex_css_class($class){
		return 'theme_'.$class;
	}

	add_filter('theme_css_class', 'theme_complex_css_class');
}

function theme_mimes_add_ico($mime_types){
	$mime_types['ico'] = 'image/x-icon'; 
	return $mime_types;
}
add_filter('upload_mimes', 'theme_mimes_add_ico');

global $wp_version;
if(version_compare($wp_version, "3.1", '<')){
	/*
	 * Thank to Bob Sherron.
	 * http://stackoverflow.com/questions/1155565/query-multiple-custom-taxonomy-terms-in-wordpress-2-8/2060777#2060777
	 */
	function multi_tax_terms($where) {
		global $wp_query;
		global $wpdb;
		if (isset($wp_query->query_vars['term']) && (strpos($wp_query->query_vars['term'], ',') !== false && strpos($where, "AND 0") !== false) ) {
			// it's failing because taxonomies can't handle multiple terms
			//first, get the terms
			$term_arr = explode(",", $wp_query->query_vars['term']);
			foreach($term_arr as $term_item) {
				$terms[] = get_terms($wp_query->query_vars['taxonomy'], array('slug' => $term_item));
			}

			//next, get the id of posts with that term in that tax
			foreach ( $terms as $term ) {
				$term_ids[] = $term[0]->term_id;
			}

			$post_ids = get_objects_in_term($term_ids, $wp_query->query_vars['taxonomy']);

			if ( !is_wp_error($post_ids) && count($post_ids) ) {
				// build the new query
				$new_where = " AND $wpdb->posts.ID IN (" . implode(', ', $post_ids) . ") ";
				// re-add any other query vars via concatenation on the $new_where string below here

				// now, sub out the bad where with the good
				$where = str_replace("AND 0", $new_where, $where);
			} else {
				// give up
			}
		}
		return $where;
	}
	add_filter("posts_where", "multi_tax_terms");
}

/*
 * add menu order support for Single Portfolio Item Previous & Next Navigation
 */
$order = theme_get_option('portfolio','single_navigation_order');
if($order == 'menu_order'){
	function get_previous_portfolio_menu_order_where($where){
		global $post, $wpdb;
		if($post->post_type == 'portfolio'){
			$current_menu_order = $post->menu_order;
			$where = $wpdb->prepare("WHERE p.menu_order < %s AND p.post_type = 'portfolio' AND p.post_status = 'publish'", $current_menu_order);
		}
		return $where;
	}
	function get_next_portfolio_menu_order_where($where){
		global $post, $wpdb;
		if($post->post_type == 'portfolio'){
			$current_menu_order = $post->menu_order;
			$where = $wpdb->prepare("WHERE p.menu_order > %s AND p.post_type = 'portfolio' AND p.post_status = 'publish'", $current_menu_order);
		}
		return $where;
	}
	add_filter("get_previous_post_where", "get_previous_portfolio_menu_order_where");
	add_filter("get_next_post_where", "get_next_portfolio_menu_order_where");

	function get_previous_portfolio_menu_order_sort($sort){
		global $post;
		if($post->post_type == 'portfolio'){
			$sort = "ORDER BY p.menu_order DESC LIMIT 1";
		}
		return $sort;
	}
	function get_next_portfolio_menu_order_sort($sort){
		global $post;
		if($post->post_type == 'portfolio'){
			$sort = "ORDER BY p.menu_order ASC LIMIT 1";	
		}
		return $sort;
	}

	add_filter("get_previous_post_sort", "get_previous_portfolio_menu_order_sort");
	add_filter("get_next_post_sort", "get_next_portfolio_menu_order_sort");
}

/*
 * Single Portfolio Item Document Type Navigation
 */
if(theme_get_option('portfolio','single_doc_navigation')){
	function get_adjacent_doc_portfolio_join($join){
		global $post, $wpdb;
		if($post->post_type == 'portfolio'){
			$join .= " JOIN $wpdb->postmeta ON (p.ID = $wpdb->postmeta.post_id) ";
		}
		return $join;	
	}
	add_filter("get_previous_post_join", "get_adjacent_doc_portfolio_join");
	add_filter("get_next_post_join", "get_adjacent_doc_portfolio_join");

	function get_adjacent_doc_portfolio_where($where){
		global $post, $wpdb;
		if($post->post_type == 'portfolio'){
			$where .= $wpdb->prepare(" AND $wpdb->postmeta.meta_key = %s ", '_type');
			$where .= $wpdb->prepare("AND $wpdb->postmeta.meta_value = %s ", 'doc');
		}
		return $where;
	}
	add_filter("get_previous_post_where", "get_adjacent_doc_portfolio_where");
	add_filter("get_next_post_where", "get_adjacent_doc_portfolio_where");
}
/*
 * Single Portfolio Item Category Navigation
 */
if(theme_get_option('portfolio','single_navigation_category')){
	function get_adjacent_category_portfolio_join($join){
		global $post, $wpdb;
		if($post->post_type == 'portfolio'){
			$join .= " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

			$cat_array = wp_get_object_terms($post->ID, 'portfolio_category', array('fields' => 'ids'));
			$join .= " AND tt.taxonomy = 'portfolio_category' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
			//$join .= " JOIN $wpdb->postmeta ON (p.ID = $wpdb->postmeta.post_id) ";
		}
		return $join;	
	}
	add_filter("get_previous_post_join", "get_adjacent_category_portfolio_join");
	add_filter("get_next_post_join", "get_adjacent_category_portfolio_join");
}

function theme_exclude_category_post_join($join){
	global $post, $wpdb;
	if($post->post_type == 'post'){
		$exclude_cats = theme_get_option('blog','exclude_categorys');
		if(is_array($exclude_cats) && !empty($exclude_cats)){
			$join .= " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
			$join .= " AND tt.taxonomy = 'category' AND tt.term_id NOT IN (" . implode(',', $exclude_cats) . ")";
			if(theme_get_option('blog','single_navigation_category')){
				$cat_array = wp_get_object_terms($post->ID, 'category', array('fields' => 'ids'));
				$join .= " AND tt.term_id IN (" . implode(',', $cat_array) . ")";
			}
		}else{
			if(theme_get_option('blog','single_navigation_category')){
				$join .= " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
				$cat_array = wp_get_object_terms($post->ID, 'category', array('fields' => 'ids'));
				$join .= " AND tt.taxonomy = 'category' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
			}
		}
	}
	return $join;
}
add_filter("get_previous_post_join", "theme_exclude_category_post_join");
add_filter("get_next_post_join", "theme_exclude_category_post_join");

if(theme_get_option('general','lightbox_rel_replace')){
	add_filter('the_content', 'theme_add_lightbox_rel_replace');
	function theme_add_lightbox_rel_replace ($content)
	{       global $post;
			$pattern = "/<a([^>]*?)href=('|\")([^\\2>]*?)\.(bmp|gif|jpeg|jpg|png)\\2(.*?)>/i";
			$replacement = '<a$1href=$2$3.$4$2 class="lightbox" rel="post_%LIGHTID%"$6>';
			$content = preg_replace($pattern, $replacement, $content);
			$content = str_replace("%LIGHTID%", $post->ID, $content);
			return $content;
	}
}

if(theme_get_option('advanced','shortcode_comment')){
	add_filter('comment_text', 'do_shortcode');
}
if(theme_get_option('general','scroll_to_top')){
	add_filter('body_class','theme_add_scoll_to_top_body_class');
	function theme_add_scoll_to_top_body_class($classes) {
		$classes[] = 'scroll-to-top';
		return $classes;
	}
}
if(theme_get_option('advanced','no_colorbox')){
	add_filter('body_class','theme_add_no_colorbox_body_class');
	function theme_add_no_colorbox_body_class($classes) {
		$classes[] = 'no_colorbox';
		return $classes;
	}
}

add_filter('body_class','theme_add_current_language_class_to_body');
function theme_add_current_language_class_to_body($classes) {
	if(function_exists('icl_get_languages')) {
		$classes[] =  'current-language-'.strtolower(ICL_LANGUAGE_NAME_EN);
	}
	return $classes;
}

function theme_search_parse_query($query = false){
	if($query->is_search){
		$exclude_cats = theme_get_option('blog','exclude_categorys');
		foreach ($exclude_cats as $key => $value) {
			$exclude_cats[$key] = -$value;
		}
		if (isset($query->query_vars["cat"])) {
			$cat = $query->query_vars["cat"];
			if(!empty($cat) && '0' != $cat){
				$cat = ''.urldecode($cat).'';
				$cat = addslashes_gpc($cat );
				$cat_array = preg_split('/[,\s]+/', $cat);
				$req_cats = array();
				foreach ( (array) $cat_array as $c ) {
					$c = intval($c);
					if(!in_array($c, $exclude_cats))
					$req_cats[] = $c;
				}
				$exclude_cats = array_merge($exclude_cats,$req_cats);
			}
		}
		$query->set("cat",  implode(",",$exclude_cats));
	}
	return $query;
}
add_filter('parse_query', 'theme_search_parse_query');


function theme_nav_menu_css_class($classes,$item){
	if(is_home() && !is_blog() && $item->object_id == get_option( 'page_for_posts' )) {
		$classes = array_diff($classes, array('current_page_parent'));
	}
	if(!is_home() && get_post_type() == 'post' && isset($item->object_id) ){
		$blog_page = theme_get_option('blog','blog_page');
		if(!empty($blog_page) && $item->object_id == $blog_page){
			$classes[] = 'current_page_parent';
		}
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'theme_nav_menu_css_class',10,2);

function theme_page_css_class($classes,$page){
	if(!is_home() && get_post_type() == 'post'){
		$blog_page = theme_get_option('blog','blog_page');
		if(!empty($blog_page) && $page->ID == $blog_page){
			$classes[] = 'current_page_parent';
		}
	}
	return $classes;
}
add_filter('page_css_class', 'theme_page_css_class',10,2);