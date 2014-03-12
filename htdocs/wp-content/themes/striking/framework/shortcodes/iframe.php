<?php
function theme_shortcode_iframe($atts, $content = null) {
	extract(shortcode_atts(array(
		'width' => false,
		'height' => false,
		'src' => '',
	), $atts));
	
	$width = $width?' width="'.$width.'"':'';
	$height = $height?' height="'.$height.'"':'';
	
	return '<iframe src="'.$src.'"'.$width.$height.' seamless="seamless" frameborder="0"></iframe>';
}

add_shortcode('iframe','theme_shortcode_iframe');