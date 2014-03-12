<?php
function theme_shortcode_button($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'id' => false,
		'class' => false,
		'size' => 'small',
		'link' => '',
		'linktarget' => '',
		'color' => 'gray',
		'bgcolor' => '',
		'width' => false,
		'textcolor' => '',
		'hoverbgcolor' => '',
		'hovertextcolor' => '',
		'full' => "false",
		'align' => false,
		'button' => "false",
		'nofollow' => "false",
	), $atts));
	$id = $id?' id="'.$id.'"':'';
	$full = ($full==="false")?'':' full';
	$color = $color?' '.$color:'';
	$class = $class?' '.$class:'';
	$link = $link?' href="'.$link.'"':'';
	$linktarget = $linktarget?' target="'.$linktarget.'"':'';
	
	$hoverbgcolor = $hoverbgcolor?($bgcolor?' data-bg="'.$bgcolor.'"':'').' data-hoverBg="'.$hoverbgcolor.'"':'';
	$hovertextcolor = $hovertextcolor?($textcolor?' data-color="'.$textcolor.'"':'').' data-hoverColor="'.$hovertextcolor.'"':'';
	
	$bgcolor = $bgcolor?' style="background-color:'.$bgcolor.'"':'';
	if($width){
		if(is_numeric($width)){
			$width = $width.'px';
		}
		$width = 'width:'.$width;
	}else{
		$width = '';
	}
	$textcolor = $textcolor?'color:'.$textcolor.';':'';
	
	if($align != 'center' && $align !== false){
		$aligncss = ' align'.$align;
	}else{
		$aligncss = '';
	}
	if($button == 'true'){
		$tag = 'button';
	}else{
		$tag = 'a';
	}
	if($nofollow == 'true'){
		$follow_tag = ' rel="nofollow"';
	}else{
		$follow_tag = '';
	}
	$content = '<'.$tag.$id.$link.$linktarget.$bgcolor.$hoverbgcolor.$hovertextcolor.' class="'.apply_filters( 'theme_css_class', 'button' ).' '.$size.$color.$full.$class.$aligncss.'"'.$follow_tag.'><span'.(($textcolor!==''||$width!='')?' style="'.$textcolor.$width.'"':'').'>' . trim($content) . '</span></'.$tag.'>';
	if($align === 'center'){
		return '<p class="center">'.$content.'</p>';
	}else{
		return $content;
	}
}
add_shortcode('button','theme_shortcode_button');