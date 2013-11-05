<?php
  class Edit_Contact extends CI_Controller{
  
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
       $this->load->model('Contact_Management_Model');       
      }
      
      function index()
      { 
    
       
       
      // $rec_id = 1;
       $rec_id = $this->uri->segment(3);  
       $data['values']= $this->Contact_Management_Model->get_contact_data($rec_id);
       
       
       $data['ck_data']= $this->ck_data;
      // print_r($data);
       
      // $this->load->view('Edit_Contact_View', $data);
      $this->template->write_view('content','Edit_Contact_View',$data);
      $this->template->render();
      
 
      }
      
      // method to edit contact data 
      function edit_contact()
      {
          
          $rec_id = $this->uri->segment(3);
         // echo $rec_id.">>>>>>>>>>>>";
          $this->Contact_Management_Model->edit_contact_data ($rec_id);
             
          
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
 
        $this->ck_data['ckeditor_2'] = array(
 
            //ID of the textarea that will be replaced
            'id'     =>     'content_2',
            'path'    =>    'js/ckeditor',
 
            //Optionnal values
            'config' => array(
                'width'     =>     "550px",    //Setting a custom width
                'height'     =>     '100px',    //Setting a custom height
                'toolbar'     =>     array(    //Setting a custom toolbar
                    array('Bold', 'Italic'),
                    array('Underline', 'Strike', 'FontSize'),
                    array('Smiley'),
                    '/'
                )
            ),
 
            //Replacing styles from the "Styles tool"
            'styles' => array(
 
                //Creating a new style named "style 1"
                'style 3' => array (
                    'name'         =>     'Green Title',
                    'element'     =>     'h3',
                    'styles' => array(
                        'color'     =>     'Green',
                        'font-weight'     =>     'bold'
                    )
                )
 
            )
        );  
       
      }  // end  load_asset_form
      
      // method used for contact save data 
     function update_contact ()
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
              
             $contact_data = array();
             $contact_menu = array();
             $contact_existing = array();
             
             $contact_data[0] = $this->input->post('id');
            //  echo  $contact_data[0].">>>>>>>>>>>>>>>>>>>>>>>>>>>>>".$rec_id; 
             $contact_data[1] = $this->input->post('contact_fname');
             
             $contact_data[2] = $this->input->post('contact_country');
             $contact_data[3] = $this->input->post('contact_state');
             $contact_data[4] = $this->input->post('contact_city');
             $contact_data[5] = $this->input->post('contact_address');
             $contact_data[6] = $this->input->post('contact_zip');
             $contact_data[7] = $this->input->post('contact_position');
             $contact_data[8] = $this->input->post('contact_phone');
             $contact_data[9] = $this->input->post('contact_fax');
             $contact_data[10] = $this->input->post('contact_google_code');
             $contact_data[11] = $this->input->post('contact_extra_info'); 
                                                     
             $contact_data[12] = $this->input->post('contact_publish');
             
             //Select A Menu -- options values
             $contact_menu[1] = $this->input->post('main_menu_chk'); 
             $contact_menu[2] = $this->input->post('category_menu_chk'); 
             $contact_menu[3] = $this->input->post('default_menu_chk'); 
             $contact_menu[3] = $this->input->post('dont_creat_link');
             $contact_menu[5] = $this->input->post('parent');
             
             //Existing Menu Links to the Contact Page  -- option values
             $contact_existing[1] = $this->input->post('contact_exist_title');
             $contact_existing[2] = $this->input->post('menu'); 
             $contact_existing[3] = $this->input->post('publish_chk');  
             
             
            $this->Contact_Management_Model->edit_contact_data($contact_data);
            
          // $this->load->view('formsuccess'); 
      //  }
        
          
      }
      

      
      
      
  }
?>
