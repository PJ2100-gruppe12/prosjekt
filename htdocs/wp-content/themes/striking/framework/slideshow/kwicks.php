<?php
class Theme_Slideshow_Kwicks {
	function header() {
		$move_bottom = theme_get_option('advanced','move_bottom');
		wp_enqueue_script('jquery-easing');
		wp_enqueue_script('jquery-kwicks');
		wp_enqueue_script('kwicks-init', THEME_JS . '/kwicksSliderInit.js',array('jquery'),false,$move_bottom);
	}

	function render($category='',$color='',$number='-1',$text = false) {
		if(!empty($color) && $color != "transparent"){
			$color = ' style="background-color:'.$color.'"';
		}else{
			$color = '';
		}
		$options = array(
			'autoplay' => theme_get_option('slideshow', 'kwicks_autoplay'),
			'pauseTime' => theme_get_option('slideshow', 'kwicks_pauseTime'),
			'number' => theme_get_option('slideshow', 'kwicks_number'),
			'maxSize' => theme_get_option('slideshow', 'kwicks_max'),
			'duration' => theme_get_option('slideshow', 'kwicks_duration'),
			'easing' => theme_get_option('slideshow', 'kwicks_easing'),
			'title' => theme_get_option('slideshow', 'kwicks_title'),
			'title_speed' => theme_get_option('slideshow', 'kwicks_title_speed'),
			'title_opacity' => theme_get_option('slideshow', 'kwicks_title_opacity'),
			'detail' => theme_get_option('slideshow', 'kwicks_detail'),
			'detail_speed' => theme_get_option('slideshow', 'kwicks_detail_speed'),
			'detail_opacity' => theme_get_option('slideshow', 'kwicks_detail_opacity')
		);
		$height = theme_get_option('slideshow','kwicks_height');
		
		
		if($number > 8){
			$number = 8;
		}elseif($number < 2 && $number != -1){
			$number = 2;
		}elseif($number == -1){
			$number = -1;
		}
		
		$images = slideshow_generator('get_images',$category,$number,'full');
		
		$number = count($images);
		if($number > 8){
			$number = 8;
		}
		
		$images = array_splice($images, 0, $number);

		$options['number'] = $number;
		//$number = theme_get_option('slideshow', 'kwicks_number');
		//$number = $number ? $number : 4;
		if($text){
			$text = '<div id="introduce" class="slider_top">'.$text.'</div>';
		}else{
			$text = '';
		}
		$output = <<<HTML

<div id="feature" class="kwicks_slider"{$color}>
	<div class="top_shadow"></div>
		<div class="inner">{$text}
HTML;
		$output .= '<ul id="kwicks" class="kwicks-number-'.$number.'">';

		foreach($images as $image) {
			$image_src = theme_get_image_src($image['source'], array($options['maxSize'], $height));
			if($image['link'] != false){
				$link = $image['link'];
			}else{
				$link = '#';
			}
			$output .= "\n<li>";
			$output .= '<a href="'.$link.'" target="'.$image['target'].'"><img src="' . $image_src.'" width="'.$options['maxSize'].'" height="'.$height.'" alt="'.$image['title'].'" /></a>';
			$output .= '<div class="kwick_title">' . $image['title'] . '</div>';
			$output .= '<div class="kwick_detail"><h3>' . $image['title'] . '</h3><div class="kwick_desc">' . $image['desc'] . '</div></div>';
			$output .= "</li>";
		}
$output .= <<<HTML

			</ul>
			<div id="kwicks_shadow"></div>
		</div>
	<div class="bottom_shadow"></div>
</div>
HTML;
		
		$output .= "\n<script type=\"text/javascript\">\n";
		$output .= "var slideShow = []; \n";
		foreach($options as $key => $value) {
			if (is_bool($value)) {
				$value = $value ? "true" : "false";
			} else if (is_numeric($value)) {
			
			} else {
				$value = "'" . $value . "'";
			}
			$output .= "slideShow['" . $key . "'] = " . $value . "; \n";
		}
		$output .= "</script>\n";
		return $output;
	}
}