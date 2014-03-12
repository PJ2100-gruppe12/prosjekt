<?php
function theme_shortcode_contactform($atts,$content = null) {
	extract(shortcode_atts(array(
		'email' => get_bloginfo('admin_email'),
		'bgcolor' => '',
		'textcolor' => '',
		'submit' => '',
	), $atts));
    wp_print_scripts('jquery-tools-validator');

    $content = trim($content);
	if(!empty($content)){
		$success = do_shortcode($content);
	}
	$bgcolor = $bgcolor?' style="background-color:'.$bgcolor.'"':'';
	$textcolor = $textcolor?' style="color:'.$textcolor.'"':'';
	
	if(empty($success)){
		$success = __('Your message was successfully sent. <strong>Thank You!</strong>','striking_front');
	}
	$name_str = __('Name *','striking_front');
	$email_str = __('Email *','striking_front');

	if(!empty($submit)){
		$submit_str = $submit;
	}else{
		$submit_str = __('Submit','striking_front');
	}
	
	$email = str_replace('@','*',$email);
	$include_path = THEME_INCLUDES;
	$id = rand(100,3000);
	//$action = $include_path.'/sendmail.php';
	$action = add_query_arg(array());
	$button_class = apply_filters( 'theme_css_class', 'button' );
	return <<<HTML
[raw]
<div class="contact_form_wrap">
	<div class="success" style="display:none;"><div class="message_box_content">{$success}</div></div> 
	<form class="contact_form" action="{$action}" method="post" novalidate="novalidate">
		<p><input type="text" required="required" id="contact_{$id}_name" name="contact_{$id}_name" class="text_input" value="" tabindex="5" />
		<label for="contact_{$id}_name">{$name_str}</label></p>
		<p><input type="email" required="required" id="contact_{$id}_email" name="contact_{$id}_email" class="text_input" value="" tabindex="6"  />
		<label for="contact_{$id}_email">{$email_str}</label></p>
		<p><textarea required="required" name="contact_{$id}_content" class="textarea" cols="30" rows="5" tabindex="7"></textarea></p>
		<p><button {$bgcolor}type="submit" class="{$button_class} white"><span{$textcolor}>{$submit_str}</span></button></p>
		<input type="hidden" value="1" name="theme_contact_form_submit"/>
		<input type="hidden" value="{$id}" name="contact_widget_id"/>
		<input type="hidden" value="{$email}" name="contact_{$id}_to"/>
	</form>
</div>
[/raw]
HTML;
}
add_shortcode('contactform', 'theme_shortcode_contactform');

function theme_shortcode_search($atts,$content = null) {
	extract(shortcode_atts(array(
		'bgcolor' => '',
		'textcolor' => '',
	), $atts));
	
	$bgcolor = $bgcolor?' style="background-color:'.$bgcolor.'"':'';
	$textcolor = $textcolor?' style="color:'.$textcolor.'"':'';
	
	$search_str = __('Search..', 'striking_front');
	$button_class = apply_filters( 'theme_css_class', 'button' );
	$url = home_url();
	return <<<HTML
<form method="get" id="searchform" action="{$url}"><input type="text" class="text_input" value="{$search_str}" name="s" id="s" onfocus="if(this.value == '{$search_str}') {this.value = '';}" onblur="if (this.value == '') {this.value = '{$search_str}';}" /><button type="submit" class="{$button_class} gray"{$bgcolor}><span{$textcolor}>{$search_str}</span></button></form>
HTML;
}
add_shortcode('search', 'theme_shortcode_search');

