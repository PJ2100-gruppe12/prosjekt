<?php
return array(
	"title" => __("Search", "theme_admin"),
	"shortcode" => 'search',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Search Button Background Color (optional)",'theme_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Search Button Text Color (optional)",'theme_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
	),
	"custom" => '',
);