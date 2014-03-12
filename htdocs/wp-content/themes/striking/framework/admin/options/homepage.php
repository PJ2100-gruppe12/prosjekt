<?php
class Theme_Options_Page_Homepage extends Theme_Options_Page_With_Tabs {
	public $slug = 'homepage';

	function __construct(){
		$this->name = sprintf(__('%s Homepage Settings','striking_admin'),THEME_NAME);
		parent::__construct();
	}
	
	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("Homepage General",'striking_admin'),
				"options"=>array(
					array(
						"name" => __("Home Page",'striking_admin'),
						"desc" => __("The page you choose here will display in the homepage. You do not needed to specify a page for homepage unless you want multi-language support.",'striking_admin'),
						"id" => "home_page",
						"page" => 0,
						"chosen" => true,
						"default" => 0,
						"prompt" => __("None",'striking_admin'),
						"type" => "select",
						"process" => "_option_home_page_process"
					),
					array(
						"name" => __("Layout",'striking_admin'),
						"desc" => "",
						"id" => "layout",
						"default" => 'full',
						"options" => array(
							"full" => __('Full Width','striking_admin'),
							"right" => __('Right Sidebar','striking_admin'),
							"left" => __('Left Sidebar','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'slideshow',
				"name" => __("Homepage SlideShow",'striking_admin'),
				"options"=>array(
					array(
						"name" => __("Disable SlideShow",'striking_admin'),
						"desc" => __("If you do not want a home page slideshow, turn on the button.",'striking_admin'),
						"id" => "disable_slideshow",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("SlideShow Source",'striking_admin'),
						"desc" => __("Select which slidershow Source to use on the home page.",'striking_admin'),
						"id" => "slideshow_category",
						"default" => "{s}",
						"chosen" => true,
						"chosen_order" => true,
						"prompt" => __("Select Source..",'striking_admin'),
						'target' => 'slideshow_source',
						'process' => 'theme_slidershow_source_process',
						'prepare' => 'theme_slidershow_source_prepare',
						"type" => "multiselect"
					),
					array(
						"name" => __("SlideShow Number",'striking_admin'),
						"desc" => __("Number of Slide items to display.",'striking_admin'),
						"id" => "slideshow_number",
						"min" => "0",
						"max" => "15",
						"step" => "1",
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("SlideShow Type",'striking_admin'),
						"desc" => __("Select which slidershow type to use on the home page.",'striking_admin'),
						"id" => "slideshow_type",
						"default" => 'nivo',
						"options" => array(
							"nivo" => __('jQuery Nivo Slider','striking_admin'),
							"3d" => __('3D Flash Image Rotator','striking_admin'),
							"kwicks" => __('Accordion Slider','striking_admin'),
							"anything" => __('Anything Slider','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'content',
				"name" => __("Homepage Content Editor",'striking_admin'),
				"options"=>array(
					array(
						"name" => __("Homepage Content Editor",'striking_admin'),
						"desc" => __("The text you enter here will display on the homepage",'striking_admin'),
						"id" => "page_content",
						"default" => '',
						"type" => "editor"
					),
				),
			),
		);
		return $options;
	}

	function _option_home_page_process($option,$value) {
		update_option( 'page_on_front', $value );
		if(!empty($value)){
			update_option( 'show_on_front', 'page' );
		}else{
			if(!get_option('page_for_posts')){
				update_option( 'show_on_front', 'posts' );
			}
		}
		return $value;
	}
}