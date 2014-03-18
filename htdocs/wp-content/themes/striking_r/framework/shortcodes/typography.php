<?php
function theme_shortcode_dropcaps($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'color' => '',
	), $atts));

	if($color){
		$color = ' '.$color;
	}
	return '<span class="' . $code.$color . '">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap1', 'theme_shortcode_dropcaps');
add_shortcode('dropcap2', 'theme_shortcode_dropcaps');
add_shortcode('dropcap3', 'theme_shortcode_dropcaps');
add_shortcode('dropcap4', 'theme_shortcode_dropcaps');

function theme_shortcode_dropcap($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'color' => '',
		'style' => 'dropcap1',
	), $atts));

	if($color){
		$color = ' '.$color;
	}
	return '<span class="' . $style.$color . '">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap', 'theme_shortcode_dropcap');

function theme_shortcode_blockquote($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'align' => false,
		'cite' => false,
	), $atts));
	
	return '<blockquote' . ($align ? ' class="align' . $align . '"' : '') . '>' . do_shortcode($content) . ($cite ? '<p><cite>- ' . $cite . '</cite></p>' : '') . '</blockquote>';
}
add_shortcode('blockquote', 'theme_shortcode_blockquote');

function theme_shortcode_highlight($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'type' => false,
	), $atts));

	return '<span class="highlight'.(($type)?' '.$type:'').'">'.do_shortcode($content).'</span>';
}
add_shortcode('highlight', 'theme_shortcode_highlight');

function theme_shortcode_progress($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'type' => '', //default, radius, round
		'size' => '',// default, small, large
		'barcolor' => '',
		'trackcolor' => '',
		'textcolor' => '',
		'percent' => '0',
		'text' => 'true',
	), $atts));

	if($type){
		$type = ' progress_'.$type;
	}
	if($size){
		$size = ' progress_'.$size;
	}
	if($barcolor){
		$barcolor = 'background-color:'.$barcolor.';';
	}
	if($textcolor){
		$textcolor = 'color:'.$textcolor;
	}
	if($trackcolor){
		$trackcolor = ' style="background-color:'.$trackcolor.'"';
	}
	if($text === 'true'){
		$text = $percent.'%';
	}else{
		$text = '';
	}

	return '<div class="progress'.$type.$size.'" data-meter="'.$percent.'"'.$trackcolor.'><span class="progress-meter" style="'.$barcolor.$textcolor.'">'.$text.'</span></div>';
}
add_shortcode('progress', 'theme_shortcode_progress');

function theme_shortcode_pie_progress($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'size' => '',// default, small, large
		'percent' => '0',
		'label' => 'percent', // percent, text, icon
		'text' => '',
		'icon' => '',
		'labelcolor' => '',
		'trackcolor' => '',
		'barcolor' => '',
	), $atts));

	if($size){
		$size = ' pie_progress_'.$size;
	}

	if($labelcolor){
		$labelcolor = ' style="color:'.$labelcolor.'"';
	}

	switch ($label) {
		case 'icon':
			$label_html = '<i class="pie_progress_icon icon-'.$icon.'"'.$labelcolor.'></i>';
			break;
		case 'text':
			$label_html = '<div class="pie_progress_text"'.$labelcolor.'>'.$text.'</div>';
			break;
		case 'percent':
			$label_html = '<span'.$labelcolor.'>'.$percent.'%'.'</span>';
			break;
		default:
			$label_html = '';
	}

	if($trackcolor) {
		$trackcolor = ' data-trackcolor="'.$trackcolor.'"';
	}
	if($barcolor) {
		$barcolor = ' data-barcolor="'.$barcolor.'"';
	}

	return '<div class="pie_progress_wrap'.$size.'"'.$trackcolor.$barcolor.'><div class="pie_progress" data-percent="'.$percent.'">'.$label_html.'</div></div>';
}
add_shortcode('pie_progress', 'theme_shortcode_pie_progress');


function theme_shortcode_list($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'style' => '',
		'color' => '',
		'icon'  => '',
	), $atts));

	if($icon){
		$style = '';
		$icon = 'list_'.$icon;
	}
	if($color){
		$color = ' list_color_'.$color;
	}
	return str_replace('<ul>', '<ul class="'.$style.$icon.$color.'">', do_shortcode(trim($content)));
}
add_shortcode('list', 'theme_shortcode_list');

function theme_shortcode_icon($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => false,
		'color' => '',
	), $atts));
	
	if($color){
		$color = ' '.$color;
	}
	return '<span class="icon_text icon_'.$style.$color.'">'.do_shortcode($content).'</span>';
}
add_shortcode('icon', 'theme_shortcode_icon');

function theme_shortcode_icon_link($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => false,
		'href' => '#',
		'color' => '',
		'target' => false,
	), $atts));
	
	if($color){
		$color = ' '.$color;
	}
	$target = $target?' target="'.$target.'"':'';
	
	if(preg_match("|^mailto:\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$|i", $href)){
		$href = str_replace('@','*',$href);
		$content = str_replace('@','*',$content);
	}
	
	return '<a class="icon_text icon_'.$style.$color.'" href="'.$href.'"'.$target.'>'.do_shortcode($content).'</a>';
}
add_shortcode('icon_link', 'theme_shortcode_icon_link');

