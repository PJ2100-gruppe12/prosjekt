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
	"title" => __("Content Box", "theme_admin"),
	"shortcode" => 'content_box',
	"type" => 'enclosing',
	"init" => $init_script,
	"options" => array(
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
			"id" => "icon_color",
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
		array (
			"name" => __("Width (optional)",'theme_admin'),
			"id" => "width",
			"default" => '',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"units" => array('px','%'),
			'default_unit' => 'px',
			"type" => "measurement",
		),
		array (
			"name" => __("Height (optional)",'theme_admin'),
			"id" => "height",
			"default" => '0',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			'unit' => 'px',
			"type" => "range",
		),
		array(
			"name" => __("Title Background Color (optional)",'theme_admin'),
			"id" => "titleBgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Title Text Color (optional)",'theme_admin'),
			"id" => "titleTextColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Content Background Color (optional)",'theme_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Content Text Color (optional)",'theme_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
		array (
			"name" => __("Rounded",'theme_admin'),
			"id" => "rounded",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" =>  __("Align (optional)",'theme_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("None",'theme_admin'),
			"options" => array(
				"left" => __('left','theme_admin'),
				"right" => __('right','theme_admin'),
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