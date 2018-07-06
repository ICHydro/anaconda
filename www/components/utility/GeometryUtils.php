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
        $lat = (max($lat) + min($lat)) / 2;
        $lon = (max($lon) + min($lon)) / 2;
        return array("lat" => $lat, "lon" => $lon);
    }
}
?>