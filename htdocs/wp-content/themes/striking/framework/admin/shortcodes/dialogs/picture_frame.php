<?php
return array(
	"title" => __("Picture Frame", "striking_admin"),
	"shortcode" => 'picture_frame',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Image Source Url",'striking_admin'),
			"id" => "source",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => __("Image Title (optional)",'striking_admin'),
			"id" => "title",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Align (optional)",'striking_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"left" => __('Left','striking_admin'),
				"right" => __('Right','striking_admin'),
				"center" => __('Center','striking_admin'),
			),
			"type" => "select",
		),
	),
	"custom" => '',
);