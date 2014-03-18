jQuery(document).ready( function($) {
	$(document).on('click', 'a.widget-action', function(){
		$(this).parents('.widget').find('input.color').colorInput({
		  format:'HEX', 
		  components: {
	        saturation: true,
	        hue: true,
	        alpha: false,
	        extra: true
	      }
		});
	});
});