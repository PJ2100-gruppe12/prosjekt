<?php
return array(
	"title" => __("Button", "striking_admin"),
	"shortcode" => 'button',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Id (optional)",'striking_admin'),
			"id" => "id",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Class (optional)",'striking_admin'),
			"id" => "class",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Size",'striking_admin'),
			"id" => "size",
			"default" => 'small',
			"options" => array(
				"small" => __("Small",'striking_admin'),
				"medium" => __("Medium",'striking_admin'),
				"large" => __("Large",'striking_admin'),
			),
			"type" => "select",
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
		array (
			"name" => __("Full",'striking_admin'),
			"id" => "full",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Link (optional)",'striking_admin'),
			"id" => "link",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Link Target (optional)",'striking_admin'),
			"id" => "linkTarget",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"_blank" => __('Load in a new window','striking_admin'),
				"_self" => __('Load in the same frame as it was clicked','striking_admin'),
				"_parent" => __('Load in the parent frameset','striking_admin'),
				"_top" => __('Load in the full body of the window','striking_admin'),
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
				"white" => 'White',
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
			"name" => __("Background Color (optional)",'striking_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Text Color (optional)",'striking_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Hover Background Color (optional)",'striking_admin'),
			"id" => "hoverBgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Hover Text Color (optional)",'striking_admin'),
			"id" => "hoverTextColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Text",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "text",
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
		array (
			"name" => __("Nofollow",'striking_admin'),
			"id" => "nofollow",
			"default" => false,
			"type" => "toggle"
		),
	),
);
