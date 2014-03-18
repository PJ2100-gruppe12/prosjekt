<?php

function theme_shortcode_message($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'align' => false,
		'class' => '',
	), $atts));
	if($class){
		$class = ' '.$class;
	}
	$align = $align?' '.$align:'';
	return '<div class="'.apply_filters( 'theme_css_class', $code ).$align.$class.'"><div class="message_box_content">'.do_shortcode(trim($content)).'<div class="message_box_space"></div></div></div>';
}

add_shortcode('info','theme_shortcode_message');
add_shortcode('success','theme_shortcode_message');
add_shortcode('error','theme_shortcode_message');
add_shortcode('error_msg','theme_shortcode_message');
add_shortcode('notice','theme_shortcode_message');


function theme_shortcode_framed_box($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'width' => '',
		'height' => '',
		'bgcolor' => '',
		'textcolor' => '',
		'bordercolor' => '',
		'borderthickness' => '1',
		'rounded' => 'false',
		'align' => false,
		'class' => '',
	), $atts));
	
	if($width){
		if(is_numeric($width)){
			$width = $width.'px';
		}
		$width = 'width:'.$width.';';
	}else{
		$width = '';
	}
	if($height){
		if(is_numeric($height)){
			$height = $height.'px';
		}
		$height = 'height:'.$height.';';
	}else{
		$height = '';
	}
	$bordercolor = $bordercolor?'border-color:'.$bordercolor.';':'';
	$borderthickness = $borderthickness !== '1'?'border-width:'.$borderthickness.'px;':'';
	if(!empty($width) || !empty($bordercolor) || !empty($borderthickness)){
		$style = ' style="'.$bordercolor.$width.$borderthickness.'"';
	}else{
		$style = '';
	}
	$align = $align?' align'.$align:'';
	if($class){
		$class = ' '.$class;
	}
	$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
	$textcolor = $textcolor?'color:'.$textcolor:'';

	$rounded = ($rounded == 'true')?' rounded':'';
	if( !empty($height) || !empty($bgcolor) || !empty($textcolor)){
		$content_style = ' style="'.$height.$bgcolor.$textcolor.'"';
	}else{
		$content_style = '';
	}
	$content = do_shortcode($content);
	if(!preg_match("/<[^>]*>/",$content)){
		$content = "<p>".trim($content)."</p>";
	}
	return '<div class="' .$code.$rounded.$align.$class. '"'.$style.'><div class="framed_box_content"'.$content_style.'>' . $content . '<div class="framed_box_space"></div></div></div>';
}
add_shortcode('framed_box','theme_shortcode_framed_box');


function theme_shortcode_content_box($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'width' => '',
		'height' => '',
		'titlebgcolor' => '',
		'titletextcolor' => '',
		'bgcolor' => '',
		'textcolor' => '',
		'rounded' => 'false',
		'align' => false,
		'class' => '',
		'icon' => false,
		'icon_color' => false,
		'title' => '',
	), $atts));
	if($icon) {
		if($icon_color){
			$icon_color_style = ' style="color:'.$icon_color.'"';
		} else {
			$icon_color_style = '';
		}
		$icon = '<i class="icon-'.$icon.'"'.$icon_color_style.'></i>';
	}else {
		$icon = '';
	}
	if($width){
		if(is_numeric($width)){
			$width = $width.'px';
		}
		$width = 'width:'.$width.';';
	}else{
		$width = '';
	}

	if(!empty($width)){
		$style = ' style="'.$width.'"';
	}else{
		$style = '';
	}
	$align = $align?' align'.$align:'';
	if($class){
		$class = ' '.$class;
	}

	$titlebgcolor = $titlebgcolor?'background-color:'.$titlebgcolor.';':'';
	$titletextcolor = $titletextcolor?'color:'.$titletextcolor:'';
	if( !empty($titlebgcolor) || !empty($titletextcolor)){
		$title_style = ' style="'.$titlebgcolor.$titletextcolor.'"';
	}else{
		$title_style = '';
	}

	if($height){
		if(is_numeric($height)){
			$height = $height.'px';
		}
		$height = 'height:'.$height.';';
	}else{
		$height = '';
	}

	$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
	$textcolor = $textcolor?'color:'.$textcolor:'';

	if( !empty($height) || !empty($bgcolor) || !empty($textcolor)){
		$content_style = ' style="'.$height.$bgcolor.$textcolor.'"';
	}else{
		$content_style = '';
	}
	$rounded = ($rounded == 'true')?' rounded':'';
	
	$content = do_shortcode($content);
	if(!preg_match("/<[^>]*>/",$content)){
		$content = "<p>".trim($content)."</p>";
	}
	return '<div class="' .$code.$rounded.$align.$class. '"'.$style.'><div class="content_box_title"'.$title_style.'>'.$icon.$title.'</div><div class="content_box_content"'.$content_style.'>' . $content . '<div class="content_box_space"></div></div></div>';
}
add_shortcode('content_box','theme_shortcode_content_box');

