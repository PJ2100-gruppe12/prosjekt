<?php
$custom_script = <<<HTML
	if(attrs['type'].value=='code'){
		return '[code]'+attrs['content'].value+'[/code]';
	}else{
		return '[pre]'+attrs['content'].value+'[/pre]';
	}
HTML;
return array(
	"title" => __("Pre & Code", "striking_admin"),
	"shortcode" => 'code',
	"type" => 'custom',
	"options" => array(
		array(
			"name" => __("Type",'striking_admin'),
			"id" => "type",
			"default" => 'code',
			"options" => array(
				"pre" => 'Pre',
				"code" => 'Code',
			),
			"type" => "select",
		),
		array(
			"name" => __("Content",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
	),
	"custom" => $custom_script,
);