<?php
return array(
	"title" => __("HTML 5", "striking_admin"),
	"shortcode" => 'video',
	"attributes" => 'type="html5"',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Poster Image",'striking_admin'),
			"desc" => __("The poster image is placeholder for the video before it plays. It's also used as the image fallback for devices that don't support HTML5 Video or Flash. ",'striking_admin'),
			"id" => "poster",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("MP4 Source",'striking_admin'),
			"desc" => __("Supported by Webkit browsers (Safari, Chrome, iPhone/iPad) and Internet Explorer 9. Also supported by Flash 9 and higher, so can double as the Flash source.",'striking_admin'),
			"id" => "mp4",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("WebM Source",'striking_admin'),
			"desc" => __('Supported by newer versions of Firefox, Chrome, and Opera.','striking_admin'),
			"id" => "webm",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Ogg Source",'striking_admin'),
			"desc" => __("Supported by Firefox, Opera, Chrome, and newer versions of Safari. Unfortunately it's not as good as WebM and MP4.",'striking_admin'),
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
			"name" => __("Download Links",'striking_admin'),
			"id" => "download",
			"desc" => __("If you want to support devices that don't support HTML5 or Flash, include links to the video source.",'striking_admin'),
			"default" => 'default',
			"type" => "tritoggle"
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
	),
);
