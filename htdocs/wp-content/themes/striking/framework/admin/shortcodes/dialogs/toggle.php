<?php
return array(
	"title" => __("Toggle",'striking_admin'),
	"shortcode" => 'toggle',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Title",'striking_admin'),
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
			"name" => __("Open",'striking_admin'),
			"desc" => __("If true, the toggle will be opened after init.",'striking_admin'),
			"id" => "open",
			"default" => false,
			"type" => "toggle"
		),
	),
	"custom" => '',
);