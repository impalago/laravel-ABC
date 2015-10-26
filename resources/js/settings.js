$(function() {

    /**
     * Edit role users
     **/

    $(document).on('click', '.update-role', function(e) {
        e.preventDefault();

        commonProperties.queryAjax($(this), function (data) {
            $(data).modal('show').on('shown.bs.modal', function() {
                $.material.checkbox();
            });
        });

    });

    /**
     * Remove role users
     **/

    $(document).on('click', '.deleteRole', function(e) {

        e.preventDefault();
        var $self = $(this);
        var roleId = $self.data('role-id');


        $.confirm({
            theme: 'hololight',
            confirmButton: 'Yes',
            cancelButton: 'No',
            title: 'Are you sure?',
            content: 'The role will be deleted without possibility to restore.',
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
                    roleId: roleId
                });

            }
        });

    });


    /**
     * Edit permission users
     **/

    $(document).on('click', '.update-permission', function(e) {
        e.preventDefault();

        commonProperties.queryAjax($(this), function (data) {
            $(data).modal('show');
        });

    });

    /**
     * Remove permission users
     **/

    $(document).on('click', '.deletePermission', function(e) {

        e.preventDefault();
        var $self = $(this);
        var roleId = $self.data('permission-id');


        $.confirm({
            theme: 'hololight',
            confirmButton: 'Yes',
            cancelButton: 'No',
            title: 'Are you sure?',
            content: 'The permission will be deleted without possibility to restore.',
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
                    roleId: roleId
                });

            }
        });

    });

});