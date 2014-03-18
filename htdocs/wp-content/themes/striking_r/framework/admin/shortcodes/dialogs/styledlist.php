<?php
return array(
	"title" => __("Styled List", "theme_admin"),
	"shortcode" => 'list',
	"type" => 'enclosing',
	"options" => array(
		array(
			"name" => __("Icon",'theme_admin'),
			"id" => "icon",
			"default" => '',
			"options" => array(
				"globe" => 'globe',
				"home" => 'home',
				"email" => 'email',
				"user" => 'user',
				"multiuser" => 'multiuser',
				"id" => 'id',
				"addressbook" => 'addressbook',
				"phone" => 'phone',
				"cellphone" => 'cellphone',
				"fax" => 'fax',
				"link" => 'link',
				"chain" => 'chain',
				"calendar" => 'calendar',
				"tag" => 'tag',
				"download" => 'download',
				"comments" => 'comments',
				"comment"  => 'comment',
				'comment-o' => 'comment-o',
				'comment-s' => 'comment-s',
				'heart' => 'heart',
				'heart-o' => 'heart-o',
				"thumbs-up" => "thumbs-up",
				"thumbs-down" => "thumbs-down",
				"key" => "key",
				"lightbulb" => "lightbulb",
				"eye" => "eye",
				"help" => "help",
				"marker" => "marker",
				"gift" => "gift",
				"star" => "star",
				"flag" => "flag",
				"medal" => "medal",
				"clock" => "clock",
				"cart" => "cart",
				"trash" => "trash",
				"cog" => "cog",
				"ban" => "ban",
				"times" => "times",
				"pencil" => "pencil",
				"note" => "note",
				"book" => "book",
				"gallery" => "gallery",
				"picture" => "picture",
				"movie" => "movie",
				"music" => "music",
				"play" => "play",
				"check" => "check",
				"check-b" => "check-b",
				"check-circle" => "check-circle",
				"check-circle-o" => "check-circle-o",
				"check-circle-d" => "check-circle-d",
				"check-square" => "check-square",
				"check-square-d" => "check-square-d",
				"arrow" => "arrow",
				"arrow-circle" => "arrow-circle",
				"arrow-circle-o" => "arrow-circle-o",
				"circle" => "circle",
				"info" => "info",
				"info-o" => "info-o",
				"question" => "question",
				"question-o" => "question-o",
				"exclamation" => "exclamation",
				"exclamation-triangle" => "exclamation-triangle",
				"exclamation-circle" => "exclamation-circle",
				"mobile" => "mobile",
				"tablet" => "tablet",
				"desktop" => "desktop",
			),
			"type" => "select",
		),
		array(
			"name" => __("Color (optional)",'theme_admin'),
			"id" => "color",
			"default" => "",
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"black" => 'Black',
				"gray" => 'Gray',
				"red" => 'Red',
				"yellow" => 'Yellow',
				"blue" => 'Blue',
				"pink" => 'Pink',
				"green" => 'Green',
				"rosy" => 'Rosy',
				"orange" => 'Orange',
				"magenta" => 'Magenta',
			),
			"type" => "select",
		),
		array(
			"name" => __("Content",'theme_admin'),
			"id" => "content",
			"desc"=> __("Sample: <pre><code>&lt;ul&gt;
&lt;li&gt;List item 1&lt;/li&gt;
&lt;li&gt;List item 2&lt;/li&gt;
&lt;li&gt;List item 3&lt;/li&gt;
&lt;/ul&gt;</code></pre>",'theme_admin'),
			"default" => "",
			"type" => "textarea"
		),
	),
	"custom" => '',
);