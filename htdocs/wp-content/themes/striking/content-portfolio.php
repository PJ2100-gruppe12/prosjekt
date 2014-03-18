<?php
/**
 * The default template for displaying portfolio content in single-portfolio.php template
 */
$post_id = get_queried_object_id();
$layout = theme_get_inherit_option($post_id, '_layout', 'portfolio','layout');
$effect = theme_get_option('portfolio','sinle_effect');
$featured_image = theme_get_inherit_option($post_id, '_featured_image', 'portfolio','featured_image');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('entry content'); ?>>
<?php if($featured_image):?>
	<header>
		<?php echo theme_generator('portfolio_featured_image',$layout,$effect,true); ?>
	</header>
<?php endif; ?>
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'theme_front' ), 'after' => '</div>' ) ); ?>
	<footer>
	<?php edit_post_link(__('Edit', 'theme_front'),'<p class="entry_edit">','</p>'); ?>
<?php if(theme_get_option('portfolio','author')):echo theme_generator('blog_author_info');endif;?>
<?php if(theme_get_option('portfolio','related_recent')):?>
		<div class="related_recent_wrap">
			<div class="one_half">
				<?php echo theme_generator('portfolio_related_posts');?>
			</div>
			<div class="one_half last">
				<?php echo theme_generator('portfolio_recent_posts');?>
			</div>
			<div class="clearboth"></div>
		</div>
<?php endif;?>
<?php if(theme_get_option('portfolio','single_navigation')):?>
		<nav class="entry_navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous portfolio link', 'theme_front' ) . '</span> %title' ,false); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next portfolio link', 'theme_front' ) . '</span>' ,false); ?></div>
		</nav>
<?php endif;?>
	</footer>
	<div class="clearboth"></div>
</article>