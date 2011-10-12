<?php
/**
 * Ihush App
 *
 * @category   Ihush
 * @package    Ihush_App_Frontend
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */
 
require_once 'Ihush/App/Frontend/Page.php';
require_once 'Ihush/Mongo.php';

/**
 * @package Ihush_App_Frontend
 */
class TestDbPage extends Ihush_App_Frontend_Page
{
	public function __init ()
	{
		require_once __ETC . '/class/MongoConfig.php';
		$this->mongo = new Ihush_Mongo();
	}
	
	public function __done ()
	{
		exit; // I don't want to display any template
	}
	
	public function indexAction () 
	{
		echo 'This is index action'; 
	}
	
	public function mysqlShardAction () 
	{
		echo '111'; 
	}
	
	public function mongoShardAction () 
	{
		$mongo = $this->mongo->load('Foo_Foo');
		$result = $mongo->create(array('foo' => 1, 'val' => 1, '_time' => time()));
		Hush_Util::dump($result);
		usleep(10000);
		$result = $mongo->read(array('foo' => 1));
		Hush_Util::dump(iterator_to_array($result));
		$result = $mongo->update(array('foo' => 1), array('foo' => 1, 'val' => 2, '_time' => time()));
		Hush_Util::dump($result);
		usleep(10000);
		$result = $mongo->read(array('foo' => 1));
		Hush_Util::dump(iterator_to_array($result));
		$result = $mongo->delete(array('foo' => 1));
		Hush_Util::dump($result);
		ob_flush();
		flush();
	}
}
