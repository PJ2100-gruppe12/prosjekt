<?php
return array(
	"title" => __("Blog", "theme_admin"),
	"shortcode" => 'blog',
	"type" => 'self-closing',
	"options" => array(
		array(
			"name" => __("Column",'theme_admin'),
			"id" => "column",
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
			"name" => __("Grid",'theme_admin'),
			"id" => "grid",
			"desc" => __("If the option is on, it will use grid layout for multiple column.",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Frame",'theme_admin'),
			"desc" => __("If the toggle is on the middle, it will use the setting on striking->blog options page.",'theme_admin'),
			"id" => "frame",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Frame Background Color (optional)",'theme_admin'),
			"id" => "frame_bgColor",
			"default" => '',
			"type" => "color"
		),
		array(
			"name" => __("Frame Border Color (optional)",'theme_admin'),
			"id" => "frame_borderColor",
			"default" => '',
			"type" => "color"
		),
		array(
			"name" => __("Frame Border Thickness (optional)",'theme_admin'),
			"id" => "frame_borderThickness",
			"default" => 1,
			"min" => 1,
			"max" => 20,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Divider Line Color (optional)",'theme_admin'),
			"id" => "divider_color",
			"default" => '',
			"type" => "color"
		),
		array(
			"name" => __("Count",'theme_admin'),
			"desc" => __("Number of posts to show per page",'theme_admin'),
			"id" => "count",
			"default" => '3',
			"min" => 1,
			"max" => 50,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Category(s) (optional)",'theme_admin'),
			"desc" => __("Use this selector to select a category for the blog list one is showing in the page or post. &nbsp;If one desires to have more then one category to show in the bloglist, select other categories using this setting (not the Multiple Categories setting below).<br /><br />Note : &nbsp;In the content editor, the categories will show by their numeric id in the shortcode string, not their name.",'theme_admin'),
			"id" => "cat",
			"default" => '',
			"target" => 'cat',
			"chosen" => true,
			"prompt" => __("Select Categories..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Multiple Categories (optional)",'theme_admin'),
			"desc" => __("This setting is not for choosing to have multiple categories to display.  &nbsp;Instead, it is to choose posts which are assigned to more then one category, and only have those posts that are 'cross-listed' to multiple categories displaying in the blog list.",'theme_admin'),
			"id" => "category__and",
			"default" => '',
			"target" => 'cat',
			"chosen" => true,
			"prompt" => __("Select Categories..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Exclude Categorie (optional)",'theme_admin'),
			"id" => "category__not_in",
			"default" => '',
			"target" => 'cat',
			"chosen" => true,
			"prompt" => __("Select Categories..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Posts (optional)",'theme_admin'),
			"desc" => __("The specific posts you want to display",'theme_admin'),
			"id" => "posts",
			"default" => array(),
			"chosen" => true,
			"target" => 'post',
			"prompt" => __("Select Posts..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Author (optional)",'theme_admin'),
			"id" => "author",
			"default" => array(),
			"chosen" => true,
			"target" => 'author',
			"prompt" => __("Select Authors..",'theme_admin'),
			"type" => "multiselect",
		),
		array(
			"name" => __("Image",'theme_admin'),
			"id" => "image",
			"desc" => __("If the option is on, it will display Featured Image of blog post",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("imageType",'theme_admin'),
			"id" => "imageType",
			"default" => '',
			"options" => array(
				"default" => __("Default",'theme_admin'),
				"full" => __("Full Width",'theme_admin'),
				"left" => __("Left Float",'theme_admin'),
				"right" => __("Right Float",'theme_admin'),
				"below" => __('Below Title','theme_admin'),
			),
			"type" => "select",
		),
		array(
			"name" => __("Width",'theme_admin'),
			"desc" => __("The width of Image",'theme_admin'),
			"id" => "width",
			"default" => '630',
			"min" => 0,
			"max" => 960,
			"step" => "1",
			"type" => "range"
		),
		array (
			"name" => __("Height (optional)",'theme_admin'),
			"desc" => __("The height of Feature image.",'theme_admin'),
			"id" => "height",
			"default" => 0,
			"min" => 0,
			"max" => 960,
			"unit" => 'px',
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Title",'theme_admin'),
			"id" => "title",
			"desc" => __("If the option is on, it will display Title of blog post",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Meta Information",'theme_admin'),
			"id" => "meta",
			"desc" => __("If the option is on, it will display Meta Information of blog post",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Description",'theme_admin'),
			"id" => "desc",
			"desc" => __("If the option is on, it will display Description of blog post",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Length of Description",'theme_admin'),
			"desc" => __("If it's set to 0, it will use default setting",'theme_admin'),
			"id" => "desc_length",
			"default" => '0',
			"min" => 0,
			"max" => 200,
			"step" => "1",
			"type" => "range"
		),
		array(
			"name" => __("Display Read More",'theme_admin'),
			"id" => "read_more",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Read More Text",'theme_admin'),
			"id" => "read_more_text",
			"default" => theme_get_option('blog','read_more_text'),
			"type" => "text",
		),
		array(
			"name" => __("Display Read More as button",'theme_admin'),
			"id" => "read_more_button",
			"default" => 'default',
			"type" => "tritoggle"
		),
		array(
			"name" => __("Display Full Post",'theme_admin'),
			"id" => "full",
			"desc" => __("If the option is on, it will display all content of the post",'theme_admin'),
			"default" => false,
			"type" => "toggle"
		),
		array(
			"name" => __("Nopaging",'theme_admin'),
			"id" => "nopaging",
			"desc" => __("If the option is on, it will disable pagination",'theme_admin'),
			"default" => true,
			"type" => "toggle"
		),
		array(
			"name" => __("Offset",'theme_admin'),
			"desc" => __("Number of post to displace or pass over.",'theme_admin'),
			"id" => "offset",
			"default" => '0',
			"min" => 0,
			"max" => 10,
			"step" => "1",
			"type" => "range"
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
