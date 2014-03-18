<?php
return array(
	"title" => __("Toggle",'theme_admin'),
	"shortcode" => 'toggle',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Title",'theme_admin'),
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
			"name" => __("Open",'theme_admin'),
			"desc" => __("If true, the toggle will be opened after init.",'theme_admin'),
			"id" => "open",
			"default" => false,
			"type" => "toggle"
		),
	),
	"custom" => '',
);