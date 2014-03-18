<?php
return array(
	"title" => __("Portfolio", "theme_admin"),
	"shortcode" => 'portfolio',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Column",'theme_admin'),
			"id" => "column",
			"default" => '4',
			"options" => array(
				"1" => sprintf(__("%d Column",'theme_admin'),1),
				"2" => sprintf(__("%d Columns",'theme_admin'),2),
				"3" => sprintf(__("%d Columns",'theme_admin'),3),
				"4" => sprintf(__("%d Columns",'theme_admin'),4),
				"5" => sprintf(__("%d Columns",'theme_admin'),5),
				"6" => sprintf(__("%d Columns",'theme_admin'),6),
				"7" => sprintf(__("%d Columns",'theme_admin'),7),
				"8" => sprintf(__("%d Columns",'theme_admin'),8),
			),
			"type" => "select",
		),
		array (
			"name" => __("Thumbnail Height (optional)",'theme_admin'),
			"desc" => __("The height of thumbnail image.",'theme_admin'),
			"id" => "height",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"unit" => 'px',
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Page Layout",'theme_admin'),
			"id" => "layout",
			"default" => 'full',
			"options" => array(
				"full" => __("Full Width",'theme_admin'),
				"sidebar" => __("With Sidebar",'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("No Paging",'theme_admin'),
			"id" => "nopaging",
			"desc" => __("If the option is on, it will disable pagination, displaying all posts",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Max",'theme_admin'),
			"desc" => __("Number of item to show per page",'theme_admin'),
			"id" => "max",
			"default" => '-1',
			"min" => -1,
			"max" => 50,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Sortable",'theme_admin'),
			"id" => "sortable",
			"desc" => __("If the option is on, it will disable pagination, displaying all posts by category with sortable.",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Sortable All",'theme_admin'),
			"id" => "sortable_all",
			"desc" => __("If the option is on, it will show all tab on sortable portfolio list.",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Sortable Show Text",'theme_admin'),
			"id" => "sortable_showText",
			"default" => theme_get_option('portfolio','show_text'),
			"type" => "text",
		),
		array(
			"name" => __("Ajax",'theme_admin'),
			"id" => "ajax",
			"desc" => __("If the option is on, it will add ajax support for page navigation. ",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Category (optional)",'theme_admin'),
			"id" => "cat",
			"default" => array(),
			"chosen" => true,
			"target" => 'portfolio_category',
			"prompt" => __("Select Categories..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Current Tab (optional)",'theme_admin'),
			"desc" => __("If only work with Sortable type.",'theme_admin'),
			"id" => "current",
			"default" => array(),
			"chosen" => true,
			"target" => 'portfolio_category',
			"prompt" => __("Select Categories..",'theme_admin'),
			"type" => "select",
		),
		array(
			"name" => __("Ids (optional)",'theme_admin'),
			"desc" => __("The specific portfolios you want to display",'theme_admin'),
			"id" => "ids",
			"default" => array(),
			"chosen" => true,
			"target" => 'portfolio',
			"prompt" => __("Select Porfolios..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Display Title",'theme_admin'),
			"id" => "title",
			"desc" => __("If the option is on, it will display title of portfolio.",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Title Linkable",'theme_admin'),
			"id" => "titleLinkable",
			"desc" => __("If the option is on, the title of portfolio will link to portfolio single page posts.",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Display Portfolio Description",'theme_admin'),
			"id" => "desc",
			"desc" => __("If the option is <em>ON,</em> it will display the Portfolio Excerpt of each portfolio item. &nbsp;&nbsp;If the Excerpt field is empty, it will fallback to/display instead the content of the main wp editor field.",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Description Length",'theme_admin'),
			"desc" => __("You can set the number of characters -> this includes blank spaces, that you will show in the portfolio item description for each item appearing in your portfolio list.&nbsp;&nbsp;The maximum number of characters is 200.&nbsp;&nbsp;Please note that this setting does not work if you have the <b>Enable Shortcode Support in Description</b> setting <em>ON</em>.",'theme_admin'),
			"id" => "desc_length",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Enable Shortcode Support in Description Field",'theme_admin'),
			"id" => "advanceDesc",
			"desc" => __("If the option is <em>ON</em>, one can use Striking shortcodes in the Excerpt and post editor fields and the shortcodes will be work for the description display.  If the setting is <em>OFF</em>, simple html tags will work, but any striking shortcodes such as the typography shortcodes, will not work.",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Display <b>Read More</b> Button",'theme_admin'),
			"id" => "more",
			"desc" => __("If the option is <b>ON</b>, the Read More button will display so that a viewer can go to the portfolio page.",'theme_admin'),
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Read More Button Text",'theme_admin'),
			"id" => "moreText",
			"desc" => __("If one has set the Read More button to display above, then with this setting one can set the text for the button to what is desired.",'theme_admin'),
			"default" => theme_get_option('portfolio','more_button_text'),
			"type" => "text",
		),
		array(
			"name" => __("Display Read More as button",'theme_admin'),
			"id" => "moreButton",
			"desc" => __("Normally, if you have enabled the ability to Read More above, it displays as text in a format similar to how a tag displays, but if this setting is toggled <em>ON</em> then the Read More button and the text set in the above settings will display within a button.",'theme_admin'),
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Lightbox Grouping of Featured Images",'theme_admin'),
			"id" => "group",
			"desc" => __("If the option is <em>ON</em>, a user will be able to transition from one portfolio thumbnail to the next without having to click on each portfolio list item -> the lightbox will display left and right arrows so that the viewer can easily transition between the images in the portfolio list.",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Lightbox Title Type",'theme_admin'),
			"id" => "lightboxTitle",
			"default" => 'portfolio',
			"options" => array(
				"portfolio" => __("Portfolio Title",'theme_admin'),
				"image" => __("Image Title",'theme_admin'),
				"imagecaption" => __("Image Caption",'theme_admin'),
				"imagedesc" => __("Image Desc",'theme_admin'),
				"none" => __("None",'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Order",'theme_admin'),
			"desc" => __("Designates the ascending or descending order of the 'orderby' parameter.",'theme_admin'),
			"id" => "order",
			"default" => 'ASC',
			"options" => array(
				"ASC" => __("ASC (ascending order)",'theme_admin'),
				"DESC" => __("DESC (descending order)",'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Orderby",'theme_admin'),
			"desc" => __("Sort retrieved portfolio items by parameter.",'theme_admin'),
			"id" => "orderby",
			"default" => 'menu_order',
			"options" => array(
				"none" => __("No order",'theme_admin'),
				"id" => __("Order by post id",'theme_admin'),
				"author" => __("Order by author",'theme_admin'),
				"title" => __("Order by title",'theme_admin'),
				"date" => __("Order by date",'theme_admin'),
				"modified" => __("Order by last modified date",'theme_admin'),
				"parent" => __("Order by post/page parent id",'theme_admin'),
				"rand" => __("Random order",'theme_admin'),
				"comment_count" => __("Order by number of comments",'theme_admin'),
				"menu_order" => __("Order by Page Order",'theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Effect",'theme_admin'),
			"desc" => __("Effect when hover the feature image.",'theme_admin'),
			"id" => "effect",
			"default" => 'default',
			"options" => array(
				"default" => __("Default",'theme_admin'),
				"icon" => __("Icon",'theme_admin'),
				"grayscale" => __("Grayscale",'theme_admin'),
				"none" => __("None",'theme_admin'),
			),
			"type" => "select",
		),
	),
);
