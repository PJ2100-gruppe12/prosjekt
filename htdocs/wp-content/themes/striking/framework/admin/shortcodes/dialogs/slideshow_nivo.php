<?php
$init_script = <<<HTML
	jQuery('[name="_source[]"]').on("change",function(){
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
	"title" => __("Nivo Slideshow", "theme_admin"),
	"shortcode" => 'slideshow',
	"attributes" => 'type="nivo"',
	"type" => 'enclosing',
	"init" => $init_script,
	"options" => array(
		array(
			"name" => __("Images Srcs (optional)",'theme_admin'),
			"desc" => __("separated by linebreak",'theme_admin'),
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		),
		array(
			"name" => __("Number (optional)",'theme_admin'),
			"desc" => __("Sets the number of images to display.<br> 0: Display all images.",'theme_admin'),
			"id" => "number",
			"default" => '0',
			"min" => 0,
			"max" => 20,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("SlideShow Source (optional)",'theme_admin'),
			"desc" => __("Select which SlideShow Source to show.",'theme_admin'),
			"id" => "source",
			"options" => array(
				"g" => __('Self Gallery','theme_admin'),
			),
			"default" => "",
			"chosen" => true,
			"prompt" => __("Select Source..",'theme_admin'),
			'target' => 'slideshow_source',
			'function' => 'theme_dialog_slideshow_source',
			"type" => "custom"
		),
		array(
			"name" => __("Width",'theme_admin'),
			"desc" => __("Width of slider.",'theme_admin'),
			"id" => "width",
			"min" => "10",
			"max" => "960",
			"step" => "1",
			"unit" => 'px',
			"default" => "630",
			"type" => "range"
		),
		array(
			"name" => __("Height",'theme_admin'),
			"desc" => __("Height of slider.",'theme_admin'),
			"id" => "height",
			"min" => "10",
			"max" => "1000",
			"step" => "1",
			"unit" => 'px',
			"default" => "300",
			"type" => "range"
		),
		array(
			"name" => __("Transition Effects",'theme_admin'),
			"desc" => __("Select which effect to use on the slideshow.",'theme_admin'),
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
			"name" => __("Segments",'theme_admin'),
			"desc" => __("Number of segments in which the image will be sliced for slice animations.",'theme_admin'),
			"id" => "slices",
			"min" => "1",
			"max" => "30",
			"step" => "1",
			"default" => "10",
			"type" => "range"
		),
		array(
			"name" => __("Box Columns",'theme_admin'),
			"desc" => __("Number of Columns in which the image will be sliced for box animations.",'theme_admin'),
			"id" => "boxCols",
			"min" => "1",
			"max" => "30",
			"step" => "1",
			"default" => "8",
			"type" => "range"
		),
		array(
			"name" => __("Box Rows",'theme_admin'),
			"desc" => __("Number of Rows in which the image will be sliced for box animations.",'theme_admin'),
			"id" => "boxRows",
			"min" => "1",
			"max" => "30",
			"step" => "1",
			"default" => "4",
			"type" => "range"
		),
		array(
			"name" => __("Animation Speed",'theme_admin'),
			"desc" => __("Define the duration of the animations.",'theme_admin'),
			"id" => "animSpeed",
			"min" => "200",
			"max" => "3000",
			"step" => "100",
			'unit' => 'miliseconds',
			"default" => "500",
			"type" => "range"
		),
		array(
			"name" => __("Pause Time",'theme_admin'),
			"desc" => __("Define the delay which each slide will have to wait to be played",'theme_admin'),
			"id" => "pauseTime",
			"min" => "1000",
			"max" => "30000",
			"step" => "500",
			"unit" => 'miliseconds',
			"default" => "3000",
			"type" => "range"
		),
		array(
			"name" => __("Next & Prev Buttons",'theme_admin'),
			"desc" => __("If you want show Next & Prev Buttons on the slider show, turn on the button.",'theme_admin'),
			"id" => "directionNav",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Hide Next & Prev Buttons",'theme_admin'),
			"desc" => __("If you want hide Next & Prev Buttons until hovering the slider, turn on the button.",'theme_admin'),
			"id" => "directionNavHide",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Control Navigation",'theme_admin'),
			"desc" => __("If you want show Control Navigation on the slidershow, turn on the button.",'theme_admin'),
			"id" => "controlNav",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Hide Control Navigation",'theme_admin'),
			"desc" => __("If you want hide Control Navigation until hovering the slider, turn on the button.",'theme_admin'),
			"id" => "controlNavHide",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Pause On Hover",'theme_admin'),
			"desc" => __("If you want stop animation while hovering, turn on the button.",'theme_admin'),
			"id" => "pauseOnHover",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Random Start",'theme_admin'),
			"desc" => __("If you want random start the slide, turn on the button.",'theme_admin'),
			"id" => "randomStart",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Caption",'theme_admin'),
			"desc" => __("If you want display the title of slider item, turn on the button.",'theme_admin'),
			"id" => "caption",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("captionOpacity",'theme_admin'),
			"id" => "captionOpacity",
			"default" => '0.8',
			"min" => "0.1",
			"max" => "1",
			"step" => "0.1",
			"type" => "range"
		),
		array(
			"name" => __("Stop Slideshow At End",'theme_admin'),
			"desc" => __("If this option is toggled <em>ON</em>, the slideshow will stop cycling upon reaching the last image in the Nivo Slideshow.",'theme_admin'),
			"id" => "stopAtEnd",
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" =>  __("Align (optional)",'theme_admin'),
			"id" => "align",
			"default" => '',
			"prompt" => __("Default",'theme_admin'),
			"options" => array(
				"left" => __('left','theme_admin'),
				"right" => __('right','theme_admin'),
				"center" => __('center','theme_admin'),
			),
			"type" => "select",
		),
	),
);
