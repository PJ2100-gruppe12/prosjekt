<?php

add_shortcode('carousel', 'theme_shortcode_carousel');

function theme_shortcode_carousel($atts, $content=null){
	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];

	extract(shortcode_atts(array(
		'title' => false,
		'width' => '200',
		'height' => '150',
		'number' => -1,
		'autoplay'=>'true',
		'infinite' => 'true',
		'circular' => 'false',
		'delay' => '4000',
		'speed' => '1000',
		'direction' => 'right', // top, right, bottom, left
		'nav' => 'false',
		// 'mousewheel' => 'true',
		'touch' => 'true',
		'source' => '',
		'keyboard' => 'false',
		'lightbox' => 'false',
	), $atts));
	
	wp_enqueue_script( 'jquery-carousel');
	$output = '<ul>';
	$images = array();
	if(!empty($source)){
		$images = SlideshowGenerator::get_images($source,$number,'full');
	}

	if (preg_match_all("/(.?)\[(carousel_image)\b(.*?)(?:(\/))?\](?:(.+?)\[\/carousel_image\])?(.?)/s", $content, $matches)) {
		for($i = 0; $i < count($matches[0]); $i++) {
			$options = shortcode_parse_atts($matches[3][$i]);
			if(!isset($options['source_type']) || !isset($options['source_value'])){
				continue;
			}
			$image = array(
				'source' => array(
					'type' => $options['source_type'],
					'value' => $options['source_value'],
				)
			);

			if(isset($options['caption'])){
				$image['caption'] = $options['caption'];
			}
			if(isset($options['link'])){
				$image['link'] = $options['link'];
			}
			$images[] = $image;
		}
	}
	foreach ($images as $image) {
		$output .= '<li>';
		$image_src = theme_get_image_src($image['source'], array($width, $height));

		if(isset($image['caption'])){
			$caption = $image['caption'];
		} else {
			$caption = '';
		}
		$img = '<img src="'.$image_src.'" alt="'.$caption.'" />';

		if($lightbox === 'true'){
			
		}
		if($lightbox === 'true'){
			$output .= '<a class="fancybox" href="'.theme_get_image_src($image['source'], 'full').'" alt="'.$caption.'">'.$img.'</a>';
		}elseif(isset($image['link']) && !empty($image['link'])){
			$output .= '<a href="'.$image['link'].'" alt="'.$caption.'">'.$img.'</a>';
		} else {
			$output .= $img;
		}
		$output .= '</li>';
	}
	$output .= '</ul>';

	$heading = '';
	$title_html = '';
	$nav_html = '';
	if($title){
		$title_html = '<div class="carousel_title">'.$title.'</div>';
	}
	if($nav === 'true'){
		$nav_html = '<div class="carousel_nav"><a class="carousel_nav_prev" href="#"> </a><a class="carousel_nav_next" href="#"> </a></div>';
	}
	if($title_html || $nav_html){
		$heading = '<div class="carousel_heading">'.$title_html.$nav_html.'</div>';
	}
	$id = md5(serialize($output));

	$wp_filter['the_content'] = $the_content_filter_backup;
	return <<<HTML
<div class="carousel_wrap">{$heading}
<div id="carousel_{$id}" class="carousel">{$output}</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	var container = jQuery("#carousel_{$id}");

	container.imagesLoaded3(function(){
		container.carousel({
			autoplay: {$autoplay},
			infinite: {$infinite},
			circular: {$circular},
			delay: {$delay},
			speed: {$speed},
			direction: '{$direction}',
			nav: false,
			touch: {$touch},
			keyboard: {$keyboard},
			pager: false,
			responsive: true
		});
		container.parent().parent().find('.carousel_nav').each(function(){
			jQuery(this).find('.carousel_nav_prev').click(function(){
				container.carousel('prev');
				return false;
			});
			jQuery(this).find('.carousel_nav_next').click(function(){
				container.carousel('next');
				return false;
			});
		});
	});
});
</script>
</div>
HTML;
}

