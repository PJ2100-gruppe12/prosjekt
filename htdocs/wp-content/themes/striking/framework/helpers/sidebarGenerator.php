<?php
class sidebarGenerator {
	var $sidebar_names = array();
	var $footer_sidebar_count = 0;
	var $footer_sidebar_names = array();
	
	function sidebarGenerator(){
		$this->sidebar_names = array(
			'home'=>__('Homepage Widget Area','striking_admin'),
			'page'=>__('Page Widget Area','striking_admin'),
			'blog'=>__('Blog Widget Area','striking_admin'),
			'portfolio' =>__('Portfolio Widget Area','striking_admin'),
		);
		$this->footer_sidebar_names = array(
			__('First Footer Widget Area','striking_admin'),
			__('Second Footer Widget Area','striking_admin'),
			__('Third Footer Widget Area','striking_admin'),
			__('Fourth Footer Widget Area','striking_admin'),
			__('Fifth Footer Widget Area','striking_admin'),
			__('Sixth Footer Widget Area','striking_admin'),
		);

	}

	function register_sidebar(){
		foreach ($this->sidebar_names as $name){
			register_sidebar(array(
				'name' => $name,
				'description' => $name,
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			));
		}
		
		//register footer sidebars
		foreach ($this->footer_sidebar_names as $name){
			register_sidebar(array(
				'name' =>  $name,
				'description' => $name,
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			));
		}
		
		$top_area_type = theme_get_option('general','top_area_type');
		if($top_area_type == 'widget'){
			register_sidebar(array(
				'name' =>  __('Header Widget Area','striking_admin'),
				'description' => __('Header Widget Area','striking_admin'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '',
				'after_title' => '',
			));
		}
		$footer_right_area_type = theme_get_option('footer','footer_right_area_type');
		if($footer_right_area_type == 'widget'){
			register_sidebar(array(
				'name' =>  __('Sub Footer Widget Area','striking_admin'),
				'description' => __('Sub Footer Widget Area','striking_admin'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '',
				'after_title' => '',
			));
		}
		
		//register custom sidebars
		$custom_sidebars = theme_get_option('sidebar','sidebars');
		if(!empty($custom_sidebars)){
			$custom_sidebar_names = explode(',',$custom_sidebars);
			foreach ($custom_sidebar_names as $name){
				register_sidebar(array(
					'name' =>  $name,
					'description' => $name,
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget' => '</section>',
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => '</h3>',
				));
			}
		}
	}
	
	function get_sidebar($post_id){
		if(is_page()){
			$sidebar = $this->sidebar_names['page'];
		}
		if(is_front_page() || $post_id == theme_get_option('homepage','home_page') ){
			$home_page_id = theme_get_option('homepage','home_page');
			$post_id = wpml_get_object_id($home_page_id,'page');
			$sidebar = $this->sidebar_names['home'];
		}
		if(is_blog()){
			$sidebar = $this->sidebar_names['blog'];
		}
		if(is_singular('post')){
			$sidebar = $this->sidebar_names['blog'];
		}elseif(is_singular('portfolio')){
			$sidebar = $this->sidebar_names['portfolio'];
		}
		if(is_search() || is_archive()){
			$sidebar = $this->sidebar_names['blog'];
		}

		if(theme_get_option('advanced', 'woocommerce')){
			if(is_singular( array('product') )){
				$custom = theme_get_option('advanced','woocommerce_product_sidebar');
				if(!empty($custom)){
					$sidebar = $custom;
				}
			}
			if(function_exists('is_post_type_archive')){
				if(is_post_type_archive('product')){
					$custom = theme_get_option('advanced','woocommerce_shop_sidebar');
					if(!empty($custom)){
						$sidebar = $custom;
					}else{
						unset($sidebar);
					}
				}
			}
			if(is_tax( 'product_cat' )){
				$custom = theme_get_option('advanced','woocommerce_cat_sidebar');
				if(!empty($custom)){
					$sidebar = $custom;
				}else{
					unset($sidebar);
				}
			}
			if(is_tax( 'product_tag' )){
				$custom = theme_get_option('advanced','woocommerce_tag_sidebar');
				if(!empty($custom)){
					$sidebar = $custom;
				}else{
					unset($sidebar);
				}
			}
		}
		if(!empty($post_id)){
			$custom = get_post_meta($post_id, '_sidebar', true);
			if(!empty($custom)){
				$sidebar = $custom;
			}
		}
		if(isset($sidebar)){
			dynamic_sidebar($sidebar);
		}
	}
	
	function get_footer_sidebar(){
		dynamic_sidebar($this->footer_sidebar_names[$this->footer_sidebar_count]);
		$this->footer_sidebar_count++;
	}
}
global $_sidebarGenerator;
$_sidebarGenerator = new sidebarGenerator;

add_action('widgets_init', array($_sidebarGenerator,'register_sidebar'));

function sidebar_generator($function){
	global $_sidebarGenerator;
	$args = array_slice( func_get_args(), 1 );
	return call_user_func_array(array( &$_sidebarGenerator, $function ), $args );
}