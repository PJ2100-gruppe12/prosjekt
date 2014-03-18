<?php
class Theme_Options_Page_General extends Theme_Options_Page_With_Tabs {
	public $slug = 'general';

	function __construct(){
		$this -> name = sprintf(__('%s General Settings','theme_admin'),THEME_NAME);
		parent::__construct();
	}
	
	function tabs(){
		return array(
			array(
				"slug" => 'header',
				"name" => __("General Header Settings",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Header Height",'theme_admin'),
						"desc" => sprintf(__('<p>The Header area is the very top portion of each webpage and initally contains the <strong>Site Title</strong> and <strong>Tagline</strong> which are defined in <a href="%s/wp-admin/options-general.php" target="_blank">Settings -> General</a>, and the main navigation menu of your site.  &nbsp;&nbsp;One can also insert a custom logo into the header area, and activate a widget area up in the top right hand corner of the header area using the <strong>Header Widget Area</strong> setting found below.</p><p>The Striking header can be set to a height ranging from 60px to 300px, and you should adjust the height to fit the logo size and the content you might decide to put into the header widget area.','theme_admin'),get_option('siteurl')),	
						"id" => "header_height",
						"min" => "60",
						"max" => "300",
						"step" => "1",
						"unit" => 'px',
						"default" => "90",
						"type" => "range"
					),
					array(
						"name" => __("Set A Custom Logo",'theme_admin'),
						"desc" => sprintf(__('<p> If you set this to <em>"On"</em>, you should upload an image using the <strong>Custom Logo</strong> uploader below.&nbsp;&nbsp;The use of a site logo is optional - generally a logo is used if one is attempting to create a brand identity. &nbsp;&nbspOnce you upload a logo, the <strong>Site Title</strong> is automatically disabled from appearing in the header area.</p><p>If you do not use a logo, you can still customize your <strong>Site Title</strong> and <strong>Site Tagline</strong> in <a href="%1s/wp-admin/options-general.php" target="_blank">Settings -> General</a>. &nbsp;&nbsp;Furthermore, Striking allows you to customize the font sizes and colors of the site title and tagline using the settings found for each in the <a href="%2s" target="_blank">Striking -> Font</a> and <a href="%3s" target="_blank">Striking -> Color</a> panels so that if you do not have a logo, you can still create a unique "id" for your site by styling the look of your site title. <p> ','theme_admin'),get_option('siteurl'),admin_url( 'admin.php?page=theme_font&tab=size'),admin_url( 'admin.php?page=theme_color&tab=header')),	
						"id" => "display_logo",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Custom Logo Uploader",'theme_admin'),
						"desc" => __("<p>The logo uploader uses the default wp image uploading function, and once you see the image dialogue box after the upload - where you can set the image caption, alt title and other attributes, click on <em>Use This</em> at the bottom of the image dialogue box and you will see your image appearing in this custom logo area.&nbsp;&nbsp;If you want your site pages to load quicker, we suggest you use a jpeg image instead of a png image due to the lighter weight of jpegs. </p><p><EM>HINT:</EM>&nbsp;&nbsp;Do remember that if you remove the image, it will not be deleted from your media libary unless you go to the media library and delete the image permanently.</p> ",'theme_admin'),
						"id" => "logo",
						"default" => "",
						"type" => "upload"
					),
					array(
						"name" => __("Display Site Tagline",'theme_admin'),
						"desc" => sprintf(__('<p> You can choose whether to display <a href="%s/wp-admin/options-general.php" target="_blank">Tagline</a> - an additional brief line of descriptive text often used for catchphrase or slogan purposes, that appears just below the Site Title or you can deactivate it using this setting by moving the toggle to the <em>OFF</em> position. </p>','theme_admin'),get_option('siteurl')),		
						"id" => "display_site_desc",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Logo and/or Tagline Bottom Spacing",'theme_admin'),	
						"desc" => __(" <p>This setting is for creating the amount of gap between the bottom of the logo, and the navigation menu and feature header area below the logo.&nbsp;&nbsp;If you have no Tagline, the spacing starts from the bottom of the Site Title or Logo.&nbsp;&nbsp;If you have a Tagline, then the spacing starts from the bottom of it.</p><p>This setting is useful as once you start to build a main navigation menu with more top level items, it will space out left towards the logo area (which is left aligned in the header area), and you will find you will need to adjust the bottom spacing in order for they not to infringe upon each other.</p>",'theme_admin'),		
						"id" => "logo_bottom",
						"min" => "-50",
						"max" => "80",
						"step" => "1",
						"unit" => 'px',
						"default" => "20",
						"type" => "range"
					),
					array(
						"name" => __("Header Top Area",'theme_admin'),
						"desc" => sprintf(__("<p>Striking provides the ability to have a widget area in the top right section of the header area. &nbsp;&nbsp; You have 3 choices:</p><p><strong>1 -</strong> <u>to show the wpml flags</u> if you are using the wordpress multi-language plugin ->Striking has auto language detection coded into it for wpml so that the wpml flag widget is not necessary if you choose this option.<br /><br /><strong>2 -</strong> <u>to set it as a Widget Area</u> in which case you go to <a href='%s/wp-admin/widgets.php' target='_blank'>Appearence -> Widgets</a> and you will see a new Header Widget Area Sidebar appear for you to insert a widget into it.<br /><br /><strong>3 -</strong> <u>set the area to the html mode</u> in which case you can style the <b>Header Top Area Html Code</b> field below to hold whatever content you wish and appear per your styling.&nbsp;&nbsp;The html mode was included into Striking at the request of designers who use our theme for their client sites, and is only recommended for users with a good understanding of html coding.&nbsp;&nbsp;However, there are a number of threads in the Striking support forum on styling the header widget area in html mode which may assist the novice coder on styling this area.</p><p><em>HINT 1:</em>&nbsp;&nbsp; If you wish to have different widgets or content side by side in the header widget area, you should set it to the html mode, and then use either divs, or column or layout shortcodes, and then place your contnet, and widget shortcodes into the columns.</p><p><em>HINT 2:</em>&nbsp;&nbsp; An easy way to build your content for this field when in HTML mode is to do so in a page content editor, and then cut and paste it into this field.</p>",'theme_admin'),get_option('siteurl')),
						"id" => "top_area_type",
						"default" => '',
						"options" => array(
							"html" => __('Html','theme_admin'),
							"wpml_flags" => __('Wpml Flags','theme_admin'),
							"widget" => __('Widget Area','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Header Top Area Html Code",'theme_admin'),
						"desc" => __("<p>In html mode this area accepts Striking shortcodes and html.&nbsp;&nbsp; An easy way to use this area is to create the content in the wp editor on a test page or post and then cut and paste it into this field. &nbsp;&nbsp;Use either layout or column shortcodes, or divs, to space out your content horizontally.</p><p>Remember that one usually does not want to enlarge the header height too much as it pushed the main content area further down the page, so this area is typically most suitable for compact items such as social icons, a search field, extra navigation links, multi-language flags, etc.</p>",'theme_admin'),		
						"id" => "top_area_html",
						"default" => "",
						'rows' => '3',
						"type" => "textarea"
					),
					array(
						"name" => __("Sticky Header",'theme_admin'),
						"desc" => __("<p>This function fixes the header area including the navigation menu so that as one scrolls down the page, the header remains fixed to the top of the page view and always remains in sight.</p>",'theme_admin'),
						"id" => "stricky_header",
						"default" => false,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => 'navigation',
				"name" => __("Navigation Menu Options",'theme_admin'),	
				"options" => array(
					array(
						"name" => __("Activate Top Level Navigation Button Style Appearence",'theme_admin'),
						"desc" => sprintf(__('<p>This setting creates a button type look for your top level navigation. &nbsp;&nbsp;To be effective you also have to go to the <a href="%1s" target="_blank">Striking -> Color</a> Panel and give your <strong>Top Level Menu Background Color</strong> a color.</p><p><em>BONUS:</em>&nbsp;&nbsp;&nbsp;&nbsp;Striking includes complete array of Call-To-Action active hover scripting for navigation, thus if you want the navigation buttons to change color when you hover over them, then also select a color in the <a href="%2s" target="_blank">Top Level Menu Hover Background Color</a>.&nbsp;&nbsp;You can also select colors for the text in both hover and non-hover states, and more, in the Color Panel - Header Settings.</p>','theme_admin'),admin_url( 'admin.php?page=theme_color&tab=header'),admin_url( 'admin.php?page=theme_color&tab=header')),	
						"id" => "nav_button",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Activate Top Level Navigation Parent Arrow Appearence Feature",'theme_admin'),
						"desc" => __("<p>If this setting is toggled <em>ON</em>, the navigation will display a arrow pointing down on the right side of the top level menu text if there are sub-navigation children. &nbsp;&nbsp;So it is particularly useful combined with the button effect in order to alert the site viewer that there are child pages to each top level navigation item. &nbsp;&nbsp;(Only works on wp 3.2 + for Wordpress buit-in Menu and wp 3.3 + for Wordpress Page Menu).</p>",'theme_admin'),	
						"id" => "nav_arrow",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Activate Wordpress Custom Menu Functionality",'theme_admin'),
						"desc" => sprintf(__("<p>If this option is <em>ON</em>, you can control the site’s menus with the new <a href='http://codex.wordpress.org/Appearance_Menus_Screen' target='_blank'>WordPress Custom Navigation Menu</a>  features, which provide the ability to do drag and drop menu ordering, custom titles to pages, hide some pages, add categories, tags and other items to menus, and more. </p><p> Striking allows for a custom navigation menu for Main Navigation, and another for the Sub-Footer via the <a href='%1s' target='_blank'>Sub-Footer Widget Area Type</a> set to <em>Menu</em>.</p> <p>HINT:&nbsp;&nbsp; One can create an unlimited number of other custom menus and display them using the Custom Navigation widget. &nbsp;&nbsp;Go here to start creating custom menus: <a href=\'%2s/wp-admin/nav-menus.php\' target='_blank'>Custom Menu Creation</a> </p>",'theme_admin'),admin_url( 'admin.php?page=theme_footer&tab=sub'),get_option('siteurl')),	
						"id" => "enable_nav_menu",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Exclude Site Pages From Striking Default Menu",'theme_admin'),
						"desc" => __("<p>If one is using the default Striking &#34;Built-in&#34; menu for site menu display, but wants to hide certain pages from appearing in the navigation, one selects the pages to exclude below. &nbsp;&nbsp;Hold down the Cntrl key on your keyboard to select multiple items (similar to how one would select multiple items on a desktop).</p>",'theme_admin'),	
						"id" => "excluded_pages",
						"default" => array(),
						"page" => '0',
						"prompt" => __("Choose page..",'theme_admin'),
						"chosen" => "true",
						"type" => "multiselect",
					),
				),
			),
			array(
				"slug" => 'page',
				"name" => __("General Page Layout Settings",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Set to a Boxed Layout Appearence",'theme_admin'),
						"desc" =>__("<p>This setting converts the site to a boxed layout type appearence, where the header and footer areas are constrained to the same width as the page body area, rsulting in a top-to-bottom &#34;column&#34; look for the site.</p><p><em>NOTE:</em>&nbsp;&nbsp; &nbsp;&nbsp;In box mode the site content width is 1000px.</p><p><em>HINT:</em>&nbsp;&nbsp;Striking features many specific settings for the box mode, including even the ability to set separately a box mode only for the blog page of the site if on so desires by way of the <b>Blog Box Frame Layout</b> setting as well as settings in the Striking Background panel and Striking Color panel specific to boxed layout usage.</p> ",'theme_admin'),	
						"id" => "enable_box_layout",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Set a Default Page Layout",'theme_admin'),
						"desc" => "<p>Striking has 3 possible default Page Templates:</p><p>1 - Full Width <br />2 - Left Sidebar<br />3 - Right Sidebar</p><p>Although one can always select the page layout on a page-by-page basis using the <strong>Template</strong> setting, setting a default page template saves one having to set the layout everytime one creates a page.</p><p>Of course in Striking one can always override the default template by selecting another in the drop down selector in the <strong>Template</strong> Setting each time one creates or edits a page, so one is never restricted. &nbsp;&nbsp;This <strong>Set a Default Page Layout</strong> ability is provided to reduce the amount of work in page creation and editing.</p>",
						"id" => "layout",
						"default" => 'right',
						"options" => array(
							"full" => __('Full Width','theme_admin'),
							"right" => __('Right Sidebar','theme_admin'),
							"left" => __('Left Sidebar','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Load a Custom Favicon",'theme_admin'),
						"desc" => __("Paste the full URL (include <code>http://</code>) of your custom favicon here, or you can upload the icon by using the Upload Icon button below. &nbsp;&nbsp;Please note that while the WP default image uploading routine will give you the option of selecting something from the media library, in fact you always have to upload the image from your desktop - selecting something in the media library will not work for this Striking feature. &nbsp;&nbsp;If you don't like the favicon you uploaded, use the Remove Image button to remove it, and upload another. <br /><br />Be advised that if you remove a favicon, the image will still remain in the media library, so if one is cycling through a variety of potential favicons, one may wish to go to the media library and permanently delete the images not used in order to reduce media library clutter.<br /><br />The standard favicon size is 16px by 16 px and there are many free web resources available for assisting in creating a favicon. &nbsp;&nbsp;Also be advised some browsers do not support favicons.",'theme_admin'),
						"id" => "custom_favicon",
						"default" => '',
						"button" => 'Upload Icon',
						"type" => 'upload',
						"imagewidth" => '16',
					),
					array(
						"name" => __("Enable the Striking Feature Header Site Wide",'theme_admin'),
						"desc" => __("<p>If this option is set to ON, you'll globally enable your website's Feature Header Area which is the area just below the navigation typically used for display of media (such as the big slider) or information.&nbsp;&nbsp;So the default position for this setting is such that normally the Featured Header Area is not showing.&nbsp;&nbsp;The default is this way as Striking also allows for the determination of the Feature Header area on a per page/post basis and the setting to do this is found in the <strong>Striking General Page Options</strong> metabox which is one of the metaboxes found below the wp content editor.</p><p>This is a legacy setting as Striking has since over time introduced a wide variety of settings allowing for full control and manipulation of the feature header area by way of the various options in the <strong>Feature Header Type</strong> setting found in the Striking Page General Options metabox -> Feature Header Settings tab.</p>",'theme_admin'),
						"id" => "introduce",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"name" => __("Disable Breadcrumbs Site Wide",'theme_admin'),
						"desc" => __("<p>Striking has built into its core code the very well known <em>Breadcrumbs Plus</em> plugin -> so it is not necessary to load this plugin separately. The purpose of this setting if turned <em>ON</em> is to globally <u>disable</u> the website's breadcrumb navigation.&nbsp;&nbsp;So the default position which is <em>OFF</em> is that breadcrumbs automatically show throughout the site.</p><p><em>OTHER INFO</em> - Breadcrumbs do not appear on the homepage of a site, and the breadcrumb string will depend on how one has set the site permalinks. &nbsp;&nbsp;The breadcrumb placement in Striking is in the upper left hand corner of the page body section of all other pages and posts. &nbsp;&nbsp;Typically each navigation layer other then the present page is a clickable link in the breadcrumb string.</P>",'theme_admin'),
						"id" => "disable_breadcrumb",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Enable default lightbox for all images sitewide",'theme_admin'),
						"desc" => __("<p>We normally suggest leaving this setting off! &nbsp;&nbsp;However, it is useful if one typically uses the wordpress Add Media function to put an image into content (rather then using the Striking Image Shortcode), and wants the images to automatically have the ability to open in a lightbox by defauIt.</p>",'theme_admin'),
						"id" => "lightbox_rel_replace",
						"default" => false,
						"type" => "toggle"
					),
					array(
						"name" => __("Scroll to Top ",'theme_admin'),
						"desc" => __("<p>If this option is <em>ON</em>, a nice scroll to top button (round circle with an upwards pointing arrow in the circle center) will be in place at the bottom right corner of site pages, posts, etc. &nbsp;&nbsp;This feature is very useful if one has long site pages due to content or long sidebars.</p>",'theme_admin'),
						"id" => "scroll_to_top",
						"default" => false,
						"type" => "toggle"
					),
				),
			),	
			array(
				"slug" => 'analytics',
				"name" => __("Google Analytics Code Settings",'theme_admin'),
				"options"=> array(
					array(
						"name" => __("Choose where to load the Google Analytics Javascript",'theme_admin'),
						"desc" => __("<p>This setting allows the ability to have the google analytics code loaded either in the header or the footer area.&nbsp;&nbsp;Typically a site has it load in the header per google recommendations but there are certain exceptions where it is more desirable for it to be loaded in the footer.</p>",'theme_admin'),
						"id" => "analytics_position",
						"default" => 'bottom',
						"options" => array(
							"header" => __('Header','theme_admin'),
							"bottom" => __('Bottom','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Google Analytics Code",'theme_admin'),
						"desc" => __("<p>Paste the <a href='http://www.google.com/analytics/' target='_blank'>analytics code</a> here, and it will get applied to each page in the site automatically.</p>",'theme_admin'),
						"id" => "analytics",
						"default" => "",
						"type" => "textarea"
					),
				),
			),
			
			array(
				"slug" => 'custom',
				"name" => __("Custom CSS & JS Fields",'theme_admin'),
				"options"=> array(
					array(
						"name" => __("Custom CSS",'theme_admin'),
					"desc" => __("<p>This field is where one can post any custom css to override the default css of the theme.&nbsp;&nbsp;The Striking default css is found in the screen.css file in the CSS folder (Striking/CSS/screen.css) and you can open that file with an editor such as Notepad ++ or Dreamweaver to review it. &nbsp;&nbsp;One can also use browser tools such as Firebug and Web Developer to detect all the individual code elements of a webpage, and these tools allow for live editing > you can take that custom code from the live editing and paste it in this field to duplicate the effect achieved.</p><p>The Striking Support Forum has thousands of threads containing simple custom css snippets that allow one to change the appearence and position of many elements in an advanced way, beyond what is practical for a traditional theme setting. &nbsp;&nbsp;You would take those snippets and copy and paste them into the field below.</p><p><strong>The content of the field below is stored in your site database, and so it is unaffected by Striking theme updates.</strong> &nbsp;&nbsp;So <u>the use of this field for custom css eliminates the need for hardcoding css changes in theme files, and also makes use of a child theme unnecessary if only creating custom CSS.</u></p><p> However, it is always a good idea to have pasted the content below into a text document and store this on your local machine or somewhere else other then your website host so that you have an independent backup, since a database can be compromised due to other circumstances.</p>",'theme_admin'),	
						"id" => "custom_css",
						"default" => "",
						'rows' => '15',
						"type" => "textarea"
					),
					array(
						"name" => __("Custom JS",'theme_admin'),
						"desc" => sprintf(__('<p>This field has the same type of ability as the above CSS field, and again code in here is stored in the database, and unaffected by theme updates. &nbsp;The code input here will display on the footer of the page. Sample: </p><p><code>&lt;script type=&quot;text/javascript&quot; src=&quot;%s/wp-content/themes/striking/js/yourscript.js&quot;&gt;&lt;/script&gt;</code><br/>
<code>&lt;script type=&quot;text/javascript&quot;&gt;alert("hello world");&lt;/script&gt;</code></p>','theme_admin'),get_option('siteurl')),
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
