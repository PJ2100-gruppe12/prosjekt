<?php
function theme_shortcode_blog($atts, $content = null, $code) {
	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];
	extract(shortcode_atts(array(
		'count' => 3,
		'cat' => '',
		'author' => '',
		'posts' => '',
		'grid'	=> 'false',
		'image' => 'true',
		'imagetype' => 'default',
		'title' => 'true',
		'meta' => 'true',
		'desc' => 'true',
		'desc_length' => 'default',
		'full' => 'false',
		'nopaging' => 'true',
		'paged' => '',
		'column' => 1,
		'width' => '',
		'height' => '',
		'offset' => 0,
		'effect' => 'default', //icon,grayscale,none
		'frame' => 'default',
		'frame_bgcolor' => '',
		'frame_bordercolor'=> '',
		'frame_borderthickness' => '1',
		'divider_color' =>'',
		'read_more' => 'default',
		'read_more_text' => '',
		'read_more_button' => 'default',
		'category__and' =>'',
		'category__not_in' => '',
	), $atts));
	
	$query = array(
		'posts_per_page' => (int)$count,
		'post_type'=>'post',
	);
	if($paged){
		$query['paged'] = $paged;
	}
	if($cat){
		$query['cat'] = $cat;
	}
	if($category__and){
		$query['category__and'] = explode(',',$category__and);
	}
	if($category__not_in){
		$query['category__not_in'] = explode(',',$category__not_in);
	}
	if($author){
		$query['author'] = $author;
	}
	if($posts){
		$query['post__in'] = explode(',',$posts);
	}
	if((int)$offset != 0){
		$query['offset'] = (int)$offset;
	}
	if ($nopaging == 'false') {
		global $wp_version;
		if((is_front_page() || is_home() ) && version_compare($wp_version, "3.1", '>=')){//fix wordpress 3.1 paged query 
			$paged = (get_query_var('paged')) ?get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
		}else{
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		$query['paged'] = $paged;
	} else {
		$query['showposts'] = $count;
	}
	if($image == 'true'){
		if($imagetype == 'default'){
			$featured_image_type = theme_get_option('blog', 'featured_image_type');
		}else{
			$featured_image_type = $imagetype;
		}
	}else{
		$featured_image_type = 'full';
	}
	if($frame == 'default'){
		$frame =  theme_get_option('blog','frame');
	}elseif($frame == 'true'){
		$frame = true;
	}else{
		$frame = false;
	}
	if($read_more == 'default'){
		$read_more =  theme_get_option('blog','read_more');
	}elseif($read_more == 'true'){
		$read_more = true;
	}else{
		$read_more = false;
	}
	if($read_more_button == 'default'){
		$read_more_button =  theme_get_option('blog','read_more_button');
	}elseif($read_more_button == 'true'){
		$read_more_button = true;
	}else{
		$read_more_button = false;
	}


	if($effect == 'default'){
		$effect = theme_get_option('blog','effect');
	}
	$r = new WP_Query($query);

	$column = (int)$column;
	if($column > 6){
		$column = 6;
	}elseif($column < 1){
		$column = 1;
	}
	$posts_per_column = ceil($query['posts_per_page']/$column);
	
	$atts = array(
		'featured_image_type' => $featured_image_type,
		'posts_per_column' => $posts_per_column,
		'posts_per_page' => (int)$count,
		'desc' => $desc,
		'full' => $full,
		'title' => $title,
		'meta' => $meta,
		'width' => $width,
		'height' => $height,
		'image' => $image,
		'column' => $column,
		'grid'	=> $grid,
		'frame' => $frame,
		'divider_color' => $divider_color,
		'frame_bgcolor' => $frame_bgcolor,
		'frame_bordercolor' => $frame_bordercolor,
		'frame_borderthickness' => $frame_borderthickness,
		'read_more'=>$read_more,
		'read_more_text'=>$read_more_text,
		'read_more_button' =>$read_more_button,
		'effect' => $effect,
	);
	
	if($desc_length != 'default'){
		$excerpt_constructor = new Theme_The_Excerpt_Length_Constructor($desc_length);
		add_filter( 'excerpt_length', array($excerpt_constructor,'get_length'));
	}
	
	$column = ($grid == 'true') ? 1 : $column;
	
	$output = '';
	
	if($column != 1){
		$class = array('half','third','fourth','fifth','sixth');
		$css = $class[$column-2];
		
		for($i=1; $i<=$column; $i++){
			if ($i%$column !== 0) {
				$output .= "<div class=\"one_{$css}\">".theme_shortcode_blog_column_posts($r,$atts,$i)."</div>";
			} else {
				$output .= "<div class=\"one_{$css} last\">".theme_shortcode_blog_column_posts($r,$atts,$i)."</div>";
			}
		}
	}else{
		$output .= theme_shortcode_blog_column_posts($r,$atts,1);
	}
	
	if($desc_length != 'default'){
		remove_filter( 'excerpt_length', array($excerpt_constructor,'get_length'));
	}
	
	if ($nopaging == 'false') {
		ob_start();
		theme_blog_pagenavi('', '', $r, $paged);
		$output .= ob_get_clean();
	}

	wp_reset_postdata();
	$wp_filter['the_content'] = $the_content_filter_backup;
	return $output;
}
add_shortcode('blog','theme_shortcode_blog');

