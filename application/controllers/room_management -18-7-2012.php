<?php
if(!session_start()){
    session_start();
}
  class Room_Management extends CI_Controller{
  
      public $ck_data     =     array(); 
      var $site_id;  
      
      function __construct()
      {
          
          parent::__construct();
          
        $this->load->database();
        $this->load->helper('url');
		$this->load->helper('html'); 
        $this->load->library('form_validation');
        $this->load->library('Template');
		$this->load->library('my_template_menu');
		$this->load->library('session');
        $this->template->set_template('gws');
         // call load_asset_form
        
		$this->load->model("Groups_Model"); 
		$this->load->model('Registration_Forms_Model');  
        $this->load->model('Menus_Model');  
        $this->load->model('Pages_Model');  
        $this->load->model('PagesModel');
		$this->load->model('Room_Model');  
		$this->load->model('Footer_Model'); 
		if(isset($_SESSION["site_id"]) && is_numeric($_SESSION["site_id"]))
		{
			$this->site_id = $_SESSION['site_id'];
		}
		
             
      }
      
	  
		function index()
		{ 
			$link = substr(uri_string(),1);
			$room_link = base_url().$link;
			$this->session->set_userdata("room_link", $room_link); 
				
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
			$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
			$this->breadcrumb->add_crumb('Rooms Management' );
			
			$show_data = '';
			$show_data['view_all_records'] =  $this->Room_Model->show_all_rooms($this->site_id);
			$this->template->write_view('content','Room_Froms_View',$show_data);
			$this->template->render();
		
		}     
		function create_room()
		{
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
			$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
			$this->breadcrumb->add_crumb('Rooms Management', $this->session->userdata("room_link") ); 
			$this->breadcrumb->add_crumb('create');
			
			$data = '';
			//$data['groups'] = $this->Groups_Model->get_site_gropus_customer_by_site_id($this->site_id);
			/*echo "<pre>";
			print_r($_SESSION);
			exit;*/
			//$data['groups'] = $this->Groups_Model->dropdown_site_gropus_by_site_id($this->site_id);
			
			$data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
			/*echo "<pre>";
			print_r($data['groups']);
			exit;*/
		    //$data['users'] = $this->Groups_Model->dropdown_site_users($this->site_id);	
			$this->template->write_view('content','create_room',$data);
			$this->template->render();
			
		}
		
		function create_new_room()
		{
			$action = $this->input->post('save-start');
			$room_data['customers'] = '';
			$room_data['non_group'] = '';
			$email1[] = '';
			$email2[] = '';
			$room_data['site_id'] = $this->site_id;
			$room_data['name'] = $this->input->post('name');
			$room_data['presenter_id'] = $_SESSION['user_info']['user_id'];
			$room_data['presenter_mail'] = $_SESSION['user_info']['user_email'];
            $room_data['topic'] = $this->input->post('topic');
            $room_data['password'] = $this->input->post('password');
			$room_data['approval'] = $this->input->post('approval');
			$room_data['attendee_options'] = $this->input->post('attendee_options');
			$room_data['join_password'] = $this->input->post('join_password');
			$customers =$this->input->post('members');
			$room_data['non_group'] = $this->input->post('non_group');
			$room_data['reg_date_start'] = $this->input->post('reg_date_start');
			$room_data['reminder'] = $this->input->post('reminder');
			$room_data['zone'] = $this->input->post('zone');
			$room_data['message'] = $this->input->post('message');	
			$room_data['room_rid'] = rand(10000000,99999999);
			
			
			
			//$message  =  "Meeting Name: ".$room_data['name']."\n\nTopic Name: ".$room_data['topic']."\n\nStart Date: ".$room_data['reg_date_start']."\n\nMessage: ".$room_data['message']."\n\nJoin Meeting";
			
			$message = "<table width='600' border='0'><tr><td>Meeting Name: </td><td>".$room_data['name']."</td></tr><tr><td>Topic Name:</td><td>".$room_data['topic']."</td></tr><tr><td>Start Date:</td><td>".$room_data['reg_date_start']."</td></tr><tr><td>Message</td><td>".$room_data['message']."</td></tr></table>";
			if(isset($customers)&&!empty($customers))
			{
					$room_data['customers'] = implode(",", $customers);
					if(isset($room_data['customers']) && !empty($room_data['customers']))
					{
						$room_data['customers'] .= ",".$room_data['presenter_id'];
					}
					else
					{
						$room_data['customers'] = $room_data['presenter_id'];
					}
			}
			/*echo "<pre>";
			print_r($room_data);
			exit();*/
			$save = $this->Room_Model->create_room($room_data);	
			if(isset($action) && !empty($action))
			{
				//Get All Email Ids Of Customers If Selected
				$email1 = $this->Room_Model->get_all_site_gropus_user_email($room_data['customers']);							
				$email2 = explode(",", $room_data['non_group']);
				$emails = array_merge($email1,$email2);
				$this->send_mail($email1, $email2, $room_data['topic'],$room_data['room_rid'], $message, $save);
				$this->send_mail_presenter($room_data['presenter_id'], $room_data['presenter_mail'],$room_data['room_rid'],  $room_data['topic'], $message, $save);
			}
			
			redirect(base_url().index_page().'room_management/index/'); 
			
		}
		
		function send_invitation($room_id)
		{
			
			$email1 = array();
			$email2 = array();
			$room_data = $this->Room_Model->edit_room($room_id);
			//$message  =  "Meeting Name: ".$room_data[0]->name."\n\nTopic Name: ".$room_data[0]->topic."\n\nStart Date: ".$room_data[0]->reg_date_start."\n\nMessage: ".$room_data[0]->message."\n\n<a href='www.google.com'>Join Meeting</a>";			
			
			$message = "<table width='600' border='0'>
						<tr>
						<td>Meeting Name: </td><td>".$room_data[0]->name."</td>
						</tr>
						<tr>
						<td>Topic Name:</td><td>".$room_data[0]->topic."</td>
						</tr>
						<tr>
						<td>Start Date:</td><td>".$room_data[0]->reg_date_start."</td>
						</tr>
						<tr>
						<td>Your Password:</td><td>".$room_data[0]->password."</td>
						</tr>
						<tr>
						<td>Message</td><td>".$room_data[0]->message."</td>
						</tr>
						</table>";
			
			if(isset($room_data[0]->customers)&&!empty($room_data[0]->customers))
			{
					//$room_data['customers'] = implode(",", $room_data[0]->customers);					
					$email1 = $this->Room_Model->get_all_site_gropus_user_email($room_data[0]->customers);							
			}
			/*echo "<pre>";
			print_r($email1);
			exit;*/
			//Get All Email Ids Of Customers If Selected
			
			$email2 = explode(",", $room_data[0]->non_group);
			$emails = array_merge($email1,$email2);
			
			//print_r($emails);
			//exit;
			$this->send_mail($email1, $email2, $room_data[0]->topic, $room_data[0]->room_rid, $message, $room_id);
			$this->send_mail_presenter($_SESSION['user_info']['user_id'], $_SESSION['user_info']['user_email'], $room_data[0]->room_rid,$room_data[0]->topic, $message, $room_id);
			redirect(base_url().index_page().'room_management/index/');
		}
		
		function send_mail($customers, $noncustomers, $sub, $room_rid, $mess, $room_id)
		{
				$subject = $sub;
				$body = $mess;
				$this->load->library('email');
				$config['mailtype'] = 'html';
				$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				
				
				foreach($customers as $id => $mail)
				{
					
					//$id_messg = '';
					$body = $mess."<br/><a href='http://webpowerup.com/broadcast/GWSWhiteboard.html#roomID=".$room_rid."&attendee_id=".($id*2)."'>Join Meeting</a>";
					
					//$body .= $id_messg;
					$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');
					$this->email->subject($subject);
					$this->email->message($body);	
					$this->email->to($mail); 
					$send = $this->email->send();
					$body = '';			
			
				}	
					
				foreach($noncustomers as  $mail)
				{
					
					
					$private_user_id = rand(100000,999999);
					
					$private_data['room_rid'] = $room_rid;
            		$private_data['private_att_id'] = $private_user_id;
					if(isset($private_data)){
						$save = $this->Room_Model->save_private_attendie($private_data);
					}
					$body = $mess."<br/><a href='http://webpowerup.com/broadcast/GWSWhiteboard.html#roomID=".$room_rid."&attendee_id=".$private_user_id."'>Join Meeting</a>";
					$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');
					$this->email->subject($subject);
					$this->email->message($body);	
					$this->email->to($mail); 
					$send = $this->email->send();			
					$body = '';			
				}
		}
		
		function send_mail_presenter($presenter_id, $presenter_mail, $room_rid, $sub, $mess, $room_id)
		{
				$subject = $sub;
				
				$body = $mess;
				//echo $presenter_mail;
				$this->load->library('email');
				$config['mailtype'] = 'html';
				$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);	
			 	$body = $mess."<b>Presenter Meeting Email</b><br/><a href='http://webpowerup.com/broadcast/GWSWhiteboard.html#roomID=".$room_rid."&attendee_id=".($presenter_id*2)."'>Join Meeting</a>";
				$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');
				
				$this->email->subject($subject);
				$this->email->message($body);	
				$this->email->to($presenter_mail); 
				$send = $this->email->send();
		}
		
		
	  function delete_room($room_id)
	  {
	  	$delete = $this->Room_Model->delete_room($room_id);
		redirect(base_url().index_page().'room_management/index/'); 
	  }
	  
	  function edit_room($room_id)
	  {
	  		$edit['user_gruop_options'] = $this->Room_Model->edit_room($room_id);
			/*echo "<pre>";
			print_r($edit);
			exit();*/
			//$edit['groups'] = $this->Groups_Model->get_site_gropus_customer_by_site_id($this->site_id);
			$edit['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
			
			if(isset($edit) && !empty($edit))
			{
				$this->template->write_view('content','edit_room',$edit);
				$this->template->render();
			}
			else
			{
				redirect(base_url().index_page().'room_management/index/'); 			
			}		
	  }
	  
	  function save_edit_room($room_id)
	  {
	  		//$room_data['room_id'] = $room_id;
			$action = $this->input->post('save-start');
			$room_data['customers'] = '';
			$email1[] = '';
			$email2[] = '';
			$room_data['name'] = $this->input->post('name');
            $room_data['topic'] = $this->input->post('topic');
            $room_data['password'] = $this->input->post('password');
			$room_data['approval'] = $this->input->post('approval');
			$room_data['attendee_options'] = $this->input->post('attendee_options');
			$room_data['join_password'] = $this->input->post('join_password');
			$customers =$this->input->post('customers');
			$room_data['non_group'] = $this->input->post('non_group');
			$room_data['reg_date_start'] = $this->input->post('reg_date_start');
			$room_data['reminder'] = $this->input->post('reminder');
			$room_data['zone'] = $this->input->post('zone');
			$room_data['message'] = $this->input->post('message');
			
			//$message  =  "Meeting Name: ".$room_data['name']."\n\nTopic Name: ".$room_data['topic']."\n\nStart Date: ".$room_data['reg_date_start']."\n\nMessage: ".$room_data['message']."\n\nJoin Meeting";
			
			$message = "<table width='600' border='0'><tr><td>Meeting Name: </td><td>".$room_data['name']."</td></tr><tr><td>Topic Name:</td><td>".$room_data['topic']."</td></tr><tr><td>Start Date:</td><td>".$room_data['reg_date_start']."</td></tr><tr><td>Message</td><td>".$room_data['message']."</td></tr></table>";
			if(isset($customers)&&!empty($customers))
			{
					$room_data['customers'] = implode(",", $customers);					
			}
			$save = $this->Room_Model->save_edit_room($room_data, $room_id);
			if(isset($action) && !empty($action))
			{
				//Get All Email Ids Of Customers If Selected
				$email1 = $this->Room_Model->get_all_site_gropus_user_email($room_data['customers']);							
				$email2 = explode(",", $room_data['non_group']);
				$emails = array_merge($email1,$email2);
				$this->send_mail($email1, $email2, $room_data['topic'], $message, $room_id);
				$this->send_mail_presenter($_SESSION['user_info']['user_id'], $_SESSION['user_info']['user_email'], $room_data['room_rid'], $room_data['topic'], $message, $room_id);
			}
			
			redirect(base_url().index_page().'room_management/index/'); 
	  
	  }
	  
      function index_old()
      {
    
       
       // $this->load->view('Create_Registration_Form_View', $this->ck_data);
       /*$data = array ();
       $data[''] = '';
       $data['menus'] = $this->Menus_Model->getAllMenus($this->site_id);
       $data['page'] = $this->PagesModel->get_pages_dropdown($this->site_id); 
	   $data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);*/
	   /*echo "<pre>";
	   print_r($data['groups']);
	   exit;*/
   //    $data['page'] = $this->PagesModel->get_pages_dropdown($this->site_id); 
       //$data['role'] = $this->Menus_Model->getRolesDropdown(); 
       //$data['ck_data'] = $this->ck_data;
      
       $this->template->write_view('content','Create_Room_Form_View');
       $this->template->render();
 
      }
	  
	  function user_rooms()
	  {
		// $this->is_login();
		//echo "<pre>";
		//print_r($_SESSION);exit;
		
		 if ($this->input->post('action') && $this->input->post('action') == 'addCustomer'){
				
			   $this->customer_id = $_SESSION['login_info']['customer_id'];
				if($this->customers_model->address_book_ad($this->site_id, $this->customer_id))
				{
					
					redirect(base_url().index_page().'MyAccount/login','refresh');
				}
				 
		}else{
			// print_r($_SESSION);  exit();
			$data = array ();
			$temp_name =  $this->my_template_menu->set_get_template($this->site_id);
		$rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
		$rowHomepage = $rsltHomepage->row_array();
		$data["mode"] = '';
		$data["site_id"] = $rowHomepage["site_id"];
		$data["page_id"] = $rowHomepage["page_id"];
		$page_status = $rowHomepage["page_status"];
		$page_id = $rowHomepage["page_id"];       
		$data["site_name"] = $rowHomepage["site_name"];
		$page_title = $rowHomepage["page_title"];
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		$_SESSION['site_id'] = $data["site_id"];
			
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
			 $site_user_id = 0 ;
         
			 if(isset($_SESSION['user_info']['user_id']))
			 {
				$site_user_id = $_SESSION['user_info']['user_id'];
			 }
			 $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id);   
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			$this->template->write_view('logo', $temp_name.'/logo', $data);
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop, Ecommerce'); 
			$data["site_name"] = '';  

		   $menu_data['menu'] =  $top_site_menu_basic;
		   if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$menu_data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$menu_data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}      
		   $this->template->write_view('menu', $temp_name.'/menu', $menu_data); 
			
			$data['title'] = "Invoices";
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['view_all_room_records'] =  $this->Room_Model->get_user_rooms($this->site_id, $_SESSION['login_info']['customer_id']);    		   
			$this->template->write_view('content','room_listing',$data);
			
			
		   //echo '<pre>'; print_r($all_categories); exit();
			$Regions = $this->template->regions;
		
			if(isset($Regions['sidebar']))
			{
			  $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
			  $this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
			   
			}
			if(isset($Regions['leftbar']))
			{  
				$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
				$data['left_menus_type'] = 'site'; 
				$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
				
			
			}
			if(isset($Regions['leftbar']))
			{
				$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
				$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     	
			} 
				
				$this->template->render();      
			}
	}
}
?>