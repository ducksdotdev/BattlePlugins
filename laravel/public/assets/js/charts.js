$(function () {
    var colors = [
        '#41A7D3',
        '#6CB755',
        '#D13434',
        '#492970',
        '#f28f43',
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

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    var rangeSettings = {
        selected : 2,
        inputEnabled: true,
        buttons: [{
            type: 'day',
            count: 1,
            text: '1d'
        }, {
            type: 'day',
            count: 3,
            text: '3d'
        }, {
            type: 'week',
            count: 1,
            text: '1w'
        }, {
            type: 'week',
            count: 3,
            text: '3w'
        }, {
            type: 'month',
            count: 1,
            text: '1m'
        }, {
            type: 'year',
            count: 1,
            text: '1y'
        }, {
            type: 'all',
            text: 'All'
        }]
    };

    if($("#serversGraph").length > 0){
        $.getJSON('/statistics/servers/totals', function (data) {
            var players = [];
            var servers = [];
            $.each(data, function (i, item) {
                var timestamp = Date.toTimestamp(item.time);
                players.push([timestamp, parseInt(item.nPlayers)]);
                servers.push([timestamp, parseInt(item.nServers)]);
            });

            $('#serversGraph').highcharts('StockChart', {
                chart: {
                    type: 'area',
                    zoomType: 'x'
                },
                title: {
                    text: null
                },
                rangeSelector : rangeSettings,
                scrollbar : {
                    enabled : false
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
        });
    }

    if($("#pluginsGraph").length > 0){
        $.getJSON('/statistics/plugin/all/totals', function (data) {
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
                colors: colors,
                series: [
                    {
                        type: 'pie',
                        data: cdata
                    }
                ]
            });
        });
    }

    if($("#authGraph").length > 0){
        $.getJSON('/statistics/servers/auth', function (data) {
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
                colors: colors,
                series: [
                    {
                        type: 'pie',
                        data: cdata
                    }
                ]
            });
        });
    }

    if($('#versionStatistics').length > 0){
        var plugin = $('#versionStatistics').data('plugin');
        $.getJSON('/statistics/plugin/'+plugin+'/version', function(data){
            $('#versionStatistics').highcharts('StockChart', {
                chart: {
                    type: 'area',
                    zoomType: 'x'
                },
                title: {
                    text: null
                },
                rangeSelector : rangeSettings,
                scrollbar : {
                    enabled : false
                },
                yAxis: {
                    min: 0
                },
                colors: colors,
                series: data
            });
        });
    }
});

Date.toTimestamp = function (s) {
    s = s.split(/[-A-Z :\.]/i);
    var d = new Date(s[0], --s[1], s[2], s[3], s[4], s[5]);
    var value = Math.round(d.getTime());
    return value;
}
