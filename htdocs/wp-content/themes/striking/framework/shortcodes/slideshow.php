<?php

function theme_shortcode_slideshow($atts, $content = null){
	if(isset($atts['type'])){
		switch($atts['type']){
			case 'nivo':
				return theme_slideshow_nivo($atts, $content);
				break;
			case 'anything':
				return theme_slideshow_anything($atts, $content);
				break;
		}
	}
	return '';
}
add_shortcode('slideshow', 'theme_shortcode_slideshow');

function theme_slideshow_nivo($atts, $content = null){
	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];
	extract(shortcode_atts(array(
		'align' => false,
		'number' => -1,
		'width' => '630',
		'height' => '300',
		'source' => '',
		'category' => '',
		'effect' => 'random',
		'slices' => '10',
		'boxCols' => '8',
		'boxRows' => '4',

		'animspeed' => '500',
		'pausetime' => '3000',
		'controlnav' => 'false',
		'controlnavhide' => 'false',
		'directionnav' => 'false',
		'directionnavhide' => 'false',
		'pauseonhover' => 'false',
		'randomstart' => 'false',
		'captionopacity' => '0.8',
		'caption' => 'false',
	), $atts));
	$align = $align?' align'.$align:'';
	
	$id = rand(1,1000);
	wp_print_scripts('jquery-nivo');
	
	if($controlnav==='true'){
		$controlnav = 'true';
	}else{
		$controlnav = 'false';
	}
	if($controlnavhide==='true'){
		$controlnavhide = 'true';
	}else{
		$controlnavhide = 'false';
	}
	if($directionnav==='true'){
		$directionnav = 'true';
	}else{
		$directionnav = 'false';
	}
	if($directionnavhide==='true'){
		$directionnavhide = 'true';
	}else{
		$directionnavhide = 'false';
	}
	if($pauseonhover==='true'){
		$pauseonhover = 'true';
	}else{
		$pauseonhover = 'false';
	}
	if($randomstart==='true'){
		$randomstart = 'true';
	}else{
		$randomstart = 'false';
	}
	
	/** fix **/
	if(!empty($category)){
		$source = '{s:'.$category.'}'; 
	}
	/** end fix **/
	
	$size[0]=$width;
	$size[1]=$height;
	
	$content = trim($content);
	$images = !empty($content)?preg_split("/(\r?\n)/", $content):'';
	
	if(!empty($images) && is_array($images)){
		$content = '';
		foreach($images as $image){
			$image_source = array(
				'type'=>'src',
				'value' => trim(strip_tags($image))
			);
			if(!empty($image_source['value'])){
				$content .= '<img src="' . theme_get_image_src($image_source, array($width, $height)) . '" width="'.$width.'" height="'.$height.'" title="" alt="" />';
			}
		}
	}
	
	if(!empty($source)){
		if($number != '-1'){
			if(!empty($images)){
				$number = $number - count($images);
			}
		}
		$images = slideshow_generator('get_images',$source,$number,'full');
		foreach($images as $image) {
			if($image['link'] != false){
				$content .= '<a href="'.$image['link'].'" target="'.$image['target'].'">';
			}
			if($caption == 'true'){
				$content .= '<img src="' . theme_get_image_src($image['source'], array($width, $height))  . '" width="'.$width.'" height="'.$height.'" title="'.esc_attr($image['title']).'" alt="'.esc_attr($image['title']).'" />';
			}else{
				$content .= '<img src="' . theme_get_image_src($image['source'], array($width, $height))  . '" width="'.$width.'" height="'.$height.'" title="" alt="'.esc_attr($image['title']).'" />';
			}
			if($image['link'] != false){
				$content .= '</a>';
			}
		}
	}
	$wp_filter['the_content'] = $the_content_filter_backup;
	return <<<HTML
[raw]
<script type="text/javascript">
jQuery(document).ready(function($) {
	var slider = $('#nivo_slider_{$id}');
	slider.nivoSlider({
        effect:'{$effect}',
        slices:{$slices}, 
        boxCols: {$boxCols},
        boxRows: {$boxRows},
        animSpeed:'{$animspeed}',
        pauseTime:'{$pausetime}',
        startSlide:0, 
        directionNav:{$directionnav},
        controlNav:{$controlnav},
		randomStart:{$randomstart}, 
        controlNavThumbs:false, 
        keyboardNav:false,
        pauseOnHover:{$pauseonhover}, 
        manualAdvance:false
    });
	slider.find('.nivo-caption').each(function(){
		jQuery(this).css('opacity', {$captionopacity});
		if({$controlnav}){
			jQuery(this).css({
				paddingRight: slider.find('.nivo-controlNav').width() + 20
			});
		}
	});
	slider.find('.nivo-caption').css('opacity', {$captionopacity});

	if({$directionnavhide}){
		slider.find('.nivo-directionNav').hide();
	}
	if({$controlnavhide}){
		slider.find('.nivo-controlNav').hide();
	}
	slider.hover(function(){
		if({$directionnavhide}){
			slider.find('.nivo-directionNav').show();
		}
		if({$controlnavhide}){
			slider.find('.nivo-controlNav').show();
		}
	}, function(){
		if({$directionnavhide}){
			slider.find('.nivo-directionNav').hide();
		}
		if({$controlnavhide}){
			slider.find('.nivo-controlNav').hide();
		}
	});	
});
</script>
<style type="text/css">
#nivo_slider_{$id} {
	width: {$width}px;
	height: {$height}px;
}
</style>
[/raw]
<div id="nivo_slider_{$id}" class="nivoslider_wrap{$align}">{$content}</div>
HTML;
}

