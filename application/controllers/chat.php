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
	
	public function history() {

		$pid = $_REQUEST['pid'];

 		$this->db->select(array('username', 'message'));
        $this->db->where('pid', $pid);
        $query = $this->db->get('chat');

        if($query->num_rows()>0){

            $data['history'] =  $query->result_array();
            $data['success'] = true;

           $this->output
           		->set_content_type('application/json')
    			->set_output(json_encode($data));

        } else {
			echo json_encode(array('success' => true));
        }

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

		/*
		if (!isset($_SESSION['username'])) {
			
			$_SESSION['username'] = 'user-' . $_SESSION['userid'];	
		}
		*/

		$username = $_SESSION['username'];
		$uid = $_SESSION['userid'];
		 
		$socket_id = $_POST['socket_id'];
		$channel_name = $_POST['channel_name'];
		 
		$presence_data = array(
		   'username' => $username
		);
		 
		echo $this->pusher->presence_auth(
		   $channel_name, 
		   $socket_id, 
		   $uid,
		   $presence_data 
		);

	}


	public function send() {

		session_start();
		 
		$message = $_POST['message'];
		$channel = $_POST['channel_name'];

		$message = trim(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

		// Save Message to Database
		$this->saveMessage($_SESSION['username'], $message, $channel);
		 
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


	private function saveMessage($u, $m, $c) {

		$nc = ltrim($c, 'presence-');

      	$data['id'] = NULL;
        $data['pid'] = $nc;
        $data['username'] = htmlspecialchars($u);
        $data['message'] = htmlspecialchars($m);
        $data['timestamp'] = time();

        $this->db->insert('chat', $data); 

	}


	public function loadHistory(){

		// STUFF.

	}

}