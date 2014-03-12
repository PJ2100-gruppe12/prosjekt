<?php
class Theme_Post_Type_Slideshow {
	public $post_type = 'slideshow';
	public $post_type_taxonomy = 'slideshow_category';

	function __construct($post_type = 'slideshow', $post_type_taxonomy = 'slideshow_category') {
		$this->post_type = $post_type;
		$this->post_type_taxonomy = $post_type_taxonomy;
	}

	function init(){
		add_action( 'template_redirect', array(&$this, 'context_fixer') );
		add_action('init', array(&$this, 'register'),0);
	}

	function register(){
		$this->register_post_type();
		$this->register_taxonomy();
	}

	function register_post_type() {
		register_post_type($this->post_type, array(
			'labels' => array(
				'name' => _x('Slider Items', 'post type general name', 'striking_admin'),
				'singular_name' => _x('Slider Item', 'post type singular name', 'striking_admin'),
				'add_new' => _x('Add New', 'slideshow', 'striking_admin'),
				'add_new_item' => __('Add New Slider Item', 'striking_admin'),
				'edit_item' => __('Edit Slider Item', 'striking_admin'),
				'new_item' => __('New Slider Item', 'striking_admin'),
				'view_item' => __('View Slider Item', 'striking_admin'),
				'search_items' => __('Search Slider Items', 'striking_admin'),
				'not_found' =>  __('No slider item found', 'striking_admin'),
				'not_found_in_trash' => __('No slider items found in Trash', 'striking_admin'), 
				'parent_item_colon' => '',
				'menu_name' => __('Slider Items', 'striking_admin' ),
			),
			'singular_label' => __('slideshow', 'striking_admin'),
			'public' => false,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			//'menu_position' => 20,
			'capability_type' => 'page',
			'hierarchical' => false,
			'supports' => array('title', 'editor', 'thumbnail' , 'page-attributes'),
			'has_archive' => false,
			'rewrite' => false,
			'query_var' => false,
			'can_export' => true,
			'show_in_nav_menus' => false,
		));
	}

	function register_taxonomy(){
		//register taxonomy for portfolio
		register_taxonomy($this->post_type_taxonomy,$this->post_type,array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x( 'Slider Categories', 'taxonomy general name', 'striking_admin' ),
				'singular_name' => _x( 'Slideshow Category', 'taxonomy singular name', 'striking_admin' ),
				'search_items' =>  __( 'Search Categories', 'striking_admin' ),
				'popular_items' => __( 'Popular Categories', 'striking_admin' ),
				'all_items' => __( 'All Categories', 'striking_admin' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Slideshow Category', 'striking_admin' ), 
				'update_item' => __( 'Update Slideshow Category', 'striking_admin' ),
				'add_new_item' => __( 'Add New Slideshow Category', 'striking_admin' ),
				'new_item_name' => __( 'New Slideshow Category Name', 'striking_admin' ),
				'separate_items_with_commas' => __( 'Separate Slideshow category with commas', 'striking_admin' ),
				'add_or_remove_items' => __( 'Add or remove slideshow category', 'striking_admin' ),
				'choose_from_most_used' => __( 'Choose from the most used slideshow category', 'striking_admin' ),
				'menu_name' => __( 'Categories', 'striking_admin' ),
			),
			'public' => false,
			'show_in_nav_menus' => false,
			'show_ui' => true,
			'show_tagcloud' => false,
			'query_var' => false,
			'rewrite' => false,
		));
	}

	function context_fixer(){
		if ( get_query_var( 'post_type' ) == $this->post_type ) {
			global $wp_query;
			$wp_query->is_home = false;
			$wp_query->is_404 = true;
			$wp_query->is_single = false;
			$wp_query->is_singular = false;
		}
	}

	function admin_init(){
		add_filter('manage_edit-'.$this->post_type.'_columns', array(&$this, 'edit_columns'));
		add_action('manage_posts_custom_column',array(&$this, 'manager_custom_column'), 10, 2);

		if(theme_is_post_type_edit($this->post_type) || theme_is_post_type_new($this->post_type)){
			wp_deregister_script('autosave');
		}
	}

	function edit_columns($columns){
		$columns['slideshow_category'] = __('Categories', 'striking_admin' );
		$columns['author'] = __('Author', 'striking_admin' );
		$columns['thumbnail'] = __('Thumbnail', 'striking_admin' );
		
		return $columns;
	}

	function manager_custom_column($column){
		global $post;
	
		if ($post->post_type == $this->post_type) {
			switch($column){
				case 'thumbnail':
					echo the_post_thumbnail('thumbnail');
					break;
				case "slideshow_category":
					$terms = get_the_terms($post->ID, $this->post_type_taxonomy);
					
					if (! empty($terms)) {
						foreach($terms as $t)
							$output[] = "<a href='edit.php?post_type=".$this->post_type."&".$this->post_type_taxonomy."=$t->slug'> " . esc_html(sanitize_term_field('name', $t->name, $t->term_id, $this->post_type_taxonomy, 'display')) . "</a>";
						$output = implode(', ', $output);
					} else {
						$t = get_taxonomy($this->post_type_taxonomy);
						$output = "No $t->label";
					}
					
					echo $output;
					break;
			}
		}
	}
}
