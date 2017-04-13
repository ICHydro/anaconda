(function (JGS, $, undefined) {
  "use strict";

  /**
   This class provides javascript handling specific to the example1 page. Most importantly, it provides the dygraphs
   setup and handling, including the handling of mouse-down/up events on the dygraphs range control element.

   @class Barplot
   @constructor
   */
  JGS.Barplot = function (pageCfg) {
    console.log("Barplot renewed");
    this.$graphCont = pageCfg.$graphCont;
    this.$rangeBtnsCont = pageCfg.$rangeBtnsCont;
    this.graphDataProvider = new JGS.GraphDataProviderBar();
    this.graphDataProvider.newGraphDataCallbacks.add($.proxy(this._onNewGraphData, this));
    this.isRangeSelectorActive = false;
  };

  /**
   * Starts everything by requesting initial data load. For example's purposes, initial date extents are hardcoded.
   * @method
   */
  JGS.Barplot.prototype.init = function () {
    console.log("Barplot initialized");
    this.showSpinner(true);
    this._setupRangeButtons();
    this.setUpRefresh();
    this.setUpRecreate();
    $('#recreateButton').prop('disabled', true);
    // Default range dates
    var detailEndMom = moment();
    //console.log(rangeEndMom.valueOf());
    //console.log(moment(1435446300000).format());
    detailEndMom.startOf('hour');
    detailEndMom.add(1, 'hour');
    //console.log("range end " + rangeEndMom.format());
    var detailStartMom = moment.utc(detailEndMom).add(-6, 'month');
    //console.log("range start " + rangeStartMom.format());
    this.$rangeBtnsCont.find("button[name='range-btn-6m']").addClass('active');
    $("#rangeLabel").html("<small>Six months range, each bar stands for one week</small>");
    // Default detail dates
    //detailEndMom.add('day', -30);
    //console.log("detail end " + detailEndMom.format());
    //detailStartMom.add('day', -60);
    //var detailStartMom = moment(rangeStartMom);
    //var detailStartMom = moment(detailEndMom);
    //detailStartMom.add('day', -120);
    //  console.log("detail start " + detailStartMom.format());
    console.log(detailEndMom);
    console.log(detailStartMom);
    this.lastOption = 'range-btn-6m';
    this.waitingOption = 'range-btn-6m';
    this.prevLabel = "<small>Details range: "  + detailStartMom.toDate() + " to " + detailEndMom.toDate() +  "</small>";
    $("#detailsrange").html("<small>Details range: "  + detailStartMom.toDate() + " to " + detailEndMom.toDate() +  "</small>");
    //console.log(rangeStartMom.toDate() + "   " + this.$graphCont.width());
    this.graphDataProvider.loadData("temperature", null,
    null, detailStartMom.toDate(), detailEndMom.toDate(), this.$graphCont.width(),"week");
  };

JGS.Barplot.prototype.setUpRecreate = function () {
  var self = this;
  $("#recreateButton").click(function () {
     //alert("done");
     self.graphDataProvider.loadData("temperature", null, null,
     (self.recreatePara)[0],(self.recreatePara)[1],(self.recreatePara)[2],(self.recreatePara)[3] );
     $('#recreateButton').prop('disabled', true);
  });
};

  JGS.Barplot.prototype.setUpRefresh = function () {
    var self = this;
    $("#refreshButton").click(function () {
      // evt.preventDefault(); // depreciated!!!
      //evt.defaultPrevent;
      //var name = $(this).attr('id');
      //alert(name);
      $('#recreateButton').prop('disabled', true);
      self.showSpinner(true);
      // Default range dates
      var detailEndMom = moment();
      //console.log(rangeEndMom.valueOf());
      //console.log(moment(1435446300000).format());
      detailEndMom.startOf('hour');
      detailEndMom.add(1, 'hour');
      //console.log("range end " + rangeEndMom.format());
      var detailStartMom = moment(detailEndMom).add(-6, 'month');
      //console.log("range start " + rangeStartMom.format());
      self.$rangeBtnsCont.children().removeClass('active');
      self.$rangeBtnsCont.find("button[name='range-btn-6m']").addClass('active');
      // Default detail dates
      //detailEndMom.add('day', -30);
      //console.log("detail end " + detailEndMom.format());
      //detailStartMom.add('day', -60);
      //var detailStartMom = moment(rangeStartMom);
      //var detailStartMom = moment(detailEndMom);
      //detailStartMom.add('day', -120);
      //  console.log("detail start " + detailStartMom.format());
      console.log(detailEndMom);
      console.log(detailStartMom);
      self.lastOption = 'range-btn-6m';
      self.waitingOption = 'range-btn-6m';
      //console.log(rangeStartMom.toDate() + "   " + this.$graphCont.width());
      this.prevLabel = "<small>Details range: "  + detailStartMom.toDate() + " to " + detailEndMom.toDate() +  "</small>";
      $("#detailsrange").html("<small>Details range: "  + detailStartMom.toDate() + " to " + detailEndMom.toDate() +  "</small>");
      self.graphDataProvider.loadData("temperature", null,
      null, detailStartMom.toDate(), detailEndMom.toDate(), self.$graphCont.width(),"week");
    });
  };


  JGS.Barplot.prototype._setupRangeButtons = function () {
    var self = this;
    this.$rangeBtnsCont.children().on('click', function (evt) {
      // evt.preventDefault(); // depreciated!!!
      evt.defaultPrevent;
      var rangeType = evt.target.name.toString().replace("range-btn-", "");
      self.waitingOption = evt.target.name.toString();
      //  var te = self.$rangeBtnsCont.children().find('.active').attr("name");
      //  alert(te);
      self.$rangeBtnsCont.children().removeClass('active');
      $(this).addClass('active');

      var rangeEndMom;
      rangeEndMom = moment();
      rangeEndMom.minutes(0).seconds(0);
      rangeEndMom.add('hour', 1);
      //console.log("rangeType: ", rangeType);

      var rangeStartMom;
      var barWidth;
      if (rangeType == "1d") {
        rangeStartMom = moment(rangeEndMom).add('day', -1);
        barWidth = "hour";
        $("#rangeLabel").html("<small>One day range, each bar stands for one hour</small>");
      } else if (rangeType == "1w") {
        rangeStartMom = moment(rangeEndMom).add('week', -1);
        barWidth = "day";
        $("#rangeLabel").html("<small>One week range, each bar stands for one day</small>");
      } else if (rangeType == "1m") {
        rangeStartMom = moment(rangeEndMom).add('month', -1);
        barWidth = "day";
        $("#rangeLabel").html("<small>One month range, each bar stands for one day</small>");
      } else if (rangeType == "3m") {
        rangeStartMom = moment(rangeEndMom).add('month', -3);
        barWidth = "week";
        $("#rangeLabel").html("<small>Three months range, each bar stands for one week</small>");
      } else if (rangeType == "6m") {
        rangeStartMom = moment(rangeEndMom).add('month', -6);
        barWidth = "week";
        $("#rangeLabel").html("<small>Six months range, each bar stands for one week</small>");
      } else if (rangeType == "1y") {
        rangeStartMom = moment(rangeEndMom).add('year', -1);
        barWidth = "month";
        $("#rangeLabel").html("<small>One Year range, each bar stands for one month</small>");
      } else if (rangeType == "2y") {
        rangeStartMom = moment(rangeEndMom).add('year', -2);
        barWidth = "month";
        $("#rangeLabel").html("<small>Two years range, each bar stands for one month</small>");
      } else if (rangeType == "3y") {
        rangeStartMom = moment(rangeEndMom).add('year', -3);
        barWidth = "month";
        $("#rangeLabel").html("<small>Three years range, each bar stands for one month</small>");
      } else if (rangeType == "5y") {
        rangeStartMom = moment(rangeEndMom).add('year', -5);
        barWidth = "month";
        $("#rangeLabel").html("<small>Five years range, each bar stands for one month</small>");
      } else if (rangeType == "ytd") {
        rangeStartMom = moment().startOf('year');
        barWidth = "month";
        $("#rangeLabel").html("<small>Range from start of this year to now, each bar stands for one month</small>");
      }

      //For demo purposes, when range is reset, auto reset detail view to same extents as range
      var detailStartMom = rangeStartMom.clone();
      var detailEndMom = rangeEndMom.clone();

      self.showSpinner(true);
      console.log("button");
      $("#detailsrange").html("<small>Details range: "  + detailStartMom.toDate() + " to " + detailEndMom.toDate() +  "</small>");
      self.graphDataProvider.loadData("temperature",
                                      rangeStartMom.toDate(),
                                      rangeEndMom.toDate(),
                                      detailStartMom.toDate(),
                                      detailEndMom.toDate(),
                                      self.$graphCont.width(),barWidth);

    });

  };

  /**
   * Internal method to add mouse down listener to dygraphs range selector.  Coded so that it can be called
   * multiple times without concern. Although not necessary for simple example (like example1), this becomes necessary
   * for more advanced `exam`ples when the graph must be recreated, not just updated.
   *
   * @method _setupRangeMouseHandling
   * @private
   */
  JGS.Barplot.prototype._setupRangeMouseHandling = function () {
    var self = this;

    // Element used for tracking mouse up events
    this.$mouseUpEventEl = $(window);
    if ($.support.cssFloat == false) { //IE<=8, doesn't support mouse events on window
      this.$mouseUpEventEl = $(document.body);
    }

    //Minor Hack...not sure how else to hook-in to dygraphs range selector events without modifying source. This is
    //where minor modification to dygraphs (range selector plugin) might make for a cleaner approach.
    //We only want to install a mouse up handler if mouse down interaction is started on the range control
    var $rangeEl = this.$graphCont.find('.dygraph-rangesel-fgcanvas, .dygraph-rangesel-zoomhandle');

    //Uninstall existing handler if already installed
    $rangeEl.off("mousedown.jgs touchstart.jgs");

    //Install new mouse down handler
    $rangeEl.on("mousedown.jgs touchstart.jgs", function (evt) {

      //Track that mouse is down on range selector
      self.isRangeSelectorActive = true;

      // Setup mouse up handler to initiate new data load
      self.$mouseUpEventEl.off("mouseup.jgs touchend.jgs"); //cancel any existing
      $(self.$mouseUpEventEl).on('mouseup.jgs touchend.jgs', function (evt) {
        console.log("exmaple 6 range mouse event called")
        self.$mouseUpEventEl.off("mouseup.jgs touchend.jgs");
        //Mouse no longer down on range selector
        self.isRangeSelectorActive = false;
        //Get the new detail window extents
        var graphAxisX = self.graph.xAxisRange();
        self.detailStartDateTm = new Date(graphAxisX[0]);
        self.detailEndDateTm = new Date(graphAxisX[1]);
        console.log(self.detailStartDateTm);
        console.log(self.detailEndDateTm);
        // Load new detail data
        self._loadNewDetailData();
      });

    });

  };

  /**
   * Initiates detail data load request using last known zoom extents
   *
   * @method _loadNewDetailData
   * @private
   */
  JGS.Barplot.prototype._loadNewDetailData = function () {
    console.log("example 6 load new detail data called");
    $('#recreateButton').prop('disabled', false);
    console.log(this.detailStartDateTm);
    console.log(this.detailEndDateTm);
    this.prevLabel = "<small>Details range: "  + moment(this.detailStartDateTm).toDate() + " to " + moment(this.detailEndDateTm).toDate() +  "</small>";
    $("#detailsrange").html("<small>Details range: "  + this.detailStartDateTm + " to "+ this.detailEndDateTm +  "</small>");
    console.log(moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'years', true)));
    console.log(moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'months', true)));
    console.log(moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'weeks', true)));
    console.log(moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'days', true)));
    console.log(moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'hours', true)));
    var monthDiff = moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'months', true));
    var range;
    if (monthDiff >= 12) {
       console.log("month");
       range = "month";
    } else {
      var weekDiff = moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'weeks', true));
      if (weekDiff >= 8) {
          console.log("week");
          range = "week";
      } else {
          var dayDiff = moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'days', true));
          if (dayDiff > 1) {
            console.log("day");
            range = "day";
          } else {
            var hourDiff = moment.duration((moment(this.detailEndDateTm)).diff(moment(this.detailStartDateTm),'hours', true));
            console.log("hour");
            range = "hour";
          }
      }

    }
    //return;
    //this.showSpinner(true);
    this.recreatePara = [this.detailStartDateTm, this.detailEndDateTm, this.$graphCont.width(),range];
    //this.graphDataProvider.loadData("temperature", null, null, this.detailStartDateTm, this.detailEndDateTm, this.$graphCont.width(),range);
  };

  /**
   * Callback handler when new graph data is available to be drawn
   *
   * @param graphData
   * @method _onNewGraphData
   * @private
   */
  JGS.Barplot.prototype._onNewGraphData = function (graphData) {
    this.drawDygraph(graphData);
    this.$rangeBtnsCont.css('visibility', 'visible');
    this.showSpinner(false);
  };

  // Darken a color
  function darkenColor(colorStr) {
          // Defined in dygraph-utils.js
          var color = Dygraph.toRGB_(colorStr);
          color.r = Math.floor((255 + color.r) / 2);
          color.g = Math.floor((255 + color.g) / 2);
          color.b = Math.floor((255 + color.b) / 2);
          return 'rgb(' + color.r + ',' + color.g + ',' + color.b + ')';
  }

  function barChartPlotter(e) {
      var ctx = e.drawingContext;
      var points = e.points;
      var y_bottom = e.dygraph.toDomYCoord(0);
      // console.log("y_bottom: " + y_bottom);
      ctx.fillStyle = darkenColor(e.color);
      // Find the minimum separation between x-values.
      // This determines the bar width.
      var min_sep = Infinity;
      //console.log("points length: " + points.length);
      for (var i = 1; i < points.length; i++) {
        var sep = points[i].canvasx - points[i - 1].canvasx;
        if (sep < min_sep) min_sep = sep;
      }
      //var bar_width = Math.floor(2.0 / 3 * min_sep);
       var bar_width = min_sep;
      // Do the actual plotting.
      for (var i = 0; i < points.length; i++) {
        var p = points[i];
        var center_x = p.canvasx;
        //console.log(center_x);
        ctx.fillRect(center_x - bar_width / 2, p.canvasy,
              bar_width, y_bottom - p.canvasy);
        ctx.strokeRect(center_x - bar_width / 2, p.canvasy,
              bar_width, y_bottom - p.canvasy);
      }
  }

  /**
   * Main method for creating or updating dygraph control
   *
   * @param graphData
   * @method drawDygraph
   */
  JGS.Barplot.prototype.drawDygraph = function (graphData) {
    console.log("demo page 1 drawing data");
    var dyData = graphData.dyData;
    var start = graphData.detailStartDateTm;
    var end = graphData.detailEndDateTm;
    console.log(start);
    console.log(end);
    for (var i = 0; i < dyData.length; i++) {
        if (dyData[i][1] != 0) {
          break;
        } else if (i == (dyData.length-1)) {
          alert("Well, there is no raining in this time range");
          this.$rangeBtnsCont.children().removeClass('active');
          console.log(this.lastOption);
          console.log(this.waitingOption);
          this.$rangeBtnsCont.find("button[name='" + this.lastOption+ "']").addClass('active');
          $("#detailsrange").html(this.prevLabel);
          return;
        }
    }
    this.prevLabel = "<small>Details range: "  + moment(start).toDate() + " to " + moment(end).toDate() +  "</small>";
    this.lastOption  = this.waitingOption;
    var labels = ["time", "Rain fall mm"];
    this.graph = new Dygraph(
                  this.$graphCont.get(0),
                  dyData,
                  {
                    legend: 'always',
                    labels: labels,
                    title: 'Rain Fall Volume in mm',
                    includeZero: true,
                    dateWindow: [start.getTime(), end.getTime()],
                    //dateWindow: [ Date.parse("2012/07/20"), Date.parse("2012/07/26") ],
                    // animatedZooms: true,
                    showRangeSelector: true,
                    // connectSeparatedPoints: true,
                    interactionModel: Dygraph.Interaction.defaultModel,
                    // drawXGrid: false,
                    axes : { x : { drawGrid : false }},
                    zoomCallback: $.proxy(this._onDyZoomCallback, this),
                    plotter: barChartPlotter
                  }
              );
    this._setupRangeMouseHandling();
  };

  /**
   * Dygraphs zoom callback handler
   *
   * @method _onDyZoomCallback
   * @private
   */
  JGS.Barplot.prototype._onDyZoomCallback = function (minDate, maxDate, yRanges) {
    console.log("_onDyZoomCallback");
    this.detailStartDateTm = new Date(minDate);
    this.detailEndDateTm = new Date(maxDate);
    console.log(this.detailStartDateTm);
    console.log(this.detailEndDateTm);
    //When zoom reset via double-click, there is no mouse-up event in chrome (maybe a bug?),
    //so we initiate data load directly
    if (this.graph.isZoomed('x') === false) {
      this.$mouseUpEventEl.off("mouseup.jgs touchend.jgs"); //Cancel current event handler if any
      this._loadNewDetailData();
      return;
    }

    //Check if need to do IE8 workaround
    if ($.support.cssFloat == false) { //IE<=8
      // ie8 calls drawCallback with new dates before zoom. This example currently does not implement the
      // drawCallback, so this example might not work in IE8 currently. This next line _might_ solve, but will
      // result in duplicate loading when drawCallback is added back in.
      this._loadNewDetailData();
      return;
    }

    //The zoom callback is called when zooming via mouse drag on graph area, as well as when
    //dragging the range selector bars. We only want to initiate dataload when mouse-drag zooming. The mouse
    //up handler takes care of loading data when dragging range selector bars.
    var doDataLoad = !this.isRangeSelectorActive;
    if (doDataLoad === true)
      this._loadNewDetailData();
  };

  /**
   * Helper method for showing/hiding spin indicator. Uses spin.js, but this method could just as easily
   * use a simple "data is loading..." div.
   *
   * @method showSpinner
   */
  JGS.Barplot.prototype.showSpinner = function (show) {
    if (show === true) {

      var target = this.$graphCont.get(0);

      if (this.spinner == null) {
        var opts = {
          lines: 13, // The number of lines to draw
          length: 7, // The length of each line
          width: 6, // The line thickness
          radius: 10, // The radius of the inner circle
          corners: 1, // Corner roundness (0..1)
          rotate: 0, // The rotation offset
          color: '#000', // #rgb or #rrggbb
          speed: 1, // Rounds per second
          trail: 60, // Afterglow percentage
          shadow: false, // Whether to render a shadow
          hwaccel: false, // Whether to use hardware acceleration
          className: 'spinner', // The CSS class to assign to the spinner
          zIndex: 2e9, // The z-index (defaults to 2000000000)
        };

        this.spinner = new Spinner(opts);
        this.spinner.spin(target);
        this.spinnerIsSpinning = true;
      } else {
        if (this.spinnerIsSpinning === false) { //else already spinning
          this.spinner.spin(target);
          this.spinnerIsSpinning = true;
        }
      }
    } else if (this.spinner != null && show === false) {
      this.spinner.stop();
      this.spinnerIsSpinning = false;
    }

  };

}(window.JGS = window.JGS || {}, jQuery));
