<?php 
/**
 * JavaScripts In Header
 */
function theme_enqueue_scripts() {
	if((is_admin() && !is_shortcode_preview()) ||'wp-login.php' == basename($_SERVER['PHP_SELF'])){
		return;
	}
	
	$move_bottom = theme_get_option('advanced','move_bottom');

	wp_register_script( 'jquery-tinyslider', THEME_JS .'/jquery-tinyslider.min.js', array('jquery'),false,$move_bottom);
	wp_register_script( 'tinyslider-init', THEME_JS .'/tinySliderInit.min.js', array('jquery','jquery-tinyslider'),false,$move_bottom);
	
	if( !theme_get_option('advanced','no_fancybox') ){
		wp_enqueue_script( 'jquery-fancybox', THEME_JS .'/jquery.fancybox.min.js', array('jquery'),'2.1.3',$move_bottom);
	}
	// wp_register_script( 'jquery-nav', THEME_JS .'/jquery.nav.js', array('jquery'),false,$move_bottom);
	// wp_register_script( 'jquery-tools-tabs', THEME_JS .'/jquery.tools.tabs.min.js', array('jquery'),'1.2.6',$move_bottom);
	// wp_register_script( 'jquery-navToSelect', THEME_JS .'/jquery-navtoselect.js', array('jquery'),false,$move_bottom);
	// wp_register_script('enquire', THEME_JS . '/enquire.js', array('jquery'),false,$move_bottom);
	// wp_register_script('jquery-imageLoaded', THEME_JS . '/jquery.imagesloaded.js', array('jquery'),false,$move_bottom);
	// wp_register_script('jquery-adaptText', THEME_JS .'/jquery-adapttext.js', array('jquery'));
	// wp_register_script( 'jquery-countTo', THEME_JS .'/jquery.countTo.js', array('jquery'));
	// wp_register_script( 'jquery-easypiechart', THEME_JS .'/jquery.easypiechart.js', array('jquery'));
	// wp_register_script( 'swfobject', THEME_JS .'/swfobject.js', false,'2.3',$move_bottom);
	// wp_enqueue_script( 'custom-js', THEME_JS .'/custom.js', array('jquery','jquery-nav','jquery-easypiechart','jquery-countTo','jquery-tools-tabs','swfobject','jquery-navToSelect','enquire','jquery-imageLoaded','jquery-adaptText'),false,$move_bottom);
	
	wp_enqueue_script( 'custom-js', THEME_JS .'/custom.combine.js', array('jquery'),false,$move_bottom);

	wp_register_script( 'jquery-sticker', THEME_JS .'/jquery-sticker.min.js', array('jquery'),'0.6.5',$move_bottom);

	if((is_front_page() && theme_get_option('footer','sticky_footer')) || (theme_get_inherit_option(get_queried_object_id(), '_sticky_footer', 'footer','sticky_footer'))) {
		wp_enqueue_script( 'jquery-stickyfooter', THEME_JS .'/jquery.stickyfooter.min.js', array('jquery-sticker'),'1.0',$move_bottom);
	}
	if(theme_get_option('general','sticky_header')){ 
		wp_enqueue_script( 'jquery-stickyheader', THEME_JS .'/jquery.stickyheader.min.js', array('jquery-sticker'),'1.0',$move_bottom);
	}
	if(theme_get_option('general','sticky_sidebar')){
		wp_enqueue_script( 'jquery-stickysidebar', THEME_JS .'/jquery.stickysidebar.min.js', array('jquery-sticker'),'1.0',$move_bottom);
	}
	
	wp_register_script( 'jquery-carousel', THEME_JS .'/jquery-carousel.min.js', array('jquery'),false,$move_bottom);
	wp_register_script( 'mediaelementjs-scripts', THEME_URI .'/mediaelement/mediaelement-and-player.js', array('jquery'),'2.11.3',$move_bottom);


	wp_register_script( 'cufon-yui', THEME_JS .'/cufon-yui.js', array('jquery'),'1.09i');
	wp_register_script( 'jquery-quicksand', THEME_JS .'/jquery.quicksand.min.js', array('jquery'),'1.3');
	wp_register_script( 'jquery-easing', THEME_JS . '/jquery.easing.1.3.min.js', array('jquery'),'1.3');
	wp_register_script( 'google-map-api', 'http://maps.google.com/maps/api/js?sensor=false');
	wp_register_script( 'jquery-gmap', THEME_JS .'/jquery.gmap.min.js', array('jquery','google-map-api'),'2.1.4');
	wp_register_script( 'jquery-tweet', THEME_JS .'/jquery.tweet.min.js', array('jquery'));
	wp_register_script( 'jquery-tools-validator', THEME_JS .'/jquery.tools.validator.min.js', array('jquery'),'1.2.5');
	wp_register_script( 'jquery-isotope', THEME_JS .'/isotope.pkgd.min.js', array('jquery'));

	//slideshow
	//Unleash Accordion Slider
	wp_register_script( 'jquery-unleash', THEME_JS .'/unleash/jquery.unleash.2.min.js', array('jquery','jquery-easing'),'2',$move_bottom);
	wp_register_script( 'unleash-init', THEME_JS . '/unleashSliderInit.min.js',array('jquery-unleash'),false,$move_bottom);
	//Roundabout Slider
	wp_register_script( 'jquery-roundabout-shape', THEME_JS .'/roundabout/jquery.roundabout-shapes.min.js', array('jquery'),'1.0',$move_bottom);
	wp_register_script( 'jquery-roundabout', THEME_JS .'/roundabout/jquery.roundabout.min.js', array('jquery','jquery-easing','jquery-roundabout-shape'),'2.4.2',$move_bottom);
	wp_register_script( 'roundabout-init', THEME_JS . '/roundSliderInit.min.js',array('jquery-roundabout'),false,$move_bottom);
	//KenBurner Slider
	wp_register_script( 'jquery-kenburner-plugin', THEME_JS .'/kenburner/jquery.themepunch.plugins.min.js', array('jquery'),false,$move_bottom);
	wp_register_script( 'jquery-kenburner', THEME_JS .'/kenburner/jquery.themepunch.kenburn.min.js', array('jquery-kenburner-plugin'),false,$move_bottom);
	wp_register_script( 'ken-init', THEME_JS . '/kenSliderInit.min.js',array('jquery-kenburner'),false,$move_bottom);
	//Nivo Slider
	wp_register_script( 'jquery-nivo', THEME_JS .'/nivo/jquery.nivo.slider.pack.js', array('jquery'),false,$move_bottom);
	wp_register_script( 'nivo-init', THEME_JS . '/nivoSliderInit.min.js',array('jquery-nivo'),false,$move_bottom);

	//Fotorama Slider
	wp_register_script( 'jquery-fotorama', THEME_JS .'/fotorama/fotorama.js', array('jquery'),false,$move_bottom);
	wp_register_script( 'fotorama-init', THEME_JS . '/fotoramaSliderInit.min.js',array('jquery-fotorama'),false,$move_bottom);

	if ( is_singular() ){
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

function theme_enqueue_styles(){
	if((is_admin() && !is_shortcode_preview()) || 'wp-login.php' == basename($_SERVER['PHP_SELF'])){
		return;
	}
	wp_register_style('mediaelementjs-styles', THEME_URI.'/mediaelement/mediaelementplayer.css', false, false, 'all');
	
	wp_register_style('ken-css', THEME_CSS.'/slideshow-ken.css', false, false, 'all');
	wp_register_style('nivo-css', THEME_CSS.'/slideshow-nivo.css', false, false, 'all');
	wp_register_style('unleash-css', THEME_CSS.'/slideshow-unleash.css', false, false, 'all');
	wp_register_style('roundabout-css', THEME_CSS.'/slideshow-roundabout.css', false, false, 'all');
	wp_register_style('fotorama-css', THEME_CSS.'/slideshow-fotorama.css', false, false, 'all');
	
	if(theme_get_option('advanced','complex_class')){
		wp_enqueue_style('theme-style', THEME_CSS.'/screen_complex.min.css', false, false, 'all');
	}else{
		wp_enqueue_style('theme-style', THEME_CSS.'/screen.min.css', false, false, 'all');
	}

	if($icons = theme_get_option('font','icons')){
		switch($icons){
			case 'awesome':
				wp_enqueue_style('theme-icons-awesome', THEME_ICONS_URI.'/awesome/css/font-awesome.min.css', false, false, 'all');
				break;
		}
	}
	if(theme_get_option('advanced','responsive')){
		wp_enqueue_style('theme-responsive', THEME_CSS.'/responsive.min.css', false, false, 'all');
	}
	if(is_multisite()){
		global $blog_id;
		wp_enqueue_style('theme-skin', THEME_CACHE_URI.'/skin_'.$blog_id.'.css', array('theme-style'), time(), 'all');
	}else{
		wp_enqueue_style('theme-skin', THEME_CACHE_URI.'/skin.css', array('theme-style'), time(), 'all');
	}
}
add_action('wp_print_styles', 'theme_enqueue_styles');

if(theme_get_option('font','cufon_enabled')){
	function theme_add_cufon_script(){
		$fonts = theme_get_option('font','cufon_used');
		if(is_array($fonts)){
			foreach ($fonts as $font){
				if(is_array($font)){
					wp_register_script($font['file_name'], $font['url'], array('cufon-yui'));
					wp_print_scripts($font['file_name']);
				}else{
					wp_register_script($font, THEME_FONT_URI .'/'.$font, array('cufon-yui'));
					wp_print_scripts($font);
				}
			}
		}
		wp_print_scripts('cufon-yui');
	}
	add_filter('wp_head','theme_add_cufon_script',1);	
}
if(theme_get_option('font','gfont_used')){
	function theme_add_gfont_lib(){
		$http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";
		$fonts = theme_get_option('font','gfont_used');
		if(is_array($fonts)){
			foreach ($fonts as $font){
				$subsets = theme_get_google_font_subsets($font);
				if(empty($subsets)){
					$subsets = array('latin');
				}
				if(count($subsets) == 1 && $subsets[0] == 'latin'){
					$subsets_str = '';
				}else{
					$subsets_str = '&subset='.implode(',', $subsets);
				}
				wp_enqueue_style('font|'.$font,$http.'://fonts.googleapis.com/css?family='.$font.$subsets_str);
			}
		}
	}
	add_action("wp_print_styles", 'theme_add_gfont_lib');
}
// if(theme_get_option('advanced','combine_js')){
// 	global $theme_combine_js_enqueued; 
// 	$theme_combine_js_enqueued = false;
// 	function theme_combine_js($handles){
// 		if(is_admin()){
// 			return;
// 		}
// 		global $wp_scripts, $theme_combine_js_enqueued;
// 		if($theme_combine_js_enqueued) return;
// 		if (! is_a($wp_scripts, 'WP_Scripts')) return;
		
// 		$move_bottom = theme_get_option('advanced','move_bottom');
// 		$combine_scripts = array();
// 		$queue_unset = array();
// 		$wp_scripts->all_deps($wp_scripts->queue); 
// 		foreach ($wp_scripts->to_do as $key => $handle) {
// 			$src = $wp_scripts->registered[$handle]->src;
// 			if (substr($src, 0, 4) != 'http') {
// 				$src = site_url($src);
// 				$external = false;
// 			} else {
// 				$home = home_url();
// 				if (substr($src, 0, strlen($home)) == $home) {
// 					$external = false;
// 				} else	{
// 					$external = true;
// 				}
// 			}
// 			if(!$external && $handle!='jquery'){
// 				$combine_scripts[$handle] = $src;
// 				unset($wp_scripts->to_do[$key]);
// 				$queue_unset[$handle] = true;
// 			}
// 		}
// 		foreach ($wp_scripts->queue as $key => $handle) {
// 			if (isset($queue_unset[$handle])){
// 				if(!in_array($handle, $wp_scripts->done, true)){
// 					$wp_scripts->done[] = $handle;
// 				}
// 				unset($wp_scripts->queue[$key]);
// 			}
// 		}
		
// 		$fileId = 0;
// 		foreach($combine_scripts as $handle => $src){
// 			$path = ABSPATH . str_replace(get_option('siteurl').'/', '', $src);
// 			$fileId += @filemtime($path);
// 		}
			
// 		$cache_name = md5(serialize($combine_scripts).$fileId);
// 		$cache_file_path = THEME_CACHE_DIR . '/' .$cache_name .'.js';
// 		$cache_file_url = THEME_CACHE_URI . '/' .$cache_name .'.js';
		
// 		if(!is_readable($cache_file_path)){
// 			$content = '';
// 			foreach($combine_scripts as $handle => $src){
// 				$content .= "/* $handle: ($src) */\n";
// 				$content .= @file_get_contents($src). "\n\n\n\n";;
// 			}
// 			if (is_writable(THEME_CACHE_DIR)) {
// 				$fhandle = @fopen($cache_file_path, 'w+');
// 				if ($fhandle) fwrite($fhandle, $content, strlen($content));
// 			}
// 		}
// 		wp_enqueue_script($cache_name, $cache_file_url,array(),false,$move_bottom);
// 		$theme_combine_js_enqueued = true;
// 	}
// 	add_action('wp_print_scripts', 'theme_combine_js',100);
// }
	
// if(theme_get_option('advanced','combine_css')){
// 	function theme_combine_css($handles){
// 		if(is_admin()){
// 			return;
// 		}
// 		global $wp_styles;
// 		if (! is_object($wp_styles)) return;
// 		$combine_styles = array();
// 		$queue_unset = array();
// 		$wp_styles->all_deps($wp_styles->queue); 
// 		foreach ($wp_styles->to_do as $key => $handle) {
// 			$media = ($wp_styles->registered[$handle]->args ? $wp_styles->registered[$handle]->args : 'screen');
// 			$src = $wp_styles->registered[$handle]->src;
// 			if (substr($src, 0, 4) != 'http') {
// 				$src = site_url($src);
// 				$external = false;
// 			} else {
// 				$home = home_url();
// 				if (substr($src, 0, strlen($home)) == $home) {
// 					$external = false;
// 				} else	{
// 					$external = true;
// 				}
// 			}
// 			if(!$external){
// 				$combine_styles[$media][$handle] = $src;
// 				unset($wp_styles->to_do[$key]);
// 				$queue_unset[$handle] = true;
// 			}
// 		}
// 		foreach ($wp_styles->queue as $key => $handle) {
// 			if (isset($queue_unset[$handle])){
// 				if(!in_array($handle, $wp_styles->done, true)){
// 					$wp_styles->done[] = $handle;
// 				}
// 				unset($wp_styles->queue[$key]);
// 			}
// 		}
// 		foreach ($combine_styles as $media => $styles) {
// 			$fileId = 0;
// 			foreach($styles as $handle => $src){
// 				$path = ABSPATH . str_replace(get_option('siteurl').'/', '', $src);
// 				$fileId += @filemtime($path);
// 			}
				
// 			$cache_name = md5(serialize($combine_styles).$fileId);
// 			$cache_file_path = THEME_CACHE_DIR . '/' .$cache_name .'.css';
// 			$cache_file_url = THEME_CACHE_URI . '/' .$cache_name .'.css';
			
// 			if(!is_readable($cache_file_path)){
// 				$content = '';
// 				foreach($styles as $handle => $src){
// 					$content .= "/* $handle: ($src) */\n";
// 					$content .= @file_get_contents($src). "\n\n";;
// 				}
// 				if (is_writable(THEME_CACHE_DIR)) {
// 					$fhandle = @fopen($cache_file_path, 'w+');
// 					if ($fhandle) fwrite($fhandle, $content, strlen($content));
// 				}
// 			}
// 			wp_enqueue_style(THEME_SLUG.'-styles-'.$media, $cache_file_url, false, false, $media);
// 		}
// 	}
// 	add_action('wp_print_styles', 'theme_combine_css',100);
// }

function theme_slideshow_header(){
	$type = false;

	if( is_front_page() || (is_home() && !get_option('page_on_front') && get_queried_object_id()== 0 )){
		$page= theme_get_option('homepage','home_page');
		if($page){
			if (in_array( get_post_meta($page, '_introduce_text_type', true), array('slideshow', 'custom_slideshow','title_slideshow'))) {
				$type = get_post_meta($page,'__slideshow_type', true);
			}
		}else{
			if (theme_get_option('homepage', 'disable_slideshow')) {
				return;
			}
			$type = theme_get_option('homepage', 'slideshow_type');
		}
	}elseif( is_single() || is_page() || (is_home() && get_queried_object_id() == get_option('page_for_posts'))){
		$post_id = get_queried_object_id();
	
		$introduce_type = get_post_meta($post_id, '_introduce_text_type', true);
		if (in_array( $introduce_type, array('slideshow', 'custom_slideshow','title_slideshow'))) {
			$type = get_post_meta($post_id,'__slideshow_type', true);
		}
		$blog_page_id = theme_get_option('blog','blog_page');
		if('default' == $introduce_type && $post_id!=$blog_page_id){
			$show_in_header = theme_get_option('blog','show_in_header');
			if(!$show_in_header){
				$introduce_type = get_post_meta($blog_page_id, '_introduce_text_type', true);
				if('slideshow' == $introduce_type){
					$type = get_post_meta($blog_page_id,'__slideshow_type', true);
				}
			}
		}
	}elseif( is_home() && get_queried_object_id()== 0 && defined('ICL_SITEPRESS_VERSION')){ //wpml other language's homepage
		$home_page_id = theme_get_option('homepage','home_page');
		$home_page_id = wpml_get_object_id($home_page_id,'page');
			
		$introduce_type = get_post_meta($home_page_id, '_introduce_text_type', true);
		if (in_array( $introduce_type, array('slideshow', 'custom_slideshow','title_slideshow'))) {
			$type = get_post_meta($home_page_id,'__slideshow_type', true);
		}
	}

	if($type != false && $type != 'revslider'){
		require_once (THEME_HELPERS . '/slideshowGenerator.php');
		$slideshowGenerator = new PageSlideshowGenerator;
		$slideshowGenerator->header($type);
	}
}
