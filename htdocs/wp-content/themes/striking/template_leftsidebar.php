<?php 
/**
 * Template Name: Left Sidebar
 * Description: A Page Template for adds a sidebar to the left side of the pages
 *
 * @package Striking
 */

if(is_blog()){
	return load_template(THEME_DIR . "/template_blog.php");
}elseif(is_front_page()){
	return load_template(THEME_DIR . "/front-page.php");
}

$post_id = get_queried_object_id();

get_header(); 
echo theme_generator('introduce',$post_id);?>
<div id="page">
	<div class="inner left_sidebar">
		<div id="main">
			<?php echo theme_generator('breadcrumbs',$post_id);?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div class="content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'striking_front' ), 'after' => '</div>' ) ); ?>
				<?php edit_post_link(__('Edit', 'striking_front'),'<footer><p class="entry_edit">','</p></footer>'); ?>
				<div class="clearboth"></div>
			</div>
<?php endwhile; ?>	
		</div>
		<?php get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>