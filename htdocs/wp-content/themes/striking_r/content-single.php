<?php
/**
 * The default template for displaying content in single.php template
 */
$post_id = get_queried_object_id();
$featured_image_type = theme_get_option('blog', 'single_featured_image_type');
$effect=theme_get_option('blog','single_effect');
$layout = theme_get_inherit_option($post_id, '_layout', 'blog','single_layout');
if($featured_image_type == 'full' || $featured_image_type == 'below'){
	if ($layout == 'full'){
		$width = 960;
	} else {
		$width = 630;
	}
} else {
	$width = '';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('entry content entry_'.$featured_image_type); ?>>
	<header>
<?php
if(theme_is_enabled(get_post_meta($post->ID, '_featured_image', true), theme_get_option('blog','featured_image')) && $featured_image_type!=='below'):
echo theme_generator('blog_featured_image',$featured_image_type,$width,'',false,$effect,true);
endif; ?>
<?php if(!theme_get_inherit_option($post_id, '_show_in_header', 'blog','show_in_header')):?>
		<div class="entry_info">
			<h1><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php printf( __("Permanent Link to %s", 'theme_front'), get_the_title() ); ?>"><?php the_title(); ?></a></h1>
			<div class="entry_meta">
<?php echo theme_generator('blog_meta'); ?>
			</div>
		</div>
<?php endif;?>
<?php
if(theme_is_enabled(get_post_meta($post->ID, '_featured_image', true), theme_get_option('blog','featured_image')) && $featured_image_type=='below'):
echo theme_generator('blog_featured_image',$featured_image_type,$width,'',false,$effect,true);
endif; ?>
	</header>
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'theme_front' ), 'after' => '</div>' ) ); ?>
	<footer>
		<?php edit_post_link(__('Edit', 'theme_front'),'<p class="entry_edit">','</p>'); ?>
		<?php if(theme_get_inherit_option($post->ID,'_author','blog','author')): echo theme_generator('blog_author_info');endif;?>
		<?php if(theme_get_inherit_option($post->ID,'_related_popular','blog','related_popular')):?>
		<div class="related_popular_wrap">
			<div class="one_half">
				<?php echo theme_generator('blog_related_posts');?>
			</div>
			<div class="one_half last">
				<?php echo theme_generator('blog_popular_posts');?>
			</div>
			<div class="clearboth"></div>
		</div>
		<?php endif;?>
		<?php if(theme_get_option('blog','entry_navigation')):?>
		<nav class="entry_navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'theme_front' ) . '</span> %title' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'theme_front' ) . '</span>' ); ?></div>
		</nav>
		<?php endif;?>
	</footer>
	<div class="clearboth"></div>
</article>