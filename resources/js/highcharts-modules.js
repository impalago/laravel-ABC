
var highchartsProperties = {

    /**
     * A chart is initialized by adding the JavaScript tag
     *
     * @param container - Id <div> container
     * @param nameY
     * @param nameX
     * @param data
     **/
    'basicChart' : function(container, titleChart, nameY, nameX, data) {
        new Highcharts.Chart({
            chart: {
                renderTo: container
            },

            title : {
                text : titleChart
            },
            rangeSelector : {
                selected : 1
            },
            yAxis: {
                title: {
                    text: nameY
                }
            },
            xAxis: {
                title: {
                    text: nameX
                },
                type: 'datetime'
            },
            series : [{
                name : 'Statistics visits',
                data: data
            }]
        });
    },

    /**
     * Pie charts
     *
     * @param container - Id <div> container
     * @param titleChart
     * @param seriesName
     * @param seriesData - json
     **/
    'pieChart' : function(container, titleChart, seriesName, seriesData) {
        new Highcharts.Chart({
            chart: {
                renderTo: container,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: titleChart
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: seriesName,
                colorByPoint: true,
                data: seriesData
            }]
        });
    }
};
