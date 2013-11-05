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
		$this->load->model('customers_model');
		$this->load->model('Groups_Model');
		$this->load->model('cart_model'); // Load our cart model for our entire class
		$this->load->model('shop_model');  
		$this->load->model('Room_Model'); 
		$this->load->Model('Webinar_Model');
		$this->load->Model('Invoice_Model'); 
		$this->load->model('Footer_Model');      
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
			//echo "<pre>";	print_r($data);		die();
			
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
			
			$data['allGroups'] = $this->Groups_Model->get_all_groups_of_member($this->customer_id); 
		   
			$this->template->write_view('content','ecommerce/groups',$data);
			
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
		   
			
			$this->template->write('title', 'Edit Groups'); 
			$data['module'] = 'MyAccount';
			$data['membership'] = $this->Groups_Model->dropdown_site_gropus(); 
			$data['address'] = $this->customers_model->getAllAddress($this->site_id, $this->customer_id); 
			$data['customer'] = $this->customers_model->getCustomer($this->customer_id);     
			
			//$group = array();
			$group = $this->Groups_Model->get_group_by_id( $this->uri->segment(3, 0) );
			$data['group'] = $group[0];
			
			$data['upgradableGroups'] = $this->Groups_Model->get_upgradable_groups( $this->uri->segment(3, 0) ); 
			
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
		
		
		$data['groups'] = $this->Groups_Model->get_all_unjoined_groups($this->site_id,$this->customer_id); 
		
		$this->template->write_view('content','ecommerce/group_new',$data);
		
		
		
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
	
	function add_group()
	{
		$r = $this->Groups_Model->add_member_to_singel_group($this->customer_id);
		if($r == 1)
		{
			$msg = "You joined the group Successfully";
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
	
}

?>