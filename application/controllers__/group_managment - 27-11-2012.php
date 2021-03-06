<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
	session_start(); }  
	
	
	
class Group_managment extends CI_Controller {
	var $site_id;  
	var $customer_id;
	var $temp_name;
	var $user_id = 0;
	function __construct()
	{
		parent::__construct();
		
		
		
		$this->load->library('Paypal_Lib');
		$this->load->model("Menus_Model");
		$this->load->model('orders_model');
		$this->load->model('Categories_model');
		$this->load->model('product_model');
		$this->load->model('group_payment_model');
		$this->load->model('customers_model');
		$this->load->model('Groups_Model');
		$this->load->model('cart_model'); // Load our cart model for our entire class
		$this->load->model('shop_model');  
		$this->load->model('Room_Model'); 
		$this->load->Model('Webinar_Model');
		$this->load->Model('Invoice_Model'); 
		$this->load->model('Footer_Model');   
		$this->load->model("Site_Model");   
		$this->load->library('cart');
		$this->load->helper('url');      
		$this->load->helper('html'); 
		$this->load->library('template');
		$this->load->library('my_template_menu');
		$this->load->library('session');
		
		
		// 	setting member id 
		if(isset($_SESSION["site_id"]) && is_numeric($_SESSION["site_id"]))
		{
			$this->site_id = $_SESSION['site_id'];
		}
		
		if(isset($_SESSION['login_info']['customer_id']))
		{
			$this->customer_id = $_SESSION['login_info']['customer_id']; 	
		}
		else
		{
			$this->customer_id = 0; 
		}
		 
		// setting tamplate name
		$this->temp_name =  $this->my_template_menu->set_get_template($this->site_id); 
		 
	}
	
