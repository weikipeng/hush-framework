<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Util
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */

/**
 * @package Hush_Util
 */
class Hush_Util
{
	/**
	 * Md5 encode triple
	 * @static
	 * @param mixed $var
	 * @return unknown
	 */
	public static function md5 ($str) 
	{
		return md5(md5(md5($str)));
	}
	
	/**
	 * Print data structure in better format
	 * @static
	 * @param mixed $var
	 * @return unknown
	 */
	public static function dump ($var) 
	{
		echo '<pre>';
		if (is_array($var)) print_r($var); 
		elseif (is_string($var)) echo $var;
		else var_dump($var);
		echo '</pre>';
	}
	
	/**
	 * Trace exception for more readable
	 * @static
	 * @param Exception $e
	 * @return unknown
	 */
	public static function trace (Exception $e) 
	{
		require_once 'Hush/Exception.php';
		$he = new Hush_Exception($e->getMessage());
		echo '<pre>';
		echo 'Caught Hush Exception at ' . date('Y-m-d H:i:s') . ' : '.$he->getMessage() . "\n";
		echo $he->getTraceAsString() . "\n";
		echo '</pre>';
	}
	
	/**
	 * Get all http request
	 * @static
	 * @see Hush_Page
	 * @param string $pname request name
	 * @param mixed $value
	 * @return mixed
	 */
	public static function param ($pname, $value = null) 
	{
		// set into $_REQUEST array
		if ($value) $_REQUEST[$pname] = $value;
		// get from $_REQUEST array
		if (array_key_exists($pname, $_REQUEST)) {
			return is_string($_REQUEST[$pname]) ? trim($_REQUEST[$pname]) : $_REQUEST[$pname];
		}
		return null;
	}
	
	/**
	 * Get all cookies
	 * @static
	 * @see Hush_Page
	 * @param string $cname cookie name
	 * @param mixed $value
	 * @return mixed
	 */
	public static function cookie ($cname, $value = null) 
	{
		// set into $_COOKIE array
		if ($value === '') unset($_SESSION[$cname]);
		// set into $_COOKIE array
		if ($value) $_COOKIE[$cname] = $value;
		// get from $_COOKIE array
		if (array_key_exists($cname, $_COOKIE)) {
			return is_string($_COOKIE[$cname]) ? trim($_COOKIE[$cname]) : $_COOKIE[$cname];
		}
		return null;
	}
	
	/**
	 * Get all sessions
	 * @static
	 * @see Hush_Page
	 * @param string $sname session name
	 * @param mixed $value
	 * @return mixed
	 */
	public static function session ($sname, $value = null) 
	{
		// start session first
		if (!$_SESSION) session_start();
		// set into $_SESSION array
		if ($value === '') unset($_SESSION[$sname]);
		// set into $_SESSION array
		if ($value) $_SESSION[$sname] = $value;
		// get from $_SESSION array
		if (array_key_exists($sname, $_SESSION)) {
			return is_string($_SESSION[$sname]) ? trim($_SESSION[$sname]) : $_SESSION[$sname];
		}
		return null;
	}
	
	/**
	 * Client Ip address
	 * @static
	 * @return string
	 */
	public static function clientip () 
	{
		return $_SERVER['REMOTE_ADDR'];
	}
	
	/**
	 * Get server hostname
	 * Usually be used in cli script
	 * @static
	 * @return string
	 */
	public static function hostname ()
	{
		if (isset($_SERVER['HOST'])) return $_SERVER['HOST'];
		if (isset($_SERVER['HOSTNAME'])) return $_SERVER['HOSTNAME'];
		if (isset($_SERVER['SERVER_NAME'])) return $_SERVER['SERVER_NAME'];
		if (isset($_SERVER['SERVER_ADDR'])) return $_SERVER['SERVER_ADDR'];
		return 'localhost';
	}
	
	/**
	 * Redirect page request by javascript
	 * @static
	 * @param string $url
	 * @return unknown
	 */
	public static function jsRedirect ($url) 
	{
		echo "<script type=\"text/javascript\">location.href='".str_replace("'", "\'", $url)."'</script>";
		exit;
	}
	
	/**
	 * Redirect page request by meta
	 * You could set your timeout seconds
	 * @static
	 * @param string $url
	 * @param int $sec
	 * @return unknown
	 */
	public static function metaRedirect ($url, $sec = 0) 
	{
		echo "<meta http-equiv=\"refresh\" content=\"{$sec};url={$url}\" />";
		exit;
	}
	
	/**
	 * Redirect page request by header status
	 * Allow setting http status by yourself
	 * @static
	 * @param string $url
	 * @param int $status Http status such as 302, 301, 404, 500 etc.
	 * @return unknown
	 */
	public static function headerRedirect ($url, $status = 302) 
	{
		if ($status) self::HTTPStatus($status);
		header("Location: {$url}");
		exit;
	}

