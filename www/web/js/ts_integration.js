var createDygraph = function (data, chartType) {
    g = new Dygraph(
        document.getElementById("graph"),
        // data function which takes raw input from controller
        // and creates JS array with proper objects (e.g. x as Date())
        data,
        {
            legend: 'always',
            animatedZooms: false, // not compatible with range selector
            title: '',
            ylabel: 'Variable',
            labels: [ "date", "min", "avg", "max"],
            plotter: (chartType === 'bar') ? multiColumnBarPlotter : null,
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

var sampleData = function(rawData) {
    var data = [];
    var numIntervals = window.innerWidth/2;
    var samplingLength = rawData.length/numIntervals;
    for (var i=0; i<rawData.length; i+=samplingLength){
        var sampleArray = rawData.slice(i,i+samplingLength);
        var timestampSum = 0;
        var valueSum = 0;
        var min = sampleArray[0]['value'];
        var max = sampleArray[0]['value'];
        sampleArray.forEach(function(element) {
            timestampSum += Date.parse(element['time']);
            valueSum += element['value'];
            min = (element['value'] < min) ? element['value'] : min;
            max = (element['value'] > max) ? element['value'] : max;
        });
        var time = timestampSum/sampleArray.length;
        var avg = valueSum/sampleArray.length;
        data.push([new Date(time), min, avg, max]);
    }
    return data;
};