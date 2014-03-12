var theme;
(function($){
	var api,s;

	// Initialize the shortcode/api object
	theme = api = {};
	
	api.init = function(options){
		s = api.settings = $.extend({}, api.settings, options);
		
		api.option.init();
	};
	
	// theme options init functions
	api.option = {};
	
	api.option.init = function(){
		api.option.select();
		api.option.multiDropdown();
		api.option.ddMultiSelect();
		api.option.superLink();
		api.option.uploader();
		api.option.range();
		api.option.measurement();
		api.option.validator();
		api.option.color();
		api.option.toggle();
		api.option.triToggle();
		api.option.switchDesc();
		api.option.fontchosen();
	};
	api.option.fontchosen = function(){
		var initFontChosen = function(element){
			var $placeholder = $(element).attr('data-placeholder');
			if($placeholder!=undefined){
				$(element).data("placeholder", $placeholder);
			}
			$(element).chosen();
			var chosen = $(element).data('chosen');
			var $preview = $(element).parent().find('.theme-font-preview');
			var $preview_name = $preview.find('.theme-font-preview-name');
			var $preview_callback = eval($preview.data('callback'));
			chosen.old_do_highlight = chosen.result_do_highlight;
			chosen.result_do_highlight = function(el){
				if (el.length) {
					var high_id = $(el).attr("id");
					var position = high_id.substr(high_id.lastIndexOf("_") + 1);
					var font = chosen.results_data[position];
					$preview_callback($preview, font);
					$preview_name.text(font.text);
					$preview.show();
				}

				return chosen.old_do_highlight(el);
			}

			
			chosen.search_field.on('blur',function(){
				$preview.hide();
			});
		}
		$("select.fontchosen").each(function(){
			api.option._initInvisibleElement(this,function(){
				initFontChosen(this);
			});
		});
	};
	api.option.select = function(){
		var initChosen = function(element){
			var $placeholder = $(element).attr('data-placeholder');
			if($placeholder!=undefined){
				$(element).data("placeholder", $placeholder);
			}
			if($(element).data("order")==true){
				$(element).val('');
				$(element).chosen();
				var $ordered = $('[name="_'+$(element).attr('id')+'"]');
				
				var selected = $ordered.val().split(',');
				var chosen_object = $(element).data('chosen');

				/**
				 * 1, 2, 3 fix mouseup focus issue
				 */
				chosen_object.search_field.unbind('focus');/* 1 */
				$.each(selected, function(index, item){
					$.each(chosen_object.results_data, function(i, data){
						if(data.value === item){
							$("#"+data.dom_id).trigger('mouseup');
						}
					});
				});
				chosen_object.search_field.focus(function(evt) { /* 2 */
					return chosen_object.input_focus(evt);
				});
				chosen_object.search_field.trigger('blur'); /* 3 */

				
				$(element).data("backupVal",$(element).val());
				$(element).change(function(){
					var backup = $(this).data("backupVal");
					var current = $(this).val();
					if(backup == null){
						backup = [];
					}
					if(current == null){
						current = [];
					}
					if(backup.length > current.length){							
						$.each(backup, function(index, item) { 
							if($.inArray(item, current) < 0){
								for(var i=0; i<selected.length; i++){
									if(selected[i] == item){
										selected.splice(i,1);
									}
								}
							}
						});
					}else if(backup.length < current.length){
						$.each(current, function(index, item) { 
							if($.inArray(item, backup) < 0){
								selected.push(item);
							}
						});
					}
					$ordered.val(selected.join(','));
					$(this).data("backupVal",current);
				});
			}else{
				$(element).chosen();
			}
		}
		$("select.chosen").each(function(){
			api.option._initInvisibleElement(this,function(){
				initChosen(this);
			});
		});
		
	};
	api.option.multiDropdown = function(){
		var wrap = $(".multidropdown-wrap");

		wrap.each(function() {
			var selects = $(this).children('select');
			var field = $(this).siblings('input:hidden');
			field.val("");
			var name = field.attr("name");
			selects.each(function(i) {
				if ($(this).val()) {
					if (field.val()) {
						field.val(field.val() + ',' + $(this).val());
					} else {
						field.val($(this).val());
					}
				}
				$(this).attr('id', name + '_' + i);
				$(this).attr('name', name + '_' + i);

				$(this).unbind('change').bind('change',function() {
					if ($(this).val() && selects.length == i + 1) {
						$(this).clone().val("").appendTo(wrap);
					} else if (!($(this).val())
							&& !(selects.length == i + 1)) {
						$(this).remove();
					}
					api.option.multiDropdown();
				});
			})
		});
	};
	api.option.ddMultiSelect = function(){
		var wrap = $(".ddmultiselect-wrap");

		wrap.each(function() {
			var field = $(this).siblings('input:hidden');
			var enabled = $(this).find('.ddmultiselect-enabled-holder ul');
			var disabled = $(this).find('.ddmultiselect-disabled-holder ul');
			enabled.sortable({
				connectWith: disabled,
				dropOnEmpty: true,
				placeholder: 'ddmultiselect-placeholder',
				items: 'li',
				update: function(event, ui){
					var $values = jQuery.map(enabled.find('li'),function(item){
						return $(item).data('value');
					});
					field.val($values.join(','));
				}
			}).disableSelection();
			disabled.sortable({
				connectWith: enabled,
				dropOnEmpty: true,
				placeholder: 'ddmultiselect-placeholder',
				items: 'li'
			}).disableSelection();
		});
	};
	api.option.superLink = function() {
		var wrap = $(".superlink-wrap");
		wrap.each(function(){
			var field = $(this).siblings('input:hidden');
			var selector = $(this).siblings('select');
			var name = field.attr('name');
			var items = $(this).children();
			selector.change(function(){
				items.hide();
				$("#"+name+"_"+$(this).val()).show();
				field.val('');
			});
			items.change(function(){
				field.val(selector.val()+'||'+$(this).val());
			})
		});
	};
	
	api.option.uploader = function(){
		if($('.theme-add-media-button').length > 0){
			// thank to http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
			var file_frame;

			jQuery('.theme-add-media-button').on('click', function( event ){
				var button = $(this);
    			var target = button.data('target');

    			button.blur();
				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
				  file_frame.open();
				  return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
				  title: jQuery( this ).data( 'uploader_title' ),
				  button: {
				    text: jQuery( this ).data( 'uploader_button_text' ),
				  },
				  multiple: false  // Set to true to allow multiple files to be selected
				});

				file_frame.on( 'select', function() {
					attachment = file_frame.state().get('selection').first().toJSON();
					imagewidth = $('#'+target+'_preview').attr('data-imagewidth');
					if(parseInt(attachment.width,10)<parseInt(imagewidth,10)){
						imagewidth = attachment.width;
					}
					if($("#"+target).size()>0){
						$("#"+target).val('{"type":"attachment_id","value":"'+attachment.id+'"}');
						$("#"+target+"_preview").html('<a class="thickbox" href="'+attachment.url+'?"><img  width="'+imagewidth+'" src="'+attachment.url+'"/></a>');
					}
				});

				file_frame.open();
			});
		}
		
		$(".theme-upload-remove").click(function(){
			$content = $(this).parent().parent();
			$content.find('.upload-value').val('');
			$content.find('.theme-option-image-preview').html('');
		});
	};
	
	api.option.uploader.getImage = function(attachment_id,target){
		$.post(ajaxurl, {
			action:'theme-option-get-image',
			id: attachment_id, 
			cookie: encodeURIComponent(document.cookie)
		}, function(src){
			if ( src == '0' ) {
				alert( 'Could not use this image. Try a different attachment.' );
			} else {
				if($("#"+target).size()>0){
					$("#"+target).val(src);
					$("#"+target+"_preview").html('<a class="thickbox" href="'+src+'?"><img src="'+src+'"/></a>');
				}
			}
		});
	};
	api.option.uploader.getImageByAttachmentId = function(attachment_id,target){
		$.post(ajaxurl, {
			action:'theme-option-get-image-by-attachment-id',
			id: attachment_id, 
			cookie: encodeURIComponent(document.cookie)
		}, function(data){
			if ( data == '0' ) {
				alert( 'Could not use this image. Try a different attachment.' );
			} else {
				var data = $.parseJSON(data);
				imagewidth = $('#'+target+'_preview').attr('data-imagewidth');
				if(data.width<imagewidth){
					imagewidth = data.width;
				}

				if($("#"+target).size()>0){
					$("#"+target).val('{"type":"attachment_id","value":"'+attachment_id+'"}');
					$("#"+target+"_preview").html('<a class="thickbox" href="'+data.src+'?"><img  width="'+imagewidth+'" src="'+data.src+'"/></a>');
				}
			}
		});
	};

	api.option.uploader.getImageByUrl = function(src,title,target){
		$.post(ajaxurl, {
			action:'theme-option-get-image-by-url',
			src: src, 
			cookie: encodeURIComponent(document.cookie)
		}, function(data){
			if ( data == '0' ) {
				alert( 'Could not use this image. Try a different attachment.' );
			} else {
				var data = $.parseJSON(data);
				imagewidth = $('#'+target+'_preview').attr('data-imagewidth');

				if($("#"+target).size()>0){
					if(title != ''){
						$("#"+target).val('{"type":"url","title":"'+title+'","value":"'+src+'"}');
					}else{
						$("#"+target).val('{"type":"url","value":"'+src+'"}');
					}
					
					$("#"+target+"_preview").html('<a class="thickbox" href="'+src+'?"><img  width="'+imagewidth+'" src="'+src+'"/></a>');
				}
			}
		});
	};

	api.option.range = function(){
		$(".range-input-wrap :range").rangeinput();
	};
	api.option.measurement = function(){
		var wrap = $(".measurement-wrap");
		wrap.each(function(){
			var field = $(this).find('input:hidden');
			var range = $(this).find('input:range');
			var unit = $(this).find('select');
			var name = field.attr('name');
			var items = $(this).children();
			range.change(function(){
				if($(this).val() != 0){
					field.val($(this).val()+unit.val());
				}else{
					field.val('');
				}
			});
			unit.change(function(){
				if(range.val() != 0){
					field.val(range.val()+$(this).val());
				}else{
					field.val('');
				}
			})
		});
	};
	
	
	api.option.validator = function(){
		$.tools.validator.addEffect("option", function(errors, event) {
			// add new ones
			$.each(errors, function(index, error) {
				var input = error.input;
				input.addClass("invalid");
				var msg = input.next('.validator-error').empty();
				$.each(error.messages, function(i, m) {
					$("<span/>").html(m).appendTo(msg);			
				});
			});
			
		// the effect does nothing when all inputs are valid	
		}, function(inputs)  {
			inputs.removeClass("invalid").each(function() {
				$(this).next('.validator-error').empty();
			});
		});
		$(".validator-wrap :input").validator({effect:'option'});
	};
	
	api.option.color = function(){
		$.fn.mColorPicker.init.showLogo = false;
		$.fn.mColorPicker.defaults.imageFolder = theme_admin_assets_uri + "/images/mColorPicker/";
	};
	
	api.option.toggle = function(){
		$('.toggle-button:checkbox').each(function(){
			api.option._initInvisibleElement(this,function(){
				$(this).iphoneStyle();
			});
		});
	};
	
	api.option.triToggle = function(){
		$('select.tri-toggle-button').each(function(){
			api.option._initInvisibleElement(this,function(){
				$(this).iphoneStyleTriToggle();
			});
		});
	};
	
	api.option.switchDesc = function(){
		$('.meta-box-item-switch,.theme-page-option-switch').click(function(event){
			$(this).parent().siblings('.description').toggle();
			event.preventDefault();
		});
	};

	api.option.getVal = function(name){
		var target = $('[name="'+name+'"]');
		if(target.size() == 0){
			target = $('[name="'+name+'[]"]');
		}
		if(target.is('.toggle-button')){
			if(target.is(':checked')){
				return true;
			}else{
				return false;
			}
		}
		if(target.is('.tri-toggle-button')){
			switch(target.val()){
				case 'true':
					return true;
				case 'false':
					return false;
				case 'default':
					return '';
			}
		}
		return target.val();
	};
	
	api.option._initInvisibleElement = function(element,callback){
		var $element = $(element);
		if($element.parents('.meta-box-container').is('.with-tabs')){
			if(!$element.parents('.meta-box-pane').hasClass('active')){
				$element.parents('.meta-box-container').find('.meta-box-tabs li').eq($element.parents('.meta-box-pane').index()).bind('click',function(e){
					callback.call(element);
				});
			}else{
				if($element.parents('.postbox').is('.closed')){
					$element.parents('.postbox').children('.hndle,.handlediv').bind('clickoutside',function(e){
						callback.call(element);
					});
				}else{
					callback.call(element);
				}
			}
		}else if($element.parents('.theme-page-container').is('.with-tabs')){
			if(!$element.parents('.theme-page-pane').hasClass('active')){
				$element.parents('.theme-page-container').find('.theme-page-tabs li').eq($element.parents('.theme-page-pane').index()).bind('click',function(e){
					callback.call(element);
				});
			}else{
				callback.call(element);
			}
		}else if($element.parents('.theme-page-container').is('.with-subtabs')){
			if( !$element.parents('.theme-page-pane').hasClass('active')){
				if($element.parents('.theme-page-subpane').hasClass('active')){
					$element.parents('.theme-page-container').find('.theme-page-tabs li').eq($element.parents('.theme-page-pane').index()).bind('click',function(e){
						callback.call(element);
					});
				}else{
					$element.parents('.theme-page-pane').find('.theme-page-subtabs li').eq($element.parents('.theme-page-subpane').index()).bind('click',function(e){
						callback.call(element);
					});
				}
			}else{
				if(! $element.parents('.theme-page-subpane').hasClass('active')){
					$element.parents('.theme-page-pane').find('.theme-page-subtabs li').eq($element.parents('.theme-page-subpane').index()).bind('click',function(e){
						callback.call(element);
					});
				}else{
					callback.call(element);
				}
			}
		}else{
			if($element.parents('.postbox').is('.closed')){
				$element.parents('.postbox').children('.hndle,.handlediv').bind('clickoutside',function(e){
					callback.call(element);
				});
			}else{
				callback.call(element);
			}
		}
	};
})(jQuery);
