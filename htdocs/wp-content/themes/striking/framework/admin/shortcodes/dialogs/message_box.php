<?php
$custom_script = <<<HTML
	switch(attrs['type'].value){
		case 'info':
			return '[info]'+attrs['content'].value+'[/info]';
		case 'success':
			return '[success]'+attrs['content'].value+'[/success]';
		case 'error':
			return '[error]'+attrs['content'].value+'[/error]';
		case 'error_msg':
			return '[error_msg]'+attrs['content'].value+'[/error_msg]';
		case 'notice':
			return '[notice]'+attrs['content'].value+'[/notice]';
	}
HTML;
return array(
	"title" => __("Message Boxes", "theme_admin"),
	"shortcode" => 'message_box',
	"type" => 'custom',
	"options" => array(
		array(
			"name" => __("Type",'theme_admin'),
			"id" => "type",
			"default" => '',
			"options" => array(
				"info" => __("Info",'theme_admin'),
				"success" => __("Success",'theme_admin'),
				"error" => __("Error",'theme_admin'),
				"error_msg" => __("Error Msg",'theme_admin'),
				"notice" => __("Notice",'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Content",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		)
	),
	"custom" => $custom_script,
);