<?php
  class Create_Testimonial extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
          
          parent::__construct();
          
          $this->load->database();
        
         // call load_asset_form
       $this->load_asset_form(); 
       $this->load->model('Testimonial_Model');        
      }
      
      function index()
      { 
    
       
       $this->load->view('Create_Testimonial_View', $this->ck_data);
      
 
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
 function create_testimonial ()
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
           //  $current = date("Y-m-d  H:i:s", time());
             
             $data[1] = $this->input->post('publish'); 
             $data[2] = $this->input->post('form_main_menu');
             $data[3] = $this->input->post('parent');  
             $data[4] = $this->input->post('body');

             

          // $new_date = date("l jS of F Y",strtotime($current));
           //$new_date2 = date("M j, Y ",strtotime($current)); 
          //  echo  $new_date.">>>>>>>>>>>>".$new_date2;
             //$data[3] = $this->input->post('send_now');
                                                                   
            
//            echo $data_tii= time(); 
//            $timestamp = strtotime($data_tii);
//             echo  $data_tii."<>>>>>>>>>>>>";
          
            $this->Testimonial_Model->save_testimonial($data); 
              echo "Data saved Successfully ....."; 
             
           if($data[3]== '1'){
               
           // $this->send_newsletter($data);   
               
           }    
            

          
      }
      

      

      
      
      
  }
?>
