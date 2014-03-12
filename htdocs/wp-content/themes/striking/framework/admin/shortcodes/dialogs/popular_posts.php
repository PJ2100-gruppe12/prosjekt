<?php
return array(
	"title" => __("Popular Posts",'striking_admin'),
	"shortcode" => 'popular_posts',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Count",'striking_admin'),
			"desc" => "",
			"id" => "count",
			"default" => '4',
			"min" => 0,
			"max" => 30,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Thumbnail",'striking_admin'),
			"id" => "thumbnail",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Length of Title",'striking_admin'),
			"desc" => "if set to 0, it will use the full length of the title.",
			"id" => "title_length",
			"default" => 0,
			"min" => 0,
			"max" => 80,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Extra infomation type",'striking_admin'),
			"id" => "extra",
			"default" => 'desc',
			"options" => array(
				"time" => __('Time','striking_admin'),
				"desc" => __('Description','striking_admin'),
				"both" => __('Time and Description','striking_admin'),
				"none" => __('None','striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Length of Description",'striking_admin'),
			"desc" => "",
			"id" => "desc_length",
			"default" => '80',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Category (optional)",'striking_admin'),
			"id" => "cat",
			"default" => array(),
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
			"target" => 'author',
			"chosen" => true,
			"prompt" => __("Select Authors..",'striking_admin'),
			"type" => "multiselect",
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
	),
);
