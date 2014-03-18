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
	jQuery('[name="type"]').select2({
		width: '70%',
		formatResult: format,
		formatSelection: format,
		escapeMarkup: function(m) { return m; }
	});
HTML;
return array(
	"title" => __("Icon Font", "theme_admin"),
	"shortcode" => 'icon_font',
	"type" => 'self-closing',
	"init" => $init_script,
	"options" => array(
		array(
			"name" => __("Type",'theme_admin'),
			"id" => "type",
			"default" => '',
			"options" => theme_get_icon_sets(),
			"type" => "select",
		),
		array(
			"name" => __("Color (optional)",'theme_admin'),
			"id" => "color",
			"default" => "",
			"type" => "color",
			"format" => "hex",
		),
		array(
			"name" => __("Size (optional)",'theme_admin'),
			"id" => "size",
			"desc" => __("To increase the size of icons relative to its container.", 'theme_admin'),
			"default" => '',
			"options" => array(
				"" => 'none',
				"large" => 'Large',
				"2x" => '2x',
				"3x" => '3x',
				"4x" => '4x',
				"5x" => '5x',
			),
			"type" => "select",
		),
		array(
			"name" => __("Pull (optional)",'theme_admin'),
			"id" => "pull",
			"default" => '',
			"options" => array(
				"" => 'none',
				"left" => 'Left',
				"right" => 'Right',
			),
			"type" => "select",
		),
		array(
			"name" => __("Border",'theme_admin'),
			"id"   => 'border',
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Spin",'theme_admin'),
			"desc" => __("Enable it to get icon to rotate.", 'theme_admin'),
			"id"   => 'spin',
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Rotate (optional)",'theme_admin'),
			"id" => "rotate",
			"default" => '',
			"options" => array(
				"" => 'none',
				"90" => '90',
				"180" => '180',
				"270" => '270',
				"horizontal" => 'Flip Horizontal',
				"vertical" => 'Flip vertical',
			),
			"type" => "select",
		),
	),
	"custom" => '',
);