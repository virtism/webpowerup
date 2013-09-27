<?php
  class Testimonial_Management extends CI_Controller{
  
      
      function __construct()
      {
          
          parent::__construct();
          
          $this->load->database();
        
       $this->load->model('Testimonial_Model'); 
       $this->load->model('Business_Reviews_Model');      
      }
      
      function index()
      { 
       
    
       $show_data['view_all_records'] = $this->Testimonial_Model->show_all_testimonies();
       $this->load->view('Testimonial_Management_View',$show_data);
      
 
      }
            

      
      // view individual contact page description 
     function   view_testimonial ()
     {
        $page_id = $this->uri->segment(3);
        //$page_id.">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
         if(!$page_id){$page_id = 1;}
        //$page_id = 1;
        $data_fetch= array ();
        
      $data_testimonial = $this->Testimonial_Model->get_testimonial($page_id);
     
      
      $data['reviews'] = $this->Testimonial_Model->get_review($page_id); 
      
//       echo '<pre>';
//      print_r($data_review['reviews']);
      
      
       $data['left_menu'] = $this->Testimonial_Model->left_menu();
       $data['right_menu'] = $this->Testimonial_Model->right_menu(); 
 
       $data['monial_id'] = $data_testimonial['monial_id'];
       $data['monial_page_body'] = $data_testimonial['monial_page_body'];
       
//       $data['news_body'] = $data_testimonial['news_body'];
//       $data['news_recipient_group'] = $data_testimonial['news_recipient_group'];
//       $data['news_date_created'] = $data_testimonial['news_date_created'];
//       $data['news_date_sent'] = $data_testimonial['news_date_sent'];
       

       
      $this->load->view('Testimonial_View',$data); 

         
         
     }
     
      // method to soft delete contact
      function delete_testmonial()
      {
            $page_id = $this->uri->segment(3);
            $contact_data = $this->Testimonial_Model->delete_review_soft($page_id);
           // $contact_data = $this->Testimonial_Model->delete_review_hard($page_id); 
            redirect(base_url().index_page().'Testimonial_Management'); 
      }
      
    // To all delete business review 
      function approve_unapprove_reviews ()
      {
          $page_id = $this->uri->segment(3);     
          
        $this->Testimonial_Model->change_status($page_id);      
        redirect(base_url().index_page().'Testimonial_Management');  
      }
      
      //--------------- create business reviews -------------------------------//
      function create_reviews ()
      {

             $data = array();
             $current = date("Y-m-d  H:i:s", time());

             $data[1] = $this->input->post('review');
             $data[2] = $this->input->post('rating');  
             $data[3] = $current;
             $data[4] = $this->input->post('submitter');   
             $data[5] = $this->input->post('monial_id'); 

          // $new_date = date("l jS of F Y",strtotime($current));
           //$new_date2 = date("M j, Y ",strtotime($current)); 
          //  echo  $new_date.">>>>>>>>>>>>".$new_date2;
             //$data[3] = $this->input->post('send_now');
                                                                   
            
//            echo $data_tii= time(); 
//            $timestamp = strtotime($data_tii);
//             echo  $data_tii."<>>>>>>>>>>>>";
          
            $this->Business_Reviews_Model->save_review($data); 
              echo "Data saved Successfully ....."; 
            // redirect(base_url().index_page().'Testimonial_Management/view_testimonial/'.$data[5]);  
            

          
      }
      
      
      
      
      
      
      
      
      
  }
?>
