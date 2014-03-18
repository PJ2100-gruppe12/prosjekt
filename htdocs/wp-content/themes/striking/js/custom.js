;
jQuery.noConflict();

jQuery(document).ready(function($) {
    $("#navigation > ul").nav({
        child: {
            beforeFirstRender: function() {
                if ($(this).find('.cufon').length > 0) {
                    Cufon.replace($('> a', this));
                }
            }
        },
        root: {
            afterHoverIn: function() {},
            afterHoverOut: function() {},
            beforeHoverIn: function() {
                $(this).addClass('hover');
                if ($(this).find('.cufon').length > 0) {
                    Cufon.replace($('> a', this));
                }
            },
            beforeHoverOut: function() {
                $(this).removeClass('hover');
                if ($(this).find('.cufon').length > 0) {
                    Cufon.replace($('> a', this));
                }
            }
        }
    });

    $("#sidebar_content .widget:last-child").css('margin-bottom', '20px');
    $(".home #sidebar_content .widget:last-child").css('margin-bottom', '0px');
    $('.top a').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
        return false;
    });
    if ($('body').is('.scroll-to-top')) {
        $('body').append('<a href="#top" id="back-to-top">Back To Top</a>');
        $(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
            // scroll body to 0px on click
            $('#back-to-top').click(function() {
                var $delay = $(window).scrollTop();
                $('body,html').animate({
                    scrollTop: 0
                }, 500 * Math.atan($delay / 3000));
                return false;
            });
        });
    }
    $(".icon_email").each(function() {
        if ($(this).attr('href') !== undefined) {
            $(this).attr('href', $(this).attr('href').replace("*", "@"));
        }
        $(this).html($(this).html().replace("*", "@"));
    });

    $(".tabs_container").each(function() {
        var $history = $(this).attr('data-history');
        if ($history !== undefined && $history === 'true') {
            $history = true;
        } else {
            $history = false;
        }
        var $initialIndex = $(this).attr('data-initialIndex');
        if ($initialIndex === undefined) {
            $initialIndex = 0;
        }
        $("ul.tabs, ul.theme_tabs", this).tabs("div.panes > div, div.theme_panes > div", {
                tabs: 'a',
                effect: 'fade',
                fadeOutSpeed: -400,
                history: $history,
                initialIndex: $initialIndex
            });
    }).addClass('tabs_inited');
    $(".mini_tabs_container").each(function() {
        var $history = $(this).attr('data-history');
        if ($history !== undefined && $history === 'true') {
            $history = true;
        } else {
            $history = false;
        }
        var $initialIndex = $(this).attr('data-initialIndex');
        if ($initialIndex === undefined) {
            $initialIndex = 0;
        }
        $("ul.mini_tabs, ul.theme_mini_tabs", this).tabs("div.panes > div, div.theme_panes > div", {
                tabs: 'a',
                effect: 'fade',
                fadeOutSpeed: -400,
                history: $history,
                initialIndex: $initialIndex
            });
    }).addClass('tabs_inited');
    if ($.tools !== undefined) {
        if ($.tools.tabs !== undefined) {
            $.tools.tabs.addEffect("slide", function(i, done) {
                this.getPanes().slideUp();
                this.getPanes().eq(i).slideDown(function() {
                    done.call();
                });
            });
        }
    }
    $(".accordion, .theme_accordion").each(function() {
        var $initialIndex = $(this).attr('data-initialIndex');
        if ($initialIndex === undefined) {
            $initialIndex = 0;
        }
        $(this).tabs("div.pane, div.theme_pane", {
            tabs: '.tab, .theme_tab',
            effect: 'slide',
            initialIndex: $initialIndex
        });
    });
    $(".toggle_title").click(function() {
        var parent = $(this).parent('.toggle');
        if (parent.is(".toggle_active")) {
            parent.removeClass('toggle_active');
            $(this).siblings('.toggle_content').slideUp("fast");
            $(this).trigger('toggle::close');
        } else {
            parent.addClass('toggle_active');
            $(this).siblings('.toggle_content').slideDown("fast");
            $(this).trigger('toggle::open');
        }
    });
    $(".button, .theme_button").hover(function() {
        var $hoverBg = $(this).attr('data-hoverBg');
        var $hoverColor = $(this).attr('data-hoverColor');

        if ($hoverBg !== undefined) {
            $(this).css('background-color', $hoverBg);
        }
        if ($hoverColor !== undefined) {
            $('span', this).css('color', $hoverColor);
        }
    }, function() {
        var $hoverBg = $(this).attr('data-hoverBg');
        var $hoverColor = $(this).attr('data-hoverColor');
        var $bg = $(this).attr('data-bg');
        var $color = $(this).attr('data-color');

        if ($hoverBg !== undefined) {
            if ($bg !== undefined) {
                $(this).css('background-color', $bg);
            } else {
                $(this).css('background-color', '');
            }
        }
        if ($hoverColor !== undefined) {
            if ($color !== undefined) {
                $('span', this).css('color', $color);
            } else {
                $('span', this).css('color', '');
            }
        }
    });
    if (!$('body').is('.no_colorbox')) {
        $(".colorbox").each(function() {
            var $iframe = $(this).attr('data-iframe');
            if ($iframe == undefined || $iframe == 'false') {
                $iframe = false;
            } else {
                $iframe = true;
            }
            var $href = false;
            var $inline = $(this).attr('data-inline');
            if ($inline == undefined || $inline == 'false') {
                $inline = false;
            } else {
                $inline = true;
                $href = $(this).attr('data-href');
            }
            var $restrict = $(this).attr('data-fittoview');
            if ($restrict == undefined) {
                if (typeof restrict_colorbox == "undefined") {
                    $restrict = false;
                } else {
                    $restrict = true;
                }
            } else if ($restrict == 'true') {
                $restrict = true;
            } else {
                $restrict = false;
            }

            var $maxWidth = false;
            var $maxHeight = false;
            var $width = $(this).attr('data-width');
            if ($width == undefined) {
                if ($iframe == true || $inline == true) {
                    $width = '80%';
                } else {
                    $width = '';
                }
                if ($restrict == true) {
                    $maxWidth = '95%';
                }
            }
            var $height = $(this).attr('data-height');
            if ($height == undefined) {
                if ($iframe == true || $inline == true) {
                    $height = '80%';
                } else {
                    $height = '';
                }
                if ($restrict == true) {
                    $maxHeight = '95%';
                }
            }
            var $photo = $(this).attr('data-photo');
            if ($photo == undefined || $photo == 'false') {
                $photo = false;
            } else {
                $photo = true;
            }
            var $close = $(this).attr('data-close');
            if ($close == undefined || $close == 'true') {
                $close = true;
            } else {
                $close = false;
            }
            $(this).colorbox({
                opacity: 0.7,
                innerWidth: $width,
                innerHeight: $height,
                maxWidth: $maxWidth,
                maxHeight: $maxHeight,
                iframe: $iframe,
                inline: $inline,
                href: $href,
                photo: $photo,
                onLoad: function() {
                    if (!$close) {
                        $("#cboxClose").css("visibility", "hidden");
                    } else {
                        $("#cboxClose").css("visibility", "visible");
                    }
                    $("#colorbox").removeClass('withVideo');
                },
                onComplete: function() {
                    if (typeof Cufon !== "undefined") {
                        Cufon.replace('#cboxTitle');
                    }
                }
            });
        });
    }

    /* enable lightbox */
    var enable_lightbox = function(parent) {
        if ($('body').is('.no_colorbox')) {
            return;
        }
        $("a.lightbox[href*='http://www.vimeo.com/']", parent).each(function() {
            $(this).attr('href', this.href.replace("www.vimeo.com/", "player.vimeo.com/video/"));
        });
        $("a.lightbox[href*='http://vimeo.com/']", parent).each(function() {
            $(this).attr('href', this.href.replace("vimeo.com/", "player.vimeo.com/video/"));
        });
        $("a.lightbox[href*='http://www.youtube.com/watch?']", parent).each(function() {
            $(this).attr('href', this.href.replace(new RegExp("watch\\?v=", "i"), "embed/") + '?autoplay=1');
        });
        $("a.lightbox[href*='http://player.vimeo.com/']", parent).each(function() {
            $(this).addClass("fancyVimeo").removeClass('lightbox');
        });
        $("a.lightbox[href*='http://www.youtube.com/embed/']", parent).each(function() {
            $(this).addClass("fancyYoutube").removeClass('lightbox');
        });
        $("a.lightbox[href*='http://www.youtube.com/v/']", parent).each(function() {
            $(this).addClass("fancyVideo").removeClass('lightbox');
        });
        $("a.lightbox[href*='.swf']", parent).each(function() {
            $(this).addClass("fancyVideo").removeClass('lightbox');
        });
        $(".fancyVimeo,.fancyYoutube", parent).each(function() {
            var $width = $(this).attr('data-width');
            if ($width == undefined) {
                $width = '640';
            }
            var $height = $(this).attr('data-height');
            if ($height == undefined) {
                $height = '408';
            }
            $(this).colorbox({
                opacity: 0.7,
                innerWidth: $width,
                innerHeight: $height,
                iframe: true,
                scrolling: false,
                current: "{current} of {total}",
                onLoad: function() {
                    $("#cboxClose").css("visibility", "hidden");
                    $("#colorbox").addClass('withVideo');
                },
                onComplete: function() {
                    if (typeof Cufon !== "undefined") {
                        Cufon.replace('#cboxTitle');
                    }
                },
                onCleanup: function() {
                    //$("#cboxLoadedContent").html('');
                }
            });
        });

        $(".fancyVideo", parent).each(function() {
            var $width = $(this).attr('data-width');
            if ($width == undefined) {
                $width = '640';
            }
            var $height = $(this).attr('data-height');
            if ($height == undefined) {
                $height = '390';
            }

            $(this).colorbox({
                opacity: 0.7,
                innerWidth: $width,
                innerHeight: $height,
                html: '<div></div>',
                scrolling: false,
                current: "{current} of {total}",
                //rel:'nofollow',
                onLoad: function() {
                    $("#cboxClose").css("visibility", "hidden");
                    $("#colorbox").addClass('withVideo');
                },
                onComplete: function() {
                    if (typeof Cufon !== "undefined") {
                        Cufon.replace('#cboxTitle');
                    }
                    $("#cboxLoadedContent").html('<div id="cboxSwfobject"></div>');
                    swfobject.embedSWF(this.href, "cboxSwfobject", $width, $height, "10", "expressInstall.swf", {
                        autostart: "true"
                    }, {
                        play: 'true',
                        wmode: 'transparent'
                    });
                },
                onCleanup: function() {
                    //$("#cboxLoadedContent").html('');
                }
            });
        });
        $(".fancyLightbox", parent).each(function() {
            var $iframe = $(this).attr('data-iframe');
            if ($iframe == undefined || $iframe == 'false') {
                $iframe = false;
            } else {
                $iframe = true;
            }
            var $href = false;
            var $inline = $(this).attr('data-inline');
            if ($inline == undefined || $inline == 'false') {
                $inline = false;
            } else {
                $inline = true;
                $href = $(this).attr('data-href');
            }
            var $width = $(this).attr('data-width');
            if ($width == undefined) {
                $width = '640';
            }
            var $height = $(this).attr('data-height');
            if ($height == undefined) {
                $height = '390';
            }
            $(this).colorbox({
                opacity: 0.7,
                innerWidth: $width,
                innerHeight: $height,
                iframe: $iframe,
                inline: $inline,
                href: $href,
                current: "{current} of {total}",
                onLoad: function() {
                    $("#cboxClose").css("visibility", "visible");
                    $("#colorbox").removeClass('withVideo');

                },
                onComplete: function() {
                    if (typeof Cufon !== "undefined") {
                        Cufon.replace('#cboxTitle');
                    }
                    if ($("#cboxLoadedContent .video-js").length > 0) {
                        $("#cboxLoadedContent .video-js").each(function() {
                            if (typeof this.player !== "undefined") {
                                $(this).css("height", this.height);
                                //this.player.height(this.height);
                                this.player.positionAll();
                            }
                        });
                    }
                },
                onCleanup: function() {
                    //$("#cboxLoadedContent").html('');
                }
            });
        });

        $(".lightbox", parent).each(function() {
            var $maxWidth = false;
            var $maxHeight = false;

            var $restrict = $(this).attr('data-fittoview');
            if ($restrict == undefined) {
                if (typeof restrict_colorbox == "undefined") {
                    $maxWidth = false;
                    $maxHeight = false;
                } else {
                    $maxWidth = "95%";
                    $maxHeight = "95%";
                }
            } else if ($restrict == 'true') {
                $maxWidth = "95%";
                $maxHeight = "95%";
            } else {
                $maxWidth = false;
                $maxHeight = false;
            }
            $(this).colorbox({
                opacity: 0.7,
                maxWidth: $maxWidth,
                maxHeight: $maxHeight,
                current: "{current} of {total}",
                onLoad: function() {
                    $("#cboxClose").css("visibility", "visible");
                    $("#colorbox").removeClass('withVideo');
                },
                onComplete: function() {
                    if (typeof Cufon !== "undefined") {
                        Cufon.replace('#cboxTitle');
                    }
                }
            });

        });
    };
    enable_lightbox(document);

    if (!$('body').is('.no_colorbox') && $.browser.msie && parseInt($.browser.version, 10) < 9) {
        /* fix ie colorbox png transparent background bug */
        document.getElementById("cboxTopLeft").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image_url + "/colorbox_ie/borderTopLeft.png', sizingMethod='scale')";
        document.getElementById("cboxTopCenter").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image_url + "/colorbox_ie/borderTopCenter.png', sizingMethod='scale')";
        document.getElementById("cboxTopRight").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image_url + "/colorbox_ie/borderTopRight.png', sizingMethod='scale')";
        document.getElementById("cboxBottomLeft").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image_url + "/colorbox_ie/borderBottomLeft.png', sizingMethod='scale')";
        document.getElementById("cboxBottomCenter").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image_url + "/colorbox_ie/borderBottomCenter.png', sizingMethod='scale')";
        document.getElementById("cboxBottomRight").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image_url + "/colorbox_ie/borderBottomRight.png', sizingMethod='scale')";
        document.getElementById("cboxMiddleLeft").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image_url + "/colorbox_ie/borderMiddleLeft.png', sizingMethod='scale')";
        document.getElementById("cboxMiddleRight").style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image_url + "/colorbox_ie/borderMiddleRight.png', sizingMethod='scale')";
    }

    /* enable image hover effect */
    var enable_image_hover = function(image) {
        if (image.is(".image_icon_zoom,.image_icon_play,.image_icon_doc,.image_icon_link")) {
            if ($.browser.msie && parseInt($.browser.version, 10) < 7) {} else {
                if ($.browser.msie && parseInt($.browser.version, 10) < 9) {
                    image.hover(function() {
                        $(".image_overlay", this).css("visibility", "visible");
                    }, function() {
                        $(".image_overlay", this).css("visibility", "hidden");
                    }).children('img').after('<span class="image_overlay"></span>');
                } else {
                    image.hover(function() {
                        $(".image_overlay", this).animate({
                            opacity: '1'
                        }, "fast");
                    }, function() {
                        $(".image_overlay", this).animate({
                            opacity: '0'
                        }, "fast");
                    }).children('img').after($('<span class="image_overlay"></span>').css({
                        opacity: '0',
                        visibility: 'visible'
                    }));
                }
            }
        }
    };
    // Grayscale w canvas method
    var grayscale = function(src) {
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var imgObj = new Image();
        imgObj.src = src;
        canvas.width = imgObj.width;
        canvas.height = imgObj.height;
        ctx.drawImage(imgObj, 0, 0);
        var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
        for (var y = 0; y < imgPixels.height; y++) {
            for (var x = 0; x < imgPixels.width; x++) {
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

    var enable_image_grayscale_hover = function(image) {
        var canvasSupported = !! document.createElement("canvas").getContext;
        if (!canvasSupported) {
            return false;
        }
        var $img = $('img', image);
        $img.fadeIn(500);
        // clone image
        $img.each(function() {
            var el = $(this);
            var width = el.outerWidth(),
                height = el.outerHeight();

            el.css({
                "position": "absolute"
            }).wrap("<div class='grayscale-wrapper' style='display: inline-block'>").clone().addClass('img_grayscale').css({
                "position": "absolute",
                "z-index": "100",
                "opacity": "0",
                "visibility": "visible"
            }).insertBefore(el).queue(function() {
                var el = $(this);
                el.parent().css({
                    "width": width,
                    "height": height
                });
                el.dequeue();
            });
            this.src = grayscale(this.src);
            el.parent('.grayscale-wrapper').data('ratio', width / height);

        });
        if (typeof grayscale_animSpeed === 'undefined') {
            grayscale_animSpeed = 1000;
        }
        if (typeof grayscale_outSpeed === 'undefined') {
            grayscale_outSpeed = 1000;
        }
        // Fade image 
        $('img', image).mouseover(function() {
            $(this).parent().find('img:first').stop().animate({
                opacity: 1
            }, grayscale_animSpeed);
        }).mouseout(function() {
            $(this).stop().animate({
                opacity: 0
            }, grayscale_outSpeed);
        });
    };

    $('.image_no_link').click(function() {
        return false;
    });

    function fillBrokenImage(width, height) {
        var canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;

        return canvas.toDataURL();
    }

    function preloader($to_be_load_images) {
        $to_be_load_images.each(function() {
            $(this).before('<div class="image-loading"/>');
        }).imagesLoaded3(function(instance) {
            $.each(instance.images, function(i, image) {
                var $image = $(image.img);
                setTimeout(function() {
                    var image_frame = $image.closest('.image_frame');
                    var image = $image.closest('a');

                    if (image_frame.is('.effect-grayscale')) {
                        enable_image_grayscale_hover(image);
                    } else if (image_frame.is('.effect-icon')) {
                        enable_image_hover(image);
                    }

                    $image.css('visibility', 'visible').animate({
                        opacity: 1
                    }, 500, function() {
                        image.find('.image-loading').remove();
                        image_frame.css('background-image', 'none');
                    });
                }, 200 * (i + 1));
            });
        }).progress(function(instance, image) {
            if (!image.isLoaded) {
                var $image = $(image.img);
                $image.attr('broken_src', $image.attr('src'));

                var width = $image.attr('width');
                var height = $image.attr('height');

                if ( !! document.createElement('canvas').getContext && width && height) {
                    $image.attr('src', fillBrokenImage(width, height));
                } else {
                    $image.attr('src', image_url + '/blank.gif');
                }
            }
        });
    }


    /* portfolio sortable */
    $(".portfolios").each(function() {
        var $section = $(this);
        var $pagenavi = $('.wp-pagenavi', this);
        var $ajax = false;
        if ($section.attr('data-options') !== undefined) {
            eval("var $options = " + $section.attr('data-options'));
            $ajax = true;
        } else {
            var $options = {};
        }
        var $cufon = false;
        if ($section.find('.portfolio_title .cufon').length > 0) {
            $cufon = true;
        }

        if ($section.is('.sortable')) {
            var $preferences = {
                duration: 1000,
                easing: 'easeInOutQuad',
                attribute: function(v) {
                    return $(v).attr('data-id');
                },
                enhancement: function() {
                    if (typeof Cufon !== "undefined" && $cufon === true) {
                        if ($.browser.msie) {
                            $('.portfolio_title').each(function() {
                                $(this).html($(this).text());
                            });
                        }
                        Cufon.replace('.portfolio_title');
                    }
                }
            };

            var $list = $('ul', this);

            var $data = $list.clone();
            $data.find('.image_frame img').css('visibility', 'visible');
            if (typeof Cufon !== "undefined" && $cufon === true) {
                $data.find('.portfolio_title').each(function() {
                    if ($('a', this).length > 0) {
                        $('a', this).html(this.textContent);
                    } else {
                        $(this).html(this.textContent);
                    }
                });
            }
            var $column;
            if ($list.is('.portfolio_one_column')) {
                $column = 1;
            } else if ($list.is('.portfolio_two_columns')) {
                $column = 2;
            } else if ($list.is('.portfolio_three_columns')) {
                $column = 3;
            } else if ($list.is('.portfolio_four_columns')) {
                $column = 4;
            }


            var $callback = function() {
                if ($.browser.msie && parseInt($.browser.version, 10) < 9 && parseInt($.browser.version, 10) > 6) {
                    $list.find('.image_shadow').css('visibility', 'visible');
                }
                enable_lightbox($list);
                $list.find('.image_frame').css('background-image', 'none');
                $list.find('.image_frame').each(function() {
                    if ($(this).is('.effect-grayscale')) {
                        if ($(this).find('.grayscale-wrapper').length === 0) {
                            enable_image_grayscale_hover($('a', this));
                        }
                    } else if ($(this).is('.effect-icon')) {
                        enable_image_hover($('a', this));
                    }
                });

                if (typeof Cufon !== "undefined" && $cufon === true && $.browser.msie && parseInt($.browser.version, 10) < 7) {
                    $list.find('.portfolio_title').each(function() {
                        if ($('a', this).length > 0) {
                            $('a', this).html($(this).text());
                        } else {
                            $(this).html($(this).text());
                        }
                    });
                    Cufon.replace('.portfolio_title');
                }
            };
            var $ajax_callback = function(data) {
                var $temp = $(data);
                $temp.find('.image_frame img').css('visibility', 'visible');
                var $temp_pagenavi = $temp.find('.wp-pagenavi');
                $list.quicksand($temp.find('li'), $preferences, $callback);
                if ($.browser.msie && parseInt($.browser.version, 10) < 7) {
                    $callback();
                }
                if ($temp_pagenavi.length > 0) {
                    $pagenavi = $section.find('.wp-pagenavi');
                    if ($pagenavi.length > 0) {
                        $pagenavi.html($temp_pagenavi.html());
                    } else {
                        $temp_pagenavi.appendTo($section);
                    }
                } else {
                    $section.find('.wp-pagenavi').remove();
                }
            };
            if ($ajax) {
                $(this).on('click', '.wp-pagenavi a', function(e) {
                    var category = 'all';
                    if ($section.find('.sort_by_cat a.current').length > 0) {
                        category = $section.find('.sort_by_cat a.current').attr('data-value');
                    }

                    $.post(window.location.href, {
                        portfolioAjax: true,
                        portfolioOptions: $options,
                        category: category,
                        portfolioPage: $(this).attr('data-page')
                    }, $ajax_callback);

                    e.preventDefault();
                });
            }

            $('.sort_by_cat a', this).click(function(e) {
                if ($.browser.msie && parseInt($.browser.version, 10) < 9) {
                    $list.find('.image_shadow').css('visibility', 'hidden');
                    $data.find('.image_shadow').css('visibility', 'hidden');
                }
                $(this).siblings('.current').removeClass('current');
                $(this).addClass('current');

                if ($ajax) {
                    var category = $(this).attr('data-value');
                    $.post(window.location.href, {
                        portfolioAjax: true,
                        portfolioOptions: $options,
                        category: category
                    }, $ajax_callback);
                } else {
                    var $sorted_data;
                    if ($(this).attr('data-value') === 'all') {
                        $sorted_data = $data.find('li').clone();
                    } else {
                        $sorted_data = $data.find('li[data-type*=' + $(this).attr('data-value') + ']').clone();
                    }

                    $list.quicksand($sorted_data, $preferences, $callback);
                    if ($.browser.msie && parseInt($.browser.version, 10) < 7) {
                        $callback();
                    }
                }

                e.preventDefault();
            });
        } else {
            if ($ajax) {
                $(this).on('click', '.wp-pagenavi a', function(e) {
                    $.post(window.location.href, {
                        portfolioAjax: true,
                        portfolioOptions: $options,
                        portfolioPage: $(this).attr('data-page')
                    }, function(data) {
                        $section.html(data);
                        enable_lightbox($section);
                        if (typeof Cufon !== "undefined" && $cufon === true) {
                            Cufon.replace('.portfolio_title');
                        }

                        preloader($section.find('.portfolio_image .image_frame img'));
                    });

                    e.preventDefault();
                });
            }
        }
    });

    preloader($(".portfolios").find('.portfolio_image .image_frame img'));

    preloader($(".content,#top_area,#content,#sidebar,#footer").find('.image_styled:not(.portfolio_image) .image_frame img'));

    $(".gallery .gallery-image").imagesLoaded3(function(instance) {
        $.each(instance.images, function(i, image) {
            var $image = $(image.img);
            setTimeout(function() {
                $image.css('visibility', 'visible').animate({
                    opacity: 1
                }, 500, function() {
                    if ($(this).is('.effect-grayscale')) {
                        enable_image_grayscale_hover($(this).parent());
                    } else {
                        $(this).hover(function() {
                            $(this).animate({
                                opacity: '0.8'
                            }, "fast");
                        }, function() {
                            $(this).animate({
                                opacity: '1'
                            }, "fast");
                        });
                    }
                });
            }, 100 * (i + 1));
        });
    });


    $(".contact_info_wrap .icon_email").each(function() {
        $(this).attr('href', $(this).attr('href').replace("*", "@"));
        $(this).html($(this).html().replace("*", "@"));
    });
    if ($.tools.validator !== undefined) {
        $.tools.validator.addEffect("contact_form", function(errors, event) {
            $.each(errors, function(index, error) {
                var input = error.input;

                input.addClass('invalid');
            });
        }, function(inputs) {
            inputs.removeClass('invalid');
        }); /* contact form widget */
        $('.widget_contact_form .contact_form').validator({
            effect: 'contact_form'
        }).submit(function(e) {
            var form = $(this);
            if (!e.isDefaultPrevented()) {
                $.post(this.action, {
                    'theme_contact_form_submit': 1,
                    'to': $('input[name="contact_to"]').val().replace("*", "@"),
                    'name': $('input[name="contact_name"]').val(),
                    'email': $('input[name="contact_email"]').val(),
                    'content': $('textarea[name="contact_content"]').val()
                }, function(data) {
                    form.fadeOut('fast', function() {
                        $(this).siblings('p').show();
                    }).delay(3000).fadeIn('fast', function() {
                        $(this).find('input[name="contact_name"]').val('');
                        $(this).find('input[name="contact_email"]').val('');
                        $(this).find('textarea[name="contact_content"]').val('');
                        $(this).siblings('p').hide();
                    });
                });
                e.preventDefault();
            }
        }); /* contact page form */
        $('.contact_form_wrap .contact_form').validator({
            effect: 'contact_form'
        }).submit(function(e) {
            var form = $(this);
            if (!e.isDefaultPrevented()) {
                var $id = form.find('input[name="contact_widget_id"]').val();
                $.post(this.action, {
                    'theme_contact_form_submit': 1,
                    'to': $('input[name="contact_' + $id + '_to"]').val().replace("*", "@"),
                    'name': $('input[name="contact_' + $id + '_name"]').val(),
                    'email': $('input[name="contact_' + $id + '_email"]').val(),
                    'content': $('textarea[name="contact_' + $id + '_content"]').val()
                }, function(data) {
                    form.fadeOut('fast', function() {
                        $(this).siblings('.success').show();
                    }).delay(3000).fadeIn('fast', function() {
                        $(this).find('input[name="contact_' + $id + '_name"]').val('');
                        $(this).find('input[name="contact_' + $id + '_email"]').val('');
                        $(this).find('textarea[name="contact_' + $id + '_content"]').val('');
                        $(this).siblings('.success').hide();
                    });
                });
                e.preventDefault();
            }
        });
    }
});
