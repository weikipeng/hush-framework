<?php
/**
 * Ihush Acl
 *
 * @category   Ihush
 * @package    Ihush_Acl
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */
 
require_once 'Hush/Acl.php';

/**
 * @package Ihush_Acl
 */
class Ihush_Acl extends Hush_Acl
{
	/**
	 * Judge the privilege is allowed
	 * @param mixed $roles
	 * @param string $resource
	 * @param string $privilege
	 * @return bool
	 */
	public function isAllowed ($roles, $resource, $privilege = null) 
	{
		if (!is_array($roles)) {
			return parent::isAllowed($roles, $resource, $privilege);
		}
		foreach ((array) $roles as $role) {
			if (parent::isAllowed($role, $resource, $privilege)) {
				return true;
			}
		}
		return false;
	}
}
