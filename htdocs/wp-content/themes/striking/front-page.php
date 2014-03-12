<?php 
if(is_blog()){
	return load_template(THEME_DIR . "/template_blog.php");
}
get_header();
global $home_page_id;
$home_page_id = theme_get_option('homepage','home_page');

if($home_page_id){
	$home_page_id = wpml_get_object_id($home_page_id,'page');
	echo theme_generator('introduce',$home_page_id);
	$home_page_date = &get_page($home_page_id);
	$content = $home_page_date->post_content;
}else{
	
	if (!theme_get_option('homepage', 'disable_slideshow')) {
		$type = theme_get_option('homepage', 'slideshow_type');
		$category = theme_get_option('homepage', 'slideshow_category');
		$number = theme_get_option('homepage', 'slideshow_number');
		theme_generator('slideshow',$type,$category,'',$number);
	}
	$content = theme_get_option('homepage','page_content');
}
$layout=theme_get_option('homepage','layout');
?>
<div id="page" class="home">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
			<div class="content">
				<?php echo apply_filters('the_content', stripslashes( $content ));?>
				<div class="clearboth"></div>
			</div>
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>