<?php
return array(
	"title" => __("Categories", "striking_admin"),
	"shortcode" => 'categories',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Display as dropdown",'striking_admin'),
			"id" => "dropdown",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Show post counts",'striking_admin'),
			"id" => "count",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Show hierarchy",'striking_admin'),
			"id" => "hierarchy",
			"default" => false,
			"type" => "toggle"
		),
	),
);
