<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9;">
  <title>Interactive time series visualization for Anaconda</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<style>
  .graph-cont {
    height: 300px;
    width: 100%;
  }

  .range-btns-cont  {
    display: block;
    float:right;
    visibility: hidden;
    margin: 6px 6px;
  }
</style>
<body>

<!-- <div class="container"> -->
  <div class="col-md-1"> <!-- bootstrap class for full with column -->
      <h4>Sensor:</h4> </div><div class="col-md-3">
<!--    <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sensors
      <span class="caret"></span></button> 
      <ul class="dropdown-menu"> -->
        <?php
          $con = @pg_Connect("host=localhost port=5432 dbname=anaconda user=anaconda password=anaconda");
          $stat = pg_connection_status($con);
          if ($stat === PGSQL_CONNECTION_OK) {
            $queryLine =  "SELECT sensor_id,sensor_name FROM sensors;";
            $result = pg_query($con,$queryLine);
            $resultArray = pg_fetch_all($result);
            echo '<select class="form-control" id="select_sensor">';
            echo '<option value="'.$resultArray[0]['sensor_id'].'" selected>'.$resultArray[0]['sensor_name'].'</option>';
            for ($x = 1; $x < sizeof($resultArray); $x++) {
              echo '<option value="'.$resultArray[$x]['sensor_id'].'">'.$resultArray[$x]['sensor_name'].'</option>';
              // echo '<li><a href="#">'.$resultArray[$x]['sensor_name'].'</a></li>';
            }
            echo '</select>';
            pg_close($con);
          } else {
          echo 'No sensors found - Cannot connect to database';
          }
        ?> </div><div class="col-md-3">
          <button id="refreshButton" class="btn btn-primary" onclick="draw('line')"><span class="glyphicon glyphicon-refresh"></span>
            Load
          </button>

<!--      </ul>
    </div> -->
  </div>
  <div class="col-md-12"> <!-- bootstrap class for full with column -->

     <h3 align="center" id="detailsrange"></h3>

      <!-- div for the actual graph -->
      <div id="graph-cont-1" class="graph-cont">
      </div>
      
      <!-- buttons -->
      <div>
        <span id="range-btns-cont-1" class="btn-group range-btns-cont">
          <button name="range-btn-5y" class="btn btn-default btn-mini">
            5y
          </button>
          <button name="range-btn-3y" class="btn btn-default btn-mini">
            3y
          </button>
          <button name="range-btn-2y" class="btn btn-default btn-mini">
            2y
          </button>
          <button name="range-btn-1y" class="btn btn-default btn-mini">
            1y
          </button>
          <button name="range-btn-ytd" class="btn btn-default  btn-mini">
            YTD
          </button>
          <button name="range-btn-6m" class="btn btn-default btn-mini">
            6m
          </button>
          <button name="range-btn-3m" class="btn btn-default btn-mini">
            3m
          </button>
          <button name="range-btn-1m" class="btn btn-default  btn-mini">
            1m
          </button>
          <button name="range-btn-1w" class="btn btn-default  btn-mini">
            1w
          </button>
          <button name="range-btn-1d" class="btn btn-default btn-mini">
            1d
          </button>
        </span>
      </div> <!-- end buttons -->
    </div> <!-- end col-md-12 -->

 

<!-- </div> -->

<!-- now load required javascript libraries -->

<script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>

<script src="js/lib/json2.js"></script>

<!-- not sure why this is necessary? Apparently for IE8 and older...-->
<!--[if lte IE 8]><script type="text/javascript" src="js/lib/excanvas.js"></script><![endif]-->

<script src="js/JGS.Lineplot.js"></script>
<script src="js/JGS.Barplot.js"></script>
<script src="js/JGS.DataFetcher.js"></script>
<script src="js/JGS.DataFetcherBar.js"></script>
<script src="js/JGS.GraphDataProvider.js"></script>
<script src="js/JGS.GraphDataProviderBar.js"></script>

<!-- and lastly, the code to generate the actual interactive graph: -->

<script>
function draw(type) {
    var pageCfg = {
      $graphCont: $("#graph-cont-1"),
      $rangeBtnsCont: $("#range-btns-cont-1")
    };
    if(type == "line") {
      var graph = new JGS.Lineplot(pageCfg);
    } else {
      var graph = new JGS.Barplot(pageCfg);
    }
    graph.init();
  };

</script>

<script>
  $(document).ready(draw("line"));
</script>



</body>
</html>
