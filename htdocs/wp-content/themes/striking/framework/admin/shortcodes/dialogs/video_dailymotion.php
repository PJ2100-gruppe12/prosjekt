<?php
return array(
	"title" => __("Dailymotion", "striking_admin"),
	"shortcode" => 'video',
	"attributes" => 'type="dailymotion"',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Clip_id",'striking_admin'),
			"desc" => __("the id from the clip's URL (e.g. http://www.dailymotion.com/video/<span style='color:red'>xf3fk2</span>_didacticiel-quicklist_tech)",'striking_admin'),
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
			"name" => __("Related",'striking_admin'),
			"desc" => __("Sets whether or not loads related videos when the current video begins playback.",'striking_admin'),
			"id" => "related",
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
			"name" => __("Chromeless",'striking_admin'),
			"desc" => __("Sets whether or not display controls or not during video playback.",'striking_admin'),
			"id" => "chromeless",
			"default" => 'default',
			"type" => "tritoggle"
		),
	),
);
