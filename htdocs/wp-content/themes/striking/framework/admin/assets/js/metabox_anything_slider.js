/* portfolio metabox */
jQuery(document).ready( function($) {
	jQuery('.meta-box-item select[name="_anything_type"]').change(function(event){
		var types = ['image','html','sidebar'];
		var selected = jQuery(this).val();
		$.each(types,function(i,type){
			if(selected != type){
				$('[data-group="'+type+'"]').hide();
			}else{
				$('[data-group="'+type+'"]').show();
			}
		});
	}).trigger('change');
});