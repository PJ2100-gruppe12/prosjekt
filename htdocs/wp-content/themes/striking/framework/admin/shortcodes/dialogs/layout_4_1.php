<?php
$custom_script = <<<HTML
	if(attrs['column_1'].value == ''){
		attrs['column_1'].value = ' ';
	}
	if(attrs['column_2'].value == ''){
		attrs['column_2'].value = ' ';
	}
	return '\\n[four_fifth]'+attrs['column_1'].value+'[/four_fifth]\\n[one_fifth_last]'+attrs['column_2'].value+'[/one_fifth_last]\\n';
HTML;
return array(
	"title" => __("Four Fifth - One Fifth Columns Layout", "striking_admin"),
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