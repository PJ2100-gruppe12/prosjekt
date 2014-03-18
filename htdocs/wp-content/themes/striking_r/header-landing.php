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
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<![endif]-->
<?php if(theme_get_option('advanced','responsive')):?>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, user-scalable=no" />
<?php endif;?>
<title><?php echo theme_generator('title'); ?></title>
<?php 
if($custom_favicon = theme_get_option('general','custom_favicon')) { ?>
<link rel="shortcut icon" href="<?php echo theme_get_image_src($custom_favicon); ?>" />
<?php } 
if($custom_favicon_57 = theme_get_option('general','custom_favicon_57')) { ?>
<link rel="apple-touch-icon" href="<?php echo theme_get_image_src($custom_favicon_57); ?>" />
<?php } 
if($custom_favicon_72 = theme_get_option('general','custom_favicon_72')) { ?>
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo theme_get_image_src($custom_favicon_72); ?>" />
<?php } 
if($custom_favicon_114 = theme_get_option('general','custom_favicon_114')) { ?>
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo theme_get_image_src($custom_favicon_114); ?>" />
<?php } 
if($custom_favicon_144 = theme_get_option('general','custom_favicon_144')) { ?>
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo theme_get_image_src($custom_favicon_144); ?>" />
<?php } 
if(!$custom_favicon_57 && !$custom_favicon_72 && !$custom_favicon_114 && !$custom_favicon_144 && !file_exists(ABSPATH.'apple-touch-icon.png')){ ?>
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo THEME_IMAGES; ?>/apple-touch-icon.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo THEME_IMAGES; ?>/apple-touch-icon-precomposed.png" />
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
<!-- Make IE8 and below responsive by adding CSS3 MediaQuery support -->
<!--[if lt IE 9]>
  <script type='text/javascript' src='<?php echo THEME_JS;?>/css3-mediaqueries.js'></script> 
<![endif]-->
<style type="text/css">
#header {
	padding-bottom: 0 !important;
}
</style>
</head>
<body <?php body_class(); ?>>
<div class="body-warp">
<header id="header">
	<div class="inner">
<?php if(theme_get_option('general','display_logo') && $custom_logo = theme_get_option('general','logo') ): 
	$mobile_logo = theme_get_option('general','mobile_logo');
?>
<div id="logo"<?php if($mobile_logo): ?> class="logo-has-mobile"<?php endif;?>>
	<a href="<?php echo home_url( '/' ); ?>">
		<img class="site-logo ie_png" src="<?php echo theme_get_image_src($custom_logo); ?>" alt="<?php bloginfo('name'); ?>"/>
<?php if($mobile_logo): ?>
		<img class="mobile-logo ie_png" src="<?php echo theme_get_image_src($mobile_logo); ?>" alt="<?php bloginfo('name'); ?>"/>
<?php endif;?>
	</a>
<?php if(theme_get_option('general','display_site_desc')){
		$site_desc = get_bloginfo( 'description' );
		if(!empty($site_desc)):?>
			<div id="site_description"><?php bloginfo( 'description' ); ?></div>
<?php endif;}?>
		</div>
<?php else:?>
		<div id="logo_text">
			<a id="site_name" href="#"><?php bloginfo('name'); ?></a>
<?php if(theme_get_option('general','display_site_desc')){
		$site_desc = get_bloginfo( 'description' );
		if(!empty($site_desc)):?>
			<div id="site_description"><?php bloginfo( 'description' ); ?></div>
<?php endif;}?>
		</div>
<?php endif; ?>
	</div>
</header>
