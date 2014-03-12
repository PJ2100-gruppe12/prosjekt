<?php
return array(
	"title" => __("Blog", "striking_admin"),
	"shortcode" => 'blog',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Column",'striking_admin'),
			"id" => "column",
			"default" => '1',
			"options" => array(
				"1" => sprintf(__("%d Column",'striking_admin'),1),
				"2" => sprintf(__("%d Columns",'striking_admin'),2),
				"3" => sprintf(__("%d Columns",'striking_admin'),3),
				"4" => sprintf(__("%d Columns",'striking_admin'),4),
				"5" => sprintf(__("%d Columns",'striking_admin'),5),
				"6" => sprintf(__("%d Columns",'striking_admin'),6),
			),
			"type" => "select",
		),
		array(
			"name" => __("Grid",'striking_admin'),
			"id" => "grid",
			"desc" => __("If the option is on, it will use grid layout for multiple column.",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Frame",'striking_admin'),
			"desc" => __("If the toggle is on the middle, it will use the setting on striking->blog options page.",'striking_admin'),
			"id" => "frame",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Frame Background Color (optional)",'striking_admin'),
			"id" => "frame_bgColor",
			"default" => '',
			"type" => "color"
		),
		array(
			"name" => __("Frame Border Color (optional)",'striking_admin'),
			"id" => "frame_borderColor",
			"default" => '',
			"type" => "color"
		),
		array(
			"name" => __("Frame Border Thickness (optional)",'striking_admin'),
			"id" => "frame_borderThickness",
			"default" => 1,
			"min" => 1,
			"max" => 20,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Divider Line Color (optional)",'striking_admin'),
			"id" => "divider_color",
			"default" => '',
			"type" => "color"
		),
		array(
			"name" => __("Count",'striking_admin'),
			"desc" => __("Number of posts to show per page",'striking_admin'),
			"id" => "count",
			"default" => '3',
			"min" => 1,
			"max" => 50,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Category (optional)",'striking_admin'),
			"id" => "cat",
			"default" => '',
			"target" => 'cat',
			"chosen" => true,
			"prompt" => __("Select Categories..",'striking_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Multiple Categories (optional)",'striking_admin'),
			"desc" => __("Display posts that are in multiple categories.",'striking_admin'),
			"id" => "category__and",
			"default" => '',
			"target" => 'cat',
			"chosen" => true,
			"prompt" => __("Select Categories..",'striking_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Exclude Categorie (optional)",'striking_admin'),
			"id" => "category__not_in",
			"default" => '',
			"target" => 'cat',
			"chosen" => true,
			"prompt" => __("Select Categories..",'striking_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Posts (optional)",'striking_admin'),
			"desc" => __("The specific posts you want to display",'striking_admin'),
			"id" => "posts",
			"default" => array(),
			"chosen" => true,
			"target" => 'post',
			"prompt" => __("Select Posts..",'striking_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Author (optional)",'striking_admin'),
			"id" => "author",
			"default" => array(),
			"chosen" => true,
			"target" => 'author',
			"prompt" => __("Select Authors..",'striking_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Image",'striking_admin'),
			"id" => "image",
			"desc" => __("If the option is on, it will display Featured Image of blog post",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("imageType",'striking_admin'),
			"id" => "imageType",
			"default" => '',
			"options" => array(
				"default" => __("Default",'striking_admin'),
				"full" => __("Full Width",'striking_admin'),
				"left" => __("Left Float",'striking_admin'),
				"right" => __("Right Float",'striking_admin'),
				"below" => __('Below Title','striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Width",'striking_admin'),
			"desc" => __("The width of Image",'striking_admin'),
			"id" => "width",
			"default" => '630',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Height (optional)",'striking_admin'),
			"desc" => __("The height of Feature image.",'striking_admin'),
			"id" => "height",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"unit" => 'px',
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Title",'striking_admin'),
			"id" => "title",
			"desc" => __("If the option is on, it will display Title of blog post",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Meta Information",'striking_admin'),
			"id" => "meta",
			"desc" => __("If the option is on, it will display Meta Information of blog post",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Description",'striking_admin'),
			"id" => "desc",
			"desc" => __("If the option is on, it will display Description of blog post",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Length of Description",'striking_admin'),
			"desc" => __("If it's set to 0, it will use default setting",'striking_admin'),
			"id" => "desc_length",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Display Read More",'striking_admin'),
			"id" => "read_more",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Read More Text",'striking_admin'),
			"id" => "read_more_text",
			"default" => theme_get_option('blog','read_more_text'),
			"type" => "text",
		),
		array(
			"name" => __("Display Read More as button",'striking_admin'),
			"id" => "read_more_button",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Display Full Post",'striking_admin'),
			"id" => "full",
			"desc" => __("If the option is on, it will display all content of the post",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Nopaging",'striking_admin'),
			"id" => "nopaging",
			"desc" => __("If the option is on, it will disable pagination",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Offset",'striking_admin'),
			"desc" => __("Number of post to displace or pass over.",'striking_admin'),
			"id" => "offset",
			"default" => '0',
			"min" => 0,
			"max" => 10,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Effect",'striking_admin'),
			"desc" => __("Effect when hover the feature image.",'striking_admin'),
			"id" => "effect",
			"default" => 'default',
			"options" => array(
				"default" => __("Default",'striking_admin'),
				"icon" => __("Icon",'striking_admin'),
				"grayscale" => __("Grayscale",'striking_admin'),
				"none" => __("None",'striking_admin'),
			),
			"type" => "select",
		),
	),
);
