<?php
/**
 * Single Product Thumbnails
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce, $woo_config;

$id = get_queried_object_id();
	
if(is_product()){
	$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_product_layout');
}else{
	$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_layout');
}

if($layout == 'full'){
	$sizes = array($woo_config['full']['shop_thumbnail']['width'], $woo_config['full']['shop_thumbnail']['height']);
}else{
	$sizes = array($woo_config['sidebar']['shop_thumbnail']['width'], $woo_config['sidebar']['shop_thumbnail']['height']);
}

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
	<div class="thumbnails"><?php

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			
			
			


			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image_src = theme_get_image_src(array('type'=>'attachment_id','value'=>$attachment_id), $sizes);
			$image_title = esc_attr( get_the_title( $attachment_id ) );

			$image = '<img class="attachment-shop_thumbnail" width="'.$sizes[0].'" height="'.$sizes[1].'" data-thumbnail="'.$attachment_id.'" src="'.$image_src.'" alt="'.$image_title.'" />';
			
			$image_class = esc_attr( implode( ' ', $classes ) );

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s"  rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}

	?></div>
	<?php
}