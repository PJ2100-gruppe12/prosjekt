<?php
if (! function_exists("theme_get_image_size")) {
	function theme_get_image_size(){
		$customs =  theme_get_option('image','customs');
		$sizes = array(
			"small" => __("Small",'striking_admin'),
			"medium" => __("Medium",'striking_admin'),
			"large" => __("Large",'striking_admin'),
		);
		if(!empty($customs)){
			$customs = explode(',',$customs);
			foreach($customs as $custom){
				$sizes[$custom] = ucfirst(strtolower($custom));
			}
		}
		return $sizes;
	}
}
return array(
	"title" => __("Image", "striking_admin"),
	"shortcode" => 'image',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Image Source",'striking_admin'),
			"id" => "source",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array (
			"name" => __("Image Caption",'striking_admin'),
			"desc" => __("The text you want to appear under the image in the post content. The text is centered under the image by default",'striking_admin'),
			"size" => 60,
			"id" => "caption",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Image Alignment (optional)",'striking_admin'),
			"desc" => __("If you choose to left or right align an image, except when the image is full column width in size, subsequent text will wrap to the side of the image",'striking_admin'),
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
		array(
			"name" => __("Effect",'striking_admin'),
			"desc" => __("The effect that occures when a cursor hovers over the image. An Icon can be used to imply a link to something, and the grayscale is a fancy black and white hover effect",'striking_admin'),
			"id" => "effect",
			"default" => 'icon',
			"options" => array(
				"icon" => __("Icon",'striking_admin'),
				"grayscale" => __("Grayscale",'striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Icon (optional)",'striking_admin'),
			"desc" => __("If you selected Icon above, here you select the type of icon you want to appear over the image on mouse hover",'striking_admin'),
			"id" => "icon",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"zoom" => __('Zoom','striking_admin'),
				"play" => __('Play','striking_admin'),
				"doc" => __('Doc','striking_admin'),
				"link" => __('Link','striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Size (optional)",'striking_admin'),
			"desc" => __("Here you choose the size of the image you want to display in the post - the image sizes are as per the Striking Image Panel settings. Or you can use the width & height settings below to set a custom size",'striking_admin'),
			"id" => "size",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => theme_get_image_size(),
			"type" => "select",
		),
		array (
			"name" => __("Width (optional)",'striking_admin'),
			"id" => "width",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Height (optional)",'striking_admin'),
			"desc" => __("For height you have two choices, set a custom height, or if you have set a width but are unsure of height, use the Auto Adjust Height setting below which sets height scaling automatically for any custom width set above",'striking_admin'),
			"id" => "height",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Auto Adjust Height",'striking_admin'),
			"id" => "autoHeight",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Link (optional)",'striking_admin'),
			"desc" => __("If you want, you can have it so that clicking on the picture links to something else, and here you input the url for that alternative",'striking_admin'),
			"size" => 60,
			"id" => "link",
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Link Target (optional)",'striking_admin'),
			"desc" => __("If you set a Link above, you have to decide whether you want the link to open in the same page, go to another page, etc",'striking_admin'),
			"id" => "linkTarget",
			"default" => '',
			"prompt" => __("Choose one..",'striking_admin'),
			"options" => array(
				"_blank" => __('Load in a new window','striking_admin'),
				"_self" => __('Load in the same frame as it was clicked','striking_admin'),
				"_parent" => __('Load in the parent frameset','striking_admin'),
				"_top" => __('Load in the full body of the window','striking_admin'),
			),
			"type" => "select",
		),
		array (
			"name" => __("Quality (optional)",'striking_admin'),
			"desc" => __("If you started with a high quality picture, you can increase this but if a low quality picture, do not as it will further distort the image",'striking_admin'),
			"id" => "quality",
			"default" => 75,
			"min" => 75,
			"max" => 100,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Lightbox",'striking_admin'),
			"desc" => __("This is for when you choose to have the image pop up in a lightbox. ",'striking_admin'),
	"id" => "lightbox",
			"default" => false,
			"type" => "toggle"
		),
		array (
			"name" => __("Lightbox group (optional)",'striking_admin'),
			"desc" => __("You can have several images in post body appear together in a lightbox if you put in the same name in this field for each of them - the field functions as a class id to link them",'striking_admin'),
			"id" => "group",
			"size" => 20,
			"default" => '',
			"type" => "text"
		),
		array(
			"name" => __("Lightbox Image Dimension Restriction",'striking_admin'),
			"desc" => __("If you enable this option, the lightbox dimension will be restricted to fit the browse screen size.",'striking_admin'),
			"id" => "lightbox_fittoview",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Lightbox Caption (optional)",'striking_admin'),
			"desc" => __("The wording appearing under the lightbox once it opens up. It is centered under the image by default.",'striking_admin'),
			"id" => "title",
			"size" => 60,
			"default" => "",
			"type" => "text",
		),
	
	),
	"custom" => '',
);