<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
	session_start(); }  
class MyAccount extends CI_Controller {
	var $site_id;  
	var $flage_step;
	var $customer_id;
	function __construct()
	{
		parent::__construct();

		$this->load->model('orders_model');
		$this->load->model('Categories_model');
		$this->load->model('product_model');
		$this->load->model('customers_model');
		$this->load->model('Groups_Model');
		$this->load->model('cart_model'); // Load our cart model for our entire class
		$this->load->model('shop_model');  
		$this->load->model('Room_Model'); 
		$this->load->Model('Webinar_Model');     
		$this->load->library('cart');

		$this->load->library('cezpdf');
		$this->load->helper('pdf');
		
		$this->load->helper('security');
		if(isset($_SESSION['login_info']['customer_id'])){
		  $this->customer_id =  $_SESSION['login_info']['customer_id'];
		}
		
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
		
	  //  $_SESSION['step'] = 'step1';
	   // $this->flage_step = ''; 
	   
		 $this->load->helper('url');      
		 $this->load->helper('html'); 
		 $this->load->library('template');
		 $this->load->library('my_template_menu');
		 //$this->site_id = $_SESSION['site_id'];   
		if(isset($_SESSION['user_info']['user_id']))
		{
			$this->user_id = $_SESSION['user_info']['user_id']; 	
		}
		else
		{
			$this->user_id = 0; 
		}
		 
		
		 $this->temp_name =  $this->my_template_menu->set_get_template($this->site_id); 
		 
 
	}
 
  function index($site_id = 0)
  {
	 
	 /* echo '<pre>';
	  print_r($_SESSION);
	  exit();*/
		   $this->is_login();
		   
		   $data = array ();
		   
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
		
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes';  
		 }else
		 {
			 $data['ishome'] = 'no';
		 }
		 

		
		if($page_header == "Other")
		{
			//$header_image = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
			$data['header_image'] = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
			
			//$data["header_image"] =  '<div style="height: 100px; background-image: url('."'".$header_image."'".'); background-repeat:no-repeat; background-size:960px 100px;">
			//</div>';
		}
		else if($page_header == "Slideshow")
		{
			//$header_image = $this->Site_Model->getSlideshowHeaderImgs($page_id);
			$data['header_image'] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
			//$header = '<div class="slideshow">';
			//foreach($header_image->result_array() as $rowImage)
			//{
			//    $header .= '<img src="'.base_url().'headers/'.$rowImage["header_image"].'" width="100%" height="150" />';    
			//}
			//$header .= '</div>';
		} 
		else
		{
			$header = "";         
		}
		
		if($header_background=='Image')
		{
			$data['header_background_image'] = base_url().'headers/'.$this->Pages_Model->getHeaderBackgroundImage($page_id);         
		} 
		
		if($page_background == "Default")
		{
			$data['background'] = "";        
		}
		else if($page_background == "Other")
		{
			//$background_image = $this->Site_Model->getBackgroundImage($page_id);
			$rsltBackgroundImage = $this->Site_Model->getBackgroundImage($page_id); 
			$rowBackgroundImage = $rsltBackgroundImage->row_array();
			$background_path = base_url()."backgrounds/";
			$data['background_image'] = $background_path.$rowBackgroundImage['background_image'];
			$data['background_area'] = $rowBackgroundImage['background_area'];
			$data['background_style'] = $rowBackgroundImage['background_style'];
			//$background_image = $data['background_image'];    
			//$data['background'] = 'style="height:400px;width:690px;background-image: url('."'".base_url()."backgrounds/".$background_image."'".'); background-repeat: no-repeat; background-size:100% 100%"';
		}
		
		//get site template
		$temp_name =  $this->my_template_menu->set_get_template($this->site_id);
		$this->template->add_js('js/jquery-1.5.1.min.js');
		$this->template->add_js('js/jquery.cycle.all.js');

		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
		
		$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
		$this->template->add_css('js/nivo-slider/nivo-slider.css'); 
		
