<?php
/**
 * Search Widget Class
 */
class Theme_Widget_Search extends WP_Widget {

	function Theme_Widget_Search() {
		$widget_ops = array('classname' => 'widget_search', 'description' => __( 'A search form for your site.', 'theme_admin') );
		$this->WP_Widget('theme_search', THEME_SLUG.' - '.__('Search', 'theme_admin'), $widget_ops);
		
		if ('widgets.php' == basename($_SERVER['PHP_SELF'])) {
			add_action( 'admin_print_scripts', array(&$this, 'add_admin_script') );
		}
	}
	
	function add_admin_script(){
		wp_enqueue_script('init-widget-color',THEME_ADMIN_ASSETS_URI . '/js/init-widget-color.js',array('jquery','jquery-colorinput'));
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		if(isset($instance['bgColor'])){
			$bgColor = $instance['bgColor']?' style="background-color:'.$instance['bgColor'].'"':'';
		}else{
			$bgColor = '';
		}
		if(isset($instance['textColor'])){
			$textColor = $instance['textColor']?' style="color:'.$instance['textColor'].'"':'';
		}else{
			$textColor = '';
		}
		
		echo $before_widget;
		if ( $title)
			echo $before_title . $title . $after_title;
		
		?>
		<form method="get" id="searchform" action="<?php echo home_url(); ?>">
			<input type="text" class="text_input" value="<?php _e('Search..', 'theme_front');?>" name="s" id="s" onfocus="if(this.value == '<?php _e('Search..', 'theme_front');?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search..', 'theme_front');?>';}" />
			<button type="submit" class="<?php echo apply_filters( 'theme_css_class', 'button' );?> gray"<?php echo $bgColor;?>><span<?php echo $textColor;?>><?php _e('Search', 'theme_front');?></span></button>
		</form>
		<?php
		echo $after_widget;

	}


	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['bgColor'] = strip_tags($new_instance['bgColor']);
		$instance['textColor'] = strip_tags($new_instance['textColor']);

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$bgColor = isset($instance['bgColor']) ? esc_attr($instance['bgColor']) : '';
		$textColor = isset($instance['textColor']) ? esc_attr($instance['textColor']) : '';
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'theme_admin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('bgColor'); ?>"><?php _e('Submit Button Background Color:', 'theme_admin'); ?></label>
		<input class="widefat color" style="width:80%" id="<?php echo $this->get_field_id('bgColor'); ?>" name="<?php echo $this->get_field_name('bgColor'); ?>" type="text" data-hex="true" value="<?php echo $bgColor; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('textColor'); ?>"><?php _e('Submit Button Text Color:', 'theme_admin'); ?></label>
		<input class="widefat color" style="width:80%" id="<?php echo $this->get_field_id('textColor'); ?>" name="<?php echo $this->get_field_name('textColor'); ?>" type="text" data-hex="true" value="<?php echo $textColor; ?>" /></p>
<?php
	}
}
