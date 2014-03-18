<?php
return array(
	"title" => __("Recent Posts",'theme_admin'),
	"shortcode" => 'recent_posts',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Count",'theme_admin'),
			"desc" => "",
			"id" => "count",
			"default" => '4',
			"min" => 0,
			"max" => 30,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Thumbnail",'theme_admin'),
			"id" => "thumbnail",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Length of Title",'theme_admin'),
			"desc" => "if set to 0, it will use the full length of the title.",
			"id" => "title_length",
			"default" => 0,
			"min" => 0,
			"max" => 80,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Extra infomation type",'theme_admin'),
			"id" => "extra",
			"default" => 'desc',
			"options" => array(
				"time" => __('Time','theme_admin'),
				"desc" => __('Description','theme_admin'),
				"both" => __('Time and Description','theme_admin'),
				"none" => __('None','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Length of Description",'theme_admin'),
			"desc" => "",
			"id" => "desc_length",
			"default" => '80',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Category (optional)",'theme_admin'),
			"id" => "cat",
			"default" => array(),
			"target" => 'cat',
			"chosen" => true,
			"prompt" => __("Select Categories..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Posts (optional)",'theme_admin'),
			"desc" => __("The specific posts you want to display",'theme_admin'),
			"id" => "posts",
			"default" => array(),
			"chosen" => true,
			"target" => 'post',
			"prompt" => __("Select Posts..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Author (optional)",'theme_admin'),
			"id" => "author",
			"default" => array(),
			"target" => 'author',
			"chosen" => true,
			"prompt" => __("Select Authors..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Offset",'theme_admin'),
			"desc" => __("Number of post to displace or pass over.",'theme_admin'),
			"id" => "offset",
			"default" => '0',
			"min" => 0,
			"max" => 10,
			"step" => "1",
			"type" => "range"
		),
	),
);
