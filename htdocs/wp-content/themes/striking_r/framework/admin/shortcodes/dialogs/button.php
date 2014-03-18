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
	"title" => __("Button", "theme_admin"),
	"shortcode" => 'button',
	"type" => 'enclosing',
	"init" => $init_script,
	"options" => array(
		array(
			"name" => __("Id (optional)",'theme_admin'),
			"id" => "id",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Class (optional)",'theme_admin'),
			"id" => "class",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Size",'theme_admin'),
			"id" => "size",
			"default" => 'small',
			"options" => array(
				"small" => __("Small",'theme_admin'),
				"medium" => __("Medium",'theme_admin'),
				"large" => __("Large",'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Align (optional)",'theme_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"left" => __('Left','theme_admin'),
				"right" => __('Right','theme_admin'),
				"center" => __('Center','theme_admin'),
			),
			"type" => "select",
		),
		array (
			"name" => __("Full",'theme_admin'),
			"id" => "full",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Link (optional)",'theme_admin'),
			"id" => "link",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Link Target (optional)",'theme_admin'),
			"id" => "linkTarget",
			"default" => '',
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"_blank" => __('Load in a new window','theme_admin'),
				"_self" => __('Load in the same frame as it was clicked','theme_admin'),
				"_parent" => __('Load in the parent frameset','theme_admin'),
				"_top" => __('Load in the full body of the window','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Color (optional)",'theme_admin'),
			"id" => "color",
			"default" => "primary",
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"primary" => 'Primary',
				"black" => 'Black',
				"gray" => 'Gray',
				"white" => 'White',
				"red" => 'Red',
				"yellow" => 'Yellow',
				"blue" => 'Blue',
				"pink" => 'Pink',
				"green" => 'Green',
				"rosy" => 'Rosy',
				"orange" => 'Orange',
				"magenta" => 'Magenta',
			),
			"type" => "select",
		),
		array(
			"name" => __("Background Color (optional)",'theme_admin'),
			"id" => "bgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Text Color (optional)",'theme_admin'),
			"id" => "textColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Hover Background Color (optional)",'theme_admin'),
			"id" => "hoverBgColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Hover Text Color (optional)",'theme_admin'),
			"id" => "hoverTextColor",
			"default" => "",
			"type" => "color"
		),
		array(
			"name" => __("Text",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "text",
		),
		array (
			"name" => __("Width (optional)",'theme_admin'),
			"id" => "width",
			"default" => '0',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Nofollow",'theme_admin'),
			"id" => "nofollow",
			"default" => false,
			"type" => "toggle"
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
			"id" => "icon_color",
			"default" => "",
			"format" => "hex",
			"type" => "color"
		),
	),
);
