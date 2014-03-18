<?php
/**
 * lightbox
 */
function theme_shortcode_lightbox($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'href' => '#',
		'title' => '',
		'group' => '',
		'width' => false,
		'height' => false,
		'iframe' => 'false',
		'inline' => 'false',
		'photo' => 'false',
		'close' => 'true',
		'fittoview' => 'true',
		'imagesource_type' => false,
		'imagesource_value' => false,
		'imageeffect' => 'icon',
		'imagewidth'  => false,
		'imageheight' => false,
		'imagealign'  => '',
		'imageicon' => false,
		'imagesize' => 'medium',
	), $atts));
	
	if($width){
		$width = ' data-width="'.$width.'"';
	}else{
		$width = '';
	}
	if($height){
		$height = ' data-height="'.$height.'"';
	}else{
		$height = '';
	}
	
	if($iframe != 'false'){
		$iframe = ' data-iframe="true"';
	}else{
		$iframe = ' data-iframe="false"';
	}
	if($inline != 'false'){
		$inline = ' data-inline="true" data-href="'.$href.'"';
		$href = '#';
	}else{
		$inline = ' data-inline="false"';
	}
	if($photo != 'false'){
		$photo = ' data-photo="true"';
	}else{
		$photo = ' data-photo="false"';
	}
	if($close != 'false'){
		$close = ' data-close="true"';
	}else{
		$close = ' data-close="false"';
	}
	if($fittoview != 'false'){
		$fittoview = ' data-fittoview="true"';
	}else{
		$fittoview = ' data-fittoview="false"';
	}
	$content = do_shortcode(str_replace('[button','[button button="true"',$content));
	
	if($imagesource_value){
		if(!$imagewidth){
			$imagewidth = theme_get_option('image', $imagesize.'_width');
			if(!$imagewidth){
				$imagewidth = '150';
			}
		}
		if(!$imageheight){
			$imageheight = theme_get_option('image', $imagesize.'_height');
			if(!$imageheight){
				$imageheight = '150';
			}
		}
		$image_src = theme_get_image_src(array('type'=>$imagesource_type,'value'=>$imagesource_value), array($imagewidth, $imageheight));
		if($imagesource_type == 'attachment_id'){
			$content = '<img alt="'.$title.'" src="'.$image_src.'" />';
		} else {
			$content = '<img alt="'.$title.'" src="'.$image_src.'" />';
		}
		
		return '<div class="image_styled'.($imagealign?' align'.$imagealign:'').'" style="width:'.($imagewidth+2).'px;"><span class="image_frame effect-'.$imageeffect.'" style="'.((empty($imageheight))?'':'height:'.($imageheight).'px').'"><a title="'.$title.'" href="'.$href.'"'.($group?' rel="'.$group.'"':'').' class="colorbox image_size_'.$imagesize.($imageicon?' image_icon_'.$imageicon:'').'"'.$width.$height.$iframe.$inline.$photo.$close.$fittoview.'>' . $content . '</a></span><img class="image_shadow" width="'.($imagewidth+2).'" src="'.THEME_IMAGES.'/image_shadow.png"/></div>';
	} else {
		return '<a title="'.$title.'" href="'.$href.'"'.($group?' rel="'.$group.'"':'').' class="colorbox"'.$width.$height.$iframe.$inline.$photo.$close.$fittoview.'>'.$content.'</a>';
	}
	
}

add_shortcode('lightbox', 'theme_shortcode_lightbox');