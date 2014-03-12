<?php
class Theme_Options_Page_Font extends Theme_Options_Page_With_Tabs {
	public $slug = 'font';
	public $cufon_fonts = false;
	public $fontface_fonts = false;

	function __construct(){
		if(isset($_GET['page']) && $_GET['page']=='theme_font'){
			add_filter('admin_head', array(&$this, 'add_scripts'));
		}
		$this->name = sprintf(__('%s Font Settings','striking_admin'),THEME_NAME);
		parent::__construct();
	}
	function add_scripts(){
		$http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";
		wp_enqueue_script('WebFont',$http.'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js');
		wp_enqueue_script( 'cufon-yui', THEME_JS .'/cufon-yui.js');

		$fontface_string_array = array();
		$fontface_fonts = $this->get_fontface_fonts();
		if(!empty($fontface_fonts)){
			foreach($fontface_fonts as $value => $font){
				$fontface_string_array[$value] = '"'.$value.'":{name:"'.$font['name'].'",url:"'. $font['url'] .'"}';
			}
		}
		$fontface_string = implode(",",$fontface_string_array);

		$cufon_string_array = array();
		$cufon_fonts = $this->get_cufon_fonts();
		if(!empty($cufon_fonts)){
			foreach($cufon_fonts as $value => $font){
				$cufon_string_array[$value] = '"'.$value.'":{name:"'.$font['font_name'].'",url:"'. $font['url'] .'"}';
			}
		}
		$cufon_string = implode(",",$cufon_string_array);

		$fontface_used = theme_get_option_from_db('font','fontface_used');
		$fontface_used_url_array = array();
		$fontface_used_url_list = '[]';
		if(!empty($fontface_used)){
			foreach($fontface_used as $value){
				$font = $this->get_fontface_font($value);
				$fontface_used_url_array[] = "'".$font['url']."'";
			}
			$fontface_used_url_list = '['.implode(',', $fontface_used_url_array).']';
		}
		
		$cufon_used = theme_get_option_from_db('font','cufon_used');
		if(!empty($cufon_used)){
			foreach($cufon_used as $value){
				$font = $this->get_cufon_font($value);
				wp_enqueue_script($font['file_name'], $font['url'], array('cufon-yui'));
			}
		}
		

		$gfont_used = theme_get_option_from_db('font','gfont_used');
		$gfont_used_array = array();
		$gfont_used_list = '[]';
		if(!empty($gfont_used)){
			foreach($gfont_used as $value){
				$gfont_used_array[] = "'".$value."'";
			}
			$gfont_used_list = '['.implode(',', $gfont_used_array).']';
		}
		echo <<<SCRIPTS
<script>
var fontface_list = {
	{$fontface_string}
};
var cufon_list = {
	{$cufon_string}
};
var fontface_used_url_list = {$fontface_used_url_list};
var gfont_used_list = {$gfont_used_list};
jQuery(document).ready(function($) {
	jQuery.each(fontface_used_url_list,function(i,url){
		var wf = document.createElement("link");
		wf.href = url;
		wf.rel = "stylesheet";
		wf.type = "text/css";
		wf.async = "true";
		var s = document.getElementsByTagName("style")[0];
		s.parentNode.insertBefore(wf, s);
	});
	
	if(gfont_used_list.length != 0){
		WebFont.load({
			google: {
				families: gfont_used_list
			}
		});
	}
	
	jQuery('.toggle-default').live('change',function(){
		if(jQuery(this).is(':checked')){
			jQuery(this).closest('li').siblings().find('input:checked').attr('checked', false).trigger('change');
		}
	});
	jQuery('.theme-font-cufon-preview').each(function(){
		var font = $(this).attr('data-font');
		Cufon.replace(this,{fontFamily: font});
	});
});
</script>
SCRIPTS;
	}
	function tabs(){
		$options = array(
			array(
				"slug" => 'general',
				"name" => __("General Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Site Font family",'striking_admin'),
						"desc" => __("<p>This dropdown contains a list of 9 standard web fonts that are the core fonts for Striking.&nbsp;&nbsp;Which ever font you select will be the font you will see across your entire site for both body text and descriptive text (such as headers, navigation labels, post titles, etc).</p><p>In Striking, one has the alternative of using one of the many custom Cufon, Fontface or Google fonts supplied for either custom replacement of selective descritive and/or body text by way of custom css, or by enabling the custom font fully across all descriptive text types via the Font settings for each custom font.</p><p>If one full enables a custom font for descriptive text in a site, all body text types such as standard paragraph text, slider description text, widget body text, etc will still be in the standard font chosen here, unless you choose to replace the standard body font with custom css.</p>",'striking_admin'),	
						"id" => "font_family",
						"default" => '"Lucida Sans Unicode","Lucida Grande",Garuda,sans-serif',
						"options" => array(
							"Arial,Helvetica,Garuda,sans-serif" => 'Arial,Helvetica,Garuda,sans-serif',
							"'Arial Black',Gadget,sans-serif" => '"Arial Black",Gadget,sans-serif',
							"Verdana,Geneva,Kalimati,sans-serif" => 'Verdana,Geneva,Kalimati,sans-serif',
							"'Lucida Sans Unicode','Lucida Grande',Garuda,sans-serif" => '"Lucida Sans Unicode","Lucida Grande",Garuda,sans-serif',
							"Georgia,'Nimbus Roman No9 L',serif" => 'Georgia,"Nimbus Roman No9 L",serif',
							"'Palatino Linotype','Book Antiqua',Palatino,FreeSerif,serif" => '"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif',
							"Tahoma,Geneva,Kalimati,sans-serif" => 'Tahoma,Geneva,Kalimati,sans-serif',
							"'Trebuchet MS',Helvetica,Jamrul,sans-serif" => '"Trebuchet MS",Helvetica,Jamrul,sans-serif',
							"'Times New Roman',Times,FreeSerif,serif" => '"Times New Roman",Times,FreeSerif,serif',
						),
						"type" => "select",
					),
					array(
						"name" => __("Line height",'striking_admin'),
						"desc" => "",
						"id" => "line_height",
						"min" => "12",
						"max" => "30",
						"step" => "1",
						"unit" => 'px',
						"default" => "20",
						"type" => "range"
					),
					array(
						"name" => __("Link Hover Underline",'striking_admin'),
						"desc" => __("<p>Enabling this setting will cause all web links listed in body text to be underlined.<p>",'striking_admin'),	
						"id" => "link_underline",
						"default" => false,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => 'size',
				"name" => __("Font Size Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Logo Text Size",'striking_admin'),
						"desc" => "",
						"id" => "site_name",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "40",
						"type" => "range"
					),
					array(
						"name" => __("Logo Tagline Size",'striking_admin'),
						"desc" => "",
						"id" => "site_description",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "11",
						"type" => "range"
					),
					array(
						"name" => __("Top Level Navigation Menu Text Size",'striking_admin'),
						"desc" => "",
						"id" => "menu_top",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "17",
						"type" => "range"
					),
					array(
						"name" => __("Sub Level Navigation Menu Text Size",'striking_admin'),
						"desc" => "",
						"id" => "menu_sub",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "14",
						"type" => "range"
					),
					array(
						"name" => __("Feature Header Title Size",'striking_admin'),
						"desc" => "",
						"id" => "feature_header",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "42",
						"type" => "range"
					),
					array(
						"name" => __("Feature Header Custom Title Text Size",'striking_admin'),
						"desc" => "",
						"id" => "feature_introduce",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "21",
						"type" => "range"
					),
					array(
						"name" => __("Accordion Slider Non-Hover Caption Text Size",'striking_admin'),
						"desc" => __("<p>This setting allows one to adjust the Accordion Slider caption text size as it appears when a slider loads on a page and the slider is cycling between slides.&nbsp;&nbsp;So with this setting you decide the text size that will appear during the regular aspects of the slideshow.&nbsp;&nbsp;In the <b>On-Hover Caption</b> setting below, you have the ability to decide the size of this caption text when a user cursor hovers over the slide image.</p><p>You create the Accordion Slider caption using the <b>Slide Caption</b> field in the <b>Striking Slider Options ->Slider Item Options</b> metabox found below the slide post content editor on any slide you are editing.",'striking_admin'),	
						"id" => "kwick_title",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "16",
						"type" => "range"
					),
					array(
						"name" => __("Accordion Slider On-Hover Caption Text Size",'striking_admin'),
						"desc" => __("<p>This setting allows one to adjust the Accordion Slider caption text size as it appears when a viewer cursor is hovering over the slide - in Striking this slider caption has a mode where typically one will have the caption expand in size on slide hover in order to grab the attention of the viewer.&nbsp;&nbsp;So with this setting you decide the on-slide hover expansion text size.</p><p>You create the Accordion Slider caption using the <b>Slide Caption</b> field in the <b>Striking Slider Options ->Slider Item Options</b> metabox found below the slide post content editor on any slide you are editing.",'striking_admin'),	
						"id" => "kwick_detail_header",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "24",
						"type" => "range"
					),
					array(
						"name" => __("Accordion Slider Description Text Size",'striking_admin'),
						"desc" => __("<p>This setting allows one to adjust the size of the text for the Accordion Slider description.&nbsp;&nbsp;You create the Accordion Slider description using the <b>Description</b> field in the <b>Striking Slider Options ->Slider Item Options</b> metabox found below the slide post content editor on any slide you are editing.</p>",'striking_admin'),	
						"id" => "kwick_desc",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Anything Slider Caption Text Size",'striking_admin'),
						"desc" => __("<p>This setting allows one to adjust the size of the text for the Anything Slider caption.</p>",'striking_admin'),	
						"id" => "anything_caption",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "24",
						"type" => "range"
					),
					array(
						"name" => __("Anything Slider Description Text Size",'striking_admin'),
						"desc" => __("<p>This setting allows one to adjust the size of the text for the Anything Slider description.&nbsp;&nbsp;You create the Anything Slider description using the <b>Description</b> field in the <b>Striking Slider Options ->Slider Item Options</b> metabox found below the slide post content editor on any slide you are editing.</p>",'striking_admin'),	
						"id" => "anything_desc",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Page Body Text Size",'striking_admin'),
						"desc" => __("<p>Body text includes text in a page or post body, widget body, description text of a slider item, normal text variations such as bold, sub and superscript, emphasized, etc.</p>",'striking_admin'),	
						"id" => "page",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Breadcrumbs Text Size",'striking_admin'),
						"desc" => "",
						"id" => "breadcrumbs",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "11",
						"type" => "range"
					),
					array(
						"name" => sprintf(__("%s Size",'striking_admin'),'H1'),
						"desc" => "",
						"id" => "h1",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "36",
						"type" => "range"
					),
					array(
						"name" => sprintf(__("%s Size",'striking_admin'),'H2'),
						"desc" => "",
						"id" => "h2",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "30",
						"type" => "range"
					),
					array(
						"name" =>  sprintf(__("%s Size",'striking_admin'),'H3'),
						"desc" => "",
						"id" => "h3",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "24",
						"type" => "range"
					),
					array(
						"name" =>  sprintf(__("%s Size",'striking_admin'),'H4'),
						"desc" => "",
						"id" => "h4",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "18",
						"type" => "range"
					),
					array(
						"name" =>  sprintf(__("%s Size",'striking_admin'),'H5'),
						"desc" => "",
						"id" => "h5",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "14",
						"type" => "range"
					),
					array(
						"name" =>  sprintf(__("%s Size",'striking_admin'),'H6'),
						"desc" => "",
						"id" => "h6",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Blog Post Title Size",'striking_admin'),
						"desc" => "",
						"id" => "entry_title",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "36",
						"type" => "range"
					),
					array(
						"name" => __("Portfolio Post Title Size",'striking_admin'),
						"desc" => "",
						"id" => "portfolio_title",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "24",
						"type" => "range"
					),
					array(
						"name" => __("Portfolio Description Text Size",'striking_admin'),
						"desc" => "",
						"id" => "portfolio_desc",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Sidebar Widget Title",'striking_admin'),
						"desc" => "",
						"id" => "widget_title",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "24",
						"type" => "range"
					),
					array(
						"name" => __("Footer Text Size",'striking_admin'),
						"desc" => "",
						"id" => "footer_text",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Footer Widget Title Size",'striking_admin'),
						"desc" => "",
						"id" => "footer_title",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "24",
						"type" => "range"
					),
					array(
						"name" => __("Copyright Text Size",'striking_admin'),
						"desc" => "",
						"id" => "copyright",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "14",
						"type" => "range"
					),
					array(
						"name" => __("Footer Menu Text Size",'striking_admin'),
						"desc" => __("<p>This font size sets the size of navigation labels if one has enable the sub footer widget area for Navigation and created a footer menu in the Striking Custom Menu function.</p>",'striking_admin'),	
						"id" => "footer_menu",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
				),
			),
			array(
				"slug" => 'cufon',
				"name" => __("Cufon Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Enable Cufon Font",'striking_admin'),
						"desc" => __("<p>Cufon is a font-replacement technique that uses javascript and vector graphics to write fonts from a font file (TTF, OTF or PFB) to your browser.&nbsp;&nbsp;Many interesting free and paid variations of Cufon are available and Striking includes 45 royalty free Cufon fonts for your use.</p><p>Cufon is very popular but as js has changed, some of the royalty free fonts don't always render correctly in the newest versions of some browsers (support for the js techniques that Cufon uses is up to the browsers and changes with every update). &nbsp;&nbsp;Sometimes one will experience, depending on the browswer, what is commonly known as the <em>Cufon Delay.</em> &nbsp;&nbsp;In this situation a page loads, and as one of the very last steps in the page loading process when java scripting typically take place, the process of replacing the web font with Cufon is executed, sometimes with a visible margin of delay. &nbsp;&nbsp; Should this occur and you dislike it, the choice is to select a different Cufon or other font type for use in your site.</p><p><b>USAGE IN STRIKING:</b></p><p><u>Step 1</u> is to enable the potential for Cufon with this setting - you are turning on Cufon, but not yet making it active in replacement of any text within the site. &nbsp;&nbsp;<b>VERY IMPORTANT - SAVE THE PANEL AFTER THIS STEP.  DO NOT PROCEED TO STEP 2 UNTIL YOU HAVE SAVED THIS SETTING!</b></p><p><u>Step 2</u> is to choose a cufon font in the <b>Choose Cufon</b> setting below - selecting a cufon font makes that specific font now available for usage, but still not actively replacing any text in the site as it has not been told what to replace.</p><p>Once one has made available a cufon font one has two choices:</p><p>1) Use custom css pasted into the <b>Cufon Custom CSS Code Field</b> below to selectively replace the regular web font where one desires (samples are provided in its help field), or</p><p>2) Turn <em>ON</em> the setting for <b>Enable Cufon Replacment for all Descriptive Text Types</b> (this field is ajaxed and only appears once you have chosen a font in Step 2 above) in which case your selected Cufon Font will replace the standard web font chosen for the site with the selected Cufon Font for all the descriptive font places in Striking (see help field for the list and also some special instructions on what not to do!).</p>",'striking_admin'),		
						"id" => "cufon_enabled",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"id" => "cufon_used",
						"name" =>__('Choose Cufon Font',"striking_admin"),
						"desc" => __("<p>Click in the field with your cursor and choose a font.&nbsp;&nbsp;One may have more then one Cufon font active at the same time, each being used for various web font replacements as well as one being the default font for most descriptive replacement in that setting below.</p><p>Choose multiple fonts by holding down the Cntrl key on your keyboard while scrolling and clicking the fonts in the list, just as you would do to select multiple items on your desktop computer.</p> ",'striking_admin'),
						"default" => array(),
						"prompt" => __("Choose Cufon font..","striking_admin"),
						"type" => "fontchosen",
						"options"=> $this->get_cufon_fonts_list(),
						"preview_callback" => 'function(element, font){
	if(cufon_list[font.value] === undefined){
		return;
	}
	var url = cufon_list[font.value].url;
	var loaded = jQuery(element).data("loaded");
	if(loaded == undefined){
		loaded = [];
	}
	
	if(jQuery.inArray(url,loaded) < 0){
		loaded.push(url);
		
		var wf = document.createElement("script");
		wf.src = url;
		wf.type = "text/javascript";
		wf.async = "true";
		wf.onload = function(){
			Cufon.replace(element,{fontFamily: cufon_list[font.value].name});
		};
		var s = document.getElementsByTagName("script")[0];
		s.parentNode.insertBefore(wf, s);
		jQuery(element).data("loaded",loaded);
	}else{
		Cufon.replace(element,{fontFamily: cufon_list[font.value].name});
	}
};',
					),	
					array(
						"name" => __("Cufon Custom CSS Code Field",'striking_admin'),
						"desc" => __('<p>One can selectively replace any web text in Striking, although typically one is usually replacing descriptive text of some sort.</p><p>Here is an example of two replacements, and in this example, notice that two separate Cufon fonts are used - one would have to have enabled both of these fonts in the <b>Choose Cufon Font</b> setting above.  Take either or both code snippets and copy and paste into the field below, and then change the font names to the name of the Cufon font you have chosen.</p><p><code>Cufon.replace("h1,h2,h3,h4,h5", {fontFamily : "Vegur"});</code></p><p><code>Cufon.replace("#site_name", {fontFamily : "Segan", color: \'-linear-gradient(white, black)\'});</code></p><p>For more code tips go to official <a href="http://wiki.github.com/sorccu/cufon/styling">Cufon\'s site</a></p>','striking_admin'),							"id" => "cufon_code",
						"default" => '',
						"id" => "cufon_code",
						"rows" => '8',
						"type" => "textarea"
					),
					array(
						"id" => "cufon_default",
						"name" =>__('Enable Cufon Replacment for all Descriptive Text Types',"striking_admin"),
						"desc" => __("<p>All Cufon fonts you have chosen to make available via the <b>Choose Cufon Font</b> setting above will appear below.&nbsp;&nbsp;Set the toggle to the <em>On</em> position for one of the fonts below, and it will replace all descriptive text types in your site after saving.</p><p><b>WARNING:</b> &nbsp;&nbsp;Do not activate more then one font as the font for replacing all descriptive types as it can lead to extremely unpredictable behaviour, and crash both your site and your browser! (ie, Doing stupid things leads to bad consequences -> you have been warned! (James aka Websys)).</p><p>The following are replaced by the Cufon font when you have activated this setting - this is not the actual script but just the names of the elements that are replaced taken from it:<br /><br /><code>(site_name, site_description, .kwick_title, .kwick_detail h3, footer h3, copyright, .dropcap1, .dropcap2, .dropcap3, .dropcap4, feature h1, introduce, portfolio_title, h1, h2, h3, h4, h5, h6, navigation a, .entry_title a, hover:true</code></p>",'striking_admin'),
						"layout" => false,
						"function" => "_option_cufon_fonts_function",
						"default" => '',
						"type" => "custom"
					),
				),
			),
			array(
				"slug" => 'fontface',
				"name" => __("@font-face Settings",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Enable @font-face",'striking_admin'),
						"desc" => __("<p>font-face is a font-replacement technique that uses a CSS rule to enable the viewing of a font on a Web page even if that font is not installed on the user's computer.</p><p><u>USAGE IN STRIKING:</u> &nbsp;The first step is to enable the potential for fontface with this setting - you are turning on fontface, but not yet making it active in replacement of any text within the site.&nbsp;&nbsp;Step 2 is to choose a fontface font in the <b>Choose @fontface Font</b> setting, which once you select a fontface font makes it an available fontface font for replacing some of the web font usage, but still not actively replacing any text in the site as it has not been told what to replace.&nbsp;&nbsp;Once one has made available a fontface font for replacement one has two choices:</p><p>1) Use custom css pasted into the <b>@fontface Custom CSS Code Field</b> below to selectively replace the regular web font where one desires (samples are provided in its help field), or</p><p>2) Turn <em>ON</em> the setting for <b>Enable @fontface Replacment for all Descriptive Text Types</b> (this field is ajaxed and only appears once you have chosen a font in Step 2 above)in which case your selected fontface font will replace the standard web font chosen for the site with the selected fontface font for all the descriptive font usages in Striking (see help field for the list).</p>",'striking_admin'),	
						"id" => "fontface_enabled",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"id" => "fontface_used",
						"name" =>__('Choose @font-face Font',"striking_admin"),
						"desc" => __("Click in the field with your cursor and choose a font.&nbsp;&nbsp;One may have more then one fontface font active at the same time, each being used for various web font replacements as well as one being the default font for most descriptive replacement in that setting below.&nbsp;&nbsp;Choose multiple fonts by holding down the Cntrl key on your keyboard while scrolling and clicking the fonts in the list, just as you would do to select multiple items on your desktop computer. ",'striking_admin'),
						"default" => array(),
						"prompt" => __("Choose fontface font..","striking_admin"),
						"chosen" => "true",
						"type" => "fontchosen",
						"preview_callback" => 'function(element, font){
	if(fontface_list[font.value] === undefined){
		return;
	}
	var url = fontface_list[font.value].url;
	var loaded = jQuery(element).data("loaded");
	if(loaded == undefined){
		loaded = [];
	}
	if(jQuery.inArray(url, loaded) < 0){
		loaded.push(url);
		
		var wf = document.createElement("link");
		wf.href = url;
		wf.rel = "stylesheet";
		wf.type = "text/css";
		wf.async = "true";
		var s = document.getElementsByTagName("style")[0];
		s.parentNode.insertBefore(wf, s);
		jQuery(element).data("loaded",loaded);
	}
	jQuery(element).css("font-family", "\'"+font.text+"\'");
};',
						"options"=> $this->get_fontface_fonts_list(),
					),
					array(
						"name" => __("@font-face Custom CSS Code Field",'striking_admin'),
						"desc" => __('One can selectively replace any web text in Striking, although typically one is usually replacing descriptive text of some sort.<br /><br />Here is an example of a replacement and you would take this code snippet and copy and paste into the field below, and then change the font name to the name of the fontface font you have chosen.<p><code>h1,h2,h3,h4,h5 { font-family:ColaborateLightRegular; }</code></p><p>For more code tips go to official <a href="http://www.fontsquirrel.com/">fontface site.</a>','striking_admin'),	
						"id" => "fontface_code",
						"default" => '',
						"rows" => '8',
						"type" => "textarea"
					),
					array(
						"id" => "fontface_default",
						"name" =>__('Enable a @font-face Replacment for all Descriptive Text Types',"striking_admin"),
						"desc" => __("<p>All fontface fonts you have chosen to make available via the <b>Choose @font-face Font</b> setting above will appear below.&nbsp;&nbsp;Set the toggle to the <em>On</em> position for one of the fonts below, and it will replace all descriptive text types in your site after saving.</p><p><b>WARNING:</b> &nbsp;&nbsp;Do not activate more then one font as the font for replacing all descriptive types as it can lead to extremely unpredictable behaviour, and crash both your site and your browser! (ie, Doing stupid things leads to bad consequences -> you have been warned! (James aka Websys)).</p><p>The following are replaced by the fontface font when you have activated this setting - this is not the actual script but just the names of the elements that are replaced taken from it:<br /><br /><code>(site_name, site_description, .kwick_title, .kwick_detail h3, footer h3, copyright, .dropcap1, .dropcap2, .dropcap3, .dropcap4, feature h1, introduce, portfolio_title, h1, h2, h3, h4, h5, h6, navigation a, .entry_title a, hover:true</code></p>",'striking_admin'),	
						"layout" => false,
						"function" => "_option_fontface_fonts_function",
						"default" => '',
						"type" => "custom"
					),
				),
			),
			array(
				"slug" => 'gfont',
				"name" => __("Google font Settings",'striking_admin'),
				"options" => array(
			
					array(
						"id" => "gfont_used",
						"name" =>__('Enable Google Font',"striking_admin"),
						'desc' =>__('<p>Below is a dropdown selectior with a list of over 600 google fonts for use in your site.&nbsp;&nbsp;If the font you desire is not in this list then go to <a href="http://www.google.com/webfonts" target="_blank">Google webfonts library</a> to check on the availability of the font from Google.</p>',"striking_admin"),
						"default" => array(),
						"prompt" => __("Choose google font..","striking_admin"),
						"chosen" => "true",
						"type" => "fontchosen",
						"preview_callback" => 'function(element, font){
	var loaded = jQuery(element).data("loaded");
	if(loaded == undefined){
		loaded = [];
	}
	if(jQuery.inArray(font.value, loaded) < 0){
		loaded.push(font.value);
		WebFont.load({
			google: {
				families: [font.value]
			}
		});
		jQuery(element).data("loaded",loaded);
	}
	jQuery(element).css("font-family", "\'"+font.value+"\'");
};',
						"options"=> $this->get_google_fonts(),
					),
	array(
						"name" => __("Google Font Custom CSS","striking_admin"),
						"desc" => __('<p>Font replacement CSS for Google Fonts can be fairly straightforward.&nbsp;&nbsp; Here is a sample code snippet for substituting for the header fonts with the google Droid Sans font into the website:<p><code>h1,h2,h3,h4,h5 { font-family:"Droid Sans"; }</code></p>',"striking_admin"),
						"id" => "gfont_code",
						"default" => '',
						"rows" => '8',
						"type" => "textarea"
					),
					array(
						"id" => "gfont_default",
						"name" =>__('Enable a Google Font Replacment for all Descriptive Text Types',"striking_admin"),
						"desc" => __("<p>All Google fonts you have chosen to make available via the <b>Choose Google Font</b> setting above will appear below.&nbsp;&nbsp;Set the toggle to the <em>On</em> position for one of the fonts below, and it will replace all descriptive text types in your site after saving.</p><p><b>WARNING:</b> &nbsp;&nbsp;Do not activate more then one font as the font for replacing all descriptive types as it can lead to extremely unpredictable behaviour, and crash both your site and your browser! (ie, Doing stupid things leads to bad consequences -> you have been warned! (James aka Websys)).</p><p>The following are replaced by the Google font when you have activated this setting - this is not the actual script but just the names of the elements that are replaced taken from it:<br /><br /><code>(site_name, site_description, .kwick_title, .kwick_detail h3, footer h3, copyright, .dropcap1, .dropcap2, .dropcap3, .dropcap4, feature h1, introduce, portfolio_title, h1, h2, h3, h4, h5, h6, navigation a, .entry_title a, hover:true</code></p>",'striking_admin'),
						"layout" => false,
						"function" => "_option_google_fonts_function",
						"default" => '',
						"type" => "custom"
					),
				),
			),
		);
		return $options;
	}
	function _option_fontface_fonts_function($item, $default) {
		$fonts =  theme_get_option('font','fontface_used');
		if(empty($fonts)){
			return;
		}
		echo '<li class="theme-page-option theme-font-set-default">';
		echo '<div class="theme-page-option-title"><h4><label for="'.$item['id'].'">' . $item['name'] . '</label></h4>';
		if(!empty($item['desc'])){
			echo '<a class="theme-page-option-switch" href="">[+] more info</a>'.
				'</div>'.
				'<div class="description">' . $item['desc'] . '</div>';
		}else{
			echo '</div>';
		}
		
		echo '<div class="theme-page-option-wrap">';
		echo '<ul>';
		$count = 1;
		foreach($fonts as $font){
			if($font == $default){
				$checked = ' checked="checked"';
			}else{
				$checked = '';
			}
			$font_array = $this->get_fontface_font($font);
			echo '<li>';
			echo '<input type="checkbox" name="'.$item['id'].'" class="toggle-button toggle-default" value="'.$font.'"'.$checked.'/>';
			echo '<div class="theme-font-set-default-preview">';
			echo '<textarea rows="1" style="font-family:'.$font_array['name'].'">'.$font_array['name'].'</textarea>';
			echo '</div>';
			echo '</li>';
			$count ++;
		}
		echo '</ul>';
		echo '</div>';
		echo '</li>';
	}
	function _option_cufon_fonts_function($item, $default) {
		$fonts =  theme_get_option('font','cufon_used');
		if(empty($fonts)){
			return;
		}
		echo '<li class="theme-page-option theme-font-set-default">';
		echo '<div class="theme-page-option-title"><h4><label for="'.$item['id'].'">' . $item['name'] . '</label></h4>';
		if(!empty($item['desc'])){
			echo '<a class="theme-page-option-switch" href="">[+] more info</a>'.
				'</div>'.
				'<div class="description">' . $item['desc'] . '</div>';
		}else{
			echo '</div>';
		}
		
		echo '<div class="theme-page-option-wrap">';
		echo '<ul>';
		$count = 1;
		foreach($fonts as $font){
			if($font == $default){
				$checked = ' checked="checked"';
			}else{
				$checked = '';
			}
			echo '<li>';
			$font_array = $this->get_cufon_font($font);
			echo '<input type="checkbox" name="'.$item['id'].'" class="toggle-button toggle-default" value="'.$font.'"'.$checked.'/>';
			echo '<div class="theme-font-set-default-preview">';
			echo '<div class="theme-font-cufon-preview" data-font="'.$font_array['font_name'].'">'.$font_array['font_name'].'</div>';
			echo '</div>';
			echo '</li>';
			$count ++;
		}
		echo '</ul>';
		echo '</div>';
		echo '</li>';
	}

	function _option_google_fonts_function($item, $default) {
		$fonts =  theme_get_option('font','gfont_used');
		if(empty($fonts)){
			return;
		}
		echo '<li class="theme-page-option theme-font-set-default">';
		echo '<div class="theme-page-option-title"><h4><label for="'.$item['id'].'">' . $item['name'] . '</label></h4>';
		if(!empty($item['desc'])){
			echo '<a class="theme-page-option-switch" href="">[+] more info</a>'.
				'</div>'.
				'<div class="description">' . $item['desc'] . '</div>';
		}else{
			echo '</div>';
		}
		
		echo '<div class="theme-page-option-wrap">';
		echo '<ul>';
		$count = 1;
		foreach($fonts as $font){
			if($font == $default){
				$checked = ' checked="checked"';
			}else{
				$checked = '';
			}
			echo '<li>';
			echo '<input type="checkbox" name="'.$item['id'].'" class="toggle-button toggle-default" value="'.$font.'"'.$checked.'/>';
			echo '<div class="theme-font-set-default-preview">';
			echo '<textarea rows="1" style="font-family:'.$this->get_google_font_name($font).'">'.$this->get_google_font_name($font).'</textarea>';
			echo '</div>';
			echo '</li>';
			$count ++;
		}
		echo '</ul>';
		echo '</div>';
		echo '</li>';
	}

	function _option_fonts_function($value, $default) {
		$fonts = $this->get_fontface_fonts();
		echo '<select class="font-selector">';
		foreach($fonts as $value => $font){
			echo '<option value="'.$value.'">'.$font['name'].'</option>';
		}
		echo '</select>';
		echo '<div class="font-tester-container"><textarea class="font-tester" rows="1"> This is Preview for the font. 0123456789</textarea></div>';
		/*
		$count = 1;
		
		foreach($fonts as $value => $font){
			if(is_array($default)){
				$checked = (in_array($value,$default) || array_key_exists($value,$default))?' checked="checked"':'';
			}else{
				$checked = '';
			}
			
			echo '<tr><td style="width:15%"><div class="font_name_wrap" style="position: relative;"><a class="fontface_font_name" href="#" title="'.$font['name'].'">'.$font['name'].'</a></div></td><td style="width:10%"><input type="checkbox" name="fonts[]" class="toggle-button" value="'.$value.'"'.$checked.'/></td><td><span class="fontface_preview" id="preview-'.$count.'">This is a preview of the <span style="color:  #379BFF;">'.$font['name'].'</span> font. Some numbers: 0123456789 &amp; so on..</span></td></tr>';
			$count ++;
		}
		echo '</tbody></table></td></tr>';
		*/
	}

	function get_google_fonts(){
		return array(
			"Abel"=>"Abel",
			"Abril Fatface"=>"Abril Fatface",
			"Aclonica"=>"Aclonica",
			"Acme"=>"Acme",
			"Actor"=>"Actor",
			"Adamina"=>"Adamina",
			"Advent Pro"=>"Advent Pro",
			"Advent Pro:100,200,300,400,500,600,700"=>"Advent Pro (plus all weights)",
			"Aguafina Script"=>"Aguafina Script",
			"Aladin"=>"Aladin",
			"Aldrich"=>"Aldrich",
			"Alex Brush"=>"Alex Brush",
			"Alfa Slab One"=>"Alfa Slab One",
			"Alice"=>"Alice",
			"Alike Angular"=>"Alike Angular",
			"Alike"=>"Alike",
			"Allan"=>"Allan",
			"Allerta Stencil"=>"Allerta Stencil",
			"Allerta"=>"Allerta",
			"Allura"=>"Allura",
			"Almendra SC"=>"Almendra SC",
			"Almendra"=>"Almendra",
			"Almendra:400,bold"=>"Almendra:400,bold",
			"Amaranth"=>"Amaranth",
			"Amatic SC"=>"Amatic SC",
			"Amatic SC:400,700"=>"Amatic SC:400,700",
			"Amethysta"=>"Amethysta",
			"Andada"=>"Andada",
			"Andika"=>"Andika",
			"Annie Use Your Telescope"=>"Annie Use Your Telescope",
			"Anonymous Pro"=>"Anonymous Pro",
			"Anonymous Pro:regular,italic,bold,bolditalic"=>"Anonymous Pro (plus italic, bold, and bold italic)",
			"Antic Didone"=>"Antic Didone",
			"Antic Slab"=>"Antic Slab",
			"Antic"=>"Antic",
			"Anton"=>"Anton",
			"Arapey"=>"Arapey",
			"Arapey:400,400italic"=>"Arapey:400,400italic",
			"Arbutus"=>"Arbutus",
			"Architects Daughter"=>"Architects Daughter",
			"Arimo"=>"Arimo",
			"Arimo:regular,italic,bold,bolditalic"=>"Arimo (plus italic, bold, and bold italic)",
			"Arizonia"=>"Arizonia",
			"Armata"=>"Armata",
			"Artifika"=>"Artifika",
			"Arvo"=>"Arvo",
			"Arvo:regular,italic,bold,bolditalic"=>"Arvo (plus italic, bold, and bold italic)",
			"Asap"=>"Asap",
			"Asap:400,400italic,700,700italic"=>"Asap (plus all weights and italics)",
			"Asset"=>"Asset",
			"Astloch"=>"Astloch",
			"Astloch:regular,bold"=>"Astloch (plus bold)",
			"Asul"=>"Asul",
			"Asul:400,bold"=>"Asul:400,bold",
			"Atomic Age"=>"Atomic Age",
			"Aubrey"=>"Aubrey",
			"Average"=>"Average",
			"Averia Gruesa Libre"=>"Averia Gruesa Libre",
			"Averia Libre"=>"Averia Libre",
			"Averia Libre:300,300italic,400,400italic,700,700italic"=>"Averia Libre (plus all weights and italics)",
			"Averia Sans Libre"=>"Averia Sans Libre",
			"Averia Sans Libre:300,300italic,400,400italic,700,700italic"=>"Averia Sans Libre (plus all weights and italics)",
			"Averia Serif Libre"=>"Averia Serif Libre", 
			"Averia Serif Libre:300,300italic,400,400italic,700,700italic"=>"Averia Serif Libre (plus all weights and italics)",
			"Bad Script"=>"Bad Script",
			"Balthazar"=>"Balthazar",
			"Bangers"=>"Bangers",
			"Basic"=>"Basic",
			"Baumans"=>"Baumans",
			"Belgrano"=>"Belgrano",
			"Bentham"=>"Bentham",
			"Berkshire Swash"=>"Berkshire Swash",
			"Bevan"=>"Bevan",
			"Bigshot One"=>"Bigshot One",
			"Bilbo Swash Caps"=>"Bilbo Swash Caps",
			"Bilbo"=>"Bilbo",
			"Bitter"=>"Bitter",
			"Bitter:400,400italic,700"=>"Bitter:400,400italic,700",
			"Black Ops One"=>"Black Ops One",
			"Bonbon"=>"Bonbon",
			"Boogaloo"=>"Boogaloo",
			"Bowlby One SC"=>"Bowlby One SC",
			"Bowlby One"=>"Bowlby One",
			"Brawler"=>"Brawler",
			"Bree Serif"=>"Bree Serif",
			"Bubblegum Sans"=>"Bubblegum Sans",
			"Buda:light"=>"Buda",
			"Buenard"=>"Buenard",
			"Buenard:400,bold"=>"Buenard:400,bold",
			"Butcherman"=>"Butcherman",
			"Butterfly Kids"=>"Butterfly Kids",
			"Cabin Condensed"=>"Cabin Condensed",
			"Cabin Condensed:400,500,600,700"=>"Cabin Condensed:400,500,600,700",
			"Cabin Sketch"=>"Cabin Sketch",
			"Cabin Sketch:bold"=>"Cabin Sketch Bold",
			"Cabin Sketch:regular,bold"=>"Cabin Sketch:regular,bold",
			"Cabin"=>"Cabin",
			"Cabin:regular,500,600,bold"=>"Cabin (plus 500, 600, and bold)",
			"Caesar Dressing"=>"Caesar Dressing",
			"Cagliostro"=>"Cagliostro",
			"Calligraffitti"=>"Calligraffitti",
			"Cambo"=>"Cambo",
			"Candal"=>"Candal",
			"Cantarell"=>"Cantarell",
			"Cantarell:regular,italic,bold,bolditalic"=>"Cantarell (plus italic, bold, and bold italic)",
			"Cantata One"=>"Cantata One",
			"Cardo"=>"Cardo",
			"Carme"=>"Carme",
			"Carter One"=>"Carter One",
			"Caudex"=>"Caudex",
			"Caudex:regular,italic,bold,bolditalic"=>"Caudex (plus italic, bold, and bold italic)",
			"Cedarville Cursive"=>"Cedarville Cursive",
			"Ceviche One"=>"Ceviche One",
			"Changa One"=>"Changa One",
			"Chango"=>"Chango",
			"Chelsea Market"=>"Chelsea Market",
			"Cherry Cream Soda"=>"Cherry Cream Soda",
			"Chewy"=>"Chewy",
			"Chicle"=>"Chicle",
			"Chivo"=>"Chivo",
			"Chivo:400,900"=>"Chivo (plus bold)",
			"Coda"=>"Coda",
			"Coda:400,800"=>"Coda:400,800",
			"Codystar"=>"Codystar",
			"Codystar:300,400"=>"Codystar (plus all weights)",
			"Comfortaa"=>"Comfortaa",
			"Comfortaa:300,400,700"=>"Comfortaa (plus book and bold)",
			"Coming Soon"=>"Coming Soon",
			"Concert One"=>"Concert One",
			"Condiment"=>"Condiment",
			"Contrail One"=>"Contrail One",
			"Convergence"=>"Convergence",
			"Cookie"=>"Cookie",
			"Copse"=>"Copse",
			"Corben"=>"Corben",
			"Corben:400,bold"=>"Corben:400,bold",
			"Corben:bold"=>"Corben Bold",
			"Cousine"=>"Cousine",
			"Cousine:regular,italic,bold,bolditalic"=>"Cousine (plus italic, bold, and bold italic)",
			"Coustard"=>"Coustard",
			"Coustard:400,900"=>"Coustard (plus ultra bold)",
			"Covered By Your Grace"=>"Covered By Your Grace",
			"Crafty Girls"=>"Crafty Girls",
			"Creepster"=>"Creepster",
			"Crete Round"=>"Crete Round",
			"Crete Round:400,400italic"=>"Crete Round:400,400italic",
			"Crimson Text"=>"Crimson Text",
			"Crushed"=>"Crushed",
			"Cuprum"=>"Cuprum",
			"Cutive"=>"Cutive",
			"Damion"=>"Damion",
			"Dancing Script"=>"Dancing Script",
			"Dawning of a New Day"=>"Dawning of a New Day",
			"Days One"=>"Days One",
			"Delius Swash Caps"=>"Delius Swash Caps",
			"Delius Unicase"=>"Delius Unicase",
			"Delius"=>"Delius",
			"Devonshire"=>"Devonshire",
			"Didact Gothic"=>"Didact Gothic",
			"Diplomata SC"=>"Diplomata SC",
			"Diplomata"=>"Diplomata",
			"Doppio One"=>"Doppio One",
			"Dorsa"=>"Dorsa",
			"Dr Sugiyama"=>"Dr Sugiyama",
			"Droid Sans Mono"=>"Droid Sans Mono",
			"Droid Sans"=>"Droid Sans",
			"Droid Sans:regular,bold"=>"Droid Sans (plus bold)",
			"Droid Serif"=>"Droid Serif",
			"Droid Serif:regular,italic,bold,bolditalic"=>"Droid Serif (plus italic, bold, and bold italic)",
			"Duru Sans"=>"Duru Sans",
			"Dynalight"=>"Dynalight",
			"EB Garamond"=>"EB Garamond",
			"Eater"=>"Eater",
			"Economica"=>"Economica",
			"Economica:400,400italic,700,700italic"=>"Economica (plus all weights and italics)",
			"Electrolize"=>"Electrolize",
			"Emblema One"=>"Emblema One",
			"Emilys Candy"=>"Emilys Candy",
			"Engagement"=>"Engagement",
			"Enriqueta"=>"Enriqueta",
			"Enriqueta:400,700"=>"Enriqueta:400,700",
			"Erica One"=>"Erica One",
			"Esteban"=>"Esteban",
			"Euphoria Script"=>"Euphoria Script",
			"Ewert"=>"Ewert",
			"Exo"=>"Exo",
			"Exo:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"=>"Exo (plus all weights and italics)",
			"Expletus Sans"=>"Expletus Sans",
			"Expletus Sans:regular,500,600,bold"=>"Expletus Sans (plus 500, 600, and bold)",
			"Fanwood Text"=>"Fanwood Text",
			"Fanwood Text:400,400italic"=>"Fanwood Text (plus italic)",
			"Fascinate Inline"=>"Fascinate Inline",
			"Fascinate"=>"Fascinate",
			"Federant"=>"Federant",
			"Federo"=>"Federo",
			"Felipa"=>"Felipa",
			"Fjord One"=>"Fjord One",
			"Flamenco"=>"Flamenco",
			"Flamenco:300"=>"Flamenco:300",
			"Flavors"=>"Flavors",
			"Fondamento"=>"Fondamento",
			"Fondamento:400,400italic"=>"Fondamento:400,400italic",
			"Fontdiner Swanky"=>"Fontdiner Swanky",
			"Forum"=>"Forum",
			"Francois One"=>"Francois One",
			"Fredoka One"=>"Fredoka One",
			"Fresca"=>"Fresca",
			"Frijole"=>"Frijole",
			"Fugaz One"=>"Fugaz One",
			"Galdeano"=>"Galdeano",
			"Gentium Basic"=>"Gentium Basic",
			"Gentium Basic:400,700,400italic,700italic"=>"Gentium Basic (plus bold and italic)",
			"Gentium Book Basic"=>"Gentium Book Basic",
			"Gentium Book Basic:400,400italic,700,700italic"=>"Gentium Book Basic (plus bold and italic)",
			"Geo"=>"Geo",
			"Geostar Fill"=>"Geostar Fill",
			"Geostar"=>"Geostar",
			"Germania One"=>"Germania One",
			"Give You Glory"=>"Give You Glory",
			"Glass Antiqua"=>"Glass Antiqua",
			"Glegoo"=>"Glegoo",
			"Gloria Hallelujah"=>"Gloria Hallelujah",
			"Goblin One"=>"Goblin One",
			"Gochi Hand"=>"Gochi Hand",
			"Gochi Hand:400"=>"Gochi Hand:400",
			"Gorditas"=>"Gorditas",
			"Gorditas:400,bold"=>"Gorditas (plus bold)",
			"Goudy Bookletter 1911"=>"Goudy Bookletter 1911",
			"Graduate"=>"Graduate",
			"Gravitas One"=>"Gravitas One",
			"Gruppo"=>"Gruppo",
			"Gudea"=>"Gudea",
			"Gudea:400,italic,bold"=>"Gudea:400,italic,bold",
			"Habibi"=>"Habibi",
			"Hammersmith One"=>"Hammersmith One",
			"Handlee"=>"Handlee",
			"Happy Monkey"=>"Happy Monkey",
			"Henny Penny"=>"Henny Penny",
			"Herr Von Muellerhoff"=>"Herr Von Muellerhoff",
			"Holtwood One SC"=>"Holtwood One SC",
			"Homemade Apple"=>"Homemade Apple",
			"Homenaje"=>"Homenaje",
			"IM Fell DW Pica SC"=>"IM Fell DW Pica SC",
			"IM Fell DW Pica"=>"IM Fell DW Pica",
			"IM Fell DW Pica:regular,italic"=>"IM Fell DW Pica (plus italic)",
			"IM Fell Double Pica SC"=>"IM Fell Double Pica SC",
			"IM Fell Double Pica"=>"IM Fell Double Pica",
			"IM Fell Double Pica:regular,italic"=>"IM Fell Double Pica (plus italic)",
			"IM Fell English SC"=>"IM Fell English SC",
			"IM Fell English"=>"IM Fell English",
			"IM Fell English:regular,italic"=>"IM Fell English (plus italic)",
			"IM Fell French Canon SC"=>"IM Fell French Canon SC",
			"IM Fell French Canon"=>"IM Fell French Canon",
			"IM Fell French Canon:regular,italic"=>"IM Fell French Canon (plus italic)",
			"IM Fell Great Primer SC"=>"IM Fell Great Primer SC",
			"IM Fell Great Primer"=>"IM Fell Great Primer",
			"IM Fell Great Primer:regular,italic"=>"IM Fell Great Primer (plus italic)",
			"Iceberg"=>"Iceberg",
			"Iceland"=>"Iceland",
			"Imprima"=>"Imprima",
			"Inconsolata"=>"Inconsolata",
			"Inder"=>"Inder",
			"Indie Flower"=>"Indie Flower",
			"Inika"=>"Inika",
			"Inika:400,bold"=>"Inika (plus bold)",
			"Irish Grover"=>"Irish Grover",
			"Irish Growler"=>"Irish Growler",
			"Istok Web"=>"Istok Web",
			"Istok Web:400,700,400italic,700italic"=>"Istok Web (plus italic, bold, and bold italic)",
			"Italiana"=>"Italiana",
			"Italianno"=>"Italianno",
			"Jim Nightshade"=>"Jim Nightshade",
			"Jockey One"=>"Jockey One",
			"Jolly Lodger"=>"Jolly Lodger",
			"Josefin Sans"=>"Josefin Sans Regular 400",
			"Josefin Sans:100"=>"Josefin Sans 100",
			"Josefin Sans:100,100italic"=>"Josefin Sans 100 (plus italic)",
			"Josefin Sans:600"=>"Josefin Sans 600",
			"Josefin Sans:600,600italic"=>"Josefin Sans 600 (plus italic)",
			"Josefin Sans:bold"=>"Josefin Sans Bold 700",
			"Josefin Sans:bold,bolditalic"=>"Josefin Sans Bold 700 (plus italic)",
			"Josefin Sans:light"=>"Josefin Sans Light 300",
			"Josefin Sans:light,lightitalic"=>"Josefin Sans Light 300 (plus italic)",
			"Josefin Sans:regular,regularitalic"=>"Josefin Sans Regular 400 (plus italic)",
			"Josefin Slab"=>"Josefin Slab Regular 400",
			"Josefin Slab:100"=>"Josefin Slab 100",
			"Josefin Slab:100,100italic"=>"Josefin Slab 100 (plus italic)",
			"Josefin Slab:600"=>"Josefin Slab 600",
			"Josefin Slab:600,600italic"=>"Josefin Slab 600 (plus italic)",
			"Josefin Slab:bold"=>"Josefin Slab Bold 700",
			"Josefin Slab:bold,bolditalic"=>"Josefin Slab Bold 700 (plus italic)",
			"Josefin Slab:light"=>"Josefin Slab Light 300",
			"Josefin Slab:light,lightitalic"=>"Josefin Slab Light 300 (plus italic)",
			"Josefin Slab:regular,regularitalic"=>"Josefin Slab Regular 400 (plus italic)",
			"Judson"=>"Judson",
			"Judson:regular,regularitalic,bold"=>"Judson (plus bold)",
			"Julee"=>"Julee",
			"Junge"=>"Junge",
			"Jura"=>" Jura Regular",
			"Jura:500"=>" Jura 500",
			"Jura:600"=>" Jura 600",
			"Jura:light"=>" Jura Light",
			"Just Another Hand"=>"Just Another Hand",
			"Just Me Again Down Here"=>"Just Me Again Down Here",
			"Kameron"=>"Kameron",
			"Kameron:400,700"=>"Kameron (plus bold)",
			"Karla"=>"Karla",
			"Karla:400,400italic,700,700italic"=>"Karla (plus all weights and italics)",
			"Kaushan Script"=>"Kaushan Script",
			"Kelly Slab"=>"Kelly Slab",
			"Kenia"=>"Kenia",
			"Knewave"=>"Knewave",
			"Kotta One"=>"Kotta One",
			"Kranky"=>"Kranky",
			"Kreon"=>"Kreon",
			"Kreon:light,regular,bold"=>"Kreon (plus light and bold)",
			"Kristi"=>"Kristi",
			"Krona One"=>"Krona One",
			"La Belle Aurore"=>"La Belle Aurore",
			"Lancelot"=>"Lancelot",
			"Lato:100"=>"Lato 100",
			"Lato:100,100italic"=>"Lato 100 (plus italic)",
			"Lato:900"=>"Lato 900",
			"Lato:900,900italic"=>"Lato 900 (plus italic)",
			"Lato:bold"=>"Lato Bold 700",
			"Lato:bold,bolditalic"=>"Lato Bold 700 (plus italic)",
			"Lato:light"=>"Lato Light 300",
			"Lato:light,lightitalic"=>"Lato Light 300 (plus italic)",
			"Lato:regular"=>"Lato Regular 400",
			"Lato:regular,regularitalic"=>"Lato Regular 400 (plus italic)",
			"League Script"=>"League Script",
			"Leckerli One"=>"Leckerli One",
			"Ledger"=>"Ledger",
			"Lekton"=>" Lekton",
			"Lekton:regular,italic,bold"=>"Lekton (plus italic and bold)",
			"Lemon"=>"Lemon",
			"Lilita One"=>"Lilita One",
			"Limelight"=>" Limelight",
			"Linden Hill"=>"Linden Hill",
			"Linden Hill:400,400italic"=>"Linden Hill:400,400italic",
			"Lobster Two"=>"Lobster Two",
			"Lobster Two:400,400italic,700,700italic"=>"Lobster Two (plus italic, bold, and bold italic)",
			"Lobster"=>"Lobster",
			"Londrina Outline"=>"Londrina Outline",
			"Londrina Shadow"=>"Londrina Shadow",
			"Londrina Sketch"=>"Londrina Sketch",
			"Londrina Solid"=>"Londrina Solid",
			"Lora"=>"Lora",
			"Lora:400,700,400italic,700italic"=>"Lora (plus bold and italic)",
			"Love Ya Like A Sister"=>"Love Ya Like A Sister",
			"Loved by the King"=>"Loved by the King",
			"Luckiest Guy"=>"Luckiest Guy",
			"Lusitana"=>"Lusitana",
			"Lusitana:400,bold"=>"Lusitana (plus bold)",
			"Lustria"=>"Lustria",
			"Macondo Swash Caps"=>"Macondo Swash Caps",
			"Macondo"=>"Macondo",
			"Magra"=>"Magra",
			"Magra:400,bold"=>"Magra (plus bold)",
			"Maiden Orange"=>"Maiden Orange",
			"Mako"=>"Mako",
			"Marck Script"=>"Marck Script",
			"Marko One"=>"Marko One",
			"Marmelad"=>"Marmelad",
			"Marvel"=>"Marvel",
			"Marvel:400,400italic,700,700italic"=>"Marvel (plus bold and italic)",
			"Mate SC"=>"Mate SC",
			"Mate"=>"Mate",
			"Mate:400,400italic"=>"Mate:400,400italic",
			"Maven Pro"=>" Maven Pro",
			"Maven Pro:500"=>" Maven Pro 500",
			"Maven Pro:900"=>" Maven Pro 900",
			"Maven Pro:bold"=>" Maven Pro 700",
			"Meddon"=>"Meddon",
			"MedievalSharp"=>"MedievalSharp",
			"Medula One"=>"Medula One",
			"Megrim"=>"Megrim",
			"Merienda One"=>"Merienda One",
			"Merriweather"=>"Merriweather",
			"Metamorphous"=>"Metamorphous",
			"Metrophobic"=>"Metrophobic",
			"Michroma"=>"Michroma",
			"Miltonian Tattoo"=>"Miltonian Tattoo",
			"Miltonian"=>"Miltonian",
			"Miniver"=>"Miniver",
			"Miss Fajardose"=>"Miss Fajardose",
			"Miss Saint Delafield"=>"Miss Saint Delafield",
			"Modern Antiqua"=>"Modern Antiqua",
			"Molengo"=>"Molengo",
			"Monofett"=>"Monofett",
			"Monoton"=>"Monoton",
			"Monsieur La Doulaise"=>"Monsieur La Doulaise",
			"Montaga"=>"Montaga",
			"Montez"=>"Montez",
			"Montserrat"=>"Montserrat",
			"Mountains of Christmas"=>"Mountains of Christmas",
			"Mr Bedford"=>"Mr Bedford",
			"Mr Dafoe"=>"Mr Dafoe",
			"Mr De Haviland"=>"Mr De Haviland",
			"Mrs Saint Delafield"=>"Mrs Saint Delafield",
			"Mrs Sheppards"=>"Mrs Sheppards",
			"Muli"=>"Muli Regular",
			"Muli:light"=>"Muli Light",
			"Muli:light,lightitalic"=>"Muli Light (plus italic)",
			"Muli:regular,regularitalic"=>"Muli Regular (plus italic)",
			"Mystery Quest"=>"Mystery Quest",
			"Neucha"=>"Neucha",
			"Neuton"=>"Neuton",
			"News Cycle"=>"News Cycle",
			"Niconne"=>"Niconne",
			"Nixie One"=>"Nixie One",
			"Nobile"=>"Nobile",
			"Nobile:regular,italic,bold,bolditalic"=>"Nobile (plus italic, bold, and bold italic)",
			"Nokora"=>"Nokora",
			"Nokora:400,700"=>"Nokora:400,700",
			"Norican"=>"Norican",
			"Nosifer"=>"Nosifer",
			"Noticia Text"=>"Noticia Text",
			"Noticia Text:400,400italic,700,700italic"=>"Noticia Text:400,400italic,700,700italic",
			"Nova Cut"=>"Nova Cut",
			"Nova Flat"=>"Nova Flat",
			"Nova Mono"=>"Nova Mono",
			"Nova Oval"=>"Nova Oval",
			"Nova Round"=>"Nova Round",
			"Nova Script"=>"Nova Script",
			"Nova Slim"=>"Nova Slim",
			"Nova Square"=>"Nova Square",
			"Numans"=>"Numans",
			"Nunito"=>" Nunito Regular",
			"Nunito:light"=>" Nunito Light",
			"OFL Sorts Mill Goudy TT"=>"OFL Sorts Mill Goudy TT",
			"OFL Sorts Mill Goudy TT:regular,italic"=>"OFL Sorts Mill Goudy TT (plus italic)",
			"Old Standard TT"=>"Old Standard TT",
			"Old Standard TT:regular,italic,bold"=>"Old Standard TT (plus italic and bold)",
			"Oldenburg"=>"Oldenburg",
			"Open Sans Condensed"=>"Open Sans Condensed",
			"Open Sans Condensed:300,300italic,700"=>"Open Sans Condensed (plus all weights and italics)",
			"Open Sans Condensed:light,lightitalic"=>"Open Sans Condensed Light (plus italic)",
			"Open Sans:600,600italic"=>"Open Sans 600",
			"Open Sans:800,800italic"=>"Open Sans 800",
			"Open Sans:bold,bolditalic"=>"Open Sans bold",
			"Open Sans:light,lightitalic"=>"Open Sans light",
			"Open Sans:light,lightitalic,regular,regularitalic,600,600italic,bold,bolditalic,800,800italic"=>"Open Sans (all weights)",
			"Open Sans:regular,regularitalic"=>"Open Sans regular",
			"Orbitron"=>"Orbitron Regular (400)",
			"Orbitron:500"=>"Orbitron 500",
			"Orbitron:900"=>"Orbitron 900",
			"Orbitron:bold"=>"Orbitron Regular (700)",
			"Original Surfer"=>"Original Surfer",
			"Oswald"=>"Oswald",
			"Over the Rainbow"=>"Over the Rainbow",
			"Overlock SC"=>"Overlock SC",
			"Overlock"=>"Overlock",
			"Overlock:400,400italic,700,700italic,900,900italic"=>"Overlock:400,400italic,700,700italic,900,900italic",
			"Ovo"=>"Ovo",
			"PT Mono"=>"PT Mono",
			"PT Sans Caption"=>"PT Sans Caption",
			"PT Sans Caption:regular,bold"=>"PT Sans Caption (plus bold)",
			"PT Sans Narrow"=>"PT Sans Narrow",
			"PT Sans Narrow:regular,bold"=>"PT Sans Narrow (plus bold)",
			"PT Sans"=>"PT Sans",
			"PT Sans:regular,italic,bold,bolditalic"=>"PT Sans (plus itlic, bold, and bold italic)",
			"PT Serif Caption"=>"PT Serif Caption",
			"PT Serif Caption:regular,italic"=>"PT Serif Caption (plus italic)",
			"PT Serif"=>"PT Serif",
			"PT Serif:regular,italic,bold,bolditalic"=>"PT Serif (plus italic, bold, and bold italic)",
			"Pacifico"=>"Pacifico",
			"Parisienne"=>"Parisienne",
			"Passero One"=>"Passero One",
			"Passion One"=>"Passion One",
			"Passion One:400,700,900"=>"Passion One:400,700,900",
			"Patrick Hand"=>"Patrick Hand",
			"Patua One"=>"Patua One",
			"Paytone One"=>"Paytone One",
			"Permanent Marker"=>"Permanent Marker",
			"Petrona"=>"Petrona",
			"Philosopher"=>"Philosopher",
			"Piedra"=>"Piedra",
			"Pinyon Script"=>"Pinyon Script",
			"Plaster"=>"Plaster",
			"Play"=>"Play",
			"Play:regular,bold"=>"Play (plus bold)",
			"Playball"=>"Playball",
			"Playfair Display"=>" Playfair Display",
			"Podkova"=>" Podkova",
			"Poiret One"=>"Poiret One",
			"Poller One"=>"Poller One",
			"Poly"=>"Poly",
			"Poly:400,400italic"=>"Poly:400,400italic",
			"Pompiere"=>"Pompiere",
			"Pontano Sans"=>"Pontano Sans",
			"Port Lligat Sans"=>"Port Lligat Sans",
			"Port Lligat Slab"=>"Port Lligat Slab",
			"Prata"=>"Prata",
			"Princess Sofia"=>"Princess Sofia",
			"Prociono"=>"Prociono",
			"Prosto One"=>"Prosto One",
			"Puritan"=>"Puritan",
			"Puritan:regular,italic,bold,bolditalic"=>"Puritan (plus italic, bold, and bold italic)",
			"Quantico"=>"Quantico",
			"Quantico:400,400italic,700,700italic"=>"Quantico:400,400italic,700,700italic",
			"Quattrocento Sans"=>"Quattrocento Sans",
			"Quattrocento"=>"Quattrocento",
			"Questrial"=>"Questrial",
			"Quicksand"=>"Quicksand",
			"Quicksand:300,400,700"=>"Quicksand:300,400,700",
			"Qwigley"=>"Qwigley",
			"Radley"=>"Radley",
			"Raleway:100"=>"Raleway",
			"Rammetto One"=>"Rammetto One",
			"Rancho"=>"Rancho",
			"Rationale"=>"Rationale",
			"Redressed"=>"Redressed",
			"Reenie Beanie"=>"Reenie Beanie",
			"Revalia"=>"Revalia",
			"Ribeye Marrow"=>"Ribeye Marrow",
			"Ribeye"=>"Ribeye",
			"Righteous"=>"Righteous",
			"Rochester"=>"Rochester",
			"Rock Salt"=>"Rock Salt",
			"Rokkitt"=>"Rokkitt",
			"Ropa Sans"=>"Ropa Sans",
			"Ropa Sans:400,400italic"=>"Ropa Sans (plus italics)",
			"Rosario"=>"Rosario",
			"Rouge Script"=>"Rouge Script",
			"Ruda"=>"Ruda",
			"Ruda:400,bold,900"=>"Ruda (plus all bold and 900)",
			"Ruge Boogie"=>"Ruge Boogie",
			"Ruluko"=>"Ruluko",
			"Ruslan Display"=>"Ruslan Display",
			"Ruthie"=>"Ruthie",
			"Sail"=>"Sail",
			"Salsa"=>"Salsa",
			"Sancreek"=>"Sancreek",
			"Sansita One"=>"Sansita One",
			"Sarina"=>"Sarina",
			"Satisfy"=>"Satisfy",
			"Schoolbell"=>"Schoolbell",
			"Seaweed Script"=>"Seaweed Script",
			"Sevillana"=>"Sevillana",
			"Shadows Into Light Two"=>"Shadows Into Light Two",
			"Shadows Into Light"=>"Shadows Into Light",
			"Shanti"=>"Shanti",
			"Share"=>"Share",
			"Share:400,400italic,700,700italic"=>"Share (plus all weights and italics)",
			"Shojumaru"=>"Shojumaru",
			"Short Stack"=>"Short Stack",
			"Sigmar One"=>"Sigmar One",
			"Signika Negative"=>"Signika Negative",
			"Signika Negative:300,400,600,700"=>"Signika Negative:300,400,600,700",
			"Signika"=>"Signika",
			"Signika:300,400,600,700"=>"Signika:300,400,600,700",
			"Simonetta"=>"Simonetta",
			"Simonetta:400,400italic"=>"Simonetta (plus italic)",
			"Sirin Stencil"=>"Sirin Stencil",
			"Six Caps"=>"Six Caps",
			"Slackey"=>"Slackey",
			"Smokum"=>"Smokum",
			"Smythe"=>"Smythe",
			"Sniglet:800"=>"Sniglet",
			"Snippet"=>"Snippet",
			"Sofia"=>"Sofia",
			"Sonsie One"=>"Sonsie One",
			"Sorts Mill Goudy"=>"Sorts Mill Goudy",
			"Sorts Mill Goudy:400,400italic"=>"Sorts Mill Goudy (plus italic)",
			"Special Elite"=>"Special Elite",
			"Spicy Rice"=>"Spicy Rice",
			"Spinnaker"=>"Spinnaker",
			"Spirax"=>"Spirax",
			"Squada One"=>"Squada One",
			"Stardos Stencil"=>"Stardos Stencil",
			"Stardos Stencil:400,700"=>"Stardos Stencil (plus bold)",
			"Stint Ultra Condensed"=>"Stint Ultra Condensed",
			"Stint Ultra Expanded"=>"Stint Ultra Expanded",
			"Stoke"=>"Stoke",
			"Sue Ellen Francisco"=>"Sue Ellen Francisco",
			"Sunshiney"=>"Sunshiney",
			"Supermercado One"=>"Supermercado One",
			"Swanky and Moo Moo"=>"Swanky and Moo Moo",
			"Syncopate"=>"Syncopate",
			"Tangerine"=>"Tangerine",
			"Telex"=>"Telex",
			"Tenor Sans"=>" Tenor Sans",
			"Terminal Dosis Light"=>"Terminal Dosis Light",
			"Terminal Dosis"=>"Terminal Dosis Regular",
			"Terminal Dosis:200"=>"Terminal Dosis 200",
			"Terminal Dosis:300"=>"Terminal Dosis 300",
			"Terminal Dosis:500"=>"Terminal Dosis 500",
			"Terminal Dosis:600"=>"Terminal Dosis 600",
			"Terminal Dosis:700"=>"Terminal Dosis 700",
			"Terminal Dosis:800"=>"Terminal Dosis 800",
			"The Girl Next Door"=>"The Girl Next Door",
			"Tinos"=>"Tinos",
			"Tinos:regular,italic,bold,bolditalic"=>"Tinos (plus italic, bold, and bold italic)",
			"Titan One"=>"Titan One",
			"Trade Winds"=>"Trade Winds",
			"Trochut"=>"Trochut",
			"Trochut:400,italic,bold"=>"Trochut (plus bold and italic)",
			"Trykker"=>"Trykker",
			"Tulpen One"=>"Tulpen One",
			"Ubuntu Condensed"=>"Ubuntu Condensed",
			"Ubuntu Mono"=>"Ubuntu Mono",
			"Ubuntu Mono:regular,italic,bold,bolditalic"=>"Ubuntu Mono:regular,italic,bold,bolditalic",
			"Ubuntu"=>"Ubuntu",
			"Ubuntu:regular,italic,bold,bolditalic"=>"Ubuntu (plus italic, bold, and bold italic)",
			"Ultra"=>"Ultra",
			"Uncial Antiqua"=>"Uncial Antiqua",
			"UnifrakturCook:bold"=>"UnifrakturCook",
			"UnifrakturMaguntia"=>"UnifrakturMaguntia",
			"Unkempt"=>"Unkempt",
			"Unlock"=>"Unlock",
			"Unna"=>"Unna",
			"VT323"=>"VT323",
			"Varela Round"=>"Varela Round",
			"Varela"=>"Varela",
			"Vast Shadow"=>"Vast Shadow",
			"Vibur"=>"Vibur",
			"Vidaloka"=>"Vidaloka",
			"Viga"=>"Viga",
			"Voces"=>"Voces",
			"Volkhov"=>"Volkhov",
			"Volkhov:400,400italic,700,700italic"=>"Volkhov (plus bold and italic)",
			"Vollkorn"=>"Vollkorn",
			"Vollkorn:regular,italic,bold,bolditalic"=>"Vollkorn (plus italic, bold, and bold italic)",
			"Voltaire"=>"Voltaire",
			"Waiting for the Sunrise"=>"Waiting for the Sunrise",
			"Wallpoet"=>"Wallpoet",
			"Walter Turncoat"=>"Walter Turncoat",
			"Wellfleet"=>"Wellfleet",
			"Wire One"=>"Wire One",
			"Yanone Kaffeesatz"=>"Yanone Kaffeesatz",
			"Yanone Kaffeesatz:300"=>"Yanone Kaffeesatz:300",
			"Yanone Kaffeesatz:400"=>"Yanone Kaffeesatz:400",
			"Yanone Kaffeesatz:700"=>"Yanone Kaffeesatz:700",
			"Yellowtail"=>"Yellowtail",
			"Yeseva One"=>"Yeseva One",
			"Yesteryear"=>"Yesteryear",
			"Zeyada"=>"Zeyada",
		);
	}

	function get_fontface_fonts(){
		if($this->fontface_fonts){
			return $this->fontface_fonts;
		}
		$fonts = array();
		$font_dirs = array_filter(glob(THEME_FONTFACE_DIR.'/*'), 'is_dir');
		
		foreach($font_dirs as $dir){
			$stylesheet = $dir.'/stylesheet.css';
			if(file_exists($stylesheet)){
				$file_content = file_get_contents($stylesheet);
				if( preg_match_all("/@font-face\s*{.*?font-family\s*:\s*('|\")(.*?)\\1.*?}/is", $file_content, $matchs) ){
					foreach($matchs[0] as $index => $css){
						$font_folder = basename($dir);
						$fonts[$font_folder.'|'.$matchs[2][$index]] = array(
							'folder' => $font_folder,
							'name' => $matchs[2][$index],
							'css' => $css,
							'dir' => THEME_FONTFACE_DIR. '/'.$font_folder.'/stylesheet.css',
							'url' => THEME_FONTFACE_URI. '/'.$font_folder.'/stylesheet.css',
						);
					}
					
				}
			}
		}
		$fonts = apply_filters('theme_fontface_fonts',$fonts);
		$this->fontface_fonts = $fonts;
		return $fonts;
	}
	function get_google_font_name($font){
		$fonts = $this->get_google_fonts();
		if(is_string($font) && $font !== '' && array_key_exists($font,$fonts)){
			return $fonts[$font];
		}else{
			return false;
		}
	}
	function get_fontface_font($font){
		$fonts = $this->get_fontface_fonts();
		if(is_string($font) && $font !== '' && array_key_exists($font,$fonts)){
			return $fonts[$font];
		}else{
			return false;
		}
	}
	function get_cufon_font($font){
		$fonts = $this->get_cufon_fonts();
		if(is_string($font) && $font !== '' && array_key_exists($font,$fonts)){
			return $fonts[$font];
		}else{
			return false;
		}
	}

	function get_fontface_fonts_list(){
		$fonts = $this->get_fontface_fonts();
		$list = array();
		foreach($fonts as $value=>$font){
			$list[$value] = $font['name'];
		}
		return $list;
	}

	function get_cufon_fonts(){
		if($this->cufon_fonts){
			return $this->cufon_fonts;
		}
		$fonts = array();
		$font_files = glob(THEME_FONT_DIR."/*.js");
		if(!empty($font_files)){
			foreach($font_files as $font_file){
				$file_content = file_get_contents($font_file);
				if(preg_match('/font-family":"(.*?)"/i',$file_content,$match)){
					$file_name = basename($font_file);
					$fonts[$file_name] = array(
						'font_name' => $match[1],
						'file_name' => $file_name,
						'url' => THEME_FONT_URI.'/'.$file_name
					);
				}
			}
		}
		$fonts = apply_filters('theme_cufon_fonts',$fonts);
		$this->cufon_fonts = $fonts;
		return $fonts;
	}

	function get_cufon_fonts_list(){
		$fonts = $this->get_cufon_fonts();
		$list = array();
		foreach($fonts as $value=>$font){
			$list[$value] = $font['font_name'];
		}
		return $list;
	}
}
