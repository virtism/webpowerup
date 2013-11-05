<?php
  class Edit_Autoresponder extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
          
          parent::__construct();
          
          $this->load->database();
        $this->load->library('session');
         $this->load->helper('url');
         $this->load->library('Template');
		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();               
         
         // call load_asset_form
       $this->load_asset_form(); 
       $this->load->model('Autoresponders_Model'); 
	   $this->load->model('Groups_Model');       
      }
      
      function index($site_id, $auto_id)
      {
		$this->breadcrumb->clear();
       	$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Edit Autoresponder' ); 
    
        $data['values']= $this->Autoresponders_Model->get_autoresponder_data($auto_id);
		$data['groups'] = $this->Autoresponders_Model->dropdown_site_gropus_by_site_id($site_id);
		$data['site_id'] = $site_id;
        /*echo "<pre>";
        print_r($data);
		exit;*/
        $data['ck_data']= $this->ck_data; 
        //$this->load->view('Edit_Autoresponder_View', $data);
        $data['all_groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
        $this->template->write_view('content','autoresponder/edit_autoresponder_view',$data);
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
 function edit_autoresponder ($site_id)
      {
 
       
        // $this->load->view('users_registration'); 
        // $this->load->helper(array('form', 'url'));
		//echo '<pre>'; print_r($_REQUEST);
        $this->load->library('');  
        $this->load->library('form_validation');
		 $data = array();
		 $current = time();
		 $data['respond_id'] = $this->input->post('id'); 
		 $data['respond_name'] = $this->input->post('name');
		 $data['respond_group'] = $this->input->post('user_group');
		 
		 if($this->input->post('when_to_send')=='immediate' ){
			 
			 $data['respond_send_immediately'] = 'Yes';
			 $data['respond_send_value'] 	= '';
			 $data['respond_send_key'] 		= $this->input->post('send_key');  
			 $data['respond_send_after'] 	= $this->input->post('send_after'); 
			 
		 }else if($this->input->post('when_to_send')=='according'){
			 
			$data['respond_send_immediately'] = 'No';
			$data['respond_send_key'] 		  = $this->input->post('send_key');
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
			$data['respond_send_key'] = $this->input->post('send_key');  
			$data['respond_send_after'] = $this->input->post('send_after');     
		 }
		 
		 
		 $data['respond_from_addrress'] = $this->input->post('from_address');  
		 $data['respond_to_address'] = $this->input->post('to_address');
		 
		 $data['respond_subject'] = $this->input->post('subject'); 
		 $data['respond_message_body'] = $this->input->post('body');
		 
		   
		   
		 $data['respond_active'] = $this->input->post('active');  
		 $data['site_id'] = $site_id;
		 $data['creation_date'] = date('Y-m-d h-i-s');
		 
		 $this->firephp->log($data);
	   	 //echo '<pre>'; print_r($data);exit;
		$this->Autoresponders_Model->update_autoresponder($data); 
		
		 
	   if($this->input->post('when_to_send') == 'immediate'){
		   
	   // $this->send_autoresponder($data);   
		   
	   }
		redirect('autoresponders_management/index/'.$site_id);    
		

          
      }
      
      
      // method to send news letter at create news letter 
      function send_autoresponder($data)
      {
        
         $this->load->library('email');
          
              $subject = $data[1];
              $body = $data[2];
              $user_gruop = $data[3];
              
            $this->email->from('your@example.com', 'Your Name');
            $this->email->to('someone@example.com'); 
            $this->email->cc('another@another-example.com'); 
            $this->email->bcc('them@their-example.com'); 

            $this->email->subject('Email Test');
            $this->email->message('Testing the email class.');    

            $this->email->send();

            echo $this->email->print_debugger();    
              
              
      }
      

      
  }
?>
