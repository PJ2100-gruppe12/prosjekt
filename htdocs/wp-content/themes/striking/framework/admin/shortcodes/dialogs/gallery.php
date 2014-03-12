<?php
return array(
	"title" => __("Gallery", "striking_admin"),
	"shortcode" => 'gallery',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Gallery Columns",'striking_admin'),
			"id" => "columns",
			"default" => '3',
			"options" => array(
				"1" => '1',
				"2" => '2',
				"3" => '3',
				"4" => '4',
				"5" => '5',
				"6" => '6',
				"7" => '7',
				"8" => '8',
			),
			"type" => "select",
		),
		array(
			"name" => __("Order",'striking_admin'),
			"id" => "order",
			"default" => 'ASC',
			"options" => array(
				"DESC" => __('DESC','striking_admin'),
				"ASC" => __('ASC','striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Order By (optional)",'striking_admin'),
			'desc' => __("specify the item used to sort the display thumbnails",'striking_admin'),
			"id" => "orderby",
			"default" => 'menu_order',
			"options" => array(
				"menu_order" => __('Menu order','striking_admin'),
				"title" => __('Title','striking_admin'),
				"ID" => __('Date/Time','striking_admin'),
				"rand" => __('Random','striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Size (optional)",'striking_admin'),
			'desc' => __("specify the image size to use for the thumbnail display.",'striking_admin'),
			"id" => "size",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"thumbnail" => __('Thumbnail','striking_admin'),
				"medium" => __('Medium','striking_admin'),
				"large" => __('Large','striking_admin'),
				"full" => __('Full','striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("link",'striking_admin'),
			'desc' => __("If you set it to lightbox, when you click on the image, it will open as a lightbox.",'striking_admin'),
			"id" => "link",
			"default" => 'post',
			"options" => array(
				"file" => __('Lightbox','striking_admin'),
				"post" => __('Attachment Page','striking_admin'),
			),
			"type" => "select",
		),
		array (
			"name" => __("Caption",'striking_admin'),
			"id" => "caption",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Lightbox Title",'striking_admin'),
			"id" => "lightboxtitle",
			"default" => 'caption',
			"options" => array(
				"caption" => __('Caption of Image','striking_admin'),
				"title" => __('Title of Image','striking_admin'),
				"none" => __('None','striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Lightbox Image Dimension Restriction",'striking_admin'),
			"desc" => __("If you enable this option, the lightbox dimension will be restricted to fit the browse screen size.",'striking_admin'),
			"id" => "lightbox_fittoview",
			"default" => true,
			"type" => "toggle"
		),
	),
	"custom" => '',
);