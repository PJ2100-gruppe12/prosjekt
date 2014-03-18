<?php

add_theme_support( 'woocommerce' );

global $woo_config;
$woo_config = array(
	'full' => array(
		'shop_thumbnail'=> array('width'=>91, 'height'=>91),
		'shop_catalog'  => array('width'=>219, 'height'=>219),
		'shop_single'   => array('width'=>294, 'height'=>294),
	),
	'sidebar' => array(
		'shop_thumbnail'=> array('width'=>59, 'height'=>59),
		'shop_catalog'  => array('width'=>137, 'height'=>137),
		'shop_single'   => array('width'=>193, 'height'=>193),
	),	
	'related_columns' => 4,
	'related_count'   => 4,
);


add_action('admin_init', 'theme_woocommerce_first_activation' , 45 );
function theme_woocommerce_first_activation() {
	if(!is_admin()) return;
	if(!class_exists( 'Woocommerce' )) return;

	theme_set_option('advanced', 'complex_class', true);

	$theme_name = THEME_SLUG;

	if(get_option("{$theme_name}_woo_settings_enabled")) return;
	update_option("{$theme_name}_woo_settings_enabled", '1');
	
	theme_woocommerce_set_defaults();
}

add_action( 'theme_activation', 'theme_woocommerce_set_defaults', 10);
function theme_woocommerce_set_defaults() {
	global $woo_config;

	update_option('shop_catalog_image_size', $woo_config['full']['shop_thumbnail']);
	update_option('shop_single_image_size', $woo_config['full']['shop_single']);
	update_option('shop_thumbnail_image_size', $woo_config['full']['shop_thumbnail']);

	$set_yes = array('woocommerce_frontend_css','woocommerce_single_image_crop');
	foreach ($set_yes as $option) { 
		update_option($option, 'yes'); 
	}

	$set_no = array('woocommerce_enable_lightbox');
	foreach ($set_no as $option) { 
		update_option($option, 'no'); 
	}
}

