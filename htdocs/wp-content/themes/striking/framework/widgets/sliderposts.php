<?php
/**
 * Slider_Posts Widget Class
 */
class Theme_Widget_Slider_Posts extends WP_Widget {

	function Theme_Widget_Slider_Posts() {
		$widget_ops = array('classname' => 'widget_slider_posts', 'description' => __( "Displays the popular posts on your site", 'striking_admin') );
		$this->WP_Widget('slider_posts', THEME_SLUG.' - '.__('Slider Posts', 'striking_admin'), $widget_ops);
		$this->alt_option_name = 'widget_slider_posts';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('theme_widget_slider_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Popular Posts', 'striking_front') : $instance['title'], $instance, $this->id_base);
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;
		
		$disable_navigation = $instance['disable_navigation'] ? '1' : '0';
		$orderby = $instance['orderby'] ? $instance['orderby'] :'time';

		$query = array('showposts' => $number, 'nopaging' => 0, 'orderby'=> 'comment_count', 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
		if(!empty($instance['cat'])){
			$query['cat'] = implode(',', $instance['cat']);
		}
		$r = new WP_Query($query);
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="posts_list">
<?php  while ($r->have_posts()) : $r->the_post(); ?>
			<li>
<?php if(!$disable_navigation):?>
				<a class="thumbnail" href="<?php echo get_permalink() ?>" title="<?php the_title();?>">
<?php if (has_post_thumbnail() ): ?>
					<?php the_post_thumbnail(array(65,65),array('title'=>get_the_title(),'alt'=>get_the_title())); ?>	
<?php else:?>
					<img src="<?php echo THEME_IMAGES;?>/widget_posts_thumbnail.png" width="65" height="65" title="<?php the_title();?>" alt="<?php the_title();?>"/>
<?php endif;//end has_post_thumbnail ?>
				</a>
<?php endif;//disable_navigation ?>
				<div class="clearboth"></div>
			</li>
<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_query();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('theme_widget_slider_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['disable_navigation'] = !empty($new_instance['disable_navigation']) ? 1 : 0;
		$instance['orderby'] = $new_instance['orderby'];
		$instance['cat'] = $new_instance['cat'];
		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['theme_widget_slider_posts']) )
			delete_option('theme_widget_slider_posts');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$disable_navigation = isset( $instance['disable_navigation'] ) ? (bool) $instance['disable_navigation'] : false;
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';
		$cat = isset($instance['cat']) ? $instance['cat'] : array();
		
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5;

		$categories = get_categories('orderby=name&hide_empty=0');

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','striking_admin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'striking_admin'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('disable_navigation'); ?>" name="<?php echo $this->get_field_name('disable_navigation'); ?>"<?php checked( $disable_navigation ); ?> />
		<label for="<?php echo $this->get_field_id('disable_navigation'); ?>"><?php _e( 'Disable Navigation?' , 'striking_admin'); ?></label></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e( 'Order by:', 'striking_admin' ); ?></label>
			<select name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>" class="widefat">
				<option value="id"<?php selected($orderby,'id');?>><?php _e( 'Post id', 'striking_admin' ); ?></option>
				<option value="author"<?php selected($orderby,'author');?>><?php _e( 'Author', 'striking_admin' ); ?></option>
				<option value="title"<?php selected($orderby,'title');?>><?php _e( 'Title', 'striking_admin' ); ?></option>
				<option value="date"<?php selected($orderby,'date');?>><?php _e( 'Date', 'striking_admin' ); ?></option>
				<option value="modified"<?php selected($orderby,'modified');?>><?php _e( 'Last modified date', 'striking_admin' ); ?></option>
				<option value="rand"<?php selected($orderby,'rand');?>><?php _e( 'Random order', 'striking_admin' ); ?></option>
				<option value="comment_count"<?php selected($orderby,'comment_count');?>><?php _e( 'Number of comments', 'striking_admin' ); ?></option>
				<option value="menu_order"<?php selected($orderby,'menu_order');?>><?php _e( 'Page Order', 'striking_admin' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e( 'Categorys:' , 'striking_admin'); ?></label>
			<select style="height:5.5em" name="<?php echo $this->get_field_name('cat'); ?>[]" id="<?php echo $this->get_field_id('cat'); ?>" class="widefat" multiple="multiple">
				<?php foreach($categories as $category):?>
				<option value="<?php echo $category->term_id;?>"<?php echo in_array($category->term_id, $cat)? ' selected="selected"':'';?>><?php echo $category->name;?></option>
				<?php endforeach;?>
			</select>
		</p>
<?php
	}
}