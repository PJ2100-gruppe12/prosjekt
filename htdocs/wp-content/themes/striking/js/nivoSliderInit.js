;
jQuery(document).ready(function() {
    if (typeof slideShow == 'undefined') return;
    var slider = jQuery('#nivo_slider');
    jQuery('<div id="nivo_slider_loading"></div>').insertBefore('#nivo_slider');
    slider.nivoSlider({
        effect: slideShow['effect'],
        slices: slideShow['slices'],
        boxCols: slideShow['boxCols'],
        boxRows: slideShow['boxRows'],
        animSpeed: slideShow['animSpeed'],
        pauseTime: slideShow['pauseTime'],
        startSlide: 0,
        directionNav: slideShow['directionNav'],
        controlNav: slideShow['controlNav'],
        controlNavThumbs: false,
        keyboardNav: slideShow['keyboardNav'],
        pauseOnHover: slideShow['pauseOnHover'],
        manualAdvance: slideShow['manualAdvance'],
        captionOpacity: slideShow['captionOpacity'],
        randomStart: slideShow['randomStart'],
        beforeChange: function() {},
        afterChange: function() {
            frame.css('cursor', 'auto').unbind('click');
            var vars = slider.data('nivo:vars');
            var current = jQuery(slider.children()[vars.currentSlide]);
            if (current.is('a')) {
                frame.css('cursor', 'pointer').click(function() {
                    if (current.attr('target') == '_blank') {
                        window.open(current.attr('href'));
                    } else {
                        location.href = current.attr('href');
                    }
                });
            }
        },
        lastSlide: function() {
            if (slideShow['stopAtEnd']) {
                slider.data('nivoslider').stop();
            }
        }
    });

    slider.find('.nivo-caption').each(function() {
        jQuery(this).css('opacity', slideShow['captionOpacity']);
        if (slideShow['controlNav']) {
            jQuery(this).css({
                paddingRight: slider.find('.nivo-controlNav').width() + 20
            });
        }
    });


    jQuery('<div id="nivo_slider_frame_top"></div>').appendTo(slider);
    var frame = jQuery('<div id="nivo_slider_frame"></div>').appendTo(slider);


    if (jQuery(":first", slider).is('a')) {
        frame.css('cursor', 'pointer').click(function() {
            if (jQuery(":first", slider).attr('target') == '_blank') {
                window.open(jQuery(":first", slider).attr('href'));
            } else {
                location.href = jQuery(":first", slider).attr('href');
            }
        });
    }
    if (slideShow['controlNav']) {
        slider.append('<div class="nivo_control_bg"></div>');
        jQuery('.nivo_control_bg', slider).css('opacity', slideShow['captionOpacity']);
        if (!slideShow['captions']) {
            jQuery('.nivo_control_bg', slider).show();
        }
    }

    slider.siblings('#nivo_slider_loading').animate({
        opacity: 0
    }, 1000, function() {
        jQuery(this).remove();
    });

    if (slideShow['directionNavHide']) {
        slider.find('.nivo-directionNav').hide();
    }

    if (slideShow['controlNavHide']) {
        slider.find('.nivo-controlNav').hide();
        if (!slideShow['captions']) {
            jQuery('.nivo_control_bg', slider).hide();
        }
    }

    slider.hover(function() {
        if (slideShow['directionNavHide']) {
            slider.find('.nivo-directionNav').show();
        }
        if (slideShow['controlNavHide']) {
            slider.find('.nivo-controlNav').show();
            if (!slideShow['captions']) {
                jQuery('.nivo_control_bg', slider).show();
            }
        }
    }, function() {
        if (slideShow['directionNavHide']) {
            slider.find('.nivo-directionNav').hide();
        }
        if (slideShow['controlNavHide']) {
            slider.find('.nivo-controlNav').hide();
            if (!slideShow['captions']) {
                jQuery('.nivo_control_bg', slider).hide();
            }
        }
    });
});
