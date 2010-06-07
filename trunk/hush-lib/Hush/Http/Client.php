<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Http
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id: james $
 */
 
/**
 * @see Zend_Http_Client
 */
require_once 'Zend/Http/Client.php';

/**
 * @package Hush_Http
 */
class Hush_Http_Client extends Zend_Http_Client
{
//	public function setNonBlocking ()
//	{
//		if ($this->adapter) {
//			stream_set_blocking($http_client->adapter->socket, 0);
//		}
//	}
}