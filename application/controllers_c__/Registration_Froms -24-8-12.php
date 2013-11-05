<?php
if(!session_start()){
    session_start();
}
  class Registration_Froms extends CI_Controller{
  
      public $ck_data     =     array(); 
      var $site_id; 
      function __construct()
      {
          
          parent::__construct();
          
        $this->load->helper('url');
		$this->load->helper('custom_helper');
        $this->load->library('form_validation');
		$this->load->model('customers_model');
        $this->load->library('Template');
        $this->template->set_template('gws');
		 $this->load->library('session');
          
          $this->load->database();
        
       $this->load->model('Registration_Forms_Model');
	  // echo "<pre>";
	  // print_r($_SESSION);
	  // exit;
       $this->site_id = $_SESSION['site_id'];        
      }
      
      function index()
      { 
	 	is_login();
	  	$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Registration Forms');
    
       $show_data['view_all_records'] = $this->Registration_Forms_Model->show_all_forms($this->site_id);
       //$this->load->view('Registration_Froms_View',$show_data);
       $this->template->write_view('content','Registration_Froms_View',$show_data);
       $this->template->render();
 
      }     
	  
	  function details()
	  {
		
		$register_link = current_url();
		$this->session->set_userdata("register_form", $register_link);
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Registration Forms Detail');
        $data['forms'] = $this->Registration_Forms_Model->get_all_form($this->site_id);
	   
        $this->template->write_view('content','registration_form_details',$data);
        $this->template->render();
	  }
	  
	  function submits($form_id)
	  {
		$this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css');    //echo $str;exit;
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Registration Forms Detail', $this->session->userdata("register_form") );
		$this->breadcrumb->add_crumb('Registration Forms Submission');
		
		
        $data['submits'] = $this->Registration_Forms_Model->get_all_form_submits($form_id);
	    $data['form_id'] = $form_id;
        $this->template->write_view('content','registration_form_submit',$data);
        $this->template->render();
	  }
	  
	  function submit_detail($submit_id)
	  {
		$data['submit_id'] = $submit_id;
        $data['submit'] = $this->Registration_Forms_Model->get_form_submits_detail($submit_id);
        $this->load->view('registration_form_submit_detail',$data);
        
	  }
	  
	  function exportCVS($form_id)
	  {
		 $submits = $this->Registration_Forms_Model->get_all_form_submits_for_export($form_id);
		 $this->load->helper('csv');
		 array_to_csv($submits,"Submission.csv");
	  }
	  
	  function submit_delete($form_id,$submit_id)
	  {
		  $r = $this->Registration_Forms_Model->form_submit_delete($submit_id);
		  if($r)
		  {
			  $msg = "Form sumbit deleted successfully";
		  }
		  else
		  {
			  $msg = "Form sumbit not deleted successfully";
		  }
		  $this->session->set_flashdata('rspDeleteSub', $msg);
		  
		  redirect("Registration_Froms/submits/".$form_id);
	  }
	  
      // view individual contact page description 
     function   view_registration_form ()
     {
        $page_id = $this->uri->segment(3);
        //$page_id.">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
         if(!$page_id){$page_id = 1;}
       // $page_id = 1;
        $contact_data= array ();
      $form_data = $this->Registration_Forms_Model->registration_form_data($page_id); 
      $form_fields = $this->Registration_Forms_Model->registration_form_fields($page_id);  

       $data['form_fields'] = $form_fields;
       
       /*$data['left_menu'] = $this->Registration_Forms_Model->left_menu();
       $data['right_menu'] = $this->Registration_Forms_Model->right_menu(); */
       
       $data['left_menu'] = '';
       $data['right_menu'] = '';
       
        
        
       $data['form_id'] = $form_data['form_id'];
       $data['form_title'] = $form_data['form_title'];
       $data['form_intro'] = $form_data['form_intro'];
       $data['form_thank_u'] = $form_data['form_thank_u'];
      // $data['form_menu'] = $form_data['form_menu'];
       $data['form_menu_parent'] = $form_data['form_menu_parent'];
       $data['form_menu_item_text'] = $form_data['form_menu_item_text'];
       $data['form_permissions'] = $form_data['form_permissions'];
       $data['form_payment_required'] = $form_data['form_payment_required'];
       $data['form_complete_action'] = $form_data['form_complete_action'];
       $data['form_publish'] = $form_data['form_publish'];
       $data['form_email_to'] = $form_data['form_email_to'];
       $data['form_make_survey'] = $form_data['form_make_survey'];
       

       
      //$this->load->view('Registration_Froms_View_User',$data); 
      $this->template->write_view('content','Registration_Froms_View_User',$data);
      $this->template->render();
         
         
     }
     
      // method to soft delete contact
      function delete_form()
      {	
	  		 /*echo "<script type='text/javascript'>deleteForm();</script>";*/
            $page_id = $this->uri->segment(3);
            $contact_data = $this->Registration_Forms_Model->delete_form_soft($page_id);
           // $contact_data = $this->Registration_Forms_Model->delete_form_hard($page_id); 
          
      }
      

      // generated form fields value save
      function save_form_fields()
      {
              
           
			   /*echo "<pre>";
			   print_r($_REQUEST);
			   exit;*/
			   $form_field_data = array();            
//             $form_field_data[1] = $this->input->post('form_fname');         
//             $form_field_data[2] = $this->input->post('form_info_txt');
//             $form_field_data[3] = $this->input->post('form_thank_txt');
//             $form_field_data[4] = $this->input->post('form_main_menu');
//             $form_field_data[5] = $this->input->post('parent');


          $total = count($this->input->post('field'));
        //  echo $total.":: ToTal >>>>>>>>>>>>";
           $items = $this->input->post('field');  
            foreach($items as $key => $item)
            {   //  is_array($items)
                
                $field = $item['value'];
                $id = $item['id'];
                
              $form_data = $this->Registration_Forms_Model->form_fields_value_save($field,$id );    
                }
              //  $name ="field_".rand(0,9);
              //$new_item = array ($id,$title,$name,$type,$required,$order ); 
              echo "DATA SAVED Successfully";   
     }
  }
?>
