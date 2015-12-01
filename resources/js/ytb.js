$(function() {
    $('.subscriptions-mode').on('click', function(e) {
        e.preventDefault();

        var pageToken = $(this).data('page-token');
        alert(pageToken);
        $.ajax({
            type: 'post',
            url: '/youtube/load-subscriptions?page=' + pageToken,
            dataType: 'json',
            success: function(data) {
                console.log(data);
            }
        });
    });
});
