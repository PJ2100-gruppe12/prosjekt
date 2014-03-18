/*! jquery switcher - v0.1.0 - 2013-08-28
* https://github.com/amazingSurge/jquery-switcher
* Copyright (c) 2013 amazingSurge; Licensed GPL */
(function($) {
    "use strict";

    var Switcher = $.switcher = function(input, options) {

        this.$input = $(input).wrap('<div></div>');
        this.$element = this.$input.parent();

        var meta = {
            disabled: this.$input.prop('disabled'),
            checked: this.$input.prop('checked')
        };

        this.options = $.extend({}, Switcher.defaults, options, meta);
        this.namespace = this.options.namespace;

        this.classes = {
            skin: this.namespace + '_' + this.options.skin,
            on: this.namespace + '_on',
            off: this.namespace + '_off'
        };

        this.$element.addClass(this.namespace);

        if (!this.options.skin !== null) {
            this.$element.addClass(this.classes.skin);
        }

        this.checked = this.options.checked;
        this.disabled = this.options.disabled;
        this.initial = false;

        // flag
        this._click = true;

        this.init();
    };

    Switcher.prototype = {
        constuctor: Switcher,
        init: function() {
            var opts = this.options;

            this.$inner = $('<div class="' + this.namespace + '-inner"></div>');
            this.$innerBox = $('<div class="' + this.namespace + '-inner-box"></div>');
            this.$on = $('<div class="' + this.namespace + '-on">' + opts.onText + '</div>');
            this.$off = $('<div class="' + this.namespace + '-off">' + opts.offText + '</div>');
            this.$handle = $('<div class="' + this.namespace + '-handle"></div>');

            this.$innerBox.append(this.$on, this.$off);
            this.$inner.append(this.$innerBox);
            this.$element.append(this.$inner, this.$handle);

            // get components width
            var w = this.$on.width();
            var h = this.$handle.width();

            this.distance = w - h / 2;

            if (this.options.clickable === true) {
                this.$element.on('click.switcher touchstart.switcher', $.proxy(this.click, this));
                
            }

            if (this.options.dragable === true) {
                this.$handle.on('mousedown.switcher touchstart.switcher', $.proxy(this.mousedown, this));
                this.$handle.on('click.switcher', function() {
                    return false;
                });
            }

            this.set(this.checked);
            this.initial = true;

            this.$input.trigger('switcher::ready', this);
        },
        animate: function(pos, callback) {
            // prevent animate when first load
            if (this.initial === false) {
                this.$innerBox.css({
                    marginLeft: pos
                });

                this.$handle.css({
                    left: this.distance + pos
                });

                if ($.type(callback) === 'function') {
                    callback();
                }
                return false;
            }

            this.$innerBox.stop().animate({
                marginLeft: pos
            }, {
                duration: this.options.animation,
                complete: callback
            });

            this.$handle.stop().animate({
                left: this.distance + pos
            }, {
                duration: this.options.animation
            });
        },
        getDragPos: function(e) {
            return e.pageX || ((e.originalEvent.changedTouches) ? e.originalEvent.changedTouches[0].pageX : 0);
        },
        move: function(pos) {
            pos = Math.max(-this.distance, Math.min(pos, 0));

            this.$innerBox.css({
                marginLeft: pos
            });

            this.$handle.css({
                left: this.distance + pos
            });
        },
        click: function() {

            if (this._click === false) {
                this._click = true;
                return false;
            }

            if (this.checked === true) {
                this.set(false);
            } else {
                this.set(true);
            }

            return false;
        },
        mousedown: function(e) {
            var dragDistance,
                self = this,
                startX = this.getDragPos(e);

            if (this.disabled === true) {
                return;
            }

            this.mousemove = function(e) {
                var current = this.getDragPos(e);

                if (this.checked === true) {
                    dragDistance = current - startX > 0 ? 0 : (current - startX < -this.distance ? -this.distance : current - startX);
                } else {
                    dragDistance = current - startX < 0 ? -this.distance : (current - startX > this.distance ? 0 : -this.distance + current - startX);
                }

                this.move(dragDistance);
                this.$handle.off('mouseup');
                return false;
            };

            this.mouseup = function() {
                var currPos = parseInt(this.$innerBox.css('margin-left'), 10);

                if (Math.abs(currPos) >= this.distance / 2) {
                    this.set(false);
                }

                if (Math.abs(currPos) < this.distance / 2) {
                    this.set(true);
                }

                $(document).off('.switcher');

                this.$handle.off('mouseup');
                return false;
            };

            $(document).on({
                'mousemove.switcher': $.proxy(this.mousemove, this),
                'mouseup.switcher': $.proxy(this.mouseup, this),
                'touchmove.switcher': $.proxy(this.mousemove, this),
                'touchend.switcher': $.proxy(this.mouseup, this)
            });

            if (this.options.clickable === true) {
                this.$handle.on('mouseup touchend', function() {
                    if (self.checked === true) {
                        self.set(false);
                    } else {
                        self.set(true);
                    }

                    self.$handle.off('mouseup touchend');

                    $(document).off('.switcher');
                });
            }

            return false;
        },
        check: function() {
            this.set(true);
            return this;
        },
        uncheck: function() {
            this.set(false);
            return this;
        },
        set: function(value) {
            var self = this;
            if (this.disabled === true) {
                return;
            }
            switch (value) {
                case true:
                    this.checked = value;
                    this.$input.trigger('switcher::checked', this);
                    this.$input.prop('checked', true);
                    this.animate(0, function() {
                        self.$element.removeClass(self.classes.off).addClass(self.classes.on);
                    });
                    break;
                case false:
                    this.checked = value;
                    this.$input.trigger('switcher::unchecked', this);
                    this.$input.prop('checked', false);
                    this.animate(-this.distance, function() {
                        self.$element.removeClass(self.classes.on).addClass(self.classes.off);
                    });
                    break;
            }
            return this;
        },
        get: function() {
            return this.$input.prop('checked');
        },

        /*
            Public Method
         */  
        
        val: function(value) {
            if (value) {
                this.set(value);
            } else {
                return this.get();
            }
        },
        enable: function() {
            this.disabled = false;
            this.$input.prop('disabled', false);
            this.$element.removeClass(this.namespace + '-disabled');
            return this;
        },
        disable: function() {
            this.disabled = true;
            this.$input.prop('disabled', true);
            this.$element.addClass(this.namespace + '-disabled');
            return this;
        },
        destroy: function() {
            this.$element.off('.switcher');
            this.$handle.off('.switcher');
        }
    };
    Switcher.defaults = {
        namespace: 'switcher',
        skin: null,

        dragable: true,
        clickable: true,
        disabled: false,

        onText: 'ON',
        offText: 'OFF',

        checked: true,
        animation: 200
    };

    $.fn.switcher = function(options) {
        if (typeof options === 'string') {
            var method = options;
            var method_arguments = arguments.length > 1 ? Array.prototype.slice.call(arguments, 1) : undefined;

            if (/^(getTabs|getPanes|getCurrentPane|getCurrentTab|getIndex)$/.test(method)) {
                var api = this.first().data('switcher');
                if (api && typeof api[method] === 'function') {
                    return api[method].apply(api, method_arguments);
                }
            } else {
                return this.each(function() {
                    var api = $.data(this, 'switcher');
                    if (api && typeof api[method] === 'function') {
                        api[method].apply(api, method_arguments);
                    }
                });
            }
        } else {
            return this.each(function() {
                if (!$.data(this, 'switcher')) {
                    $.data(this, 'switcher', new Switcher(this, options));
                }
            });
        }
    };
}(jQuery));