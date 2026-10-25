(function ($) {
    "use strict";
    
    // Cache the selectors for better performance
    var $window = $(window);
    var $scrollToTop = $(".scroll-to-top");

    // Ensure the button is hidden initially using JavaScript
    $scrollToTop.hide();

    // Function to toggle the visibility of the scroll-to-top button
    function toggleScrollToTop() {
        if ($window.scrollTop() > 200) {
            $scrollToTop.fadeIn();
        } else {
            $scrollToTop.fadeOut();
        }
    }

    // Function to check if the Customizer is active and show the button
    function checkCustomizer() {
        if (typeof wp !== 'undefined' && wp.customize && wp.customize.preview) {
            $scrollToTop.fadeIn();
            return true;
        }
        return false;
    }

    /* =========================================================================
          Window Scroll Function
       =========================================================================*/
    $window.on('scroll', function () {
        if (!checkCustomizer()) {
            toggleScrollToTop();
        }
    });

    /* =========================================================================
            Window Load Function
    ===================================================================*/
    $window.on('load', function () {
        // Ensure the button is correctly shown/hidden on page load
        if (!checkCustomizer()) {
            toggleScrollToTop();
        }

        // Ensure the button is visible when the Customizer is opened
        if (typeof wp !== 'undefined' && wp.customize && wp.customize.preview) {
            wp.customize.preview.bind('preview-ready', function() {
                $scrollToTop.fadeIn();
            });
        }

        $scrollToTop.on("click", function () {
            $('html, body').animate({ scrollTop: 0 }, 800);
            return false;
        });
    });

    // Check Customizer state on document ready
    $(document).ready(function() {
        if (checkCustomizer()) {
            $scrollToTop.fadeIn();
        }
    });

}(jQuery));
