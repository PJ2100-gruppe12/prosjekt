<?php
$init_script = <<<HTML
	jQuery('[name="post_type"]').on("change",function(){
		var val = jQuery(this).val();
		
		$.post(ajaxurl, {
			action:'theme-get-taxonomies',
			post_type: val,
			cookie: encodeURIComponent(document.cookie)
		}, function(data){
			jQuery('[name="taxonomy"]').html(data);
		});
		jQuery('[name="terms[]"]').html('');
	}).trigger("change");

	jQuery('[name="taxonomy"]').on("change", function(){
		var val = jQuery(this).val();
		
		$.post(ajaxurl, {
			action:'theme-get-terms',
			taxonomy: val,
			cookie: encodeURIComponent(document.cookie)
		}, function(data){
			jQuery('[name="terms[]"]').html(data);
		});
	});
HTML;
return array(
	"title" => __("Product Carousel",'theme_admin'),
	"shortcode" => 'product_carousel',
	"init" => $init_script,
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Image Width",'theme_admin'),
			"id" => "width",
			"min" => "50",
			"max" => "500",
			"step" => "1",
			"default" => "200",
			"unit" => 'px',
			"type" => "range"
		),
		array(
			"name" => __("Image Height",'theme_admin'),
			"id" => "height",
			"min" => "50",
			"max" => "500",
			"step" => "1",
			"default" => "150",
			"unit" => 'px',
			"type" => "range"
		),
		array(
			"name" => __("Title (optional)",'theme_admin'),
			"id" => "title",
			"default" => "",
			"type" => "text",
			"class" => 'full'
		),
		array (
			"name" => __("Nav",'theme_admin'),
			"id" => "nav",
			"default" => false,
			"type" => "toggle"
		),
		array (
			"name" => __("Autoplay",'theme_admin'),
			"id" => "autoplay",
			"default" => true,
			"type" => "toggle"
		),
		array (
			"name" => __("Circular",'theme_admin'),
			"id" => "circular",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Post Type",'theme_admin'),
			"id" => "post_type",
			"default" => '',
			"target" => 'thumbnail_custom_post_types',
			"type" => "select",
		),
		array(
			"name" => __("Taxonomy (optional)",'theme_admin'),
			"id" => "taxonomy",
			"default" => '',
			"options" => array(),
			"type" => "select",
		),
		array(
			"name" => __("Taxonomy terms (optional)",'theme_admin'),
			"id" => "terms",
			"default" => '',
			"options" => array(),
			"type" => "multiselect",
		),
		array(
			"name" => __("Number of images",'theme_admin'),
			"id" => "number",
			"min" => "0",
			"max" => "15",
			"step" => "1",
			"default" => "0",
			"type" => "range"
		),
	),
);
