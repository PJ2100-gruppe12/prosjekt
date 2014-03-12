<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php _e('Preview','striking_admin'); ?></title>
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
	<script type="text/javascript" src="<?php echo THEME_JS;?>/html5.js"></script>
<![endif]-->
<script type="text/javascript">
var image_url='<?php echo THEME_IMAGES;?>';
</script>
</head>
<body class="preview" style="background:none">
<div id="page">
<div id="content">
<?php
if(isset($_POST['shortcode'])){
	echo str_replace(array('[raw]','[/raw]'),'',do_shortcode(stripcslashes($_POST['shortcode'])));
}
?>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>