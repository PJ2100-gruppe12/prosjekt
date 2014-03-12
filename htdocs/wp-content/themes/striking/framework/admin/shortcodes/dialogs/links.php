<?php
return array(
	"title" => __("Links", "striking_admin"),
	"shortcode" => 'links',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Show name",'striking_admin'),
			"id" => "name",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Show description",'striking_admin'),
			"id" => "desc",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Show images",'striking_admin'),
			"id" => "images",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Show Rating",'striking_admin'),
			"id" => "rating",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Category",'striking_admin'),
			"id" => "cat",
			"default" => '',
			"target" => 'link_category',
			"chosen" => true,
			"prompt" => __("Select Categories..",'striking_admin'),
			"type" => "select",
		),
		array(
			"name" => __("Show Category Title",'striking_admin'),
			"id" => "cat_title",
			"default" => true,
			"type" => "toggle"
		),
	),
);
