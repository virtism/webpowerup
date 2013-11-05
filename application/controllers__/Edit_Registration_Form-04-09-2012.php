<?php
if(!session_start()){
    session_start();
}
  class Edit_Registration_Form extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
          
          parent::__construct();
          
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Template');
        
         // call load_asset_form
		$this->load_asset_form();
		$this->load->model('Menus_Model');  
		$this->load->model('Pages_Model');  
		$this->load->model('PagesModel');  
		$this->load->model('Registration_Forms_Model'); 
		$this->site_id = $_SESSION['site_id'];
		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
      }
      
      function index()
      { 
        $rec_id = $this->uri->segment(3);
		$data['menus'] = $this->Menus_Model->getAllMenus($this->site_id);
       	$data['pages']  = $this->Menus_Model->getPages($this->site_id);
		//$data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
        $data['values']= $this->Registration_Forms_Model->get_form_data($rec_id);
        $data['fields']= $this->Registration_Forms_Model->get_form_fields($rec_id);
		$data['options'] = $this->Registration_Forms_Model->get_form_fields_options($rec_id); 
        $data['ck_data']= $this->ck_data;
		
        $this->template->write_view('content','registration_form/Edit_Registration_Form_View',$data);
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
 function edit_reg_data ()
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
             $reg_form_data = array();
             $reg_form_data[0] = $this->input->post('id'); 
             $reg_form_data[1] = $this->input->post('form_fname');
             
             $reg_form_data[2] = $this->input->post('form_info_txt');
             $reg_form_data[3] = $this->input->post('form_thank_txt');
             $reg_form_data[4] = $this->input->post('form_main_menu');
             $reg_form_data[5] = $this->input->post('parent');
             if($this->input->post('same_as_title_chk')=='1'){
                $reg_form_data[6] = $reg_form_data[1];   
             }else{
                $reg_form_data[6] = $this->input->post('menu_item_txt');    
             }
             
             $reg_form_data[7] = $this->input->post('form_permissions');
             $reg_form_data[8] = $this->input->post('require_payement');
             $reg_form_data[9] = $this->input->post('after_complete'); 
                                                     
             $reg_form_data[10] = $this->input->post('form_publish');
             $reg_form_data[11] = $this->input->post('email_to'); 
             $reg_form_data[12] = $this->input->post('make_survey'); 
			 $items = $this->input->post('items'); 
			 $total = count($this->input->post('items'));
         
         //   foreach ($this->input->post('items') as $key => $value) {
                 foreach($items as $item)
                  {
                            $title = $item['title'];
                            $type = $item['type'];
                            
                            
							
							if(isset($item['required']) )
							{
                                if($item['required']=='on')
								{
                                  $required ='Yes';  
                                }
								else
								{
                                  $required = 'No';
								}
                            }else 
							{
                               $required = 'No'; 
                            }
                            $order =$item['order'];
                             if(!$item['order']){
                               $order = '0'; 
                            }
                            $id = $item['id'];
                  
				  $update['form_id'] = $reg_form_data[0];           
                  $update['field_title'] = $title; 
                  $update['field_type'] = $type;
                  $update['field_required'] = $required;
                  $update['field_sequence'] = $order;
                  $new_id = $id;
                  $this->Registration_Forms_Model->edit_registration_form_fields($update,$new_id); 
                  }

                  $this->Registration_Forms_Model->edit_registration_form($reg_form_data,$items);
       
                   redirect('/Registration_Froms/', 'location');
				   // echo "DATA EDITED";       
          
      }
      
  
      
      
      
  }
?>