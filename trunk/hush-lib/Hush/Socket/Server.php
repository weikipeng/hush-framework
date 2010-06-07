<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Socket
 * @author     James.Huang <james@ihush.com>
 * @copyright  Copyright (c) iHush Technologies Inc. (http://www.ihush.com)
 * @version    $Id$
 */

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
* as it comes in. */
ob_implicit_flush();

/**
 * @see Hush_Exception
 */
require_once 'Hush/Socket/Exception.php';

/**
 * @see Hush_Exception
 */
require_once 'Hush/Socket.php';

/**
 * @package Hush_Socket
 * @example Server.php Example for using Hush_Socket_Server class
 */
class Hush_Socket_Server extends Hush_Socket
{
	/**
	 * @staticvar int
	 */
	public static $debugMode = 0;
	
	/**
	 * @var int
	 */
	public $sumClientId = 0;
	
	/**
	 * @var int
	 */
	public $sumClientNo = 0;
	
	/**
	 * Contruct
	 */
	public function __construct ($host = '', $port = 0) 
	{
		$this->__initialize(trim($host), $port);
	}
	
	/**
	 * Destruct
	 */
	public function __destruct ()
	{
		@socket_close($this->sock);
	}
	
	/**
	 * Magic method
	 */
	public function __call ($method, $params)
	{
		if (!method_exists($this, $method)) {
			return null;
		}
		$this->$method($params);
	}
	
	/**
	 * Init socket resource
	 * Only once !!!
	 * 
	 * @return resource
	 */
	public function initSocket ()
	{
		if (!$this->host ||
			!$this->port) {
				throw new Hush_Socket_Exception("Please set server's host and port first");
			}
		
		if (($this->sock = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
			echo "socket_create() failed.\nReason: " . socket_strerror($this->sock) . "\n";
		}
		
		if (!@socket_bind($this->sock, $this->host, $this->port)) {
			echo "socket_bind() failed\n";
		}
		
		if (!@socket_listen($this->sock, 5)) {
			echo "socket_listen() failed\n";
		}
		
		return $this->sock;
	}
	
	/**
	 * Run server as a daemon
	 * 
	 * @return void
	 */
	 public function daemon ($init = true) 
	 {
	 	if ($init) $this->initSocket();
	 	
		if (!$this->sock) {
			throw new Hush_Socket_Exception("Please init socket resource first");
		}

		if (($this->sock = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
			echo "socket_create() failed.\nReason: " . socket_strerror($this->sock) . "\n";
		}

		if (!@socket_bind($this->sock, $this->host, $this->port)) {
			echo "socket_bind() failed\n";
		}

		if (!@socket_listen($this->sock, 5)) {
			echo "socket_listen() failed\n";
		}

		@socket_set_block($this->sock);

		do {
			
			if (($msgsock = socket_accept($this->sock)) < 0) {
				break;
			}
			else {
				$this->sumClientId++;
				$this->sumClientNo++;
				
				if (self::$debugMode) {
					echo "Client # : " .$this->sumClientId ."\n";
					echo "Client @ : " .$this->sumClientNo ."\n";
				}
			}

			do {
				
				$buf = trim($buf); // trim "\r\n" chars
				
				if (!$buf) continue;
				
				// deal with quit command from client
				if ($buf == 'quit') {
					unset($buf);
					break;
				}
				
				// deal with shutdown command from client
				if ($buf == 'shutdown') {
					socket_close($msgsock);
					unset($buf);
					break 2;
				}
				
				// deal with common request from client
				$pack = unserialize($buf);
				if ($pack['method']) {
				
					$method = $pack['method'];
					$params = $pack['params'];
					
//					$result = $this->$method($params);
					$result = call_user_method_array($method, $this, $params);
					
					if (self::$debugMode) {
						echo "result   : ";
						var_dump($result);
						echo "\n";
					}
					
					// must escape null or false value
					// for preventing socket error
					$result = serialize($result);
					
					@socket_write($msgsock, $result, strlen($result));
				}
				
			}
			while ($buf = @socket_read($msgsock, 2048, PHP_NORMAL_READ));
			
			socket_close($msgsock);
			
			$this->sumClientNo--;
		}
		while (true);

		@socket_close($this->sock);
	}
	
	/**
	 * Echo messages in server
	 * 
	 * @param int $mode Debug mode (int number)
	 */
	public function debugMode ($mode = false)
	{
		self::$debugMode = $mode;
	}
}
