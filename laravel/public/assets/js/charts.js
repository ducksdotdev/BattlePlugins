$(function(){
    $.get('/statistics/getTotalServers', function(data){
        drawChart(data, 'serversGraph');
    });

})

google.load('visualization', '1.0', {'packages':['corechart']});
function drawChart(data, div) {
    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Time', 'Sales'],
        ['2013',  1000],
        ['2014',  1170],
        ['2015',  660],
        ['2016',  1030]
    ]);

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.AreaChart(document.getElementById(div));
    chart.draw(data);
}