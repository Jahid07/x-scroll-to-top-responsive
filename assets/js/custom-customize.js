; (function ($) {
    $(document).ready(function () {
        $(".customize-inside-control-row").on("click", function(){
            $(".customize-inside-control-row").removeClass('selected');
            $(this).addClass("selected");
        });

        $("#accordion-section-xscroll_responsive_settings").on("click", function(){
            $(".wp-full-overlay.in-sub-panel.section-open").removeClass('preview-desktop');
            $(".wp-full-overlay.in-sub-panel.section-open").addClass('preview-tablet');
            $(".devices-wrapper button").removeClass('active');
            $(".devices-wrapper button.preview-tablet").addClass('active');
        })

        $("button.customize-section-back").on("click", function(){
            $(".wp-full-overlay.in-sub-panel").removeClass('preview-tablet');
            $(".wp-full-overlay.in-sub-panel").addClass('preview-desktop');
            $(".devices-wrapper button.preview-tablet").removeClass('active');
            $(".devices-wrapper button.preview-desktop").addClass('active');
        })
        

    })
})(jQuery);