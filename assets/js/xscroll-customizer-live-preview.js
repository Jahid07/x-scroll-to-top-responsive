(function ($) {
    /**
     * Select Icon
     */
    wp.customize('xstr_option[icon_picker]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a i').removeClass();
            $('.scroll-to-top a i').addClass(newval);
        });
    });

    /**
     * Icon width
     */
    wp.customize('xstr_option[size]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('width', newval);
        });
    });

    /**
     * Icon Height
     */
    wp.customize('xstr_option[size]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('height', newval);
        });
    });

    /**
     * Margin Left
     */
    wp.customize('xstr_option[size]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('margin-left', -(newval/2));
        });
    });

    /**
     * Icon border radius
     */
    wp.customize('xstr_option[border_radius]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('border-radius', newval+'%');
        });
    });


    /**
     * Icon size
     */
    wp.customize('xstr_option[size]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('font-size', newval/2);
        });
    });

    /**
     * Icon color
     */



    /**
     * Icon background
     */



    /**
     * Icon position
     */
    wp.customize('xstr_option[icon_position]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top').css('left', newval + '%');
        });
    });

     /**
     * Icon position Y
     */
     wp.customize('xstr_option[icon_position_y]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top').css('bottom', newval + '%');
        });
    });

    /**
     * Incon size and postion in mobile & tablet X & Y 
     * 
     */

    wp.customize('xstr_option[size_mobile]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('width', newval);
        });
    });

    wp.customize('xstr_option[size_mobile]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('height', newval);
        });
    });
    wp.customize('xstr_option[size_mobile]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('margin-left', -(newval/2));
        });
    });
    wp.customize('xstr_option[size_mobile]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top a').css('font-size', newval/2);
        });
    });

    wp.customize('xstr_option[icon_position_tablet_mobile]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top').css('left', newval + '%');
        });
    });
    wp.customize('xstr_option[icon_position_tablet_mobile_y]', function (value) {
        value.bind(function (newval) {
            $('.scroll-to-top').css('bottom', newval + '%');
        });
    });

    

    

    wp.customize('xstr_option[scroll_speed]', function (value) {
        value.bind(function (speed) {
            $('.scroll-to-top').attr('data-scroll-speed', speed);
        });
    });

    var colorFields = ['icon_color', 'icon_bg_color', 'icon_hover_color', 'icon_hover_bg_color'];
    var colorStyle = document.createElement('style');
    document.head.appendChild(colorStyle);
    function updateColors() {
        var colors = colorFields.map(function (field) { return wp.customize('xstr_option[' + field + ']').get(); });
        $('.scroll-to-top a').css({ color: '', background: '' });
        colorStyle.textContent = '.scroll-to-top a{color:' + colors[0] + ';background:' + colors[1] + ';}' +
            '.scroll-to-top:hover a{color:' + colors[2] + ';background:' + colors[3] + ';}';
    }
    colorFields.forEach(function (field) {
        wp.customize('xstr_option[' + field + ']', function (value) { value.bind(updateColors); });
    });

})(jQuery);