<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Striking
 */

$layout=theme_get_option('blog','search_layout');
if($layout == 'default'){
	$layout = theme_get_option('blog','layout');
}
get_header(); ?>
<?php echo theme_generator('introduce');?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
			<?php echo theme_generator('breadcrumbs');?>
			<div class="content">
			<?php			
				get_template_part( 'loop','search');
			?>
				<div class="clearboth"></div>
			</div>
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<?php get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>