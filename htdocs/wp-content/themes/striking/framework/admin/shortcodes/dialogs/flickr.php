<?php
return array(
	"title" => __("Flickr", "striking_admin"),
	"shortcode" => 'flickr',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Type",'striking_admin'),
			"id" => "type",
			"default" => 'page',
			"options" => array(
				"user" => __("User",'striking_admin'),
				"group" => __("Group",'striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Flickr id (<a href='http://idgettr.com/' target='_blank'>idGettr</a>)",'striking_admin'),
			"id" => "id",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Count",'striking_admin'),
			"desc" => "",
			"id" => "count",
			"default" => '4',
			"min" => 0,
			"max" => 20,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Display",'striking_admin'),
			"id" => "display",
			"default" => 'latest',
			"options" => array(
				"latest" => __('Latest','striking_admin'),
				"random" => __('Random','striking_admin'),
			),
			"type" => "select",
		),
	),
);
