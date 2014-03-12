<?php
return array(
	"title" => __("Search", "striking_admin"),
	"shortcode" => 'search',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Search Button Background Color (optional)",'striking_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Search Button Text Color (optional)",'striking_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
	),
	"custom" => '',
);