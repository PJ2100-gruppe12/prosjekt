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
	"title" => __("Pie Progress", "theme_admin"),
	"shortcode" => 'pie_progress',
	"type" => 'self-closing',
	"init" => $init_script,
	"options" => array(
		array (
			"name" => __("Percent",'theme_admin'),
			"id" => "percent",
			"default" => '0',
			"min" => 0,
			"max" => 100,
			"step" => "1",
			'unit' => '%',
			"type" => "range",
		),
		array(
			"name" =>  __("Size",'theme_admin'),
			"id" => "size",
			"default" => 'default',
			"options" => array(
				"small" => __('Small','theme_admin'),
				"default" => __('Default','theme_admin'),
				"large" => __('Large','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" =>  __("Label Type",'theme_admin'),
			"id" => "label",
			"default" => 'percent',
			"options" => array(
				"percent" => __('Percent','theme_admin'),
				"text" => __('Text','theme_admin'),
				"icon" => __('Icon','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Label Text (optional)",'theme_admin'),
			"id" => "text",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Label Icon (optional)",'theme_admin'),
			"id" => "icon",
			"default" => '',
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" => __("Label Color (optional)",'theme_admin'),
			"id" => "labelColor",
			"default" => "",
			"type" => "color",
			"format" => "hex",
		),
		array(
			"name" => __("Track Color (optional)",'theme_admin'),
			"id" => "trackcolor",
			"default" => "",
			"type" => "color",
			"format" => "hex",
		),
		array(
			"name" => __("Bar Color (optional)",'theme_admin'),
			"id" => "barcolor",
			"default" => "",
			"type" => "color",
			"format" => "hex",
		),
	),
	"custom" => '',
);