<?php
/**
 * The default template for displaying slideshow in the pages
 */
function theme_section_slideshow($type, $category = '', $color = '',$number ='-1',$text = false) {
	/** fix **/
	if(empty($category)){
		$category = '{s}'; 
	}elseif(strpos($category, '|') != false){
		list($target, $cat) = explode("|", $category);
		$category = '{'.$target.':'.$cat.'}';
	}
	/** end fix **/

	// if there is no type setted
	if(empty($type)){
		$type = 'nivo';
	}
	require_once (THEME_HELPERS . '/slideshowGenerator.php');
	$slideshowGenerator = new slideshowGenerator;
	return $slideshowGenerator->render($type,$category,$color,$number,$text);
}