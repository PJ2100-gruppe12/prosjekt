<?php
class Theme_Slideshow_3d {
	function header() {
		
	}

	function render($category='',$color='',$number='-1',$text = false) {
		if(!empty($color) && $color != "transparent"){
			$color = ' style="background-color:'.$color.'"';
		}else{
			$color = '';
		}
		if($text){
			$text = '<div class="inner"><div id="introduce" class="slider_top">'.$text.'</div></div>';
		}else{
			$text = '';
		}
		$height = theme_get_option('slideshow', '3d_height');
		$wrap_height = $height+70;
		$uri = THEME_URI;
		$uploads = wp_upload_dir();
		if($category == '{g}'){
			$category = '{g:'.get_queried_object_id().'}';
		}
		$category = $category?'[category='.$category.']':'';
		$lang = wpml_get_current_languages();
		if($lang){
			$lang = '[lang='.$lang.']';
		}else{
			$lang = '';
		}
		$noflash = __('You need to <a href="http://www.adobe.com/products/flashplayer/" target="_blank">upgrade your Flash Player</a> to version 10 or newer.','striking_front');
		$output = <<<HTML

<div id="feature" class="3d"{$color}>
	<div class="top_shadow"></div>{$text}
	<object width="100%" height="{$wrap_height}" type="application/x-shockwave-flash" data="{$uri}/piecemaker/piecemaker_{$height}.swf" id="piecemaker">
		<param name="wmode" value="transparent">
		<param name="expressInstaller" value="{$uri}/swf/expressInstall.swf"/>
		<param name="flashvars" value="xmlSource={$uri}/piecemaker/piecemakerXML.php?vars=[number={$number}]{$category}{$lang}&amp;cssSource={$uri}/piecemaker/piecemakerCSS.css&amp;imageSource={$uploads['baseurl']}">
		<param name="movie" value="{$uri}/piecemaker/piecemaker_{$height}.swf"/>
		<embed src="{$uri}/piecemaker/piecemaker_{$height}.swf" type="application/x-shockwave-flash" wmode="transparent" width="100%" height="{$wrap_height}" />
	</object>
	<div class="bottom_shadow"></div>
</div>
HTML;
		return $output;
	}
}