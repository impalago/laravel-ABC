$(function() {
    $(document).on('click', '.subscriptions-mode', function(e) {
        e.preventDefault();
        $('.show-more').html('<img src="/img/load.gif" style="width:30px;">');
        var pageToken = $(this).data('page-token');
        $.ajax({
            url: '/youtube/load-subscriptions/' + pageToken,
            success: function(data) {
                $('.show-more').remove();
                $('.subscriptions').append(data);
            }
        });
    });
});
