$(function () {
    $.get('/statistics/getTotalServers', function(data){
        $('#serversGraph').highcharts({
            chart: {
                type: 'area'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
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
            series:
                [{
                    name: 'Servers',
                    data: data[0].servers
                }]
        });
    }, 'json');
});
    