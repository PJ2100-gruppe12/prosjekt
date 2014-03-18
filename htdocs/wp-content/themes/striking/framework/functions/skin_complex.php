<?php 
	/* general settings */
	$logo_bottom = theme_get_option('general','logo_bottom');
	$header_height = theme_get_option('general','header_height');

	/* font settings */
	$font = theme_get_option('font');
	$font['font_family']=stripslashes($font['font_family']);
	if($font['link_underline']){
		$font['link_underline']='underline';
	}else{
		$font['link_underline']='none';
	}
	$font['pagenavi_hover'] = $font['page'] + 2;
	$font['pagenavi_current'] = $font['page'] + 4;

	/* fontface */
	$fontface_css = '';
	if(theme_get_option('font','fontface_enabled')){
		$fontface_used = theme_get_option('font','fontface_used');
		$fontface_default = theme_get_option('font','fontface_default');
		if(is_array($fontface_used)){
			foreach ($fontface_used as $font_str){
				if(is_array($font_str)){
					$font_name = $font_str['name'];
					$font_folder = $font_str['folder'];
					if(file_exists($font_str['dir'])){
						$file_content = file_get_contents($font_str['dir']);
						if( preg_match("/@font-face\s*{[^}]*?font-family\s*:\s*('|\")$font_name\\1.*?}/is", $file_content, $match) ){
							if(false === stripos($font_str['url'],get_stylesheet_directory_uri())){
								$uri = str_replace('stylesheet.css','',$font_str['url']);
								$fontface_css .= preg_replace("/url\s*\(\s*['|\"]\s*/is","\\0$uri",$match[0])."\n";
							}else{
								$fontface_css .= preg_replace("/url\s*\(\s*['|\"]\s*/is","\\0../fontfaces/$font_folder/",$match[0])."\n";
							}
						}
					}
					
				}else{
					$font_info = explode("|", $font_str);
					$font_name = $font_info[1];
					$stylesheet = THEME_FONTFACE_DIR.'/'.$font_info[0].'/stylesheet.css';
					if(file_exists($stylesheet)){
						$file_content = file_get_contents($stylesheet);
						if( preg_match("/@font-face\s*{[^}]*?font-family\s*:\s*('|\")$font_info[1]\\1.*?}/is", $file_content, $match) ){
							if(defined('THEME_CHILD_NAME')){
								$template = get_template();
								$fontface_css .= preg_replace("/url\s*\(\s*['|\"]\s*/is","\\0../../".$template."/fontfaces/$font_info[0]/",$match[0])."\n";
							}else{
								$fontface_css .= preg_replace("/url\s*\(\s*['|\"]\s*/is","\\0../fontfaces/$font_info[0]/",$match[0])."\n";
							}
						}
					}elseif(defined('THEME_CHILD_FONTFACE_DIR') && file_exists(THEME_CHILD_FONTFACE_DIR.'/'.$font_info[0].'/stylesheet.css')){
						$stylesheet = THEME_CHILD_FONTFACE_DIR.'/'.$font_info[0].'/stylesheet.css';
						$file_content = file_get_contents($stylesheet);
						if( preg_match("/@font-face\s*{[^}]*?font-family\s*:\s*('|\")$font_info[1]\\1.*?}/is", $file_content, $match) ){
							$fontface_css .= preg_replace("/url\s*\(\s*['|\"]\s*/is","\\0../fontfaces/$font_info[0]/",$match[0])."\n";
						}
					}

					if($fontface_default == $font_str){
						$fontface_default_name = $font_name;
					}


				}
			}
		}
		
		if(isset($fontface_default_name)){
			$default_code =  <<<CSS
#site_name, #site_description, 
.kwick_title, .kwick_detail h3, 
#navigation a, 
.portfolio_title, 
.dropcap1, .dropcap2, .dropcap3, .dropcap4, 
h1,h2,h3,h4,h5,h6,
#feature h1, #introduce, 
#footer h3, #copyright{
	font-family: '{$fontface_default_name}';
}

CSS;
			$fontface_css .= $default_code;
		}
		$code = stripslashes(theme_get_option('font','fontface_code'));
		$fontface_css .= $code;
	}
	/* google font */
	
	$gfont_css = '';
	$used_gfont = theme_get_option('font','gfont_used');
	if(!empty($used_gfont)){
		$custom_code = stripslashes(theme_get_option('font','gfont_code'));
		$default = theme_get_option('font','gfont_default');
		if(in_array($default,$used_gfont)){
			$pos = strpos($default, ':');
			$font_weight = '';
			$font_style = '';
			if($pos !== false){
				$font_family = substr($default, 0, $pos);
				$font_variant = substr($default, $pos+1);
				$font_weight = "font-weight: ".str_replace('italic', '', $font_variant).";";
			}else{
				$font_family = $default;
			}
			
			if(strpos($default, 'italic') !== false ){
				$font_style = "font-style: italic;";
			}
			$gfont_css .=  <<<CSS
#site_name, #site_description, 
.kwick_title, .kwick_detail h3, 
#navigation a, 
.portfolio_title, 
.dropcap1, .dropcap2, .dropcap3, .dropcap4, 
h1,h2,h3,h4,h5,h6,
#feature h1, #introduce, 
#footer h3, #copyright{
	font-family: '{$font_family}';
	{$font_weight}
	{$font_style}
}
CSS;
		}
		$gfont_css .= $custom_code;
	}
	
	/* color settings */
	$color = theme_get_option('color');
	if($color['menu_sub_current']==''){
		$color['menu_sub_current']=$color['menu_sub'];
	}
	if($color['menu_sub_current_background']==''){
		$color['menu_sub_current_background']=$color['menu_sub_background'];
	}
	if($color['page_h1']==''){
		$color['page_h1']=$color['page_header'];
	}
	if($color['page_h2']==''){
		$color['page_h2']=$color['page_header'];
	}
	if($color['page_h3']==''){
		$color['page_h3']=$color['page_header'];
	}
	if($color['page_h4']==''){
		$color['page_h4']=$color['page_header'];
	}
	if($color['page_h5']==''){
		$color['page_h5']=$color['page_header'];
	}
	if($color['page_h6']==''){
		$color['page_h6']=$color['page_header'];
	}
	// menu settings
	$menu_css = '';
	if($color['menu_top_active_background']){
		$menu_css .= <<<CSS
#navigation .menu > li.hover > a,
#navigation .menu > li.hover > a:active,
#navigation .menu > li.hover > a:visited {
	background-color: {$color['menu_top_active_background']};
	color: {$color['menu_top_active']}
}
CSS;
	}else{
$menu_css .= <<<CSS
#navigation .menu > li.hover > a,
#navigation .menu > li.hover > a:active,
#navigation .menu > li.hover > a:visited {
	color: {$color['menu_top_active']}
}
CSS;
	}
	if(empty($color['menu_top_current_background']) && !empty($color['menu_top_active_background']) ){
		if(empty($color['menu_top_background'])){
			$color['menu_top_current_background'] = 'transparent';
		}else{
			$color['menu_top_current_background'] = $color['menu_top_background'];
		}
	}
	if($color['menu_top_current_background']){
		$menu_css .= <<<CSS
#navigation .menu > li.current-menu-item > a,
#navigation .menu > li.current-menu-item > a:visited,
#navigation .menu > li.current-menu-ancestor > a,
#navigation .menu > li.current-menu-ancestor > a:visited,
#navigation .menu > li.current_page_item > a,
#navigation .menu > li.current_page_item > a:visited,
#navigation .menu > li.current_page_ancestor > a,
#navigation .menu > li.current_page_ancestor > a:visited,
#navigation .menu > li.current_page_parent > a,
#navigation .menu > li.current_page_parent > a:visited,
#navigation .menu > li.current-page-item > a,
#navigation .menu > li.current-page-item > a:visited,
#navigation .menu > li.current-page-ancestor > a,
#navigation .menu > li.current-page-ancestor > a:visited {
	color: {$color['menu_top_current']};
	background-color: {$color['menu_top_current_background']};
}
CSS;
	}else{
		$menu_css .= <<<CSS
#navigation .menu > li.current-menu-item > a,
#navigation .menu > li.current-menu-item > a:visited,
#navigation .menu > li.current-menu_item > a,
#navigation .menu > li.current-menu_item > a:visited,
#navigation .menu > li.current-menu-ancestor > a,
#navigation .menu > li.current-menu-ancestor > a:visited,
#navigation .menu > li.current_page_item > a,
#navigation .menu > li.current_page_item > a:visited,
#navigation .menu > li.current_page_ancestor > a,
#navigation .menu > li.current_page_ancestor > a:visited,
#navigation .menu > li.current-page-item > a ,
#navigation .menu > li.current-page-item > a:visited,
#navigation .menu > li.current-page-ancestor > a,
#navigation .menu > li.current-page-ancestor > a:visited {
	color: {$color['menu_top_current']};
}
CSS;
	}
	$nav_button = theme_get_option('general','nav_button');
	if($nav_button){
		$menu_css .= <<<CSS
#navigation > ul > li {
	height: 60px;
}
#navigation > ul > li > a {
	height:auto;
	line-height: 100%;
	padding: 10px 15px;
	margin: 10px 5px 0 0;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
