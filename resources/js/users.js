$(function() {

    /**
     * Edit user status in list of user
     **/
    $(document).on('change', '.editUserStatus', function (e) {
        e.preventDefault();

        /**
         * Ajax Request
         *
         * @param The current element
         * @param Callback
         **/
        commonProperties.queryAjax($(this), function (data) {
            $.jGrowl(data, {life: 3000});
        });
    });


    /**
     * The delete user
     **/
    $(document).on('click', '.deleteUser', function (e) {
        e.preventDefault();
        var $self = $(this)
        var userId = $self.data('user-id');


        $.confirm({
            theme: 'hololight',
            confirmButton: 'Yes',
            cancelButton: 'No',
            title: 'Are you sure?',
            content: 'The user will be deleted without possibility to restore.',
            confirm: function(){

                /**
                 * Ajax Request
                 *
                 * @param The current element
                 * @param Callback
                 * @param dataType
                 * @param data
                 **/
                commonProperties.queryAjax($self, function (data) {
                    $self.closest('tr').fadeOut();
                    $.jGrowl(data, {life: 3000});
                }, 'html', {
                    userId: userId
                });

            }
        });
    });

});