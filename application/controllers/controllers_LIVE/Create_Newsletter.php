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
			$this->template->set_template('gws');			
			$this->site_id = $_SESSION['current_site_info']['site_id']; 
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
		  
		$data['ck_data']= $this->ck_data;
		$data['groups'] = $this->Groups_Model->dropdown_site_gropus_by_site_id($this->site_id);	
		$this->template->write_view('content','Create_Newsletter_View',$data);
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
       //Numaan 08/09/2011
      //confirm that user has logged-in    
      //$this->check_login();
      //end
       
        // $this->load->view('users_registration'); 
        // $this->load->helper(array('form', 'url'));
       // $this->load->library('');  
        $this->load->library('form_validation'); 
        
       /*
        $this->form_validation->set_rules('user_fname', 'User First Name : ', 'required');
        $this->form_validation->set_rules('user_lname', 'User Last Name : ', 'required');
        $this->form_validation->set_rules('user_zip', 'User Last Name : ', 'trim|required|max_length[6]|integer'); 
        $this->form_validation->set_rules('user_password', 'User Pasasword', 'trim|required|min_length[5]');  
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|callback_email_not_exist');
       */
       /* 
        if ($this->form_validation->run() == FALSE)
        {
             // error in form validation 
             $this->load->view('Contact_Management_View');
            
        }else{ */
             // fetch the form value into array
             $data = array();
             $current = date("Y-m-d  H:i:s", time());
             
             $data[1] = $this->input->post('subject'); 
             $data[2] = $this->input->post('body');
             $groups = $this->input->post('user_group');
			 $data[3] = implode(',',$groups);
             $data[4] = $current;
             

          // $new_date = date("l jS of F Y",strtotime($current));
           //$new_date2 = date("M j, Y ",strtotime($current)); 
          //  echo  $new_date.">>>>>>>>>>>>".$new_date2;
             //$data[3] = $this->input->post('send_now');
                                                                   
            
//            echo $data_tii= time(); 
//            $timestamp = strtotime($data_tii);
//             echo  $data_tii."<>>>>>>>>>>>>";
          
            $this->Newsletter_Model->save_newsletter($data); 
            redirect('Newsletter_Management');
             
           if($data[3]== '1'){
               
           // $this->send_newsletter($data);   
               
           }    
      }
      // method to send news letter at create news letter 
      function send_newsletter($data)
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