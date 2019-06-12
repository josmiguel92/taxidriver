/**
 * Global variables
 */
"use strict";

var userAgent = navigator.userAgent.toLowerCase(),
    initialDate = new Date(),

    $document = $(document),
    $window = $(window),
    $html = $("html"),

    isDesktop = $html.hasClass("desktop"),
    isIE = userAgent.indexOf("msie") != -1 ? parseInt(userAgent.split("msie")[1]) : userAgent.indexOf("trident") != -1 ? 11 : userAgent.indexOf("edge") != -1 ? 12 : false,
    isIE = userAgent.indexOf("msie") != -1 ? parseInt(userAgent.split("msie")[1]) : userAgent.indexOf("trident") != -1 ? 11 : userAgent.indexOf("edge") != -1 ? 12 : false,
    isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
    isTouch = "ontouchstart" in window,

    plugins = {
        pointerEvents: isIE < 11 ? "js/pointer-events.min.js" : false,
        smoothScroll: $html.hasClass("use--smoothscroll") ? "js/smoothscroll.min.js" : false,
        bootstrapTooltip: $("[data-toggle='tooltip']"),
        bootstrapTabs: $(".tabs"),
        rdParallax: $(".rd-parallax"),
        //rdAudioPlayer: $(".rd-audio"),
        //rdVideoPlayer: $(".rd-video-player"),
        //responsiveTabs: $(".responsive-tabs"),
        //rdGoogleMaps: $(".rd-google-map"),
        rdNavbar: $(".rd-navbar"),
        //rdVideoBG: $(".rd-video"),
        //rdRange: $('.rd-range'),
        //textRotator: $(".text-rotator"),
        owl: $(".owl-carousel"),


        //counter: $(".counter"),
        //flickrfeed: $(".flickr"),
        //twitterfeed: $(".twitter"),
        //progressBar: $(".progress-linear"),
        //isotope: $(".isotope"),
        //countDown: $(".countdown"),
        //calendar: $(".rd-calendar"),
        //facebookfeed: $(".facebook"),
        bootstrapDateTimePicker: $("[data-time-picker]"),
        //instafeed: $(".instafeed"),
        //facebookWidget: $('#fb-root'),
        materialTabs: $('.rd-material-tabs'),
        //filePicker: $('.rd-file-picker'),
        //fileDrop: $('.rd-file-drop'),
        popover: $('[data-toggle="popover"]'),
        dateCountdown: $('.DateCountdown'),
        statefulButton: $('.btn-stateful'),
        slick: $('.slick-slider'),
        scroller: $(".scroll-wrap"),
        //socialite: $(".socialite"),
        viewAnimate: $('.view-animate'),
        selectFilter: $("select"),
        rdInputLabel: $(".form-label"),
        stacktable: $("[data-responsive=true]"),
        //customWaypoints: $('[data-custom-scroll-to]'),
        //photoSwipeGallery: $("[data-photo-swipe-item]"),
        //circleProgress: $(".progress-bar-circle"),
        stepper: $("input[type='number']"),
        radio: $("input[type='radio']"),
        checkbox: $("input[type='checkbox']"),
        customToggle: $("[data-custom-toggle]"),
        rdMailForm: $(".rd-mailform"),
        regula: $("[data-constraints]"),
        //search: $(".rd-search"),
        //searchResults: $('.rd-search-results'),
        imgZoom: $('[mag-thumb]'),
        navbarToggle: $(".rd-navbar-toggle")
    };

/**
 * Initialize All Scripts
 */
