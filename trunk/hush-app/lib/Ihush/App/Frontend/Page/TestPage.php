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
		echo 'Paging object : ';
		$this->pagingDemo();
		
	}
	
	private function pagingDemo ()
	{
		$data = array();
		for ($i = 0; $i < 100; $i++) {
			$data[$i]['id'] = $i;
			$data[$i]['name'] = 'Test' . $i;
		}
		
		$page = new Ihush_Paging($data, 5, null, array(
			'Href' => '/test/p/{page}',
			'Mode' => 3,
		));
		
//		$page->setTotalPage(5); // only if have no total count
		
		Hush_Util::dump($page->paging());
	}
}
