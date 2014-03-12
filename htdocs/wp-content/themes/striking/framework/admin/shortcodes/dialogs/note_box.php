<?php
return array(
	"title" => __("Note Box", "striking_admin"),
	"shortcode" => 'note',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("title (optional)",'striking_admin'),
			"id" => "title",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Content",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  __("Align (optional)",'striking_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"left" => __('left','striking_admin'),
				"right" => __('right','striking_admin'),
				"center" => __('center','striking_admin'),
			),
			"type" => "select",
		),
		array (
			"name" => __("Width (optional)",'striking_admin'),
			"id" => "width",
			"default" => '0',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
	),
	"custom" => '',
);