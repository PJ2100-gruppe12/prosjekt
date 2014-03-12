<?php
/**
 * The default template for displaying portfolio lists in the pages
 *
 * @package Striking
 * @since Striking 5.2
 */
function theme_section_portfolio_list($options){
	global $wp_filter;
	$the_content_filter_backup = $wp_filter['the_content'];

	$options = shortcode_atts(array(
		'column' => 4,
		'layout' => 'full',//sidebar
		'cat' => '',
		'max' => -1,
		'title' => '',
		'titlelinkable' => 'false',
		'desc' => '',
		'desc_length'=>'default',
		'more' => '',
		'moretext' => '',
		'height' => '',
		"ajax" => 'false',
		'current' => '',
		'nopaging' => 'false',
		'sortable' => 'false',
		'group' => 'true',
		'lightboxtitle' => 'portfolio', //portfolio,image,imagecaption,imagedesc,none
		'advancedesc'=>'false',
		'effect' => 'default', //icon,grayscale,none
		'ids' => '',
		'order'=> 'ASC',
		'orderby'=> 'menu_order', //none, id, author, title, date, modified, parent, rand, comment_count, menu_order
		'paged' => null
	), $options);

	extract($options);
	if($desc_length != 'default'){
		$excerpt_constructor = new Theme_The_Excerpt_Length_Constructor($desc_length);
		add_filter( 'excerpt_length', array($excerpt_constructor,'get_length'));
	}
	$output = '<div class="portfolio_wrap">';
	$size = array();
	switch($column){
		case 1:
			$column_class = 'one_column';
			if($layout=='sidebar'){
				$size[0] = '400';
			}else{
				$size[0] = '600';
			}
			$size[1] = (int)theme_get_option('portfolio','1_column_height');
			break;
		case 2:
			$column_class = 'two_columns';
			if($layout=='sidebar'){
				$size[0] = '293';
			}else{
				$size[0] = '450';
			}
			$size[1] = (int)theme_get_option('portfolio','2_columns_height');
			break;
		case 3:
			$column_class = 'three_columns';
			if($layout=='sidebar'){
				$size[0] = '188';
			}else{
				$size[0] = '292';
			}
			$size[1] = (int)theme_get_option('portfolio','3_columns_height');
			break;
		case 5:
			$column_class = 'five_columns';
			if($layout=='sidebar'){
				$size[0] = '108';
			}else{
				$size[0] = '170';
			}
			$size[1] = (int)theme_get_option('portfolio','5_columns_height');
			break;
		case 6:
			$column_class = 'six_columns';
			if($layout=='sidebar'){
				$size[0] = '88';
			}else{
				$size[0] = '138';
			}
			$size[1] = (int)theme_get_option('portfolio','6_columns_height');
			break;
		case 7:
			$column_class = 'seven_columns';
			if($layout=='sidebar'){
				$size[0] = '70';
			}else{
				$size[0] = '118';
			}
			$size[1] = (int)theme_get_option('portfolio','7_columns_height');
			break;
		case 8:
			$column_class = 'eight_columns';
			if($layout=='sidebar'){
				$size[0] = '61';
			}else{
				$size[0] = '97';
			}
			$size[1] = (int)theme_get_option('portfolio','8_columns_height');
			break;
		case 4:
		default:
			$column_class = 'four_columns';
			if($layout=='sidebar'){
				$size[0] = '136';
			}else{
				$size[0] = '217';
			}
			$size[1] = (int)theme_get_option('portfolio','4_columns_height');
	}
	if($height){
		$size[1] = $height;
	}
	$rel_group = 'portfolio_'.rand(1,1000); //for lightbox group

	if($layout=='sidebar'){
		$output .= '<ul class="portfolio_' . $column_class . ' with_sidebar portfolio_container">';
	}else{
		$output .= '<ul class="portfolio_' . $column_class . ' portfolio_container">';
	}

	if ($nopaging == 'false') {
		if(is_null($paged)){
			global $wp_version;
			if(is_front_page() && version_compare($wp_version, "3.1", '>=')){//fix wordpress 3.1 paged query
				$paged = (get_query_var('paged')) ?get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
			}else{
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			}
		}
		
		$query = array(
			'post_type' => 'portfolio', 
			'posts_per_page' => $max, 
			'paged' => $paged,
			'orderby'=> $orderby, 
			'order'=> $order
		);
	} else {
		$query = array(
			'post_type' => 'portfolio', 
			'showposts' => $max,
			'orderby'=> $orderby, 
			'order'=> $order
		);
	}
	if(!empty($current)){
		$cat = $current;
	}
	if($cat != ''){
		global $wp_version;
		if(version_compare($wp_version, "3.1", '>=')){
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => explode(',', $cat)
				)
			);
		}else{
			$query['taxonomy'] = 'portfolio_category';
			$query['term'] = $cat;
		}
	}

	if($ids){
		$query['post__in'] = explode(',',$ids);
	}
	$r = new WP_Query($query);

	if($effect == 'default'){
		$effect = theme_get_option('portfolio','effect');
	}

	$i = 1;
	//deprecated
	if($title == ''){
		if(theme_get_option('portfolio','display_title') || $column == 1){
			$title = 'true';
		}
	}
	if($desc == ''){
		if(theme_get_option('portfolio','display_excerpt') || $column == 1){
			$desc = 'true';
		}
	}

	switch($more){
		case '':
			if( theme_get_option('portfolio','display_more_button') ){
				$more = true;
			}else{
				$more = false;
			}
			break;
		case 'false':
			$more = false;
			break;
		case 'true':
		default:
			$more = true;
			break;
	}
	while($r->have_posts()) {
		$r->the_post();
		$terms = get_the_terms(get_the_id(), 'portfolio_category');
		$terms_slug = array();
		if (is_array($terms)) {
			foreach($terms as $term) {
				$terms_slug[] = $term->slug;
			}
		}
		
		if (($i % $column) == 0 && $column != 1) {
			$output .= '<li class="portfolio_item" data-id="'.get_the_id().'" data-type="' . implode(',', $terms_slug) . '">';
		} else {
			$output .= '<li class="portfolio_item" data-id="'.get_the_id().'" data-type="' . implode(',', $terms_slug) . '">';
		}
		$i++;
		$type = get_post_meta(get_the_id(), '_type', true);
		
		if (has_post_thumbnail()) {
			$image_source = array('type'=>'attachment_id','value'=>get_post_thumbnail_id(get_the_id()));
			$image_src = theme_get_image_src($image_source, $size);
			
			$width = '';
			$height = '';
			$iframe = '';
			$inline = '';
			$image_lightbox_fittoview = '';
			if($type == 'image'){
				$href =  get_post_meta(get_the_id(), '_image', true);
				if(empty($href) || (!empty($href) && is_array($href) && isset($href['value']) && empty($href['value']))){
					$href = theme_get_image_src($image_source);
				}else{
					$href = theme_get_image_src($href);
				}
				$image_lightbox_fittoview =  get_post_meta(get_the_id(), '_image_lightbox_fittoview', true);

				if($image_lightbox_fittoview === 'true'){
					$image_lightbox_fittoview = ' data-fittoview="true"';
				}else if($image_lightbox_fittoview === 'false'){
					$image_lightbox_fittoview = ' data-fittoview="false"';
				}
				$icon = 'zoom';
				$lightbox = ' lightbox';
				if($group == 'true'){
					$rel = ' rel="'.$rel_group.'"';
				}else{
					$rel = '';
				}

			}elseif($type == 'video'){
				$href =  get_post_meta(get_the_id(), '_video', true);
				if(empty($href)){
					$href = theme_get_image_src($image_source);
				}
				$video_width = get_post_meta(get_the_id(), '_video_width', true);
				$video_height = get_post_meta(get_the_id(), '_video_height', true);
				if($video_width==''){
					$video_width = theme_get_option('portfolio','video_width');
				}
				if($video_height==''){
					$video_height = theme_get_option('portfolio','video_height');
				}
				$width = ' data-width="'.$video_width.'"';
				$height = ' data-height="'.$video_height.'"';
				
				$icon = 'play';
				$lightbox = ' lightbox';
				if($group == 'true'){
					$rel = ' rel="'.$rel_group.'"';
				}else{
					$rel = '';
				}
			}elseif($type == 'lightbox'){
				$href =  get_post_meta(get_the_id(), '_lightbox_href', true);
				if(empty($href)){
					$inline_id = 'portfolio_inline_'.get_the_id();
					$href = '#';
					$inline = ' data-inline="true" data-href="#'.$inline_id.'"';
					$output .= '<div class="hidden"><div id="'.$inline_id.'">';
					$output .= do_shortcode(get_post_meta(get_the_id(), '_lightbox_content', true));
					$output .= '</div></div>';
				}else{
					$iframe = ' data-iframe="true"';
				}
				$lightbox_width = get_post_meta(get_the_id(), '_lightbox_width', true);
				$lightbox_height = get_post_meta(get_the_id(), '_lightbox_height', true);
				if($lightbox_width==''){
					$lightbox_width = theme_get_option('portfolio','lightbox_width');
				}
				if($lightbox_height==''){
					$lightbox_height = theme_get_option('portfolio','lightbox_height');
				}
				$width = ' data-width="'.$lightbox_width.'"';
				$height = ' data-height="'.$lightbox_height.'"';
				
				$icon = 'zoom';
				$lightbox = ' fancyLightbox';
				if($group == 'true'){
					$rel = ' rel="'.$rel_group.'"';
				}else{
					$rel = '';
				}
			}elseif($type == 'link'){
				$link = get_post_meta(get_the_ID(), '_link', true);
				$href = theme_get_superlink($link);
				$link_target = get_post_meta(get_the_ID(), '_link_target', true);
				$link_target = $link_target?$link_target:'_self';
				$icon = 'link';
				$lightbox = '';
				$rel = '';
			}elseif($type == 'gallery'){
				$image_ids_str = get_post_meta(get_the_id(), '_image_ids', true);
				$image_ids = array();
				if(!empty($image_ids_str)){
					$image_ids = explode(',',str_replace('image-','',$image_ids_str));
					$image_id = array_shift($image_ids);
					if($lightboxtitle=='portfolio'){
						$image_title = get_the_title();
					}elseif($lightboxtitle=='image'){
						$image_title = get_the_title($image_id);
					}elseif($lightboxtitle=='imagecaption'){
						$attachment = get_post( $image_id );
						$image_title = $attachment->post_excerpt;//Caption
					}elseif($lightboxtitle=='imagedesc'){
						$attachment = get_post( $image_id );
						$image_title = $attachment->post_content;;//Description
					}else{
						$image_title = '';
					}
					$base_image_src = wp_get_attachment_image_src($image_id,'full');
					$href = $base_image_src[0];
				}else{
					$href =  get_post_meta(get_the_id(), '_image', true);
					if(empty($href)){
						$href = theme_get_image_src($image_source);
					}else{
						$href = theme_get_image_src($href);
					}
					if($lightboxtitle=='portfolio'){
						$image_title = get_the_title();
					}else{
						$image_title = '';
					}
				}
				$icon = 'zoom';
				$lightbox = ' lightbox';
				if($group == 'true'){
					$rel = ' rel="'.$rel_group.'"';
				}else{
					$rel = ' rel="gallery-'.get_the_ID().'"';
				}
			}else{
				$href = get_permalink();
				$icon = 'doc';
				$lightbox = '';
				$rel = '';
			}
			
			if($type!=='gallery'){
				$image_id = get_post_thumbnail_id(get_the_id());
				if($lightboxtitle=='portfolio'){
						$image_title = get_the_title();
					}elseif($lightboxtitle=='image'){
						$image_title = get_the_title($image_id);
					}elseif($lightboxtitle=='imagecaption'){
						$attachment = get_post( $image_id );
						$image_title = $attachment->post_excerpt;//Caption
					}elseif($lightboxtitle=='imagedesc'){
						$attachment = get_post( $image_id );
						$image_title = $attachment->post_content;;//Description
					}else{
						$image_title = '';
					}
			}
			$override_icon = get_post_meta(get_the_ID(), '_icon', true);
			if($override_icon && $override_icon != 'default'){
				$icon = $override_icon;
			}
			
			
			$output .= '<div class="image_styled portfolio_image">';
			$output .= '<span class="image_frame effect-'.$effect.'" style="height:'.$size[1].'px">';
			$output .= '<a class="image_icon_'.$icon.$lightbox.'" '.(isset($link_target)?'target="'.$link_target.'" ':'').' title="'. $image_title .'" href="' . $href . '"'.$rel.$width.$height.$inline.$iframe.$image_lightbox_fittoview.'>';
			$output .= '<img src="' . $image_src . '" width="'.$size[0].'" height="'.$size[1].'" title="' . get_the_title() . '" alt="' . get_the_title() . '" />';
			$output .= '</a>';
			$output .= '</span>';
			$output .= '<img src="' . THEME_IMAGES . '/image_shadow.png" class="image_shadow">';
			$output .= '</div>';
		}
		
		$output .= '<div class="portfolio_details">';
		
		if($title == 'true'){
			if($titlelinkable == 'true'){
				if($type != 'link'){
					$href = get_permalink();
				}
				$output .= '<div class="portfolio_title"><a href="'.$href.'">' . get_the_title() . '</a></div>';
			} else{
				$output .= '<div class="portfolio_title">' . get_the_title() . '</div>';
			}
		}
		
		if($desc == 'true'){
			if($advancedesc == 'true'){
				remove_filter('get_the_excerpt', 'wp_trim_excerpt');
				$output .= '<div class="portfolio_desc">' . do_shortcode(wpautop(get_the_excerpt())) . '</div>';
			}else{
				$output .= '<div class="portfolio_desc">' . get_the_excerpt() . '</div>';
			}
		}
		
		if(theme_is_enabled(get_post_meta(get_the_id(), '_more', true), $more)){
			$more_link = theme_get_superlink(get_post_meta(get_the_id(), '_more_link', true), get_permalink());
			$more_link_target = get_post_meta(get_the_ID(), '_more_link_target', true);
			$more_link_target = $more_link_target?$more_link_target:'_self';
			if($moretext == ''){
				$moretext = wpml_t(THEME_NAME , 'Portfolio More Button Text',theme_get_option('portfolio','more_button_text'));
			}
			if(theme_get_option('portfolio','read_more_button')){
				$output .= '<div class="portfolio_more_button"><a href="'.$more_link.'" class="'.apply_filters( 'theme_css_class', 'button' ).'" target="'.$more_link_target.'"><span>'.$moretext.'</span></a></div>';
			}else{
				$output .= '<div class="portfolio_more_button"><a href="'.$more_link.'" target="'.$more_link_target.'"><span>'.$moretext.'</span></a></div>';
			}
				
		}
		if($type == 'gallery'&&!empty($image_ids)){
			$output .= '<div class="hidden">';
			foreach($image_ids as $image_id){
				if($lightboxtitle=='portfolio'){
					$image_title = get_the_title();
				}elseif($lightboxtitle=='image'){
					$image_title = get_the_title($image_id);
				}elseif($lightboxtitle=='imagecaption'){
					$attachment = get_post( $image_id );
					$image_title = $attachment->post_excerpt;//Caption
				}elseif($lightboxtitle=='imagedesc'){
					$attachment = get_post( $image_id );
					$image_title = $attachment->post_content;;//Description
				}else{
					$image_title = '';
				}
				$image_src = wp_get_attachment_image_src($image_id,'full');
				$output .= '<a class="lightbox" href="'.$image_src[0].'" title="'. $image_title .'" rel="'.(($group=='true')?$rel_group:'gallery-'.get_the_ID()).'">gallery-'.get_the_ID().'</a>';
			}
			$output .= '</div>';
		}
		$output .= '</div>';
		$output .= '</li>';
	}
	$output .= '</ul>';
	if ($nopaging == 'false') {
		ob_start();
		theme_portfolio_pagenavi('', '', $r, $paged);
		$output .= ob_get_clean();
	}
	$output .= '</div>';
	if($desc_length != 'default'){
		remove_filter( 'excerpt_length', array($excerpt_constructor,'get_length'));
	}
	wp_reset_postdata();
	$wp_filter['the_content'] = $the_content_filter_backup;
	return $output;
}