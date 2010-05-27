<?php
/**
 * iHush Track
 *
 * @category   Track
 * @package    Ihush_App_Backend
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */
 
require_once 'Ihush/App/Backend/Page.php';

/**
 * @package Ihush_App_Backend
 */
class IndexPage extends Ihush_App_Backend_Page
{	
	public function __init ()
	{
		$this->authenticate();
		
		parent::__init(); // overload parent class's method
	}
	
	public function indexAction () 
	{
		// get app menu list
		$appDao = $this->dao->acl->load('Acl_App');
		$appList = $appDao->getAppListByRole($this->admin['role']);
		$this->view->appList = $appList;
	}
}