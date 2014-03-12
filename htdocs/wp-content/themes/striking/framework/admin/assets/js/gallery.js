var themeGalleryGetImage,themeGalleryGetAllImages,themeGalleryCompleteEditImage,themeGalleryDeleteImage,themeGalleryImagesSetIds;
(function($){

themeGalleryGetImage = function(attachment_id){
	jQuery.post(ajaxurl, {
		action:'theme-gallery-get-image',
		id: attachment_id, 
		cookie: encodeURIComponent(document.cookie)
	}, function(str){
		if ( str == '0' ) {
			alert( 'Could not insert into gallery. Try a different attachment.' );
		} else {
			jQuery("#images_sortable").append(str);
			themeGalleryImagesSetIds();
		}
	});
	//var field = $('input[value=_thumbnail_id]', '#list-table');
	//if ( field.size() > 0 ) {
	//	$('#meta\\[' + field.attr('id').match(/[0-9]+/) + '\\]\\[value\\]').text(id);
	//}
};

themeGalleryGetAllImages = function(attachment_ids){
	jQuery.each(attachment_ids, function() { 
		themeGalleryGetImage(parseInt(this));
	});
};


themeGalleryCompleteEditImage = function(attachment_id){
	jQuery.post(ajaxurl, {
		action:'theme-gallery-get-image',
		id: attachment_id, 
		cookie: encodeURIComponent(document.cookie)
	}, function(str){
		if ( str == '0' ) {
			alert( 'Could not insert into gallery. Try a different attachment.' );
		} else {
			jQuery("#image-"+ attachment_id).replaceWith(str);
			themeGalleryImagesSetIds();
		}
	});
};

themeGalleryDeleteImage = function(attachment_id){
	jQuery("#image-"+ attachment_id).remove();
	themeGalleryImagesSetIds();
};

themeGalleryImagesSetIds = function(){
	var ids = jQuery('#images_sortable').sortable('toArray').toString();
	jQuery('#gallery_image_ids').val(ids);
}

})(jQuery);

jQuery(document).ready( function($) {

	jQuery("#images_sortable").sortable({
		handle: '.handle',
		opacity: 0.6,
		placeholder: 'sort-item-placeholder',
		stop: function(event, ui) {
			themeGalleryImagesSetIds();
		}
	});


	jQuery('.edit-item',"#images_sortable").live('click', function(){
		var id = jQuery(this).parents('.imageItemWrap').attr('id').slice(6);//remove "image-"
		
		tb_show('Edit Image',"media.php?action=edit&attachment_id="+id+"&gallery_edit_image=true&TB_iframe=true");
	})

	jQuery('.delete-item',"#images_sortable").live('click', function(){
		var id = jQuery(this).parents('.imageItemWrap').attr('id').slice(6);//remove "image-"
		
		themeGalleryDeleteImage(id);
	})


});





