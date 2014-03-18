;
jQuery(document).ready(function() {

    if (typeof slideShow == 'undefined') return;
    var autoplay = true;
    var current = 0;
    var $slideshow = jQuery('#kwicks');
    var $kwicks_items = $slideshow.children('li');
    if ($kwicks_items.length > 0) {
        var size = $slideshow.children('li').width();

        $slideshow.kwicks({
            size: size,
            maxSize: slideShow['maxSize'],
            duration: slideShow['duration'],
            easing: slideShow['easing'],
            isVertical: false,
            spacing: 0,
            behavior: 'menu'
        });
        $slideshow.find(".kwick_detail").width(slideShow['maxSize'] - 20);
        if (slideShow['title']) {
            $slideshow.find(".kwick_title").fadeTo("fast", slideShow['title_opacity']);
        }

        $kwicks_items.append('<div class="kwick_shadow"> </div><div class="kwick_frame_top"></div><div class="kwick_frame"></div>').each(function(i) {
            jQuery(this).css('z-index', 100 + i);
        }).hover(function(e, auto) {
            if (auto != true) {
                if (slideShow['autoplay']) {
                    $kwicks_items.eq($slideshow.kwicks('expanded')).trigger('mouseout');
                    autoplay = false;
                }
            }
            if (slideShow['title']) {
                jQuery(".kwick_title", this).stop().fadeTo(slideShow['title_speed'], 0);
            }
            if (slideShow['detail']) {
                jQuery(".kwick_detail", this).stop().fadeTo(slideShow['detail_speed'], slideShow['detail_opacity']);
            }
            jQuery(this).kwicks('expand');
        }, function() {
            if (slideShow['autoplay']) {
                autoplay = true;
            }
            if (slideShow['title']) {
                jQuery(".kwick_title", this).stop().fadeTo(slideShow['title_speed'], slideShow['title_opacity']);
            }
            if (slideShow['detail']) {
                jQuery(".kwick_detail", this).stop().fadeTo(slideShow['detail_speed'], 0);
            }
        }).each(function() {
            if (jQuery(this).children('a').attr('href') != '#') {
                jQuery(this).addClass('is-linkable').click(function() {
                    if (jQuery(this).children('a').attr('target') == '_blank') {
                        window.open(jQuery(this).children('a').attr('href'));
                    } else {
                        location.href = jQuery(this).children('a').attr('href');
                    }
                });
            }
        });

        $slideshow.find("li:last-child").append('<div class="kwick_last_frame"></div>');

        $slideshow.find('img').each(function() {
            jQuery(this).closest('li').addClass('preloading');
        }).imagesLoaded3(function(instance) {
            jQuery.each(instance.images, function(i, image) {
                var $image = jQuery(image.img);
                setTimeout(function() {
                    $image.closest('li').removeClass('preloading');
                }, 500 * (i + 1));
            });
        }).always(function() {
            if (slideShow['autoplay']) {
                var numSlides = slideShow['number'];
                var curSlide = 0;
                setInterval(function() {
                    //console.info(autoplay);
                    if (autoplay) {
                        $slideshow.kwicks('expand', ++curSlide % numSlides);
                    }
                }, slideShow['pauseTime']);
            }
        }).progress(function(instance, image) {
            if (!image.isLoaded) {
                var $image = jQuery(image.img);
                $image.attr('broken_src', $image.attr('src'));

                var width = $image.attr('width');
                var height = $image.attr('height');

                function fillBrokenImage(width, height) {
                    var canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;

                    return canvas.toDataURL();
                }

                if ( !! document.createElement('canvas').getContext && width && height) {
                    $image.attr('src', fillBrokenImage(width, height));
                } else {
                    $image.attr('src', image_url + '/blank.gif');
                }
            }
        });
    }
});
