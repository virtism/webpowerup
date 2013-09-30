<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 if(!session_start()){	session_start(); }
class orders extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->helper('url');
		$this->load->helper('custom_helper');
        $this->load->library('form_validation');
        $this->load->library('Template');
        $this->template->set_template('gws');
        $this->load->model('orders_model');
        $this->load->model('Categories_model');
        $this->load->model('product_model');
   		$this->load->model("Groups_Model");       
		$this->load->library('my_template_menu');
		$this->load->library('email');
		$this->load->library('session');
        $this->load->helper('security');
		$this->site_id = $_SESSION['site_id'];
 
    }
 
 
   function index(){
 		
		is_login();
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Orders' );
		
        $data['title'] = "Manage Orders";
        $data['products'] = $this->product_model->getAllProducts();
        $data['categories'] = $this->Categories_model->getCategoriesDropDown();
        $data['orders'] = $this->orders_model->getAllOrders($this->site_id);
        $data['module'] = 'orders';
        
        //$this->load->view('ecommerce/Ecommerce_Category_Manage',$data);
        $this->template->write_view('content','ecommerce/orders_home',$data);
        $this->template->render();
 
    }
 
    function details($id){
 
        $data['title'] = "Order Details";

        //$data['products'] = $this->product_model->getAllProducts();
        //$data['categories'] = $this->Categories_model->getCategoriesDropDown();
        $data['orderdetails'] = $this->orders_model->getOrderDetails($id);

        $data['module'] = 'orders';
        //$this->load->view($this->_container,$data);
        $this->template->write_view('content','ecommerce/orders_details',$data);
        $this->template->render();
    }
 
    function paid($id){
        $this->orders_model->setpayment($id);
        
        redirect('orders/');
    }
 
    function delivered($id){
        $this->orders_model->setdelivery($id);

        redirect('orders/');
    }  
	
	 function pending($id){
        $this->orders_model->setpending($id);

        redirect('orders/');
    }  
 
    function deleteitem($order_id, $order_item_id){
        $order_id = $this->uri->segment(4);
        $order_item_id = $this->uri->segment(5);
 
        if (count($this->orders_model->findsiblings($order_id)) < 2){
            $this->orders_model->deleteOrder($order_id);
            $this->orders_model->deleteOrderItem($order_item_id);
            
            redirect('orders/index','refresh');
        }else{
            $this->orders_model->deleteOrderItem($order_item_id);
            
            redirect('orders/details/'.$order_id,'refresh');
        }
    }
	
	function order_site_list()
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
			
			//get & set site template
		
			$temp_name =  $this->my_template_menu->set_get_template($_SESSION['site_id']); 
			$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($_SESSION['site_id']);
			$this->template->add_css($color_scheme_css,'embed');
			
			/***********	Basic Menu Start		************/
			if(!isset($is_seo_enabled)){ $is_seo_enabled = 1;  }
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($_SESSION['site_id'],$is_seo_enabled);
			  
			$dataMenu = $top_site_menu_basic;
			
			$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
			
			$data['menu'] =  $top_site_menu_basic;
			
			/***********	Basic Menu End		************/
		
			
			
			 $site_user_id = 0 ;        
			 if(isset($_SESSION['user_info']['user_id']))
			 {
				$site_user_id = $_SESSION['user_info']['user_id'];
			 }
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$site_user_id);  
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
			$data['view_all_order_history'] =  $this->orders_model->get_user_orders($this->site_id, $_SESSION['login_info']['customer_id']);    		   
			$this->template->write_view('content','ecommerce/order_site_list',$data);
			
			
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
}//end class
?>