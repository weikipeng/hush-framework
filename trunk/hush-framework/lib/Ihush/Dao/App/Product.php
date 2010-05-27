<?php
/**
 * Ihush Dao
 *
 * @category   Ihush
 * @package    Ihush_Dao_App
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */
 
require_once 'Ihush/Dao/App.php';
/**
 * @package Ihush_Dao_App
 */
class App_Product extends Ihush_Dao_App
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'product';
	
	/**
	 * Initialize
	 */
	public function __init () 
	{
		$this->t1 = self::TABLE_NAME;
		
		$this->__bind($this->t1);
	}

}