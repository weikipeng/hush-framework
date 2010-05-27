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
class TestPage extends Ihush_App_Backend_Page
{
	public function indexAction () 
	{
		$this->view->welcome = 'Welcome to Hush Framework (Backend) !';
	}
}
