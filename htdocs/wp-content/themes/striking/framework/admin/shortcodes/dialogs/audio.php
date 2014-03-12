<?php
return array(
	"title" => __("Audio", "striking_admin"),
	"shortcode" => 'audio',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("mp3 Source",'striking_admin'),
			"id" => "mp3",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Ogg Source (optional)",'striking_admin'),
			"id" => "ogg",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array (
			"name" => __("Width",'striking_admin'),
			"id" => "width",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Height",'striking_admin'),
			"id" => "height",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Preload",'striking_admin'),
			"id" => "preload",
			"desc" => __("Select this if you want the video to start downloading as soon the user loads the page.",'striking_admin'),
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Autoplay",'striking_admin'),
			"id" => "autoplay",
			"desc" => __("Select this if you want the video to start playing as soon as the page is loaded.",'striking_admin'),
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Loop",'striking_admin'),
			"id" => "audio_loop",
			"desc" => __("Select this if you want loop the audio when it ends .",'striking_admin'),
			"default" => 'default',
			"type" => "tritoggle"
		),
	),
);
