<?php
header('Access-Control-Allow-Origin: *');
$con = pg_Connect("host=localhost port=5432 dbname=anaconda user=anaconda password=anaconda");
$stat = pg_connection_status($con);
if ($stat === PGSQL_CONNECTION_OK) {
  //  echo 'Connection status ok';
  //  echo "db is connected <br>" ;
  //  echo "requesting data <br>";
  $queryLine = "";
  // echo 'this is an ajax POST acton: <br>';
  // echo 'Thank you '. $_POST['firstname'] . ' ' . $_POST['lastname'] . ', says the PHP file';
  $con1 = $_POST["timecondition1"];
  $con2 = $_POST["timecondition2"];
  $req = $_POST["req"];
  //var_dump($req);
  $reqType = $req["reqType"];
  $reqNum = $req["reqNum"];
  $startDateTm = $req["startDateTm"];
  $endDateTm = $req["endDateTm"];
  $numIntervals = $req["numIntervals"];
  $includeMinMax = $req["includeMinMax"];
  /*["reqType"]
    ["reqNum"]
    ["startDateTm"]
    ["endDateTm"]
    ["numIntervals"]
    ["includeMinMax"]*/
  $queryLine =  "SELECT time ::timestamp without time zone,ptemp_c,battv FROM ic_weatherstation_skempton6 WHERE '" . $con1 .
       "' <= time AND time <= '" . $con2 . "' ORDER BY time ASC;";
  $result = pg_query($con,$queryLine);
  //check result
  // Get the result status
  $status = pg_result_status($result);
  if(($status == 1) || ($status == 2)){
      if ($status == 1) {
        echo 'No return data';
        pg_close($con);
        return;
        // 1 -> no return data
        //echo " no return data <br>";
      } else {
        // 2-> has return data
        //echo " has return data <br>";
      }
  } else if(($status == 3) || ($status == 4)){
      // for copy results;
      echo 'Database error';
      pg_close($con);
      return;
  }
  // echo "got data <br>";
  // print json_encode(array_values(pg_fetch_all($result)));
  // check result
  // Get the result status
  //$status = pg_result_status($result);
  // Determine status
  // for($gt = 0; $gt < pg_num_fields($result); $gt++) {
  //   for($lt = 0; $lt < pg_num_rows($result); $lt++)  {
  //      //  echo pg_result($result, $lt, $gt);
  //   }
  // }
  $resultArray = array();
  $resultArray = pg_fetch_all($result);
  //echo "size of result", sizeof($resultArray), "\n";
  //echo "sample: ", $resultArray[11111][time], "\n";
  //echo "sample2: ", $resultArray[11111][ptemp_c], "\n";
  //  $jsondata   = json_encode($resultArray);
  // This fucntion convert the time stamp got from postgre sql result
  // to the moment.js format, which can be directly input to the data points
  //  console.log("generate server data 2 called, " + resultData.length);
  // resultData.reverse();
  // if (resultData.length == 0) {
  //    console.log("\\\\\\\\\\\\");
  // }
    // console.log("gen2 1: " + resultData[0].time + "  " + resultData[0].ptemp_c);
    //  console.log("gen2 2: " + toTimestamp2(resultData[0].time));
    //  console.log("gen2 3: " + toTimestamp2(resultData[0].time).valueOf());
    //  console.log("gen2 4: " + resultData[resultData.length-1].time + "  " + resultData[resultData.length-1].ptemp_c);
    //  if (i%1000 == 0) {
    //    console.log(xx + "  " + yy);
    //  }
    // console.log(resultData[i].time + "  " + resultData[i].ptemp_c);
    // console.log(data);
    //  console.log("test show data ended");
    //  var l = data.length;
    //  console.log("len: " + l);
    //  console.log(moment(data[0].x).valueOf() + "  " + data[0].y);
    //  console.log(moment(data[l-1].x).valueOf() + "  " + data[l-1].y);
    //  console.log(moment(toTimestamp2(resultData[0].time).valueOf()).format() + "  " + resultData[0].ptemp_c);
    //console.log("loadData2 ", dataLoadReq);
    //console.log("simulator load data 2 called---------");
    //Generate fake raw data set on first call
    //Do down sampling per the dataLoadReq
  //var dataPoints = [];
  $dataPoints = array();
    //console.log(dataLoadReq.numIntervals);
    $timePerInterval = (strtotime($endDateTm)*1000 - strtotime($startDateTm)*1000) / $numIntervals;
    $currTime = strtotime($startDateTm)*1000;
    //console.log("currTime: " + moment(currTime).format());
    //Find start of load request in the raw dataset
    $currIdx = 0;
    //console.log(timePerInterval);
    //console.log(this.serverData.length);
    for ($i = 0; $i < sizeof($resultArray); $i++) {
      // if (i < 10) {
      //   console.log(this.serverData[currIdx].x + "   " + this.serverData[currIdx].y + "  " + (currTime - timePerInterval));
      // }
      if (strtotime($resultArray[$currIdx]['time'])*1000 < ($currTime - $timePerInterval)) {
        $currIdx++;
      } else {
        break;
      }
    }
    //echo "currIdx2: " , $currIdx, "\n";
    //echo "currTime: " , $currTime, "\n";
    //  console.log("currIdx: " + currIdx);
    //  console.log("now x: " + parseInt(this.serverData[currIdx].x));
    //  console.log("index: " + moment(parseInt(this.serverData[currIdx].x)).format());
    // Calculate average/min/max while downsampling
    while ($currIdx < sizeof($resultArray) and $currTime < strtotime($endDateTm)*1000) {
      //for each time interval (Pixel?)
      $numPoints = 0;
      $sum = 0;
      $min = 9007199254740992;
      $max = -9007199254740992;
      $sum2 = 0;
      $min2 = 9007199254740992;
      $max2 = -9007199254740992;
      //echo "compare : ", strtotime($resultArray[$currIdx][time])*1000 ,"   " , $currTime, "\n";
      while ($currIdx < sizeof($resultArray) and strtotime($resultArray[$currIdx]['time'])*1000 < $currTime) {
        $sum += $resultArray[$currIdx]['ptemp_c'];
        $min = min($min, $resultArray[$currIdx]['ptemp_c']);
        $max = max($max, $resultArray[$currIdx]['ptemp_c']);
        $sum2 += $resultArray[$currIdx]['battv'];
        $min2 = min($min2, $resultArray[$currIdx]['battv']);
        $max2 = max($max2, $resultArray[$currIdx]['battv']);
        $currIdx++;
        $numPoints++;
      }
      //echo "numberpoints: " , $numPoints , "\n";
      //console.log("numberpoints: " + numPoints);

      if ($numPoints == 0) {
        if ($includeMinMax) {
          array_push($dataPoints, array(
            'x' => $currTime,
            'avg' => null,
            'min' => null,
            'max' => null,
            'avg2' => null,
            'min2' => null,
            'max2' => null
          ));
        } else {
          array_push($dataPoints, array(
            'x' => $currTime,
            'avg' => null,
            'avg2' => null
          ));
        }
      } else { // numPoints != 0
        $avg = $sum / $numPoints;
        $avg2 = $sum2 / $numPoints;

        if ($includeMinMax) {
          //echo "pushing \n";
          array_push($dataPoints, array(
            'x' => $currTime,
            'avg' => round($avg, 2),
            'min' => round($min, 2),
            'max' => round($max, 2),
            'avg2' => round($avg2, 2),
            'min2' => round($min2, 2),
            'max2' => round($max2, 2)
          ));
        } else {
          //echo "pushing 2\n";
          array_push($dataPoints, array(
            'x' => $currTime,
            'avg' => round($avg, 2),
            'avg2' => round($avg2, 2)
          ));
        }
      }
      $currTime += $timePerInterval;
      $currTime = round($currTime, 2);
    }
    //echo sizeof($dataPoints);
    //print_r($dataPoints);
    $jsondata = json_encode($dataPoints);
    echo $jsondata;
    //  console.log(dataPoints);
    //  console.log("datapoints: " + dataPoints.length);
    //  for (var i = 0; i < dataPoints.length; i++) {
    //    if (i%10 == 0) {
    //       console.log(dataPoints[i].x + "  " + dataPoints[i].avg + " "  + dataPoints[i].min + " "  + dataPoints[i].max);
    //       console.log(dataPoints[i].x + " " + dataPoints[i].avg + " " +dataPoints[i].min + " " +dataPoints[i].max );
    //    }
    //  }
    //  console.log("dataPoints", dataLoadReq, dataPoints);
    //  echo $jsondata;
    //  $myarray = array();
    //  while ($row = pg_fetch_row($result)) {
    //  $myarray[] = $row;
    //  }
    //  $jsondata = json_encode($myarray);
    //  echo "data converted into json: <br>";
    //  echo "printting json result: <br>";
    //  echo $jsondata;
  } else {
    echo 'Database Connection status bad';
  }
  pg_close($con);
?>
