<?php

// this script receives a data request via a POST action to extract and downsample a time series.
// It is often invoked twice per page view; once for the "range" TS and once for the "detail" TS.

header('Access-Control-Allow-Origin: *');

// set logging
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
error_log( "Invoked: fetch_single" );

$con = pg_Connect("host=localhost port=5432 dbname=anaconda user=anaconda password=anaconda");
$stat = pg_connection_status($con);
if ($stat === PGSQL_CONNECTION_OK) {
  $queryLine = "";
  $con1 = $_POST["timecondition1"];        // e.g., "2014-08-24 18:00:00"
  $con2 = $_POST["timecondition2"];        // e.g., "2015-05-16 04:50:21"
  $sensor = $_POST["sensor"];              // sensor name
  $req = $_POST["req"];
  $reqType = $req["reqType"];              // either "range" or "detail", both are queried separately 
  $reqNum = $req["reqNum"];                // request number? seems to count up
  $startDateTm = $req["startDateTm"];      // seems the same value as timecondition1 but in different format. WB: do we need this??
  $endDateTm = $req["endDateTm"];          // seems the same value as timeconditions2 but in different format. WB: do we need this??
  $numIntervals = $req["numIntervals"];    // number of datapoints; depends on width of graph in display (e.g., 400)
  $includeMinMax = $req["includeMinMax"];  // true or false

  error_log("Number of intervals: ".$numIntervals);
  $queryLine =  "SELECT timestamp ::timestamp without time zone,value FROM observations WHERE '" . $con1 .
       "' <= timestamp AND timestamp <= '" . $con2 . "' AND sensor_id=". $sensor ." ORDER BY timestamp ASC;";
  error_log($queryLine);
  $result = pg_query($con,$queryLine);
  $status = pg_result_status($result);     // should be 2
  if(($status == 1) || ($status == 2)){
      if ($status == 1) {
        echo 'No data returned';
        pg_close($con);
        return;
        // 1 -> no return data
        //echo " no return data <br>";
      } else {
        // 2-> has return data
        //echo " has return data <br>";
      }
  } else if(($status == 3) || ($status == 4)){
      echo 'Error in retrieving data from database';
      pg_close($con);
      return;
  }
  $resultArray = array();
  $resultArray = pg_fetch_all($result);
//  if($reqType == "detail"){
//    for ($i = 0; $i < 10; $i++) {
//      error_log($resultArray[$i]['timestamp']);
//      error_log($resultArray[$i]['value']);
//    }
//  }
  $dataPoints = array();
  $timePerInterval = (strtotime($con2)*1000 - strtotime($con1)*1000) / $numIntervals;
  $currTime = strtotime($con1)*1000;

  //Find start of load request in the raw dataset
  // (this should be zero with a freshly retrieved dataset but may change when zooming?)
  $currIdx = 0;
  for ($i = 0; $i < sizeof($resultArray); $i++) {
    if (strtotime($resultArray[$currIdx]['timestamp'])*1000 < ($currTime - $timePerInterval)) {
      $currIdx++;
    } else {
      break;
    }
  }
  error_log("currIdx: ".$currIdx);
  error_log("currTime: ".$currTime);
  error_log("endTime: ".strtotime($endDateTm)*1000);

  // Calculate average/min/max while downsampling
  while ($currIdx < sizeof($resultArray) and $currTime < strtotime($con2)*1000) {
    $numPoints = 0;
    $sum = 0;
    $min = 9007199254740992;
    $max = -9007199254740992;
    //echo "compare : ", strtotime($resultArray[$currIdx][time])*1000 ,"   " , $currTime, "\n";
    while ($currIdx < sizeof($resultArray) and strtotime($resultArray[$currIdx]['timestamp'])*1000 < $currTime) {
      $sum += $resultArray[$currIdx]['value'];
      $min = min($min, $resultArray[$currIdx]['value']);
      $max = max($max, $resultArray[$currIdx]['value']);
      $currIdx++;
      $numPoints++;
    }
//    error_log("numberpoints: ".$numPoints);
    if ($numPoints == 0) {
      if ($includeMinMax) {
        array_push($dataPoints, array(
          'x' => $currTime,
          'avg' => null,
          'min' => null,
          'max' => null
        ));
      } else {
        array_push($dataPoints, array(
          'x' => $currTime,
          'avg' => null
        ));
      }
    } else { // numPoints != 0
      $avg = $sum / $numPoints;

      if ($includeMinMax) {
        array_push($dataPoints, array(
            'x' => $currTime,
            'avg' => round($avg, 2),
            'min' => round($min, 2),
            'max' => round($max, 2),
          ));
        } else {
          array_push($dataPoints, array(
            'x' => $currTime,
            'avg' => round($avg,2)
          ));
        }
      }
      $currTime += $timePerInterval;
      $currTime = round($currTime, 2);
    }
    error_log("Number of datapoints returned: ".sizeof($dataPoints));
    $jsondata = json_encode($dataPoints);
    echo $jsondata;
  } else {
    echo 'Database Connection status bad';
  }
  pg_close($con);
?>
