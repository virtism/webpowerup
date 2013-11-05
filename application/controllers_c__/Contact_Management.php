<?php
  class Contact_Management extends CI_Controller{
  
	  public $ck_data     =     array(); 
	  
	  function __construct()
	  {
		  
		  parent::__construct();
		  
		 $this->load->database();
		 
		 
		 $this->load->helper('url');
		 $this->load->library('Template');
		 $this->template->set_template('gws'); 
		 
		 $this->load->model('Contact_Management_Model');    
			  
	  }
	  
	  function index()
	  { 
	  //$this->load->model('Contact_Management_Model');        
	//echo base_url();
	//exit;
	
	   $show_data['view_all_records'] = $this->Contact_Management_Model->show_all_contact();
	   
       //$this->template->write('title', 'Contact Management');
	   $this->template->write_view('content','Contact_Management_View',$show_data);
	   $this->template->render();
	   //$this->load->view('Contact_Management_View',$show_data);
	  }
			
	  
	  // view individual contact page description 
	function  view_Contact_page ()
	 {
		$page_id = $this->uri->segment(3);
		//$page_id.">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
		 if(!$page_id){$page_id = 1;}
	   // $page_id = 1;
		$contact_data= array ();
		$contact_data = $this->Contact_Management_Model->contact_page_data($page_id); 
	   $data['left_menu'] = $this->Contact_Management_Model->left_menu();
	   $data['right_menu'] = $this->Contact_Management_Model->right_menu(); 
		
		
	   $data['contact_id'] = $contact_data['contact_id'];
	   $data['contact_name'] = $contact_data['contact_name'];
	   $data['contact_country'] = $contact_data['contact_country'];
	   $data['contact_state'] = $contact_data['contact_state'];
	   $data['contact_city'] = $contact_data['contact_city'];
	   $data['contact_address'] = $contact_data['contact_address'];
	   $data['contact_zip'] = $contact_data['contact_zip'];
	   $data['contact_position'] = $contact_data['contact_position'];
	   $data['contact_phone'] = $contact_data['contact_phone'];
	   $data['contact_fax'] = $contact_data['contact_fax'];
	   $data['contact_google_code'] = $contact_data['contact_google_code'];
	   $data['contact_extra_info'] = $contact_data['contact_extra_info'];
	   
	  $this->load->view('Contact_Management_View_User',$data); 
	 
	// $this->template->write_view('content','Contact_Management_View_User',$data);
	// $this->template->write_view('sidebar','Contact_Management_View_User',$data_menu);
	// $this->template->render();
		 
		 
	 }
	 
	  // method to soft delete contact
	  function delete_contact()
	  {
			$page_id = $this->uri->segment(3);
			$contact_data = $this->Contact_Management_Model->delete_contact_soft($page_id);
		   // $contact_data = $this->Contact_Management_Model->delete_contact_hard($page_id); 
		  
	  }
	  
  }
?>
