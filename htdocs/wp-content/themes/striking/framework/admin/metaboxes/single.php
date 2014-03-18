<?php 
class Theme_Metabox_Single extends Theme_Metabox {
	public $slug = 'single';
	public function config(){
		return array(
			'title' => sprintf(__('%s Blog Single Options','theme_admin'),THEME_NAME),
			'post_types' => array('post'),
			'callback' => '',
			'context' => 'normal',
			'priority' => 'high',
		);
	}
	public function options(){
		return array(
			array(
				"name" => __("Featured Image",'theme_admin'),
				"desc" => __("Whether to dispaly Featured Image in this page. This will override the global configuration",'theme_admin'),
				"id" => "_featured_image",
				"default" => '',
				"type" => "tritoggle",
			),
			array(
				"name" => __("Show in Header Area",'theme_admin'),
				"desc" => __("Turned on the Blogtitle and meta info will show in header text area. Turned off the Blogtitle and meta info will be shown in the page itself. This will override the global configuration",'theme_admin'),
				"id" => "_show_in_header",
				"default" => '',
				"type" => "tritoggle"
			),
			array(
				"name" => __("About Author Box",'theme_admin'),
				"desc" => __("Whether to dispaly About Author Box in this page below the post content. This will override the global configuration",'theme_admin'),
				"id" => "_author",
				"default" => '',
				"type" => "tritoggle"
			),
			array(
				"name" => __("Related & Popular Post Module",'theme_admin'),
				"desc" => __("Whether to dispaly Related & Popular Post Module in this page below the post content. This will override the global configuration",'theme_admin'),
				"id" => "_related_popular",
				"default" => '',
				"type" => "tritoggle"
			),
		);
	}
}