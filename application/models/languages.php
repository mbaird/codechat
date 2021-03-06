<?php


class Languages extends CI_Model 
{

	/** 
	* Class Constructor
	*
	* @return void
	*/

	function __construct()
	{
		parent::__construct();
	}


	/** 
	* Checks if a language is valid, called from the main controller _valid_lang validation callback method
	*
	* @param string $lang Paste language
	* @return Boolean
	* @access public
	*/

	function valid_language($lang)
	{
		$this->db->where('code', $lang);
		$query = $this->db->get('languages');
		
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/** 
	* Gets list of languages from database to generate select field on paste form.
	*
	* @return array
	* @access public
	*/
	
	function get_languages()
	{
		$query = $this->db->get('languages');
		
		$data = array();
		
		foreach($query->result_array() as $row)
		{
			$data[$row['code']] = $row['pretty'];
		}
		
		return $data;
	}
	
	
	/** 
	* Takes a language code eg. php, cpp, html4 and converts it to its description eg. PHP, C++, Html 4 (Strict).
	*
	* @param string $code Paste language
	* @return Boolean|string
	* @access public
	*/
	
	function code_to_description($code)
	{
		$this->db->select('pretty');
		$this->db->where('code', $code);
		$query = $this->db->get('languages');
		
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				return $row['pretty'];
			}
		}
		else
		{
			return false;
		}
	}

}

?>
