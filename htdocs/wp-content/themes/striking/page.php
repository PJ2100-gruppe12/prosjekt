<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Striking
 */

if(is_blog()){
	return load_template(THEME_DIR . "/template_blog.php");
}elseif(is_front_page()){
	return load_template(THEME_DIR . "/front-page.php");
}

$post_id = get_queried_object_id();
$layout = theme_get_inherit_option($post_id, '_layout', 'general','layout');

get_header(); 
echo theme_generator('introduce',$post_id);?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
			<?php echo theme_generator('breadcrumbs',$post_id);?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<?php get_template_part('content','page'); ?>
<?php endwhile; // end of the loop.?>
			<div class="clearboth"></div>
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>