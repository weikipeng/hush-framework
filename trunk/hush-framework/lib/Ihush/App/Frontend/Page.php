<?php
/**
 * Ihush Page
 *
 * @category   Ihush
 * @package    Ihush_App_Frontend
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */
 
require_once 'Ihush/App/Page.php';
require_once 'Ihush/Dao/Acl.php';
require_once 'Ihush/Dao/App.php';

/**
 * @package Ihush_App_Frontend
 */
class Ihush_App_Frontend_Page extends Ihush_App_Page
{
	/**
	 * Do something before dispatch
	 * @see Hush_App_Dispatcher
	 */
	public function __init ()
	{
		// Auto load dao
		$this->dao->acl = new Ihush_Dao_Acl();
		$this->dao->app = new Ihush_Dao_App();
	}
}