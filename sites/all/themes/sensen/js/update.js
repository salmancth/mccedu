var megamenu_carousel_el = {"bk-carousel-351": "3"};
var megamenu_carousel_el = {"bk-carousel-351": "3", "bk-carousel-167": "3"};
var megamenu_carousel_el = {"bk-carousel-351": "3", "bk-carousel-167": "3", "bk-carousel-569": "4"};
var justified_ids = [];
var fixed_nav = "1";
var customconfig = null;
var path = Drupal.settings.pathToTheme;


(function($) {
    $(function() {

//        jQuery(".shop-page article.product >form").attr("class",'woocommerce-ordering');
//jQuery(".shop-page article.product >form select").attr("class",'orderby');

        var $switch = $('.style-selector .switch');

        var toggle_switcher = function(status) {
            if (status == 'open') {
                // open
                $('.style-selector').css('left', '0');
                $switch.attr('status', 'open');
            } else {
                // close
                $('.style-selector').css('left', '-225px');
                $switch.attr('status', 'closed');
            }
        }
        $switch.click(function() {
            if ($switch.attr('status') == 'closed') {
                toggle_switcher('open');
            } else {
                toggle_switcher('closed');
            }
        });
        $('#site_layout').change(function() {
            if ($('#site_layout option:selected').text() == 'Wide') {
                $('#page-wrap').removeClass('boxed');
                $('#page-wrap').addClass('wide');
                $('body').attr('style', 'background-image: none');
                //$('#page-wrap').attr('style','width: auto');
            } else {
                $('#page-wrap').removeClass('wide');
                $('#page-wrap').addClass('boxed');
                var url_bg = $('body').attr('data-bg');
                $('body').css({'background-image': 'url(' + url_bg + ')', 'background-position': 'center bottom', 'background-repeat': 'no-repeat', 'background-size': 'cover', 'background-attachment': 'fixed'});
                //$('#page-wrap').attr('style','width: 1170px');
            }
        })

        $('#logo_position').change(function() {
            if ($('#logo_position option:selected').text() == 'Left Logo') {
                $('.header-inner').removeClass('header-center');
            } else {
                $('.header-inner').addClass('header-center');
            }
        })
        $('#menu_scheme').change(function() {
            if ($('#menu_scheme option:selected').text() == 'Dark Menu') {
                $('.main-nav').removeClass('bk-menu-light');
                $('.top-bar').removeClass('bk-menu-light');
            } else {
                $('.main-nav').addClass('bk-menu-light');
                $('.top-bar').addClass('bk-menu-light');
            }
        })
        $('.color-small-box').click(function() {
            if ($(this).hasClass('selected'))
                return;

            $(this).siblings().removeClass('selected');
            $(this).toggleClass('selected');
        });

        $(".color-small-box").click(function() {
            var data_skin = $(this).attr('data-file');
            $('#skins-color').removeAttr("href");
            $('#skins-color').attr('href', path + '/css/skins/' + data_skin);
        });
//        $('.primary-color-option .color-small-box').click(function() {
//            var value = $(this).data('color');
//            var template = $('#primary-color-option-template').val();
//            template = template.replace(/##VAL##/g, value);
//            $('#primary-color-option').text(template);
//        });
//        $('.secondary-color-option .color-small-box').click(function() {
//            var value = $(this).data('color');
//            var template = $('#secondary-color-option-template').val();
//            template = template.replace(/##VAL##/g, value);
//            $('#secondary-color-option').text(template);
//        });
    });



    jQuery(document).ready(function() {
        jQuery(".ajax-search-wrap form").attr("class", "ajax-form");

        jQuery(".main-nav #main-menu ul.menu >li >ul").removeClass("sub-menu");
        jQuery(".main-nav #main-menu ul.menu >li >ul").attr("class", "bk");
        jQuery(".main-nav #main-menu ul.menu >li >ul li ul").removeClass("sub-menu");
        jQuery(".main-nav #main-menu ul.menu >li >ul li ul").addClass("bk-sub-sub-menu");
        jQuery(".main-nav .menu > li>a.active").parent("li").addClass("active-trail");

        jQuery(".main-nav ul.menu >li.current-menu-ancestor ").each(function(index, el) {
            var html_child_menu = '<div class="bk-mega-column-menu"><div class="bk-sub-menu-wrap"><ul class="bk-sub-menu clearfix">';
            var link_child_menu = jQuery(this).find('.bk').html();
            html_child_menu += link_child_menu;

            html_child_menu += '</ul></div></div>';
            jQuery(this).find('.bk').html(html_child_menu);
        });

        jQuery(".main-nav ul.menu >li.dropdown ").each(function(index, el) {
            var html_child_menu = '<div class="bk-dropdown-menu"><div class="bk-sub-menu-wrap"><ul class="bk-sub-menu clearfix">';
            var link_child_menu = jQuery(this).find('.bk').html();
            html_child_menu += link_child_menu;

            html_child_menu += '</ul></div></div>';
            jQuery(this).find('.bk').html(html_child_menu);
        });



//seacher update js       
        jQuery('form.ajax-form input[type=submit]').hide();

        jQuery('#ajax-form-search').click(function() {

            if (jQuery('.ajax-form').width() == 0) {
                jQuery('.ajax-form input').css('width', '220px');
                jQuery('.ajax-form').css('padding', '0 54px 0 0');
                jQuery('.ajax-form input').css('padding', '8px 12px');
                jQuery('.ajax-form input').css('font-size', '16px');
                //jQuery('.ajax-form input').val('');

            } else {
                jQuery('.ajax-form input').css('width', '0');
                jQuery('.ajax-form').css('padding', '0');
                jQuery('.ajax-form input').css('padding', '0');
                jQuery('.ajax-form input').css('font-size', '0');
                jQuery('#ajax-search-result').empty().css('height', 'auto');
                jQuery('#ajax-search-result').css({'box-shadow': 'none'});
                jQuery('.ajax-search-wrap').css({'width': '0px'});

            }

        });
//comment js update
        jQuery('#comments  form label').hide();
        jQuery("#comments  form input[name=name]").attr('placeholder', 'Name*...');
        jQuery('#comments  form input[name=mail]').attr('placeholder', 'Mail*...');
        jQuery("#comments form input[name=homepage]").attr('placeholder', 'Website...');
        jQuery('#comments form textarea').attr('placeholder', 'Comment...');

//404 page js update

        jQuery("#bk-404-wrap .search form > div").addClass("searchform-wrap");
//jQuery("#bk-404-wrap .search form div.form-item input[type=text]").attr('name','s');
        jQuery("#bk-404-wrap .search form div.form-item input[type=text]").attr('id', 's');
        jQuery("#bk-404-wrap .search form div.form-actions").addClass("search-icon");
        jQuery("#bk-404-wrap .search form input[type=submit]").addClass("fa fa-search");
        jQuery('#bk-404-wrap .search form input[type=submit]').removeAttr('value');
        jQuery('#bk-404-wrap .search form input[type=submit]').attr('value', '');

        jQuery('<i class="fa fa-search"></i>').insertBefore('#bk-404-wrap .search form input[type=submit]');


        //jQuery('.bk_small_cart .line-item-summary span.line-item-quantity-label').remove();

//update style of background
        jQuery('div[data-type=background]').each(function() {
            //  url_img = "huyen";
            var url_img = 'url(' + jQuery(this).find('>img').attr('src') + ')';
            jQuery(this).css("background-image", url_img);
            jQuery(this).find('>img').hide();
        });

        //    update shop-page

//add first, last in list product
        var product_number = jQuery('.woocommerce-page ul.products li.product').length;
        var j = 1;
        for (var i = 1; i < product_number; ) {

            jQuery('.woocommerce-page ul.products li.product:nth-of-type(' + i + ')').addClass('first');
            i = i + 3;
        }
        product_number = product_number / 3;
        for (var i = 1; i < product_number; ) {
            j = i * 3;
            jQuery('.woocommerce-page ul.products li.product:nth-of-type(' + j + ')').addClass('last');

            i++;
        }

//        jQuery(".mcc_org_unit").change(function() {
//            var val = $(".mcc_org_unit option:selected").text();
//            if (val == "Federal Unit") {
//                $(".mcc_org_level").html("<option value='Member'>Member</option><option value='Other'>Other</option>");
//            } else {
//                $(".mcc_org_level").html("<option value='Associate Member'>Associate Member</option>");
//            }
//        });
        var trim = function(str)
        {
            return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g, '');
        };

        var hasClass = function(el, cn)
        {
            return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
        };

        var addClass = function(el, cn)
        {
            if (!hasClass(el, cn)) {
                el.className = (el.className === '') ? cn : el.className + ' ' + cn;
            }
        };

        var removeClass = function(el, cn)
        {
            el.className = trim((' ' + el.className + ' ').replace(' ' + cn + ' ', ' '));
        };

        var hasParent = function(el, id)
        {
            if (el) {
                do {
                    if (el.id === id) {
                        return true;
                    }
                    if (el.nodeType === 9) {
                        break;
                    }
                }
                while ((el = el.parentNode));
            }
            return false;
        };

        // normalize vendor prefixes

        var doc = document.documentElement;

        var transform_prop = window.Modernizr.prefixed('transform'),
                transition_prop = window.Modernizr.prefixed('transition'),
                transition_end = (function() {
                    var props = {
                        'WebkitTransition': 'webkitTransitionEnd',
                        'MozTransition': 'transitionend',
                        'OTransition': 'oTransitionEnd otransitionend',
                        'msTransition': 'MSTransitionEnd',
                        'transition': 'transitionend'
                    };
                    return props.hasOwnProperty(transition_prop) ? props[transition_prop] : false;
                })();

        window.App = (function()
        {

            var _init = false, app = {};

            app.init = function()
            {
                if (_init) {
                    return;
                }
                _init = true;

                addClass(doc, 'js-ready');

            };

            return app;

        })();
        var pagecontainer = document.getElementById('page-inner-wrap');
        if (window.addEventListener) {
            window.addEventListener('DOMContentLoaded', window.App.init, false);
        }
        jQuery('a#nav-open-btn').on('click', function() {
            jQuery(pagecontainer).find('.page-cover').css({"opacity": "0.5", "display": "block"});
            addClass(doc, 'js-nav');
        });

        jQuery('.mobile-menu-close').on('click', function() {
            jQuery(pagecontainer).find('.page-cover').css({"opacity": "0.5", "display": "none"});
            removeClass(doc, 'js-nav');
        });

    });


    jQuery('.woocommerce-tabs form div.form-item-homepage').hide();
//    jQuery('.woocommerce-product-rating form input[type=submit] ').attr('placeholder','SUBMIT');
    jQuery(".bk_small_cart aside.widget_shopping_cart div").removeClass("cart-contents");       

})(jQuery);