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
				"name" => __("Display Featured Image in the Post",'theme_admin'),
				"desc" => __("Whether to display Featured Image at the top of the post. &nbsp;This will override the global configuration from the same setting in the Single Post Tab/Blog Panel. &nbsp;Toggle to OFF if intending instead to insert a different image into the post body (an example being a different ratio of the featured image) or if there is no need to dispaly the Feature Image in the post. ",'theme_admin'),
				"id" => "_featured_image",
				"default" => '',
				"type" => "tritoggle",
			),
			array(
				"name" => __("Different Image for Blog List (optional)",'theme_admin'),
				"desc" => __("This setting allows substitution of an alternate image for appearence in a blog list (ie the blog shortcode) in place of the featured image of the post. &nbsp;If not assigned, the featured image will appear in the post list.  ",'theme_admin'),
				"id" => "_list_image",
				"button" => "Insert Image",
				"default" => '',
				"type" => "upload",
			),
			array(
				"name" => __("Show Meta in Feature Header Area",'theme_admin'),
				"desc" => __("If this setting is ON, the post title and meta info will show in feature header text area. &nbsp;Turned OFF the Blogtitle and meta info will be shown in the page itself. &nbsp; This will override the global configuration from the same setting in the Single Post Tab/Blog Panel",'theme_admin'),
				"id" => "_show_in_header",
				"default" => '',
				"type" => "tritoggle"
			),
			array(
				"name" => __("Display the About Author Box",'theme_admin'),
				"desc" => __("Whether to display About Author Box in the webpage below the post content. This will override the global configuration from the same setting in the Single Post Tab/Blog Panel",'theme_admin'),
				"id" => "_author",
				"default" => '',
				"type" => "tritoggle"
			),
			array(
				"name" => __("Show the Related & Popular Post Module",'theme_admin'),
				"desc" => __("Whether to display the Related & Popular Post Module in this webpage below the post content. This will override the global configuration from the same setting in the Single Post Tab/Blog Panel",'theme_admin'),
				"id" => "_related_popular",
				"default" => '',
				"type" => "tritoggle"
			),
		);
	}
}