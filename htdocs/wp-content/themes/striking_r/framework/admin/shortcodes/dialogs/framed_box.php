<?php
return array(
	"title" => __("Framed Box", "theme_admin"),
	"shortcode" => 'framed_box',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Content",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array (
			"name" => __("Width (optional)",'theme_admin'),
			"id" => "width",
			"default" => '',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"units" => array('px','%'),
			'default_unit' => 'px',
			"type" => "measurement",
		),
		array (
			"name" => __("Height (optional)",'theme_admin'),
			"id" => "height",
			"default" => '0',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			'unit' => 'px',
			"type" => "range",
		),
		array(
			"name" => __("Background Color (optional)",'theme_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Border Color (optional)",'theme_admin'),
			"id" => "borderColor",
			"default" => "",
			"format" => "hex",
			"type" => "color"
		),
		array (
			"name" => __("Border Thickness (optional)",'theme_admin'),
			"id" => "borderThickness",
			"default" => '1',
			"min" => 0,
			"max" => 20,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Text Color (optional)",'theme_admin'),
			"id" => "textColor",
			"default" => "",
			"format" => "hex",
			"type" => "color"
		),
		array (
			"name" => __("Rounded",'theme_admin'),
			"id" => "rounded",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" =>  __("Align (optional)",'theme_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("None",'theme_admin'),
			"options" => array(
				"left" => __('left','theme_admin'),
				"right" => __('right','theme_admin'),
				"center" => __('center','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Class (optional)",'theme_admin'),
			"id" => "class",
			"default" => "",
			"type" => "text"
		),
	),
	"custom" => '',
);