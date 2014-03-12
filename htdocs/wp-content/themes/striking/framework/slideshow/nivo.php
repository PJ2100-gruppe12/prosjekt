<?php
class Theme_Slideshow_Nivo {
	function header() {
		$move_bottom = theme_get_option('advanced','move_bottom');
		wp_enqueue_script('jquery-nivo');
		wp_enqueue_script('nivo-init', THEME_JS . '/nivoSliderInit.js',array('jquery'),false,$move_bottom);
	}

	function render($category='',$color='',$number='-1',$text = false) {
		if(!empty($color) && $color != "transparent"){
			$color = ' style="background-color:'.$color.'"';
		}else{
			$color = '';
		}
		$height = theme_get_option('slideshow','nivo_height');
		if($text){
			$text = '<div id="introduce" class="slider_top">'.$text.'</div>';
		}else{
			$text = '';
		}
		$output = <<<HTML
<div id="feature" class="nivo"{$color}>
	<div class="top_shadow"></div>
	<div class="inner">{$text}
		<div id="nivo_slider_wrap">
			<div id="nivo_slider">
HTML;

		$images = slideshow_generator('get_images',$category,$number,'full');
		
		$captions = theme_get_option('slideshow', 'nivo_captions');
		
		foreach($images as $image) {
			$title = $captions?$image['title']:'';

			$image_src = theme_get_image_src($image['source'], array(960, $height));
			if($image_src != ''){
				if($image['link'] != false){
					$output .= '<a href="'.$image['link'].'" target="'.$image['target'].'"><img src="' . $image_src . '" width="960" height="'.$height.'" title="'.$title.'" alt="'.$image['title'].'" /></a>';
				}else{
					$output .= '<img src="' . $image_src. '" width="960" height="'.$height.'" title="'.$title.'" alt="'.$image['title'].'" />';
				}
			}
		}
		$output .= <<<HTML

			</div>
		</div>
	</div>
	<div class="bottom_shadow"></div>
</div>
HTML;

		$options = array(
			'effect' => theme_get_option('slideshow', 'nivo_effect'), 
			'slices' => theme_get_option('slideshow', 'nivo_slices'), 
			'boxCols' => theme_get_option('slideshow', 'nivo_boxCols'), 
			'boxRows' => theme_get_option('slideshow', 'nivo_boxRows'), 
			'animSpeed' => theme_get_option('slideshow', 'nivo_animSpeed'), 
			'pauseTime' => theme_get_option('slideshow', 'nivo_pauseTime'), 
			'directionNav' => theme_get_option('slideshow', 'nivo_directionNav'), 
			'directionNavHide' => theme_get_option('slideshow', 'nivo_directionNavHide'), 
			'controlNav' => theme_get_option('slideshow', 'nivo_controlNav'), 
			'controlNavHide' => theme_get_option('slideshow', 'nivo_controlNavHide'), 
			'keyboardNav' => theme_get_option('slideshow', 'nivo_keyboardNav'), 
			'pauseOnHover' => theme_get_option('slideshow', 'nivo_pauseOnHover'), 
			'manualAdvance' => theme_get_option('slideshow', 'nivo_manualAdvance'),
			'randomStart' => theme_get_option('slideshow', 'nivo_randomStart'),
			'captions' => theme_get_option('slideshow', 'nivo_captions'),
			'captionOpacity' => theme_get_option('slideshow', 'nivo_captionOpacity'),
			'stopAtEnd' => theme_get_option('slideshow', 'nivo_stopAtEnd'),
		);
		
		$output .= "\n<script type=\"text/javascript\">\n";
		$output .= "var slideShow = []; \n";
		foreach($options as $key => $value) {
			if (is_bool($value)) {
				$value = $value ? "true" : "false";
			} elseif(is_numeric($value)){
				$value = $value;
			} elseif($value!="true"&&$value!="false") {
				$value = "'" . $value . "'";
			}
			$output .= "slideShow['" . $key . "'] = " . $value . "; \n";
		}
		$output .= "</script>\n";
		return $output;
	}
}