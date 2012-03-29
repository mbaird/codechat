<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	/** 
	* Class Constructor
	*
	* @return void
	*/

	function __construct() 
	{
		parent::__construct();
		$this->load->model('languages');

	}

	/** 
	* Controller to prepare new paste form
	*
	* @return void
	* @access public
	*
	*/
	public function _form_prep() {

		// Get & Load Languages
		$this->load->helper(array('form', 'url'));
		$data['languages'] = $this->languages->get_languages();	
		$data['pusher'] = false;
		$this->load->view('pages/home', $data, true);	


	}

	/** 
	* Home page controller
	*
	* @return void
	* @access public
	*
	*/
	public function index(){	

		$this->title = "Codechat | Home";

		if(!isset($_POST['submit']))
		{
			// Load Form
			$data = $this->_form_prep();

			// Render Home Page
			$this->_render('pages/home');
		}
		else
		{
			// Create New Paste
			$this->load->model('pastes');
			$this->load->library('form_validation');

			$this->form_validation->set_rules('title', 'title', 'trim|required|min_length[2]|max_length[16]|xss_clean');
			$this->form_validation->set_rules('desc', 'description', 'trim|max_length[255]|xss_clean');
			$this->form_validation->set_rules('code', 'code', 'required');
			$this->form_validation->set_rules('lang', 'code language', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error fade in"> <a class="close" data-dismiss="alert">×</a>', '</div>');

			if ($this->form_validation->run() == FALSE)
			{

				$data = $this->_form_prep();
				$this->_render('pages/home');
			}
			else
			{					
				redirect($this->pastes->createPaste());
			}
		
		}
		
	}

	public function listall() {

		// load pagination class
	    $this->load->library('pagination');
	    $this->load->model('pastes');

	    $config['base_url'] = base_url().'/list/';
	    $config['total_rows'] = $this->pastes->getNumPastes();
	    $config['per_page'] = 10;
	    $config['uri_segment'] = 2;
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

	    $this->pagination->initialize($config);
	
   	 	$data['pastes'] = $this->pastes->getPastes($config['per_page'],$this->uri->segment(2));


   		$data['links'] = $this->pagination->create_links();

  
  		$data['pusher'] = false;
		// Load Paste Data
		$this->load->view('pages/all', $data, true);	

		// Render Home Page
		$this->_render('pages/all');

	}


	/** 
	* Controller method to show a paste.
	*
	* @return void
	* @access public
	*
	*/
	public function view() 
	{

		$this->title = "Codechat | View Code ";

		$this->load->model('pastes');	
		$this->load->helper('date');

		if(!isset($_POST['submit']))
		{
			$check = $this->pastes->checkPaste();
				
			if($check)
			{
				
				$data = $this->pastes->getPaste(2);
				$data['revs'] = $this->pastes->getRevisions();
				$data['pusher'] = true;

				// Load Paste Data
				$this->load->view('pages/view', $data, true);	


				// Render Home Page
				$this->_render('pages/view');
			}
			else
			{
				show_404();
			}
		}
		else
		{
			// Create New Revision
			$this->load->library('form_validation');

			$this->form_validation->set_rules('code', 'code', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error fade in"> <a class="close" data-dismiss="alert">×</a>', '</div>');
			
			if ($this->form_validation->run() == FALSE)
			{
				$data = $this->_form_prep();
				// LOAD THE ORIGINAL PAGE LOL
				$this->load->view('pages/home', $data);
			}
			else
			{					
				redirect($this->pastes->createRevision());
			}
		}

		
	}


	
}