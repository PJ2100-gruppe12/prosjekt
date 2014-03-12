<?php
$init_script = <<<HTML
	jQuery('[name="inline"]').live("change",function(){
		if(this.checked){
			jQuery('.shortcode-item[data-option="inline_id"]').show();
			jQuery('.shortcode-item[data-option="inline_html"]').show();
		}else{
			jQuery('.shortcode-item[data-option="inline_id"]').hide();
			jQuery('.shortcode-item[data-option="inline_html"]').hide();
		}
	}).trigger("change");
	jQuery('[name="iframe"]').live("change",function(){
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
	if(attrs['inline'].value == 'true'){
		attrs['iframe'].attributeText = undefined;
		attrs['iframe'].value = 'false';
		attrs['href'].value = '#' + attrs['inline_id'].value;
		attrs['href'].attributeText = 'href="'+ attrs['href'].value +'"';
		extra = '<div class="hidden"><div id="'+ attrs['inline_id'].value +'">'+ attrs['inline_html'].value +'</div></div>';
	}
	
	if(attrs['iframe'].value == 'true'){
		attrs['href'].value = attrs['iframe_href'].value;
		attrs['href'].attributeText = 'href="'+ attrs['href'].value +'"';
	}

	var use = ['title','group','width','height','group','photo','close','href','inline','iframe','fittoview'];
	for (x in use) {
		options[use[x]] = attrs[use[x]];
	}
	return '[lightbox' + this.builtAttributesChain(options) + ']'+  attrs['content'].value +'[/lightbox]'+ extra;
HTML;
return array(
	"title" => __("Lightbox", "striking_admin"),
	"shortcode" => 'lightbox',
	"type" => 'custom',
	"init" => $init_script,
	"custom" => $custom_script,
	"options" => array(
		array(
			"name" => __("Content",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Href",'striking_admin'),
			"id" => "href",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Title",'striking_admin'),
			"desc" => __("The title you want to display on the bottom of the lightbox.",'striking_admin'),
			"id" => "title",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array (
			"name" => __("Group (optional)",'striking_admin'),
			"desc" => __("This allows the user to group any combination of elements together for a gallery.",'striking_admin'),
			"id" => "group",
			"default" => '',
			"type" => "text"
		),
		array(
			"name" => __("Restrict Colorbox Dimension",'striking_admin'),
			"desc" => __("If you enable this option, the lightbox dimension will be restricted to fit the browse screen size.",'striking_admin'),
			"id" => "fittoview",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Width (optional)",'striking_admin'),
			"desc" => __("Set a width. Example: '100%', '500px', or 500",'striking_admin'),
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
			"name" => __("Height (optional)",'striking_admin'),
			"desc" => __("Set a height. Example: '100%', '500px', or 500",'striking_admin'),
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
			"name" => __("Iframe",'striking_admin'),
			"id" => "iframe",
			"desc" => __("If 'true' specifies that content should be displayed in an iFrame.",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Iframe Href",'striking_admin'),
			"id" => "iframe_href",
			"size" => 30,
			"default" => "",
			"type" => "text",
		),
		array(
			"name" => __("Photo",'striking_admin'),
			"id" => "photo",
			"desc" => __("If true, this setting forces Lightbox to display a link as a photo. Use this when automatic photo detection fails (such as using a url like 'photo.php' instead of 'photo.jpg', 'photo.jpg#1', or 'photo.jpg?pic=1')",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Inline",'striking_admin'),
			"id" => "inline",
			"desc" => __("If 'true' lightbox can be used to display content from the inline html. ",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Inline Id",'striking_admin'),
			"desc" => __('unique id for inline content.','striking_admin'),
			"id" => "inline_id",
			"default" => '',
			"type" => "text"
		),
		array(
			"name" => __("Inline Html",'striking_admin'),
			"desc" => __('You can use shortcode here.','striking_admin'),
			"id" => "inline_html",
			"default" => '',
			"type" => "textarea"
		),
		array (
			"name" => __("Display Close Button",'striking_admin'),
			"id" => "close",
			"default" => true,
			"type" => "toggle"
		),
	),
);