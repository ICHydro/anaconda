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
            labels: (data[0].length === 4) ? [ "date", "min", "avg", "max"] : ["data", "value"],
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
    var numIntervals = window.innerWidth / 2;
    var samplingLength = rawData.length / numIntervals;
    for (var i = 0; i < rawData.length; i += samplingLength) {
        var sampleArray = rawData.slice(i, i + samplingLength);
        var timestampSum = 0;
        var valueSum = 0;
        var min = sampleArray[0]['value'];
        var max = sampleArray[0]['value'];
        sampleArray.forEach(function (element) {
            timestampSum += Date.parse(element['time']);
            valueSum += element['value'];
            min = (element['value'] < min) ? element['value'] : min;
            max = (element['value'] > max) ? element['value'] : max;
        });
        var time = timestampSum / sampleArray.length;
        var avg = valueSum / sampleArray.length;
        data.push([new Date(time), min, avg, max]);
    }
    return data;
};

function getDygraphData(rawData) {
    if (rawData.length) {
        // do resampling only for periods longer than 30 days (TODO tune condition)
        var timeDiffDays = (Date.parse(rawData[rawData.length-1]['time'])-Date.parse(rawData[0]['time']))/(1000*3600*24);
        if (timeDiffDays > 30) {
            return sampleData(rawData);
        } else {
            var gData = [];
            rawData.forEach(function (item) {
                gData.push([new Date(item['time']), item['value']])
            });
            return gData
        }
    }
    return [[0,0]]
}