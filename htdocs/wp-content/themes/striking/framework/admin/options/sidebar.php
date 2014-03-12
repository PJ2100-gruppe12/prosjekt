<?php
class Theme_Options_Page_Sidebar extends Theme_Options_Page_With_Tabs {
	public $slug = 'sidebar';

	function __construct(){
		$this->name = sprintf(__('%s Sidebar Settings','striking_admin'),THEME_NAME);
		parent::__construct();
	}

	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("Custom Sidebar Generator Tool",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Create A Custom Sidebar",'striking_admin'),
						"desc" => __("<p>In this field enter the name of your new custom sidebar and then click on the <b>Save Changes</b> button below. &nbsp;&nbsp;Once you have created a custom sidebar, it will be listed below. &nbsp;&nbsp;Then go to the Global Settings tabs and in each individual page, post and archive type selector dropdown list you will see the names of the sidebars you have created. &nbsp;&nbsp;Select the custom sidebar you wish to use for that page or post type from the dropdown list.</p><p>After you have created a custom sidebar, go to the Widgets section of the WP admin and you will see all the custom sidebars you have created showing below the list of regular sidebars. &nbsp;&nbsp;Drag into a custom sidebar the widgets you wish to appear in the page or post sidebar when you view it in your site.</p><p>There is no limit to the number of custom sidebars in a site. &nbsp;&nbsp;One could create a custom sidebar for every page in a site if so desired. &nbsp;&nbsp;If one needs even more control over widgets appearing in sidebars, one can also go to the wordpress.org plugin index and download a widget control plugin such as Dynamic Widgets, Widget Logic or Widgets Controller. &nbsp;&nbsp;However, the Striking Custom Sidebar can alleviate the need for a widget plugin in most instances, and reduces the processing overhead  a plugin script incurs on a page load.</p>",'striking_admin'),	
						"id" => "sidebars",
						"function" => "_option_sidebars_function",
						"default" => "",
						"type" => "custom"
					),
				),
			),
			array(
				"slug" => 'custom',
				"name" => __("Striking Metabox Custom Sidebar - Global Settings",'striking_admin'),	
				"options" => array(
					array(
						"name" => __("Global Single Page Custom Sidebar Selector",'striking_admin'),
						"desc" => __("<p>With this selector you may set a custom sidebar to appear on all your sites 'normal' pages. However, when desired, Striking still allows you to override this global setting on a page by page basis. </p><p>To do so go to the <b>Striking Page General Options</b> metabox below the WP content editor of the page. The <em>General Page</em> tab in this metabox has a <b>Custom Sidebar</b> setting. &nbsp;&nbsp;It is here that one can individually select another custom sidebar or default to the regular Page Widget sidebar to override the global setting for that page you are editing.&nbsp;&nbsp;Be aware that if you have pages which use another custom  or the default page sidebar, and you edit that page subsequently for any reason, you will have to set it to that sidebar again in the selector as part of the edit, or the page will default to this globally set custom sidebar which is default by way of this setting.</p><p>The result is that Striking allows you to have a unique sidebar on every page and post page.</p>",'striking_admin'),
						"id" => "single_page",
						"default" => '',
						"options"=> theme_get_sidebar_options(),
						"prompt" => __("None",'striking_admin'),
						"type" => "select",
					),
					array(
						"name" => __("Global Single Blog Post Page Custom Sidebar Selector",'striking_admin'),
						"desc" => __("<p>With this selector you may set a custom sidebar to appear on all your site's 'single blog post' pages. &nbsp;&nbsp;However, when desired, Striking still allows you to override this global setting on a post by post basis.</p><p>To do so go to the <em>Striking Page General Options</em> metabox below the WP content editor of the post you are editing. &nbsp;&nbsp;The <em>General Page</em> tab in this metabox has a <b>Custom Sidebar</b> setting. &nbsp;&nbsp;It is here that one can individually select another custom sidebar or default to the regular Blog Widget Area sidebar to override the global setting for that post you are editing.&nbsp;&nbsp;Be aware that if you have blog posts which use another custom or the default blog sidebar, and you edit that blog post subsequently for any reason, you will have to set it to that sidebar again in the selector as part of the edit, or the page will default to this globally set custom sidebar which is default by way of this setting.</p><p>The result is that Striking allows you to have a unique sidebar on every single blog post page.</p>",'striking_admin'),	
						"id" => "single_post",
						"default" => '',
						"options"=> theme_get_sidebar_options(),
						"prompt" => __("None",'striking_admin'),
						"type" => "select",
					),
					array(
						"name" => __("Gobal Single Portfolio Post Page Custom Sidebar Selector",'striking_admin'),
						"desc" => __("With this selector you may set a custom sidebar to appear on all your site's 'single portfolio post' pages. &nbsp;&nbsp;However, when desired, Striking still allows you to override this global setting on a post by post basis. <br><br>To do so go to the <em>Striking Page General Options</em> metabox below the WP content editor of the portfolio post you are editing. &nbsp;&nbsp;The <em>General Page</em> tab in this metabox has a <b>Custom Sidebar</b> setting. &nbsp;&nbsp;It is here that one can individually select another custom sidebar or default to the regular Portfolio Widget Area sidebar to override the global setting for that post you are editing.&nbsp;&nbsp;Be aware that if you have portfolio posts which use another custom or the default portfolio sidebar, and you edit that portfolio post subsequently for any reason, you will have to set it to that sidebar again in the selector as part of the edit, or the page will default to this globally set custom sidebar which is default by way of this setting.<br><br>The result is that Striking allows you to have a unique sidebar on every single portfolio post page.",'striking_admin'),	
						"id" => "single_portfolio",
						"default" => '',
						"options"=> theme_get_sidebar_options(),
						"prompt" => __("None",'striking_admin'),
						"type" => "select",
					),
				),
			),
		);
		return $options;
	}

	function _option_sidebars_function($value, $default) {
		if(!empty($default)){
			$sidebars = explode(',',$default);
		}else{
			$sidebars = array();
		}
		
		echo <<<HTML
<script type="text/javascript">
jQuery(document).ready( function($) {
	$("#add_sidebar").validator({effect:'option'}).closest('form').submit(function(e) {
		if (!e.isDefaultPrevented() && $("#add_sidebar").val()) {
			if($('#sidebars').val()){
				$('#sidebars').val($('#sidebars').val()+','+$("#add_sidebar").val());
			}else{
				$('#sidebars').val($("#add_sidebar").val());
			}
		}
	});
	$(".sidebar-item input:button").click(function(){
		$(this).closest(".sidebar-item").fadeOut("normal",function(){
  			$(this).remove();
  			$('#sidebars').val('');
			$(".sidebar-item-value").each(function(){
				if($('#sidebars').val()){
					$('#sidebars').val($('#sidebars').val()+','+$(this).val());
				}else{
					$('#sidebars').val($(this).val());
				}
			});
 		});
		
	});
	
});
</script>
<style type="text/css">
.sidebar-title {
	margin:20px 0 5px;
	font-weight:bold;
}
.sidebar-item {
	padding-left:10px;
}
.sidebar-item span {
	margin-right:10px;
}

</style>
HTML;
		
		echo '<input type="text" id="add_sidebar" name="add_sidebar" pattern="([a-zA-Z\x7f-\xff][ a-zA-Z0-9_\x7f-\xff]*){0,1}" data-message="'.__('Please input a valid name which starts with a letter, followed by letters, numbers, spaces, or underscores.','striking_admin').'" maxlength="20" /><span class="validator-error"></span>';
		if(!empty($sidebars)){
			echo '<div class="sidebar-title">'.__('Below are the Sidebars you have created','striking_admin').'</div>';
			foreach($sidebars as $sidebar){
				echo '<div class="sidebar-item"><span>'.$sidebar.'</span><input type="hidden" class="sidebar-item-value" value="'.$sidebar.'"/><input type="button" class="button" value="'.__('Delete','striking_admin').'"/></div>';
			}
		}
		echo '<input type="hidden" value="' . $default . '" name="' . $value['id'] . '" id="sidebars"/>';
	}
}
