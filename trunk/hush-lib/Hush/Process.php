<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Process
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */

/**
 * @see Hush_Process_Exception
 */
require_once 'Hush/Process/Exception.php';

/**
 * Set basic environment
 * Give us eternity to execute the script
 */
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
@set_time_limit(0);

/**
 * @abstract
 * @package Hush_Process
 * @example Process.php Example for using Hush_Process class
 */
abstract class Hush_Process
{
	/**
	 * @staticvar int
	 */
	public static $nullVal = 0;
	
	/**
	 * @staticvar int
	 */
	public static $nowStatus = null;
	
	/**
	 * @staticvar int
	 */
	public static $sumProcessNum = 0;
	
	/**
	 * @staticvar int
	 */
	public static $maxProcessNum = 5;
	
	/**
	 * @staticvar int
	 */
	public static $parentPid = 0;
	
	/**
	 * @var resource
	 */
	public $mutex = null;
	
	/**
	 * @var resource
	 */
	public $global = null;
	
	/**
	 * @var resource
	 */
	public $shared = null;
	
	/**
	 * @var string
	 */
	public $name = '';
	
	/**
	 * @var int
	 */
	public $pid = 0;
	
	/**
	 * Construct
	 */
	public function __construct ($name = '')
	{
		// get global process id
		$this->name = get_class($this);
		$this->gid = hexdec($this->name);
		
		// get process id from name
		$this->name .= '_' . $name;
		$this->pid = hexdec($this->name);
		
		// release all resource
		$this->__release();
		
		// initialization
		$this->__initialize();
	}
	
	/**
	 * Destruct
	 */
	public function __destruct ()
	{
		$this->__release();
	}
	
	/**
	 * Set shared variables
	 */
	public function __set ($k, $v)
	{
		$val = $v ? $v : self::$nullVal;
		@shm_put_var($this->shared, $k, $val);
		return $val;
	}
	
	/**
	 * Get shared variables
	 */
	public function __get ($k)
	{
		$val = @shm_get_var($this->shared, $k);
		return $val ? $val : self::$nullVal;
	}
	
