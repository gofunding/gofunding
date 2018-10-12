<?php
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
namespace app\widgets\MobileDetect;

require_once 'Mobile_Detect.php';
class Detect {
	private static $ipAddress = null;
	private static $ipUrl = null;
	private static $ipInfo = null;
	private static $ipInfoError = false;
	private static $ipInfoSource = null;
	private static $ipInfoHostname = null;
	private static $ipInfoOrg = null;
	private static $ipInfoCountry = null;
	#private static $ipInfoLatitude = null;
	#private static $ipInfoLongitude = null;
	#private static $ipInfoAddress = null;
	private static $detect = null;

	public static function init() {
		self::$detect = new Mobile_Detect();
		self::$detect->setDetectionType(Mobile_Detect::DETECTION_TYPE_EXTENDED);
		self::getIp();
	}

	private static function getIp() {
		#self::$setDetectionType(Mobile_Detect::DETECTION_TYPE_EXTENDED);
		if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) { self::$ipAddress = $_SERVER['HTTP_CLIENT_IP']; }
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { self::$ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR']; }
		else { self::$ipAddress = $_SERVER['REMOTE_ADDR']; }
		if (in_array(self::$ipAddress, array('::1', '127.0.0.1', 'localhost'))) {
			self::$ipAddress = 'localhost';
			self::$ipUrl = '';
		} else {
			self::$ipUrl = '/' . self::$ipAddress;
		}
	}

	public static function isMobile() {
		return self::$detect->isMobile();
	}

	public static function isTablet() {
		return self::$detect->isTablet();
	}

	public static function isPhone() {
		return (self::$detect->isMobile() ? (self::$detect->isTablet() ? false : true) : false);
	}

	public static function isComputer() {
		return (self::$detect->isMobile() ? false : true);
	}

	public static function deviceType() {
		return (self::$detect->isMobile() ? (self::$detect->isTablet() ? 'Tablet' : 'Phone') : 'Computer');
	}

	public static function version($var) {
		return self::$detect->version($var);
	}
	
	public static function isEdge() {
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/Edge\/\d+/', $agent)) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function __callStatic($name, $arguments) {
		if (substr($name, 0, 2) != 'is') {
			$trace = current(debug_backtrace());
            Debug::error('No such method exists: ' . $name, $trace);
			return null;
		} else {
			return self::$detect->{$name}();
		}
	}

	public static function brand() {
		#$agent = $_SERVER['HTTP_USER_AGENT'];
		$brand = 'Unknown Brand';
		switch (self::deviceType()) {
		case 'Phone':
			foreach(self::$detect->getPhoneDevices() as $name => $regex) {
				$check = self::$detect->{'is'.$name}();
				if ($check !== false) { $brand = $name; }
			}
			return $brand;
		case 'Tablet':
			foreach(self::$detect->getTabletDevices() as $name => $regex) {
				$check = self::$detect->{'is'.$name}();
				if ($check !== false) { $brand = str_replace('Tablet', '', $name); }
			}
			return $brand;
			break;
		case 'Computer':
			return $brand;
			break;
		}
	}

