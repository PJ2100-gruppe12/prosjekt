<?php
return array(
	"title" => __("Note Box", "theme_admin"),
	"shortcode" => 'note',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("title (optional)",'theme_admin'),
			"id" => "title",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Content",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  __("Align (optional)",'theme_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"left" => __('left','theme_admin'),
				"right" => __('right','theme_admin'),
				"center" => __('center','theme_admin'),
			),
			"type" => "select",
		),
		array (
			"name" => __("Width (optional)",'theme_admin'),
			"id" => "width",
			"default" => '0',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		)
	),
	"custom" => '',
);