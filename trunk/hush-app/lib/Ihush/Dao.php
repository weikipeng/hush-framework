<?php
/**
 * Ihush Dao
 *
 * @category   Ihush
 * @package    Ihush_Dao
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */
 
require_once 'Hush/Db/Dao.php';

/**
 * @abstract
 * @package Ihush_Dao
 */
class Ihush_Dao extends Hush_Db_Dao
{
	/**
	 * Autoload Ihush Daos
	 * 
	 * @param string $dao
	 * @return Ihush_Dao
	 */
	public static function load ($class_name)
	{
	    static $_model = array();
	    if(!isset($_model[$class_name])) {
	    	require_once 'Ihush/Dao/' . str_replace('_', '/', $class_name) . '.php';
	    	$_model[$class_name] = new $class_name();
	    	$_model[$class_name]->charset('utf8');
	    }
	    return $_model[$class_name];
	}
}