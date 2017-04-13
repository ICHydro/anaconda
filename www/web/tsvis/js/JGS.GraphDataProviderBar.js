(function (JGS, $, undefined) {
  "use strict";
  /**
   This class is used to acquire, aggregate, splice, and convert data to be fed to dygraphs.  The handling
   of data will be different for each project and is heavily dependent on the downsampling methods, backend service API,
   etc.  Generally though, the expectation is that JavaScript clients are able to make one or more calls to get the following
   data sets:
    - range-data-avg
    - range-data-min
    - range-data-max
    - detail-data-avg
    - detail-data-min
    - detail-data-max
   Depending on backend API, this could mean six distinct HTTP calls, or just one.  In this example, the API is
   structured such that a single API call with start date, end date, & downsampling level, provides a dataset
   that includes avg/min/min values in a single response.  As a result, the example  initially has to make two calls
   to get data; one for the range datasets, and one for the detail datasets.  This class is responsible for waiting until
   both datasets are available before continuing.
   After the initial load, only detailed datasets need to be loaded.  (Future examples might add ability to change
   the range, in which case we'll be loading new range data at times too.)  Data loads are often delayed. Users might be
   initiating or changing zoom extents even before responses have been received.  Because of that, this class is also
   responsible for making sure only the most recent request/response gets used. All others are discarded. That is
   the purpose of "reqNum" parameter in the requests.
   Once data is available, this class splices the range and detail to generate a single dataset. It then converts the raw
   data points to native format of dygraphs.
   @class GraphDataProviderBar
   @constructor
   */
  JGS.GraphDataProviderBar = function () {
    //  console.log("data provider newed");
    this.serverDataSims = {};
    this.newGraphDataCallbacks = $.Callbacks();
    this.lastRangeReqNum = 0;
    this.lastDetailReqNum = 0;
  };

  /**
   Initiates data load request. The rangeStartDateTm and rangeEndDateTm parameters are optional. If null, then only
   new detail data will be loaded, and the result spliced with most recent existing range data.
   @method loadData
  */
  JGS.GraphDataProviderBar.prototype.loadData = function (seriesName, rangeStartDateTm,
     rangeEndDateTm, detailStartDateTm, detailEndDateTm, pixelWidth, barWidth) {
    console.log("data provider load data called========");
    console.log(detailStartDateTm);
    //Construct server data provider/simulator if needed for the requested series
    var serverDataSim = this.serverDataSims[seriesName];
    if (!serverDataSim) {
      serverDataSim = new JGS.DataFetcherBar(seriesName, false);
      serverDataSim.getDataCallback.add($.proxy(this._onServerDataLoad, this));
      // serverDataSim = new JGS.ServerDataSimulator(seriesName);
      // serverDataSim.onServerDataLoadCallbacks.add($.proxy(this._onServerDataLoad, this));
      this.serverDataSims[seriesName] = serverDataSim;
    }
    if (detailStartDateTm && detailEndDateTm) {
      this.detailDataLoadComplete = false;
      //This determines how many points we load (and so how much downsampling is being asked for).
      //This might be specific to each project and require some knowledge of the underlying data purpose.
      //  var numDetailsIntervals = pixelWidth / 2; // ...so at most, downsample to one point every two pixels in the graph
      var barCols = [];
      //  console.log(moment(detailEndDateTm).format());
      console.log(barWidth);
      var a = moment(detailEndDateTm).add(barWidth, -1);
      //  console.log(a.format());
      console.log("====");
      var temp = 0;
      //  console.log(moment(detailEndDateTm).format());
      var pre = moment(detailEndDateTm).add(barWidth, -1);
      while (pre > detailStartDateTm) {
        barCols.push(pre.toDate());
        //console.log(pre.format());
        temp += 1;
        pre = moment(pre).add(barWidth, -1);
      };
      //  console.log(moment(detailStartDateTm).format());
      barCols.push(moment(detailStartDateTm).toDate());
      temp += 1;
      console.log(temp);
      console.log(barCols);
      console.log("====");
      barCols = barCols.reverse();
      var detailDataLoadReq = {
        // reqType: "detail",
        reqNum: ++this.lastDetailReqNum,
        startDateTm: detailStartDateTm,
        endDateTm: detailEndDateTm,
        //  numIntervals: numDetailsIntervals,
        //  includeMinMax: true,
        barCols: barCols,
        colNum:12
      };
      console.log(detailDataLoadReq);
      this.lastDetailDataLoadReq = detailDataLoadReq;
      //  console.log("detail");
      //  console.log(detailDataLoadReq);
      serverDataSim.loadData(detailDataLoadReq);
    } else {
      this.detailDataLoadComplete = true;
    }
  };

  /**
   Callback handler for server data load response. Will discard responses if newer requests were made in the meantime.
   Responsible for making sure all data received before continuing.
   @method _onServerDataLoad
   @private
   */
  JGS.GraphDataProviderBar.prototype._onServerDataLoad = function (dataLoadReq, dataLoadResp) {
    console.log("_onServerDataLoad");
    console.log(dataLoadResp);
    // console.log("dataprovider onServerDataLoad called");
    // console.log("provider: onserver data load: 1 :" + dataLoadResp.dataPoints[100]);
    // if (dataLoadResp.dataPoints.length == 0) {
    //    console.log("------");
    // }
    if (true) {
      if (this.lastDetailReqNum != dataLoadReq.reqNum) {
        return;  //discard because newer request was sent
      } else {
        this.lastDetailDataLoadResp = dataLoadResp;
        this.detailDataLoadComplete = true;
      }
    }
    var splicedData = this.lastDetailDataLoadResp.dataPoints;
      //Convert to dygraph native format
      var dyData = [];
      for (var i = 0; i < splicedData.length; i++) {
        dyData.push([new Date(splicedData[i].x), splicedData[i].rain]);
      }
      //console.log("+++++");
      //console.log(dyData);
      var graphData = {
        dyData: dyData,
        detailStartDateTm: this.lastDetailDataLoadReq.startDateTm,
        detailEndDateTm: this.lastDetailDataLoadReq.endDateTm
      };
      //  console.log("===");
      //  console.log(this.lastDetailDataLoadReq.startDateTm);
      //  console.log(this.lastDetailDataLoadReq.endDateTm);
      //  console.log("===");
      // console.log("provider: onserver data load: " + dyData[500]);
      this.newGraphDataCallbacks.fire(graphData);
  };

}(window.JGS = window.JGS || {}, jQuery));
