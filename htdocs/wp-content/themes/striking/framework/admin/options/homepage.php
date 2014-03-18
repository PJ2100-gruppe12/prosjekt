<?php
class Theme_Options_Page_Homepage extends Theme_Options_Page_With_Tabs {
	public $slug = 'homepage';

	function __construct(){
		$this->name = sprintf(__('%s Homepage Settings','theme_admin'),THEME_NAME);
		parent::__construct();
	}
	
	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("Homepage General",'theme_admin'),
				"options"=>array(
					array(
						"name" => __("Home Page",'theme_admin'),
						"desc" => __("<p align='justify'>The page you choose here will display as the home page of your site. &nbsp;One does not needed to set a specific page as the site home page unless one requires multi-language support, however, a custom page set as a home page for a site provides more editing options then what is provided in this homepage panel -->> which is really intended as a &#34;quick starter&#34; home page for the site.</p><p align='justify'>If one does not select a custom page then the site has what is called a &#34;non-static&#34; homepage and in the selector below, it will show &#34;None&#34; when one has not selected a custom page for a homepage.</p><p align='justify'>If one does not set a custom page as the site homepage, then proceed to the HomePage Slideshow Tab and Homepage Content tab to create content for your site homepage.",'theme_admin'),
						"id" => "home_page",
						"page" => 0,
						"chosen" => true,
						"default" => 0,
						"prompt" => __("None",'theme_admin'),
						"type" => "select",
						"process" => "_option_home_page_process"
					),
					array(
						"name" => __("Home Page Layout",'theme_admin'),
					"desc" => __("<p align='justify'>If proceeding to use this Homepage Panel content editor as the basis for content of the site Home page, then use this Layout setting to determine the appearence, the choices being full width, left sidebar and right sidebar. &nbsp;If one has set a custom page for the site home page (which in wordpress terminology is called a &#34;static page&#34;), then this setting is not applicable.</p>",'theme_admin'),	
						"id" => "layout",
						"default" => 'full',
						"options" => array(
							"full" => __('Full Width','theme_admin'),
							"right" => __('Right Sidebar','theme_admin'),
							"left" => __('Left Sidebar','theme_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'slideshow',
				"name" => __("Homepage SlideShow",'theme_admin'),
				"options"=>array(
					array(
						"name" => __("Disable SlideShow",'theme_admin'),
						"desc" => __("If you do not want a home page slideshow, turn on the button.",'theme_admin'),
						"id" => "disable_slideshow",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("SlideShow Source",'theme_admin'),
						"desc" => __("Select which slidershow Source to use on the home page.",'theme_admin'),
						"id" => "slideshow_category",
						"default" => "{s}",
						"chosen" => true,
						"chosen_order" => true,
						"prompt" => __("Select Source..",'theme_admin'),
						'target' => 'slideshow_source',
						'process' => 'theme_slidershow_source_process',
						'prepare' => 'theme_slidershow_source_prepare',
						"type" => "multiselect"
					),
					array(
						"name" => __("SlideShow Number",'theme_admin'),
						"desc" => __("Number of Slide items to display.",'theme_admin'),
						"id" => "slideshow_number",
						"min" => "0",
						"max" => "15",
						"step" => "1",
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("SlideShow Type",'theme_admin'),
						"desc" => __("Select which slidershow type to use on the home page.",'theme_admin'),
						"id" => "slideshow_type",
						"default" => 'nivo',
						"options" => array(
							"nivo" => __('jQuery Nivo Slider','theme_admin'),
							"3d" => __('3D Flash Image Rotator','theme_admin'),
							"kwicks" => __('Accordion Slider','theme_admin'),
							"anything" => __('Anything Slider','theme_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'content',
				"name" => __("Homepage Content Editor",'theme_admin'),
				"options"=>array(
					array(
						"name" => __("Homepage Content Editor",'theme_admin'),
						"desc" => __("The text you enter here will display on the homepage",'theme_admin'),
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