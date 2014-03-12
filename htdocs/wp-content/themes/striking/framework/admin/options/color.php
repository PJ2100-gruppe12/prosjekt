<?php
class Theme_Options_Page_Color extends Theme_Options_Page_With_Tabs {
	public $slug = 'color';

	function __construct(){
		$this->name = sprintf(__('%s Color Settings','striking_admin'),THEME_NAME);
		parent::__construct();
	}
	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("General Setting",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Boxed layout Background Color",'striking_admin'),
						"desc" => "",
						"id" => "box_bg",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Header Background Color",'striking_admin'),
						"desc" => "",
						"id" => "header_bg",
						"default" => "#fefefe",
						"type" => "color"
					),
					array(
						"name" => __("Feature Header Background Color",'striking_admin'),
						"desc" => "",
						"id" => "feature_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Page Background Color",'striking_admin'),
						"desc" => "",
						"id" => "page_bg",
						"default" => "#fefefe",
						"type" => "color"
					),
					array(
						"name" => __("Footer Background Color",'striking_admin'),
						"desc" => "",
						"id" => "footer_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Sub Footer Background Color",'striking_admin'),
						"desc" => "",
						"id" => "sub_footer_bg",
						"default" => "",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'header',
				"name" => __("Header Setting",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Logo Text Color",'striking_admin'),
						"desc" => "",
						"id" => "site_name",
						"default" => "#444444",
						"type" => "color"
					),
					array(
						"name" => __("Logo Description Text Color",'striking_admin'),
						"desc" => "",
						"id" => "site_description",
						"default" => "#444444",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Menu Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_top",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Menu Background Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_top_background",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Menu Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_top_active",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Menu Hover Background Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_top_active_background",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Current Menu Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_top_current",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Current Menu Background Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_top_current_background",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Menu Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_sub",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Menu Background Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_sub_background",
						"default" => "#f5f5f5",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Menu Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_sub_active",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Menu Hover Background Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_sub_hover_background",
						"default" => "#dddddd",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Current Menu Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_sub_current",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Current Menu Hover Background Color",'striking_admin'),
						"desc" => "",
						"id" => "menu_sub_current_background",
						"default" => "",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'feature',
				"name" => __("Feature Header Setting",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Feature Header Title Color",'striking_admin'),
						"desc" => "",
						"id" => "feature_header",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Feature Header Custom Text Color",'striking_admin'),
						"desc" => "",
						"id" => "feature_introduce",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Nivo Slider Loading Background Color",'striking_admin'),
						"desc" => "",
						"id" => "nivo_loading_bg",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Nivo Slider Caption Text Color",'striking_admin'),
						"desc" => "",
						"id" => "nivo_caption_text",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Nivo Slider Caption Background Color",'striking_admin'),
						"desc" => "",
						"id" => "nivo_caption_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Loading Background Color",'striking_admin'),
						"desc" => "",
						"id" => "anything_loading_bg",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Caption Background Color",'striking_admin'),
						"desc" => "",
						"id" => "anything_caption_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Caption Text Color",'striking_admin'),
						"desc" => "",
						"id" => "anything_caption",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Caption Header Text Color",'striking_admin'),
						"desc" => "",
						"id" => "anything_caption_header",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Background Color",'striking_admin'),
						"desc" => "",
						"id" => "anything_bg",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Caption Background Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_caption_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Caption Text Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_caption",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Detail Background Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_detail_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Detail Header Text Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_detail_header",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Detail Text Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_detail",
						"default" => "#ffffff",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'page',
				"name" => __("Page Setting",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Page Text Color",'striking_admin'),
						"desc" => "",
						"id" => "page",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Page Header Color",'striking_admin'),
						"desc" => "",
						"id" => "page_header",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Page H1 Color",'striking_admin'),
						"desc" => "",
						"id" => "page_h1",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H2 Color",'striking_admin'),
						"desc" => "",
						"id" => "page_h2",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H3 Color",'striking_admin'),
						"desc" => "",
						"id" => "page_h3",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H4 Color",'striking_admin'),
						"desc" => "",
						"id" => "page_h4",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H5 Color",'striking_admin'),
						"desc" => "",
						"id" => "page_h5",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H6 Color",'striking_admin'),
						"desc" => "",
						"id" => "page_h6",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page Link Color",'striking_admin'),
						"desc" => "",
						"id" => "page_link",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Page Link Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "page_link_active",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Sidebar Widget Title",'striking_admin'),
						"desc" => "",
						"id" => "widget_title",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Sidebar Link Color",'striking_admin'),
						"desc" => "",
						"id" => "sidebar_link",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Sidebar Link Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "sidebar_link_active",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Breadcrumbs Text Color",'striking_admin'),
						"desc" => "",
						"id" => "breadcrumbs",
						"default" => "#999999",
						"type" => "color"
					),
					array(
						"name" => __("Breadcrumbs Link Color",'striking_admin'),
						"desc" => "",
						"id" => "breadcrumbs_link",
						"default" => "#999999",
						"type" => "color"
					),
					array(
						"name" => __("Breadcrumbs Link Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "breadcrumbs_active",
						"default" => "#999999",
						"type" => "color"
					),
					array(
						"name" => __("Divider Line Color",'striking_admin'),
						"desc" => "",
						"id" => "divider_line",
						"default" => "#eeeeee",
						"type" => "color"
					),
					array(
						"name" => __("Text Field Color",'striking_admin'),
						"desc" => "",
						"id" => "input_text",
						"default" => "#333333",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'blog',
				"name" => __("Blog Setting",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Blog Post Title Color",'striking_admin'),
						"desc" => "",
						"id" => "entry_title",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Post Title Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "entry_title_active",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Meta Link Color",'striking_admin'),
						"desc" => "",
						"id" => "blog_meta_link",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Blog Meta Link Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "blog_meta_link_active",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Read More Button Background Color",'striking_admin'),
						"id" => "read_more_bg",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Read More Button Text Color",'striking_admin'),
						"id" => "read_more_text",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Blog Read More Button Hover Background Color",'striking_admin'),
						"id" => "read_more_active_bg",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Read More Button Hover Text Color",'striking_admin'),
						"id" => "read_more_active_text",
						"default" => "#ffffff",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'portfolio',
				"name" => __("Portfolio Setting",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Portfolio Sortable Header Background Color",'striking_admin'),
						"desc" => "",
						"id" => "portfolio_header_bg",
						"default" => "#eeeeee",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Sortable Header Text Color",'striking_admin'),
						"desc" => "",
						"id" => "portfolio_header_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Sortable Header Hover Background Color",'striking_admin'),
						"desc" => "",
						"id" => "portfolio_header_active_bg",
						"default" => "#eeeeee",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Sortable Header Hover Text Color",'striking_admin'),
						"desc" => "",
						"id" => "portfolio_header_active_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Title Text Color",'striking_admin'),
						"desc" => "",
						"id" => "portfolio_title",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Read More Button Background Color",'striking_admin'),
						"id" => "portfolio_read_more_bg",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Read More Button Text Color",'striking_admin'),
						"id" => "portfolio_read_more_text",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Read More Button Hover Background Color",'striking_admin'),
						"id" => "portfolio_read_more_active_bg",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Read More Button Hover Text Color",'striking_admin'),
						"id" => "portfolio_read_more_active_text",
						"default" => "#ffffff",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'tabs',
				"name" => __("Tabs Setting",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Tab Title Bg Color",'striking_admin'),
						"desc" => "",
						"id" => "tab_bg",
						"default" => "#f5f5f5",
						"type" => "color"
					),
					array(
						"name" => __("Tab Title Text Color",'striking_admin'),
						"desc" => "",
						"id" => "tab_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Tab Current Bg Color",'striking_admin'),
						"desc" => "",
						"id" => "tab_current_bg",
						"default" => "#FFFFFF",
						"type" => "color"
					),
					array(
						"name" => __("Tab Current Text Color",'striking_admin'),
						"desc" => "",
						"id" => "tab_current_text",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Tab Content Bg Color",'striking_admin'),
						"desc" => "",
						"id" => "tab_content_bg",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Tab Content Text Color",'striking_admin'),
						"desc" => "",
						"id" => "tab_content_text",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("MiniTab Title Bg Color",'striking_admin'),
						"desc" => "",
						"id" => "minitab_bg",
						"default" => "#f5f5f5",
						"type" => "color"
					),
					array(
						"name" => __("MiniTab Title Text Color",'striking_admin'),
						"desc" => "",
						"id" => "minitab_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("MiniTab Current Bg Color",'striking_admin'),
						"desc" => "",
						"id" => "minitab_current_bg",
						"default" => "#FFFFFF",
						"type" => "color"
					),
					array(
						"name" => __("MiniTab Current Text Color",'striking_admin'),
						"desc" => "",
						"id" => "minitab_current_text",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Title Bg Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_bg",
						"default" => "#f5f5f5",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Title Text Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Current Bg Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_current_bg",
						"default" => "#FFFFFF",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Current Text Color",'striking_admin'),
						"desc" => "",
						"id" => "accordion_current_text",
						"default" => "#333333",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'footer',
				"name" => __("Footer Setting",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Footer Text Color",'striking_admin'),
						"desc" => "",
						"id" => "footer_text",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Widget Title Color",'striking_admin'),
						"desc" => "",
						"id" => "footer_title",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Link Color",'striking_admin'),
						"desc" => "",
						"id" => "footer_link",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Link Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "footer_link_active",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Copyright Text Color",'striking_admin'),
						"desc" => "",
						"id" => "copyright",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Menu Text Color",'striking_admin'),
						"desc" => "",
						"id" => "footer_menu",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Menu Hover Color",'striking_admin'),
						"desc" => "",
						"id" => "footer_menu_active",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Text Field Color",'striking_admin'),
						"desc" => "",
						"id" => "footer_text_field_color",
						"default" => "#ffffff",
						"type" => "color"
					),
				),
			),
		);
		return $options;
	}
}
