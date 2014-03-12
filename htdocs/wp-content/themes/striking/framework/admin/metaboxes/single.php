<?php 
class Theme_Metabox_Single extends Theme_Metabox {
	public $slug = 'single';
	public function config(){
		return array(
			'title' => sprintf(__('%s Blog Single Options','striking_admin'),THEME_NAME),
			'post_types' => array('post'),
			'callback' => '',
			'context' => 'normal',
			'priority' => 'high',
		);
	}
	public function options(){
		return array(
			array(
				"name" => __("Featured Image",'striking_admin'),
				"desc" => __("Whether to dispaly Featured Image in this page. This will override the global configuration",'striking_admin'),
				"id" => "_featured_image",
				"default" => '',
				"type" => "tritoggle",
			),
			array(
				"name" => __("Show in Header Area",'striking_admin'),
				"desc" => __("Turned on the Blogtitle and meta info will show in header text area. Turned off the Blogtitle and meta info will be shown in the page itself. This will override the global configuration",'striking_admin'),
				"id" => "_show_in_header",
				"default" => '',
				"type" => "tritoggle"
			),
			array(
				"name" => __("About Author Box",'striking_admin'),
				"desc" => __("Whether to dispaly About Author Box in this page below the post content. This will override the global configuration",'striking_admin'),
				"id" => "_author",
				"default" => '',
				"type" => "tritoggle"
			),
			array(
				"name" => __("Related & Popular Post Module",'striking_admin'),
				"desc" => __("Whether to dispaly Related & Popular Post Module in this page below the post content. This will override the global configuration",'striking_admin'),
				"id" => "_related_popular",
				"default" => '',
				"type" => "tritoggle"
			),
		);
	}
}