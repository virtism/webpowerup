<?php
  class Autoresponders_Management extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
          
          parent::__construct();
          
          $this->load->database();
          
         $this->load->helper('url');
         $this->load->library('Template');
         $this->template->set_template('gws'); 
        
       $this->load->model('Autoresponders_Model');        
      }
      
      function index()
      { 
    
       $show_data['view_all_records'] = $this->Autoresponders_Model->show_all_autoresponder();
      // $this->load->view('Autoresponders_Management_View',$show_data);
      
      $this->template->write_view('content','Autoresponders_Management_View',$show_data);
      $this->template->render();
 
      }
            

      
      // view individual contact page description 
     function   view_autoresponder ()
     {
        $page_id = $this->uri->segment(3);
        //$page_id.">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
         if(!$page_id){$page_id = 1;}
       // $page_id = 1;
      $data_fetch= array ();
      $data_fetch = $this->Autoresponders_Model->autoresponder_data($page_id); 

       $data['left_menu'] = $this->Autoresponders_Model->left_menu();
       $data['right_menu'] = $this->Autoresponders_Model->right_menu(); 
        
        
       $data['respond_id'] = $data_fetch['respond_id'];
       $data['respond_name'] = $data_fetch['respond_name'];
       $data['respond_group'] = $data_fetch['respond_group'];
       $data['respond_send_immediately'] = $data_fetch['respond_send_immediately'];
       $data['respond_send_value'] = $data_fetch['respond_send_value'];
       $data['respond_send_key'] = $data_fetch['respond_send_key'];
       $data['respond_send_after'] = $data_fetch['respond_send_after'];
       $data['respond_from_addrress'] = $data_fetch['respond_from_addrress'];
       $data['respond_to_address'] = $data_fetch['respond_to_address'];
       $data['respond_subject'] = $data_fetch['respond_subject'];
       $data['respond_message_body'] = $data_fetch['respond_message_body']; 
       $data['respond_active'] = $data_fetch['respond_active']; 
       

       
      $this->load->view('Autoresponders_View',$data); 
      
      //$this->template->write_view('content','Autoresponders_Management_View',$show_data);
      //$this->template->render();

         
         
     }
     
      // method to soft delete contact
      function delete_autoresponder()
      {
            $page_id = $this->uri->segment(3);
            $contact_data = $this->Autoresponders_Model->delete_soft($page_id);
           // $contact_data = $this->Autoresponders_Model->delete_hard($page_id); 
          
      }
      
      
      
      
      
      
  }
?>
