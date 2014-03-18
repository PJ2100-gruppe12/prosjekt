<?php
class Theme_Slideshow_Fotorama {
	public $add_script = false ;


	public function __construct(){
		add_action('wp_footer', array($this, 'header'));
	}
	
	public function header() {
		if($this->add_script){
			wp_enqueue_script('fotorama-init');
			wp_enqueue_style('fotorama-css');
		}
	}
	public function render($images, $options, $shortcode = false) {
		if(empty($images))
			return '';

		$this->add_script = true;

		if(!isset($options['width'])){
			$options['width'] = 960;
		}
		$width = (int)$options['width'];


		$slide_id = md5(serialize($images));
		$caption = $options['captions'];
		
		$data_options = '';
		foreach($options as $key=>$value){
			if($value === true){
				$value = 'true';
			}
			if($value === false){
				$value = 'false';
			}

			if(in_array($key, array('width','minwidth','height','minheight','maxheight','ratio')) && $value === 0){
				continue;
			}


			$data_options .= ' data-'.$key.'="'.$value.'"';
		}

		$output = <<<HTML
<div id="fotorama{$slide_id}" class="fotorama" data-width="100%" data-auto="false"{$data_options}>
HTML;
		$i = 1;
		foreach($images as $image) {
			
			$image_src = theme_get_image_src($image['source'], 'full');
			if($caption) {
				$output .= '<img src="'.$image_src.'" title="" alt="" data-caption="'.$image['title'].'" />';
			}else{
				$output .= '<img src="'.$image_src.'" title="" alt="" />';
			}
			$i++;
		}
		$output .= <<<HTML
</div>
HTML;
		return $output;
	}
}