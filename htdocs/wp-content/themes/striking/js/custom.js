;jQuery.noConflict();

jQuery(document).ready(function($) {
	$("#navigation > ul").nav({
		child: {
			beforeFirstRender: function () {
				if($(this).find('.cufon').length>0){
					Cufon.replace($('> a', this));
				}
		    }
		},
		root: {
			afterHoverIn: function(){},
			afterHoverOut: function(){},
			beforeHoverIn: function () {
				$(this).addClass('hover');
				if($(this).find('.cufon').length>0){
					Cufon.replace($('> a', this));
				}
			},
			beforeHoverOut: function () {
				$(this).removeClass('hover');
				if($(this).find('.cufon').length>0){
					Cufon.replace($('> a', this));
				}
			}
		}
	});
	jQuery("#sidebar_content .widget:last-child").css('margin-bottom','20px');
	jQuery(".home #sidebar_content .widget:last-child").css('margin-bottom','0px');
	jQuery('.top a').click(function(){ 
		jQuery('html, body').animate({scrollTop:0}, 'slow'); 
		return false;
	}); 
	if(jQuery('body').is('.scroll-to-top')){
		jQuery('body').append('<a href="#top" id="back-to-top">Back To Top</a>');
		jQuery(function () {
			jQuery(window).scroll(function () {
				if (jQuery(this).scrollTop() > 100) {
					jQuery('#back-to-top').fadeIn();
				} else {
					jQuery('#back-to-top').fadeOut();
				}
			});
			// scroll body to 0px on click
			jQuery('#back-to-top').click(function () {
				var $delay = jQuery(window).scrollTop();
				jQuery('body,html').animate({
					scrollTop: 0
				}, 2000*Math.atan($delay/3000));
				return false;
			});
		});
	}
	jQuery(".icon_email").each(function(){
		if(jQuery(this).attr('href') != undefined){
			jQuery(this).attr('href',jQuery(this).attr('href').replace("*", "@"));
		}
		jQuery(this).html(jQuery(this).html().replace("*", "@"));
	});

	jQuery(".tabs_container").each(function(){
		var $history = jQuery(this).attr('data-history');
		if($history!=undefined && $history == 'true'){
			$history = true;
		}else {
			$history = false;
		}
		var $initialIndex = jQuery(this).attr('data-initialIndex');
		if($initialIndex==undefined){
			$initialIndex = 0;
		}
		jQuery("ul.tabs, ul.theme_tabs",this).tabs("div.panes > div, div.theme_panes > div", {tabs:'a', effect: 'fade', fadeOutSpeed: -400, history: $history, initialIndex: $initialIndex});
	});
	jQuery(".mini_tabs_container").each(function(){
		var $history = jQuery(this).attr('data-history');
		if($history!=undefined && $history == 'true'){
			$history = true;
		}else {
			$history = false;
		}
		var $initialIndex = jQuery(this).attr('data-initialIndex');
		if($initialIndex==undefined){
			$initialIndex = 0;
		}
		jQuery("ul.mini_tabs, ul.theme_mini_tabs",this).tabs("div.panes > div, div.theme_panes > div", {tabs:'a', effect: 'fade', fadeOutSpeed: -400, history: $history, initialIndex: $initialIndex});
	});
	if(jQuery.tools != undefined){
		if(jQuery.tools.tabs != undefined){
			jQuery.tools.tabs.addEffect("slide", function(i, done) {
				this.getPanes().slideUp();
				this.getPanes().eq(i).slideDown(function()  {
					done.call();
				});
			});
		}
	}
	jQuery(".accordion, .theme_accordion").each(function(){
		var $initialIndex = jQuery(this).attr('data-initialIndex');
		if($initialIndex==undefined){
			$initialIndex = 0;
		}
		jQuery(this).tabs("div.pane, div.theme_pane", {tabs: '.tab, .theme_tab', effect: 'slide',initialIndex: $initialIndex});
	});
	jQuery(".toggle_title").click(function(){
		var parent = jQuery(this).parent('.toggle');
		if(parent.is(".toggle_active")){
			parent.removeClass('toggle_active');
			jQuery(this).siblings('.toggle_content').slideUp("fast");
		}else{
			parent.addClass('toggle_active');
			jQuery(this).siblings('.toggle_content').slideDown("fast");
		
		}
	});
	jQuery(".button, .theme_button").hover(function(){
		var $hoverBg = jQuery(this).attr('data-hoverBg');
		var $hoverColor = jQuery(this).attr('data-hoverColor');

		if($hoverBg!=undefined){
			jQuery(this).css('background-color',$hoverBg);
		}
		if($hoverColor!=undefined){
			jQuery('span',this).css('color',$hoverColor);
		}
	},
	function(){
		var $hoverBg = jQuery(this).attr('data-hoverBg');
		var $hoverColor = jQuery(this).attr('data-hoverColor');
		var $bg = jQuery(this).attr('data-bg');
		var $color = jQuery(this).attr('data-color');

		if($hoverBg!=undefined){
			if($bg !=undefined){
				jQuery(this).css('background-color',$bg);
			}else{
				jQuery(this).css('background-color','');
			}
		}
		if($hoverColor!=undefined){
			if($color !=undefined){
				jQuery('span',this).css('color',$color);
			}else{
				jQuery('span',this).css('color','');
			}
		}
	});
	if(!jQuery('body').is('.no_colorbox')){
		jQuery(".colorbox").each(function(){
			var $iframe = jQuery(this).attr('data-iframe');
			if($iframe == undefined || $iframe == 'false'){
				$iframe = false;
			}else{
				$iframe = true;
			}
			var $href = false;
			var $inline = jQuery(this).attr('data-inline');
			if($inline == undefined || $inline == 'false'){
				$inline = false;
			}else{
				$inline = true;
				$href = jQuery(this).attr('data-href');
			}
			var $restrict = jQuery(this).attr('data-fittoview');
			if($restrict == undefined){
				if(typeof restrict_colorbox == "undefined"){
					$restrict = false;
				}else{
					$restrict = true;
				}
			}else if($restrict == 'true'){
				$restrict = true;
			}else{
				$restrict = false;
			}

			var $maxWidth = false;
			var $maxHeight = false;
			var $width = jQuery(this).attr('data-width');
			if($width == undefined){
				if($iframe == true || $inline == true ){
					$width = '80%';
				}else{
					$width = '';
				}
				if($restrict == true){
					$maxWidth = '95%';
				}
			}
			var $height = jQuery(this).attr('data-height');
			if($height == undefined){
				if($iframe == true || $inline == true ){
					$height = '80%';
				}else{
					$height = '';
				}
				if($restrict == true){
					$maxHeight = '95%';
				}
			}
			var $photo = jQuery(this).attr('data-photo');
			if($photo == undefined || $photo == 'false'){
				$photo = false;
			}else{
				$photo = true;
			}
			var $close = jQuery(this).attr('data-close');
			if($close == undefined || $close == 'true'){
				$close = true;
			}else{
				$close = false;
			}
			jQuery(this).colorbox({
				opacity:0.7,
				innerWidth:$width,
				innerHeight:$height,
				maxWidth:$maxWidth,
				maxHeight:$maxHeight,
				iframe:$iframe,
				inline:$inline,
				href:$href,
				photo:$photo,
				onLoad: function(){
					if(!$close){
						jQuery("#cboxClose").css("visibility", "hidden");
					}else{
						jQuery("#cboxClose").css("visibility", "visible");
					}
					jQuery("#colorbox").removeClass('withVideo');
				},
				onComplete: function(){	
					if (typeof Cufon !== "undefined"){
						Cufon.replace('#cboxTitle');
					}
				}
			});
		});
	}
	
	/* enable lightbox */
	var enable_lightbox = function(parent){
		if(jQuery('body').is('.no_colorbox')){
			return;
		}
		jQuery("a.lightbox[href*='http://www.vimeo.com/']",parent).each(function() {
			jQuery(this).attr('href',this.href.replace("www.vimeo.com/", "player.vimeo.com/video/"));
		});
		jQuery("a.lightbox[href*='http://vimeo.com/']",parent).each(function() {
			jQuery(this).attr('href',this.href.replace("vimeo.com/", "player.vimeo.com/video/"));
		});
		jQuery("a.lightbox[href*='http://www.youtube.com/watch?']",parent).each(function() {
			jQuery(this).attr('href',this.href.replace(new RegExp("watch\\?v=", "i"), "embed/")+'?autoplay=1');
		});
		jQuery("a.lightbox[href*='http://player.vimeo.com/']",parent).each(function() {
			jQuery(this).addClass("fancyVimeo").removeClass('lightbox');
		});
		jQuery("a.lightbox[href*='http://www.youtube.com/embed/']",parent).each(function() {
			jQuery(this).addClass("fancyYoutube").removeClass('lightbox');
		});
		jQuery("a.lightbox[href*='http://www.youtube.com/v/']",parent).each(function() {
			jQuery(this).addClass("fancyVideo").removeClass('lightbox');
		});
		jQuery("a.lightbox[href*='.swf']",parent).each(function() {
			jQuery(this).addClass("fancyVideo").removeClass('lightbox');
		});
		jQuery(".fancyVimeo,.fancyYoutube",parent).each(function(){
			var $width = jQuery(this).attr('data-width');
			if($width == undefined){
				$width = '640';
			}
			var $height = jQuery(this).attr('data-height');
			if($height == undefined){
				$height = '408';
			}
			jQuery(this).colorbox({
				opacity:0.7,
				innerWidth:$width,
				innerHeight:$height,
				iframe:true,
				scrolling:false,
				current:"{current} of {total}",
				onLoad: function(){
					jQuery("#cboxClose").css("visibility", "hidden");
					jQuery("#colorbox").addClass('withVideo');
				},
				onComplete: function(){
					if (typeof Cufon !== "undefined"){
						Cufon.replace('#cboxTitle');
					}
				},
				onCleanup: function(){
					//jQuery("#cboxLoadedContent").html('');
				}
			});
		});

		jQuery(".fancyVideo",parent).each(function(){
			var $width = jQuery(this).attr('data-width');
			if($width == undefined){
				$width = '640';
			}
			var $height = jQuery(this).attr('data-height');
			if($height == undefined){
				$height = '390';
			}
			
			jQuery(this).colorbox({
				opacity:0.7,
				innerWidth:$width,
				innerHeight:$height,
				html:'<div></div>',
				scrolling:false,
				current:"{current} of {total}",
				//rel:'nofollow',
				onLoad: function(){
					jQuery("#cboxClose").css("visibility", "hidden");
					jQuery("#colorbox").addClass('withVideo');
				},
				onComplete: function(){
					if (typeof Cufon !== "undefined"){
						Cufon.replace('#cboxTitle');
					}
					jQuery("#cboxLoadedContent").html('<div id="cboxSwfobject"></div>');
					swfobject.embedSWF(this.href, "cboxSwfobject", $width, $height, "10","expressInstall.swf", {autostart: "true"}, {play: 'true',wmode:'transparent'});
				},
				onCleanup: function(){
					//jQuery("#cboxLoadedContent").html('');
				}
			});
		});
		jQuery(".fancyLightbox",parent).each(function(){
			var $iframe = jQuery(this).attr('data-iframe');
			if($iframe == undefined || $iframe == 'false'){
				$iframe = false;
			}else{
				$iframe = true;
			}
			var $href = false;
			var $inline = jQuery(this).attr('data-inline');
			if($inline == undefined || $inline == 'false'){
				$inline = false;
			}else{
				$inline = true;
				$href = jQuery(this).attr('data-href');
			}
			var $width = jQuery(this).attr('data-width');
			if($width == undefined){
				$width = '640';
			}
			var $height = jQuery(this).attr('data-height');
			if($height == undefined){
				$height = '390';
			}
			jQuery(this).colorbox({
				opacity:0.7,
				innerWidth:$width,
				innerHeight:$height,
				iframe:$iframe,
				inline:$inline,
				href:$href,
				current:"{current} of {total}",
				onLoad: function(){
					jQuery("#cboxClose").css("visibility", "visible");
					jQuery("#colorbox").removeClass('withVideo');
					
				},
				onComplete: function(){
					if (typeof Cufon !== "undefined"){
						Cufon.replace('#cboxTitle');
					}
					if(jQuery("#cboxLoadedContent .video-js").size()>0){
						jQuery("#cboxLoadedContent .video-js").each(function(){
							if(typeof this.player !== "undefined"){
								jQuery(this).css("height",this.height);
								//this.player.height(this.height);
								this.player.positionAll();
							}
						});
					}
				},
				onCleanup: function(){
					//jQuery("#cboxLoadedContent").html('');
				}
			});
		});
		
		jQuery(".lightbox",parent).each(function(){
			var $maxWidth = false;
			var $maxHeight = false;

			var $restrict = jQuery(this).attr('data-fittoview');
			if($restrict == undefined){
				if(typeof restrict_colorbox == "undefined"){
					$maxWidth = false;
					$maxHeight = false;
				}else{
					$maxWidth = "95%";
					$maxHeight = "95%";
				}
			}else if($restrict == 'true'){
				$maxWidth = "95%";
				$maxHeight = "95%";
			}else{
				$maxWidth = false;
				$maxHeight = false;
			}
			jQuery(this).colorbox({
				opacity:0.7,
				maxWidth:$maxWidth,
				maxHeight:$maxHeight,
				current:"{current} of {total}",
				onLoad: function(){
					jQuery("#cboxClose").css("visibility", "visible");
					jQuery("#colorbox").removeClass('withVideo');
				},
				onComplete: function(){
					if (typeof Cufon !== "undefined"){
						Cufon.replace('#cboxTitle');
					}
				}
			});

		});
	};
	enable_lightbox(document);

	if(!jQuery('body').is('.no_colorbox') && jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 9){
	/* fix ie colorbox png transparent background bug */
		document.getElementById("cboxTopLeft").style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+image_url+"/colorbox_ie/borderTopLeft.png', sizingMethod='scale')";
		document.getElementById("cboxTopCenter").style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+image_url+"/colorbox_ie/borderTopCenter.png', sizingMethod='scale')";
		document.getElementById("cboxTopRight").style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+image_url+"/colorbox_ie/borderTopRight.png', sizingMethod='scale')";
		document.getElementById("cboxBottomLeft").style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+image_url+"/colorbox_ie/borderBottomLeft.png', sizingMethod='scale')";
		document.getElementById("cboxBottomCenter").style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+image_url+"/colorbox_ie/borderBottomCenter.png', sizingMethod='scale')";
		document.getElementById("cboxBottomRight").style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+image_url+"/colorbox_ie/borderBottomRight.png', sizingMethod='scale')";
		document.getElementById("cboxMiddleLeft").style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+image_url+"/colorbox_ie/borderMiddleLeft.png', sizingMethod='scale')";
		document.getElementById("cboxMiddleRight").style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+image_url+"/colorbox_ie/borderMiddleRight.png', sizingMethod='scale')";
	}
	
	/* enable image hover effect */
	var enable_image_hover = function(image){
		if(image.is(".image_icon_zoom,.image_icon_play,.image_icon_doc,.image_icon_link")){
			if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 7) {} else {
				if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 9) {
					image.hover(function(){
						jQuery(".image_overlay",this).css("visibility", "visible");
					},function(){
						jQuery(".image_overlay",this).css("visibility", "hidden");
					}).children('img').after('<span class="image_overlay"></span>');
				}else{
					image.hover(function(){
						jQuery(".image_overlay",this).animate({
							opacity: '1'
						},"fast");
					},function(){
						jQuery(".image_overlay",this).animate({
							opacity: '0'
						},"fast");
					}).children('img').after(jQuery('<span class="image_overlay"></span>').css({opacity: '0',visibility:'visible'}));
				}
			}
		}
	};
	// Grayscale w canvas method
	var grayscale = function(src){
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
		var imgObj = new Image();
		imgObj.src = src;
		canvas.width = imgObj.width;
		canvas.height = imgObj.height; 
		ctx.drawImage(imgObj, 0, 0); 
		var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
		for(var y = 0; y < imgPixels.height; y++){
			for(var x = 0; x < imgPixels.width; x++){
				var i = (y * 4) * imgPixels.width + x * 4;
				var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
				imgPixels.data[i] = avg; 
				imgPixels.data[i + 1] = avg; 
				imgPixels.data[i + 2] = avg;
			}
		}
		ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
		return canvas.toDataURL();
	};

	var enable_image_grayscale_hover = function(image){
		$('img', image).fadeIn(500);

		// clone image
		$('img', image).each(function(){
			var el = $(this);
			el.css({"position":"absolute"}).wrap("<div class='img_wrapper' style='display: inline-block'>").clone().addClass('img_grayscale').css({"position":"absolute","z-index":"100","opacity":"0"}).insertBefore(el).queue(function(){
				var el = $(this);
				el.parent().css({"width":this.width,"height":this.height});
				el.dequeue();
			});
			this.src = grayscale(this.src);
		});
		if(typeof grayscale_animSpeed=='undefined'){
			grayscale_animSpeed = 1000;
		}
		if(typeof grayscale_outSpeed=='undefined'){
			grayscale_outSpeed = 1000;
		}
		// Fade image 
		$('img', image).mouseover(function(){
			$(this).parent().find('img:first').stop().animate({opacity:1}, grayscale_animSpeed);
		})
		$('img', image).mouseout(function(){
			$(this).stop().animate({opacity:0}, grayscale_outSpeed);
		});
	};
	
	jQuery('.image_no_link').click(function(){
		return false;
	});
	/* portfolio sortable */
	jQuery(".portfolios").each(function(){
		var $section = jQuery(this);
		var $pagenavi = jQuery('.wp-pagenavi', this);
		var $ajax = false;
		if($section.attr('data-options') != undefined){
			eval("var $options = "+$section.attr('data-options'));
			$ajax = true;
		}
		var $cufon = false;
		if($section.find('.portfolio_title .cufon').size()>0){
			$cufon = true;
		}

		if($section.is('.sortable')){
			var $preferences = {
				duration: 1000,
				easing: 'easeInOutQuad',
				attribute: function(v) {
		           	return $(v).attr('data-id');
				},
				enhancement:function(){
					if (typeof Cufon !== "undefined" && $cufon == true){
						if (jQuery.browser.msie){
							jQuery('.portfolio_title').each(function(){
								jQuery(this).html(jQuery(this).text());
							});
						}
						Cufon.replace('.portfolio_title');
					}
				}
			};
			
			var $list = jQuery('ul',this);
			
			var $data = $list.clone();
			$data.find('.image_frame img').css('visibility','visible');
			if (typeof Cufon !== "undefined" && $cufon == true){
				$data.find('.portfolio_title').each(function(){
					if(jQuery('a', this).size()>0){
						jQuery('a', this).html(this.textContent);
					}else{
						jQuery(this).html(this.textContent);
					}
				});
			}
			var $column;
			if($list.is('.portfolio_one_column')){
				$column = 1;
			}else if($list.is('.portfolio_two_columns')){
				$column = 2;
			}else if($list.is('.portfolio_three_columns')){
				$column = 3;
			}else if($list.is('.portfolio_four_columns')){
				$column = 4;
			}
			
			
			var $callback = function(){
				if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 9 && parseInt(jQuery.browser.version, 10) > 6) {
					$list.find('.image_shadow').css('visibility','visible');
				}
				enable_lightbox($list);
				$list.find('.image_frame').css('background-image','none');
				$list.find('.image_frame').each(function(){
					if($(this).is('.effect-grayscale')){
						enable_image_grayscale_hover($('a', this));
					}else if($(this).is('.effect-icon')){
						enable_image_hover($('a', this));
					}
				});
				
				if (typeof Cufon !== "undefined" && $cufon == true && jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 7){
					$list.find('.portfolio_title').each(function(){
						if(jQuery('a', this).size()>0){
							jQuery('a', this).html(jQuery(this).text());
						}else{
							jQuery(this).html(jQuery(this).text());
						}
					});
					Cufon.replace('.portfolio_title');
				}
			};
			var $ajax_callback = function(data){
				var $temp = $(data);
				$temp.find('.image_frame img').css('visibility','visible');
				var $temp_pagenavi = $temp.find('.wp-pagenavi');
				$list.quicksand($temp.find('li'),$preferences,$callback);
				if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 7) {
					$callback();
				}
				$pagenavi = $section.find('.wp-pagenavi');
				if($pagenavi.size()>0){
					$pagenavi.html($temp_pagenavi.html());
				}else{
					$temp_pagenavi.appendTo($section);
				}
			};
			if($ajax){
				jQuery('.wp-pagenavi a', this).live('click',function(e){
					var category = 'all';
					if($section.find('.sort_by_cat a.current').size()>0){
						category = $section.find('.sort_by_cat a.current').attr('data-value');
					}
								 	
					jQuery.post(window.location.href,{
						portfolioAjax: true,
						portfolioOptions: $options,
						category:category,
						portfolioPage: jQuery(this).attr('data-page')
					}, $ajax_callback);

					e.preventDefault();  
				});
			}
			jQuery('.sort_by_cat a',this).click(function(e){
				if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 9) {
					$list.find('.image_shadow').css('visibility','hidden');
					$data.find('.image_shadow').css('visibility','hidden');
				}
				jQuery(this).siblings('.current').removeClass('current');
				jQuery(this).addClass('current');

				if($ajax){
					var category = jQuery(this).attr('data-value');
					jQuery.post(window.location.href,{
						portfolioAjax:true,
						portfolioOptions:$options,
						category:category
					}, $ajax_callback);
				}else{
					if(jQuery(this).attr('data-value') == 'all'){
						$sorted_data = $data.find('li').clone();
					}else{
						$sorted_data = $data.find('li[data-type*='+jQuery(this).attr('data-value')+']').clone();
					}
					$list.quicksand($sorted_data,$preferences,$callback);
					if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 7) {
						$callback();
					}
				}
				
				e.preventDefault();  
			});
		}else{
			if($ajax){
				jQuery('.wp-pagenavi a', this).live('click',function(e){
					jQuery.post(window.location.href,{
						portfolioAjax: true,
						portfolioOptions: $options,
						portfolioPage: jQuery(this).attr('data-page')
					}, function(data){
						$section.html(data);
						enable_lightbox($section);
						if (typeof Cufon !== "undefined" && $cufon == true){
							Cufon.replace('.portfolio_title');
						}
						
						$section.preloader({
							delay:200,
							imgSelector:'.portfolio_image .image_frame img',
							beforeShow:function(){
								jQuery(this).closest('.image_frame img').css('visibility','hidden');
							},
							afterShow:function(){
								var image_frame = jQuery(this).closest('.image_frame');
								image_frame.css('background-image','none');
								var image = jQuery(this).closest('.image_frame img').css('visibility','visible').closest('a');
								if(image_frame.is('.effect-grayscale')){
									enable_image_grayscale_hover(image);
								}else if(image_frame.is('.effect-icon')){
									enable_image_hover(image);
								}
							}
						});
					});

					e.preventDefault();  
				});
			}
		}
	});

	jQuery(".portfolios").preloader({
		delay:200,
		imgSelector:'.portfolio_image .image_frame img',
		beforeShow:function(){
			jQuery(this).closest('.image_frame img').css('visibility','hidden');
		},
		afterShow:function(){
			var image_frame = jQuery(this).closest('.image_frame');
			image_frame.css('background-image','none');
			var image = jQuery(this).closest('.image_frame img').css('visibility','visible').closest('a');
			
			if(image_frame.is('.effect-grayscale')){
				enable_image_grayscale_hover(image);
			}else if(image_frame.is('.effect-icon')){
				enable_image_hover(image);
			}
		}
	});
	jQuery(".content,#top_area,#content,#sidebar,#footer").preloader({
		delay:200,
		imgSelector:'.image_styled:not(.portfolio_image) .image_frame img',
		beforeShow:function(){
			jQuery(this).closest('.image_frame img').css('visibility','hidden');
		},
		afterShow:function(){
			var image_frame = jQuery(this).closest('.image_frame');
			image_frame.css('background-image','none');
			var image = jQuery(this).closest('.image_frame img').css('visibility','visible').closest('a');
			
			if(image_frame.is('.effect-grayscale')){
				enable_image_grayscale_hover(image);
			}else if(image_frame.is('.effect-icon')){
				enable_image_hover(image);
			}
		}
	});
	jQuery(".gallery").preloader({
		delay:100,
		imgSelector:'.gallery-image',
		beforeShow:function(){},
		afterShow:function(){
			jQuery(this).hover(function(){
				jQuery(this).animate({
					opacity: '0.8'
				},"fast");
			},function(){
				jQuery(this).animate({
					opacity: '1'
				},"fast");
			})
		}
	});
	
	jQuery(".contact_info_wrap .icon_email").each(function(){
		jQuery(this).attr('href',jQuery(this).attr('href').replace("*", "@"));
		jQuery(this).html(jQuery(this).html().replace("*", "@"));
	});
    if(jQuery.tools.validator != undefined){
        jQuery.tools.validator.addEffect("contact_form", function(errors, event) {
            jQuery.each(errors, function(index, error) {
                var input = error.input;
				
                input.addClass('invalid');
            });
        }, function(inputs)  {
            inputs.removeClass('invalid');
        });
        /* contact form widget */
        jQuery('.widget_contact_form .contact_form').validator({effect:'contact_form'}).submit(function(e) {
			var form = jQuery(this);
			if (!e.isDefaultPrevented()) {
				jQuery.post(this.action,{
					'theme_contact_form_submit': 1,
					'to':jQuery('input[name="contact_to"]').val().replace("*", "@"),
					'name':jQuery('input[name="contact_name"]').val(),
					'email':jQuery('input[name="contact_email"]').val(),
					'content':jQuery('textarea[name="contact_content"]').val()
				},function(data){
					form.fadeOut('fast', function() {
						jQuery(this).siblings('p').show();
					}).delay(3000).fadeIn('fast',function(){
						jQuery(this).find('input[name="contact_name"]').val('');
						jQuery(this).find('input[name="contact_email"]').val('');
						jQuery(this).find('textarea[name="contact_content"]').val('');
						jQuery(this).siblings('p').hide();
					});
				});
				e.preventDefault();
            }
        });
        /* contact page form */
        jQuery('.contact_form_wrap .contact_form').validator({effect:'contact_form'}).submit(function(e) {
			var form = jQuery(this);
 			if (!e.isDefaultPrevented()) {
				var $id = form.find('input[name="contact_widget_id"]').val();
				jQuery.post(this.action,{
					'theme_contact_form_submit': 1,
					'to':jQuery('input[name="contact_'+$id+'_to"]').val().replace("*", "@"),
					'name':jQuery('input[name="contact_'+$id+'_name"]').val(),
					'email':jQuery('input[name="contact_'+$id+'_email"]').val(),
					'content':jQuery('textarea[name="contact_'+$id+'_content"]').val()
				},function(data){
					form.fadeOut('fast', function() {
						jQuery(this).siblings('.success').show();
					}).delay(3000).fadeIn('fast',function(){
						jQuery(this).find('input[name="contact_'+$id+'_name"]').val('');
						jQuery(this).find('input[name="contact_'+$id+'_email"]').val('');
						jQuery(this).find('textarea[name="contact_'+$id+'_content"]').val('');
						jQuery(this).siblings('.success').hide();
					});
                });
                e.preventDefault();
            }
        });
    }
});

