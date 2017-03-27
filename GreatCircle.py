#!/usr/bin/python

import math

def getRadius(unit):
    r = {'M': 6371009, 'KM': 6371.009, 'MI': 3958.761, 'NM': 3440.070, 'YD': 6967420, 'FT': 20902260}
    if unit in r:
        return r[unit]
    else:
        return unit

def distance(lat1, lon1, lat2, lon2, unit='KM'):
    r = getRadius(unit)
    lat1 = math.radians(lat1)
    lon1 = math.radians(lon1)
    lat2 = math.radians(lat2)
    lon2 = math.radians(lon2)
    londelta = lon2 - lon1
    a = math.pow(math.cos(lat2) * math.sin(londelta), 2) + math.pow(math.cos(lat1) * math.sin(lat2) - math.sin(lat1) * math.cos(lat2) * math.cos(londelta), 2)
    b = math.sin(lat1) * math.sin(lat2) + math.cos(lat1) * math.cos(lat2) * math.cos(londelta)
    angle = math.atan2(math.sqrt(a), b)

    return angle * r

def bearing(lat1, lon1, lat2, lon2):
    lat1 = math.radians(lat1)
    lon1 = math.radians(lon1)
    lat2 = math.radians(lat2)
    lon2 = math.radians(lon2)
    londelta = lon2 - lon1
    y = math.sin(londelta) * math.cos(lat2)
    x = math.cos(lat1) * math.sin(lat2) - math.sin(lat1) * math.cos(lat2) * math.cos(londelta)
    brng = math.atan2(y, x)
    brng *= (180 / math.pi)

    if brng < 0:
        brng += 360

    return brng

def destination(lat1, lon1, brng, dt, unit='KM'):
    r = getRadius(unit)
    lat1 = math.radians(lat1)
    lon1 = math.radians(lon1)
    lat3 = math.asin(math.sin(lat1) * math.cos(dt / r) + math.cos(lat1) * math.sin(dt / r) * math.cos(math.radians(brng)))
    lon3 = lon1 + math.atan2(math.sin(math.radians(brng)) * math.sin(dt / r) * math.cos(lat1) , math.cos(dt / r) - math.sin(lat1) * math.sin(lat3))

    return {'LAT': math.degrees(lat3), 'LON': math.degrees(lon3)}
