<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section
 */
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo theme_generator('title'); ?></title>
<?php if($custom_favicon = theme_get_option('general','custom_favicon')) { ?>
<link rel="shortcut icon" href="<?php echo theme_get_image_src($custom_favicon); ?>" />
<?php } ?>

<!-- Feeds and Pingback -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

<!--[if IE 6 ]>
	<link href="<?php echo THEME_CSS;?>/ie6.css" media="screen" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo THEME_JS;?>/dd_belatedpng-min.js"></script>
	<script type="text/javascript" src="<?php echo THEME_JS;?>/ie6.js"></script>
<![endif]-->
<!--[if IE 7 ]>
<link href="<?php echo THEME_CSS;?>/ie7.css" media="screen" rel="stylesheet" type="text/css">
<![endif]-->
<!--[if IE 8 ]>
<link href="<?php echo THEME_CSS;?>/ie8.css" media="screen" rel="stylesheet" type="text/css">
<![endif]-->
<!--[if IE]>
	<script type="text/javascript" src="<?php echo THEME_JS;?>/html5shiv.js"></script>
<![endif]-->
</head>
<body <?php body_class(); ?>>
<header id="header">
	<div class="inner">
<?php if(theme_get_option('general','display_logo') && $custom_logo = theme_get_option('general','logo') ): 
?>
<div id="logo">
	<a href="<?php echo home_url( '/' ); ?>"><img class="ie_png" src="<?php echo theme_get_image_src($custom_logo); ?>" alt="<?php bloginfo('name'); ?>"/></a>
<?php if(theme_get_option('general','display_site_desc')){
		$site_desc = get_bloginfo( 'description' );
		if(!empty($site_desc)):?>
			<div id="site_description"><?php bloginfo( 'description' ); ?></div>
<?php endif;}?>
		</div>
<?php else:?>
		<div id="logo_text">
			<a id="site_name" href="<?php echo home_url( '/' ); ?>"><?php bloginfo('name'); ?></a>
<?php if(theme_get_option('general','display_site_desc')){
		$site_desc = get_bloginfo( 'description' );
		if(!empty($site_desc)):?>
			<div id="site_description"><?php bloginfo( 'description' ); ?></div>
<?php endif;}?>
		</div>
<?php endif; ?>
<?php $top_area_type = theme_get_option('general','top_area_type');
	switch($top_area_type){
		case 'html':
			if(theme_get_option('general','top_area_html')){
				echo '<div id="top_area">';
				echo wp_loginout();
				echo str_replace(array('[raw]','[/raw]'),'',do_shortcode(wpml_t(THEME_NAME, 'Top Area Html Code', stripslashes( theme_get_option('general','top_area_html') ))));
				echo '</div>';
			}
			break;
		case 'wpml_flags':
			echo theme_generator('wpml_flags');
			break;
		case 'widget':
			echo '<div id="top_area">';
			dynamic_sidebar(__('Header Widget Area','theme_admin'));
			echo '</div>';
			break;
	}
?>
		<?php echo theme_generator('menu');?>
	</div>
</header>