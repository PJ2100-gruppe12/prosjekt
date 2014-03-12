<?php
return array(
	"title" => __("Sitemap With Posts", "striking_admin"),
	"shortcode" => 'sitemap',
	"attributes" => 'type="posts"',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Show Comment",'striking_admin'),
			"id" => "show_comment",
			"desc" => __(" ",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("number",'striking_admin'),
			"desc" => __("Sets the number of Pages to display.<br> 0: Display all Pages.",'striking_admin'),
			"id" => "number",
			"default" => '0',
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
			"target" => 'post',
			"chosen" => true,
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
	),
);
