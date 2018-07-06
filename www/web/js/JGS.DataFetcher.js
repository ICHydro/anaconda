(function (JGS, $, undefined) {
  "use strict";
  /**
   * This class
   *
   @class DataFetcher
   @constructor
   */
  JGS.DataFetcher = function (seriesName) {
    this.seriesName = seriesName;
    this.getDataCallback = $.Callbacks();
  };

  JGS.DataFetcher.prototype.loadData = function (dataLoadReq, sensor) {
    this.dataLoadReq = dataLoadReq;
    this.errorhandle = function errorhandle(data) {
      alert("Unable to connect to server, please try again");
      return;
    };
    var start = moment(dataLoadReq.startDateTm).unix();
    var end = moment(dataLoadReq.endDateTm).unix();

    // prepare data for ajax call
    this.dataLoadReq['sensor'] = sensor;
    this.dataLoadReq['start'] = start;
    this.dataLoadReq['end'] = end;
    this.dataLoadReq['_csrf'] = getCSRF();
    $.ajax({
      type: "POST",
      url: "/site/fetch",
      data: this.dataLoadReq,
      dataType:'text',
      context: this,
      success: function (resp) {
              var jsonData = JSON.parse(resp);
              var dataLoadResp = {
                  dataPoints: JSON.parse(jsonData.data_points)
              };
              this.firecallback(dataLoadReq, dataLoadResp);
      },
      error: this.errorhandle
    });
  };

  JGS.DataFetcher.prototype.firecallback = function (dataLoadReq, result) {
    this.getDataCallback.fire(dataLoadReq, result);
  };

}(window.JGS = window.JGS || {}, jQuery));
