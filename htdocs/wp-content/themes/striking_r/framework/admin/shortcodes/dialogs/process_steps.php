<?php
if($icons = theme_get_option('font','icons')){
	switch($icons){
		case 'awesome':
			wp_enqueue_style('theme-icons-awesome', THEME_ICONS_URI.'/awesome/css/font-awesome.min.css', false, false, 'all');
			break;
	}
}
$init_script = <<<HTML
	function format(state) {
		if (!state.id) return state.text; // optgroup
		return "<i class='icon-" + state.id.toLowerCase() + "'/> " + state.text;
	}
	jQuery('select[name^="icon_"]').select2({
		width: '70%',
		formatResult: format,
		formatSelection: format,
		escapeMarkup: function(m) { return m; }
	});
	jQuery('[name="number"]').on("change",function(){
		var steps_number = jQuery(this).val();
		jQuery('.shortcode-item').each(function(i){
			if(i>(2+steps_number*4)){
				jQuery(this).hide();
			}else{
				jQuery(this).show();
			}
		});
	}).trigger("change");
HTML;
$custom_script = <<<HTML
	var number = attrs['number'].value;
	var type = attrs['type'].value;
	var size = attrs['size'].value;

	type = ' type="'+type+'"';
	
	if(size != 'horizontal'){
		size = ' size="'+size+'"';
	}else{
		size = '';
	}
	if(number != '3'){
		number_attr = ' number="'+number+'"';
	}else{
		number_attr = '';
	}
	
	var ret = '\\n[process_steps'+type+size+number_attr+']\\n';
	var icon = '';
	for(var i=1;i<=number;i++){
		if(attrs['process_steps', 'icon_'+i].value){
			icon = ' icon="'+attrs['process_steps', 'icon_'+i].value+'"';
			if(attrs['process_steps', 'icon_color_'+i].value){
				icon += ' icon_color="'+attrs['process_steps', 'icon_color_'+i].value+'"';
			}
		}else{
			icon = '';
		}
		ret +='[process_step title="'+attrs['process_steps','title_'+i].value+'"'+icon+']\\n'+attrs['process_steps','content_'+i].value+'\\n[/process_step]\\n';
	}
	ret +='[/process_steps]\\n';
	return ret;
HTML;
return array(
	"title" => __("Process Steps",'theme_admin'),
	"type" => 'custom',
	'contentOption' => 'content_1',
	"options" => array(
		array(
			"name" => __("Size",'theme_admin'),
			"id" => "size",
			"default" => 'default',
			"options" => array(
				"small" => __('small','theme_admin'),
				"default" => __('default','theme_admin'),
				"large" => __('large','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Type",'theme_admin'),
			"id" => "type",
			"default" => 'horizontal',
			"options" => array(
				'horizontal' => __('Horizontal', 'theme_admin'),
				'vertical' => __('Vertical', 'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Number of steps",'theme_admin'),
			"id" => "number",
			"min" => "2",
			"max" => "5",
			"step" => "1",
			"default" => "3",
			"type" => "range"
		),
		array(
			"name" => sprintf(__("Step %d Title",'theme_admin'),1),
			"id" => "title_1",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Step %d Icon (optional)",'theme_admin'),1),
			"id" => "icon_1",
			"default" => "",
			"prompt" => __("None",'theme_admin'),
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" => sprintf(__("Step %d Icon Color (optional)",'theme_admin'),1),
			"id" => "icon_color_1",
			"default" => "",
			"format" => "hex",
			"type" => "color",
		),
		array(
			"name" => sprintf(__("Step %d Content",'theme_admin'),1),
			"id" => "content_1",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Step %d Title",'theme_admin'),2),
			"id" => "title_2",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Step %d Icon (optional)",'theme_admin'),2),
			"id" => "icon_2",
			"default" => "",
			"prompt" => __("None",'theme_admin'),
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" => sprintf(__("Step %d Icon Color (optional)",'theme_admin'),2),
			"id" => "icon_color_2",
			"default" => "",
			"format" => "hex",
			"type" => "color",
		),
		array(
			"name" => sprintf(__("Step %d Content",'theme_admin'),2),
			"id" => "content_2",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Step %d Title",'theme_admin'),3),
			"id" => "title_3",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Step %d Icon (optional)",'theme_admin'),3),
			"id" => "icon_3",
			"default" => "",
			"prompt" => __("None",'theme_admin'),
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" => sprintf(__("Step %d Icon Color (optional)",'theme_admin'),3),
			"id" => "icon_color_3",
			"default" => "",
			"format" => "hex",
			"type" => "color",
		),
		array(
			"name" => sprintf(__("Step %d Content",'theme_admin'),3),
			"id" => "content_3",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Step %d Title",'theme_admin'),4),
			"id" => "title_4",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Step %d Icon (optional)",'theme_admin'),4),
			"id" => "icon_4",
			"default" => "",
			"prompt" => __("None",'theme_admin'),
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" => sprintf(__("Step %d Icon Color (optional)",'theme_admin'),4),
			"id" => "icon_color_4",
			"default" => "",
			"format" => "hex",
			"type" => "color",
		),
		array(
			"name" => sprintf(__("Step %d Content",'theme_admin'),4),
			"id" => "content_4",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  sprintf(__("Step %d Title",'theme_admin'),5),
			"id" => "title_5",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Step %d Icon (optional)",'theme_admin'),5),
			"id" => "icon_5",
			"default" => "",
			"prompt" => __("None",'theme_admin'),
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" => sprintf(__("Step %d Icon Color (optional)",'theme_admin'),5),
			"id" => "icon_color_5",
			"default" => "",
			"format" => "hex",
			"type" => "color",
		),
		array(
			"name" => sprintf(__("Step %d Content",'theme_admin'),5),
			"id" => "content_5",
			"default" => "",
			"type" => "textarea"
		),
	),
	"custom" => $custom_script,
	"init" => $init_script,
);
