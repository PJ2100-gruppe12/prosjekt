jQuery(document).ready(function($) {
	/* meta-box tabs init */
	$('.meta-box-container.with-tabs').each(function(){
		var container = this;
		$(this).find(".meta-box-tabs li").each(function(i){
			$(this).on('click',function(e){
				$(this).siblings().removeClass('active');
				$(this).addClass('active');
				$('.meta-box-panes > li',container).removeClass('active').eq(i).addClass('active');
			});

		});
	});
	
	/* options-page tabs init */
	$('.theme-page-container.with-tabs, .theme-page-container.with-subtabs').each(function(){
		var currentTab = '';
		var match = RegExp('[?&]tab=([^&]*)')
	                .exec(window.location.search);
		if(match){
			currentTab = decodeURIComponent(match[1].replace(/\+/g, ' '));
		}
		
		if(currentTab === ''){
			currentTab = $(this).find(".theme-page-tabs li:first").data('tab');
		}
		var container = this;
		$(this).find(".theme-page-tabs li").each(function(i){
			var slug = $(this).data('tab');

			$(this).on('click',function(e){
				$(this).trigger('active');
				
				if (window.history && window.history.pushState && window.history.replaceState) {					
					window.history.pushState({tab:slug}, "", window.location.search.replace(/&*tab=[^&]+/,'') + "&tab="+slug);
				}
			});

			$(this).on('active',function(e){
				$(this).siblings().removeClass('active');
				$(this).addClass('active');
				$('.theme-page-panes > li',container).removeClass('active').eq(i).addClass('active');
			});

			if(currentTab == slug){
				$(this).trigger('click');
			}
		});
	});
	$(window).on('popstate', function (event) {
		if (event.originalEvent.state !== null) {
			if(typeof event.originalEvent.state.tab != 'undefined'){
				$('.theme-page-tabs').children('[data-tab="'+event.originalEvent.state.tab+'"]').trigger('active');
				event.preventDefault();
			}
		}
    });
	$(".theme-page-container.with-subtabs .theme-page-subtabs").each(function(i){
		$(this).find('li').each(function(i){
			$(this).on('click',function(e){
				$(this).siblings().removeClass('active');
				$(this).addClass('active');
				$(this).parent().siblings('.theme-page-subpanes').find('.theme-page-subpane').removeClass('active').eq(i).addClass('active');
			});
		});
	});
	theme.init();
});