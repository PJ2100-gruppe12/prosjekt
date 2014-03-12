<?php
class Theme_Options_Page_Background extends Theme_Options_Page_With_Tabs {
	public $slug = 'background';

	function __construct(){
		$this->name = sprintf(__('%s Background Settings','striking_admin'),THEME_NAME);
		parent::__construct();
	}

	function tabs(){
		$options = array(
			array(
				"slug" => 'box',
				"name" => __("Boxed layout Background",'striking_admin'),
				"options"=>array(
					array(
						"name" => __("Custom Image",'striking_admin'),
						"id" => "box_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'striking_admin'),
						"desc" => "",
						"id" => "box_position_x",
						"default" => 'center',
						"options" => array(				
							"left" => __('Left','striking_admin'),
							"center" => __('Center','striking_admin'),
							"right" => __('Right','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'striking_admin'),
						"desc" => "",
						"id" => "box_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','striking_admin'),
							"center" => __('Center','striking_admin'),
							"bottom" => __('Bottom','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'striking_admin'),
						"desc" => "",
						"id" => "box_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','striking_admin'),
							"repeat" => __('Tile','striking_admin'),
							"repeat-x" => __('Tile Horizontally','striking_admin'),
							"repeat-y" => __('Tile Vertically','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'striking_admin'),
						"desc" => "",
						"id" => "box_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','striking_admin'),
							"fixed" => __('Fixed','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'header',
				"name" => __("Header Background",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Custom Image",'striking_admin'),
						"id" => "header_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'striking_admin'),
						"desc" => "",
						"id" => "header_position_x",
						"default" => 'center',
						"options" => array(
							"left" => __('Left','striking_admin'),
							"center" => __('Center','striking_admin'),
							"right" => __('Right','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'striking_admin'),
						"desc" => "",
						"id" => "header_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','striking_admin'),
							"center" => __('Center','striking_admin'),
							"bottom" => __('Bottom','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'striking_admin'),
						"desc" => "",
						"id" => "header_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','striking_admin'),
							"repeat" => __('Tile','striking_admin'),
							"repeat-x" => __('Tile Horizontally','striking_admin'),
							"repeat-y" => __('Tile Vertically','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'striking_admin'),
						"desc" => "",
						"id" => "header_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','striking_admin'),
							"fixed" => __('Fixed','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'feature',
				"name" => __("Feature Header Background",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Custom Image",'striking_admin'),
						"id" => "feature_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'striking_admin'),
						"desc" => "",
						"id" => "feature_position_x",
						"default" => 'center',
						"options" => array(
							"left" => __('Left','striking_admin'),
							"center" => __('Center','striking_admin'),
							"right" => __('Right','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'striking_admin'),
						"desc" => "",
						"id" => "feature_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','striking_admin'),
							"center" => __('Center','striking_admin'),
							"bottom" => __('Bottom','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'striking_admin'),
						"desc" => "",
						"id" => "feature_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','striking_admin'),
							"repeat" => __('Tile','striking_admin'),
							"repeat-x" => __('Tile Horizontally','striking_admin'),
							"repeat-y" => __('Tile Vertically','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'striking_admin'),
						"desc" => "",
						"id" => "feature_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','striking_admin'),
							"fixed" => __('Fixed','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'page',
				"name" => __("Page Background",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Custom Image",'striking_admin'),
						"id" => "page_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'striking_admin'),
						"desc" => "",
						"id" => "page_position_x",
						"default" => 'center',
						"options" => array(
							"left" => __('Left','striking_admin'),
							"center" => __('Center','striking_admin'),
							"right" => __('Right','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'striking_admin'),
						"desc" => "",
						"id" => "page_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','striking_admin'),
							"center" => __('Center','striking_admin'),
							"bottom" => __('Bottom','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'striking_admin'),
						"desc" => "",
						"id" => "page_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','striking_admin'),
							"repeat" => __('Tile','striking_admin'),
							"repeat-x" => __('Tile Horizontally','striking_admin'),
							"repeat-y" => __('Tile Vertically','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'striking_admin'),
						"desc" => "",
						"id" => "page_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','striking_admin'),
							"fixed" => __('Fixed','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'footer',
				"name" => __("Footer Background",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Custom Image",'striking_admin'),
						"id" => "footer_image",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Position X",'striking_admin'),
						"desc" => "",
						"id" => "footer_position_x",
						"default" => 'center',
						"options" => array(
							"left" => __('Left','striking_admin'),
							"center" => __('Center','striking_admin'),
							"right" => __('Right','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Position Y",'striking_admin'),
						"desc" => "",
						"id" => "footer_position_y",
						"default" => 'top',
						"options" => array(				
							"top" => __('Top','striking_admin'),
							"center" => __('Center','striking_admin'),
							"bottom" => __('Bottom','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Repeat",'striking_admin'),
						"desc" => "",
						"id" => "footer_repeat",
						"default" => 'no-repeat',
						"options" => array(
							"no-repeat" => __('No Repeat','striking_admin'),
							"repeat" => __('Tile','striking_admin'),
							"repeat-x" => __('Tile Horizontally','striking_admin'),
							"repeat-y" => __('Tile Vertically','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Attachment",'striking_admin'),
						"desc" => "",
						"id" => "footer_attachment",
						"default" => 'scroll',
						"options" => array(
							"scroll" => __('Scroll','striking_admin'),
							"fixed" => __('Fixed','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
		);
		return $options;
	}
}
