<?php
function theme_shortcode_video($atts){
	if(isset($atts['type'])){
		switch($atts['type']){
			case 'html5':
				return theme_video_html5($atts);
				break;
			case 'flash':
				return theme_video_flash($atts);
				break;
			case 'youtube':
				return theme_video_youtube($atts);
				break;
			case 'vimeo':
				return theme_video_vimeo($atts);
				break;
			case 'dailymotion':
				return theme_video_dailymotion($atts);
				break;
			case 'blip':
				return theme_video_blip($atts);
				break;
		}
	}
	return '';
}
add_shortcode('video', 'theme_shortcode_video');
function theme_video_html5_print_scripts(){
	wp_print_styles('mediaelementjs-styles');
	wp_print_scripts('mediaelementjs-scripts');
}
function theme_video_html5($atts){
	extract(shortcode_atts(array(
		'mp4' => '',
		'webm' => '',
		'ogg' => '',
		'wmv' => '',
		'flv' => '',
		'poster' => '',
		'width' => false,
		'height' => false,
		'download' => false,
		'preload' => false,
		'autoplay' => false,
		"loop" => false,
		// captions
		'captions' => '',
		'captionslang' => 'en'
	), $atts));

	add_action('wp_footer', 'theme_video_html5_print_scripts');
	
	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);
	if (!$height && !$width){
		$height = theme_get_option('media','html5_height');
		$width = theme_get_option('media','html5_width');
	}
	
	if (!$download){
		$download = theme_get_option('media','html5_download');
	}else{
		if($download==='true'){
			$download = true;
		}else{
			$download = false;
		}
	}
	if (!$preload){
		$preload = theme_get_option('media','html5_preload');
	}else{
		if($preload==='true'){
			$preload = true;
		}else{
			$preload = false;
		}
	}
	if (!$autoplay){
		$autoplay = theme_get_option('media','html5_autoplay');
	}else{
		if($autoplay==='true'){
			$autoplay = true;
		}else{
			$autoplay = false;
		}
	}
	
	// MP4 Source Supplied
	$mp4_source = '';
	$flash_src = '';
	if ($mp4) {
		$mp4_source = '<source type="video/mp4" src="'.htmlspecialchars($mp4).'" />';
		$mp4_link = '<a href="'.$mp4.'">MP4</a>';
		$flash_src = htmlspecialchars($mp4);
	}

	// WebM Source Supplied
	$webm_source = '';
	if ($webm) {
		$webm_source = '<source type="video/webm" src="'.htmlspecialchars($webm).'" />';
		$webm_link = '<a href="'.$webm.'">WebM</a>';
		if(empty($flash_src)){
			$flash_src = htmlspecialchars($webm);
		}
	}

	// Ogg source supplied
	$ogg_source = '';
	if ($ogg) {
		$ogg_source = '<source type="video/ogg" src="'.htmlspecialchars($ogg).'" />';
		$ogg_link = '<a href="'.$ogg.'">Ogg</a>';
		if(empty($flash_src)){
			$flash_src = htmlspecialchars($ogg);
		}
	}
	
	// wmv source supplied
	$wmv_source = '';
	if ($wmv) {
		$wmv_source = '<source type="video/wmv" src="'.htmlspecialchars($wmv).'" />';
		$wmv_link = '<a href="'.$wmv.'">Wmv</a>';
		if(empty($flash_src)){
			$flash_src = htmlspecialchars($wmv);
		}
	}
	
	// flv source supplied
	$flv_source = '';
	if ($flv) {
		$flv_source = '<source type="video/flv" src="'.htmlspecialchars($flv).'" />';
		$flv_link = '<a href="'.$flv.'">Flv</a>';
		if(empty($flash_src)){
			$flash_src = htmlspecialchars($flv);
		}
	}
	
	$captions_source = '';
	if ($captions) {
		$captions_source = '<track src="'.$captions.'" kind="subtitles" srclang="'.$captionslang.'" />';
	}
	
	$poster_attribute = '';
	$poster_var = '';
	if ($poster) {
		$poster_attribute = 'poster="'.htmlspecialchars($poster).'"';
		$poster_var = 'poster='.htmlspecialchars($poster).'&amp;';
		$image_fallback = <<<_end_
			<img src="$poster" width="$width" height="$height" alt="Poster Image" title="No video playback capabilities." />
_end_;
	}
	
	if ($preload) {
		$preload_attribute = 'preload="auto"';
	} else {
		$preload_attribute = 'preload="none"';
	}
	
	$autoplay_var = '';
	if ($autoplay) {
		$poster_var = 'autoplay=true&amp;';
		$autoplay_attribute = "autoplay";
	} else {
		$autoplay_attribute = "";
	}
	$js_options = array();
	if ($loop) {
		$js_options[] = 'loop: ' . $loop;
	}
	$js_options_string = implode(",", $js_options);
	
	$uri = THEME_URI;
	
	if($download){
		$download_string = <<<HTML
<p class="vjs-no-video"><strong>Download Video:</strong>
		{$mp4_link}
		{$webm_link}
		{$ogg_link}
		{$flv}
		{$wmv}
</p>
HTML;
	} else {
		$download_string = '';
	}
	$src_attribute = 'src="'+$flash_src+'"';
	$id = rand(100,1000);
	$uri = THEME_URI;
	return <<<HTML
