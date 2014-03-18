<?php
class Theme_Options_Page_Background extends Theme_Options_Page_With_Tabs {
	public $slug = 'background';

	function __construct(){
		$this->name = sprintf(__('%s Background Settings','theme_admin'),THEME_NAME);
		parent::__construct();
	}

	function tabs(){
		$options = array(
			array(
				"slug" => 'box',
				"name" => __("Boxed layout Background",'theme_admin'),
				"options"=>array(
					array(
						"name" => __("Custom Image",'theme_admin'),
						"id" => "box_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'theme_admin'),
						"desc" => "",
						"id" => "box_position_x",
						"default" => 'center',
						"options" => array(				
							"left" => __('Left','theme_admin'),
							"center" => __('Center','theme_admin'),
							"right" => __('Right','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'theme_admin'),
						"desc" => "",
						"id" => "box_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','theme_admin'),
							"center" => __('Center','theme_admin'),
							"bottom" => __('Bottom','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'theme_admin'),
						"desc" => "",
						"id" => "box_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','theme_admin'),
							"repeat" => __('Tile','theme_admin'),
							"repeat-x" => __('Tile Horizontally','theme_admin'),
							"repeat-y" => __('Tile Vertically','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'theme_admin'),
						"desc" => "",
						"id" => "box_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','theme_admin'),
							"fixed" => __('Fixed','theme_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'header',
				"name" => __("Header Background",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Custom Image",'theme_admin'),
						"id" => "header_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'theme_admin'),
						"desc" => "",
						"id" => "header_position_x",
						"default" => 'center',
						"options" => array(
							"left" => __('Left','theme_admin'),
							"center" => __('Center','theme_admin'),
							"right" => __('Right','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'theme_admin'),
						"desc" => "",
						"id" => "header_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','theme_admin'),
							"center" => __('Center','theme_admin'),
							"bottom" => __('Bottom','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'theme_admin'),
						"desc" => "",
						"id" => "header_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','theme_admin'),
							"repeat" => __('Tile','theme_admin'),
							"repeat-x" => __('Tile Horizontally','theme_admin'),
							"repeat-y" => __('Tile Vertically','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'theme_admin'),
						"desc" => "",
						"id" => "header_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','theme_admin'),
							"fixed" => __('Fixed','theme_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'feature',
				"name" => __("Feature Header Background",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Custom Image",'theme_admin'),
						"id" => "feature_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'theme_admin'),
						"desc" => "",
						"id" => "feature_position_x",
						"default" => 'center',
						"options" => array(
							"left" => __('Left','theme_admin'),
							"center" => __('Center','theme_admin'),
							"right" => __('Right','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'theme_admin'),
						"desc" => "",
						"id" => "feature_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','theme_admin'),
							"center" => __('Center','theme_admin'),
							"bottom" => __('Bottom','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'theme_admin'),
						"desc" => "",
						"id" => "feature_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','theme_admin'),
							"repeat" => __('Tile','theme_admin'),
							"repeat-x" => __('Tile Horizontally','theme_admin'),
							"repeat-y" => __('Tile Vertically','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'theme_admin'),
						"desc" => "",
						"id" => "feature_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','theme_admin'),
							"fixed" => __('Fixed','theme_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'page',
				"name" => __("Page Background",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Custom Image",'theme_admin'),
						"id" => "page_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'theme_admin'),
						"desc" => "",
						"id" => "page_position_x",
						"default" => 'center',
						"options" => array(
							"left" => __('Left','theme_admin'),
							"center" => __('Center','theme_admin'),
							"right" => __('Right','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'theme_admin'),
						"desc" => "",
						"id" => "page_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','theme_admin'),
							"center" => __('Center','theme_admin'),
							"bottom" => __('Bottom','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'theme_admin'),
						"desc" => "",
						"id" => "page_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','theme_admin'),
							"repeat" => __('Tile','theme_admin'),
							"repeat-x" => __('Tile Horizontally','theme_admin'),
							"repeat-y" => __('Tile Vertically','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'theme_admin'),
						"desc" => "",
						"id" => "page_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','theme_admin'),
							"fixed" => __('Fixed','theme_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'footer',
				"name" => __("Footer Background",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Custom Image",'theme_admin'),
						"id" => "footer_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'theme_admin'),
						"desc" => "",
						"id" => "footer_position_x",
						"default" => 'center',
						"options" => array(
							"left" => __('Left','theme_admin'),
							"center" => __('Center','theme_admin'),
							"right" => __('Right','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'theme_admin'),
						"desc" => "",
						"id" => "footer_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','theme_admin'),
							"center" => __('Center','theme_admin'),
							"bottom" => __('Bottom','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'theme_admin'),
						"desc" => "",
						"id" => "footer_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','theme_admin'),
							"repeat" => __('Tile','theme_admin'),
							"repeat-x" => __('Tile Horizontally','theme_admin'),
							"repeat-y" => __('Tile Vertically','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'theme_admin'),
						"desc" => "",
						"id" => "footer_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','theme_admin'),
							"fixed" => __('Fixed','theme_admin'),
						),
						"type" => "select",
					),
				),
			),
		);
		return $options;
	}
}
