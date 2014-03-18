<?php
return array(
	"title" => __("Contact Form", "theme_admin"),
	"shortcode" => 'contactform',
	"type" => 'both',
	"options" => array(
		array(
			"name" => __("email (optional)",'theme_admin'),
			"id" => "email",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Success Text (optional)",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Submit Button Text (optional)",'theme_admin'),
			"id" => "submit",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Submit Button Background Color (optional)",'theme_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Submit Button Text Color (optional)",'theme_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
	),
	"custom" => '',
);