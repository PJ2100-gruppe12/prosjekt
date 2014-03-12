<?php
return array(
	"title" => __("vimeo", "striking_admin"),
	"shortcode" => 'video',
	"attributes" => 'type="vimeo"',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Clip_id",'striking_admin'),
			"desc" => __("the number from the clip's URL (e.g. http://vimeo.com/<span style='color:red'>123456</span>)",'striking_admin'),
			"id" => "clip_id",
			"size" => 30,
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
			"name" => __("Byline",'striking_admin'),
			"desc" => __('Sets whether or not show the byline on the video','striking_admin'),
			"id" => "byline",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Title",'striking_admin'),
			"desc" => __('Sets whether or not show the title on the video','striking_admin'),
			"id" => "title",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Portrait",'striking_admin'),
			"desc" => __("Sets whether or not show the user's portrai on the video",'striking_admin'),
			"id" => "portrait",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Autoplay",'striking_admin'),
			"desc" => __("Sets whether or not automatically start playback of the video.",'striking_admin'),
			"id" => "autoplay",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Loop",'striking_admin'),
			"desc" => __('Sets whether or not play the initial video again and again.','striking_admin'),
			"id" => "loop",
			"default" => 'default',
			"type" => "tritoggle"
		),
	),
);