	public static function os() {
		#self::$getOperatingSystems();
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$version = '';
		$codeName = '';
		$os = 'Unknown OS';
		foreach(self::$detect->getOperatingSystems() as $name => $regex) {
			$check = self::$detect->version($name);
			if ($check !== false) { $os = $name . ' ' . $check; }
			break;
		}
		if (self::$detect->isAndroidOS()) {
			if (self::$detect->version('Android') !== false) {
				$version = ' ' . self::$detect->version('Android');
				switch (true) {
                    case self::$detect->version('Android') >= 8.0: $codeName = ' (Oreo)'; break;
					case self::$detect->version('Android') >= 7.0: $codeName = ' (Nougat)'; break;
                    case self::$detect->version('Android') >= 6.0: $codeName = ' (Marshmallow)'; break;
                    case self::$detect->version('Android') >= 5.0: $codeName = ' (Lollipop)'; break;
					case self::$detect->version('Android') >= 4.4: $codeName = ' (KitKat)'; break;
					case self::$detect->version('Android') >= 4.1: $codeName = ' (Jelly Bean)'; break;
					case self::$detect->version('Android') >= 4.0: $codeName = ' (Ice Cream Sandwich)'; break;
					case self::$detect->version('Android') >= 3.0: $codeName = ' (Honeycomb)'; break;
					case self::$detect->version('Android') >= 2.3: $codeName = ' (Gingerbread)'; break;
					case self::$detect->version('Android') >= 2.2: $codeName = ' (Froyo)'; break;
					case self::$detect->version('Android') >= 2.0: $codeName = ' (Eclair)'; break;
					case self::$detect->version('Android') >= 1.6: $codeName = ' (Donut)'; break;
					case self::$detect->version('Android') >= 1.5: $codeName = ' (Cupcake)'; break;
					default: $codeName = ''; break;
				}
			}
			$os = 'Android' . $version . $codeName;
		} elseif (preg_match('/Linux/', $agent)) {
			$os = 'Linux';
		} elseif (preg_match('/Mac OS X/', $agent)) {
			if (preg_match('/Mac OS X 10_13/', $agent) || preg_match('/Mac OS X 10.13/', $agent)) {
				$os = 'OS X (High Sierra)';
			} elseif (preg_match('/Mac OS X 10_12/', $agent) || preg_match('/Mac OS X 10.12/', $agent)) {
				$os = 'OS X (Sierra)';
			} elseif (preg_match('/Mac OS X 10_11/', $agent) || preg_match('/Mac OS X 10.11/', $agent)) {
				$os = 'OS X (El Capitan)';
			} elseif (preg_match('/Mac OS X 10_10/', $agent) || preg_match('/Mac OS X 10.10/', $agent)) {
				$os = 'OS X (Yosemite)';
			} elseif (preg_match('/Mac OS X 10_9/', $agent) || preg_match('/Mac OS X 10.9/', $agent)) {
				$os = 'OS X (Mavericks)';
			} elseif (preg_match('/Mac OS X 10_8/', $agent) || preg_match('/Mac OS X 10.8/', $agent)) {
				$os = 'OS X (Mountain Lion)';
			} elseif (preg_match('/Mac OS X 10_7/', $agent) || preg_match('/Mac OS X 10.7/', $agent)) {
				$os = 'Mac OS X (Lion)';
			} elseif (preg_match('/Mac OS X 10_6/', $agent) || preg_match('/Mac OS X 10.6/', $agent)) {
				$os = 'Mac OS X (Snow Leopard)';
			} elseif (preg_match('/Mac OS X 10_5/', $agent) || preg_match('/Mac OS X 10.5/', $agent)) {
				$os = 'Mac OS X (Leopard)';
			} elseif (preg_match('/Mac OS X 10_4/', $agent) || preg_match('/Mac OS X 10.4/', $agent)) {
				$os = 'Mac OS X (Tiger)';
			} elseif (preg_match('/Mac OS X 10_3/', $agent) || preg_match('/Mac OS X 10.3/', $agent)) {
				$os = 'Mac OS X (Panther)';
			} elseif (preg_match('/Mac OS X 10_2/', $agent) || preg_match('/Mac OS X 10.2/', $agent)) {
				$os = 'Mac OS X (Jaguar)';
			} elseif (preg_match('/Mac OS X 10_1/', $agent) || preg_match('/Mac OS X 10.1/', $agent)) {
				$os = 'Mac OS X (Puma)';
			} elseif (preg_match('/Mac OS X 10/', $agent)) {
				$os = 'Mac OS X (Cheetah)';
			}
		} elseif (self::$detect->isWindowsPhoneOS()) {
			//$icon = 'windowsphone8';
			if (self::$detect->version('WindowsPhone') !== false) {
				$version = ' ' . self::$detect->version('WindowsPhoneOS');
				/*switch (true) {
					case $version >= 8: $icon = 'windowsphone8'; break;
					case $version >= 7: $icon = 'windowsphone7'; break;
					default: $icon = 'windowsphone8'; break;
				}*/
			}
			$os = 'Windows Phone' . $version;
		} elseif (self::$detect->version('Windows NT') !== false) {
			switch (self::$detect->version('Windows NT')) {
				case 10.0: $codeName = ' 10'; break;
				case 6.3: $codeName = ' 8.1'; break;
				case 6.2: $codeName = ' 8'; break;
				case 6.1: $codeName = ' 7'; break;
				case 6.0: $codeName = ' Vista'; break;
				case 5.2: $codeName = ' Server 2003; Windows XP x64 Edition'; break;
				case 5.1: $codeName = ' XP'; break;
				case 5.01: $codeName = ' 2000, Service Pack 1 (SP1)'; break;
				case 5.0: $codeName = ' 2000'; break;
				case 4.0: $codeName = ' NT 4.0'; break;
				default: $codeName = ' NT v' . self::$detect->version('Windows NT'); break;
			}
			$os = 'Windows' . $codeName;
		} elseif (self::$detect->isiOS()) {
            if (self::$detect->isTablet()) {
                $version = ' ' . self::$detect->version('iPad');
            } else {
                $version = ' ' . self::$detect->version('iPhone');
            }
            $os = 'iOS' . $version;
        }
		return $os;

	}
	
	public static function browser() {
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$browser = 'Unknown Browser';
		if (preg_match('/Edge\/\d+/', $agent)) {
			#$browser = 'Microsoft Edge ' . (floatval(self::$detect->version('Edge')) + 8);
			$browser = 'Microsoft Edge ' . str_replace('12', '20', self::$detect->version('Edge'));
		} elseif (self::$detect->version('Trident') !== false && preg_match('/rv:11.0/', $agent)) {
			$browser = 'Internet Explorer 11';
		} else {
			$found = false;
			foreach(self::$detect->getBrowsers() as $name => $regex) {
				$check = self::$detect->version($name);
				if ($check !== false && !$found) {
					$browser = $name . ' ' . $check;
					$found = true;
				}
			}
		}
		return $browser;
	}

