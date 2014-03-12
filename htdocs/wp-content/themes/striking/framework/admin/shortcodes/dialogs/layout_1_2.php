<?php
$custom_script = <<<HTML
	if(attrs['column_1'].value == ''){
		attrs['column_1'].value = ' ';
	}
	if(attrs['column_2'].value == ''){
		attrs['column_2'].value = ' ';
	}
	return '\\n[one_third]'+attrs['column_1'].value+'[/one_third]\\n[two_third_last]'+attrs['column_2'].value+'[/two_third_last]\\n';
HTML;
return array(
	"title" => __("One Third - Two Third Columns Layout", "striking_admin"),
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
	),
	"custom" => $custom_script,
);