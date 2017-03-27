<?php
Class GreatCircle {

    const M = 6371009;
    const KM = 6371.009;
    const MI = 3958.761;
    const NM = 3440.070;
    const YD = 6967420;
    const FT = 20902260;
    
    private function validateRadius($unit) {
        if ( defined('self::'.$unit) ) { return constant('self::'.$unit); }
        else if ( is_numeric($unit) ) { return $unit; }
        else { throw new Exception('Invalid unit or radius: '.$unit); }
    }

    // Takes two sets of geographic coordinates in decimal degrees and produces distance along the great circle line.
    // Optionally takes a fifth argument with one of the predefined units of measurements, or planet radius in custom units.
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit = KM) {
        $r = self::validateRadius($unit);
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
        
        if ( $brng < 0 ) { $brng += 360; }
        
        return $brng;
    }

    // Takes one set of geographic coordinates in decimal degrees, azimuth and distance to produce a new set of coordinates, specified distance and bearing away from original.
    // Optionally takes a fifth argument with one of the predefined units of measurements or planet radius in custom units.
    public static function destination($lat1, $lon1, $brng, $dt, $unit = KM) {
        $r = self::validateRadius($unit);
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
