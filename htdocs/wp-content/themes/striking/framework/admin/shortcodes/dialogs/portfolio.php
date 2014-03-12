<?php
return array(
	"title" => __("Portfolio", "striking_admin"),
	"shortcode" => 'portfolio',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Column",'striking_admin'),
			"id" => "column",
			"default" => '4',
			"options" => array(
				"1" => sprintf(__("%d Column",'striking_admin'),1),
				"2" => sprintf(__("%d Columns",'striking_admin'),2),
				"3" => sprintf(__("%d Columns",'striking_admin'),3),
				"4" => sprintf(__("%d Columns",'striking_admin'),4),
				"5" => sprintf(__("%d Columns",'striking_admin'),5),
				"6" => sprintf(__("%d Columns",'striking_admin'),6),
				"7" => sprintf(__("%d Columns",'striking_admin'),7),
				"8" => sprintf(__("%d Columns",'striking_admin'),8),
			),
			"type" => "select",
		),
		array (
			"name" => __("Height (optional)",'striking_admin'),
			"desc" => __("The height of thumbnail image.",'striking_admin'),
			"id" => "height",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"unit" => 'px',
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Layout",'striking_admin'),
			"id" => "layout",
			"default" => 'full',
			"options" => array(
				"full" => __("Full Width",'striking_admin'),
				"sidebar" => __("With Sidebar",'striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("No Paging",'striking_admin'),
			"id" => "nopaging",
			"desc" => __("If the option is on, it will disable pagination, displaying all posts",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Max",'striking_admin'),
			"desc" => __("Number of item to show per page",'striking_admin'),
			"id" => "max",
			"default" => '-1',
			"min" => -1,
			"max" => 50,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Sortable",'striking_admin'),
			"id" => "sortable",
			"desc" => __("If the option is on, it will disable pagination, displaying all posts by category with sortable.",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Sortable All",'striking_admin'),
			"id" => "sortable_all",
			"desc" => __("If the option is on, it will show all tab on sortable portfolio list.",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Sortable Show Text",'striking_admin'),
			"id" => "sortable_showText",
			"default" => theme_get_option('portfolio','show_text'),
			"type" => "text",
		),
		array(
			"name" => __("Ajax",'striking_admin'),
			"id" => "ajax",
			"desc" => __("If the option is on, it will add ajax support for page navigation. ",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Category (optional)",'striking_admin'),
			"id" => "cat",
			"default" => array(),
			"chosen" => true,
			"target" => 'portfolio_category',
			"prompt" => __("Select Categories..",'striking_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Current Tab (optional)",'striking_admin'),
			"desc" => __("If only work with Sortable type.",'striking_admin'),
			"id" => "current",
			"default" => array(),
			"chosen" => true,
			"target" => 'portfolio_category',
			"prompt" => __("Select Categories..",'striking_admin'),
			"type" => "select",
		),
		array(
			"name" => __("Ids (optional)",'striking_admin'),
			"desc" => __("The specific portfolios you want to display",'striking_admin'),
			"id" => "ids",
			"default" => array(),
			"chosen" => true,
			"target" => 'portfolio',
			"prompt" => __("Select Porfolios..",'striking_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Display Title",'striking_admin'),
			"id" => "title",
			"desc" => __("If the option is on, it will display title of portfolio.",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Title Linkable",'striking_admin'),
			"id" => "titleLinkable",
			"desc" => __("If the option is on, the title of portfolio will link to portfolio single page.",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Display Description",'striking_admin'),
			"id" => "desc",
			"desc" => __("If the option is on, it will display description of portfolio.",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Length of Description",'striking_admin'),
			"desc" => __("It will not work with advance description.",'striking_admin'),
			"id" => "desc_length",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Advance Description",'striking_admin'),
			"id" => "advanceDesc",
			"desc" => __("If the option is on, it will add shortcode support for description.",'striking_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Display More Button",'striking_admin'),
			"id" => "more",
			"desc" => __("If the option is on, it will display more button.",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("More Button Text",'striking_admin'),
			"id" => "moreText",
			"default" => theme_get_option('portfolio','more_button_text'),
			"type" => "text",
		),
		array(
			"name" => __("Group",'striking_admin'),
			"id" => "group",
			"desc" => __("If the option is on, the lightbox will display left and right arrow.",'striking_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Lightbox Title Type",'striking_admin'),
			"id" => "lightboxTitle",
			"default" => 'portfolio',
			"options" => array(
				"portfolio" => __("Portfolio Title",'striking_admin'),
				"image" => __("Image Title",'striking_admin'),
				"imagecaption" => __("Image Caption",'striking_admin'),
				"imagedesc" => __("Image Desc",'striking_admin'),
				"none" => __("None",'striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Order",'striking_admin'),
			"desc" => __("Designates the ascending or descending order of the 'orderby' parameter.",'striking_admin'),
			"id" => "order",
			"default" => 'ASC',
			"options" => array(
				"ASC" => __("ASC (ascending order)",'striking_admin'),
				"DESC" => __("DESC (descending order)",'striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Orderby",'striking_admin'),
			"desc" => __("Sort retrieved portfolio items by parameter.",'striking_admin'),
			"id" => "orderby",
			"default" => 'menu_order',
			"options" => array(
				"none" => __("No order",'striking_admin'),
				"id" => __("Order by post id",'striking_admin'),
				"author" => __("Order by author",'striking_admin'),
				"title" => __("Order by title",'striking_admin'),
				"date" => __("Order by date",'striking_admin'),
				"modified" => __("Order by last modified date",'striking_admin'),
				"parent" => __("Order by post/page parent id",'striking_admin'),
				"rand" => __("Random order",'striking_admin'),
				"comment_count" => __("Order by number of comments",'striking_admin'),
				"menu_order" => __("Order by Page Order",'striking_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Effect",'striking_admin'),
			"desc" => __("Effect when hover the feature image.",'striking_admin'),
			"id" => "effect",
			"default" => 'default',
			"options" => array(
				"default" => __("Default",'striking_admin'),
				"icon" => __("Icon",'striking_admin'),
				"grayscale" => __("Grayscale",'striking_admin'),
				"none" => __("None",'striking_admin'),
			),
			"type" => "select",
		),
	),
);
