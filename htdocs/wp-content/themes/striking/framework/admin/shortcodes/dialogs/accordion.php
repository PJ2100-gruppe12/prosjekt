<?php
$init_script = <<<HTML
	jQuery('[name="number"]').live("change",function(){
		var accordion_number = jQuery(this).val();
		jQuery('.shortcode-item').each(function(i){
			if(i>(1+accordion_number*2)){
				jQuery(this).hide();
			}else{
				jQuery(this).show();
			}
		});
		var select=jQuery('[name="initialTab"]');
		var selectedOption = select.val();
		jQuery('option', select).remove();
		for (i=0;i<=accordion_number;i++){
			select.append(jQuery("<option></option>").attr("value",i).text(i)); 
		}
		select.val(selectedOption);
	}).trigger("change");
HTML;
$custom_script = <<<HTML
	var number = attrs['number'].value;
	var initialTab = attrs['initialTab'].value;
	if(initialTab != 1){
		initialTab = ' initialTab="'+initialTab+'"';
	}else{
		initialTab = '';
	}
	var ret = '\\n[accordions'+initialTab+']\\n';
	for(var i=1;i<=number;i++){
		ret +='[accordion title="'+attrs['tabs','title_'+i].value+'"]\\n'+attrs['tabs','content_'+i].value+'\\n[/accordion]\\n';
	}
	ret +='[/accordions]\\n';
	return ret;
HTML;
return array(
	"title" => __("Accordion",'striking_admin'),
	"type" => 'custom',
	'contentOption' => 'content_1',
	"options" => array(
		array(
			"name" => __("Number of pans",'striking_admin'),
			"id" => "number",
			"min" => "1",
			"max" => "8",
			"step" => "1",
			"default" => "2",
			"type" => "range"
		),
		array(
			"name" => __("Initial Tab",'striking_admin'),
			"id" => "initialTab",
			"desc" => __("Specifies the tab that is initially opened when the page loads.",'striking_admin'),
			"options" => array(),
			"default" => "1",
			"type" => "select"
		),
		array(
			"name" => sprintf(__("Accordion %d Title",'striking_admin'),1),
			"id" => "title_1",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Accordion %d Content",'striking_admin'),1),
			"id" => "content_1",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => sprintf(__("Accordion %d Title",'striking_admin'),2),
			"id" => "title_2",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Accordion %d Content",'striking_admin'),2),
			"id" => "content_2",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => sprintf(__("Accordion %d Title",'striking_admin'),3),
			"id" => "title_3",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Accordion %d Content",'striking_admin'),3),
			"id" => "content_3",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => sprintf(__("Accordion %d Title",'striking_admin'),4),
			"id" => "title_4",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Accordion %d Content",'striking_admin'),4),
			"id" => "content_4",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => sprintf(__("Accordion %d Title",'striking_admin'),5),
			"id" => "title_5",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Accordion %d Content",'striking_admin'),5),
			"id" => "content_5",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => sprintf(__("Accordion %d Title",'striking_admin'),6),
			"id" => "title_6",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Accordion %d Content",'striking_admin'),6),
			"id" => "content_6",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => sprintf(__("Accordion %d Title",'striking_admin'),7),
			"id" => "title_7",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Accordion %d Content",'striking_admin'),7),
			"id" => "content_7",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => sprintf(__("Accordion %d Title",'striking_admin'),8),
			"id" => "title_8",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Accordion %d Content",'striking_admin'),8),
			"id" => "content_8",
			"default" => "",
			"type" => "textarea"
		),
	),
	"custom" => $custom_script,
	"init" => $init_script,
);