;jQuery(document).ready(function() {
	if(typeof slideShow == 'undefined') return;
	var autoplay = true;
	var current = 0;
	var $slideshow = jQuery('#kwicks');
	var $kwicks_items = $slideshow.children('li');
	if ($kwicks_items.size()!=0) {
	$slideshow.preloader({
		delay:500,
		beforeShowAll:function(){
			var size = jQuery(this).children('li').width();
			jQuery(this).kwicks({
				size: size,
				maxSize: slideShow['maxSize'],
				duration: slideShow['duration'],
				easing: slideShow['easing'],
				isVertical: false,
				spacing:0,
				behavior: 'menu'
			});
			jQuery(".kwick_detail",this).width(slideShow['maxSize']-20);
			if(slideShow['title']){
				jQuery(".kwick_title",this).fadeTo("fast", slideShow['title_opacity']);
			}
			
			jQuery("li",this).append('<div class="kwick_shadow"> </div><div class="kwick_frame_top"></div><div class="kwick_frame"></div>').each(function(i){
				jQuery(this).css('z-index',100+i);
			}).hover(function(e,auto) {
				if( auto!= true ){
					if(slideShow['autoplay']){
						$kwicks_items.eq($slideshow.kwicks('expanded')).trigger('mouseout');
						autoplay = false;
					}
				}
				if(slideShow['title']){
					jQuery(".kwick_title",this).stop().fadeTo(slideShow['title_speed'], 0);
				}
				if(slideShow['detail']){
					jQuery(".kwick_detail",this).stop().fadeTo(slideShow['detail_speed'], slideShow['detail_opacity']);
				}
				jQuery(this).kwicks('expand');
			},function(){
				if(slideShow['autoplay']){
					autoplay = true;
				}
				if(slideShow['title']){
					jQuery(".kwick_title",this).stop().fadeTo(slideShow['title_speed'],slideShow['title_opacity']);
				}
				if(slideShow['detail']){
					jQuery(".kwick_detail",this).stop().fadeTo(slideShow['detail_speed'], 0);
				}
			}).each(function(){
				if(jQuery(this).children('a').attr('href') != '#'){
					jQuery(this).addClass('is-linkable').click(function(){
						if(jQuery(this).children('a').attr('target')=='_blank'){
							window.open(jQuery(this).children('a').attr('href'));
						}else{
							location.href = jQuery(this).children('a').attr('href');
						}
					});
				}
			});
			
			jQuery("li:last-child",this).append('<div class="kwick_last_frame"></div>');
		},
		beforeShow:function(){
			jQuery(this).closest('li').addClass('preloading');
		},
		afterShow:function(){
			jQuery(this).closest('li').removeClass('preloading');
		},
		afterShowAll:function(){
			if(slideShow['autoplay']){
				var numSlides = slideShow['number'];
				var curSlide = 0;
				setInterval(function(){
					//console.info(autoplay);
					if(autoplay){
						$slideshow.kwicks('expand', ++curSlide % numSlides);
					}
				},slideShow['pauseTime']);
			}
		}
	});
    };
});
