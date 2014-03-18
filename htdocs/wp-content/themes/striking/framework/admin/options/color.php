<?php
class Theme_Options_Page_Color extends Theme_Options_Page_With_Tabs {
	public $slug = 'color';

	function __construct(){
		$this->name = sprintf(__('%s Color Settings','theme_admin'),THEME_NAME);
		parent::__construct();
	}
	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("General Setting",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Boxed layout Background Color",'theme_admin'),
						"desc" => "",
						"id" => "box_bg",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Header Background Color",'theme_admin'),
						"desc" => "",
						"id" => "header_bg",
						"default" => "#fefefe",
						"type" => "color"
					),
					array(
						"name" => __("Feature Header Background Color",'theme_admin'),
						"desc" => "",
						"id" => "feature_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Page Background Color",'theme_admin'),
						"desc" => "",
						"id" => "page_bg",
						"default" => "#fefefe",
						"type" => "color"
					),
					array(
						"name" => __("Footer Background Color",'theme_admin'),
						"desc" => "",
						"id" => "footer_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Sub Footer Background Color",'theme_admin'),
						"desc" => "",
						"id" => "sub_footer_bg",
						"default" => "",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'header',
				"name" => __("Header Setting",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Logo Text Color",'theme_admin'),
						"desc" => "",
						"id" => "site_name",
						"default" => "#444444",
						"type" => "color"
					),
					array(
						"name" => __("Logo Description Text Color",'theme_admin'),
						"desc" => "",
						"id" => "site_description",
						"default" => "#444444",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Menu Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_top",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Menu Background Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_top_background",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Menu Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_top_active",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Menu Hover Background Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_top_active_background",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Current Menu Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_top_current",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Top Level Current Menu Background Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_top_current_background",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Menu Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_sub",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Menu Background Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_sub_background",
						"default" => "#f5f5f5",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Menu Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_sub_active",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Menu Hover Background Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_sub_hover_background",
						"default" => "#dddddd",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Current Menu Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_sub_current",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Sub Level Current Menu Hover Background Color",'theme_admin'),
						"desc" => "",
						"id" => "menu_sub_current_background",
						"default" => "",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'feature',
				"name" => __("Feature Header Setting",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Feature Header Title Color",'theme_admin'),
						"desc" => "",
						"id" => "feature_header",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Feature Header Custom Text Color",'theme_admin'),
						"desc" => "",
						"id" => "feature_introduce",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Nivo Slider Loading Background Color",'theme_admin'),
						"desc" => "",
						"id" => "nivo_loading_bg",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Nivo Slider Caption Text Color",'theme_admin'),
						"desc" => "",
						"id" => "nivo_caption_text",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Nivo Slider Caption Background Color",'theme_admin'),
						"desc" => "",
						"id" => "nivo_caption_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Loading Background Color",'theme_admin'),
						"desc" => "",
						"id" => "anything_loading_bg",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Caption Background Color",'theme_admin'),
						"desc" => "",
						"id" => "anything_caption_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Caption Text Color",'theme_admin'),
						"desc" => "",
						"id" => "anything_caption",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Caption Header Text Color",'theme_admin'),
						"desc" => "",
						"id" => "anything_caption_header",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Anything Slider Background Color",'theme_admin'),
						"desc" => "",
						"id" => "anything_bg",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Caption Background Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_caption_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Caption Text Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_caption",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Detail Background Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_detail_bg",
						"default" => "#000000",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Detail Header Text Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_detail_header",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Slider Detail Text Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_detail",
						"default" => "#ffffff",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'page',
				"name" => __("Page Setting",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Page Text Color",'theme_admin'),
						"desc" => "",
						"id" => "page",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Page Header Color",'theme_admin'),
						"desc" => "",
						"id" => "page_header",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Page H1 Color",'theme_admin'),
						"desc" => "",
						"id" => "page_h1",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H2 Color",'theme_admin'),
						"desc" => "",
						"id" => "page_h2",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H3 Color",'theme_admin'),
						"desc" => "",
						"id" => "page_h3",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H4 Color",'theme_admin'),
						"desc" => "",
						"id" => "page_h4",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H5 Color",'theme_admin'),
						"desc" => "",
						"id" => "page_h5",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page H6 Color",'theme_admin'),
						"desc" => "",
						"id" => "page_h6",
						"default" => "",
						"type" => "color"
					),
					array(
						"name" => __("Page Link Color",'theme_admin'),
						"desc" => "",
						"id" => "page_link",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Page Link Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "page_link_active",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Sidebar Widget Title",'theme_admin'),
						"desc" => "",
						"id" => "widget_title",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Sidebar Link Color",'theme_admin'),
						"desc" => "",
						"id" => "sidebar_link",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Sidebar Link Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "sidebar_link_active",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Breadcrumbs Text Color",'theme_admin'),
						"desc" => "",
						"id" => "breadcrumbs",
						"default" => "#999999",
						"type" => "color"
					),
					array(
						"name" => __("Breadcrumbs Link Color",'theme_admin'),
						"desc" => "",
						"id" => "breadcrumbs_link",
						"default" => "#999999",
						"type" => "color"
					),
					array(
						"name" => __("Breadcrumbs Link Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "breadcrumbs_active",
						"default" => "#999999",
						"type" => "color"
					),
					array(
						"name" => __("Divider Line Color",'theme_admin'),
						"desc" => "",
						"id" => "divider_line",
						"default" => "#eeeeee",
						"type" => "color"
					),
					array(
						"name" => __("Text Field Color",'theme_admin'),
						"desc" => "",
						"id" => "input_text",
						"default" => "#333333",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'blog',
				"name" => __("Blog Setting",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Blog Post Title Color",'theme_admin'),
						"desc" => "",
						"id" => "entry_title",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Post Title Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "entry_title_active",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Meta Link Color",'theme_admin'),
						"desc" => "",
						"id" => "blog_meta_link",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Blog Meta Link Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "blog_meta_link_active",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Read More Button Background Color",'theme_admin'),
						"id" => "read_more_bg",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Read More Button Text Color",'theme_admin'),
						"id" => "read_more_text",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Blog Read More Button Hover Background Color",'theme_admin'),
						"id" => "read_more_active_bg",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Blog Read More Button Hover Text Color",'theme_admin'),
						"id" => "read_more_active_text",
						"default" => "#ffffff",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'portfolio',
				"name" => __("Portfolio Setting",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Portfolio Sortable Header Background Color",'theme_admin'),
						"desc" => "",
						"id" => "portfolio_header_bg",
						"default" => "#eeeeee",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Sortable Header Text Color",'theme_admin'),
						"desc" => "",
						"id" => "portfolio_header_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Sortable Header Hover Background Color",'theme_admin'),
						"desc" => "",
						"id" => "portfolio_header_active_bg",
						"default" => "#eeeeee",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Sortable Header Hover Text Color",'theme_admin'),
						"desc" => "",
						"id" => "portfolio_header_active_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Title Text Color",'theme_admin'),
						"desc" => "",
						"id" => "portfolio_title",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Read More Button Background Color",'theme_admin'),
						"id" => "portfolio_read_more_bg",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Read More Button Text Color",'theme_admin'),
						"id" => "portfolio_read_more_text",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Read More Button Hover Background Color",'theme_admin'),
						"id" => "portfolio_read_more_active_bg",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Portfolio Read More Button Hover Text Color",'theme_admin'),
						"id" => "portfolio_read_more_active_text",
						"default" => "#ffffff",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'tabs',
				"name" => __("Tabs Setting",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Tab Title Bg Color",'theme_admin'),
						"desc" => "",
						"id" => "tab_bg",
						"default" => "#f5f5f5",
						"type" => "color"
					),
					array(
						"name" => __("Tab Title Text Color",'theme_admin'),
						"desc" => "",
						"id" => "tab_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Tab Current Bg Color",'theme_admin'),
						"desc" => "",
						"id" => "tab_current_bg",
						"default" => "#FFFFFF",
						"type" => "color"
					),
					array(
						"name" => __("Tab Current Text Color",'theme_admin'),
						"desc" => "",
						"id" => "tab_current_text",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Tab Content Bg Color",'theme_admin'),
						"desc" => "",
						"id" => "tab_content_bg",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Tab Content Text Color",'theme_admin'),
						"desc" => "",
						"id" => "tab_content_text",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("MiniTab Title Bg Color",'theme_admin'),
						"desc" => "",
						"id" => "minitab_bg",
						"default" => "#f5f5f5",
						"type" => "color"
					),
					array(
						"name" => __("MiniTab Title Text Color",'theme_admin'),
						"desc" => "",
						"id" => "minitab_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("MiniTab Current Bg Color",'theme_admin'),
						"desc" => "",
						"id" => "minitab_current_bg",
						"default" => "#FFFFFF",
						"type" => "color"
					),
					array(
						"name" => __("MiniTab Current Text Color",'theme_admin'),
						"desc" => "",
						"id" => "minitab_current_text",
						"default" => "#333333",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Title Bg Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_bg",
						"default" => "#f5f5f5",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Title Text Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_text",
						"default" => "#666666",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Current Bg Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_current_bg",
						"default" => "#FFFFFF",
						"type" => "color"
					),
					array(
						"name" => __("Accordion Current Text Color",'theme_admin'),
						"desc" => "",
						"id" => "accordion_current_text",
						"default" => "#333333",
						"type" => "color"
					),
				),
			),
			array(
				"slug" => 'footer',
				"name" => __("Footer Setting",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Footer Text Color",'theme_admin'),
						"desc" => "",
						"id" => "footer_text",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Widget Title Color",'theme_admin'),
						"desc" => "",
						"id" => "footer_title",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Link Color",'theme_admin'),
						"desc" => "",
						"id" => "footer_link",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Link Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "footer_link_active",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Copyright Text Color",'theme_admin'),
						"desc" => "",
						"id" => "copyright",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Menu Text Color",'theme_admin'),
						"desc" => "",
						"id" => "footer_menu",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Menu Hover Color",'theme_admin'),
						"desc" => "",
						"id" => "footer_menu_active",
						"default" => "#ffffff",
						"type" => "color"
					),
					array(
						"name" => __("Footer Text Field Color",'theme_admin'),
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