function theme_shortcode_note($atts, $content = null) {
	extract(shortcode_atts(array(
		'align' => false,
		'title' => '',
		'width' => false,
		'class' => '',
	), $atts));
	$align = $align?' align'.$align:'';
	if($class){
		$class = ' '.$class;
	}
	$width = $width?' style="width:'.(int)$width.'px"':'';
	if(!empty($title)){
		$title = '<h4 class="'.apply_filters( 'theme_css_class', 'note_title' ).'">'.$title.'</h4>';
	}

	return '<div class="'.apply_filters( 'theme_css_class', 'note' ).$align.$class.'"'.$width.'>'.$title.'<div class="'.apply_filters( 'theme_css_class', 'note_content' ).'">' . do_shortcode($content) . '</div></div>';
}
add_shortcode('note','theme_shortcode_note');

function theme_shortcode_slogan($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'size' => '',
		'color' => '',
		'class' => false,
		'buttontext' => '',
		'buttonlink' => '',
		'buttonlinktarget' => '',
		'buttoncolor' => '',
		'buttonbgcolor'=> '',
		'buttontextcolor' => '',
		'buttonhoverbgcolor' => '',
		'buttonhovertextcolor' => '',
		'buttonicon' => false,
		'buttoniconcolor' => false,
	), $atts));

	$class = $class?' '.$class:'';
	$color = $color?' style="color:'.$color.';"':'';

	$content = do_shortcode($content);

	if($size){
		$size = ' slogan_'.$size;
	}

	if($buttontext){
		$button = theme_shortcode_button(array(
			'link' => $buttonlink,
			'linktarget' => $buttonlinktarget,
			'color' => $buttoncolor,
			'size' => '',
			'bgcolor'=>$buttonbgcolor,
			'textcolor' => $buttontextcolor,
			'hoverbgcolor' => $buttonhoverbgcolor,
			'hovertextcolor' => $buttonhovertextcolor,
			'icon' => $buttonicon,
			'icon_color' => $buttoniconcolor,
		), $buttontext, 'button');

		return '<div class="slogan slogan_with_button'.$class.$size.'"><span class="slogan_text"'.$color.'>'.$content.'</span>'.$button.'</div>';
	} else {
		return '<div class="slogan'.$class.$size.'"><span class="slogan_text"'.$color.'>'.$content.'</span></div>';
	}	
}
add_shortcode('slogan', 'theme_shortcode_slogan');


function theme_shortcode_iconbox($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'type' => 'inline', // left, inline, center
		'title' => '',
		'class' => '',
		'icon' => '',
		'iconcolor' => false,
		'iconsize' => '', // default, small, large
	), $atts));

	if($class){
		$class = ' '.$class;
	}
	if($iconsize){
		$iconsize = ' iconbox_'.$iconsize;
	}

	if($iconcolor){
		$icon_color_style = ' style="color:'.$iconcolor.'"';
	} else {
		$icon_color_style = '';
	}
	$icon = '<i class="icon-'.$icon.'"'.$icon_color_style.'></i>';

	if($title) {
		$title = '<h4 class="iconbox-title">'.$title.'</h4>';
	}

	$content = do_shortcode($content);
	return '<div class="iconbox'.$class.$iconsize.' iconbox_'.$type.'"><span class="iconbox_icon">'.$icon.'</span><div class="iconbox_content">'.$title.$content.'</div></div>';
}
add_shortcode('iconbox', 'theme_shortcode_iconbox');

function theme_shortcode_process_steps($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'style' => false,
		'class' => '',
		'number' => 3,
		'type' => 'horizontal',
		'size' => '', // default, small, large
	), $atts));
	
	if (!preg_match_all("/(.?)\[(process_step)\b(.*?)(?:(\/))?\](?:(.+?)\[\/process_step\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		
		$output = '<ul>';
		
		for($i = 0; $i < count($matches[0]); $i++) {
			$options = $matches[3][$i];

			$output .= '<li>';
			if(isset($options['icon'])){
				if(isset($options['icon_color'])){
					$icon_color_style = ' style="color:'.$options['icon_color'].'"';
				} else {
					$icon_color_style = '';
				}
				$icon = '<i class="icon-'.$options['icon'].'"'.$icon_color_style.'></i>';
				
			} else {
				$icon = '';
			}

			if(isset($options['link'])){
				$output .= '<a class="process_step_icon" href="'.$options['link'].'" alt="">'.$icon.'</a>';
			} else {
				$output .= '<div class="process_step_icon">'.$icon.'</div>';
			}
			$output .= '<div class="process_step_detail">';
			if(isset($options['title'])){
				$output .= '<h3 class="process_step_title">'.$options['title'].'</h3>';
			}
			$output .= do_shortcode(trim($matches[5][$i]));
			$output .= '</div>';
			$output .= '</li>';
		}
		$output .= '</ul>';

		if($class){
			$class = ' '.$class;
		}
		if($size) {
			$size = ' process_steps_'.$size;
		}

		$number = ' process_steps_'.$number;

		$type = ' process_steps_'.$type;

		return '<div class="process_steps'.$class.$type.$size.$number.'">' . $output . '</div>';
	}
}
add_shortcode('process_steps', 'theme_shortcode_process_steps');