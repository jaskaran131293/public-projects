/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var container, button, menu, links, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();

(function ($) {
	var screenHeight = $(document).height();
	var screenWidth = $(window).width();
    var $rtl = false;

	if (jQuery("html").attr("dir") == 'rtl'){
		$rtl = true;
	}
    var header1El = $('.site-header.teepro-header-1.fixed .middle-section-wrap');
    if(header1El.length > 0) {
        var sticky = new Waypoint.Sticky({
            element: $('.site-header.teepro-header-1.fixed .middle-section-wrap')[0],
        })
    }

    var header2El = $('.site-header.teepro-header-2.fixed .middle-section-wrap');
    if(header2El.length > 0) {
        var sticky = new Waypoint.Sticky({
            element: $('.site-header.teepro-header-2.fixed .middle-section-wrap')[0],
        })
    }

    var header3El = $('.site-header.teepro-header-3.fixed .middle-section-wrap');
    if(header3El.length > 0) {
        var sticky = new Waypoint.Sticky({
            element: $('.site-header.teepro-header-3.fixed .middle-section-wrap')[0],
        })
    }

    var  header4El = $('.site-header.teepro-header-4.fixed .middle-section-wrap');
    if(header4El.length > 0) {
        var sticky = new Waypoint.Sticky({
            element: $('.site-header.teepro-header-4.fixed .middle-section-wrap')[0],
        })
	}

    	$('.site-header .top-section-wrap .header_top_right_menu .data_user > a').on('click', function(e) {
		$('.site-header .top-section-wrap .header_top_right_menu .data_user').toggleClass('open');
    });
	

    $('.widget_nav_menu .menu-item-has-children > a').on('click', function(e) {
        e.preventDefault();
        $(this).next('.sub-menu').first().slideToggle('fast');
    });
	
	function menuPosition() {
		if ($('#main-menu ul.sub-menu').length) {
			$('#main-menu ul.sub-menu').each(function () {
				$(this).removeAttr("style");
				var $containerWidth = $("body").outerWidth();
				var $menuwidth = $(this).outerWidth();
				var $parentleft = $(this).parent().offset().left;
				var $parentright = $(this).parent().offset().left + $(this).parent().outerWidth();
				if ($(this).parents('.sub-menu').length) {
					var $menuleft = $parentleft - $(this).outerWidth();
					var $menuright = $parentright + $(this).outerWidth();
					if ($rtl){
						if ($menuleft < 0) {
							if ($menuright > $containerWidth) {
								if ($parentleft > ($containerWidth - $parentright)) {
									$(this).css({
										'width': $parentleft + 'px',
										'left': 'auto',
										'right': '100%'
									});
								} else {
									$(this).css({
										'width': ($containerWidth - $parentright) + 'px',
										'left': '100%',
										'right': 'auto'
									});
								}
							} else {
								$(this).css({
									'left': '100%',
									'right': 'auto'
								});
							}
						} else {
							$(this).css({
								'left': '-100%'
							});
						}
					} else {
						if ($menuright > $containerWidth) {
							if ($menuleft < 0) {
								if ($parentleft > ($containerWidth - $parentright)) {
									$(this).css({
										'width': $parentleft + 'px',
										'left': 'auto',
										'right': '100%'
									});
								} else {
									$(this).css({
										'width': ($containerWidth - $parentright) + 'px',
										'left': '100%',
										'right': 'auto'
									});
								}
							} else {
								$(this).offset({
									'left': $menuleft
								});
							}
						} else {
							$(this).css({
								'left': '100%'
							});
						}
					}
				} else {
					var $menuleft = $parentright - $(this).outerWidth();
					var $menuright = $parentleft + $(this).outerWidth();
					if ($rtl){
						if ($menuleft < 0) {
							if ($menuright > $containerWidth) {
								$(this).offset({
									'left': ($containerWidth - $menuwidth) / 2
								});
							} else {
								$(this).offset({
									'left': $parentleft
								});
							}
						} else {
							$(this).offset({
								'left': $menuleft
							});
						}
					} else {
						if ($menuright > $containerWidth) {
							if ($menuleft < 0) {
								$(this).offset({
									'left': ($containerWidth - $menuwidth) / 2
								});
							} else {
								$(this).offset({
									'left': $menuleft
								});
							}
						} else {
							$(this).offset({
								'left': $parentleft
							});
						}
					}
				}
			});
		}
	}
	function menuShow() {
		$('.main-navigation .menu-main-menu-wrap').toggleClass('active');
	}
	function menuHide() {
		$('.main-navigation .menu-main-menu-wrap').removeClass('active');
        $('.main-navigation .menu-item-has-children').removeClass('open');
	}
	function menuResponsive() {
        var screenHeight = jQuery(window).height();
        var screenWidth = jQuery(window).width();
        if ($('.navigation_right .menu-sub-menu-container').length) {
            if (screenWidth < teepro.menu_resp) {
                $('.navigation_right #menu-sub-menu').appendTo('.navigation_left .menu-main-menu-container');
                $('.main-navigation').appendTo('.navigation_right');
            } else {
                $('.main-navigation').appendTo('.navigation_left');
                $('.navigation_left #menu-sub-menu').appendTo('.navigation_right .menu-sub-menu-container');
            }
        } else {
            if ($('.main-menu-section .nb-header-sub-menu').length) {
                $('.main-menu-section .nb-header-sub-menu > li').appendTo('.nb-navbar');
                $('.main-menu-section .sub-navigation').remove();
            }
        }
        if (screenWidth < teepro.menu_resp) {
            $('.site-header').removeClass('header-desktop');
            $('.site-header').addClass('header-mobile');
            $('.main-navigation').removeClass('main-desktop-navigation');
            $('.main-navigation').addClass('main-mobile-navigation');
			if ($('.admin-bar').length > 0){
				if (screenWidth > 782) {
					$('.main-navigation .menu-main-menu-wrap').css({'height': (screenHeight - 32) + 'px',})
				} else if (screenWidth > 600) {
					$('.main-navigation .menu-main-menu-wrap').css({'height': (screenHeight - 46) + 'px',})
				} else {
					$('.main-navigation .menu-main-menu-wrap').css({'height': screenHeight + 'px',})
				}
			} else {
				$('.main-navigation .menu-main-menu-wrap').css({'height': screenHeight + 'px',})
			}
        } else {
			$('.main-navigation .menu-main-menu-wrap').removeAttr('style');
            $('.site-header').removeClass('header-mobile');
            $('.site-header').addClass('header-desktop');
            $('.main-navigation').removeClass('main-mobile-navigation');
            $('.main-navigation').addClass('main-desktop-navigation');
            $('.main-navigation .menu-main-menu-wrap').removeAttr('style');
            $('.main-navigation .menu-item-has-children').removeClass('open');
            menuPosition();
        }
	}
	
	menuResponsive();
	$('.main-navigation .mobile-toggle-button').on('click', function () {
        menuShow();
    });
    $('.main-navigation .icon-cancel-circle').on('click', function () {
        menuHide();
    });
    $('.main-navigation .menu-item-has-children').on('click', function () {

        $(this).toggleClass('open');
    });
    $('.main-navigation .menu-item-has-children > *').on('click', function (e) {
        e.stopPropagation();
    });
	$(window).on('resize', function () {
        menuResponsive();
    });

	
    if($().imagesLoaded) {
        var $blog_masonry = $('.blog .masonry').imagesLoaded( function() {
            // init Isotope after all images have loaded
            $blog_masonry.isotope({
                itemSelector: '.post',
            });
        });
    }

    var d = 0;
    var $numbertype = null;

    var quantityButton = function() {
        $(".quantity-plus, .quantity-minus").mousedown(function () {
            $el = $(this).closest('.nb-quantity').find('.qty');
            $numbertype = parseInt($el.val());
            d = $(this).is(".quantity-minus") ? -1 : 1;
            $numbertype = $numbertype + d;
            if($numbertype > 0) {
                $el.val($numbertype)
            }

            $( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );

        });
    };
    quantityButton();

    jQuery(document.body).on('removed_from_cart updated_cart_totals', function () {
        quantityButton();
    });

    if (jQuery().magnificPopup) {
        $('.featured-gallery').magnificPopup({
            delegate: 'img',
            type: 'image',
            gallery: {
                enabled: true
            },
            callbacks: {
                elementParse: function (item) {
                    item.src = item.el.attr('src');
                }
            }
        });
        $('.popup-search').magnificPopup({
            type: 'inline',
            focus: '.search-field',
            // modal: true,
            // midClick: true
            mainClass: 'mfp-search',
            callbacks: {
                beforeOpen: function () {
                    if ($(window).width() < 700) {
                        this.st.focus = false;
                    } else {
                        this.st.focus = '.search-field';
                    }
                }
            }
        });
        $(document).on('click', '.popup-modal-dismiss', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
        });


    }

    if (jQuery().accordion) {
        $('.shop-main.accordion-tabs .wc-tabs').accordion({
            header: ".accordion-title-wrap",
            heightStyle: "content",
        });
    }

    $('.header-cart-wrap').on({
        mouseenter: function () {
            $(this).find('.mini-cart-section').stop().fadeIn('fast');
        },
        mouseleave: function () {
            $(this).find('.mini-cart-section').stop().fadeOut('fast');
        }
    });

    $('.header-account-wrap').on({
        mouseenter: function () {
            $(this).find('.nb-account-dropdown').stop().fadeIn('fast');
        },
        mouseleave: function () {
            $(this).find('.nb-account-dropdown').stop().fadeOut('fast');
        }
    });

    $(document.body).on('added_to_cart', function () {
        $(".cart-notice-wrap").addClass("active").delay(5000).queue(function(next){
            $(this).removeClass("active");
            next();
        });
    });

    $('.cart-notice-wrap span').on('click', function() {
        $(this).closest('.cart-notice-wrap').removeClass('active');
    });

    var $sticky = $('.sticky-wrapper.sticky-sidebar');

    if($sticky.length > 0) {
        $($sticky).stick_in_parent({
            offset_top: 45
        });

        $(window).on('resize', function() {
            $($sticky).trigger('sticky_kit:detach');
        });
    }

    if ($('#back-to-top-button').length) {
        var scrollTrigger = 500; // px
        var backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top-button').addClass('show');
                } else {
                    $('#back-to-top-button').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back-to-top-button').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }
	if ($('.related .swiper-container').length){
		var slidesm = 2;
		var slidemd = 3;
		if(teepro.related_columns==2){
			slidesm = 1;
			slidemd = 2;
		}
		var related = new Swiper('.related .swiper-container', {
			slidesPerView: teepro.related_columns,
			pagination: {
				el: '.related .swiper-pagination',
				clickable: true,
		  	},
			breakpoints: {
				991: {
					slidesPerView: slidemd
				},
				767: {
					slidesPerView: slidesm
				},
				575: {
					slidesPerView: 1
				}
			}
		});
	}
	if ($('.upsells .swiper-container').length){
		var slidesm = 2;
		var slidemd = 3;
		if(teepro.upsells_columns==2){
			slidesm = 1;
			slidemd = 2;
		}
		var upsells = new Swiper('.upsells .swiper-container', {
			slidesPerView: teepro.upsells_columns,
			pagination: {
				el: '.upsells .swiper-pagination',
				clickable: true,
		  	},
			breakpoints: {
				991: {
					slidesPerView: slidemd
				},
				767: {
					slidesPerView: slidesm
				},
				575: {
					slidesPerView: 1
				}
			}
		});
	}
	if ($('.cross-sells .swiper-container').length){
		var slidemd = 3;
		var slidelg = 4;
		if(teepro.cross_sells_columns==3){
			slidemd = 2;
			slidelg = 3
		}
		var crossSells = new Swiper('.cross-sells .swiper-container', {
			slidesPerView: teepro.cross_sells_columns,
			pagination: {
				el: '.cross-sells .swiper-pagination',
				clickable: true,
		  	},
			breakpoints: {
				1199: {
					slidesPerView: slidelg,
				},
				991: {
					slidesPerView: slidemd,
				},
				767: {
					slidesPerView: 2,
				},
				575: {
					slidesPerView: 1,
				}
			}
		});
    }

    function updateHeightProductGalleryWrapper() {
        var featuredImg = $('.left-thumb .woocommerce-product-gallery__wrapper .featured-gallery img');
        if (featuredImg.length > 0) {
            var featuredImgHeight = featuredImg.eq(0).outerWidth();
            $('.left-thumb .woocommerce-product-gallery__wrapper').css('height', featuredImgHeight);
        }
    }

    updateHeightProductGalleryWrapper();

    
    var swiperInit = function (classColor) {

        classColor = classColor || '';

        if ($('.featured-gallery').length && $('.thumb-gallery').length) {

            var thumbObj = {
                spaceBetween: 10,
                // centeredSlides: true,
                slidesPerView: 4,
                touchRatio: 0.2,
                slideToClickedSlide: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
            }

            if (teepro.thumb_pos === 'left-thumb' || teepro.thumb_pos === 'inside-thumb') {
                thumbObj.direction = 'vertical'
            }                        
            if( classColor != "" ) {
                if ($('.featured-gallery.'+classColor).length ==1  && $('.thumb-gallery.'+classColor).length == 1 ) {
                    var galleryThumbs = new Swiper('.thumb-gallery.'+classColor, thumbObj);
                    var featuredObj = {
                        navigation: {
                            nextEl: '.featured-gallery .swiper-button-next',
                            prevEl: '.featured-gallery .swiper-button-prev',
                        },
                        autoHeight: true,
                        thumbs: {
                            swiper: galleryThumbs,
                        }
                    };
                    var galleryTop = new Swiper('.featured-gallery.'+classColor, featuredObj);
                   
                }
            }else {
                if ($('.featured-gallery').length ==1  && $('.thumb-gallery').length == 1 ) {
                    var galleryThumbs = new Swiper('.thumb-gallery', thumbObj);
                    var featuredObj = {
                        navigation: {
                            nextEl: '.featured-gallery .swiper-button-next',
                            prevEl: '.featured-gallery .swiper-button-prev',
                        },
                        autoHeight: true,
                        thumbs: {
                            swiper: galleryThumbs,
                        }
                    };
                    var galleryTop = new Swiper('.featured-gallery', featuredObj);
                   
                }
                else{ 
                    var galleryThumbs = new Swiper('#yith-quick-view-content .thumb-gallery', thumbObj);
                    var featuredObj = {
                        navigation: {
                            nextEl: '.featured-gallery .swiper-button-next',
                            prevEl: '.featured-gallery .swiper-button-prev',
                        },
                        autoHeight: true,
                        thumbs: {
                            swiper: galleryThumbs,
                        }
                    };
                    var galleryTop = new Swiper('#yith-quick-view-content .featured-gallery', featuredObj);
                }
            }            

            if (teepro.thumb_pos === 'left-thumb' || teepro.thumb_pos === 'inside-thumb') {
                galleryTop.on('resize', function () {
                    if (teepro.thumb_pos === 'left-thumb') {
                        updateHeightProductGalleryWrapper();
                    }
                    galleryThumbs.update();
                });
            }

            $('.single-product-wrap .featured-gallery .woocommerce-product-gallery__image').each(function (index) {
                $(this).attr('data-index', index);
            })

            $('.variations_form').on('show_variation', function (event, variation) {
                var currentindex = 0;
                $('.single-product-wrap .featured-gallery .woocommerce-product-gallery__image').each(function () {
                    var image = $(this).children('img').attr('src');
                    if (image === variation.image.src) {
                        currentindex = $(this).data('index');
                    }
                })
                galleryTop.slideTo(currentindex, 300, false);
            })
        }
    };
    swiperInit();    
	
	var isMobile = false;
	var $variation_form = $('.variations_form');
	var $product_variations = $variation_form.data( 'product_variations' );
	$('body').on('click touchstart','li.swatch-item',function(){
		var current = $(this);
		var value = current.attr('option-value');
		var selector_name = current.closest('ul').attr('data-id');
		if($("select#"+selector_name).find('option[value="'+value+'"]').length > 0)
		{
			$(this).closest('ul').children('li').each(function(){
				$(this).removeClass('selected');
				$(this).removeClass('disable');
			});
			if(!$(this).hasClass('selected'))
			{
				current.addClass('selected');
				$("select#"+selector_name).val(value).change();
				$("select#"+selector_name).trigger('change');
				$variation_form.trigger( 'wc_variation_form' );
				$variation_form
					.trigger( 'woocommerce_variation_select_change' )
					.trigger( 'check_variations', [ '', false ] );
			}
		}else{
			current.addClass('disable');
		}
	});

	$variation_form.on('wc_variation_form', function() {
		$( this ).on( 'click', '.reset_variations', function( event ) {
			$(this).parents('.variations').eq(0).find('ul.swatch li').removeClass('selected');
		});
	});
	var $single_variation_wrap = $variation_form.find( '.single_variation_wrap' );
	$single_variation_wrap.on('show_variation', function(event,variation) {
		var $product = $variation_form.closest('.product');
		if(variation.image_link)
		{
			var variation_image = variation.image_link;
			$product.find('.main-image a').attr('href',variation_image);
			$product.find('.main-image a img').attr('src',variation.image_src);
			$product.find('.main-image a img').attr('srcset',variation.image_srcset);
			$product.find('.main-image a img').attr('alt',variation.image_alt);
			$product.find('.main-image a img').attr('title',variation.image_title);
			$product.find('.main-image a img').attr('sizes',variation.image_sizes);
			$product.find('.main-image img').attr('data-large',variation_image);
		}
	});

    var qv_modal    = $(document).find( '#yith-quick-view-modal' ),
        qv_overlay  = qv_modal.find( '.yith-quick-view-overlay'),
        qv_content  = qv_modal.find( '#yith-quick-view-content' ),
        qv_close    = qv_modal.find( '#yith-quick-view-close' ),
        qv_wrapper  = qv_modal.find( '.yith-wcqv-wrapper'),
        qv_wrapper_w = qv_wrapper.width(),
        qv_wrapper_h = qv_wrapper.height(),
        center_modal = function() {

            var window_w = $(window).width(),
                window_h = $(window).height(),
                width    = ( ( window_w - 60 ) > qv_wrapper_w ) ? qv_wrapper_w : ( window_w - 60 ),
                height   = ( ( window_h - 120 ) > qv_wrapper_h ) ? qv_wrapper_h : ( window_h - 120 );

            qv_wrapper.css({
                'left' : (( window_w/2 ) - ( width/2 )),
                'top' : (( window_h/2 ) - ( height/2 )),
                'width'     : width + 'px',
                'height'    : height + 'px'
            });
        };


    /*==================
     *MAIN BUTTON OPEN
     ==================*/

    $.fn.yith_quick_view = function() {

        $(document).off( 'click', '.yith-wcqv-button' ).on( 'click', '.yith-wcqv-button', function(e){
            e.preventDefault();

            var t           = $(this),
                product_id  = t.data( 'product_id' );
                
            t.block({
                message: null,
                overlayCSS  : {
                    background: '#fff url(' + teepro.loader + ') no-repeat center',
                    opacity   : 0.5,
                    cursor    : 'none'
                }
            });

            t.addClass('loading');

            setTimeout(function() {
                t.removeClass('loading');
            }, 3000);

            if( ! qv_modal.hasClass( 'loading' ) ) {
                qv_modal.addClass('loading')
            }

            // stop loader
            $(document).trigger( 'qv_loading' );
            ajax_call( t, product_id, true );
        });
    };

    /*================
     * MAIN AJAX CALL
     ================*/

    var ajax_call = function( t, product_id, is_blocked ) {

        $.ajax({
            url: teepro.ajaxurl,
            data: {
                action: 'yith_load_product_quick_view',
                product_id: product_id
            },
            dataType: 'html',
            type: 'POST',
            success: function (data) {

                qv_content.html(data);

                // quantity fields for WC 2.2
                if (teepro.is2_2) {
                    qv_content.find('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');
                }

                // Variation Form
                var form_variation = qv_content.find('.variations_form');

                form_variation.wc_variation_form();
                form_variation.trigger('check_variations');

                if (typeof $.fn.yith_wccl !== 'undefined') {
                    form_variation.yith_wccl();
                }

                // Init prettyPhoto
                if (typeof $.fn.prettyPhoto !== 'undefined') {
                    qv_content.find("a[data-rel^='prettyPhoto'], a.zoom").prettyPhoto({
                        hook: 'data-rel',
                        social_tools: false,
                        theme: 'pp_woocommerce',
                        horizontal_padding: 20,
                        opacity: 0.8,
                        deeplinking: false
                    });
                }

                if (!qv_modal.hasClass('open')) {
                    qv_modal.removeClass('loading').addClass('open');
                    if (is_blocked)
                        t.unblock();
                }

                // stop loader
                $(document).trigger('qv_loader_stop');
                updateHeightProductGalleryWrapper();
                swiperInit();
                quantityButton();
            }
        });
    };

    /*===================
     * CLOSE QUICK VIEW
     ===================*/

    var close_modal_qv = function() {

        // Close box by click overlay
        qv_overlay.on( 'click', function(e){
            close_qv();
        });
        // Close box with esc key
        $(document).keyup(function(e){
            if( e.keyCode === 27 )
                close_qv();
        });
        // Close box by click close button
        qv_close.on( 'click', function(e) {
            e.preventDefault();
            close_qv();
        });

        var close_qv = function() {
            qv_modal.removeClass('open').removeClass('loading');

            setTimeout(function () {
                qv_content.html('');
            }, 1000);
        }
    };

    close_modal_qv();


    center_modal();
    $( window ).on( 'resize', center_modal );

    // START
    $.fn.yith_quick_view();

    $( document ).on( 'yith_infs_adding_elem yith-wcan-ajax-filtered', function(){
        // RESTART
        $.fn.yith_quick_view();
    });

    $(document).on('click', '.compare.button', function() {
        $(this).find('.icon-compare').css('visibility', 'hidden');
    });

    $('.widget.shop-sidebar ul.menu .menu-item-has-children.current-menu-parent').addClass('dot');

    $('.widget.shop-sidebar ul.menu .menu-item-has-children > a').click(function(){
        $(this).parent().toggleClass('dot');
    })


    
    jQuery(window).load(function() {
        
        $(".loading").fadeOut(1000, function() {
            $('html').removeClass('html-loading');
        });
        
        var $window = jQuery(window).innerHeight();
        var $html = jQuery('html').innerHeight();
        if($html < $window){
            $('#colophon').css({position:'fixed',width:'100%',bottom:'0',left:'0'})
        }

        jQuery('#secondary #cat-drop-stack').each(function(){
            jQuery(this).parent('.widget').addClass('background');
        })

        jQuery('.shop-main .woof .woof_redraw_zone .woof_container > .woof_container_inner').each(function(){
            var height = jQuery(this).innerHeight();
            jQuery(this).css({height:height,overflowX:'hidden'});
        })

        jQuery('.shop-main .woof_redraw_zone').isotope({
            itemSelector: '.woof_container,.woof_submit_search_form_container',
        })
    })

    $('.woocommerce-cart tbody tr.cart_item td[data-title],.woocommerce-checkout tbody tr.cart_item td[data-title]').each(function(){
        var attr = $(this).attr('data-title');
        $(this).prepend("<span class='title'>"+ attr +"</span>");
    })

    //open popup size guide

    var size_guide_popup = $( '.teepro-open-popup' );

    size_guide_popup.magnificPopup({
        type: 'inline',      
        removalDelay: 500,
        mainClass: 'mfp-fade'
    });

    //show and hide filter block in shop page

    var woof_shortcode      = $( '.shop-main .woof_sid_auto_shortcode' );
    var html_root_el        = $( 'html' );
    var filter_header_text  = $( '.shop-main .woof_filter_button_wrap .woof_toggle_filter_button' ).attr('data-filter-bar-header-txt');
    var filter_btn_close_text  = $( '.shop-main .woof_filter_button_wrap .woof_toggle_filter_button' ).attr('data-filter-bar-close-btn-txt');
    woof_shortcode.addClass('hide_filter');
    woof_shortcode.prepend('<div class="filter_bar_header"><span class="filter_bar_title">' + filter_header_text + '</span><span class="filter_bar_close_btn">' + filter_btn_close_text + '</span></div>');
    $('.woof_toggle_filter_button').on('click', function(e) {
        woof_shortcode.toggleClass('show_filter hide_filter');
        html_root_el.toggleClass('no_scroll');
    });
    $('.filter_bar_close_btn').on('click', function(e) {
        woof_shortcode.toggleClass('show_filter hide_filter');
        html_root_el.toggleClass('no_scroll');
    });


    $("body").on('mouseenter', '.product-image', function() {
        var pt_product_meta=$(this).closest('.pt-product-meta');
        var hover_image_img= pt_product_meta.find('.product-thumbs');
        var img_show = pt_product_meta.find('.attachment-woocommerce_thumbnail');
        var i=hover_image_img.length;

        if (i=0){
            $(img_show).css("opacity", "0");
        }
    });


/**
 *-------------------------------------------------------------------------------------------------------------------------------------------
* Product 360 button
*-------------------------------------------------------------------------------------------------------------------------------------------
*/

    $('.product-360-button a').magnificPopup({
        type: 'inline',
        preloader: false,
        modal: true

    });
    $(document).on('click', '.popup-modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
    });
    

    $(document).ready(function(){



        var $threeSixty = $('.threesixty');

        $threeSixty.threeSixty({
            dragDirection: 'horizontal',
            useKeys: true,
            draggable: true
        });

        $('.next').click(function(){
            $threeSixty.nextFrame();
        });

        $('.prev').click(function(){
            $threeSixty.prevFrame();
        });

        $threeSixty.on('down', function(){
            $('.ui, h1, h2, .label, .examples').stop().animate({opacity:0}, 300);
        });

        $threeSixty.on('up', function(){
            $('.ui, h1, h2, .label, .examples').stop().animate({opacity:1}, 500);
        });
    });



    $('.WC-threed-view').each(function() {
        var $this = $(this),
            w = $this.find('.threesixty-frame.current-image').attr('width'),
            h = $this.find('.threesixty-frame.current-image').attr('heigh');
        $this.width(w).height(h); 
    });

    $('body').on('keyup',function(evt) {
        if (evt.keyCode == 27) {
            $.magnificPopup.close();
        }
    });

    var $product_360_wrapper = $('body .product-360-view-wrapper');

    if($product_360_wrapper.length > 0){
        $('body').mousedown(function (e) {
            if (!$(e.target).is('.threesixty-frame,.ui,.prev,.next,.mfp-arrow')&&($(".mfp-ready").length > 0)&&($(".threesixty-frame:hover").length == 0)) {
                $.magnificPopup.close();   
            }
        });
    }


    $('body').on('click','.single-product-wrap .nbtcs-swatches .swatch-color',function (e) {
        $this = $(this);
        var formCloset = $this.closest('.variations_form'); 
        var product_id = formCloset.attr('data-product_id');
        var varriation_color = $this.attr('data-value');
        var has_class = $('body').find('.woocommerce-product-gallery__wrapper').hasClass('has-gallery');
        var has_class_color = $('body').find('.woocommerce-product-gallery__wrapper').hasClass(varriation_color);
        var class_color_hide = $('body').find('.woocommerce-product-gallery__wrapper').is(":hidden");
        if(has_class_color){
            if(class_color_hide){
                $('body').append('<style>.blockOverlay{display:none !important;}</style>');
                $('.woocommerce-product-gallery__wrapper').not(varriation_color).hide();
                $('body').find('.woocommerce-product-gallery__wrapper.'+ varriation_color).show();
            }
        }else if(has_class){
            $.ajax({
                url: teepro.ajaxurl,
                type: 'POST',
                dataType: 'html',
                data: {
                    action: 'color_ajax',
                    product_id: product_id,
                    varriation_color: varriation_color
                },
                beforeSend: function() {
                    $('body').append('<style>.woocommerce-product-gallery__wrapper:after{display:block !important;}</style>');
                    $('body').append('<style>.woocommerce-product-gallery__wrapper:before{display:block !important;}</style>');
                    $('body').append('<style>.blockOverlay{visibility:hidden !important;}</style>');
                    $('body').append('<style>.yith-wcwl-add-to-wishlist{opacity:1 !important;}</style>');
                },
                success: function(data) {
                    $('body').append('<style>.woocommerce-product-gallery__wrapper:after{display:none !important;}</style>');
                    $('body').append('<style>.woocommerce-product-gallery__wrapper:before{display:none !important;}</style>');
                    $('body').append('<style>.blockOverlay{visibility: visible !important;}</style>');
                    $('.woocommerce-product-gallery__wrapper').not(varriation_color).hide();
                    $('.woocommerce-product-gallery').append(data);
                    swiperInit(varriation_color);                 
                },
                error: function() {

                }
            });
        }
    });
    // allow press enter on coupon button
    $(document).on('keyup', '#coupon_code', function (e) {
		if (e.keyCode == 13 || e.which == 13) {
            e.preventDefault();
            $('input[name="apply_coupon"]').click();
        }
    });


})(jQuery);

