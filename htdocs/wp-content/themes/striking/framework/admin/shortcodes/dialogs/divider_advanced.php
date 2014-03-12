<?php
return array(
	"title" => __("Advanced Divider Line", "striking_admin"),
	"shortcode" => 'divider_advanced',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Line Color (optional)",'striking_admin'),
			"id" => "color",
			"default" => "",
			"type" => "color"
		),
		array (
			"name" => __("Padding Top (optional)",'striking_admin'),
			"id" => "paddingTop",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Padding Bottom (optional)",'striking_admin'),
			"id" => "paddingBottom",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Thickness (optional)",'striking_admin'),
			"id" => "thickness",
			"default" => '0',
			"min" => 0,
			"max" => 30,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Width (optional)",'striking_admin'),
			"desc" => __("Set a width. Example: '100%', '500px'",'striking_admin'),
			"id" => "width",
			"default" => "",
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"units" => array('px','%'),
			'default_unit' => 'px',
			"type" => "measurement",
		),
		array (
			"name" => __("Show top text",'striking_admin'),
			"id" => "top",
			"default" => false,
			"type" => "toggle"
		),
	),
	"custom" => '',
);