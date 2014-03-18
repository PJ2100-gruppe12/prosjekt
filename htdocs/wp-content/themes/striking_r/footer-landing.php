<?php
/**
 * The template for displaying the footer.
 */

if(theme_get_option('footer','footer') || theme_get_option('footer','sub_footer')):
	wp_reset_query();
	if(is_front_page()){
		global $home_page_id;
		$footer_color = get_post_meta($home_page_id, '_footer_background_color', true);
	}else{
		$footer_color = get_post_meta(get_queried_object_id(), '_footer_background_color', true);
	}
	if(!empty($footer_color) && $footer_color != "transparent"){
		$footer_color = ' style="background-color:'.$footer_color.'"';
	}else{
		$footer_color = '';
	}
?>
<footer id="footer"<?php echo $footer_color;?>>
<?php if(theme_get_option('footer','sub_footer')):?>
	<div id="footer_bottom">
		<div class="inner">
			<div id="copyright"><?php echo wpml_t(THEME_NAME, 'Copyright Footer Text',stripslashes(theme_get_option('footer','copyright')))?></div>
			<div class="clearboth"></div>
		</div>
	</div>
<?php endif;?>
</footer>
<?php
endif;
	wp_footer();
	theme_add_cufon_code_footer();
	if(theme_get_option('general','analytics') && theme_get_option('general','analytics_position')=='bottom'){
		echo stripslashes(theme_get_option('general','analytics'));
	}
	if(theme_get_option('general','custom_js')){
		echo stripslashes(theme_get_option('general','custom_js'));
	}
?>
</div>
</body>
</html>
