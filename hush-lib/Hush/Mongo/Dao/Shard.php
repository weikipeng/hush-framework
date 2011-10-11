<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Mongo_Dao
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

/**
 * @see Hush_Mongo_Dao
 */
require_once 'Hush/Mongo/Dao.php';

/**
 * @see Hush_Mongo_Exception
 */
require_once 'Hush/Mongo/Exception.php';

/**
 * @package Hush_Mongo_Dao
 */
class Hush_Mongo_Dao_Shard extends Hush_Mongo_Dao
{
	/**
	 * Shard key
	 * 
	 * @var string
	 */
	protected $_shardKey;
	
	/**
	 * Shard value
	 * 
	 * @var string
	 */
	protected $_shardVal;
	
	/**
	 * Shard condition
	 * 
	 * @var array
	 */
	protected $_shardSet = array();
	
	/**
	 * Shard db servers
	 * 
	 * @var array
	 */
	protected $_shardDbs = array();
	
	/**
	 * Shard db servers
	 * 
	 * @var array
	 */
	protected $_shardTbl = '';
	
	/**
	 * Constructor
	 * Initialize mongo db connection and collection object
	 * 
	 * @param array $shardVal
	 * @return void
	 */
	public function __construct($shardVal = null)
	{
		global $mongoShardServers;
		
		// get config from global config
		$dbName = (string) $this->_database;
		$configs = isset($mongoShardServers[$dbName]) ? $mongoShardServers[$dbName] : $mongoShardServers['default'];
		if (!$configs) {
			throw new Hush_Mongo_Exception("Can not find sharding configs for class '$currClassName'.");
		}
		
		$this->_shardKey = $configs['shardKey'];
		$this->_shardSet = $configs['shardSet'];
		
		if (!$this->_shardKey || !$this->_shardSet) {
			throw new Hush_Mongo_Exception("Sharding configs for class '$currClassName' is error.");
		}
		
		// get shard value from arguments
		$this->_shardVal = (int) $shardVal;
		if (!$this->_shardVal) {
			throw new Hush_Mongo_Exception("Sharding key's value can not be null.");
		}
		
		// get db configs from subclasses
		$this->_config['database'] = $this->_database;
		$this->_config['collection'] = $this->_collection;
		$this->_config['persistent'] = $this->_persistent;
		$this->_config['persistentId'] = $this->_persistentId;
		$this->_config['replicaSet'] = $this->_replicaSet;
	}
	
	/**
	 * Parse MongoDB sharding conditions for servers.
	 * 
	 * @param array $config
	 * @return void
	 */
	protected function _parseShardSettings($shardSet = array())
	{
		if (!$this->_shardKey || !$this->_shardVal) {
			throw new Hush_Mongo_Exception("Please set shard key and value before get server.");
		}
		
		$shardServer = array();
		foreach ((array) $shardSet as $ranges => $configs) {
			// get condition
			preg_match('/(\[|\()(\*|\d+)-(\*|\d+)(\]|\))/i', $ranges, $pres);
			$lc = isset($pres[1]) ? $pres[1] : null;
			$ln = isset($pres[2]) ? $pres[2] : null;
			$rn = isset($pres[3]) ? $pres[3] : null;
			$rc = isset($pres[4]) ? $pres[4] : null;
			if (!$lc || !$ln || !$rn || !$rc) {
				throw new Hush_Mongo_Exception("Shard condition error.");
			}
			// matching shard range
			$matched = true;
			if (is_numeric($ln)) {
				if ($lc == '[') {
					$matched = ($this->_shardVal >= $ln) ? true : false;
				} elseif ($lc == '(') {
					$matched = ($this->_shardVal > $ln) ? true : false;
				} else {
					$matched = false;
				}
			} else {
				$ln = 0;
			}
			if (is_numeric($rn)) {
				if ($rc == ']') {
					$matched = ($this->_shardVal <= $rn) ? true : false;
				} elseif ($rc == ')') {
					$matched = ($this->_shardVal < $rn) ? true : false;
				} else {
					$matched = false;
				}
			} else {
				$rn = 0;
			}
			// in shard range
			if ($matched) {
				// get shard db servers
				$this->_shardDbs = $configs['dbs'];
				// get shard table name
				$limit = (int) $configs['tbl']['shardLimit'];
				if ($limit) {
					$tblSuffix = intval(($this->_shardVal - $ln) / $limit);
					$this->_shardTbl = $this->_collection . '_' . $tblSuffix;
				}
				break;
			}
		}
		
		return $shardServer;
	}
	
