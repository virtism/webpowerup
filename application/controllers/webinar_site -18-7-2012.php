<?php
if(!session_start()){
	session_start();
}
  class Webinar_Site extends CI_Controller{
  
	public $ck_data =  array(); 
	var $site_id;
	var $form_id;
	var $user_id;
	var $temp_name;
	  
	  function __construct()
	  {
		  
		parent::__construct();
		  
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('Template');
		$this->template->set_template('gws');
		$this->load->Model('Webinar_Model');   
		$this->load->model("Menus_Model");  
		$this->load->model("Groups_Model"); 
		$this->load->model('Footer_Model');      
		$this->load->library('my_template_menu');
				$this->load->library('email');  
		
		if(isset($_SESSION['site_id']) && is_numeric($_SESSION['site_id']))
		{
			$this->site_id = $_SESSION['site_id'];	
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
	  
	  function index($site_id,$webinar_id)
	  { 
		
		
		$this->webinar_id  =  $webinar_id;    
		$this->site_id = $site_id;
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
		
		
		
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
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
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		/* echo $_SESSION['user_info']['user_id'];
		 if(isset($_SESSION['user_info']['user_id']))
		 {*/
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id); 
			
			if(count($other_top_navigation)>1) //when shop is not active login links show default
			{
				
				$data['other_top_navigation'] =  $other_top_navigation;    
				
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();
				
				
			}       
		 //}           
		  
		
		  $this->template->write_view('menu', $temp_name.'/menu', $data);  
			$data['forums'] = 'customers';
			
			$Regions = $this->template->regions;
			//print_r($Regions);exit;
			if(isset($Regions['sidebar']))
			{
				$data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);
				$this->template->write_view('sidebar',$temp_name.'/sidebar', $data); 
			}
			else if(isset($Regions['leftbar']))
			{
				$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
				$data['left_menus_type'] = 'site'; 
				$this->template->write_view('leftbar',$temp_name.'/leftbar', $data); 
			}else if(isset($Regions['rightbar'])){   
				$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
				$this->template->write_view('rightbar',$temp_name.'/rightbar', $data);     
			}     
			
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
			$data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
				$this->template->write_view('footer',$temp_name.'/footer', $data);          
			}
			$contact_data= array ();
			
			$data["webinar_id"] = $this->webinar_id;
			$data['form_data'] = $this->Webinar_Model->get_webinar_form_data($this->webinar_id); 
			$data['webinar_default_fields'] = $this->Webinar_Model->webinar_form_fields($this->webinar_id,'default');
			$data['form_fields'] = $this->Webinar_Model->webinar_form_fields($this->webinar_id,'custom');
		
		   //$this->load->view('Registration_Froms_View_User',$data); 
			$this->template->write_view('content','webinar/site_home',$data);
			$this->template->render();  
		 
	 }
	 //Complete
	 function webinar_sent($site_id,$webinar_id)
	 {
	 	$this->webinar_id  =  $webinar_id;    
		$this->site_id = $site_id;
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
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($this->site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
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
		
				
		/* if(isset($_SESSION['user_info']['user_id']))
		 {*/
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id); 
			
			if(count($other_top_navigation)>1) //when shop is not active login links show default
			{
				
				$data['other_top_navigation'] =  $other_top_navigation;    
				
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();
				
			}      
		/* } */          
		  
		 
		  
		  $this->template->write_view('menu', $temp_name.'/menu', $data);  
			$data['forums'] = 'customers';
			$Regions = $this->template->regions;
			if(isset($Regions['sidebar']))
			{
				$data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);
				$this->template->write_view('sidebar',$temp_name.'/sidebar', $data); 
			}
			else if(isset($Regions['leftbar']))
			{
				$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
				$data['left_menus_type'] = 'site'; 
				$this->template->write_view('leftbar',$temp_name.'/leftbar', $data); 
			}else if(isset($Regions['rightbar'])){   
				$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
				$this->template->write_view('rightbar',$temp_name.'/rightbar', $data);     
			}     
			
			$footer_navigation =  $this->Menus_Model->footer_navigation($this->site_id);
			$data['footer_navigation'] =  $footer_navigation;
			if(isset($Regions['footer']))
			{
				$this->template->write_view('footer',$temp_name.'/footer', $data);          
			}
			$contact_data= array ();
			
			$data["webinar_id"] = $this->webinar_id;
			$data['form_data'] = $this->Webinar_Model->get_webinar_form_data($this->webinar_id); 
			$data['webinar_default_fields'] = $this->Webinar_Model->webinar_form_fields($this->webinar_id,'default');
			$data['form_fields'] = $this->Webinar_Model->webinar_form_fields($this->webinar_id,'custom');
		 
		   //$this->load->view('Registration_Froms_View_User',$data); 
			$this->template->write_view('content','webinar/webinar_sent',$data);
			$this->template->render();
		
		
	 }
	 
	 function submit_webinar($webinar_id)
	 {
		
	/*echo "<pre>";
	print_r($_POST);
	exit();
*/
		
		$webinar_info = $this->Webinar_Model->get_webinar_data($webinar_id);
		//print_r($webinar_info);
		
	//exit;
		
		if($webinar_info[0]["email_to"] != "")
		{
			$email_to = $webinar_info[0]["email_to"] ;
		}
		else 
		{
			$email_to = "junaidkhalil@virtism.com" ;
		}
		
		$total = count($this->input->post('field'));
		// echo $total.":: ToTal >>>>>>>>>>>>";  exit();
		$items = $this->input->post('field');
		$form_values_arr = array ();
		$msg_bdy = ''; 
		$i=0;  
		foreach($items as $key => $item)
		{   //  is_array($items)
		$form_values_arr[$i]['value'] = $item['value'];
		$form_values_arr[$i]['name'] = $item['name'];
		$msg_bdy .=  "\n".$form_values_arr[$i]['name'].' : '.$form_values_arr[$i]['value']."\n";
		$i++;
		// $form_data = $this->Registration_Forms_Model->form_fields_value_save($field,$id );    
		} 
		//echo '<pre>'; print_r($form_values_arr); exit();
		$message = '';
		$message .=  "This email send via Global Online Website Solutions  \n\n Please Dont Reply it  \n\n ";
		$message .=  "# ------------------------ ";
		$message .=  "\n".$msg_bdy."\n";
		$message .=  "# ---------------------------";
		$message .= "\n\nThanks for using Our Webinar\n ";
		$message .= 'http://www.webpowerup.com/';
		//echo   $message;
		// exit;  
		// #### send mail #### //
		
		
		$config['mailtype'] = 'text';
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		
		$this->email->initialize($config);
		//$send = $this->email->send();
		$this->email->from($_REQUEST['field'][2]['value'], 'Webinar Mail');
		$this->email->subject('Webinar Mail');
		$this->email->message($message);
		
		
		
		$this->email->to($email_to);
		$send = $this->email->send();
		//$send = $this->email->send();
		if($send)
		{
			redirect("webinar_site/webinar_sent/".$this->site_id."/".$webinar_id);
		}
		else
		{
			//echo "Email Failed Please try Some Later.";
			$this->index($this->site_id,$webinar_id);
		}
		//exit;
	 }
	 
	 function user_webinar()
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
			 $site_user_id = 0 ;        
			 if(isset($_SESSION['user_info']['user_id']))
			 {
				$site_user_id = $_SESSION['user_info']['user_id'];
			 }
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
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
			$data['view_all_webinar_records'] =  $this->Webinar_Model->get_user_webinar($this->site_id, $_SESSION['login_info']['customer_id']);    		   
			$this->template->write_view('content','webinar/webinar_listing',$data);
			
			
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