	/**
	 * HTTP Protocol defined status codes
	 * @static
	 * @param int $num
	 * @return unknown
	 */
	public static function HTTPStatus ($num) 
	{
	
		static $http = array (
			100 => "HTTP/1.1 100 Continue",
			101 => "HTTP/1.1 101 Switching Protocols",
			200 => "HTTP/1.1 200 OK",
			201 => "HTTP/1.1 201 Created",
			202 => "HTTP/1.1 202 Accepted",
			203 => "HTTP/1.1 203 Non-Authoritative Information",
			204 => "HTTP/1.1 204 No Content",
			205 => "HTTP/1.1 205 Reset Content",
			206 => "HTTP/1.1 206 Partial Content",
			300 => "HTTP/1.1 300 Multiple Choices",
			301 => "HTTP/1.1 301 Moved Permanently",
			302 => "HTTP/1.1 302 Found",
			303 => "HTTP/1.1 303 See Other",
			304 => "HTTP/1.1 304 Not Modified",
			305 => "HTTP/1.1 305 Use Proxy",
			307 => "HTTP/1.1 307 Temporary Redirect",
			400 => "HTTP/1.1 400 Bad Request",
			401 => "HTTP/1.1 401 Unauthorized",
			402 => "HTTP/1.1 402 Payment Required",
			403 => "HTTP/1.1 403 Forbidden",
			404 => "HTTP/1.1 404 Not Found",
			405 => "HTTP/1.1 405 Method Not Allowed",
			406 => "HTTP/1.1 406 Not Acceptable",
			407 => "HTTP/1.1 407 Proxy Authentication Required",
			408 => "HTTP/1.1 408 Request Time-out",
			409 => "HTTP/1.1 409 Conflict",
			410 => "HTTP/1.1 410 Gone",
			411 => "HTTP/1.1 411 Length Required",
			412 => "HTTP/1.1 412 Precondition Failed",
			413 => "HTTP/1.1 413 Request Entity Too Large",
			414 => "HTTP/1.1 414 Request-URI Too Large",
			415 => "HTTP/1.1 415 Unsupported Media Type",
			416 => "HTTP/1.1 416 Requested range not satisfiable",
			417 => "HTTP/1.1 417 Expectation Failed",
			500 => "HTTP/1.1 500 Internal Server Error",
			501 => "HTTP/1.1 501 Not Implemented",
			502 => "HTTP/1.1 502 Bad Gateway",
			503 => "HTTP/1.1 503 Service Unavailable",
			504 => "HTTP/1.1 504 Gateway Time-out"
		);
	
		header($http[$num]);
	}
	
	/**
	 * Flush output buffer
	 * @static
	 */
	public static function flush() 
	{
		ob_flush();
		flush();
	}
	
	/**
	 * Get remote url content by curl client
	 * @static
	 * @param string $file
	 * @param int $timeout
	 * @return string
	 */
	public static function curl ($file = '', $timeout = 0) 
	{
		if (!$file && !strlen($file)) return "";
		$to = isset($timeout) ? $timeout : 5;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, $to);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $file);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	/**
	 * Get array deepest level
	 * @static
	 * @param array $array
	 * @return int
	 */
	public static function array_depth ($array) 
	{
		$max_depth = 1;
		foreach ((array) $array as $value) {
			if (is_array($value)) {
				$depth = self::array_depth($value) + 1;
				if ($depth > $max_depth) {
					$max_depth = $depth;
				}
			}
		}
		return $max_depth;
	}
	
	/**
	 * Sort hash array by value's key
	 * @static
	 * @param array $array
	 * @param string $key
	 * @param bool $rev
	 * @return array
	 */
	public static function array_sort ($array, $key = '', $rev = false, $flags = SORT_REGULAR)
	{
		// sort functions
		$asort_func = $rev ? 'arsort' : 'asort';
		$ksort_func = $rev ? 'krsort' : 'ksort';
		
		// sort value
		if (!$key) {
			@$asort_func($array, $flags);
			return $array;
		}
		
		// sort key value
		$sort_array = array();
		foreach ((array) $array as $index => $value) {
			if (isset($value[$key])) $sort_array[$value[$key] . ' ' . $index] = $value;
		}
		
		@$ksort_func($sort_array, $flags);
		
		return $sort_array;
	}
	
	/**
	 * Count array value's sum amount
	 * @static
	 * @param array $array
	 * @param string $key
	 * @return int
	 */
	public static function array_sum ($array, $key = '') 
	{
		// count value sum
		if (!$key) return array_sum($array);
		// count key value sum
		$sum_array = array();
		foreach ((array) $array as $value) {
			if (isset($value[$key])) $sum_array[] = intval($value[$key]);
		}
		return array_sum($sum_array);
	}
	
	/**
	 * Insert array item into specific position
	 * @static
	 * @param array $array
	 * @param int $pos
	 * @param mixed $val
	 * @param int $times insert times
	 * @return array
	 */
	public static function array_insert ($array, $pos, $val, $times = 1)
	{
		$array2 = array_splice($array, $pos);
		for ($i = 0; $i < $times; $i++) $array[] = $val;
		$array = array_merge($array, $array2);
		return $array;
	}
	
	/**
	 * Remove some item from the array
	 * @static
	 * @param array $array
	 * @param string $key
	 * @return array
	 */
	public static function array_remove ($array, $key)
	{
		$array2 = array();
		foreach ((array) $array as $k => $v) {
			if ($k == $key || $v == $key) continue;
			$array2[$k] = $v;
		}
		return $array2;
	}
	
	/**
	 * Chop one section from an array
	 * @static
	 * @param array $array
	 * @param int $start
	 * @param int $end
	 * @return array
	 */
	public static function array_chop ($array, $start, $end) 
	{
		if (is_array($array)) {
			return array_slice($array, $start, $end - $start);
		}
		return false;
	}
}