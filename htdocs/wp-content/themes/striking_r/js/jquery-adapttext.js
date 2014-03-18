/*! jQuery AdaptText - v1.1.0 - 2014-01-05
* https://github.com/amazingSurge/jquery-adaptText
* Copyright (c) 2014 amazingSurge; Licensed MIT */
(function(window, document, $, undefined) {
    "use strict";

    var instances = [],
        viewportWidth = $(window).width();

    // Constructor
    var AdaptText = $.AdaptText = function(element, options) {
        // Attach element to the 'this' keyword
        this.element = element;
        this.$element = $(element);

        // options
        this.options = $.extend(true, {}, AdaptText.defaults, options, this.$element.data());

        this.width = this.$element.width();

        var self = this;
        $.extend(self, {
            init: function() {
                self.resize();

                if (self.options.scrollable) {
                    self.scrollOnHover();
                }
            },
            scrollOnHover: function() {
                self.$element.css({
                    'overflow': 'hidden',
                    'text-overflow': 'ellipsis',
                    'white-space': 'nowrap'
                });
                self.$element.hover(function() {
                    var distance = self.element.scrollWidth - self.$element.width();

                    if (distance > 0) {
                        var scrollSpeed = Math.sqrt(distance / self.width) * self.options.scrollSpeed;

                        self.$element.css('cursor', 'e-resize');
                        return self.$element.stop().animate({
                            "text-indent": -distance
                        }, scrollSpeed, function() {
                            return self.$element.css('cursor', 'text');
                        });
                    }
                }, function() {
                    return self.$element.stop().animate({
                        "text-indent": 0
                    }, self.options.scrollResetSpeed);
                });
            }
        });

        this.init();
        instances.push(this);
    };

    // Default options for the plugin as a simple object
    AdaptText.defaults = {
        compression: 10,
        max: Number.POSITIVE_INFINITY,
        min: Number.NEGATIVE_INFINITY,
        scrollable: false,
        scrollSpeed: 1000,
        scrollResetSpeed: 300,
        onResizeEvent: true
    };

    AdaptText.prototype = {
        constructor: AdaptText,

        resize: function() {
            this.width = this.$element.width();
            if (this.width === 0) {
                return;
            }

            this.$element.css('font-size', Math.floor(Math.max(
                Math.min(this.width / (this.options.compression), parseFloat(this.options.max)),
                parseFloat(this.options.min)
            )));
        },
    };

    AdaptText.resize = function() {
        if ($(window).width() === viewportWidth) {
            return;
        }
        viewportWidth = $(window).width();

        $.each(instances, function() {
            if (this.options.onResizeEvent) {
                this.resize();
            }
        });
    };

    // Collection method.
    $.fn.adaptText = function(options) {
        if (typeof options === 'string') {
            var method = options;
            var method_arguments = arguments.length > 1 ? Array.prototype.slice.call(arguments, 1) : undefined;

            return this.each(function() {
                var api = $.data(this, 'adaptText');
                if (typeof api[method] === 'function') {
                    api[method].apply(api, method_arguments);
                }
            });
        } else {
            return this.each(function() {
                if (!$.data(this, 'adaptText')) {
                    $.data(this, 'adaptText', new AdaptText(this, options));
                }
            });
        }
    };

    if (window.addEventListener) {
        window.addEventListener("resize", AdaptText.resize, false);
    } else if (window.attachEvent) {
        window.attachEvent("onresize", AdaptText.resize);
    }
}(window, document, jQuery));
