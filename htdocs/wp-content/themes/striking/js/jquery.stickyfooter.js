jQuery(document).ready(function($) {
    $('#footer').sticker({
        type: 'fill',
        adjustHeight: function(documentHeight) {
            paddingbottom = parseInt($('#page .inner').css('paddingBottom').replace("px", ""), 10);
            return documentHeight - paddingbottom;
        },
        callback: function(scrollTop, documentHeight, windowHeight) {
            if (scrollTop === 0 && documentHeight <= windowHeight) {
                var $page = $('#page'),
                    paddingbottom = parseInt($('#page .inner').css('paddingBottom').replace("px", ""), 10),
                    page_top = $page.offset().top,
                    page_height = $page.height(),
                    extra = this.$element.offset().top - page_top - page_height;
                $('#page .inner').css('paddingBottom', extra + paddingbottom);
            } else {
                $('#page .inner').css('paddingBottom', 0);
            }
        },
        disable: function(api) {
            $('#page .inner').css('paddingBottom', 0);
        }
    });
});
