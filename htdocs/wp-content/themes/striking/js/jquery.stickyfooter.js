/*
 * Sticky footer plugin for jQuery
 */
;(function( $, window, document, undefined ){
(function(){
		var interval;
		jQuery.event.special.heightchange = {
		setup: function(){
			var self = this,
			$this = $(this),
			$originalHeight = $this.height();
			interval = setInterval(function(){
				if($originalHeight != $this.outerHeight()) {
						$originalHeight = $this.outerHeight();
					jQuery.event.handle.call(self, {type:'heightchange'});
				}
			},500);
		},
		teardown: function(){
			clearInterval(interval);
		}
	};
})();

$.stickyfooter = function (element, options) {
	var self = this;

	self.settings = {};

	var $footer = $('#footer'),
		$window = $(window),
		$page = $(element),
		page = element;
	$.extend(self, {
		init : function () { 
			self.settings = $.extend({}, $.stickyfooter.defaults, options);
			$footer.parent().css({'width': '100%'}).parent().css({'width': '100%', 'height':$footer.height()});
			
			$window.bind('resize.stickyfooter', function () {
					setFooterPosition();
			});
			$('#page').bind('heightchange',function(){
				setFooterPosition();
			});
			setFooterPosition();
		}
	});
	var setFooterPosition = function() {
		var document_height,window_height = $window.height(),
		$page_top = $page.offset().top,
		$page_height = $page.height();
		
		if($.browser.msie && parseInt(jQuery.browser.version, 10) == 8 && document.documentMode == 8){
			document_height = document.documentElement.scrollHeight;
		}else{
			document_height = $(document).height();
		}
		if($footer.size()>0){
			var $paddingbottom = parseInt($('#page .inner').css('paddingBottom').replace("px", ""));
			if ( document_height - window_height <= 0) {
				$footer.parent().css({position: 'fixed', left: '0px', bottom: 0});
				$footer.css({width: $('body').width(),margin:'0 auto'});
				$extra = $footer.offset().top-$page_top-$page_height;
				$('#page .inner').css('paddingBottom',$extra + $paddingbottom);
			} else {
				if($paddingbottom > 0 && (document_height - window_height)< $paddingbottom ){
					$('#page .inner').css('paddingBottom',$paddingbottom - document_height + window_height);
				}else{
					$footer.parent().stop().css({position: 'relative', bottom: 'auto'});
					$('#page .inner').css('paddingBottom',0);
				}
			}
		}else{
			if ( document_height - window_height <= 0) {
				$extra = window_height-$page_top-$page_height;
				$('#page .inner').css('paddingBottom',$extra + $paddingbottom);
			} else {
				$('#page .inner').stop().css('paddingBottom',0);
			}
		}
	};
	self.init();
};

$.stickyfooter.defaults = {

};

$.fn.stickyfooter = function (options) {
	return this.each(function () {
		new $.stickyfooter(this, options);
	});
};

})( jQuery, window , document );

jQuery(document).ready(function($) {
	jQuery('#page').stickyfooter();
});