/*! jQuery carousel - v0.2.1 - 2014-01-25
* https://github.com/amazingSurge/jquery-carousel
* Copyright (c) 2014 amazingSurge; Licensed GPL */
(function(window, document, $, undefined) {
	'use strict';

	// Constructor
	var Carousel = function(element, options) {
		this.element = element;
		this.$element = $(element);

		// options
		this.options = $.extend(true, {}, Carousel.defaults, options, this.$element.data());

		// Namespacing
		var namespace = this.options.namespace;
		this.$element.addClass(namespace);
		this.$ul = this.$element.children('ul');
		this.$wrap = this.$element.wrap('<div class="' + namespace + '-wrap" />').parent();

		this.current = 0;
		this.view = 0;

		this.navItems = this.options.navItems;

		this.isMoving = false;
		this.onTransition = false;

		var self = this;
		$.extend(self, {
			init: {
				prepare: function(api) {
					// json support
					if (typeof self.options.load === "function") {
						self.options.load(self.loadContent);
					} else {
						this.run(api);
					}
				},
				run: function(api) {
					// namespacing
					self.$items = self.$ul.children();
					self.itemsLength = self.$items.length;
					self.transition = self.transition();

					self.build();

					if (self.options.pager) {
						self.pager.setup();
					}
					if (self.options.nav) {
						self.nav.setup();
					}
					// Auto start
					if (self.options.autoplay) {
						self.autoplay.enabled = true;
						self.autoplay.start();
					}
					// keyDown support 
					if (self.options.keyboard) {
						self.$element.trigger('carousel::init', self);
						self.keyboard(api);
					}

					// Mousewheel support
					if (self.options.mousewheel) {
						self.mousewheel();
					}
					// Responsive support
					if (self.options.responsive) {
						self.responsive.init();
					}

					// Touch
					// touch force some settings
					if (self.options.touch) {
						self.touch.setup();
					}

					self.animation.init();

					self.$element.on('go', function(e, data) {
						if (typeof data.force === 'undefined' || data.force === false) {
							if (self.view === data.current && !self.isMoving) {
								return;
							}
						}
						var to = data.index;
						if (self.options.circular) {
							if (!self.isMoving) {
								self.$ul.css(self.transition.prefix + 'transition-duration', self.options.speed + 'ms');
								if (self.offsetNext) {
									to = to - self.offset + self.reserve;
								} else if (self.offsetPrev) {
									to = to - self.offset - self.reserve;
								}
							} else {
								to = to - self.offset;
							}
						}
						self.animation.run(to * self.itemSize);
						self.view = data.index;
					});
				}
			},
			loadContent: function(data) {
				var items = '';
				$.each(data, function(i, n) {
					items += self.options.render(n);
				});
				self.$ul.html(items);
				self.init.run(self);
			},
			build: function() {
				this.$ul.addClass(namespace + '-items');

				if ((this.options.direction === 'right') || (this.options.direction === 'left')) {
					this.direction = "horizontal";
				} else if ((this.options.direction === 'top') || (this.options.direction === 'bottom')) {
					this.direction = "vertical";
				}
				if (this.options.circular) {
					var cycleContent = this.$ul.children().clone();
					this.$ul.append(cycleContent);
					this.$items = this.$ul.children();
				}

				this.fillGutter();

				// give init state
				if (this.options.circular) {
					for (var i = 0; i < this.visibleItems; i++) {
						this.$items = this.$ul.children();
						this.$items.last().insertBefore(this.$items.first());
					}
					this.$ul.css(this.animateProperty, -this.itemSize * this.visibleItems);
				} else {
					this.$ul.css(this.animateProperty, '0');
				}
			},
			getCssVariables: function() {
				if (this.direction === "horizontal") {
					return {
						'viewport': this.$element.width(),
						'item': this.$items.outerWidth(),
						'before': 'margin-left',
						'after': 'margin-right',
						'animate': 'left'
					};
				} else {
					return {
						'viewport': this.$element.height(),
						'item': this.$items.outerHeight(),
						'before': 'margin-top',
						'after': 'margin-bottom',
						'animate': 'top'
					};
				}
			},
			fillGutter: function() {
				var variables = self.getCssVariables();

				this.visibleItems = Math.floor(variables.viewport / variables.item);
				if (this.visibleItems === 0) {
					this.visibleItems = 1;
				}

				if (this.navItems > this.visibleItems || this.navItems === 0) {
					this.navItems = this.visibleItems;
				} else if (this.options.navItems < this.visibleItems) {
					this.navItem = this.options.navItems;
				}

				var gutterSize = Math.round(((variables.viewport / this.visibleItems - variables.item) / 2)),
					styles = {};

				if (gutterSize < 0) {
					gutterSize = 0;
				}

				styles[variables.before] = gutterSize;
				styles[variables.after] = gutterSize;

				this.$items.css(styles);

				this.itemSize = variables.item + gutterSize * 2;
				this.viewportSize = variables.viewport;
				this.animateProperty = variables.animate;

				this.offset = -this.visibleItems;
				this.reserve = this.navItems;
			},
			pager: {
				setup: function() {
					// init
					self.currentPager = 0;

					// build dom
					self.$pager = $('<ul class="' + namespace + '-pager" />');
					this.build();
					self.$pager.appendTo(self.$wrap);

					// bind events
					self.pager.bind();

					// active current pager
					self.pager.active(self.currentPager);
				},
				build: function() {
					var itemMarkup = [],
						i = Math.ceil(self.itemsLength / self.visibleItems);
					for (var n = 1; n <= i; n++) {
						itemMarkup += "<li>" + "<a href='#'>" + n + "</a>" + "</li>";
					}
					self.$pager.html(itemMarkup);
					self.pager.$items = self.$pager.children();
				},
				update: function() {
					// rebuild pager items
					this.build();

					// get new current pager
					var pager = Math.floor(self.current / self.visibleItems);
					self.pager.active(pager);
				},
				bind: function() {
					self.$pager.on('click', 'li', function() {
						var to = $(this).index() * self.visibleItems;
						self.current = to;
						if ($(this).index() === self.pager.$items.length - 1 && !self.options.circular) {
							to = self.itemsLength - self.visibleItems;
						} else if (self.options.circular) {
							var navItemsMirror = self.view - to;
							if ((navItemsMirror > 0) && (navItemsMirror <= 3)) {
								self.offsetPrev = true;
								self.offsetNext = false;
								self.reserve = navItemsMirror;
								self.offset -= self.reserve;
							} else {
								self.offsetPrev = false;
								self.offsetNext = true;
								if (navItemsMirror < 0) {
									self.reserve = -navItemsMirror;
									self.offset += self.reserve;
								} else {
									self.reserve = self.itemsLength - self.view;
									self.offset = to - self.visibleItems;
								}
							}
						}
						self.goTo(to, self.current);
						return false;
					});

					self.$element.on('go', function(e, data) {
						var pager = Math.floor(data.current / self.visibleItems);
						if (pager !== self.currentPager) {
							self.pager.active(pager);
						}
					});
				},
				active: function(i) {
					self.currentPager = i;
					self.pager.$items.removeClass(namespace + '-pager-active').eq(i).addClass(namespace + '-pager-active');
				}
			},
			nav: {
				setup: function() {
					self.$nav = $('<div class="' + namespace + '-nav">' + '<a href="#" class="' + namespace + '-nav-prev">' + self.options.prevText +
						'</a>' + '<a href="#" class="' + namespace + '-nav-next">' + self.options.nextText + '</a>' + '</div>');

					self.$nav.appendTo(self.$wrap);

					self.$nav.on("click", 'a', function() {
						if ($(this).is('.' + namespace + '-nav-prev')) {
							self.prev(self.navItems);
						} else {
							self.next(self.navItems);
						}
						return false;
					});
				}
			},
			autoplay: {
				enabled: false,
				timeout: null,
				start: function() {
					self.options.infinite = true;

					if (this.timeout) {
						clearTimeout(this.timeout);
					}
					this.timeout = setTimeout(function() {
						self.go();
					}, self.options.delay);
				},
				stop: function() {
					clearTimeout(this.timeout);
				}
			},
			responsive: {
				init: function() {
					$(window).on("resize", this.resize);
				},
				resize: function() {
					var prevVisiableItems = self.visibleItems;
					self.fillGutter();

					if (self.options.pager) {
						self.pager.update();
					}

					if (!self.options.circular) {
						self.$element.trigger('go', {
							index: self.current,
							current: self.current,
							force: true
						});
					} else {
						var reserve = prevVisiableItems - self.visibleItems;
						if (reserve > 0) {
							self.offsetNext = true;
							self.offsetPrev = false;
							self.reserve = reserve;
							self.animation.reserve();
						} else if (reserve < 0) {
							self.offsetNext = false;
							self.offsetPrev = true;
							self.reserve = -reserve;
							self.animation.reserve();
						}
						self.$ul.css(self.animateProperty, -self.itemSize * self.visibleItems);
					}
				}
			},
			mousewheel: function() {
				var element = self.$element.get(0);

				var callback = function(element) {
					var roll = 0;
					if (element.preventDefault) {
						element.preventDefault();
					} else {
						element.returnValue = !1;
						element.cancelBubble = !0;
					}
					if (element.wheelDelta) {
						roll = element.wheelDelta / 120;
					} else if (element.detail) {
						roll = -element.detail / 3;
					}
					if (roll > 0) {
						self.prev(self.navItems);
					} else if (roll < 0) {
						self.next(self.navItems);
					}
				};
				self.$element.attr('tabindex', '0').on('focus', function() {
					if (element.addEventListener) {
						element.addEventListener('mousewheel', callback, false);
						element.addEventListener("DOMMouseScroll", callback, false);
					} else if (element.attachEvent) {
						element.attachEvent('onmousewheel', callback);
					}
				}).on('blur', function() {
					if (element.addEventListener) {
						element.removeEventListener('mousewheel', callback, false);
						element.removeEventListener("DOMMouseScroll", callback, false);
					} else if (element.attachEvent) {
						element.detachEvent('onmousewheel', callback);
					}
				});
			},
			keyboard: function(api) {
				var keyboard;
				if (api._keyboard) {
					keyboard = $.extend(true, {}, api._keyboard);
				} else {
					return false;
				}

				self.$element.attr('tabindex', '0').on('focus', function() {
					keyboard.attach({
						left: function() {
							self.prev(self.navItems);
						},
						right: function() {
							self.next(self.navItems);
						},
						up: function() {
							self.prev(self.navItems);
						},
						down: function() {
							self.next(self.navItems);
						}
					});
					return false;
				}).on('blur', function() {
					keyboard.detach();
				});
			},
			animation: {
				init: function() {
					if (self.transition.supported) {
						self.$ul.css(self.transition.prefix + 'transition-duration', self.options.speed + 'ms').addClass('easing_' + self.options.easing)
							.on(self.transition.end, this.end);
					}
				},
				reserve: function() {
					var i;
					if (self.offsetNext) {
						for (i = 0; i < self.reserve; i++) {
							self.$items = self.$ul.children();
							self.$items.first().insertAfter(self.$items.last());
						}
					} else if (self.offsetPrev) {
						for (i = 0; i < self.reserve; i++) {
							self.$items = self.$ul.children();
							self.$items.last().insertBefore(self.$items.first());
						}
					}
				},
				end: function() {
					if (self.options.circular && !self.isMoving) {
						self.$ul.css(self.transition.prefix + 'transition-duration', '0ms').css(self.animateProperty, -self.visibleItems * self.itemSize);
						self.animation.reserve();
						self.onTransition = false;
					}
					if (self.autoplay.enabled) {
						self.autoplay.start();
					}
					self.isMoving = false;
				},
				run: function(distance) {
					if (self.transition.supported) {
						self.$ul.css(self.animateProperty, -distance);
					} else {
						var style = {};
						style[self.animateProperty] = -distance;
						self.$ul.animate(style, self.options.speed, self.options.easing, this.end);
					}
				}
			},
			transition: function() {
				var e,
					end,
					prefix = '',
					supported = false,
					el = document.createElement("fakeelement"),
					transitions = {
						"WebkitTransition": "webkitTransitionEnd",
						"MozTransition": "transitionend",
						"OTransition": "oTransitionend",
						"transition": "transitionend"
					};
				for (e in transitions) {
					if (el.style[e] !== undefined) {
						end = transitions[e];
						supported = true;
						break;
					}
				}
				if (/(WebKit)/i.test(window.navigator.userAgent)) {
					prefix = '-webkit-';
				}
				return {
					prefix: prefix,
					end: end,
					supported: supported
				};
			},
			touch: {
				supported: ("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch,
				eventType: function(action) {
					var eventTypes = {
						start: (this.supported ? 'touchstart' : 'mousedown'),
						move: (this.supported ? 'touchmove' : 'mousemove'),
						end: (this.supported ? 'touchend' : 'mouseup'),
						cancel: (this.supported ? 'touchcancel' : 'mouseout')
					};
					return eventTypes[action];
				},
				setup: function() {
					self.$element.on(this.eventType('start'), $.proxy(this.startTouch, this));
				},
				getEvent: function(event) {
					var e = event.originalEvent;
					if (self.touch.supported && e.touches.length && e.touches[0]) {
						e = e.touches[0];
					}
					return e;
				},
				calculate: function() {
					var value = Math.round(this.posValue * self.visibleItems - self.current);
					if (!self.options.circular) {
						if (value <= self.visibleItems - self.itemsLength) {
							value = self.itemsLength - 1;
						} else if (value >= 0) {
							value = 0;
						}
					} else {
						if (self.offset < -self.visibleItems) {
							value = self.itemsLength - value;
							self.offset = value - self.visibleItems;
						} else if (self.offset >= self.itemsLength - self.visibleItems) {
							self.offset = self.offset - self.itemsLength;
							value = self.offset + self.visibleItems;
						} else {
							value = self.view - value;
						}
					}
					return Math.abs(value);
				},
				reserve: function(value, valueMirror) {
					if (self.offset === self.view - valueMirror - self.visibleItems) {
						return;
					}
					if (self.offset > self.view - valueMirror - self.visibleItems) {
						self.offset -= 1;
						self.offsetNext = false;
						self.offsetPrev = true;
					} else if (self.offset < self.view - valueMirror - self.visibleItems) {
						self.offset += 1;
						self.offsetNext = true;
						self.offsetPrev = false;
					}
					self.reserve = 1;
					self.animation.reserve();
				},
				move: function(value) {
					if (self.options.circular) {
						self.current = 0;
					} else {
						if (self.current === self.itemsLength - 1) {
							self.current = self.itemsLength - self.visibleItems;
						}
					}
					value = Math.round(value * 100) / 100;
					var posValue = value / 100 * self.viewportSize - self.current * self.itemSize;
					this.posValue = value / 100;
					// cancel css3 transition
					this.cancelTransition();
					if (self.options.circular) {
						var valueMirror = Math.round(this.posValue * self.visibleItems);
						this.reserve(value, valueMirror);
						posValue = posValue - (self.visibleItems + valueMirror) * self.itemSize;
					}
					self.$ul.css(self.animateProperty, posValue);
				},
				startTouch: function(e) {
					if (self.isMoving) {
						return false;
					}

					var event = this.getEvent(e);
					this.data = {};
					if (self.direction === "horizontal") {
						this.data.start = event.pageX;
					} else if (self.direction === "vertical") {
						this.data.start = event.pageY;
					}

					this.posValue = 0;

					$(document).on(this.eventType('move'), $.proxy(this.moving, this)).on(this.eventType('end'), $.proxy(this.endTouch, this));
					return self.$element.focus(), false;
				},
				moving: function(e) {
					self.$element.addClass(namespace + '_moving');
					self.easingMirror = self.options.easing;
					self.options.easing = 'linear';
					var $anchor = self.$ul.find('a');
					$anchor.one('click', function(e) {
						e.preventDefault();
					});

					var event = this.getEvent(e),
						value;
					if (self.direction === "horizontal") {
						value = (event.pageX || this.data.start) - this.data.start;
					} else if (self.direction === "vertical") {
						value = (event.pageY || this.data.start) - this.data.start;
					}
					var percent = value / self.viewportSize * 100;
					this.move(percent);
					return false;
				},
				endTouch: function() {
					$(document).off(this.eventType('move')).off(this.eventType('end'));

					if (this.posValue === 0) {
						return;
					}
					var index = this.calculate();
					self.isMoving = true;
					this.addTransition();
					self.current = index;
					if (index === self.itemsLength - 1 && !self.options.circular) {
						index = self.itemsLength - self.visibleItems;
					}
					self.goTo(index, self.current);
					self.options.easing = self.easingMirror;
					self.$element.removeClass(namespace + '_moving');
					return false;
				},
				cancelTransition: function() {
					self.$ul.css(self.transition.prefix + 'transition-duration', '0ms');
				},
				addTransition: function() {
					self.$ul.css(self.transition.prefix + 'transition-duration', self.options.speed / 2 + 'ms');
				}
			}
		});

		this.init.prepare(this);
	};

	// Default options for the plugin as a simple object
	Carousel.defaults = {
		namespace: 'carousel',

		autoplay: false,
		infinite: false,
		circular: false,
		delay: 4000,
		speed: 1000,
		direction: 'right', //top, right, bottom, left
		easing: 'linear',

		pager: true, // Boolean: Show pager, true or false

		nav: true, // Boolean: Show navigation, true or false,
		navItems: 1,

		prevText: "Previous", // String: Text for the "previous" button
		nextText: "Next", // String: Text for the "next" button

		render: function(item) {
			return '<li><img src="' + item.img + '" alt="" /></li>';
		},
		load: null,
		/* function(callback){},*/

		mousewheel: true,
		touch: true,
		keyboard: true,
		responsive: true
	};

	Carousel.prototype = {
		constructor: Carousel,
		next: function(number) {
			if (typeof number === 'undefined' || (number === 0 || number > this.visibleItems)) {
				number = this.visibleItems;
			}
			var to = this.view + number;
			if (to > this.itemsLength - 1) {
				if (this.options.infinite) {
					if (this.options.circular) {
						to = to - this.itemsLength;
					} else {
						to = 0;
					}
				} else {
					to = this.itemsLength - 1;
				}
			}
			this.current = to;
			if (!this.options.circular) {
				if (to >= this.itemsLength - this.visibleItems) {
					to = this.itemsLength - this.visibleItems;
					if (this.view >= this.itemsLength - this.visibleItems && this.options.infinite) {
						this.current = 0;
						to = 0;
					} else {
						this.current = this.itemsLength - 1;
					}
				}
			} else {
				if (this.onTransition) {
					return;
				}
				this.onTransition = true;
				this.offset += number;
				if (this.offset + this.visibleItems >= this.itemsLength) {
					this.offset = to - this.visibleItems;
				}
				this.reserve = number;
				this.offsetNext = true;
				this.offsetPrev = false;
			}
			this.goTo(to, this.current);
			return false;
		},
		prev: function(number) {
			if (typeof number === 'undefined' || (number === 0 || number > this.visibleItems)) {
				number = this.visibleItems;
			}
			var to = this.view - number;

			if (to < 0) {
				if (this.options.infinite) {
					if (this.options.circular) {
						to = to + this.itemsLength;
					} else {
						to = this.itemsLength - 1;
					}
				} else {
					to = 0;
				}
			}
			this.current = to;
			if (!this.options.circular) {
				if (this.view > 0 && this.view < number) {
					to = 0;
					this.current = 0;
				}
				if (to > this.itemsLength - this.visibleItems) {
					to = this.itemsLength - this.visibleItems;
					this.current = this.itemsLength - 1;
				}
			} else {
				if (this.onTransition) {
					return;
				}
				this.onTransition = true;
				this.offset -= number;
				if (this.offset < -this.visibleItems) {
					this.offset = to - this.visibleItems;
				}
				this.reserve = number;
				this.offsetNext = false;
				this.offsetPrev = true;
			}
			this.goTo(to, this.current);
			return false;
		},
		go: function() {
			if ((this.options.direction === 'right') || (this.options.direction === 'bottom')) {
				this.next(this.navItems);
			}
			if ((this.options.direction === 'left') || (this.options.direction === 'top')) {
				this.prev(this.navItems);
			}
		},
		goTo: function(index, current) {
			this.$element.trigger('go', {
				index: index,
				current: current
			});
		},
		play: function() {
			this.autoplay.enabled = true;
			this.autoplay.start();
		},
		pause: function() {
			this.autoplay.stop();
		},
		stop: function() {
			this.autoplay.enabled = false;
			this.autoplay.stop();
		},
		destroy: function() {
			this.$trigger.remove();
			this.$element.data('Carousel', null);
		}
	};

	// Collection method.
	$.fn.carousel = function(options) {
		if (typeof options === 'string') {
			var method = options;
			var method_arguments = arguments.length > 1 ? Array.prototype.slice.call(arguments, 1) : undefined;

			return this.each(function() {
				var api = $.data(this, 'carousel');

				if (api && typeof api[method] === 'function') {
					api[method].apply(api, method_arguments);
				}
			});
		} else {
			return this.each(function() {
				if (!$.data(this, 'carousel')) {
					$.data(this, 'carousel', new Carousel(this, options));
				}
			});
		}
	};
}(window, document, jQuery));

// keyboard
(function(window, document, $, undefined) {
	var $doc = $(document);
	var keyboard = {
		keys: {
			'UP': 38,
			'DOWN': 40,
			'LEFT': 37,
			'RIGHT': 39
		},
		map: {},
		bound: false,
		press: function(e) {
			var key = e.keyCode || e.which;
			if (key in keyboard.map && typeof keyboard.map[key] === 'function') {
				keyboard.map[key](e);
			}
			return false;
		},
		attach: function(map) {
			var key, up;
			for (key in map) {
				if (map.hasOwnProperty(key)) {
					up = key.toUpperCase();
					if (up in keyboard.keys) {
						keyboard.map[keyboard.keys[up]] = map[key];
					} else {
						keyboard.map[up] = map[key];
					}
				}
			}
			if (!keyboard.bound) {
				keyboard.bound = true;
				$doc.bind('keydown', keyboard.press);
			}
		},
		detach: function() {
			keyboard.bound = false;
			keyboard.map = {};
			$doc.unbind('keydown', keyboard.press);
		}
	};
	$doc.on('carousel::init', function(event, instance) {
		if (instance.options.keyboard === true) {
			instance._keyboard = keyboard;
		}
	});
})(window, document, jQuery);
