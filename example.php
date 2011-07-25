<?php
/*
$Id: v 1.4 2009/12/08 11:40:00 $

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

require_once('./xbd.php');

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

// Return array of browser data
$ret = _browser();
_print('All', $ret);

$ret = _browser('*');
_print('Useragent string', $ret);

// Return true if using firefox
$ret = _browser('firefox');
_print('Firefox', $ret);

// Return true if using IE 7.0 or above else false
$ret = _browser('msie', '>= 7.0');
_print('MSIE >= 7.0', $ret);

// Return true if using below firefox 3.0.5 (can check minor version)
$ret = _browser('firefox', '< 3.0.5');
_print('Firefox < 3.0.5', $ret);

// Return string of name of browser and version
$ret = _browser(false, false, true);
_print('Browser and version', $ret);

// To check if Gecko browser is used
$ret = _browser('gecko');
_print('Is Gecko?', $ret);

$ret = _browser('firefox', 'le 1.5');
_print('Operator by name (Checking Firefox le 1.5)', $ret);

$ret = _browser('firefox', 'ge 3.5.1');
_print('Operator by name (Checking Firefox ge 3.5.1)', $ret);

// -----------------------------------------------------------------------------------
// XBD 1.1 tests.
// -----------------------------------------------------------------------------------

$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-US; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5';

$ret = _browser();
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

?>