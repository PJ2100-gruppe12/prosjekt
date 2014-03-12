<?php
return array(
	"title" => __("Framed Box", "striking_admin"),
	"shortcode" => 'framed_box',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Content",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array (
			"name" => __("Width (optional)",'striking_admin'),
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
			"name" => __("Height (optional)",'striking_admin'),
			"id" => "height",
			"default" => '0',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			'unit' => 'px',
			"type" => "range",
		),
		array(
			"name" => __("Background Color (optional)",'striking_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Text Color (optional)",'striking_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
		array (
			"name" => __("Rounded",'striking_admin'),
			"id" => "rounded",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" =>  __("Align (optional)",'striking_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("None",'striking_admin'),
			"options" => array(
				"left" => __('left','striking_admin'),
				"right" => __('right','striking_admin'),
				"center" => __('center','striking_admin'),
			),
			"type" => "select",
		),
	),
	"custom" => '',
);