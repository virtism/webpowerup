<?php
if(!session_start()){
    session_start();
}
  class Promotional_Boxes_Management extends CI_Controller{
      public $ck_data     =     array(); 
      function __construct()
      {
        parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Template');
		$this->load->library('Webpowerup');
		//Check user login
		$this->load->library('check_user_login');
        $this->check_user_login->checkLogin();
		$this->load->model('Promotional_Boxes_Model');
		
		$this->webpowerup->initialize_template();
      }
      function index()
      { 
		
       $show_data['view_all_records'] = $this->Promotional_Boxes_Model->get_all_promotional_box();
	  // echo "<pre>";print_r($show_data['view_all_records']);exit;
       //$this->load->view('Promotional_Boxes_Management_View',$show_data);
       $this->template->write_view('content','promotional_box/Promotional_Boxes_Management_View',$show_data);
       $this->template->render();
      }
      // view individual contact page description 
     function   view_promotional_boxe ()
     {
        $page_id = $this->uri->segment(3);
        //$page_id.">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
         if(!$page_id){$page_id = 1;}
       // $page_id = 1;
        $contact_data= array ();
       $data_fetch = $this->Promotional_Boxes_Model->show_promotional_boxe($page_id); 
     // echo "<pre>";
     // print_r($data_fetch);
       $data['left_menu'] = $this->Promotional_Boxes_Model->left_menu();
       $data['right_menu'] = $this->Promotional_Boxes_Model->right_menu(); 
       $data['box_id'] = $data_fetch['box_id'];
       $data['box_title'] = $data_fetch['box_title'];
       $data['box_show_title'] = $data_fetch['box_show_title'];
       $data['box_product'] = $data_fetch['box_product'];
       $data['box_position'] = $data_fetch['box_position'];
       $data['box_order'] = $data_fetch['box_order'];
       $data['box_publish'] = $data_fetch['box_publish'];
       $data['box_display_page'] = $data_fetch['box_display_page'];
       $data['box_permissions'] = $data_fetch['box_permissions'];
       $data['box_content'] = $data_fetch['box_content'];
       //$this->load->view('Promotional_Boxes_View',$data); 
       $this->template->write_view('content','promotional_box/Promotional_Boxes_View',$data);
       $this->template->render();
     }
      // method to soft delete contact
      function delete_promotional_boxe()
      {
            $page_id = $this->uri->segment(3);
            $contact_data = $this->Promotional_Boxes_Model->delete_soft($page_id);
           // $contact_data = $this->Promotional_Boxes_Model->delete_hard($page_id); 
      }
  }
?>
