{
    "id":"<?php echo $location->id ?>",
    "name":<?php echo json_encode($location->name) ?>,
    "description":<?php echo json_encode($location->description) ?>,
    "sensors": {
		<?php 
		$i = 0;
		foreach ($location->sensors as $sensor) {
			echo ($i++ == 0)?"":", ";
			echo '"'. $sensor->id.'": '.json_encode($sensor->name);
		} ?>
	}
}