<?php
session_start();
  class support_ticket extends CI_Controller{

      

      function __construct(){

          parent::__construct();

        $this->load->helper('url');
		$this->load->library('Template');
		$this->load->library('session');
		$this->load->model('support_ticket_model');
        $this->template->set_template('gws');
		$this->load->helper(array('form', 'url'));

      }

        function checkLogin()
		{
			//checks if session user_info is set
			if(!$_SESSION['user_info']['user_id'] && $_SESSION['user_info']['user_id'] == NULL)
			{
				//go to login controller
				redirect("UsersController/login/sitelogin");
			}
			else
			{
				//ok, let go
				return;
			}
		}
		
		
      function index(){
			
			$link = substr(uri_string(),1);
			$ticket_link = base_url().$link;
			$this->session->set_userdata("ticket_link", $ticket_link); 
			
			$this->breadcrumb->clear();
       		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
			$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
			$this->breadcrumb->add_crumb('Manage Tickets' );
			
			$this->checkLogin();
			
			if(isset ($_SESSION['current_site_info']['site_id']) )	
			{  
				$site_id = $_SESSION['current_site_info']['site_id'];
			}
			else
			{
				redirect("SiteController/sitebuilder/");
			}
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
               else
               {
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
         
          
            if ($this->input->post('make_public'))  
            {
            
                foreach($_POST["chk"] as $key => $val){ 
                    $this->db->query("update support_department SET d_visibility='Public' where d_id = $val");
                }

            }
			
          
		  
		  
			if ($this->input->post('group_dept'))  // if assign department is clicked 
            {
            	
                foreach($_POST["chk"] as $key => $val){ 
                    $deptId = $val;
                }
				
				$data['d_id'] = $deptId;
				/*
				$this->session->set_userdata("deptId",$deptId);
				echo $this->session->userdata('deptId');
				*/
				
				
				$this->load->model('support_ticket_model');
				$data['dep'] = $this->support_ticket_model->get_department_by_id($deptId);
				
				
				$currSiteId = $_SESSION['site_id'];
        		
				$q = "SELECT gp.id,gp.group_name FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$currSiteId."' ";
                $data['q'] = $this->db->query($q);
		   
		  		
				$this->template->write_view('content','assign_department',$data);
				$this->template->render();
				

            }
			
			
			else		  // if assign department is not clicked clicked 
			{	
				
				 /*	back end ticket query 	*/
				 $data['query']= $this->db->query("
				 SELECT support_tickets.t_site_id,
				 support_tickets.t_id, 
				 support_tickets.t_no,
				 support_tickets.t_subject,
				 support_tickets.t_department_id, 
				 support_tickets.t_priority, 
				 support_tickets.t_open_date, 
				 support_tickets.t_department_id,
				 support_department.d_id,
				 support_department.d_name
				 
				 FROM support_tickets 
				  
				 INNER JOIN support_department 
				 ON support_tickets.t_department_id = support_department.d_id 
				 
				 WHERE support_tickets.t_closed='0' AND support_tickets.t_deleted='0' AND t_site_id = '$site_id' ORDER BY support_tickets.t_open_date DESC");
				
			  /*	back end department query 	*/
              $data['dept_query']=$this->db->query("
			  select sd.d_id,
			  sd.d_name, 
			  sd.d_visibility, 
			  sd.d_users, 
			  sd.d_owner, 
			  users.user_fname, 
			  users.user_lname 
			  FROM support_department sd 
			  INNER JOIN users 
			  ON sd.d_owner = users.user_id 
			  WHERE d_site_id = '$site_id' AND sd.d_deleted = '0'");
          //$this->load->view('support_ticket_view',$data) ;                   
			  $this->template->write_view('content','support_ticket_view',$data);
			  $this->template->render();
			  
			}
          
          
           
      } // end of index function
      
	  function assign_department()
	  {
	  	 
		  $r = $this->support_ticket_model->update_department();
		  if($r == 1)
		  {
		   
				 $site_id = $_SESSION['current_site_info']['site_id'];
				  	
		  	     /*	back end ticket query 	*/
				 $data['query']= $this->db->query("
				 SELECT support_tickets.t_site_id,
				 support_tickets.t_id, 
				 support_tickets.t_no,
				 support_tickets.t_subject,
				 support_tickets.t_department_id, 
				 support_tickets.t_priority, 
				 support_tickets.t_open_date, 
				 support_tickets.t_department_id,
				 support_department.d_id,
				 support_department.d_name
				 
				 FROM support_tickets 
				  
				 INNER JOIN support_department 
				 ON support_tickets.t_department_id = support_department.d_id 
				 
				 WHERE support_tickets.t_closed='0' AND support_tickets.t_deleted='0' AND t_site_id = '$site_id' ORDER BY support_tickets.t_open_date DESC");
          
		  		/*	back end department query 	*/
		      $data['dept_query']=$this->db->query("
			  select sd.d_id,
			  sd.d_name, 
			  sd.d_visibility, 
			  sd.d_users, 
			  sd.d_owner, 
			  users.user_fname, 
			  users.user_lname 
			  FROM support_department sd 
			  INNER JOIN users 
			  ON sd.d_owner = users.user_id 
			  WHERE d_site_id = '$site_id' AND sd.d_deleted = '0'");
          //$this->load->view('support_ticket_view',$data) ;                   
			  $this->template->write_view('content','support_ticket_view',$data);
			  $this->template->render();
		  }
	  }
	  
      function new_ticket(){
		  
		  $this->breadcrumb->clear();
       	  $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		  $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		  $this->breadcrumb->add_crumb('Manage Tickets', $this->session->userdata("ticket_link") ); 
		  $this->breadcrumb->add_crumb('Create');
		  
		  $site_id = $_SESSION['current_site_info']['site_id'];	
		  $this->db->where('d_deleted','0');
		  $this->db->where('d_site_id',$site_id);
		  $data['query']=$this->db->get('support_department');
		  $this->template->write_view('content','new_ticket',$data);
          $this->template->render();
          
      }
      
      function insert_ticket(){
          
           $this->load->library('form_validation');
		   
		   $this->form_validation->set_rules('t_email', 'Email', 'required|valid_email');
           $this->form_validation->set_rules('t_subject', 'Support Ticket Subject', 'required|xss_clean()'); 
           $this->form_validation->set_rules('t_body', 'Description', 'required|xss_clean()'); 
           $this->form_validation->set_rules('t_department_id', 'Department', 'required');
          // $this->form_validation->set_rules('d_name', 'Department Name', 'required'); 
          
            if ($this->form_validation->run() == FALSE){
                
          
             $data['query']=$this->db->get_where('support_department', array('d_deleted' => '0') );
             //$this->load->view('new_ticket',$data);
             $this->template->write_view('content','new_ticket',$data);
             $this->template->render();
          }
         else{
             /*
			 $t_no = rand(0,1000);  // random ticket number
             $this->db->query("INSERT INTO support_tickets (t_no,t_subject, t_department_id, t_priority, t_body, t_owner, t_open_date) VALUES ('$t_no','".$_POST["t_subject"]."','".$_POST["t_department_id"]."','".$_POST["t_priority"]."','".$_POST["t_body"]."','".$_POST["t_owner"]."',now())");
			 */
			  $this->support_ticket_model->add_ticket();
			 
			  /*----------------------------------*/
			  /* send email to group members */
			  /*----------------------------------*/
			  /*
			  $dptName = $this->input->post('t_department');
              $q = $this->db->get_where("support_department", array('d_name' => $dptName) );
              if($q->num_rows() > 0)
              {
                  $row = $q->result_array();
                  $groupId = $row[0]['d_group_id'];           
              }
			  $q2 = $this->->support_ticket_model->get_all_group_members($groupId);
              foreach($q2->result() as $row )
              {
                  $email = $row->customer_email;
                  $this->emailToDepartmentGroupMember($email);
              }
			  */
			  /*----------------------------------*/
			  /* send email to group members */
			  /*----------------------------------*/
			 
              redirect('support_ticket');
         }
      }
      
      function new_department(){
	  
	  	  $this->breadcrumb->clear();
       	  $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		  $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		  $this->breadcrumb->add_crumb('Manage Tickets', $this->session->userdata("ticket_link") ); 
		  $this->breadcrumb->add_crumb('Create');
          
          //$this->load->view('new_department');
          
          $currSiteId = $_SESSION['current_site_info']['site_id'];
          $q = "SELECT gp.id,gp.group_name FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$currSiteId."' ";
          $data['q'] = $this->db->query($q);

          $this->template->write_view('content','new_department',$data);
          $this->template->render();
		  
      }
      
      function insert_department(){
          
          $this->load->library('form_validation');  
          $this->form_validation->set_rules('d_name', 'Department Name', 'required'); 

          if ($this->form_validation->run() == FALSE)
		  {
              // $this->load->view('new_department');
               $this->template->write_view('content','new_department');
               $this->template->render();
          }
          else
		  {
		  	$this->support_ticket_model->add_department();
		  	redirect('support_ticket','refresh');  
		  }

        
          
      }
      
	  

  }

?>