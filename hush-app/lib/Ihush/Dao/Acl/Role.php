<?php
/**
 * Ihush Dao
 *
 * @category   Ihush
 * @package    Ihush_Dao_Acl
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */
 
require_once 'Ihush/Dao/Acl.php';
require_once 'Ihush/Dao/Acl/AppRole.php';
require_once 'Ihush/Dao/Acl/UserRole.php';
require_once 'Ihush/Dao/Acl/ResourceRole.php';
require_once 'Ihush/Dao/Acl/RolePriv.php';

/**
 * @package Ihush_Dao_Acl
 */
class Acl_Role extends Ihush_Dao_Acl
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'role';
	
	/**
	 * Initialize
	 */
	public function __init () 
	{
		$this->t1 = self::TABLE_NAME;
		$this->rsh1 = Acl_UserRole::TABLE_NAME;
		$this->rsh2 = Acl_AppRole::TABLE_NAME;
		$this->rsh3 = Acl_ResourceRole::TABLE_NAME;
		$this->rsh4 = Acl_RolePriv::TABLE_NAME;
		
		$this->__bind($this->t1);
	}
	
	/**
	 * Get user's role data by user id
	 * Include the user's roles
	 * @param int $id User ID
	 * @param array $privs Allowed privileges
	 * @return array
	 */
	public function getRoleByUserId ($id, $privs = array())
	{
		$sql = $this->db->select()
			->from($this->t1, "{$this->t1}.*")
			->join($this->rsh1, "{$this->t1}.id = {$this->rsh1}.role_id", null)
			->where("{$this->rsh1}.user_id=?", $id);
			
		$res = $this->db->fetchAll($sql);
		
		foreach ((array) $res as $k => $v) {
			if (!in_array($v['id'], $privs)) $res[$k]['readonly'] = true;
		}
		
		return $res;
	}
	
	/**
	 * Get app's role data by app id
	 * Include the app's roles
	 * @param int $id App ID
	 * @param array $privs Allowed privileges
	 * @return array
	 */
	public function getRoleByAppId ($id, $privs = array())
	{
		$sql = $this->db->select()
			->from($this->t1, "{$this->t1}.*")
			->join($this->rsh2, "{$this->t1}.id = {$this->rsh2}.role_id", null)
			->where("{$this->rsh2}.app_id=?", $id);
		
		$res = $this->db->fetchAll($sql);
		
		foreach ((array) $res as $k => $v) {
			if (!in_array($v['id'], $privs)) $res[$k]['readonly'] = true;
		}
		
		return $res;
	}
	
	/**
	 * Get resource's role data by resource id
	 * Include the resource's roles
	 * @param int $id Resource ID
	 * @param array $privs Allowed privileges
	 * @return array
	 */
	public function getRoleByResourceId ($id, $privs = array())
	{
		$sql = $this->db->select()
			->from($this->t1, "{$this->t1}.*")
			->join($this->rsh3, "{$this->t1}.id = {$this->rsh3}.role_id", null)
			->where("{$this->rsh3}.resource_id=?", $id);
		
		$res = $this->db->fetchAll($sql);
		
		foreach ((array) $res as $k => $v) {
			if (!in_array($v['id'], $privs)) $res[$k]['readonly'] = true;
		}
		
		return $res;
	}
	
	/**
	 * Get all roles data from track_acl_role
	 * @return array
	 */
	public function getAllRoles ()
	{
		$sql = $this->db->select()->from($this->t1, "*");
		
		return $this->db->fetchAll($sql);
	}
	
	/**
	 * Get all roles data from track_acl_role
	 * Only for backend acl tools
	 * @return array
	 */
	public function getRoleList ()
	{
		// Join self demo !!!
		$sql = $this->db->select()
			->from($this->t1, array("{$this->t1}.*", "group_concat({$this->t1}_2.name) as role"))
			->joinLeft($this->rsh4, "{$this->t1}.id = {$this->rsh4}.role_id", null)
			->joinLeft($this->t1, "{$this->t1}_2.id = {$this->rsh4}.priv_id", null)
			->group("{$this->t1}.id");
		
		return $this->db->fetchAll($sql);
	}
	
	/**
	 * Get all role's priv data
	 * Only for privilege management
	 * @param array $roles Role ID array (from session)
	 * @return array
	 */
	public function getAllPrivs ($roles)
	{
		if (!$roles || !sizeof($roles)) return array();
		
		$sql = $this->db->select()
			->from($this->t1, "{$this->t1}.*")
			->join($this->rsh4, "{$this->t1}.id = {$this->rsh4}.priv_id", null)
			->where("{$this->rsh4}.role_id IN (?)", implode(',', $roles));
		
		return $this->db->fetchAll($sql);
	}
	
	/**
	 * Get user's priv data by role id
	 * That is getting user accessed role list
	 * @param int $id Role ID
	 * @return array
	 */
	public function getPrivByRoleId ($id)
	{
		$sql = $this->db->select()
			->from($this->t1, "{$this->t1}.*")
			->join($this->rsh4, "{$this->t1}.id = {$this->rsh4}.priv_id", null)
			->where("{$this->rsh4}.role_id=?", $id);
		
		return $this->db->fetchAll($sql);
	}
	
	/**
	 * Update all role priv from track_acl_role_priv
	 * @param int $id Role ID
	 * @param array $privs Role's privs array (that is also role id)
	 * @return bool
	 */
	 public function updatePrivs ($id, $privs = array())
	 {
	 	if ($id) {
			$this->db->delete($this->rsh4, $this->db->quoteInto("role_id = ?", $id));
	 	} else {
	 		return false;
	 	}
	 	
		if ($privs) {
			$cols = array('role_id', 'priv_id');
			$vals = array();
			foreach ((array) $privs as $priv) {
				$vals[] = array($id, $priv);
			}
			if ($cols && $vals) {
				$this->db->insertMultiRow($this->rsh4, $cols, $vals);
				return true;
			}
		} else {
			return true;
		}
		
		return false;
	 }
}