function theme_shortcode_blog_column_posts(&$r, $atts, $current) {
	extract($atts);
	if($read_more_text == ''){
		$read_more_text = wpml_t(THEME_NAME, 'Blog Post Read More Button Text',stripslashes(theme_get_option('blog','read_more_text')));
	}
	if ($grid == 'true') {
		$class = array('half','third','fourth','fifth','sixth');
		$css = $class[$column-2];
	} else {
		$start = ($current-1) * $posts_per_column +1;
		$end = $current * $posts_per_column;
		if( $r->post_count < $start){
			return '';
		}
	}

	if($frame){
		$frame_css = ' entry_frame';
	}else{
		$frame_css = '';
	}
	
	$output = '';
		
	$i = 0;
	if ($r->have_posts()):
		while ($r->have_posts()) : 
			$i++;
			
			if ($grid == 'false') {
				if($i < $start) continue;
				if($i > $end) break;
			}
						
			$r->the_post();
			
			if ($grid == 'true' && $column != 1) {
				if ($i%$column !== 0) {
					$output .= "<div class=\"one_{$css}\">";
				} else {
					$output .= "<div class=\"one_{$css} last\">";
				}
			}
			$frame_styles = array();

			if($frame && $frame_bgcolor){
				$frame_styles[]='background-color:'.$frame_bgcolor;
			}
			if($frame && $frame_bordercolor){
				$frame_styles[]='border-color:'.$frame_bordercolor;
			}
			if($frame && $frame_borderthickness!='1'){
				$frame_styles[]='border-width:'.$frame_borderthickness.'px';
				$frame = 30 + 2*$frame_borderthickness;
			}
			if(!empty($frame_styles)){
				$style = ' style="'.implode(';', $frame_styles).'"';
			} else{
				$style = '';
			}
			

			if($divider_color){
				$divider_style = ' style="border-color:'.$divider_color.'"';
			}else{
				$divider_style = '';
			}
			

			$output .= '<article id="post-'.get_the_ID().'" class="entry entry_'.$featured_image_type.$frame_css.'"'.$style.'>';
			if($image == 'true' && $featured_image_type!=='below'){
				$output .= theme_generator('blog_featured_image',$featured_image_type,$width,$height,$frame,$effect);
			}
			if($title == 'true' || $meta == 'true'){
				$output .= '<div class="entry_info">';
				if($title == 'true'){
					$output .= '<h2 class="entry_title"><a href="'.get_permalink().'" rel="bookmark" title="'.sprintf( __("Permanent Link to %s", 'striking_front'), get_the_title() ).'">'.get_the_title().'</a></h2>';
				}
				if($meta == 'true'){
					$output .= '<div class="entry_meta"'.$divider_style.'>';
					$output .= theme_generator('blog_meta');
					$output .= '</div>';
				}
				$output .= '</div>';
			}
			if($image == 'true' && $featured_image_type=='below'){
				$output .= theme_generator('blog_featured_image',$featured_image_type,$width,$height,$frame,$effect);
			}
			if($desc == 'true'){
				$output .= '<div class="entry_content">';

				if($full == 'true'){
					global $more;
					$more = 0;
					$content = get_the_content($read_more_text,false);
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$output .= $content;
				}else{
					$content = get_the_excerpt();
					$content = apply_filters('the_excerpt', $content);
					$output .= '<div>'.$content.'</div>';
					
					if($read_more){
						$output .= '<div class="read_more_wrap">';
						if($read_more_button){
							$output .= '<a class="read_more_link '.apply_filters( 'theme_css_class', 'button' ).' small" href="'.get_permalink().'" rel="nofollow"><span>'.$read_more_text.'</span></a>';
						}else{
							$output .= '<a class="read_more_link" href="'.get_permalink().'" rel="nofollow">'.$read_more_text.'</a>';
						}
						$output .= '</div>';
					}
				}
				$output .= '</div>';
			}
			
			$output .= '</article>';
			
			if ($grid == 'true' && $column != 1) {
				$output .= '</div>';
				if ($i%$column === 0) {
					$output .= "<div class=\"clearboth\"></div>";
				}
			}
		endwhile;
	endif;
		
	return $output;
}

