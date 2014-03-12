<?php
/**
 * The default template for displaying page content in page.php template
 *
 * @package Striking
 * @since Striking 5.2
 */
?>
<div class="content" <?php post_class(); ?>>
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'striking_front' ), 'after' => '</div>' ) ); ?>
	<?php edit_post_link(__('Edit', 'striking_front'),'<footer><p class="entry_edit">','</p></footer>'); ?>
	<div class="clearboth"></div>
</div>