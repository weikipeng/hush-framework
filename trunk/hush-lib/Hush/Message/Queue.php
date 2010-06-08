<?php
/**
 * Hush Framework
 *
 * @category   Hush
 * @package    Hush_Message
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */
 
/**
 * @see Hush_Message_Exception
 */
require_once 'Hush/Message/Exception.php';

/**
 * @see Hush_Message
 */
require_once 'Hush/Message.php';

/**
 * @package Hush_Message
 */
abstract class Hush_Message_Queue
{
	/**
	 * @var int
	 */
	public $qid = 0;
	
	/**
	 * @var string
	 */
	public $name = '';
	
	/**
	 * @var resource
	 */
	public $queue = null;
	
	/**
	 * @var mixed
	 */
	public $status = null;
	
	/**
	 * @var array
	 */
	public $handlers = array();
	
	public function __construct ($name = '')
	{
		if (!extension_loaded("sysvsem") ||
			!extension_loaded("sysvshm") ||
			!extension_loaded("sysvmsg")) {
				throw new Hush_Process_Exception("You need to open sysv* extensions");
				return false;
			}
		
		// get global queue name
		$this->name = get_class($this);
		
		// get queue id from name
		$this->name .= '_' . $name;
		$this->qid = hexdec($this->name);
		
		// init msg queue
		if (!$this->queue = msg_get_queue($this->qid, 0666)) {
			throw new Hush_Message_Exception("Queue " . $this->name . " create failed");
			return false;
		}
	}
	
	/**
	 * Get queue name
	 * 
	 * @return string
	 */
	public function getName ()
	{
		return $this->name;
	}
	
	/**
	 * Get queue
	 * 
	 * @return resource
	 */
	public function getQueue ()
	{
		if (!$this->queue = msg_get_queue($this->qid, 0666)) {
			throw new Hush_Message_Exception("Get queue " . $this->name . " failed");
			return false;
		}
		
		return $this->queue;
	}
	
	/**
	 * Get status
	 * 
	 * @return mixed
	 */
	public function getStatus ()
	{
		return $this->status;
	}
	
	/**
	 * Add handler for message
	 * 
	 * @param Hush_Message $message
	 * @return bool
	 */
	public function addMessage ($message)
	{
		if (!($message instanceof Hush_Message)) {
			throw new Hush_Message_Exception("Please add an instance of the Hush_Message");
			return false;
		}
		
		if (!$queue = $this->getQueue()) return false;
		
		// serialize : true ; blocking : false
		$errorcode = 0;
		$this->status = msg_send($queue, $message->getType(), $message->getData(), true, false, $errorcode);
		
		// catch send error code
		if ($errorcode) {
			throw new Hush_Message_Exception("Message send error : " . $errorcode);
		}
		
		return $this;
	}
	
	/**
	 * Add handler for message
	 * 
	 * @param Hush_Message_Handler $handler
	 * @return bool
	 */
	public function addHandler ($handler)
	{
		if (!($handler instanceof Hush_Message_Handler)) {
			throw new Hush_Message_Exception("Please add an instance of the Hush_Message_Handler");
			return false;
		}
		
		$this->handlers[] = $handler;
		
		return $this;
	}
	
	/**
	 * Receive one message
	 * 
	 * @return bool
	 */
	public function receive ()
	{
		if (!$queue = $this->getQueue()) return false;
		
		// unserialize : true ; MSG_IPC_NOWAIT
		$type = $data = null;
		if (msg_receive($queue, 0, $type, 1024, $data, true, MSG_IPC_NOWAIT)) 
		{
			// do handler process
			foreach ($this->handlers as $handler) {
				
				$message = new Hush_Message();
				$message->setType($type);
				$message->setData($data);
				
				$handler->setMessage($message);
				$handler->handler();
			}
			return true;
		}
		
		return false;
	}
	
	/**
	 * Start the queue dealing with all messages
	 * 
	 * @return bool
	 */
	public function start ()
	{
		if (!$queue = $this->getQueue()) return false;
		
		// clear type and data when start
		$type = $data = null;
		
		while ($this->size()) 
		{
			// receive messages on by one
			$this->receive();
		}
		
		return true;
	}
	
	/**
	 * Get size of the queue
	 * 
	 * @return int
	 */
	public function clear ()
	{
		if (!$queue = $this->getQueue()) return false;
		
		return msg_remove_queue($queue);
	}
	
	/**
	 * Get queue stats
	 * 
	 * @return resource
	 */
	public function stats ()
	{
		if (!$queue = $this->getQueue()) return false;
		
		return msg_stat_queue($queue);
	}
	
	/**
	 * Get size of the queue
	 * 
	 * @return int
	 */
	public function size ()
	{
		$stats = $this->stats();
		
		return $stats ? $stats['msg_qnum'] : 0;
	}
}