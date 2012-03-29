<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends MY_Controller {

	/** 
	* Class Constructor
	*
	* @return void
	*/

	function __construct() 
	{
		parent::__construct();
		$this->load->library('pusher');
	}


	/** 
	* Chat Root controller
	*
	* @return void
	* @access public
	*
	*/
	public function index(){	



	}
	

	public function start() {

		session_start();

		$username = $_REQUEST['username'];
		$username = trim(filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
		
		$_SESSION['username'] = $username;
		 
		//set a unique id for the user. since we don't have a working user system, we'll just use the time()
		//variable to generate a unique id, and add the user's name to it and the user's session id, then
		//MD5 the whole thing
		$_SESSION['userid'] = md5(time() + '_' + $username + '_' + session_id());
		 
		echo json_encode(array('success' => true));

	}


	public function auth() {

		session_start();
		 
		$socket_id = $_POST['socket_id'];
		$channel_name = $_POST['channel_name'];
		 
		$presence_data = array(
		   'username' => $_SESSION['username']
		);
		 
		echo $this->pusher->presence_auth(
		   $channel_name, 
		   $socket_id, 
		   $_SESSION['userid'],
		   $presence_data 
		);

	}


	public function send() {

		session_start();
		 
		$message = $_POST['message'];
		$channel = $_POST['channel_name'];
		 
		$message = trim(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
		 
		$message = "<strong>&lt;{$_SESSION['username']}&gt;</strong> {$message}";

		$this->pusher->trigger(
		   $channel, //the channel
		   'new_message', //the event
		   array('message' => $message) //the data to send
		);
		 
		echo json_encode(array(
		   'message' => $message,
		   'success' => true
		));


	}
}