
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
    }
};
