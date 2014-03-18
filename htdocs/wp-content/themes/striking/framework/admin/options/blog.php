<?php
class Theme_Options_Page_Blog extends Theme_Options_Page_With_Tabs {
	public $slug = 'blog';

	function __construct(){
		$this->name = sprintf(__('%s Blog Settings','theme_admin'),THEME_NAME);
		parent::__construct();
	}
	
	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("Blog General",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Blog Page",'theme_admin'),
						"desc" => __("The page you choose here will display the blog",'theme_admin'),
						"id" => "blog_page",
						"page" => 0,
						"chosen" => true,
						"default" => '',
						"prompt" => __("None",'theme_admin'),
						"type" => "select",
						"process" => "_option_blog_page_process"
					),
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
						"name" => __("Column Layout",'theme_admin'),
						"id" => "columns",
						"default" => '1',
						"options" => array(
							"1" => sprintf(__("%d Column",'theme_admin'),1),
							"2" => sprintf(__("%d Columns",'theme_admin'),2),
							"3" => sprintf(__("%d Columns",'theme_admin'),3),
							"4" => sprintf(__("%d Columns",'theme_admin'),4),
							"5" => sprintf(__("%d Columns",'theme_admin'),5),
							"6" => sprintf(__("%d Columns",'theme_admin'),6),
						),
						"type" => "select",
					),
					array(
						"name" => __("Box Frame Layout",'theme_admin'),
						"id" => "frame",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Featured Image",'theme_admin'),
						"desc" => __("If this option is on, Featured Image will appear in Blog Archives page.",'theme_admin'),
						"id" => "index_featured_image",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Featured Image Type",'theme_admin'),
						"desc" => "",
						"id" => "featured_image_type",
						"default" => 'full',
						"options" => array(
							"full" => __('Full Width','theme_admin'),
							"left" => __('Left Float','theme_admin'),
							"right" => __('Right Float','theme_admin'),
							"below" => __('Below Title','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Featured Image for Lightbox",'theme_admin'),
						"desc" => __("If this option is on, the full image will open in the lightbox when click on Featured Image.",'theme_admin'),
						"id" => "index_featured_image_lightbox",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Display Full Blog Posts",'theme_admin'),
						"desc" => __("This option determinate whether to display full blog posts in index page.",'theme_admin'),
						"id" => "display_full",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable shortcode for the excerpt",'theme_admin'),
						"desc" => __("If this option is on, it will enable shortcode support for the excerpt.",'theme_admin'),
						"id" => "excerpt_shortcode",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Exclude Categories for blog page",'theme_admin'),
						"desc" => __("The blog Page usually displays all Categorys, since sometimes you want to exclude some of these categories. You can exclude multiple categories here:",'theme_admin'),
						"id" => "exclude_categorys_for_blog_page",
						"default" => array(),
						"target" => "cat",
						"chosen" => "true",
						"prompt" => __("Choose category..",'theme_admin'),
						"type" => "multiselect"
					),
					array(
						"name" => __("Exclude Categories for whole site",'theme_admin'),
						"desc" => __("The posts with the categories you selected here will not show on the any archive pages and any posts widget.",'theme_admin'),
						"id" => "exclude_categorys",
						"default" => array(),
						"target" => "cat",
						"chosen" => "true",
						"prompt" => __("Choose category..",'theme_admin'),
						"type" => "multiselect"
					),
					array(
						"name" => __("Gap Between Posts",'theme_admin'),
						"desc" => "",
						"id" => "posts_gap",
						"min" => "0",
						"max" => "200",
						"step" => "1",
						"unit" => 'px',
						"default" => "80",
						"type" => "range"
					),
					array(
						"name" => __("Featured Image Effect",'theme_admin'),
						"desc" => "Effect when hover feature image of blog archives page.",
						"id" => "effect",
						"default" => 'icon',
						"options" => array(
							"icon" => __("Icon",'theme_admin'),
							"grayscale" => __("Grayscale",'theme_admin'),
							"none" => __("None",'theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Author link to website",'theme_admin'),
						"desc" => __("If this option is on, the author name text will link to Website field which is set in the user's profile, or it will link to the author's posts page.",'theme_admin'),
						"id" => "author_link_to_website",
						"default" => true,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => 'search',
				"name" => __("Search Result Page",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Layout",'theme_admin'),
						"desc" => "",
						"id" => "search_layout",
						"default" => 'right',
						"options" => array(
							"default" => __('Default','theme_admin'),
							"full" => __('Full Width','theme_admin'),
							"right" => __('Right Sidebar','theme_admin'),
							"left" => __('Left Sidebar','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Display Full Blog Posts",'theme_admin'),
						"desc" => __("This option determinate whether to display full blog posts in search result page.",'theme_admin'),
						"id" => "search_display_full",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Nothing Found Text",'theme_admin'),
						"desc" => 'eg: <code>Nothing found matching the searchcriteria.</code>. ',
						"id" => "search_nothing_found",
						"default" => '',
						'rows' => '2',
						"type" => "textarea"
					),
				),
			),
			array(
				"slug" => 'single',
				"name" => __("Single Blog",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Layout",'theme_admin'),
						"desc" => "",
						"id" => "single_layout",
						"default" => 'right',
						"options" => array(
							"full" => __('Full Width','theme_admin'),
							"right" => __('Right Sidebar','theme_admin'),
							"left" => __('Left Sidebar','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Featured Image",'theme_admin'),
						"desc" => __("If this option is on, Featured Image will appear in Single Blog page.",'theme_admin'),
						"id" => "featured_image",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Featured Image Type",'theme_admin'),
						"desc" => "",
						"id" => "single_featured_image_type",
						"default" => 'full',
						"options" => array(
							"full" => __('Full Width','theme_admin'),
							"left" => __('Left Float','theme_admin'),
							"right" => __('Right Float','theme_admin'),
							"below" => __('Below Title','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Featured Image for Lightbox",'theme_admin'),
						"desc" => __("If this option is on, the full image will open in the lightbox when click on Featured Image of Blog Single Post page.",'theme_admin'),
						"id" => "featured_image_lightbox",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Featured Image gallery for Lightbox",'theme_admin'),
						"desc" => __("If this option is on, the images that attached to the post will open in the lightbox when click on Featured Image of Blog Single post page.",'theme_admin'),
						"id" => "featured_image_lightbox_gallery",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Featured Image Effect",'theme_admin'),
						"desc" => "Effect when hover feature image of Blog Single post page.",
						"id" => "single_effect",
						"default" => 'none',
						"options" => array(
							"icon" => __("Icon",'theme_admin'),
							"grayscale" => __("Grayscale",'theme_admin'),
							"none" => __("None",'theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Show in Header Area",'theme_admin'),
						"desc" => __("Turned on the Blogtitle and meta info will show in header text area. Turned off the Blogtitle and meta info will be shown in the page itself.",'theme_admin'),
						"id" => "show_in_header",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("About Author Box",'theme_admin'),
						"desc" => "",
						"id" => "author",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Related & Popular Post Module",'theme_admin'),
						"desc" => "",
						"id" => "related_popular",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Related Post Base on",'theme_admin'),
						"desc" => "",
						"id" => "related_base_on",
						"default" => 'tags',
						"options" => array(
							'categories'=>__('Same Categories','theme_admin'),
							'tags'=>__('Same Tags','theme_admin'),
						),
						"type" => "select"
					),
					array(
						"name" => __("Previous & Next Navigation",'theme_admin'),
						"desc" => "",
						"id" => "entry_navigation",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __(" Previous & Next Navigation for Category",'theme_admin'),
						"desc" => "If this option is on, the Previous & Next Navigation will only show the portfolio items with the same Category",
						"id" => "single_navigation_category",
						"default" => false,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => 'meta',
				"name" => __("Meta informations",'theme_admin'),
				"options" => array(
					array(
						"name" => __("For Blog list",'theme_admin'),
						"desc" => "",
						"id" => "meta_items",
						"default" => array('category','date','comment'),
						"options" => array(
							'category'=>__('Category','theme_admin'),
							'tags'=>__('Tags','theme_admin'),
							'author'=>__('Author','theme_admin'),
							'date'=>__('Date','theme_admin'),
							'comment'=>__('Comment','theme_admin'),
						),
						'enable_text' => __('Enabled','theme_admin'),
						'disable_text' => __('Disabled','theme_admin'),
						"type" => "ddmultiselect"
					),
					array(
						"name" => __("For Header Area of Single Post Page",'theme_admin'),
						"desc" => "",
						"id" => "single_meta_items",
						"default" => array('date','category','comment'),
						"options" => array(
							'category'=>__('Category','theme_admin'),
							'tags'=>__('Tags','theme_admin'),
							'author'=>__('Author','theme_admin'),
							'date'=>__('Date','theme_admin'),
							'comment'=>__('Comment','theme_admin'),
						),
						'enable_text' => __('Enabled','theme_admin'),
						'disable_text' => __('Disabled','theme_admin'),
						"type" => "ddmultiselect"
					),
				),
			),
			array(
				"slug" => 'more',
				"name" => __("Read More",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Display Read More",'theme_admin'),
						"desc" => "",
						"id" => "read_more",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Display Read More as button",'theme_admin'),
						"desc" => "",
						"id" => "read_more_button",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Read More Text",'theme_admin'),
						"id" => "read_more_text",
						"default" => __("Read more &raquo;",'theme_front'),
						"type" => "text",
					),
				),
			),
			array(
				"slug" => 'full_featured_image',
				"name" => __("Full Width Featured Image",'theme_admin'),
				"options" => array(
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
					array(
						"name" => __("Single Post page Fixed Height",'theme_admin'),
						"desc" => __("If the option above is off, it will take effect. If set to 0, it will use the setting above.",'theme_admin'),
						"id" => "single_fixed_height",
						"min" => "0",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "0",
						"type" => "range"
					),
				),
			),
			array(
				"slug" => 'left_featured_image',
				"name" => __("Left Float Featured Image",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Width",'theme_admin'),
						"id" => "left_width",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "200",
						"type" => "range"
					),
					array(
						"name" => __("Height",'theme_admin'),
						"id" => "left_height",
						"min" => "1",
						"max" => "600",
						"step" => "1",
						"unit" => 'px',
						"default" => "200",
						"type" => "range"
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

	function _option_blog_page_process($option,$value) {
		if(!empty($value)){
			//update_option( 'page_for_posts', $value );
		}
		return $value;
	}
}
