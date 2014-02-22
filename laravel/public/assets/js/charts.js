$(function(){
    $.get('/statistics/getTotalServers', function(data){
        drawChart(data, 'serversGraph');
    });

})

google.load('visualization', '1.0', {'packages':['corechart']});
function drawChart(data, div) {
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
        ['Mushrooms', 3],
        ['Onions', 1],
        ['Olives', 1],
        ['Zucchini', 1],
        ['Pepperoni', 2]
    ]);

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.AreaChart(document.getElementById(div));
    chart.draw(data);
}