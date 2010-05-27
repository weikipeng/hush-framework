<?php
/**
 * Ihush Dao
 *
 * @category   Ihush
 * @package    Ihush_Dao
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */
 
require_once 'Hush/Exception.php';

/**
 * @package Ihush_Dao
 */
class Ihush_Dao_Exception extends Hush_Exception
{
	public function __construct($msg = '', $code = 0, Exception $e = null)
	{
		parent::__construct($msg, $code, $e);
	}
	
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}