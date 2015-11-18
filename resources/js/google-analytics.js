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

        commonProperties.queryAjax($(this), function(data) {
            highchartsProperties.basicChart(
                'chartViews',
                'Statistics visits',
                'Views',
                'Date',
                data.visitByDay
            );

            $('.sessions').html(data.generalStatistics['ga:sessions']);
            $('.pageviews').html(data.generalStatistics['ga:pageviews']);
            $('.sessionDuration').html(data.generalStatistics['ga:sessionDuration']);
            $('.users').html(data.generalStatistics['ga:users']);
            $('.generalStatistics').fadeIn();


        }, 'json');

    });

});