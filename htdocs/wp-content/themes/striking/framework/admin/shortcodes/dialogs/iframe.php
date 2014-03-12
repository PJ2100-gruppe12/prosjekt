<?php
return array(
	"title" => __("Iframe", "striking_admin"),
	"shortcode" => 'iframe',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Src",'striking_admin'),
			"id" => "src",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array (
			"name" => __("Width",'striking_admin'),
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
			"name" => __("Height",'striking_admin'),
			"id" => "height",
			"default" => '0',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range",
			'unit' => 'px',
		),
	),
	"custom" => '',
);