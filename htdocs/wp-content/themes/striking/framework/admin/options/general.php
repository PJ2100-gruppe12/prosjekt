<?php
class Theme_Options_Page_General extends Theme_Options_Page_With_Tabs {
	public $slug = 'general';

	function __construct(){
		$this -> name = sprintf(__('%s General Settings','striking_admin'),THEME_NAME);
		parent::__construct();
	}
	
	function tabs(){
		return array(
			array(
				"slug" => 'header',
				"name" => __("General Header Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Header Height",'striking_admin'),
						"desc" => sprintf(__('The Header area is the very top portion of each webpage and initally contains the <b>Site Title</b> and <b>Tagline</b> which are defined in <a href="%s/wp-admin/options-general.php">Settings -> General</a>, and the main navigation menu of your site.  &nbsp;&nbsp;One can also insert a custom logo into the header area, and activate a widget area up in the top right hand corner of the header area using the <b>Header Widget Area</b> setting found below.<br /><br />The Striking header can be set to a height ranging from 60px to 300px, and you should adjust the height to fit the logo size and the content you might decide to put into the header widget area.','striking_admin'),get_option('siteurl')),	
						"id" => "header_height",
						"min" => "60",
						"max" => "300",
						"step" => "1",
						"unit" => 'px',
						"default" => "90",
						"type" => "range"
					),
					array(
						"name" => __("Set A Custom Logo",'striking_admin'),
						"desc" => sprintf(__('If you set this to <em>"On"</em>, you should upload an image using the <b>Custom Logo</b> uploader below.&nbsp;&nbsp;The use of a site logo is optional - generally a logo is used if one is attempting to create a brand identity. &nbsp;&nbspOnce you upload a logo, the <b>Site Title</b> is automatically disabled from appearing in the header area.<br /><br />If you do not use a logo, you can still customize your <b>Site Title</b> and <b>Site Tagline</b> in <a href="%1s/wp-admin/options-general.php">Settings -> General</a>. &nbsp;&nbsp;Furthermore, Striking allows you to customize the font sizes and colors of the site title and tagline using the settings found for each in the <a href="%2s">Striking -> Font</a> and <a href="%3s">Striking -> Color</a> panels so that if you do not have a logo, you can still create a unique "id" for your site.','striking_admin'),get_option('siteurl'),admin_url( 'admin.php?page=theme_font'),admin_url( 'admin.php?page=theme_color')),	
						"id" => "display_logo",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Custom Logo Uploader",'striking_admin'),
						"desc" => __("The logo uploader uses the default wp image uploading function, and once you see the image dialogue box - where you can set <em>alt</em> title and so on, click on <em>Use This</em> at the bottom of the dialogue box and you will see your image appearing in this custom logo area.&nbsp;&nbsp;If you want your site pages to load quicker, we suggest you use a jpeg image instead of a png image due to the lighter weight of jpegs. &nbsp;&nbspDo remember that if you remove the image, it will not be deleted from your media libary unless you go to the media library and delete the image permanently.",'striking_admin'),
						"id" => "logo",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Display Site Tagline",'striking_admin'),
						"desc" => sprintf(__('You can choose whether to display <a href="%s/wp-admin/options-general.php">Tagline</a> after the Site Title or Logo or you can deactivate it using this setting.','striking_admin'),get_option('siteurl')),		
						"id" => "display_site_desc",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Logo and/or Tagline Bottom Spacing",'striking_admin'),	
						"desc" => __("This setting is for creating the amount of gap between the bottom of the logo, and the navigation menu and feature header area below the logo.&nbsp;&nbsp;If you have no Tagline, the spacing starts from the bottom of the Site Title or Logo.&nbsp;&nbsp;If you have a Tagline, then the spacing starts from the bottom of it.<br /><br /> This setting is useful as once you start to build a larger navigation menu, it will space out left towards the logo area, and you will find you will need to adjust the bottom spacing in order for they not to infringe upon each other.",'striking_admin'),		
						"id" => "logo_bottom",
						"min" => "-50",
						"max" => "80",
						"step" => "1",
						"unit" => 'px',
						"default" => "20",
						"type" => "range"
					),
					array(
						"name" => __("Header Top Area",'striking_admin'),
						"desc" => sprintf(__("Striking provides the ability to have a widget area in the top right section of the header area. &nbsp;&nbsp; You have 3 choices:<br /><br />1 - to show the wpml flags if you are using the wordpress multi-language plugin <br />2 - to set it as a Widget Area in which case you go to <a href='%s/wp-admin/widgets.php'>Appearence -> Widgets</a> and you will see a new Header Widget Area appear for you to insert a widget into it<br />3 - set the area to the html mode in which case you can style the header widget area space to hold whatever content you wish and appear per your styling.&nbsp;&nbsp;The html mode was included into Striking at the request of designers who use our theme for their client sites, and is only recommended for users with a good understanding of html coding.&nbsp;&nbsp;However, there are a number of threads in the Striking support forum on styling the header widget area in html mode which may assist the novice coder on styling this area.<br /><br />A hint: If you wish to have multiple widgets side by side in the header widget area, you should set it to the html mode, and then use either divs, or column or layout shortcodes, and then copy and paste the widget shortcodes into the columns.&nbsp;&nbsp;  The easy way to set the options for the actual widgets you want to insert here is to use a test page to input the widget shortcode and then cut and paste this widget code into the html field below.",'striking_admin'),get_option('siteurl')),
						"id" => "top_area_type",
						"default" => '',
						"options" => array(
							"html" => __('Html','striking_admin'),
							"wpml_flags" => __('Wpml Flags','striking_admin'),
							"widget" => __('Widget Area','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Header Top Area Html Code",'striking_admin'),
						"desc" => __("In html mode this area accepts Striking shortcodes and html.&nbsp;&nbsp; An easy way to use this area is to create the content in the wp editor on a test page or post and then cut and paste it into this field. &nbsp;&nbsp;Use either layout or column shortcodes, or divs, to space out your content horizontally.<br /><br />Remember that you do not want to enlarge the header height too much so this area is typically most suitable for compact items such as social icons, a search field, extra navigation links, multi-language flags, etc.",'striking_admin'),		
						"id" => "top_area_html",
						"default" => "",
						'rows' => '3',
						"type" => "textarea"
					),
				),
			),
			array(
				"slug" => 'navigation',
				"name" => __("Navigation Menu Options",'striking_admin'),	
				"options" => array(
					array(
						"name" => __("Activate Top Level Navigation Button Style Appearence",'striking_admin'),	
						"desc" => __("This setting creates a button type look for your top level navigation. &nbsp;&nbsp;To be effective you also have to go to the <b>Striking -> Color</B> Panel and give your <b>Top Level Menu Background Color</b> a color. &nbsp;&nbsp;And if you want the buttons to change color when you hover over them, then also select a color in the <b>Top Level Menu Hover Background Color</b>.&nbsp;&nbsp;You can also select colors for the text in both hover and non-hover states, and more, in the Color Panel - Header Settings.",'striking_admin'),	
						"id" => "nav_button",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Activate Top Level Navigation Parent Arrow Appearence Feature",'striking_admin'),
						"desc" => __("If this setting is toggled <em>ON</em>, the navigation will display a arrow pointing down after the top level menu text if there are sub-navigation children. &nbsp;&nbsp;So it is particularly useful combined with the button effect in order to alert the site viewer that there are child pages to each top level navigation item. &nbsp;&nbsp;(Only works on wp 3.2 + for Wordpress buit-in Menu and wp 3.3 + for Wordpress Page Menu.)",'striking_admin'),	
						"id" => "nav_arrow",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Activate Wordpress Custom Menu Functionality",'striking_admin'),
				"desc" => sprintf(__("If this option is <em>ON</em>, you can control the site’s menus with the new WordPress Custom Navigation Menu features, which provide the ability to do drag and drop menu ordering, custom titles to pages, hide some pages, add categories, tags and other items to menus, and more. <br /><br />Striking allows for 2 top level custom navigation menus (Main Navigation and Footer) and unlimited custom navigation menus for the Custom Navigation widgets. &nbsp;&nbsp;See here: <a href=\"%s/wp-admin/nav-menus.php\">%s/wp-admin/nav-menus.php</a>",'striking_admin'),get_option('siteurl'),get_option('siteurl')),	
						"id" => "enable_nav_menu",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Exclude Site Pages From Striking Default Menu",'striking_admin'),
						"desc" => __("If one is not using the Wordpress Built-in Menu for custom menu manipulation, but wants to hide certain pages from appearing in the navigation, one selects the pages to exclude below. &nbsp;&nbsp;Hold down the Cntrl key on your keyboard to select multiple items (similar to how one would select multiple items on a desktop).",'striking_admin'),	
						"id" => "excluded_pages",
						"default" => array(),
						"page" => '0',
						"prompt" => __("Choose page..",'striking_admin'),
						"chosen" => "true",
						"type" => "multiselect",
					),
				),
			),
			array(
				"slug" => 'page',
				"name" => __("General Page Layout Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Set to a Boxed Layout Appearence",'striking_admin'),
						"desc" => "This setting converts the site to a boxed layout type appearence, where the header and footer areas are constrained to the same width as the page body area, which is 1000px when in boxed mode.",	
						"id" => "enable_box_layout",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Set a Default Page Layout",'striking_admin'),
						"desc" => "Striking has 3 possible default Page Templates:<br /><br />1 - Full Width <br />2 - Left Sidebar<br />3 - Right Sidebar<br /><br />Although one can always select the page layout on a page-by-page basis using the <b>Template</b> setting, setting a default page template saves one having to set the layout everytime one creates a page.<br /><br />Of course in Striking one can always override the default template by selecting another in the drop down selector in the <b>Template</b> Setting each time one creates or edits a page, so one is never restricted. &nbsp;&nbsp;This <b>Set a Default Page Layout</b> ability is provided to reduce the amount of work in page creation and editing.",
						"id" => "layout",
						"default" => 'right',
						"options" => array(
							"full" => __('Full Width','striking_admin'),
							"right" => __('Right Sidebar','striking_admin'),
							"left" => __('Left Sidebar','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Load a Custom Favicon",'striking_admin'),
						"desc" => __("Paste the full URL (include <code>http://</code>) of your custom favicon here, or you can upload the icon by using the Upload Icon button below. &nbsp;&nbsp;Please note that while the WP default image uploading routine will give you the option of selecting something from the media library, in fact you always have to upload the image from your desktop - selecting something in the media library will not work for this Striking feature. &nbsp;&nbsp;If you don't like the favicon you uploaded, use the Remove Image button to remove it, and upload another. <br /><br />Be advised that if you remove a favicon, the image will still remain in the media library, so if one is cycling through a variety of potential favicons, one may wish to go to the media library and permanently delete the images not used in order to reduce media library clutter.<br /><br />The standard favicon size is 16px by 16 px and there are many free web resources available for assisting in creating a favicon. &nbsp;&nbsp;Also be advised some browsers do not support favicons.",'striking_admin'),
						"id" => "custom_favicon",
						"default" => '',
						"button" => 'Upload Icon',
						"type" => 'upload',
						"imagewidth" => '16',
					),
					array(
						"name" => __("Disable the Striking Feature Header Site Wide",'striking_admin'),
						"desc" => __("If this option is set to ON, you'll globally disable your website's Feature Header Area which is the area just below the navigation typically used for display of media (such as the big slider) or information. &nbsp;&nbsp;Striking also allows for the removal of the Feature Header area on a per page/post basis and the setting to do this is found in the <b>Striking General Page Options</b> metabox which is one of the metabox found below the wp content editor.<br /><br />This is a legacy setting as Striking has since over time introduced a wide variety of settings allowing for full control and manipulation of the feature header area by way of the various options in the <b>Feature Header Type</b> setting found in the Striking Page General Options metabox -> Feature Header Settings tab.",'striking_admin'),
						"id" => "introduce",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Disable Breadcrumbs Site Wide",'striking_admin'),
						"desc" => __("Striking has built into its core code the very well known <em>Breadcrumbs Plus</em> plugin -> so it is not necessary to load this plugin separately. &nbsp;&nbsp;The purpose of this setting if turned on is to globally disable the website's breadcrumb navigation.<br /><br />Breadcrumbs do not appear on the homepage of a site, and the breadcrumb string will depend on how one has set the site permalinks. &nbsp;&nbsp;The breadcrumb placement in Striking is in the upper left hand corner of the page body section of all other pages and posts. &nbsp;&nbsp;Typically each navigation layer other then the present page is a clickable link in the breadcrumb string.",'striking_admin'),
						"id" => "disable_breadcrumb",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable default lightbox for all images sitewide",'striking_admin'),
						"desc" => __("We normally suggest leaving this setting off! &nbsp;&nbsp;However, it is useful if one typically uses the wordpress Add Media function to put an image into content (rather then using the Striking Image Shortcode), and wants the images to automatically have the ability to open in a lightbox by defauIt.",'striking_admin'),
						"id" => "lightbox_rel_replace",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Scroll to Top ",'striking_admin'),
						"desc" => __("If this option is <em>ON</em>, you'll see a nice scroll to top button (round circle with an upwards pointing arrow in the circle center) at the bottom right corner of site pages, posts, etc. &nbsp;&nbsp;Particularly useful if one has site pages with lots of content or long sidebars.",'striking_admin'),
						"id" => "scroll_to_top",
						"default" => false,
						"type" => "toggle"
					),
				),
			),	
			array(
				"slug" => 'analytics',
				"name" => __("Google Analytics Code Settings",'striking_admin'),
				"options"=> array(
					array(
						"name" => __("Choose where to load the Google Analytics Javascript",'striking_admin'),
						"desc" => __("This setting gives you the ability to have the google analytics code loaded either in the header or the footer area.&nbsp;&nbsp;Typically a site has it load in the header per google recommendations but there are certain exceptions where it is more desirable for it to be loaded in the footer.",'striking_admin'),
						"id" => "analytics_position",
						"default" => 'bottom',
						"options" => array(
							"header" => __('Header','striking_admin'),
							"bottom" => __('Bottom','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Google Analytics Code",'striking_admin'),
						"desc" => __("Paste your <a href='http://www.google.com/analytics/' target='_blank'>analytics code</a> here, and it will get applied to each page in the site automatically.",'striking_admin'),
						"id" => "analytics",
						"default" => "",
						"type" => "textarea"
					),
				),
			),
			
			array(
				"slug" => 'custom',
				"name" => __("Custom CSS & JS Fields",'striking_admin'),
				"options"=> array(
					array(
						"name" => __("Custom CSS",'striking_admin'),
					"desc" => __("This field is where one can post any custom css to override the default css of the theme.&nbsp;&nbsp;The Striking default css is found in the screen.css file in the CSS folder (Striking/CSS/screen.css) and you can open that file with an editor such as Notepad ++ or Dreamweaver to review it. &nbsp;&nbsp;One can also use browser tools such as Firebug and Web Developer to detect all the individual code elements of a webpage, and these tools allow for live editing > you can take that custom code from the live editing and paste it in this field to duplicate the effect achieved.<br /><br />The Striking Support Forum has thousands of threads containing simple custom css snippets that allow one to change the appearence and position of many elements in an advanced way, beyond what is practical for a traditional theme setting. &nbsp;&nbsp;You would take those snippets and copy and paste them into the field below.<br /><br />The content of the field below is stored in your site database, and so it is unaffected by Striking theme updates. &nbsp;&nbsp;But it is always a good idea to have pasted the content below into a text document and store this on your local machine or somewhere else other then your website host so that you have an independent backup, since a database can be compromised due to other circumstances.",'striking_admin'),	
						"id" => "custom_css",
						"default" => "",
						'rows' => '10',
						"type" => "textarea"
					),
					array(
						"name" => __("Custom JS",'striking_admin'),
						"desc" => sprintf(__('This field has the same type of ability as the above CSS field, and again code in here is stored in the database, and unaffected by theme updates. The code input here will display on the footer of the page. Sample: <br/><code>&lt;script type=&quot;text/javascript&quot; src=&quot;%s/wp-content/themes/striking/js/yourscript.js&quot;&gt;&lt;/script&gt;</code><br/>
<code>&lt;script type=&quot;text/javascript&quot;&gt;alert("hello world");&lt;/script&gt;</code>','striking_admin'),get_option('siteurl')),
						"id" => "custom_js",
						"default" => "",
						'rows' => '10',
						"type" => "textarea"
					),
				),
			),
		);
	}
}
