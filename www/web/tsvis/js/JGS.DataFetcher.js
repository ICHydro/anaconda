(function (JGS, $, undefined) {
  "use strict";
  /**
   * This class
   *
   @class DataFetcher
   @constructor
   */
  JGS.DataFetcher = function (seriesName, mul) {
    console.log("simulator init called: " + seriesName);
    this.seriesName = seriesName;
    this.getDataCallback = $.Callbacks();
    this.mul = mul;
  };

  JGS.DataFetcher.prototype.loadData = function (dataLoadReq, sensor) {
    console.log("data fetcher load data called: " + sensor);
    //console.log(dataLoadReq);
    this.dataLoadReq = dataLoadReq;
    this.handle = function handle(data2) {
      console.log("this is result");
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
      // console.log(data2);
      var jsonData = JSON.parse(data2);
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
    var serName = this.seriesName;
    //  console.log(cond1);
    // console.log(cond2);
    console.log(moment(dataLoadReq.startDateTm).format('YYYY-MM-DD HH:mm:ss'));
    console.log(moment(dataLoadReq.endDateTm).format('YYYY-MM-DD HH:mm:ss'));
    var cond1 = moment(dataLoadReq.startDateTm).format('YYYY-MM-DD HH:mm:ss');
    var cond2 = moment(dataLoadReq.endDateTm).format('YYYY-MM-DD HH:mm:ss');
  //  dataLoadReq.startDateTm = moment(dataLoadReq.startDateTm).format('YYYY-MM-DD HH:mm:ss')
  //  dataLoadReq.endDateTm = moment(dataLoadReq.endDateTm).format('YYYY-MM-DD HH:mm:ss')
    //  console.log("serName: " + serName);
    console.log("DataFetcher: " + sensor);
    var dbUrl =  "";
    if (this.mul) {
      dbUrl = "fetch_multiple.php";
    } else {
      dbUrl = "fetch_single.php";
    }
    $.ajax({
      type: "POST",
      url: dbUrl,
      data: { 'timecondition1': cond1, 'timecondition2': cond2, 'series': serName, 'mul': false, 'sensor': sensor, 'req': dataLoadReq},
      dataType:'text',
      context: this,
      success: this.handle,
      error: this.errorhandle
    });
    // for (var i = 0; i < jsonData.length; i++) {
    //console.log(jsonData[i].time + "  " + jsonData[i].ptemp_c + "  " + jsonData[i].battv);
    // }
  };

  JGS.DataFetcher.prototype.firecallback = function (dataLoadReq, result) {
    //  console.log("fire call back called");
    this.getDataCallback.fire(dataLoadReq, result);
  };

}(window.JGS = window.JGS || {}, jQuery));
