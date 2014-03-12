<?php
$custom_script = <<<HTML
	
	return '';
HTML;
return array(
	"title" => __("Test", "striking_admin"),
	"shortcode" => 'test',
	"type" => 'enclosing', //enclosing, self-closing, custom
	"options" => array(
		array(
			"name" => __("Text",'striking_admin'),
			"id" => "text",
			"default" => "",
			"type" => "text"		
		),
		array(
			"name" => __("Textarea",'striking_admin'),
			"id" => "textarea",
			"rows" => "2",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Select",'striking_admin'),
			"id" => "select",
			"default" => '1',
			"options" => array(
				"1" => sprintf(__("%d Option",'striking_admin'),1),
				"2" => sprintf(__("%d Option",'striking_admin'),2),
				"3" => sprintf(__("%d Option",'striking_admin'),3),
				"4" => sprintf(__("%d Option",'striking_admin'),4),
				"5" => sprintf(__("%d Option",'striking_admin'),5),
				"6" => sprintf(__("%d Option",'striking_admin'),6),
			),
			"type" => "select",
		),
		array(
			"name" => __("Multi Select",'striking_admin'),
			"id" => "multiselect",
			"default" => array('1','2'),
			"options" => array(
				"1" => sprintf(__("%d Option",'striking_admin'),1),
				"2" => sprintf(__("%d Option",'striking_admin'),2),
				"3" => sprintf(__("%d Option",'striking_admin'),3),
				"4" => sprintf(__("%d Option",'striking_admin'),4),
				"5" => sprintf(__("%d Option",'striking_admin'),5),
				"6" => sprintf(__("%d Option",'striking_admin'),6),
			),
			"type" => "multiselect",
		),
		array(
			"name" => __("Multi Dropdown",'striking_admin'),
			"id" => "multidropdown",
			"default" => array('1056','9','123'),
			"page" => '0',
			"prompt" => __("Choose page..",'striking_admin'),
			"type" => "multidropdown",
		),
		array(
			"name" => __("Super Link",'striking_admin'),
			"id" => "superlink",
			"default" => "",
			"shows" => array('page','cat','post','manually'),
			"type" => "superlink"
		),
		array(
			"name" => __("Checkboxes",'striking_admin'),
			"id" => "checkboxes",
			"default" => array("3","2"),
			"options" => array(
				"1" => sprintf(__("%d Option",'striking_admin'),1),
				"2" => sprintf(__("%d Option",'striking_admin'),2),
				"3" => sprintf(__("%d Option",'striking_admin'),3),
			),
			"type" => "checkboxes",
		),
		array(
			"name" => __("Radios",'striking_admin'),
			"id" => "radios",
			"default" => "1",
			"options" => array(
				"1" => sprintf(__("%d Option",'striking_admin'),1),
				"2" => sprintf(__("%d Option",'striking_admin'),2),
				"3" => sprintf(__("%d Option",'striking_admin'),3),
			),
			"type" => "radios",
		),
		array(
			"name" => __("Upload",'striking_admin'),
			"id" => "upload",
			"button" => "Insert Image",
			"default" => '',
			"type" => "upload",
		),
		array (
			"name" => __("Range",'striking_admin'),
			"id" => "range",
			"default" => 0,
			"min" => 0,
			"max" => 100,
			"unit" => 'px',
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Color",'striking_admin'),
			"id" => "color",
			"default" => "",
			"type" => "color"		
		),
		array(
			"name" => __("Toggle",'striking_admin'),
			"id" => "toggle",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Tri Toggle",'striking_admin'),
			"id" => "tritoggle",
			"label" => "lable text",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Validator",'striking_admin'),
			"id" => "validator",
			"default" => "",
			"required" => true,
			"maxlength" => '15',
			"minlength" => '2',
			"format" => 'email',
			"type" => "validator"		
		),
	),
	"custom" => $custom_script,
);
