<?php 
/**
 * Template Name: Page with comment
 * Description: A Page Template for adds comment function to the pages
 *
 * @package Striking
 */
$post_id = get_queried_object_id();
$layout = theme_get_inherit_option($post_id, '_layout', 'general','layout');

get_header(); 
echo theme_generator('introduce',$post_id);?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
			<?php echo theme_generator('breadcrumbs',$post_id);?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div class="content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'striking_front' ), 'after' => '</div>' ) ); ?>
				<?php edit_post_link(__('Edit', 'striking_front'),'<footer><p class="entry_edit">','</p></footer>'); ?>
				<?php comments_template( '', true ); ?>
				<div class="clearboth"></div>
			</div>
<?php endwhile; ?>
			<div class="clearboth"></div>
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>