[raw]<div class="video_frame">
<video id="html5_video_{$id}" width="{$width}" height="{$height}" {$poster_attribute} controls="controls" {$preload_attribute} {$autoplay_attribute}>
{$mp4_source}{$webm_source}{$ogg_source}{$flv_source}{$wmv_source}{$captions_source}
	<object width="{$width}" height="{$height}" type="application/x-shockwave-flash" data="{$uri}/mediaelement/flashmediaelement.swf">
		<param name="movie" value="{$uri}/mediaelement/flashmediaelement.swf" />
		<param name="flashvars" value="controls=true&amp;{$poster_var}{$autoplay_var}file={$flash_src}" />
		{$image_fallback}
	</object>
</video>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery("#html5_video_{$id}").mediaelementplayer({{$js_options_string}});
});
</script>[/raw]
HTML;
}

function theme_video_flash($atts) {
	extract(shortcode_atts(array(
		'src' 	=> '',
		'id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
		'play'		=> 'false',
		'flashvars' => '',
	), $atts));
	
	if($id!=''){
		$id = ' id="'.$id.'"';
	}
	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);
	if (!$height && !$width){
		$height = theme_get_option('media','flash_height');
		$width = theme_get_option('media','flash_width');
	}

	$uri = THEME_URI;
	if (!empty($src)){
		return <<<HTML
<div class="video_frame">
<object{$id} class="flash" width="{$width}" height="{$height}" type="application/x-shockwave-flash" data="{$src}">
	<param name="movie" value="{$src}" />
	<param name="allowFullScreen" value="true" />
	<param name="allowscriptaccess" value="always" />
	<param name="expressInstaller" value="{$uri}/swf/expressInstall.swf"/>
	<param name="play" value="{$play}"/>
	<param name="wmode" value="transparent" />
	<embed src="$src" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" allowfullscreen="true" width="{$width}" height="{$height}" />
</object>
</div>
HTML;
	}
}


function theme_video_blip($atts) {
	extract(shortcode_atts(array(
		'clip_id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
	), $atts));
	
	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);
	if (!$height && !$width){
		$height = theme_get_option('media','blip_height');
		$width = theme_get_option('media','blip_width');
	}
	
	$uri = THEME_URI;
	if (!empty($clip_id) && is_numeric($clip_id)){
		return <<<HTML
<div class="video_frame">
<object class="flash" width="{$width}" height="{$height}" type="application/x-shockwave-flash">
	<param name="movie" value="http://blip.tv/scripts/flash/showplayer.swf?file=http://blip.tv/rss/flash/{$clip_id}" />
	<param name="allowFullScreen" value="true" />
	<param name="allowscriptaccess" value="always" />
	<param name="expressInstaller" value="{$uri}/swf/expressInstall.swf"/>
	<param name="wmode" value="transparent" />
	<embed src="http://blip.tv/scripts/flash/showplayer.swf?file=http://blip.tv/rss/flash/{$clip_id}" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" allowfullscreen="true" width="{$width}" height="{$height}" />
</object>
</div>
HTML;
	}
}

function theme_video_vimeo($atts) {
	extract(shortcode_atts(array(
		'clip_id' 	=> '',
		'width' => false,
		'height' => false,
		'byline'    => false,
		'title'     => false,
		'portrait'  => false,
		'autoplay'  => false,
		'loop'      => false,
	), $atts));

	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);
	if (!$height && !$width){
		$height = theme_get_option('media','vimeo_height');
		$width = theme_get_option('media','vimeo_width');
	}
	if (!$byline){
		$byline = (theme_get_option('media','vimeo_byline') == true)?1:0;
	}else{
		if($byline==='true'){
			$byline = '1';
		}else{
			$byline = '0';
		}
	}
	if (!$title){
		$title = (theme_get_option('media','vimeo_title') == true)?1:0;
	}else{
		if($title==='true'){
			$title = '1';
		}else{
			$title = '0';
		}
	}
	if (!$portrait){
		$portrait = (theme_get_option('media','vimeo_portrait') == true)?1:0;
	}else{
		if($portrait==='true'){
			$portrait = '1';
		}else{
			$portrait = '0';
		}
	}
	if (!$autoplay){
		$autoplay = (theme_get_option('media','vimeo_autoplay') == true)?1:0;
	}else{
		if($autoplay==='true'){
			$autoplay = '1';
		}else{
			$autoplay = '0';
		}
	}
	if (!$loop){
		$loop = (theme_get_option('media','vimeo_loop') == true)?1:0;
	}else{
		if($loop==='true'){
			$loop = '1';
		}else{
			$loop = '0';
		}
	}

	if (!empty($clip_id) && is_numeric($clip_id)){
		return "<div class='video_frame'><iframe class='vimeo' style='height:{$height}px;width:{$width}px' src='http://player.vimeo.com/video/$clip_id?title={$title}&amp;byline={$byline}&amp;portrait={$portrait}&amp;autoplay={$autoplay}&amp;loop={$loop}' width='$width' height='$height' frameborder='0'></iframe></div>";
	}
}