	function is_login()
	{
		if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) ){
		   return true;
		}else
		{
		 
		 redirect('MyAccount/login'); 
		 //redirect("http://".$_SERVER['HTTP_HOST']);
		}
	}
	
	function index()
	{
	  
		$this->is_login();
		
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
			
			//$temp_name =  $this->my_template_menu->set_get_template($site_id); 
			$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
			$this->template->add_css($color_scheme_css,'embed');
			
			/***********	Basic Menu Start		************/
			
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
			  
			$dataMenu = $top_site_menu_basic;
			
			$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
			
			$data['menu'] =  $top_site_menu_basic;
			
			/***********	Basic Menu End		************/
			$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
	
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			if(isset($logo_view['publish']) && $logo_view['publish'] == "Yes")
			{
				$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
				$this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
			
			
			
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
	/*            $this->template->write('title', 'Online Shop'); */
			$data['site_id']=$this->site_id;
			
			
			
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
			$data["site_name"] = '';  
	
	
		   
		   if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}      
			
		   	if(isset($temp_name) && $temp_name != 'intro_template')
			 {
				$this->template->write_view('menu', $temp_name.'/menu', $data);  
			 }
	
			$this->template->add_js('js/validation/jquery.js');    
			$this->template->add_js('js/validation/jquery.validate.js');    
		   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
		   // $this->template->add_js($my_js, 'embed'); 
		   
			
			$this->template->write('title', 'Manage Groups'); 
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
			$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
			
			$data['allGroups'] = $this->Groups_Model->get_all_groups_of_member($this->customer_id); 
		   
			$this->template->write_view('content','site_groups/front/groups',$data);
			
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
	
	
	function edit_group()
	{
	  
		$this->is_login();
		
		
		//print_r($_SESSION);  exit();
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
		
		$this->template->write('description', ''); 
		$this->template->write('keywords', ''); 
		$data["site_name"] = '';  
	   
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
		$this->template->add_js('js/validation/jquery.js');    
		$this->template->add_js('js/validation/jquery.validate.js');    
	   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
	   // $this->template->add_js($my_js, 'embed'); 
	   
		
		$this->template->write('title', 'Manage Groups'); 
		$data['module'] = 'MyAccount';
		$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
		$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
		$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
		
		//$group = array();
		$group = $this->Groups_Model->get_group_by_id( $this->uri->segment(3, 0) );
		$data['group'] = $group[0];
		
		$data['upgradableGroups'] = $this->Groups_Model->get_upgradable_groups( $this->uri->segment(3, 0) ); 
		
		$this->template->write_view('content','site_groups/front/group_edit',$data);
		
		
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
	
	
	function update_group()
	{
		//current_group_id
		//echo "here"; 		die();
		//upgrade_group_id
		$member_id = $this->customer_id;
		$r = $this->Groups_Model->upgrade_group($member_id);
		
		if($r == 1)
		{
			$this->session->set_flashdata('upgradeGroupRsp', 'Group was upgraded successfully');
			redirect("group_managment");
		}
		else if ($r == 2)
		{
			$this->session->set_flashdata('upgradeGroupRsp', 'You are already a member of this group');
			redirect("group_managment");
		}
		
		else 
		{
			$this->session->set_flashdata('upgradeGroupRsp', 'Group was not upgraded successfully');
			redirect("group_managment");
		}
		
	}
	
	
	function new_group()
	{
	  
		$this->is_login();
		
		
		//print_r($_SESSION);  exit();
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
		
		$this->template->write('description', ''); 
		$this->template->write('keywords', ''); 
		$data["site_name"] = '';  
	   
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
		$this->template->add_js('js/validation/jquery.js');    
		$this->template->add_js('js/validation/jquery.validate.js');    
	   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
	   // $this->template->add_js($my_js, 'embed'); 
	   
		
		$this->template->write('title', 'Manage Groups'); 
		$data['module'] = 'MyAccount';
		$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
		$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
		$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
		
		
		$data['groups'] = $this->Groups_Model->get_all_unjoined_groups($this->site_id,$this->customer_id); 
		
		$this->template->write_view('content','site_groups/front/group_new',$data);
		
		
		
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
	
	
	function payment()
	{
	  
		$this->is_login();
		
		
		//print_r($_SESSION);  exit();
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
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', ''); 
		$this->template->write('keywords', ''); 
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
		
		//echo "<pre>";	print_r($_POST);	die();
		
		// save payemt details 
		if ($this->group_payment_model->save_payment() )
		{
			$group_id = $this->input->post("item_number");
			$this->Groups_Model->add_member_to_group_after_payment($this->customer_id,$group_id);   
		}
		
		$data['messageResponse'] = ""; 
		$this->template->write_view('content','site_groups/front/group_payment',$data);
		
		
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
	
	
	function upgrade_group_payment()
	{
	  
		$this->is_login();
		
		
		//print_r($_SESSION);  exit();
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
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', ''); 
		$this->template->write('keywords', ''); 
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
		
		//echo "<pre>";	print_r($_POST);	die();
		
		// save payemt details 
		$row = $this->group_payment_model->save_upgradable_group_payment();
		
		if ($row)
		{
			$group_id = $this->input->post("item_number");
			$current_group_id = $row[5];
			$this->Groups_Model->upgrade_group_after_payment($this->customer_id,$group_id,$current_group_id);   
		}
		
		$data['messageResponse'] = ""; 
		$this->template->write_view('content','site_groups/front/group_update_payment',$data);
		
		
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
	
	function group_trail_end()
	{
	  
		$this->is_login();
		
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
			
			//$temp_name =  $this->my_template_menu->set_get_template($site_id); 
			$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
			$this->template->add_css($color_scheme_css,'embed');
			
			/***********	Basic Menu Start		************/
			
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
			  
			$dataMenu = $top_site_menu_basic;
			
			$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
			
			$data['menu'] =  $top_site_menu_basic;
			
			/***********	Basic Menu End		************/
			$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
	
			$logo_view = $this->Site_Model->check_logo_image($site_id);
			if(isset($logo_view['publish']) && $logo_view['publish'] == "Yes")
			{
				$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
				$this->template->write_view('logo', $temp_name.'/logo', $data);
			}
			
			
			
			
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
	/*            $this->template->write('title', 'Online Shop'); */
			$data['site_id']=$this->site_id;
			
			
			
			$this->template->write('description', 'online product store'); 
			$this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
			$data["site_name"] = '';  
	
	
		   
		   if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}      
			
		   	if(isset($temp_name) && $temp_name != 'intro_template')
			 {
				$this->template->write_view('menu', $temp_name.'/menu', $data);  
			 }
	
			$this->template->add_js('js/validation/jquery.js');    
			$this->template->add_js('js/validation/jquery.validate.js');    
		   // $this->template->add_css('js/fancybox/jquery.fancybox-1.3.4.css'); 
		   // $this->template->add_js($my_js, 'embed'); 
		   
			
			$this->template->write('title', 'Manage Groups'); 
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
			$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
			
			
			
		   
			$this->template->write_view('content','site_groups/front/group_trial_end',$data);
			
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
	
	function add_group()
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
		// echo "<pre>";		print_r($form_values_arr);	die();  
		$data_save = $this->Groups_Model->save_group_field_data($form_values_arr, $this->input->post("group_id") );
		
		
		
		$r = $this->Groups_Model->add_member_to_singel_group($this->customer_id);
		
		
		if($r == 1) // if group joined success
		{
			$msg = "You joined the group Successfully";
			 
			// send notification
			$this->Groups_Model->send_group_notification( $this->customer_id,$this->input->post("group_id") );
			
			
		}
		else
		{
			$msg = "You did not join the group successfully";
		}
		$this->session->set_flashdata('response', $msg);
		redirect("group_managment/new_group");
	}
	
	function unsubsribe($group_id)
	{
		$member_id = $this->customer_id;
		$this->Groups_Model->unsubsribe_group($member_id,$group_id);
		
		redirect("group_managment");
	}
	
	function check_group_payment_status()
	{
		
		$group_id = $this->input->post("group_id");
		$group_id = trim($group_id);
		$q = "SELECT payment_method,id FROM groups WHERE id = '$group_id' ";
		$r = $this->db->query($q);
		if($r->num_rows() == 1)
		{
			$row = $r->row_array();
			$method = $row["payment_method"];
			$data = $method;
		}
		else
		{
			$data = "";
		}
		
		echo $data;
	}
	function  code_exist ($code = '')
    {
       /* echo $code.">>>>>>>>>";
         exit();*/
       // $this->form_validation->set_message('login_not_exist','This %s login Name already exists. Please try another.');
        if($this->Groups_Model->code_check($code))
		{
          	echo "true";
        }
		else
		{
        	echo "false";
        }
    }
	
	function get_group_id_by_code($group_code)
	{
		$group_id = $this->Groups_Model->get_group_id_by_group_Code($group_code);
		if($group_id)
		{
			echo $group_id;
		}
		else
		{
			echo "false";
		}
	}
}
?>