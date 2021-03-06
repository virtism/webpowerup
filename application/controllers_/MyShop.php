<?php
if(!session_start()){
	session_start(); }
	class MyShop extends CI_Controller { // Our Cart class extends the Controller class
	
		 var $site_id;
		 var $user_id;
		 var $temp_name;
		   
		function MyShop()
		{
			parent::__construct();  // We define the the Controller class is the parent.    
			$this->load->model('cart_model'); // Load our cart model for our entire class
			$this->load->model('categories_model');  
			$this->load->model('shop_model');  
			$this->load->model('product_model');
			$this->load->model('Promotional_Boxes_Model');  
			$this->load->model('Footer_Model'); 
			$this->load->model("Groups_Model");
			$this->load->model("Customers_Model");				
			$this->load->model("Site_Model");
			$this->load->model('Shipping_model');
			$this->load->model("Video_Gallery_Model");
			$this->load->library('cart');
			$this->load->library('template');
			$this->load->library('my_template_menu');            
			$this->load->library('pagination');
			$this->load->library('Paypal_Lib');			
			$this->load->library('session');
			$this->load->helper('url');      
			$this->load->helper('html'); 
		   // $this->load->library('table'); 
			
			if(isset($_SESSION["site_id"]) && is_numeric($_SESSION["site_id"]))
			{
				
				$this->site_id = $_SESSION['site_id'];
			}
			else if(isset($_SESSION['site_id_custom']) && is_numeric($_SESSION["site_id_custom"]))
			{
				
				$this->site_id = $_SESSION['site_id_custom'];
			}      
			else
			{
				
				$this->site_id = $this->uri->segment(3);
			}
			
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
	function is_session_exist()
	 {
	  
	  //echo "ssss"; echo $this->site_id; exit;
	  if(isset ($this->site_id) && !empty($this->site_id)){
		   return true;
	  }else
	  {
		 
		 // redirect('MyAccount/login'); 
		 redirect("http://".$_SERVER['HTTP_HOST']);
	  }
	}
		function index($site_id = 0, $cat_id=0, $offset=NULL )
		{
			//echo $site_id;exit;
			// print_r($_SESSION);  exit();
			if(isset($site_id) && $site_id!=0)
			{
				$_SESSION['site_id'] = $site_id;
				$this->site_id = $site_id;
			}
			$data["admindetail"] = $this->Site_Model->getSiteAdmindetail($site_id);	
			if($data['admindetail'] != 0)
			{
				$_SESSION['user_info']['user_id'] = $data["admindetail"]['user_id'];
				$_SESSION['user_info']['user_login'] = $data["admindetail"]['user_login'];
			}	
			$this->is_session_exist();
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
			$this->template->add_js('js/arial.js');
			$this->template->add_js('js/radius.js');
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
			
			
			
			
			$this->template->write('description', 'Online store for buy and get '); 
			$this->template->write('keywords', 'online purchase, online get, '); 
			//$this->template->write('header', $header);
			//$this->template->write('background', $background);
			   
			   
			// menu requiired variable 
		
		$is_seo_enabled = $this->config->item('seo_url');
		
		
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
		$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
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
		$data['other_top_navigation'] =  $other_top_navigation;    
		//echo "<pre>"; print_r($data['other_top_navigation']);exit;
			  
			 
			  
			  $this->template->write_view('menu', $this->temp_name.'/menu', $data); 
				
				// Retrieve an array with all products
				//--------------------- paging variables ----------------------------//
					$store_settings = $this->shop_model->get_store_settings($this->site_id);
					$total = $this->product_model->count_posts($cat_id);
					$config['base_url'] = base_url().index_page().'MyShop/index/'.$cat_id.'/';
				   // $config['total_rows'] = $this->db->get('tblname')->num_rows(); 
					$config['total_rows'] = intval($total);
					$config['per_page'] = intval($store_settings['product_per_page']);
					$config['num_links'] = intval($store_settings['link_per_page']);  
				 //  print_r($config['per_page']); echo '>>>>>>>>>>>'; exit();
				   // $config['per_page'] = 5;
				   // $config['num_links'] = 20;  
				   
				   
					$config['full_tag_open'] = '<div id="pagination" style="float:right; margin:10px 0px 20px 0px;">';
					$config['full_tag_close'] = '</div>';
					
					$this->pagination->initialize($config);
					
				 //   $data['records'] = $this->db->get('data', $config['per_page'], $this->uri->segment(3)); \
				 $data['products'] = $this->product_model->getProductsByCategory(intval($cat_id), $config['per_page'], $offset);
				 
				/* echo "<pre>";
				 print_r($data['products']);exit;*/
				//--------------------- /paging variables ----------------------------//
				
				
			   if($cat_id != 0 )
			   {  
					$site_name =  $this->categories_model->getSiteNameById($this->site_id);
					$cat_data =  $this->categories_model->getCategory(intval($cat_id),$this->site_id);
					
					$cat_name = str_replace(' ','_',strtolower(trim($cat_data['cat_name'])));
					$cat_image_name = trim($cat_data['image']);
					
					$data["img_path_full"] = $this->site_id.'/'.$cat_name.'/full_size';  
					$data["img_path_thumb"] = $this->site_id.'/'.$cat_name.'/thumb';
			   }
			   // $this->template->write_view('content','cart/product_grid',$data);
				if(isset($cat_data['cat_name'])){
					$data['cat_title'] = $cat_data['cat_name'];
					$data["category_image"] = $this->site_id.'/'.$cat_name.'/'.$cat_image_name;
				}
				$data['view'] = $store_settings['product_view'];
				if($cat_id== 0){
				$data['ishome'] = 'yes';
				}else{
					$data['ishome'] = 'no';
				}
			/*	
				echo "<pre>";
				print_r($data);
				exit;
							*/
				
				if($temp_name == 'vantage')
				{			
					$this->template->write_view('content','cart/products',$data);
				}
				else
				{
					$this->template->write_view('content',$this->temp_name.'/cart/products',$data);
				}
				
				
				$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
				//echo '<pre>'; print_r($all_categories); exit();
				$data['left_menus'] = $all_categories;  
				$data['left_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($this->site_id);
				$data['right_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($this->site_id);
				//echo '<pre>'; print_r($data['right_menus_Pbox'] ); exit();
				$data['left_menus_type'] = 'myshop';
				$Regions = $this->template->regions;
				$this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
				
				//$data['right_menus'] = '';
				$this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);
				$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
				$data['footer_navigation'] =  $footer_navigation;				
				if(isset($Regions['footer']))
				{
				  $this->template->write_view('footer', $this->temp_name.'/footer', $data);          
				} 
				
				$this->template->render();
		}
		
	function detail($pd_id=0)
	{
		
		$data["admindetail"] = $this->Site_Model->getSiteAdmindetail($site_id);	
		if($data['admindetail'] != 0)
		{
			$_SESSION['user_info']['user_id'] = $data["admindetail"]['user_id'];
			$_SESSION['user_info']['user_login'] = $data["admindetail"]['user_login'];
		}	
		$this->is_session_exist();
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
		$this->template->add_js('js/arial.js');
		$this->template->add_js('js/radius.js');
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
		
		
		
		$this->template->write('description', 'Product detail'); 
		$this->template->write('keywords', 'products details'); 
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
		 $data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
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
		$data['other_top_navigation'] =  $other_top_navigation;    
				   
		  
		 
		  
		  $this->template->write_view('menu', $this->temp_name.'/menu', $data); 
			
		   $data['product'] = $this->product_model->getProduct(intval($pd_id)); // Retrieve an array with all products
			$data['attributes'] = $this->product_model->getProduct_attribute(intval($pd_id)); // Retrieve an array with  products Attribute
		/*	echo "<pre>";
		print_r($data['attributes']);
		exit();*/
			$site_name =  $this->categories_model->getSiteNameById($this->site_id);
			$cat_data =  $this->categories_model->getCategoryNamebyProductID(intval($pd_id),$this->site_id); 
			$cat_name = str_replace(' ','_',strtolower(trim($cat_data['cat_name'])));
			$data["img_path_full"] = $this->site_id.'/'.$cat_name.'/full_size';  
			$data["img_path_thumb"] = $this->site_id.'/'.$cat_name.'/thumb';
			
			if($temp_name == 'vantage')
			{			
				$this->template->write_view('content','cart/products_details',$data);
			}
			else
			{
				$this->template->write_view('content',$this->temp_name.'/cart/products_details',$data);
			}
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
			 
			
			$data['left_menus'] = $all_categories; 
			$data['left_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($this->site_id); 
			$data['left_menus_type'] = 'myshop';  
			$Regions = $this->template->regions;
			//echo '<pre>'; print_r($data); exit();
			$this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
			$data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			  $this->template->write_view('footer', $temp_name.'/footer', $data);          
			}
		   //  $data['right_menus'] = '';
		   // $this->template->write_view('rightbar', $temp_name.'/rightbar', $data);             
			$this->template->render();
		}        
	   function mycart()
		{
		
		$this->is_session_exist();
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
		
		
		$this->template->write('description', 'Mycart'); 
		$this->template->write('keywords', 'Mycart'); 
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
		 $data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
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
		$data['other_top_navigation'] =  $other_top_navigation;               
			
			$this->template->write_view('menu', $this->temp_name.'/menu', $data); 
			if(isset($_SESSION['login_info']['customer_id']) && !empty($_SESSION['login_info']['customer_id']))
			{
				$customer_group_id = $this->Customers_Model->getCustomerGroupID($_SESSION['login_info']['customer_id']);
				if(isset($customer_group_id))
				{
					$data['customer_group_data'] = $this->Groups_Model->get_group_by_id($customer_group_id);
					/*echo "<pre>";
					print_r($data['customer_group_data']);
					exit;*/
				}				 
			}	
			
			// Get store settings 3-19-2012
			  $data['countries'] = $this->Shipping_model->get_country();
			  $data['states'] = $this->Shipping_model->get_states();
			$data['store_info'] = $this->shop_model->get_store_settings($this->site_id);
			//print_r($data['store_info']);exit;
			
			$this->template->write_view('content','cart/cart',$data);
			/*if($temp_name == 'vantage')
			{		
				$this->template->write_view('content','cart/cart',$data);
			}
			else
			{
				$this->template->write_view('content',$temp_name.'/cart/cart',$data);
			}		*/	
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
		   //echo '<pre>'; print_r($all_categories); exit();
			
			$data['left_menus'] = $all_categories;  
			$data['left_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($this->site_id);
			$data['left_menus_type'] = 'myshop';  
			/*echo "<pre>";
			print_r($data);
			exit;*/
			//echo $_SESSION['login_info']['customer_id'];
			$Regions = $this->template->regions;
			$this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 			
		  //  $data['right_menus'] = '';
		   // $this->template->write_view('rightbar', $temp_name.'/rightbar', $data); 
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
			$data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
			  $this->template->write_view('footer', $temp_name.'/footer', $data);          
			}
			$this->template->render();
		}        
		
		function add_cart_item(){
			
			if($this->cart_model->validate_add_cart_item() == TRUE){
				// Check if user has javascript enabled
				if($this->input->post('ajax') != '1'){
					redirect('MyShop/mycart'); // If javascript is not enabled, reload the page with new data
				}else{
					  echo 'true'; // If javascript is enabled, return true, so the cart gets updated
				}
			}
			
		}
			
		function update_cart(){
			
			$this->cart_model->validate_update_cart();
			redirect('MyShop/mycart');
		}
		
													 
		function show_cart(){
			$this->load->view('cart/cart');
		}
		
		function get_time_difference( $start, $end )
		{
			
			$uts['start']      =    strtotime( $start );
			$uts['end']        =    strtotime( $end );
			if( $uts['start']!=-1 && $uts['end']!=-1 )
			{
				if( $uts['end'] >= $uts['start'] )
				{
					$diff = $uts['end'] - $uts['start'];
					if( $days=intval((floor($diff/86400))) )
						$diff = $diff % 86400;
					if( $hours=intval((floor($diff/3600))) )
						$diff = $diff % 3600;
					if( $minutes=intval((floor($diff/60))) )
						$diff = $diff % 60;
					$diff    =    intval( $diff);            
					return( array('days'=>$days,'hours'=>$hours, 'mint'=>$minutes, 'sec'=>$diff) );
				}
				else
				{
					echo "Check Out date/time is Invalid <br> User must have forgot to check Out:&nbsp;&nbsp;";
				}
			  
			}
			else
			{
				trigger_error( "Invalid date/time data detected", E_USER_WARNING );
			}
			return( false );
	   }
	
		function empty_cart(){
			
			
		
			/*echo "***************************";*/
			/*print_r($_POST);
			echo "---------------------";
			$this->paypal_lib->ipn_data;
			exit;*/
			/*echo "<pre>";
			phpinfo();
			print_r($this->paypal_lib->ipn_data);exit;*/
			
			if ($this->paypal_lib->validate_ipn()) 
				{
					// Do something with the data
			
			
					$product_array = $this->paypal_lib->ipn_data;
					
					
					$data = array();
					if(isset($product_array) && !empty($product_array))
					{
						$product_ids = explode(',',$product_array['custom']);
					
						//echo "---------------------------";
							//if digital product
						if(isset($product_ids) && !empty($product_ids))
						{
							
							for($i = 0; $i<count($product_ids); $i++)
							{
								$digital_data = $this->product_model->getProduct_digital($product_ids[$i]);
			
								$product_digital_ids[] = $product_ids[$i];
								if(isset($digital_data['products_attributes_url']) && !empty($digital_data['products_attributes_url']))
								{
									$_SESSION['products_attributes_url'][] = $digital_data['products_attributes_url'];		
								}
								else
								{
									//$product_download_url = base_url().'media/ecommerce/downloadproducts/'.$digital_data['products_attributes_filename'];
									
									if(isset($digital_data['products_attributes_filename']) && !empty($digital_data['products_attributes_filename']))
									{
										//$_SESSION['products_attributes_url'][] = base_url().'media/ecommerce/downloadproducts/'.$digital_data['products_attributes_filename'];
										$_SESSION['products_attributes_url'][] = '1';
									}
									else
									{
										$_SESSION['products_attributes_url'][] = 'Download Limit Expires';
									}
								}							
							}
							
							$sendmail = $this->download_product_email($product_digital_ids, $this->site_id, $_SESSION['login_info']['customer_id']);
						}
						
					}
						
				}
				else if(isset($_REQUEST['receipt_id']) || isset($_REQUEST['payer_status']))// ssl is not working so temprary code for testing
				{
			
						$product_ids = explode(',',$_REQUEST['custom']);
						if(isset($product_ids) && !empty($product_ids))
						{
							for($i = 0; $i<count($product_ids); $i++)
							{
								$digital_data = $this->product_model->getProduct_digital($product_ids[$i]);
								$product_digital_ids[] = $product_ids[$i];
								$now_date = date("Y-m-d");
								$expire = $digital_data['products_attributes_expire'];
								$days = $this->get_time_difference($now_date,$expire);
								$day = $days['days'];
							
								if(isset($digital_data['products_attributes_url']) && !empty($digital_data['products_attributes_url']))
								{
									$_SESSION['products_attributes_url'][] = $digital_data['products_attributes_url'];		
								}
								else
								{
									//$product_download_url = base_url().'media/ecommerce/downloadproducts/'.$digital_data['products_attributes_filename'];
									
									if(isset($digital_data['products_attributes_filename']) && !empty($digital_data['products_attributes_filename']))
									{
										//$_SESSION['products_attributes_url'][] = base_url().'media/ecommerce/downloadproducts/'.$digital_data['products_attributes_filename'];
										$_SESSION['products_attributes_url'][] = 1;
									}
									else
									{
										$_SESSION['products_attributes_url'][] = 'Download Limit Expires';
									}
								}							
							}
							
						$sendmail = $this->download_product_email($product_digital_ids, $this->site_id, $_SESSION['login_info']['customer_id']);
						}	
						
					
						$data = array();
						$txnid = '';
						$discount = '';
						$itemid = '';
						$site_id_order = '';
						$customer_id_order = '';
						if(isset($this->site_id) && !empty($this->site_id))
						{
							$site_id_order = $this->site_id;
						}
						if(isset($_SESSION['login_info']['customer_id']) && !empty($_SESSION['login_info']['customer_id']))
						{
							$customer_id_order = $_SESSION['login_info']['customer_id'];
						}
						if(isset($_REQUEST['txnid']))
						{
							$txnid = $_REQUEST['txnid'];							
							
						}
						if(isset($_REQUEST['discount']))
						{
							$discount = $_REQUEST['discount'];
						}
						if(isset($_REQUEST['txnid']))
						{
							$itemid = $_REQUEST['txnid'];
						}
						$array = array( 
						'site_id' => $site_id_order, 
						'customer_id' => $customer_id_order,
						'txnid' => $txnid, 						  
						'payment_gross' => $_REQUEST['payment_gross'], 
						'discount' => $discount, 
						'payment_status' => $_REQUEST['payment_status'], 
						'itemid' => $itemid, 
						'payment_date' => $_REQUEST['payment_date'], 
						'payer_email' => $_REQUEST['payer_email'], 
						'payer_id' => $_REQUEST['payer_id'], 
						'payer_status' => $_REQUEST['payer_status'], 
						'tax' => $_REQUEST['tax'], 
						'receiver_email' => $_REQUEST['receiver_email'], 
						'receipt_id' => $_REQUEST['receipt_id'],
						'customer_name' => $_REQUEST['first_name'].' '.$_REQUEST['last_name'],
						'address_city' => $_REQUEST['address_city'],
						'download_link' => implode(',',$product_digital_ids),
						
						);
					
						$insert_order = $this->shop_model->save_order_record($array);			
									
				}
				   
				//paypal_errors();
				//exit;
			$this->cart->destroy();
		
			//From PayPal
			if(isset($_POST["txn_id"]))
			{
					$data = array();
						$txnid = '';
						$discount = '';
						$itemid = '';
						$site_id_order = '';
						$customer_id_order = '';
						if(isset($_REQUEST['receipt_id']))
						{
							$receipt_id = $_REQUEST['receipt_id'];
						}
						else
						{
							$receipt_id = $_REQUEST['txn_id'];
						}
						if(isset($this->site_id) && !empty($this->site_id))
						{
							$site_id_order = $this->site_id;
						}
						if(isset($_SESSION['login_info']['customer_id']) && !empty($_SESSION['login_info']['customer_id']))
						{
							$customer_id_order = $_SESSION['login_info']['customer_id'];
						}
						if(isset($_REQUEST['txnid']))
						{
							$txnid = $_REQUEST['txnid'];							
							
						}
						if(isset($_REQUEST['discount']))
						{
							$discount = $_REQUEST['discount'];
						}
						if(isset($_REQUEST['txnid']))
						{
							$itemid = $_REQUEST['txnid'];
						}
						$array = array( 
						'site_id' => $site_id_order, 
						'customer_id' => $customer_id_order,
						'txnid' => $txnid, 						  
						'payment_gross' => $_REQUEST['payment_gross'], 
						'discount' => $discount, 
						'payment_status' => $_REQUEST['payment_status'], 
						'itemid' => $itemid, 
						'payment_date' => $_REQUEST['payment_date'], 
						'payer_email' => $_REQUEST['payer_email'], 
						'payer_id' => $_REQUEST['payer_id'], 
						'payer_status' => $_REQUEST['payer_status'], 
						'tax' => $_REQUEST['tax'], 
						'receiver_email' => $_REQUEST['receiver_email'], 
						'receipt_id' => $receipt_id,
						'txnid' => $_REQUEST['txn_id'],
						'customer_name' => $_REQUEST['first_name'].' '.$_REQUEST['last_name'],
						'address_city' => $_REQUEST['address_city'],
						'download_link' => implode(',',$product_digital_ids),
						
						);
					
						$insert_order = $this->shop_model->save_order_record($array);
					
				redirect('MyShop/payment_success/');
			}
			
			if(isset($this->site_id) && $this->site_id!='')
			{
				redirect('MyShop/index/'.$this->site_id);
			}
			else
			{
				redirect('MyShop');
			}
	}
	
	
	function download_product_email($product_digital_ids, $site_id, $customer_id)
		{
				$customer_email = $this->Customers_Model->getCustomer($customer_id);
				/*echo "<pre>";
				print_r($product_digital_ids);
				print_r($customer_email['customer_email']);				
				exit;*/
				  
				$subject = 'Product Link';
				$mess = 'Thank you for purchasing the product if you find any problem or do not get any link to download please contact with admin.<br/><br/>Please click the link below to download the product';
				$this->load->library('email');
				$config['mailtype'] = 'html';
				$config['protocol'] = 'sendmail';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				
				foreach($product_digital_ids as $product_id)
				{
					$body = $body."<br/><br/><a href='".base_url()."MyShop/download/".($product_id*2)."/".($customer_id*2)."/".($site_id*2)."'>LINK</a>";				
				}
					$body = $mess.$body;
					//$body .= $id_messg;
					$this->email->from('download@webpowerup.com', 'WebpowerUp');
					$this->email->subject($subject);
					$this->email->message($body);	
					$this->email->to($customer_email['customer_email']);
					$send = $this->email->send();
					//echo $this->email->print_debugger();exit;
					//echo $mail['customer_email'];
					//$body = '';	
					return ($send ? true : false);
			
		}
	
	
	function download($product_id, $customer_id, $site_id)
	{
			$product_id 	= ($product_id/2);
			$customer_id 	= ($customer_id/2);
			$site_id 		= ($site_id/2);
			$user_info 		= $this->Video_Gallery_Model->get_user_of_site($site_id);
			$product_info 	=  $this->product_model->getProduct($product_id);
			$digital_product_info =  $this->product_model->getProduct_digital($product_id);
			$category_info =  $this->categories_model->getCategoryNamebyProductID($product_id, $site_id);
			$cat_name = str_replace(' ','_',strtolower(trim($category_info['cat_name'])));
			$get_donwload_record = $this->db->query("SELECT * FROM  `ec_customers_download_record` WHERE product_id =".$product_id. " AND customer_id = ".$customer_id);
			$is_record = $get_donwload_record->result_array();
			
			if(count($is_record)==0)
			{
			
				$get_donwload_record_insert = $this->db->query("INSERT INTO `ec_customers_download_record`  (product_id, customer_id, site_id, download_count) VALUES (".$product_id.",".$customer_id.",".$site_id.",0)");
				
				$get_donwload_record_select = $this->db->query("SELECT * FROM  `ec_customers_download_record` WHERE product_id =".$product_id. " AND customer_id = ".$customer_id);
				$is_record = $get_donwload_record_select->result_array();
				
			}
			//echo "<pre>";print_r($get_donwload_record);exit;
			
			//$is_record = $get_donwload_record->result_array();
			//echo $is_record[0]['download_count'];
			//exit;
			//echo $digital_product_info['products_attributes_max_download'].'----------'.$is_record[0]['download_count']."<br/>";
			if($digital_product_info['products_attributes_max_download']>$is_record[0]['download_count'])
			{
				
				$this->load->helper('download');
				
				if(isset($digital_product_info['products_attributes_url']) && !empty($digital_product_info['products_attributes_url']))
				{
					$donwload_path = $digital_product_info['products_attributes_url'];
					echo "<a href=".$donwload_path." title='donwload_link' >Please click here for download.</a>";
				}
				else
				{
					$donwload_path = base_url().'/media/ckeditor_uploads/'.$user_info[0]['user_login'].'_'.$user_info[0]['user_id'].'/ecommerce/'.$site_id.'/'.$cat_name.'/downloadproducts/'.$digital_product_info['products_attributes_filename'];
					
				}
				//exit;
				$data = file_get_contents($donwload_path); // Read the file's contents
				$name = $digital_product_info['products_attributes_filename'];
				$get_donwload_record = $this->db->query("UPDATE ec_customers_download_record SET `download_count` = ".($is_record[0]['download_count']+1)." WHERE product_id =".$product_id);
				force_download($name, $data);
			}
			else
			{
				echo "Product link is expired or you have reached at maximum download";
			}
			
	}
	
	//PayPall CallBack Function
	function payment_success()
	{
		$this->is_session_exist();
		$data = array ();
		$rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
		$rowHomepage = $rsltHomepage->row_array();
		if(isset($_SESSION['products_attributes_url'])){
		$data['product_download_url'] = $_SESSION['products_attributes_url'];
		$_SESSION['products_attributes_url'] = '';
		}
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
		$this->template->add_js('js/arial.js');
		$this->template->add_js('js/radius.js');
		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
		
		$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
		$this->template->add_css('js/nivo-slider/nivo-slider.css'); 
		
		//exit;
		//print_r($arrayRegions['header']);exit;
		//$this->template->set_template('vantage');
		
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $this->site_id; 
		if(!isset($site_id))
		{
			$site_id = $this->site_id; 
		
		}
		//$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$logo_view = $this->Site_Model->check_logo_image($site_id);
		
		if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
		{
		  $this->template->write_view('logo', $temp_name.'/logo', $data);
		}
		
		$this->template->write('description', 'Product detail'); 
		$this->template->write('keywords', 'products details'); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		   
		   
		
		//get & set site template
		
		$temp_name =  $this->my_template_menu->set_get_template($this->site_id);
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
		$data['other_top_navigation'] =  $other_top_navigation;    
		
		
		 
			$this->template->write_view('menu', $this->temp_name.'/menu', $data); 
			$this->template->write_view('content','cart/payment_success',$data);
			$all_categories = $this->categories_model->getAllCategories_shop($this->site_id);
			//echo '<pre>'; print_r($all_categories); exit();
		
			$data['left_menus'] = $all_categories; 
			$data['left_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($this->site_id); 
			$data['left_menus_type'] = 'myshop';  
			$Regions = $this->template->regions;		
			$this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data);
			
			//  $data['right_menus'] = '';
			// $this->template->write_view('rightbar', $temp_name.'/rightbar', $data);             
			$this->template->render();
		} 
		
		
		 
		
	 function ajax_call_states()
	  {
		
			$country_id = $_POST['country_id'];
			$country_id = str_replace("-"," ",$country_id);
			$states = $this->shop_model->getstates_by_country_id($country_id);
	
			if(empty($states))
			{
			?>
				<input id="state" name="state"/>
			<?
			}
			else
			{
				?>
				<select id="state" name="state" style="opacity: 1;" onChange="get_ajax_shipping_rates();">
					<? foreach($states as $state) 
						{
							echo "<option value=".$state['zone_name'].">".$state['zone_name']."</option>";
						}
					?>													
				</select>	
				
				<?
			}
	  }
	  
	  function ajax_get_attrib_price()
	  {
		  $attrib_id = $_POST['attrib_id'];
		  $price = $this->cart_model->get_attribute_price($attrib_id);
		 // echo $price[0]['option_status'];
		//  echo $price[0]['option_price'];
		  echo json_encode($price[0]);
		/*  echo "<pre>";
		  print_r($price);
		  exit();*/
	  }
	 function ajax_call_shipping_rates()
	  {
		
			$country_id = $_POST['country_id'];
			$country_id = str_replace("-"," ",$country_id);
			
			$state_id     = $_POST['state_id'];
			$state_id = str_replace("-"," ",$state_id);
			
			$total_weight = $_POST['total_weight'];
			
			/*echo $country_id."  ".$state_id."  ".$total_weight ;
			exit();*/
			
			$rate = $this->cart_model->get_rates_by_country_id($country_id,$state_id,$total_weight);
			echo $rate[0]['rate'];
			
		/*	if(empty($states))
			{
			?>
				<input id="state" name="state"/>
			<?
			}
			else
			{
				?>
				<select id="state" name="state" style="opacity: 1;">
					<? foreach($states as $state) 
						{
							echo "<option value=".$state['zone_code'].">".$state['zone_name']."</option>";
						}
					?>													
				</select>	
				
				<?
			}*/
	  }
	
 }
/* End of file cart.php */
/* Location: ./application/controllers/cart.php */
?>