function theme_video_youtube($atts, $content=null) {
	extract(shortcode_atts(array(
		'clip_id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
		'autohide'  => false,
		'autoplay'  => false,
		'controls'  => false,
		'disablekb' => false,
		'fs'        => false,
		'loop'      => false,
		'rel'       => false,
		'showinfo'  => false,
		'start'     => '0',
		'modestbranding' => false,
		'theme'     => 'default',
	), $atts));
	
	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16) + 25;
	if (!$height && !$width){
		$height = theme_get_option('media','youtube_height');
		$width = theme_get_option('media','youtube_width');
	}
	if (!$autohide){
		$autohide = theme_get_option('media','youtube_autohide');
	}
	if (!$autoplay){
		$autoplay = (theme_get_option('media','youtube_autoplay') == true)?1:0;
	}else{
		if($autoplay==='true'){
			$autoplay = '1';
		}else{
			$autoplay = '0';
		}
	}
	if($autoplay!='1'){
		$autoplay = '';
	}else{
		$autoplay = '&amp;autoplay=1';
	}
	if (!$controls){
		$controls = (theme_get_option('media','youtube_controls') == true)?1:0;
	}else{
		if($controls==='true'){
			$controls = '1';
		}else{
			$controls = '0';
		}
	}
	if (!$disablekb){
		$disablekb = (theme_get_option('media','youtube_disablekb') == true)?1:0;
	}else{
		if($disablekb==='true'){
			$disablekb = '1';
		}else{
			$disablekb = '0';
		}
	}
	if ($theme === 'default'){
		$theme = theme_get_option('media','youtube_theme');
	}
	if (!$fs){
		$fs = (theme_get_option('media','youtube_fs') == true)?1:0;
	}else{
		if($fs==='true'){
			$fs = '1';
		}else{
			$fs = '0';
		}
	}
	
	if (!$loop){
		$loop = (theme_get_option('media','youtube_loop') == true)?1:0;
	}else{
		if($loop==='true'){
			$loop = '1';
		}else{
			$loop = '0';
		}
	}
	if (!$rel){
		$rel = (theme_get_option('media','youtube_rel') == true)?1:0;
	}else{
		if($rel==='true'){
			$rel = '1';
		}else{
			$rel = '0';
		}
	}
	if (!$showinfo){
		$showinfo = (theme_get_option('media','youtube_showinfo') == true)?1:0;
	}else{
		if($showinfo==='true'){
			$showinfo = '1';
		}else{
			$showinfo = '0';
		}
	}

	if (!$modestbranding){
		$modestbranding = (theme_get_option('media','youtube_modestbranding') == true)?1:0;
	}else{
		if($modestbranding==='true'){
			$modestbranding = '1';
		}else{
			$modestbranding = '0';
		}
	}

	if (!empty($clip_id)){
		return "<div class='video_frame' style='height:{$height}px;width:{$width}px'><iframe class='youtube' style='height:100%;width:100%' src='http://www.youtube.com/embed/{$clip_id}?enablejsapi=1&amp;autohide={$autohide}{$autoplay}&amp;controls={$controls}&amp;disablekb={$disablekb}&amp;fs={$fs}&amp;start={$start}&amp;loop={$loop}&amp;rel={$rel}&amp;showinfo={$showinfo}&amp;theme={$theme}&amp;modestbranding={$modestbranding}&amp;wmode=transparent' width='100%' height='100%' frameborder='0'></iframe></div>";
	}
}

function theme_video_dailymotion($atts, $content=null) {
	extract(shortcode_atts(array(
		'clip_id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
		'related'   => false,
		'autoplay'  => false,
		'chromeless'=> false,
	), $atts));
	
	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);
	if (!$height && !$width){
		$height = theme_get_option('media','dailymotion_height');
		$width = theme_get_option('media','dailymotion_width');
	}
	if (!$related){
		$related = (theme_get_option('media','dailymotion_related') == true)?1:0;
	}else{
		if($related==='true'){
			$related = '1';
		}else{
			$related = '0';
		}
	}
	if (!$autoplay){
		$autoplay = (theme_get_option('media','dailymotion_autoplay') == true)?1:0;
	}else{
		if($autoplay==='true'){
			$autoplay = '1';
		}else{
			$autoplay = '0';
		}
	}
	if (!$chromeless){
		$chromeless = (theme_get_option('media','dailymotion_chromeless') == true)?1:0;
	}else{
		if($chromeless==='true'){
			$chromeless = '1';
		}else{
			$chromeless = '0';
		}
	}
