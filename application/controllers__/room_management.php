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
		$this->load->helper('custom_helper'); 
        $this->load->library('form_validation');
        $this->load->library('Template');
		$this->load->library('my_template_menu');
		$this->load->library('session');
		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();        
         // call load_asset_form
        
		$this->load->model("Groups_Model"); 
		$this->load->model('Registration_Forms_Model');  
        $this->load->model('Menus_Model');  
        $this->load->model('Pages_Model');  
        $this->load->model('PagesModel');
		$this->load->model('Room_Model');
		$this->load->model('Webinar_Model');
		$this->load->model('Footer_Model'); 
		if(isset($_SESSION["site_id"]) && is_numeric($_SESSION["site_id"]))
		{
			$this->site_id = $_SESSION['site_id'];
		}
		else
		{
			//$this->site_id = $_SESSION['site_id_custom'];
			$this->site_id = '';
			$this->site_id = $this->uri->segment(3);
		}
		
             
      }
      
	  
		function index()
		{ 
			is_login();
			$room_link = current_url();
			$this->session->set_userdata("room_link", $room_link); 
				
			$this->breadcrumb->clear();
			$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
			$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
			$this->breadcrumb->add_crumb('Rooms Management' );
			
			$show_data = '';
			$show_data['rooms'] = $this->Room_Model->get_all_rooms($this->site_id);
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
			print_r($data['groups']);
			exit;*/
			//$data['groups'] = $this->Groups_Model->dropdown_site_gropus_by_site_id($this->site_id);
			$data['groups_users'] = $this->Room_Model->get_site_gropus_customer_by_site_id($this->site_id);	
			$data['regestered_users'] = $this->Room_Model->get_site_registered_user_by_site_id($this->site_id);	
			//$data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
			$data['times_zones'] = $this->Webinar_Model->getAllTimeZone();
		    //$data['users'] = $this->Groups_Model->dropdown_site_users($this->site_id);	
			$this->template->write_view('content','create_room',$data);
			$this->template->render();
			
		}
		
		function create_new_room()
		{
			
			//echo "<pre>";print_r($_POST);
			include_once(realpath("./").'/tokbox/flex_session_for_server.php');
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
			//$customers =$this->input->post('customers');
			$room_data['non_group'] = $this->input->post('non_group');
			
			$room_data['reg_date_start'] = $this->input->post('reg_date_start');
			$room_data['reminder'] = $this->input->post('reminder');
			//$room_data['zone'] = $this->input->post('zone');
			$room_data['message'] = $this->input->post('message');	
			$room_data['r_creation_time'] = date("Y-m-d h:i:s A");
			$room_data['room_rid'] = mt_rand();
			$room_data['check_status'] = '1';
			$room_data['room_session_id'] =  $this->db->escape_str($session_f_php);
			if(isset($room_data['reg_date_start']))
			{
				$newDate = date("Y-m-d", strtotime($room_data['reg_date_start']));
				$room_data['reg_date_start'] = $newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts').' '.$this->input->post('ampm');
				
				$timezone = new DateTimeZone($_REQUEST["hidden_time_zone"]);
				$offset = $timezone->getOffset(new DateTime("now")); 
				$offset_value =  ($offset < 0 ? '' : '+').round($offset/3600);
				$room_data['server_start_time']= date('Y-m-d h:i A',strtotime($newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts'))-($offset_value*3600));
				
			}
			
			if(isset($_REQUEST["show_us_intl"]) && $_REQUEST["show_us_intl"]=='intl')
			{
				$room_data['time_zone_offset'] = $_REQUEST['time_zone_intl'];
			}
			else if(isset($_REQUEST["show_us_intl"]) && $_REQUEST["show_us_intl"]=='us')
			{
				$room_data['time_zone_offset'] = $_REQUEST['time_zone_us'];
			}
			else
			{
				$room_data['time_zone_offset'] = '';
			}
			
			$password = '';
			if(isset($room_data['password']))
			{
				$password =  "<tr><td>Your Password:</td><td>".$room_data['password']."</td></tr>";
			}
			$message = "<table width='600' border='0'><tr><td>Meeting Name: </td><td>".$room_data['name']."</td></tr><tr><td>Topic Name:</td><td>".$room_data['topic']."</td></tr>".$password."<tr><td>Start Date:</td><td>".$room_data['reg_date_start']."</td></tr><tr><td>Message</td><td>".$room_data['message']."</td></tr></table>";
			if(isset($room_data['non_group'])&&!empty($room_data['non_group'] ))
			{
					
					$room_new_attendies = explode(",", $room_data['non_group'] );
					$private_attendies = $this->Room_Model->save_private_attendies($room_new_attendies, $this->site_id, $room_data['room_rid']);					
			}
			//echo "<pre>";print_r($room_data);exit;
			
			$this->Room_Model->save_existing_users($room_data['room_rid']);
			
			//echo "<pre>";print_r($room_data);exit;
			$save = $this->Room_Model->create_room($room_data);	
			if(isset($action) && !empty($action))
			{
				//Get All Email Ids Of Customers If Selected
				$email_ids = $this->Room_Model->get_all_site_gropus_user_email($room_data['room_rid']);						
				//$email2 = explode(",", $room_data['non_group']);
				//$emails = array_merge($email1,$email2);
				//echo "<pre>";print_r($email_ids);exit;
				$this->send_mail($email_ids, $room_data['topic'],$room_data['room_rid'], $message, $save);
				$this->send_mail_presenter($room_data['presenter_id'], $room_data['presenter_mail'],$room_data['room_rid'],  $room_data['topic'], $message, $save);
			}
			
			redirect(base_url().index_page().'room_management/index/'); 
			
		}
		
		function send_invitation($room_id)
		{
			
			$emails = array();
			$room_data = $this->Room_Model->edit_room($room_id);			
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
			
			/*if(isset($room_data[0]->customers)&&!empty($room_data[0]->customers))
			{
					//$room_data['customers'] = implode(",", $room_data[0]->customers);					
					$email1 = $this->Room_Model->get_all_site_gropus_user_email($room_data[0]->customers);							
			}*/
			
			//Get All Email Ids Of Customers If Selected
			$emails = $this->Room_Model->get_all_meeting_user($room_data[0]->room_rid);			
			//$email2 =$this->Room_Model->get_all_invited_attendee($room_data[0]->room_rid);
			//$emails = array_merge($email1,$email2);
			/*echo "<pre>"; echo $room_data[0]->room_rid;
			print_r($emails);
			exit;*/
			//$this->send_mail_to_all_attendee($email1, $email2, $room_data[0]->topic, $room_data[0]->room_rid, $message, $room_id);
			$this->send_mail($emails, $room_data[0]->topic, $room_data[0]->room_rid, $message, $room_id);
			$this->send_mail_presenter($_SESSION['user_info']['user_id'], $_SESSION['user_info']['user_email'], $room_data[0]->room_rid,$room_data[0]->topic, $message, $room_id);
			redirect(base_url().index_page().'room_management/index/');
		}
		
		function send_mail($customers, $sub, $room_rid, $mess, $room_id)
		{
				//print_r($noncustomers);exit;
				$subject = $sub;
				$body = $mess;
				$this->load->library('email');
				$config['mailtype'] = 'html';
				$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				//echo "<pre>";print_r($customers);
		
				foreach($customers as $id => $mail)
				{
		
					//print_r($mail);exit;
					$body = $mess."<br/><a href=http://webpowerup.com/broadcast/GWSWhiteboard.html#roomID=".$room_rid."&attendee_id=".($mail['customer_id']*2)."&guest_id=1".">Join Meeting</a>";				
					//$body .= $id_messg;
					$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');
					$this->email->subject($subject);
					$this->email->message($body);	
					$this->email->to($mail['customer_email']); 
					$send = $this->email->send();
					//echo $mail['customer_email'];
					$body = '';	
				}
				//exit;
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
			
		
			$edit['groups'] = $this->Groups_Model->get_site_gropus_customer_by_site_id($this->site_id);
			$edit['groups_users'] = $this->Room_Model->get_site_gropus_customer_by_site_id($this->site_id);	
			$edit['selected_users'] = $this->Room_Model->get_all_meeting_user($room_id);
			$edit['times_zones'] = $this->Webinar_Model->getAllTimeZone();
			//$edit['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
			/*echo "<pre>";
			print_r($edit);
			exit();*/
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
	  		//echo  $this->input->post('hidden_room_rid');
			//echo "<pre>";
			//print_r($_REQUEST);exit;
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
			//$customers =$this->input->post('customers');
			$non_group['non_group'] = $this->input->post('non_group');
			$room_data['reg_date_start'] = $this->input->post('reg_date_start');
			$room_data['reminder'] = $this->input->post('reminder');
			//$room_data['zone'] = $this->input->post('zone');
			$room_data['message'] = $this->input->post('message');
		 	$room_data['r_creation_time'] = date("Y-m-d h:i:s");
			//$room_data['room_rid'] = mt_rand();
			$room_data['check_status'] = '1';
			if(isset($room_data['reg_date_start']))
			{
				$newDate = date("Y-m-d", strtotime($room_data['reg_date_start']));
				$room_data['reg_date_start'] = $newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts').' '.$this->input->post('ampm');
				//echo "<br>".$_REQUEST["hidden_time_zone"];
				
				$timezone = new DateTimeZone($_REQUEST["hidden_time_zone"]);
				$offset = $timezone->getOffset(new DateTime("now")); 
				$offset_value =  ($offset < 0 ? '' : '+').round($offset/3600);
				$room_data['server_start_time']= date('Y-m-d h:i A',strtotime($newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts'))-($offset_value*3600));
			}
			
			if(isset($_REQUEST["show_us_intl"]) && $_REQUEST["show_us_intl"]=='intl')
			{
				$room_data['time_zone_offset'] = $_REQUEST['time_zone_intl'];
			}
			else if(isset($_REQUEST["show_us_intl"]) && $_REQUEST["show_us_intl"]=='us')
			{
				$room_data['time_zone_offset'] = $_REQUEST['time_zone_us'];
			}
			else
			{
				$room_data['time_zone_offset'] = '';
			}
			
			$password = '';
			if(isset($room_data['password']))
			{
				$password =  "<tr><td>Your Password:</td><td>".$room_data['password']."</td></tr>";
			}
			
			$message = "<table width='600' border='0'><tr><td>Meeting Name: </td><td>".$room_data['name']."</td></tr><tr><td>Topic Name:</td><td>".$room_data['topic']."</td></tr>".$password."<tr><td>Start Date:</td><td>".$room_data['reg_date_start']."</td></tr><tr><td>Message</td><td>".$room_data['message']."</td></tr></table>";
			
			$room_rid = $this->Room_Model->save_edit_existing_users($this->input->post('hidden_room_rid'));
			//print_r($non_group['non_group']);exit;
			if(isset($non_group['non_group'])&&!empty($non_group['non_group']))
			{
					$customers = explode(",", $non_group['non_group']);					
					$private_attendies = $this->Room_Model->save_private_attendies($customers, $this->site_id, $this->input->post('hidden_room_rid'));					
			}
			//$this->Room_Model->save_existing_users($room_data['room_rid']);			
			$save = $this->Room_Model->save_edit_room($room_data, $room_id);
			if(isset($action) && !empty($action))
			{
				//Get All Email Ids Of Customers If Selected
				
				$email_ids = $this->Room_Model->get_all_site_gropus_user_email($this->input->post('hidden_room_rid'));								
				$this->send_mail($email_ids, $room_data['topic'], $room_rid, $message, $room_id);
				$this->send_mail_presenter($_SESSION['user_info']['user_id'], $_SESSION['user_info']['user_email'], $room_rid, $room_data['topic'], $message, $room_id);
			}
			
			redirect(base_url().index_page().'room_management/index/'); 
	  
	  }
	  
      function user_rooms()
	  {
		
		 if ($this->input->post('action') && $this->input->post('action') == 'addCustomer'){
				
			   $this->customer_id = $_SESSION['login_info']['customer_id'];
				if($this->customers_model->address_book_ad($this->site_id, $this->customer_id))
				{
					
					redirect(base_url().index_page().'MyAccount/login','refresh');
				}
				 
		}
		else{
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
		if($page_header == "Other")
		{			
			$data['header_image'] = $this->Site_Model->getHeaderImage($data["page_id"]);
		}
		else if($page_header == "Slideshow")
		{			
			$data['header_image'] = $this->Site_Model->getSlideshowHeaderImgs($page_id);			
		} 
		else
		{
			$header = "";         
		}
		$_SESSION['site_id'] = $data["site_id"];
			
			 // menu requiired variable 
		
			$is_seo_enabled = $this->config->item('seo_url');
			$site_id = $_SESSION['site_id'];
			$temp_name =  $this->my_template_menu->set_get_template($site_id); // template name
			
			//get & set site template
			
			$temp_name =  $this->my_template_menu->set_get_template($site_id); 
			$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
			$this->template->add_css($color_scheme_css,'embed');
			
			/***********	Basic Menu Start		************/
			
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
			  
			$dataMenu = $top_site_menu_basic;
			
			$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
			
			$data['menu'] =  $top_site_menu_basic;
			
			/***********	Basic Menu End		************/
			
			 $site_user_id = 0 ;
         
			 if(isset($_SESSION['user_info']['user_id']))
			 {
				$site_user_id = $_SESSION['user_info']['user_id'];
			 }
			 $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id);   
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			
			$data['logo_image'] = $this->Site_Model->get_logo_image($_SESSION['site_id']);
			$logo_view = $this->Site_Model->check_logo_image($_SESSION['site_id']);
			
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop, Ecommerce'); 
			$data["site_name"] = '';  

		   
		   if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}      
		   $this->template->write_view('menu', $temp_name.'/menu', $data); 
			
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