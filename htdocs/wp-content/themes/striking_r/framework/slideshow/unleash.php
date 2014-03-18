<?php
class Theme_Slideshow_Unleash {
	public $add_script = false ;

	public function __construct(){
		add_action('wp_footer', array($this, 'header'));
	}
	public function header() {
		if($this->add_script){
			wp_enqueue_script('unleash-init');
			wp_enqueue_style('unleash-css');
		}
	}

	public function render($images, $options, $shortcode = false) {
		if(empty($images))
			return '';

		$this->add_script = true;

		$marginTop = 'padding-top:'.$options['marginTop'].'px;';
		$marginBottom = 'padding-bottom:'.$options['marginBottom'].'px;';
	
		$imagew = (int)$options['slide_width'];
		$imageh = (int)$options['slide_height'];

		$caption_css = $options['captionCss'];
		unset($options['captionCss']);

		$caption = $options['caption'];

		$options = htmlspecialchars(json_encode($options));

		$output = <<<HTML
<div class="unleash-slider-wrap" style="{$marginTop}{$marginBottom}">
<div class="unleash-slider-list" data-options='{$options}'>
HTML;

		$i = 1;
		foreach($images as $image) {

			$output .= '<div class="unleash-slider-item item-'.$i.'">';
			$image_src = theme_get_image_src($image['source'], array($imagew,$imageh));
			if($image['link'] != false){
				$output .= '<a href="'.$image['link'].'" target="'.$image['target'].'">'.'<img src="'.$image_src.'" alt="" />'.'</a>';
			} else {
				$output .= '<img src="'.$image_src.'" alt="" />';
			}
			$output .= '<img src="'.$image_src.'" alt="" />';
			$title = $caption?$image['title']:'';
			$desc = $caption?$image['desc']:'';
			if(!$caption ||(empty($title) && empty($desc))){
				$display_caption = ' unleash-caption-hidden';
			}else{
				$display_caption = '';
			}
			$output .= '<div class="unleash-slider-detail '.$caption_css.$display_caption.'">';

			if($image['link'] != false){
				$output .= '<h3 class="unleash-slider-caption"><a href="'.$image['link'].'" target="'.$image['target'].'">'.$title.'</a></h3>';
			}else{
				$output .= '<h3 class="unleash-slider-caption">'.$title.'</h3>';
			}
			$output .= empty($desc) ? '' : ('<div class="unleash-slider-desc">'.do_shortcode($desc).'</div>');
			$output .= '</div>';
			$output .= '</div>';
			$i++;
			
		}
		$output .= <<<HTML
</div>
</div>
HTML;
		return $output;
	}
}