function theme_shortcode_twitter($atts) {
	extract(shortcode_atts(array(
		'username' => '',
		'count' => 3,
		'query' => 'null',
		'avatarsize' => 'null',
	), $atts));
	
	$user_array = explode(',',$username);
	foreach($user_array as $key => $user){
		$user_array[$key] = '"'.$user.'"';
	}	
	
	wp_print_scripts('jquery-tweet');
	$id = rand(1,1000);
	$just_now_text = __('just now','striking_front');
	$seconds_ago_text = __('about %d seconds ago','striking_front');
	$a_minutes_ago_text = __('about a minute ago','striking_front');
	$minutes_ago_text = __('about %d minutes ago','striking_front');
	$a_hours_ago_text = __('about an hour ago','striking_front');
	$hours_ago_text = __('about %d hours ago','striking_front');
	$a_day_ago_text = __('about a day ago','striking_front');
	$days_ago_text = __('about %d days ago','striking_front');
	$view_text = __('view tweet on twitter','striking_front');
	
	if ( !empty( $user_array )|| $query!="null" ) {
		$username = implode(',',$user_array);
		if($query != "null"){
			$query = '"'.html_entity_decode($query).'"';
		}
		$with_avatar = ($avatarsize != 'null')?' with_avatar':'';
		return <<<HTML
[raw]
<div class="twitter_wrap{$with_avatar}">
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery("#twitter_wrap_{$id}").tweet({
		username: [{$username}],
		count: {$count},
		query: {$query},
		avatar_size: {$avatarsize},
		just_now_text: "{$just_now_text}",
		seconds_ago_text: "{$seconds_ago_text}",
		a_minutes_ago_text: "{$a_minutes_ago_text}",
		minutes_ago_text: "{$minutes_ago_text}",
		a_hours_ago_text: "{$a_hours_ago_text}",
		hours_ago_text: "{$hours_ago_text}",
		a_day_ago_text: "{$a_day_ago_text}",
		days_ago_text: "{$days_ago_text}",
		view_text: "{$view_text}"
	});
});
</script>
	<div id="twitter_wrap_{$id}"></div>
	<div class="clearboth"></div>
</div>
[/raw]
HTML;
	}
}
add_shortcode('twitter', 'theme_shortcode_twitter');

function theme_shortcode_flickr($atts) {
	extract(shortcode_atts(array(
		'id' => '',
		'type' => 'user',
		'count' => 4,
		'display' => 'latest'//lastest or random
	), $atts));
	
	return <<<HTML
[raw]
<div class="flickr_wrap">
	<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count={$count}&amp;display={$display}&amp;size=s&amp;layout=x&amp;source={$type}&amp;{$type}={$id}"></script>
</div>
<div class="clearboth"></div>
[/raw]
HTML;
}
add_shortcode('flickr', 'theme_shortcode_flickr');


function theme_shortcode_links($atts) {
	extract(shortcode_atts(array(
		'desc' => 'false',
		'name' => 'false',
		'rating' => 'false',
		'images' => 'false',
		'cat' => '',
		'cat_title' => 'true',
	), $atts));
	if ($desc == 'false') {
		$desc = 0;
	}else{
		$desc = 1;
	}
	if ($name == 'false') {
		$name = 0;
	}else{
		$name = 1;
	}
	if ($rating == 'false') {
		$rating = 0;
	}else{
		$rating = 1;
	}
	if ($images == 'false') {
		$images = 0;
	}else{
		$images = 1;
	}
	if($cat_title == 'true'){
		$categorize = 1;
	}else{
		$categorize = 0;
	}
	
	$output = wp_list_bookmarks(array(
		'show_images' => $images,
		'show_description' => $desc,
		'show_name' => $name, 
		'show_rating' => $rating,
		'category' => $cat,
		'class' => 'linkcat',
		'category_before' =>null,
		'category_after' => null,
		'title_before' => '<h3>',
		'title_after' => '</h3>',
		'categorize' => $categorize,
		'title_li' => 0,
		'echo' => 0
	));
	if($cat_title == 'true'){
		$output = '[raw]<div class="links_wrap">'.$output.'</div>[/raw]';
	}else{
		$output = '[raw]<div class="links_wrap"><ul class="xoxo blogroll">'.$output.'</ul></div>[/raw]';;
	}
	return $output;
}
add_shortcode('links', 'theme_shortcode_links');

