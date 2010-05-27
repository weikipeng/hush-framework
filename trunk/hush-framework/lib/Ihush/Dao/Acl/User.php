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
require_once 'Ihush/Dao/Acl/Role.php';
require_once 'Ihush/Dao/Acl/UserRole.php';

/**
 * @package Ihush_Dao_Acl
 */
class Acl_User extends Ihush_Dao_Acl
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'user';
	
	/**
	 * Initialize
	 */
	public function __init () 
	{
		$this->t1 = self::TABLE_NAME;
		$this->t2 = Acl_Role::TABLE_NAME;
		$this->rsh = Acl_UserRole::TABLE_NAME;
		
		$this->__bind($this->t1);
	}
	
	/**
	 * Login function
	 * @uses Used by user login process
	 * @param string $user
	 * @param string $pass
	 * @return bool or array
	 */
	public function authenticate ($user, $pass)
	{
		$t1 = self::TABLE_NAME;
		
		$sql = $this->db->select()
			->from($this->t1, "*")
			->where("name = ?", $user)
			->where("pass = ?", Hush_Util::md5($pass));
		
		$user = $this->db->fetchRow($sql);
		
		if (!$user['id']) return false;
		
		$sql = $this->db->select()
			->from($this->t2, "*")
			->join($this->rsh, "{$this->t2}.id = {$this->rsh}.role_id", null)
			->where("{$this->rsh}.user_id = ?", $user['id']);
		
		$roles = $this->db->fetchAll($sql);
		
		if (!sizeof($roles)) return false;
		
		foreach ($roles as $role) {
			$user['role'][] = $role['id'];
			$user['priv'][] = $role['alias'];
		}
		
		return $user;
	}
	
	/**
	 * Get all user data from track_acl_user
	 * @see Ihush_Acl
	 * @return array
	 */
	public function getAllUsers ()
	{
		$sql = $this->db->select()->from($this->t1, "*");
		
		return $this->db->fetchAll($sql);
	}
	
	/**
	 * Get all user data from track_acl_user
	 * Only for backend acl tools
	 * @return array
	 */
	public function getUserList ()
	{
		$sql = $this->db->select()
			->from($this->t1, array("{$this->t1}.*", "group_concat({$this->t2}.name) as role"))
			->joinLeft($this->rsh, "{$this->t1}.id = {$this->rsh}.user_id", null)
			->joinLeft($this->t2, "{$this->t2}.id = {$this->rsh}.role_id", null)
			->group("{$this->t1}.id");
		
		return $this->db->fetchAll($sql);
	}
	
	/**
	 * Update all user role from track_acl_user_role
	 * @param int $id User ID
	 * @param array $roles Role ID's array
	 * @return bool
	 */
	 public function updateRoles ($id, $roles = array())
	 {
	 	if ($id) {
			$this->db->delete($this->rsh, $this->db->quoteInto("user_id = ?", $id));
	 	} else {
	 		return false;
	 	}
	 	
		if ($roles) {
			$cols = array('user_id', 'role_id');
			$vals = array();
			foreach ((array) $roles as $role) {
				$vals[] = array($id, $role);
			}
			if ($cols && $vals) {
				$this->db->insertMultiRow($this->rsh, $cols, $vals);
				return true;
			}
		} else {
			return true;
		}
		
		return false;
	 }
}