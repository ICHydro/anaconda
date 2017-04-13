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
   @class GraphDataProvider
   @constructor
   */
  JGS.GraphDataProvider = function () {
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
  JGS.GraphDataProvider.prototype.loadData = function (seriesName, sensor, rangeStartDateTm,
     rangeEndDateTm, detailStartDateTm, detailEndDateTm, pixelWidth) {
    console.log("data provider load data called========");
    console.log("sensor = " + sensor);
    //console.log(detailStartDateTm);
    //Construct server data provider/simulator if needed for the requested series
    var serverDataSim = this.serverDataSims[seriesName];
    if (!serverDataSim) {
     serverDataSim = new JGS.DataFetcher(seriesName, false);
      serverDataSim.getDataCallback.add($.proxy(this._onServerDataLoad, this));
  //     serverDataSim = new JGS.ServerDataSimulator(seriesName);
    //   serverDataSim.onServerDataLoadCallbacks.add($.proxy(this._onServerDataLoad, this));
       this.serverDataSims[seriesName] = serverDataSim;
    }

    if (rangeStartDateTm && detailStartDateTm) {
      this.first = true;
    } else {
      this.first = false;
    }

    // loading range data is optional
    if (rangeStartDateTm && rangeEndDateTm) {
      this.rangeDataLoadComplete = false;
      //This determines how many points we load (and so how much downsampling is being asked for).
      //This might be specific to each project and require some knowledge of the underlying data purpose.
      var numRangeIntervals = pixelWidth / 2; // ...so at most, downsample to one point every two pixels in the range selector

      var rangeDataLoadReq = {
        reqType: "range",
        reqNum: ++this.lastRangeReqNum,
        startDateTm: rangeStartDateTm,
        endDateTm: rangeEndDateTm,
        numIntervals: numRangeIntervals,
        includeMinMax: true
      };
      //     console.log(rangeDataLoadReq);
      this.lastRangeDataLoadReq = rangeDataLoadReq;
      //  console.log("range");
      //console.log(rangeDataLoadReq);
      serverDataSim.loadData(rangeDataLoadReq, sensor);
    }
    else {
      this.rangeDataLoadComplete = true;
    }

    // load detail data ...also coded optional,
    //but never used as optional because we don't range extents without changing detail extents
    if (detailStartDateTm && detailEndDateTm) {
      this.detailDataLoadComplete = false;
      //This determines how many points we load (and so how much downsampling is being asked for).
      //This might be specific to each project and require some knowledge of the underlying data purpose.
      var numDetailsIntervals = pixelWidth / 2; // ...so at most, downsample to one point every two pixels in the graph

      var detailDataLoadReq = {
        reqType: "detail",
        reqNum: ++this.lastDetailReqNum,
        startDateTm: detailStartDateTm,
        endDateTm: detailEndDateTm,
        numIntervals: numDetailsIntervals,
        includeMinMax: true
      };
      // console.log(detailDataLoadReq);
      this.lastDetailDataLoadReq = detailDataLoadReq;
    //  console.log("detail");
    //  console.log(detailDataLoadReq);
      serverDataSim.loadData(detailDataLoadReq,sensor);
    }
    else {
      this.detailDataLoadComplete = true;
    }
  };

  /**
   Callback handler for server data load response. Will discard responses if newer requests were made in the meantime.
   Responsible for making sure all data received before continuing.
   @method _onServerDataLoad
   @private
   */
  JGS.GraphDataProvider.prototype._onServerDataLoad = function (dataLoadReq, dataLoadResp) {
    console.log("_onServerDataLoad");
  //  console.log(dataLoadResp);
    // console.log("dataprovider onServerDataLoad called");
    // console.log("provider: onserver data load: 1 :" + dataLoadResp.dataPoints[100]);
    // if (dataLoadResp.dataPoints.length == 0) {
    //    console.log("------");
    // }
    if (dataLoadReq.reqType == 'detail') {
      if (this.lastDetailReqNum != dataLoadReq.reqNum) {
        return;  //discard because newer request was sent
      } else {
        this.lastDetailDataLoadResp = dataLoadResp;
        this.detailDataLoadComplete = true;
      }
    } else { //range
      if (this.lastRangeReqNum != dataLoadReq.reqNum) {
        return;  //discard because newer request was sent
      } else {
        if (dataLoadResp.dataPoints.length > 0) {
          this.lastRangeDataLoadResp = dataLoadResp;
        }
        this.rangeDataLoadComplete = true;
      }
    }
    if (this.rangeDataLoadComplete && this.detailDataLoadComplete) {
      //console.log(dyData[0][0]);
     if (dataLoadResp.dataPoints.length>0) {
      var len = this.lastDetailDataLoadResp.dataPoints.length;
      if (len > 0) {
        console.log("process detail");
        var respTimeEnd = moment(this.lastDetailDataLoadResp.dataPoints[len-1]["x"]);
        var respTimeStart = moment(this.lastDetailDataLoadResp.dataPoints[0]["x"]);
        var ReqEnd = this.lastDetailDataLoadReq.endDateTm;
        console.log(respTimeStart);
        console.log(respTimeEnd);
        console.log(ReqEnd);
        console.log(moment(this.lastDetailDataLoadResp.dataPoints[len-1]["x"]).toDate());
        var diff = Math.abs(moment.duration(moment(respTimeEnd).diff(moment(ReqEnd))));
        console.log(diff);
        if (len > 0 && diff > 1000) {
          console.log(" NO DATA FIRST! 1");
          if (dataLoadReq.includeMinMax)
               this.lastDetailDataLoadResp.dataPoints.push({x:this.lastDetailDataLoadReq.endDateTm, avg:null,min:null,max:null});
          else
              this.lastDetailDataLoadResp.dataPoints.push({x:this.lastDetailDataLoadReq.endDateTm, avg:null});
        }
      }
      len = this.lastRangeDataLoadResp.dataPoints.length;
      //  len = 0;
      if (this.first && len > 0) {
          console.log("process range");
          respTimeEnd = moment(this.lastRangeDataLoadResp.dataPoints[len-1]["x"]);
          respTimeStart = moment(this.lastRangeDataLoadResp.dataPoints[0]["x"]);
          ReqEnd = this.lastRangeDataLoadReq.endDateTm;
          console.log(respTimeStart);
          console.log(respTimeEnd);
          console.log(ReqEnd);
          console.log(moment(this.lastRangeDataLoadResp.dataPoints[len-1]["x"]).toDate());
          var diff = Math.abs(moment.duration(moment(respTimeEnd).diff(moment(ReqEnd))));
          console.log(diff);
          if (len > 0 && diff > 1000) {
            console.log(" NO DATA FIRST! 2");
            if (dataLoadReq.includeMinMax)
              this.lastRangeDataLoadResp.dataPoints.push({x:this.lastRangeDataLoadReq.endDateTm, avg:null,min:null,max:null});
            else
              this.lastRangeDataLoadResp.dataPoints.push({x:this.lastRangeDataLoadReq.endDateTm, avg:null});
          }
        }
        var splicedData = this._spliceRangeAndDetail(this.lastRangeDataLoadResp.dataPoints, this.lastDetailDataLoadResp.dataPoints);
        //Convert to dygraph native format
        var dyData = [];
        for (var i = 0; i < splicedData.length; i++) {
          if (dataLoadReq.includeMinMax)
            dyData.push([new Date(splicedData[i].x), [splicedData[i].min, splicedData[i].avg, splicedData[i].max]]);
          else
            dyData.push([new Date(splicedData[i].x), splicedData[i].y]);
        }
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
      } else {
          var dyData = [];
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
      }

    }
  };

  /**
   Splices the range data set, with detail data set, to come-up with a single spliced dataset. See documentation
   for explanation.  There might be more efficient ways to code it.
   @method _spliceRangeAndDetail
   @private
   */
  JGS.GraphDataProvider.prototype._spliceRangeAndDetail = function (rangeDps, detailDps) {
    var splicedDps = [];
    if (rangeDps.length == 0 && detailDps.length == 0) {
      // do nothing, no data
    } else if (detailDps.length == 0) {
      for (var i = 0; i < rangeDps.length; i++) {
        splicedDps.push(rangeDps[i]);
      }
    } else if (rangeDps.length == 0) { //should never happen?
      for (var i = 0; i < detailDps.length; i++) {
        splicedDps.push(detailDps[i]);
      }
    } else {
      var detailStartX = detailDps[0].x;
      var detailEndX = detailDps[detailDps.length - 1].x;

      // Find last data point index in range where-after detail data will be inserted
      var lastRangeIdx = this._findLastRangeIdxBeforeDetailStart(rangeDps, detailStartX);

      //Insert 1st part of range
      if (lastRangeIdx >= 0) {
        splicedDps.push.apply(splicedDps, rangeDps.slice(0, lastRangeIdx + 1));
      }

      //Insert detail
      splicedDps.push.apply(splicedDps, detailDps.slice(0));

      //Insert last part of range
      var startEndRangeIdx = rangeDps.length;
      for (var i = startEndRangeIdx; i >= lastRangeIdx; i--) {
        if (i <= 1 || rangeDps[i - 1].x <= detailEndX) {
          break;
        } else {
          startEndRangeIdx--;
        }
      }

      if (startEndRangeIdx < rangeDps.length) {
        splicedDps.push.apply(splicedDps, rangeDps.slice(startEndRangeIdx, rangeDps.length));
      }
    }
    return splicedDps;
  };

  /**
   Finds last index in the range data set before the first detail data value.  Uses binary search per suggestion
   by Benoit Person (https://github.com/ddr2) in Dygraphs mailing list.
   @method _findLastRangeIdxBeforeDetailStart
   @private
   */
  JGS.GraphDataProvider.prototype._findLastRangeIdxBeforeDetailStart = function (rangeDps, firstDetailTime) {
    var minIndex = 0;
    var maxIndex = rangeDps.length - 1;
    var currentIndex;
    var currentElement;

    // Handle out of range cases
    if (rangeDps.length == 0 || firstDetailTime <= rangeDps[0].x)
      return -1;
    else if (rangeDps[rangeDps.length-1].x < firstDetailTime)
      return rangeDps.length-1;

    // Use binary search to find index of data point in range data that occurs immediately before firstDetailTime
    while (minIndex <= maxIndex) {
      currentIndex = Math.floor((minIndex + maxIndex) / 2);
      currentElement = rangeDps[currentIndex];

      if (currentElement.x < firstDetailTime) {
        minIndex = currentIndex + 1;

        //we want previous point, and will not often have an exact match due to different sampling intervals
        if (rangeDps[minIndex].x > firstDetailTime) {
          return currentIndex;
        }
      }
      else if (currentElement.x > firstDetailTime) {
        maxIndex = currentIndex - 1;

        //we want previous point, and will not often have an exact match due to different sampling intervals
        if (rangeDps[maxIndex].x < firstDetailTime) {
          return currentIndex-1;
        }
      }
      else {
        return currentIndex-1; //if exact match, we use previous range data point
      }
    }
    return -1;
  };

}(window.JGS = window.JGS || {}, jQuery));
