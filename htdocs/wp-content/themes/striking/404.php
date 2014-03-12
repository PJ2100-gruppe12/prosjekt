<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Striking
 */

get_header(); ?>
<?php echo theme_generator('introduce');?>
<div id="page">
	<div class="inner right_sidebar">
		<div id="main">
			<div class="content">
				<h2><?php _e('Pages','striking_front');?></h2>
				<?php if (theme_get_option('general','enable_nav_menu') && has_nav_menu( 'primary-menu' ) ) {
			wp_nav_menu( array( 
				'theme_location' => 'primary-menu',
				'container_class' => '',
				'container' => '',
	 	 	 	'sort_column' => 'menu_order'
			));
		}else{
			$excluded_pages_with_childs = theme_get_excluded_pages();
			
			$output .= '<ul>';
			$output .= wp_list_pages("sort_column=menu_order&exclude=$excluded_pages_with_childs&title_li=&echo=0");
			$output .= '</ul>';
			
			echo $output;
		}
?>

				<div class="divider top"><a href="#"><?php _e('Top','striking_front');?></a></div>
<?php 
	$exclude_cats = theme_get_option('blog','exclude_categorys');
?>
				<h2><?php _e( 'Category Archives','striking_front'); ?></h2>
				<ul>
					<?php wp_list_categories( array( 'exclude'=> implode(",",$exclude_cats), 'feed' => __( 'RSS', 'striking_front' ), 'show_count' => true, 'use_desc_for_title' => false, 'title_li' => false ) ); ?>
				</ul>
				<div class="divider top"><a href="#"><?php _e('Top','striking_front');?></a></div> 

<?php 
	$archive_query = new WP_Query( array('showposts' => 1000,'category__not_in' => $exclude_cats ));
?>
				<h2><?php _e( 'Blog Posts','striking_front' ); ?></h2>
				<ul>
<?php while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
					<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __("Permanent Link to %s", 'striking_front'), get_the_title() ); ?>"><?php the_title(); ?></a> (<?php comments_number('0', '1', '%'); ?>)</li>
<?php endwhile; ?>
				</ul>

				<div class="divider top"><a href="#"><?php _e('Top','striking_front');?></a></div>
			</div>
		</div>
		<aside id="sidebar">
			<div id="sidebar_content"><?php get_search_form(); ?></div>
			<div id="sidebar_bottom"></div>
		</aside>
		<div class="clearboth"></div>
	</div>
	<div id="page_bottom"></div>
</div>
<?php get_footer(); ?>