	/**
	 * Get & set global variables
	 */
	public function __global ($k, $v = null)
	{
		// get global variables
		if (!isset($v)) {
			$val = @shm_get_var($this->global, $k);
			return $val ? $val : self::$nullVal;
		} 
		// set global variables
		else {
			$val = $v ? $v : self::$nullVal;
			@shm_put_var($this->global, $k, $val);
			return $val;
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// private methods
	
	/**
	 * Check runtime enviornment and initlialize resource for process
	 * Resource include Mutex resource and shared variables
	 * Call by construct
	 * 
	 * @return void
	 */
	private function __initialize ()
	{
		if (substr(php_sapi_name(), 0, 3) != 'cli') {
			throw new Hush_Process_Exception("Please use cli mode to run this script");
		}
		
		if (!extension_loaded("pcntl") ||
			!extension_loaded("posix") ||
			!extension_loaded("sysvsem") ||
			!extension_loaded("sysvshm") ||
			!extension_loaded("sysvmsg")) {
				throw new Hush_Process_Exception("You need to open pcntl, posix, sysv* extensions");
			}
		
		// init mutex for lock
		$mutex_id = ftok(__FILE__, 'm') + $this->pid;
		$this->mutex = sem_get($mutex_id, 1);
		
		// init global space for all
		$global_id = ftok(__FILE__, 'r') + $this->gid;
		$this->global = shm_attach($global_id, 1024 * 1024 * 2);
		
		// init shared space for group
		$shared_id = ftok(__FILE__, 'r') + $this->pid;
		$this->shared = shm_attach($shared_id, 1024 * 1024 * 1);
		
		// register callback functions
		pcntl_signal(SIGTERM,	array(&$this, "__singal"));
		pcntl_signal(SIGHUP,	array(&$this, "__singal"));
		pcntl_signal(SIGUSR1,	array(&$this, "__singal"));
		
		// get parent process id
		if (!self::$parentPid) self::$parentPid = posix_getpid();
		
		// do init logic in subclasses
		$this->__init();
	}
	
	/**
	 * Release all resource after process end
	 * Call by destruct
	 * 
	 * @return void
	 */
	protected function __release ()
	{
		// release global space for vars
		@shm_remove($this->global);

		// release shared space for vars
		@shm_remove($this->shared);
		
		// remove mutex for lock
		@sem_remove($this->mutex);
	}
	
	/**
	 * Making processes by fork
	 * Control the number of the sub processes
	 * 
	 * @return void
	 */
	private function __process ()
	{
		$pid = pcntl_fork();
		
		if ($pid == -1) {
			die("System could not fork\n");
		}
		// we are the parent
		elseif ($pid) {
			
			$sumProcessNum = $this->getSumProcessNum();
			
			$sumProcessNum++;
			if ($sumProcessNum >= self::$maxProcessNum) {
				pcntl_wait(self::$nowStatus);
				$sumProcessNum--;
			}
			
			$this->setSumProcessNum($sumProcessNum);
			
			return $pid;
		}
		// we are the child
		else {
			declare (ticks = 1) {
				$this->run();
				$this->stop();
			}
			exit();
		}
	}
	
	/**
	 * Wait processes
	 * 
	 * @return void
	 */
	private function __wait ($pids)
	{
		foreach ($pids as $pid) {
			pcntl_waitpid($pid, self::$nowStatus);
		}
	}
	
	/**
	 * Callback function
	 * Do some action by the system singals
	 * 
	 * @param int $signo Constants restart_syscalls
	 * @return void
	 */
	protected function __singal ($signo)
	{
		switch ($signo) {
			case SIGTERM :
				// TODO : Do somthing when caught SIGTERM
				break;
			case SIGHUP :
				// TODO : Do somthing when caught SIGHUP
				break;
			case SIGUSR1 :
				// TODO : Do somthing when caught SIGUSR1
				break;
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// public methods
	
	private function setSumProcessNum ($num)
	{
		$this->__global('sumProcessNum', intval($num));
	}
	
	public function getSumProcessNum ()
	{
		return $this->__global('sumProcessNum');
	}
	
	/**
	 * Set max sub processes number
	 * 
	 * @param int $num
	 */
	public function setMaxProcess ($num)
	{
		self::$maxProcessNum = intval($num);
	}
	
	/**
	 * Get process priority
	 * 
	 * @return void
	 */
	public function setPriority ($priority)
	{
		pcntl_setpriority(intval($priority), posix_getpid());
	}
	
	/**
	 * Set process priority
	 * 
	 * @return int
	 */
	public function getPriority ()
	{
		return pcntl_getpriority(posix_getpid());
	}
	
	/**
	 * Return process status
	 * 
	 * @return int
	 */
	public function getStatus ()
	{
		return self::$nowStatus;
	}
	
	/**
	 * Check if current process is parent
	 * Each run only have one parent pid
	 * 
	 * @return bool
	 */
	public function isParent ()
	{
		return (posix_getpid() == self::$parentPid) ? 1 : 0;
	}
	
	/**
	 * Return process name (uniq id)
	 * 
	 * @return int
	 */
	public function getName ()
	{
		return $this->name;
	}
	
	/**
	 * Process start
	 * Should be called by instance
	 * 
	 * @return void
	 */
	public function start ()
	{
		$pids = array();
		$sumProcessNum = $this->getSumProcessNum();
		for ($i = $sumProcessNum; $i < self::$maxProcessNum; $i++) {
			$pids[] = $this->__process();
		}
		$this->__wait($pids);
	}
	
	/**
	 * Process sleep
	 * Can be used in run() method in subclasses
	 * 
	 * @return void
	 */
	public function sleep ($ms)
	{
		usleep($ms);
	}
	
	/**
	 * Process stop
	 * Can be used in run() method in subclasses
	 * 
	 * @return void
	 */
	public function stop ()
	{
		$sumProcessNum = $this->getSumProcessNum();
		$this->setSumProcessNum(--$sumProcessNum);
		posix_kill(posix_getpid(), SIGKILL);
	}
	
	/**
	 * Process lock
	 * Protected current process
	 * Should be called by instance of each process
	 * 
	 * @return void
	 */
	public function lock ()
	{
		@sem_acquire($this->mutex);
	}
	
	/**
	 * Process unlock
	 * Should be called by instance
	 * 
	 * @return void
	 */
	public function unlock ()
	{
		@sem_remove($this->mutex);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// abstract methods
	
	protected function __init () {} // to be overridden
	
	abstract protected function run ();
}
