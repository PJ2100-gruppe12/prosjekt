<?php
class Theme_Options_Page_Portfolio extends Theme_Options_Page_With_Tabs {
	public $slug = 'portfolio';

	function __construct(){
		$this->name = sprintf(__('%s Portfolio Settings','theme_admin'),THEME_NAME);
		parent::__construct();
	}
	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("Portfolio General",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Breadcrumbs Parent Page",'theme_admin'),
						"desc" => __("If set will enable portfolio item breadcrumbs. The page you choose here will be the parent page of portfolio items on the breadcrumbs. This will override the global configuration.",'theme_admin'),
						"id" => "breadcrumbs_page",
						"page" => 0,
						"default" => 0,
						"chosen" => "true",
						"prompt" => __("None",'theme_admin'),
						"type" => "select",
					),
					array(
						"name" => __("Display Title",'theme_admin'),
						"desc" => "",
						"id" => "display_title",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Display Description",'theme_admin'),
						"desc" => "",
						"id" => "display_excerpt",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Display Read More",'theme_admin'),
						"desc" => "",
						"id" => "display_more_button",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Show Text",'theme_admin'),
						"desc" => "",
						"id" => "show_text",
						"size" => 30,
						"default" => __('Show:','theme_front'),
						"type" => "text"
					),
					array(
						"name" => __("Effect",'theme_admin'),
						"desc" => "Effect when hover feature image.",
						"id" => "effect",
						"default" => 'icon',
						"options" => array(
							"icon" => __("Icon",'theme_admin'),
							"grayscale" => __("Grayscale",'theme_admin'),
							"none" => __("None",'theme_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"slug" => 'more',
				"name" => __("Read More",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Read More Text",'theme_admin'),
						"desc" => "",
						"size" => 30,
						"id" => "more_button_text",
						"default" => 'Read More »',
						"type" => "text",
					),
					array(
						"name" => __("Display Read More as button",'theme_admin'),
						"desc" => "",
						"id" => "read_more_button",
						"default" => false,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => 'url',
				"name" => __("Portfolio Rewrite URL",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Permalink Slug",'theme_admin'),
						"desc" => "Permalink Slug is used for build URLs of portfolio. If this value is empty, it will use 'portfolio' for build URL.",
						"size" => 30,
						"id" => "permalink_slug",
						"default" => '',
						"process" => '_option_permalink_slug_process',
						"type" => "text",
					),
				),
			),
			array(
				"slug" => 'thumbnail_height',
				"name" => __("Height of Thumbnail",'theme_admin'),
				"options" => array(
					array(
						"name" => __("One Column",'theme_admin'),
						"desc" => sprintf(__("%s in width",'theme_admin'),'600px'),
						"id" => "1_column_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "350",
						"type" => "range"
					),
					array(
						"name" => __("Two Columns",'theme_admin'),
						"desc" => sprintf(__("%s in width",'theme_admin'),'450px'),
						"id" => "2_columns_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "250",
						"type" => "range"
					),
					array(
						"name" => __("Three Columns",'theme_admin'),
						"desc" => sprintf(__("%s in width",'theme_admin'),'292px'),
						"id" => "3_columns_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "180",
						"type" => "range"
					),
					array(
						"name" => __("Four Columns",'theme_admin'),
						"desc" => sprintf(__("%s in width",'theme_admin'),'217px'),
						"id" => "4_columns_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "150",
						"type" => "range"
					),
					array(
						"name" => __("Five Columns",'theme_admin'),
						"desc" => sprintf(__("%s in width",'theme_admin'),'172px'),
						"id" => "5_columns_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "120",
						"type" => "range"
					),
					array(
						"name" => __("Sive Columns",'theme_admin'),
						"desc" => sprintf(__("%s in width",'theme_admin'),'140px'),
						"id" => "6_columns_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "90",
						"type" => "range"
					),
					array(
						"name" => __("Seven Columns",'theme_admin'),
						"desc" => sprintf(__("%s in width",'theme_admin'),'120px'),
						"id" => "7_columns_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "80",
						"type" => "range"
					),
					array(
						"name" => __("Eight Columns",'theme_admin'),
						"desc" => sprintf(__("%s in width",'theme_admin'),'99px'),
						"id" => "8_columns_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "66",
						"type" => "range"
					),
				),
			),
			array(
				"slug" => 'lightbox_dimension',
				"name" => __("Lightbox Dimension",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Video Type Width",'theme_admin'),
						"desc" => "",
						"id" => "video_width",
						"default" => "640",
						"min" => 0,
						"max" => 960,
						"step" => "1",
						"units" => array('px','%'),
						'default_unit' => 'px',
						"type" => "measurement",
					),
					array(
						"name" => __("Video Type Height",'theme_admin'),
						"desc" => "",
						"id" => "video_height",
						"default" => "390",
						"min" => 0,
						"max" => 960,
						"step" => "1",
						"units" => array('px','%'),
						'default_unit' => 'px',
						"type" => "measurement",
					),
					array(
						"name" => __("Lightbox Type Width",'theme_admin'),
						"desc" => "",
						"id" => "lightbox_width",
						"default" => "640",
						"min" => 0,
						"max" => 960,
						"step" => "1",
						"units" => array('px','%'),
						'default_unit' => 'px',
						"type" => "measurement",
					),
					array(
						"name" => __("Lightbox Type Height",'theme_admin'),
						"desc" => "",
						"id" => "lightbox_height",
						"default" => "390",
						"min" => 0,
						"max" => 960,
						"step" => "1",
						"units" => array('px','%'),
						'default_unit' => 'px',
						"type" => "measurement",
					),
				),
			),
			array(
				"slug"=>'feature',
				"name" => __("Featured Image",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Featured Image",'theme_admin'),
						"desc" => __("If this option is on, Featured Image will appear in Portfolio Item page.",'theme_admin'),
						"id" => "featured_image",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Featured Image for Lightbox",'theme_admin'),
						"desc" => __("If this option is on, the full image will open in the lightbox when click on Featured Image of Portfolio Item page.",'theme_admin'),
						"id" => "featured_image_lightbox",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Featured Image gallery for Lightbox",'theme_admin'),
						"desc" => __("If this option is on, the images that attached to the post will open in the lightbox when click on Featured Image of Portfolio Single Post page.",'theme_admin'),
						"id" => "featured_image_lightbox_gallery",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Featured Image Effect",'theme_admin'),
						"desc" => "Effect when hover feature image of Blog Single post page.",
						"id" => "sinle_effect",
						"default" => 'none',
						"options" => array(
							"icon" => __("Icon",'theme_admin'),
							"grayscale" => __("Grayscale",'theme_admin'),
							"none" => __("None",'theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Adaptive Height",'theme_admin'),
						"desc" => __("If this option is on, the height of the featured image depand on the scale of the image.",'theme_admin'),
						"id" => "adaptive_height",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Fixed Height",'theme_admin'),
						"desc" => __("If the option above is off, it will take effect.",'theme_admin'),
						"id" => "fixed_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "250",
						"type" => "range"
					),
				),
			),
			array(
				"slug" => "single",
				"name" => __("Single Portfolio Item",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Layout",'theme_admin'),
						"desc" => "",
						"id" => "layout",
						"default" => 'right',
						"options" => array(
							"full" => __('Full Width','theme_admin'),
							"right" => __('Right Sidebar','theme_admin'),
							"left" => __('Left Sidebar','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Previous & Next Navigation",'theme_admin'),
						"desc" => "",
						"id" => "single_navigation",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Previous & Next Navigation Order",'theme_admin'),
						"desc" => "",
						"id" => "single_navigation_order",
						"default" => 'post_data',
						"options" => array(
							"post_data" => __('Post Data','theme_admin'),
							"menu_order" => __('Menu Order','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __(" Previous & Next Navigation for Category",'theme_admin'),
						"desc" => "If this option is on, the Previous & Next Navigation will only show the portfolio items with the same Category",
						"id" => "single_navigation_category",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Document Type Navigation",'theme_admin'),
						"desc" => "If this option is on, the Previous & Next Navigation will only apply to Document type of Portfolio",
						"id" => "single_doc_navigation",
						"default" => true,
						"type" => "toggle"
					),
					
					array(
						"name" => __("Enable Comment",'theme_admin'),
						"desc" => "",
						"id" => "enable_comment",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("About Author Box",'theme_admin'),
						"desc" => "",
						"id" => "author",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Related & Recent Module",'theme_admin'),
						"desc" => "",
						"id" => "related_recent",
						"default" => false,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => 'thumbnail',
				"name" => __("Featured Image Thumbnail for Widget",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Display default thumbnail image",'theme_admin'),
						"desc" => __("If this option is on, it will display default thumbnail image when there is no feature image.",'theme_admin'),
						"id" => "display_default_thumbnail",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Custom default thumbnail image",'theme_admin'),
						"id" => "default_thumbnail_custom",
						"default" => "",
						"type" => "upload"
					),
				),
			),
		);
		return $options;
	}

	function _option_permalink_slug_process($option,$value) {
		if(theme_get_option('portfolio','permalink_slug') != $value){
			$this->_ajax_flush_rewrite_rules();
		}
		
		return $value;
	}

	function _ajax_flush_rewrite_rules(){
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {
	var data = {
		action: 'theme-flush-rewrite-rules'
	};
	jQuery.post(ajaxurl, data, function(response) {
		
	});
});
</script>
<?php
	}
}
