<?php
$custom_script = <<<HTML
	if(attrs['column_1'].value == ''){
		attrs['column_1'].value = ' ';
	}
	if(attrs['column_2'].value == ''){
		attrs['column_2'].value = ' ';
	}
	if(attrs['column_3'].value == ''){
		attrs['column_3'].value = ' ';
	}
	return '\\n[one_fourth]'+attrs['column_1'].value+'[/one_fourth]\\n[one_half]'+attrs['column_2'].value+'[/one_half]\\n[one_fourth_last]'+attrs['column_3'].value+'[/one_fourth_last]\\n';
HTML;
return array(
	"title" => __("One Fourth - One Half - One Fourth Columns Layout", "striking_admin"),
	'contentOption' => 'column_1',
	"type" => 'custom',	
	"options" => array(
		array(
			"name" => __("Column 1",'striking_admin'),
			"id" => "column_1",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Column 2",'striking_admin'),
			"id" => "column_2",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Column 3",'striking_admin'),
			"id" => "column_3",
			"default" => "",
			"type" => "textarea"
		),
	),
	"custom" => $custom_script,
);