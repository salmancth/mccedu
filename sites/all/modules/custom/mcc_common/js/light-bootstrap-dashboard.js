/*!
 
 =========================================================
 * Light Bootstrap Dashboard - v1.3.1.0
 =========================================================
 
 * Product Page: http://www.creative-tim.com/product/light-bootstrap-dashboard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE.md)
 
 =========================================================
 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 
 */

var searchVisible = 0;
var transparent = true;

var transparentDemo = true;
var fixedTop = false;

var navbar_initialized = false;

jQuery(document).ready(function() {
    window_width = jQuery(window).width();

    // check if there is an image set for the sidebar's background
    lbd.checkSidebarImage();

    // Init navigation toggle for small screens   
    if (window_width <= 991) {
        lbd.initRightMenu();
    }

    //  Activate the tooltips   
    //jQuery('[rel="tooltip"]').tooltip();

    //      Activate the switches with icons 
    if (jQuery('.switch').length != 0) {
        jQuery('.switch')['bootstrapSwitch']();
    }
    //      Activate regular switches
    if (jQuery("[data-toggle='switch']").length != 0) {
        jQuery("[data-toggle='switch']").wrap('<div class="switch" />').parent().bootstrapSwitch();
    }

    jQuery('.form-control').on("focus", function() {
        jQuery(this).parent('.input-group').addClass("input-group-focus");
    }).on("blur", function() {
        jQuery(this).parent(".input-group").removeClass("input-group-focus");
    });

});

// activate collapse right menu when the windows is resized 
jQuery(window).resize(function() {
    if (jQuery(window).width() <= 991) {
        lbd.initRightMenu();
    }
});

lbd = {
    misc: {
        navbar_menu_visible: 0
    },
    checkSidebarImage: function() {
        $sidebar = jQuery('.sidebar');
        image_src = $sidebar.data('image');

        if (image_src !== undefined) {
            sidebar_container = '<div class="sidebar-background" style="background-image: url(' + image_src + ') "/>'
            $sidebar.append(sidebar_container);
        }
    },
    initRightMenu: function() {
        if (!navbar_initialized) {
            $navbar = jQuery('nav').find('.navbar-collapse').first().clone(true);

            $sidebar = jQuery('.sidebar');
            sidebar_color = $sidebar.data('color');

            $logo = $sidebar.find('.logo').first();
            logo_content = $logo[0].outerHTML;

            ul_content = '';

            $navbar.attr('data-color', sidebar_color);

            // add the content from the sidebar to the right menu
            content_buff = $sidebar.find('.nav').html();
            ul_content = ul_content + content_buff;

            //add the content from the regular header to the right menu
            $navbar.children('ul').each(function() {
                content_buff = jQuery(this).html();
                ul_content = ul_content + content_buff;
            });

            ul_content = '<ul class="nav navbar-nav">' + ul_content + '</ul>';

            navbar_content = logo_content + ul_content;

            $navbar.html(navbar_content);

            jQuery('body').append($navbar);

            background_image = $sidebar.data('image');
            if (background_image != undefined) {
                $navbar.css('background', "url('" + background_image + "')")
                        .removeAttr('data-nav-image')
                        .addClass('has-image');
            }


            $toggle = jQuery('.navbar-toggle');

            $navbar.find('a').removeClass('btn btn-round btn-default');
            $navbar.find('button').removeClass('btn-round btn-fill btn-info btn-primary btn-success btn-danger btn-warning btn-neutral');
            $navbar.find('button').addClass('btn-simple btn-block');

            $toggle.click(function() {
                if (lbd.misc.navbar_menu_visible == 1) {
                    jQuery('html').removeClass('nav-open');
                    lbd.misc.navbar_menu_visible = 0;
                    jQuery('#bodyClick').remove();
                    setTimeout(function() {
                        $toggle.removeClass('toggled');
                    }, 400);

                } else {
                    setTimeout(function() {
                        $toggle.addClass('toggled');
                    }, 430);

                    div = '<div id="bodyClick"></div>';
                    jQuery(div).appendTo("body").click(function() {
                        jQuery('html').removeClass('nav-open');
                        lbd.misc.navbar_menu_visible = 0;
                        jQuery('#bodyClick').remove();
                        setTimeout(function() {
                            $toggle.removeClass('toggled');
                        }, 400);
                    });

                    jQuery('html').addClass('nav-open');
                    lbd.misc.navbar_menu_visible = 1;

                }
            });
            navbar_initialized = true;
        }

    }
}


// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            timeout = null;
            if (!immediate)
                func.apply(context, args);
        }, wait);
        if (immediate && !timeout)
            func.apply(context, args);
    };
}
;


function mailManpower(el) {
    var mailTo = jQuery("#email-to-send").val();
    var mailMessage = jQuery("#custom-message").val();
    var mailSubject = jQuery("#subject-to-send").val();
    jQuery("#email-to-send").val('');
    jQuery("textarea#custom-message").val('');
    jQuery("#subject-to-send").val('');
    if (mailTo) {
        jQuery('input[type="button"]').prop('disabled', true);
        jQuery('.mail-sending').css('display', 'block');
        var dataString = 'mail-to-address=' + encodeURIComponent(mailTo) + '&custom-message=' + encodeURIComponent(mailMessage)
                + '&mail-subject=' + encodeURIComponent(mailSubject);
        jQuery.ajax({
            type: "POST",
            url: "/mcc-manpower-mail-send",
            data: dataString,
            cache: false,
            success: function(result) {
                jQuery('input[type="button"]').prop('disabled', false);
                jQuery('.mail-sending').css('display', 'none');
                alert(result.value);
            }
        });
    }
}

(function($) {
    if (jQuery('ul.dept-tabs').length) {
        $("ul.dept-tabs li").on("click", function() {
            if ($(this).attr("id")) {
                var a_href = $(this).find('a').attr('href');
                if (a_href) {
                    parent.location.hash = a_href;
                }
            }
        });
    }

    $(window).load(function()
    {
        var destination_section = location.hash;
        //console.log('pp-'.destination_section);
        if (destination_section) {
            if (jQuery('ul.dept-tabs').length) {
                jQuery('ul.dept-tabs li').removeClass("active");
                jQuery('ul.dept-tabs li' + destination_section + '-li').addClass("active");
                jQuery('div.tab-content div.tab-pane').removeClass("active");
                jQuery('div.tab-content div.tab-pane').removeClass("in");
                jQuery('div.tab-content div' + destination_section).addClass("active");
                jQuery('div.tab-content div' + destination_section).addClass("in");
            }
        }
    });
})(jQuery);
