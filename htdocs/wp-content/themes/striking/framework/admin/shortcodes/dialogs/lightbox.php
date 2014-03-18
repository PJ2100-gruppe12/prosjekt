<?php
$init_script = <<<HTML
	jQuery('[name="inline"]').on("change",function(){
		if(this.checked){
			jQuery('.shortcode-item[data-option="inline_id"]').show();
			jQuery('.shortcode-item[data-option="inline_html"]').show();
		}else{
			jQuery('.shortcode-item[data-option="inline_id"]').hide();
			jQuery('.shortcode-item[data-option="inline_html"]').hide();
		}
	}).trigger("change");
	jQuery('[name="iframe"]').on("change",function(){
		if(this.checked){
			jQuery('.shortcode-item[data-option="iframe_href"]').show();
		}else{
			jQuery('.shortcode-item[data-option="iframe_href"]').hide();
		}
	}).trigger("change");
HTML;
$custom_script = <<<HTML
	var options = new Array();
	var extra = '';
	if(attrs['inline'].value === true){
		attrs['iframe'].attributeText = undefined;
		attrs['iframe'].value = 'false';
		attrs['href'].value = '#' + attrs['inline_id'].value;
		attrs['href'].attributeText = 'href="'+ attrs['href'].value +'"';
		extra = '<div class="hidden"><div id="'+ attrs['inline_id'].value +'">'+ attrs['inline_html'].value +'</div></div>';
	}

	if(attrs['iframe'].value === true){
		attrs['href'].value = attrs['iframe_href'].value;
		attrs['href'].attributeText = 'href="'+ attrs['href'].value +'"';
	}

	var use = ['title','group','width','height','group','photo','close','href','inline','iframe','fittoview','imageSource','imageEffect','imageWidth','imageHeight','imageAlign','imageIcon','imageSize'];
	for (x in use) {
		options[use[x]] = attrs[use[x]];
	}
	return '[lightbox' + this.builtAttributesChain(options) + ']'+  attrs['content'].value +'[/lightbox]'+ extra;
HTML;
return array(
	"title" => __("Lightbox", "theme_admin"),
	"shortcode" => 'lightbox',
	"type" => 'custom',
	"init" => $init_script,
	"custom" => $custom_script,
	"options" => array(
		array(
			"name" => __("Content",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Href",'theme_admin'),
			"id" => "href",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Title",'theme_admin'),
			"desc" => __("The title you want to display on the bottom of the lightbox.",'theme_admin'),
			"id" => "title",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array (
			"name" => __("Group (optional)",'theme_admin'),
			"desc" => __("This allows the user to group any combination of elements together for a gallery.",'theme_admin'),
			"id" => "group",
			"default" => '',
			"type" => "text"
		),
		array(
			"name" => __("Restrict Colorbox Dimension",'theme_admin'),
			"desc" => __("If you enable this option, the lightbox dimension will be restricted to fit the browse screen size.",'theme_admin'),
			"id" => "fittoview",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Width (optional)",'theme_admin'),
			"desc" => __("Set a width. Example: '100%', '500px', or 500",'theme_admin'),
			"id" => "width",
			"default" => "",
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"units" => array('px','%'),
			'default_unit' => 'px',
			"type" => "measurement",
		),
		array(
			"name" => __("Height (optional)",'theme_admin'),
			"desc" => __("Set a height. Example: '100%', '500px', or 500",'theme_admin'),
			"id" => "height",
			"default" => "",
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"units" => array('px','%'),
			'default_unit' => 'px',
			"type" => "measurement",
		),
		array(
			"name" => __("Iframe",'theme_admin'),
			"id" => "iframe",
			"desc" => __("If 'true' specifies that content should be displayed in an iFrame.",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Iframe Href",'theme_admin'),
			"id" => "iframe_href",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Photo",'theme_admin'),
			"id" => "photo",
			"desc" => __("If true, this setting forces Lightbox to display a link as a photo. Use this when automatic photo detection fails (such as using a url like 'photo.php' instead of 'photo.jpg', 'photo.jpg#1', or 'photo.jpg?pic=1')",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Inline",'theme_admin'),
			"id" => "inline",
			"desc" => __("If 'true' lightbox can be used to display content from the inline html. ",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Inline Id",'theme_admin'),
			"desc" => __('unique id for inline content.','theme_admin'),
			"id" => "inline_id",
			"default" => '',
			"type" => "text"
		),
		array(
			"name" => __("Inline Html",'theme_admin'),
			"desc" => __('You can use shortcode here.','theme_admin'),
			"id" => "inline_html",
			"default" => '',
			"type" => "textarea"
		),
		array (
			"name" => __("Display Close Button",'theme_admin'),
			"id" => "close",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Image Source (optional)",'theme_admin'),
			"desc" => __("If you select a image, the lightbox will show this image for trigger content",'theme_admin'),
			"id" => "imageSource",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => __("Image Alignment (optional)",'theme_admin'),
			"desc" => __("If you choose to left or right align an image, except when the image is full column width in size, subsequent text will wrap to the side of the image",'theme_admin'),
			"id" => "imageAlign",
			"default" => '',
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"left" => __('Left','theme_admin'),
				"right" => __('Right','theme_admin'),
				"center" => __('Center','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Image Effect (optional)",'theme_admin'),
			"desc" => __("The effect that occures when a cursor hovers over the image. An Icon can be used to imply a link to something, and the grayscale is a fancy black and white hover effect",'theme_admin'),
			"id" => "imageEffect",
			"default" => 'icon',
			"options" => array(
				"icon" => __("Icon",'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Image Icon (optional)",'theme_admin'),
			"desc" => __("If you selected Icon above, here you select the type of icon you want to appear over the image on mouse hover",'theme_admin'),
			"id" => "imageIcon",
			"default" => '',
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => array(
				"zoom" => __('Zoom','theme_admin'),
				"play" => __('Play','theme_admin'),
				"doc" => __('Doc','theme_admin'),
				"link" => __('Link','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Image Size (optional)",'theme_admin'),
			"desc" => __("Here you choose the size of the image you want to display in the post - the image sizes are as per the Striking Image Panel settings. Or you can use the width & height settings below to set a custom size",'theme_admin'),
			"id" => "imageSize",
			"default" => '',
			"prompt" => __("Choose one..",'theme_admin'),
			"options" => theme_get_image_size(),
			"type" => "select",
		),
		array (
			"name" => __("Image Width (optional)",'theme_admin'),
			"id" => "imageWidth",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Image Height (optional)",'theme_admin'),
			"desc" => __("For height you have two choices, set a custom height, or if you have set a width but are unsure of height, use the Auto Adjust Height setting below which sets height scaling automatically for any custom width set above",'theme_admin'),
			"id" => "imageHeight",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
	),
);
