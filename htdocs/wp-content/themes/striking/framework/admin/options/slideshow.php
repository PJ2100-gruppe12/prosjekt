<?php
class Theme_Options_Page_Slideshow extends Theme_Options_Page_With_Tabs {
	public $slug = 'slideshow';
	function __construct(){
		$this->name = sprintf(__('%s SlideShow Settings','striking_admin'),THEME_NAME);
		parent::__construct();
	}
	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("Post & Portfolio Linking Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Blog Posts linkable",'striking_admin'),
						"desc" => __("If toggled to <em>ON</em>, then if you select Blog Post Category in the slideshow source, the featured image of each blog post item in that category will be shown in the slideshow, and clicking on the slide image will link directly to that blog single post.",'striking_admin'),
						"id" => "post_linkable",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Portfolio Posts linkable",'striking_admin'),
						"desc" => __("If toggled to <em>ON</em>, then if you select Portfolio Post Category in the slideshow source, the featured image of each portfolio post item in that category will be shown in the slideshow, and  clicking on that slide image will link directly to that portfolio single post.",'striking_admin'),	
						"id" => "portfolio_linkable",
						"default" => true,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => 'nivo',
				"name" => __(" Nivo Slider Settings when in Featured Header Area",'striking_admin'),
				"options" => array(
					array(
						"name" => __("General Info, Height and Width",'striking_admin'),
						"desc" => __("USAGE: This slider shows image type media only.&nbsp;&nbsp;This slider can show a caption (see the <b>Turn On Captions</b> setting below for details).<br /><br />The sliding toggle allows for the adjusting the height of Nivo Slider from 60px to 600px in height.&nbsp;&nbsp;The width of the Nivo Slider when it is in the feature area is set at 960px.&nbsp;&nbsp;So all pictures used in the feature area Nivo slider should have a dimension of 960px x H.<br /><br />As the Nivo Slider is shortcoded, one can vary both the height and the width if the <b>Feature Header Type</b> setting in the <b>Striking Page General Options</b> metabox (found below the content editor on every page and post editing panel) is set to <em>Custom Text Only</em>, and then a Nivo shortcode with your desired height and width are put into the <b>Featured Header Custom Text</b> field.<br /><br />Whenever one uses the Nivo Slider shortcode, the shortcode has its own array of settings. So none of the settings below are applicable for Nivo sliders appearing in page, post or widget areas by shortcode.",'striking_admin'),
						"id" => "nivo_height",
						"min" => "60",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "440",
						"type" => "range"
					),
					array(
						"name" => __("Transition Effects",'striking_admin'),
						"desc" => __("Select which transition effect to use for the slideshow.",'striking_admin'),
						"id" => "nivo_effect",
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
						"id" => "nivo_slices",
						"min" => "1",
						"max" => "30",
						"step" => "1",
						"default" => "10",
						"type" => "range"
					),
					array(
						"name" => __("Box Columns",'striking_admin'),
						"desc" => __("Number of Columns in which the image will be sliced for box animations.",'striking_admin'),
						"id" => "nivo_boxCols",
						"min" => "1",
						"max" => "20",
						"step" => "1",
						"default" => "8",
						"type" => "range"
					),
					array(
						"name" => __("Box Rows",'striking_admin'),
						"desc" => __("Number of Rows in which the image will be sliced for box animations.",'striking_admin'),
						"id" => "nivo_boxRows",
						"min" => "1",
						"max" => "20",
						"step" => "1",
						"default" => "4",
						"type" => "range"
					),
					array(
						"name" => __("Animation Speed",'striking_admin'),
						"desc" => __("Define the duration of the animations.",'striking_admin'),
						"id" => "nivo_animSpeed",
						"min" => "200",
						"max" => "3000",
						"step" => "100",
						'unit' => 'miliseconds',
						"default" => "500",
						"type" => "range"
					),
					array(
						"name" => __("Pause Time",'striking_admin'),
						"desc" => __("Define the delay for transitions from slide to slide.",'striking_admin'),
						"id" => "nivo_pauseTime",
						"min" => "1000",
						"max" => "30000",
						"step" => "500",
						"unit" => 'miliseconds',
						"default" => "3000",
						"type" => "range"
					),
					array(
						"name" => __("Show Next & Prev Navigation Arrows",'striking_admin'),
						"desc" => __("If you want show navigation arrows on the slideshow, turn this setting to <em>ON</em>.",'striking_admin'),
						"id" => "nivo_directionNav",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Hide Next & Prev Nav Arrows on Non-Hover",'striking_admin'),
						"desc" => __("If you want hide the navigation arrows so that they only appear if a cursor is hovering over the slider, toggle this setting to <em>ON</em>.&nbsp;&nbsp;The <b>Show Next & Prev Navigation Arrows</b> setting above must be active in order for this Hide setting to work.",'striking_admin'),
						"id" => "nivo_directionNavHide",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Control Navigation Buttons",'striking_admin'),
						"desc" => __("If you want show the little navigation circles that indicate the number of slides in the slideshow, toggle this setting to <em>ON</em>.",'striking_admin'),
						"id" => "nivo_controlNav",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Hide Control Navigation Buttons on Non-Hover",'striking_admin'),
						"desc" => __("If you want hide the navigation buttons until a user is hovering their cursor over the the slider, toggle this setting to <em>ON</em>.",'striking_admin'),
						"id" => "nivo_controlNavHide",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Keyboard Navigation",'striking_admin'),
						"desc" => __("If you want to enable keyboard navigation where your site visitor can use left & right arrows to transition the slideshow, toggle this setting to <em>ON</em>.",'striking_admin'),
						"id" => "nivo_keyboardNav",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Pause On Hover",'striking_admin'),
						"desc" => __("If you want stop the nivo slider transtions from slide to slide when a user hovers their cursor over the slider, toggle this setting to <em>ON</em>.",'striking_admin'),
						"id" => "nivo_pauseOnHover",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Manual Transitions",'striking_admin'),
						"desc" => __("If you want the slideshow to advance from slide to slide oly when the viewer clicks on the left and right navigation arrows, or navigation buttons (if enabled) toggle this setting to <em>ON</em>.&nbsp;&nbsp;Note that when you have this setting active, the <b>Pause on Hover</b> setting above is not applicable",'striking_admin'),
						"id" => "nivo_manualAdvance",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Nivo Slider Random Start",'striking_admin'),
						"desc" => __("If you want the nivo slider to randomly choose the slide it starts upon toggle this setting to <em>ON</em>.&nbsp;&nbsp;Normally the slider would start with the first slide of the group of slides.&nbsp;&nbsp;With this setting toggled on, it will commence with a different slide in the group each time the page is loaded.",'striking_admin'),
						"id" => "nivo_randomStart",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Turn On Captions",'striking_admin'),
						"desc" => __("When this setting is toggled to the <em>ON</em> position, a caption will show at the bottom of the slider image.&nbsp;&nbsp;The default caption that is shown is the actual title of the slide post.&nbsp;&nbsp;However, in the <b>Striking Slider Item Options</b> metabox (this metabox is found below the slide post content editor), one can place content in the <b>Slide Caption</b> field, and that content will show instead of the slide post title.<br /><br />As well, whether using the title or the caption field, simple html such as the em, b and ul tags is permitted.&nbsp;&nbsp;The color of the caption text can be set by the <b>Featured Header Settings->Nivo Slider Caption Text Color</b> setting in the Striking Color Panel.<br /><br />The newest version of the Nivo slider script no longer supports multi-line captions.",'striking_admin'),
						"id" => "nivo_captions",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Caption Opacity",'striking_admin'),
						"desc" => __("The Opacity of Caption with it's background.",'striking_admin'),
						"id" => "nivo_captionOpacity",
						"min" => "0",
						"max" => "1",
						"step" => "0.1",
						"default" => "0.5",
						"type" => "range"
					),
					array(
						"name" => __("Stop Slideshow At End",'striking_admin'),
						"desc" => __("If this option is toggled <em>ON</em>, the slideshow will stop cycling upon reaching the last image in the Nivo Slideshow.",'striking_admin'),
						"id" => "nivo_stopAtEnd",
						"default" => false,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => '3d',
				"name" => __("Image Rotator Image Rotator Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("General Info, Captions & Mobile Slider Replacement selection",'striking_admin'),
						"desc" => __("USAGE - This is a slider that is available solely in the Striking Feature Header Area.&nbsp;&nbsp;This slider shows image type media only.<br /><br />CAPTIONS - Please note the Image Rotator slider does not support captions - so you would have to build any captions you wish into the slider images directly using Paint, Adobe or similar software for image manipulation.<br /><br />When users using mobile device to view the site, it will use the slider you choose below instead of using the Image Rotator slider - as the Image Rotator slider is not mobile device compatible. ",'striking_admin'),
						"id" => "3d_mobile",
						"default" => "anything",
						"options" => array(
							"nivo" => __('jQuery Nivo Slider','striking_admin'),
							"kwicks" => __('Accordion Slider','striking_admin'),
							"anything" => __('Anything Slider','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Height and Width",'striking_admin'),
						"desc" => __("The Image Rotator slider has 5 height settings to choose from - 150, 250, 320, 400 and 440px.&nbsp;&nbsp;The width of the Image Rotator slider is 960px.&nbsp;&nbsp;So all pictures used in this slider should have a dimension of 960px x H.",'striking_admin'),
						"id" => "3d_height",
						"default" => '440',
						"options" => array(
							"150" => '150px',
							"250" => '250px',
							"320" => '320px',
							"400" => '400px',
							"440" => '440px',
						),
						"type" => "select",
					),
					array(
						"name" => __("Segments",'striking_admin'),
						"desc" => __("Number of segments in which the image will be sliced.",'striking_admin'),
						"id" => "3d_segments",
						"min" => "1",
						"max" => "30",
						"step" => "1",
						"default" => "10",
						"type" => "range"
					),
					array(
						"name" => __("Tween Time",'striking_admin'),
						"desc" => __("Number of seconds for each element to be turned.",'striking_admin'),
						"id" => "3d_tweenTime",
						"min" => "0",
						"max" => "3",
						"step" => "0.1",
						"unit" => 'seconds',
						"default" => "1.2",
						"type" => "range"
					),
					array(
						"name" => __("Tween Delay",'striking_admin'),
						"desc" => __("Number of seconds from one element starting to turn to the next element starting.",'striking_admin'),
						"id" => "3d_tweenDelay",
						"min" => "0",
						"max" => "1",
						"step" => "0.1",
						"unit" => 'seconds',
						"default" => "0.1",
						"type" => "range"
					),
					array(
						"name" => __("Tween Type",'striking_admin'),
						"desc" => __("Select which effect to use when transition.",'striking_admin'),
						"id" => "3d_tweenType",
						"default" => 'easeInOutCirc',
						"options" => array(
							"linear" => 'linear',
							"easeInSine" => 'easeInSine',
							"easeOutSine" => 'easeOutSine',
							"easeInOutSine" => 'easeInOutSine',
							"easeInCubic" => 'easeInCubic',
							"easeOutCubic" => 'easeOutCubic',
							"easeInOutCubic" => 'easeInOutCubic',
							"easeOutInCubic" => 'easeOutInCubic',
							"easeInQuint" => 'easeInQuint',
							"easeOutQuint" => 'easeOutQuint',
							"easeInOutQuint" => 'easeInOutQuint',
							"easeOutInQuint" => 'easeOutInQuint',
							"easeInCirc" => 'easeInCirc',
							"easeOutCirc" => 'easeOutCirc',
							"easeInOutCirc" => 'easeInOutCirc',
							"easeOutInCirc" => 'easeOutInCirc',
							"easeInBack" => 'easeInBack',
							"easeOutBack" => 'easeOutBack',
							"easeInOutBack" => 'easeInOutBack',
							"easeOutInBack" => 'easeOutInBack',
							"easeInQuad" => 'easeInQuad',
							"easeOutQuad" => 'easeOutQuad',
							"easeInOutQuad" => 'easeInOutQuad',
							"easeOutInQuad" => 'easeOutInQuad',
							"easeInQuart" => 'easeInQuart',
							"easeOutQuart" => 'easeOutQuart',
							"easeInOutQuart" => 'easeInOutQuart',
							"easeOutInQuart" => 'easeOutInQuart',
							"easeInExpo" => 'easeInExpo',
							"easeOutExpo" => 'easeOutExpo',
							"easeInOutExpo" => 'easeInOutExpo',
							"easeOutInExpo" => 'easeOutInExpo',
							"easeInElastic" => 'easeInElastic',
							"easeOutElastic" => 'easeOutElastic',
							"easeInOutElastic" => 'easeInOutElastic',
							"easeOutInElastic" => 'easeOutInElastic',
							"easeInBounce" => 'easeInBounce',
							"easeOutBounce" => 'easeOutBounce',
							"easeInOutBounce" => 'easeInOutBounce',
							"easeOutInBounce" => 'easeOutInBounce',
						),
						"type" => "select",
					),
					array(
						"name" => __("Z Distance",'striking_admin'),
						"desc" => __("To which extend are the cubes moved on z axis when being tweened.&nbsp;&nbsp;Negative values bring the cube closer to the camera, positive values take it further away.",'striking_admin'),
						"id" => "3d_zDistance",
						"min" => "-200",
						"max" => "700",
						"step" => "50",
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("Expand",'striking_admin'),
						"desc" => __("To which extend are the cubes moved away from each other when tweening.",'striking_admin'),
						"id" => "3d_expand",
						"min" => "0",
						"max" => "100",
						"step" => "5",
						"default" => "20",
						"type" => "range"
					),
					array(
						"name" => __("Inner Color",'striking_admin'),
						"desc" => __("Color of the sides of the elements in hex values",'striking_admin'),
						"id" => "3d_innerColor",
						"default" => "#111111",
						"type" => "color"
					),
					array(
						"name" => __("Shadow Darkness",'striking_admin'),
						"desc" => __("To which extend are the sides shadowed, when the elements are tweening and the sided move towards the background.&nbsp;&nbsp;100 is black, 0 is no darkening.",'striking_admin'),
						"id" => "3d_shadowDarkness",
						"min" => "0",
						"max" => "100",
						"step" => "10",
						"default" => "100",
						"type" => "range"
					),
					array(
						"name" => __("Autoplay",'striking_admin'),
						"desc" => __("Number of seconds to the next image, when autoplay is on.&nbsp;&nbsp;Set 0, if you don‘t want autoplay.",'striking_admin'),
						"id" => "3d_autoplay",
						"min" => "0",
						"max" => "20",
						"step" => "1",
						"unit" => 'seconds',
						"default" => "5",
						"type" => "range"
					),
				),
			),
			array(
				"slug" => 'accordion',
				"name" => __("Accordion Slider Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("General Info & Height Settings",'striking_admin'),
						"desc" => __("USAGE - This is a slider that is available solely in the Striking Feature Header Area.&nbsp;&nbsp;It has the flexibility to show multiple levels of information detail (see the Caption and Description settings below) in an image slide.&nbsp;&nbsp;It shows image type media only.<br /><br />The sliding toggle allows for the adjusting the height of Accordion Slider, which can vary from 60px to 600px.&nbsp;&nbsp;The width of the Accordion Slider is 960px.&nbsp;&nbsp;So all pictures used in in this slider should have a dimension of 960px x H.",'striking_admin'),
						"id" => "kwicks_height",
						"min" => "60",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "440",
						"type" => "range"
					),
					array(
						"name" => __("AutoPlay",'striking_admin'),
						"desc" => __("If you want slider expand automatically, turn on the button.&nbsp;&nbsp;If you leave this setting off, then the viewer will have to click on each slide in order to see it fully.",'striking_admin'),
						"id" => "kwicks_autoplay",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("AutoPlay Pause Time",'striking_admin'),
						"desc" => __("Set the transition time by which each slide will have to wait to be played",'striking_admin'),
						"id" => "kwicks_pauseTime",
						"min" => "1000",
						"max" => "10000",
						"step" => "500",
						"unit" => 'miliseconds',
						"default" => "5000",
						"type" => "range"
					),
					array(
						"name" => __("Number Of Slides",'striking_admin'),
						"desc" => __("Set the number of slides to show.",'striking_admin'),
						"id" => "kwicks_number",
						"min" => "2",
						"max" => "8",
						"step" => "1",
						"default" => "4",
						"type" => "range"
					),
					array(
						"name" => __("Max width",'striking_admin'),
						"desc" => __("Define the width of a fully expanded slider element.&nbsp;&nbsp;The miminum width is 240 px and the max width is 960px, in 10 px increments.",'striking_admin'),
						"id" => "kwicks_max",
						"min" => "240",
						"max" => "960",
						"step" => "10",
						'unit' => 'px',
						"default" => "850",
						"type" => "range"
					),
					array(
						"name" => __("Animation Speed",'striking_admin'),
						"desc" => __("Set the duration of the animations.",'striking_admin'),
						"id" => "kwicks_duration",
						"min" => "0",
						"max" => "3000",
						"step" => "100",
						'unit' => 'milliseconds',
						"default" => "800",
						"type" => "range"
					),
					array(
						"name" => __("Easing Animations",'striking_admin'),
						"desc" => __("Select which easing effect to use.",'striking_admin'),
						"id" => "kwicks_easing",
						"default" => 'linear',
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
						"name" => __("Accordion Caption Setting",'striking_admin'),
						"desc" => __("When this setting is toggled to the <em>On</em> position, a caption will show at the bottom of the slider image.&nbsp;&nbsp;The default caption that is shown is the actual title of the slide post.&nbsp;&nbsp;However, in the <b>Striking Slider Options</b> metabox, one can place some content in the <b>Slide Caption</b> field, and that content will show instead of the slide post title.<br /><br />As well, whether using the title or the caption field, simple html such as the b, em and ul tags is allowed.<br /><br />The caption font automatically expands to an H3 title size upon hover by a cursor and the non-hover and hover caption font sizes are adjustable using the <b>Accordion Slider Caption Non-Hover</b>, and <b>Accordion Slider Caption Hover</b> settings in the Striking Font Panel.",'striking_admin'),				
						"id" => "kwicks_title",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Caption Fade Speed",'striking_admin'),
						"desc" => __("Define the Speed of caption fade transition.",'striking_admin'),
						"id" => "kwicks_title_speed",
						"min" => "0",
						"max" => "2000",
						"step" => "100",
						'unit' => 'miliseconds',
						"default" => "500",
						"type" => "range"
					),
					array(
						"name" => __("Caption Opacity",'striking_admin'),
						"desc" => __("Define the Opacity of caption.",'striking_admin'),
						"id" => "kwicks_title_opacity",
						"min" => "0",
						"max" => "1",
						"step" => "0.1",
						"default" => "0.6",
						"type" => "range"
					),
					array(
						"name" => __("Accordion Slider Description Field",'striking_admin'),
						"desc" => __("A benefit of the Accordion Slider is that one can show both a caption, and also show with it a description which can be multiline in size.&nbsp;&nbsp;Please note the description only becomes visible on hover, thus a popular usage of the slider is to have it in manual transition mode when using the description ability of the slider. <br /><br />To enable this content, toggle this setting to <em>ON</em>, and in the slide post, fill out some content in the <b>Description</b> field of the <b>Slider Item Options</b> Metabox.&nbsp;&nbsp;The description field allows for simple html.<br /><br />The description font size is adjustable using the <b>Accordion Slider Description Text size</b> setting in the Striking Font Panel.",'striking_admin'),
						"id" => "kwicks_detail",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Description Fade Speed",'striking_admin'),
						"desc" => __("Define the Speed of detail fade transition.",'striking_admin'),
						"id" => "kwicks_detail_speed",
						"min" => "0",
						"max" => "2000",
						"step" => "100",
						'unit' => 'miliseconds',
						"default" => "500",
						"type" => "range"
					),
					array(
						"name" => __("Description Opacity",'striking_admin'),
						"desc" => __("Define the Opacity of detail.",'striking_admin'),
						"id" => "kwicks_detail_opacity",
						"min" => "0",
						"max" => "1",
						"step" => "0.1",
						"default" => "0.6",
						"type" => "range"
					),
				),
			),
			array(
				"slug" => 'anything',
				"name" => __("Anything Slider Settings when in Featured Header Area",'striking_admin'),
				"options" => array(
					array(
						"name" => __("General Info, Height and Width",'striking_admin'),
						"desc" => __("USAGE: The Anything slider is an extremly powerful tool in which one can show all types of media includings images, gifs, youtube, vimeo and html 5 videos, and more.&nbsp;&nbsp;It is a very complex slider with an extremely wide variety of settings and abilities - in the display of simple media it is as easy to set up as a Nivo slider, but the display of multiple media and individual tweaks for your customization will almost certainly result in a learning curve on your part.&nbsp;&nbsp; While we provide information in help fields users should also visit the Striking demo and Striking support forum for examples of usage and support threads on various customization abilities of the slider.<br /><br />As the Anything Slider is shortcoded, one can vary both the height and the width if the <b>Feature Header Type</b> setting in the <b>Striking Page General Options</b> metabox (found below the content editor on every page and post editing panel) is set to <em>Custom Text Only</em>, and then an Anything Slider shortcode with your desired height and width are put into the <b>Featured Header Custom Text</b> field.<br /><br />Whenever one uses the Anything Slider shortcode, the shortcode has its own array of settings. So none of the settings below are applicable for Anything sliders appearing in page, post or widget areas by shortcode.<br /><br />The sliding toggle allows for the adjusting the height of the Anything Slider from 60px to 600px in height.&nbsp;&nbsp;The width of the Anything Slider when it is in the feature area is set at 960px.&nbsp;&nbsp;So all pictures used in the feature area Anything slider should have a dimension of 960px x H.",'striking_admin'),
						"id" => "anything_height",
						"min" => "60",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "440",
						"type" => "range"
					),
					array(
						"name" => __("Easing Animations",'striking_admin'),
						"desc" => __("Select which easing effect to use.",'striking_admin'),
						"id" => "anything_easing",
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
						"name" => __("Show Navigation Arrows",'striking_admin'),
						"desc" => __("If <em>ON</em>, displays the forwards and backwards navigation arrows",'striking_admin'),
						"id" => "anything_buildArrows",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Hover only for Navigation Arrows",'striking_admin'),
						"desc" => __("If <em>ON</em>, the side navigation arrows will slide out on hovering & hide when a user cursor moves off the slider item.",'striking_admin'),
						"id" => "anything_toggleArrows",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Control Navigation Buttons",'striking_admin'),
						"desc" => __("If you want show the little navigation circles that indicate the number of slides in the slideshow, toggle this setting to <em>ON</em>.",'striking_admin'),
						"id" => "anything_buildNavigation",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Navigation Display on Changeup/Hover only",'striking_admin'),
						"desc" => __("If <em>ON</em>, the various navigation controls (navigation + play/stop button) appear on hover and slide change, and hide at otherwise.",'striking_admin'),
						"id" => "anything_toggleControls",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Arrows for Navigation",'striking_admin'),
						"desc" => __("When <em>OFF</em>, the navigation arrows will be visible, but not clickable.&nbsp;&nbsp;Typically one has the setting <em>ON</em> so that the navigations arrows, if set to show by the above settings, actually function.",'striking_admin'),
						"id" => "anything_enableArrows",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Buttons for Navigation",'striking_admin'),
						"desc" => __("When <em>OFF,</em> the navigation buttons will be visible, but not clickable.",'striking_admin'),
						"id" => "anything_enableNavigation",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable Keyboard Navigation",'striking_admin'),
						"desc" => __("If <em>ON</em>, keyboard arrow keys will work for navigation for this slider.",'striking_admin'),
						"id" => "anything_enableKeyboard",
						"default" => true,
						"type" => "toggle"
					),
					
					array(
						"name" => __("Slideshow AutoPlay",'striking_admin'),
						"desc" => __("If <em>ON</em>, the slideshow will commence automatically upon page load.<br /><br />YOUTUBE NOTE: Currently we have an issue with youtube videos auto advancing in the Anything Slider while they are playing.&nbsp;&nbsp;One way to deal with this matter temporarily is to have this setting <em>OFF</em> so that the user has to advance each slide manually.&nbsp;&nbsp;In this instance we suggest you enable both arrow and button navigation so that the user has visual cues that there are multiple slides in the slideshow.&nbsp;&nbsp;The <b>Pause on Hover</b> setting below has alternate suggestions in respect of the youtube issue should you choose to proceed with having your slideshow autoplay.",'striking_admin'),
						"id" => "anything_autoPlay",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("AutoPlay Locked",'striking_admin'),
						"desc" => __("If <em>ON</em>, the slideshow will run continuously and the user changing slides will not stop the slideshow from subsequently advancing.",'striking_admin'),
						"id" => "anything_autoPlayLocked",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("AutoPlayDelayed",'striking_admin'),
						"desc" => __("If <em>ON</em>, starting a slideshow will delay advancing slides; if false, the slider will immediately advance to the next slide when the page loads.",'striking_admin'),
						"id" => "anything_autoPlayDelayed",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Pause On Hover",'striking_admin'),
						"desc" => __("If true & the slideshow is active, the slideshow will pause on hover by a user cursor.<br /><br />YOUTUBE VIDEO - At this time, if one has youtube videos in a slideshow, one should have this setting in the <em>ON</em> position as only if a user hovers over the playing video will it continue to play and the slider stop advancing while playing, unless you have the <b>Slideshow Autoplay</b> setting above in the <em>OFF</em> position.&nbsp;&nbsp;We are working on this error as the slider should pause on play for a youtube video, when the </b>Resume on Video End</b> setting below is enabled, but the latest versions of the Youtube and Anything Slider scripts are not playing well together.&nbsp;&nbsp;We will resolve asap!",'striking_admin'),
						"id" => "anything_pauseOnHover",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Stop At Last Slide",'striking_admin'),
						"desc" => __("If <em>ON</em> & the slideshow is active, the slideshow will stop on the last slide",'striking_admin'),
						"id" => "anything_stopAtEnd",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Play Slides in RTL format",'striking_admin'),
						"desc" => __("If <em>ON</em>, the slideshow will move right-to-left",'striking_admin'),
						"id" => "anything_playRtl",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("resumeOnVideoEnd",'striking_admin'),
						"desc" => __("If <em>ON</em> & the slideshow is active & a youtube video is playing, the autoplay will pause until the video completes",'striking_admin'),
						"id" => "anything_resumeOnVideoEnd",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("resumeOnVisible",'striking_admin'),
						"desc" => __("If true the video will resume playing (if previously paused, except for YouTube iframe - known issue); if false, the video remains paused.",'striking_admin'),
						"id" => "anything_resumeOnVisible",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("delay",'striking_admin'),
						"desc" => __("How long between slideshow transitions in AutoPlay mode",'striking_admin'),
						"id" => "anything_delay",
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
						"id" => "anything_resumeDelay",
						"min" => "1000",
						"max" => "80000",
						"step" => "1000",
						'unit' => 'miliseconds',
						"default" => "15000",
						"type" => "range"
					),
					array(
						"name" => __("animationTime",'striking_admin'),
						"desc" => __("How long the slideshow transition takes",'striking_admin'),
						"id" => "anything_animationTime",
						"min" => "200",
						"max" => "10000",
						"step" => "100",
						"unit" => 'miliseconds',
						"default" => "500",
						"type" => "range"
					),
					array(
						"name" => __("Caption Opacity",'striking_admin'),
						"desc" => __("The Opacity of Caption with it's background.",'striking_admin'),
						"id" => "anything_captionOpacity",
						"min" => "0",
						"max" => "1",
						"step" => "0.1",
						"default" => "0.8",
						"type" => "range"
					),
					array(
						"name" => __("Blog & Portfolio Posts Caption Position",'striking_admin'),
						"desc" => __("If one is showing Blog and/or Portfolio Post featured images with the slider, the title of the post will show as a caption if set to one of the 4 enabled positions of top, bottom, left or right.&nbsp;&nbsp; One can also choose only to display the post featured image, but not the post title by selecting disable.",'striking_admin'),
						"id" => "anything_postsCaptionPosition",
						"default" => 'bottom',
						"options" => array(
							"top" => __('Top','striking_admin'),
							"bottom" => __('Bottom','striking_admin'),
							"left" => __('Left','striking_admin'),
							"right" => __('Right','striking_admin'),
							"disable" => __('Disable','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
		);
		return $options;
	}
}
