<?php
/**
 * The template for displaying woocommerce pages.
 */

if(is_blog()){
	return load_template(THEME_DIR . "/template_blog.php");
}elseif(is_front_page()){
	return load_template(THEME_DIR . "/front-page.php");
}
if(function_exists('is_shop') && is_shop()){
	$post_id = woocommerce_get_page_id( 'shop' );
} else {
	$post_id = get_queried_object_id();
}
if(is_product()){
	$layout = theme_get_inherit_option($post_id, '_layout', 'advanced','woocommerce_product_layout');
}else{
	$layout = theme_get_inherit_option($post_id, '_layout', 'advanced','woocommerce_layout');
}



get_header('shop'); 
echo theme_generator('introduce',$post_id);?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
			<?php echo theme_generator('breadcrumbs',$post_id);?>
			<div class="content" <?php post_class(); ?>>
				<?php woocommerce_content();?>
				<?php if(is_shop() || is_product()) {edit_post_link(__('Edit', 'theme_front'),'<footer><p class="entry_edit">','</p></footer>',$post_id); }?>
				<div class="clearboth"></div>
			</div>
			<div class="clearboth"></div>
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer('shop'); ?>
