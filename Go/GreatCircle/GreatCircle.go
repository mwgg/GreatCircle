package GreatCircle

import (
	"math"
)

var FixedValues = map[string]float64{
	"M":  6371009,
	"KM": 6371.009,
	"MI": 3958.761,
	"NM": 3440.070,
	"YD": 6967420,
	"FT": 20902260,
}

type Unit interface {
	validateRadius() float64
}

type UnitFixed string
type UnitValue float64

func (r UnitFixed) validateRadius() float64 {
	return FixedValues[string(r)]
}
func (r UnitValue) validateRadius() float64 {
	return float64(r)
}

func deg2rad(deg float64) float64 {
	return deg * math.Pi / 180
}
func rad2deg(rad float64) float64 {
	return rad * 180 / math.Pi
}

func Distance(lat1 float64, lon1 float64, lat2 float64, lon2 float64, unit Unit) float64 {
	r := unit.validateRadius()
	lat1 = deg2rad(lat1)
	lon1 = deg2rad(lon1)
	lat2 = deg2rad(lat2)
	lon2 = deg2rad(lon2)
	lonDelta := lon2 - lon1
	a := math.Pow(math.Cos(lat2)*math.Sin(lonDelta), 2) + math.Pow(math.Cos(lat1)*math.Sin(lat2)-math.Sin(lat1)*math.Cos(lat2)*math.Cos(lonDelta), 2)
	b := math.Sin(lat1)*math.Sin(lat2) + math.Cos(lat1)*math.Cos(lat2)*math.Cos(lonDelta)
	angle := math.Atan2(math.Sqrt(a), b)

	return angle * r
}

func Bearing(lat1 float64, lon1 float64, lat2 float64, lon2 float64) float64 {
	lat1 = deg2rad(lat1)
	lon1 = deg2rad(lon1)
	lat2 = deg2rad(lat2)
	lon2 = deg2rad(lon2)
	lonDelta := lon2 - lon1
	y := math.Sin(lonDelta) * math.Cos(lat2)
	x := math.Cos(lat1)*math.Sin(lat2) - math.Sin(lat1)*math.Cos(lat2)*math.Cos(lonDelta)
	brng := math.Atan2(y, x)
	brng = brng * (180 / math.Pi)
	if brng < 0 {
		brng += 360
	}

	return brng
}

func Destination(lat1 float64, lon1 float64, brng float64, dt float64, unit Unit) map[string]float64 {
	r := unit.validateRadius()
	lat1 = deg2rad(lat1)
	lon1 = deg2rad(lon1)
	lat3 := math.Asin(math.Sin(lat1)*math.Cos(dt/r) + math.Cos(lat1)*math.Sin(dt/r)*math.Cos(deg2rad(brng)))
	lon3 := lon1 + math.Atan2(math.Sin(deg2rad(brng))*math.Sin(dt/r)*math.Cos(lat1), math.Cos(dt/r)-math.Sin(lat1)*math.Sin(lat3))

	return map[string]float64{
		"LAT": rad2deg(lat3),
		"LON": rad2deg(lon3),
	}
}
