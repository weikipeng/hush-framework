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
require_once 'Ihush/Paging.php';

/**
 * @package Ihush_App_Frontend
 */
class TestPage extends Ihush_App_Frontend_Page
{
	public function __done ()
	{
		exit; // I don't want to display any template
	}
	
	public function indexAction () 
	{
		echo 'This is index action'; 
	}
	
	public function mappingAction () 
	{
		echo 'This is mapping action'; 
	}
	
	public function pagingAction () 
	{
		echo 'Paging request uri : ' . $_SERVER['REQUEST_URI'] . '<br/>';
		echo 'Paging demo : <br/>';
		$this->paging();
	}
	
	private function paging ()
	{
		$data = array();
		for ($i = 0; $i < 50; $i++) {
			$data[$i]['id'] = $i;
			$data[$i]['name'] = 'Test' . $i;
		}
		
		$page = new Ihush_Paging($data, 5, null, array(
			'Href' => '/test/p/{page}'
		));
		Hush_Util::dump($page->paging());
	}
}
