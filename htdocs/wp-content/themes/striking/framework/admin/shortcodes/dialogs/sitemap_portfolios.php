<?php
return array(
	"title" => __("Sitemap With Portfolios", "striking_admin"),
	"shortcode" => 'sitemap',
	"attributes" => 'type="portfolios"',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Show Comment",'striking_admin'),
			"id" => "show_comment",
			"desc" => __(" ",'striking_admin'),
			"default" => false,
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
			"target" => 'portfolio_category',
			"chosen" => true,
			"prompt" => __("Select Categories..",'striking_admin'),
			"type" => "multiselect",
		),
	),
);
