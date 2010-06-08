<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Db
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

/**
 * @see Zend_Db
 */
require_once 'Zend/Db.php';
require_once 'Zend/Db/Exception.php';
require_once 'Hush/Db/Exception.php';

/**
 * @package Hush_Db
 */
class Hush_Db extends Zend_Db
{
	/**
	 * @static
	 */
	const ADAPTER_NAME_SPACE = 'Hush_Db_Adapter'; // default name space
	
	/**
	 * Db links' pool array
	 * @var array
	 */
	public static $db_pool = array();
	
	/**
	 * Db file name
	 * @var string
	 */
	public static $db_file = '';
	
	/**
	 * Db link configuration
	 * @var Zend_Db_Adaptor
	 */
	public static $db_link = null;
	
	/**
	 * Db prefix string
	 * @var string
	 */
	public static $db_pref = null;
	
	/**
	 * Db adaptor factory
	 * @static
	 * @param mixed $adapter Can be 'MYSQLI', 'ORACLE'...
	 * @param array $config
	 * @return Zend_Db_Adaptor
	 */
	public static function factory($adapter, $config = array())
	{
		if (!is_array($config)) {
			throw new Zend_Db_Exception("Adapter parameters must be in an array or a Zend_Config object");
		}
		
		if (!is_string($adapter) || empty($adapter)) {
			throw new Zend_Db_Exception("Adapter name must be specified in a string");
		}
		
		$adapterNameSpace = self::ADAPTER_NAME_SPACE;
		$adapterName = $adapterNameSpace . '_' . str_replace(' ', '_', ucwords(str_replace('_', ' ', strtolower($adapter))));
		$adapterFile = str_replace('_', DIRECTORY_SEPARATOR, $adapterName) . '.php';
		
		if (!class_exists($adapterName)) {
			require_once $adapterFile;
		}
		
		$dbAdapter = new $adapterName($config);
		
        if (! $dbAdapter instanceof Zend_Db_Adapter_Abstract) {
            throw new Zend_Db_Exception("Adapter class '$adapterName' does not extend Zend_Db_Adapter_Abstract");
        }

        return $dbAdapter;
	}
	
	/**
	 * Make db pool from db link's ini file
	 * @param string $db_link_ini
	 * @return array
	 */
	public static function pool ($db_file_ini) 
	{
		if (!is_readable($db_file_ini)) {
			throw new Hush_Db_Exception('Could not read db config ini file \'' . $db_file_ini . '\'');
		}
		
		// store current db links ini file name here
		self::$db_file = basename($db_file_ini);
		
		if (array_key_exists(self::$db_file, self::$db_pool)) {
			return self::$db_pool;
		}
		
		// initialize the db links ini file into db pool
		$db_links = parse_ini_file($db_file_ini, true);
		$db_write_links = array();
		
		foreach ((array) $db_links as $k => $v) {
			if (!strcasecmp('w', $k[0])) {
				$db_write_links[$k] = $v;
				unset($db_links[$k]);
			}
		}
		
		self::$db_pool[self::$db_file] = array(
			'WRITE' => $db_write_links,
			'READ'	=> $db_links
		);
		
		return self::$db_pool;
	}
	
	/**
	 * Random the db link we need
	 * @param string $type 'READ' or 'WRITE'
	 */
	public static function rand ($type, $db_file_ini = '')
	{
		if (!self::$db_pool) {
			throw new Hush_Db_Exception('Please init db pool first');
		}
		
		// if not get the ini file, get last ini file
		If (!$db_file_ini) $db_file_ini = self::$db_file;
		
		if (!array_key_exists($db_file_ini, self::$db_pool)) {
			throw new Hush_Db_Exception('Can not found \'' . $db_file_ini . '\' in db pool');
		}
		
		$db_pool_arr = (array) self::$db_pool[$db_file_ini][$type];
		$db_link_key = array_rand($db_pool_arr);
		$db_link_arr = $db_pool_arr[$db_link_key];
		
		if (!isset($db_link_arr['TYPE']) ||
			!isset($db_link_arr['HOST']) ||
			!isset($db_link_arr['USER']) ||
			!isset($db_link_arr['PASS']) ||
			!isset($db_link_arr['NAME'])){
			throw new Hush_Db_Exception('Invalid db config file format');
		}
		
		if (!isset($db_link_arr['PORT'])) {
			$db_link_arr['PORT'] = '3306'; // default port
		}
		
		if (isset($db_link_arr['PREF'])) {
			self::$db_pref = $db_link_arr['PREF'];
		}
		
		self::$db_link = self::factory($db_link_arr['TYPE'], array(
			'host'     => $db_link_arr['HOST'],
			'port'     => $db_link_arr['PORT'],
			'username' => $db_link_arr['USER'],
			'password' => $db_link_arr['PASS'],
			'dbname'   => $db_link_arr['NAME']
		));
		
		return self::$db_link;
	}
	
	/**
	 * Return the db link's prefix string
	 * @return string
	 */
	public static function pref () 
	{
		if (!self::$db_pref) {
			throw new Hush_Db_Exception('Please specify a db link first');
		}
		
		return self::$db_pref;
	}
}
