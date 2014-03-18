<?php
class Theme_Metabox_PageGeneral extends Theme_Metabox_With_Tabs {
	public $slug = 'page_general';
	public function config(){
		return array(
			'title' => sprintf(__('%s Page General Options','theme_admin'),THEME_NAME),
			'post_types' => theme_get_option('advanced','page_general'),
			'callback' => '',
			'context' => 'normal',
			'priority' => 'high',
		);
	}

	public function tabs(){
		return array(
			array(
				"name" => __("General Page Setup",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Layout",'theme_admin'),
						"desc" => __("It will override the global blog single layout setting.",'theme_admin'),
						"id" => "_layout",
						"default" => 'default',
						"options" => array(
							"default" => __('Default','theme_admin'),
							"full" => __('Full Width','theme_admin'),
							"right" => __('Right Sidebar','theme_admin'),
							"left" => __('Left Sidebar','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Disable Breadcrumbs",'theme_admin'),
						"desc" => __('Here you can disable breadcrumbs on a post by post basis. Alternatively you can globally disable breadcrumbs under the "General Settings" tab in your theme\'s option panel.','theme_admin'),
						"id" => "_disable_breadcrumb",
						"label" => "Check to disable breadcrumbs on this post",
						"default" => "",
						"type" => "tritoggle"
					),
					array(
						"name" => __("Custom Sidebar",'theme_admin'),
						"desc" => __("Select the custom sidebar that you'd like to be displayed on this.<br />Note: you will need to first create a custom sidebar in your themes option panel before it will show up here.",'theme_admin'),
						"id" => "_sidebar",
						"prompt" => __("Choose one..",'theme_admin'),
						"default" => theme_get_sidebar_default(),
						"options" => theme_get_sidebar_options(),
						"type" => "select",
					),
				),
			),
			array(
				"name" => __("Feature Header Settings",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Feature Header Type",'theme_admin'),
						"desc" => __("Here you can override the general feature header on a post by post basis.",'theme_admin'),
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
						"name" => __("Feature Header Custom Title",'theme_admin'),
						"desc" => __('If any text you enter here will override your default feature header title.','theme_admin'),
						"id" => "_custom_title",
						"default" => "",
						"class" => 'full',
						"htmlspecialchars" => true,
						"type" => "text"
					),
					array(
						"name" => __("Feature Header Custom Text",'theme_admin'),
						"desc" => __('If the "custom text" option is selected above any text you enter here will override your general feautre header text .','theme_admin'),
						"id" => "_custom_introduce_text",
						"rows" => "2",
						"default" => "",
						"htmlspecialchars" => true,
						"type" => "textarea"
					),
					array(
						"name" => __("SlideShow Source",'theme_admin'),
						"desc" => __("Select which slidershow Source to use. It only available when the type of feature header is slideshow",'theme_admin'),
						"id" => "_slideshow_category",
						"default" => "{s}",
						"options" => array(
							"g" => __('Self Gallery','theme_admin'),
						),
						"chosen" => true,
						"chosen_order" => true,
						"prompt" => __("Select Source..",'theme_admin'),
						"function" => "theme_slideshow_category",
						'target' => 'slideshow_source',
						'process' => 'theme_slidershow_source_process',
						'prepare' => 'theme_slidershow_source_prepare',
						"type" => "multiselect"
					),
					array(
						"name" => __("SlideShow Number",'theme_admin'),
						"desc" => __("Number of Slide items to display.",'theme_admin'),
						"id" => "_slideshow_number",
						"min" => "0",
						"max" => "20",
						"step" => "1",
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("SlideShow Type",'theme_admin'),
						"desc" => __("Select which slidershow type to use.",'theme_admin'),
						"id" => "_slideshow_type",
						"default" => 'nivo',
						"options" => array(
							"nivo" => __('jQuery Nivo Slider','theme_admin'),
							"3d" => __('3D Flash Image Rotator','theme_admin'),
							"kwicks" => __('Accordion Slider','theme_admin'),
							"anything" => __('Anything Slider','theme_admin'),
						),
						"type" => "select",
					),
				)
			),
			array(
				"name" => __("Page Design Settings",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Feature Header Background Color",'theme_admin'),
						"desc" => __("If you specify a color below, this will override the global configuration. Set transparent to disable this.",'theme_admin'),
						"id" => "_introduce_background_color",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Footer Background Color",'theme_admin'),
						"desc" => __("If you specify a color below, this will override the global configuration. Set transparent to disable this.",'theme_admin'),
						"id" => "_footer_background_color",
						"default" => "",
						"type" => "color"
					),
				),
			)
		);
	}
}
