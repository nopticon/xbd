<?php
/*
<XBD, Extended Browser Detection.>
Copyright (C) <2009>  <Guillermo Azurdia, www.nopticon.com>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// -----------------------------------------------------------------------------------
// NOTES:
//
//
// This library also can handle browser detection of cellphones,
// basic spiders and games consoles!
//
// Cellphones: Nokia, Motorola, Samsung, Sony Ericsson, Blackberry, iPhone and HTC.
// Game consoles: Wii and Playstation
//
// If you need to detect IE, when calling the function must use "msie".
// ("ie" won't work.)
//
// 'version_compare' function is used so you can use the same operator syntax
// http://www.php.net/manual/en/function.version-compare.php
//
// The possible operators are: <, lt, <=, le, >, gt, >=, ge, ==, =, eq, !=, <>, ne respectively.
//
// * XBD 1.1 *
// ==
//
// After a request by email about how to detect OS X version, I've added
// a new argument to return array data based on first argument.
// -----------------------------------------------------------------------------------

require_once('./xbd_object.php');
$xbd = new xbd();

// Return array of browser data
$ret = $xbd->_browser();
_print('All', $ret);

$ret = $xbd->_browser('*');
_print('Useragent string', $ret);

// Return true if using firefox
$ret = $xbd->_browser('firefox');
_print('Firefox', $ret);

// Return true if using IE 7.0 or above else false
$ret = $xbd->_browser('msie', '>= 7.0');
_print('MSIE >= 7.0', $ret);

// Return true if using below firefox 3.0.5 (can check minor version)
$ret = $xbd->_browser('firefox', '< 3.0.5');
_print('Firefox < 3.0.5', $ret);

// Return string of name of browser and version
$ret = $xbd->_browser(false, false, true);
_print('Browser and version', $ret);

// To check if Gecko browser is used
$ret = $xbd->_browser('gecko');
_print('Is Gecko?', $ret);

$ret = $xbd->_browser('firefox', 'le 1.5');
_print('Operator by name (Checking Firefox le 1.5)', $ret);

$ret = $xbd->_browser('firefox', 'ge 3.5.1');
_print('Operator by name (Checking Firefox ge 3.5.1)', $ret);

// -----------------------------------------------------------------------------------
// XBD 1.1 tests.
// -----------------------------------------------------------------------------------

$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-US; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5';

$ret = $xbd->_browser();
_print('Mac useragent', $ret);

// -----------------------------------------------------------------------------------
// XBD 1.0, can return (string) OS X version.
// Or if using OS X (bool)
//
// XBD 1.1, can return an (array) based on first arg.
// -----------------------------------------------------------------------------------
$ret = _browser('os x', false, true);
_print('OS X string', $ret);

$ret = _browser('os x');
_print('OS X bool', $ret);

$ret = _browser('os x', false, false, false, true);
_print('Mac OS X array', $ret);

// -----------------------------------------------------------------------------------
// How to know the Windows version from the client?
//
// I found a useful information page from Microsoft explaining the user agent strings here:
// http://msdn.microsoft.com/en-us/library/ms537503(v=vs.85).aspx
//
// So, getting the "Windows NT" part from the useragent, we can known the Windows version :-)
// -----------------------------------------------------------------------------------

$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9b2pre) Gecko/2007120505 Minefield/3.0b2pre';

$ret = _browser('windows nt', false, false, false, true);

_print('Windows array', $ret);

$windows_array = array(
	'6.1' => 'Windows 7',
	'6.0' => 'Windows Vista',
	'5.2' => 'Windows Server 2003 or Windows XP x64',
	'5.1' => 'Windows XP'
);

if (isset($windows_array[$ret['version']])) {
	_print('Client is using', $windows_array[$ret['version']]);
} else {
	_print('Windows version not found.');
}

// -----------------------------------------------------------------------------------
// Detect if Windows version is below or above a determined version.
// Based on $windows_array you can determine the version number for the condition.
// -----------------------------------------------------------------------------------

$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9b2pre) Gecko/2007120505 Minefield/3.0b2pre';

$windows_array = array(
	'6.1' => 'Windows 7',
	'6.0' => 'Windows Vista',
	'5.2' => 'Windows Server 2003 or Windows XP x64',
	'5.1' => 'Windows XP'
);

$ret = _browser('windows nt', false, false, false, true);

if (isset($ret['version']) && !empty($ret['version'])) {
	$detect_by_name = 'Windows Vista';
	$detect_by_number = array_search($detect_by_name, $windows_array);

	if ($ret['version'] == $detect_by_number) {
		_print('Detected version (' . $windows_array[$ret['version']] . ') is equal to ' . $windows_array[$detect_by_number]);
	} elseif ($ret['version'] <= $detect_by_number) {
		_print('Detected version ' . $windows_array[$ret['version']] . ' is below to ' . $windows_array[$detect_by_number]);
	} else {
		_print('Detected version ' . $windows_array[$ret['version']] . ' is above to ' . $windows_array[$detect_by_number]);
	}
} else {
	_print('Windows version not found.');
}