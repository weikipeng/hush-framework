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
	
	public function pagerAction () 
	{
		echo 'Pager request uri : ' . $_SERVER['REQUEST_URI'];
	}
}
