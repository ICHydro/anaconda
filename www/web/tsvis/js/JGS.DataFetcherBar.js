(function (JGS, $, undefined) {
  "use strict";
  /**
   * This class
   *
   @class DataFetcherBar
   @constructor
   */
  JGS.DataFetcherBar = function (seriesName, mul) {
    //console.log("simulator init called: " + seriesName);
    this.seriesName = seriesName;
    this.getDataCallback = $.Callbacks();
    this.mul = mul;
  };

  JGS.DataFetcherBar.prototype.loadData = function (dataLoadReq) {
    console.log("data fetcher load data called: ");
    //console.log(dataLoadReq);
    this.dataLoadReq = dataLoadReq;
    this.handle = function handle(data2) {
      console.log("this is result");
      //console.log(data2);
      if (data2 == "Database Connection status bad") {
        alert(data2);
        return;
      } else if (data2 == "No return data") {
        alert(data2);
        return;
      } else if (data2 == "Database error") {
        alert(data2);
        return;
      }

      var jsonData = JSON.parse(data2);
      //console.log(jsonData.length);
      //console.log(jsonData);
      var dataLoadResp = {
        dataPoints: jsonData
      };
      this.firecallback(dataLoadReq, dataLoadResp);
    };

    this.errorhandle = function errorhandle(data) {
      console.log("error called");
      alert("Unable to connect to server, please try again");
      return;
    };
    //  console.log("handling data callbeck called : " + data2.length);
    //  try {
    //        var dd = JSON.parse(data2);
    //    if(dd[0].time) {
    //        console.log("okkk!!!");    // do something interesting
    //    } else {
    // failed
    //    }
    //    }  catch(e)  {
    // failed
    //    }
    //    console.log(moment().format('YYYY-MM-DD HH:mm:ss'));
    //  console.log(moment().add('month', -36).format('YYYY-MM-DD HH:mm:ss'));
    //var cond1 = '2014-01-20 23:00:00';
    //var cond2 = '2015-07-05 00:00:00';
    //var cond1 = moment().add('month', -36).format('YYYY-MM-DD HH:mm:ss');
    //var cond2 = moment().format('YYYY-MM-DD HH:mm:ss');
    //console.log(cond1);
    //console.log(cond2);
    var dataLoadReq2 =   jQuery.extend(true, {}, dataLoadReq);
    console.log(moment(dataLoadReq2.startDateTm).format('YYYY-MM-DD HH:mm:ss'));
    console.log(moment(dataLoadReq2.endDateTm).format('YYYY-MM-DD HH:mm:ss'));
    dataLoadReq2.startDateTm = moment(dataLoadReq2.startDateTm).format('YYYY-MM-DD HH:mm:ss');
    dataLoadReq2.endDateTm = moment(dataLoadReq2.endDateTm).format('YYYY-MM-DD HH:mm:ss');
    //  var serName = this.seriesName;
    //  console.log("serName: " + serName);
    var  dbUrl = "fetch_single.php";
    $.ajax({
      type: "POST",
      url: dbUrl,
      data: { 'req': dataLoadReq2, 'barNum': 12},
      dataType:'text',
      context: this,
      success: this.handle,
      error: this.errorhandle
    });
    // for (var i = 0; i < jsonData.length; i++) {
    //console.log(jsonData[i].time + "  " + jsonData[i].ptemp_c + "  " + jsonData[i].battv);
    // }
  };

  JGS.DataFetcherBar.prototype.firecallback = function (dataLoadReq, result) {
    //  console.log("fire call back called");
    this.getDataCallback.fire(dataLoadReq, result);
  };

}(window.JGS = window.JGS || {}, jQuery));
