// custom plotter, e.g. bar chart, see http://dygraphs.com/tests/plotters.html

// Darken a color
function darkenColor(colorStr) {
    // Defined in dygraph-utils.js
    var color = Dygraph.toRGB_(colorStr);
    color.r = Math.floor((255 + color.r) / 2);
    color.g = Math.floor((255 + color.g) / 2);
    color.b = Math.floor((255 + color.b) / 2);
    return 'rgb(' + color.r + ',' + color.g + ',' + color.b + ')';
}

// This function draws bars for a single series. See
// multiColumnBarPlotter below for a plotter which can draw multi-series
// bar charts.
function barChartPlotter(e) {
    var ctx = e.drawingContext;
    var points = e.points;
    var y_bottom = e.dygraph.toDomYCoord(0);

    ctx.fillStyle = darkenColor(e.color);

    // Find the minimum separation between x-values.
    // This determines the bar width.
    var min_sep = Infinity;
    for (var i = 1; i < points.length; i++) {
        var sep = points[i].canvasx - points[i - 1].canvasx;
        if (sep < min_sep) min_sep = sep;
    }
    var bar_width = Math.floor(2.0 / 3 * min_sep);

    // Do the actual plotting.
    for (var i = 0; i < points.length; i++) {
        var p = points[i];
        var center_x = p.canvasx;

        ctx.fillRect(center_x - bar_width / 2, p.canvasy,
            bar_width, y_bottom - p.canvasy);

        ctx.strokeRect(center_x - bar_width / 2, p.canvasy,
            bar_width, y_bottom - p.canvasy);
    }
}

var createDygraph = function (rawData, chartType) {
    g = new Dygraph(
        document.getElementById("graph"),
        // data function which takes raw input from controller
        // and creates JS array with proper objects (e.g. x as Date())
        function() {
            var data = [];
            rawData.forEach(function(element) {
                data.push([new Date(element[0]), element[1]]);
            });
            return data;
        },
        {
            legend: 'always',
            animatedZooms: false, // not compatible with range selector
            title: '',
            ylabel: 'Variable',
            labels: [ "date", "variable"],
            plotter: (chartType === 'bar') ? barChartPlotter : null,
            showRangeSelector: true
        });
    return g;
};

var fetchTSData = function (sensorID, timeSpan='9 months', chartType='line') {
    var data = {};
    data['sensor_id'] = sensorID;
    data['chart_type'] = chartType;
    data['time_span'] = timeSpan;

    $.pjax({
        container: '#content',
        timeout: null,
        url: '/site/observatory',
        type: 'POST',
        data: data
    });
};