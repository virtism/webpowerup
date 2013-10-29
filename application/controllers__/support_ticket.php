<?php
 if(!session_start()){	session_start(); }
  class support_ticket extends CI_Controller{

      

      function __construct(){

        parent::__construct();
		$this->load->helper("date_helper");
        $this->load->helper('url');
		$this->load->library('Template');
		$this->load->library('session');
		$this->load->model('support_ticket_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
		          //    echo '<pre>';print_r("sdfsf");echo '</pre>';exit;

		if(isset($_SESSION["site_id"]) && is_numeric($_SESSION["site_id"]))
		{
			$this->site_id = $_SESSION['site_id'];
		}
		else
		{
			//$this->site_id = $_SESSION['site_id_custom'];
			$this->site_id = '';
			$this->site_id = $this->uri->segment(3);
			$_SESSION['site_id'] = $this->uri->segment(3);
		}
          
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
		
		
      function index()
	  {
			
			$this->checkLogin();
			//echo $this->site_id.'-------------------'.$_SESSION['site_id'];exit;
			if(isset ($_SESSION['site_id']) )	
			{  
				$site_id = $_SESSION['site_id'];
			}
			else
			{
				redirect("SiteController/sitebuilder/");
			}
			
         	if ($this->input->post('close_ticket'))  
            {
				
			   
				   $checkempty =  $_POST["chk"];
				   if (empty($checkempty))
				   {
					   echo "<script>alert('You did not select any checkbox');</script>";
				   }
				   else 
				   {
					   foreach($_POST["chk"] as $key => $val)
					   { 
						// echo "<PRE>";
						//print_r($_REQUEST);    
																						  
						$this->db->query("update support_tickets SET t_closed='1' where t_id = $val");
					
						}
					}
					redirect('support_ticket');
            
			}
           
          
			
			else		  // if assign department is not clicked clicked 
			{	
				
				 /*	back end ticket query 	*/
				 $data['query']= $this->support_ticket_model->get_backend_ticket($site_id);
				
				  /*	back end department query 	*/
				  $data['dept_query']= $this->support_ticket_model->get_backend_department($site_id);
          //$this->load->view('support_ticket_view',$data) ;                   
			  $this->template->write_view('content','ticket/support_ticket_view',$data);
			  $this->template->render();
			  
			}
          
          
           
      } // end of index function
      
	  function delete_ticket($id)
	  {
		  $this->support_ticket_model->delete_ticket($id);
		  redirect('support_ticket');
	  }
	  
	  function delete_department($id)
	  {
		  $this->support_ticket_model->delete_department($id);
		  redirect('support_ticket');
	  }
	  
	  function assign_department_form()
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
	   
			
			$this->template->write_view('content','ticket/assign_department',$data);
			$this->template->render();
	  }
	  
	  function assign_department()
	  {
	  	  $this->breadcrumb->clear();
       	  $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		  $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		  $this->breadcrumb->add_crumb('Manage Tickets', $this->session->userdata("ticket_link") ); 
		  
		  
		  $r = $this->support_ticket_model->update_department();
		  if($r == 1)
		  {
		   
				$site_id = $_SESSION['current_site_info']['site_id'];
				  	
		  	    /*	back end ticket query 	*/
				$data['query']= $this->support_ticket_model->get_backend_ticket($site_id);
				
				/*	back end department query 	*/
				$data['dept_query']= $this->support_ticket_model->get_backend_department($site_id);
		        
				redirect('support_ticket');
          		
		  }
		  redirect('support_ticket/assign_department_form');
	  }
	  
      function new_ticket(){
		  
		  $this->breadcrumb->clear();
       	  $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		  $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		  $this->breadcrumb->add_crumb('Manage Tickets', $this->session->userdata("ticket_link") ); 
		  $this->breadcrumb->add_crumb('Create');
		  
		  $site_id = $_SESSION['current_site_info']['site_id'];	
		  $data['query']=$this->support_ticket_model->get_all_department_by_site($site_id);
		  $this->template->write_view('content','ticket/new_ticket',$data);
          $this->template->render();
          
      }
      
      function insert_ticket()
	  {
           
           $this->load->library('form_validation');
		   
		   $this->form_validation->set_rules('t_email', 'Email', 'required|valid_email');
           $this->form_validation->set_rules('t_subject', 'Support Ticket Subject', 'required|xss_clean()'); 
           $this->form_validation->set_rules('t_detail', 'Description', 'required|xss_clean()'); 
           $this->form_validation->set_rules('t_department_id', 'Department', 'required');
          // $this->form_validation->set_rules('d_name', 'Department Name', 'required'); 
          
            if ($this->form_validation->run() == FALSE){
             
			 $site_id = $_SESSION['current_site_info']['site_id'];	
             $data['query']=$this->support_ticket_model->get_all_department_by_site($site_id);
             $this->template->write_view('content','ticket/new_ticket',$data);
             $this->template->render();
			 
          }
         else{
              
			  $this->support_ticket_model->add_ticket();
              redirect('support_ticket');
         }
      }
      
      function new_department()
      {

	  	         

          $this->breadcrumb->clear();
       	  $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		  $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		  $this->breadcrumb->add_crumb('Manage Tickets', $this->session->userdata("ticket_link") ); 
		  $this->breadcrumb->add_crumb('Create');
          
          //$this->load->view('new_department');
          
          $currSiteId = $_SESSION['current_site_info']['site_id'];
          $q = "SELECT gp.id,gp.group_name FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$currSiteId."' ";
          $data['q'] = $this->db->query($q);
          $this->template->write_view('content','ticket/new_department',$data);
          $this->template->render();
		  
      }
      
      function insert_department()
	  {
          
          $this->load->library('form_validation');  
          $this->form_validation->set_rules('d_name', 'Department Name', 'required'); 

          if ($this->form_validation->run() == FALSE)
		  {
               $currSiteId = $_SESSION['current_site_info']['site_id'];
 			   $q = "SELECT gp.id,gp.group_name FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$currSiteId."' ";
			   $data['q'] = $this->db->query($q);
			   
               $this->template->write_view('content','ticket/new_department',$data);
               $this->template->render();
          }
          else
		  {
		  	$this->support_ticket_model->add_department();
		  	redirect('support_ticket','refresh');  
		  }
          
      }
	  
	  function ticket_detail($ticket_id)
	  {
		  
		  $data['ticket'] = $this->support_ticket_model->get_ticket_detail($ticket_id);
		  
		  $data['comments'] = $this->support_ticket_model->get_all_comment($ticket_id);
		  
		  $this->template->write_view('content','ticket/ticket_detail',$data);
		  $this->template->render();
		  
	  }
	  
	  function reopen_ticket($ticket_id)
	  {
		  $r = $this->support_ticket_model->reopen_ticket($ticket_id);
		  
		  redirect("support_ticket/ticket_detail/".$ticket_id);
		 
	  }
	  
	  function post_comment($ticket_id)
	  {
		  
		  $description = $this->input->post("description");
		  $related_id = $_SESSION['user_info']['user_id'];
		  $type = "admin";
		  $r = $this->support_ticket_model->add_comment($ticket_id,$related_id,$type,$description);
		  
		  redirect("support_ticket/ticket_detail/".$ticket_id);
		  
	  }
	  
      function remove_comment($ticket_id)
	  {
		  $r = $this->support_ticket_model->delete_comment($ticket_id); 
	  }
	  

  }

?>