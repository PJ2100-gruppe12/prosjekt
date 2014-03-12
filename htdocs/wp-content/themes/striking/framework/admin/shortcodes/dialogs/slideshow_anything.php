<?php
$init_script = <<<HTML
	jQuery('[name="_source[]"]').live("change",function(){
		var __val = jQuery(this).val();
		var _val={};
		jQuery.each(__val, function(key, value) { 
			if(value.indexOf('|')!=-1){
				var source = value.split('|');
				if(_val[source[0]] == undefined){
					_val[source[0]]=[];
				}
				if(_val[source[0]] != true){
					_val[source[0]].push(source[1])
				}
			}else{
				_val[value] = true;
			}
		});
		var val=[];
		jQuery.each(_val, function(key, value) { 
			if($.isArray(value)){
				val.push('{'+key+':'+value.join(',')+'}');
			}else{
				val.push('{'+key+'}');
			}
		});
		jQuery('[name="source"]').val(val.join(''));
	});
HTML;
if (! function_exists("theme_dialog_slideshow_source")) {
function theme_dialog_slideshow_source($option){
	include_once (THEME_HELPERS . '/baseOptionsGenerator.php');
	$generator = new baseOptionsGenerator();
	echo '<input type="hidden" id="' . $option['id'] . '" name="' . $option['id'] . '" value="" />';
	$option['id'] = '_source';
	$generator->multiselect($option);
}
}
return array(
	"title" => __("Anything Slideshow", "striking_admin"),
	"shortcode" => 'slideshow',
	"attributes" => 'type="anything"',
	"type" => 'enclosing',
	"init" => $init_script,
	"options" => array(
		array(
			"name" => __("Images Srcs (optional)",'striking_admin'),
			"desc" => __("separated by linebreak",'striking_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("SlideShow Source (optional)",'striking_admin'),
			"desc" => __("Select which SlideShow Source to show.",'striking_admin'),
			"id" => "source",
			"options" => array(
				"g" => __('Self Gallery','striking_admin'),
			),
			"default" => "",
			"chosen" => true,
			"prompt" => __("Select Source..",'striking_admin'),
			'target' => 'slideshow_source',
			'function' => 'theme_dialog_slideshow_source',
			"type" => "custom"
		),
		array(
			"name" => __("Number (optional)",'striking_admin'),
			"desc" => __("Sets the number of images to display.<br> 0: Display all images.",'striking_admin'),
			"id" => "number",
			"default" => '0',
			"min" => 0,
			"max" => 20,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Width",'striking_admin'),
			"desc" => __("Width of slider.",'striking_admin'),
			"id" => "width",
			"min" => "10",
			"max" => "960",
			"step" => "1",
			"unit" => 'px',
			"default" => "630",
			"type" => "range"
		),
		array(
			"name" => __("Height",'striking_admin'),
			"desc" => __("Height of slider.",'striking_admin'),
			"id" => "height",
			"min" => "10",
			"max" => "1000",
			"step" => "1",
			"unit" => 'px',
			"default" => "300",
			"type" => "range"
		),
		array(
			"name" => __("Easing Animations",'striking_admin'),
			"desc" => __("Select which easing effect to use.",'striking_admin'),
			"id" => "easing",
			"default" => 'swing',
			"options" => array(
				"linear" => 'linear',
				"swing" => 'swing',
				"easeInQuad" => 'easeInQuad',
				"easeOutQuad" => 'easeOutQuad',
				"easeInOutQuad" => 'easeInOutQuad',
				"easeInCubic" => 'easeInCubic',
				"easeOutCubic" => 'easeOutCubic',
				"easeInOutCubic" => 'easeInOutCubic',
				"easeInQuart" => 'easeInQuart',
				"easeOutQuart" => 'easeOutQuart',
				"easeInOutQuart" => 'easeInOutQuart',
				"easeInQuint" => 'easeInQuint',
				"easeOutQuint" => 'easeOutQuint',
				"easeInOutQuint" => 'easeInOutQuint',
				"easeInSine" => 'easeInSine',
				"easeOutSine" => 'easeOutSine',
				"easeInOutSine" => 'easeInOutSine',
				"easeInExpo" => 'easeInExpo',
				"easeOutExpo" => 'easeOutExpo',
				"easeInOutExpo" => 'easeInOutExpo',
				"easeInCirc" => 'easeInCirc',
				"easeOutCirc" => 'easeOutCirc',
				"easeInOutCirc" => 'easeInOutCirc',
				"easeInElastic" => 'easeInElastic',
				"easeOutElastic" => 'easeOutElastic',
				"easeInOutElastic" => 'easeInOutElastic',
				"easeInBack" => 'easeInBack',
				"easeOutBack" => 'easeOutBack',
				"easeInOutBack" => 'easeInOutBack',
				"easeInBounce" => 'easeInBounce',
				"easeOutBounce" => 'easeOutBounce',
				"easeInOutBounce" => 'easeInOutBounce'
			),
			"type" => "select",
		),
		array(
			"name" => __("buildArrows",'striking_admin'),
			"desc" => __("If true, builds the forwards and backwards buttons",'striking_admin'),
			"id" => "buildArrows",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("toggleArrows",'striking_admin'),
			"desc" => __("if true, side navigation arrows will slide out on hovering & hide @ other times",'striking_admin'),
			"id" => "toggleArrows",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("buildNavigation",'striking_admin'),
			"desc" => __("If true, builds a list of anchor links to link to each panel",'striking_admin'),
			"id" => "buildNavigation",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("toggleControls",'striking_admin'),
			"desc" => __("if true, slide in controls (navigation + play/stop button) on hover and slide change, hide @ other times",'striking_admin'),
			"id" => "toggleControls",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("enableArrows",'striking_admin'),
			"desc" => __("if false, arrows will be visible, but not clickable.",'striking_admin'),
			"id" => "enableArrows",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("enableNavigation",'striking_admin'),
			"desc" => __("if false, navigation links will still be visible, but not clickable.",'striking_admin'),
			"id" => "enableNavigation",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("enableKeyboard",'striking_admin'),
			"desc" => __("if false, keyboard arrow keys will not work for this slider.",'striking_admin'),
			"id" => "enableKeyboard",
			"default" => true,
			"type" => "toggle"
		),
		
		array(
			"name" => __("autoPlay",'striking_admin'),
			"desc" => __("If true, the slideshow will starts running automatically.",'striking_admin'),
			"id" => "autoPlay",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("autoPlayLocked",'striking_admin'),
			"desc" => __("If true, user changing slides will not stop the slideshow.",'striking_admin'),
			"id" => "autoPlayLocked",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("autoPlayDelayed",'striking_admin'),
			"desc" => __("If true, starting a slideshow will delay advancing slides; if false, the slider will immediately advance to the next slide when slideshow starts.",'striking_admin'),
			"id" => "autoPlayDelayed",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("pauseOnHover",'striking_admin'),
			"desc" => __("If true & the slideshow is active, the slideshow will pause on hover",'striking_admin'),
			"id" => "pauseOnHover",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("stopAtEnd",'striking_admin'),
			"desc" => __("If true & the slideshow is active, the slideshow will stop on the last page",'striking_admin'),
			"id" => "stopAtEnd",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("playRtl",'striking_admin'),
			"desc" => __("If true, the slideshow will move right-to-left",'striking_admin'),
			"id" => "playRtl",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("delay",'striking_admin'),
			"desc" => __("How long between slideshow transitions in AutoPlay mode",'striking_admin'),
			"id" => "delay",
			"min" => "1000",
			"max" => "30000",
			"step" => "500",
			'unit' => 'miliseconds',
			"default" => "3500",
			"type" => "range"
		),
		array(
			"name" => __("resumeDelay",'striking_admin'),
			"desc" => __("Resume slideshow after user interaction, only if autoplayLocked is true",'striking_admin'),
			"id" => "resumeDelay",
			"min" => "1000",
			"max" => "80000",
			"step" => "1000",
			'unit' => 'miliseconds',
			"default" => "3000",
			"type" => "range"
		),
		array(
			"name" => __("animationTime",'striking_admin'),
			"desc" => __("How long the slideshow transition takes",'striking_admin'),
			"id" => "animationTime",
			"min" => "200",
			"max" => "3000",
			"step" => "100",
			"unit" => 'miliseconds',
			"default" => "500",
			"type" => "range"
		),
		array(
			"name" => __("resumeOnVideoEnd",'striking_admin'),
			"desc" => __("If true & the slideshow is active & a youtube video is playing, the autoplay will pause until the video completes",'striking_admin'),
			"id" => "resumeOnVideoEnd",
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Caption Opacity",'striking_admin'),
			"desc" => __("The Opacity of Caption with it's background.",'striking_admin'),
			"id" => "captionOpacity",
			"min" => "0",
			"max" => "1",
			"step" => "0.1",
			"default" => "0.8",
			"type" => "range"
		),
		array(
			"name" =>  __("Align (optional)",'striking_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("Default",'striking_admin'),
			"options" => array(
				"left" => __('left','striking_admin'),
				"right" => __('right','striking_admin'),
				"center" => __('center','striking_admin'),
			),
			"type" => "select",
		),
	),
);