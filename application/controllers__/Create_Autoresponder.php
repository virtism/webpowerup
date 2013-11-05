<?php
  class Create_Autoresponder extends CI_Controller{
  
      public $ck_data = array();      
      function __construct()
      {
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('Template');
		$this->load->library('session');		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
		// call load_asset_form
		$this->load_asset_form(); 
		$this->load->model('Autoresponders_Model'); 
		$this->load->model('Groups_Model');
		$this->load->helper('date');      
      }
     
	  function index($site_id)
      { 
        $this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link"));
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Autoresponder Management', $this->session->userdata("responder_link") ); 
		$this->breadcrumb->add_crumb('Create' );
      	
		//echo $this->ck_data;exit;
		//echo "<pre>";print_r($this->ck_data);exit;
		$data['all_groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
      	$this->template->write_view('content','autoresponder/create_autoresponder_view',$data);
     	$this->template->render();
      }
      
      // method load_asset_form used to load ckeditor and ckfinder
      function load_asset_form ()
      {
        $this->load->helper('url'); //You should autoload this one ;)
        $this->load->helper('ckeditor');
 
 
        //Ckeditor's configuration
        $this->ck_data['ckeditor'] = array(
 
            //ID of the textarea that will be replaced
            'id'     =>     'ck_content',
            'path'    =>    'js/ckeditor',
 
            //Optionnal values
            'config' => array(
                'toolbar'     =>     "Full",     //Using the Full toolbar
                'width'     =>     "550px",    //Setting a custom width
                'height'     =>     '100px',    //Setting a custom height
 
            ),
 
            //Replacing styles from the "Styles tool"
            'styles' => array(
 
                //Creating a new style named "style 1"
                'style 1' => array (
                    'name'         =>     'Blue Title',
                    'element'     =>     'h2',
                    'styles' => array(
                        'color'     =>     'Blue',
                        'font-weight'     =>     'bold'
                    )
                ),
 
                //Creating a new style named "style 2"
                'style 2' => array (
                    'name'     =>     'Red Title',
                    'element'     =>     'h2',
                    'styles' => array(
                        'color'         =>     'Red',
                        'font-weight'         =>     'bold',
                        'text-decoration'    =>     'underline'
                    )
                )                
            )
        );
 
     
       
      }  // end  load_asset_form
      
      // method used for contact save data 
 function create_autoresponder ()
      {
 
			//echo '<pre>'; print_r($_REQUEST);
			$this->load->library(''); 	
			$this->load->library('form_validation'); 
      
             $data 					= array();
             $current 				= time();             
             $data['respond_name'] 	= $this->input->post('name');
             $data['respond_group'] = $this->input->post('user_group');
             
             if($this->input->post('when_to_send')=='immediate' ){
                 
                 $data['respond_send_immediately'] 	= 'Yes';
                 $data['respond_send_value'] 		= '';  
                 $data['respond_send_key'] 			= $this->input->post('send_key');  
                 $data['respond_send_after'] 		= $this->input->post('send_after'); 
                 
             }else if($this->input->post('when_to_send')=='according'){
                 
                 $data['respond_send_immediately'] 	= 'No';                  
                 $data['respond_send_key'] 			= $this->input->post('send_key');
				 
				 if($data['respond_send_key'] == 'Weeks')
				 {
				 	 $data['respond_send_value'] 	= $this->input->post('value_send')*7;  
                 }
				 else if($data['respond_send_key'] == 'Months')
				 {
				 	 $data['respond_send_value'] 	= $this->input->post('value_send')*30; 
				 }
				 else 
				 {
				 	$data['respond_send_value'] 	= $this->input->post('value_send');
				 }
				 
				 $data['respond_send_after'] 		= $this->input->post('send_after');  
             }
             
             
             $data['respond_from_addrress'] 		= $this->input->post('from_address');  
             $data['respond_to_address'] 			= $this->input->post('to_address');             
             $data['respond_subject'] 				= $this->input->post('subject'); 
             $data['respond_message_body'] 			= $this->input->post('body');
             
               
               
             $data['respond_active'] = $this->input->post('active');  
             $data['site_id'] = $_SESSION['site_id'];
			 $data['creation_date'] =  date("Y-m-d");
			// echo '<pre>'; print_r($data);exit;
			//echo  date("Y-m-d h:i:s", strtotime($data['creation_date']));exit;
			
			 $this->Autoresponders_Model->save_autoresponder($data); 
            // echo "Data saved Successfully ....."; 
             
           if($this->input->post('when_to_send') == 'immediate'){
               
           		$this->send_autoresponder($data);               
           }
		       
		   redirect("autoresponders_management/index/".$_SESSION['site_id']);          
      }
      
      
      // method to send news letter at create news letter 
      function send_autoresponder($data)
      {
        
         	$this->load->library('email');
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);          
            $subject = $data['respond_name'];
            $body = $data['respond_subject'];
			$emails_customers = $this->get_site_gropus_customer_by_site_id($data['respond_group']);
			//echo count($emails_customers);echo "<pre>";print_r($emails_customers);exit;
            $user_gruop = $data['respond_message_body'];
			foreach($emails_customers as $id => $mail)
			{
				//echo $mail;exit;
				$this->email->from($data['respond_from_addrress'], 'Your Name');
				$this->email->to($mail);           
				$this->email->subject($subject);
				$this->email->message($body);    
				$this->email->send();
			}
      }
	  
	  
	  function get_site_gropus_customer_by_site_id($group_id)
		{
					
					$groups_array = array();
					$c = $this->db->query("
					SELECT 
					c.customer_id,
					c.customer_login,
					c.customer_name,
					c.customer_email, 
					cgx.customer_id,
					cgx.group_id
					FROM  ec_customers_group_xref AS cgx
					JOIN `ec_customers` AS c
					ON c.customer_id = cgx.customer_id
					WHERE cgx.group_id = ".$group_id);
					//fetching customer for Group
					$int_count = $c->result_array();
					
					if ($c->num_rows() > 0)
					 {
						
						foreach($int_count as $record)
						{
							//customers registered to this group							
							$member_array[$record['customer_id']] = $record['customer_email'];
						}
							//$groups_array[$i]['users'] = $member_array;
													
					 }
					 else
					 {
						 //no customers registered to this group
						$groups_array[$i]['users'] = 0;
					 }
			//$groups_array[$i]['users'] = $this->get_site_registered_user_by_site_id($site_id);
			//print_r($member_array);exit;
			return $member_array;
	}
	
	function calculate_trail_end_date($start_date)
	{
		$date = strtotime($start_date. " +1 Days");
		$end_date = date("Y-m-d",$date);
		return $end_date;
	}
	  
  }
?>