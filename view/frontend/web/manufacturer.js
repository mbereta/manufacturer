require([ 'jquery'], function($) {
    $(window).load(function() {
        $('.scroll-to').click(function (e) {
            e.stopPropagation();
            e.preventDefault();

            var _this = $(this).attr('href');
            var _top;
            var minBarOuterHeight = $('.header.content').outerHeight();
                        
            if ($(window).width() > 768) {                
                _top = $(_this).offset().top - 2 * minBarOuterHeight +45;
            } else {                
                _top = $(_this).offset().top - minBarOuterHeight + 120;
            }
            $('html, body').animate({
                scrollTop: _top
            }, 400);
        });
    });
});
