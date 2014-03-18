<?php
return array(
	"title" => __("Button", "theme_admin"),
	"shortcode" => 'button',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Id (optional)",'theme_admin'),
			"id" => "id",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Class (optional)",'theme_admin'),
			"id" => "class",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Size",'theme_admin'),
			"id" => "size",
			"default" => 'small',
			"options" => array(
				"small" => __("Small",'theme_admin'),
				"medium" => __("Medium",'theme_admin'),
				"large" => __("Large",'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Align (optional)",'theme_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"left" => __('Left','theme_admin'),
				"right" => __('Right','theme_admin'),
				"center" => __('Center','theme_admin'),
			),
			"type" => "select",
		),
		array (
			"name" => __("Full",'theme_admin'),
			"id" => "full",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Link (optional)",'theme_admin'),
			"id" => "link",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Link Target (optional)",'theme_admin'),
			"id" => "linkTarget",
			"default" => '',
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"_blank" => __('Load in a new window','theme_admin'),
				"_self" => __('Load in the same frame as it was clicked','theme_admin'),
				"_parent" => __('Load in the parent frameset','theme_admin'),
				"_top" => __('Load in the full body of the window','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Color (optional)",'theme_admin'),
			"id" => "color",
			"default" => "",
			"prompt" => __("Choose one..",'theme_admin'),
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
			"name" => __("Background Color (optional)",'theme_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Text Color (optional)",'theme_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Hover Background Color (optional)",'theme_admin'),
			"id" => "hoverBgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Hover Text Color (optional)",'theme_admin'),
			"id" => "hoverTextColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Text",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "text",
		),
		array (
			"name" => __("Width (optional)",'theme_admin'),
			"id" => "width",
			"default" => '0',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Nofollow",'theme_admin'),
			"id" => "nofollow",
			"default" => false,
			"type" => "toggle"
		),
	),
);
