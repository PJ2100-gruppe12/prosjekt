<?php
return array(
	"title" => __("Advanced Divider Line", "theme_admin"),
	"shortcode" => 'divider_advanced',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Line Color (optional)",'theme_admin'),
			"id" => "color",
			"default" => "",
			"type" => "color"
		),
		array (
			"name" => __("Padding Top (optional)",'theme_admin'),
			"id" => "paddingTop",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Padding Bottom (optional)",'theme_admin'),
			"id" => "paddingBottom",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Thickness (optional)",'theme_admin'),
			"id" => "thickness",
			"default" => '0',
			"min" => 0,
			"max" => 30,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Width (optional)",'theme_admin'),
			"desc" => __("Set a width. Example: '100%', '500px'",'theme_admin'),
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
			"name" => __("Show top text",'theme_admin'),
			"id" => "top",
			"default" => false,
			"type" => "toggle"
		),
	),
	"custom" => '',
);