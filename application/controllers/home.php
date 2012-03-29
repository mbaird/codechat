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
		$this->load->view('pages/home', $data, true);	

		// Render Home Page
		$this->_render('pages/home');
	}

	/** 
	* Home page controller
	*
	* @return void
	* @access public
	*
	*/
	public function index(){	

		$this->title = "Codechat | Home ";

		if(!isset($_POST['submit']))
		{
			// Load Form
			$data = $this->_form_prep();
			$this->load->view('pages/home', $data);
		}
		else
		{
			// Create New Paste
			$this->load->model('pastes');
			$this->load->library('form_validation');

			$this->form_validation->set_rules('code', 'Code', 'required');
			$this->form_validation->set_rules('lang', 'Language', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$data = $this->_form_prep();
				$this->load->view('pages/home', $data);
			}
			else
			{					
				redirect($this->pastes->createPaste());
			}
		
		}
		
	
	}

	/** 
	* Controller method to show a paste.
	*
	* @return void
	* @access public
	*
	*/
	function view() 
	{
		$this->load->model('pastes');	
		$this->load->helper('date');

		if(!isset($_POST['submit']))
		{
			$check = $this->pastes->checkPaste();
				
			if($check)
			{
				
				$data = $this->pastes->getPaste(2);
				$data['revs'] = $this->pastes->getRevisions();
				
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

			$this->form_validation->set_rules('code', 'Code', 'required');
			
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