$document.ready(function () {

    /**
     * getSwiperHeight
     * @description  calculate the height of swiper slider basing on data attr
     */
    function getSwiperHeight(object, attr) {
        var val = object.attr("data-" + attr),
            dim;

        if (!val) {
            return undefined;
        }

        dim = val.match(/(px)|(%)|(vh)$/i);

        if (dim.length) {
            switch (dim[0]) {
                case "px":
                    return parseFloat(val);
                case "vh":
                    return $(window).height() * (parseFloat(val) / 100);
                case "%":
                    return object.width() * (parseFloat(val) / 100);
            }
        } else {
            return undefined;
        }
    }

    /**
     * toggleSwiperInnerVideos
     * @description  toggle swiper videos on active slides
     */
    function toggleSwiperInnerVideos(swiper) {
        var prevSlide = $(swiper.slides[swiper.previousIndex]),
            nextSlide = $(swiper.slides[swiper.activeIndex]),
            videos;

        prevSlide.find("video").each(function () {
            this.pause();
        });

        videos = nextSlide.find("video");
        if (videos.length) {
            videos.get(0).play();
        }
    }

    /**
     * toggleSwiperCaptionAnimation
     * @description  toggle swiper animations on active slides
     */
    function toggleSwiperCaptionAnimation(swiper) {
        var prevSlide = $(swiper.container),
            nextSlide = $(swiper.slides[swiper.activeIndex]);

        prevSlide
            .find("[data-caption-animate]")
            .each(function () {
                var $this = $(this);
                $this
                    .removeClass("animated")
                    .removeClass($this.attr("data-caption-animate"))
                    .addClass("not-animated");
            });

        nextSlide
            .find("[data-caption-animate]")
            .each(function () {
                var $this = $(this),
                    delay = $this.attr("data-caption-delay");

                setTimeout(function () {
                    $this
                        .removeClass("not-animated")
                        .addClass($this.attr("data-caption-animate"))
                        .addClass("animated");
                }, delay ? parseInt(delay) : 0);
            });
    }

    /**
     * makeParallax
     * @description  create swiper parallax scrolling effect
     */
    function makeParallax(el, speed, wrapper, prevScroll) {
        var scrollY = window.scrollY || window.pageYOffset;

        if (prevScroll != scrollY) {
            prevScroll = scrollY;
            el.addClass('no-transition');
            el[0].style['transform'] = 'translate3d(0,' + -scrollY * (1 - speed) + 'px,0)';
            el.height();
            el.removeClass('no-transition');

            if (el.attr('data-fade') === 'true') {
                var bound = el[0].getBoundingClientRect(),
                    offsetTop = bound.top * 2 + scrollY,
                    sceneHeight = wrapper.outerHeight(),
                    sceneDevider = wrapper.offset().top + sceneHeight / 2.0,
                    layerDevider = offsetTop + el.outerHeight() / 2.0,
                    pos = sceneHeight / 6.0,
                    opacity;
                if (sceneDevider + pos > layerDevider && sceneDevider - pos < layerDevider) {
                    el[0].style["opacity"] = 1;
                } else {
                    if (sceneDevider - pos < layerDevider) {
                        opacity = 1 + ((sceneDevider + pos - layerDevider) / sceneHeight / 3.0 * 5);
                    } else {
                        opacity = 1 - ((sceneDevider - pos - layerDevider) / sceneHeight / 3.0 * 5);
                    }
                    el[0].style["opacity"] = opacity < 0 ? 0 : opacity > 1 ? 1 : opacity.toFixed(2);
                }
            }
        }

        requestAnimationFrame(function () {
            makeParallax(el, speed, wrapper, prevScroll);
        });
    }

    /**
     * isScrolledIntoView
     * @description  check the element whas been scrolled into the view
     */
    function isScrolledIntoView(elem) {
        var $window = $(window);
        return elem.offset().top + elem.outerHeight() >= $window.scrollTop() && elem.offset().top <= $window.scrollTop() + $window.height();
    }

    /**
     * initOnView
     * @description  calls a function when element has been scrolled into the view
     */
    function lazyInit(element, func) {
        var $win = jQuery(window);
        $win.on('load scroll', function () {
            if ((!element.hasClass('lazy-loaded') && (isScrolledIntoView(element)))) {
                func.call();
                element.addClass('lazy-loaded');
            }
        });
    }

    /**
     * Live Search
     * @description  create live search results
     */
    function liveSearch(options) {
        $('#' + options.live).removeClass('cleared').html();
        options.current++;
        options.spin.addClass('loading');
        $.get(handler, {
            s: decodeURI(options.term),
            liveSearch: options.live,
            dataType: "html",
            liveCount: options.liveCount,
            filter: options.filter,
            template: options.template
        }, function (data) {
            options.processed++;
            var live = $('#' + options.live);
            if (options.processed == options.current && !live.hasClass('cleared')) {
                live.find('> #search-results').removeClass('active');
                live.html(data);
                setTimeout(function () {
                    live.find('> #search-results').addClass('active');
                }, 50);
            }
            options.spin.parents('.rd-search').find('.input-group-addon').removeClass('loading');
        })
    }

    /**
     * attachFormValidator
     * @description  attach form validation to elements
     */
    function attachFormValidator(elements) {
        for (var i = 0; i < elements.length; i++) {
            var o = $(elements[i]), v;
            o.addClass("form-control-has-validation").after("<span class='form-validation'></span>");
            v = o.parent().find(".form-validation");
            if (v.is(":last-child")) {
                o.addClass("form-control-last-child");
            }
        }

        elements
            .on('input change propertychange blur', function (e) {
                var $this = $(this), results;

                if (e.type != "blur") {
                    if (!$this.parent().hasClass("has-error")) {
                        return;
                    }
                }

                if ($this.parents('.rd-mailform').hasClass('success')) {
                    return;
                }

                if ((results = $this.regula('validate')).length) {
                    for (i = 0; i < results.length; i++) {
                        $this.siblings(".form-validation").text(results[i].message).parent().addClass("has-error")
                    }
                } else {
                    $this.siblings(".form-validation").text("").parent().removeClass("has-error")
                }
            })
            .regula('bind');
    }

    /**
     * isValidated
     * @description  check if all elemnts pass validation
     */
    function isValidated(elements) {
        var results, errors = 0;
        if (elements.length) {
            for (j = 0; j < elements.length; j++) {

                var $input = $(elements[j]);

                if ((results = $input.regula('validate')).length) {
                    for (k = 0; k < results.length; k++) {
                        errors++;
                        $input.siblings(".form-validation").text(results[k].message).parent().addClass("has-error");
                    }
                } else {
                    $input.siblings(".form-validation").text("").parent().removeClass("has-error")
                }
            }

            return errors == 0;
        }
        return true;
    }

    /**
     * Init Bootstrap tooltip
     * @description  calls a function when need to init bootstrap tooltips
     */
    function initBootstrapTooltip(tooltipPlacement) {
        if (window.innerWidth < 599) {
            plugins.bootstrapTooltip.tooltip('destroy');
            plugins.bootstrapTooltip.tooltip({
                placement: 'bottom'
            });
        } else {
            plugins.bootstrapTooltip.tooltip('destroy');
            plugins.bootstrapTooltip.tooltipPlacement;
            plugins.bootstrapTooltip.tooltip();
        }
    }

    /**
     * ChangeExternalButtons
     * @description Change active tab in responsive active tab by external buttons (next tab, prev tab)
     */
    function changeExternalButtons(respTabItem, direction) {
        var prev,
            next,
            activeItem;

        respTabItem.find('.resp-tabs-extertal-list li').removeClass('active');

        activeItem = respTabItem.find('.resp-tab-item.resp-tab-active');

        next = activeItem.next();
        if (!next.length) {
            next = respTabItem.find('.resp-tab-item:first-child()');
        }

        prev = activeItem.prev();
        if (!prev.length) {
            prev = respTabItem.find('.resp-tab-item:last-child()');
        }

        if (direction) {
            if (direction === 'next') {
                next.trigger('click');
            } else {
                prev.trigger('click');
            }

            setTimeout(function () {
                changeExternalButtons(respTabItem);
            }, 10);
        }

        respTabItem.find('.resp-tab-external-prev li:nth-child(' + (prev.index() + 1) + ')').addClass('active');
        respTabItem.find('.resp-tab-external-next li:nth-child(' + (next.index() + 1) + ')').addClass('active');
    }

    /**
     * Copyright Year
     * @description  Evaluates correct copyright year
     */
    var o = $("#copyright-year");
    if (o.length) {
        o.text(initialDate.getFullYear());
    }

    /**
     * IE Polyfills
     * @description  Adds some loosing functionality to IE browsers
     */
    if (isIE) {
        if (isIE < 10) {
            $html.addClass("lt-ie-10");
        }

        if (isIE < 11) {
            if (plugins.pointerEvents) {
                $.getScript(plugins.pointerEvents)
                    .done(function () {
                        $html.addClass("ie-10");
                        PointerEventsPolyfill.initialize({});
                    });
            }
        }

        if (isIE === 11) {
            $("html").addClass("ie-11");
        }

        if (isIE === 12) {
            $("html").addClass("ie-edge");
        }
    }

    /**
     * Bootstrap Tooltips
     * @description Activate Bootstrap Tooltips
     */
    if (plugins.bootstrapTooltip.length) {
        var tooltipPlacement = plugins.bootstrapTooltip.attr('data-placement');
        initBootstrapTooltip(tooltipPlacement);
        $(window).on('resize orientationchange', function () {
            initBootstrapTooltip(tooltipPlacement);
        })
    }

    /**
     * Smooth scrolling
     * @description  Enables a smooth scrolling for Google Chrome (Windows)
     */
    if (plugins.smoothScroll) {
        $.getScript(plugins.smoothScroll);
    }

    

    /**
     * Stepper
     * @description Enables Stepper Plugin
     */
    if (plugins.stepper.length) {
        plugins.stepper.stepper({
            labels: {
                up: "",
                down: ""
            }
        });
    }

    /**
     * Radio
     * @description Add custom styling options for input[type="radio"]
     */
    if (plugins.radio.length) {
        var i;
        for (i = 0; i < plugins.radio.length; i++) {
            var $this = $(plugins.radio[i]);
            $this.addClass("radio-custom").after("<span class='radio-custom-dummy'></span>")
        }
    }

    /**
     * Checkbox
     * @description Add custom styling options for input[type="checkbox"]
     */
    if (plugins.checkbox.length) {
        var i;
        for (i = 0; i < plugins.checkbox.length; i++) {
            var $this = $(plugins.checkbox[i]);
            $this.addClass("checkbox-custom").after("<span class='checkbox-custom-dummy'></span>")
        }
    }

    

    /**
     * Popovers
     * @description Enables Popovers plugin
     */
    if (plugins.popover.length) {
        if (window.innerWidth < 767) {
            plugins.popover.attr('data-placement', 'bottom');
            plugins.popover.popover();
        }
        else {
            plugins.popover.popover();
        }
    }

    
    /**
     * Bootstrap Date time picker
     */

if (plugins.bootstrapDateTimePicker.length) {
    var i;
    var startDate = new Date();
    startDate.setDate(startDate.getDate() + 2);
    
    for (i = 0; i < plugins.bootstrapDateTimePicker.length; i++) {
      var $dateTimePicker = $(plugins.bootstrapDateTimePicker[i]);
      var options = {};
        
      options['format'] = 'dddd DD MMMM YYYY - HH:mm';
      options['minDate'] = startDate;

      if ($dateTimePicker.attr("data-time-picker") == "date") {
        options['format'] = 'dddd DD MMMM YYYY';
      } else if ($dateTimePicker.attr("data-time-picker") == "time") {
        options['format'] = 'HH:mm';
      }

      options["time"] = ($dateTimePicker.attr("data-time-picker") != "date");
      options["date"] = ($dateTimePicker.attr("data-time-picker") != "time");
      options["shortTime"] = true;

      $dateTimePicker.bootstrapMaterialDatePicker(options);
    }
  }


    

    /**
     * Bootstrap Buttons
     * @description  Enable Bootstrap Buttons plugin
     */
    if (plugins.statefulButton.length) {
        $(plugins.statefulButton).on('click', function () {
            var statefulButtonLoading = $(this).button('loading');

            setTimeout(function () {
                statefulButtonLoading.button('reset')
            }, 2000);
        })
    }

    

    /**
     * UI To Top
     * @description Enables ToTop Button
     */
    if (isDesktop) {
        $().UItoTop({
            easingType: 'easeOutQuart',
            containerClass: 'ui-to-top fa fa-angle-up'
        });
    }

    /**
     * RD Navbar
     * @description Enables RD Navbar plugin
     */
    if (plugins.rdNavbar.length) {
        plugins.rdNavbar.RDNavbar({
            stickUpClone: (plugins.rdNavbar.attr("data-stick-up-clone")) ? plugins.rdNavbar.attr("data-stick-up-clone") === 'true' : false
        });
        if (plugins.rdNavbar.attr("data-body-class")) {
            document.body.className += ' ' + plugins.rdNavbar.attr("data-body-class");
        }
    }

    /**
     * ViewPort Universal
     * @description Add class in viewport
     */
    if (plugins.viewAnimate.length) {
        var i;
        for (i = 0; i < plugins.viewAnimate.length; i++) {
            var $view = $(plugins.viewAnimate[i]).not('.active');
            $document.on("scroll", $.proxy(function () {
                if (isScrolledIntoView(this)) {
                    this.addClass("active");
                }
            }, $view))
                .trigger("scroll");
        }
    }



    /**
     *  Custom scroll
     *  @description change class when is scroll to some id
     */
    if ($('#section-change-color').length) {
        if (plugins.navbarToggle.length) {
            if ($(window).width() > 1182) {
                for (i = 0; i < plugins.navbarToggle.length; i++) {
                    var $navbarToggle = $(plugins.navbarToggle[i]),
                        $changeColor = $('#section-change-color'),
                        $navbarToogleInv = $changeColor.offset().top - '60';

                    if (window.pageYOffset >= $navbarToogleInv) {
                        $navbarToggle.addClass("rd-navbar-toggle-inverse");
                    }

                    $(window).on('scroll', function () {
                        if (window.pageYOffset >= $navbarToogleInv) {
                            $navbarToggle.addClass("rd-navbar-toggle-inverse");
                        }
                        else {
                            $navbarToggle.removeClass("rd-navbar-toggle-inverse");
                        }
                    });
                }
            }
        }
    }



    
    /**
     * Slick carousel
     * @description  Enable Slick carousel plugin
     */
    if (plugins.slick.length) {
        var i;
        for (i = 0; i < plugins.slick.length; i++) {
            var $slickItem = $(plugins.slick[i]);

            $slickItem.slick({
                slidesToScroll: parseInt($slickItem.attr('data-slide-to-scroll')) || 1,
                asNavFor: $slickItem.attr('data-for') || false,
                dots: $slickItem.attr("data-dots") == "true",
                infinite: $slickItem.attr("data-loop") == "true",
                focusOnSelect: true,
                arrows: $slickItem.attr("data-arrows") == "true",
                swipe: $slickItem.attr("data-swipe") == "true",
                autoplay: $slickItem.attr("data-autoplay") == "true",
                vertical: $slickItem.attr("data-vertical") == "true",
                centerMode: $slickItem.attr("data-center-mode") == "true",
                centerPadding: $slickItem.attr("data-center-padding") ? $slickItem.attr("data-center-padding") : '0.50',
                mobileFirst: true,
                responsive: [
                    {
                        breakpoint: 0,
                        settings: {
                            slidesToShow: parseInt($slickItem.attr('data-items')) || 1,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: parseInt($slickItem.attr('data-xs-items')) || 1,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: parseInt($slickItem.attr('data-sm-items')) || 1,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: parseInt($slickItem.attr('data-md-items')) || 1,
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: parseInt($slickItem.attr('data-lg-items')) || 1,
                        }
                    }
                ]
            })
                .on('afterChange', function (event, slick, currentSlide, nextSlide) {
                    var $this = $(this),
                        childCarousel = $this.attr('data-child');

                    if (childCarousel) {
                        $(childCarousel + ' .slick-slide').removeClass('slick-current');
                        $(childCarousel + ' .slick-slide').eq(currentSlide).addClass('slick-current');
                    }
                });
        }
    }

    /**
     * Owl carousel
     * @description Enables Owl carousel plugin
     */
    if (plugins.owl.length) {
        var k;
        for (k = 0; k < plugins.owl.length; k++) {
            var c = $(plugins.owl[k]),
                responsive = {};

            var aliaces = ["-", "-xs-", "-sm-", "-md-", "-lg-"],
                values = [0, 480, 768, 992, 1200],
                i, j;

            for (i = 0; i < values.length; i++) {
                responsive[values[i]] = {};
                for (j = i; j >= -1; j--) {
                    if (!responsive[values[i]]["items"] && c.attr("data" + aliaces[j] + "items")) {
                        responsive[values[i]]["items"] = j < 0 ? 1 : parseInt(c.attr("data" + aliaces[j] + "items"));
                    }
                    if (!responsive[values[i]]["stagePadding"] && responsive[values[i]]["stagePadding"] !== 0 && c.attr("data" + aliaces[j] + "stage-padding")) {
                        responsive[values[i]]["stagePadding"] = j < 0 ? 0 : parseInt(c.attr("data" + aliaces[j] + "stage-padding"));
                    }
                    if (!responsive[values[i]]["margin"] && responsive[values[i]]["margin"] !== 0 && c.attr("data" + aliaces[j] + "margin")) {
                        responsive[values[i]]["margin"] = j < 0 ? 30 : parseInt(c.attr("data" + aliaces[j] + "margin"));
                    }
                    if (!responsive[values[i]]["dotsEach"] && responsive[values[i]]["dotsEach"] !== 0 && c.attr("data" + aliaces[j] + "dots-each")) {
                        responsive[values[i]]["dotsEach"] = j < 0 ? false : parseInt(c.attr("data" + aliaces[j] + "dots-each"));
                    }
                }
            }

            // Create custom Pagination
            if (c.attr('data-dots-custom')) {
                c.on("initialized.owl.carousel", function (event) {
                    var carousel = $(event.currentTarget),
                        customPag = $(carousel.attr("data-dots-custom")),
                        active = 0;

                    if (carousel.attr('data-active')) {
                        active = parseInt(carousel.attr('data-active'));
                    }

                    carousel.trigger('to.owl.carousel', [active, 300, true]);
                    customPag.find("[data-owl-item='" + active + "']").addClass("active");

                    customPag.find("[data-owl-item]").on('click', function (e) {
                        e.preventDefault();
                        carousel.trigger('to.owl.carousel', [parseInt(this.getAttribute("data-owl-item")), 300, true]);
                    });

                    carousel.on("translate.owl.carousel", function (event) {
                        customPag.find(".active").removeClass("active");
                        customPag.find("[data-owl-item='" + event.item.index + "']").addClass("active")
                    });
                });
            }

            // Create custom Navigation
            if (c.attr('data-nav-custom')) {
                c.on("initialized.owl.carousel", function (event) {
                    var carousel = $(event.currentTarget),
                        customNav = $(carousel.attr("data-nav-custom"));

                    customNav.find("[data-owl-prev]").on('click', function (e) {
                        e.preventDefault();
                        carousel.trigger('prev.owl.carousel', [300]);
                    });

                    customNav.find("[data-owl-next]").on('click', function (e) {
                        e.preventDefault();
                        carousel.trigger('next.owl.carousel', [300]);
                    });
                });
            }

            c.owlCarousel({
                autoplay: c.attr("data-autoplay") === "true",
                loop: c.attr("data-loop") === "true",
                items: 1,
                autoplaySpeed: 600,
                autoplayTimeout: 3000,
                dotsContainer: c.attr("data-pagination-class") || false,
                navContainer: c.attr("data-navigation-class") || false,
                mouseDrag: c.attr("data-mouse-drag") === "true",
                nav: c.attr("data-nav") === "true",
                dots: c.attr("data-dots") === "true",
                dotsEach: c.attr("data-dots-each") ? parseInt(c.attr("data-dots-each")) : false,
                responsive: responsive,
                animateIn: c.attr("data-animation-in") || false,
                animateOut: c.attr("data-animation-out") || false,
                navText: $.parseJSON(c.attr("data-nav-text")) || [],
                navClass: $.parseJSON(c.attr("data-nav-class")) || ['owl-prev', 'owl-next']
            });

        }
    }

    
    /**
     * WOW
     * @description Enables Wow animation plugin
     */
    if (isDesktop && $html.hasClass("wow-animation") && $(".wow").length) {
        new WOW().init();
    }

    /**
     * Bootstrap tabs
     * @description Activate Bootstrap Tabs
     */
    if (plugins.bootstrapTabs.length) {
        var i;
        for (i = 0; i < plugins.bootstrapTabs.length; i++) {
            var bootstrapTabsItem = $(plugins.bootstrapTabs[i]);

            bootstrapTabsItem.on("click", "a", function (event) {
                event.preventDefault();
                $(this).tab('show');
            });
        }
    }

    /**
     * JQuery mousewheel plugin
     * @description  Enables jquery mousewheel plugin
     */
    if (plugins.scroller.length) {
        var i;
        for (i = 0; i < plugins.scroller.length; i++) {
            var scrollerItem = $(plugins.scroller[i]);

            scrollerItem.mCustomScrollbar({
                scrollInertia: 200,
                scrollButtons: {enable: true}
            });
        }
    }


    /**
     * Regula
     * @description Enables Regula plugin
     */
    if (plugins.regula.length) {
        attachFormValidator(plugins.regula);
    }

    /**
     * RD Mailform
     */

    if (plugins.rdMailForm.length) {
        var i, j, k,
            msg = {
                'MF000': 'Successfully sent!',
                'MF001': 'Recipients are not set!',
                'MF002': 'Form will not work locally!',
                'MF003': 'Please, define email field in your form!',
                'MF004': 'Please, define type of your form!',
                'MF254': 'Something went wrong with PHPMailer!',
                'MF255': 'Aw, snap! Something went wrong.'
            };

        for (i = 0; i < plugins.rdMailForm.length; i++) {
            var $form = $(plugins.rdMailForm[i]);

            $form.attr('novalidate', 'novalidate').ajaxForm({
                data: {
                    "form-type": $form.attr("data-form-type") || "contact",
                    "counter": i
                },
                beforeSubmit: function () {
                    var form = $(plugins.rdMailForm[this.extraData.counter]);
                    var inputs = form.find("[data-constraints]");
                    if (isValidated(inputs)) {
                        var output = $("#" + form.attr("data-form-output"));

                        if (output.hasClass("snackbars")) {
                            output.html('<p><span class="icon text-middle fa fa-circle-o-notch fa-spin icon-xxs"></span><span>Sending</span></p>');
                            output.addClass("active");
                        }
                    } else {
                        return false;
                    }
                },
                error: function (result) {
                    var output = $("#" + $(plugins.rdMailForm[this.extraData.counter]).attr("data-form-output"));
                    output.text(msg[result]);
                },
                success: function (result) {
                    var form = $(plugins.rdMailForm[this.extraData.counter]),
                        output = $("#" + form.attr("data-form-output")),
                        $select = $form.find('select');

                    // Clear select2 after submit form
                    if ($select.length) {
                        for (j = 0; j < $select.length; j++) {
                            var $selectitem = $($select[j]);
                            $selectitem.select2('val', null);
                        }
                    }

                    form.addClass('success');
                    result = result.length == 5 ? result : 'MF255';
                    output.text(msg[result]);

                    if (result === "MF000") {
                        if (output.hasClass("snackbars")) {
                            output.html('<p><span class="icon text-middle mdi mdi-check icon-xxs"></span><span>' + msg[result] + '</span></p>');
                        }
                        output.addClass("success active");
                    } else {
                        if (output.hasClass("snackbars")) {
                            output.html(' <p class="snackbars-left"><span class="icon icon-xxs mdi mdi-alert-outline text-middle"></span><span>' + msg[result] + '</span></p>');
                        }
                        output.addClass("error active");
                    }

                    form.clearForm();
                    form.find('input, textarea').blur();

                    setTimeout(function () {
                        output.removeClass("active error success");
                        form.removeClass('success');
                    }, 5000);
                }
            });
        }
    }

    /**
     * Stacktable
     * @description Enables Stacktable plugin
     */
    if (plugins.stacktable.length) {
        var i;
        for (i = 0; i < plugins.stacktable.length; i++) {
            var stacktableItem = $(plugins.stacktable[i]);
            stacktableItem.stacktable();
        }
    }

    /**
     * Custom Toggles
     */
    if (plugins.customToggle.length) {
        var i;

        for (i = 0; i < plugins.customToggle.length; i++) {
            var $this = $(plugins.customToggle[i]);

            $this.on('click', $.proxy(function (event) {
                event.preventDefault();
                var $ctx = $(this);
                $($ctx.attr('data-custom-toggle')).add(this).toggleClass('active');
            }, $this));

            if ($this.attr("data-custom-toggle-disable-on-blur") === "true") {
                $("body").on("click", $this, function (e) {
                    if (e.target !== e.data[0] && $(e.data.attr('data-custom-toggle')).find($(e.target)).length == 0 && e.data.find($(e.target)).length == 0) {
                        $(e.data.attr('data-custom-toggle')).add(e.data[0]).removeClass('active');
                    }
                })
            }
        }
    }

    /**
     * Magnificent image zoom
     */
    if (plugins.imgZoom.length) {
        var i;
        for (i = 0; i < plugins.imgZoom.length; i++) {
            var $imgZoomItem = $(plugins.imgZoom[i]);
            $imgZoomItem.mag();
        }
    }



    /**
     * RD Parallax
     * @description Enables RD Parallax plugin
     */
    if (plugins.rdParallax.length) {
        var i;
        $.RDParallax();

        if (!isIE && !isMobile) {
            $(window).on("scroll", function () {
                for (i = 0; i < plugins.rdParallax.length; i++) {
                    var parallax = $(plugins.rdParallax[i]);
                    if (isScrolledIntoView(parallax)) {
                        parallax.find(".rd-parallax-inner").css("position", "fixed");
                    } else {
                        parallax.find(".rd-parallax-inner").css("position", "absolute");
                    }
                }
            });
        }

        $("a[href='#'], a[href^='#']").on("click", function (event) {
            setTimeout(function () {
                $(window).trigger("resize");
            }, 300);
        });
    }
});


