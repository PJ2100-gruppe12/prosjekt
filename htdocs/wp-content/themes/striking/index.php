<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Striking
 */

get_header(); 
$layout=theme_get_option('general','layout');
$post_id = get_queried_object_id();

echo theme_generator('introduce',$post_id);?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
<?php if ( have_posts() ) : ?>
			<?php echo theme_generator('breadcrumbs',$post_id);?>
	<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>
<?php else : ?>
			<article id="post-0" class="post no-results not-found">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. ', 'striking' ); ?></p>
			</article>
<?php endif; ?>
			<div class="clearboth"></div>
		</div>
		<?php get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>