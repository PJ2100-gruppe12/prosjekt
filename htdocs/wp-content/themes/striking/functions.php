<?php 
/**
 * Theme framework initialization
 *
 * Sets up the theme and provides some helper functions.
 *
 * This file will not be overrided by theme updates. So you can add Your custom functions here. 
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package Striking
 */

if(!class_exists('Theme')){
	/* Load the Theme class. */
	require_once (TEMPLATEPATH . '/framework/theme.php');

	$theme = new Theme();
	$options = include(TEMPLATEPATH . '/framework/info.php');

	$theme->init($options);
}

/* You custom functions below */