function theme_slideshow_anything($atts, $content = null){
	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];
	extract(shortcode_atts(array(
		'align' => false,
		'number' => -1,
		'width' => '630',
		'height' => '300',
		'source' => '',
		
		'easing' => 'swing',
		'buildarrows' => 'true', 
		'buildnavigation' => 'true', 
		
		'togglearrows' => 'false', 
		'togglecontrols' => 'false', 
		
		// Function
		"enablearrows" => 'true', 
		"enablenavigation" => 'true', 
		"enablekeyboard" => 'true', 
		
		// Slideshow options
		'autoplay' => 'true', 
		'autoplaylocked' => 'true', 
		'autoplaydelayed' => 'false', 
		'pauseonhover' => 'true', 
		'stopatend' => 'false',
		'playrtl' => 'false',
		
		'delay' => '3500',
		'resumedelay' => '3000',
		'animationtime' => '500',
		
		'resumeonvideoend' => 'true',
		'captionopacity' => '0.8',
	), $atts));
	$align = $align?' align'.$align:'';
	$class = array();
	if($align){
		$class[] = $align;
	}
	$id = rand(1,1000);
	wp_print_scripts('jquery-anything');
	wp_print_scripts('jquery-anything-video');
	
	$size[0]=$width;
	$size[1]=$height;
		
	$content = trim($content);
	$images = !empty($content)?preg_split("/(\r?\n)/", $content):'';
	
	/****/
	$caption_width = $width-40;
	$caption_side_width = floor($width*0.25);
	$caption_height = $height-30;
	$sidebar_width = floor(($width-60) * 0.3);
	$sidebar_image_width = $width - 60 - $sidebar_width;
	
	
	if($buildnavigation=='true') {
		$class[]='show_control';
	}
	/****/
	
	$content = '';
	if(!empty($images) && is_array($images)){
		
		foreach($images as $image){
			$image_source = array(
				'type'=>'src',
				'value' => trim(strip_tags($image))
			);
			if(!empty($image_source['value'])){
				$content .= '<li class="panel"><img src="' . theme_get_image_src($image_source, array($width, $height))  . '" width="'.$width.'" height="'.$height.'" title="" alt="" /></li>';
			}
		}
	}
	
	if(!empty($source)){
		if($number != '-1'){
			if(!empty($images)){
				$number = $number - count($images);
			}
		}
		$images = slideshow_generator('get_images',$source,$number,'full');
		
		foreach($images as $image) {
			$bg = '';
			if($image['type'] !== 'slideshow'){
				$type = 'image';
			} else {
				$type = get_post_meta($image['post_id'], '_anything_type', true);
			
				$bg = get_post_meta($image['post_id'], '_anything_bg', true);
				if($bg != ''){
					$bg = " style='background-color:".$bg."'";
				}
			}
			
			$content .=  "<li class='panel'".$bg.">";
			
			switch($type){
				case 'sidebar':
					$image_src = theme_get_image_src($image['source'], array($sidebar_image_width, $height));
					$content .=  '<div class="anything_sidebar_'.get_post_meta($image['post_id'], '_sidebar_position', true).'">';
					$content .=  '<div class="anything_sidebar_content">';
					$page_data = get_page( $image['post_id'] );
					$post_content = $page_data->post_content; 
					$content .=  apply_filters('the_content', stripslashes( $post_content ));
					$content .=  '</div>';
					$content .=  '<div class="anything_sidebar_image">';
					if($image['link'] != false){
						$content .=  '<a href="'.$image['link'].'" target="'.$image['target'].'"><img class="slideimage" src="' . $image_src.'" width="'.$sidebar_image_width.'" height="'.$height.'" alt="'.esc_attr($image['title']).'" /></a>';
					}else{
						$content .=  '<img class="slideimage" src="' . $image_src .'" width="'.$sidebar_image_width.'" height="'.$height.'" alt="'.esc_attr($image['title']).'" />';
					}
					$content .=  '</div>';
					$content .=  '</div>';
					break;
				case 'html':
					$page_data = get_page( $image['post_id'] );
					$post_content = $page_data->post_content; 
					$content .=  apply_filters('the_content', stripslashes( $post_content ));
					break;
				case 'image':
				default:
					$image_src = theme_get_image_src($image['source'], array($width, $height));
					if($image['type'] !== 'slideshow'){
						$caption_position = theme_get_option('slideshow','anything_postsCaptionPosition');
					}else{
						$caption_position = get_post_meta($image['post_id'], '_image_caption_position', true);
					}
					$caption_bg = get_post_meta($image['post_id'], '_anything_caption_bg', true);
					if($caption_bg != ''){
						$caption_bg = ';background-color:'.$caption_bg.'"';
					}
					if($image['link'] != false){
						if($caption_position != '' && $caption_position !='disable'){
							$content .=  '<a href="'.$image['link'].'" target="'.$image['target'].'" class="anything_caption caption_'.$caption_position.'" style="opacity:'.$captionopacity.$caption_bg.'">';
							$content .=  '<h3>'.$image['title'].'</h3>';
							if($image['desc']){
								$content .=  '<p>'.$image['desc'].'</p>';
							}
							$content .=  '</a>';
						}
						$content .=  '<a href="'.$image['link'].'" target="'.$image['target'].'"><img class="slideimage" src="' . $image_src .'" alt="'.$image['title'].'" /></a>';
					}else{
						if($caption_position != '' && $caption_position !='disable'){
							$content .=  '<div class="anything_caption caption_'.$caption_position.'" style="opacity:'.$captionopacity.$caption_bg.'">';
							$content .=  '<h3>'.$image['title'].'</h3>';
							if($image['desc']){
								$content .=  '<p>'.$image['desc'].'</p>';
							}
							$content .=  '</div>';
						}
						$content .= '<img class="slideimage" src="' . $image_src .'" alt="'.$image['title'].'" />';
					}
					break;
			}
			$content .= "</li>";
		}
	}
	if(empty($class)){
		$classes = '';
	}else{
		$classes = 'class="'.implode(" ",$class).'"';
	}
	$wp_filter['the_content'] = $the_content_filter_backup;
	return <<<HTML
