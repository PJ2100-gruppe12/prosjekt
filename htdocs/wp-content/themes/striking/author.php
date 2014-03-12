<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package Striking
 */

$layout=theme_get_option('blog','layout');
get_header(); 
?>
<?php echo theme_generator('introduce');?>
<div id="page">
	<div class="inner <?php if($layout=='right'):?>right_sidebar<?php endif;?><?php if($layout=='left'):?>left_sidebar<?php endif;?>">
		<div id="main">
			<?php echo theme_generator('breadcrumbs');?>
			<div class="content">
<?php
	if ( have_posts() )
			the_post();
?>
<?php if ( get_the_author_meta( 'description' ) ) : ?>
			<div id="author" class="entry">
				<h1><?php echo get_the_author();?></h1>
				<div class="gravatar"><?php echo get_avatar( get_the_author_meta('user_email'), '60' ); ?></div>
				<p>
					<?php the_author_meta( 'description' ); ?>
				</p>				
			</div>
<?php endif; ?>
<?php
			rewind_posts();
			$exclude_cats = theme_get_option('blog','exclude_categorys');
			foreach ($exclude_cats as $key => $value) {
				$exclude_cats[$key] = -$value;
			}
			if(stripos($query_string,'cat=') === false){
				query_posts($query_string."&cat=".implode(",",$exclude_cats));
			}else{
				query_posts($query_string.implode(",",$exclude_cats));
			}
			get_template_part('loop','author');
?>
				<div class="clearboth"></div>
			</div>
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<?php if($layout != 'full') get_sidebar(); ?>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>