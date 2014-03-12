<?php
class Theme_Metabox_PageGeneral extends Theme_Metabox_With_Tabs {
	public $slug = 'page_general';
	public function config(){
		return array(
			'title' => sprintf(__('%s Page General Options','striking_admin'),THEME_NAME),
			'post_types' => theme_get_option('advanced','page_general'),
			'callback' => '',
			'context' => 'normal',
			'priority' => 'high',
		);
	}

	public function tabs(){
		return array(
			array(
				"name" => __("General Page Setup",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Layout",'striking_admin'),
						"desc" => __("It will override the global blog single layout setting.",'striking_admin'),
						"id" => "_layout",
						"default" => 'default',
						"options" => array(
							"default" => __('Default','striking_admin'),
							"full" => __('Full Width','striking_admin'),
							"right" => __('Right Sidebar','striking_admin'),
							"left" => __('Left Sidebar','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Disable Breadcrumbs",'striking_admin'),
						"desc" => __('Here you can disable breadcrumbs on a post by post basis. Alternatively you can globally disable breadcrumbs under the "General Settings" tab in your theme\'s option panel.','striking_admin'),
						"id" => "_disable_breadcrumb",
						"label" => "Check to disable breadcrumbs on this post",
						"default" => "",
						"type" => "tritoggle"
					),
					array(
						"name" => __("Custom Sidebar",'striking_admin'),
						"desc" => __("Select the custom sidebar that you'd like to be displayed on this.<br />Note: you will need to first create a custom sidebar in your themes option panel before it will show up here.",'striking_admin'),
						"id" => "_sidebar",
						"prompt" => __("Choose one..",'striking_admin'),
						"default" => theme_get_sidebar_default(),
						"options" => theme_get_sidebar_options(),
						"type" => "select",
					),
				),
			),
			array(
				"name" => __("Feature Header Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Feature Header Type",'striking_admin'),
						"desc" => __("Here you can override the general feature header on a post by post basis.",'striking_admin'),
						"id" => "_introduce_text_type",
						"options" => array(
							"default" => "Default",
							"title" => "Title only",
							"custom" => "Custom text only",
							"title_custom" => "Title & custom text",
							"slideshow" => "SlideShow",
							"title_slideshow" => "Title & SlideShow",
							"custom_slideshow" => "custom text & SlideShow",
							"disable" => "Disable",
						),
						"default" => "default",
						"type" => "radios"
					),
					array(
						"name" => __("Feature Header Custom Title",'striking_admin'),
						"desc" => __('If any text you enter here will override your default feature header title.','striking_admin'),
						"id" => "_custom_title",
						"default" => "",
						"class" => 'full',
						"htmlspecialchars" => true,
						"type" => "text"
					),
					array(
						"name" => __("Feature Header Custom Text",'striking_admin'),
						"desc" => __('If the "custom text" option is selected above any text you enter here will override your general feautre header text .','striking_admin'),
						"id" => "_custom_introduce_text",
						"rows" => "2",
						"default" => "",
						"htmlspecialchars" => true,
						"type" => "textarea"
					),
					array(
						"name" => __("SlideShow Source",'striking_admin'),
						"desc" => __("Select which slidershow Source to use. It only available when the type of feature header is slideshow",'striking_admin'),
						"id" => "_slideshow_category",
						"default" => "{s}",
						"options" => array(
							"g" => __('Self Gallery','striking_admin'),
						),
						"chosen" => true,
						"chosen_order" => true,
						"prompt" => __("Select Source..",'striking_admin'),
						"function" => "theme_slideshow_category",
						'target' => 'slideshow_source',
						'process' => 'theme_slidershow_source_process',
						'prepare' => 'theme_slidershow_source_prepare',
						"type" => "multiselect"
					),
					array(
						"name" => __("SlideShow Number",'striking_admin'),
						"desc" => __("Number of Slide items to display.",'striking_admin'),
						"id" => "_slideshow_number",
						"min" => "0",
						"max" => "10",
						"step" => "1",
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("SlideShow Type",'striking_admin'),
						"desc" => __("Select which slidershow type to use.",'striking_admin'),
						"id" => "_slideshow_type",
						"default" => 'nivo',
						"options" => array(
							"nivo" => __('jQuery Nivo Slider','striking_admin'),
							"3d" => __('3D Flash Image Rotator','striking_admin'),
							"kwicks" => __('Accordion Slider','striking_admin'),
							"anything" => __('Anything Slider','striking_admin'),
						),
						"type" => "select",
					),
				)
			),
			array(
				"name" => __("Page Design Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Feature Header Background Color",'striking_admin'),
						"desc" => __("If you specify a color below, this will override the global configuration. Set transparent to disable this.",'striking_admin'),
						"id" => "_introduce_background_color",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Footer Background Color",'striking_admin'),
						"desc" => __("If you specify a color below, this will override the global configuration. Set transparent to disable this.",'striking_admin'),
						"id" => "_footer_background_color",
						"default" => "",
						"type" => "color"
					),
				),
			)
		);
	}
}