		//exit;
		//print_r($arrayRegions['header']);exit;
		//$this->template->set_template('vantage');
		
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $this->site_id; 
		
		//$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', 'MY Account '); 
		$this->template->write('keywords', 'MY Account , login , logout, mycart'); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		   
		   
		 $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
		 
		 $site_user_id = 0 ;
		 
		 if(isset($_SESSION['user_info']['user_id']))
		 {
			$site_user_id = $_SESSION['user_info']['user_id'];
		 }
  	  
		$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 
		 if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}          
		

		  $data['menu'] =  $top_site_menu_basic;
		 
		  
		  $this->template->write_view('menu', $temp_name.'/menu', $data); 
		   
		   
		   
			
		   $data['customers'] = $this->customers_model->getAllCustomers();
		   $data['module'] = 'customers';
			
			/*	ticket */
			
			$this->load->model("support_ticket_model");
			
			$data['total_tickets'] = $this->support_ticket_model->get_loggedInUser_ticket();
			echo "<pre>";
			print_r($data);
			exit;
			/*	ticket */
			
			/*	check user have room meeting */
			$data['room_exist'] = $this->Room_Model->check_customer_meeting($this->site_id, $cid);
			/*	check user have room meeting */
			
			/*	check user have webinar */
			$data['webinar_exist'] = $this->Webinar_Model->check_customer_webinar($this->site_id, $cid);
			/*	check user have webinar */
			
			$this->template->write_view('content','ecommerce/MyAccount_Home',$data);
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 

		$Regions = $this->template->regions;
		
		if(isset($Regions['sidebar']))
		{
		  $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
		  $this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
		   
		}
		if(isset($Regions['rightbar']))
		{  
			$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
			$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
		}
		if(isset($Regions['leftbar']))
		{
			$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
			$data['left_menus_type'] = 'site'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}
		 
			
			
			$this->template->render();
  }

  function login()
  {

		
		if(empty($this->site_id)){
			
		 $this->is_login();
		 }
		 
		//echo "<pre>"; print_r($_POST);exit;
		$data["log_in"] = $this->input->post('log_in');  
		if ($this->input->post('action') && $this->input->post('action') == 'do_login'){
				
				if($this->customers_model->do_login($this->site_id))
				{
					//echo "<pre>"; print_r($_POST);exit;
					//echo '***'.$this->site_id;exit;
					redirect(base_url().index_page().'MyAccount','refresh');        
				}
				else
				{
					if($this->input->post('log_in') == 'shiptime')
					{
						redirect(base_url().index_page().'site_preview/site/'.$this->site_id);   
					}else
					{
						redirect(base_url().index_page().'MyAccount/login','refresh'); 
						
					}
					
				}
				 
		}else{
			// print_r($_SESSION);  exit();
			$data = array ();
			
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
		
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes';  
		 }else
		 {
			 $data['ishome'] = 'no';
		 }
		 

		
		if($page_header == "Other")
		{
			//$header_image = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
			$data['header_image'] = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
			
			//$data["header_image"] =  '<div style="height: 100px; background-image: url('."'".$header_image."'".'); background-repeat:no-repeat; background-size:960px 100px;">
			//</div>';
		}
		else if($page_header == "Slideshow")
		{
			//$header_image = $this->Site_Model->getSlideshowHeaderImgs($page_id);
			$data['header_image'] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
			//$header = '<div class="slideshow">';
			//foreach($header_image->result_array() as $rowImage)
			//{
			//    $header .= '<img src="'.base_url().'headers/'.$rowImage["header_image"].'" width="100%" height="150" />';    
			//}
			//$header .= '</div>';
		} 
		else
		{
			$header = "";         
		}
		
		if($header_background=='Image')
		{
			$data['header_background_image'] = base_url().'headers/'.$this->Pages_Model->getHeaderBackgroundImage($page_id);         
		} 
		
		if($page_background == "Default")
		{
			$data['background'] = "";        
		}
		else if($page_background == "Other")
		{
			//$background_image = $this->Site_Model->getBackgroundImage($page_id);
			$rsltBackgroundImage = $this->Site_Model->getBackgroundImage($page_id); 
			$rowBackgroundImage = $rsltBackgroundImage->row_array();
			$background_path = base_url()."backgrounds/";
			$data['background_image'] = $background_path.$rowBackgroundImage['background_image'];
			$data['background_area'] = $rowBackgroundImage['background_area'];
			$data['background_style'] = $rowBackgroundImage['background_style'];
			//$background_image = $data['background_image'];    
			//$data['background'] = 'style="height:400px;width:690px;background-image: url('."'".base_url()."backgrounds/".$background_image."'".'); background-repeat: no-repeat; background-size:100% 100%"';
		}
		
		//get site template
		$temp_name =  $this->my_template_menu->set_get_template($this->site_id);
		$this->template->add_js('js/jquery-1.5.1.min.js');
		$this->template->add_js('js/jquery.cycle.all.js');
		
		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
		
		$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
		$this->template->add_css('js/nivo-slider/nivo-slider.css'); 
		
		//exit;
		//print_r($arrayRegions['header']);exit;
		//$this->template->set_template('vantage');
		
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $this->site_id; 
		
		//$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', 'MY Account '); 
		$this->template->write('keywords', 'MY Account , login , logout, mycart'); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		   
		   
		 $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
			  $site_user_id = 0 ;
		 
		 if(isset($_SESSION['user_info']['user_id']))
		 {
			$site_user_id = $_SESSION['user_info']['user_id'];
		 }

		$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 
		 if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}      
		  $data['menu'] =  $top_site_menu_basic;
		 
		  
		  $this->template->write_view('menu', $temp_name.'/menu', $data);  

			
			$data['title'] = "Authentication";
			$data['module'] = 'MyAccount';
			$data['log_in'] = 'Myshop';
		   // $this->load->view($this->_container,$data);
			if($temp_name == "vantage")
			{
				//Default laout set for Vanatage
				$this->template->write_view('content','ecommerce/Login.php',$data);
			}
			else 
			{
				$this->template->write_view('content',$temp_name.'/ecommerce/Login.php',$data);
			}
			
			
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 

			$Regions = $this->template->regions;
			if(isset($Regions['sidebar']))
			{
			  $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
			  $this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
			   
			}
			if(isset($Regions['rightbar']))
			{  
				$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
				$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
			}
			if(isset($Regions['leftbar']))
			{
				$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
				$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);
				$data['left_menus_type'] = 'site'; 
				$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
			} 
				
				$this->template->render();
				
				
		}    
	  
	  
  }
  function logout ()
  {
			//@@@@ For Only PHP Session @@@//
					
		   // session_unset();
		   // session_destroy();  
			unset($_SESSION['login_info']);
			unset($_SESSION["customer_group_id"]);
		 //  session_destroy($_SESSION['login_info']);
			
		  //  $_SESSION[] = array();
			//$_SESSION['user_info'] = array();
		   redirect(base_url().index_page().'MyAccount/login','refresh'); 
		//---------------------------------------------------------------------//
		
		//######## For Using Codeigniter Session Class ####### //
		
	   /* $this->session->sess_destroy();
		$this->session->unset_userdata('is_logged_in');
		redirect(base_url().index_page().'UsersController/login/sitelogin');   */
	  
  }
  
  function register ()
  {
		 if ($this->input->post('action') && $this->input->post('action') == 'addCustomer'){
				$mail = $this->input->post('email');
				$password = $this->input->post('password');
					 
				if($this->customers_model->addCustomer($this->site_id))
				{
					$message = '';
					$message .=  "Congratulation !  \n\n Your signup process copmlete \n ";
					$message .=  ' \n
								  
									# ------------------------ 
									# Login Mail: '.$mail.' 
									# Password: '.$password.' 
									# ------------------------ 
								  \n
								  ';
					$message .= "Thanks for using Our Services 
								\n ";
					$message .= 'http://globalonlinewebsitesolutions.com/';
					
				   // echo   $message;
				   // exit;  
					// #### send mail #### //
					
					$this->load->library('email');
					
					$this->email->from('admin@globalonlinewebsitesolutions.com', 'Global Online Website Solutions');
					$this->email->to($mail);
					$this->email->cc('musman@virtism.com');
				   // $this->email->bcc('them@their-example.com');

					$this->email->subject('Signup | System Confirmation Mail');
					$this->email->message($message);

					$this->email->send();
				   // echo $this->email->print_debugger();
					
					
					
					
					
					redirect(base_url().index_page().'MyAccount/login','refresh');
				}
				 
		}else{
			
		// print_r($_SESSION);  exit();
		
		$data = array ();
			
		$rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
		$rowHomepage = $rsltHomepage->row_array();
		
		$data["mode"] 	 = '';
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
		
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes';  
		 }else
		 {
			 $data['ishome'] = 'no';
		 }
		 

		
		if($page_header == "Other")
		{
			//$header_image = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
			$data['header_image'] = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
			
			//$data["header_image"] =  '<div style="height: 100px; background-image: url('."'".$header_image."'".'); background-repeat:no-repeat; background-size:960px 100px;">
			//</div>';
		}
		else if($page_header == "Slideshow")
		{
			//$header_image = $this->Site_Model->getSlideshowHeaderImgs($page_id);
			$data['header_image'] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
			//$header = '<div class="slideshow">';
			//foreach($header_image->result_array() as $rowImage)
			//{
			//    $header .= '<img src="'.base_url().'headers/'.$rowImage["header_image"].'" width="100%" height="150" />';    
			//}
			//$header .= '</div>';
		} 
		else
		{
			$header = "";         
		}
		
		if($header_background=='Image')
		{
			$data['header_background_image'] = base_url().'headers/'.$this->Pages_Model->getHeaderBackgroundImage($page_id);         
		} 
		
		if($page_background == "Default")
		{
			$data['background'] = "";        
		}
		else if($page_background == "Other")
		{
			//$background_image = $this->Site_Model->getBackgroundImage($page_id);
			$rsltBackgroundImage = $this->Site_Model->getBackgroundImage($page_id); 
			$rowBackgroundImage = $rsltBackgroundImage->row_array();
			$background_path = base_url()."backgrounds/";
			$data['background_image'] = $background_path.$rowBackgroundImage['background_image'];
			$data['background_area'] = $rowBackgroundImage['background_area'];
			$data['background_style'] = $rowBackgroundImage['background_style'];
			//$background_image = $data['background_image'];    
			//$data['background'] = 'style="height:400px;width:690px;background-image: url('."'".base_url()."backgrounds/".$background_image."'".'); background-repeat: no-repeat; background-size:100% 100%"';
		}
		
		//get site template
		$temp_name =  $this->my_template_menu->set_get_template($this->site_id);
		$this->template->add_js('js/jquery-1.5.1.min.js');
		$this->template->add_js('js/jquery.cycle.all.js');
		
		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
		
		$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
		$this->template->add_css('js/nivo-slider/nivo-slider.css'); 
		
		//exit;
		//print_r($arrayRegions['header']);exit;
		//$this->template->set_template('vantage');
		
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $this->site_id; 
		
		//$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', 'MY Account '); 
		$this->template->write('keywords', 'MY Account , login , logout, mycart'); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		   
		   
		 $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
		  $site_user_id = 0 ;
		 
		 if(isset($_SESSION['user_info']['user_id']))
		 {
			$site_user_id = $_SESSION['user_info']['user_id'];
		 }

		$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 
		 if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}         

		  $data['menu'] =  $top_site_menu_basic;
		 
		  
		  $this->template->write_view('menu', $temp_name.'/menu', $data); 
		   
			// $this->template->add_js('js/validation/jquery.js');    
			$this->template->add_js('js/validation/jquery.validate.js');    
		   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
		   // $this->template->add_js($my_js, 'embed'); 
			
			$data['title'] = "Create Profile";
			$data['module'] = 'MyAccount';
			
			//Groups respect to site
			$groups = $this->Groups_Model->get_all_site_gropus_suctomer_view($this->site_id);
			$data['membership'] = $groups;    
			
		   
		   
		   // $this->load->view($this->_container,$data);
		   //This function is used to create the register page;
		   /*
		   echo '<pre>';
		   echo $temp_name.'I am working here in register';
		   exit;
		   */		   
		   if($temp_name == "vantage")
			{
				//Default laout set for Vanatage
				$this->template->write_view('content','ecommerce/customers_create',$data);
			}
			else 
			{
				$this->template->write_view('content',$temp_name.'/ecommerce/customers_create',$data);
			}
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 
			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);

		$Regions = $this->template->regions;
		
		if(isset($Regions['sidebar']))
		{
		  $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
		  $this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
		   
		}
		if(isset($Regions['rightbar']))
		{  
			
			
			$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
			$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
		}
		if(isset($Regions['leftbar']))
		{
			$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
			$data['left_menus_type'] = 'site'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		} 
			
			$this->template->render();      
		}
  }
  
  function AddressBook ()
  {
		
		  $this->is_login();
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
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			$this->template->write_view('logo', $temp_name.'/logo', $data);
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
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

			
			$data['title'] = "Address book";
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id);     
		   // $this->load->view($this->_container,$data);
			$this->template->write_view('content','ecommerce/AddressBook',$data);
			
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 

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
  
  
  function Password_Recovery()
  {
  
	/*
		echo '<pre>';
		print_r($data);	
		exit;
		$data;
		  */
	 	 $data = array();
		 $temp_name = 'comunity';
		 $this->template->write_view('content',$temp_name.'/ecommerce/password_recovery',$data);
		 $this->template->render();    
		// $this->template->render($temp_name.'/ecommerce/password_recovery.php'); 
	 
	  //$this->load->view($temp_name.'/ecommerce/password_recovery.php',$data);    
		
  }
  
  function is_login()
  {
	  if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) ){
		   return true;
	  }else
	  {
		 
		 // redirect('MyAccount/login'); 
		 redirect("http://".$_SERVER['HTTP_HOST']);
	  }
  }
  
  function AddressBook_new ()
  {
		
		 $this->is_login();
		if ($this->input->post('action') && $this->input->post('action') == 'address_book_add'){
				
			   $this->customer_id = $_SESSION['login_info']['customer_id'];
				if($this->customers_model->address_book_ad($this->site_id, $this->customer_id))
				{
					
					redirect(base_url().index_page().'MyAccount/AddressBook','refresh');
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
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			$this->template->write_view('logo', $temp_name.'/logo', $data);
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
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

		   
			$this->template->add_js('js/validation/jquery.js');    
			$this->template->add_js('js/validation/jquery.validate.js');    
		   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
		   // $this->template->add_js($my_js, 'embed');  
			
			$data['title'] = "Address book";
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id);     
		   // $this->load->view($this->_container,$data);
			$this->template->write_view('content','ecommerce/AddressBook_add',$data);
			
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 

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
		if(isset($Regions['rightbar'])) 
		{
			$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
			$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
		}
			
			$this->template->render();      
		}
  }
  
  
   function account ()
  {
		
		 $this->is_login();
		 //echo "i m in";exit;
		 if ($this->input->post('action') && $this->input->post('action') == 'updat_account'){
				
			   $this->customer_id = $_SESSION['login_info']['customer_id'];
				if($this->customers_model->updateCustomer($this->site_id, $this->customer_id))
				{
					
					redirect(base_url().index_page().'MyAccount','refresh');
				}
				 
		}else{
			// print_r($_SESSION);  exit();
			$data = array ();
		
		$rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
		$rowHomepage = $rsltHomepage->row_array();
		$temp_name =  $this->my_template_menu->set_get_template($this->site_id);	
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
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			$this->template->write_view('logo', $temp_name.'/logo', $data);
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
			$data["site_name"] = '';  

			
			$this->template->add_js('js/validation/jquery.js');    
			$this->template->add_js('js/validation/jquery.validate.js');    
		   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
		   // $this->template->add_js($my_js, 'embed');  
			

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

			
			$data['title'] = "My Account Informations";
			$data['module'] = 'MyAccount';
			
			 $data['membership'] = $this->Groups_Model->get_all_site_gropus_suctomer_view($this->site_id); 
			//$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
			$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
		   // $this->load->view($this->_container,$data);
			$this->template->write_view('content','ecommerce/customers_edit',$data);
			
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 

			   
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
				
				$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
				$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
			}  
			if(isset($Regions['rightbar']))
			{
				$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
				$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
			}
			
			$this->template->render();      
		}
  }

			//	12 March 2012, Mohsin
  function invoices()
  {
		 $this->is_login();
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
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
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
			$data['invoices'] = $this->customers_model->getAllInvoices($this->site_id, $this->customer_id);     
		   // $this->load->view($this->_container,$data);
			$this->template->write_view('content','ecommerce/show_invoices',$data);
			
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 

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
			
			//	12 March 2012, Mohsin 
			
			//	Invoice View Action Functions
	
	// Invoice View
	function create_view_invoice($invoice_id)
	{
		// Making Changes 12 MArch, 2012
		//$site_id = $_SESSION['site_id'];
		$invoice_data['invoice_info'] = $this->customers_model->get_invoice($invoice_id);
		$customer_id = $invoice_data['invoice_info'][0]['customer_id'];
		$invoice_data['customer_detail'] = $this->customers_model->getCustomer($customer_id);
		$invoice_data['customer_book'] = $this->customers_model->getAllAddress($customer_id);
		//$product_id = $invoice_data['invoice_info'][0]['product_id'];
		$invoice_data['count'] = count($invoice_data['invoice_info']);
		for($i = 0; $i<$invoice_data['count']; $i++)
		{
			$invoice_data['product_detail'][] = $this->product_model->getProduct($invoice_data['invoice_info'][$i]['product_id']);
		}		
		/*echo "<pre>";
		print_r($invoice_data);
		exit;*/
		$this->template->write_view('content','ecommerce/invoice_view',$invoice_data);
		$this->template->render();
	}
	
	// PDF View
	function create_pdf_invoice($invoice_id)
	{
		prep_pdf(); // creates the footer for the document we are creating.
		
		$invoice_data['invoice_info'] = $this->customers_model->get_invoice($invoice_id);
		$customer_id = $invoice_data['invoice_info'][0]['customer_id'];
		$invoice_data['customer_detail'] = $this->customers_model->getCustomer($customer_id);
		$invoice_data['customer_book'] = $this->customers_model->getAllAddress($customer_id);
		//$product_id = $invoice_data['invoice_info'][0]['product_id'];
		$invoice_data['count'] = count($invoice_data['invoice_info']);
		for($i = 0; $i<$invoice_data['count']; $i++)
		{
			$invoice_data['product_detail'][] = $this->product_model->getProduct($invoice_data['invoice_info'][$i]['product_id']);
		}	
		/*echo "<pre>";	
		echo $invoice_data['invoice_info'][0]['subtotal'];
		print_r($invoice_data['invoice_info']);
		exit;*/
		
		//Invoice Heading
		$this->cezpdf->ezText("Invoice View", 16, array('justification' => 'center'));
		$this->cezpdf->ezSetDy(-20);
		////////
		
		//Invoice detail
		if(isset($invoice_data['invoice_info'][0]['quote']) && $invoice_data['invoice_info'][0]['quote'] == 'yes')
		{ 
			$type = "Quote";
		}
		else
		{ 
			$type = "Invoice";
		}
		
		$content = "Invoice ID: ".$invoice_data['invoice_info'][0]['invoice_id']."\n";
		$content .= "Username: ".$invoice_data['invoice_info'][0]['username']."\n";
		$content .= "Invoice Date: ".$invoice_data['invoice_info'][0]['invoice_date']."\n";
		$content .= "Type: ".$type."\n";
		$this->cezpdf->ezText($content, 12);
		/////////
		
		//Invoice Customer		
		$text = $this->cezpdf->ezText("Bill To :", 12, array('justification' => 'left'));
		//$this->cezpdf->ezSetDy(-20);
		$customer_detail = "Name: ".$invoice_data['customer_detail']['customer_fname']."\n";
		$customer_detail .= "Company: ".$invoice_data['customer_detail']['customer_company']."\n";
		$customer_detail .= "Email: ".$invoice_data['customer_detail']['customer_email']."\n";
		$this->cezpdf->ezText($customer_detail, 12);
		/////////
		
		// Creating Table products
		 for($i = 0; $i<$invoice_data['count']; $i++)
		 {
			$db_data[] = array('product' => $invoice_data['product_detail'][$i]['product'], 'description' => $invoice_data['invoice_info'][$i]['description'], 'ucost' => $invoice_data['product_detail'][$i]['list_price'], 'qty' => $invoice_data['invoice_info'][$i]['quantity'] , 'discount' => $invoice_data['invoice_info'][$i]['discount'], 'taxone' => $invoice_data['invoice_info'][$i]['taxone'], 'taxtwo' => $invoice_data['invoice_info'][$i]['taxtwo'], 'price' => $invoice_data['invoice_info'][$i]['price']);
		 }
		
		$col_names = array(
			'product' => 'Product/Service',
			'description' => 'Description',
			'ucost' => 'Unit Cost',
			'qty' => 'Quantity',
			'discount' => 'Discount',
			'taxone' => 'Tax 1',
			'taxtwo' => 'Tax 2',
			'price' => 'Price'
		);		
		$this->cezpdf->ezTable($db_data, $col_names, 'Prodcuts List', array('width'=>550, 'top'=>550));
		////////
		
		//Amount Detail
		$amount[] = array('subtotal'=>$invoice_data['invoice_info'][0]['subtotal'], 'total'=>$invoice_data['invoice_info'][0]['total']);
		
		$amount_total = array('subtotal' => 'Subtotal', 'total' => 'Total');
		
		$this->cezpdf->ezSetDy(-20);
		
		$this->cezpdf->ezTable($amount, $amount_total, '', array('showHeadings'=>1,'shaded'=>0,'showLines'=>0,'fontSize' => 12,'xPos' => 'right'));
		
		$this->cezpdf->ezStream();		
	} 
	
	//Invoice Edit View

	function password_change ()
  {
	  
		$this->is_login();
		 if ($this->input->post('action') && $this->input->post('action') == 'change_pass'){
				
			   $this->customer_id = $_SESSION['login_info']['customer_id'];
				if($this->customers_model->change_password($this->site_id, $this->customer_id))
				{
					
					redirect(base_url().index_page().'MyAccount','refresh');
				}
				 
		}else{
			// print_r($_SESSION);  exit();
			$temp_name =  $this->my_template_menu->set_get_template($this->site_id);
			$data = array ();
			
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
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
/*            $this->template->write('title', 'Online Shop'); */
			$data['site_id']=$this->site_id;
			$this->template->write_view('logo', $temp_name.'/logo', $data);
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
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

			$this->template->add_js('js/validation/jquery.js');    
			$this->template->add_js('js/validation/jquery.validate.js');    
		   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
		   // $this->template->add_js($my_js, 'embed'); 
		   
			
			$data['title'] = "My Account Informations";
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
			$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
		   // $this->load->view($this->_container,$data);
			$this->template->write_view('content','ecommerce/Password_change',$data);
			
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 

			   
			  $Regions = $this->template->regions;
			if(isset($Regions['sidebar']))
			{
			  $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
			  $this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
			   
			}
			if(isset($Regions['sidebar']))
			{  
				$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
				$data['left_menus_type'] = 'site'; 
				$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
				
			
			}  
			if(isset($Regions['rightbar']))
			{
				$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
				$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
			}
			
			$this->template->render();      
		}
  }
 
 
 
}//end class
?>