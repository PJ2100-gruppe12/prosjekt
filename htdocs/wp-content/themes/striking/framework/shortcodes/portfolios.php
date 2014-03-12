<?php 
function theme_shortcode_portfolio($atts, $content = null, $code) {
	$opts = shortcode_atts(array(
		'column' => 4,
		'layout' => 'full',//sidebar
		'cat' => '',
		'max' => -1,
		'title' => '',
		'titlelinkable' => 'false',
		'desc' => '',
		'desc_length' => 'default',
		'more' => '',
		'moretext' => '',
		'height' => '',
		"ajax" => 'false',
		'current' => '',
		'nopaging' => 'false',
		'sortable' => 'false',
		'sortable_all'=> 'true',
		'sortable_showtext'=> '',
		'group' => 'true',
		'lightboxtitle' => 'portfolio', //portfolio,image,imagecaption,imagedesc,none
		'advancedesc'=>'false',
		'effect' => 'default', //icon,grayscale,none
		'ids' => '',
		'order'=> 'ASC',
		'orderby'=> 'menu_order', //none, id, author, title, date, modified, parent, rand, comment_count, menu_order
	), $atts);

	extract($opts);
	switch($column){
		case 1:
			$column_class = 'one_column';
			break;
		case 2:
			$column_class = 'two_columns';
			break;
		case 3:
			$column_class = 'three_columns';
			break;
		case 5:
			$column_class = 'five_columns';
			break;
		case 6:
			$column_class = 'six_columns';
			break;
		case 7:
			$column_class = 'seven_columns';
			break;
		case 8:
			$column_class = 'eight_columns';
			break;
		case 4:
		default:
			$column_class = 'four_columns';
	}
	if ($sortable != 'false') {
		if($sortable_showtext == ''){
			$sortable_showtext = wpml_t(THEME_NAME , 'Portfolio Sortable Show Text',theme_get_option('portfolio','show_text'));
		}
		if(!empty($current)){
			$ajax = true;
		}
		//print scripts for sortable
		wp_print_scripts('jquery-quicksand');
		wp_print_scripts('jquery-easing');
		if($ajax == 'true'){
			$output = '<section class="portfolios sortable" data-options="'.htmlspecialchars(json_encode($opts)).'">';
		}else{
			$output = '<section class="portfolios sortable">';
		}
		
		$output .= '<header class="sort_by_cat">';
		$output .= '<span>'.$sortable_showtext.'</span>';
		if($sortable_all == 'true'){
			if(empty($current)){
				$output .= '<a class="current" data-value="all" href="#">'.__('All','striking_front').'</a>';
			}else{
				$output .= '<a data-value="all" href="#">'.__('All','striking_front').'</a>';
			}
		}
		$terms = array();
		if ($cat != '') {
			foreach(explode(',', $cat) as $term_slug) {
				$terms[] = get_term_by('slug', $term_slug, 'portfolio_category');
			}
		} else {
			$terms = get_terms('portfolio_category', 'hide_empty=1');
		}
		foreach($terms as $term) {
			if($term->slug == $current){
				$output .= '<a data-value="' . $term->slug . '" href="#" class="current">' . $term->name . '</a>';
			}else{
				$output .= '<a data-value="' . $term->slug . '" href="#">' . $term->name . '</a>';
			}
		}
		
		$output .= '</header>';
		$nopaging = 'true';
	} else {
		$opts['current'] = '';
		if($ajax == 'true'){
			$output = '<section class="portfolios" data-options="'.htmlspecialchars(json_encode($opts)).'">';
		}else{
			$output = '<section class="portfolios">';
		}
	}
	$output .= theme_generator('portfolio_list',$opts);
	$output .= '</section>';
	return $output;
}
add_shortcode('portfolio', 'theme_shortcode_portfolio');

function theme_portfolio_pagenavi($before = '', $after = '',$portfolio_query, $paged) {
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
	
	$request = $portfolio_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	
	$numposts = $portfolio_query->found_posts;
	$max_page = intval($portfolio_query->max_num_pages);
	
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
					echo '<a href="' . esc_url(get_pagenum_link()) . '" class="first" data-page="1" title="' . $first_page_text . '">' . $first_page_text . '</a>';
					if (! empty($pagenavi_options['dotleft_text'])) {
						echo '<span class="extend">' . $pagenavi_options['dotleft_text'] . '</span>';
					}
				}
				$larger_page_start = 0;
				foreach($larger_pages_array as $larger_page) {
					if ($larger_page < $start_page && $larger_page_start < $larger_page_to_show) {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
						echo '<a href="' . esc_url(get_pagenum_link($larger_page)) . '" data-page="'.$larger_page.'" class="page" title="' . $page_text . '">' . $page_text . '</a>';
						$larger_page_start++;
					}
				}
				if ( $paged > 1 ) {
					$prevpage = intval($paged) - 1;
					if ( $prevpage < 1 ){
						$prevpage = 1;
					}
					echo '<a class="previouspostslink" href="' . esc_url(get_pagenum_link($prevpage)) . '" data-page="'.$prevpage.'" title="' . $pagenavi_options['prev_text'] . '">'.$pagenavi_options['prev_text'].'</a>';
				}
				
				for($i = $start_page; $i <= $end_page; $i++) {
					if ($i == $paged) {
						$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
						echo '<span class="current">' . $current_page_text . '</span>';
					} else {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
						echo '<a href="' . esc_url(get_pagenum_link($i)) . '" data-page="'.$i.'" class="page" title="' . $page_text . '">' . $page_text . '</a>';
					}
				}

				$nextpage = intval($paged) + 1;

				if ( $nextpage <= $max_page ) {
					echo '<a class="nextpostslink" href="' . esc_url(get_pagenum_link($nextpage)) . '" data-page="'.$nextpage.'" title="' . $pagenavi_options['next_text'] . '">'.$pagenavi_options['next_text'].'</a>';
				}
				
				$larger_page_end = 0;
				foreach($larger_pages_array as $larger_page) {
					if ($larger_page > $end_page && $larger_page_end < $larger_page_to_show) {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
						echo '<a href="' . esc_url(get_pagenum_link($larger_page)) . '" data-page="'.$larger_page.'" class="page" title="' . $page_text . '">' . $page_text . '</a>';
						$larger_page_end++;
					}
				}
				if ($end_page < $max_page) {
					if (! empty($pagenavi_options['dotright_text'])) {
						echo '<span class="extend">' . $pagenavi_options['dotright_text'] . '</span>';
					}
					$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
					echo '<a href="' . esc_url(get_pagenum_link($max_page)) . '" data-page="'.$max_page.'" class="last" title="' . $last_page_text . '">' . $last_page_text . '</a>';
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