function theme_blog_pagenavi($before = '', $after = '', $blog_query, $paged) {
	global $wpdb, $wp_query;
	
	if (is_single())
		return;
	
	$pagenavi_options = array(
		//'pages_text' => __('Page %CURRENT_PAGE% of %TOTAL_PAGES%','striking_front'),
		'pages_text' => '',
		'current_text' => '%PAGE_NUMBER%',
		'page_text' => '%PAGE_NUMBER%',
		'first_text' => __('&laquo; First','striking_front'),
		'last_text' => __('Last &raquo;','striking_front'),
		'next_text' => __('&raquo;','striking_front'),
		'prev_text' => __('&laquo;','striking_front'),
		'dotright_text' => __('...','striking_front'),
		'dotleft_text' => __('...','striking_front'),
		'style' => 1,
		'num_pages' => 4,
		'always_show' => 0,
		'num_larger_page_numbers' => 3,
		'larger_page_numbers_multiple' => 10,
		'use_pagenavi_css' => 0,
	);
	
	$request = $blog_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	global $wp_version;
	if((is_front_page() || is_home() ) && version_compare($wp_version, "3.1", '>=')){//fix wordpress 3.1 paged query 
		$paged = (get_query_var('paged')) ?intval(get_query_var('paged')) : intval(get_query_var('page'));
	}else{
		$paged = intval(get_query_var('paged'));
	}
	
	$numposts = $blog_query->found_posts;
	$max_page = intval($blog_query->max_num_pages);
	
	if (empty($paged) || $paged == 0)
		$paged = 1;
	$pages_to_show = intval($pagenavi_options['num_pages']);
	$larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
	$larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start = floor($pages_to_show_minus_1 / 2);
	$half_page_end = ceil($pages_to_show_minus_1 / 2);
	$start_page = $paged - $half_page_start;
	
	if ($start_page <= 0)
		$start_page = 1;
	
	$end_page = $paged + $half_page_end;
	if (($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	
	if ($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	
	if ($start_page <= 0)
		$start_page = 1;
	
	$larger_pages_array = array();
	if ($larger_page_multiple)
		for($i = $larger_page_multiple; $i <= $max_page; $i += $larger_page_multiple)
			$larger_pages_array[] = $i;
	
	if ($max_page > 1 || intval($pagenavi_options['always_show'])) {
		$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
		$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
		echo $before . '<div class="wp-pagenavi">' . "\n";
		switch(intval($pagenavi_options['style'])){
			// Normal
			case 1:
				if (! empty($pages_text)) {
					echo '<span class="pages">' . $pages_text . '</span>';
				}
				if ($start_page >= 2 && $pages_to_show < $max_page) {
					$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
					echo '<a href="' . esc_url(get_pagenum_link()) . '" class="first" title="' . $first_page_text . '">' . $first_page_text . '</a>';
					if (! empty($pagenavi_options['dotleft_text'])) {
						echo '<span class="extend">' . $pagenavi_options['dotleft_text'] . '</span>';
					}
				}
				$larger_page_start = 0;
				foreach($larger_pages_array as $larger_page) {
					if ($larger_page < $start_page && $larger_page_start < $larger_page_to_show) {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
						echo '<a href="' . esc_url(get_pagenum_link($larger_page)) . '" class="page" title="' . $page_text . '">' . $page_text . '</a>';
						$larger_page_start++;
					}
				}
				previous_posts_link($pagenavi_options['prev_text']);
				for($i = $start_page; $i <= $end_page; $i++) {
					if ($i == $paged) {
						$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
						echo '<span class="current">' . $current_page_text . '</span>';
					} else {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
						echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="page" title="' . $page_text . '">' . $page_text . '</a>';
					}
				}
				next_posts_link($pagenavi_options['next_text'], $max_page);
				$larger_page_end = 0;
				foreach($larger_pages_array as $larger_page) {
					if ($larger_page > $end_page && $larger_page_end < $larger_page_to_show) {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
						echo '<a href="' . esc_url(get_pagenum_link($larger_page)) . '" class="page" title="' . $page_text . '">' . $page_text . '</a>';
						$larger_page_end++;
					}
				}
				if ($end_page < $max_page) {
					if (! empty($pagenavi_options['dotright_text'])) {
						echo '<span class="extend">' . $pagenavi_options['dotright_text'] . '</span>';
					}
					$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
					echo '<a href="' . esc_url(get_pagenum_link($max_page)) . '" class="last" title="' . $last_page_text . '">' . $last_page_text . '</a>';
				}
				break;
			// Dropdown
			case 2:
				echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="get">' . "\n";
				echo '<select size="1" onchange="document.location.href = this.options[this.selectedIndex].value;">' . "\n";
				for($i = 1; $i <= $max_page; $i++) {
					$page_num = $i;
					if ($page_num == 1) {
						$page_num = 0;
					}
					if ($i == $paged) {
						$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
						echo '<option value="' . esc_url(get_pagenum_link($page_num)) . '" selected="selected" class="current">' . $current_page_text . "</option>\n";
					} else {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
						echo '<option value="' . esc_url(get_pagenum_link($page_num)) . '">' . $page_text . "</option>\n";
					}
				}
				echo "</select>\n";
				echo "</form>\n";
				break;
		}
		echo '</div>' . $after . "\n";
	}
}