/*!
 * ThreeSixty: A jQuery plugin for generating a draggable 360 preview from an image sequence.
 * Version: 0.1.2
 * Original author: @nick-jonas
 * Website: http://www.nickjonas.nyc
 * Licensed under the Apache License Version 2.0
 */

;(function ( $, window, document, undefined ) {

    var scope,
        pluginName = 'threeSixty',
        defaults = {
            dragDirection: 'horizontal',
            useKeys: false,
            draggable: true
        },
        dragDirections = ['horizontal', 'vertical'],
        options = {},
        $el = {},
        data = [],
        total = 0,
        loaded = 0;
    
        /**
         * Constructor
         * @param {jQuery Object} element       main jQuery object
         * @param {Object} customOptions        options to override defaults
         */
        function ThreeSixty( element, customOptions ) {
            scope = this;
            this.element = element;
            options = options = $.extend( {}, defaults, customOptions) ;
            this._defaults = defaults;
            this._name = pluginName;
    
            // make sure string input for drag direction is valid
            if($.inArray(options.dragDirection, dragDirections) < 0){
                options.dragDirection = defaults.dragDirection;
            }
    
            this.init();
        }
    
        // PUBLIC API -----------------------------------------------------
    
        $.fn.destroy = ThreeSixty.prototype.destroy = function(){
            if(options.useKeys === true) $(document).unbind('keydown', this.onKeyDown);
            $(this).removeData();
            $el.html('');
        };
    
        $.fn.nextFrame = ThreeSixty.prototype.nextFrame = function(){
            var frame =  $(this).find('.threesixty-frame');
            var thisTotal = $(this).find('.threesixty-frame').length;
            var val;
                        

            frame.each(function(i){
                var $this = $(this);
                var activeImage = $this.hasClass('current-image');
                if(activeImage){
                    val = parseInt($this.attr('data-index'));
                }
                if((val+1) >= thisTotal){
                    $this.removeClass('current-image');
                    $(frame[0]).removeClass('previous-image').addClass('current-image');
                } ;

            });
            $(frame[val]).removeClass('current-image').addClass('previous-image');
            $(frame[val+1]).removeClass('previous-image').addClass('current-image');
                  
           
            
        };
    
        $.fn.prevFrame = ThreeSixty.prototype.prevFrame = function(){
            var frame =  $(this).find('.threesixty-frame');
            var thisTotal = parseInt($(this).find('.threesixty-frame').length);
            var val;
                        
            frame.each(function(i){
                var $this = $(this);
                var activeImage = $this.hasClass('current-image');
                if(activeImage){
                    val = parseInt($this.attr('data-index'));
                }
                if(val <= 0) {
                    $this.removeClass('current-image');
                    $(frame[thisTotal -1]).removeClass('previous-image').addClass('current-image');
                } ;
            });
            $(frame[val]).removeClass('current-image').addClass('previous-image');
            $(frame[val-1]).removeClass('previous-image').addClass('current-image');
        
           
            
        };
    
    
    
        // PRIVATE METHODS -------------------------------------------------
    
        /**
         * Initializiation, called once from constructor
         * @return null
         */
        ThreeSixty.prototype.init = function () {
            var $this = $(this.element);
            $el = $this;
            _disableTextSelectAndDragIE8();
    
            scope.attachHandlers();
        };
    
           
        var startY = 0,
            thisTotal = 0,
            $downElem = null,
            lastY,
            lastX,
            lastVal,
            x,y,
            isMouseDown = false,
            ontouchstart = false;
            
            
        ThreeSixty.prototype.attachHandlers = function() {
            var that = this;
            var $this = $(this);

            // add draggable events
            if(options.draggable){
                if(typeof document.ontouchstart !== 'undefined' &&
                    typeof document.ontouchmove !== 'undefined' &&
                    typeof document.ontouchend !== 'undefined' &&
                    typeof document.ontouchcancel !== 'undefined'){
                    var elem = $('.threesixty')[0];
                    // elem.addEventListener('touchstart',that.Touchstart);
                    // elem.addEventListener('touchmove', that.onTouchMove);
                    // elem.addEventListener('touchend', that.onTouchEnd);
                    // elem.addEventListener('touchcancel', that.onTouchEnd);

                    elem.addEventListener('touchstart',touchstart);
                    elem.addEventListener('touchmove', touchMove);
                    elem.addEventListener('touchend', touchEnd);
                    elem.addEventListener('touchcancel', touchEnd);
                
                }
            }


            function touchstart(e) {
                
                var touch = e.touches[0];
                e.preventDefault();
                $downElem = $(this).find('.threesixty-frame');
                thisTotal = $('body').find('.threesixty-frame').length;
                $downElem.each(function(i){
                    var $this = $(this);
                    var activeImage = $this.hasClass('current-image');
                    if(activeImage){
                        lastVal = parseInt($this.attr('data-index'));
                    }
    
                });
                lastX = e.touches[0].clientX;
                lastY = e.touches[0].clientY;
                ontouchstart = true;
                $downElem.trigger('down');

            };
        
            function touchMove(e) {
                e.preventDefault();
                var touch = e.touches[0];
                if('ontouchstart' in document.documentElement){
                    x = touch.pageX,
                    y = touch.pageY,
                    val = 0;  
                $downElem.trigger('move');

                    if(x > lastX){    
                        val = lastVal + 1;
                    }else if(x === lastX){
                        return;
                    }else{
                        val = lastVal - 1;
                    }
                

                if((val) >= thisTotal){
                    val = val % (thisTotal - 1);
                    $downElem.removeClass('current-image');
                    $($downElem[val]).removeClass('previous-image').addClass('current-image');
                }
                else if(val <= 0 && val > -thisTotal) {
                    val = thisTotal + val;

                    $($downElem[lastVal]).removeClass('current-image').addClass('previous-image');
                    $($downElem[thisTotal -1]).removeClass('previous-image').addClass('current-image');
                }

                    $($downElem[lastVal]).removeClass('current-image').addClass('previous-image');
                    $($downElem[val]).removeClass('previous-image').addClass('current-image');


                lastVal = val;
              
            }
                
            };
        
            function touchEnd(e) {
                ontouchstart = false;
                $el.trigger('up');
            };
    
            // mouse down
            $el.mousedown(function(e){
                e.preventDefault();
                thisTotal = $(this).find('.threesixty-frame').length;
                $downElem = $(this).find('.threesixty-frame');
                $downElem.each(function(i){
                    var $this = $(this);
                    var activeImage = $this.hasClass('current-image');
                    if(activeImage){
                        lastVal = parseInt($this.attr('data-index'));
                    }

                });
                startY = e.screenY;
                lastX = x || 0;
                lastY = y || 0;
                isMouseDown = true;
                $downElem.trigger('down');
    
            });
    
            // arrow keys
            if(options.useKeys === true){
                $(document).bind('keydown', that.onKeyDown);
            }
    
            // mouse up
            $(document, 'html', 'body').mouseup(that.onMouseUp);
            $(document).blur(that.onMouseUp);
            $('body').mousemove(function(e){
                that.onMove(e.screenX, e.screenY);
            });
        };

    
        
        
        
    
        ThreeSixty.prototype.onMove = function(screenX, screenY){
            if(isMouseDown){
                    x = screenX,
                    y = screenY,
                    val = 0;
                    
                $downElem.trigger('move');
    
                if(options.dragDirection === 'vertical'){
                    if(y > lastY){
                        val = lastVal + 1;
                    }else{
                        val = lastVal - 1;
                    }
                }else{
                    if(x > lastX){
                        val = lastVal + 1;
                    }else if(x === lastX){
                        return;
                    }else{
                        val = lastVal - 1;
                    }
                }

                lastY = y;
                lastX = x;
                

                if((val) >= thisTotal){
                    val = val % (thisTotal - 1);
                    $downElem.removeClass('current-image');
                    $($downElem[val]).removeClass('previous-image').addClass('current-image');
                }
                else if(val <= 0 && val > -thisTotal) {
                    val = thisTotal + val;

                    $($downElem[lastVal]).removeClass('current-image').addClass('previous-image');
                    $($downElem[thisTotal -1]).removeClass('previous-image').addClass('current-image');
                }

                    $($downElem[lastVal]).removeClass('current-image').addClass('previous-image');
                    $($downElem[val]).removeClass('previous-image').addClass('current-image');


                lastVal = val;
              
            }
        };
    
        ThreeSixty.prototype.onKeyDown = function(e) {
            switch(e.keyCode){
                case 37: // left
                    $el.prevFrame();
                    break;
                case 39: // right
                    $el.nextFrame();
                    break;
            }
        };
    
        ThreeSixty.prototype.onMouseUp = function(e) {
            isMouseDown = false;
            $el.trigger('up');
        };
    
        /**
         * Disables text selection and dragging on IE8 and below.
         */
        var _disableTextSelectAndDragIE8 = function() {
          // Disable text selection.
          document.body.onselectstart = function() {
              return false;
          };
    
          // Disable dragging.
          document.body.ondragstart = function() {
              return false;
          };
        };
    
    
        /**
         * A really lightweight plugin wrapper around the constructor,
            preventing against multiple instantiations
         * @param  {Object} options
         * @return {jQuery Object}
         */
        $.fn[pluginName] = function ( options ) {
            return this.each(function () {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName,
                    new ThreeSixty( this, options ));
                }
            });
        };



    // Ajax filter start

        // add query string to url

        function add_query_to_url(){
            current_url = window.location.href;
            separator = current_url.indexOf('?') !== -1 ? "&" : "?";
            url = new URL(current_url);
        }
        function removeParams(key){
            var url = window.location.href.split('?')[0]+'?';
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
        
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] != key) {
                    url = url + sParameterName[0] + '=' + sParameterName[1] + '&'
                }
            }
            return url.substring(0,url.length-1);
        }

        function change_value_param_url(key,value){
            key = "ajax_" + key;
            if(current_url.indexOf(key) == -1){
                new_current_url = current_url + separator + key +"="+ value ;
                window.history.pushState('', '', new_current_url);
            }else{
                url.searchParams.set(key, value);
                newUrl = url.href
                search = '%2C';
                replaceWith = ',';
                newUrl = newUrl.split(search).join(replaceWith);
                window.history.pushState('', '', newUrl);
            }
            if(value == ""){
                newUrl = removeParams(key);
                window.history.pushState('', '', newUrl);
            }
        }
        // Add ranger slider in filter ajax

        var min = Number;
        var max = Number;
        var min_text = $(".min-price-shop span").text()
        var max_text = $(".max-price-shop span").text()
        var page_selected;
        var data_url = $('.orderby').data('url');
        $(function() {
            min = Number($('.min-price-shop').text().replace(min_text,""))
            max = Number($('.max-price-shop').text().replace(max_text,"")) 
            $("#slider-range").slider({
                range: true,
                min: min,
                max: max,
                values: [min,max],
                slide: function(event, ui) {
                $("#amount_min").val(ui.values[0]);
                $("#amount_max").val(ui.values[1]);
                }
            });
            $("#amount_min").val($("#slider-range").slider("values", 0));
            $("#amount_max").val($("#slider-range").slider("values", 1));
            $("#amount_min").change(function() {
                $("#slider-range").slider("values", 0, $(this).val());
                
            });
            $("#amount_max").change(function() {
                $("#slider-range").slider("values", 1, $(this).val());
                
            })
            
        });

        teepro_load_more = false;
        pagination_number_check = false;
        teepro_load_more_scroll = false;

        function beforeSend_ajax_filter(){
            if(teepro_load_more == true || teepro_load_more_scroll == true){
                $('.teepro-load-more-scroll').show();
                $this.html('LOADING... <span class="icon-spin6"> </span>');
                $this.css('opacity','0.5');
                $(' .teepro-load-more .icon-spin6').show();
                $('.teepro-load-more-scroll .icon-spin6' ).show();
            }else{
                $('.teepro-product-content-show .icon-spin6').css("display","inline-block")
                $('.teepro-product-content-show  .grid-type').css("opacity","0")
            }
        }

        function error_ajax_filter(){
            if(teepro_load_more == true || teepro_load_more_scroll == true){
                $('.icon-spin6').hide();
                $(".teepro-load-more").html(text_button);
                $('.teepro-load-more-scroll').hide();
            }else{
                $('.teepro-product-content-show .icon-spin6').css("display","none")
                $('.teepro-product-content-show  .grid-type').css("opacity","1")
            }
        }
        page_number_style = Number;
        function success_ajax_filter(event){
            
            if($(".pagination-number").size() > 0){
                page_number_style = page_selected;
                if(page_selected == ""){
                    page_number_style = 1;
                }
            }
            
            if(teepro_load_more == true){
                $('.icon-spin6').hide();
                $(".teepro-load-more").css('pointer-events','auto');
                $(".teepro-load-more").html(text_button);
                $this.css('opacity','1');   
            }else if(teepro_load_more_scroll == true){
                $('.icon-spin6').hide();
                $(".teepro-load-more").html(text_button);
                page_selected = page_selected + 1;
            }else{
                $('.teepro-product-content-show  .grid-type').empty();
                $('.teepro-product-content-show  .grid-type').css("opacity","1")
                $('.teepro-product-content-show .icon-spin6').css("display","none")
                page_selected = 1;
            }
            $('.chosen-filter').empty()
            
        }

        function complete_ajax_filter(){
            page_number = Number($('.max_num_pages').val()) 
            arr_page_number = [];
            for(i = 1; i <= page_number; i++){
                arr_page_number.push(i)
            }
            
            $('.list-pagination').empty()
            if(arr_page_number.length > 1){
                page_number_new= "";
                arr_page_number.forEach(add_element_pagination);

                function add_element_pagination(item, index) {
                    page_number_new += "<li class='pagination-number' data-url='"+data_url+"'>"+item+"</li>"
                }
                $('.list-pagination').append(page_number_new); 
                $(".pagination-icon").show()
            }else{
                $(".pagination-icon").hide()
            }

            if(page_number_style == 1){ //show pre icon
                $(".pagination-pre").hide()
            }else{
                $(".pagination-pre").show()
            } 
            if($(".pagination-number").length > 1){
                if(page_number_style == $(".pagination-number:last").text()){
                    $(".pagination-next").hide()
                }else{
                    $(".pagination-next").show()
                }
            }

            $(".teepro-load-more").show()

            if(page_number == page_selected || page_number == 0){
                $(".teepro-load-more").hide()
            }
            if(teepro_load_more == true && $('.teepro-load-more').size() > 0){
                page_selected = page_selected + 1;
            }
            if($(".pagination-number").size() > 0){
                pagination_number_array = jQuery('.pagination-number').map(function(){
                    return jQuery.trim(jQuery(this).text());
                }).get();
                $.each(pagination_number_array , function (index, value){
                    if(value == page_number_style){
                        product_attr_selected = $('.pagination-number').eq(index)
                        product_attr_selected.addClass("page-selected")
                        $('.pagination-number').hide()
                        $('.pagination-number').eq(index).show()
                        $('.pagination-number').eq(index + 1).show()
                        $('.pagination-number').eq(index + 2).show()
                        if(page_number_style >=3){
                            $('.pagination-number').eq(index - 1).show()
                            $('.pagination-number').eq(index - 2).show()
                        }else if(page_number_style ==2){
                            $('.pagination-number').eq(index - 1).show()
                            $('.pagination-number').eq(index + 3).show()
                        }else if(page_number_style == 1){
                            $('.pagination-number').eq(index + 3).show()
                            $('.pagination-number').eq(index + 4).show()
                        }
                    }
                });
                $(".pagination-next").attr("data-element",page_number_style + 1);
                $(".pagination-pre").attr("data-element",page_number_style - 1);
                $(".pagination-last").attr("data-element",pagination_number_array.length);
                show_pagination_last()
                show_pagination_first()

            }
            teepro_load_more = false; 
            pagination_number_check = false;
            $('.teepro-load-more-scroll').hide();
            
            if (!$(".teepro-product-content-show").hasClass("loaded")){
                $(".teepro-product-content-show").addClass('loaded');
            }
            if(jQuery('.max-price-shop').css("display") == "block" || jQuery('.min-price-shop').css("display") == "block" || jQuery('.chosen-filter li').length > 0){
                $('.clear-filter').show()
            }else{
                $('.clear-filter').hide()
            }
            teepro_load_more_scroll = false          
        }

        function remeve_price_ajax(min_price,max_price,id_value,value_price,event){
            page_selected = 1;
            $.ajax({
                url : ajaxurl,
                type : 'post',
                data : {
                    action: 'teepro_ajax_filter_product',
                    ajax_min_price : min_price,
                    ajax_max_price : max_price,
                    query: teepro.posts,
                    categories_id: teepro.categories_id,
                    term_id: term_id,
                    teepro_order_by: teepro_order_by,
                    page_selected: page_selected
                },
                beforeSend : function(){
                    beforeSend_ajax_filter()
                },
                error : function(response){
                    error_ajax_filter()
                    console.log(response) 
                },
                success : function(response){
                    success_ajax_filter()
                    $('.teepro-product-content-show  .grid-type').append( response );
                    $.each(term_name_list_array , function (index, value){
                        $(".chosen-filter").append("<li>" + value + "</li>");
                    });
                    id_value.val(value_price)
                },
                complete : function(){
                    complete_ajax_filter()
                    if(event !='price' && event != "clear_filter"){
                        $("#amount_min").val($('.min_value_filter').val())
                        $("#amount_max").val($('.max_value_filter').val())
                        $(function() {
                            min_value = Number($("#amount_min").val())
                            max_value = Number($("#amount_max").val()) 
                            $("#slider-range").slider({
                                range: true,
                                min: min_value,
                                max: max_value,
                                values: [min_value,max_value],
                                slide: function(event, ui) {
                                $("#amount_min").val(ui.values[0]);
                                $("#amount_max").val(ui.values[1]);
                                }
                            });
                            $("#amount_min").val($("#slider-range").slider("values", 0));
                            $("#amount_max").val($("#slider-range").slider("values", 1));
                            $("#amount_min").change(function() {
                                $("#slider-range").slider("values", 0, $(this).val());
                                
                            });
                            $("#amount_max").change(function() {
                                $("#slider-range").slider("values", 1, $(this).val()); 
                            })
                            
                        });
                        $("#slider-range").slider("values", 0, $('.min_value_filter').val());
                        $("#slider-range").slider("values", 1, $('.max_value_filter').val()); 
                    }
                    if($(".clear-filter").css("display") == "none"){
                        $(function() {
                            $("#slider-range").slider({
                                range: true,
                                min: min,
                                max: max,
                                values: [min,max],
                                slide: function(event, ui) {
                                $("#amount_min").val(ui.values[0]);
                                $("#amount_max").val(ui.values[1]);
                                }
                            });
                            $("#amount_min").val($("#slider-range").slider("values", 0));
                            $("#amount_max").val($("#slider-range").slider("values", 1));
                            $("#amount_min").change(function() {
                                $("#slider-range").slider("values", 0, $(this).val());
                                
                            });
                            $("#amount_max").change(function() {
                                $("#slider-range").slider("values", 1, $(this).val());
                                
                            })
                            
                        });
                        $("#slider-range").slider("values", 0, min);
                        $("#slider-range").slider("values", 1, max);
                    } 
                }
            })
        }

        $(".chosen-all .chosen-price li.min-price-shop").click(function(){
            $(this).hide();
            remeve_price_ajax(min,$("#amount_max").val(),$('#amount_min'),min,"")
            newUrl = removeParams("ajax_min_price")
            window.history.pushState('', '', newUrl);
        })

        $(".chosen-all .chosen-price li.max-price-shop").click(function(){
            $(this).hide();
            remeve_price_ajax($("#amount_min").val(),max,$('#amount_max'),max,"")
            newUrl = removeParams("ajax_max_price")
            window.history.pushState('', '', newUrl);
        })


        // Ajax filter product

        // reload page
        reset_term = ""
        function show_pagination_last(){
            if($(".pagination-number:last").css("display") == "inline-block"){
                $(".pagination-last").hide()
            }else{
                $(".pagination-last").show()
            }
        }
        function show_pagination_first(){
            if($(".pagination-number:first").css("display") == "inline-block"){
                $(".pagination-first").hide()
            }else{
                $(".pagination-first").show()
            }
        }
        $( window ).on( "load", function() {
            jQuery('.term-id-selected').text(reset_term);
            $('.woocommerce-ordering').off("change");  // remove onchange() event sort by woocommerce
            add_query_to_url()

            show_pagination_last();
            show_pagination_first();
           
            queryString = window.location.search;
            queryString = queryString.substring(1)
            queryString_array = queryString.split("&");
            if(current_url.indexOf("?") > 0 && current_url.indexOf("ajax") > 0){
                if(current_url.indexOf("ajax_orderby") > 0){
                    orderby_load = url.searchParams.get("ajax_orderby");
                    $('.orderby option').removeAttr("selected");
                    $.each(order_by_element_value, function(index,value){
                        if(orderby_load == value){
                            element = $('.orderby option').eq(index)
                            element.attr("selected","selected")
                        }
                    })
                    teepro_order_by = orderby_load;
                }
                if(current_url.indexOf("ajax_min_price") > 0){
                    min_price_load = url.searchParams.get("ajax_min_price");
                    $("#amount_min").val(min_price_load)
                    $('.min-price-shop').text(min_text+min_price_load)
                    $('.min-price-shop').css('display','block')            
                }
                if(current_url.indexOf("ajax_max_price") > 0){
                    max_price_load = url.searchParams.get("ajax_max_price");
                    $("#amount_max").val(max_price_load)
                    $('.max-price-shop').text(max_text+max_price_load)
                    $('.max-price-shop').css('display','block')
                } 
                term_name_list_array = [];
                $.each(queryString_array , function (index, value){
                    if(value.indexOf("ajax_filter") != -1){
                        queryString_value = value.split('=').pop();
                        queryString_value = decodeURI(queryString_value)
                        queryString_value = queryString_value.split(",")
                        $.each(queryString_value, function(key,v){
                            if(v.indexOf("+")){
                                v = v.split("+").join(" ");
                            }
                            term_name_list_array.push(v)
                        })              
                    }
                });
                term_name_list_array = get_value1_by_value2(term_name_list_array,product_attr_element_data_name,"text")
                term_id_array = get_value1_by_value2(term_name_list_array,product_attr_element_text,"value")
                term_id = term_id_array.join(";")
                $('#filter-array').text(term_id);

                add_term_id_reload = "";
                $.each(product_attr_element_data_value, function (index,value){
                    $.each(term_id_array, function (k,v){
                        if(value === v){
                            product_attr_selected_load = $('.product-attr').eq(index)
                            product_filter_selected_load = product_attr_selected_load.closest('.product-filter')
                            term_id_reload_text = product_filter_selected_load.find(".term-id-selected").text()
                            term_element_selected_load = product_filter_selected_load.find('.product-attr-list').find('[data-value="'+v+'"]')
                            term_element_selected_load = term_element_selected_load.closest('.product-attr-list')
                            term_element_selected_load.find('.circle').addClass("opacity")
                            term_element_selected_load.find('.remove-filter').addClass("opacity")

                            if(term_id_reload_text != ""){
                                add_term_id_reload = add_term_id_reload + ";" + v + ";";
                            }else{
                                add_term_id_reload = v + ";";
                            }
                            product_filter_selected_load.find(".term-id-selected").text(add_term_id_reload)
                        }
                    })
                })

                ajaxurl = data_url;
                page_selected = 1;
                ajax_filter_product('load');
            }
            
        });
        

        function ajax_filter_product(event){
            price_min = "";
            price_max = "";
            if($(".min-price-shop").css("display") == "block" || $(".max-price-shop").css("display") == "block"){
                price_min = min
                price_max = max
                if($(".min-price-shop").css("display") == "block"){
                    price_min = Number($('.min-price-shop').text().replace(min_text,""))
                }
                if($(".max-price-shop").css("display") == "block"){
                    price_max = Number($('.max-price-shop').text().replace(max_text,""))
                } 
            }else{
                price_min = min
                price_max = max
            }
            if($(".clear-filter").css("display") == "none"){
                price_min = min
                price_max = max
            }
            if(event == "price" || event == "load"){
                price_min = Number($("#amount_min").val())
                price_max = Number($("#amount_max").val())
            }
            if (typeof(term_id) == 'undefined'){
                term_id = 0;
            }
            if (typeof(page_selected) == 'undefined'){
                page_selected = "";
                if(teepro_load_more == true){
                    page_selected = 2
                }
            }else if(teepro_load_more == true && page_selected <= 2){
                page_selected = 2
            }else if(teepro_load_more == false && pagination_number_check == false && teepro_load_more_scroll == false){
                page_selected = 1
            }
            if(teepro_load_more_scroll == true && page_selected == 1){
                page_selected = 2
            }
            if (typeof(teepro_order_by) == 'undefined'){
                teepro_order_by = "menu_order";
            }
            if (typeof(term_name_list_array) == "undefined" ){
                term_name_list_array = [];
            }
            $.ajax({
                url : ajaxurl,
                type : 'post',
                data : {
                    action: 'teepro_ajax_filter_product',
                    ajax_min_price : price_min,
                    ajax_max_price : price_max,
                    query: teepro.posts,
                    categories_id: teepro.categories_id,
                    term_id: term_id,
                    teepro_order_by: teepro_order_by,
                    page_selected: page_selected
                },
                beforeSend : function(){
                    beforeSend_ajax_filter()
                },
                error : function(response){
                    error_ajax_filter()
                    console.log(response)
                },
                success : function(response){
                    success_ajax_filter()
                    $('.teepro-product-content-show  .grid-type').append( response );
                    $.each(term_name_list_array , function (index, value){
                        $(".chosen-filter").append("<li>" + value + "</li>");
                    });
                    
                },
                complete : function(){
                    complete_ajax_filter()
                    if(event=='load'){
                        if($(".pagination-number").length > 5){
                            $('.pagination-number').hide()
                            $.each(pagination_number_array , function (index, value){
                                if(index == 0|| index == 1|| index == 2||index == 3||index == 4) 
                                $('.pagination-number').eq(index).show()
                            });    
                            $(".pagination-next").show()
                        }

                    } 
                    function ranger_slider(min_value, max_value){ 
                        $("#slider-range").slider({
                            range: true,
                            min: min_value,
                            max: max_value,
                            values: [min_value,max_value],
                            slide: function(event, ui) {
                            $("#amount_min").val(ui.values[0]);
                            $("#amount_max").val(ui.values[1]);
                            }
                        });
                        $("#amount_min").val($("#slider-range").slider("values", 0));
                        $("#amount_max").val($("#slider-range").slider("values", 1));
                        $("#amount_min").change(function() {
                            $("#slider-range").slider("values", 0, $(this).val());
                            
                        });
                        $("#amount_max").change(function() {
                            $("#slider-range").slider("values", 1, $(this).val()); 
                        })
                    } 
                    if(event !='price' && event != "clear_filter"){
                        $("#amount_min").val($('.min_value_filter').val())
                        $("#amount_max").val($('.max_value_filter').val())
                        min_value = Number($("#amount_min").val())
                        max_value = Number($("#amount_max").val()) 
                        ranger_slider(min_value, max_value)
                        $("#slider-range").slider("values", 0, $('.min_value_filter').val());
                        $("#slider-range").slider("values", 1, $('.max_value_filter').val()); 
                    }
                    if($(".clear-filter").css("display") == "none"){
                        ranger_slider(min, max)
                        $("#slider-range").slider("values", 0, min);
                        $("#slider-range").slider("values", 1, max);
                    }                    
                }
            })
        }
        // Ajax remove attr 
        $(document).on('click', '.chosen-all .chosen-filter li', function(){
            teepro_load_more_scroll == false
            term_name_remove = $(this).text();

            $.each(product_attr_element_text , function (index, value){
                if(product_attr_element_text[index] === term_name_remove){
                    product_attr_selected = $('.product-attr').eq(index)
                    product_filter_selected = product_attr_selected.closest('.product-filter')
                    term_id_remove = $('.product-attr').eq(index).data("value")
                }
            });

            term_element_selected = product_filter_selected.find('.product-attr-list').find('[data-value="'+term_id_remove+'"]')
            term_element_selected = term_element_selected.closest('.product-attr-list')
            term_element_selected.find('.circle').removeClass("opacity")
            term_element_selected.find('.remove-filter').removeClass("opacity")

            term_id_selected_current = product_filter_selected.find('.term-id-selected').text().replace(term_id_remove,"")
            product_filter_selected.find('.term-id-selected').text(term_id_selected_current)

            

            // remove key + value in URL
            filter_name = term_id_remove.split('=')[0];
            term_id_selected = product_filter_selected.find('.term-id-selected').text();
            term_id_selected_array = create_array_from_string(term_id_selected);
            term_slug_list = get_value1_by_value2(term_id_selected_array,product_attr_element_data_value,"slug")
            term_slug_list = term_slug_list.join()

            add_query_to_url();
            change_value_param_url(filter_name,term_slug_list);

            all_term_id_selected = $("#filter-array").text()
            term_id_remove_all = all_term_id_selected.replace(term_id_remove,"");
            
            jQuery('#filter-array').text(term_id_remove_all);
            term_id = jQuery('#filter-array').text();

            term_id_array = create_array_from_string(term_id);
            term_name_list_array = get_value1_by_value2(term_id_array,product_attr_element_data_value,"text")
            ajax_filter_product()
            $(this).remove()
        })

        

        // Ajax filter by price

        $('.ajax-filter').on('click', function(){
            teepro_load_more_scroll = false
            ajaxurl = $('.ajax-filter').data('url');
            ajax_filter_product("price");

            min_price_shop = $('.min-price-shop').text(min_text + $("#amount_min").val());
            max_price_shop = $('.max-price-shop').text(max_text + $("#amount_max").val());

            $('.min-price-shop').css('display','block')           
            $('.max-price-shop').css('display','block')

            // change query string url
            add_query_to_url();

            if(current_url.indexOf("ajax_min_price") == -1 && current_url.indexOf("ajax_max_price") == -1){
                new_current_url = current_url + separator + "ajax_min_price" + "=" + $("#amount_min").val() +"&"+ "ajax_max_price" + "=" + $("#amount_max").val() ;
                window.history.pushState('', '', new_current_url);
            }else{
                url.searchParams.set("ajax_min_price", $("#amount_min").val());
                url.searchParams.set("ajax_max_price", $("#amount_max").val());
                newUrl = url.href
                window.history.pushState('', '', newUrl);
            }
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        })
 
        $(document).on('click', '.clear-filter', function(){
            $('.chosen-all ul li').hide()
            $(".term-id-selected").text(reset_term);
            $(".term-name").text(reset_term);
            $("#filter-array").text(reset_term);

            $(".circle").removeClass("opacity")
            $(".remove-filter").removeClass("opacity")

            current_url = window.location.href;
            remove_query = current_url.substring(current_url.indexOf('?'));
            new_current_url = current_url.replace(remove_query,"");
            window.history.pushState('', '', new_current_url);

            $('#amount_min').val(min)
            $('#amount_max').val(max)

            $('.orderby option').removeAttr("selected");
            $('.orderby option[value = "menu_order"]').attr("selected","selected")

            teepro_order_by = "menu_order";
            term_id = 0;
            page_selected = 1;
            term_name_list_array = [];
            ajax_filter_product("clear_filter")
        })
        
        // Ajax filter by attributes + brands

        product_attr_element_text = $('.product-attr').map(function(){
            return jQuery.trim(jQuery(this).text());
        }).get();
        product_attr_element_data_name = $('.product-attr').map(function(){
            return jQuery.trim(jQuery(this).data("slug"));
        }).get();
        product_attr_element_data_value = $('.product-attr').map(function(){
            return jQuery.trim(jQuery(this).data("value"));
        }).get();
        order_by_element_value = $('.orderby option').map(function(){
            return jQuery.trim(jQuery(this).val());
        }).get();
        pagination_number_array = jQuery('.pagination-number').map(function(){
            return jQuery.trim(jQuery(this).text());
        }).get();    
        function get_value1_by_value2(e, v, type){
            slug = "";
            $.each(v , function (index1, value1){
                $.each(e , function (index2, value2){
                    if(value1 === value2){
                        element = $('.product-attr').eq(index1)
                        if(type == "slug"){
                            slug = slug + ";" + element.data("slug")
                        }else if(type == "text"){
                            slug = slug + ";" + element.text()
                        }else if(type == "value"){
                            slug = slug + ";" + element.data("value")
                        }
                    }
                });
            });
            slug_array = slug.split(";");
            slug_array = slug_array.filter(function (el) {
                return el != "";
            });
            return slug_array;
        }
        function create_array_from_string(e){
            list_array = e.split(";");
            list_array = list_array.filter(function (el) {
                return el != "";
            });
            return list_array;
        }
        $('.product-attr-list').click(function(){
            teepro_load_more_scroll = false
            ajaxurl = $(".product-attr-list").data('url');
            var product_filter = $(this).closest('.product-filter');
            term_id = "";
            var term_id_selected = product_filter.find('.term-id-selected').text();  // term id
            var attr_term_id = $(this).find('.product-attr').data('value');

            var filter_name = attr_term_id.split('=')[0];

            var query_type_selected = product_filter.find('.query-type-selected').text();

            $(this).find('.circle').toggleClass('opacity')
            $(this).find('.remove-filter').toggleClass('opacity')

            if($(this).find('.remove-filter').hasClass("opacity")){ //add attr
                if(query_type_selected == "or"){
                    product_filter.find('.term-id-selected').text(attr_term_id + ";");

                    if(product_filter.find('.remove-filter.opacity').length > 1){
                        product_filter.find('.remove-filter.opacity').removeClass("opacity");
                        $(this).find('.remove-filter').addClass("opacity")
                    }
                    if(product_filter.find('.circle.opacity').length > 1){
                        product_filter.find('.circle.opacity').removeClass("opacity");
                        $(this).find('.circle').addClass("opacity")
                    }
                }
                if(query_type_selected == "and"){
                    if(Number(term_id_selected) == 0 ){
                        product_filter.find('.term-id-selected').text(attr_term_id+ ";");
                    }else{
                        term_id = product_filter.find('.term-id-selected').text();
                        term_id = attr_term_id+ ";" +term_id + ";";
                        product_filter.find('.term-id-selected').text(term_id);
                    }
                }
                
            }else{ // remove attr
                var attr_term_id = term_id_selected.replace(attr_term_id,'');
                product_filter.find('.term-id-selected').text(attr_term_id);
            }

            term_id_selected_text = create_array_from_string(product_filter.find('.term-id-selected').text())
            term_name_list_array = get_value1_by_value2(term_id_selected_text,product_attr_element_data_value,"slug")
            term_name_list = term_name_list_array.join(); 


            add_query_to_url();
            change_value_param_url(filter_name,term_name_list);

            all_term_id_selected = jQuery('.term-id-selected').text();
            jQuery('#filter-array').text(all_term_id_selected);
            term_id = $('#filter-array').text();    // get term id -> ajax

            filter_array_text = create_array_from_string(term_id)
            term_name_list_array = get_value1_by_value2(filter_array_text,product_attr_element_data_value,"text")

            ajax_filter_product(); 
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        })

        // Ajax orderby

        $('.orderby').on('change', function () {
            ajaxurl = $(".orderby").data('url');
            teepro_order_by = $(this).val();
            page_selected = 1;
            add_query_to_url();
            change_value_param_url("orderby",teepro_order_by);
            ajax_filter_product();
        });

        // Ajax Pagination number
        function show_page(){
            $.each(pagination_number_array , function (index, value){   
                if(index == page_selected ){
                    $('.pagination-number').hide()
                    
                    $('.pagination-number').eq(index - 1).show()
                    $('.pagination-number').eq(index).show()
                    $('.pagination-number').eq(index + 1).show()
                    if(page_selected >= 3){
                        $('.pagination-number').eq(index - 3).show()
                        $('.pagination-number').eq(index - 2).show()
                    }else if(page_selected == 2){
                        $('.pagination-number').eq(index - 2).show()
                        $('.pagination-number').eq(index + 2).show()
                    }else if(page_selected == 1){
                        $('.pagination-number').eq(index + 2).show()
                        $('.pagination-number').eq(index + 3).show()
                    }
                }
            });
        }

        $(document).on('click', '.pagination-number', function(){
            ajaxurl = $('.pagination-number').data('url');
            pagination_number = $(this).text();
            page_selected = Number(pagination_number);
            pagination_number_check = true;
            if(page_selected == 1){
                $(".pagination-pre").hide()
            }else{
                $(".pagination-pre").show()
            } 
            if($('.max_num_pages')[0]){
                ajax_filter_product()
            }else{
                $('.pagination-number').removeClass("page-selected")
                $(this).addClass("page-selected") 
                show_page();
                ajax_load_more($('.pagination-number'));
            }
            if($(".pagination-number").length > 1){
                if(page_selected == $(".pagination-number:last").text()){
                    $(".pagination-next").hide()
                }else{
                    $(".pagination-next").show()
                }
            }
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        })
        
        $(document).on('click', ".pagination-next" , function(){
            
            $(".pagination-pre").show()
            pagination_number = $(".pagination-next").attr("data-element");
            page_selected = Number(pagination_number);
            pagination_number_check = true;
            if($('.max_num_pages')[0]){
                
                ajax_filter_product()
            }else{
                $('.pagination-number').removeClass("page-selected")
                if($(".pagination-number:last").text() == page_selected){
                    $(".pagination-next").hide()
                }else{
                    $(".pagination-next").show()
                }
                jQuery('.pagination-number:contains('+pagination_number+')').addClass("page-selected");

                show_page();       
                
                ajax_load_more($('.pagination-number'));
            }
               
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        })
        $(document).on('click', '.pagination-pre', function(){
                pagination_number = $(".pagination-pre").attr("data-element");
                page_selected = Number(pagination_number);
                pagination_number_check = true;
            if($('.max_num_pages')[0]){
                ajax_filter_product()
            }else{ 
                $('.pagination-number').removeClass("page-selected")
                jQuery('.pagination-number:contains('+pagination_number+')').addClass("page-selected");
                show_page();   
                if(page_selected >= 1){
                    if(page_selected == 1){
                        $(".pagination-pre").hide()
                    }
                    if($(".pagination-number:last").text() == page_selected){
                        $(".pagination-next").hide()
                    }else{
                        $(".pagination-next").show()
                    }
                    ajax_load_more($('.pagination-number'));

                }  
            }
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        })
        $(document).on("click", ".pagination-first", function(){
            page_selected = 1;
            pagination_number_check = true;
            if($('.max_num_pages')[0]){
                ajax_filter_product()
            }else{ 
                $('.pagination-number').removeClass("page-selected")
                jQuery('.pagination-number:contains('+page_selected+')').addClass("page-selected");
                show_page();   
                if(page_selected >= 1){
                    if(page_selected == 1){
                        $(".pagination-pre").hide()
                    }
                    if($(".pagination-number:last").text() == page_selected){
                        $(".pagination-next").hide()
                    }else{
                        $(".pagination-next").show()
                    }
                    ajax_load_more($('.pagination-number'));

                }  
            }
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        })
        $(document).on("click", ".pagination-last", function(){
            pagination_number = $(".pagination-last").attr("data-element");
            page_selected = Number(pagination_number);
            pagination_number_check = true;

            if($('.max_num_pages')[0]){
                ajax_filter_product()
            }else{
                $('.pagination-number').removeClass("page-selected")
                if($(".pagination-number:last").text() == page_selected){
                    $(".pagination-next").hide()
                }else{
                    $(".pagination-next").show()
                }
                jQuery('.pagination-number:contains('+pagination_number+')').addClass("page-selected");

                $.each(pagination_number_array , function (index, value){   
                    if(value == page_selected ){
                        $('.pagination-number').hide()
                        
                        $('.pagination-number').eq(index - 1).show()
                        $('.pagination-number').eq(index).show()
                        $('.pagination-number').eq(index - 2).show()

                    }
                }); 
                if($(".pagination-number").length > 1){
                    if($(".pagination-number:first").css("display") == "none"){
                        $(".pagination-pre").show()
                    }else{
                        $(".pagination-pre").hide()
                    }
                }  
                
                ajax_load_more($('.pagination-number'));

            }
            
               
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        })

        // Ajax Infiniti Scroll + Ajax Pagination
         
            var progress = null
            function ajax_load_more(e){
                var $this = e;
                var ajaxurl = $this.data('url');
                var order_by = $this.data('order-by');
                var total_page = $this.data('total-page');
                if(pagination_number_check == true){
                    teepro.current_page = page_selected - 1;
                    total_page = $('.list-pagination').data('total-page');
                }
                var text_button = $this.html();   
                if(teepro.current_page < total_page){

                    if (progress) {
                        progress.abort();
                    }
                    progress = $.ajax({
                        url : ajaxurl,
                        type : 'post',
                        data : {       
                            action: 'teepro_load_more',
                            order_by : order_by,
                            query: teepro.posts, // that's how we get params from wp_localize_script() function
                            page : teepro.current_page,
                            categories_id: teepro.categories_id
                        }, 
                        beforeSend : function(){
                            if(pagination_number_check == true){
                                $('.teepro-product-content-show .icon-spin6').css("display","inline-block")
                                $('.teepro-product-content-show  .grid-type').css("opacity","0")
                            }else{
                                $('.teepro-load-more-scroll').show();
                                $this.html('LOADING... <span class="icon-spin6"> </span>');
                                $this.css('opacity','0.5');
                                $('.icon-spin6').show();
                            }
                        },  
                        error : function( response ){
                            if(pagination_number_check == false){
                                $('.icon-spin6').hide();
                                $(".teepro-load-more").html(text_button);
                                $('.teepro-load-more-scroll').hide();
                            }
                            console.log(response);
                        },
                        success : function( response ){  
                            if(pagination_number_check == true){
                                $('.teepro-product-content-show .icon-spin6').css("display","none")
                                $('.teepro-product-content-show  .grid-type').css("opacity","1")
                                $('.teepro-product-content-show  .grid-type').empty()
                            }else{
                                $('.icon-spin6').hide();
                                $('.teepro-load-more-scroll').hide();
                                $(".teepro-load-more").css('pointer-events','auto');
                                $(".teepro-load-more").html(text_button);
                                $this.css('opacity','1');
                                if(Number(teepro.current_page) == Number(total_page) -1 ){
                                    $this.hide();
                                }
                                teepro.current_page = Number(teepro.current_page)  +1;
                            } 
                            $('.teepro-product-content-show  .grid-type').append( response );
                            progress = null;
                            pagination_number_check = false 
                        },
                        complete : function(){
                            $(".pagination-next").attr("data-element",page_selected + 1);
                            $(".pagination-pre").attr("data-element",page_selected - 1);
                            if(pagination_number_check == false){
                                page_selected = 1;
                            }
                            if (!$(".teepro-product-content-show").hasClass("loaded")){
                                $(".teepro-product-content-show").addClass('loaded');
                            }
                            show_pagination_last()
                            show_pagination_first()
                        }
                    });
                }
            }
            if($('.teepro-load-more-scroll').length == 1){
                function infinite_scroll(){
                    var scrollHeight = $('.teepro-product-content-show.loaded').height();
                    
                    if($(window).scrollTop() >= scrollHeight - 350 && $(".teepro-product-content-show").hasClass('loaded')) {
    
                        $(".teepro-product-content-show").toggleClass('loaded');
                        if($('.max_num_pages')[0]){
                            $this = $(".teepro-load-more-scroll");
                            text_button = $this.html();
                            teepro_load_more_scroll = true;
                            ajaxurl = $(".teepro-load-more-scroll").data('url');
                            if(page_selected <= Number($('.max_num_pages').val()) && Number($('.max_num_pages').val()) > 1){
                                ajax_filter_product() 
                            }else{
                                teepro_load_more_scroll = false;
                            }
                        }else{ 
                            ajax_load_more($(".teepro-load-more-scroll"));
                        }
                    }                 
                }
                var debounced = _.debounce(infinite_scroll, 300);
                $(window).scroll(debounced);
            }
            
            $(".teepro-load-more").on('click', function(){
                $(this).css('pointer-events','none');
                if($('.max_num_pages')[0]){
                    $this = $(".teepro-load-more");
                    text_button = $this.html();
                    teepro_load_more = true;
                    ajaxurl = $(this).data('url');
                    ajax_filter_product() 
                }else{
                    ajax_load_more($(this));
                }
            });        
    })( jQuery, window, document );
