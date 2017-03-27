var GreatCircle = {

    validateRadius: function(unit) {
        var r = {'M': 6371009, 'KM': 6371.009, 'MI': 3958.761, 'NM': 3440.070, 'YD': 6967420, 'FT': 20902260};
        if ( unit in r ) return r[unit];
        else return unit;
    },

    distance: function(lat1, lon1, lat2, lon2, unit) {
        if ( unit === undefined ) unit = 'KM';
        var r = this.validateRadius(unit); 
        lat1 *= Math.PI / 180;
        lon1 *= Math.PI / 180;
        lat2 *= Math.PI / 180;
        lon2 *= Math.PI / 180;
        var lonDelta = lon2 - lon1;
        var a = Math.pow(Math.cos(lat2) * Math.sin(lonDelta) , 2) + Math.pow(Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(lonDelta) , 2);
        var b = Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(lonDelta);
        var angle = Math.atan2(Math.sqrt(a) , b);
        
        return angle * r;
    },
    
    bearing: function(lat1, lon1, lat2, lon2) {
        lat1 *= Math.PI / 180;
        lon1 *= Math.PI / 180;
        lat2 *= Math.PI / 180;
        lon2 *= Math.PI / 180;
        var lonDelta = lon2 - lon1;
        var y = Math.sin(lonDelta) * Math.cos(lat2);
        var x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(lonDelta);
        var brng = Math.atan2(y, x);
        brng = brng * (180 / Math.PI);
        
        if ( brng < 0 ) { brng += 360; }
        
        return brng;
    },
    
    destination: function(lat1, lon1, brng, dt, unit) {
        if ( unit === undefined ) unit = 'KM';
        var r = this.validateRadius(unit);
        lat1 *= Math.PI / 180;
        lon1 *= Math.PI / 180;
        var lat3 = Math.asin(Math.sin(lat1) * Math.cos(dt / r) + Math.cos(lat1) * Math.sin(dt / r) * Math.cos( brng * Math.PI / 180 ));
        var lon3 = lon1 + Math.atan2(Math.sin( brng * Math.PI / 180 ) * Math.sin(dt / r) * Math.cos(lat1) , Math.cos(dt / r) - Math.sin(lat1) * Math.sin(lat3));
        
        return {
            'LAT': lat3 * 180 / Math.PI,
            'LON': lon3 * 180 / Math.PI
        };
    }

}

if (typeof module != 'undefined' && module.exports) {
    module.exports = GreatCircle;
} else {
    window['GreatCircle'] = GreatCircle;
}