//&additionalInfos=0
//&hideInfos=0
	if (!empty($clip_id)){
		return "<div class='video_frame'><iframe class='dailymotion' style='height:{$height}px;width:{$width}px' src='http://www.dailymotion.com/embed/video/$clip_id?width=$width&amp;autoPlay={$autoplay}&amp;related={$related}&amp;chromeless={$chromeless}&amp;theme=none&amp;foreground=%23F7FFFD&amp;highlight=%23FFC300&amp;background=%23171D1B&amp;iframe=1&amp;wmode=transparent' width='$width' height='$height' frameborder='0'></iframe></div>";
	}
}

add_shortcode('audio', 'theme_audio');
function theme_audio($atts){
	extract(shortcode_atts(array(
		'mp3' => '',
		'ogg' => '',
		'width' => false,
		'height' => false,
		'preload' => false,
		'autoplay' => false,
		"loop" => false,
	), $atts));
	wp_print_styles('mediaelementjs-styles');
	wp_print_scripts('mediaelementjs-scripts');
	
	$js_options = array();
	if (!$width){
		$width = theme_get_option('media','audio_width');
	}
	if (!$height){
		$height = theme_get_option('media','audio_height');
	}
	if (!$preload){
		$preload = theme_get_option('media','audio_preload');
	}else{
		if($preload==='true'){
			$preload = true;
		}else{
			$preload = false;
		}
	}
	if (!$autoplay){
		$autoplay = theme_get_option('media','audio_autoplay');
	}else{
		if($autoplay==='true'){
			$autoplay = true;
		}else{
			$autoplay = false;
		}
	}
	if (!$loop){
		$loop = theme_get_option('media','audio_loop');
	}
	if($loop===false){
		$loop = 'false';
	}else{
		$loop = 'true';
	}
	
	if ($loop) {
		$js_options[] = 'loop: ' . $loop;
	}
	$js_options[] = 'audioWidth: ' . $width;
	$js_options[] = 'audioHeight: ' . $height;
	$js_options_string = implode(",", $js_options);
	
	// MP3 Source Supplied
	if ($mp3) {
		$mp3_source = '<source type="audio/mp3" src="'.htmlspecialchars($mp3).'" />';
		$flash_src = htmlspecialchars($mp3);
	}
	
	// ogg source supplied
	if ($ogg) {
		$ogg_source = '<source type="audio/ogg" src="'.htmlspecialchars($ogg).'" />';
		if(empty($flash_src)){
			$flash_src = htmlspecialchars($ogg);
		}
	}
	
	
	if ($preload) {
		$preload_attribute = 'preload="auto"';
	} else {
		$preload_attribute = 'preload="none"';
	}

	if ($autoplay) {
		$autoplay_attribute = "autoplay";
	} else {
		$autoplay_attribute = "";
	}
	
	
	$uri = THEME_URI;
	
	$src_attribute = 'src="'+$flash_src+'"';
	$id = rand(100,1000);
	$uri = THEME_URI;
	return <<<HTML
[raw]<div class="audio_frame">
<audio id="html5_audio_{$id}" width="{$width}" height="{$height}" controls="controls" {$preload_attribute} {$autoplay_attribute}>
    {$mp3_source}
	{$ogg_source}
	<object width="{$width}" height="{$height}" type="application/x-shockwave-flash" data="{$uri}/mediaelement/flashmediaelement.swf">
		<param name="movie" value="{$uri}/mediaelement/flashmediaelement.swf" />
		<param name="flashvars" value="controls=true&amp;file={$flash_src}" />
	</object>
</audio>
</div>
<script type="text/javascript">
	var toggle = jQuery("#html5_audio_{$id}").parents('.toggle');
	jQuery("#html5_audio_{$id}").bind('initMediaelement',function(){
		jQuery(this).mediaelementplayer({{$js_options_string}});
		jQuery(this).data("mediaelementInited",true);
	}).data("mediaelementInited",false);

	if(toggle.size()!=0){
		toggle.find('.toggle_title').click(function() {
			if(jQuery("#html5_audio_{$id}").data("mediaelementInited")==false){
				jQuery("#html5_audio_{$id}").trigger('initMediaelement');
			}
		});
	}else{
		jQuery("#html5_audio_{$id}").trigger('initMediaelement');
	}
</script>[/raw]
HTML;
}