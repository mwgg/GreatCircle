<?php
Class GreatCircle {

    // Takes two sets of geographic coordinates in decimal degrees and produces distance along the great circle line.
    public static function distance($lat1, $lon1, $lat2, $lon2) {
        $r = 6371; // Earth radius in KM. Use radius in different units for results in those units.
        
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
        $lonDelta = $lon2 - $lon1;
        $a = pow(cos($lat2) * sin($lonDelta) , 2) + pow(cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($lonDelta) , 2);
        $b = sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lonDelta);
        $angle = atan2(sqrt($a) , $b);

        return $angle * $r;
    }

    // Takes two sets of geographic coordinates in decimal degrees and produces bearing (azimuth) from the first set of coordinates to the second set.
    public static function bearing($lat1, $lon1, $lat2, $lon2) {
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
        $lonDelta = $lon2 - $lon1;
        $y = sin($lonDelta) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($lonDelta);
        $brng = atan2($y, $x);
        $brng = $brng * (180 / pi());
        
        return ($brng + 360);
    }

    // Takes one set of geographic coordinates in decimal degrees, azimuth and distance to produce a new set of coordinates, specified distance and bearing away from original.
    public static function destination($lat1, $lon1, $brng, $dt) {
        $r = 6371; // Earth radius in KM.
        
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat3 = asin(sin($lat1) * cos($dt / $r) + cos($lat1) * sin($dt / $r) * cos(deg2rad($brng)));
        $lon3 = $lon1 + atan2(sin(deg2rad($brng)) * sin($dt / $r) * cos($lat1) , cos($dt / $r) - sin($lat1) * sin($lat3));
        return array(
            "LAT" => rad2deg($lat3) ,
            "LON" => rad2deg($lon3)
        );
    }
}
?>
