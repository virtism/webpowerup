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
         // call load_asset_form
        //$this->load_asset_form();
		$this->load->model("Groups_Model"); 
        $this->load->model('Registration_Forms_Model');  
        $this->load->model('Menus_Model');  
        $this->load->model('Pages_Model');  
        $this->load->model('PagesModel');  
        $this->site_id = $_SESSION['site_id'];
		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
             
      }
      
      function index()
      { 
    
       // $this->load->view('Create_Registration_Form_View', $this->ck_data);
	   $data = array ();
       $data['menus'] = $this->Menus_Model->getAllMenus($this->site_id);
	   $data['pages'] = $this->Pages_Model->getAllPages($this->site_id);
	   $data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
	   
	   /*echo "<pre>";
	   print_r($data['groups']);
	   exit;*/
	   //$data['page'] = $this->PagesModel->get_pages_dropdown($this->site_id);
	   //$data['role'] = $this->Menus_Model->getRolesDropdown(); 
       //$data['ck_data'] = $this->ck_data;
	         
       $this->template->write_view('content','registration_form/Create_Registration_Form_View',$data);
       $this->template->render();
 
      }
      
      
      // method used for contact save data 
 	  function create_contact()
      { 
	  		 
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
             }
			 else
			 {
                $reg_form_data['form_menu_page'] = 0;  
             }
             	
			 $reg_form_data['form_menu_parent'] = $this->input->post('parent');
             if($this->input->post('same_as_title_chk')=='1')
			 {
                $reg_form_data['form_menu_item_text'] = $reg_form_data['form_title'];   
             }
			 else
			 {
                $reg_form_data['form_menu_item_text'] = $this->input->post('menu_item_txt');    
             }
             
             $reg_form_data['form_permissions'] = $this->input->post('form_permissions');
             if($this->input->post('form_permissions') == 'Level of Access')
			 {
                $reg_form_data['form_permissions_id'] = $this->input->post('options_acess_level');  
             }
			 else
			 {
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
			// echo "<pre>";	print_r($items); 	echo "</pre>"; die();
			 $groups = $this->input->post('group_access');
			 if(isset($groups))
			 {
				$reg_form_data['group_access'] = $this->input->post('group_access');
			 } 
			 
	    
			
			$this->Registration_Forms_Model->add_registration_form($reg_form_data,$items); 
		    // echo "Data saved Successfully ....."; 
			
			redirect(site_url().'Registration_Froms'); 
		
      }
  }
?>