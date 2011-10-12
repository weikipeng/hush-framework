<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Mongo
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */
 
/**
 * @package Hush_Mongo
 */
abstract class Hush_Mongo_Config
{
	/**
	 * 默认策略
	 * @param string $dbName
	 * @param string $tbName
	 */
	abstract public function getInstance();
	
	/**
	 * 默认策略
	 * @param string $dbName
	 * @param string $tbName
	 */
	abstract public function useDefault($dbName, $tbName);
	
	/**
	 * ReplicaSet策略
	 * @param string $dbName
	 * @param string $tbName
	 * @param int|string $shardId
	 */
	abstract public function useReplicaSet($dbName, $tbName);
	
	/**
	 * 分库策略
	 * @param string $dbName
	 * @param string $tbName
	 * @param int|string $shardId
	 */
	abstract public function shardDatabase($dbName, $tbName, $shardId);
	
	/**
	 * 分表策略
	 * @param string $dbName
	 * @param string $tbName
	 * @param int|string $shardId
	 */
	abstract public function shardCollection($dbName, $tbName, $shardId);
}