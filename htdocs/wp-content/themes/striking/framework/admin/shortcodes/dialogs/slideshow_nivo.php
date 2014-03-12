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
	"title" => __("Nivo Slideshow", "striking_admin"),
	"shortcode" => 'slideshow',
	"attributes" => 'type="nivo"',
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
			"name" => __("Transition Effects",'striking_admin'),
			"desc" => __("Select which effect to use on the slideshow.",'striking_admin'),
			"id" => "effect",
			"default" => 'random',
			"options" => array(
				"random" => 'random',
				"sliceDown" => 'sliceDown',
				"sliceDownLeft" => 'sliceDownLeft',
				"sliceUp" => 'sliceUp',
				"sliceUpLeft" => 'sliceUpLeft',
				"sliceUpDown" => 'sliceUpDown',
				"sliceUpDownLeft" => 'sliceUpDownLeft',
				"fold" => 'fold',
				"fade" => 'fade',
				'slideInRight' => 'slideInRight',
				'slideInLeft' => 'slideInLeft',
				'boxRandom' => 'boxRandom',
				'boxRain' => 'boxRain',
				'boxRainReverse' => 'boxRainReverse',
				'boxRainGrow' => 'boxRainGrow',
				'boxRainGrowReverse' => 'boxRainGrowReverse',
			),
			"type" => "select",
		),
		array(
			"name" => __("Segments",'striking_admin'),
			"desc" => __("Number of segments in which the image will be sliced for slice animations.",'striking_admin'),
			"id" => "slices",
			"min" => "1",
			"max" => "30",
			"step" => "1",
			"default" => "10",
			"type" => "range"
		),
		array(
			"name" => __("Box Columns",'striking_admin'),
			"desc" => __("Number of Columns in which the image will be sliced for box animations.",'striking_admin'),
			"id" => "boxCols",
			"min" => "1",
			"max" => "30",
			"step" => "1",
			"default" => "8",
			"type" => "range"
		),
		array(
			"name" => __("Box Rows",'striking_admin'),
			"desc" => __("Number of Rows in which the image will be sliced for box animations.",'striking_admin'),
			"id" => "boxRows",
			"min" => "1",
			"max" => "30",
			"step" => "1",
			"default" => "4",
			"type" => "range"
		),
		array(
			"name" => __("Animation Speed",'striking_admin'),
			"desc" => __("Define the duration of the animations.",'striking_admin'),
			"id" => "animSpeed",
			"min" => "200",
			"max" => "3000",
			"step" => "100",
			'unit' => 'miliseconds',
			"default" => "500",
			"type" => "range"
		),
		array(
			"name" => __("Pause Time",'striking_admin'),
			"desc" => __("Define the delay which each slide will have to wait to be played",'striking_admin'),
			"id" => "pauseTime",
			"min" => "1000",
			"max" => "30000",
			"step" => "500",
			"unit" => 'miliseconds',
			"default" => "3000",
			"type" => "range"
		),
		array(
			"name" => __("Next & Prev Buttons",'striking_admin'),
			"desc" => __("If you want show Next & Prev Buttons on the slider show, turn on the button.",'striking_admin'),
			"id" => "directionNav",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Hide Next & Prev Buttons",'striking_admin'),
			"desc" => __("If you want hide Next & Prev Buttons until hovering the slider, turn on the button.",'striking_admin'),
			"id" => "directionNavHide",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Control Navigation",'striking_admin'),
			"desc" => __("If you want show Control Navigation on the slidershow, turn on the button.",'striking_admin'),
			"id" => "controlNav",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Hide Control Navigation",'striking_admin'),
			"desc" => __("If you want hide Control Navigation until hovering the slider, turn on the button.",'striking_admin'),
			"id" => "controlNavHide",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Pause On Hover",'striking_admin'),
			"desc" => __("If you want stop animation while hovering, turn on the button.",'striking_admin'),
			"id" => "pauseOnHover",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Random Start",'striking_admin'),
			"desc" => __("If you want random start the slide, turn on the button.",'striking_admin'),
			"id" => "randomStart",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Caption",'striking_admin'),
			"desc" => __("If you want display the title of slider item, turn on the button.",'striking_admin'),
			"id" => "caption",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("captionOpacity",'striking_admin'),
			"id" => "captionOpacity",
			"default" => '0.8',
			"min" => "0.1",
			"max" => "1",
			"step" => "0.1",
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
