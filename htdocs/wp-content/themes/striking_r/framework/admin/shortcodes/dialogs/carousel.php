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
	jQuery('[name="number"]').on("change",function(){
		var steps_number = jQuery(this).val();
		jQuery('.shortcode-item').each(function(i){
			if(i>(7+steps_number*3)){
				jQuery(this).hide();
			}else{
				jQuery(this).show();
			}
		});
	}).trigger("change");
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
$custom_script = <<<HTML
	var number = attrs['number'].value;	
	var source = attrs['source'].value;
	var title = attrs['title'].value;
	var nav = attrs['nav'].value;
	var autoplay = attrs['autoplay'].value;
	var circular = attrs['circular'].value;
	var lightbox = attrs['lightbox'].value;
	var number_attr = '';

	if(source){
		source = ' source="'+source+'"';

		if(number !== '0'){
			number_attr = ' number="'+number+'"';
		}
	}
	if(title){
		title = ' title="'+title+'"';
	}
	if(nav === 'true'){
		nav = ' nav="'+nav+'"';
	}else{
		nav = '';
	}
	if(autoplay === 'false'){
		autoplay = ' autoplay="'+autoplay+'"';
	}else{
		autoplay = '';
	}
	if(circular === 'true'){
		circular = ' circular="'+circular+'"';
	}else{
		circular = '';
	}
	if(lightbox === 'true'){
		lightbox = ' lightbox="'+lightbox+'"';
	}else{
		lightbox = '';
	}

	var ret = '\\n[carousel width="'+attrs['width'].value+'" height="'+attrs['height'].value+'"'+source+number_attr+title+nav+autoplay+circular+lightbox+']\\n';
	var caption = '';
	var imgSource = '';
	for(var i=1;i<=number;i++){
		if(attrs['source_'+i].value){
			imgSource = jQuery.parseJSON(attrs['source_'+i].value);
			if(attrs['caption_'+i].value){
				caption = ' caption="'+attrs['caption_'+i].value+'"';
			}else{
				caption = '';
			}

			ret +='  [carousel_image source_type="'+imgSource.type+'" source_value="'+imgSource.value+'"'+caption+']\\n';
		}
	}
	ret +='[/carousel]\\n';
	return ret;
HTML;
return array(
	"title" => __("Carousel",'theme_admin'),
	"type" => 'custom',
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
		array (
			"name" => __("Lightbox",'theme_admin'),
			"desc" => __("Enable lightbox support when click on the item",'theme_admin'),
			"id" => "lightbox",
			"default" => false,
			"type" => "toggle"
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
			"name" => __("Number of images",'theme_admin'),
			"id" => "number",
			"min" => "0",
			"max" => "15",
			"step" => "1",
			"default" => "0",
			"type" => "range"
		),
		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),1),
			"id" => "source_1",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),1),
			"id" => "caption_1",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),1),
			"id" => "link_1",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),2),
			"id" => "source_2",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),2),
			"id" => "caption_2",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),2),
			"id" => "link_2",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),3),
			"id" => "source_3",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),3),
			"id" => "caption_3",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),3),
			"id" => "link_3",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),4),
			"id" => "source_4",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),4),
			"id" => "caption_4",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),4),
			"id" => "link_4",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),5),
			"id" => "source_5",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),5),
			"id" => "caption_5",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),5),
			"id" => "link_5",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),6),
			"id" => "source_6",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),6),
			"id" => "caption_6",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),6),
			"id" => "link_6",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),7),
			"id" => "source_7",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),7),
			"id" => "caption_7",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),7),
			"id" => "link_7",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),8),
			"id" => "source_8",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),8),
			"id" => "caption_8",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),8),
			"id" => "link_8",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),9),
			"id" => "source_9",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),9),
			"id" => "caption_9",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),9),
			"id" => "link_9",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),10),
			"id" => "source_10",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),10),
			"id" => "caption_10",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),10),
			"id" => "link_10",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),11),
			"id" => "source_11",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),11),
			"id" => "caption_11",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),11),
			"id" => "link_11",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),12),
			"id" => "source_12",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),12),
			"id" => "caption_12",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),12),
			"id" => "link_12",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),13),
			"id" => "source_13",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),13),
			"id" => "caption_13",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),13),
			"id" => "link_13",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),14),
			"id" => "source_14",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),14),
			"id" => "caption_14",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),14),
			"id" => "link_14",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),

		array(
			"name" =>sprintf(__("Image %d Source",'theme_admin'),15),
			"id" => "source_15",
			"size" => 30,
			"default" => "",
			"type" => "upload",
		),
		array(
			"name" => sprintf(__("Image %d Caption (optional)",'theme_admin'),15),
			"id" => "caption_15",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
		array(
			"name" => sprintf(__("Image %d Link (optional)",'theme_admin'),15),
			"id" => "link_15",
			"default" => "",
			"class"=> 'full',
			"type" => "text"
		),
	),
	"custom" => $custom_script,
	"init" => $init_script,
);
