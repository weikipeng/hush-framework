<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Exception
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

/**
 * @package Hush_Exception
 */
class Hush_Exception extends Exception
{
	public function __construct($msg = '', $code = 0, Exception $e = null)
	{
		parent::__construct($msg, $code, $e);
	}
}