$(function() {
    $.material.init();

    $('.tt-on').tooltip({
        placement: 'left'
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
     * Setting Ytb package
     *
     **/

    $('.disabled').on('click', function(e) {
        e.preventDefault();
    });

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