CSS;
	}
	foreach($color as $key => $value){
		if($value == ''){
			$color[$key]='transparent';
		}
	}
	if(theme_get_option('general','nav_arrow')){
		$menu_css .= <<<CSS
#navigation > ul > li.has-children > a:after {
	content: ' ';
	display: inline-block;
	width: 0;
	height: 0;
	margin-left: 0.5em;
	border-left: 4px solid transparent;
	border-right: 4px solid transparent;
	border-top: 5px solid {$color['menu_top']};
	border-bottom: 2px solid transparent;
}
#navigation > ul > li.has-children.current-menu-item > a:after,
#navigation > ul > li.has-children.current-menu-ancestor > a:after,
#navigation > ul > li.has-children.current-page-item > a:after,
#navigation > ul > li.has-children.current-page-ancestor > a:after,
#navigation > ul > li.has-children.current_page_item > a:after,
#navigation > ul > li.has-children.current_page_ancestor > a:after,
#navigation > ul > li.has-children.current_page_parent > a:after {
	border-top-color: {$color['menu_top_current']};
}
#navigation > ul > li.has-children.hover > a:after {
	border-top-color: {$color['menu_top_active']};
}
#navigation ul .hover ul .has-children > a:after {
	content: ' ';
	display: inline-block;
	width: 0;
	height: 0;
	float: right;
	margin-top: 6px;
	border-top: 5px solid transparent;
	border-bottom: 5px solid transparent;
	border-left: 5px solid {$color['menu_sub']};
}
#navigation ul ul li.has-children.current-menu-item > a:after,
#navigation ul ul li.has-children.current-menu-ancestor > a:after,
#navigation ul ul li.has-children.current-page-item > a:after,
#navigation ul ul li.has-children.current-page-ancestor > a:after
#navigation ul ul li.has-children.current_page_item > a:after,
#navigation ul ul li.has-children.current_page_ancestor > a:after ,
#navigation ul ul li.has-children.current_page_parent > a:after {
	border-left-color: {$color['menu_sub_current']};
}
#navigation ul ul li.has-children a:hover:after {
	border-left-color: {$color['menu_sub_active']};
}
CSS;
	}

	/* background settings */
	$background = theme_get_option('background');
	if(!empty($background['header_image'])){
		$background['header_image'] = theme_get_image_src($background['header_image']);
		$header_image = <<<CSS
	background-image: url('{$background['header_image']}');
	background-repeat: {$background['header_repeat']};
	background-position: {$background['header_position_x']} {$background['header_position_y']};
	background-attachment: {$background['header_attachment']};
CSS;
	}else{
		$header_image = '';
	}
	if(!empty($background['feature_image'])){
		$background['feature_image'] = theme_get_image_src($background['feature_image']);
		$feature_image = <<<CSS
	background-image: url('{$background['feature_image']}');
	background-repeat: {$background['feature_repeat']};
	background-position: {$background['feature_position_x']} {$background['feature_position_y']};
	background-attachment: {$background['feature_attachment']};
CSS;
	}else{
		$feature_image = '';
	}
	if(!empty($background['page_image'])){
		$background['page_image'] = theme_get_image_src($background['page_image']);
		$page_image = <<<CSS
	background-image: url('{$background['page_image']}');
	background-repeat: {$background['page_repeat']};
	background-position: {$background['page_position_x']} {$background['page_position_y']};
	background-attachment: {$background['page_attachment']};
CSS;
		$page_bottom_image = <<<CSS
#page_bottom{
	background:none;
}
CSS;
	}else{
		$page_image = '';
		$page_bottom_image = '';
	}
	if(!empty($background['footer_image'])){
		$background['footer_image'] = theme_get_image_src($background['footer_image']);
		$footer_image = <<<CSS
	background-image: url('{$background['footer_image']}');
	background-repeat: {$background['footer_repeat']};
	background-position: {$background['footer_position_x']} {$background['footer_position_y']};
	background-attachment: {$background['footer_attachment']};
CSS;
	}else{
		$footer_image = '';
	}
	
	if(theme_get_option('general','enable_box_layout')){
		$box_layout_css = <<<CSS
	margin:0 auto;
	width:1000px; 
	background-color: {$color['box_bg']};
CSS;
		if(!empty($background['box_image'])){
			$background['box_image'] = theme_get_image_src($background['box_image']);
			$box_layout_css .= <<<CSS
	background-image: url('{$background['box_image']}');
	background-repeat: {$background['box_repeat']};
	background-position: {$background['box_position_x']} {$background['box_position_y']};
	background-attachment: {$background['box_attachment']};
CSS;
		}
	}else{
		$box_layout_css = '';
	}

	/* slideshow settings */
	$nivo_height = theme_get_option('slideshow','nivo_height');
	$nivo_frame_height = $nivo_height - 1;
	$kwicks_height = theme_get_option('slideshow','kwicks_height');
	$kwicks_frame_height = $kwicks_height - 1;
	$anything_height = theme_get_option('slideshow','anything_height');
	$anything_caption_height = $anything_height - 30;
	
	/* blog settings */
	$posts_gap = theme_get_option('blog','posts_gap');
	$blog_left_image_width = theme_get_option('blog', 'left_width');
	$blog_left_image_height = theme_get_option('blog','left_height');
	$blog_left_image_shadow_width = $blog_left_image_width +2;
	$custom_css =  stripslashes(theme_get_option('general','custom_css'));
		
	
	return <<<CSS
