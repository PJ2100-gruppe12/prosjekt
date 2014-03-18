/*! jquery choice - v0.2.0 - 2013-11-22
* https://github.com/amazingSurge/jquery-choice
* Copyright (c) 2013 amazingSurge; Licensed GPL */
(function($) {
    "use strict";

    var Choice = $.choice = function(select, options) {
        this.select = select;
        this.$select = $(select);

        this.$options = this.$select.find('option');
        var meta = {};

        if (this.$options.length !== 0) {
            meta.status = {};
            meta.value = [];
            meta.multiple = this.$select.prop('multiple');

            $.each(this.$options, function(i, v) {
                meta.status[$(v).attr('value')] = {};
                meta.status[$(v).attr('value')].text = $(v).text();
                if ($(v).prop('selected')) {
                    meta.value.push($(v).attr('value'));
                }
            });
        }

        this.options = $.extend({}, Choice.defaults, options, meta);
        this.namespace = this.options.namespace;
        this.status = this.options.status;

        this.classes = {
            selected: this.namespace + '-selected',
            disabled: this.namespace + '-disabled',
            skin: this.namespace + '_' + this.options.skin
        };

        this.value = [];
        this.disabled = false;
        this.init();
    };

    Choice.prototype = {
        constuctor: Choice,
        init: function() {
            var self = this,
                tpl = '<li><span class="' + self.namespace + '-text"></span></li>';

            this.$select.css({
                display: 'none'
            });

            this.$wrap = $('<ul></ul>');
            this.$wrap.addClass(this.namespace);
            if (this.options.skin) {
                this.$wrap.addClass(this.classes.skin);
            }

            $.each(this.status, function(key, value) {
                var $tpl = $(tpl).data('value', key);

                if (typeof value === 'object') {
                    if (value.icon) {
                        $('<i></i>').addClass(value.icon).appendTo($tpl);
                    }
                    if (value.text) {
                        $tpl.find('span').text(value.text);
                    }
                    
                } else {
                    $tpl.find('span').text(value.text);
                }

                $.each(self.value, function(i, v) {
                    if (v === key) {
                        $tpl.addClass(self.classes.selected);
                    }
                });

                self.$wrap.append($tpl);
            });

            this.$select.after(this.$wrap);

            // unselected a link
            this.$wrap.find('a').on('click.choice', function(e) {
                e.preventDefault();
            });

            if (this.options.multiple === true) {
                this.$wrap.delegate('li', 'click.choice touchstart.choice', function() {
                    if ($(this).hasClass(self.classes.selected)) {
                        self.set.call(self, $(this).data('value'), 'unselected');
                        return false;
                    } else {
                        self.set.call(self, $(this).data('value'), 'selected');
                        return false;
                    }

                });
                $.each(this.options.value, function(i, v) {
                    self.set.call(self, v, 'selected');
                });
            } else {
                this.$wrap.delegate('li', 'click.choice touchstart.choice', function() {
                    self.set($(this).data('value'), 'selected');
                });
                this.set(this.options.value[0], 'selected');
            }

            this.$select.trigger('choice::ready', this);
        },
        set: function(value, status) {
            var $option, $li,
                pos = $.inArray(value, this.value);

            if (this.disabled) {
                return;
            }

            if (this.options.multiple === true) {
                $.each(this.$options, function(i, v) {
                    if ($(v).attr('value') === value) {
                        $option = $(v);
                    }
                });
                $.each(this.$wrap.find('li'), function(i, v) {
                    if ($(v).data('value') === value) {
                        $li = $(v);
                    }
                });

                if (status === 'selected') {
                    this.value.push(value);
                    $li.addClass(this.classes.selected);
                    $option.prop('selected', true);

                } else {
                    this.value.splice(pos, 1);
                    $li.removeClass(this.classes.selected);
                    $option.prop('selected', false);
                }

                this.$select.trigger('choice::change', this);
                if (typeof this.options.onChange === 'function') {
                    this.options.onChange.call(this, this.value);
                }
            } else {
                if (value === this.value[0]) {
                    return false;
                }

                if (status === 'unselected') {
                    return false;
                }

                var self = this;
                $.each(this.$options, function(i, v) {
                    if ($(v).attr('value') === value) {
                        $(v).prop('selected', true);
                    } else {
                        $(v).prop('selected', false);
                    }
                });

                $.each(this.$wrap.find('li'), function(i, v) {
                    if ($(v).data('value') === value) {
                        $(v).addClass(self.classes.selected);
                        self.value[0] = value;

                    } else {
                        $(v).removeClass(self.classes.selected);
                    }
                });

                this.$select.trigger('choice::change', this);
                if (typeof this.options.onChange === 'function') {
                    this.options.onChange.call(this, this.value);
                }
            }
        },

        /*
            Public Method
         */
        
        val: function(value, status) {
            if (value && status) {
                this.set(value, status);
            } else {
                return this.value;
            }
        },
        enable: function() {
            this.disabled = false;
            this.$wrap.removeClass(this.classes.disabled);
            return this;
        },
        disable: function() {
            this.disabled = true;
            this.$wrap.addClass(this.classes.disabled);
            return this;
        },
        destroy: function() {
            this.$wrap.undelegate('.choice');
            this.$wrap.find('a').off('.choice');
            this.$wrap.remove();
        }
    };

    Choice.defaults = {
        skin: null,

        multiple: false,
        value: ['default'],

        namespace: 'choice'
    };

    $.fn.choice = function(options) {
        if (typeof options === 'string') {
            var method = options;
            var method_arguments = arguments.length > 1 ? Array.prototype.slice.call(arguments, 1) : undefined;

            return this.each(function() {
                var api = $.data(this, 'choice');
                if (typeof api[method] === 'function') {
                    api[method].apply(api, method_arguments);
                }
            });
        } else {
            return this.each(function() {
                if (!$.data(this, 'choice')) {
                    $.data(this, 'choice', new Choice(this, options));
                }
            });
        }
    };
}(jQuery));


