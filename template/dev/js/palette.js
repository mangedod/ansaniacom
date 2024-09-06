/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */

(function(e){if(typeof define==="function"&&define.amd){define(["jquery"],e)}else if(typeof exports==="object"){e(require("jquery"))}else{e(jQuery)}})(function(e){function n(e){return u.raw?e:encodeURIComponent(e)}function r(e){return u.raw?e:decodeURIComponent(e)}function i(e){return n(u.json?JSON.stringify(e):String(e))}function s(e){if(e.indexOf('"')===0){e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\")}try{e=decodeURIComponent(e.replace(t," "));return u.json?JSON.parse(e):e}catch(n){}}function o(t,n){var r=u.raw?t:s(t);return e.isFunction(n)?n(r):r}var t=/\+/g;var u=e.cookie=function(t,s,a){if(s!==undefined&&!e.isFunction(s)){a=e.extend({},u.defaults,a);if(typeof a.expires==="number"){var f=a.expires,l=a.expires=new Date;l.setTime(+l+f*864e5)}return document.cookie=[n(t),"=",i(s),a.expires?"; expires="+a.expires.toUTCString():"",a.path?"; path="+a.path:"",a.domain?"; domain="+a.domain:"",a.secure?"; secure":""].join("")}var c=t?undefined:{};var h=document.cookie?document.cookie.split("; "):[];for(var p=0,d=h.length;p<d;p++){var v=h[p].split("=");var m=r(v.shift());var g=v.join("=");if(t&&t===m){c=o(g,s);break}if(!t&&(g=o(g))!==undefined){c[m]=g}}return c};u.defaults={};e.removeCookie=function(t,n){if(e.cookie(t)===undefined){return false}e.cookie(t,"",e.extend({},n,{expires:-1}));return!e.cookie(t)}});

var AppPalette = (function(){

    var $body = $(document.body),
        $palette = $('<div id="palette"/>'),
        $paletteStructure = '<a href="" id="palette-toggle"><i class="custom-icon custom-icon-palette-settings"></i></a>' +
        '<div class="pa-row">' +
        '<div class="pa-col pa-wide">' +
        '<div class="pa-label">Menu</div>' +
        '<select data-width="141" id="pa-menu-position">' +
        '<option value="Right">Right</option>' +
        '<option value="Left">Left</option>' +
        '<option value="Center">Center</option>' +
        '<option value="Simple">Simple</option>' +
        '</select>' +
        '</div>' +
        '<div class="pa-col pa-thin">' +
        '<div class="pa-label">Color</div>' +
        '<nav class="pa-radio">' +
        '<a href="" class="active" id="pa-menu-white" style="background-color: #ECECEC;"></a>' +
        '<a href="" id="pa-menu-black" style="background-color: #121212;"></a>' +
        '</nav>' +
        '</div>' +
        '</div>' +
        '<div class="pa-row">' +
        '<div class="pa-col pa-wide">' +
        '<div class="pa-label">Footer</div>' +
        '<select data-width="141" id="pa-footer-position">' +
        '<option value="Extended">Extended</option>' +
        '<option value="Standart 1">Standart 1</option>' +
        '<option value="Standart 2">Standart 2</option>' +
        '<option value="Simple">Simple</option>' +
        '</select>' +
        '</div>' +
        '<div class="pa-col pa-thin">' +
        '<div class="pa-label">Color</div>' +
        '<nav class="pa-radio">' +
        '<a href="" id="pa-footer-white" style="background-color: #ECECEC;"></a>' +
        '<a href="" class="active" id="pa-footer-black" style="background-color: #121212;"></a>' +
        '</nav>' +
        '</div>' +
        '</div>' +
        '<div class="pa-row">' +
        '<div class="pa-label">Color Skin</div>' +
        '<nav class="pa-radio" id="pa-skin">' +
        '<a href="" class="active" id="skin-red" style="background-color: #E7543D;"></a>' +
        '<a href="" id="skin-green" style="background-color: #00A74D;"></a>' +
        '<a href="" id="skin-yellow" style="background-color: #FAAB10;"></a>' +
        '<a href="" id="skin-aqua" style="background-color: #48CBD9;"></a>' +
        '<a href="" id="skin-blue" style="background-color: #39AEDA;"></a>' +
        '<a href="" id="skin-orange" style="background-color: #FF9633;"></a>' +
        '<a href="" id="skin-gray" style="background-color: #8E8E8E;"></a>' +
        '<a href="" id="skin-brown" style="background-color: #CA6B1A;"></a>' +
        '<a href="" id="skin-sand" style="background-color: #998674;"></a>' +
        '</nav>' +
        '</div>',
        $stylize = $('<style id="palette-style"/>'),
        $stylizeStructure = '#palette{position:fixed;left:-259px;top:10%;z-index:9999;background-color:#212121;width:259px;border-radius:0 0 4px 0;padding:28px 21px;}#palette-toggle{width:50px;height:50px;text-align:center;position:absolute;right:-50px;display:block;line-height:50px;font-size:1px;top:0;border-radius:0 4px 4px 0;background-color:#212121;}#palette-toggle i{-webkit-transition:all 4s ease;-ms-transition:all 4s ease;transition:all 4s ease;-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg);}#palette-toggle:hover i{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg);}.pa-row{margin-bottom:30px;float:left;width:100%;}.pa-row:last-child{margin-bottom:0;}.pa-col.pa-wide{float:left;width:141px;}.pa-col.pa-thin{float:right;width:62px;}.pa-label{font-size:15px;color:#666;line-height:1;margin-bottom:10px;}.pa-radio a{float:left;width:31px;height:31px;position:relative;}.pa-radio a:first-child{border-radius:2px 0 0 2px;}.pa-radio a:last-child,.pa-radio a:nth-child(7){border-radius:0 2px 2px 0;}.pa-radio a:nth-child(8){border-radius:0 0 0 2px;}#pa-skin a:first-child{border-radius:2px 0 0;}#pa-skin a:last-child{border-radius:0 0 2px;}.pa-radio a.active:after{position:absolute;width:10px;height:7px;background:url(images/icons.png) -467px -57px;display:block;content:" ";top:13px;left:11px;}#pa-skin a.active:after{background-position:-437px -57px;}#palette .chosen-container,#palette .chosen-container .chosen-drop{background-color:#404040;border:0;border-radius:2px; line-height:31px; max-width: 141px;}#palette .chosen-container .chosen-results{padding:0;}#palette .chosen-container-single .chosen-single,#palette .chosen-container .chosen-results li{border:0;font-size:15px;color:#ccc;line-height:31px;} #palette .chosen-single{height: 31px;}',
        $P,
        $S,
        timer = 500;

    return {
        init: function(){
            this.creating();
        },
        creating: function(){
            $body.append($palette);
            $body.append($stylize);

            $P = $('#palette');
            $S = $('#palette-style');
            $P.prepend($paletteStructure);
            $S.prepend($stylizeStructure);

            $Pwid = $P.outerWidth();

            if ($P.find('select').length > 0){
                $P.find('select').each(function(){
                    var self = $(this),
                        wid = self.data('width');

                    self.width(wid).chosen();
                });
            }

            $P.on('click', 'a', function(e){
                e.preventDefault();
            });

            // Panel Toggle
            this.toggleF();

            // Cookie Functions
            this.footerColorCookie();
            this.footerPositionCookie();
            this.headerColorCookie();
            this.headerPositionCookie();
            this.skinCookie();
        },
        toggleF: function(){
            $P.on('click', '#palette-toggle', function(){
                if (parseInt($P.css('left')) === 0 ) {
                    $P.stop(true, true).animate({'left': -$Pwid}, timer);
                } else {
                    $P.stop(true, true).animate({'left': 0}, timer);
                }
            });
        },
        footerColorCookie: function(){
            var footerClass = $.cookie('fcookie'),
                $footer = $('.footer'),
                $flight = $('#pa-footer-white'),
                $fdark = $('#pa-footer-black');

            $footer.removeClass("flight");


            $flight.on('click', function(){
                var $this = $(this);

                $footer.addClass("flight");
                $this.addClass('active').siblings().removeClass('active');
                $.cookie('fcookie','flight');
            });

            $fdark.on('click', function(){
                var $this = $(this);

                $footer.removeClass("flight");
                $this.addClass('active').siblings().removeClass('active');
                $.cookie('fcookie','');
            });

            if (footerClass) {
                $footer.addClass(footerClass);
                if (footerClass == 'flight'){
                    $flight.addClass('active').siblings().removeClass('active');
                }
            }
        },
        footerPositionCookie: function(){
            var frow = $.cookie('frowcookie'),
                $selFooPos = $('#pa_footer_position_chosen'),
                $fooPosActive = $selFooPos.find('.chosen-single > span');

            $selFooPos.on('click', function(){
                var $this = $(this),
                    resSel = $this.find('.chosen-single > span').text().toLowerCase();

                if (resSel == 'extended') {
                    $('.foorow').show();
                    $.cookie('frowcookie','');
                } else if (resSel == 'standart 1'){
                    $('.foorow').hide();
                    $('.foorow-1, .foorow-3').show();
                    $.cookie('frowcookie','frowcookie-1-3');
                } else if (resSel == 'simple'){
                    $('.foorow').hide();
                    $('.foorow-3').show();
                    $.cookie('frowcookie','frowcookie-3');
                } else if( resSel == 'standart 2'){
                    $('.foorow').hide();
                    $('.foorow-2, .foorow-3').show();
                    $.cookie('frowcookie','frowcookie-2-3');
                }

            });

            if (frow) {
                if (frow == 'frowcookie-1-3'){
                    $('.foorow').hide();
                    $('.foorow-1, .foorow-3').show();
                    $fooPosActive.text('Standart 1');
                } else if (frow == 'frowcookie-3'){
                    $('.foorow').hide();
                    $('.foorow-3').show();
                    $fooPosActive.text('Simple');
                } else if (frow == 'frowcookie-2-3'){
                    $('.foorow').hide();
                    $('.foorow-2, .foorow-3').show();
                    $fooPosActive.text('Standart 2');
                }
            } else {
                $fooPosActive.text('Extended');
            }

        },
        headerColorCookie: function(){
            var headerColor = $.cookie('hcolor'),
                $hlight = $('#pa-menu-white'),
                $hdark = $('#pa-menu-black'),
                $hbottom = $('.hbottom');

            $hlight.on('click', function(){
                var $this = $(this);

                $hbottom.removeClass("dark");
                $this.addClass('active').siblings().removeClass('active');
                $.cookie('hcolor','');
            });

            $hdark.on('click', function(){
                var $this = $(this);

                $hbottom.addClass("dark");
                $this.addClass('active').siblings().removeClass('active');
                $.cookie('hcolor','dark');
            });

            if (headerColor) {
                $hbottom.addClass(headerColor);
                if (headerColor == 'dark'){
                    $hdark.addClass('active').siblings().removeClass('active');
                }
            }

        },
        headerPositionCookie: function(){
            var headerClass = $.cookie('hcookie'),
                $selHeaPos = $('#pa_menu_position_chosen'),
                $heaPosActive = $selHeaPos.find('.chosen-single > span');

            $selHeaPos.on('click', function(){
                var $this = $(this),
                    resSel = $this.find('.chosen-single > span').text().toLowerCase();

                if (resSel == 'right') {
                    $('.header').removeClass('header-simple centered');
                    $('.header.sides').show().siblings('.header').hide();
                    $('.hbottom').removeClass('left-pos').addClass('right-pos');
                    $.cookie('hcookie','header-right');
                } else if (resSel == 'left'){
                    $('.header').removeClass('header-simple centered');
                    $('.header.sides').show().siblings('.header').hide();
                    $('.hbottom').removeClass('right-pos').addClass('left-pos');
                    $.cookie('hcookie','header-left');
                } else if (resSel == 'center'){
                    $('.header').removeClass('header-simple').addClass('centered');
                    $.cookie('hcookie','header-center');
                } else if( resSel == 'simple'){
                    $('.header').removeClass('centered').addClass('header-simple');
                    $('.hbottom').removeClass('left-pos').addClass('right-pos');
                    $.cookie('hcookie','header-simple');
                }

            });

            if (headerClass) {
                if (headerClass == 'header-right'){
                    $('.header').removeClass('header-simple centered');
                    $('.hbottom').removeClass('left-pos').addClass('right-pos');
                    $heaPosActive.text('Right');
                } else if (headerClass == 'header-left'){
                    $('.header').removeClass('header-simple centered');
                    $('.hbottom').removeClass('right-pos').addClass('left-pos');
                    $heaPosActive.text('Left');
                } else if (headerClass == 'header-center'){
                    $('.header').removeClass('header-simple').addClass('centered');
                    $heaPosActive.text('Center');
                } else if(headerClass == 'header-simple') {
                    $('.header').removeClass('centered').addClass('header-simple');
                    $('.hbottom').removeClass('left-pos').addClass('right-pos');
                    $heaPosActive.text('Simple');
                }
            }

        },
        skinCookie: function(){
            var skin = $.cookie('skin'),
                $navSkin = $('#pa-skin');

            $navSkin.children().on('click', function(){
                var $this = $(this),
                    theme = $this.attr('id');

                $this.addClass('active').siblings().removeClass('active');
                $body.removeClass().addClass(theme);

                if ($.cookie('layoutwidth') == 'container'){
                    $body.addClass($.cookie('layoutwidth'));
                }

                $.cookie('skin',theme);

            });

            if (skin) {
                $navSkin.find('a[id='+skin+']').addClass('active').siblings().removeClass('active');
                if (skin == 'skin-red') {
                    $body.removeClass('skin*');
                } else {
                    $body.addClass(skin);
                }
            }

        }
    }
})();

AppPalette.init();