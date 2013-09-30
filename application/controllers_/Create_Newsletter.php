<?php
if(!session_start()){
    session_start();
}
  class Create_Newsletter extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
			parent::__construct();
			$this->load->database();
			$this->load->helper('url');
			$this->load->library('Template');
			$this->load->library('session');
			$this->load->model('Groups_Model');
			$this->load->model('Newsletter_Model'); 
			$this->load_asset_form(); 
			$this->load->library('session');
			if(isset($_SESSION['current_site_info']['site_id']))
			{
				$this->site_id = $_SESSION['current_site_info']['site_id']; 
			}			
			$this->load->library('Webpowerup');
			$this->webpowerup->initialize_template();
      }
      
    //checks that user has logged-in Or not
    function check_login()
    {
        //checks if session user_info is set
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        /*
        echo "<pre>";
        print_r($user_role);
        exit;
        */
        
        if($user_info=='' && $user_role=='')
        {
            redirect('administrator/index');
        }
        else
        {
            return;
        }   
    }
    //end
    
      function index()
      {
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Newsletter Management', $this->session->userdata("news_link") ); 
		$this->breadcrumb->add_crumb('Create' );
		  
		$data['ck_data']= $this->ck_data;
		
		$data['groups'] = $this->Groups_Model->get_groups_by_site_id($this->site_id);
		
		$this->template->write_view('content','newsletter/Create_Newsletter_View',$data);
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
 function create_newsletter ()
      {
       
       //echo "<pre>";print_r($_REQUEST);exit;
		$this->load->library('form_validation'); 
        $data = array();
        $current 						= date("Y-m-d  H:i:s", time());
		$data['news_subject'] 			= $this->input->post('subject'); 
		$data['news_body'] 				= $this->input->post('body');
		$groups 						= $this->input->post('user_group');
		$data['news_recipient_group'] 	= implode(',',$groups);
		$data['news_date_created'] 		= $current;
		$data['site_id'] 				= $_SESSION['site_id'];
		$data['from'] 					= $_REQUEST['from'];
		$send_now						= $this->input->post('send_now');
		//echo "<pre>";print_r($data);exit;
		$this->Newsletter_Model->save_newsletter($data);
		if(isset($groups) && $send_now == 1)
		{
		 	
		  $this->send_newsletter($data);
		}    
		 redirect('Newsletter_Management');
			 
      }
      // method to send news letter at create news letter 
      function send_newsletter($data)
      {
         	$this->load->library('email');
            $subject = $data['news_subject'];
            $body = $data['news_body'];
            $user_gruop = explode(',',$data['news_recipient_group']);
			//print_r($user_gruop);exit;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			foreach($user_gruop as $group_id)
			{
				//print_r($group_id);exit;
				$customers = $this->Newsletter_Model->get_site_gropus_customer_by_group_id($group_id);
				foreach($customers as $mail)
				{
					$this->email->from($data['from'] , 'WebpowerUp');
					$this->email->subject($subject);
					$this->email->message($body);	
					$this->email->to($mail); 
					$send = $this->email->send();
				}
			}
		
			
      }
  }
?>