add_action('wp_print_styles', 'theme_woocommerce_styles',12);
function theme_woocommerce_styles(){
	if((is_admin() && !is_shortcode_preview()) || 'wp-login.php' == basename($_SERVER['PHP_SELF'])){
		return;
	}
	wp_enqueue_style('theme-woocommerce', THEME_CSS.'/woocommerce.css', false, false, 'all');

	if(is_rtl()){
		wp_enqueue_style('theme-woocommerce-rtl', THEME_CSS.'/woocommerce-rtl.css', false, false, 'all');
	}
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
// add_action( 'woocommerce_before_main_content', 'theme_woocommerce_output_content_wrapper', 10);
// add_action( 'woocommerce_after_main_content', 'theme_woocommerce_output_content_wrapper_end', 10);
function theme_woocommerce_output_content_wrapper() {
	$id = get_queried_object_id();
	if(is_product()){
		$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_product_layout');
	}else{
		$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_layout');
	}

	if(is_archive() && !theme_is_enabled(theme_get_option('advanced','woocommerce_introduce'), theme_get_option('general','introduce'))){

	}else{
		echo theme_generator('introduce',$id,true);
	}
?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
<?php
}

function theme_woocommerce_output_content_wrapper_end() {
	$id = get_queried_object_id();
	
	if(is_product()){
		$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_product_layout');
	}else{
		$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_layout');
	}
?>
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
</div>
<?php
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'theme_woocommerce_thumbnail', 10);
function theme_woocommerce_thumbnail(){
	global $woo_config;
	global $post;
	$size = 'shop_catalog';

	if(function_exists('is_shop') && is_shop()){
		$id = woocommerce_get_page_id( 'shop' );
	} else {
		$id = get_queried_object_id();
	}
	
	if(is_product()){
		$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_product_layout');
	}else{
		$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_layout');
	}
	if($layout == 'full'){
		$sizes = array($woo_config['full'][$size]['width'], $woo_config['full'][$size]['height']);
	}else{
		$sizes = array($woo_config['sidebar'][$size]['width'], $woo_config['sidebar'][$size]['height']);
	}


	echo '<div class="product-thumbnail-wrap">';
	if ( has_post_thumbnail() ){
		$thumbnail_id = get_post_thumbnail_id();
		
		$hover = get_post_meta( get_the_id(), '_product_hover', true );
		
		$image_src = theme_get_image_src(array('type'=>'attachment_id','value'=>$thumbnail_id), $sizes);
		
		echo '<img class="product-thumbnail" width="'.$sizes[0].'" height="'.$sizes[1].'" data-thumbnail="'.$thumbnail_id.'" src="'.$image_src.'" alt="'.get_the_title().'" />';
		echo theme_woocommerce_thumbnail_hover(get_the_id(), $sizes);
	}	
	elseif ( woocommerce_placeholder_img_src() )
		echo woocommerce_placeholder_img( $size );
	echo '</div>';
}

function theme_woocommerce_thumbnail_hover($id, $sizes){
	$hover = get_post_meta( $id, '_product_hover', true );

	if($hover === 'true'){
		$product_gallery = get_post_meta( $id, '_product_image_gallery', true );
		
		if(!empty($product_gallery))
		{
			$gallery	= explode(',',$product_gallery);
			$image_id 	= $gallery[0];

			$image_src = theme_get_image_src(array('type'=>'attachment_id','value'=>$image_id), $sizes);
			return '<img class="product-thumbnail-hover" width="'.$sizes[0].'" height="'.$sizes[1].'" src="'.$image_src.'" />';
		}
	}
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products',10);
add_action( 'woocommerce_after_single_product_summary', 'avia_woocommerce_output_related_products', 20);

function avia_woocommerce_output_related_products(){
	global $woo_config;
	$output = "";

	ob_start();
	woocommerce_related_products($woo_config['related_count'],$woo_config['related_columns']); 
	$output = ob_get_clean();
	
	echo $output;
}

function theme_woocommerce_breadcrumb_defaults($args){
	return wp_parse_args( array(
		'delimiter'   => ' <span class="separator">»</span> ',
		'wrap_before' => '<section id="breadcrumbs" itemprop="breadcrumb">',
		'wrap_after'  => '</section>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	), $args);
}
add_filter('woocommerce_breadcrumb_defaults', 'theme_woocommerce_breadcrumb_defaults');


function theme_woocommerce_loop_add_to_cart_link($content){
	$content = str_replace(' button ', ' ', $content);
	$content = preg_replace('|(<a.*?class=")(.+?)(".*?>)(.+)?(</a>)|i', '<div class="product-actions">$1theme_button white $2$3<span>$4</span>$5</div>',$content);
	return $content;
}

add_filter('woocommerce_loop_add_to_cart_link', 'theme_woocommerce_loop_add_to_cart_link');

add_action( 'woocommerce_before_shop_loop_item_title', 'theme_woocommerce_product_wrap_meta_div', 20);
function theme_woocommerce_product_wrap_meta_div(){
	echo "<div class='product-meta-wrap'>";
}

add_action( 'woocommerce_after_shop_loop_item_title',  'theme_woocommerce_div_close', 1000);

function theme_woocommerce_div_close(){
	echo "</div>";
}

add_action( 'woocommerce_before_single_product_summary', 'theme_woocommcere_add_image_wrap_div', 2);
add_action( 'woocommerce_before_single_product_summary',  'theme_woocommerce_div_close', 20);
function theme_woocommcere_add_image_wrap_div() {
	echo "<div class='one_third single-product-main-image'>";
}

function theme_woocommerce_div_close_with_clear() {
	echo "</div>";
	echo '<div class="clearboth"></div>';
}

add_action( 'woocommerce_before_single_product_summary', 'theme_woocommcere_add_summary_wrap_div', 25);
add_action( 'woocommerce_after_single_product_summary',  'theme_woocommerce_div_close_with_clear', 3);
function theme_woocommcere_add_summary_wrap_div(){
	echo "<div class='two_third last single-product-summary'>";
}

add_action('wp_head', 'theme_woocommerce_product_desciption_position') ;
function theme_woocommerce_product_desciption_position(){
	if(is_product()){
		$layout = theme_get_inherit_option(get_queried_object_id(), '_layout', 'advanced','woocommerce_product_layout');
		if($layout == 'full'){
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			add_action(    'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1 );
		}
	}
}
