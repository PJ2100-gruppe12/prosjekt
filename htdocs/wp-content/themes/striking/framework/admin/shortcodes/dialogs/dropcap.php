<?php
return array(
	"title" => __("Drop Cap", "striking_admin"),
	"shortcode" => 'dropcap',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Style",'striking_admin'),
			"id" => "style",
			"default" => 'dropcap1',
			"options" => array(
				"dropcap1" => 'dropcap1',
				"dropcap2" => 'dropcap2',
				"dropcap3" => 'dropcap3',
				"dropcap4" => 'dropcap4',
			),
			"type" => "select",
		),
		array(
			"name" => __("Color (optional)",'striking_admin'),
			"id" => "color",
			"default" => "",
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"black" => 'Black',
				"gray" => 'Gray',
				"red" => 'Red',
				"yellow" => 'Yellow',
				"blue" => 'Blue',
				"pink" => 'Pink',
				"green" => 'Green',
				"rosy" => 'Rosy',
				"orange" => 'Orange',
				"magenta" => 'Magenta',
			),
			"type" => "select",
		),
		array(
			"name" => __("Content",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "text"
		),
	),
	"custom" => '',
);