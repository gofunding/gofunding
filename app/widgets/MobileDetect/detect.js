/*!
 * Developed by Kevin Warren, https://twitter.com/KevinTWarren
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 * Detect Device 1.0.4
 *
 * Last Modification Date: 20/11/2017
 */
var detect = {
	screenWidth: function() {
		return window.screen.width;
	},
	screenHeight: function() {
		return window.screen.height;
	},
	viewportWidth: function() {
		return document.documentElement.clientWidth;
	},
	viewportHeight: function() {
		return document.documentElement.clientHeight;
	},
	latitude: function(latitudeId) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById(latitudeId).innerHTML = position.coords.latitude;
			}, function(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        document.getElementById(latitudeId).innerHTML = 'User denied the request for Geolocation.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        document.getElementById(latitudeId).innerHTML = 'Location information is unavailable.';
                        break;
                    case error.TIMEOUT:
                        document.getElementById(latitudeId).innerHTML = 'The request to get user location timed out.';
                        break;
                    case error.UNKNOWN_ERROR:
                        document.getElementById(latitudeId).innerHTML = 'An unknown error occurred.';
                        break;
                }
            });
		}
	},
	longitude: function(longitudeId) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById(longitudeId).innerHTML = position.coords.longitude;
                longitude = position.coords.longitude;
			}, function(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        document.getElementById(longitudeId).innerHTML = 'User denied the request for Geolocation.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        document.getElementById(longitudeId).innerHTML = 'Location information is unavailable.';
                        break;
                    case error.TIMEOUT:
                        document.getElementById(longitudeId).innerHTML = 'The request to get user location timed out.';
                        break;
                    case error.UNKNOWN_ERROR:
                        document.getElementById(longitudeId).innerHTML = 'An unknown error occurred.';
                        break;
                }
            });
		}
	},
	address: function(addressId) {
		var accuracy = 0;
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				$.get('http://maps.googleapis.com/maps/api/geocode/json?latlng='+position.coords.latitude+','+position.coords.longitude+'&sensor=false',function(response) {
					document.getElementById(addressId).innerHTML = response.results[accuracy].formatted_address;
				}, 'json');
			}, function(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        document.getElementById(addressId).innerHTML = 'User denied the request for Geolocation.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        document.getElementById(addressId).innerHTML = 'Location information is unavailable.';
                        break;
                    case error.TIMEOUT:
                        document.getElementById(addressId).innerHTML = 'The request to get user location timed out.';
                        break;
                    case error.UNKNOWN_ERROR:
                        document.getElementById(addressId).innerHTML = 'An unknown error occurred.';
                        break;
                }
            });
		}
	}
};