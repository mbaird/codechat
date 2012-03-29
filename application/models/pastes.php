<?php

class Pastes extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        parent::__construct();

    }

    function checkRevision($rev) {
        $query = $this->db->select('1', FALSE)->where('revision = ' . $rev)->limit(1)->get('pastes');
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

    function latestRevision($pid) {
            
        // Get byt pid and revision
        $this->db->where('pid', $pid);
        $this->db->order_by('revision', 'DESC'); 
        $this->db->limit(1);

        $query = $this->db->get('pastes');

        foreach ($query->result_array() as $row)
        {
            $latest = $row['revision'];
        }

        return $latest;

    }
    
    function getPaste($seg=2, $rev=0) {

        // Ensure a pid is specified
        if($this->uri->segment($seg) == '')
        {
            redirect('');
        }
        else
        {
            $pid = $this->uri->segment($seg);
        }

        // Check if a revision is specified
        if($this->uri->segment(3) != '')
        {
            // Rev specified, check exists
            $rev = $this->uri->segment(3);
            if ($this->checkRevision($rev)) {
                // Exists, go get it..
                $this->db->where('revision', $rev);
            } else {
                // Specified rev doesn't exist, redirect to latest
                redirect('/view/' . $pid . '/' . $this->latestRevision($pid));
            }
        } else {
            // No revision specified, redirect to latest
            redirect('/view/' . $pid . '/' . $this->latestRevision($pid));
        }

       
        // Get the paste
        $this->db->where('pid', $pid);
        $query = $this->db->get('pastes');

        
        foreach ($query->result_array() as $row)
        {
            $data['id'] = $row['id'];
            $data['pid'] = $row['pid'];
            $data['user'] = $row['user'];
            $data['lang_code'] = $row['lang'];
            $data['lang'] = $this->languages->code_to_description($row['lang']);
            $data['raw'] = $row['raw'];
            $data['rev'] = $row['revision'];       
        }
        
        return $data;

    }

    /** 
    * Gets list of revisions for form
    *
    * @return array
    * @access public
    */
    
    function getRevisions($seg=2)
    {

        // Ensure a pid is specified
        if($this->uri->segment($seg) == '')
        {
            return null;
        }
        else
        {
            $pid = $this->uri->segment($seg);
        }

        $this->db->select(array('created', 'revision'));
        $this->db->where('pid', $pid);
        $this->db->order_by('revision', 'ASC'); 
        $query = $this->db->get('pastes');
        
        $data = array();
        
        foreach($query->result_array() as $row)
        {

            $p = date('jS M Y H:i', $row['created']);
            $r = $row['revision'];
            if ($r == 0) {
                $r = 'Original';
            } else {
                $r = 'Rev. ' . $r;
            }
            $data[$row['revision']] =  $r . ' - ' . $p;
        }
        
        return $data;

    }

    function getPastes($num, $offset) {

        $this->db->select(array('pid', 'lang', 'created', 'title', 'description'));
        $this->db->where('revision', 0);
        $query = $this->db->get('pastes',$num, $offset);

        if($query->num_rows()>0){
            return $query->result_array();
        }

    }

    function getNumPastes() {

        return $this->db->count_all('pastes');

    }

    function createRevision($seg=2) {

        $data['id'] = NULL;
        $data['user'] = 1;
        $data['lang'] = htmlspecialchars($this->input->post('lang'));
        $data['raw'] = htmlspecialchars($this->input->post('code'));
        $data['private'] = 0;
        $data['created'] = time();
        $data['revision'] = 0;

        // Ensure a pid is specified
        if($this->uri->segment($seg) == '')
        {
            return null;
        }
        else
        {
            $pid = $this->uri->segment($seg);
        }

        //Set PID
        $data['pid'] = $pid;

        // Set Revision
        $data['revision'] = $this->latestRevision($pid) + 1;

        $this->db->insert('pastes', $data); 

        $this->load->library('pusher');
        $this->pusher->trigger('presence-' . $pid, 'new_revision', array('success' => true));

        return 'view/'.$pid;

    }

    function createPaste() {

        $data['id'] = NULL;
        $data['user'] = 1;
        $data['lang'] = htmlspecialchars($this->input->post('lang'));
        $data['raw'] = htmlspecialchars($this->input->post('code'));
        $data['private'] = 0;
        $data['created'] = time();

        $data['title'] = htmlspecialchars($this->input->post('title'));
        $data['description'] = htmlspecialchars($this->input->post('desc'));

        do {
        
            if($this->input->post('private'))
            {
                $data['pid'] = substr(md5(md5(rand())), 0, 8);
            }
            else
            {
                $data['pid'] = rand(10000,99999999);
            }
                
                $this->db->select('id');
                $this->db->where('pid', $data['pid']);
                $query = $this->db->get('pastes');
                if($query->num_rows > 0)
                {
                    $n = 0;
                    break;
                }
                else
                {
                    $n = 1;
                    break;
                }
        
        } while($n == 0);


        $this->db->insert('pastes', $data); 


        return 'view/'.$data['pid'];
       
    }

        /** 
    * Checks if a paste exists
    *
    * @param int $seg URL Segment which the paste id is in
    * @return boolean
    * @access public
    */
    
    function checkPaste($seg=2)
    {
        if($this->uri->segment($seg) == "")
        {
            return false;
        }
        else
        {
            $this->db->where('pid', $this->uri->segment($seg));
            $query = $this->db->get('pastes');

            if($query->num_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

}

?>