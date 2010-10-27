<?php
/**
 * Ihush Dao
 *
 * @category   Ihush
 * @package    Ihush_Dao
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */
 
require_once 'Hush/Db.php';

/**
 * @abstract
 * @package Ihush_Dao
 */
class Ihush_Dao
{
	/**
	 * @var array
	 */
	public $db_pool = null;
	
	/**
	 * @var Zend_Db object
	 */
	public $db = null;
	
	/**
	 * @var string
	 */
	public $table = null;
	
	/**
	 * Construct
	 * Init the target db link
	 * 
	 * @param $type 'READ' or 'WRITE'
	 * @return unknown
	 */
	public function __construct ($type = 'READ')
	{
		if (!$this->db) {
			require_once 'Ihush/Dao/Exception.php';
			throw new Ihush_Dao_Exception('Can not initialize class \'' . __CLASS__ . '\'');
		}
		
		if (Hush_Debug::showDebug('sql')) {
			$this->db->_debug = true;
		}
		
		$this->__init(); // do some preparation in subclass
	}
	
	/**
	 * Destruct
	 * Release the db link
	 */
	public function __destruct ()
	{
		$this->db->closeConnection();
	}
	
	/**
	 * Bind table for CRUD method
	 * 
	 * @param string $table Binded table name
	 * @return unknown
	 */
	public function __bind ($table = '')
	{
		if (!$this->table) $this->table = $table;
	}
	
	/**
	 * Return the db link's pool
	 * 
	 * @return array
	 */
	public function __pool ()
	{
		return $this->db_pool;
	}
	
	/**
	 * Do some preparation after construct
	 * Should be implemented by subclass
	 * 
	 * @return unknown
	 */
	public function __init () {}
	
	/**
	 * Create data by insert method
	 * 
	 * @param array $data
	 * @return mixed
	 */
	public function create ($data)
	{
		if (!$this->table) {
			require_once 'Ihush/Dao/Exception.php';
			throw new Ihush_Dao_Exception('Please bind table name first');
		}
		if ($this->db->insert($this->table, $data)) {
			return $this->db->lastInsertId();
		}
		return false;
	}
	
	/**
	 * Load data by primary key id
	 * 
	 * @param mixed $id Primary key value
	 * @param string $pk Primary key name
	 * @return array
	 */
	public function read ($id, $pk = 'id')
	{
		if (!$this->table) {
			require_once 'Ihush/Dao/Exception.php';
			throw new Ihush_Dao_Exception('Please bind table name first');
		}
		$sql = $this->db->select()->from($this->table)->where("$pk = ?", $id);
		return $this->db->fetchRow($sql);
	}
	
	/**
	 * Update specific data by where expr
	 * 
	 * @param array $data Update data
	 * @param string $where Where sql expr
	 * @return bool
	 */
	public function update ($data, $where)
	{
		if (!$this->table) {
			require_once 'Ihush/Dao/Exception.php';
			throw new Ihush_Dao_Exception('Please bind table name first');
		}
		return $this->db->update($this->table, $data, $where);
	}
	
	/**
	 * Delete data by primary key id
	 * 
	 * @param mixed $id Primary key value
	 * @param string $pk Primary key name
	 * @return bool
	 */
	public function delete ($id, $pk = 'id')
	{
		if (!$this->table) {
			require_once 'Ihush/Dao/Exception.php';
			throw new Ihush_Dao_Exception('Please bind table name first');
		}
		return $this->db->delete($this->table, $this->db->quoteInto("$pk = ?", $id));
	}
	
	/**
	 * Set connection charset
	 * 
	 * @param string $charset Db connection's charset
	 * @return Ihush_Dao
	 */
	public function charset ($charset = 'utf8')
	{
		if ($charset) $this->db->query('set names ' . $charset);
		return $this;
	}
	
	/**
	 * Autoload Ihush Daos
	 * 
	 * @param string $dao
	 * @return Ihush_Dao
	 */
	public static function load ($class_name)
	{
		require_once 'Ihush/Dao/' . str_replace('_', '/', $class_name) . '.php';
		$daoClass = new $class_name();
		$daoClass->charset('utf8');
		return $daoClass;
	}
}