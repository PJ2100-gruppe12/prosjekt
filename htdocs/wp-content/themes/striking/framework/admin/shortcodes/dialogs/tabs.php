<?php
$init_script = <<<HTML
	jQuery('[name="number"]').live("change",function(){
		var tabs_number = jQuery(this).val();
		jQuery('.shortcode-item').each(function(i){
			if(i>(3+tabs_number*2)){
				jQuery(this).hide();
			}else{
				jQuery(this).show();
			}
		});
		var select=jQuery('[name="initialTab"]');
		var selectedOption = select.val();
		jQuery('option', select).remove();
		for (i=1;i<=tabs_number;i++){
			select.append(jQuery("<option></option>").attr("value",i).text(i)); 
		}
		select.val(selectedOption);
	}).trigger("change");
HTML;
$custom_script = <<<HTML
	var type = attrs['type'].value;
	var number = attrs['number'].value;
	var history = attrs['history'].value;
	var initialTab = attrs['initialTab'].value;
	if(type == ''){
		type = 'tabs';
	}
	if(history == 'true'){
		history = ' history="true"';
	}else{
		history = '';
	}
	if(initialTab != 1){
		initialTab = ' initialTab="'+initialTab+'"';
	}else{
		initialTab = '';
	}
	var ret = '\\n['+type+history+initialTab+']\\n';
	for(var i=1;i<=number;i++){
		ret +='[tab title="'+attrs['tabs','title_'+i].value+'"]\\n'+attrs['tabs','content_'+i].value+'\\n[/tab]\\n';
	}
	ret +='[/'+type+']\\n';
	return ret;
HTML;
return array(
	"title" => __("Tabs",'striking_admin'),
	"type" => 'custom',
	'contentOption' => 'content_1',
	"options" => array(
		array(
			"name" => __("Type",'striking_admin'),
			"id" => "type",
			"default" => 'tabs',
			"options" => array(
				"tabs" => __("Framed Tabs",'striking_admin'),
				"mini_tabs" => __("Mini Tabs",'striking_admin'),
			),
			"type" => "select",
		),
		array (
			"name" => __("History (optional)",'striking_admin'),
			"desc" => __("Enable this to get browser's back and forward buttons support.",'striking_admin'),
			"id" => "history",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Number of tabs",'striking_admin'),
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
			"desc" => __("Specifies the tab that is initially opened when the page loads.</br>When the history feature is enabled, this will not take effect.",'striking_admin'),
			"options" => array(),
			"default" => "1",
			"type" => "select"
		),
		array(
			"name" => sprintf(__("Tab %d Title",'striking_admin'),1),
			"id" => "title_1",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Tab %d Content",'striking_admin'),1),
			"id" => "content_1",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Tab %d Title",'striking_admin'),2),
			"id" => "title_2",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Tab %d Content",'striking_admin'),2),
			"id" => "content_2",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Tab %d Title",'striking_admin'),3),
			"id" => "title_3",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Tab %d Content",'striking_admin'),3),
			"id" => "content_3",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Tab %d Title",'striking_admin'),4),
			"id" => "title_4",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Tab %d Content",'striking_admin'),4),
			"id" => "content_4",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Tab %d Title",'striking_admin'),5),
			"id" => "title_5",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Tab %d Content",'striking_admin'),5),
			"id" => "content_5",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => sprintf(__("Tab %d Title",'striking_admin'),6),
			"id" => "title_6",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Tab %d Content",'striking_admin'),6),
			"id" => "content_6",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Tab %d Title",'striking_admin'),7),
			"id" => "title_7",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Tab %d Content",'striking_admin'),7),
			"id" => "content_7",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Tab %d Title",'striking_admin'),8),
			"id" => "title_8",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Tab %d Content",'striking_admin'),8),
			"id" => "content_8",
			"default" => "",
			"type" => "textarea"
		),
	),
	"custom" => $custom_script,
	"init" => $init_script,
);