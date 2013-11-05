<?php
if(!session_start()){
    session_start();
}
  class Create_Registration_Form extends CI_Controller{
  
      public $ck_data     =     array(); 
      var $site_id;  
      
      function __construct()
      {
          
          parent::__construct();
          
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
        $this->template->set_template('gws');
         // call load_asset_form
        $this->load_asset_form(); 
        $this->load->model('Registration_Forms_Model');  
        $this->load->model('Menus_Model');  
        $this->load->model('Pages_Model');  
        $this->load->model('PagesModel');  
        $this->site_id = $_SESSION['site_id'];
             
      }
      
      function index()
      { 
    
       
      // $this->load->view('Create_Registration_Form_View', $this->ck_data);
       $data = array ();
       $data[''] = '';
       $data['menus'] = $this->Menus_Model->getAllMenus($this->site_id);
       $data['page'] = $this->PagesModel->get_pages_dropdown($this->site_id); 
   //    $data['page'] = $this->PagesModel->get_pages_dropdown($this->site_id); 
       $data['role'] = $this->Menus_Model->getRolesDropdown(); 
       $data['ck_data'] = $this->ck_data;
      
       $this->template->write_view('content','Create_Registration_Form_View',$data);
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
 
        $this->ck_data['ckeditor_2'] = array(
 
            //ID of the textarea that will be replaced
            'id'     =>     'ck_content_2',
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
 function create_contact ()
      {
 
       
        // $this->load->view('users_registration'); 
        // $this->load->helper(array('form', 'url'));
        $this->load->library('');  
      //  $this->load->library('form_validation'); 
        
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
             $reg_form_data = array();
             
             $reg_form_data['form_title'] = $this->input->post('form_fname');
             $reg_form_data['site_id'] = $this->site_id;
             
             $reg_form_data['form_intro'] = $this->input->post('form_info_txt');
             $reg_form_data['form_thank_u'] = $this->input->post('form_thank_txt');
             $reg_form_data['form_menu'] = $this->input->post('form_main_menu');
             if($this->input->post('form_main_menu') == 'none')
             {
                $reg_form_data['form_menu_page'] = $this->input->post('page');   
             }else{
                $reg_form_data['form_menu_page'] = 0;  
             }
                
             $reg_form_data['form_menu_parent'] = $this->input->post('parent');
             if($this->input->post('same_as_title_chk')=='1'){
                $reg_form_data['form_menu_item_text'] = $reg_form_data['form_title'];   
             }else{
                $reg_form_data['form_menu_item_text'] = $this->input->post('menu_item_txt');    
             }
             
             $reg_form_data['form_permissions'] = $this->input->post('form_permissions');
             if($this->input->post('form_permissions') == 'Level of Access'){
                $reg_form_data['form_permissions_id'] = $this->input->post('options_acess_level');  
             }else{
                $reg_form_data['form_permissions_id'] = 0;  
             }
             
             $reg_form_data['form_payment_required'] = $this->input->post('require_payement');
             if($this->input->post('require_payement') == '1'){
                $reg_form_data['form_payment_qty'] = $this->input->post('payment_qty');  
             }else{
                $reg_form_data['form_payment_qty'] = 0;  
             }
             $reg_form_data['form_complete_action'] = $this->input->post('after_complete'); 
                                                     
             $reg_form_data['form_publish'] = $this->input->post('form_publish');
             $reg_form_data['form_email_to'] = $this->input->post('email_to'); 
             $reg_form_data['form_make_survey'] = $this->input->post('make_survey'); 

              
              
            $items = $this->input->post('items'); 

             //echo '<pr>';
//             print_r($reg_form_data);  
//             echo '</pr>';
             
             
             
             


             
             
             
             
        $this->Registration_Forms_Model->add_registration_form($reg_form_data,$items); 
        echo "Data saved Successfully ....."; 
        redirect(base_url().'index.php/Registration_Froms', 'location'); 
            
//                $total = count($this->input->post('items'));
//               for ($i=0; $i<=$total; $i++){
            ///foreach ($this->input->post('items') as $key => $value) {
//                 foreach($items as $element)
//                  {
//                      $new_item = array(
//                            'title' => $element['title'],
//                            'type' => $element['type'],
//                            'required' => $element['required'],
//                            'order' => $element['order']
//                            );
//              
//                  }
//                  echo "<pre>";
//             print_r($new_item);
//              echo "</pre>";
  //          }
         //   $this->db->addProduct($new_item); //This is a function that adds the records(array) to database.
         
               
              
          //  $this->Contact_Management_Model->add_contact_data($contact_data);
            
          // $this->load->view('formsuccess'); 
      //  }
        
          
      }
      

      
      
      
  }
?>
