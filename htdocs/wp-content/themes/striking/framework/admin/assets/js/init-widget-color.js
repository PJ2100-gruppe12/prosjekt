jQuery(document).ready( function($) {
	$.fn.mColorPicker.defaults.imageFolder = theme_admin_assets_uri + "/images/mColorPicker/";
	
	$('input[data-mcolorpicker!="true"]').filter(function() {
        return ($.fn.mColorPicker.init.replace == '[type=color]')? this.getAttribute("type") == 'color': $(this).is($.fn.mColorPicker.init.replace);
    }).mColorPicker();
});