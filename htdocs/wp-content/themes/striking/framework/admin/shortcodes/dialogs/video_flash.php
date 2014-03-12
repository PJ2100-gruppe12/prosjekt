<?php
return array(
	"title" => __("Flash", "striking_admin"),
	"shortcode" => 'video',
	"attributes" => 'type="flash"',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Src",'striking_admin'),
			"desc" => __('Specifies the location (URL) of the movie to be loaded','striking_admin'),
			"id" => "src",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Id (optional)",'striking_admin'),
			"id" => "id",
			"default" => "",
			"type" => "text",
		),
		array (
			"name" => __("Width (optional)",'striking_admin'),
			"id" => "width",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Height (optional)",'striking_admin'),
			"id" => "height",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Play",'striking_admin'),
			"id" => "play",
			"desc" => __("Specifies whether the movie begins playing immediately on loading in the browser.",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("flashvars (optional)",'striking_admin'),
			"desc" => __("variable to pass to Flash Player.",'striking_admin'),
			"id" => "flashvars",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
	),
);
