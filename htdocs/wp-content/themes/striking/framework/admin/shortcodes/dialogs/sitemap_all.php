<?php
return array(
	"title" => __("Sitemap With Pages, Categories, Posts and Portfolios", "striking_admin"),
	"shortcode" => 'sitemap',
	"attributes" => 'type="all"',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Columns",'striking_admin'),
			"id" => "shows",
			"default" => array(),
			"options" => array(
				"pages" => __("Pages",'striking_admin'),
				"categories" => __("Categories",'striking_admin'),
				"posts" => __("Posts",'striking_admin'),
				"portfolios" => __("Portfolios",'striking_admin'),
			),
			"type" => "multiselect",
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
	),
);
