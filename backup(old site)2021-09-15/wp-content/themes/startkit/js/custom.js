(function($) {
    "use strict";
	jQuery(document).ready(function() {
		
        /* --------------------------------------
            Scroll UP
        -------------------------------------- */

        jQuery(window).on('scroll', function() {
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        });

        jQuery('.scrollup').on('click', function() {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });

        // Search
        var changeClass = function(name) {
            $('#search').removeAttr('class').addClass(name);
        }

        /*------------------------------------
            Sticky Menu 
        --------------------------------------*/
        var windows = $(window);
        var stick = $(".header-sticky");
        windows.on('scroll', function() {
            var scroll = windows.scrollTop();
            if (scroll < 10) {
                stick.removeClass("sticky");
            } else {
                stick.addClass("sticky");
            }
        });
        /*------------------------------------
            jQuery MeanMenu 
        --------------------------------------*/
		
		jQuery('.mobile-menu-active').meanmenu({
            meanScreenWidth: "991",
            meanMenuContainer: '.mobile-menu'
        });

        /* last  2 li child add class */
        jQuery('ul.menu > li').slice(-2).addClass('last-elements');
	});



    jQuery(window).on('load', function() {

        // Sticky Nav
        jQuery(".sticky-nav").sticky({ topSpacing: 0 });

    });
	
	// Add/Remove .focus class for accessibility
	jQuery('.navbar-area').find( 'a' ).on( 'focus blur', function() {
		jQuery( this ).parents( 'ul, li' ).toggleClass( 'focus' );
	} );
}(jQuery));