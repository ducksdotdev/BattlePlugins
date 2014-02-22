$(function () {
    $.get('/statistics/getTotalServers', function(data){
        var players = [];
        var servers = [];
        $.each(data, function(i, item){
            players.push(parseInt(item.players));
            servers.push(parseInt(item.servers));
        });

        var t = data[0].timestamp.split(/[- :]/);
        var pointstart = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

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
                pointStart: pointstart,
                area: {
                    lineWidth: 1,
                    marker: {
                        enabled: false
                    },
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                },
            },
            series: [{
                name: 'Players',
                pointInterval: 60 * 3600 * 1000,
                pointStart: pointstart,
                data: players
            },{
                name: 'Servers',
                pointInterval: 60 * 3600 * 1000,
                pointStart: pointstart,
                data: servers
            }]
        });
    }, 'json');
});
    