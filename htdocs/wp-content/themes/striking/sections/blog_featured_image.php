<?php
/**
 * The default template for displaying blog featured image in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_blog_featured_image($type='full',$layout='',$height='',$frame = false,$effect= '',$single = false){
	if (!has_post_thumbnail()){
		return '';
	}
	$image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(),'full', true);
	if($layout == 'full'){
		$width = 958;
	}elseif(is_numeric($layout)){
		$width = $layout-2;
	}else{
		$width = 628;
	}
	if(empty($effect)){
		$effect = theme_get_option('blog','effect');
	}
	if($frame && isset($width)){
		if($frame === true){
			$width = $width - 32;
		}else{
			$width = $width - $frame;
		}
		
	}
	if($type=='left' || $type=='right'){
		if(is_numeric($layout)){
			$width = $layout-2;
		}else{
			$width = theme_get_option('blog', 'left_width');
		}
		if($height == ''){
			$height = theme_get_option('blog', 'left_height');
		}
	}else{
		if(empty($height)){
			$adaptive_height = theme_get_option('blog', 'adaptive_height');
			if($adaptive_height && !empty($image_src_array[1])){
				$height = floor($width*($image_src_array[2]/$image_src_array[1]));
			}else{
				$height = theme_get_option('blog', 'fixed_height');
			}
		}
	}
	$image_src = theme_get_image_src(array('type'=>'attachment_id','value'=>get_post_thumbnail_id()), array($width, $height));
	$output = '';
	$output .= '<div class="image_styled entry_image"'.(($type=='left' || $type=='right')?' style="width:'.$width.'px"':'').'>';
	$output .= '<span class="image_frame effect-'.$effect.'" style="height:'.$height.'px;width:'.$width.'px">';
	if($single){
		if(theme_get_option('blog', 'featured_image_lightbox')){
			if(theme_get_option('blog', 'featured_image_lightbox_gallery')){
				$output .= '<a class="image_icon_zoom lightbox" href="'.$image_src_array[0].'" rel="post-'.get_queried_object_id().'" title="'.get_the_title().'">';
				$output .= '<img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" />';
				$output .= '</a>';

				$children = array(
					'post_parent' => get_queried_object_id(),
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
				if(!empty($attachments)){
					$output .= '<div class="hidden">';
					$post_thumbnail_id = get_post_thumbnail_id();
					foreach ( $attachments as $id => $attachment ) {
						$img_src = wp_get_attachment_image_src($id, 'full');
						if($id != $post_thumbnail_id){
						//$title = wptexturize( esc_html($attachment->post_excerpt) );
							$output .= '<a class="lightbox" href="'.$img_src[0].'" title="'.get_the_title().'" rel="post-'.get_queried_object_id().'">'.$id.'</a>';
						}
					}
					$output .= '</div>';
				}
			}else{
				$output .= '<a class="image_icon_zoom lightbox" href="'.$image_src_array[0].'" title="'.get_the_title().'">';
				$output .= '<img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" />';
				$output .= '</a>';
			}
		} else {
			if($effect!='none'){
				$output .= '<a class="image_icon_zoom" href="#" title="'.get_the_title().'"><img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" /></a>';
			}else{
				$output .= '<img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" />';
			}
		}
	} else {
		if(theme_get_option('blog', 'index_featured_image_lightbox')){
			$output .= '<a class="image_icon_zoom lightbox" href="'.$image_src_array[0].'" title="'.get_the_title().'">';
			$output .= '<img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" />';
			$output .= '</a>';
		} else {
			$output .= '<a class="image_icon_doc" href="'.get_permalink().'" title="">';
			$output .= '<img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" />';
			$output .= '</a>';
		}
		
	}
	$output .= '</span>';
	$output .= '<img src="'.THEME_IMAGES.'/image_shadow.png" class="image_shadow" width="'.($width+2).'" alt="" style="width:'.($width+2).'px">';
	$output .= '</div>';

	return $output;
}