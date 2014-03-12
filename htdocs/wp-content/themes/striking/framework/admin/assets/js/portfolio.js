/* portfolio metabox */
jQuery(document).ready( function($) {
	jQuery('.meta-box-item select[name="_type"]').change(function(event){
		var groups = jQuery(this).parents('.meta-box-item').siblings('.meta-box-group').hide();
		
		switch(jQuery(this).val()){
			case 'image':
				groups.filter("#portfolio_image").show();
				break;
			case 'video':
				groups.filter("#portfolio_video").show();
				break;
			case 'lightbox':
				groups.filter("#portfolio_lightbox").show();
				break;
			case 'link':
				groups.filter("#portfolio_link").show();
				break;
		}
		if(jQuery(this).val() == "gallery"){
			jQuery('#portfolio_gallery').show();
		}else{
			jQuery('#portfolio_gallery').hide();
		}
	}).trigger('change');
});