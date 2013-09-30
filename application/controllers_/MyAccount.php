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
		
		$this->load->library('Paypal_Lib');
		$this->load->model("Menus_Model");
		$this->load->model("UsersModel");
		$this->load->model('orders_model');
		$this->load->model('Shop_model');
		$this->load->model('Categories_model');
		$this->load->model('product_model');
		$this->load->model('customers_model');
		$this->load->model('Groups_Model');
		$this->load->model('cart_model'); // Load our cart model for our entire class
		$this->load->model('shop_model');  
		$this->load->model('Room_Model'); 
		$this->load->Model('Webinar_Model');
		$this->load->Model('Invoice_Model'); 
		$this->load->Model("pages_model");
		$this->load->model('Footer_Model');  		
		$this->load->model('Site_Model');
		$this->load->model("Video_Gallery_Model");
		$this->load->model("Autoresponders_Model");
		$this->load->library('cart');
		$this->load->library('cezpdf');
		$this->load->library('mpdf/mpdf');
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
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		$page_title = $rowHomepage["page_title"];
		$data['page_title'] =  $page_title;
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
		$_SESSION['site_id'] = $data["site_id"];
		
		  $data['page_id2'] = $page_id; 
		  if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'ok'; 
		   $data['page_title'] =  $page_title;
		  
		 }else
		 {
			 $data['ishome'] = 'no';
			 $data['page_title'] =  '';
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
		
		
		
		$this->template->write('description', 'MY Account '); 
		$this->template->write('keywords', 'MY Account , login , logout, mycart'); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		   
		   
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
		 
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$logo_view = $this->Site_Model->check_logo_image($site_id);
		
		if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
		{
		  $this->template->write_view('logo', $temp_name.'/logo', $data);
		}
		 
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
		
		  
		 
		  
		  $this->template->write_view('menu', $temp_name.'/menu', $data); 
		   
		   
		   
			
		 //  $data['customers'] = $this->customers_model->getAllCustomers();
		 //  $data['module'] = 'customers';
			
			
			/*	check ticket exitst	*/
			$this->load->model("support_ticket_model");
			$data['tickets_exist'] = $this->support_ticket_model->is_ticket_exist();
			
			
			$cid = $_SESSION["login_info"]["customer_id"];
			/*	check user have room meeting */
			//echo $this->site_id.'--'.$cid;
			$data['room_exist'] = $this->Room_Model->check_customer_meeting($this->site_id, $cid);
			//echo "<pre>"; print_r($data['room_exist']);exit;
			/*	check user have room meeting */
			
			/*	check user have webinar */
			//echo $this->site_id.'-----'.$cid;
			$data['webinar_exist'] = $this->Webinar_Model->check_customer_webinar($this->site_id, $cid);
			//echo "<pre>"; print_r($data['room_exist']);exit;
			/*	check user have webinar */
			
			/*	check user have invoices */
			$data['invoice_exist'] = $this->Invoice_Model->get_user_invoices($this->site_id, $cid);
			/*	check user have invoices */						
			
			/*	check user have order */
			$data['order_exist'] = $this->orders_model->check_customer_order($this->site_id, $cid);
			/*	check user have order */
			
			/*	check for users private pages 	*/
			$data['private_page_exist'] = $this->pages_model->if_user_private_page_exist($this->site_id, $cid);
			
			$this->template->write_view('content','ecommerce/MyAccount_Home',$data);
	
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);
			//echo "<pre>";	print_r($data['private_page_users']); echo "</pre>";
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
		}         $data['page_title'] =  $page_title;
		if(isset($Regions['leftbar']))
		{
			$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
			$data['left_menus_type'] = 'site'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}
		 
		$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		$data['footer_navigation'] =  $footer_navigation;
		if(isset($Regions['footer']))
		{
		$this->template->write_view('footer', $temp_name.'/footer', $data);          
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
	
					
					$customer_id = $_SESSION['login_info']['customer_id'];
					$group_ids = $this->customers_model->get_all_groups_by_customer_id($customer_id);
					
					// check multiple group expire date					
					if (isset($_SESSION['expired_group_id']))  
					{
						unset($_SESSION['expired_group_id']);
					}
					// echo "<pre>";    print_r($group_ids);    echo "</pre>";
					foreach($group_ids as $row)
					{
						$group_id = $row['group_id'];
						
						$group_data = $this->customers_model->check_group_paid($group_id);
						$trialDays = $group_data[0]['duration'];
						$payment_method = $group_data[0]['payment_method'];
						
							
						if ($payment_method == 'Trial' || $payment_method == 'Recursion')
						{
							
							$join_date = $row['group_joining_date'];
							$trial_expire_date = add_days_to_date($join_date,$trialDays);  
							$is_expire = is_date_expired($trial_expire_date); 
							if($is_expire)
							{
								$_SESSION['expired_group_id'][] = $group_id;
							}
							
						}
						  
						
					}
					// echo "<pre>";    print_r($_SESSION['expired_group_id']);    echo "</pre>";  die();
					if($is_expire)
					{
						redirect(site_url().'group_managment/group_trail_end/');    
					}
					
					
					// TRIAL & RECURRING OLDER GROUP 
						// Check Group Id Set
						//if(isset($_SESSION['customer_group_id']))
//						{
//						//echo "sfsf";exit; 
//						$group_data = $this->customers_model->check_group_paid($_SESSION['customer_group_id']);
//						
//						//Check Group Is Recursive
//						//echo $group_data[0]['payment_method'];exit;
//						if($group_data[0]['payment_method'] == 'Recursion' || $group_data[0]['payment_method'] == 'Trial')
//						{	
//							
//							$date_time = explode(" ",$group_data[0]['creat_date']);
//							$customer_data = $this->customers_model->get_customer_group_xref($_SESSION['login_info']['customer_id'], $_SESSION['customer_group_id']);					
//							$date_time = explode(" ",$customer_data['group_joining_date']);
//							$days_left = $this->time_ago($date_time[0], $date_time[1]);
//							
//							// Check Time Is Complete
//							//echo $days_left ."==". $group_data[0]['payment_cycle'];exit;
//							$elapsedTime = new DateTime($customer_data['group_joining_date']);
//							$now         = new DateTime();
//							$time_past_future = ($now < $elapsedTime ? 'Future' : 'Past');
//							
//							if($days_left == $group_data[0]['payment_cycle'] && $time_past_future == 'Past')
//							{
//									//echo $_SESSION['login_info']['customer_id'].'--'.$_SESSION['customer_group_id'];exit;
//									// Delete Customer Group Relation from customer group xref
//									$delete_customer_group_xref = $this->customers_model->recurring_delete_customer_group_xref($_SESSION['login_info']['customer_id'], $_SESSION['customer_group_id']);				
//									$_SESSION['customer_group_id'] = 0;
//									//exit;
//									//$this->logout();
//							}							
//						}
//					}
					// TRIAL & RECURRING OLDER GROUP 
					
					
					if(isset($_SESSION['customer_group_id']))
					{
						
						$group_page = $this->customers_model->get_customer_group_page($_SESSION['customer_group_id']);
						
						 
					}
					
					$cart_data = $this->cart->contents();
					if(!empty($cart_data))
					{
						redirect(base_url().index_page().'MyShop/mycart/'.$this->site_id,'refresh'); 
					}
					
					//$group_page = $this->customers_model->get_customer_group_page($_SESSION['login_info']['customer_id']);
					if(isset($group_page) && $group_page !=0)
					{
					
						//redirect(base_url().index_page().'site_preview/page/'.$this->site_id.'/'.$group_page, 'refresh');
						redirect(base_url().index_page().'site_preview/page/'.$this->site_id.'/'.$group_page, 'refresh');                
					}
					else
					{
						redirect(base_url().index_page().'site_preview/site/'.$this->site_id,'refresh');        
					}        
				}
				else
				{
					if($this->input->post('log_in') == 'shiptime')
					{
						redirect(base_url().index_page().'site_preview/site/'.$this->site_id, 'refresh');   
					}
					else
					{
						
						redirect(base_url().index_page().'MyAccount/login/'.$this->site_id); 
						
					}
					
				}
				 
		}else{
			// print_r($_SESSION);  exit();
			$data = array ();
		//echo "helo";	
		
		
		
		 $rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
		$rowHomepage = $rsltHomepage->row_array();	
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		
		$data["mode"] = '';
		$data["site_id"] = $rowHomepage["site_id"];
		$data["page_id"] = $rowHomepage["page_id"];
		
		$page_status = $rowHomepage["page_status"];
		$page_id = $rowHomepage["page_id"];       
		$data["site_name"] = $rowHomepage["site_name"];
		
		$page_title = $rowHomepage["page_title"];
         $data['page_title'] =  $page_title;
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic		
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
		$_SESSION['site_id'] = $data["site_id"];
		
		$data['page_id2'] = $page_id; 
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'ok';  
		 }else
		 {
			 $data['ishome'] = 'no';
		 }
		 
		$data['page_title'] = $page_title;
		if($page_header == "Other")
		{
			//$header_image = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
			$data['header_image'] = $this->Site_Model->getHeaderImage($data["page_id"]);
			
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
			$rsltBackgroundImage = $this->Site_Model->getBackgroundImage($page_id); 
			$rowBackgroundImage = $rsltBackgroundImage->row_array();
			
			$background_path = base_url()."media/ckeditor_uploads/".$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']."/images/background/";
			$data['background_image'] = $background_path.$rowBackgroundImage['background_image'];
			$data['background_area'] = $rowBackgroundImage['background_area'];
			$data['background_style'] = $rowBackgroundImage['background_style'];
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
		
		
		
		$this->template->write('description', 'MY Account '); 
		$this->template->write('keywords', 'MY Account , login , logout, mycart'); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		$site_id = $this->site_id;   
		$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);  
		   
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
		 
		$image_path = '';
		$result = $this->Video_Gallery_Model->get_user_of_site($site_id);
	
		$image_path = base_url().'media/ckeditor_uploads/'.$result[0]['user_login'].'_'.$result[0]['user_id'].'/logo/';
		
		$data['path'] = $image_path;
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$logo_view = $this->Site_Model->check_logo_image($site_id);
		
		if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
		{
		  $this->template->write_view('logo', $temp_name.'/logo', $data);
		}
		
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
			$data['page_title'] =  $page_title;
			if(isset($Regions['leftbar']))
			{
				$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
				$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);
				$data['left_menus_type'] = 'site'; 
				$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
			} 
			
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		    $data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
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
  
  function generatePassword($length=8, $strength=0)
	{
	  $vowels = '@#$aeuy*';
	  $consonants = '*#$*()bdghjmnpqrstvz';
	  if ($strength & 1) {
		  $consonants .= '#$*BDGHJLMNPQRSTVWXZ';
	  }
	  if ($strength & 2) {
		  $vowels .= "()AEUY";
	  }
	  if ($strength & 4) {
		  $consonants .= '?23456789';
	  }
	  if ($strength & 8) {
		  $consonants .= '@#$';
	  }
   
	  $password = '';
	  $alt = time() % 2;
	  for ($i = 0; $i < $length; $i++) {
		  if ($alt == 1) {
			  $password .= $consonants[(rand() % strlen($consonants))];
			  $alt = 0;
		  } else {
			  $password .= $vowels[(rand() % strlen($vowels))];
			  $alt = 1;
		  }
	  }
	  return $password;
   }
  
  function Send_Password()
  {
  	$mail = $_POST['email_id'];
	//$user_mail = $this->input->post('email');
	//$password  = $this->customers_model->Recover_Password($mail ,$this->site_id);
	
	$password = $this->generatePassword();
	$this->customers_model->Recover_Password($mail ,$password,$this->site_id);
	 // exit();
	if($password)
	{
		$message = '';
		/*$message .=  "Congratulation !  \n\n Your Password Recovery process copmlete \n \n";
		$message .=  ' 
									# ------------------------ 
									# Login Mail: '.$mail .' 
									# Password: '.$password.' 
									# ------------------------ 								  ';
					$message .= " \n Thanks for using Our Services 
								\n ";
					$message .= 'http://www.webpowerup.com/';*/
						 // #### send mail #### //
                    $message = '-------------------
					
You are receiving this email because someone has requested a change of password.
					
If you did not wish to change your password, please login with the new one here and reset your password back.
					
Login Mail: '.$mail.' 
Password: '.$password.' 

Please do not reply to this email, as it was sent from an unmonitored account.

http://www.webpowerup.com/

--------------';
					$this->load->library('email');
					$this->email->from('web@webpowerup.net', 'WebPowerUp!');
					$this->email->to($mail);
					$this->email->subject('WebPowerUp! Password Recovery Confirmation');
					$this->email->message($message);
					$this->email->send();
					redirect(base_url().index_page().'MyAccount/login','refresh');
	}
	else
	{
			   redirect(base_url().index_page().'MyAccount/password_recovery/');
			 // redirect(base_url().index_page().'MyAccount/login','refresh');
	}
 }
  
 	function register()
	{
	
	
		
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
	$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
	$page_title = $rowHomepage["page_title"];
	$page_desc = $rowHomepage["page_desc"]; 
	$page_keywords = $rowHomepage["page_keywords"];
	$page_header = $rowHomepage["page_header"];
	$data['page_header'] = $page_header;
	
	$header_background = $rowHomepage["header_background"];
	$data['header_background'] = $header_background;
	$data['header_background_image'] = ''; 
	
	$data["footer_content"] = "";
	
	//This is for Footer Dynamic
	$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
	if(!empty($footer_content))
	{
		$data["footer_content"] = $footer_content["content"];
	}
	
	$page_background = $rowHomepage["page_background"]; 
	$page_start_date = $rowHomepage["page_start_date"];  
	$page_end_date = $rowHomepage["page_end_date"];  
	$page_access = $rowHomepage["page_access"];
	
	$_SESSION['site_id'] = $data["site_id"];
	
	 $data['page_id2'] = $page_id; 	
	 if(trim($page_title) == 'Home')
	 {
	   $data['ishome'] = 'ok'; 
	   $data['page_title'] =  $page_title;
	   $data['register'] = 'register';
	  
	 }else
	 {
		 $data['ishome'] = 'no';
		 $data['page_title'] =  '';
		
	 }
	 
	
	if($page_header == "Other")
	{
		//$header_image = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
		$data['header_image'] = $this->Site_Model->getHeaderImage($data["page_id"]);
		
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
		$rsltBackgroundImage = $this->Site_Model->getBackgroundImage($page_id); 
		$rowBackgroundImage = $rsltBackgroundImage->row_array();
		
		$background_path = base_url()."media/ckeditor_uploads/".$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']."/images/background/";
		$data['background_image'] = $background_path.$rowBackgroundImage['background_image'];
		$data['background_area'] = $rowBackgroundImage['background_area'];
		$data['background_style'] = $rowBackgroundImage['background_style'];
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
	
	
	
	$this->template->write('description', 'MY Account '); 
	$this->template->write('keywords', 'MY Account , login , logout, mycart'); 
	//$this->template->write('header', $header);
	//$this->template->write('background', $background);
	 $site_id = $this->site_id;   
	 $data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
	 
	 // menu requiired variable 
	
	$is_seo_enabled = $this->config->item('seo_url');
	$site_id = $_SESSION['site_id'];
	$temp_name =  $this->my_template_menu->set_get_template($site_id); // template name
	
	//die();
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
	
	    $image_path = '';
		$result = $this->Video_Gallery_Model->get_user_of_site($site_id);
	
		$image_path = base_url().'media/ckeditor_uploads/'.$result[0]['user_login'].'_'.$result[0]['user_id'].'/logo/';
		
		$data['path'] = $image_path;
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$logo_view = $this->Site_Model->check_logo_image($site_id);
		
		if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
		{
		  $this->template->write_view('logo', $temp_name.'/logo', $data);
		}
	 
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
	  
	 
	  
	  $this->template->write_view('menu', $temp_name.'/menu', $data); 
	   
		// $this->template->add_js('js/validation/jquery.js');    
		$this->template->add_js('js/validation/jquery.validate.js');    
	   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
	   // $this->template->add_js($my_js, 'embed'); 
		
		$data['title'] = "Create Profile";
		$data['module'] = 'MyAccount';
		
		//Groups respect to site
		$groups = $this->Groups_Model->get_all_site_gropus_customer_view_by_group_type($this->site_id,"Registration");
		// echo "<pre>";"-----------------".print_r($groups);exit;	 
		$data['membership'] = $groups;    
		//echo "<pre>";"-----------------".print_r($data['membership']);exit;
		$button_groups = $this->Groups_Model->get_all_site_groups_with_button($this->site_id);
		//echo "<pre>";print_r($button_groups);exit;
	    $data['button_groups'] = $button_groups;
		
	   /****** Captcah Code *****/
			 $path= realpath( getcwd() ); 
			$this->load->helper('captcha');
			$configs = array(
					'img_path' => $path.'/captcha/',
					'img_url' => base_url() . 'captcha/',
					'img_height' => '23',
					'img_width' => '70',
				); 
			
			$cap = create_captcha($configs);
			
			$data['captcha_record'] = array(
				'captcha_time'	=> $cap['time'],
				'ip_address'	=> $this->input->ip_address(),
				'word'	 => $cap['word']
				);
				
		    $data['captcha_data'] = $cap;
			$data['captcha_image'] = $cap['image'];
				
				
		/****** Captcah Code *****/
	   
	   // $this->load->view($this->_container,$data);
	   //This function is used to create the register page;
	   /*
	   echo '<pre>';
	   echo $temp_name.'I am working here in register';
	   exit;
	   */	
	   
	   /* 3-30-2012 Load payment Data  */
	   
	   //if ($this->paypal_lib->validate_ipn())
		//{
			//echo "<pre>";
			//print_r($this->paypal_lib->ipn_data);
			/*exit;*/
			//$data['group_payment'] = $this->paypal_lib->ipn_data;
			// print_r($data['group_payment']);
		//}	   
		
		/* 3-30-2012 Load payment Data  */
		/*
		if($temp_name == "vantage")
		{
			//Default laout set for Vanatage
			$this->template->write_view('content','ecommerce/customers_create',$data);
		}
		else 
		{
			$this->template->write_view('content',$temp_name.'/ecommerce/customers_create',$data);
		}
		*/
		
		$data['step'] = 1; 
		if($temp_name == "salima-pirani")
		{
			$this->template->write_view('content',$temp_name.'/ecommerce/customers_create',$data);
		}
		else 
		{
			$this->template->write_view('content','ecommerce/customers_create',$data);
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
	$data['page_title'] = $rowHomepage["page_title"];
	if(isset($Regions['leftbar']))
	{
		$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
		$data['left_menus_type'] = 'site'; 
		$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
	} 
		
	$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
	$data['footer_navigation'] =  $footer_navigation;
	
	
	if(isset($Regions['footer']))
	{
		$this->template->write_view('footer', $temp_name.'/footer', $data);          
	} 
		$this->template->render();      
	
	}
  
	function register_process()
	{
		
		$mail = $this->input->post('email');
		$password = $this->input->post('password');
		
		
		if($customer_id = $this->customers_model->addCustomer($this->site_id))
		{
			$message = '';
			$message .=  "Congratulation !  \n\n Your signup process copmlete \n ";
			$message .=  " \n
						  
							# ------------------------ 
							# Login Mail: ".$mail." 
							# Password: ".$password."
							# ------------------------ 
						  \n
						  ";
			$message .= "Thanks for using Our Services 
						\n ";
			$message .= 'http://www.webpowerup.com';
			
			$this->load->library('email');
			
			$this->email->from('web@webpowerup.net', 'WebpowerUp');
			$this->email->to($mail);
			//$this->email->cc('musman@virtism.com');
			// $this->email->bcc('them@their-example.com');
			$this->email->subject('Signup | System Confirmation Mail');
			$this->email->message($message);
			$this->email->send();
			echo $customer_id;
			/*$result_array = $this->Autoresponders_Model->autoresponder_data_site_id($this->site_id);
			$count = count($result_array);
			for($i = 0; $i<$count; $i++)
			{				
				$to = $mail;
				$subject = $result_array[$i]['respond_subject'];
				$from = $result_array[$i]['respond_from_addrress'];
				$message = "<h2>".$result_array[$i]['respond_name']."</h2>";
				$message .=  $result_array[$i]['respond_message_body']; 
				$mail_sent = $this->send_mail($to, $subject, $message, $from, $cc = "", $send_html = 1);
			}*/
			//echo 1;
			
		}
		else
		{
			echo 0;
		}
 
		
	}
	
	function send_mail($to, $subject, $message, $from, $cc = "", $send_html = 1)
	{
		$headers  = "";
		if ($send_html)
		{
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		}
		$headers .= "From: $from\r\n";
		if($cc != "") $headers .= "Cc: $cc\r\n";
		@mail($to, $subject, $message, $headers);
	}
	
	function join_group()
	{
		/******		saving custom form data 	********/	
		$items = $this->input->post('field');
		//echo "<pre>";		print_r($_POST);
		
		$form_values_arr = array ();
		$msg_bdy = ''; 
		foreach($items as $key => $item)
		{ 	
		
			if(!empty($item['value']) && !empty($item['name']))
			{
				if( is_array($item['value']) )
				{
					$form_values_arr[$key]['name'] = $item['name'];
					$form_values_arr[$key]['value'] = implode(",",$item['value']);
				}
				else
				{
					$form_values_arr[$key]['name'] = $item['name'];
					$form_values_arr[$key]['value'] = $item['value'];
				}
			}
			
			
		}
		
		$data_save = $this->Groups_Model->save_group_field_data($form_values_arr, $this->input->post("pending_membershipid") );
		/******		saving custom form data 	********/	
		
		
	  
	 
	  $group_id = $this->input->post("pending_membershipid");
	  
	  if($group_id == 0)
	  {
		  // add group by group code 
		  if( $group_id != "") 
		  {
			  $group_code = $this->input->post("group_code");
			  $group_id = $this->Groups_Model->get_group_id_by_group_Code($group_code);
			  $r = $this->Groups_Model->add_member_to_free_group_registration($group_id);
		  }
	  		  
	  }
	  else
	  {
			$r = $this->Groups_Model->add_member_to_singel_group_registering();
			$this->session->set_userdata('seccess_group', 'You have successfully joined group please login.');
			$this->Groups_Model->send_group_notification($this->input->post("customer_id"), $group_id);  
	  }
	  if($r == 1)
	  {
			$autorespond_data = $this->Autoresponders_Model->get_autoresponder_by_group_id($group_id);
			//$this->input->post("customer_id");exit;//"<pre>";print_r($autorespond_data);exit;
			foreach($autorespond_data as $responder)
			{
				//echo "<pre>";print_r($responder);exit;
				$this->send_autoresponder($responder,$this->input->post("customer_id"));
			}
			
			$this->Groups_Model->send_group_notification($this->input->post("customer_id"),$group_id);
	  }
	  
	  redirect(base_url().index_page().'MyAccount/login','refresh');
  }
  
  function payment_process()
  {
	  	$this->load->model("group_payment_model");
		if ( $this->group_payment_model->save_payment() )
		{
			
			$group_id = $this->input->post("item_number");
			$custom = $this->input->post("custom");
			$customAry = explode("-",$custom);
			//echo "<pre>";	print_r($customAry);		die();
			$customer_id = $customAry[3];
			$this->Groups_Model->add_member_to_group_after_payment($customer_id,$group_id);
			$autorespond_data = $this->Autoresponders_Model->get_autoresponder_by_group_id($group_id);
			//$this->input->post("customer_id");exit;//"<pre>";print_r($autorespond_data);exit;
			foreach($autorespond_data as $responder)
			{
				//echo "<pre>";print_r($responder);exit;
				$this->send_autoresponder($responder,$customer_id);
			}   
			redirect(base_url().index_page().'MyAccount/login','refresh');
			
		}
  }
    // method to send autoresponder email 
      function send_autoresponder($data, $customer_id)
      {
        	//echo $customer_id;exit;
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);          
            $subject = $data['respond_name'];
            $body = $data['respond_subject'];
			$emails_customers = $this->customers_model->getCustomer($customer_id);
			//echo "<pre>";print_r($emails_customers);
            $user_gruop = $data['respond_message_body'];
			//echo $emails_customers['customer_email'];exit;
			//echo $mail;exit;
			$this->email->from($data['respond_from_addrress'], 'Your Name');
			$this->email->to($emails_customers['customer_email']);           
			$this->email->subject($subject);
			$this->email->message($body);    
			$this->email->send();
			return true;			
      }
  
  function sendcontact_mail()
{
	 $names = $_POST['names'];
	 $email = $_POST['email_address'];
	 $comment = $_POST['comment'];
	
	 
	 $message = "";
	 $message .= "Name: " . htmlspecialchars($names, ENT_QUOTES);
	 $message .= "Email: " . htmlspecialchars($email, ENT_QUOTES);
	 $message .= "Comment: " . htmlspecialchars($comment, ENT_QUOTES);
	 $message .= "Thanks for using Our Services ";
	 $message .= 'http://webpowerup.com/';
	 $to = 'khalil.junaid@gmail.com';
	// #### send mail #### //			
	/*$this->load->library('email');
	$this->email->from('admin@webpowerup.com', 'WebpowerUp');
	$this->email->to($email);	
	$this->email->subject('Contact Us');
	$this->email->message($message);
	$this->email->send();
*/
	 
	$mail =   mail($to, "Contact Form", $message);
	 if ($mail)
	 {
	    echo 'sent';
	 }else
	 {
		echo 'failed';
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
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		$page_title = $rowHomepage["page_title"];
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
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
			 
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			
			$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
			$data["site_name"] = '';  		  
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
		
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		    $data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
			}
						
			$this->template->render();      
		}
  }
  
  
  function Password_Recovery()
  {
  
	
		/*echo "hello";
		echo $_SESSION['site_id'];
		exit();*/
		  
		$data = array ();
		$temp_name =  $this->my_template_menu->set_get_template($this->site_id);			
		$rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
		$rowHomepage = $rsltHomepage->row_array();
		
		/*echo "<pre>";
		print_r($rowHomepage);
		exit();*/
		
		$data["mode"] = '';
		$data["site_id"] = $rowHomepage["site_id"];
		$data["page_id"] = $rowHomepage["page_id"];
		
		$is_seo_enabled = $this->config->item('seo_url');
		//$site_id = $_SESSION['site_id'];
		
		//$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $this->site_id; 
		$site_id = $this->site_id; 
		/*echo $temp_name;
		exit();*/
        $image_path = '';
		$result = $this->Video_Gallery_Model->get_user_of_site($site_id);
	
		$image_path = base_url().'media/ckeditor_uploads/'.$result[0]['user_login'].'_'.$result[0]['user_id'].'/logo/';
		
		$data['path'] = $image_path;
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$logo_view = $this->Site_Model->check_logo_image($site_id);
		
		if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
		{
		  $this->template->write_view('logo', $temp_name.'/logo', $data);
		}
		
		$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id,$is_seo_enabled);
		  
		$dataMenu = $top_site_menu_basic;
		
		$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
		
		$data['menu'] =  $top_site_menu_basic;
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
		  $this->template->write_view('menu', $temp_name.'/menu', $data);
		  
           	$page_title = $rowHomepage["page_title"];
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'ok'; 
		  
		   $data['register'] = 'register';
		  
		 }else
		 {
			 $data['ishome'] = 'no';
		
			
		 }		
		   if($temp_name == "vantage")
		  {
		  	 $temp_name = 'comunity'; 
		     $this->template->write_view('content',$temp_name.'/ecommerce/password_recovery',$data);
		  }
		  else
		  {
		    $this->template->write_view('content',$temp_name.'/ecommerce/password_recovery',$data);
		  }
		 $this->template->render();       
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
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		$page_title = $rowHomepage["page_title"];
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
		$_SESSION['site_id'] = $data["site_id"];
			
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			
			
			
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
			$data["site_name"] = '';  		   
			$data['menu'] =  $top_site_menu_basic;
		    if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}      
			
			 $this->template->write_view('menu', $temp_name.'/menu', $data); 
		   
			$this->template->add_js('js/validation/jquery.js');    
			$this->template->add_js('js/validation/jquery.validate.js');    
		   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
		   // $this->template->add_js($my_js, 'embed');  
			
			$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			

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
			
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		    $data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
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
					
					redirect(base_url().index_page().'MyAccount/account','refresh');
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
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		$page_title = $rowHomepage["page_title"];
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
		$_SESSION['site_id'] = $data["site_id"];
					
					
			 
			$data['site_id']=$this->site_id;
			
			
			
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
			$data["site_name"] = '';  
			
			$this->template->add_js('js/validation/jquery.js');    
			$this->template->add_js('js/validation/jquery.validate.js');    
		    // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
		    // $this->template->add_js($my_js, 'embed');  
			
			
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
			/*$this->template->write('title', 'Online Shop');  */
			
			
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
			$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
		   if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}       
			$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
		   $this->template->write_view('menu', $temp_name.'/menu', $data); 
			
			$data['title'] = "My Account Informations";
			$data['module'] = 'MyAccount';
			
			 $data['membership'] = $this->Groups_Model->get_all_site_gropus_suctomer_view($this->site_id); 
			//$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
			$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
			
			/* right side linkes data */
			/*	check ticket exitst	*/
			$this->load->model("support_ticket_model");
			$data['tickets_exist'] = $this->support_ticket_model->is_ticket_exist();
			$cid = $_SESSION["login_info"]["customer_id"];
			/*	check user have room meeting */
			$data['room_exist'] = $this->Room_Model->check_customer_meeting($this->site_id, $cid);
			/*	check user have room meeting */
			/*	check user have webinar */
			$data['webinar_exist'] = $this->Webinar_Model->check_customer_webinar($this->site_id, $cid);
			/*	check user have webinar */
			/*	check user have invoices */
			$data['invoice_exist'] = $this->Invoice_Model->get_user_invoices($this->site_id, $cid);
			/*	check user have invoices */						
			/*	check user have order */
			$data['order_exist'] = $this->orders_model->check_customer_order($this->site_id, $cid);
			/*	check user have order */
			/*	check for users private pages 	*/
			$data['private_page_exist'] = $this->pages_model->if_user_private_page_exist($this->site_id, $cid);
			/* right side linkes data  */
			
		   // $this->load->view($this->_container,$data);
			$this->template->write_view('content','ecommerce/customers_edit',$data);
			
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_type'] = 'myshop'; 
			   
			  $Regions = $this->template->regions;
			/*if(isset($Regions['sidebar']))
			{
			  $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
			  $this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
			   
			}*/
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
				
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		    $data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
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
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		$page_title = $rowHomepage["page_title"];
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
			$_SESSION['site_id'] = $data["site_id"];
			$site_id = $data["site_id"];
			
			
			
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
			
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			
			
			
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
			
			$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
			$data['title'] = "Invoices";
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['invoices'] = $this->customers_model->getAllInvoices($this->site_id, $this->customer_id);
			$data['payPal_id'] = '';
			$data['payPal_id'] =  $this->Shop_model->get_paypal_id_of_store_of_site($this->site_id);
			$data['site_id'] = $this->site_id;
			$data['customer_detail'] = $this->customers_model->getCustomer($this->customer_id);
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
				
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		    $data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
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
		$store_logo = $this->shop_model->get_store_settings($this->site_id);
		$customer_id = $invoice_data['invoice_info'][0]['customer_id'];
		$invoice_data['customer_detail'] = $this->customers_model->getCustomer($customer_id);
		$invoice_data['customer_book'] = $this->customers_model->getAllAddress($customer_id);
		$site_admin_id = $this->UsersModel->get_user_id_by_site_id($this->site_id);
		$user_data = $this->UsersModel->get_user_details_by_user_id($site_admin_id);
		
		$invoice_data['count'] = count($invoice_data['invoice_info']);
		
		for($i = 0; $i<$invoice_data['count']; $i++)
		{
			$invoice_data['product_detail'][] = $this->product_model->getProduct($invoice_data['invoice_info'][$i]['product_id']);
		}	
		
		if($store_logo['publish'] =='Yes' && !empty($store_logo['store_logo']))
		{
			$image_name_array = explode('.',$store_logo['store_logo']);
			$thumbnail_name = $image_name_array[0]."_thumb.".$image_name_array[1];
			$upload_path  = realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/logo/'.$thumbnail_name; 
		}
		
			
		//Invoice detail
		if(isset($invoice_data['invoice_info'][0]['quote']) && $invoice_data['invoice_info'][0]['quote'] == 'yes')
		{ 
			$type = "Quote";
		}
		else
		{ 
			$type = "Invoice";
		}
		
		$all_products_html = '';
		$sub_tax = 0;
		$total_price = 0;
		
		
		for($i = 0; $i<$invoice_data['count']; $i++)
		  {
			$all_products_html .='<tr align="center">
				<td>'.$invoice_data['product_detail'][$i]['product'].'</td>
				<td>'.$invoice_data['invoice_info'][$i]['description'].'</td>
				<td>$'.number_format($invoice_data['product_detail'][$i]['list_price'],2,'.','').'</td>
				<td>'.number_format($invoice_data['invoice_info'][$i]['quantity'],2,'.','').'</td>
				<td>'.number_format($invoice_data['invoice_info'][$i]['discount'],2,'.','').'%</td>
				<td>'.number_format($invoice_data['invoice_info'][$i]['taxone'],2,'.','').'%</td>
				<td>'.number_format($invoice_data['invoice_info'][$i]['taxtwo'],2,'.','').'%</td>
				<td>$'.number_format($invoice_data['invoice_info'][$i]['price'],2,'.','').'</td>
		  		</tr>';
				
				$total_tax = $invoice_data['invoice_info'][$i]['taxone'] + $invoice_data['invoice_info'][$i]['taxtwo'];
				$tax1      = $invoice_data['invoice_info'][$i]['taxone'] * (0.01) * $invoice_data['invoice_info'][$i]['price'];
				$tax2      = $invoice_data['invoice_info'][$i]['taxtwo'] * (0.01) * $invoice_data['invoice_info'][$i]['price'];
				$tax = $tax1 + $tax2;
				$sub_tax = $sub_tax + $tax; 
				$total_price += $invoice_data['invoice_info'][$i]['price'];
				
		  }
		
		
		 $this->mpdf->SetHeader('{DATE d-m-Y}|{PAGENO}|Customer Invoice');
		
		$html_output = '<table width="100%" border="0" >
							 <tr>
								<td colspan="2">
									<table width="100%">
										<tr>
											<td align="left" width="60%"><img  style="vertical-align:top; width:100px; height:100; margin-right:200px;  float:left;" src="'.$upload_path.'" /></td>
											<td><h1 >Invoice View</h1></td>
										</tr>
									</table>
								</td>
    						</tr>
            				<tr>
								<td>
									<table width="350" border="1">
										<tr>
											<td colspan="2"><b>Biller Detail</b></td>  
										</tr>
										<tr>
											<td>Name</td><td>'.$invoice_data['invoice_info'][0]['username'].'</td>  
										</tr>
										<tr>
											<td>Company</td><td>'.$invoice_data[0]['company'].'</td>  
										</tr>
										<tr>
											<td>Address</td><td>'.$user_data[0]['street_address'].' ,'.$user_data[0]['city'].' '.$user_data[0]['country'].' ,'.$user_data[0]['state'].'<br>'.$user_data[0]['pnumber'].'</td>  
										</tr>
										<tr>
											<td>Create Date</td><td>'.$invoice_data['invoice_info'][0]['invoice_date'].'</td>  
										</tr>
										<tr>
											<td>Due Date </td><td>'.$invoice_data['invoice_info'][0]['due_date'].'</td>  
										</tr>
										
									</table>	
								</td>
								<td align="right">
									<table  width="300" border="1" style="border:1px solid #666666;">
										<tr>
											<td colspan="2"><b>Customer Detail</b></td>  
										</tr>				
										<tr>
											<td colspan="2">Bill To: </td>  
										</tr>				
										<tr>
											<td>Name </td><td>'.$invoice_data['customer_detail']['customer_fname'].'</td>
										</tr>
										<tr>
											<td>Company</td><td>'.$invoice_data['customer_detail']['customer_company'].'</td>  
										</tr>
										<tr>
											<td>Address</td><td>'.$user_data[0]['street_address'].' ,'.$user_data[0]['city'].' '.$user_data[0]['country'].' ,'.$user_data[0]['state'].'<br>'.$user_data[0]['pnumber'].'</td>  
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-top:25px;"   colspan="2">
									<table  width="100%" cellspacing="1" cellpadding="20" border="0">
										  <tr style="background-color:#CCCCCC;" >
											<th scope="col"><h6>Product/Service</h6></th>
											<th scope="col"><h6>Description</h6></th>
											<th scope="col"><h6>Unit&nbsp;Cost</h6></th>
											<th scope="col"><h6>Quantity</h6></th>
											<th scope="col"><h6>Discount</h6></th>
											<th scope="col"><h6>Tax&nbsp;1</h6></th>
											<th scope="col"><h6>Tax&nbsp;2</h6></th>
											<th scope="col"><h6>Price</h6></th>
										  </tr>'.$all_products_html.'
									</table>
								</td>	
							</tr>
							<tr>
								<td style="padding-top:20px; padding-right:10px;" colspan="2">
									<table align="right"> 
									  <tr>
										<td ><label>Subtotal: </label></td>
										<td ><div id="subtotal">$'.number_format($total_price,2,'.','').'</div></td>
									  </tr>
									  <tr>
										<td  style="font-weight:bold;"><label>Net Total: </label></td>
										<td  style="font-weight:bold;"><div id="total">$'.number_format($total_price,2,'.','').'</div></td>
									  </tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="left" >
									<strong>Terms & Conditions</strong>
									<br>
									'.$invoice_data['invoice_info'][0]['terms_conditions'].'
									<br>
								</td>			
							</tr>
							<tr>
								<td align="left" >
									<br>		
									<strong>Invoice Notes</strong>
									<br>
									'.$invoice_data['invoice_info'][0]['invoice_notes'].'
								</td>
							</tr>
					</table>' ;
		
		
		//Amount Detail
		$this->mpdf->WriteHTML($html_output);
		$this->mpdf->Output();
		exit;
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
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		$page_title = $rowHomepage["page_title"];
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
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
			
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
/*            $this->template->write('title', 'Online Shop'); */
			$data['site_id']=$this->site_id;
			
			$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
			$data["site_name"] = '';  		   
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
			
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		    $data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
			}
			
			$this->template->render();      
		}
  }
  
	function edit_group()
	{
	  
		$this->is_login();
		if ($this->input->post('action') && $this->input->post('action') == 'change_pass'){
				
			   $this->customer_id = $_SESSION['login_info']['customer_id'];
				if($this->customers_model->change_password($this->site_id, $this->customer_id))
				{
					
					redirect(base_url().index_page().'MyAccount','refresh');
				}
				 
		}
		else{
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
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		$page_title = $rowHomepage["page_title"];
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
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
	
			
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
	/*            $this->template->write('title', 'Online Shop'); */
			$data['site_id']=$this->site_id;
			
			$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
			$data["site_name"] = '';  
	
	
		   
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
		   
			
			$this->template->write('title', 'Manage Groups'); 
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
			$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
			
			$data['allGroups'] = $this->Groups_Model->get_all_groups_of_member($this->site_id,$this->customer_id); 
		   
			$this->template->write_view('content','ecommerce/group_edit',$data);
			
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
			
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
			$data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
			}
			
			$this->template->render();      
		}
	}
	
	function private_pages()
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
		$this->session->set_userdata('site_url',$rowHomepage["site_url"]);
		$page_title = $rowHomepage["page_title"];
		$page_desc = $rowHomepage["page_desc"]; 
		$page_keywords = $rowHomepage["page_keywords"];
		$page_header = $rowHomepage["page_header"];
		$data['page_header'] = $page_header;
		
		$header_background = $rowHomepage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($this->site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
			$_SESSION['site_id'] = $data["site_id"];
			$site_id = $data["site_id"];
			
			
			
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
			
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
			/*$this->template->write('title', 'Online Shop');  */
			$data['site_id']=$this->site_id;
			
			
			
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
			
			$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
			{
			  $this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
			$data['title'] = "Invoices";
			$data['module'] = 'MyAccount';
			
			$data['private_pages'] = $this->pages_model->get_user_private_pages($this->site_id,$this->customer_id);
			$this->template->write_view('content','page/front/user_private_pages',$data);
			
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
				
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
		    $data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
			}
				
				$this->template->render();      
			}
			    
	}
	
	function time_ago($date,$time) {
	  $days = abs(ceil((strtotime($date)-strtotime("now"))/86400));
		if ($days > 0)  $timepast = $days." days";
		if ($days == 1)  $timepast = $days." day";
	  $hours = abs(ceil((strtotime($time)-strtotime("now"))/3600));
		if ($days == 0) $timepast = "about ".$hours." hours";
		if ($hours == 1) $timepast = "about ".$hours." hour";
	  $minutes = abs(ceil((strtotime($time)-strtotime("now"))/60))-($hours*60);
		if ($hours == 0) $timepast = $minutes." minutes";
		if ($minutes == 1) $timepast = $minutes." minute";
	  //return $days.'-'.$hours.'-'.$minutes;
	  	return $days;
	}
	
	function submit_payment($site_id, $invoice_id)
	{
		if ($this->paypal_lib->validate_ipn())
		{
			
			$data = $this->paypal_lib->ipn_data;
			if($data['payment_status']!='Denied')
			{
				$this->Invoice_Model->update_invoice_status($data['item_number'], $data['payment_status']);
				 redirect('http://webpowerup.com/MyAccount/invoices', 'refresh');
			}
		}
		 redirect('http://webpowerup.com/MyAccount/invoices', 'refresh');
	}
	
	
}//end class
?>