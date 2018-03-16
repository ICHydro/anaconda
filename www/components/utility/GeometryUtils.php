<?php

namespace app\components\utility;

use yii\helpers\ArrayHelper;

class GeometryUtils
{
    /**
     * Get center of given coordinates array by simply finding the extremal values.
     * @param  array    $coordinates    Each array of coordinate pairs with keys 'lat' and 'lon'
     * @return array                    Center of coordinates
     */
    public static function getCoordsCenter( $coordinates ) {
        $lat = ArrayHelper::getColumn($coordinates, 'lat');
        $lon = ArrayHelper::getColumn($coordinates, 'lon');

        //TODO add some limit validations for lat and lon
        $min_lat = min($lat);
        $max_lat = max($lat);
        $min_lon = min($lon);
        $max_lon = max($lon);

        $lat = $max_lat - (($max_lat - $min_lat) / 2);
        $lon = $max_lon - (($max_lon - $min_lon) / 2);
        return array("lat" => $lat, "lon" => $lon);
    }
}
?>