function theme_shortcode_contact_info($atts) {
	extract(shortcode_atts(array(
		'color' => '',
		'phone' => '',
		'cellphone' => '',
		'email' => '',
		'link' => '',
		'address' => '',
		'city' => '',
		'state' => '',
		'zip' => '',
		'name' => '',
	), $atts));
	
	if(!empty($city) && !empty($state)){
		$city = $city.',&nbsp;'.$state;
	}elseif(!empty($state)){
		$city = $state;
	}
	if(!empty($color)){
		$color = ' '.$color;
	}
	
	$output = '<div class="contact_info_wrap">';
	if(!empty($phone)){
		$output .= '<p><span class="icon_text icon_phone'.$color.'">'.$phone.'</span></p>';
	}
	if(!empty($cellphone)){
		$output .= '<p><span class="icon_text icon_cellphone'.$color.'">'.$cellphone.'</span></p>';
	}
	if(!empty($fax)){
		$output .= '<p><span class="icon_text icon_fax'.$color.'">'.$fax.'</span></p>';
	}
	if(!empty($email)){
		$email = str_replace('@','*',$email);
		$output .= '<p><a href="mailto:'.$email.'" class="icon_text icon_email'.$color.'">'.$email.'</a></p>';
	}
	if(!empty($link)){
		$output .= '<p><a href="'.$link.'" target="_blank" class="icon_text icon_link'.$color.'">'.$link.'</a></p>';
	}
	if(!empty($address)){
		$output .= '<p><span class="icon_text icon_home'.$color.'">'.$address.'</span></p>';
	}
	if(!empty($city)||!empty($zip)){
		$output .= '<p class="contact_address">';
		if(!empty($city)){
			$output .= '<span>'.$city.'</span>';
		}
		if(!empty($zip)){
			$output .= '<span class="contact_zip">'.$zip.'</span>';
		}
	}
	if(!empty($name)){
		$output .= '<p><span class="icon_text icon_id'.$color.'">'.$name.'</span></p>';
	}
	$output .= '</div>';
	
	return $output;
}
add_shortcode('contact_info', 'theme_shortcode_contact_info');

function theme_shortcode_archives($atts){
	extract(shortcode_atts(array(
		'dropdown' => 'false',
		'count' => 'false',
	), $atts));

	$cache = wp_cache_get('shortcode_archives', 'shortcode');

	if ( ! is_array( $cache ) )
		$cache = array();

	$cache_id = md5(serialize($atts));

	if ( isset( $cache[ $cache_id ] ) ) {
		return $cache[ $cache_id ];
	}

	if($count === 'true'){
		$count = 1;
	}else{
		$count = 0;
	}
	if($dropdown === 'true'){
		$output = '<select name="archive-dropdown" onchange=\'document.location.href=this.options[this.selectedIndex].value;\'> <option value="">'.esc_attr(__('Select Month','striking_front')).'</option> '.wp_get_archives(apply_filters('widget_archives_dropdown_args', array('type' => 'monthly', 'format' => 'option', 'show_post_count' => $count,'echo'=> 0))).' </select>';
	}else{
		$output = '<ul>'.wp_get_archives(apply_filters('widget_archives_args', array('type' => 'monthly', 'show_post_count' => $count, 'echo'=>0))).'</ul>';
	}

	$cache[$cache_id] = $output;
	wp_cache_set('shortcode_archives', $cache, 'shortcode');

	return $output;
}
add_shortcode('archives', 'theme_shortcode_archives');


function theme_shortcode_categories($atts){
	extract(shortcode_atts(array(
		'dropdown' => 'false',
		'count' => 'false',
		'hierarchical' => 'false',
	), $atts));

	$cache = wp_cache_get('shortcode_categories', 'shortcode');

	if ( ! is_array( $cache ) )
		$cache = array();

	$cache_id = md5(serialize($atts));

	if ( isset( $cache[ $cache_id ] ) ) {
		return $cache[ $cache_id ];
	}

	if($count === 'true'){
		$count = 1;
	}else{
		$count = 0;
	}
	if($hierarchical === 'true'){
		$hierarchical = 1;
	}else{
		$hierarchical = 0;
	}
	$cat_args = array('orderby' => 'name', 'show_count' => $count, 'hierarchical' => $hierarchical, 'echo'=>0);

	if($dropdown === 'true'){
		$cat_args['show_option_none'] = __('Select Category','striking_front');
		$output = wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
		$home_url = home_url();
		$output .= <<<HTML
[raw]<script type='text/javascript'>
/* <![CDATA[ */
	var dropdown = document.getElementById("cat");
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
			location.href = "{$home_url}/?cat="+dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onCatChange;
/* ]]> */
</script>[/raw]
HTML;
	}else{
		$cat_args['title_li'] = '';
		$output = '<ul>'.wp_list_categories(apply_filters('widget_categories_args', $cat_args)).'</ul>';
	}

	$cache[$cache_id] = $output;
	wp_cache_set('shortcode_categories', $cache, 'shortcode');

	return $output;
}
add_shortcode('categories', 'theme_shortcode_categories');

