<?php
/**
 * The default template for displaying portfolio_featured_image in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_portfolio_featured_image($layout='',$effect= '', $single = false){
	if (!has_post_thumbnail()){
		return;
	}
	if($layout == 'full'){
		$width = 958;
	}else{
		$width = 628;
	}
	$image_src_array = wp_get_attachment_image_src(get_post_thumbnail_id(),'full', true);
	$adaptive_height = theme_get_option('portfolio', 'adaptive_height');

	if($adaptive_height){
		$height = floor($width*($image_src_array[2]/$image_src_array[1]));
	}else{
		$height = theme_get_option('portfolio', 'fixed_height');
	}
	$image_src = theme_get_image_src(array('type'=>'attachment_id','value'=>get_post_thumbnail_id()), array($width, $height));
	$output = '';
	if(empty($effect)){
		$effect = theme_get_option('blog','effect');
	}
	$output .= '<div class="image_styled entry_image">';
	$output .= '<span class="image_frame effect-'.$effect.'" style="height:'.$height.'px;width:'.$width.'px">';
	if($single){
		if(theme_get_option('portfolio', 'featured_image_lightbox')){
			if(theme_get_option('portfolio', 'featured_image_lightbox_gallery')){
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
				$output .= '<a class="image_icon_doc" href="#" title=""><img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" /></a>';
			}else{
				$output .= '<img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" />';
			}
		}
	} else {
		$output .= '<a class="image_icon_doc" href="'.get_permalink().'" title="">';
		$output .= '<img width="'.$width.'" height="'.$height.'" src="'.$image_src.'" alt="'.get_the_title().'" />';
		$output .= '</a>';
	}
	$output .= '</span>';
	$output .= '<img src="'.THEME_IMAGES.'/image_shadow.png" class="image_shadow" width="'.($width+2).'" alt="" style="width:'.($width+2).'px">';
	$output .= '</div>';

	return $output;
}