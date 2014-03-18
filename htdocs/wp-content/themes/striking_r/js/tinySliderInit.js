jQuery(document).ready(function($) {
    jQuery('.tinyslider_images').tinySlider({
        onStart: function() {
            if (this.$element.data('caption') === 1) {
                this.caption = true;
                this.$caption = $('<div class="tinyslider_images-caption">').appendTo(this.$element);

                this.$caption.width(this.$pager.find('li:first').position().left - 15);

                var caption_text = this.$slides.eq(this.current).find('img').attr('alt');
                this.$caption.text(caption_text);
            } else {
                this.caption = false;
            }
        },
        onBefore: function(data) {
            if (this.caption) {
                var caption_text = this.$slides.eq(data.index).find('img').attr('alt');
                this.$caption.text(caption_text);
            }
        },
        onResize: function() {
            if (this.caption) {
                this.$caption.width(this.$pager.find('li:first').position().left - 10);
            }
        }
    });
});
