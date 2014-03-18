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
	jQuery('[name="icon"]').select2({
		width: '70%',
		formatResult: format,
		formatSelection: format,
		escapeMarkup: function(m) { return m; }
	});
HTML;
return array(
	"title" => __("Icon Box", "theme_admin"),
	"shortcode" => 'iconbox',
	"type" => 'enclosing',
	"init" => $init_script,
	"options" => array(
		array(
			"name" => __("Icon",'theme_admin'),
			"id" => "icon",
			"default" => '',
			"prompt" => __("None",'theme_admin'),
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" =>  __("Icon size (optional)",'theme_admin'),
			"id" => "iconSize",
			"default" => 'default',
			"options" => array(
				"small" => __('small','theme_admin'),
				"default" => __('default','theme_admin'),
				"large" => __('large','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Icon Color (optional)",'theme_admin'),
			"id" => "iconColor",
			"default" => "",
			"format" => "hex",
			"type" => "color"
		),
		array(
			"name" => __("title",'theme_admin'),
			"id" => "title",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => __("Content",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" =>  __("Type",'theme_admin'),
			"id" => "type",
			"default" => '',
			"options" => array(
				"inline" => __('inline','theme_admin'),
				"left" => __('left','theme_admin'),
				"center" => __('center','theme_admin'),
			),
			"type" => "select",
		),
		
		array(
			"name" => __("Class (optional)",'theme_admin'),
			"id" => "class",
			"default" => "",
			"type" => "text"
		),
	),
	"custom" => '',
);