(function($) {

	$.fn.preloader = function(options) {
		var settings = $.extend({}, $.fn.preloader.defaults, options);


		return this.each(function() {
			settings.beforeShowAll.call(this);
			var imageHolder = $(this);
			
			var images = imageHolder.find(settings.imgSelector).css({opacity:0, visibility:'hidden'});	
			var count = images.length;
			var showImage = function(image,imageHolder){
				if(image.data.source != undefined){
					imageHolder = image.data.holder;
					image = image.data.source;	
				};
				
				count --;
				if(settings.delay <= 0){
					image.css('visibility','visible').animate({opacity:1}, settings.animSpeed, function(){settings.afterShow.call(this)});
				}
				if(count == 0){
					imageHolder.removeData('count');
					if(settings.delay <= 0){
						settings.afterShowAll.call(this);
					}else{
						if(settings.gradualDelay){
							images.each(function(i,e){
								var image = $(this);
								setTimeout(function(){
									image.css('visibility','visible').animate({opacity:1}, settings.animSpeed, function(){settings.afterShow.call(this)});
								},settings.delay*(i+1));
							});
							setTimeout(function(){settings.afterShowAll.call(imageHolder[0])}, settings.delay*images.length+settings.animSpeed);
						}else{
							setTimeout(function(){
								images.each(function(i,e){
									$(this).css('visibility','visible').animate({opacity:1}, settings.animSpeed, function(){settings.afterShow.call(this)});
								});
								setTimeout(function(){settings.afterShowAll.call(imageHolder[0])}, settings.animSpeed);
							}, settings.delay);
						}
					}
				}
			};
			
			if(count==0){
				settings.afterShowAll.call(this);
			}else{
				images.each(function(i){
					settings.beforeShow.call(this);
					image = $(this);
					
					if(this.complete===true){
						showImage(image,imageHolder);
					}else{
						image.bind('error load',{source:image,holder:imageHolder}, showImage);
						if($.browser.opera || ($.browser.msie && parseInt(jQuery.browser.version, 10) == 9 && (document.documentMode == 9||document.documentMode == 10) )
							|| ($.browser.msie && parseInt(jQuery.browser.version, 10) == 8 && document.documentMode == 8) 
							|| ($.browser.msie && parseInt(jQuery.browser.version, 10) == 7 && document.documentMode == 7)){
							image.trigger("load");//for hidden image
						}
					}
				});
			}
		});
	};


	//Default settings
	$.fn.preloader.defaults = {
		delay:1000,
		gradualDelay:true,
		imgSelector:'img',
		animSpeed:500,
		beforeShowAll: function(){},
		beforeShow: function(){},
		afterShow: function(){},
		afterShowAll: function(){}
	};
})(jQuery);