function theme_shortcode_popular_posts($atts) {
	extract(shortcode_atts(array(
		'count' => '4',
		'thumbnail' => 'true',
		'extra' => 'desc', //desc, time, both
		'cat' => '',
		'posts' => '',
		'author' => '',
		'offset' => 0,
		'title_length' => '',
		'desc_length' => '80',
	), $atts));
	
	$cache = wp_cache_get('shortcode_popular_posts', 'shortcode');

	if ( ! is_array( $cache ) )
		$cache = array();

	$cache_id = md5(serialize($atts));

	if ( isset( $cache[ $cache_id ] ) ) {
		return $cache[ $cache_id ];
	}

	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];
	
	$query = array('showposts' => $count, 'nopaging' => 0, 'orderby'=> 'comment_count', 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
	if($cat){
		$query['cat'] = $cat;
	}
	if($posts){
		$query['post__in'] = explode(',',$posts);
	}
	if($author){
		$query['author'] = $author;
	}
	if($extra == 'both'){
		$extra = array('time','desc');
	}else{
		$extra = array($extra);
	}
	if((int)$offset != 0){
		$query['offset'] = (int)$offset;
	}
	$exclude_cats = theme_get_option('blog','exclude_categorys');
	if(!empty($exclude_cats)){
		$query['category__not_in'] = $exclude_cats;
	}
	$r = new WP_Query($query);
	$output = '';
	if ($r->have_posts()){
		$output = '<div class="popular_posts_wrap">';
		$output .= '<ul class="posts_list">';
		while ($r->have_posts()){
			$r->the_post();
			$output .= '<li>';
			if($thumbnail!='false'){
				if (has_post_thumbnail() ){
					$output .= '<a class="thumbnail" href="'.get_permalink().'" title="'.get_the_title().'">';
					$output .= get_the_post_thumbnail(get_the_ID(),array(65,65),array('title'=>get_the_title(),'alt'=>get_the_title()));
					$output .= '</a>';
				}elseif(theme_get_option('blog','display_default_thumbnail')){
					if($default_thumbnail_custom = theme_get_option('blog','default_thumbnail_custom')){
						$default_thumbnail_image = theme_get_image_src($default_thumbnail_custom);
					}else{
						$default_thumbnail_image = THEME_IMAGES.'/widget_posts_thumbnail.png';
					}
					$output .= '<a class="thumbnail" href="'.get_permalink().'" title="'.get_the_title().'">';
					$output .= '<img src="'.$default_thumbnail_image.'" width="65" height="65" title="'.get_the_title().'" alt="'. get_the_title().'"/>';
					$output .= '</a>';
				}
			}
			$output .= '<div class="post_extra_info">';
			$title = get_the_title();
			if((int)$title_length && mb_strlen($title)>$title_length){
				$title =  mb_substr($title,0,$title_length).'...';
			}
			$output .= '<a class="post_title" href="'.get_permalink().'" title="'.get_the_title().'" rel="bookmark">'.$title.'</a>';
			
			if(in_array('time', $extra)){
				$output .= '<time datetime="'.get_the_time('Y-m-d').'">'.get_the_date().'</time>';
			}
			if(in_array('desc', $extra)){
				global $post;
				$excerpt = $post->post_excerpt;
				$excerpt = apply_filters('get_the_excerpt', $excerpt);
				$output .= '<p>'.wp_html_excerpt($excerpt,$desc_length).'...</p>';
			}
			$output .= '</div>';
			$output .= '<div class="clearboth"></div>';
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '</div>';
	} 
	wp_reset_query();
	
	$wp_filter['the_content'] = $the_content_filter_backup;

	$cache[$cache_id] = $output;
	wp_cache_set('shortcode_popular_posts', $cache, 'shortcode');

	return $output;
}
add_shortcode('popular_posts', 'theme_shortcode_popular_posts');

function theme_shortcode_recent_posts($atts) {
	extract(shortcode_atts(array(
		'count' => '4',
		'thumbnail' => 'true',
		'extra' => 'desc',
		'cat' => '',
		'posts' => '',
		'author' => '',
		'offset' => 0,
		'title_length' => '',
		'desc_length' => '80',
	), $atts));
	
	$cache = wp_cache_get('shortcode_recent_posts', 'shortcode');

	if ( ! is_array( $cache ) )
		$cache = array();

	$cache_id = md5(serialize($atts));

	if ( isset( $cache[ $cache_id ] ) ) {
		return $cache[ $cache_id ];
	}

	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];
	
	$query = array('showposts' => $count, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
	if($cat){
		$query['cat'] = $cat;
	}
	if($posts){
		$query['post__in'] = explode(',',$posts);
	}
	if($author){
		$query['author'] = $author;
	}
	if($extra == 'both'){
		$extra = array('time','desc');
	}else{
		$extra = array($extra);
	}
	if((int)$offset != 0){
		$query['offset'] = (int)$offset;
	}
	$exclude_cats = theme_get_option('blog','exclude_categorys');
	if(!empty($exclude_cats)){
		$query['category__not_in'] = $exclude_cats;
	}
	$r = new WP_Query($query);
	
	$output = '';
	if ($r->have_posts()){
		$output = '<div class="recent_posts_wrap">';
		$output .= '<ul class="posts_list">';
		while ($r->have_posts()){
			$r->the_post();
			$output .= '<li>';
			if($thumbnail!='false'){
				if (has_post_thumbnail() ){
					$output .= '<a class="thumbnail" href="'.get_permalink().'" title="'.get_the_title().'">';
					$output .= get_the_post_thumbnail(get_the_ID(),array(65,65),array('title'=>get_the_title(),'alt'=>get_the_title()));
					$output .= '</a>';
				}elseif(theme_get_option('blog','display_default_thumbnail')){
					if($default_thumbnail_custom = theme_get_option('blog','default_thumbnail_custom')){
						$default_thumbnail_image = theme_get_image_src($default_thumbnail_custom);
					}else{
						$default_thumbnail_image = THEME_IMAGES.'/widget_posts_thumbnail.png';
					}
					$output .= '<a class="thumbnail" href="'.get_permalink().'" title="'.get_the_title().'">';
					$output .= '<img src="'.$default_thumbnail_image.'" width="65" height="65" title="'.get_the_title().'" alt="'. get_the_title().'"/>';
					$output .= '</a>';
				}
			}
			$output .= '<div class="post_extra_info">';
			$title = get_the_title();
			if((int)$title_length && mb_strlen($title)>$title_length){
				$title =  mb_substr($title,0,$title_length).'...';
			}
			$output .= '<a class="post_title" href="'.get_permalink().'" title="'.get_the_title().'" rel="bookmark">'.$title.'</a>';
			if(in_array('time', $extra)){
				$output .= '<time datetime="'.get_the_time('Y-m-d').'">'.get_the_date().'</time>';
			}
			if(in_array('desc', $extra)){
				global $post;
				$excerpt = $post->post_excerpt;
				$excerpt = apply_filters('get_the_excerpt', $excerpt);
				$output .= '<p>'.wp_html_excerpt($excerpt,$desc_length).'...</p>';
			}
			$output .= '</div>';
			$output .= '<div class="clearboth"></div>';
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '</div>';
	} 
	wp_reset_query();
	
	$wp_filter['the_content'] = $the_content_filter_backup;

	$cache[$cache_id] = $output;
	wp_cache_set('shortcode_recent_posts', $cache, 'shortcode');

	return $output;
}
add_shortcode('recent_posts', 'theme_shortcode_recent_posts');


function theme_shortcode_portfolio_list($atts) {
	extract(shortcode_atts(array(
		'count' => '4',
		'thumbnail' => 'true',
		'extra' => 'desc',
		'cat' => '',
		'type'=>'',
		'author' => '',
		'offset' => 0,
		'title_length' => '',
		'desc_length' => '80',
	), $atts));
	
	$cache = wp_cache_get('shortcode_portfolio_list', 'shortcode');

	if ( ! is_array( $cache ) )
		$cache = array();

	$cache_id = md5(serialize($atts));

	if ( isset( $cache[ $cache_id ] ) ) {
		return $cache[ $cache_id ];
	}

	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];
	
	$query = array(
		'showposts' => $count, 
		'nopaging' => 0, 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1,
		'post_type' => 'portfolio',
		'suppress_filters'=>0,
	);
	if($cat != ''){
		global $wp_version;
		if(version_compare($wp_version, "3.1", '>=')){
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => explode(',', $cat)
				)
			);
		}else{
			$query['taxonomy'] = 'portfolio_category';
			$query['term'] = $cat;
		}
	}
	if($type != ''){
		$query['meta_key'] = '_type';
		$query['meta_value'] = $type;
		$query['meta_compare'] = 'IN';
	}
	if($author != '' ){
		$query['author'] = $author;
	}
	if($extra == 'both'){
		$extra = array('time','desc');
	}else{
		$extra = array($extra);
	}
	if((int)$offset != 0){
		$query['offset'] = (int)$offset;
	}
	$r = new WP_Query($query);
	$output = '';
	if ($r->have_posts()){
		$output = '<div class="portfolio_list_wrap">';
		$output .= '<ul class="posts_list">';
		while ($r->have_posts()){
			$r->the_post();
			$output .= '<li>';
			if($thumbnail!='false'){
				if (has_post_thumbnail() ){
					$output .= '<a class="thumbnail" href="'.get_permalink().'" title="'.get_the_title().'">';
					$output .= get_the_post_thumbnail(get_the_ID(),array(65,65),array('title'=>get_the_title(),'alt'=>get_the_title()));
					$output .= '</a>';
				}elseif(theme_get_option('portfolio','display_default_thumbnail')){
					if($default_thumbnail_custom = theme_get_option('portfolio','default_thumbnail_custom')){
						$default_thumbnail_image = theme_get_image_src($default_thumbnail_custom);
					}else{
						$default_thumbnail_image = THEME_IMAGES.'/widget_posts_thumbnail.png';
					}
					$output .= '<a class="thumbnail" href="'.get_permalink().'" title="'.get_the_title().'">';
					$output .= '<img src="'.$default_thumbnail_image.'" width="65" height="65" title="'.get_the_title().'" alt="'. get_the_title().'"/>';
					$output .= '</a>';
				}
			}
			$output .= '<div class="post_extra_info">';
			$title = get_the_title();
			if((int)$title_length && mb_strlen($title)>$title_length){
				$title =  mb_substr($title,0,$title_length).'...';
			}
			$output .= '<a class="post_title" href="'.get_permalink().'" title="'.get_the_title().'" rel="bookmark">'.$title.'</a>';
			if(in_array('time', $extra)){
				$output .= '<time datetime="'.get_the_time('Y-m-d').'">'.get_the_date().'</time>';
			}
			if(in_array('desc', $extra)){
				global $post;
				$excerpt = $post->post_excerpt;
				$excerpt = apply_filters('get_the_excerpt', $excerpt);
				$output .= '<p>'.wp_html_excerpt($excerpt,$desc_length).'...</p>';
			}
			$output .= '</div>';
			$output .= '<div class="clearboth"></div>';
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '</div>';
	} 
	wp_reset_query();
	
	$wp_filter['the_content'] = $the_content_filter_backup;

	$cache[$cache_id] = $output;
	wp_cache_set('shortcode_portfolio_list', $cache, 'shortcode');

	return $output;
}
add_shortcode('portfolio_list', 'theme_shortcode_portfolio_list');
