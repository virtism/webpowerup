<?php
  class Edit_Autoresponder extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
          
          parent::__construct();
          
          $this->load->database();
        
         $this->load->helper('url');
         $this->load->library('Template');
         $this->template->set_template('gws');        
         
         // call load_asset_form
       $this->load_asset_form(); 
       $this->load->model('Autoresponders_Model');        
      }
      
      function index()
      { 
    
        $rec_id = $this->uri->segment(3);
        $data['values']= $this->Autoresponders_Model->get_autoresponder_data($rec_id);
      // echo "<pre>";
      //  print_r($data['fields']);
        $data['ck_data']= $this->ck_data; 
        //$this->load->view('Edit_Autoresponder_View', $data);
        
        $this->template->write_view('content','Edit_Autoresponder_View',$data);
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
 function edit_autoresponder ()
      {
 
       
        // $this->load->view('users_registration'); 
        // $this->load->helper(array('form', 'url'));
        $this->load->library('');  
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
             $current = time();
             $data[0] = $this->input->post('id'); 
             $data[1] = $this->input->post('name');
             $data[2] = $this->input->post('user_group');
             
             if($this->input->post('when_to_send')=='immediate' ){
                 
                 $data[3] = 'Yes';
                 $data[4] = '';  
                 $data[5] = $this->input->post('send_key');  
                 $data[6] = $this->input->post('send_after'); 
                 
             }else if($this->input->post('when_to_send')=='according'){
                 
                 $data[3] = 'No';
                 $data[4] = $this->input->post('value_send');  
                 $data[5] = $this->input->post('send_key');  
                 $data[6] = $this->input->post('send_after');   
             }
             
             
             $data[7] = $this->input->post('from_address');  
             $data[8] = $this->input->post('to_address');
             
             $data[9] = $this->input->post('subject'); 
             $data[10] = $this->input->post('body');
             
               
               
             $data[11] = $this->input->post('active');  
             
             //$data[4] = $current;
             
             //$data[3] = $this->input->post('send_now');
             
            
//            echo $data_tii= time(); 
//            $timestamp = strtotime($data_tii);
//             echo  $data_tii."<>>>>>>>>>>>>";
          
            $this->Autoresponders_Model->update_autoresponder($data); 
             echo "Data saved Successfully ....."; 
             
           if($this->input->post('when_to_send') == 'immediate'){
               
           // $this->send_autoresponder($data);   
               
           }    
            

          
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
