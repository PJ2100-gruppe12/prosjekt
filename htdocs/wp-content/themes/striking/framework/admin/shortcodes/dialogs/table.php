<?php
return array(
	"title" => __("Table", "striking_admin"),
	"shortcode" => 'styled_table',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Content",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Width",'striking_admin'),
			"desc" => __("You can use % or px as units for width",'striking_admin'),
			"id" => "width",
			"default" => "",
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"units" => array('px','%'),
			'default_unit' => 'px',
			"type" => "measurement",
		),
	),
	"custom" => '',
);