	/**
	 * Replace sharding key
	 *
	 * @param array $shardKey Sharding key name
	 * @return $this
	 */
	public function setShardKey($shardKey)
	{
		$this->_shardKey = (string) $shardKey;
		return $this;
	}
	
	/**
	 * Replace sharding value
	 *
	 * @param array $shardKey Sharding key value
	 * @return $this
	 */
	public function setShardVal($shardVal)
	{
		$this->_shardVal = (int) $shardVal;
		return $this;
	}
	
	/**
	 * Auto-set shard key & value
	 *
	 * @param array $data Auto-set shard key & value into data or query
	 * @return $this
	 */
	protected function _doAutoShard($data)
	{
		if (!$this->_shardKey || !$this->_shardVal) {
			throw new Hush_Mongo_Exception("Please set shard key and value before operating data.");
		}
		
		unset($data[$this->_shardKey]);
		$data = array($this->_shardKey => $this->_shardVal) + $data;
		return $data;
	}
	
	/**
	 * Return specific MongoCollection API
	 *
	 * @param const $type self::REPLSET / self::MASTER / self::SLAVE
	 * @return MongoCollection
	 */
	public function getMongo($type = self::REPLSET)
	{
		// parse shard settings
		$this->_parseShardSettings($this->_shardSet);
		
		// rewrite servers
		switch ($type) {
			case self::MASTER :
				$this->_config['servers'] = (array) $this->_shardDbs['master'];
				break;
			case self::SLAVE :
				$this->_config['servers'] = (array) $this->_shardDbs['slave'];
				break;
			case self::REPLSET :
			default :
				$this->_config['servers'] = (array) $this->_shardDbs;
				break;
		}
		
		// rewrite collection
		$this->_config['collection'] = $this->_shardTbl;
		$this->_collection = $this->_shardTbl;
		
		try {
			$this->_connect($this->_config);
		} catch (Exception $e) {
			die(__CLASS__ . " : " . $e->getMessage() . "\n");
		}
		
		// mongo cursor object
		return $this->_mongo;
	}
	
	/**
	 * CRUD : Create
	 *
	 * @param array $data Insert data array
	 * @param array $options Includeing safe / fsync / timeout
	 * @return mixed
	 */
	public function create($data = array(), $options = array())
	{
		return parent::create($this->_doAutoShard($data), $options);
	}
	
	/**
	 * CRUD : Batch Create
	 *
	 * @param array $dataArr Insert data array
	 * @param array $options Includeing safe / fsync / timeout
	 * @return mixed
	 */
	public function batchCreate($dataArr = array(), $options = array())
	{
		foreach ($dataArr as $id => $data) {
			$dataArr[$id] = $this->_doAutoShard($data);
		}
		return parent::batchCreate($dataArr, $options);
	}
	
	/**
	 * CRUD : Read
	 *
	 * @param array $query Querying array
	 * @param array $fields Fetching fields
	 * @return mixed
	 */
	public function read($query = array(), $fields = array())
	{
		return parent::read($this->_doAutoShard($query), $fields);
	}
	
	/**
	 * CRUD : Update
	 *
	 * @param array $query Querying array
	 * @param array $data Update data array
	 * @param array $options Includeing safe : false / fsync : false / timeout : false
	 * @return bool
	 */
	public function update($query = array(), $data = array(), $options = array())
	{
		return parent::update($this->_doAutoShard($query), $data, $options);
	}
	
	/**
	 * CRUD : Delete
	 *
	 * @param array $query Querying array
	 * @param array $options Includeing safe / fsync / timeout
	 * @return mixed
	 */
	public function delete($query, $options = array())
	{
		return parent::delete($this->_doAutoShard($query), $options);
	}
	
	/**
	 * Create Index for shard key
	 * Do this action only for master connection
	 * 
	 * @return void
	 */
	public function doForMasterOnly()
	{
		$this->_initCollection(array(
			array(
				'indexKeys' => array($this->_shardKey => 1),
				'indexOpts' => array()
			)
		));
	}
}