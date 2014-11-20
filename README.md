GreatCircle
===========
A set of three functions, useful in geographical calculations of different sorts.

####Distance
Takes two sets of geographic coordinates in decimal degrees and produces distance along the great circle line.
####Bearing
Takes two sets of geographic coordinates in decimal degrees and produces bearing (azimuth) from the first set of coordinates to the second set.
####Destination
Takes one set of geographic coordinates in decimal degrees, azimuth and distance to produce a new set of coordinates, specified distance and bearing away from original.

##Example
Output in kilometers by default, may be changed by specifying Earth radius in different units.

```php
// Distance from London to Paris
echo GreatCircle::distance(51.507222, -0.1275, 48.8567, 2.3508);
// Output: 343.46748684413
    
// Bearing from Paris to London in decimal degrees
echo GreatCircle::bearing(48.8567, 2.3508, 51.507222, -0.1275);
// Output: 330.03509575101
    
// Coordinates of a location 100 KM away from Paris, traveling in the direction of London
$dest = GreatCircle::destination(48.8567, 2.3508, 330, 100);
printf("Latitude: %f, Longitude: %f", $dest["LAT"], $dest["LON"]);
// Output: Latitude: 49.633476, Longitude: 1.656542
```
