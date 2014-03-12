$(function () {
    var colors = [
        '#41A7D3',
        '#6CB755',
        '#D13434',
        '#0d233a',
        '#910000',
        '#492970',
        '#f28f43',
        '#77a1e5',
        '#c42525',
        '#a6c96a',
        '#4572A7',
        '#AA4643',
        '#89A54E',
        '#80699B',
        '#3D96AE',
        '#DB843D',
        '#92A8CD',
        '#A47D7C',
        '#B5CA92'
    ];

    $.get('/statistics/getTotalServers', function (data) {
        var players = [];
        var servers = [];
        $.each(data, function (i, item) {
            var timestamp = Date.toTimestamp(item.time);
            players.push([timestamp, parseInt(item.nPlayers)]);
            servers.push([timestamp, parseInt(item.nServers)]);
        });

        $('#serversGraph').highcharts({
            chart: {
                type: 'area',
                zoomType: 'x'
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
                labels: {
                    align: 'left',
                    x: 3,
                    y: -3
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
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
                }
            },
            colors: colors,
            series: [
                {
                    name: 'Players',
                    data: players
                },
                {
                    name: 'Servers',
                    data: servers
                }
            ]
        });
    }, 'json');

    $.get('/statistics/getPluginCount', function (data) {
        var cdata = [];
        $.each(data, function (i, item) {
            cdata.push([item.plugin, parseInt(item.total)]);
        });

        $('#pluginsGraph').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: null
            },
            tooltip: {
                pointFormat: '<b>{point.y} servers</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [
                {
                    type: 'pie',
                    data: cdata
                }
            ]
        });
    }, 'json');

    $.get('/statistics/getAuthMode', function (data) {
        var cdata = [];
        $.each(data, function (i, item) {
            var name = item.bOnlineMode == 'true' ? 'Online' : 'Offline';
            cdata.push([name, parseInt(item.total)]);
        });

        $('#authGraph').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: null
            },
            tooltip: {
                pointFormat: '<b>{point.y} servers</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [
                {
                    type: 'pie',
                    data: cdata
                }
            ]
        });
    }, 'json');
});

Date.toTimestamp = function (s) {
    s = s.split(/[-A-Z :\.]/i);
    var d = new Date(Date.UTC(s[0], --s[1], s[2], s[3], s[4], s[5]));
    return Math.round(d.getTime());
}
