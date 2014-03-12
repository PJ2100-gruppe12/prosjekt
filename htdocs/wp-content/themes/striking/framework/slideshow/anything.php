<?php
class Theme_Slideshow_Anything {
	function header() {
		$move_bottom = theme_get_option('advanced','move_bottom');
		wp_enqueue_script('jquery-easing');
		wp_enqueue_script('jquery-anything');
		wp_enqueue_script('jquery-anything-video');
		wp_enqueue_script('anything-init', THEME_JS . '/anythingSliderInit.js',array('jquery'),false,$move_bottom);
	}

	function render($category='',$color='',$number='-1',$text = false) {
		if(!empty($color) && $color != "transparent"){
			$color = ' style="background-color:'.$color.'"';
		}else{
			$color = '';
		}
		if($text){
			$text = '<div id="introduce" class="slider_top">'.$text.'</div>';
		}else{
			$text = '';
		}
		$output =  <<<HTML

<div id="feature" class="anything"{$color}>
	<div class="top_shadow"></div>
	<div class="inner">{$text}
		<div id="anything_slider_wrap">
			<ul id="anything_slider">
HTML;
		
		$images = slideshow_generator('get_images',$category,$number,'full');
		$height = theme_get_option('slideshow','anything_height');
		
		foreach($images as $image) {
			$bg = '';
			if($image['type'] !== 'slideshow'){
				$type = 'image';
			}else{
				$bg = get_post_meta($image['post_id'], '_anything_bg', true);
				if($bg != ''){
					$bg = ' style="background-color:'.$bg.'"';
				}
				
				$type = get_post_meta($image['post_id'], '_anything_type', true);
			}
			
			$output .= "\n<li class='panel'".$bg.">\n";
			
			switch($type){
				case 'sidebar':
					$image_src = theme_get_image_src($image['source'], array(660, $height));
					$output .=  '<div class="anything_sidebar_'.get_post_meta($image['post_id'], '_sidebar_position', true).'">';
					$output .=  '<div class="anything_sidebar_content">';
					$page_data = get_page( $image['post_id'] );
					$content = $page_data->post_content; 
					$output .=  apply_filters('the_content', stripslashes( $content ));
					$output .=  '</div>';
					$output .=  '<div class="anything_sidebar_image">';
					if($image['link'] != false){
						$output .=  '<a href="'.$image['link'].'" target="'.$image['target'].'"><img class="slideimage" src="' . $image_src.'" width="660" height="'.$height.'" alt="'.$image['title'].'" /></a>';
					}else{
						$output .=  '<img class="slideimage" src="' . $image_src.'" width="660" height="'.$height.'" alt="'.$image['title'].'" />';
					}
					$output .=  '</div>';
					$output .=  '</div>';
					break;
				case 'html':
					$page_data = get_page( $image['post_id'] );
					$post_content = $page_data->post_content; 
					$output .=  apply_filters('the_content', stripslashes( $post_content ));
					break;
				case 'image':
				default:
					$image_src = theme_get_image_src($image['source'], array(960, $height));
					if($image['type'] !== 'slideshow'){
						$caption_position = theme_get_option('slideshow','anything_postsCaptionPosition');
					}else{
						$caption_position = get_post_meta($image['post_id'], '_image_caption_position', true);
					}
					$caption_bg = get_post_meta($image['post_id'], '_anything_caption_bg', true);
					if($caption_bg != ''){
						$caption_bg = ' style="background-color:'.$caption_bg.'"';
					}

					if($image['link'] != false){
						if($caption_position != '' && $caption_position !='disable'){
							$output .=  '<a href="'.$image['link'].'" target="'.$image['target'].'" class="anything_caption caption_'.$caption_position.'"'.$caption_bg.'>';
							$output .=  '<h3>'.$image['title'].'</h3>';
							if($image['desc']) $output .= '<p>'.$image['desc'].'</p>';
							$output .=  '</a>';
						}
						$output .=  '<a href="'.$image['link'].'" target="'.$image['target'].'"><img class="slideimage" src="' . $image_src.'" width="960" height="'.$height.'" alt="'.$image['title'].'" /></a>';
					}else{
						if($caption_position != '' && $caption_position !='disable'){
							$output .=  '<div class="anything_caption caption_'.$caption_position.'"'.$caption_bg.'>';
							$output .=  '<h3>'.$image['title'].'</h3>';
							if($image['desc']) $output .= '<p>'.$image['desc'].'</p>';
							$output .=  '</div>';
						}
						$output .=  '<img class="slideimage" src="' . $image_src .'" width="960" height="'.$height.'" alt="'.$image['title'].'" />';
					}
					break;
			}
			$output .=  "\n</li>\n";
		}
		$output .=  <<<HTML

			</ul>
		</div>
		<div id="anything_shadow"></div>
	</div>
	<div class="bottom_shadow"></div>
</div>
HTML;

		$options = array(
			'easing' => theme_get_option('slideshow', 'anything_easing'),
			
			'buildArrows' => theme_get_option('slideshow', 'anything_buildArrows'), 
			'buildNavigation' => theme_get_option('slideshow', 'anything_buildNavigation'), 
			
			'toggleArrows' => theme_get_option('slideshow', 'anything_toggleArrows'), 
			'toggleControls' => theme_get_option('slideshow', 'anything_toggleControls'), 
			
			// Function
			"enableArrows" => theme_get_option('slideshow', 'anything_enableArrows'), 
			"enableNavigation" => theme_get_option('slideshow', 'anything_enableNavigation'), 
			"enableKeyboard" => theme_get_option('slideshow', 'anything_enableKeyboard'), 
			
			// Slideshow options
			'autoPlay' => theme_get_option('slideshow', 'anything_autoPlay'), 
			'autoPlayLocked' => theme_get_option('slideshow', 'anything_autoPlayLocked'), 
			'autoPlayDelayed' => theme_get_option('slideshow', 'anything_autoPlayDelayed'), 
			'pauseOnHover' => theme_get_option('slideshow', 'anything_pauseOnHover'), 
			'stopAtEnd' => theme_get_option('slideshow', 'anything_stopAtEnd'),
			'playRtl' => theme_get_option('slideshow', 'anything_playRtl'),
			
			'delay' => theme_get_option('slideshow', 'anything_delay'),
			'resumeDelay' => theme_get_option('slideshow', 'anything_resumeDelay'),
			'animationTime' => theme_get_option('slideshow', 'anything_animationTime'),
			
			'resumeOnVideoEnd' => theme_get_option('slideshow', 'anything_resumeOnVideoEnd'),
			'resumeOnVisible' => theme_get_option('slideshow', 'anything_resumeOnVisible'),
			'captionOpacity' => theme_get_option('slideshow', 'anything_captionOpacity'),
		);
		
		$output .=  "\n<script type=\"text/javascript\">\n";
		$output .=  "var slideShow = []; \n";
		foreach($options as $key => $value) {
			if (is_bool($value)) {
				$value = $value ? "true" : "false";
			} elseif(is_numeric($value)){
				$value = $value;
			} elseif($value!="true"&&$value!="false") {
				$value = "'" . $value . "'";
			}
			$output .=  "slideShow['" . $key . "'] = " . $value . "; \n";
		}
		$output .=  "</script>\n";

		return $output;
	}
}