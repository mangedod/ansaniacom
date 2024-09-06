(function ($, window, document, undefined) {
    'use strict';
    var pluginName = "Camaro",
        defaults = {
            sliderFx: 'crossfade',		// Slider effect. Can be 'slide', 'fade', 'crossfade'
            sliderInterval: 6000,		// Interval
            speedAnimation: 1,        // Default speed of the animation
            countdownTo: '2015/03/30',          // Change this in the format: 'YYYY/MM/DD'
            successText: 'You have successfully subscribed', // text after successful subscribing
            errorText: 'Please, enter a valid email', // text, if email is invalid
            teamHeight : 450, // Team expand height
            tooltipPosition: 'bottom',            // Tooltip position
            scrollTopButtonOffset: 100 // when scrollTop Button will show
        },
        $win = $(window),
        $doc = $(document),
        $html = $('html'),
        onMobile = false,
        scrT;

    // The plugin constructor
    function Plugin(element, options) {
        var that = this;
        that.element = $(element);
        that.options = $.extend({}, defaults, options);

        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            onMobile = true;
        }

        $win.scrollTop(0);

        that.init();

        // onLoad function
        $win.load(function(){
            //$('#status').fadeOut(defaults.speedAnimation);
            //$('#preloader').delay(defaults.speedAnimation)
           //     .fadeOut(defaults.speedAnimation/2, function() {
                that.fSize();
                that.activate();
                that.sliders();

                setTimeout(function(){
                    that.fMiddle();
                }, 10);
                setTimeout( function(){
                    that.fNum();
                    $('.layer').height(
                        $doc.height()
                    );
                }, defaults.speedAnimation/2);

                that.chars();
                that.bars();
                that.histLine();
                that.headerScroll();
                that.ytVideo();

                if (!onMobile){
                    $win.stellar({
                        horizontalScrolling: false
                    });
                }

          //  });
        }).scroll(function(){  // onScroll function
            that.fNum();
            that.chars();
            that.bars();
            that.histLine();
            that.headerScroll();
        }).resize(function(){  // onResize function
            $('.layer').height(
                $doc.height()
            );

            that.fSize();

            that.mask.each(function(){
                var $this = $(this),
                    realHeight;
                $this.parent().attr('maskheight', $(this).parent().height());
                realHeight = +$this.parent().attr('maskheight') + 1;
                $this.height(realHeight);

            });
            that.fMiddle();

            if( $win.width() > 768) {
                $('.header .collapse.in').removeClass('in').removeAttr('style');
            }

        });

    }

    Plugin.prototype = {
        init: function () {
            this.body = $(document.body);
            this.wrapper = $('.wrapper');
            this.home = $('.home');
            this.slider = $('.slider');
            this.owlslider = $('.owlslider');
            this.oneslider = $('.oneslider');
            this.gallery = $('.gallery');
            this.ribbon = $('.ribbon');
            this.popup = $('.popup');
            this.pclose = $('.pclose');
            this.vmiddle = $('.vmiddle');
            this.fullsize = $('.full-size');
            this.internalLinks = $('.internal');
            this.tooltipstered = $('.tooltipstered');
            this.header = $('.header');
            this.search = this.header.find('.search');
            this.aMenu = $('.a-menu');
            this.sidemenu = $('.sidemenu');
            this.menutable = $('.menutable');
            this.shoptable = $('.menushop');
            this.audio = $('audio');
            this.num = $('[data-num]');
            this.dataPopup = $('[data-popup]');
            this.chart = $('.chart');
            this.estimateshipping = $('.estimate-shipping');
            this.timer = $('#countdown');
            this.barDiagramm = $('.bar');
            this.skillLine = $('.progresses');
            this.team = $('.team');
            this.expandTeam = $('.expandteam');
            this.history = $('.history');
            this.histEvent = this.history.find('.row');
            this.newsletter = $('#feedback-form').find('form');
            this.passw = $('.login-password');
            this.cntMap = $('#contact-map');
            this.cntMapFix = $('#contact-map-fix');
            this.select = $('.select');
            this.scrTop = $('.scrolltop');
            this.mask = $('.mask');
            this.bs3date = $('#inputDate .input-group.date');
            this.magnific = $('.magnific');
            this.magnificWrap = $('.magnific-wrap');
            this.magnificGallery = $('.magnific-gallery');
            this.magnificVideo = $('.magnific-video');
            this.citem = $('.catalog-square .citem');
            this.addCart = $('.add-cart');
            this.jslider = $('.jslider');
            this.rating = $('.raty');
            this.thumbsSlider = $('.thumbs-slider');
            this.mediumSlider = $('.medium-slider');
            this.counting = $('.counting');
            this.aLess = $('.a-less');
            this.aMore = $('.a-more');
            this.trRemove = $('.tr-remove');
            this.tabLink = $('.tab-link');
            this.dataToggleTab = $('[data-toggle="tab"]');
            this.btnValid = $('.btn-validation');
            this.selectColor = $('.select-color');
            this.inputMask = $('[data-inputmask]');
            this.faq = $('.faq');
            this.navFaq = this.faq.find('.nav-category');
            this.faqGroup = this.faq.find('.panel-group');
            this.faqBody = this.faqGroup.find('.panel-body');
            this.dataToggle = $('[data-toggle]');
            this.popoverElement = $('[data-rel="popover"]');
            this.expandLink = $('.expand-link');
            this.collapseLink = $('.collapse-link');
            this.accToggle = $('.accordeon-toggle');
            this.navCategory = $('.nav-category');
            this.filterLink = $('a.filter');
            this.mixList = $('.mix-list');
            this.ytvid = $('.ytvideo');
            this.vacRow = $('.vacancy-row');
            this.closeBox = $('.close-box');
            this.loadmore = $('a.loadmore');
            this.availcolor = $('.available-colors');
            this.accordionPanel = $('.panel-accordion');
            this.contactForm = $('#send-form');
            this.contactFormName = $('#send-form-name');
            this.contactFormEmail = $('#send-form-email');
            this.contactFormMessage = $('#send-form-message');
           // this.emailValidationRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        },
        activate: function () {
            var instance = this;

            instance.mask.each(function(){
                var $this = $(this),
                    realHeight;
                $this.parent().attr('maskheight', $(this).parent().height());
                realHeight = +$this.parent().attr('maskheight');
                $this.height(realHeight);

            });

            // Starting animation
            if (instance.home.length > 0){
                instance.home.children().animate({'opacity': 1}, instance.options.speedAnimation, 'easeOutSine');
            }

          //  $('.content, .footer').delay(instance.options.speedAnimation/2).animate({'opacity': 1}, instance.options.speedAnimation, 'easeInOutQuad');

            if (instance.audio.length > 0){
                instance.audio.mediaelementplayer();
            }

            if (instance.internalLinks.length > 0){
                instance.internalLinks.on('click', function(e){
                    e.preventDefault();
                    var $this = $(this),
                        url = $this.attr('href'),
                        urlTop = $(url).offset().top;

                    $('body, html').stop(true, true)
                        .animate({ scrollTop: urlTop },
                        instance.options.speedAnimation);
                });
            }

            // Custom Select
            if (instance.select.length > 0){
                instance.select.each(function(){
                    var self = $(this),
                        wid = self.data('width');

                    self.width(wid).chosen({width: wid});
                });
            }

            // Custom Select
            if (instance.bs3date.length > 0){
                instance.bs3date.each(function(){
                    var self = $(this);
                    self.datepicker({
                         format: "yyyy-mm-dd",
                         todayHighlight: true
                    });
                });
            }

            // Custom input[type=range]
            if (instance.jslider.length > 0) {
                instance.jslider.slider({
                    from: 0,
                    to: 1000,
                    step: 1,
                    limits: false,
                    scale: [0, 1000],
                    dimension: "$&nbsp;"
                });
            }

            instance.inputMask.inputmask();

            // RATING
            if (instance.rating.length > 0){
                instance.rating.raty({
                    half: true,
                    starType: 'i',
                    readOnly   : function() {
                        return $(this).data('readonly');
                    },
                    score: function() {
                        return $(this).data('score');
                    },
                    starOff: 'fa fa-star-o',
                    starOn: 'fa fa-star',
                    starHalf: 'fa fa-star-half-o'
                });
            }

            if (instance.timer.length === 1) {
                instance.timer.countdown(instance.options.countdownTo, function (event) {
                    var $this = $(this);
                    $this.html(event.strftime(
                            '<div><span class="day color">%D</span> <ins>day%!D</ins></div>' + '<div><span>%H<i></i></span><ins class="cd1">hour%!D</ins></div>' + '<div><span>%M<i></i></span><ins class="cd2">minute%!D</ins></div>' + '<div><span class="csec">%S</span><ins class="cd3">second%!D</ins></div>'));
                });
            }


            instance.citem.find('a').hover(function(){
               // $(this).parents('.citem').toggleClass('color');
            });
          /*  instance.addCart.on('click', function(e){
                e.preventDefault();
                var self = $(this);

                if (self.hasClass('btn-primary')){
                    self.removeClass('btn-primary').addClass('btn-default').text('Remove from Cart');
                } else {
                    self.removeClass('btn-default').addClass('btn-primary').text('Add to Cart');
                }
            });*/

            // Tooltips
            if (instance.tooltipstered.length > 0) {
                instance.tooltipstered.tooltipster({
                    position: instance.options.tooltipPosition,
                    contentAsHTML: true,
                    interactive: false
                });
            }

            // TEAM
            if (instance.team.length > 0){
                var speed = instance.options.speedAnimation/2,
                    itemH = instance.team.find('.profile').height();

                instance.team.find('.img').on('click', function(e){
                    e.preventDefault();

                    var $this = $(this),
                        $expand = $this.parent().find(instance.expandTeam),
                        leftPos = $this.offset().left,
                        topPos = +$this.parent().offset().top,
                        wid = $this.outerWidth(),
                        corner = $expand.find('.corner'),
                        h = instance.options.teamHeight,
                        totalH = ($expand.find('.row').length > 1) ? h+300 : h,
                        actPos,
                        cornerAA = $('.corner');

                    cornerAA.css({'display': 'none'});
                    corner.css({'left': leftPos + wid/2, 'display': 'block'});

                    instance.team.find('.active').addClass('before');
                    instance.team.find(instance.expandTeam).removeClass('active');
                    $expand.addClass('active');

                    if (instance.team.find('.before').length > 0){
                        actPos = +instance.team.find('.before').parent().offset().top;
                    }

                    instance.team.find(instance.expandTeam).removeClass('before');
                    if ( topPos != actPos){
                        closeExpand();

                        $this.parent().stop(true,true).animate({'height': (totalH+350)}, speed, 'easeInQuad');
                        $expand.css('overflow', 'visible').stop(true,true).animate({'height': totalH}, speed, 'easeInQuad');
                        $expand.find('.inner').stop(true,true).animate({'height': totalH}, speed, 'easeInQuad');
                    } else {
                        $this.parent().css({'height': (totalH+350)});
                        $expand.css('overflow', 'visible').css({'height': totalH});
                        $expand.find('.inner').css({'height': totalH});
                        setTimeout(closeExpand, 1);
                    }

                    setTimeout(function() {
                        $expand.parents('.team').parents('.container').css({'paddingBottom': 0, 'marginBottom': -30});
                    }, 20);

                });

                var closeExpand = function(){
                    instance.expandTeam.not(".active").css('overflow', 'hidden').stop(true,true).animate({'height': 0, 'overflow': 'hidden'}, speed, 'easeInQuad');
                    instance.expandTeam.not(".active").find('.inner').stop(true,true).animate({'height': 0}, speed, 'easeInQuad');
                    instance.expandTeam.not(".active").parents('[class*="col-"]').stop(true,true).animate({'height': itemH}, speed, 'easeInQuad');
                    instance.expandTeam.parents('.container').removeAttr('style');
                };

                $win.resize( function(){
                    $('.expandteam').removeClass('active');
                    closeExpand();
                });

                $('.expandteam .close').on('click', function(e){
                    e.preventDefault();
                    $(this).parents('.expandteam').removeClass('active');
                    closeExpand();
                });

            }

            // scrollTop function
            if (instance.scrTop.length === 1) {
                instance.scrTop.click(function(e){
                    $('html, body').stop(true,true).animate({ scrollTop: 0 }, instance.options.speedAnimation);
                    e.preventDefault();
                });
            }

            instance.closeBox.on('click', function(e){
                e.preventDefault();
                var $this = $(this);

                $this.parents('.box-inline').fadeOut(instance.options.speedAnimation);
            });

            instance.estimateshipping.find('[data-toggle]').on('click', function(e){
                e.preventDefault();
            });

            instance.btnValid.on('click', function(e){

                var $this = $(this),
                    form = $this.parents('form');

                form.find('input').each(function(){
                        console.log($(this).val());
                    if ($(this).val().length === 0){
                        e.preventDefault();
                        $(this).addClass('invalid');
                        
                    }
                });

                if ($this.parents(instance.form).find('.formwrap').length > 0) {
                    $this.parents(instance.form).find('.formwrap').addClass('has-error');
                }
            });

            $('input, textarea').on('keyup', function(){
                $(this).removeClass('invalid');
            });

            instance.vacRow.find('[data-toggle]').on('click', function(){
                var self = $(this),
                    txt  = self.text();
                txt = (txt == 'Details') ? 'Hide' : 'Details';
                self.text(txt);
            });

            // navbar dropdown
            $('.navbar-nav .dropdown').hover(function() {
                if (!$(this).parents('.navbar-collapse').hasClass('in')) {
                    var offs = $(this).offset().left,
                        dropW = $(this).find('.dropdown-menu').first().outerWidth(),
                        ww = $win.width();

                    $(this).find('.dropdown-menu').first().delay(10).fadeIn(instance.options.speedAnimation / 2);

                    if (ww <= (offs + dropW)) {
                        $(this).find('.dropdown-menu').first().addClass('otherwise');
                    }
                    $(this).find('.dropdown-menu').first().stop(true, true).delay(10).slideDown(instance.options.speedAnimation / 4);
                }
            }, function() {
                    if (!$(this).parents('.navbar-collapse').hasClass('in')) {
                        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(instance.options.speedAnimation / 4);
                        $('.otherwise').removeClass('otherwise').removeAttr('style');
                    }
            });

            $('.dropdown-submenu').hover(function() {
                if (!$(this).parents('.navbar-collapse').hasClass('in')) {
                    var offs = $(this).offset().left,
                        dropW = $(this).find('.dropdown-menu').first().outerWidth(),
                        ww = $win.width();

                    if (ww <= (offs + dropW + $(this).parent().width())) {
                        $(this).find('.dropdown-menu').first().addClass('subotherwise');
                    }
                }
            }, function() {
                if (!$(this).parents('.navbar-collapse').hasClass('in')) {
                    $('.subotherwise').removeClass('subotherwise').removeAttr('style');
                }
            });

            // hcart dropdown
            $('.hcart').hover(function() {
                $(this).find('.dropdown').first().stop(true, true).delay(300).slideDown(instance.options.speedAnimation/4);
            }, function() {
                $(this).find('.dropdown').first().stop(true, true).slideUp(instance.options.speedAnimation/4);
            });

            $('.a-search').on('click', function(e){
                e.preventDefault();
                instance.search.fadeIn(instance.options.speedAnimation/4);
                instance.search.find('input').focus();
            });

            instance.search.find('.sclose').on('click', function(e){
                e.preventDefault();
                instance.search.fadeOut(instance.options.speedAnimation/4);
            });

            instance.aMenu.on('click', function(e){
                e.preventDefault();
                instance.sidemenu.fadeIn(instance.options.speedAnimation/4);
            });

            instance.sidemenu.find('.sclose').on('click', function(e){
                e.preventDefault();
                instance.sidemenu.fadeOut(instance.options.speedAnimation/4);
            });

            instance.dataToggleTab.on('shown.bs.tab', function () {
                var $this = $(this);
                $this.parent().addClass('active').siblings().removeClass('active');
            });

            instance.tabLink.on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    hrf = $this.attr("href"),
                    top = $(hrf).parent().offset().top;
                $this.tab('show');
                $('.nav li').removeClass('active');
                setTimeout(function() {
                    $('.nav li a[href="' + $this.attr("href") + '"]').parent().addClass('active');
                }, 300);
                $('html, body').animate({scrollTop: top}, instance.options.speedAnimation/2);
            });


            $('.shop-category li a').on('mouseover', function(){
                if(!onMobile) {
                    var self = $(this),
                        img = self.data('img');
                    $('.category-imgs li').hide();
                    $('#'+img).show();
                } else {
                    // OR $(this).trigger('click');
                    return false;
                }
            });

            if (instance.navCategory.length > 0){

                var hsh = window.location.hash.replace('#','.'),
                    worksNavArr = [];

                if (hsh == '.all' ) {
                    hsh = 'all';
                }

                instance.navCategory.find('li').each(function(){
                    var $this = $(this);
                    worksNavArr.push($this.children().data('filter'));
                });

                if (instance.mixList.length > 0){
                    instance.mixList.stop(true,true)
                        .animate({'opacity': 1},
                        instance.options.speedAnimation/2, function() {
                            instance.mixList.mixItUp({
                                load: {
                                    filter: hsh !== '' ? hsh : 'all'
                                }
                            });

                            instance.navCategory.find('ins').removeAttr('style');
                            instance.navCategory.find('a.active ins').animate({
                                'width': '100%',
                                'left': 0
                            }, instance.options.speedAnimation, 'easeOutQuart');
                    });
                }

                instance.filterLink.on('click', function(){
                    var self = $(this),
                        npLine = self.find('ins'),
                        $expandTeam = $('.expandteam');

                    instance.navCategory.find('ins').removeAttr('style');
                    npLine.animate({
                        'width': '100%',
                        'left': 0
                    }, instance.options.speedAnimation, 'easeOutQuart');

                    if (self.parents('ul').hasClass('team-category')){
                        if ($expandTeam.length > 0) {
                            $expandTeam.removeClass('active');
                            closeExpand();
                        }
                    }
                });
            }

            if (instance.gallery.length > 0) {
                instance.mixList.children().toggle();
                instance.mask.each(function(){
                    var $this = $(this),
                        realHeight;
                    $this.parent().attr('maskheight', $(this).parent().height());
                    realHeight = +$this.parent().attr('maskheight') + 1;
                    $this.height(realHeight);

                });
            }

            if (instance.availcolor.length > 0) {
                $("li label span", instance.availcolor).on('click', function(){
                    $("li label span", instance.availcolor).removeClass('selected');
                    $(this).addClass('selected');
                    var warnaid = $(this).parent().find('#warnaid').val(),
                        kodeproduk = $(this).data('kodeproduk');

                    $.ajax({
                        url : "/librari/ajax/ajax_size.php",
                        method : "GET",
                        dataType :"JSON",
                        data : {warnaid:warnaid,kodeproduk:kodeproduk},
                        success : function(d) {
                            
                           var select = document.getElementById("sizeid");
                               select.options.length = 0;
                           for(var i in d.oSize){
                                var opt = document.createElement('option');
                                opt.value = d.oSize[i].sizeid;
                                opt.innerHTML = d.oSize[i].size;
                                select.appendChild(opt);
                           }
                           $(".select").trigger("chosen:updated");
                           if (d.totalstok === 0) {
                             $("#product-navigation").addClass('hidden');
                                 if($('.btn.btn-danger.add-cart').length > 0){
                                    $('.btn.btn-danger.add-cart').removeClass('hidden');
                                 }
                                 else
                                 {
                                    var html = '<a class="btn btn-danger add-cart" href="#">. <i class="fa fa-info-circle"></i> Stock not available</a>';
                                    $(".product-count").append(html);
                                 }
                           }
                           else{
                            if ($("#product-navigation").length > 0)
                            {
                                $('.btn.btn-danger.add-cart').addClass('hidden');
                                $("#product-navigation").removeClass('hidden');
                            }
                           }
                           $(".select").trigger('change');
                        },
                        error (err) {
                            console.log(err);
                        }
                    });
                });
                $(".select").on('change mouseup',function() {
                    var self = $(this),
                        sizeid = $("option:selected", self).val(),
                        isSelected = $('span.selected'),
                        kodeproduk = $(isSelected).data('kodeproduk'),
                        warnaid = $(isSelected).parent().find('#warnaid').val();


                    $.ajax({
                        url : "/librari/ajax/ajax_stoksize.php",
                        method : "GET",
                        dataType :"JSON",
                        data : {sizeid:sizeid,warnaid:warnaid,kodeproduk:kodeproduk},
                        beforeSend : function() {
                            $(".stock-preloader").removeClass('hidden');
                        },
                        complete: function() {
                            $(".stock-preloader").addClass('hidden');
                        },
                        success : function(d) {
                            if (d < 1){
                                $("#product-navigation").addClass('hidden');
                                 if($('.btn.btn-danger.add-cart').length > 0){
                                    $('.btn.btn-danger.add-cart').removeClass('hidden');
                                 }
                                 else
                                 {
                                    var html = '<a class="btn btn-danger add-cart" href="#"><i class="fa fa-info-circle"></i> Stock not available</a>';
                                    $(".product-count").append(html);
                                 }
                             }else{
                                if ($("#product-navigation").length > 0){
                                    $('.btn.btn-danger.add-cart').addClass('hidden');
                                    $("#product-navigation").removeClass('hidden');
                                }
                             }
                        },
                        error : function(err) {
                            console.log(err);
                        }
                    });
                });

                $("li label span.selected", instance.availcolor)[0].click();
                
            }

            instance.mixList.find(instance.filterLink).on('click', function(e){
                e.preventDefault();
                var self = $(this),
                    hrf = self.attr('href');

                if (!instance.navFaq.find('a[href=' + hrf + ']').hasClass('active')) {
                    instance.navFaq.find('ins').removeAttr('style');
                    instance.navFaq.find('a[href=' + hrf + ']').addClass('active');
                    instance.navFaq.find('a[href=' + hrf + '] ins').animate({
                        'width': '100%',
                        'left': 0
                    }, instance.options.speedAnimation, 'easeOutQuart');
                }

            });

            if (instance.faqBody.length > 0) {
                instance.faqBody.collapse({ toggle: false });
            }

            instance.expandLink.on('click', function(e){
                e.preventDefault();

                instance.faqBody.collapse('show');

                if (instance.accToggle.length > 0){
                    instance.accToggle.text('-');
                    instance.dataToggle.addClass('open');
                }
            });

            instance.collapseLink.on('click', function(e){
                e.preventDefault();

                instance.faqBody.collapse('hide');

                if (instance.accToggle.length > 0){
                    instance.accToggle.text('+');
                    instance.accToggle.removeClass('open');
                }
            });

            instance.dataToggle.on('click', function(){
                var $this = $(this),
                    par = $this.parents('.row:first');

                par.find(instance.dataToggle).toggleClass('open');
                if (par.find(instance.accToggle).hasClass('open')){
                    par.find(instance.accToggle).text('-');
                } else {
                    par.find(instance.accToggle).text('+');
                }

            });

            instance.magnificWrap.each(function() {
                $(this).find(instance.magnific).magnificPopup({
                    type: 'image',
                    tLoading: '',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true
                    },
                    image: {
                        titleSrc: function (item) {
                            return item.el.attr('title');
                        }
                    }
                });
            });

            instance.magnificVideo.magnificPopup({
                type: 'iframe',
                fixedContentPos: false
            });

            instance.magnificGallery.on('click', function(e) {
                e.preventDefault();

                var $this = $(this),
                    items = [],
                    im = $this.data('gallery'),
                    imA = im.split(','),
                    imL = imA.length,
                    titl = $this.attr('title');

                    for (var i = 0; i < imL; i++){
                        items.push({
                            src: imA[i]
                        });
                    }

                $.magnificPopup.open({
                    items: items,
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    image: {
                        titleSrc: function () {
                            return titl;
                        }
                    }
                });
            });

            // Contact Map();
            if (instance.cntMap.length === 1){
                instance.contactMap();
            }

            if (instance.cntMapFix.length === 1){
                instance.contactMapFix();
            }

            if (instance.passw.length > 0){
                instance.passw.each(function(){
                    $(this).hideShowPassword(false, true, {
                        toggle: {
                            element: '<a href="">',
                            className: 'fa form-control-feedback toggle-password'
                        },
                        states: {
                            shown: {
                                toggle: {
                                    className: 'fa-eye-slash',
                                    content: ''
                                }
                            },
                            hidden: {
                                toggle: {
                                    className: 'fa-eye',
                                    content: ''
                                }
                            }
                        }
                    });
                });
            }

            instance.contactFormName.focusout(function(){
                if ($(this).val() === '')
                    $(this).addClass('invalid');
            }).focusin(function(){
                $(this).removeClass('invalid');
            });

            instance.contactFormMessage.focusout(function(){
                if ($(this).val() === '')
                    $(this).addClass('invalid');
            }).focusin(function(){
                $(this).removeClass('invalid');
            });

            instance.contactFormEmail.focusout(function(){
                if (($(this).val() === '') || (!instance.emailValidationRegex.test($(this).val()))) {
                    $(this).addClass('invalid');
                }
            }).focusin(function(){
                $(this).removeClass('invalid');
            });

            instance.contactForm.on('submit', function(){
                var isHaveErrors = false;

                if (instance.contactFormName.val() === '') {
                    isHaveErrors = true;
                    instance.contactFormName.addClass('invalid');
                }

                if (instance.contactFormMessage.val() === '') {
                    isHaveErrors = true;
                    instance.contactFormMessage.addClass('invalid');
                }

                if ((instance.contactFormEmail.val() === '') || (!instance.emailValidationRegex.test(instance.contactFormEmail.val()))) {
                    isHaveErrors = true;
                    instance.contactFormEmail.addClass('invalid');
                }

                if (!isHaveErrors) {
                    $.ajax({
                        type: 'POST',
                        url: 'php/email.php',
                        data: {
                            name: instance.contactFormName.val(),
                            email: instance.contactFormEmail.val(),
                            message: instance.contactFormMessage.val()
                        },
                        dataType: 'json'
                    })
                        .done(function(answer){
                            if ((typeof answer.status != 'undefined') && (answer.status == 'ok')) {
                                $('.succs-msg').fadeIn().css("display","inline-block");
                                instance.contactFormName.val('');
                                instance.contactFormEmail.val('');
                                instance.contactFormMessage.val('');
                            } else {
                                alert('Message was not sent. Server-side error!');
                            }
                        })
                        .fail(function(){
                            alert('Message was not sent. Client error or Internet connection problems.');
                        });
                }

                return false;
            });

            // popover
            if(instance.popoverElement.length > 0) {
                instance.popoverElement.popover();
                instance.popoverElement.on('show.bs.popover', function (e) {
                    console.log(e.type);
                });

                $(document).on('change',instance.selectColor, function(){
                    var $this = $(this),
                        warnaid = $('option:selected', $this).val(),
                        kodeproduk = $('option:selected', $this).data('productid'),
                        select = $('#select-size-'+ kodeproduk);

                     $.ajax({
                        url : "/librari/ajax/ajax_size.php",
                        method : "GET",
                        dataType :"JSON",
                        data : {warnaid:warnaid,kodeproduk:kodeproduk},
                        success : function(d) {
                            var option = "<option>Select Size</option>";
                            for(var i in d.oSize){
                                option += "<option value='"+d.oSize[i].sizeid+"'>"+d.oSize[i].size+"</option>";
                            }
                            if (!kodeproduk) {
                                 option = "<option>Product is Not Available</option>";
                            }
                            select.html(option);
                        },
                        error : function(err){
                            console.log(err);
                        }
                    });

            });
            }


            // accordion

            if (instance.accordionPanel.length > 0) {
                instance.accordionPanel.on('show.bs.collapse', function (e) {
                    var clicked = $(document).find("[href='#" + $(e.target).attr('id') + "']");
                   $("span .fa.fa-angle-down", clicked).removeClass("fa-angle-down").addClass("fa-angle-up");
                   console.log($("span i.fa.fa-angle-down", clicked).length);
                });

                instance.accordionPanel.on('hidden.bs.collapse', function (e) {
                    var clicked = $(document).find("[href='#" + $(e.target).attr('id') + "']");
                   $("span .fa.fa-angle-up", clicked).removeClass("fa-angle-up").addClass("fa-angle-down");
                });
            }

            // all about popups
            instance.body.append('<div class="layer"></div>');
            instance.dataPopup.on('click', function(e){
                e.preventDefault();
                var that = $(this),
                    popup = that.data('popup'),
                    $popup = $('#'+popup),
                    winTop = $win.scrollTop();

                instance.popup.hide();

                scrT = winTop;

                if ($popup.hasClass('block-popup')){
                    $('.layer').fadeIn(instance.options.speedAnimation/2);
                    $popup.css('top', winTop + 50).fadeIn(instance.options.speedAnimation/2);
                } else {
                    $popup.show(instance.options.speedAnimation / 2, function () {
                        instance.body.css('position', 'fixed');
                        instance.wrapper.css('marginTop', -scrT);
                    });
                }

            });

            instance.popup.click(function(e){ e.stopPropagation(); });

            instance.pclose.click(function(e){
                e.preventDefault();
                if ($(this).parents('.popup').hasClass('block-popup')){
                    $(this).parents('.popup').fadeOut(instance.options.speedAnimation / 2);
                    $('.layer').fadeOut(instance.options.speedAnimation/2);
                } else {
                    $(this).parents('.popup').hide(instance.options.speedAnimation / 2);
                    $html.css('overflow-y', 'auto');
                    $('body').removeAttr('style');
                    instance.wrapper.removeAttr('style');
                    $('body, html').scrollTop(scrT);
                }
            });

            $('.layer').on('click', function(){
                if (instance.popup.filter(':visible').hasClass('block-popup')){
                    instance.popup.filter(':visible').fadeOut(instance.options.speedAnimation / 2);
                    $('.layer').fadeOut(instance.options.speedAnimation/2);
                }
            });


            // Product Thumbs
            if (instance.thumbsSlider.length > 0) {

                instance.thumbsSlider.find('a').each(function(i) {
                    $(this).addClass( 'itm'+i );
                    $(this).click(function() {
                        instance.mediumSlider.trigger( 'slideTo', [i, 0, true] );
                    });
                });
                instance.thumbsSlider.find('.itm0').addClass( 'selected' );

                instance.mediumSlider.carouFredSel({
                    responsive: true,
                    circular: false,
                    infinite: false,
                    items : {
                        visible     : 1,
                        height       : 'auto',
                        width      : 870
                    },
                    auto: true,
                    scroll: {
                        fx: 'crossfade',
                        onBefore: function() {
                            var pos = $(this).triggerHandler( 'currentPosition' );
                            instance.thumbsSlider.find('a').removeClass( 'selected' );
                            instance.thumbsSlider.find('a.itm'+pos).addClass('selected');
                        }
                    }
                });

                instance.thumbsSlider.carouFredSel({
                    auto: false,
                    width: '100%',
                    scroll:{
                        items: 1
                    },
                    prev: ".th-prev",
                    next: ".th-next"
                });
            }

            instance.thumbsSlider.find('a').on('click', function(e){
                e.preventDefault();
            });

            // Product counting more
            instance.aMore.on('click',function(e){
                e.preventDefault();
                var $this = $(this),
                    valIn = $this.parent().find('input').val();
                valIn++;
                $this.parent().find('input').val(valIn);

                if ($this.parent().find('input').val() <= 1){
                    $this.parent().find(instance.aLess).addClass('disabled');
                } else {
                    $this.parent().find(instance.aLess).removeClass('disabled');
                }
            });

            instance.counting.find('input').on('change', function(){
                var $this = $(this);
                if ($this.parent().find('input').val() <= 1){
                    $this.parent().find(instance.aLess).addClass('disabled');
                } else {
                    $this.parent().find(instance.aLess).removeClass('disabled');
                }
            });

            // Product counting less
            instance.aLess.on('click',function(e){
                e.preventDefault();
                var $this = $(this),
                    valIn = $this.parent().find('input').val();
                if($this.parent().find('input').val() != 1){
                    valIn--;
                    $this.parent().find('input').val(valIn);
                    $this.removeClass('disabled');
                } else{
                    $this.addClass('disabled');
                    return false;
                }
                if ($this.parent().find('input').val() <= 1){
                    $this.addClass('disabled');
                }
            });

            instance.trRemove.on('click', function(e){
                e.preventDefault();
                var $this = $(this);

                $this.parents('tr').fadeOut(instance.options.speedAnimation/2, function(){
                    $(this).remove();
                });
            });

            // Activate the subscribe form
            if(this.newsletter.length === 1) {
                this.newsletter.find('input[type=email]').on('keyup', function(){
                    var sucBlock = $('.success');
                    if (sucBlock.is(':visible'))
                        sucBlock.css('display','none');
                });

                this.newsletter.validatr({
                    showall: true,
                    location: 'top',
                    template: '<div class="error-email">'+instance.options.errorText+'</div>',
                    valid: function(){
                        var form = instance.newsletter,
                            msgwrap = form.next(),
                            url = form.attr('action'),
                            email = form.find('input[type=email]');

                        url = url.replace('/post?', '/post-json?').concat('&c=?');

                        var data = {};
                        var dataArray = form.serializeArray();

                        $.each(dataArray, function (index, item) {
                            data[item.name] = item.value;
                        });

                        $.ajax({
                            url: url,
                            data: data,
                            success: function(resp){
                                var successText = instance.options.successText;
                                function notHide(){
                                    form.attr('style',' ');
                                }

                                if(resp.result === 'success') {
                                    msgwrap.html('<p class="success">'+successText+'</p>');
                                    setTimeout(notHide, 0);
                                }
                                else {
                                    setTimeout(notHide, 0);
                                    var msg;
                                    try {
                                        var parts = resp.msg.split(' - ', 2);
                                        if (parts[1] === undefined) {
                                            msg = resp.msg;
                                        } else {
                                            var i = parseInt(parts[0], 10);
                                            if (i.toString() === parts[0]) {
                                                msg = parts[1];
                                            } else {
                                                msg = resp.msg;
                                            }
                                        }
                                    }
                                    catch (e) {
                                        msg = resp.msg;
                                    }
                                    msgwrap.html('<p class="error">' + msg + '</p>');
                                }
                                form.slideUp(0,function () {
                                    msgwrap.slideDown();
                                });
                            },
                            dataType: 'jsonp',
                            error: function (resp, text) {
                                alert('Oops! AJAX error: ' + text);
                            }
                        });
                        return false;
                    }
                });
            }
        },
        sliders: function(){
            var instance = this;

            if (instance.owlslider.length > 0) {
                instance.owlslider.each(function(e) {
                    var $this = $(this),
                        owlNav = $(this).prev().find('.owlnav'),
                        owlPrev = owlNav.find('.prev'),
                        owlNext = owlNav.find('.next'),
                        items = $(this).data('item');

                        // console.log(owlNav.length);
                        

                        if (items !== undefined) {
                           $this.owlCarousel({
                                margin : 10,
                                responsiveClass:true,
                                responsive : {
                                    0 : {
                                        items :1
                                    },
                                    480 : {
                                        items : 2
                                    },
                                    992 : {
                                        items : items
                                    }
                                }
                            });
                        }
                        else {
                            $this.owlCarousel({
                                margin : 10,
                                responsiveClass:true,
                                responsive : {
                                    0 : {
                                        items :1
                                    },
                                    480 : {
                                        items : 2
                                    },
                                    768 : {
                                        items : 3
                                    },
                                    992 : {
                                        items : 4
                                    }
                                }
                            });
                        }

                        owlPrev.on('click', function(d) {
                            d.preventDefault();
                            $this.trigger('prev.owl.carousel');
                        });

                        owlNext.on('click', function(d) {
                            d.preventDefault();
                            $this.trigger('next.owl.carousel');
                        })
                });
            }

            if (instance.slider.length > 0){
                instance.slider.each(function(e){
                    var $this = $(this),
                        slidewrap = $this.find('ul:first'),
                        sliderFx = slidewrap.data('fx'),
                        sliderAuto = slidewrap.data('auto'),
                        sliderCircular = slidewrap.data('circular'),
                        sliderPrefix = '#slider-';

                    $this.attr('id', 'slider-'+e);

                    slidewrap.carouFredSel({
                        infinite: (typeof sliderCircular) ? sliderCircular : true,
                        circular: (typeof sliderCircular) ? sliderCircular : true,
                        width: '100%',
                        auto : sliderAuto ? sliderAuto : false,
                        scroll : {
                            fx : sliderFx ? sliderFx : 'crossfade',
                            duration : instance.options.speedAnimation,
                            timeoutDuration : instance.options.sliderInterval
                        },

                        swipe : {
                            onTouch : true,
                            onMouse : false
                        },
                        prev : $(sliderPrefix + e).find('.prev'),
                        next : $(sliderPrefix + e).find('.next'),
                        pagination : {
                            container: $(sliderPrefix + e).find('.pagination')
                        }
                    }).parent().css('margin', 'auto');
                });
            }

            if (instance.ribbon.length > 0){
                instance.ribbon.each(function(e){
                    var $this = $(this),
                        sliderAuto = $this.find('ul').data('auto'),
                        ribbonPrefix = '#ribbonslider-';

                    $this.attr('id', 'ribbonslider-' + e);

                    $this.find('ul').carouFredSel({
                        circular: true,
                        infinite: true,
                        width: '100%',
                        auto : sliderAuto ? sliderAuto : false,
                        items: {
                            visible: 'odd+2'
                        },
                        scroll: {
                            fx: 'directscroll',
                            items: 1,
                            timeoutDuration: instance.options.sliderInterval/2
                        },
                        pagination : $(ribbonPrefix + e).find('.pagination')
                    }).parent().css('margin', 'auto');
                });
            }

            if (instance.oneslider.length > 0){
                instance.oneslider.each(function(e){
                    var $this = $(this),
                        slidewrap = $this.find('ul'),
                        sliderFx = slidewrap.data('fx'),
                        sliderAuto = slidewrap.data('auto'),
                        onesliderPrefix = '#oneslider-';

                    $this.attr('id', 'oneslider-'+e);

                    slidewrap.carouFredSel({
                        responsive: true,
                        auto : sliderAuto ? sliderAuto : false,
                        scroll : {
                            fx : sliderFx ? sliderFx : 'crossfade',
                            duration : instance.options.speedAnimation,
                            timeoutDuration : instance.options.sliderInterval
                        },
                        items : {
                            visible     : 1,
                            height       : 'auto',
                            width      : 870
                        },
                        swipe : {
                            onTouch : true,
                            onMouse : false
                        },
                        prev : $(onesliderPrefix + e).find('.prev'),
                        next : $(onesliderPrefix + e).find('.next'),
                        pagination : {
                            container: $(onesliderPrefix + e).find('.pagination'),
                            anchorBuilder: function () {
                                if ($(this).parents(instance.slider.hasClass('pricing'))) {
                                    var per = $(this).data('period');
                                    return '<a href="#"><span>' + per + '</span></a>';
                                }
                            }
                        }
                    }).parent().css('margin', 'auto');
                });
            }
        },
        chars: function(){
            var instance = this;
            if (instance.chart.length > 0){
                var winTop = $win.scrollTop(),
                    winHeight = $win.height(),
                    chartTop = instance.chart.offset().top,
                    chartColor = instance.chart.css('color');

                if (!instance.chart.parents('.popup').hasClass('popup')){
                    if ( (winTop + winHeight) > chartTop) {
                        instance.chart.animate({'opacity': 1}, instance.options.speedAnimation);
                        instance.chart.easyPieChart({
                            barColor: '#e7543d',
                            animate: instance.options.speedAnimation * 4,
                            onStep: function (from, to, percent) {
                                if (!$(this.el).hasClass('no-percent')) {
                                    $(this.el).find('.percent').text(Math.round(percent));
                                }
                            }
                        });
                    }

                } else {
                    instance.popup.filter(':visible').find(instance.chart).animate({'opacity': 1}, instance.options.speedAnimation);
                    instance.popup.filter(':visible').find(instance.chart).easyPieChart({
                        barColor: chartColor,
                        animate: instance.options.speedAnimation * 4,
                        onStep: function (from, to, percent) {
                            $(this.el).find('.percent').text(Math.round(percent));
                        }
                    });
                }

            }

        },
        headerScroll: function(){
            var instance = this,
                winTop = $win.scrollTop(),
                scrTop = instance.scrTop,
                hTopHeight = instance.header.filter(':visible').find('.htop').outerHeight();

            if (winTop > instance.options.scrollTopButtonOffset) {
                scrTop.fadeIn(instance.options.speedAnimation);
            } else {
                scrTop.fadeOut(instance.options.speedAnimation);
            }

            if (instance.header.filter(':visible').hasClass('centered') && !$html.hasClass('page404')) {
                if(instance.header.filter(':visible').hasClass('header-simple')) {
                    hTopHeight = 0;
                    if (winTop > hTopHeight) {
                        instance.header.addClass('sticky');
                        instance.wrapper.css('marginTop', hTopHeight);
                    } else {
                        instance.header.removeClass('sticky');
                        instance.wrapper.css('marginTop', 0);
                    }
                } else if (winTop > 39) {
                    instance.header.addClass('sticky');
                    instance.wrapper.css('marginTop', 39);
                } else {
                    instance.header.removeClass('sticky');
                    instance.wrapper.css('marginTop', 0);
                }
            } else if(instance.header.filter(':visible').hasClass('header-simple')){
                hTopHeight = 0;
                if (winTop > hTopHeight) {
                    instance.header.addClass('sticky');
                    instance.wrapper.css('marginTop', hTopHeight);
                } else {
                    instance.header.removeClass('sticky');
                    instance.wrapper.css('marginTop', 0);
                }
            } else if(instance.header.filter(':visible').hasClass('sides')){
                if (winTop > 39) {
                    instance.header.addClass('sticky');
                    instance.wrapper.css('marginTop', 39);
                } else {
                    instance.header.removeClass('sticky');
                    instance.wrapper.css('marginTop', 0);
                }
            }
        },
        histLine: function(){
            var instance = this;

            if (instance.histEvent.length > 0){
                instance.histEvent.each(function() {
                    var self = $(this),
                        winTop = $win.scrollTop(),
                        topPos = self.offset().top - $win.height();
                        if ( (winTop >= topPos) && !onMobile){
                            self.delay(instance.options.speedAnimation/3).animate({'opacity': 1}, instance.options.speedAnimation, 'easeOutQuad');
                        } else if (onMobile){
                            self.css('opacity', 1);
                        }
                });
            }

        },
        bars: function(){
            var instance = this;

            if (instance.barDiagramm.length > 0) {
                instance.barDiagramm.each(function (e) {
                    var $this = $(this),
                        pColors = $this.data('colors'),
                        pPostfix = $this.data('postfix'),
                        pData = $this.data('value'),
                        winTop = $win.scrollTop(),
                        topPos = $this.offset().top - $win.height();

                    $this.attr('id', 'bar-' + e);
                    if ( winTop >= topPos && !instance.barDiagramm.parents('.popup').hasClass('popup')) {
                        if ($this.children().length === 0) {
                            $this.jqBarGraph({
                                data: [
                                    [pData]
                                ],
                                colors: [pColors],
                                postfix: pPostfix,
                                height: 225
                            });
                        }
                    } else if( instance.barDiagramm.parents('.popup').hasClass('popup') && instance.barDiagramm.parents('.popup').is(':visible') ) {
                        if ($this.children().length === 0) {
                            instance.barDiagramm.parents('.popup:visible').find($this).jqBarGraph({
                                data: [
                                    [pData]
                                ],
                                colors: [pColors],
                                postfix: pPostfix,
                                height: 225
                            });
                        }
                    }
                });
            }
        },
        fNum: function(){
            var instance = this,
                numbS;

            if (instance.num.length > 0){

                instance.num.parent().each(function(){
                    var self = $(this),
                        winTop = $win.scrollTop(),
                        topPos = self.offset().top - $win.height(),
                        blHeight = self.height() - 120,
                        sectionTop = self.parents('.container').offset().top;

                    if (!self.hasClass('target')) {
                        self.find(instance.num).each(function(){
                            var $this = $(this),
                                numb = $this.data('num'),
                                incr = $this.data('increment'),
                                fractional = $this.data('fractional') ? $this.data('fractional') : 0,
                                i = 0,
                                timer;

                            if ( (winTop >= topPos && winTop <= (topPos + blHeight)) && !onMobile || (winTop <= sectionTop && (winTop+$win.height()) >= sectionTop)){
                                timer = setTimeout(function run() {
                                    if ( i < numb) i+=incr;
                                    else {
                                        i = numb;
                                        $this.text(i.toFixed(fractional).replace('.',',')
                                            .replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
                                        return i;
                                    }
                                    $this.text(i.toFixed(fractional).replace('.',',')
                                        .replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));

                                    if ( instance.skillLine.length > 0){
                                        $this.parent().prev().animate({'width' : i + '%'}, 17);
                                    }

                                    timer = setTimeout(run, 20);
                                }, 20);

                                $this.parent().addClass('target');
                            }
                            else {
                                numbS = numb.toString().replace('.',',');
                                $this.text(numbS.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
                                if ( instance.skillLine.length > 0){
                                    $this.parent().prev().css('width', numb + '%');
                                }
                            }
                        });
                    }
                });

            }
        },
        contactMap: function() {
            var cmyLatlng = new google.maps.LatLng(-6.168163, 106.7980204);
            var cmapOptions = {
                zoom: 13,
                scrollwheel: false,
                navigationControl: false,
                mapTypeControl: false,
                scaleControl: false,
                draggable: true,
                center: cmyLatlng
            };
            var cmap = new google.maps.Map(document.getElementById('contact-map'), cmapOptions);
            new google.maps.Marker({
                position: cmyLatlng,
                map: cmap
            });
        },
        contactMapFix: function() {
            var cmyLatlng = new google.maps.LatLng(-6.168163, 106.7980204);
            var cmapOptions = {
                zoom: 13,
                scrollwheel: false,
                navigationControl: false,
                mapTypeControl: false,
                scaleControl: false,
                draggable: true,
                center: cmyLatlng
            };
            var cmap = new google.maps.Map(document.getElementById('contact-map-fix'), cmapOptions);
            new google.maps.Marker({
                position: cmyLatlng,
                map: cmap
            });
        },
        ytVideo: function(){
            var instance = this;

            if (instance.ytvid.length > 0 && !onMobile){
                instance.ytvid.each(function(){
                    var $this = $(this);

                    $this.mb_YTPlayer({
                        containment: 'self',
                        mute: true,
                        autoPlay: true,
                        loop: true,
                        addRaster: false
                    });
                });

            }
        },
        fMiddle: function(){
            this.vmiddle.each(function(){
                var $this = $(this);
             /*   if ( !$this.prev().length ){
                    $this.css({
                        'marginTop' : ($this.parent().outerHeight() - $this.outerHeight())/2
                    });
                } else{
                    $this.css({
                        'marginTop' : ($this.parent().outerHeight() - $this.outerHeight())/2 - $this.prev().css('paddingTop').replace('px','')
                    });
                }
*/
            });
        },
        fSize: function(){
            this.fullsize.height($win.height());
            this.fullsize.find('li').height($win.height());
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                    new Plugin(this, options));
            }
        });
    };
})(jQuery, window, document);

(function ($) {
    $(document.body).Camaro();

    // *** crossbrowser html5 placeholder *** //
    var UA=window.navigator.userAgent,IEB=/MSIE 9/i,IE=UA.match(IEB);if(!IE==""){$("[placeholder]").focus(function(){var e=$(this);if(e.val()==e.attr("placeholder")){e.val("");e.removeClass("placeholder");}}).blur(function(){var e=$(this);if(e.val()===""||e.val()==e.attr("placeholder")){e.addClass("placeholder");e.val(e.attr("placeholder"));}}).blur().parents("form").submit(function(){$(this).find("[placeholder]").each(function(){var e=$(this);if(e.val()==e.attr("placeholder")){e.val("");}});});}

})(jQuery);