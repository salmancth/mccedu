/*jslint browser: true*/
/*global $, jQuery, alert*/

jQuery(document).ready(function($) {

    "use strict";

    var body = $("body");

    $(function() {
        $(".preloader").fadeOut();
        $('#side-menu').metisMenu();
    });

    /* ===== Open-Close Right Sidebar ===== */

    $(".right-side-toggle").on("click", function() {
        $(".right-sidebar").slideDown(50).toggleClass("shw-rside");
        $(".fxhdr").on("click", function() {
            body.toggleClass("fix-header"); /* Fix Header JS */
        });
        $(".fxsdr").on("click", function() {
            body.toggleClass("fix-sidebar"); /* Fix Sidebar JS */
        });

        /* ===== Service Panel JS ===== */

        var fxhdr = $('.fxhdr');
        if (body.hasClass("fix-header")) {
            fxhdr.attr('checked', true);
        } else {
            fxhdr.attr('checked', false);
        }
        if (body.hasClass("fix-sidebar")) {
            fxhdr.attr('checked', true);
        } else {
            fxhdr.attr('checked', false);
        }
    });

    /* ===========================================================
     Loads the correct sidebar on window load.
     collapses the sidebar on window resize.
     Sets the min-height of #page-wrapper to window size.
     =========================================================== */

    $(function() {
        var set = function() {
            var topOffset = 136,
                    width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width,
                    height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
            if (width < 768) {
                $('div.navbar-collapse').addClass('collapse');
                topOffset = 100; /* 2-row-menu */
            } else {
                $('div.navbar-collapse').removeClass('collapse');
            }

            /* ===== This is for resizing window ===== */

            if (width < 1170) {
                body.addClass('content-wrapper');
                $(".open-close i").removeClass('icon-arrow-left-circle');
                $(".sidebar").css("overflow", "inherit").parent().css("overflow", "visible");
            } else {
                body.removeClass('content-wrapper');
                $(".open-close i").addClass('icon-arrow-left-circle');
            }

            height = height - topOffset;
            if (height < 1) {
                height = 1;
            }
            if (height > topOffset) {
                $("#page-wrapper").css("min-height", (height) + "px");
            }
        },
                url = window.location,
                element = $('ul.nav a').filter(function() {
            return this.href === url || url.href.indexOf(this.href) === 0;
        }).addClass('active').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('active');
        }
        $(window).ready(set);
        $(window).on("resize", set);
    });

    /* ===================================================
     This is for click on open close button
     Sidebar open close
     =================================================== */

    $(".open-close").on('click', function() {
        if ($("body").hasClass("content-wrapper")) {
            $("body").trigger("resize");
            $(".sidebar-nav, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible");
            $("body").removeClass("content-wrapper");
            $(".open-close i").addClass("icon-arrow-left-circle");
            $(".logo span").show();
        } else {
            $("body").trigger("resize");
            $(".sidebar-nav, .slimScrollDiv").css("overflow", "inherit").parent().css("overflow", "visible");
            $("body").addClass("content-wrapper");
            $(".open-close i").removeClass("icon-arrow-left-circle");
            $(".logo span").hide();
        }
    });

    /* ===== Collapsible Panels JS ===== */

    (function($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]',
                panelRemover = '[data-perform="panel-dismiss"]';
        $(panelSelector).each(function() {
            var collapseOpts = {
                toggle: false
            },
            parent = $(this).closest('.panel'),
                    wrapper = parent.find('.panel-wrapper'),
                    child = $(this).children('i');
            if (!wrapper.length) {
                wrapper = parent.children('.panel-heading').nextAll().wrapAll('<div/>').parent().addClass('panel-wrapper');
                collapseOpts = {};
            }
            wrapper.collapse(collapseOpts).on('hide.bs.collapse', function() {
                child.removeClass('ti-minus').addClass('ti-plus');
            }).on('show.bs.collapse', function() {
                child.removeClass('ti-plus').addClass('ti-minus');
            });
        });

        /* ===== Collapse Panels ===== */

        $(document).on('click', panelSelector, function(e) {
            e.preventDefault();
            var parent = $(this).closest('.panel'),
                    wrapper = parent.find('.panel-wrapper');
            wrapper.collapse('toggle');
        });

        /* ===== Remove Panels ===== */

        $(document).on('click', panelRemover, function(e) {
            e.preventDefault();
            var removeParent = $(this).closest('.panel');

            function removeElement() {
                var col = removeParent.parent();
                removeParent.remove();
                col.filter(function() {
                    return ($(this).is('[class*="col-"]') && $(this).children('*').length === 0);
                }).remove();
            }
            removeElement();
        });
    }(jQuery, window, document));

    /* ===== Tooltip Initialization ===== */

    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    /* ===== Popover Initialization ===== */

    $(function() {
        $('[data-toggle="popover"]').popover();
    });

    /* ===== Task Initialization ===== */

    $(".list-task li label").on("click", function() {
        $(this).toggleClass("task-done");
    });
    $(".settings_box a").on("click", function() {
        $("ul.theme_color").toggleClass("theme_block");
    });

    /* ===== Collepsible Toggle ===== */

    $(".collapseble").on("click", function() {
        $(".collapseblebox").fadeToggle(350);
    });

    /* ===== Sidebar ===== */

    $('.slimscrollright').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'
    });

    $('.chat-list').slimScroll({
        height: '100%',
        position: 'right',
        size: "0px",
        color: '#dcdcdc'
    });

    /* ===== Resize all elements ===== */

    body.trigger("resize");

    /* ===== Visited ul li ===== */

    $('.visited li a').on("click", function(e) {
        $('.visited li').removeClass('active');
        var $parent = $(this).parent();
        if (!$parent.hasClass('active')) {
            $parent.addClass('active');
        }
        e.preventDefault();
    });

    /* ===== Login and Recover Password ===== */

    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });

    /* ================================================================= 
     Update 1.5
     this is for close icon when navigation open in mobile view
     ================================================================= */

    $(".navbar-toggle").on("click", function() {
        $(".navbar-toggle i").toggleClass("ti-menu").addClass("ti-close");
    });

    if ($('#module_content_list-table').length) {
        var table = $('#module_content_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
//      "columnDefs": [
//        {targets: [0], orderable: true},
//        {targets: '_all', orderable: false},
//        {targets: [0], className: "mcc_click_col"}
//      ],
            "select": true
        });
    }
    if ($('#materials_list-table').length) {
        var table = $('#materials_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
//      "columnDefs": [
//        {targets: [0], orderable: true},
//        {targets: '_all', orderable: false},
//        {targets: [0], className: "mcc_click_col"}
//      ],
            "select": true
        });
    }
    if ($('#audio_video_list-table').length) {
        var table = $('#audio_video_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
//      "columnDefs": [
//        {targets: [0], orderable: true},
//        {targets: '_all', orderable: false},
//        {targets: [0], className: "mcc_click_col"}
//      ],
            "select": true
        });
    }

    if ($('#uploaded_qb_list-table').length) {
        var table = $('#uploaded_qb_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
            "select": true
        });
    }
    if ($('#course_url_list-table').length) {
        var table = $('#course_url_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
            "select": true
        });
    }
    if ($('#completed_registration_list-table').length) {
        var table = $('#completed_registration_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
            "select": true
        });
    }
    if ($('#faculty_courses_list-table').length) {
        var table = $('#faculty_courses_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
            "select": true
        });
    }
    if ($('#registered_courses_list-table').length) {
        var table = $('#registered_courses_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
            "select": true
        });
    }
    if ($('#courses_result_list-table').length) {
        var table = $('#courses_result_list-table').DataTable({
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "processing": true,
            "orderCellsTop": true,
            "select": true
        });
    }
});

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
                jQuery('ul.dept-tabs li a').removeClass("active");
                jQuery('ul.dept-tabs li a' + destination_section + '-li').addClass("active");
                jQuery('div.tab-content div.tab-pane').removeClass("active");
                jQuery('div.tab-content div.tab-pane').removeClass("in");
                jQuery('div.tab-content div.tab-pane').removeClass("show");
                jQuery('div.tab-content div' + destination_section).addClass("active");
                jQuery('div.tab-content div' + destination_section).addClass("in");
                jQuery('div.tab-content div' + destination_section).addClass("show");
            }
        }
    });
})(jQuery);

function collapseNavbar() {
    if (jQuery(window).scrollTop() > 30) {
        jQuery("#wrapper").addClass("fix-top");
    } else {
        jQuery("#wrapper").removeClass("fix-top");
    }
}
jQuery(window).scroll(collapseNavbar);
jQuery(document).ready(collapseNavbar);
