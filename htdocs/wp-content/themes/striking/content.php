<?php
/**
 * The default template for displaying content
 */
?>
<div class="content" <?php post_class(); ?>>
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'theme_front' ), 'after' => '</div>' ) ); ?>
	<?php edit_post_link(__('Edit', 'theme_front'),'<footer><p class="entry_edit">','</p></footer>'); ?>
	<div class="clearboth"></div>
</div>