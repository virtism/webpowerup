<?php
  class Registration_Froms extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
          
          parent::__construct();
          
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
        $this->template->set_template('gws');
          
          $this->load->database();
        
       $this->load->model('Registration_Forms_Model');        
      }
      
      function index()
      { 
    
       $show_data['view_all_records'] = $this->Registration_Forms_Model->show_all_forms();
       //$this->load->view('Registration_Froms_View',$show_data);
       $this->template->write_view('content','Registration_Froms_View',$show_data);
       $this->template->render();
 
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
       
       $data['left_menu'] = $this->Registration_Forms_Model->left_menu();
       $data['right_menu'] = $this->Registration_Forms_Model->right_menu(); 
        
        
       $data['form_id'] = $form_data['form_id'];
       $data['form_title'] = $form_data['form_title'];
       $data['form_intro'] = $form_data['form_intro'];
       $data['form_thank_u'] = $form_data['form_thank_u'];
       $data['form_menu'] = $form_data['form_menu'];
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
            $page_id = $this->uri->segment(3);
            $contact_data = $this->Registration_Forms_Model->delete_form_soft($page_id);
           // $contact_data = $this->Registration_Forms_Model->delete_form_hard($page_id); 
          
      }
      

      // generated form fields value save
      function save_form_fields()
      {
              
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
