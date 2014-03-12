<?php
$init_script = <<<HTML
	jQuery('[name="controls"]').live("change",function(){
		if(this.checked){
			jQuery('.shortcode-item[data-option="panControl"]').show();
			jQuery('.shortcode-item[data-option="zoomControl"]').show();
			jQuery('.shortcode-item[data-option="mapTypeControl"]').show();
			jQuery('.shortcode-item[data-option="scaleControl"]').show();
			jQuery('.shortcode-item[data-option="streetViewControl"]').show();
			jQuery('.shortcode-item[data-option="overviewMapControl"]').show();
		}else{
			jQuery('.shortcode-item[data-option="panControl"]').hide();
			jQuery('.shortcode-item[data-option="zoomControl"]').hide();
			jQuery('.shortcode-item[data-option="mapTypeControl"]').hide();
			jQuery('.shortcode-item[data-option="scaleControl"]').hide();
			jQuery('.shortcode-item[data-option="streetViewControl"]').hide();
			jQuery('.shortcode-item[data-option="overviewMapControl"]').hide();
		}
	}).trigger("change");
HTML;
$custom_script = <<<HTML
	if(attrs['html'].value!=''){
		attrs['html'].value = attrs['html'].value.replace(/\\n/gi,"{linebreak}");
		attrs['html'].attributeText = attrs['html'].attributeText.replace(/\\n/gi,"{linebreak}");
	}
	return '[gmap' + this.builtAttributesChain(attrs) + '] ';
HTML;
return array(
	"title" => __("Google Map", "striking_admin"),
	"shortcode" => 'gmap',
	"type" => 'custom',
	"init" => $init_script,
	"custom" => $custom_script,
	"options" => array(
		array (
			"name" => __("Width (optional)",'striking_admin'),
			"desc" => __("set to 0 is the full width",'striking_admin'),
			"id" => "width",
			"default" => "",
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"units" => array('px','%'),
			'default_unit' => 'px',
			"type" => "measurement",
		),
		array (
			"name" => __("Height",'striking_admin'),
			"id" => "height",
			"default" => '400',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			'unit' => 'px',
			"type" => "range",
		),
		array(
			"name" => __("Address (optional)",'striking_admin'),
			"id" => "address",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Latitude",'striking_admin'),
			"id" => "latitude",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("longitude",'striking_admin'),
			"id" => "longitude",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array (
			"name" => __("Zoom",'striking_admin'),
			"id" => "zoom",
			"default" => '',
			"min" => 1,
			"max" => 19,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Marker",'striking_admin'),
			"id" => "marker",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("Html",'striking_admin'),
			"id" => "html",
			"size" => 30,
			"default" => "",
			"type" => "textarea",
		),
		array (
			"name" => __("Popup Marker",'striking_admin'),
			"id" => "popup",
			"default" => false,
			"type" => "toggle"
		),
		array (
			"name" => __("Controls",'striking_admin'),
			"id" => "controls",
			"default" => false,
			"type" => "toggle"
		),
		array (
			"name" => __("panControl",'striking_admin'),
			"id" => "panControl",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("zoomControl",'striking_admin'),
			"id" => "zoomControl",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("doubleClickZoom",'striking_admin'),
			"id" => "doubleclickzoom",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("mapTypeControl",'striking_admin'),
			"id" => "mapTypeControl",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("scaleControl",'striking_admin'),
			"id" => "scaleControl",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("streetViewControl",'striking_admin'),
			"id" => "streetViewControl",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("overviewMapControl",'striking_admin'),
			"id" => "overviewMapControl",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("Scrollwheel",'striking_admin'),
			"id" => "scrollwheel",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Maptype (optional)",'striking_admin'),
			"id" => "maptype",
			"default" => 'ROADMAP',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"ROADMAP" => __('Default road map','striking_admin'),
				"SATELLITE" => __('Google Earth satellite','striking_admin'),
				"HYBRID" => __('Mixture of normal and satellite','striking_admin'),
				"TERRAIN" => __('Physical map','striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Align (optional)",'striking_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"left" => __('Left','striking_admin'),
				"right" => __('Right','striking_admin'),
				"center" => __('Center','striking_admin'),
			),
			"type" => "select",
		),
	),
);
