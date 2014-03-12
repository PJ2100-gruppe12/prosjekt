<?php
/**
 * Sub Navigation Widget Class
 */
class Theme_Widget_SubNav extends WP_Widget {

	function Theme_Widget_SubNav() {
		$widget_ops = array('classname' => 'widget_subnav', 'description' => __( 'Displays a list of SubPages', 'striking_admin') );
		$this->WP_Widget('subnav', THEME_SLUG.' - '.__('Sub Navigation', 'striking_admin'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
		$exclude = empty( $instance['exclude'] ) ? theme_get_excluded_pages() : $instance['exclude'].','.theme_get_excluded_pages();
		$parent_linkable = $instance['parent_linkable'] ? '1' : '0';

		global $post;
		$children=wp_list_pages( 'echo=0&child_of=' . $post->ID . '&title_li=' );
		if ($children) {
			$parent = $post->ID;
			$parent_linkable = 0;
		}else{
			$parent = $post->post_parent;
			if(!$parent){
				$parent_linkable = 0;
				$parent = $post->ID;
			}
		}
		$parent_title = get_the_title($parent);
		$title = apply_filters('widget_title', empty($instance['title']) ? $parent_title : $instance['title'], $instance, $this->id_base);
		$output = wp_list_pages( array('title_li' => '', 'echo' => 0, 'child_of' =>$parent, 'sort_column' => $sortby, 'exclude' => $exclude, 'depth' => 1) );
		if($parent_linkable){
			$title='<a href="'.get_permalink($parent).'">'.$title.'</a>';
		}
		if ( !empty( $output ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
		?>
		<ul>
			<?php echo $output; ?>
		</ul>
		<?php
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( in_array( $new_instance['sortby'], array( 'post_title', 'menu_order', 'ID' ) ) ) {
			$instance['sortby'] = $new_instance['sortby'];
		} else {
			$instance['sortby'] = 'menu_order';
		}

		$instance['exclude'] = strip_tags( $new_instance['exclude'] );
		$instance['parent_linkable'] = !empty($new_instance['parent_linkable']) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'sortby' => 'menu_order', 'title' => '', 'exclude' => '') );
		$parent_linkable = isset( $instance['parent_linkable'] ) ? (bool) $instance['parent_linkable'] : false;
		$title = esc_attr( $instance['title'] );
		$exclude = esc_attr( $instance['exclude'] );
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'striking_admin'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e( 'Sort by:', 'striking_admin'); ?></label>
			<select name="<?php echo $this->get_field_name('sortby'); ?>" id="<?php echo $this->get_field_id('sortby'); ?>" class="widefat">
				<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php _e('Page order', 'striking_admin'); ?></option>
				<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php _e('Page title', 'striking_admin'); ?></option>
				<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php _e( 'Page ID', 'striking_admin' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e( 'Exclude:', 'striking_admin' ); ?></label> <input type="text" value="<?php echo $exclude; ?>" name="<?php echo $this->get_field_name('exclude'); ?>" id="<?php echo $this->get_field_id('exclude'); ?>" class="widefat" />
			<br />
			<small><?php _e( 'Page IDs, separated by commas.' ,'striking_admin'); ?></small>
		</p>
		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('parent_linkable'); ?>" name="<?php echo $this->get_field_name('parent_linkable'); ?>"<?php checked( $parent_linkable ); ?> />
		<label for="<?php echo $this->get_field_id('parent_linkable'); ?>"><?php _e( 'Make Parent Linkable?', 'striking_admin' ); ?></label></p>
<?php
	}
}