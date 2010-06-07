<?php
/**
 * Hush Framework
 *
 * @ignore
 * @category   Examples
 * @package    Examples
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */

require_once 'config.inc';

require_once 'Hush/Socket/Client.php';
require_once 'Hush/Util.php';

/**
 * @ignore
 * @package Examples
 */
class Examples_Client extends Hush_Socket_Client
{
	
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// run demo

try {
	
	$client = new Examples_Client();
	echo $client->test();
	
//	$client->shutdown();

} catch (Exception $e) {
	Hush_Util::trace($e);
	exit;
}
