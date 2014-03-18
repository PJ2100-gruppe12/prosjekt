<?php
function theme_generator($slug){

	do_action( "theme_generator_{$slug}", $slug);
	$slug = apply_filters("theme_generator_{$slug}",$slug);

	$template = "{$slug}.php";

	theme_load_section($template);

	$args = array_slice( func_get_args(), 1 );

	$function = "theme_section_{$slug}";

	return call_user_func_array($function, $args );
}

function theme_load_section($template_name){
	if( file_exists(THEME_SECTIONS.'/'.$template_name)){
		require_once(THEME_SECTIONS.'/'.$template_name);
	}
}