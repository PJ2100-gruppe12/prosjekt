<?php
return array(
	"title" => __("Twitter", "striking_admin"),
	"shortcode" => 'twitter',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Username",'striking_admin'),
			"desc" => __("Use ',' separate multi user.<br> (e.g <code>user1,user2</code>)",'striking_admin'),
			"id" => "username",
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
			"name" => __("Avatar Size (optional)",'striking_admin'),
			"desc" => __("Height and width of avatar if displayed",'striking_admin'),
			"id" => "avatarSize",
			"default" => '0',
			"min" => 0,
			"max" => 48,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Query (optional)",'striking_admin'),
			"desc" => __("uses <a href='http://apiwiki.twitter.com/Twitter-Search-API-Method%3A-search' target='_blank'>Twitter's Search API</a>, so you can display any tweets you like.", 'striking_admin'),
			"id" => "query",
			"default" => '',
			"type" => "textarea"
		),
	),
);
