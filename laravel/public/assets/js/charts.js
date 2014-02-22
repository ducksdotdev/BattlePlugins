$(function(){
    $.get('/statistics/getTotalServers', function(data){
        drawChart(data, 'serversGraph');
    });

})

google.load('visualization', '1.0', {'packages':['corechart']});
function drawChart(data, div) {
    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Sales', 'Expenses'],
        ['2013',  1000,      400],
        ['2014',  1170,      460],
        ['2015',  660,       1120],
        ['2016',  1030,      540]
    ]);

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.AreaChart(document.getElementById(div));
    chart.draw(data);
}