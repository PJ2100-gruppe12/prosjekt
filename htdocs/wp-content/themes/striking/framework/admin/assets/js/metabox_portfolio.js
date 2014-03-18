/* portfolio metabox */
jQuery(document).ready( function($) {
	jQuery('.meta-box-item select[name="_type"]').change(function(event){
		var types = ['image','video','lightbox','link','gallery'];
		var selected = jQuery(this).val();
		$.each(types,function(i,type){
			if(selected != type){
				$('#portfolio_type_'+type).addClass('disabled');
			}else{
				$('#portfolio_type_'+type).removeClass('disabled');
			}
		});
	}).trigger('change');
});