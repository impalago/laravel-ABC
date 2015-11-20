/**
 * Setting Ytb package
 *
 * Had to be done through window load because jquery masonry not working
 *
 **/
$(window).load(function() {
    $grid = $('.grid');
    $grid.masonry({
        itemSelector: '.grid-item',
        singleMode: false,
        isResizable: true,
        isAnimated: true,
        animationOptions: {
            queue: false,
            duration: 500
        }
    });
});

$(function() {
    $.material.init();

    $('.tt-on').tooltip({
        placement: 'left'
    });

    $('.tt-on-bottom').tooltip({
        placement: 'bottom'
    });

    $('.disabled').on('click', function(e) {
        e.preventDefault();
    });

    /**
     * Menu add class 'active'
     *
     **/

    $('.nav li').each(function() {
        var href = $(this).find('a').attr('href');
        if (href === window.location.href) {
            $(this).addClass('active');
        }
    });


    /**
     * Receive a csrf-token for ajax requests
     *
     **/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});









