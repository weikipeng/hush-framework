<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Db
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

/**
 * @see Hush_Db
 */
require_once 'Hush/Db.php';

/**
 * @see Hush_Db_Exception
 */
require_once 'Hush/Db/Exception.php';

/**
 * @package Hush_Db
 */
class Hush_Db_Dao
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
	 * @var string
	 */
	public $charset = 'utf8';
	
	/**
	 * Construct
	 * Init the target db link
	 * 
	 * @param $type 'READ' or 'WRITE'
	 * @return unknown
	 */
	public function __construct ($type = 'READ')
	{
		if (!$this->db) return ;
		
		if (class_exists('Hush_Debug') && Hush_Debug::showDebug('sql')) {
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
		if (!$this->db) return ;
		
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
			throw new Ihush_Dao_Exception('Please bind table name first');
		}
		return $this->db->delete($this->table, $this->db->quoteInto("$pk = ?", $id));
	}
	
	/**
	 * Replace specific data by where expr
	 * 
	 * @param array $data Update data
	 * @param string $where Where sql expr
	 * @return bool
	 */
	public function replace ($data)
	{
		if (!$this->table) {
			require_once $this->exception_class;
			throw new $this->exception_name('Please bind table name first');
		}
		$affect_rows = $this->db->replace($this->table, $data);
		return ($affect_rows !== false) ? true : false;
	}
	
	/**
	 * Set connection charset
	 * 
	 * @param string $charset Db connection's charset
	 * @return Hush_Db_Dao
	 */
	public function charset ($charset = 'utf8')
	{
		$this->charset = $charset; // override default charset
		$this->db->query('set names ' . $this->charset);
		return $this;
	}
	
	/**
	 * Start transaction
	 */
	public function beginTransaction ()
	{
		return $this->db->beginTransaction();
	}
	
	/**
	 * Start transaction
	 */
	public function rollback ()
	{
		return $this->db->rollback();
	}
	
	/**
	 * Start transaction
	 */
	public function commit ()
	{
		return $this->db->commit();
	}
	
	/**
	 * Get db link (READ/WRITE)
	 * 
	 * @param string $type Db link type (READ/WRITE)
	 */
	public function db ($type)
	{
		if (!$this->db_pool) {
			throw new Ihush_Dao_Exception('Please init db pool first');
		}
		$db = Hush_Db::rand($type);
		$db->query('set names ' . $this->charset);
		return $db;
	}
	
	/**
	 * Get read db link
	 * 
	 * @param string $type Db link type
	 */
	public function dbr ()
	{
		return $this->db('READ');
	}
	
	/**
	 * Get write db link
	 * 
	 * @param string $type Db link type
	 */
	public function dbw ()
	{
		return $this->db('WRITE');
	}
}