body {
	font-family: {$font['font_family']};
	line-height: {$font['line_height']}px;
{$box_layout_css}
}
{$fontface_css}
{$gfont_css}
#header {
	height: {$header_height}px;
	background-color: {$color['header_bg']};
{$header_image}
}
#site_name {
	color: {$color['site_name']};
	font-size: {$font['site_name']}px;
}
#site_description {
	color: {$color['site_description']};
	font-size: {$font['site_description']}px;
}
#logo, #logo_text {
	bottom: {$logo_bottom}px;
}
{$menu_css}

#navigation .menu > li > a, #navigation .menu > li > a:visited {
	font-size: {$font['menu_top']}px;
	color: {$color['menu_top']};
	background-color: {$color['menu_top_background']};
}
#navigation ul li.hover ul li a, #navigation ul ul li a, #navigation ul ul li a:visited {
	font-size: {$font['menu_sub']}px;
	color: {$color['menu_sub']};
}
#navigation ul li ul {
	background-color: {$color['menu_sub_background']};
}
#navigation .sub-menu .current-menu-item > a,
#navigation .sub-menu .current-menu-item > a:visited,
#navigation .sub-menu .current-menu_item > a,
#navigation .sub-menu .current-menu_item > a:visited,
#navigation .sub-menu .current-menu-ancestor > a,
#navigation .sub-menu .current-menu-ancestor > a:visited,
#navigation .sub-menu .current-page-item > a,
#navigation .sub-menu .current-page-item > a:visited,
#navigation .sub-menu .current-page-ancestor > a,
#navigation .sub-menu .current-page-ancestor > a:visited,
#navigation .sub-menu .current_page_item > a,
#navigation .sub-menu .current_page_item > a:visited,
#navigation .sub-menu .current_page_ancestor > a,
#navigation .sub-menu .current_page_ancestor > a:visited  {
	color: {$color['menu_sub_current']};
	background-color: {$color['menu_sub_current_background']};
}
#navigation ul ul li a:hover, #navigation ul ul li a:active,
#navigation ul li.hover ul li a:hover, #navigation ul li.hover ul li a:active {
	color: {$color['menu_sub_active']} !important; 
}
#navigation ul li ul li a:hover, #navigation ul ul li a:hover {
	background-color: {$color['menu_sub_hover_background']} !important;
}
a:hover {
	text-decoration:{$font['link_underline']};
}
#feature {
	background-color: {$color['feature_bg']};
{$feature_image}
}
#feature h1 {
	font-size: {$font['feature_header']}px;
	color: {$color['feature_header']};
}
#introduce {
	font-size: {$font['feature_introduce']}px;
	color: {$color['feature_introduce']};
}
#introduce a {
	color: {$color['feature_introduce']};
}
#page {
	background-color: {$color['page_bg']};
{$page_image}
	color: {$color['page']};
	font-size: {$font['page']}px;
}
{$page_bottom_image}
.wp-pagenavi a:hover {
	font-size: {$font['pagenavi_hover']}px;
}
.wp-pagenavi span.current {
	font-size: {$font['pagenavi_current']}px;
}
ul.theme_mini_tabs li.current, ul.theme_mini_tabs li.current a {
	background-color: {$color['page_bg']};
}
.tabs_container .theme_panes {
	background-color: {$color['tab_content_bg']};
	color: {$color['tab_content_text']};
}
.divider.top a {
	background-color: {$color['page_bg']};
}
#breadcrumbs {
	font-size: {$font['breadcrumbs']}px;
}
#page h1,#page h2,#page h3,#page h4,#page h5,#page h6{
	color: {$color['page_header']};
}
#page h1 {
	color: {$color['page_h1']};
}
#page h2 {
	color: {$color['page_h2']};
}
#page h3 {
	color: {$color['page_h3']};
}
#page h4 {
	color: {$color['page_h4']};
}
#page h5 {
	color: {$color['page_h5']};
}
#page h6 {
	color: {$color['page_h6']};
}
#page a, #page a:visited {
	color: {$color['page_link']};
}
#page a:hover, #page a:active {
	color: {$color['page_link_active']};
}
#page h1 a,#page h1 a:visited,#page h1 a:hover,#page h1 a:active {
	color: {$color['page_h1']};
}
#page h2 a,#page h2 a:visited,#page h2 a:hover,#page h2 a:active {
	color: {$color['page_h2']};
}
#page h3 a,#page h3 a:visited,#page h3 a:hover,#page h3 a:active {
	color: {$color['page_h3']};
}
#page h4 a,#page h4 a:visited,#page h4 a:hover,#page h4 a:active {
	color: {$color['page_h4']};
}
#page h5 a,#page h5 a:visited,#page h5 a:hover,#page h5 a:active {
	color: {$color['page_h5']};
}
#page h6 a,#page h6 a:visited,#page h6 a:hover,#page h6 a:active {
	color: {$color['page_h6']};
}
#page .portfolios.sortable header a {
	background-color:{$color['portfolio_header_bg']};
	color:{$color['portfolio_header_text']};
}
#page .portfolios.sortable header a.current, #page .portfolios.sortable header a:hover {
	background-color:{$color['portfolio_header_active_bg']};
	color:{$color['portfolio_header_active_text']};
}
.portfolio_more_button .theme_button {
	background-color: {$color['portfolio_read_more_bg']};
}
.portfolio_more_button .theme_button span {
	color: {$color['portfolio_read_more_text']};
}
.portfolio_more_button .theme_button:hover, .portfolio_more_button .theme_button.hover {
	background-color: {$color['portfolio_read_more_active_bg']};
}
.portfolio_more_button .theme_button:hover span, .portfolio_more_button .theme_button.hover span {
	color: {$color['portfolio_read_more_active_text']};
}
#sidebar .widget a, #sidebar .widget a:visited {
	color: {$color['sidebar_link']};
}
#sidebar .widget a:hover, #sidebar .widget a:active {
	color: {$color['sidebar_link_active']};
}
#sidebar .widgettitle {
	color: {$color['widget_title']};
	font-size: {$font['widget_title']}px;
}
#breadcrumbs {
	color: {$color['breadcrumbs']};
}
#breadcrumbs a, #breadcrumbs a:visited {
	color: {$color['breadcrumbs_link']};
}
#breadcrumbs a:hover, #breadcrumbs a:active {
	color: {$color['breadcrumbs_active']};
}
.portfolio_title, #page .portfolio_title a, #page .portfolio_title a:visited {
	font-size: {$font['portfolio_title']}px;
	color: {$color['portfolio_title']};
}
.portfolio_desc {
	font-size: {$font['portfolio_desc']}px;
}
#footer {
	background-color:{$color['footer_bg']};
	color: {$color['footer_text']};
	font-size: {$font['footer_text']}px;
{$footer_image}
}
#footer .widget a, #footer .widget a:visited{
	color: {$color['footer_link']};
}
#footer .widget a:active, #footer .widget a:hover{
	color: {$color['footer_link_active']};
}
#footer h3.widgettitle {
	color: {$color['footer_title']};
	font-size: {$font['footer_title']}px;
}
#footer_bottom {
	background-color:{$color['sub_footer_bg']};
}
#copyright {
	color: {$color['copyright']};
	font-size: {$font['copyright']}px;
}
#footer_menu a {
	font-size: {$font['footer_menu']}px;
}
#footer_menu a, #footer_menu a:visited{
	color: {$color['footer_menu']};
}
#footer_menu a:hover, #footer_menu a:active {
	color: {$color['footer_menu_active']};
}
#footer_bottom a, #footer_bottom a:visited{
	color: {$color['footer_menu']};
}
#footer_bottom a:hover, #footer_bottom a:active {
	color: {$color['footer_menu_active']};
}
.entry_frame, .divider, .divider_line, .commentlist li,.entry .entry_meta,#sidebar .widget li,#sidebar .widget_pages ul ul,#about_the_author .author_content {
	border-color: {$color['divider_line']};
}
h1 {
	font-size: {$font['h1']}px;
}
h2 {
	font-size: {$font['h2']}px;
}
h3 {
	font-size: {$font['h3']}px;
}
h4 {
	font-size: {$font['h4']}px;
}
h5 {
	font-size: {$font['h5']}px;
}
h6 {
	font-size: {$font['h6']}px;
}
#nivo_slider_wrap, #nivo_slider_loading, #nivo_slider {
	height: {$nivo_height}px;
}
#nivo_slider_frame {
	height: {$nivo_frame_height}px;
}
#nivo_slider_loading {
	background-color: {$color['nivo_loading_bg']};
}
.nivo-caption {
	background-color: {$color['nivo_caption_bg']};
	color: {$color['nivo_caption_text']};
}
.slider_control_bg {
	background-color: {$color['nivo_caption_bg']};
}
#kwicks, #kwicks li {
	height: {$kwicks_height}px;
}
.kwick_frame,.kwick_last_frame {
	height: {$kwicks_frame_height}px;
}
ul.anythingBase li.panel, div.anythingSlider .anythingWindow {
	background-color: {$color['anything_bg']};
}
#anything_slider_loading {
	background-color: {$color['anything_loading_bg']};
}
#anything_slider_wrap, #anything_slider_loading, #anything_slider {
	height: {$anything_height}px;
}
#anything_slider p {
	font-size: {$font['anything_desc']}px;
}
.anything_caption h3 {
	font-size: {$font['anything_caption']}px;
}
#kwicks li .kwick_title {
	font-size: {$font['kwick_title']}px;
	color: {$color['accordion_caption']};
	background-color: {$color['accordion_caption_bg']};
}
#kwicks li .kwick_detail h3 {
	font-size: {$font['kwick_detail_header']}px;
	color: {$color['accordion_detail_header']};
}
#kwicks li .kwick_detail {
	font-size: {$font['kwick_desc']}px;
	color: {$color['accordion_detail']};
	background-color: {$color['accordion_detail_bg']};
}
.anything_caption {
	background-color: {$color['anything_caption_bg']};
}
.anything_caption h3 {
	color: {$color['anything_caption_header']} !important;
}
.anything_caption p {
	color: {$color['anything_caption']} !important;
}
.caption_left, .caption_right {
	height: {$anything_caption_height}px;
}
.entry {
	margin-bottom: {$posts_gap}px;
}
.entry_title {
	font-size: {$font['entry_title']}px;
}
.entry_left .entry_image .image_frame {
	width: {$blog_left_image_width}px;
	height: {$blog_left_image_height}px;
}
.entry_left .entry_image, .entry_left .entry_image .image_shadow {
	width: {$blog_left_image_shadow_width}px;
}
.read_more_link.theme_button {
	background-color: {$color['read_more_bg']};
}
.read_more_link.theme_button span {
	color: {$color['read_more_text']};
}
.read_more_link.theme_button:hover, .read_more_link.theme_button.hover {
	background-color: {$color['read_more_active_bg']};
}
.read_more_link.theme_button:hover span, .read_more_link.theme_button.hover span {
	color: {$color['read_more_active_text']};
}
#page .entry .entry_title a,
#page .entry .entry_title a:visited {
	color: {$color['entry_title']};
}
#page .entry .entry_title a:hover,
#page .entry .entry_title a:active {
	color: {$color['entry_title_active']};
}
#page .entry_meta a, #page .entry_meta a:visited {
	color: {$color['blog_meta_link']};
}
#page .entry_meta a:hover, #page .entry_meta a:active {
	color: {$color['blog_meta_link_active']};
}
ul.theme_tabs li a {
	background-color: {$color['tab_bg']};
}
#page ul.theme_tabs li a {
	color: {$color['tab_text']};
}
ul.theme_tabs li a.current {
	background-color: {$color['tab_current_bg']};
}
#page ul.theme_tabs li a.current {
	color: {$color['tab_current_text']}; 
}
ul.theme_mini_tabs li a {
	background-color: {$color['minitab_bg']};
}
#page ul.theme_mini_tabs li a {
	color: {$color['minitab_text']};
}
ul.theme_mini_tabs li a.current {
	background-color: {$color['minitab_current_bg']};
}
#page ul.theme_mini_tabs li a.current {
	color: {$color['minitab_current_text']}; 
}
.theme_accordion .theme_tab {
	background-color: {$color['accordion_bg']};
}
.theme_accordion .theme_tab a {
	color: {$color['accordion_text']} !important;
}
.theme_accordion .theme_tab.current {
	background-color: {$color['accordion_current_bg']};
}
.theme_accordion .theme_tab.current a {
	color: {$color['accordion_current_text']} !important;
}
#page input[type="text"],
#page input[type="password"],
#page input[type="email"],
#page input[type="file"],
#page input[type="datetime"],
#page input[type="datetime-local"],
#page input[type="date"],
#page input[type="month"],
#page input[type="time"],
#page input[type="week"],
#page input[type="number"],
#page input[type="url"],
#page input[type="search"],
#page input[type="tel"],
#page input[type="color"],
#page textarea {
	color: {$color['input_text']};
}
#footer input[type="text"],
#footer input[type="password"],
#footer input[type="email"],
#footer input[type="file"],
#footer input[type="datetime"],
#footer input[type="datetime-local"],
#footer input[type="date"],
#footer input[type="month"],
#footer input[type="time"],
#footer input[type="week"],
#footer input[type="number"],
#footer input[type="url"],
#footer input[type="search"],
#footer input[type="tel"],
#footer input[type="color"],
#footer textarea, 
#footer .text_input, 
#footer .textarea {
	color:  {$color['footer_text_field_color']};
}
{$custom_css}
CSS;
?>