	public static function ieCountdown($prependHTML = '', $appendHTML = '') {
		$ieCountdownHTML = '';
		if (self::$detect->version('IE') !== false && self::$detect->version('IE') <= 9) {
			$ieCountdownHTML = $prependHTML . '<a href="';
			if (self::$detect->version('IE') <= 6) {
				$ieCountdownHTML .= 'http://www.ie6countdown.com';
			} elseif (self::$detect->version('IE') <= 7) {
				$ieCountdownHTML .= 'http://www.theie7countdown.com/ie-users-info';
			} elseif (self::$detect->version('IE') <= 8) {
				$ieCountdownHTML .= 'http://www.theie8countdown.com/ie-users-info';
			} elseif (self::$detect->version('IE') <= 9) {
				$ieCountdownHTML .= 'http://www.theie9countdown.com/ie-users-info';
			}
			$ieCountdownHTML .= '" target="_blank"><strong>YOU ARE USING AN OUTDATED BROWSER</strong><br />It is limiting your experience.<br />Please upgrade your browser,<br />or click this link to read more.</a>' . $appendHTML;
		}
		return $ieCountdownHTML;
	}

	public static function ip() {
		if (self::$ipAddress == 'localhost' && is_null(self::$ipInfo) && !self::$ipInfoError) { self::getIpInfo(); }
		return self::$ipAddress;
	}

	private static function getIpInfo() {
		try {
			self::$ipInfo = json_decode(file_get_contents('http://ipinfo.io' . self::$ipUrl . '/json'));
			self::$ipAddress = self::$ipInfo->ip;
			self::$ipInfoHostname = self::$ipInfo->hostname;
			self::$ipInfoOrg = self::$ipInfo->org;
			self::$ipInfoCountry = self::$ipInfo->country;
			#list(self::$ipInfoLatitude, self::$ipInfoLongitude) = explode(',', self::$ipInfo->loc);
			/*try {
				$googleLocation = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . self::$ipInfoLatitude . ',' . self::$ipInfoLongitude . '&sensor=false'));
				self::$ipInfoAddress = $googleLocation->results[2]->formatted_address;
			} catch (Exception  $e) {
				$googleLocation = null;
			}*/
			self::$ipInfoSource = 'ipinfo.io';
			self::$ipInfoError = false;
			return true;
		} catch (Exception  $e) {
			try {
				self::$ipInfo = json_decode(file_get_contents('http://freegeoip.net/json' . self::$ipUrl));
				self::$ipAddress = self::$ipInfo->ip;
				self::$ipInfoCountry = self::$ipInfo->country_code;
				/*self::$ipInfoLatitude = self::$ipInfo->latitude;
				self::$ipInfoLongitude = self::$ipInfo->longitude;*/
				/*try {
					$googleLocation = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . self::$ipInfoLatitude . ',' . self::$ipInfoLongitude . '&sensor=false'));
					self::$ipInfoAddress = $googleLocation->results[2]->formatted_address;
				} catch (Exception  $e) {
					$googleLocation = null;
				}*/
				self::$ipInfoSource = 'freegeoip.net';
				self::$ipInfoError = false;
				return true;
			} catch (Exception  $e) {
				self::$ipInfo = null;
				self::$ipInfoSource = null;
				self::$ipInfoError = true;
				return false;
			}
		}
	}

	public static function ipInfoSrc() {
		if (is_null(self::$ipInfo) && !self::$ipInfoError) { self::getIpInfo(); }
		return self::$ipInfoSource;
	}

	public static function ipHostname() {
		if (is_null(self::$ipInfo) && !self::$ipInfoError) { self::getIpInfo(); }
		return self::$ipInfoHostname;
	}

	public static function ipOrg() {
		if (is_null(self::$ipInfo) && !self::$ipInfoError) { self::getIpInfo(); }
		return self::$ipInfoOrg;
	}

	public static function ipCountry() {
		if (is_null(self::$ipInfo) && !self::$ipInfoError) { self::getIpInfo(); }
		return self::$ipInfoCountry;
	}

	/*public static function ipLatitude() {
		if (is_null(self::$ipInfo) && !self::$ipInfoError) { self::getIpInfo(); }
		return self::$ipInfoLatitude;
	}

	public static function ipLongitude() {
		if (is_null(self::$ipInfo) && !self::$ipInfoError) { self::getIpInfo(); }
		return self::$ipInfoLongitude;
	}

	public static function ipLocation() {
		if (is_null(self::$ipInfo) && !self::$ipInfoError) { self::getIpInfo(); }
		return self::$ipInfoAddress;
	}*/

}

class Debug {
	public static function error($message = null, $trace) {
		echo $message . ', in <strong>' . $trace['file'] . '</strong> on line <strong>' . $trace['line'] . '</strong>';
	}
}

Detect::init();