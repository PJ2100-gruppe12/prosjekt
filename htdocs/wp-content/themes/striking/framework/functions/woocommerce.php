<?php
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_action( 'woocommerce_before_main_content', 'theme_woocommerce_output_content_wrapper', 10);
add_action( 'woocommerce_after_main_content', 'theme_woocommerce_output_content_wrapper_end', 10);

function theme_woocommerce_output_content_wrapper() {
	$layout = get_post_meta(get_queried_object_id(), '_layout', true);
	if(empty($layout) || $layout == 'default'){
		$layout=theme_get_option('advanced','woocommerce_layout');
	}
	echo theme_generator('introduce',get_queried_object_id());
?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
<?php
}

function theme_woocommerce_output_content_wrapper_end() {
	$layout = get_post_meta(get_queried_object_id(), '_layout', true);
	if(empty($layout) || $layout == 'default'){
		$layout=theme_get_option('advanced','woocommerce_layout');
	}
?>
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php
}

function theme_woocommerce_styles(){
	if((is_admin() && !is_shortcode_preview()) || 'wp-login.php' == basename($_SERVER['PHP_SELF'])){
		return;
	}
	wp_enqueue_style('theme-woocommerce', THEME_CSS.'/woocommerce.css', false, false, 'all');
}
add_action('wp_print_styles', 'theme_woocommerce_styles',12);


if(!get_option('theme_woocommerce_pages_raw_fix')){
function theme_woocommerce_pages_raw_fix(){
	global $wpdb;
	$pages = array(
		//'woocommerce_shop_page_id' => _x('shop', 'page_slug', 'woothemes'),
		'woocommerce_cart_page_id' => _x('cart', 'page_slug', 'woothemes'),
		'woocommerce_checkout_page_id' => _x('checkout', 'page_slug', 'woothemes'),
		'woocommerce_order_tracking_page_id' => _x('order-tracking', 'page_slug', 'woothemes'),
		'woocommerce_myaccount_page_id' =>  _x('my-account', 'page_slug', 'woothemes'),
		'woocommerce_edit_address_page_id' => _x('edit-address', 'page_slug', 'woothemes'),
		'woocommerce_view_order_page_id' => _x('view-order', 'page_slug', 'woothemes'),
		'woocommerce_change_password_page_id' => _x('change-password', 'page_slug', 'woothemes'),
		'woocommerce_pay_page_id' => _x('pay', 'page_slug', 'woothemes'),
		'woocommerce_thanks_page_id' => _x('order-received', 'page_slug', 'woothemes'),
	);
	$i =0;
	foreach($pages as $option => $slug){
		$option_value = get_option($option); 
		
		if ($option_value>0 && $p = get_post( $option_value )){
			$pattern = '/(?<!\[raw\])\s*(\[woocommerce_[a-zA-Z_]+?\])\s*(?!\[\/raw\])/i';
			$replacement = '[raw]$1[/raw]';
			$post_content = preg_replace($pattern, $replacement, $p->post_content);	
			$wpdb->update( $wpdb->posts, stripslashes_deep(array('post_content' => $post_content)), array( 'ID' => $p->ID ));
			$i ++;
		}
	}
	if($i > 5){
		update_option('theme_woocommerce_pages_raw_fix',1);
	}
}
theme_woocommerce_pages_raw_fix();
}


if (!function_exists('woocommerce_breadcrumb')) {
	function woocommerce_breadcrumb( $args = array() ) {
		
		$defaults = array(
			'delimiter' 	=> ' &rsaquo; ',
			'wrap_before' 	=> '<section id="breadcrumbs">',
			'wrap_after'	=> '</section>',
			'before' 		=> '',
			'after' 		=> '',
			'home' 			=> null
		);

		$args = wp_parse_args( $args, $defaults );

		woocommerce_get_template('shop/breadcrumb.php', $args);
	}
}