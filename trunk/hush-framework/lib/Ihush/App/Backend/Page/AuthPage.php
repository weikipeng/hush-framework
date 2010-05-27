<?php
/**
 * Ihush Page
 *
 * @category   Ihush
 * @package    Ihush_App_Backend
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */
 
require_once 'Ihush/App/Backend/Page.php';

/**
 * @package Ihush_App_Backend
 */
class AuthPage extends Ihush_App_Backend_Page
{
	public function indexAction () 
	{
		// TODO : Display directly
	}
	
	public function loginAction () 
	{
		if (strcasecmp($this->param('securitycode'),$this->session('securitycode'))) {
			// redirect to homepage
			$this->forward($this->root);
		}
		
		$aclUserDao = $this->dao->acl->load('Acl_User');
		$admin = $aclUserDao->authenticate($this->param('username'), $this->param('password'));
		if ($admin) {
			// whether super admin
			$admin['sa'] = strcasecmp($admin['name'], $this->sa) ? false : true;
			// store admin into session
			$this->session('admin', $admin);
			// redirect to homepage
			$this->forward($this->root);
		}
		
		$this->forward($this->root);
	}
	
	public function logoutAction ()
	{
		if ($this->session('admin')) {
			// clear admin from session
			$this->session('admin', '');
		}
		
		$this->forward($this->root);
	}
}
