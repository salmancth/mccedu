(function($) {
    "use strict";
    $ = jQuery;
    /*!
     Version: beta 1.3.5
     License: MIT http://en.wikipedia.org/wiki/MIT_License or GPLv2 http://en.wikipedia.org/wiki/GNU_General_Public_License
     */;
    (function($, window, document, undefined) {
        var pluginName = 'sharrre', defaults = {className: 'sharrre', share: {googlePlus: false, facebook: false, twitter: false, digg: false, delicious: false, stumbleupon: false, linkedin: false, pinterest: false}, shareTotal: 0, template: '', title: '', url: document.location.href, text: document.title, urlCurl: 'sharrre.php', count: {}, total: 0, shorterTotal: true, enableHover: true, enableCounter: true, enableTracking: false, hover: function() {
            }, hide: function() {
            }, click: function() {
            }, render: function() {
            }, buttons: {googlePlus: {url: '', urlCount: false, size: 'medium', lang: 'en-US', annotation: ''}, facebook: {url: '', urlCount: false, action: 'like', layout: 'button_count', width: '', send: 'false', faces: 'false', colorscheme: '', font: '', lang: 'en_US'}, twitter: {url: '', urlCount: false, count: 'horizontal', hashtags: '', via: '', related: '', lang: 'en'}, digg: {url: '', urlCount: false, type: 'DiggCompact'}, delicious: {url: '', urlCount: false, size: 'medium'}, stumbleupon: {url: '', urlCount: false, layout: '1'}, linkedin: {url: '', urlCount: false, counter: ''}, pinterest: {url: '', media: '', description: '', layout: 'horizontal'}}}, urlJson = {googlePlus: "", facebook: "https://graph.facebook.com/fql?q=SELECT%20url,%20normalized_url,%20share_count,%20like_count,%20comment_count,%20total_count,commentsbox_count,%20comments_fbid,%20click_count%20FROM%20link_stat%20WHERE%20url=%27{url}%27&callback=?", twitter: "http://cdn.api.twitter.com/1/urls/count.json?url={url}&callback=?", digg: "http://services.digg.com/2.0/story.getInfo?links={url}&type=javascript&callback=?", delicious: 'http://feeds.delicious.com/v2/json/urlinfo/data?url={url}&callback=?', stumbleupon: "", linkedin: "http://www.linkedin.com/countserv/count/share?format=jsonp&url={url}&callback=?", pinterest: "http://api.pinterest.com/v1/urls/count.json?url={url}&callback=?"}, loadButton = {googlePlus: function(self) {
                var sett = self.options.buttons.googlePlus;
                $(self.element).find('.buttons').append('<div class="button googleplus"><div class="g-plusone" data-size="' + sett.size + '" data-href="' + (sett.url !== '' ? sett.url : self.options.url) + '" data-annotation="' + sett.ann_gaqotation + '"></div></div>');
                window.___gcfg = {lang: self.options.buttons.googlePlus.lang};
                var loading = 0;
                if (typeof gapi === 'undefined' && loading == 0) {
                    loading = 1;
                    (function() {
                        var po = document.createElement('script');
                        po.type = 'text/javascript';
                        po.async = true;
                        po.src = '//apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(po, s);
                    })();
                } else {
                    gapi.plusone.go();
                }
            }, facebook: function(self) {
                var sett = self.options.buttons.facebook;
                $(self.element).find('.buttons').append('<div class="button facebook"><div id="fb-root"></div><div class="fb-like" data-href="' + (sett.url !== '' ? sett.url : self.options.url) + '" data-send="' + sett.send + '" data-layout="' + sett.layout + '" data-width="' + sett.width + '" data-show-faces="' + sett.faces + '" data-action="' + sett.action + '" data-colorscheme="' + sett.colorscheme + '" data-font="' + sett.font + '" data-via="' + sett.via + '"></div></div>');
                var loading = 0;
                if (typeof FB === 'undefined' && loading == 0) {
                    loading = 1;
                    (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) {
                            return;
                        }
                        js = d.createElement(s);
                        js.id = id;
                        js.src = '//connect.facebook.net/' + sett.lang + '/all.js#xfbml=1';
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                } else {
                    FB.XFBML.parse();
                }
            }, twitter: function(self) {
                var sett = self.options.buttons.twitter;
                $(self.element).find('.buttons').append('<div class="button twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-url="' + (sett.url !== '' ? sett.url : self.options.url) + '" data-count="' + sett.count + '" data-text="' + self.options.text + '" data-via="' + sett.via + '" data-hashtags="' + sett.hashtags + '" data-related="' + sett.related + '" data-lang="' + sett.lang + '">Tweet</a></div>');
                var loading = 0;
                if (typeof twttr === 'undefined' && loading == 0) {
                    loading = 1;
                    (function() {
                        var twitterScriptTag = document.createElement('script');
                        twitterScriptTag.type = 'text/javascript';
                        twitterScriptTag.async = true;
                        twitterScriptTag.src = '//platform.twitter.com/widgets.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(twitterScriptTag, s);
                    })();
                } else {
                    $.ajax({url: '//platform.twitter.com/widgets.js', dataType: 'script', cache: true});
                }
            }, digg: function(self) {
                var sett = self.options.buttons.digg;
                $(self.element).find('.buttons').append('<div class="button digg"><a class="DiggThisButton ' + sett.type + '" rel="nofollow external" href="http://digg.com/submit?url=' + encodeURIComponent((sett.url !== '' ? sett.url : self.options.url)) + '"></a></div>');
                var loading = 0;
                if (typeof __DBW === 'undefined' && loading == 0) {
                    loading = 1;
                    (function() {
                        var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
                        s.type = 'text/javascript';
                        s.async = true;
                        s.src = '//widgets.digg.com/buttons.js';
                        s1.parentNode.insertBefore(s, s1);
                    })();
                }
            }, delicious: function(self) {
                if (self.options.buttons.delicious.size == 'tall') {
                    var css = 'width:50px;', cssCount = 'height:35px;width:50px;font-size:15px;line-height:35px;', cssShare = 'height:18px;line-height:18px;margin-top:3px;';
                } else {
                    var css = 'width:93px;', cssCount = 'float:right;padding:0 3px;height:20px;width:26px;line-height:20px;', cssShare = 'float:left;height:20px;line-height:20px;';
                }
                var count = self.shorterTotal(self.options.count.delicious);
                if (typeof count === "undefined") {
                    count = 0;
                }
                $(self.element).find('.buttons').append('<div class="button delicious"><div style="' + css + 'font:12px Arial,Helvetica,sans-serif;cursor:pointer;color:#666666;display:inline-block;float:none;height:20px;line-height:normal;margin:0;padding:0;text-indent:0;vertical-align:baseline;">' + '<div style="' + cssCount + 'background-color:#fff;margin-bottom:5px;overflow:hidden;text-align:center;border:1px solid #ccc;border-radius:3px;">' + count + '</div>' + '<div style="' + cssShare + 'display:block;padding:0;text-align:center;text-decoration:none;width:50px;background-color:#7EACEE;border:1px solid #40679C;border-radius:3px;color:#fff;">' + '<img src="http://www.delicious.com/static/img/delicious.small.gif" height="10" width="10" alt="Delicious" /> Add</div></div></div>');
                $(self.element).find('.delicious').on('click', function() {
                    self.openPopup('delicious');
                });
            }, stumbleupon: function(self) {
                var sett = self.options.buttons.stumbleupon;
                $(self.element).find('.buttons').append('<div class="button stumbleupon"><su:badge layout="' + sett.layout + '" location="' + (sett.url !== '' ? sett.url : self.options.url) + '"></su:badge></div>');
                var loading = 0;
                if (typeof STMBLPN === 'undefined' && loading == 0) {
                    loading = 1;
                    (function() {
                        var li = document.createElement('script');
                        li.type = 'text/javascript';
                        li.async = true;
                        li.src = '//platform.stumbleupon.com/1/widgets.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(li, s);
                    })();
                    s = window.setTimeout(function() {
                        if (typeof STMBLPN !== 'undefined') {
                            STMBLPN.processWidgets();
                            clearInterval(s);
                        }
                    }, 500);
                } else {
                    STMBLPN.processWidgets();
                }
            }, linkedin: function(self) {
                var sett = self.options.buttons.linkedin;
                $(self.element).find('.buttons').append('<div class="button linkedin"><script type="in/share" data-url="' + (sett.url !== '' ? sett.url : self.options.url) + '" data-counter="' + sett.counter + '"></script></div>');
                var loading = 0;
                if (typeof window.IN === 'undefined' && loading == 0) {
                    loading = 1;
                    (function() {
                        var li = document.createElement('script');
                        li.type = 'text/javascript';
                        li.async = true;
                        li.src = '//platform.linkedin.com/in.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(li, s);
                    })();
                } else {
                    window.IN.init();
                }
            }, pinterest: function(self) {
                var sett = self.options.buttons.pinterest;
                $(self.element).find('.buttons').append('<div class="button pinterest"><a href="http://pinterest.com/pin/create/button/?url=' + (sett.url !== '' ? sett.url : self.options.url) + '&media=' + sett.media + '&description=' + sett.description + '" class="pin-it-button" count-layout="' + sett.layout + '">Pin It</a></div>');
                (function() {
                    var li = document.createElement('script');
                    li.type = 'text/javascript';
                    li.async = true;
                    li.src = '//assets.pinterest.com/js/pinit.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(li, s);
                })();
            }}, tracking = {googlePlus: function() {
            }, facebook: function() {
                fb = window.setInterval(function() {
                    if (typeof FB !== 'undefined') {
                        FB.Event.subscribe('edge.create', function(targetUrl) {
                            c.push(['_trackSocial', 'facebook', 'like', targetUrl]);
                        });
                        FB.Event.subscribe('edge.remove', function(targetUrl) {
                            _gaq.push(['_trackSocial', 'facebook', 'unlike', targetUrl]);
                        });
                        FB.Event.subscribe('message.send', function(targetUrl) {
                            _gaq.push(['_trackSocial', 'facebook', 'send', targetUrl]);
                        });
                        clearInterval(fb);
                    }
                }, 1000);
            }, twitter: function() {
                tw = window.setInterval(function() {
                    if (typeof twttr !== 'undefined') {
                        twttr.events.bind('tweet', function(event) {
                            if (event) {
                                _gaq.push(['_trackSocial', 'twitter', 'tweet']);
                            }
                        });
                        clearInterval(tw);
                    }
                }, 1000);
            }, digg: function() {
            }, delicious: function() {
            }, stumbleupon: function() {
            }, linkedin: function() {
                function LinkedInShare() {
                    _gaq.push(['_trackSocial', 'linkedin', 'share']);
                }}
            , pinterest: function() {
            }}, popup = {googlePlus: function(opt) {
                window.open("https://plus.google.com/share?hl=" + opt.buttons.googlePlus.lang + "&url=" + encodeURIComponent((opt.buttons.googlePlus.url !== '' ? opt.buttons.googlePlus.url : opt.url)), "", "toolbar=0, status=0, width=900, height=500");
            }, facebook: function(opt) {
                window.open("http://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent((opt.buttons.facebook.url !== '' ? opt.buttons.facebook.url : opt.url)) + "&t=" + opt.text + "", "", "toolbar=0, status=0, width=550, height=500");
            }, twitter: function(opt) {
                window.open("https://twitter.com/intent/tweet?text=" + encodeURIComponent(opt.text) + "&url=" + encodeURIComponent((opt.buttons.twitter.url !== '' ? opt.buttons.twitter.url : opt.url)) + (opt.buttons.twitter.via !== '' ? '&via=' + opt.buttons.twitter.via : ''), "", "toolbar=0, status=0, width=650, height=360");
            }, digg: function(opt) {
                window.open("http://digg.com/tools/diggthis/submit?url=" + encodeURIComponent((opt.buttons.digg.url !== '' ? opt.buttons.digg.url : opt.url)) + "&title=" + opt.text + "&related=true&style=true", "", "toolbar=0, status=0, width=650, height=360");
            }, delicious: function(opt) {
                window.open('http://www.delicious.com/save?v=5&noui&jump=close&url=' + encodeURIComponent((opt.buttons.delicious.url !== '' ? opt.buttons.delicious.url : opt.url)) + '&title=' + opt.text, 'delicious', 'toolbar=no,width=550,height=550');
            }, stumbleupon: function(opt) {
                window.open('http://www.stumbleupon.com/badge/?url=' + encodeURIComponent((opt.buttons.stumbleupon.url !== '' ? opt.buttons.stumbleupon.url : opt.url)), 'stumbleupon', 'toolbar=no,width=550,height=550');
            }, linkedin: function(opt) {
                window.open('https://www.linkedin.com/cws/share?url=' + encodeURIComponent((opt.buttons.linkedin.url !== '' ? opt.buttons.linkedin.url : opt.url)) + '&token=&isFramed=true', 'linkedin', 'toolbar=no,width=550,height=550');
            }, pinterest: function(opt) {
                window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent((opt.buttons.pinterest.url !== '' ? opt.buttons.pinterest.url : opt.url)) + '&media=' + encodeURIComponent(opt.buttons.pinterest.media) + '&description=' + opt.buttons.pinterest.description, 'pinterest', 'toolbar=no,width=700,height=300');
            }};
        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend(true, {}, defaults, options);
            this.options.share = options.share;
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }
        ;
        Plugin.prototype.init = function() {
            var self = this;
            if (this.options.urlCurl !== '') {
                urlJson.googlePlus = this.options.urlCurl + '?url={url}&type=googlePlus';
                urlJson.stumbleupon = this.options.urlCurl + '?url={url}&type=stumbleupon';
            }
            $(this.element).addClass(this.options.className);
            if (typeof $(this.element).data('title') !== 'undefined') {
                this.options.title = $(this.element).attr('data-title');
            }
            if (typeof $(this.element).data('url') !== 'undefined') {
                this.options.url = $(this.element).data('url');
            }
            if (typeof $(this.element).data('text') !== 'undefined') {
                this.options.text = $(this.element).data('text');
            }
            $.each(this.options.share, function(name, val) {
                if (val === true) {
                    self.options.shareTotal++;
                }
            });
            if (self.options.enableCounter === true) {
                $.each(this.options.share, function(name, val) {
                    if (val === true) {
                        try {
                            self.getSocialJson(name);
                        } catch (e) {
                        }
                    }
                });
            } else if (self.options.template !== '') {
                this.options.render(this, this.options);
            } else {
                this.loadButtons();
            }
            $(this.element).hover(function() {
                if ($(this).find('.buttons').length === 0 && self.options.enableHover === true) {
                    self.loadButtons();
                }
                self.options.hover(self, self.options);
            }, function() {
                self.options.hide(self, self.options);
            });
            $(this.element).click(function() {
                self.options.click(self, self.options);
                return false;
            });
        };
        Plugin.prototype.loadButtons = function() {
            var self = this;
            $(this.element).append('<div class="buttons"></div>');
            $.each(self.options.share, function(name, val) {
                if (val == true) {
                    loadButton[name](self);
                    if (self.options.enableTracking === true) {
                        tracking[name]();
                    }
                }
            });
        };
        Plugin.prototype.getSocialJson = function(name) {
            var self = this, count = 0, url = urlJson[name].replace('{url}', encodeURIComponent(this.options.url));
            if (this.options.buttons[name].urlCount === true && this.options.buttons[name].url !== '') {
                url = urlJson[name].replace('{url}', this.options.buttons[name].url);
            }
            if (url != '' && self.options.urlCurl !== '') {
                $.getJSON(url, function(json) {
                    if (typeof json.count !== "undefined") {
                        var temp = json.count + '';
                        temp = temp.replace('\u00c2\u00a0', '');
                        count += parseInt(temp, 10);
                    } else if (json.data && json.data.length > 0 && typeof json.data[0].total_count !== "undefined") {
                        count += parseInt(json.data[0].total_count, 10);
                    } else if (typeof json[0] !== "undefined") {
                        count += parseInt(json[0].total_posts, 10);
                    } else if (typeof json[0] !== "undefined") {
                    }
                    self.options.count[name] = count;
                    self.options.total += count;
                    self.renderer();
                    self.rendererPerso();
                }).error(function() {
                    self.options.count[name] = 0;
                    self.rendererPerso();
                });
            } else {
                self.renderer();
                self.options.count[name] = 0;
                self.rendererPerso();
            }
        };
        Plugin.prototype.rendererPerso = function() {
            var shareCount = 0;
            var e;
            for (e in this.options.count) {
                shareCount++;
            }
            if (shareCount === this.options.shareTotal) {
                this.options.render(this, this.options);
            }
        };
        Plugin.prototype.renderer = function() {
            var total = this.options.total, template = this.options.template;
            if (this.options.shorterTotal === true) {
                total = this.shorterTotal(total);
            }
            if (template !== '') {
                template = template.replace('{total}', total);
                $(this.element).html(template);
            } else {
                $(this.element).html('<div class="box"><a class="count" href="#">' + total + '</a>' +
                        (this.options.title !== '' ? '<a class="share" href="#">' + this.options.title + '</a>' : '') + '</div>');
            }
            $(document).trigger("share-box-rendered");
        };
        Plugin.prototype.shorterTotal = function(num) {
            if (num >= 1e6) {
                num = (num / 1e6).toFixed(2) + "M"
            } else if (num >= 1e3) {
                num = (num / 1e3).toFixed(1) + "k"
            }
            return num;
        };
        Plugin.prototype.openPopup = function(site) {
            var _gaq = _gaq || [];
            popup[site](this.options);
            if (this.options.enableTracking === true) {
                var tracking = {googlePlus: {site: 'Google', action: '+1'}, facebook: {site: 'facebook', action: 'like'}, twitter: {site: 'twitter', action: 'tweet'}, digg: {site: 'digg', action: 'add'}, delicious: {site: 'delicious', action: 'add'}, stumbleupon: {site: 'stumbleupon', action: 'add'}, linkedin: {site: 'linkedin', action: 'share'}, pinterest: {site: 'pinterest', action: 'pin'}};
                _gaq.push(['_trackSocial', tracking[site].site, tracking[site].action]);
            }
        };
        Plugin.prototype.simulateClick = function() {
            var html = $(this.element).html();
            $(this.element).html(html.replace(this.options.total, this.options.total + 1));
        };
        Plugin.prototype.update = function(url, text) {
            if (url !== '') {
                this.options.url = url;
            }
            if (text !== '') {
                this.options.text = text;
            }
        };
        $.fn[pluginName] = function(options) {
            var args = arguments;
            if (options === undefined || typeof options === 'object') {
                return this.each(function() {
                    if (!$.data(this, 'plugin_' + pluginName)) {
                        $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
                    }
                });
            } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
                return this.each(function() {
                    var instance = $.data(this, 'plugin_' + pluginName);
                    if (instance instanceof Plugin && typeof instance[options] === 'function') {
                        instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                    }
                });
            }
        };
    })(jQuery, window, document);

    jQuery(document).ready(function($) {
        $('.bk-links-remember').click(function(e) {
            e.preventDefault();
            $(this).parents('.bk-form-wrapper').hide();
            $(this).parents('.bk-form-wrapper').siblings('.bk-remember-form-wrapper').fadeIn(500);
        });
        $('.bk-back-login').click(function(e) {
            e.preventDefault();
            if ($(this).parents('.bk-form-wrapper').hasClass('bk-remember-form-wrapper')) {
                $(this).parents('.bk-form-wrapper').siblings('.bk-register-form-wrapper').hide();
            } else if ($(this).parents('.bk-form-wrapper').hasClass('bk-register-form-wrapper')) {
                $(this).parents('.bk-form-wrapper').siblings('.bk-remember-form-wrapper').hide();
            }
            $(this).parents('.bk-form-wrapper').hide();
            $(this).parents('.bk-form-wrapper').siblings('.bk-login-form-wrapper').fadeIn(500);
        });

        $('.bk-links-register-inline').click(function(e) {
            e.preventDefault();
            $(this).parents('.bk-form-wrapper').hide();
            $(this).parents('.bk-form-wrapper').siblings('.bk-register-form-wrapper').fadeIn(500);
        });

        $(".price_slider_amount").css("opacity", "1");
        $("#main-mobile-menu").css("display", "block");
        $('#mobile-menu > ul > li.menu-item-has-children').prepend('<div class="expand"><i class="fa fa-chevron-down"></i></div>');
        $('#mobile-top-menu > ul > li.menu-item-has-children').prepend('<div class="expand"><i class="fa fa-chevron-down"></i></div>');
        $('.expand').click(function() {
            $(this).siblings('.sub-menu').toggle(300);
        });
        // display breaking module
        $('.module-breaking-carousel').removeClass('hide');
        $('.module-carousel').removeClass('hide');
        $('.single .article-content').fitVids();
        var bkWindowWidth = $(window).width(),
                bkWindowHeight = $(window).height();
        // Ajax search 
//        $('#ajax-form-search').click(function(){
//            if ($(this).siblings('.ajax-form').width() == 0){
//                $('.ajax-form input').css('width','220px');
//                $('.ajax-form').css('padding','0 54px 0 0');
//                $('.ajax-form input').css('padding','8px 12px');
//                $('.ajax-form input').css('font-size','16px'); 
//                $('.ajax-form input').val('');
//            } else {
//                $('.ajax-form input').css('width','0');
//                $('.ajax-form').css('padding','0');
//                $('.ajax-form input').css('padding','0');
//                $('.ajax-form input').css('font-size','0'); 
//                $('#ajax-search-result').empty().css('height', 'auto');
//                $('#ajax-search-result').css({'box-shadow' : 'none'});
//                $('.ajax-search-wrap').css({'width' : '0px'});
//            }
//            
//        });
//        
        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();

        $('#search-form-text').keyup(function() {
            var value = $(this).val();
            var $container = $('#ajax-search-result');
            if ($(window).width() > 511) {
                $('.ajax-search-wrap').css({'width': '350px'});
            } else {
                $('.ajax-search-wrap').css({'width': '300px'});
            }
            delay(function() {
                if (value) {
                    var search_class = $('#ajax-search-result');
                    search_class.fadeIn(300).html('<div class="loading-img-wrap"><div class="search-loadding"></div></div>');
                    var data = {
                        action: 'bk_ajax_search',
                        s: value
                    };
                    $.post(ajaxurl, data, function(response) {
                        response = $.parseJSON(response);
                        $('#ajax-search-result').empty().hide().css('height', 'auto').html(response.content).fadeIn(300).css('height', search_class.height());
                        delay(function() {
                            $($container).find('.thumb').removeClass('hide-thumb');
                            $($container).css({'box-shadow': '0px 1px 3px 1px rgba(0, 0, 0, 0.2)'});
                        }, 150);
                    });
                } else
                    $('#ajax-search-result').fadeOut(300, function() {
                        $(this).empty().css('height', 'auto');
                        $($container).css({'box-shadow': 'none'});
                    });

            }, 450);
        });
        // Breaking margin
        if ($('#page-content-wrap').children('.bksection:first-child').find('.bkmodule:first-child').hasClass('module-breaking-carousel') == true) {
            $('#page-content-wrap').css('margin-top', '0px');
        }
        /*** Light Box ***/
        $('.single-page').imagesLoaded(function() {
            if ($('.single-page').find('header').attr('id') != 'bk-nomal-feat') {
                var sHeaderHeight = $('.single-page').find('header').height();
                var iconPlayHeight = $('.icon-play').height();
                var iconTop = (sHeaderHeight - iconPlayHeight) / 2;
                $('.icon-play').css({'top': iconTop, 'opacity': '1'});
            } else {
                var sHeaderHeight = $('#bk-nomal-feat').height();
                var sFeatIngHeight = $('.s-feat-img').height();
                var iconPlayHeight = $('.icon-play').height();
                var FeatMarginTop = sHeaderHeight - sFeatIngHeight;
                var iconTop = (sFeatIngHeight - iconPlayHeight + FeatMarginTop) / 2;
                $('.icon-play').css({'top': iconTop, 'opacity': '1'});
            }
        });
        $('.img-popup-link').magnificPopup({
            type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            image: {
                verticalFit: true
            }
        });
        $('.video-popup-link').magnificPopup({
            closeBtnInside: false,
            fixedContentPos: true,
            disableOn: 700,
            type: 'iframe',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            preloader: false,
        });
        $.each(justified_ids, function(index, justified_id) {
            $(".justifiedgall_" + justified_id).justifiedGallery({
                rowHeight: 200,
                fixedHeight: false,
                lastRow: 'justify',
                margins: 4,
                randomize: false,
                sizeRangeSuffixes: {lt100: "", lt240: "", lt320: "", lt500: "", lt640: "", lt1024: ""},
            });
        });
        $('.zoom-gallery').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a.zoomer',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    verticalFit: true,
                    titleSrc: function(item) {
                        console.log(item.el[0]);
                        return ' <a class="image-source-link" href="' + item.el.attr('data-source') + '" target="_blank">' + item.el.attr('title') + '</a>';
                    }
                },
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                zoom: {
                    enabled: true,
                    duration: 600, // duration of the effect, in milliseconds
                    easing: 'ease', // CSS transition easing function
                    opener: function(element) {
                        return element.find('img');
                    }
                }
            });
        });
        $('#bk-gallery-slider').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a.zoomer',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                removalDelay: 300,
                //mainClass: 'mfp-with-zoom mfp-img-mobile',
                mainClass: 'mfp-fade',
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    verticalFit: true,
                    titleSrc: function(item) {
                        console.log(item.el[0]);
                        return ' <a class="image-source-link" href="' + item.src + '" target="_blank">' + item.el.attr('title') + '</a>';
                    }
                },
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                }
            });
        });
        // tiny helper function to add breakpoints
        function getGridSize() {
            return  (window.innerWidth < 500) ? 1 :
                    (window.innerWidth < 1000) ? 2 :
                    (window.innerWidth < 1170) ? 3 : 4;
        }
        $(window).resize(function() {
            if (typeof flexslider !== 'undefined') {
                var gridSize = getGridSize();
                flexslider.vars.minItems = gridSize;
                flexslider.vars.maxItems = gridSize;
            }
        });
        //FW Slider	
        $('.flexslider').imagesLoaded(function() {
            $('.bk-slider-module .flexslider').flexslider({
                animation: 'slide',
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                pauseOnHover: true,
                slideshowSpeed: 10000,
                animationSpeed: 1200,
                smoothHeight: true,
                directionNav: true,
                prevText: '',
                nextText: '',
            });
            //Feature 2 slider 
            $('.module-feature2 .flexslider').flexslider({
                animation: 'slide',
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                pauseOnHover: true,
                slideshowSpeed: 15000,
                animationSpeed: 1200,
                smoothHeight: true,
                directionNav: true,
                prevText: '',
                nextText: '',
            });
            //Widget Comment 
            $('.widget_comment').flexslider({
                animation: 'slide',
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                pauseOnHover: true,
                slideshowSpeed: 10000,
                animationSpeed: 1200,
                smoothHeight: true,
                directionNav: true,
                prevText: '',
                nextText: '',
            });
            // Twitter 
            $('.widget-twitter .flexslider').flexslider({
                animation: 'slide',
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                pauseOnHover: true,
                slideshowSpeed: 10000,
                animationSpeed: 1200,
                smoothHeight: true,
                directionNav: true,
                prevText: '',
                nextText: '',
            });
            // Widget Slider 
            $('.widget_slider .flexslider').flexslider({
                animation: 'slide',
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                pauseOnHover: true,
                slideshowSpeed: 8000,
                animationSpeed: 1200,
                smoothHeight: true,
                directionNav: true,
                prevText: '',
                nextText: '',
            });
            // Gallery Slider
            $('#bk-gallery-slider').flexslider({
                animation: 'slide',
                controlNav: true,
                animationLoop: true,
                slideshow: false,
                pauseOnHover: true,
                slideshowSpeed: 5000,
                animationSpeed: 600,
                smoothHeight: true,
                directionNav: true,
                prevText: '',
                nextText: '',
            });
            //Megamenu
            if (typeof (megamenu_carousel_el) !== 'undefined') {
                var bk_megamenu_item;
                $.each(megamenu_carousel_el, function(id, maxitems) {
                    bk_megamenu_item = $('#' + id).find('.bk-sub-post').length;
                    if (bk_megamenu_item >= maxitems) {
                        $('#' + id).flexslider({
                            animation: "slide",
                            animationLoop: true,
                            slideshow: false,
                            itemWidth: 10,
                            minItems: maxitems,
                            maxItems: maxitems,
                            controlNav: false,
                            directionNav: true,
                            slideshowSpeed: 3000,
                            prevText: '',
                            nextText: '',
                            move: 1,
                            touch: true,
                            useCSS: true,
                        });
                    } else {
                        //console.log(bk_megamenu_item);
                        //console.log(maxitems);
                        $('#' + id).removeClass('flexslider');
                        $('#' + id).addClass('flexslider_destroy');
                    }
                });
            }
            if ($('.product.flexslider ul li').length > 3) {
                $('.product.flexslider').flexslider({
                    animation: "slide",
                    animationLoop: false,
                    directionNav: true,
                    controlNav: false,
                    itemWidth: 50,
                    minItems: 1,
                    maxItems: 3,
                    prevText: '',
                    nextText: '',
                });
            } else {
                $('.product').removeClass('flexslider');
            }
        });
        waitForGallerySlider();
        // Breaking Slider 
        $('.module-breaking-carousel .bk-carousel-wrap').flexslider({
            animation: "slide",
            controlNav: false,
            itemWidth: 210,
            columnWidth: 1,
            pauseOnHover: true,
            move: 1,
            animationLoop: true,
            prevText: '',
            nextText: '',
            minItems: getGridSize(), // use function to pull in initial value
            maxItems: getGridSize(), // use function to pull in initial value
            start: function(slider) {
                if (typeof flexslider !== 'undefined') {
                    flexslider = slider;
                }
            }
        });
        // Module carousel
        $('.carousel_2 .bk-carousel-wrap').flexslider({
            animation: "slide",
            controlNav: false,
            itemWidth: 245,
            columnWidth: 1,
            pauseOnHover: true,
            move: 1,
            animationLoop: true,
            prevText: '',
            nextText: '',
            minItems: 1, // use function to pull in initial value
            maxItems: 2, // use function to pull in initial value
        });
        $('.carousel_3 .bk-carousel-wrap').flexslider({
            animation: "slide",
            controlNav: false,
            itemWidth: 245,
            columnWidth: 1,
            pauseOnHover: true,
            move: 1,
            animationLoop: true,
            prevText: '',
            nextText: '',
            minItems: 1, // use function to pull in initial value
            maxItems: 3, // use function to pull in initial value
        });
        // Masonry Module Init
        $('#page-wrap').imagesLoaded(function() {
            setTimeout(function() {
                if ($('.bk-masonry-content').find('.item').length > 2) {
                    $('.bk-masonry-content').masonry({
                        itemSelector: '.item',
                        columnWidth: 1,
                        isAnimated: true,
                        isFitWidth: true,
                    });
                }
                $('.ajax-load-btn').addClass('active');
                $('.bk-masonry-content').find('.post-c-wrap').removeClass('sink');
                $('.bk-masonry-content').find('.post-category').removeClass('sink');

            }, 500);
        });

        $('.menu-toggle').toggle(function() {
            $('.open-icon').removeClass('hide');
            $('.close-icon').addClass('hide');
            $('.share-label').addClass('hide');
            $('.top-share').removeClass('hide');

        }, function() {
            $('.close-icon').removeClass('hide');
            $('.open-icon').addClass('hide');
            $('.share-label').removeClass('hide');
            $('.top-share').addClass('hide');
        });

        // Back top
        $(window).scroll(function() {
            if ($(this).scrollTop() > 500) {
                $('#back-top').css('bottom', '0');
            } else {
                $('#back-top').css('bottom', '-34px');
            }
        });

        // scroll body to top on click
        $('#back-top').click(function() {
            $('body,html').animate({
                scrollTop: 0,
            }, 1300);
            return false;
        });
        if (fixed_nav == 2) {
            var nav = $('nav.main-nav');
            var d = nav.offset().top;
            $(window).scroll(function() {
                if ($(this).scrollTop() > d) {
                    nav.addClass("fixed");
                    //menu fixed if have admin bar
                    var ad_bar = $('#wpadminbar');
                    if (ad_bar.length != 0) {
                        $('.main-nav').css('margin-top', ad_bar.height());
                    }
                } else {
                    nav.removeClass("fixed");
                    $('.main-nav').css('margin-top', '0');
                }
            });
        }
        // Single Parallax
        var bkParallaxWrap = $('#bk-parallax-feat'),
                bkParallaxFeatImg = bkParallaxWrap.find('.s-feat-img');
        if (bkParallaxFeatImg.length !== 0) {
            $(window).scroll(function() {
                //console.log(bkParallaxFeatImg.offset().top);
                var bkBgy_p = -(($(window).scrollTop()) / 3.5),
                        bkBgPos = '50% ' + bkBgy_p + 'px';

                bkParallaxFeatImg.css("background-position", bkBgPos);

            });
        }
        //Rating canvas
        var canvasArray = $('.rating-canvas');
        $.each(canvasArray, function(i, canvas) {
            var percent = $(canvas).data('rating');
            var ctx = canvas.getContext('2d');

            canvas.width = $(canvas).parent().width();
            canvas.height = $(canvas).parent().height();

            var x = (canvas.width) / 2;
            var y = (canvas.height) / 2;
            if ($(canvas).parents().hasClass('review-score')) {
                var radius = (canvas.width - 6) / 2;
                var lineWidth = 2;
            } else {
                var radius = (canvas.width - 10) / 2;
                var lineWidth = 4;
            }

            var endAngle = (Math.PI * percent * 2 / 100);
            ctx.beginPath();
            ctx.arc(x, y, radius, -(Math.PI / 180 * 90), endAngle - (Math.PI / 180 * 90), false);
            ctx.lineWidth = lineWidth;
            ctx.strokeStyle = "#fff";
            ctx.stroke();
        });
        $(".bk-tipper-bottom").tipper({
            direction: "bottom"
        });


        // Calculate total shares
        var renders = 0;
        var share_items = $('.share-box').find('li').length;
        $(document).on('share-box-rendered', function() {
            renders++;
            if (renders == share_items) {
                var total_shares = 0;
                $('.share-box .share-item__value').each(function(i, e) {
                    var value = parseInt($(this).text());
                    if (!isNaN(value)) {
                        total_shares = total_shares + value;
                    }
                });
                if (total_shares >= 1e6) {
                    total_shares = (total_shares / 1e6).toFixed(2) + "M"
                } else if (total_shares >= 1e3) {
                    total_shares = (total_shares / 1e3).toFixed(1) + "k"
                }
                $('.share-total__value').html(total_shares);
            }
        });
        /* SHARE BOX BUTTONS (single only) */
        if ($('body.single').length) {
            shareBox();
        }
        /* Sidebar stick */
        var win, tick, curscroll, nextscroll;
        win = $(window);
        var width = $('.sidebar-wrap').width();
        tick = function() {
            nextscroll = win.scrollTop();
            $(".sidebar-wrap.stick").each(function() {
                var bottom_compare, top_compare, screen_scroll, parent_top, parent_h, parent_bottom, scroll_status = 0, topab;
                var sbID = "#" + $(this).attr(("id"));
                //var sbID = "#bk_sidebar_4";
                //console.log(sbID);
                bottom_compare = $(sbID).offset().top + $(sbID).outerHeight(true);
                screen_scroll = win.scrollTop() + win.height();
                parent_top = $(sbID).parents('.bksection').offset().top;
                parent_h = $(sbID).parents('.bksection').height();
                parent_bottom = parent_top + parent_h;
                if ($(sbID).parents('.bksection').hasClass('bk-in-single-page')) {
                    topab = parent_h - $(sbID).outerHeight(true) - 36;
                } else {
                    topab = parent_h - $(sbID).outerHeight(true);
                }

                if (window.innerWidth > 991) {
                    if (parent_h > $(sbID).outerHeight(true)) {
                        //console.log(win.scrollTop()  + "  " +  (parent_bottom - $(sbID).outerHeight(true)) + "   " + scroll_status);
                        if (win.scrollTop() < parent_top) {
                            scroll_status = 0;
                        } else if ((win.scrollTop() >= parent_top) && (screen_scroll < parent_bottom)) {
                            //console.log(curscroll+ "    "+nextscroll);
                            if (curscroll <= nextscroll) {
                                scroll_status = 1;
                            } else if (curscroll > nextscroll) {
                                scroll_status = 3;
                            }
                        } else if (screen_scroll >= parent_bottom) {
                            scroll_status = 2;
                        }
                        if (scroll_status == 0) {
                            $(sbID).css({
                                "position": "static",
                                "top": "auto",
                                "bottom": "auto"
                            });
                        } else if (scroll_status == 1) {
                            if (screen_scroll < bottom_compare) {
                                //console.log($(sbID).offset().top + "   " + parent_top);
                                if ($(sbID).parents('.bksection').hasClass('bk-in-single-page')) {
                                    topab = $(sbID).offset().top - parent_top - 36;
                                } else {
                                    topab = $(sbID).offset().top - parent_top;
                                }
                                $(sbID).css({
                                    "position": "absolute",
                                    "top": topab,
                                    "bottom": "auto",
                                    "width": width
                                });
                            } else {
                                $(sbID).css({
                                    "position": "fixed",
                                    "top": "auto",
                                    "bottom": "16px",
                                    "width": width
                                });
                            }
                        } else if (scroll_status == 3) {
                            if (win.scrollTop() > ($(sbID).offset().top)) {
                                if ($(sbID).parents('.bksection').hasClass('bk-in-single-page')) {
                                    topab = $(sbID).offset().top - parent_top - 36;
                                } else {
                                    topab = $(sbID).offset().top - parent_top;
                                }
                                $(sbID).css({
                                    "position": "absolute",
                                    "top": topab,
                                    "bottom": "auto",
                                    "width": width
                                });
                            } else {
                                var ad_bar = $('#wpadminbar');
                                if (fixed_nav == 2) {
                                    if (ad_bar.length != 0) {
                                        var sb_height_fixed = 16 + ad_bar.height() + $('.main-nav').height() + 'px';
                                    }
                                    else {
                                        var sb_height_fixed = 16 + $('.main-nav').height() + 'px';
                                    }

                                } else {
                                    if (ad_bar.length != 0) {
                                        var sb_height_fixed = 16 + ad_bar.height() + 'px';
                                    } else {
                                        var sb_height_fixed = 16 + 'px';
                                    }
                                }
                                $(sbID).css({
                                    "position": "fixed",
                                    "top": sb_height_fixed,
                                    "bottom": "auto",
                                    "width": width
                                });
                            }
                        } else if (scroll_status == 2) {
                            $(sbID).css({
                                "position": "absolute",
                                "top": topab,
                                "bottom": "auto",
                                "width": width
                            });
                        }
                    }
                }
            });
            curscroll = nextscroll;
        }
        $(".sidebar-wrap.stick").each(function() {
            $(this).wrap("<div class='bk-sticksb-wrapper'></div>");
        });
        delay(function() {
            win.on("scroll", tick);
        }, 2000);
        win.resize(function() {
            $(".sidebar-wrap.stick").each(function() {
                var sbID = "#" + $(this).attr(("id"));
                if (window.innerWidth > 991) {
                    if ($(this).parent().hasClass('bk-sticksb-wrapper')) {
                        width = $('.bk-sticksb-wrapper').width();
                        $(sbID).css({
                            "width": width
                        });
                    }
                } else {
                    $(sbID).css({
                        "position": "static",
                        "top": "auto",
                        "bottom": "auto"
                    });
                }
            });
        });
        //Short Code 
        $('.module-shortcode').fitVids();
        $('.bk_accordions').each(function() {
            var accordions_id = $(this).attr('id');
            if (accordions_id) {
                $('#' + accordions_id).accordion({
                    icons: {'header': 'ui-icon-plus sprites', 'activeHeader': 'ui-icon-minus sprites'},
                    collapsible: true
                });
            }
        });
        $('.bk_tabs').each(function() {
            var tabs_id = $(this).attr('id');
            if (tabs_id) {
                $('#' + tabs_id).tabs();
            }
        });

        // Parallax
        // Single Parallax
        var bkscParallax = $('.bkparallaxsc');
        var bkscParallaxImg = new Array();
        $.each(bkscParallax, function(index, value) {
            bkscParallaxImg[index] = $(this).find('.parallaximage');
        });
        $(window).scroll(function() {
            $.each(bkscParallaxImg, function(index, value) {
                if (bkscParallaxImg[index].length !== 0) {
                    //console.log(bkscParallaxImg.offset().top);
                    var bkBgy_p = -(($(window).scrollTop() - bkscParallaxImg[index].offset().top) / 3.5),
                            bkBgPos = '50% ' + bkBgy_p + 'px';
                    bkscParallaxImg[index].css("background-position", bkBgPos);
                }
            });
        });
    });
    function shareBox() {
        $('#twitter').sharrre({
            share: {
                twitter: true
            },
            template: '<div class="share-item__icon"><i class="fa fa-twitter " title="Twitter"></i></div>',//<div class="share-item__value">{total}</div>',
            enableHover: false,
            enableTracking: true,
            click: function(api, options) {
                api.simulateClick();
                api.openPopup('twitter');
            }
        });
        $('#facebook').sharrre({
            share: {
                facebook: true
            },
            template: '<div class="share-item__icon"><i class="fa fa-facebook " title="Facebook"></i></div>',//<div class="share-item__value">{total}</div>',
            enableHover: false,
            enableTracking: true,
            click: function(api, options) {
                api.simulateClick();
                api.openPopup('facebook');
            }
        });
        $('#gplus').sharrre({
            share: {
                googlePlus: true
            },
            urlCurl: '',
            template: '<div class="share-item__icon"><i class="fa fa-google-plus " title="Google Plus"></i></div>',//<div class="share-item__value">{total}</div>',
            enableHover: false,
            enableTracking: true,
            click: function(api, options) {
                api.simulateClick();
                api.openPopup('googlePlus');
            }
        });
        $('#pinterest').sharrre({
            share: {
                pinterest: true
            },
            template: '<div class="share-item__icon"><i class="fa fa-pinterest " title="Pinterest"></i></div>',//<div class="share-item__value">{total}</div>',
            enableHover: false,
            enableTracking: true,
            click: function(api, options) {
                api.simulateClick();
                api.openPopup('pinterest');
            },
            buttons: {
                pinterest: {
                    media: bkgetFeatureImage(),
                    description: $('#pinterest').data('text')
                }
            }
        });
        $('#stumbleupon').sharrre({
            share: {
                stumbleupon: true
            },
            urlCurl: '',
            template: '<div class="share-item__icon"><i class="fa fa-stumbleupon " title="Stumbleupon"></i></div>',//<div class="share-item__value">{total}</div>',
            enableHover: false,
            enableTracking: true,
            click: function(api, options) {
                api.simulateClick();
                api.openPopup('stumbleupon');
            }
        });
        $('#linkedin').sharrre({
            share: {
                linkedin: true
            },
            template: '<div class="share-item__icon"><i class="fa fa-linkedin " title="Linkedin"></i></div>',//<div class="share-item__value">{total}</div>',
            enableHover: false,
            enableTracking: true,
            click: function(api, options) {
                api.simulateClick();
                api.openPopup('linkedin');
            }
        });
    }

    function bkgetFeatureImage() {
        var metas = document.getElementsByTagName('meta');
        var i;
        for (i = 0; i < metas.length; i++) {
            if (metas[i].getAttribute("property") == "og:image") {
                return metas[i].getAttribute("content");
            } else if (metas[i].getAttribute("property") == "image") {
                return metas[i].getAttribute("content");
            } else if (metas[i].getAttribute("property") == "twitter:image:src") {
                return metas[i].getAttribute("content");
            }
        }

        return "";
    }

    function waitForGallerySlider() {
        // if slider is loaded
        if ($("#bk-gallery-slider").children('div:first').hasClass('flex-viewport')) {
            $(".bk-gallery-item").each(function() {
                if ($(this).hasClass('clone')) {
                    $(this).children('a').removeClass('zoomer');
                }
            });
            return false;
        }
        else
        {
            // Wait another 0,5 seconds
            setTimeout(waitForGallerySlider, 500);
        }
    }
})(jQuery);