[raw]
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#anything_slider_{$id} .anything_slider_wrap').anythingSlider({
		expand:false,
		resizeContents:true,
		showMultiple:false,
		easing:'{$easing}',
		buildArrows:{$buildarrows},
		buildNavigation:{$buildnavigation},
		buildStartStop:false,
		toggleArrows:{$togglearrows},
		toggleControls:{$togglecontrols},
		enableArrows:{$enablearrows},
		enableNavigation:{$enablenavigation},
		enableStartStop: false,
		enableKeyboard:{$enablekeyboard},
		startPanel:1,
		changeBy:1,
		hashTags:false,
		infiniteSlides: true,
		navigationFormatter : null,
		navigationSize : false,
		autoPlay:{$autoplay},
		autoPlayLocked:{$autoplaylocked},
		autoPlayDelayed:{$autoplaydelayed},
		pauseOnHover:{$pauseonhover},
		stopAtEnd:{$stopatend},
		playRtl:{$playrtl},
		delay:{$delay},
		resumeDelay:{$resumedelay},
		animationTime:{$animationtime},
		resumeOnVideoEnd:'{$resumeonvideoend}',
		addWmodeToObject: 'transparent'
	});
});
</script>
<style type="text/css">
#anything_slider_{$id} {
	width: {$width}px;
	height: {$height}px;
}
#anything_slider_{$id}.show_control {
	margin-bottom:40px;
}
#anything_slider_{$id}.show_control div.anythingSlider .anythingControls {
    outline: 0 none;
    padding-top: 10px;
}
#anything_slider_{$id} .anything_slider_wrap{
	width: {$width}px;
	height: {$height}px;
	position:relative;
	overflow:hidden;
	margin: 0;
	list-style:none;
}
#anything_slider_{$id} .anything_slider_wrap li.panel{
	margin:0;
}
#anything_slider_{$id} .caption_top, #anything_slider_{$id} .caption_bottom {
	width:{$caption_width}px;
}
#anything_slider_{$id} .anything_sidebar_content {
	width:{$sidebar_width}px;
}
#anything_slider_{$id} .anything_sidebar_image {
	width:{$sidebar_image_width}px;
}
#anything_slider_{$id} .caption_left, #anything_slider_{$id} .caption_right {
	height:{$caption_height}px;
	width:{$caption_side_width}px;
}
</style>
<div id="anything_slider_{$id}"{$classes}><ul class="anything_slider_wrap">{$content}</ul></div>
[/raw]
HTML;

}
