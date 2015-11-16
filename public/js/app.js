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










$(function() {

    //

});
$(function () {

    /**
     * Show account property
     **/
    $('.account').on('show.bs.collapse', function () {
        var $self = $(this);
        var empty = $self.find('.show-info').is(':empty');
        if (empty == true) {
            $self.find('.show-info').html('<div class="load-info"><img src="/img/google-load.gif"></div>').fadeIn();
            $self.find('.account-info').find('span').removeClass('glyphicon-folder-close').addClass('glyphicon-folder-open');
            commonProperties.queryAjax($self, function (data) {
                $self.find('.show-info').hide().html(data).slideDown();
            });
        }
    });

    /**
     * Datepicker settings
     **/

    $('#startDateCont, #endDateCont').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD',
        showTodayButton: true,
        showClose: true,
        allowInputToggle: true,
    });
    $('#startDateCont').on("dp.change", function (e) {
        endDate.data("DateTimePicker").minDate(e.date);
    });
    $('#endDateCont').on("dp.change", function (e) {
        startDate.data("DateTimePicker").maxDate(e.date);
    });

    /**
     * Get Statistic
     **/



    $('#sendData').on('submit', function (e) {
        e.preventDefault();
        var startDate = $('#startDate').val(),
            endDate = $('#endDate').val();

        commonProperties.queryAjax($(this), function() {
            alert(222);
        });


    });

});

var commonProperties = {

    /**
     * Ajax Request
     *
     * @param The current element
     * @param Callback
     * @param dataType
     * @param data
     **/
    'queryAjax' : function($elem, callback,dataType, data) {
        $.ajax({
            type: $elem.data('method') ? $elem.data('method') : $elem.attr('method'),
            url: $elem.data('action') ? $elem.data('action') : $elem.attr('action'),
            data: data ? data : $elem.serialize(),
            dataType: dataType ? dataType : 'html',
            success: function(data) {
                if(typeof callback === 'function') {
                    callback(data);
                } else {
                    location.reload();
                }
            }
        });
    }
};

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
//# sourceMappingURL=app.js.map
