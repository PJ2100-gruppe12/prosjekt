<?php
class Theme_Options_Page_Font extends Theme_Options_Page_With_Tabs {
	public $slug = 'font';
	public $cufon_fonts = false;
	public $fontface_fonts = false;

	function __construct(){
		if(isset($_GET['page']) && $_GET['page']=='theme_font'){
			add_filter('admin_head', array(&$this, 'add_scripts'));
		}
		$this->name = sprintf(__('%s Font Settings','theme_admin'),THEME_NAME);
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
	
	jQuery(document).on('change','.toggle-default',function(){
		if(jQuery(this).is(':checked')){
			jQuery(this).closest('li').siblings().find('.toggle-default:checked').attr('checked', false).trigger('change');
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
				"name" => __("General Settings",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Site Font family",'theme_admin'),
						"desc" => __("<p>This dropdown contains a list of 9 standard web fonts that are the core fonts for Striking.&nbsp;&nbsp;Which ever font you select will be the font you will see across your entire site for both body text and descriptive text (such as headers, navigation labels, post titles, etc).</p><p>In Striking, one has the alternative of using one of the many custom Cufon, Fontface or Google fonts supplied for either custom replacement of selective descritive and/or body text by way of custom css, or by enabling the custom font fully across all descriptive text types via the Font settings for each custom font.</p><p>If one full enables a custom font for descriptive text in a site, all body text types such as standard paragraph text, slider description text, widget body text, etc will still be in the standard font chosen here, unless you choose to replace the standard body font with custom css.</p>",'theme_admin'),	
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
						"name" => __("Line height",'theme_admin'),
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
						"name" => __("Link Hover Underline",'theme_admin'),
						"desc" => __("<p>Enabling this setting will cause all web links listed in body text to be underlined.<p>",'theme_admin'),	
						"id" => "link_underline",
						"default" => false,
						"type" => "toggle"
					),
				),
			),
			array(
				"slug" => 'size',
				"name" => __("Font Size Settings",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Logo Text Size",'theme_admin'),
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
						"name" => __("Logo Tagline Size",'theme_admin'),
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
						"name" => __("Top Level Navigation Menu Text Size",'theme_admin'),
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
						"name" => __("Sub Level Navigation Menu Text Size",'theme_admin'),
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
						"name" => __("Feature Header Title Size",'theme_admin'),
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
						"name" => __("Feature Header Custom Title Text Size",'theme_admin'),
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
						"name" => __("Accordion Slider Non-Hover Caption Text Size",'theme_admin'),
						"desc" => __("<p>This setting allows one to adjust the Accordion Slider caption text size as it appears when a slider loads on a page and the slider is cycling between slides.&nbsp;&nbsp;So with this setting you decide the text size that will appear during the regular aspects of the slideshow.&nbsp;&nbsp;In the <b>On-Hover Caption</b> setting below, you have the ability to decide the size of this caption text when a user cursor hovers over the slide image.</p><p>You create the Accordion Slider caption using the <b>Slide Caption</b> field in the <b>Striking Slider Options ->Slider Item Options</b> metabox found below the slide post content editor on any slide you are editing.",'theme_admin'),	
						"id" => "kwick_title",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "16",
						"type" => "range"
					),
					array(
						"name" => __("Accordion Slider On-Hover Caption Text Size",'theme_admin'),
						"desc" => __("<p>This setting allows one to adjust the Accordion Slider caption text size as it appears when a viewer cursor is hovering over the slide - in Striking this slider caption has a mode where typically one will have the caption expand in size on slide hover in order to grab the attention of the viewer.&nbsp;&nbsp;So with this setting you decide the on-slide hover expansion text size.</p><p>You create the Accordion Slider caption using the <b>Slide Caption</b> field in the <b>Striking Slider Options ->Slider Item Options</b> metabox found below the slide post content editor on any slide you are editing.",'theme_admin'),	
						"id" => "kwick_detail_header",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "24",
						"type" => "range"
					),
					array(
						"name" => __("Accordion Slider Description Text Size",'theme_admin'),
						"desc" => __("<p>This setting allows one to adjust the size of the text for the Accordion Slider description.&nbsp;&nbsp;You create the Accordion Slider description using the <b>Description</b> field in the <b>Striking Slider Options ->Slider Item Options</b> metabox found below the slide post content editor on any slide you are editing.</p>",'theme_admin'),	
						"id" => "kwick_desc",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Anything Slider Caption Text Size",'theme_admin'),
						"desc" => __("<p>This setting allows one to adjust the size of the text for the Anything Slider caption.</p>",'theme_admin'),	
						"id" => "anything_caption",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "24",
						"type" => "range"
					),
					array(
						"name" => __("Anything Slider Description Text Size",'theme_admin'),
						"desc" => __("<p>This setting allows one to adjust the size of the text for the Anything Slider description.&nbsp;&nbsp;You create the Anything Slider description using the <b>Description</b> field in the <b>Striking Slider Options ->Slider Item Options</b> metabox found below the slide post content editor on any slide you are editing.</p>",'theme_admin'),	
						"id" => "anything_desc",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Page Body Text Size",'theme_admin'),
						"desc" => __("<p>Body text includes text in a page or post body, widget body, description text of a slider item, normal text variations such as bold, sub and superscript, emphasized, etc.</p>",'theme_admin'),	
						"id" => "page",
						"min" => "1",
						"max" => "60",
						"step" => "1",
						"unit" => 'px',
						"default" => "12",
						"type" => "range"
					),
					array(
						"name" => __("Breadcrumbs Text Size",'theme_admin'),
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
						"name" => sprintf(__("%s Size",'theme_admin'),'H1'),
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
						"name" => sprintf(__("%s Size",'theme_admin'),'H2'),
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
						"name" =>  sprintf(__("%s Size",'theme_admin'),'H3'),
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
						"name" =>  sprintf(__("%s Size",'theme_admin'),'H4'),
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
						"name" =>  sprintf(__("%s Size",'theme_admin'),'H5'),
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
						"name" =>  sprintf(__("%s Size",'theme_admin'),'H6'),
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
						"name" => __("Blog Post Title Size",'theme_admin'),
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
						"name" => __("Portfolio Post Title Size",'theme_admin'),
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
						"name" => __("Portfolio Description Text Size",'theme_admin'),
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
						"name" => __("Sidebar Widget Title",'theme_admin'),
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
						"name" => __("Footer Text Size",'theme_admin'),
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
						"name" => __("Footer Widget Title Size",'theme_admin'),
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
						"name" => __("Copyright Text Size",'theme_admin'),
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
						"name" => __("Footer Menu Text Size",'theme_admin'),
						"desc" => __("<p>This font size sets the size of navigation labels if one has enable the sub footer widget area for Navigation and created a footer menu in the Striking Custom Menu function.</p>",'theme_admin'),	
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
				"name" => __("Cufon Settings",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Enable Cufon Font",'theme_admin'),
						"desc" => __("<p>Cufon is a font-replacement technique that uses javascript and vector graphics to write fonts from a font file (TTF, OTF or PFB) to your browser.&nbsp;&nbsp;Many interesting free and paid variations of Cufon are available and Striking includes 45 royalty free Cufon fonts for your use.</p><p>Cufon is very popular but as js has changed, some of the royalty free fonts don't always render correctly in the newest versions of some browsers (support for the js techniques that Cufon uses is up to the browsers and changes with every update). &nbsp;&nbsp;Sometimes one will experience, depending on the browswer, what is commonly known as the <em>Cufon Delay.</em> &nbsp;&nbsp;In this situation a page loads, and as one of the very last steps in the page loading process when java scripting typically take place, the process of replacing the web font with Cufon is executed, sometimes with a visible margin of delay. &nbsp;&nbsp; Should this occur and you dislike it, the choice is to select a different Cufon or other font type for use in your site.</p><p><b>USAGE IN STRIKING:</b></p><p><u>Step 1</u> is to enable the potential for Cufon with this setting - you are turning on Cufon, but not yet making it active in replacement of any text within the site. &nbsp;&nbsp;<b>VERY IMPORTANT - SAVE THE PANEL AFTER THIS STEP.  DO NOT PROCEED TO STEP 2 UNTIL YOU HAVE SAVED THIS SETTING!</b></p><p><u>Step 2</u> is to choose a cufon font in the <b>Choose Cufon</b> setting below - selecting a cufon font makes that specific font now available for usage, but still not actively replacing any text in the site as it has not been told what to replace.</p><p>Once one has made available a cufon font one has two choices:</p><p>1) Use custom css pasted into the <b>Cufon Custom CSS Code Field</b> below to selectively replace the regular web font where one desires (samples are provided in its help field), or</p><p>2) Turn <em>ON</em> the setting for <b>Enable Cufon Replacment for all Descriptive Text Types</b> (this field is ajaxed and only appears once you have chosen a font in Step 2 above) in which case your selected Cufon Font will replace the standard web font chosen for the site with the selected Cufon Font for all the descriptive font places in Striking (see help field for the list and also some special instructions on what not to do!).</p>",'theme_admin'),		
						"id" => "cufon_enabled",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"id" => "cufon_used",
						"name" =>__('Choose Cufon Font',"theme_admin"),
						"desc" => __("<p>Click in the field with your cursor and choose a font.&nbsp;&nbsp;One may have more then one Cufon font active at the same time, each being used for various web font replacements as well as one being the default font for most descriptive replacement in that setting below.</p><p>Choose multiple fonts by holding down the Cntrl key on your keyboard while scrolling and clicking the fonts in the list, just as you would do to select multiple items on your desktop computer.</p> ",'theme_admin'),
						"default" => array(),
						"prompt" => __("Choose Cufon font..","theme_admin"),
						"type" => "fontchosen",
						"options"=> $this->get_cufon_fonts_list(),
						"preview_callback" => 'function(element, font){
	if(cufon_list[font.id] === undefined){
		return;
	}
	var url = cufon_list[font.id].url;
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
			Cufon.replace(element,{fontFamily: cufon_list[font.id].name});
		};
		var s = document.getElementsByTagName("script")[0];
		s.parentNode.insertBefore(wf, s);
		jQuery(element).data("loaded",loaded);
	}else{
		Cufon.replace(element,{fontFamily: cufon_list[font.id].name});
	}
};',
					),	
					array(
						"name" => __("Cufon Custom CSS Code Field",'theme_admin'),
						"desc" => __('<p>One can selectively replace any web text in Striking, although typically one is usually replacing descriptive text of some sort.</p><p>Here is an example of two replacements, and in this example, notice that two separate Cufon fonts are used - one would have to have enabled both of these fonts in the <b>Choose Cufon Font</b> setting above.  Take either or both code snippets and copy and paste into the field below, and then change the font names to the name of the Cufon font you have chosen.</p><p><code>Cufon.replace("h1,h2,h3,h4,h5", {fontFamily : "Vegur"});</code></p><p><code>Cufon.replace("#site_name", {fontFamily : "Segan", color: \'-linear-gradient(white, black)\'});</code></p><p>For more code tips go to official <a href="http://wiki.github.com/sorccu/cufon/styling">Cufon\'s site</a></p>','theme_admin'),							"id" => "cufon_code",
						"default" => '',
						"id" => "cufon_code",
						"rows" => '8',
						"type" => "textarea"
					),
					array(
						"id" => "cufon_default",
						"name" =>__('Enable Cufon Replacment for all Descriptive Text Types',"theme_admin"),
						"desc" => __("<p>All Cufon fonts you have chosen to make available via the <b>Choose Cufon Font</b> setting above will appear below.&nbsp;&nbsp;Set the toggle to the <em>On</em> position for one of the fonts below, and it will replace all descriptive text types in your site after saving.</p><p><b>WARNING:</b> &nbsp;&nbsp;Do not activate more then one font as the font for replacing all descriptive types as it can lead to extremely unpredictable behaviour, and crash both your site and your browser! (ie, Doing stupid things leads to bad consequences -> you have been warned! (James aka Websys)).</p><p>The following are replaced by the Cufon font when you have activated this setting - this is not the actual script but just the names of the elements that are replaced taken from it:<br /><br /><code>(site_name, site_description, .kwick_title, .kwick_detail h3, footer h3, copyright, .dropcap1, .dropcap2, .dropcap3, .dropcap4, feature h1, introduce, portfolio_title, h1, h2, h3, h4, h5, h6, navigation a, .entry_title a, hover:true</code></p>",'theme_admin'),
						"layout" => false,
						"function" => "_option_cufon_fonts_function",
						"default" => '',
						"type" => "custom"
					),
				),
			),
			array(
				"slug" => 'fontface',
				"name" => __("@font-face Settings",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Enable @font-face",'theme_admin'),
						"desc" => __("<p>font-face is a font-replacement technique that uses a CSS rule to enable the viewing of a font on a Web page even if that font is not installed on the user's computer.</p><p><u>USAGE IN STRIKING:</u> &nbsp;The first step is to enable the potential for fontface with this setting - you are turning on fontface, but not yet making it active in replacement of any text within the site.&nbsp;&nbsp;Step 2 is to choose a fontface font in the <b>Choose @fontface Font</b> setting, which once you select a fontface font makes it an available fontface font for replacing some of the web font usage, but still not actively replacing any text in the site as it has not been told what to replace.&nbsp;&nbsp;Once one has made available a fontface font for replacement one has two choices:</p><p>1) Use custom css pasted into the <b>@fontface Custom CSS Code Field</b> below to selectively replace the regular web font where one desires (samples are provided in its help field), or</p><p>2) Turn <em>ON</em> the setting for <b>Enable @fontface Replacment for all Descriptive Text Types</b> (this field is ajaxed and only appears once you have chosen a font in Step 2 above)in which case your selected fontface font will replace the standard web font chosen for the site with the selected fontface font for all the descriptive font usages in Striking (see help field for the list).</p>",'theme_admin'),	
						"id" => "fontface_enabled",
						"default" => true,
						"type" => "toggle"
					),
					array(
						"id" => "fontface_used",
						"name" =>__('Choose @font-face Font',"theme_admin"),
						"desc" => __("Click in the field with your cursor and choose a font.&nbsp;&nbsp;One may have more then one fontface font active at the same time, each being used for various web font replacements as well as one being the default font for most descriptive replacement in that setting below.&nbsp;&nbsp;Choose multiple fonts by holding down the Cntrl key on your keyboard while scrolling and clicking the fonts in the list, just as you would do to select multiple items on your desktop computer. ",'theme_admin'),
						"default" => array(),
						"prompt" => __("Choose fontface font..","theme_admin"),
						"chosen" => "true",
						"type" => "fontchosen",
						"preview_callback" => 'function(element, font){
	if(fontface_list[font.id] === undefined){
		return;
	}
	var url = fontface_list[font.id].url;
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
						"name" => __("@font-face Custom CSS Code Field",'theme_admin'),
						"desc" => __('One can selectively replace any web text in Striking, although typically one is usually replacing descriptive text of some sort.<br /><br />Here is an example of a replacement and you would take this code snippet and copy and paste into the field below, and then change the font name to the name of the fontface font you have chosen.<p><code>h1,h2,h3,h4,h5 { font-family:ColaborateLightRegular; }</code></p><p>For more code tips go to official <a href="http://www.fontsquirrel.com/">fontface site.</a>','theme_admin'),	
						"id" => "fontface_code",
						"default" => '',
						"rows" => '8',
						"type" => "textarea"
					),
					array(
						"id" => "fontface_default",
						"name" =>__('Enable a @font-face Replacment for all Descriptive Text Types',"theme_admin"),
						"desc" => __("<p>All fontface fonts you have chosen to make available via the <b>Choose @font-face Font</b> setting above will appear below.&nbsp;&nbsp;Set the toggle to the <em>On</em> position for one of the fonts below, and it will replace all descriptive text types in your site after saving.</p><p><b>WARNING:</b> &nbsp;&nbsp;Do not activate more then one font as the font for replacing all descriptive types as it can lead to extremely unpredictable behaviour, and crash both your site and your browser! (ie, Doing stupid things leads to bad consequences -> you have been warned! (James aka Websys)).</p><p>The following are replaced by the fontface font when you have activated this setting - this is not the actual script but just the names of the elements that are replaced taken from it:<br /><br /><code>(site_name, site_description, .kwick_title, .kwick_detail h3, footer h3, copyright, .dropcap1, .dropcap2, .dropcap3, .dropcap4, feature h1, introduce, portfolio_title, h1, h2, h3, h4, h5, h6, navigation a, .entry_title a, hover:true</code></p>",'theme_admin'),	
						"layout" => false,
						"function" => "_option_fontface_fonts_function",
						"default" => '',
						"type" => "custom"
					),
				),
			),
			array(
				"slug" => 'gfont',
				"name" => __("Google font Settings",'theme_admin'),
				"options" => array(
			
					array(
						"id" => "gfont_used",
						"name" =>__('Enable Google Font',"theme_admin"),
						'desc' =>__('<p>Below is a dropdown selectior with a list of over 600 google fonts for use in your site.&nbsp;&nbsp;If the font you desire is not in this list then go to <a href="http://www.google.com/webfonts" target="_blank">Google webfonts library</a> to check on the availability of the font from Google.</p>',"theme_admin"),
						"default" => array(),
						"prompt" => __("Choose google font..","theme_admin"),
						"chosen" => "true",
						"type" => "fontchosen",
						"preview_callback" => 'function(element, font){
	var pos = font.id.indexOf(":");
	var family;
	var variant;
	if(pos != -1){
		family = font.id.substr(0, pos);
		variant = font.id.substr(pos+1);
		jQuery(element).css("font-weight", variant.replace(/italic/,""));
	}else{
		family = font.id;
		jQuery(element).css("font-weight", "");
	}
	jQuery(element).css("font-family", "\'"+family+"\'");

	if(font.id.indexOf("italic")!= -1){
		jQuery(element).css("font-style", "italic");
	}else{
		jQuery(element).css("font-style", "");
	}

	var loaded = jQuery(element).data("loaded");
	if(loaded == undefined){
		loaded = [];
	}
	if(jQuery.inArray(font.id, loaded) < 0){
		loaded.push(font.id);
		WebFont.load({
			google: {
				families: [font.id]
			}
		});
		jQuery(element).data("loaded",loaded);
	}
};',
						"options"=> $this->get_google_fonts(),
					),
					array(
						"name" => __("Google Font Custom CSS","theme_admin"),
						"desc" => __('<p>Font replacement CSS for Google Fonts can be fairly straightforward.&nbsp;&nbsp; Here is a sample code snippet for substituting for the header fonts with the google Droid Sans font into the website:<p><code>h1,h2,h3,h4,h5 { font-family:"Droid Sans"; }</code></p>',"theme_admin"),
						"id" => "gfont_code",
						"default" => '',
						"rows" => '8',
						"type" => "textarea"
					),
					array(
						"id" => "gfont_default",
						"name" =>__('Enable a Google Font Replacment for all Descriptive Text Types',"theme_admin"),
						"desc" => __("<p>All Google fonts you have chosen to make available via the <b>Choose Google Font</b> setting above will appear below.&nbsp;&nbsp;Set the toggle to the <em>On</em> position for one of the fonts below, and it will replace all descriptive text types in your site after saving.</p><p><b>WARNING:</b> &nbsp;&nbsp;Do not activate more then one font as the font for replacing all descriptive types as it can lead to extremely unpredictable behaviour, and crash both your site and your browser! (ie, Doing stupid things leads to bad consequences -> you have been warned! (James aka Websys)).</p><p>The following are replaced by the Google font when you have activated this setting - this is not the actual script but just the names of the elements that are replaced taken from it:<br /><br /><code>(site_name, site_description, .kwick_title, .kwick_detail h3, footer h3, copyright, .dropcap1, .dropcap2, .dropcap3, .dropcap4, feature h1, introduce, portfolio_title, h1, h2, h3, h4, h5, h6, navigation a, .entry_title a, hover:true</code></p>",'theme_admin'),
						"layout" => false,
						"function" => "_option_google_fonts_function",
						"default" => '',
						"process" => '_option_google_fonts_process',
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
		echo '<ul class="theme-font-set-default-list">';
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
		echo '<ul class="theme-font-set-default-list">';
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

	function _option_google_fonts_process($item, $data){
		if(isset($_POST['gfonts_subsets'])){
			$gfonts_subsets = $_POST['gfonts_subsets'];
			if(is_array($gfonts_subsets) && !empty($gfonts_subsets)){
				foreach($gfonts_subsets as $font => $subsets){
					theme_set_google_font_subsets($font, $subsets);
				}
			}
		}
		return $data;
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
		echo '<ul class="theme-font-set-default-list">';
		$count = 1;
		global $google_fonts;

		foreach($fonts as $font){
			$font_obj = $google_fonts->font($font);
			if($font_obj){
				if($font == $default){
					$checked = ' checked="checked"';
				}else{
					$checked = '';
				}
				echo '<li>';
				echo '<input type="checkbox" name="'.$item['id'].'" class="toggle-button toggle-default" value="'.$font.'"'.$checked.'/>';
				echo '<div class="theme-font-set-default-preview">';
				$styles = array();
				$styles[] = "font-family:'".$font_obj->_family."'";

				if($font_obj->weight!== '400'){
					$styles[] = "font-weight:".$font_obj->weight;
				}
				if($font_obj->italic == true){
					$styles[] = "font-style: italic";
				}
				echo '<textarea rows="1" style="'.implode(';',$styles).'">'.$font_obj->name.'</textarea>';
				echo '<ul class="theme-font-set-subsets">';
				$selected_subsets = theme_get_google_font_subsets($font_obj->family);
				foreach ($font_obj->subsets as $subset) {
					echo '<li>';
					if(in_array($subset, $selected_subsets)){
						$checked = ' checked="checked"';
					}else{
						$checked = '';
					}
					echo '<input type="checkbox" id="gfonts_subsets_'.$font_obj->family.$subset.'" name="gfonts_subsets['.$font_obj->family.'][]" value="'.$subset.'"'.$checked.'>';
					echo '<label for="gfonts_subsets_'.$font_obj->family.$subset.'">'.$subset.'</label>';
					echo '</li>';
				}
				echo '</ul>';
				echo '</div>';
				echo '</li>';
				$count ++;
			}
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
	}

	function get_google_fonts(){
		global $google_fonts;
		if(!$google_fonts){
			$familys = get_option('theme_google_fonts_familys');
			if(empty($familys)){
				global $google_fonts;
				require_once (THEME_PLUGINS . '/google_font/google_font.php');
				$google_fonts = new Theme_google_fonts();
				$familys = $google_fonts->familys();
			}
		} else {
			$familys = $google_fonts->familys();
		}
				
		return $familys;
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