function theme_shortcode_icon_font($atts){
	extract(shortcode_atts(array(
		'type' => false,
		'size' => false,// large, 2x, 3x, 4x
		'color' => '',
		'pull' => false,//left,right
		'border' => false,
		'spin'  => false,
		'rotate' => false, // 90, 180, 270, horizontal, vertical
	), $atts));

	$classes = array();

	if($color){
		$color_style = ' style="color:'.$color.'"';
	}else{
		$color_style = '';
	}

	if($type){
		$classes[] = 'icon-'.$type;
	}
	if($size){
		$classes[] = 'icon-'.$size;
	}
	if($pull){
		$classes[] = 'pull-'.$pull;
	}
	if($border == 'true'){
		$classes[] = 'icon-border';
	}
	if($spin == 'true'){
		$classes[] = 'icon-spin';
	}
	if($rotate){
		if(is_numeric($rotate)){
			$classes[] = 'icon-rotate-'.$rotate;
		} else {
			$classes[] = 'icon-flip-'.$rotate;
		}
	}

	return '<i class="'.implode(' ', $classes).'"'.$color_style.'></i>';
}
add_shortcode('icon_font', 'theme_shortcode_icon_font');

global $theme_code_token;
$theme_code_token = md5(uniqid(rand()));
$theme_code_matches = array();
function theme_code_before_filter($content) {
	return preg_replace_callback("/\[(pre|code)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\\1\])?/s", "theme_code_before_filter_callback", $content);
}

function theme_code_before_filter_callback(&$match) {
	global $theme_code_token, $theme_code_matches;
	$i = count($theme_code_matches);
	
	$theme_code_matches[$i] = $match;
	return "\n\n<p>" . $theme_code_token . sprintf("%03d", $i) . "</p>\n\n";
}

function theme_code_after_filter($content) {
	global $theme_code_token;
	
	$content = preg_replace_callback("/<p>\s*" . $theme_code_token . "(\d{3})\s*<\/p>/si", "theme_code_after_filter_callback", $content);
	
	return $content;
}

function theme_code_after_filter_callback($match) {
	global $theme_code_matches;
	$i = intval($match[1]);
	$content = $theme_code_matches[$i];
	$content[4]=trim($content[4]);
	
	if (version_compare(PHP_VERSION, '5.2.3') >= 0) {
		$output = htmlspecialchars($content[4], ENT_NOQUOTES, get_bloginfo('charset'), false);
	} else {
		$specialChars = array('&' => '&amp;', '<' => '&lt;', '>' => '&gt;');
		
		$output = strtr(htmlspecialchars_decode($content[4]), $specialChars);
	}
	return '<' . $content[1] . ' class="'. apply_filters( 'theme_css_class', $content[1] ) .'">' . $output . '</' . $content[1] . '>';
}

add_filter('the_content', 'theme_code_before_filter', 0);
add_filter('the_content', 'theme_code_after_filter', 999);


function theme_shortcode_responsive_text($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'compression' => '10',
		'max' => '',
		'min' => '',
		'lineheight' => '1',
		'fontsize' => ''
	), $atts));

	// wp_print_scripts('jquery-adaptText');

	$data_compression = '';
	if(is_numeric($compression)){
		$data_compression = ' data-compression="'.$compression.'"';
	}

	$data_max = '';
	if(!empty($max) && is_numeric($max)){
		$data_max = ' data-max="'.$max.'"';
	}

	$data_min = '';
	if(!empty($min) && is_numeric($min)){
		$data_min = ' data-min="'.$min.'"';
	}
	$styles = array();
	if(!empty($lineheight) && is_numeric($lineheight)){
		$styles[] = 'line-height:'.$lineheight.'em';
	}
	if(!empty($fontsize) && is_numeric($fontsize)){
		$styles[] = 'font-size:'.$fontsize.'px';
	}

	return '<p class="responsive_text"'.$data_compression.$data_max.$data_min.' style="'.implode(';', $styles).'">'.do_shortcode($content).'</p>';
}
add_shortcode('responsive_text', 'theme_shortcode_responsive_text');

function theme_shortcode_milestone($atts) {
	extract(shortcode_atts(array(
		'numberfrom' => '0',
		'number' => '',
		'subject' => '',
		'icon' => false,
		'subjectcolor'=> false,
		'iconcolor' => false,
		'numbercolor' => '',
		'size' => '', // default, small, large
	), $atts));

	if($icon) {
		if($iconcolor){
			$icon_color_style = ' style="color:'.$iconcolor.'"';
		} else {
			$icon_color_style = '';
		}
		$icon = '<i class="icon-'.$icon.'"'.$icon_color_style.'></i>';
		$icon_class = ' milestone_icon';
	}else {
		$icon = '';
		$icon_class = '';
	}
	if($numbercolor){
		$number_color_style = ' style="color:'.$numbercolor.'"';
	} else {
		$number_color_style = '';
	}
	if($subjectcolor){
		$subject_color_style = ' style="color:'.$subjectcolor.'"';
	} else {
		$subject_color_style = '';
	}
	if($size){
		$size_class = ' milestone_'.$size;
	} else {
		$size_class = '';
	}
	
	return '<div class="milestone'.$icon_class.$size_class.'">'.$icon.'<div class="milestone_number"'.$number_color_style.' data-from="'.$numberfrom.'" data-to="'.$number.'">'.$numberfrom.'</div><div class="milestone_subject"'.$subject_color_style.'>'.$subject.'</div></div>';
}
add_shortcode('milestone', 'theme_shortcode_milestone');