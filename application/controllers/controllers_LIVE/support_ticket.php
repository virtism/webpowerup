<?php
  class support_ticket extends CI_Controller{
      
      function __construct(){
          parent::__construct();
          
        $this->load->helper('url');
        $this->load->library('Template');
        $this->template->set_template('gws');
          
          
           $this->load->helper(array('form', 'url'));
      }
      
      function index(){
        if ($this->input->post('close_ticket'))  
           {
           $checkempty =  $_POST["chk"];
           if (empty($checkempty)){
               echo "<script>alert('You did not select any checkbox');</script>";
           }
             else {
               foreach($_POST["chk"] as $key => $val){ 
             // echo "<PRE>";
              //print_r($_REQUEST);    
                                                                                  
            $this->db->query("update support_tickets SET t_closed='1' where t_id = $val");
                    }
                }
            }
          // Delete tickets start 
           if ($this->input->post('delete_tickets'))  
           {
           $checkempty =  $_POST["chk"];
           if (empty($checkempty)){
               echo "<script>alert('You did not select any checkbox');</script>";
           }
             else {
               foreach($_POST["chk"] as $key => $val){ 
   
                                                                                  
            $this->db->query("update support_tickets SET t_deleted='1' where t_id = $val");
           }
             }
           }
           // Delete tickets end   
           // Delete tickets start 
           if ($this->input->post('delete_dept'))  
           {
               // $checkempty =  $_POST["chk"];
                foreach($_POST["chk"] as $key => $val){ 
                $this->db->query("update support_department SET d_deleted='1' where d_id = $val");
           }
             
           }
           // Delete tickets end
          $data['query']= $this->db->query("select support_tickets.t_id, support_tickets.t_no, support_tickets.t_subject, support_tickets.t_department, support_tickets.t_priority, support_tickets.t_open_date, users.user_fname, users.user_lname from support_tickets INNER JOIN users ON support_tickets.t_owner = users.user_id where support_tickets.t_closed='0' AND support_tickets.t_deleted='0' ORDER BY support_tickets.t_open_date DESC");
          $data['dept_query']=$this->db->query("select sd.d_id, sd.d_name, sd.d_visibility, sd.d_users, sd.d_owner, users.user_fname, users.user_lname from support_department sd INNER JOIN users ON sd.d_owner = users.user_id where sd.d_deleted = '0'");
          //$this->load->view('support_ticket_view',$data) ;
          $this->template->write_view('content','support_ticket_view',$data);
          $this->template->render();
          
          
           
      } // end of index function
      
      function new_ticket(){

          
          $data['query']=$this->db->get('support_department');
          //$this->load->view('new_ticket',$data);  
          $this->template->write_view('content','new_ticket',$data);
          $this->template->render();
          
      }
      
      function insert_ticket(){
          
           $this->load->library('form_validation');
           $this->form_validation->set_rules('t_subject', 'Support Ticket Subject', 'required|xss_clean()'); 
           $this->form_validation->set_rules('t_body', 'Description', 'required|xss_clean()'); 
           $this->form_validation->set_rules('t_department', 'Department', 'required');
          // $this->form_validation->set_rules('d_name', 'Department Name', 'required'); 
          
            if ($this->form_validation->run() == FALSE){
                
           // echo "<script>alert('form error');</script>";
             $data['query']=$this->db->get('support_department');
             //$this->load->view('new_ticket',$data);
             $this->template->write_view('content','new_ticket',$data);
             $this->template->render();
          }
         else {
        // echo "<PRE>" ;
        // print_r($_POST); exit;
         $this->db->query("INSERT INTO support_tickets(t_subject, t_department, t_priority, t_body, t_owner, t_open_date) VALUES ('".$_POST["t_subject"]."','".$_POST["t_department"]."','".$_POST["t_priority"]."','".$_POST["t_body"]."','".$_POST["t_owner"]."',now())");
          redirect('support_ticket');
         }
      }
      
      function new_department(){
          
          //$this->load->view('new_department');
          $this->template->write_view('content','new_department');
          $this->template->render();
      }
      
      function insert_department(){
          
           $this->load->library('form_validation');  
           $this->form_validation->set_rules('d_name', 'Department Name', 'required'); 

          if ($this->form_validation->run() == FALSE){
              // $this->load->view('new_department');
               $this->template->write_view('content','new_department');
               $this->template->render();
          }
          else{
          $this->db->query("INSERT INTO support_department(d_name, d_visibility, d_owner) VALUES ('".$_POST["d_name"]."','".$_POST["d_visibility"]."','".$_POST["d_owner"]."')");
          redirect('support_ticket','refresh');   
          }

        
          
      }
  }
?>
