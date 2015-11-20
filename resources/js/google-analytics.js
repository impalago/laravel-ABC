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

        commonProperties.ajaxPreloader();
        commonProperties.queryAjax($(this), function(data) {

            var time = parseInt(data.generalStatistics['ga:avgSessionDuration']);
            time = moment.duration(time, 'seconds').format("hh:mm:ss", { trim: false });

            var users = data.generalStatistics['ga:users'],
                newUsers = data.generalStatistics['ga:newUsers'],
                sessions = data.generalStatistics['ga:sessions'],
                pageviews = data.generalStatistics['ga:pageviews'],
                returnUsers = sessions - newUsers;

            highchartsProperties.basicChart(
                'chartViews',
                'Statistics visits',
                'Views',
                'Date',
                data.visitByDay
            );

            highchartsProperties.pieChart(
                'visitsChart',
                'Visits',
                'Visits',
                [{
                    name: "New Visitor",
                    y: parseInt(users)
                }, {
                    name: "Returning Visitor",
                    y: parseInt(returnUsers),
                    sliced: true
                }]
            );

            $('.sessions').html(sessions);
            $('.pageviews').html(pageviews);
            $('.sessionDuration').html(time);
            $('.users').html(users);
            $('.generalStatistics').fadeIn();
            $('#visitsChart, #chartViews').highcharts().reflow();
        }, 'json');

    });

});