add_shortcode('product_carousel', 'theme_shortcode_product_carousel');

function theme_shortcode_product_carousel($atts, $content=null){
	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];

	extract(shortcode_atts(array(
		'title' => false,
		'width' => '200',
		'height' => '150',
		'number' => -1,
		'autoplay'=>'true',
		'infinite' => 'true',
		'circular' => 'false',
		'delay' => '4000',
		'speed' => '1000',
		'direction' => 'right', // top, right, bottom, left
		'nav' => 'false',
		// 'mousewheel' => 'true',
		'touch' => 'true',
		'post_type' => 'product',
		'taxonomy' => false,
		'terms' => false,
		'keyboard' => 'false',
	), $atts));
	
	wp_enqueue_script( 'jquery-carousel');

	$query = array(
		'posts_per_page' => (int)$number,
		'post_type'=>$post_type,
		'showposts' => $number
	);
	if($taxonomy && $terms){
		$query['tax_query'] = array(
			array(
				'taxonomy' => $taxonomy,
				'field' => 'slug',
				'terms' => explode(',',$terms)
			)
		);
	}

	$r = new WP_Query($query);

	$images = array();
	while ( $r->have_posts() ) : $r->the_post();
	$image_id = get_post_thumbnail_id();
	if(!empty($image_id)){
		$image_array = array(
			'source' => array(
				'type'=>'attachment_id',
				'value'=>$image_id
			),
			'type' => 'portfolio',
			'post_id'=> get_the_ID(),
			'title' => get_the_title(),
			'desc'  => get_the_excerpt(),
			'link' => get_permalink(),
			'target' => '_self'
		);
		$images[] = $image_array;
	}
	endwhile;

	$output = '<ul>';	
	foreach ($images as $image) {
		$output .= '<li>';
		$image_src = theme_get_image_src($image['source'], array($width, $height));

		if(isset($image['caption'])){
			$caption = $image['caption'];
		} else {
			$caption = '';
		}
		$img = '<img src="'.$image_src.'" alt="'.$caption.'" />';

		if(isset($image['link'])){
			$output .= '<a href="'.$image['link'].'" alt="'.$caption.'">'.$img.'</a>';
		} else {
			$output .= $img;
		}
		$output .= '</li>';
	}
	$output .= '</ul>';

	$heading = '';
	$title_html = '';
	$nav_html = '';
	if($title){
		$title_html = '<div class="carousel_title">'.$title.'</div>';
	}
	if($nav === 'true'){
		$nav_html = '<div class="carousel_nav"><a class="carousel_nav_prev" href="#"> </a><a class="carousel_nav_next" href="#"> </a></div>';
	}
	if($title_html || $nav_html){
		$heading = '<div class="carousel_heading">'.$title_html.$nav_html.'</div>';
	}
	$id = md5(serialize($output));

	$wp_filter['the_content'] = $the_content_filter_backup;
	return <<<HTML
<div class="carousel_wrap">{$heading}
<div id="carousel_{$id}" class="carousel">{$output}</div>
<script type="text/javascript">
jQuery(window).ready(function($) {
	var carousel = jQuery("#carousel_{$id}").carousel({
		autoplay: {$autoplay},
		infinite: {$infinite},
		circular: {$circular},
		delay: {$delay},
		speed: {$speed},
		direction: '{$direction}',
		nav: false,
		touch: {$touch},
		keyboard: {$keyboard},
		pager: false,
		responsive: true
	});
	carousel.parent().parent().find('.carousel_nav').each(function(){
		jQuery(this).find('.carousel_nav_prev').click(function(){
			carousel.carousel('prev');
			return false;
		});
		jQuery(this).find('.carousel_nav_next').click(function(){
			carousel.carousel('next');
			return false;
		});
	});
});
</script>
</div>
HTML;
}