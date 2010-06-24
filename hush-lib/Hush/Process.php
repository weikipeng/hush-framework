<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Process
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

/**
 * @see Hush_Process_Exception
 */
require_once 'Hush/Process/Exception.php';

/**
 * @see Hush_Util
 */
require_once 'Hush/Util.php';

/**
 * Set basic environment
 * Give us eternity to execute the script
 */
ini_set("max_execution_time", "0");
ini_set("max_input_time", "0");
@set_time_limit(0);

/**
 * PAY ATTENTION !!!
 * There is still some problem on PHP's shm_* methods in Multi-CPUs environment
 * So please use the shared variables carefully !!!
 * FYI : http://bugs.php.net/bug.php?id=8985
 * 
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
	 * @staticvar int
	 */
	public static $globalMemorySize = 16777216; // 1024 * 1024 * 16
	
	/**
	 * @staticvar int
	 */
	public static $sharedMemorySize = 16777216; // 1024 * 1024 * 16

	/**
	 * @staticvar bool
	 */
	public static $stopAfterRun = true;

	/**
	 * @var int
	 */
	public $ftbm = 0;
	
	/**
	 * @var int
	 */
	public $ftbr = 0;
	
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
		// ftok base id
		$this->ftbm = ftok(__FILE__, 'm');
		$this->ftbr = ftok(__FILE__, 'r');
		
		// get global process id
		$this->name = get_class($this);
		$this->gid = $this->__hashcode($this->name);
		
		// get process id from name
		$this->name .= '_' . $name;
		$this->pid = $this->__hashcode($this->name);
		
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
		$key = $this->__hashcode($k);
		$val = $v ? $v : self::$nullVal;
		
		// avoid dirty write
		$this->lock();
		@shm_put_var($this->shared, $key, $val);
		$this->unlock();
		
		return $val;
	}
	
	/**
	 * Get shared variables
	 */
	public function __get ($k)
	{
		$key = $this->__hashcode($k);
		
		// avoid dirty read
		$this->lock();
		$val = @shm_get_var($this->shared, $key);
		$this->unlock();
		
		return $val ? $val : self::$nullVal;
	}
	
	/**
	 * Get & set global variables
	 */
	public function __global ($k, $v = null)
	{
		$key = $this->__hashcode($k);
		
		// get global variables
		if (!isset($v)) 
		{
			$this->lock();
			$val = @shm_get_var($this->global, $key);
			$this->unlock();
			
			return $val ? $val : self::$nullVal;
		}
		
		// set global variables
		else 
		{
			$val = $v ? $v : self::$nullVal;
			
			$this->lock();
			@shm_put_var($this->global, $key, $val);
			$this->unlock();
			
			return $val;
		}
	}
	
	/**
	 * Get string or key's hash code
	 * @param string $s
	 * @return int
	 */
	private function __hashcode ($s)
	{
		$code = $this->ftbr + Hush_Util::str_hash($s);
		
		return $code ? $code : $this->ftbr;
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
		$mutex_id = $this->ftbm + $this->pid;
		$this->mutex = sem_get($mutex_id, 1);
		
		// init global space for all
		$global_id = $this->ftbr + $this->gid;
		$this->global = shm_attach($global_id, self::$globalMemorySize);
		
		// init shared space for group
		$shared_id = $this->ftbr + $this->pid;
		$this->shared = shm_attach($shared_id, self::$sharedMemorySize);
		
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
	 * Protect shared variables dirty read/write
	 * Please use this method when data is important
	 * Especially when do something for database in multi-processes
	 * Pay attention that this method will have speed slower
	 * 
	 * @return void
	 */
	protected function __safewait ()
	{
		$rs = 11111 * self::$maxProcessNum;
		$re = 33333 * self::$maxProcessNum;
		$this->sleep(rand($rs, $re));
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
				// force to kill process after run
				if (self::$stopAfterRun) {
					$this->stop();
				}
			}
		}
	}
	
	/**
	 * Wait processes
	 * 
	 * @return void
	 */
	private function __waitpid ($pids)
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
			$this->__safewait(); // stagger each process
			$pids[] = $this->__process();
		}
		
		$this->__waitpid($pids);
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
		$this->__release(); // must release all resource first
		
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
		@sem_release($this->mutex);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// abstract methods
	
	protected function __init () {} // to be overridden
	
	abstract protected function run ();
}
