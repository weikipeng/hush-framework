<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Exception
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */
 
/**
 * @see Zend_Exception
 */
require_once 'Zend/Exception.php';

/**
 * @package Hush_Exception
 */
class Hush_Exception extends Zend_Exception
{
	public function __construct($msg = '', $code = 0, Exception $e = null)
	{
		parent::__construct($msg, $code, $e);
	}
}