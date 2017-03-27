class GreatCircle
  def self.distance(lat1, lon1, lat2, lon2, unit='KM')
    radius = get_radius unit

    Math::acos(
      Math::sin(to_radians(lat1))*Math::sin(to_radians(lat2)) +
      Math::cos(to_radians(lat1))*Math::cos(to_radians(lat2)) *
      Math::cos(to_radians(lon2-lon1))
    ) * radius
  end

  def self.bearing(lat1, lon1, lat2, lon2)
    lat1 = to_radians lat1
    lat2 = to_radians lat2
    dLon = to_radians lon2-lon1

    y = Math::sin(dLon) * Math::cos(lat2)
    x = Math::cos(lat1) * Math::sin(lat2) -
        Math::sin(lat1) * Math::cos(lat2) * Math::cos(dLon)

    to_bearing Math::atan2(y, x)
  end

  def self.destination(lat1, lon1, brng, distance, unit='KM')
    radius = get_radius unit
    lat1 = to_radians lat1
    lon1 = to_radians lon1
    brng = to_radians brng

    lat2 = Math::asin(
            Math::sin(lat1) * Math::cos(distance/radius) +
            Math::cos(lat1) * Math::sin(distance/radius) *
            Math::cos(brng)
          )

    lon2 = lon1 + Math::atan2(
                    Math::sin(brng) * Math::sin(distance/radius) * Math::cos(lat1),
                    Math::cos(distance/radius) - Math::sin(lat1) * Math::sin(lat2)
                  )

    lon2 = (lon2 + Math::PI) % (2 * Math::PI) - Math::PI

    { 'LAT' => to_degrees(lat2), 'LON' => to_degrees(lon2) }
  end

  private

  # degrees to radians
  def self.to_radians(degrees)
    degrees * Math::PI / 180.0
  end

  # radians to bearing
  def self.to_bearing(radians)
    (to_degrees(radians) + 360.0) % 360.0
  end

  # radians to degree
  def self.to_degrees(radians)
    radians * 180 / Math::PI
  end

  # radius of earth
  def self.get_radius(unit)
    radius = { 'M' => 6371009, 'KM' => 6371.009, 'MI' => 3958.761, 'NM' => 3440.070, 'YD' => 6967420, 'FT' => 20902260 }

    radius[unit] || unit
  end
end
