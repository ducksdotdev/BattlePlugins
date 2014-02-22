$(function () {
    $.get('/statistics/getTotalServers', function(data){
        $('#serversGraph').highcharts({
            chart: {
                type: 'area'
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                type: 'datetime',
                tickInterval: 3600 * 1000,
                tickWidth: 0,
                gridLineWidth: 1,
                labels: {
                    align: 'left',
                    x: 3,
                    y: -3
                }
            },
            tooltip: {
                pointFormat: '<b>{point.y:,.0f} {series.name}</b>'
            },
            plotOptions: {
                area: {
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 2,
                        states: {
                            hover: {
                                enabled: true
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'Servers',
                data: [1,15]
            },{
                name: 'Players',
                data: [2,20]
            }]
        });
    }, 'json');
});
    