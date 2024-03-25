var clvbase;
! function($) {
  "use strict";
  clvbase = function() {
    var basetheme = {
      popupEffect: "",
      supports_html5_storage: !1,
      ajaxLinks: ""
    };
    try {
      basetheme.supports_html5_storage = "sessionStorage" in window && null !== window.sessionStorage, window.sessionStorage.setItem("theme", "test"), window.sessionStorage.removeItem("theme")
    } catch (e) {
      basetheme.supports_html5_storage = !1
    }
    return {
      init: function() {
        this.shopcarousel();
        this.oneSlide();
        this.brandImage();
        this.quote();
        this.instagramd();
        this.image360();
        this.blog();
        this.threeslide();
        this.slidebuild();
        this.center_slide();
        this.timeline();
        this.slideshow();
        this.twoSlide();
      },

      center_slide: function() {
        void 0 !==  $(".slider_center").each(
          function(e) {
            var l = {

              dots: true,
              centerMode: true,
              slidesToShow: 1,
              centerPadding: "25%",
              arrows: true,
              autoplay: true,
              autoplaySpeed: 6000,
              nextArrow: '<button type="button" data-role="none" class="slick-next slick-arrow slick-initialized slick-slider" aria-label="Next" role="button" ><i class="cs-font clever-icon-next"></i></button>',
              prevArrow: '<button type="button" data-role="none" class="slick-prev slick-arrow" aria-label="Previous" role="button" ><i class="cs-font clever-icon-prev"></i></button>',
              responsive: [{
                breakpoint: 768,
                settings: {
                  centerMode: true,
                  centerPadding: "20px",
                  slidesToShow: 1
                }
              }]
            }
            $(this).slick(l);
          })
      },
      slideshow: function() {
        void 0 !==  $(".flexslider").each(
          function(e) {
            var d = $(this).data("dots"),
                b = $(this).data("nav"),
                p = $(this).data("speed"),
                h = $(this).data("hover"),
                l = {

                  slideshow: true,
                  animationDuration: 700,
                  slideshowSpeed: p,
                  controlsContainer: ".flex-controls",
                  controlNav: d,   
                  pauseOnHover: h,
                  directionNav: b, 
                  prevText: '<span class="cs-font clever-icon-arrow-left-3"></span>',
                  nextText: '<span class="cs-font clever-icon-arrow-right-3"></span>',
                  keyboardNav: true
                };
            $(this).flexslider(l).hover(function(){ $('.flex-direction-nav').fadeIn();}, function(){$('.flex-direction-nav').fadeOut();});
          })
      },
      slidebuild: function() {
        void 0 !==  $(".carousel-slide.owl-carousel ").each(
          function(e) {
            var p = $(this).data("desktop"),
                t = $(this).data("tablet"),
                m = $(this).data("mobile"),
                d = $(this).data("dot"),
                b = $(this).data("button"),
                l = {
                  rtl: $("body").hasClass("rtl"),
                  items: t,
                  responsive: {
                    1200: {
                      items: p
                    },
                    993: {
                      items: p
                    },
                    768: {
                      items: t
                    },
                    479: {
                      items: m
                    },
                    0: {
                      items: m
                    }
                  },
                  autoplay: true,
                  autoplayTimeout: 5000,
                  dots: d,
                  autoplayHoverPause:true,
                  nav: b,
                  navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                  autoheight: !0,
                  slideBy: "page",
                  loop: true,
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };

            $(this).owlCarousel(l)
          })
      },
      shopcarousel: function() {
        void 0 !==  $(".slider.owl-carousel ").each(
          function(e) {
            var t = $(this).data("limit"),
                b = $(this).data("button"),
                s = $(this).data("dots"),
                a = ($(this).data("medium"), $(this).data("time")),
                i = $(this).data("loop"),
                n = $(this).data("autoplay"),
                sp = $(this).data("speed"),

                l = {
                  rtl: $("body").hasClass("rtl"),
                  items: t,
                  responsive: {
                    979: {
                      items: t
                    },
                    768: {
                      items: 3
                    },
                    479: {
                      items: 3
                    },
                    0: {
                      items: 1
                    }
                  },
                  autoplay: n,
                  autoplayTimeout: 5000,
                  dots: s,
                  autoplayHoverPause:true,
                  nav: b,
                  navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                  autoheight: !0,
                  slideBy: "page",
                  loop: true,
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };
            console.log(b);
            $(this).owlCarousel(l)
          })
      },
      blog: function() {
        void 0 !==  $(".slide-blog.owl-carousel ").each(
          function(e) {
            var t = $(this).data("limit"),
                o = $(this).data("nav"),
                s = $(this).data("dots"),
                a = ($(this).data("medium"), $(this).data("time")),
                i = $(this).data("loop"),
                n = $(this).data("autoplay"),
                l = {
                  rtl: $("body").hasClass("rtl"),
                  items: t,
                  responsive: {
                    979: {
                      items: t
                    },
                    768: {
                      items: 2
                    },
                    479: {
                      items: 2
                    },
                    0: {
                      items: 1
                    }
                  },
                  autoplay: true,
                  autoplayTimeout: 5000,
                  dots: true,
                  autoplayHoverPause:true,
                  nav: true,
                  navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                  autoheight: !0,
                  slideBy: "page",
                  loop: true,
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };
            $(this).owlCarousel(l)
          })
      },
      oneSlide: function() {
        void 0 !==  $(".one.owl-carousel ").each(
          function(e) {
            var t = $(this).data("limit"),
                o = $(this).data("button"),
                s = $(this).data("dots"),
                a = ($(this).data("medium"), $(this).data("time")),
                i = $(this).data("loop"),
                n = $(this).data("autoplay"),
                l = {
                  rtl: $("body").hasClass("rtl"),
                  items: 1,
                  autoplay: n,
                  autoplayTimeout: 5000,
                  dots: s,
                  autoplayHoverPause:true,
                  nav: o,
                  autoheight: !0,
                  slideBy: "page",
                  navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                  loop: false,
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };
            $(this).owlCarousel(l)
          })
      },

      twoSlide: function() {
        void 0 !==  $(".two.owl-carousel ").each(
          function(e) {
            var t = $(this).data("limit"),
                o = $(this).data("button"),
                s = $(this).data("dots"),
                a = ($(this).data("medium"), $(this).data("time")),
                i = $(this).data("loop"),
                n = $(this).data("autoplay"),
                l = {
                  rtl: $("body").hasClass("rtl"),
                  items: 2,
                  responsive: {
                    979: {
                      items: 2
                    },
                    768: {
                      items: 2
                    },
                    479: {
                      items: 2
                    },
                    0: {
                      items: 1
                    }
                  },
                  autoplay: false,
                  autoplayTimeout: 5000,
                  dots: false,
                  autoplayHoverPause:true,
                  nav: true,
                  autoheight: !0,
                  slideBy: "page",
                  navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                  loop: false,
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };
            $(this).owlCarousel(l)
          })
      },
      threeslide: function() {
        void 0 !==  $(".threeslide.owl-carousel ").each(
          function(e) {
            var t = $(this).data("limit"),
                o = $(this).data("nav"),
                s = $(this).data("dots"),
                a = ($(this).data("medium"), $(this).data("time")),
                i = $(this).data("loop"),
                n = $(this).data("autoplay"),
                l = {
                  rtl: $("body").hasClass("rtl"),
                  items: t,
                  responsive: {
                    979: {
                      items: 3
                    },
                    768: {
                      items: 3
                    },
                    479: {
                      items: 2
                    },
                    0: {
                      items: 1
                    }
                  },
                  autoplay: true,
                  autoplayTimeout: 5000,
                  dots: true,
                  autoplayHoverPause:true,
                  nav: true,
                  autoheight: !0,
                  slideBy: "page",
                  navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                  loop: true,
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };
            $(this).owlCarousel(l)
          })
      },
      brandImage: function() {
        void 0 !==  $(".slide.owl-carousel ").each(
          function(e) { 
            var t = $(this).data("limit"),
                b = $(this).data("button"),
                s = $(this).data("dots"),
                a = ($(this).data("medium"), $(this).data("time")),
                i = $(this).data("loop"),
                n = $(this).data("autoplay"),
                l = {
                  rtl: $("body").hasClass("rtl"),
                  items: t,
                  responsive: {

                    1200: {
                      items:  t
                    },
                    1024: {
                      items: 5
                    },
                    991: {
                      items: 4
                    },
                    768: {
                      items: 4
                    },
                    479: {
                      items: 3
                    },
                    0: {
                      items: 2
                    }
                  },
                  autoplay: n,
                  autoplayTimeout: 5000,
                  dots: s,
                  autoplayHoverPause:true,
                  nav: b,
                  autoheight: !0,
                  slideBy: "page",
                  navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                  loop: true,
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };
            $(this).owlCarousel(l)
          })
      },
      quote: function() {
        void 0 !==  $(".quotes-slider.owl-carousel ").each(
          function(e) {
            var d = $(this).data("desktop"),
                t = $(this).data("tablet"),
                m = $(this).data("mobile"),
                a = ($(this).data("medium"), $(this).data("time")),
                i = $(this).data("loop"),
                n = $(this).data("autoplay"),
                l = {
                  rtl: $("body").hasClass("rtl"),
                  items: d,
                  responsive: {
                    979: {
                      items: d
                    },
                    768: {
                      items: t
                    },
                    479: {
                      items: m
                    },
                    0: {
                      items: m
                    }
                  },
                  autoplay: true,
                  autoplayTimeout: 5000,
                  dots: true,
                  nav: true,
                  autoheight: !0,
                  autoplayHoverPause:true,
                  slideBy: "page",
                  navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                  loop: true,
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };
            $(this).owlCarousel(l)
          })
      },
      instagramd: function() {
        void 0 !==  $(".instafeed").each(
          function(e) {
            var d = $(this).data("user"),
                t = $(this).data("token"),
                m = $(this).data("clienid"),
                a = ($(this).data("medium"), $(this).data("time")),
                i = $(this).data("limit"),
                n = $(this).data("image"),
                o = $(this).data("arrows"),
                c = $(this).data("carousel"),
                s = $(this).data("dots"),
                feed = new Instafeed({
                  get: "user",    

                  userId: d,
                  accessToken: t,

                  clientId: m,
                  limit: i,
                  resolution: n,
                  after: function() {
                    setTimeout(function(){
                      $('.instafeed > a').attr( "target", "_blank" );
                      $(".instafeed.slides-owl").owlCarousel({
                        loop:false,
                        margin:1,
                        responsiveClass:true,
                        dots: s,
                        nav: o,
                        navText: ['<i class="cs-font clever-icon-prev"></i>','<i class="cs-font clever-icon-next"></i>'],
                        responsive:{
                          0:{
                            items:1
                          },
                          600:{
                            items:2
                          },
                          800:{
                            items:3
                          },
                          1000:{
                            items:c,
                            loop:false
                          }
                        }
                      });
                      //                       jQuery('.instafeed.grid > a').attr( "target", "_blank" );
                      //                       var count_a = jQuery(".instafeed.grid" ).width();
                      //                       var width_item = count_a / i - 0.3 ;
                      //                       jQuery(".instafeed.grid a").css("width", width_item);
                      //                       jQuery('.instafeed.grid > a').addClass('col-md-2');
                      //                       jQuery('.instafeed.grid ').addClass('row');
                    }, 2000);

                  }
                });
            feed.run();
          }
        )
      },
      timeline: function() {
        void 0 !==  $(".timeline-block").each(
          function(e) {
            var t = $(this).data("time"),
                l = {
                  TargetDate:t,

                  DisplayFormat:"<div class='day'><span class='no'>%%D%%</span><span class='text'>days</span></div><div class='hours'><span class='no'>%%H%%</span><span class='text'>hours</span></div><div class='min'><span class='no'>%%M%%</span><span class='text'>min</span></div><div class='second'><span class='no'>%%S%%</span><span class='text'>sec</span></div>",
                  FinishMessage: "Expired",
                  onRefreshed: function() {
                    $(window).resize()
                  }
                };
            $(this).lofCountDown(l)
          })
      },
      image360: function() {
        void 0 !==  $(".product-image-360").each(
          function(e) {
            var string = $(this).data("allimage");
            var array = string.split(',');
            var count_ht = array.length;
            var  l = {
              totalFrames: count_ht,
              endFrame: count_ht, 
              currentFrame: 1, 
              imgList: '.product-images-item', 
              progress: '.spinner',
              imgArray: array,
              height: null,
              width: null,
              responsive: true,
              navigation: false
            };

            $('.custom_previous').bind('click', function(e) {
              car.previous();
            });

            $('.custom_next').bind('click', function(e) {
              car.next();
            });

            $('.custom_play').bind('click', function(e) {
              car.play();
              $('.nav_bar').addClass('play-video');
            });

            $('.custom_stop').bind('click', function(e) {
              car.stop();
              $('.nav_bar').removeClass('play-video');
            });

            $(this).ThreeSixty(l)
          })
      }
    }
  }()
}(jQuery), 
  jQuery(document).ready(function() {
  clvbase.init()
}), jQuery(document).on("shopify:section:load", clvbase.shopcarousel).on("shopify:section:unload", clvbase.shopcarousel).on("shopify:section:select", clvbase.shopcarousel).on("shopify:section:deselect", clvbase.shopcarousel).on("shopify:block:select", clvbase.shopcarousel).on("shopify:block:deselect", clvbase.shopcarousel)
jQuery(document).on("shopify:section:load", clvbase.quote).on("shopify:section:unload", clvbase.quote).on("shopify:section:select", clvbase.quote).on("shopify:section:deselect", clvbase.quote).on("shopify:block:select", clvbase.quote).on("shopify:block:deselect", clvbase.quote),
  jQuery(document).on("shopify:section:load", clvbase.instagramd).on("shopify:section:unload", clvbase.instagramd).on("shopify:section:select", clvbase.instagramd).on("shopify:section:deselect", clvbase.instagramd).on("shopify:block:select", clvbase.instagramd).on("shopify:block:deselect", clvbase.instagramd),
  jQuery(document).on("shopify:section:load", clvbase.brandImage).on("shopify:section:unload", clvbase.brandImage).on("shopify:section:select", clvbase.brandImage).on("shopify:section:deselect", clvbase.brandImage).on("shopify:block:select", clvbase.brandImage).on("shopify:block:deselect", clvbase.brandImage),
  jQuery(document).on("shopify:section:load", clvbase.oneSlide).on("shopify:section:unload", clvbase.oneSlide).on("shopify:section:select", clvbase.oneSlide).on("shopify:section:deselect", clvbase.oneSlide).on("shopify:block:select", clvbase.oneSlide).on("shopify:block:deselect", clvbase.oneSlide),
  jQuery(document).on("shopify:section:load", clvbase.timeline).on("shopify:section:unload", clvbase.timeline).on("shopify:section:select", clvbase.timeline).on("shopify:section:deselect", clvbase.timeline).on("shopify:block:select", clvbase.timeline).on("shopify:block:deselect", clvbase.timeline),
  jQuery(document).on("shopify:section:load", clvbase.image360).on("shopify:section:unload", clvbase.image360).on("shopify:section:select", clvbase.image360).on("shopify:section:deselect", clvbase.image360).on("shopify:block:select", clvbase.image360).on("shopify:block:deselect", clvbase.image360),
  jQuery(document).on("shopify:section:load", clvbase.blog).on("shopify:section:unload", clvbase.blog).on("shopify:section:select", clvbase.blog).on("shopify:section:deselect", clvbase.blog).on("shopify:block:select", clvbase.blog).on("shopify:block:deselect", clvbase.blog),
  jQuery(document).on("shopify:section:load", clvbase.slidebuild).on("shopify:section:unload", clvbase.slidebuild).on("shopify:section:select", clvbase.slidebuild).on("shopify:section:deselect", clvbase.slidebuild).on("shopify:block:select", clvbase.slidebuild).on("shopify:block:deselect", clvbase.slidebuild),
  jQuery(document).on("shopify:section:load", clvbase.slideshow).on("shopify:section:unload", clvbase.slideshow).on("shopify:section:select", clvbase.slideshow).on("shopify:section:deselect", clvbase.slideshow).on("shopify:block:select", clvbase.slideshow).on("shopify:block:deselect", clvbase.slideshow),
  jQuery(document).on("shopify:section:load", clvbase.twoSlide).on("shopify:section:unload", clvbase.twoSlide).on("shopify:section:select", clvbase.twoSlide).on("shopify:section:deselect", clvbase.twoSlide).on("shopify:block:select", clvbase.twoSlide).on("shopify:block:deselect", clvbase.twoSlide),
  jQuery(document).on("shopify:section:load", clvbase.center_slide).on("shopify:section:unload", clvbase.center_slide).on("shopify:section:select", clvbase.center_slide).on("shopify:section:deselect", clvbase.center_slide).on("shopify:block:select", clvbase.center_slide).on("shopify:block:deselect", clvbase.center_slide),
  jQuery(document).on("shopify:section:load", clvbase.threeslide).on("shopify:section:unload", clvbase.threeslide).on("shopify:section:select", clvbase.threeslide).on("shopify:section:deselect", clvbase.threeslide).on("shopify:block:select", clvbase.threeslide).on("shopify:block:deselect", clvbase.threeslide);

