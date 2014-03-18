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
	"title" => __("Milestone", "theme_admin"),
	"shortcode" => 'milestone',
	"type" => 'self-closing',
	"init" => $init_script,
	"options" => array(
		array(
			"name" => __("Number From (optional)",'theme_admin'),
			"id" => "numberFrom",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Number To",'theme_admin'),
			"id" => "number",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Subject",'theme_admin'),
			"id" => "subject",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" =>  __("Size",'theme_admin'),
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
			"name" => __("Number Color (optional)",'theme_admin'),
			"id" => "numberColor",
			"default" => "",
			"format" => "hex",
			"type" => "color"
		),
		array(
			"name" => __("Subject Color (optional)",'theme_admin'),
			"id" => "subjectColor",
			"default" => "",
			"format" => "hex",
			"type" => "color"
		),
		array(
			"name" => __("Icon (optional)",'theme_admin'),
			"id" => "icon",
			"default" => '',
			"prompt" => __("None",'theme_admin'),
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" => __("Icon Color (optional)",'theme_admin'),
			"id" => "iconColor",
			"default" => "",
			"format" => "hex",
			"type" => "color"
		),
	),
);
