<?php
return array(
	"title" => __("Blockquote", "striking_admin"),
	"shortcode" => 'blockquote',
	"type" => 'enclosing',
	"options" => array(
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
		array(
			"name" => __("Cite (optional)",'striking_admin'),
			"id" => "cite",
			"default" => "",
			"type" => "text",
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