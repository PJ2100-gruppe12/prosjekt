<?php
return array(
	"title" => __("Contact Form", "striking_admin"),
	"shortcode" => 'contactform',
	"type" => 'both',
	"options" => array(
		array(
			"name" => __("email (optional)",'striking_admin'),
			"id" => "email",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Success Text (optional)",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Submit Button Text (optional)",'striking_admin'),
			"id" => "submit",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Submit Button Background Color (optional)",'striking_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Submit Button Text Color (optional)",'striking_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
	),
	"custom" => '',
);