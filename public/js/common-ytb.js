$(window).load(function() {
    $.material.init();

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
});
