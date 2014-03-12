<?php
/**
 * The default template for displaying introduce in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_introduce($post_id = NULL){
	if (is_blog()){
		$blog_page_id = theme_get_option('blog','blog_page');
		$post_id = wpml_get_object_id($blog_page_id,'page');
	}
	if (is_single() || is_page() || (is_front_page() && $post_id != NULL) || (is_home() && $post_id != NULL)){
		$type = get_post_meta($post_id, '_introduce_text_type', true);
		
		if (empty($type))
			$type = 'default';
		
		if (!theme_get_option('general','introduce') && $type=='default'){
			return;
		}
		
		if ($type == 'disable') {
			return;
		}
		if (in_array($type, array('default', 'title', 'title_custom','title_slideshow'))) {
			$custom_title = get_post_meta($post_id, '_custom_title', true);
			if(!empty($custom_title)){
				$title = $custom_title;
			}else{
				$title = get_the_title($post_id);
			}
		}
		if (in_array($type, array('slideshow', 'custom_slideshow','title_slideshow'))) {
			$stype = get_post_meta($post_id, '_slideshow_type', true);
			$scategory = get_post_meta($post_id, '_slideshow_category', true);
			$color = get_post_meta($post_id, '_introduce_background_color', true);
			$number = get_post_meta($post_id, '_slideshow_number', true);

			if ($type == 'slideshow' ){
				return theme_generator('slideshow',$stype,$scategory,$color,$number);
			}else{
				if($type == 'custom_slideshow'){
					$text = str_replace(array('[raw]','[/raw]','</div> <div'),array('','','</div><div'),do_shortcode(get_post_meta($post_id, '_custom_introduce_text', true)));
				}elseif($type == 'title_slideshow'){
					$text = '<h1>'.$title.'</h1>';
				}
				
				return theme_generator('slideshow',$stype,$scategory,$color,$number,$text);
			}
		}
		
		$blog_page_id = theme_get_option('blog','blog_page');
		$blog_page_id = wpml_get_object_id($blog_page_id,'page');
		if ($type == 'default' && is_singular('post') && $post_id!=$blog_page_id) {
			$show_in_header = theme_get_inherit_option($post_id, '_show_in_header', 'blog','show_in_header');
			if($show_in_header){
				$title = get_the_title($post_id);
				$text = '<div class="entry_meta">';
				$text .= theme_generator('blog_meta',true);
				$text .= '</div>';
				/*$outputs = array();
				if (theme_get_option('blog','single_meta_date')){
					$outputs[]='<time datetime="'.get_the_time('Y-m-d').'">'.get_the_date().'</time>';
				}
				if (theme_get_option('blog','single_meta_category')){
					$outputs[]= '<span class="categories">'.get_the_category_list(',').'</span>'; 
				}
				if (theme_get_option('blog','single_meta_tags')){
					$content =  '<span class="tags">'.get_the_tag_list('',',').'</span>'; 
					if(!empty($content)){
						$outputs[] = $content;
					}
				}
				$text.= implode('<span class="separater">|</span>',$outputs);
				ob_start();
					edit_post_link( __( 'Edit', 'striking_front' ), '<span class="separater">|</span> <span class="edit-link">', '</span>' );
					global $post;
					if(theme_get_option('blog','single_meta_comment') && ($post->comment_count > 0 || comments_open())):
						echo '<span class="comments">';
						comments_popup_link(__('No Comments','striking_front'), __('1 Comment','striking_front'), __('% Comments','striking_front'));
						echo '</span>';
					endif;
				$text .= ob_get_clean();
				*/
			}else{
				return theme_generator('introduce',$blog_page_id);
			}
		}
		
		if (in_array($type, array('custom', 'title_custom'))) {
			$text = str_replace(array('[raw]','[/raw]','</div> <div'),array('','','</div><div'),do_shortcode(get_post_meta($post_id, '_custom_introduce_text', true)));
		}
	}elseif(!theme_get_option('general','introduce')){
		return;
	}

	if (is_archive()){
		$title = __('Archives','striking_front');
		if(function_exists('is_post_type_archive')){
			if(is_post_type_archive()){
				$title = wpml_t(THEME_NAME, get_query_var( 'post_type' ) . ' Post Type Archive Title',theme_get_option('advanced','archive_'.get_query_var( 'post_type' ).'_title'));
				if($title === false){
					$title = theme_get_option('advanced','archive_'.get_query_var( 'post_type' ).'_title');
				}
				$text = wpml_t(THEME_NAME, get_query_var( 'post_type' ) . ' Post Type Archive Text',theme_get_option('advanced','taxonomy_'.get_query_var( 'taxonomy' ).'_text'));
				if($text === false ){
					$text = theme_get_option('advanced','archive_'.get_query_var( 'post_type' ).'_text');
				}
				$post_type = get_post_type_object( get_query_var( 'post_type' ) );
				$title = sprintf($title,$post_type->name);
				$text = sprintf($text,$post_type->name);
			}
		}
		if(is_category()){
			$title = wpml_t(THEME_NAME, 'Category Archive Title',theme_get_option('advanced','category_title'));
			$text = wpml_t(THEME_NAME, 'Category Archive Text',theme_get_option('advanced','category_text'));
			$title = sprintf($title,single_cat_title('',false));
			$text = sprintf($text,single_cat_title('',false));
		}elseif(is_tag()){
			$title = wpml_t(THEME_NAME, 'Tag Archive Title',theme_get_option('advanced','tag_title'));
			$text = wpml_t(THEME_NAME, 'Tag Archive Text',theme_get_option('advanced','tag_text'));
			$title = sprintf($title,single_tag_title('',false));
			$text = sprintf($text,single_tag_title('',false));
		}elseif(is_date() && is_numeric(get_query_var('w')) && 0 !== get_query_var('w') ){
			$title = wpml_t(THEME_NAME, 'Weekly Archive Title',theme_get_option('advanced','weekly_title'));
			$text = wpml_t(THEME_NAME, 'Weekly Archive Text',theme_get_option('advanced','weekly_text'));
			$title = sprintf($title,get_the_time('W'));
			$text = sprintf($text,get_the_time('W'));
		}elseif(is_day()){
			$title = wpml_t(THEME_NAME, 'Daily Archive Title',theme_get_option('advanced','daily_title'));
			$text = wpml_t(THEME_NAME, 'Daily Archive Text',theme_get_option('advanced','daily_text'));
			$title = sprintf($title,get_the_time('F jS, Y'));
			$text = sprintf($text,get_the_time('F jS, Y'));
		}elseif(is_month()){
			$title = wpml_t(THEME_NAME, 'Monthly Archive Title',theme_get_option('advanced','monthly_title'));
			$text = wpml_t(THEME_NAME, 'Monthly Archive Text',theme_get_option('advanced','monthly_text'));
			$title = sprintf($title,get_the_time('F, Y'));
			$text = sprintf($text,get_the_time('F, Y'));
		}elseif(is_year()){
			$title = wpml_t(THEME_NAME, 'Yearly Archive Title',theme_get_option('advanced','yearly_title'));
			$text = wpml_t(THEME_NAME, 'Yearly Archive Text',theme_get_option('advanced','yearly_text'));
			$title = sprintf($title,get_the_time('Y'));
			$text = sprintf($text,get_the_time('Y'));
		}elseif(is_author()){
			$title = wpml_t(THEME_NAME, 'Author Archive Title',theme_get_option('advanced','author_title'));
			$text = wpml_t(THEME_NAME, 'Author Archive Text',theme_get_option('advanced','author_text'));

			if(get_query_var('author_name')){
				$curauth = get_user_by('slug', get_query_var('author_name'));
			} else {
				$curauth = get_userdata(get_query_var('author'));
			}
			$title = sprintf($title,$curauth->nickname);
			$text = sprintf($text,$curauth->nickname);
		}elseif(isset($_GET['paged']) && !empty($_GET['paged'])) {
			$title = wpml_t(THEME_NAME, 'Blog Archive Title',theme_get_option('advanced','blog_title'));
			$text = wpml_t(THEME_NAME, 'Blog Archive Text',theme_get_option('advanced','blog_text'));
		}elseif(is_tax()){
			$title = wpml_t(THEME_NAME, get_query_var( 'taxonomy' ) . ' Taxonomy Archive Title',theme_get_option('advanced','taxonomy_'.get_query_var( 'taxonomy' ).'_title'));
			if($title === false){
				$title = theme_get_option('advanced','taxonomy_'.get_query_var( 'taxonomy' ).'_title');
			}
			if($title === false){
				$title = wpml_t(THEME_NAME, 'Taxonomy Archive Title',theme_get_option('advanced','taxonomy_title'));
			}
			$text = wpml_t(THEME_NAME, get_query_var( 'taxonomy' ) . ' Taxonomy Archive Text',theme_get_option('advanced','taxonomy_'.get_query_var( 'taxonomy' ).'_text'));
			if($text === false ){
				$text = theme_get_option('advanced','taxonomy_'.get_query_var( 'taxonomy' ).'_text');
			}
			if($text === false ){
				$text = wpml_t(THEME_NAME, 'Taxonomy Archive Text',theme_get_option('advanced','taxonomy_text'));
			}
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$title = sprintf($title,$term->name);
			$text = sprintf($text,$term->name);
		}
		$title = stripslashes($title);
		$text = stripslashes($text);
	}

	if (is_404()) {
		$title = wpml_t(THEME_NAME, '404 Page Title',theme_get_option('advanced','404_title'));
		$text = wpml_t(THEME_NAME, '404 Page Text',theme_get_option('advanced','404_text'));
		$title = stripslashes($title);
		$text = stripslashes($text);
	}

	if (is_search()) {
		$title = wpml_t(THEME_NAME, 'Search Page Title',theme_get_option('advanced','search_title'));
		$text = wpml_t(THEME_NAME, 'Search Page Text',theme_get_option('advanced','search_text'));
		$text = sprintf($text,stripslashes( strip_tags( get_search_query() ) ));
		$title = stripslashes($title);
		$text = stripslashes($text);
	}

	$color = get_post_meta($post_id, '_introduce_background_color', true);
	if(!empty($color) && $color != "transparent"){
		$color = ' style="background-color:'.$color.'"';
	}else{
		$color = '';
	}
	$output = '';
	$output .= '<div id="feature"'.$color.'>';
	$output .= '<div class="top_shadow"></div>';
	$output .= '<div class="inner">';
	if (isset($title)) {
		$output .= '<h1>' . $title . '</h1>';
	}
	if (isset($text)) {
		$output .= '<div id="introduce">';
		$output .= $text;
		$output .= '</div>';
	}
	$output .= '</div>';
	$output .= '<div class="bottom_shadow"></div>';
	$output .= '</div>';
	
	return $output;
}