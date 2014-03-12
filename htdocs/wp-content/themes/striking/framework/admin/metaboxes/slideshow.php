<?php
class Theme_Metabox_Slideshow extends Theme_Metabox_With_Tabs {
	public $slug = 'slideshow';
	public function config(){
		return array(
			'title' => sprintf(__('%s Slider Options','striking_admin'),THEME_NAME),
			'post_types' => array('slideshow'),
			'callback' => '',
			'context' => 'normal',
			'priority' => 'high',
		);
	}

	public function __construct(){
		parent::__construct();
		foreach($this->config['post_types'] as $post_type){
			if (theme_is_post_type($post_type)){
				add_action('admin_init', array(&$this, '_enqueue_script'));
			}
		}
	}

	public function _enqueue_script(){
		wp_enqueue_script('theme-metabox-anything-slider', THEME_ADMIN_ASSETS_URI . '/js/metabox_anything_slider.js', array('jquery'));
	}

	public function tabs(){
		return array(
			array(
				"name" => __("Slider Item Options",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Slide Caption (optional)",'striking_admin'),
						"desc" => __("<p>If one has enabled captions in the slider they are using, Striking will show the title of the slide post, unless you fill out this field.</p> <p><strong>USAGE</strong>: &nbsp;&nbsp;The Accordion Slider and the Anything Slider allow for multi-line captions, and the Nivo Slider permits single line captions only. &nbsp;&nbsp;The 3d Slider does not have caption ability.</p><p>This field accepts simple html such as the em, b, and other tags.</p><p>The Accordion font size of this caption is adjustable in the Striking Font panel by way of the <b>Accordion Slider Non-Hover Caption Text Size,</b> the <b>Accordion Slider On-Hover Caption Text Size,</b> and the <b>Anything Slider Caption Text Size</b> settings.</p> ",'striking_admin'),	 				
						"id" => "_caption",
						"default" => "",
						"class" => 'full',
						"htmlspecialchars" => true,
						"type" => "text"
					),
					array(
						"name" => __("Description (optional)",'striking_admin'),
						"desc" => __("<p><strong>USAGE</strong>:&nbsp;&nbsp; The Accordion Slider & Anything Slider have a 2 part caption ability.&nbsp;&nbsp; They can display the content of the caption field above in a manner similar to a title line, and also can optionally display the content of this field as paragraph text below the caption.&nbsp;&nbsp;One can display only the caption, only the description, or both together!</p><p>The font size for this text is adjustable in the Striking Font panel by way of the <b>Accordion Slider Description Text Size</b> and <b>Anything Slider Description Text Size</b> settings.</p>",'striking_admin'),	
						"id" => "_description",
						"default" => "",
						"rows" => "2",
						"type" => "textarea"
					),
					array(
						"name" => __("Image link to a URL (optional) ",'striking_admin'),
						"desc" => __("You can have an image link to either an internal or external url.&nbsp;&nbsp; Selecting any of the options in the drop down selector will cause another field to appear which will provide the appropriate items to choose from based on your selection.&nbsp;&nbsp;<u>For linking to an external url</u>, select <em>Link Manually</em> and a text field will appear where you should type in the full web address including the <code>http://</code>",'striking_admin'),
						"id" => "_link_to",
						"default" => "",
						"type" => "superlink"
					),
					array(
						"name" => __("Link Target",'striking_admin'),
						"id" => "_link_target",
						"default" => '_self',
						"options" => array(
							"_blank" => __('Load in a new window','striking_admin'),
							"_self" => __('Load in the same frame as it was clicked','striking_admin'),
							"_parent" => __('Load in the parent frameset','striking_admin'),
							"_top" => __('Load in the full body of the window','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"name" => __("Anything-Slider Setup",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Slider Type",'striking_admin'),
						"desc" => __("<p>It is with this setting that one chooses whether one wants to have an image with caption (which allows for the caption only to show in one of 4 positions), an image with a sidebar (which allows for an image with the content from both the caption and description fields to display), or an html type slide for displaying media of any type including videos, gifs, swf, and everything else</p><p><strong>HTML VIDEO & OTHER HTML USAGE</strong>: &nbsp;&nbsp;If one wants a video to appear, then after setting this to HTML, one should use the Striking Shortcode button to place a video shortcode into the slide post editor above.&nbsp;&nbsp;Similarly, one can design an html slide to have any other content, everything that is in the shortcode editor, plus all custom code and text can be used.&nbsp;&nbsp;One uses the post editor box to design an html slide just like one one use the editor to design a page. &nbsp;&nbsp;Use may use the video shortcodes for videos, image shortcodes for imagery, layout and columns for organizing content, and more exactly as per laying out a page.</p><p><b>Hints:</b>&nbsp;&nbsp; Remember that in html mode, the slide has no featured image and loading a featured image is not necessary.&nbsp;&nbsp;Also be advised that if one is creating a video slide, depending on the video type, one may need to include a poster image as part of the code - for example youtube and vimeo supply the poster image automatically, but one should provide the poster image as part of thecode for an html5 and flash video.</p><p>The Striking Support Forum and the Striking Demo site have many discussions and examples of the various types of Anything Slider slides possible, all in the same slideshow - one can mix your Anything Slider slide content types at will in a show using this slider type.</p>",'striking_admin'),
						"id" => "_anything_type",
						"default" => 'image',
						"options" => array(
							"image" => __('Image with caption','striking_admin'),
							"sidebar" => __('Sidebar','striking_admin'),
							"html" => __('Html','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Caption Background Color",'striking_admin'),
						"desc" => __("You can specify a color for the Anything Slider Caption background which will override the default black color. Set to transparent to disable the caption background color.",'striking_admin'),
						"id" => "_anything_caption_bg",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Sidebar Background Color",'striking_admin'),
						"desc" => __("You can specify a color for the Anything Slider Sidebar background which will override the default black color. Set to transparent to disable the sidebar color.",'striking_admin'),
						"id" => "_anything_bg",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Image Caption Position",'striking_admin'),
						"id" => "_image_caption_position",
						"group" => 'image',
						"default" => 'disable',
						"options" => array(
							"top" => __('Top','striking_admin'),
							"bottom" => __('Bottom','striking_admin'),
							"left" => __('Left','striking_admin'),
							"right" => __('Right','striking_admin'),
							"disable" => __('Disable','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Sidebar Position",'striking_admin'),
						"id" => "_sidebar_position",
						"group" => 'sidebar',
						"default" => 'left',
						"options" => array(
							"left" => __('Left','striking_admin'),
							"right" => __('Right','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"name" => __("3D image Rotator",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Transition Pieces",'striking_admin'),
						"desc" => __("Number of pieces to which the image is sliced. If set to 0, it will use the general setting.",'striking_admin'),
						"id" => "_3d_pieces",
						"min" => "0",
						"max" => "30",
						"step" => "1",
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("Transition Time",'striking_admin'),
						"desc" => __("Number of seconds for each element to be turned. If set to 0, it will use the general setting.",'striking_admin'),
						"id" => "_3d_time",
						"min" => "0",
						"max" => "3",
						"step" => "0.1",
						"unit" => 'seconds',
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("Transition Delay",'striking_admin'),
						"desc" => __("Number of seconds from one element starting to turn to the next element starting. If set to 0, it will use the general setting.",'striking_admin'),
						"id" => "_3d_delay",
						"min" => "0",
						"max" => "1",
						"step" => "0.1",
						"unit" => 'seconds',
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("Transition Type",'striking_admin'),
						"desc" => __("Select which effect to use when transition.",'striking_admin'),
						"id" => "_3d_transition",
						"default" => 'default',
						"options" => array(
							"default" => 'default',
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
						"name" => __("Transition Depth Offset",'striking_admin'),
						"desc" => __("The offset during transition on the z-axis. If set to 0, it will use the general setting.",'striking_admin'),
						"id" => "_3d_depthOffset",
						"min" => "0",
						"max" => "1000",
						"step" => "100",
						"default" => "0",
						"type" => "range"
					),
					array(
						"name" => __("Transition Cube Distance",'striking_admin'),
						"desc" => __("The distance between the cubes during transition. If set to 0, it will use the general setting.",'striking_admin'),
						"id" => "_3d_cubeDistance",
						"min" => "0",
						"max" => "50",
						"step" => "5",
						"unit" => 'seconds',
						"default" => "0",
						"type" => "range"
					),
				),
			)
		);
	}
}
