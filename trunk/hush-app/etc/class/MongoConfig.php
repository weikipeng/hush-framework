<?php
/**
 * Mongo DB 全局配置类
 */
require_once 'Hush/Mongo/Config.php';

class MongoConfig extends Hush_Mongo_Config
{
	// 手动配置
	private $_servers = array(
		// cluster1
		'm1' => array('host' => '192.168.41.60', 'port' => '27017', 'username' => null, 'password' => null),
		's1' => array('host' => '192.168.41.60', 'port' => '27018', 'username' => null, 'password' => null),
		// cluster2
		'm2' => array('host' => '116.211.28.9', 'port' => '27017', 'username' => null, 'password' => null),
		's2' => array('host' => '116.211.28.9', 'port' => '27017', 'username' => null, 'password' => null),
		// replica set
		'r1' => array('host' => '192.168.41.60', 'port' => '27018', 'username' => null, 'password' => null),
		'r2' => array('host' => '192.168.41.60', 'port' => '27019', 'username' => null, 'password' => null),
		'r3' => array('host' => '192.168.41.60', 'port' => '27020', 'username' => null, 'password' => null),
	);
	
	// 获取单例
	public function getInstance () {
		static $mongoConfig;
		if ($mongoConfig == null) {
			$mongoConfig = new MongoConfig();
		}
		return $mongoConfig;
	}
	
	// 主从策略（默认）
	public function useDefault($dbName, $colName) {
		return array(
			'master'	=> array($this->_servers['m1']),
			'slave'		=> array($this->_servers['s1']),
		);
	}
	
	// ReplicaSet策略（Mongo特有）
	public function useReplicaSet($dbName, $colName) {
		return array(
			$this->_servers['r1'],
			$this->_servers['r2'],
			$this->_servers['r3'],
		);
	}
	
	// 分库策略
	public function shardDatabase($dbName, $colName, $shardId) {
		// 平均分配到2组cluster上去
		switch ($shardId % 2) {
			case 1:
				return array(
					'master'	=> array($this->_servers['m1']),
					'slave'		=> array($this->_servers['s1']),
				);
			case 0:
			default:
				return array(
					'master'	=> array($this->_servers['m2']),
					'slave'		=> array($this->_servers['s2']),
				);
		}
	}
	
	// 分表策略
	public function shardCollection($dbName, $colName, $shardId) {
		return $colName.'_'.($shardId % 2);
	}
}
