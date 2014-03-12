<?php
return array(
	"title" => __("Highlight", "striking_admin"),
	"shortcode" => 'highlight',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Type (optional)",'striking_admin'),
			"id" => "type",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"light" => __("light",'striking_admin'),
				"dark" => __("dark",'striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Content",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
	),
	"custom" => '',
);