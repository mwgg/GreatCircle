GreatCircle
===========
A set of three functions, useful in geographical calculations of different sorts. Available for PHP, Python, Javascript and Ruby.

[Live demo](http://mw.gg/gc/) of the JavaScript implementation.

### Usage with node.js
Install npm module `great-circle`
```
npm install great-circle
```
Usage in node.js or with browserify
```javascript
var GreatCircle = require('great-circle')
```
### Distance
Takes two sets of geographic coordinates in decimal degrees and produces distance along the great circle line. Output in kilometers by default.

PHP:
```php
// Distance from London to Paris
echo GreatCircle::distance(51.507222, -0.1275, 48.8567, 2.3508);
// Output: 343.46748684413
```
Python:
```python
print( GreatCircle.distance(51.507222, -0.1275, 48.8567, 2.3508) )
```
JavaScript:
```javascript
document.write ( GreatCircle.distance(51.507222, -0.1275, 48.8567, 2.3508) );
```
Ruby
```ruby
puts GreatCircle.distance(51.507222, -0.1275, 48.8567, 2.3508)
```
Optional fifth argument allows to specify desired units:
* M - meters
* KM - kilometers
* MI - miles
* NM - nautical miles
* YD - yards
* FT - feet

```php
// Distance from JFK airport to La Guardia airport in feet
echo GreatCircle::distance(40.63980103, -73.77890015, 40.77719879, -73.87259674, "FT");
// Output: 56425.612628758
```
The optional argument can also be passed in form of planet radius in any unit, to produce output in this unit.
```php
// Distance between North and South poles on Mars (3389.5 is mean radius of Mars in kilometers)
echo GreatCircle::distance(90, 0, -90, 0, 3389.5);
// Output: 10648.428299343
```
```php
// Distance between Moscow and New York in furlongs (31670.092 is Earth radius in furlongs)
echo GreatCircle::distance(55.75, 37.616667, 40.7127, -74.0059, 31670.092);
// Output: 37335.295755141
```
### Bearing
Takes two sets of geographic coordinates in decimal degrees and produces bearing (azimuth) from the first set of coordinates to the second set.
```php
// Bearing from Paris to London in decimal degrees
echo GreatCircle::bearing(48.8567, 2.3508, 51.507222, -0.1275);
// Output: 330.03509575101
```
### Destination
Takes one set of geographic coordinates in decimal degrees, azimuth and distance to produce a new set of coordinates, specified distance and bearing away from original.
```php
// Coordinates of a location 100 KM away from Paris, traveling in the direction of London
$dest = GreatCircle::destination(48.8567, 2.3508, 330.035, 100);
printf("Latitude: %f, Longitude: %f", $dest["LAT"], $dest["LON"]);
// Output: Latitude: 49.633753, Longitude: 1.657274
```
Just like Distance, Destination assumes entered distance is in kilometers, but takes an optional argument to specify desired unit.
```php
// Coordinates of a location 500 nautical miles away from Paris, traveling in the direction of New York
$brg = GreatCircle::bearing(48.8567, 2.3508, 40.7127, -74.0059);
$dest = GreatCircle::destination(48.8567, 2.3508, $brg, 500, "NM");
printf("Latitude: %f, Longitude: %f", $dest["LAT"], $dest["LON"]);
// Output: Latitude: 51.306719, Longitude: -10.071875
```