$(document).on("click", ".cart-list .remove_item_cart", function(e) {
  var varaint_id = $(this).attr('data-id');

  jQuery.ajax({
    type: "POST",
    url: "/cart/change.js",
    dataType: "json",
    data: {
      quantity: 0,
      id: varaint_id
    },
    success: function(data) {
      jQuery(".complte_product_options li").each(function() {
        var curr_this = jQuery(this);
        var chk_id = jQuery(this).attr("data-id");
        if (varaint_id == chk_id) {
          jQuery(curr_this).parents(".product_bl_out").removeClass("added_pro khulja");
          jQuery(curr_this).parents(".product_bl_out").find("ul.size_options_utl li").removeClass("fill_color")
        }
      });
      loadcart();
    }
  });
});


function loadcart() {
jQuery.ajax({
  type: "GET",
  url: "/cart.js",
  dataType: "json",
  success: function(cart_data) {
    console.log(cart_data.item_count);
    if(cart_data.item_count){
    jQuery(".cart-list").html("");

    jQuery.each(cart_data.items, function(index, item) {

      var pp = item.price / 100;
      cart_items_html ='<li class="item" id="cart-item"><a class="popim" href="' + item.url + '"><img src="' + item.image + '"/></a><a href="' + item.url + '">"' + item.product_title + '"</a> <div class="option"><small>"' + item.variant_title + '"</small></div><div class="cart-collateral"><span class="qty-cart">Qty: "' + item.quantity + '" </span><span class="price" data-price="' + pp + '">"$' + pp + '"</span></div><a data-id="' + item.variant_id + '" title="Remove Item" class="btn-remove remove_item_cart" id="cart_remove"><i class="cs-font clever-icon-close"></i></a></div></li>'
      jQuery(".cart-list").append(cart_items_html);

    });
    jQuery("#dropdown-cart > div.mini_cart_header > div > div.summary > p > span.price").text('$ '+cart_data.items_subtotal_price/100);
    jQuery(".mini_cart_header").addClass("active");
    jQuery(".wrapper-container").addClass("show-cart");
    jQuery(".js-popup-cart-ajax").addClass("active actove_my");
    jQuery(".cart-count").text('1');
      jQuery('.cart-empty').removeClass('empty_cart_show');
      jQuery('.mini_cart_header').removeClass('empty_cart');
    } else {
     
      jQuery('.cart-empty').addClass('empty_cart_show');
      jQuery('.mini_cart_header').addClass('empty_cart');
      jQuery('.header-cart-count .cart-count').text('0');      
     location.reload();
    }
  }
});
}

function hideHeader() {
let headerElement = document.querySelector('#shopify-section-header');

if (location.hash === "#_" || location.hash.length === 0) {      
    headerElement.style.display = 'block';
}
else if (location.hash.includes("-feed")) {   
    headerElement.style.display = 'none';
    }
}
window.addEventListener('hashchange', hideHeader, false);