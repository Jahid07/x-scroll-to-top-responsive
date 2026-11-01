(function ($) {
    "use strict";
    
    // Cache the selectors for better performance
    var $window = $(window);
    var $scrollToTop = $(".scroll-to-top");

    var scrollFrame;
    function cancelScroll() {
        window.cancelAnimationFrame(scrollFrame);
    }
    $window.on('wheel touchstart keydown', cancelScroll);

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
            cancelScroll();
            var speed = Math.max(1, Math.min(10, Number($scrollToTop.attr('data-scroll-speed')) || 5));
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || speed === 5) {
                window.scrollTo({
                    top: 0,
                    behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth'
                });
            } else {
                var duration = speed < 5 ? 600 + (5 - speed) * 250 : 600 - (speed - 5) * 80;
                var startY = window.scrollY;
                var start = performance.now();
                function step(now) {
                    var progress = Math.min(1, (now - start) / duration);
                    // Instant steps avoid competing with a theme's CSS smooth scrolling.
                    window.scrollTo({ top: startY * Math.pow(1 - progress, 3), behavior: 'instant' });
                    if (progress < 1) scrollFrame = window.requestAnimationFrame(step);
                }
                scrollFrame = window.requestAnimationFrame(step);
            }
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