/*! ========================================================================
 * Bootstrap Toggle: bootstrap-toggle.js v2.2.0
 * http://www.bootstraptoggle.com
 * ========================================================================
 * Copyright 2014 Min Hur, The New York Times Company
 * Licensed under MIT
 * ======================================================================== */


+function ($) {
    'use strict';

    // TOGGLE PUBLIC CLASS DEFINITION
    // ==============================

    var Toggle = function (element, options) {
        this.$element  = $(element);
        this.options   = $.extend({}, this.defaults(), options);
        this.render()
    };

    Toggle.VERSION  = '2.2.0';

    Toggle.DEFAULTS = {
        on: 'Yes',
        off: 'No',
        onstyle: 'primary',
        offstyle: 'default',
        size: 'normal',
        style: '',
        width: null,
        height: null
    };

    Toggle.prototype.defaults = function() {
        return {
            on: this.$element.attr('data-on') || Toggle.DEFAULTS.on,
            off: this.$element.attr('data-off') || Toggle.DEFAULTS.off,
            onstyle: this.$element.attr('data-onstyle') || Toggle.DEFAULTS.onstyle,
            offstyle: this.$element.attr('data-offstyle') || Toggle.DEFAULTS.offstyle,
            size: this.$element.attr('data-size') || Toggle.DEFAULTS.size,
            style: this.$element.attr('data-style') || Toggle.DEFAULTS.style,
            width: this.$element.attr('data-width') || Toggle.DEFAULTS.width,
            height: this.$element.attr('data-height') || Toggle.DEFAULTS.height
        }
    };

    Toggle.prototype.render = function () {
        this._onstyle = 'btn-' + this.options.onstyle;
        this._offstyle = 'btn-' + this.options.offstyle;
        var size = this.options.size === 'large' ? 'btn-lg'
            : this.options.size === 'small' ? 'btn-sm'
                : this.options.size === 'mini' ? 'btn-xs'
                    : '';
        var $toggleOn = $('<label class="btn">').html(this.options.on)
            .addClass(this._onstyle + ' ' + size);
        var $toggleOff = $('<label class="btn">').html(this.options.off)
            .addClass(this._offstyle + ' ' + size + ' active');
        var $toggleHandle = $('<span class="toggle-handle btn btn-default">')
            .addClass(size);
        var $toggleGroup = $('<div class="toggle-group">')
            .append($toggleOn, $toggleOff, $toggleHandle);
        var $toggle = $('<div class="toggle btn" data-toggle="toggle">')
            .addClass( this.$element.prop('checked') ? this._onstyle : this._offstyle+' off' )
            .addClass(size).addClass(this.options.style);

        this.$element.wrap($toggle);
        $.extend(this, {
            $toggle: this.$element.parent(),
            $toggleOn: $toggleOn,
            $toggleOff: $toggleOff,
            $toggleGroup: $toggleGroup
        });
        this.$toggle.append($toggleGroup);

        var width = this.options.width || Math.max($toggleOn.outerWidth(), $toggleOff.outerWidth())+($toggleHandle.outerWidth()/2)
        var height = this.options.height || Math.max($toggleOn.outerHeight(), $toggleOff.outerHeight())
        $toggleOn.addClass('toggle-on');
        $toggleOff.addClass('toggle-off');
        this.$toggle.css({ width: width, height: height });
        if (this.options.height) {
            $toggleOn.css('line-height', $toggleOn.height() + 'px');
            $toggleOff.css('line-height', $toggleOff.height() + 'px')
        }
        this.update(true);
        this.trigger(true)
    };

    Toggle.prototype.toggle = function () {
        if (this.$element.prop('checked')) this.off();
        else this.on()
    };

    Toggle.prototype.on = function (silent) {
        if (this.$element.prop('disabled')) return false;
        this.$toggle.removeClass(this._offstyle + ' off').addClass(this._onstyle)
        this.$element.prop('checked', true);
        if (!silent) this.trigger()
    };

    Toggle.prototype.off = function (silent) {
        if (this.$element.prop('disabled')) return false;
        this.$toggle.removeClass(this._onstyle).addClass(this._offstyle + ' off')
        this.$element.prop('checked', false);
        if (!silent) this.trigger()
    };

    Toggle.prototype.enable = function () {
        this.$toggle.removeAttr('disabled');
        this.$element.prop('disabled', false)
    };

    Toggle.prototype.disable = function () {
        this.$toggle.attr('disabled', 'disabled');
        this.$element.prop('disabled', true)
    };

    Toggle.prototype.update = function (silent) {
        if (this.$element.prop('disabled')) this.disable();
        else this.enable();
        if (this.$element.prop('checked')) this.on(silent);
        else this.off(silent)
    };

    Toggle.prototype.trigger = function (silent) {
        this.$element.off('change.bs.toggle')
        if (!silent) this.$element.change()
        this.$element.on('change.bs.toggle', $.proxy(function() {
            this.update()
        }, this))
    }

    Toggle.prototype.destroy = function() {
        this.$element.off('change.bs.toggle');
        this.$toggleGroup.remove();
        this.$element.removeData('bs.toggle');
        this.$element.unwrap()
    };

    // TOGGLE PLUGIN DEFINITION
    // ========================

    function Plugin(option) {
        return this.each(function () {
            var $this   = $(this);
            var data    = $this.data('bs.toggle');
            var options = typeof option == 'object' && option;

            if (!data) $this.data('bs.toggle', (data = new Toggle(this, options)))
            if (typeof option == 'string' && data[option]) data[option]()
        })
    }

    var old = $.fn.bootstrapToggle;

    $.fn.bootstrapToggle             = Plugin;
    $.fn.bootstrapToggle.Constructor = Toggle;

    // TOGGLE NO CONFLICT
    // ==================

    $.fn.toggle.noConflict = function () {
        $.fn.bootstrapToggle = old;
        return this
    };

    // TOGGLE DATA-API
    // ===============

    $(function() {
        $('input[type=checkbox][data-toggle^=toggle]').bootstrapToggle()
    });

    $(document).on('click.bs.toggle', 'div[data-toggle^=toggle]', function(e) {
        var $checkbox = $(this).find('input[type=checkbox]');
        $checkbox.bootstrapToggle('toggle');
        e.preventDefault()
    })

}(jQuery);

// Highlight the top nav as scrolling occurs
$('body').scrollspy({
    target: ['.rd-navbar', '#call-to-action']
});
