! function(e) {
    "use strict";
    var a = {
            Android: function() {
                return navigator.userAgent.match(/Android/i)
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i)
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i)
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i)
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i)
            },
            any: function() {
                return a.Android() || a.BlackBerry() || a.iOS() || a.Opera() || a.Windows()
            }
        },
        t = {
            obj: {
                subscribeEmail: e("#subscribe-email"),
                subscribeButton: e("#subscribe-button"),
                subscribeMsg: e("#subscribe-msg"),
                subscribeContent: e("#subscribe-content"),
                dataMailchimp: e("#subscribe-form").attr("data-mailchimp"),
                success_message: '<div class="notification_ok">Thank you for joining our mailing list! Please check your email for a confirmation link.</div>',
                failure_message: '<div class="notification_error">Error! <strong>There was a problem processing your submission.</strong></div>',
                noticeError: '<div class="notification_error">{msg}</div>',
                noticeInfo: '<div class="notification_error">{msg}</div>',
                basicAction: "mail/subscribe.php",
                mailChimpAction: "mail/subscribe-mailchimp.php"
            },
            eventLoad: function() {
                var a = t.obj;
                e(a.subscribeButton).on("click", function() {
                    window.ajaxCalling || ("true" === a.dataMailchimp ? t.ajaxCall(a.mailChimpAction) : t.ajaxCall(a.basicAction))
                })
            },
            ajaxCall: function(a) {
                window.ajaxCalling = !0;
                var i = t.obj,
                    s = i.subscribeMsg.html("").hide();
                e.ajax({
                    url: a,
                    type: "POST",
                    dataType: "json",
                    data: {
                        subscribeEmail: i.subscribeEmail.val()
                    },
                    success: function(e, a, t) {
                        if (e.status) i.subscribeContent.fadeOut(500, function() {
                            s.html(i.success_message).fadeIn(500)
                        });
                        else {
                            switch (e.msg) {
                                case "email-required":
                                    s.html(i.noticeError.replace("{msg}", "Error! <strong>Email is required.</strong>"));
                                    break;
                                case "email-err":
                                    s.html(i.noticeError.replace("{msg}", "Error! <strong>Email invalid.</strong>"));
                                    break;
                                case "duplicate":
                                    s.html(i.noticeError.replace("{msg}", "Error! <strong>Email is duplicate.</strong>"));
                                    break;
                                case "filewrite":
                                    s.html(i.noticeInfo.replace("{msg}", "Error! <strong>Mail list file is open.</strong>"));
                                    break;
                                case "undefined":
                                    s.html(i.noticeInfo.replace("{msg}", "Error! <strong>undefined error.</strong>"));
                                    break;
                                case "api-error":
                                    i.subscribeContent.fadeOut(500, function() {
                                        s.html(i.failure_message)
                                    })
                            }
                            s.fadeIn(500)
                        }
                    },
                    error: function(e, a, t) {
                        alert("Connection error")
                    },
                    complete: function(e) {
                        window.ajaxCalling = !1
                    }
                })
            }
        };
    e(function() {
        var i, s, n, o, l;
        matchMedia("only screen and (min-width: 991px)").matches && function() {
                if (e("body").hasClass("header_sticky")) {
                    var a = e("#header");
                    if (0 !== a.size()) {
                        var t = e("#header").offset().top,
                            i = e("#header").height(),
                            s = e("<div />", {
                                height: i
                            }).insertAfter(a);
                        s.hide(), e(window).on("load scroll", function() {
                            e(window).scrollTop() > t ? (e("#header").hasClass("header-classic") && s.show(), e("#header").addClass("downscrolled")) : (e("#header").removeClass("header-small downscrolled"), s.hide())
                        })
                    }
                }
            }(), i = "desktop", e(window).on("load resize", function() {
                var a = "desktop";
                if (matchMedia("only screen and (max-width: 991px)").matches && (a = "mobile"), a !== i)
                    if (i = a, "mobile" === a) {
                        var t = e("#mainnav").attr("id", "mainnav-mobi").hide(),
                            s = e("#mainnav-mobi").find("li:has(ul)");
                        e("#header").after(t), s.children("ul").hide(), s.children("a").after('<span class="btn-submenu"></span>'), e(".btn-menu").removeClass("active")
                    } else {
                        var n = e("#mainnav-mobi").attr("id", "mainnav").removeAttr("style");
                        n.find(".submenu").removeAttr("style"), e("#header").find(".nav-wrap").append(n), e(".btn-submenu").remove()
                    }
            }), e(".btn-menu").on("click", function() {
                e("#mainnav-mobi").slideToggle(300), e(this).toggleClass("active")
            }), e(document).on("click", "#mainnav-mobi li .btn-submenu", function(a) {
                e(this).toggleClass("active").next("ul").slideToggle(300), a.stopImmediatePropagation()
            }), e(document).on("click", function(a) {
                "input-search" !== a.target.id && e(".top-search").removeClass("show")
            }), e(".show-search").on("click", function(e) {
                e.stopPropagation()
            }), e(".search-form").on("click", function(e) {
                e.stopPropagation()
            }), e(".show-search").on("click", function(a) {
                e(".top-search").hasClass("show") ? e(".top-search").removeClass("show") : (e(".top-search").addClass("show"), a.preventDefault()), a.preventDefault(), e(".show-search").hasClass("active") ? e(".show-search").removeClass("active") : e(".show-search").addClass("active")
            }), t.eventLoad(), e("#contactform").each(function() {
                e(this).validate({
                    submitHandler: function(a) {
                        var t = e(a),
                            i = t.serialize(),
                            s = e("<div />", {
                                class: "loading"
                            });
                        e.ajax({
                            type: "POST",
                            url: t.attr("action"),
                            data: i,
                            beforeSend: function() {
                                t.find(".form-submit").append(s)
                            },
                            success: function(a) {
                                var i, s;
                                "Success" === a ? (i = "Message Sent Successfully To Email Administrator. ( You can change the email management a very easy way to get the message of customers in the user manual )", s = "msg-success") : (i = "Error sending email.", s = "msg-error"), t.prepend(e("<div />", {
                                    class: "flat-alert " + s,
                                    text: i
                                }).append(e('<a class="close" href="#"><i class="fa fa-close"></i></a>'))), t.find(":input").not(".submit").val("")
                            },
                            complete: function(e, a, i) {
                                t.find(".loading").remove()
                            }
                        })
                    }
                })
            }), e('[data-waypoint-active="yes"]').waypoint(function() {
                e(this).trigger("on-appear")
            }, {
                offset: "90%",
                triggerOnce: !0
            }), e(window).on("load", function() {
                setTimeout(function() {
                    e.waypoints("refresh")
                })
            }), e(".flat-row").each(function() {
                e().owlCarousel && e(this).find(".flat-testimonials").owlCarousel({
                    loop: !0,
                    margin: 0,
                    nav: e(".flat-testimonials").data("nav"),
                    dots: e(".flat-testimonials").data("dots"),
                    autoplay: e(".flat-testimonials").data("auto"),
                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 1
                        },
                        767: {
                            items: 1
                        },
                        991: {
                            items: 1
                        },
                        1200: {
                            items: e(".flat-testimonials").data("item")
                        }
                    }
                }), e().owlCarousel && e(this).find(".flat-testimonials2").owlCarousel({
                    loop: !0,
                    margin: 30,
                    nav: e(".flat-testimonials2").data("nav"),
                    dots: e(".flat-testimonials2").data("dots"),
                    autoplay: e(".flat-testimonials2").data("auto"),
                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 1
                        },
                        767: {
                            items: 1
                        },
                        991: {
                            items: 2
                        },
                        1200: {
                            items: e(".flat-testimonials2").data("item")
                        }
                    }
                })
            }), e(".wrap-testimonial").each(function() {
                e(this).children("#testimonial-carousel").flexslider({
                    animation: "slide",
                    controlNav: !1,
                    controldot: !1,
                    animationLoop: !0,
                    slideshow: !1,
                    itemWidth: 194,
                    drag: !0,
                    itemMargin: 0,
                    directionNav: !1,
                    asNavFor: e(this).children("#testimonial-slider")
                }), e(this).children("#testimonial-slider").flexslider({
                    animation: "slide",
                    controlNav: !1,
                    animationLoop: !1,
                    slideshow: !1,
                    directionNav: !1,
                    sync: e(this).children("#testimonial-carousel")
                })
            }), e(".fancybox").on("click", function() {
                return e.fancybox({
                    href: this.href,
                    type: e(this).data("type")
                }), !1
            }), s = {
                duration: 600
            }, e(".flat-toggle .toggle-title.active").siblings(".toggle-content").show(), e(".flat-toggle.enable .toggle-title").on("click", function() {
                e(this).closest(".flat-toggle").find(".toggle-content").slideToggle(s), e(this).toggleClass("active")
            }), e(".flat-accordion .toggle-title").on("click", function() {
                e(this).is(".active") ? (e(this).toggleClass("active"), e(this).next().slideToggle(s)) : (e(this).closest(".flat-accordion").find(".toggle-title.active").toggleClass("active").next().slideToggle(s), e(this).toggleClass("active"), e(this).next().slideToggle(s))
            }), e(".flat-tabs").each(function() {
                e(this).children(".content-tab").children().hide(), e(this).children(".content-tab").children().first().show(), e(this).find(".menu-tab").children("li").on("click", function(a) {
                    var t = e(this).index(),
                        i = e(this).siblings().removeClass("active").parents(".flat-tabs").children(".content-tab").children().eq(t);
                    i.addClass("active").fadeIn("slow"), i.siblings().removeClass("active"), e(this).addClass("active").parents(".flat-tabs").children(".content-tab").children().eq(t).siblings().hide(), a.preventDefault()
                })
            }), e(".flat-row").each(function() {
                e().owlCarousel && e(this).find(".flat-carousel").owlCarousel({
                    loop: !0,
                    margin: 0,
                    nav: e(".flat-carousel").data("nav"),
                    dots: e(".flat-carousel").data("dots"),
                    autoplay: e(".flat-carousel").data("auto"),
                    responsive: {
                        0: {
                            items: 1
                        },
                        320: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        767: {
                            items: 2
                        },
                        991: {
                            items: 3
                        },
                        1200: {
                            items: e(".flat-carousel").data("item")
                        }
                    }
                })
            }), e(".flat-row").each(function() {
                e().owlCarousel && e(this).find(".flat-client").owlCarousel({
                    loop: !0,
                    margin: 0,
                    nav: e(".flat-client").data("nav"),
                    dots: e(".flat-client").data("dots"),
                    autoplay: e(".flat-client").data("auto"),
                    responsive: {
                        0: {
                            items: 1
                        },
                        320: {
                            items: 2
                        },
                        480: {
                            items: 3
                        },
                        767: {
                            items: 3
                        },
                        991: {
                            items: 4
                        },
                        1200: {
                            items: e(".flat-client").data("item")
                        }
                    }
                })
            }), e(function() {
                e(" #data-effect > li ").each(function() {
                    e(this).hoverdir()
                })
            }), e(".flat-counter").on("on-appear", function() {
                e(this).find(".numb-count").each(function() {
                    var a = parseInt(e(this).attr("data-to"), 10),
                        t = parseInt(e(this).attr("data-speed"), 10);
                    e().countTo && e(this).countTo({
                        to: a,
                        speed: t
                    })
                })
            }), e(window).load(function() {
                matchMedia("only screen and (min-width: 1199px)").matches && (e("section").hasClass("blancejqurey") && e(".wrap-blance").each(function() {
                    var e = document.getElementById("blance1").offsetHeight;
                    document.getElementById("blance2").style.height = e + "px"
                }), e("section").hasClass("blancejqurey2") && e(".wrap-blance").each(function() {
                    var e = document.getElementById("blance-s1").offsetHeight;
                    document.getElementById("blance-s2").style.height = e + "px"
                }))
            }), e(".effect-animation").each(function() {
                var a = e(this),
                    t = a.data("animation"),
                    i = a.data("animation-delay"),
                    s = a.data("animation-offset");
                a.css({
                    "-webkit-animation-delay": i,
                    "-moz-animation-delay": i,
                    "animation-delay": i
                }), a.waypoint(function() {
                    a.addClass("animated " + t)
                }, {
                    triggerOnce: !0,
                    offset: s
                })
            }), n = '<div class="square"><div class="numb">', o = '</div><div class="text">', e().countdown && e(".countdown").countdown("2018/12/25", function(a) {
                e(this).html(a.strftime(n + "%D" + o + "DAY</div></div>" + n + "%H" + o + "HOURS</div></div>" + n + "%M" + o + "MINS</div></div>" + n + "%S" + o + "SECS</div>"))
            }),
            function() {
                if (e("section").hasClass("full-page")) {
                    function a() {
                        var a = e(window).height();
                        e(".full-page").css("height", a + "px")
                    }
                    a(), e(window).resize(function() {
                        a()
                    })
                }
            }(),
            function() {
                if (e().gmap3) {
                    var a = JSON.parse('[{"address":"Baria Sreet,  NewYork City","content":""}]'),
                        t = JSON.parse('[{"address":"Harvard Yard, Cambridge, Massachusetts, Hoa Ká»³","content":""}]');
                    e(".maps").gmap3({
                        map: {
                            options: {
                                center: [40.6777899, -73.9981382],
                                mapTypeId: "Consuloan",
                                mapTypeControlOptions: {
                                    mapTypeIds: ["Consuloan", google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID]
                                },
                                zoom: 16
                            },
                            navigationControl: !0,
                            scrollwheel: !1,
                            streetViewControl: !0
                        }
                    }), e(".maps2").gmap3({
                        map: {
                            options: {
                                center: [42.3738858, -71.1164816],
                                mapTypeId: "Consuloan",
                                mapTypeControlOptions: {
                                    mapTypeIds: ["Consuloan", google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID]
                                },
                                zoom: 16
                            },
                            navigationControl: !1,
                            scrollwheel: !1,
                            streetViewControl: !1
                        }
                    })
                }
                e.each(a, function(a, t) {
                    e(".maps").gmap3({
                        marker: {
                            values: [{
                                address: t.address,
                                options: {
                                    icon: "images/maps/1.png"
                                },
                                events: {
                                    mouseover: function() {
                                        e(this).gmap3({
                                            overlay: {
                                                address: t.address,
                                                options: {
                                                    content: "<div class='infobox clearfix'><div class='img-map float-left'><img src='images/maps/f1.jpg' alt='image'></div><div class='info-map'><h5>40 Baria Sreet,<br> NewYork City, US</h5></div><div class='clearfix'></div></div>",
                                                    offset: {
                                                        y: 34,
                                                        x: -186
                                                    }
                                                }
                                            }
                                        })
                                    },
                                    mouseout: function() {
                                        e(".infobox").each(function() {
                                            e(this).remove()
                                        })
                                    }
                                }
                            }]
                        },
                        styledmaptype: {
                            id: "Consuloan",
                            options: {
                                name: "Consuloan Maps"
                            },
                            styles: [{
                                featureType: "landscape",
                                elementType: "labels",
                                stylers: [{
                                    visibility: "off"
                                }]
                            }, {
                                featureType: "transit",
                                elementType: "labels",
                                stylers: [{
                                    visibility: "off"
                                }]
                            }, {
                                featureType: "poi",
                                elementType: "labels",
                                stylers: [{
                                    visibility: "off"
                                }]
                            }, {
                                featureType: "water",
                                elementType: "labels",
                                stylers: [{
                                    visibility: "off"
                                }]
                            }, {
                                featureType: "road",
                                elementType: "labels.icon",
                                stylers: [{
                                    visibility: "off"
                                }]
                            }, {
                                stylers: [{
                                    hue: "#00aaff"
                                }, {
                                    saturation: -100
                                }, {
                                    gamma: 2.15
                                }, {
                                    lightness: 12
                                }]
                            }, {
                                featureType: "road",
                                elementType: "labels.text.fill",
                                stylers: [{
                                    visibility: "on"
                                }, {
                                    lightness: 24
                                }]
                            }, {
                                featureType: "road",
                                elementType: "geometry",
                                stylers: [{
                                    lightness: 57
                                }]
                            }]
                        }
                    })
                }), e.each(t, function(a, t) {
                    e(".maps2").gmap3({
                        marker: {
                            values: [{
                                address: t.address,
                                options: {
                                    icon: "images/maps/2.png"
                                },
                                events: {
                                    mouseover: function() {
                                        e(this).gmap3({
                                            overlay: {
                                                address: t.address,
                                                options: {
                                                    content: "<div class='infobox style2 text-center'><div class='info-map'><h5>40 Baria Sreet, NewYork<br>City, US</h5></div><div class='clearfix'></div></div>",
                                                    offset: {
                                                        y: 26,
                                                        x: -137
                                                    }
                                                }
                                            }
                                        })
                                    },
                                    mouseout: function() {
                                        e(".infobox").each(function() {
                                            e(this).remove()
                                        })
                                    }
                                }
                            }]
                        },
                        styledmaptype: {
                            id: "Consuloan",
                            options: {
                                name: "Consuloan Maps"
                            },
                            styles: [{
                                featureType: "administrative",
                                elementType: "all",
                                stylers: [{
                                    visibility: "on"
                                }, {
                                    saturation: -100
                                }, {
                                    lightness: 20
                                }]
                            }, {
                                featureType: "road",
                                elementType: "all",
                                stylers: [{
                                    visibility: "on"
                                }, {
                                    saturation: -100
                                }, {
                                    lightness: 40
                                }]
                            }, {
                                featureType: "water",
                                elementType: "all",
                                stylers: [{
                                    visibility: "on"
                                }, {
                                    saturation: -10
                                }, {
                                    lightness: 30
                                }]
                            }, {
                                featureType: "landscape.man_made",
                                elementType: "all",
                                stylers: [{
                                    visibility: "simplified"
                                }, {
                                    saturation: -60
                                }, {
                                    lightness: 10
                                }]
                            }, {
                                featureType: "landscape.natural",
                                elementType: "all",
                                stylers: [{
                                    visibility: "simplified"
                                }, {
                                    saturation: -60
                                }, {
                                    lightness: 60
                                }]
                            }, {
                                featureType: "poi",
                                elementType: "all",
                                stylers: [{
                                    visibility: "off"
                                }, {
                                    saturation: -100
                                }, {
                                    lightness: 60
                                }]
                            }, {
                                featureType: "transit",
                                elementType: "all",
                                stylers: [{
                                    visibility: "off"
                                }, {
                                    saturation: -100
                                }, {
                                    lightness: 60
                                }]
                            }]
                        }
                    })
                })
            }(), e(".blog-carosuel-wrap").each(function() {
                e().owlCarousel && e(this).find(".blog-shortcode").owlCarousel({
                    loop: !0,
                    margin: 30,
                    nav: !1,
                    dots: !1,
                    auto: !0,
                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        767: {
                            items: 2
                        },
                        991: {
                            items: 3
                        },
                        1200: {
                            items: 3
                        }
                    }
                })
            }), e(".blog-carosuel-wrap2").each(function() {
                e().owlCarousel && e(this).find(".blog-shortcode").owlCarousel({
                    loop: !0,
                    margin: 30,
                    nav: !1,
                    dots: !1,
                    auto: !0,
                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        767: {
                            items: 2
                        },
                        991: {
                            items: 2
                        },
                        1200: {
                            items: 2
                        }
                    }
                })
            }), e().slider && (e(".price_slider").slider({
                range: !0,
                min: 607,
                max: 1140,
                values: [610, 980],
                slide: function(a, t) {
                    e(".price_label > input ").val("$" + t.values[0] + "  - $" + t.values[1])
                }
            }), e(".price_label > input ").val("$" + e(".price_slider").slider("values", 0) + "  -  $" + e(".price_slider").slider("values", 1)), e(".ui-slider-handle").append("<span class='shadow'></span>")),
            function() {
                e(".switcher-container").on("click", "a.sw-light", function() {
                    e(this).toggleClass("active"), e("body").addClass("home-boxed"), e("body").css({
                        background: "#f6f6f6"
                    }), e(".sw-pattern.pattern").css({
                        top: "100%",
                        opacity: 1,
                        "z-index": "10"
                    })
                }).on("click", "a.sw-dark", function() {
                    return e(".sw-pattern.pattern").css({
                        top: "98%",
                        opacity: 0,
                        "z-index": "-1"
                    }), e(this).removeClass("active").addClass("active"), e("body").removeClass("home-boxed"), e("body").css({
                        background: "#fff"
                    }), !1
                }), e(".sw-pattern").on("click", function() {
                    return e(".sw-pattern.pattern a").removeClass("current"), e(this).addClass("current"), e("body").css({
                        background: 'url("' + e(this).data("image") + '")',
                        "background-size": "30px 30px",
                        "background-repeat": "repeat"
                    }), !1
                })
            }(), e(window).scroll(function() {
                e(this).scrollTop() > 800 ? e(".go-top").addClass("show") : e(".go-top").removeClass("show")
            }), e(".go-top").on("click", function() {
                return e("html, body").animate({
                    scrollTop: 0
                }, 1e3, "easeInOutExpo"), !1
            }), e(document).on("click", ".close", function(a) {
                e(this).closest(".flat-alert").remove(), a.preventDefault()
            }), e().parallax && null === a.any() && (e(".parallax1").parallax("50%", -.6), e(".parallax2").parallax("50%", .5), e(".parallax3").parallax("50%", .5), e(".parallax4").parallax("50%", -.6), e(".parallax5").parallax("50%", -.6), e(".parallax6").parallax("50%", .5), e(".parallax7").parallax("50%", -.5)), (l = window.devicePixelRatio > 1) && e(".header .logo").find("img").attr({
                src: "./images/logo@2x.png",
                width: "217",
                height: "35"
            }), l && e(".footer .logo").find("img").attr({
                src: "./images/logofooter@2x.png",
                width: "217",
                height: "35"
            }), e(window).on("load", function() {
                e(".loader").fadeOut(), e("#loading-overlay").delay(300).fadeOut("slow", function() {
                    e(this).remove()
                })
            })
    })
}(jQuery);