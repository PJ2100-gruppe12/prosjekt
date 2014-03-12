<?php
class slideshowGenerator {
	public $types = array(
		'nivo' => 'Theme_Slideshow_Nivo',
		'3d'  => 'Theme_Slideshow_3d',
		'kwicks' => 'Theme_Slideshow_Kwicks',
		'anything' => 'Theme_Slideshow_Anything',
	);

	public $instances = array();

	function render($type, $category = '', $color = '',$number ='-1',$text = false) {
		if($type == "3d"){
			require_once (THEME_PLUGINS . '/Browser.php');
			$browser = new Browser();
			if($browser->isMobile()){
				$type = theme_get_option('slideshow','3d_mobile');
			}
		}
		if(empty($number)){
			$number = '-1';
		}
		if(isset($this->instances[$type])){
			$slideshow = $this->instances[$type];
		}else{
			require_once (THEME_SLIDESHOW . '/'.$type.'.php');
			$slideshow = new $this->types[$type];
			$this->instances[$type] = $slideshow;
		}
		
		echo $slideshow->render($category,$color,$number,$text);
	}

	function header($type) {
		if($type == "3d"){
			require_once (THEME_PLUGINS . '/Browser.php');
			$browser = new Browser();
			if($browser->isMobile()){
				$type = theme_get_option('slideshow','3d_mobile');
			}
		}
		
		if(isset($this->instances[$type])){
			$slideshow = $this->instances[$type];
		}else{
			require_once (THEME_SLIDESHOW . '/'.$type.'.php');
			$slideshow = new $this->types[$type];
			$this->instances[$type] = $slideshow;
		}

		$slideshow->header();
	}

	function get_images($source_string='',$number='-1',$size=array(960,440)){
		$pattern = '/{([sbpg]):{0,1}([^}]+?){0,1}}/i';
		preg_match_all($pattern, $source_string, $match);
		$sources = array();
		if(empty($match[0])){
			$source_value = $source_string;
		}else{
			foreach($match[1] as $index => $cat){
				$sources[$cat] = $match[2][$index];
			}
		}
		$images = array();
		foreach($sources as $key=>$source_value){
			switch($key){
				case 'b':
					$query = array( 
						'post_type' => 'post', 
						'showposts'=>$number, 
						'orderby'=>'date', 
						'order'=>'DESC',
						'meta_key'=>'_thumbnail_id',
					);
					if(!empty($source_value)){
						$query['category_name'] = $source_value;
					}

					$loop = new WP_Query($query);
					$post_linkable = theme_get_option('slideshow','post_linkable');
					while ( $loop->have_posts() ) : $loop->the_post();
						$image_array = array(
							'source' => array(
								'type'=>'attachment_id',
								'value'=>get_post_thumbnail_id()
							),
							'type' => 'blog',
							'post_id'=> get_the_ID(),
							'title' => get_the_title(),
							'desc'  => get_the_excerpt(),
							'target' => '_self'
						);
						if($post_linkable){
							$image_array['link'] = get_permalink();
						}
						$images[] = $image_array;
					endwhile;
					break;
				case 'p':
					$query = array( 
						'post_type' => 'portfolio', 
						'showposts'=>$number, 
						'orderby'=>'menu_order', 
						'order'=>'ASC',
					);
					if(!empty($source_value)){
						global $wp_version;
						if(version_compare($wp_version, "3.1", '>=')){
							$query['tax_query'] = array(
								array(
									'taxonomy' => 'portfolio_category',
									'field' => 'slug',
									'terms' => explode(',', $source_value)
								)
							);
						}else{
							$query['taxonomy'] = 'portfolio_category';
							$query['term'] = $source_value;
						}
					}
					
					$loop = new WP_Query($query);
					$portfolio_linkable = theme_get_option('slideshow','portfolio_linkable');
					while ( $loop->have_posts() ) : $loop->the_post();
						$image_array = array(
							'source' => array(
								'type'=>'attachment_id',
								'value'=>get_post_thumbnail_id()
							),
							'type' => 'portfolio',
							'post_id'=> get_the_ID(),
							'title' => get_the_title(),
							'desc'  => get_the_excerpt(),
							'target' => '_self'
						);
						if($portfolio_linkable){
							$image_array['link'] = get_permalink();
						}
						$images[] = $image_array;
					endwhile;
					break;
				case 's':
					$query = array( 
						'post_type' => 'slideshow', 
						'showposts'=>$number, 
						'orderby'=>'menu_order', 
						'order'=>'ASC',
					);
					if(!empty($source_value)){
						global $wp_version;
						if(version_compare($wp_version, "3.1", '>=')){
							$query['tax_query'] = array(
								array(
									'taxonomy' => 'slideshow_category',
									'field' => 'slug',
									'terms' => explode(',', $source_value)
								)
							);
						}else{
							$query['taxonomy'] = 'slideshow_category';
							$query['term'] = $source_value;
						}
					}
					
					$loop = new WP_Query($query);
					
					while ( $loop->have_posts() ) : $loop->the_post();
						$link_to = get_post_meta(get_the_ID(), '_link_to', true);
						$link = theme_get_superlink($link_to);			
						$link_target = get_post_meta(get_the_ID(), '_link_target', true);

						$link_target = $link_target?$link_target:'_self';
						$caption = get_post_meta(get_the_ID(), '_caption', true);
						if(empty($caption)){
							$caption = get_the_title();
						}

						$images[] = array(
							'source' => array(
								'type'=>'attachment_id',
								'value'=>get_post_thumbnail_id()
							),
							'type' => 'slideshow',
							'post_id'=> get_the_ID(),
							'title' => $caption,
							'desc'  => get_post_meta(get_the_ID(), '_description', true),
							'link' => $link,
							'target' => $link_target
						);
					endwhile;
					break;
				case 'g':
					if($source_value==''){
						$post_id =  get_queried_object_id();
					}else{
						$post_id = $source_value;
					}
					$children = array(
						'post_parent' => $post_id,
						'post_status' => 'inherit',
						'post_type' => 'attachment',
						'post_mime_type' => 'image',
						'order' => 'ASC',
						'orderby' => 'menu_order ID',
						'numberposts' => -1,
						'offset' => ''
					);

					/* Get image attachments. If none, return. */
					$attachments = get_children( $children );
					foreach ( $attachments as $id => $attachment ) {
						$images[] = array(
							'source' => array(
								'type'=>'attachment_id',
								'value'=>$id
							),
							'type' => 'gallery',
							'post_id'=> $post_id,
							'title' => wptexturize( esc_html($attachment->post_excerpt) ),
							'desc'  => '',
							'src' => $img_src[0],
							'link' => '',
							'target' => '_self'
						);
					}
					break;
			}
		}
		wp_reset_query();
		if($number!='-1'){
			return array_slice($images, 0, $number);
		} else {
			return $images;
		}
	}
}
function slideshow_generator($function){
	global $_slideshowGenerator;
	$_slideshowGenerator = new slideshowGenerator;
	$args = array_slice( func_get_args(), 1 );
	return call_user_func_array(array( &$_slideshowGenerator, $function ), $args );
}