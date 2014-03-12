<?php
return array(
	"title" => __("Sitemap With Categories", "striking_admin"),
	"shortcode" => 'sitemap',
	"attributes" => 'type="categories"',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Show Count",'striking_admin'),
			"id" => "show_count",
			"desc" => __("Toggles the display of the current count of posts in each category.",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Show Feed",'striking_admin'),
			"id" => "show_feed",
			"desc" => __("Display a link to each category's <a href='http://codex.wordpress.org/Glossary#RSS' target='_blank'>rss-2</a> feed.",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("depth",'striking_admin'),
			"desc" => __("This parameter controls how many levels in the hierarchy of Categories are to be included. <br> 0: Displays pages at any depth and arranges them hierarchically in nested lists<br> -1: Displays pages at any depth and arranges them in a single, flat list<br> 1: Displays top-level Pages only<br> 2, 3 ... Displays Pages to the given depth",'striking_admin'),
			"id" => "depth",
			"default" => '0',
			"min" => -1,
			"max" => 5,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("number",'striking_admin'),
			"desc" => __("Sets the number of Categories to display.<br> 0: Display all Categories.",'striking_admin'),
			"id" => "number",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
	),
);
