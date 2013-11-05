<?php
if(!session_start()){
	session_start(); }
class Site_preview extends CI_Controller
{
	function Site_Preview()
	{
		parent::__construct();
		$this->load->model("Menus_Model");
		$this->load->model("Pages_Model");
		$this->load->model("Site_Model");
		$this->load->model("usersmodel");
		$this->load->model("Slideshow_Model"); 
		$this->load->model('Footer_Model'); 
		$this->load->model('customers_model');
		$this->load->model('Promotional_Boxes_Model');
		$this->load->model('Contact_Management_Model');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->library('form_validation');       
		$this->load->library('template');
		$this->load->library('my_template_menu');
		$this->load->helper('url');   
		$this->load->helper('html'); 
		
	  // $uri_segments =  parse_str($_SERVER['QUERY_STRING'],$_GET);
	  // $uri_segments =  uri_string();
	  // $pieces = explode("/", $uri_segments);
	   
	  //$_SESSION['site_id']= end($pieces);
	  
	//  print_r($_SESSION);   exit();
	//   echo $uri_segments.'>>>>>>>>>>';   exit();
	}
	
	//Used to show Site's Preview(homepage)
	function site($site_id)
	{
		//echo "<pre>";
		//echo $_SESSION['user_info']['user_id'];
		//print_r($_SESSION['user_info']);
		//exit();
		$footer_content = '';
		$_SESSION['site_id'] = $site_id;
		$_SESSION['site_id_custom'] = $site_id;
		$site_user_id = 0 ;
		 if(isset($_SESSION['user_info']['user_id']))
		 {
			$site_user_id = $_SESSION['user_info']['user_id'];
		 }
		 
		
		$rsltHomepage = $this->Site_Model->getHomepage($site_id);
		$footer_content = $this->Footer_Model->get_footer_content($site_id);
		
		$rowHomepage = $rsltHomepage->row_array();
		
		$data["mode"] = '';
		$data["site_id"] = $rowHomepage["site_id"];
		$data["page_id"] = $rowHomepage["page_id"];
		if(isset($footer_content)&&!empty($footer_content)){
		$data["footer_content"] = $footer_content["content"];
		}
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
		
		/*-------------- FB Page Comments--------------------*/
		
		$data["show_fb_comments"] = "false";
		
		if($rowHomepage["is_comments"] == 1)
		{
			$data["show_fb_comments"] = "true";
		}
		
		$_SESSION['site_id'] = $data["site_id"];
		$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
		
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes';  
		 }else
		 {
			 $data['ishome'] = 'no';
		 }
		 
		 $data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id); 

		
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
		$temp_name =  $this->my_template_menu->set_get_template($site_id);
		
		//echo $temp_name;exit;
		
		$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
		$this->template->add_css($color_scheme_css,'embed'); 
		
		$this->template->add_js('js/jquery-1.5.1.min.js');
		$this->template->add_js('js/jquery.cycle.all.js');
		/*$this->template->add_js('js/arial.js');
		$this->template->add_js('js/radius.js');*/
		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
		$this->template->add_js('js/jwplayer.js'); 
		
		$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
		$this->template->add_css('js/nivo-slider/nivo-slider.css'); 
		
		//exit;
		//print_r($arrayRegions['header']);exit;
		//$this->template->set_template('vantage');
		
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $site_id; 
		
		//$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		
		//SEO URLs
		$is_seo_enabled = $this->config->item('seo_url'); 

		$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
		 
		if($temp_name == "gymnastic")
		{
			//echo "i m in<pre>";
			//print_r($top_site_menu_basic); 
			$data = $top_site_menu_basic;
			$top_site_menu_basic = $this->Menus_Model->make_menu_top($data,'preview',$is_seo_enabled);
			/* echo "<pre>";
	 print_r($top_site_menu_basic);
		 exit;*/
		}
		  //exit; 
		  //print_r($top_site_menu_basic);exit;
		 
		 if($temp_name == "carclub")
		 {
			 /***********	Basic Menu Start		************/
		
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
			  
			$dataMenu = $top_site_menu_basic;
			
			$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
			
			
			/***********	Basic Menu End		************/
			
			
			
		 }
		 $data['menu'] =  $top_site_menu_basic;	
		 
		 
		 
		 
		 /***********	Ohter Menu Start		************/
		 
  		$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($site_id,$site_user_id); 
		
		if(count($other_top_navigation)>1) //when shop is not active login links show default
		{			
			$data['other_top_navigation'] =  $other_top_navigation;  			
		}
		else
		{
			$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
		}    
	 	 
		 /***********	Ohter Menu End		************/
		 
		 /***********	Advance Menu Start		************/
		 	 
		 $top_site_menu_advance =  $this->my_template_menu->getTopNavigation($site_id, $page_id); 
		 $data['adv_menu'] =  $top_site_menu_advance;
		 
		 /***********	Advance Menu End		************/
		 
//		 echo "<pre>";
	//	 print_r($data['adv_menu']);
		// exit;
		 
		 $this->template->write_view('menu', $temp_name.'/menu', $data);  
		 
		$flag_page_status = FALSE;
		
		if($page_status == "Published")
		{ 
			$flag_page_status = TRUE;   
		}
		else if($page_status == "Schedule")
		{
			$page_start_date = strtotime($page_start_date); 
			$page_end_date = strtotime($page_end_date);
			$date_today = strtotime(date("Y-m-d h:i:s"));
			if($page_start_date < $date_today && $page_end_date > $date_today)
			{
				$flag_page_status = TRUE;        
			}            
		}
		
		$flag_page_access = FALSE;
		
		if($page_access == "Registered")
		{
			if(isset($_SESSION['user_info']))
			{
				$flag_page_access = TRUE;            
			}
			else
			{
				$flag_page_access = FALSE;               
			}        
		}
		//THIS NEEEEEEED TO BE CHANGED FOR ACCCEEEEEE LEVEL NOWWWWWW IMPLEMENT GROUP HERE 
		else if($page_access == "Other")
		{
			$user_id = $_SESSION['user_info']['user_id'];
			//$role_id = $this->usersmodel->get_user_role_id($user_id);
			if($this->Pages_Model->isPageforUser($page_id, $user_id) == TRUE)
			{
				$flag_page_access = TRUE;        
			}  
			else
			{
				$flag_page_access = FALSE;                  
			}        
		}
		else//Everyone case
		{
			$flag_page_access = TRUE;        
		}
		
		if($flag_page_status == TRUE && $flag_page_access == TRUE)
		{
			//$data['content'] = $this->Site_Model->getPageContent($page_id);
			$data['content'] = $this->get_page_content($page_id);
		}
		else if($flag_page_status == FALSE)
		{
			$data['content'] = "<h3>This page is ".$page_status."</h3>
			<p>So, your access to this page is restricted.</p>";    
		}
		else if($flag_page_access == FALSE) 
		{
			$data['content'] = "<h3>Access is Restricted</h3>
			<p>Your access to this page is restricted.</p>";                
		}
		
		$data['main_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Main');
		$this->template->write_view('top_slider','all_common/top_slider', $data);
		
		$data['top_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Top');
		$data['bottom_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Bottom');  
		$data['left_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Left');  
		$data['right_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Right');
		
		$this->template->write_view('content','all_common/content', $data); 
		$this->template->write_view('header', 'all_common/header', $data);
		
		//get page regions
		$Regions = $this->template->regions;
		
		//see what region(s) are defined for menus: either Sidebar or Leftbar & Rightbar
		if(isset($Regions['sidebar']))
		//case: template with a sidebar region to show menus
		{
			$data['menus'] = $this->my_template_menu->getSidebar($site_id, $page_id);			
			$this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
		}
		else if(isset($Regions['leftbar']))
		//case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
		{
			//echo "doesnot exist";			
			$data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
			//echo "<pre>";
			//print_r($data['private_page_users']);
			//exit;
			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($site_id);
			
			
			$data['left_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($site_id);		 			
			//echo "<pre>"; print_r($data['left_menus']); exit;
			
			if(isset($_SESSION['customer_group_id']))
			{
				//$customer_group_pages =  $this->Site_Model->customerGroupPages($site_id, $page_id, $_SESSION['customer_group_id']);
			}	
			$data['left_menus_type'] = 'site';
			//$data['left_menus'] = "";
			
			//To Check Access level and Page Checking Under Sub Menu
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}else if(isset($Regions['rightbar'])){   
			$data['right_menus'] = $this->my_template_menu->getRightbar($site_id, $page_id);
			$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
		}
		/*
		echo "<pre>";
		print_r($data);
		exit;
		*/
		//print_r($finalArray);exit;
		//$this->template->write_view('sidebar','winglobal/sidebar', $data['menus']); 
		$footer_navigation =  $this->Menus_Model->footer_navigation($site_id);
		$data['footer_navigation'] =  $footer_navigation;
		if(isset($Regions['footer']))
		{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
		}
		$this->template->render();   
}
	
	//used to preview Page(s) of the Site's Preview
	function seo_urls($seo_page_name)
	{
		//Site ID by Domain Name
		$domain_name = $_SERVER["HTTP_HOST"];
		$seo_site_id = $this->Site_Model->get_site_id_by_domain($domain_name);
		
		$pieces = explode(".",$seo_page_name);
	
		if(count($pieces) > 0)
		{
			//Exception Handling if site ID not Found again Domain
			//echo $_SESSION["site_id"];
			if($seo_site_id != 0)
			{
				$page_site_id = $this->Pages_Model->get_page_site_id_by_seo($pieces[0],$seo_site_id);
			}
			else if(is_numeric($_SESSION["site_id"]))
			{
				//echo "here in right place";exit;
				$page_site_id = $this->Pages_Model->get_page_site_id_by_seo($pieces[0],$_SESSION["site_id"]);
			}
			else
			{
				//echo "here";exit;
				$page_site_id = $this->Pages_Model->get_page_site_id_by_seo($pieces[0]);
			} 
			
		} 
		else
		{
			//Exception Handling if site ID not Found again Domain
			if($seo_site_id != 0)
			{
				$page_site_id = $this->Pages_Model->get_page_site_id_by_seo($seo_page_name,$seo_site_id);
			}
			else
			{
				$page_site_id = $this->Pages_Model->get_page_site_id_by_seo($seo_page_name);
			}
			
		}	
		
		if($page_site_id)
		{
			$this->page($page_site_id["site_id"], $page_site_id["page_id"]);
		}
	}
	
	function page($site_id, $page_id="")
	{
		//echo $site_id;exit;
		
		$_SESSION['site_id'] = $site_id; 
		$rsltPage = $this->Site_Model->getSitePage($site_id, $page_id);
		$rowPage = $rsltPage->row_array();
		
	//	echo "<pre>";
	//	print_r($rowPage);
		//exit;

		if(isset($rowPage['page_title']) && $rowPage['page_title'] == "Contact Us")
		{	
			$cf_view = $this->Contact_Management_Model->check_contact_form($site_id);
		
			if(isset($cf_view['publish']) && $cf_view['publish'] == "Yes")
			{
				//echo "im being called";
				$action = base_url().index_page()."/FooterController/conatct_form_email";
				
				$cf_html = "<form action='".$action."' method='post' id='cf_generate' name='cf_generate'>
			
				<table align='center'>
				<tr>
				<td>".$cf_view['caption_Name']."</td>
				<td><input type='text' name='txtcap1' value='' /></td>
				</tr>

				<tr>
				<td>Email</td>
				<td><input type='text' name='email_from' value='' /></td>
				</tr>
								
				<tr>
				<td>".$cf_view['caption_Subject']."</td>
				<td><input type='text' name='txtcap2' value='' /></td>
				</tr>
				
				<tr>
				<td>".$cf_view['caption_Message']."</td>
				<td><textarea name='txtcap3' value='' rows='7' cols='17' ></textarea></td>
				</tr>
	
				<tr>
				<td></td>
				<td><input type='submit' value='Send Message' /></td>
				</tr>
				
				</table>";
				
				$data['contact_form'] = $cf_html;
			}	
		
		}
			  
		$data["mode"] = '';
		$data["site_id"] = $rowPage["site_id"];
		$data["page_id"] = $rowPage["page_id"];
		
		$page_status = $rowPage["page_status"];
		$page_title_status = $rowPage["page_title_status"];
		
				
		$page_id = $rowPage["page_id"];       
		$data["site_name"] = $rowPage["site_name"];
		$page_title = $rowPage["page_title"];
		$page_desc = $rowPage["page_desc"]; 
		$page_keywords = $rowPage["page_keywords"];
		$page_header = $rowPage["page_header"];
		$data['page_header'] = $page_header;
		
		
		/*-------------- FB Page Comments--------------------*/
		
		$data["show_fb_comments"] = "false";
		if($rowPage["is_comments"] == 1)
		{
			$data["show_fb_comments"] = "true";
		}
		
		
		//ENF FB 

		
		$header_background = $rowPage["header_background"];
		$data['header_background'] = $header_background;
		$data['header_background_image'] = ''; 
		$data["color_after_image"] = ""; 
		$data["background_area"] = ""; 
		$data["footer_content"] = "";
		
		//This is for Footer Dynamic
		$footer_content = $this->Footer_Model->get_footer_content($site_id);
		if(!empty($footer_content))
		{
			$data["footer_content"] = $footer_content["content"];
		} 	
		$page_background = $rowPage["page_background"];
		$data['page_background'] = $page_background; 
		$page_start_date = $rowPage["page_start_date"];  
		$page_end_date = $rowPage["page_end_date"];  
		$page_access = $rowPage["page_access"];
 
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes';  
		 }else
		 {
			 $data['ishome'] = 'no';
		 }
		
		if($page_header == "Other")
		{
			$data['header_image'] = base_url()."headers/".$this->Site_Model->getHeaderImage($data["page_id"]);
		}
		else if($page_header == "Slideshow")
		{
			$data['header_image'] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
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
			$background_path = base_url()."backgrounds/";
			$data['background_image'] = $background_path.$rowBackgroundImage['background_image'];
			$data['background_area'] = $rowBackgroundImage['background_area'];
			$data['background_style'] = $rowBackgroundImage['background_style'];
		}
		
		//get site template
		$temp_name =  $this->my_template_menu->set_get_template($site_id); 
		$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
		$this->template->add_css($color_scheme_css,'embed');
		
		$this->template->add_js('js/jquery-1.5.1.min.js');
		$this->template->add_js('js/jquery.cycle.all.js');
		/*$this->template->add_js('js/arial.js');
		$this->template->add_js('js/radius.js');*/
		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
		$this->template->add_js('js/jwplayer.js'); 
		
		$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
		$this->template->add_css('js/nivo-slider/nivo-slider.css'); 
		
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $site_id; 
		
		//$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		
		$is_seo_enabled = $this->config->item('seo_url'); 

		$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
		if($temp_name == "gymnastic")
		{
			//echo "i m in<pre>";
			//print_r($top_site_menu_basic); 
			$data = $top_site_menu_basic;
			$top_site_menu_basic = $this->Menus_Model->make_menu_top($data,'preview',$is_seo_enabled);
		}
		if($temp_name == "carclub")
		{
			 /***********	Basic Menu Start		************/
			
			$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
			  
			$dataMenu = $top_site_menu_basic;
			
			$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
			
			
			
			/***********	Basic Menu End		************/
		}
		
		$data['menu'] =  $top_site_menu_basic;
		
		$site_user_id = 0 ;
		if(isset($_SESSION['user_info']['user_id']))
		{
			$site_user_id = $_SESSION['user_info']['user_id'];
		}

		$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($site_id, $site_user_id); 
		if(count($other_top_navigation)>1) //when shop is not active login links show default
			{			
				$data['other_top_navigation'] =  $other_top_navigation;  			
			}
			else
			{
				$data['other_top_navigation'] =  $this->Menus_Model->get_register_link();			
			}         
		

		//Access Level Check For top Menu Page Linking
		/*if(count($top_site_menu_basic) > 0)
		{
			//restricting only for site Customers
			if(isset($_SESSION['customer_group_id']))
			{
				for($i=0;$i<count($top_site_menu_basic);$i++)
				{
					//echo $_SESSION['customer_group_id']."<br>";
					if($this->Menus_Model->is_page_allowed_for_group($top_site_menu_basic[$i]["page_id"],$_SESSION['customer_group_id']))
					{
							$page_not_in_menu[] = $i;	
					}
				}	
			}		
		}*/
		
		//echo "<pre>";
		//print_r($page_not_in_menu);
		//exit;
		/*if(isset($page_not_in_menu) && !empty($page_not_in_menu))
		{
			echo "sasasas";exit;
			
			foreach($page_not_in_menu as $key => $val)
			{
				unset($top_site_menu_basic[$val]);
			}
		}	*/
		
		

		// 28 March - Mohsin
		$main_menu_id = $this->Menus_Model->fetch_main_menu_id($site_id);
		if(isset($_SESSION['user_info']['user_id']))
		{
			$user_id = $_SESSION['user_info']['user_id'];
		}
		else
		{
			$user_id = "";
		}
		$main_menu_id = $main_menu_id['menu_id'];
		$data['main_menu_form_links'] =  $this->Menus_Model->fetch_reg_frm_menu($site_id, $user_id, $main_menu_id);
		// 28 March - Mohsin
		
		$top_site_menu_advance =  $this->my_template_menu->getTopNavigation($site_id, $page_id); 
		$data['adv_menu'] =  $top_site_menu_advance;
		
		$this->template->write_view('menu', $temp_name.'/menu', $data);
		
		
		$flag_page_status = FALSE;
		
		if($page_status == "Published")
		{ 
			$flag_page_status = TRUE;   
		}
		else if($page_status == "Schedule")
		{
			$page_start_date = strtotime($page_start_date); 
			$page_end_date = strtotime($page_end_date);
			$date_today = strtotime(date("Y-m-d h:i:s"));
			if($page_start_date < $date_today && $page_end_date > $date_today)
			{
				$flag_page_status = TRUE;        
			}            
		}
		   
		$flag_page_access = FALSE;
		if($page_access == "Registered")
		{
			if(isset($_SESSION['user_info']))
			{
				$flag_page_access = TRUE;            
			}
			else
			{
				$flag_page_access = FALSE;               
			}        
		}
		else if($page_access == "Other")
		{
		
			if(isset($_SESSION['user_info']['user_id']))
			{
				$user_id = $_SESSION['user_info']['user_id'];
				//if($this->Pages_Model->isPageforUser($page_id, $user_id) == TRUE)
				if($this->Menus_Model->is_page_allowed_for_group($page_id,$_SESSION['customer_group_id']))
				{
					$flag_page_access = TRUE;        
				}   
				else
				{
					$flag_page_access = FALSE;    
				} 
			}
			else
			{
				$flag_page_access = FALSE;                  
			}
		
		}
		else//Everyone case
		{
			$flag_page_access = TRUE;        
		}
		
		if($flag_page_status == TRUE && $flag_page_access == TRUE)
		{
			$data['content'] = $this->get_page_content($page_id); 
		}
		else if($flag_page_status == FALSE)
		{
			$data['content'] = "<h3>This page is ".$page_status."</h3>
			<p>So, your access to this page is restricted.</p>";    
		}
		else if($flag_page_access == FALSE) 
		{
			$data['content'] = "<h3>Access is Restricted</h3>
			<p>Your access to this page is restricted.</p>";                
		}
		
		$data['main_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Main');
		$this->template->write_view('top_slider','all_common/top_slider', $data);
			
		$data['top_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Top');
		$data['bottom_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Bottom');  
		$data['left_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Left');  
		$data['right_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Right');
		 
		 
		$this->template->write_view('content','all_common/content', $data); 
		
		//get page regions
		$Regions = $this->template->regions;
		
		//see what region(s) are defined for menus: either Sidebar or Leftbar & Rightbar
		if(isset($Regions['sidebar']))
		//case: template with a sidebar region to show menus
		{
			//echo "exist";
			$data['menus'] = $this->my_template_menu->getSidebar($site_id, $page_id);
				/*echo "<pre>";
			print_r($data['menus']);
			echo "<pre>";*/
			
			$this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
		}
		if(isset($Regions['leftbar']))
		//case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
		{
			//echo "doesnot exist";
			//echo "<pre>"; print_r($_SESSION); exit;
			$data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
			// 28 March - Mohsin
			if(sizeof($data['left_menus']) > 0)
			{
				$menu_id = $data['left_menus'][0]['menu_id'];
				if(isset($_SESSION['user_info']['user_id']))
				{
					$user_id = $_SESSION['user_info']['user_id'];
				}
				else
				{
					$user_id = "";
				}
				$i = 0;
				for($i; $i<sizeof($data['left_menus']); $i++)
				{	
					$menu_id = $data['left_menus'][$i]['menu_id'];
					$data['form_links_left'][] =  $this->Menus_Model->fetch_reg_frm_menu($site_id, $user_id, $menu_id);
					$data['form_links_menu_id'][] = $data['left_menus'][$i]['menu_id'];
				}
					//echo "<pre>"; print_r($data['form_links_left']); exit;
			}
			// 28 March - Mohsin
			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($site_id);
			$data['left_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($site_id);
			//echo "<pre>"; print_r($data['left_menus']); exit;
			if(isset($_SESSION['customer_group_id']))
			{
				//$customer_group_pages =  $this->Site_Model->customerGroupPages($site_id, $page_id, $_SESSION['customer_group_id']);
			}			
			$data['left_menus_type'] = 'site'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}
		if(isset($Regions['rightbar']))
		{   
			$data['right_menus'] = $this->my_template_menu->getRightbar($site_id, $page_id);
			// 28 March - Mohsin
			//echo "<pre>"; print_r($data['left_menus']); exit;
			if(sizeof($data['right_menus']) > 0)
			{
				$menu_id = $data['right_menus'][0]['menu_id'];
				if(isset($_SESSION['user_info']['user_id']))
				{
					$user_id = $_SESSION['user_info']['user_id'];
				}
				else
				{
					$user_id = "";
				}
				$i = 0;
				for($i; $i<sizeof($data['right_menus']); $i++)
				{	
					$menu_id = $data['right_menus'][$i]['menu_id'];
					$data['form_links_right'][] =  $this->Menus_Model->fetch_reg_frm_menu($site_id, $user_id, $menu_id);
					$data['form_links_menu_id'][] = $data['right_menus'][$i]['menu_id'];
				}			
			}
			// 28 March - Mohsin			
			$this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
		}     
		
		$footer_navigation =  $this->Menus_Model->footer_navigation($site_id);
		$data['footer_navigation'] =  $footer_navigation;
		if(isset($Regions['footer']))
		{
			$this->template->write_view('footer', $temp_name.'/footer', $data);          
		}                
		/*
		echo "<pre>";
		print_r($data);
		exit;
		*/
		$this->template->render();       
	} 
	
	function get_page_content_BKP($page_id)
	{   
		$result = $this->Site_Model->get_page_content($page_id);
		$count = 1;
		$content = "";  
		$page_title = $this->Pages_Model->get_page_title($page_id);
		
		if($_SESSION['page_title_status']){
			$content = '<div><h2>'.$page_title.'</h2></div>';
		}
		
		if($result->num_rows()>0)
		{
			$image_path = base_url()."media/uploads/";
			
			foreach($result->result_array() as $row)
			{
			//	echo "<pre>";
			//	print_r($row);
				
				$user_style = "" ;
				$user_anchor = "";
				$user_anchor_close = "";
				$user_anchor_open = "";
				if(!empty($row['image_alt']) || !empty($row['image_width']) || !empty($row['image_height']) || !empty($row['image_border']) || !empty($row['image_hspace']) || !empty($row['image_vspace']) || !empty($row['image_alignment']))
				{
					$user_style = 'style="';
					
					if(!empty($row['image_width']))
					{
						$user_style .= 'width:'.$row['image_width'].'px;';
					}
					if(!empty($row['image_height']))
					{
						$user_style .= 'height:'.$row['image_height'].'px;';
					}
					if(!empty($row['image_border']))
					{
						$user_style .= 'border:'.$row['image_border'].'px solid;';
					}
					if(!empty($row['image_hspace']))
					{
						$user_style .= 'margin-top:'.$row['image_hspace'].'px; margin-bottom:'.$row['image_hspace'].'px;';
					}
					if(!empty($row['image_vspace']))
					{
						$user_style .= 'margin-left:'.$row['image_vspace'].'px; margin-right:'.$row['image_vspace'].'px;';
					}
					if(!empty($row['image_alignment']) )
					{
						$user_style .= 'float:'.$row['image_alignment'].';';
					}
					
					$user_style .= '"';                             		
				}
				
				if(!empty($row['image_url']) ||!empty($row['image_target']))
				{
					$user_anchor_open = '<a href="'.$row['image_url'].'"';
					
					if(!empty($row['image_target']))
					{
						$user_anchor_open .= 'target="'.$row['image_target'].'">';
					}
					else
					{
						$user_anchor_open .= '>';
					}
					$user_anchor_close = '</a>';
				}
				
				if($row['type']=="para")
				{
					$content .= '<div style="position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$row['data'].'</div>';    
				}
				if($row['type']=="textarea")
				{
					$content .= '<div style="position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$row['data'].'</div>';    
				}
				if($row['type'] == "image")
				{
					
					
				//	echo $user_style."<br>";
					
					$content .= '<div>'.$user_anchor_open.'<img '.$user_style.' src="'.$image_path.$row['image'].'" />'.$user_anchor_close.'</div>';    
				}
				if($row['type']=="image-para")
				{
					//$content .= '<div style="clear:both;height:auto;"><p><img style="margin-right:10px;" align="left" src="'.$image_path.$row['image'].'" />'.$row['data'].'</p></div>';
					$content .= '<div style="clear:both;height:auto;"><p>'.$user_anchor_open.'<img '.$user_style.' src="'.$image_path.$row['image'].'" />'.$user_anchor_close.$row['data'].'</p></div>';
				}
				if($row['type']=="para-image")
				{
					//$content .= '<div style="clear:both;height:auto;"><p><img align="right" src="'.$image_path.$row['image'].'" />'.$row['data'].'</p></div>';
					$content .= '<div style="clear:both;height:auto;"><p>'.$user_anchor_open.'<img '.$user_style.' src="'.$image_path.$row['image'].'" />'.$user_anchor_close.$row['data'].'</p></div>';
				}
			}
			
			//echo $content;exit;
			return $content;            
		}
		else
		{
			return $content;
		}
	}
										
	function get_page_content($page_id)
	{   
		$result = $this->Site_Model->get_page_content($page_id);
		$count = 1;
		$content = "";  
		$page_title = $this->Pages_Model->get_page_title($page_id);		
		$rsltPage = $this->Site_Model->getSitePage($_SESSION['site_id'], $page_id);
		$rowPage = $rsltPage->row_array();
		$page_title_status = $rowPage["page_title_status"];
		//$content = '<div   style="  height:auto"><h2>'.$page_title.'</h2></div>';
		if(isset($page_title_status))
		{
			if($page_title_status == 'Published' || $page_title_status == '')
			{
				$content = '<div   style="  height:auto"><h2>'.$page_title.'</h2></div>';
			}
		}		
		if($result->num_rows()>0)
		{
			$image_path = base_url()."media/uploads/";
			$working_directory = getcwd();
			foreach($result->result_array() as $row)
			{
				
				$user_style = "" ;
				$user_anchor = "";
				$user_anchor_close = "";
				$user_anchor_open = "";
				$row['data'] = str_replace("http://www.globalonlinewebsitesolutions.com",base_url(),$row['data']);
				$row['image']= str_replace("http://www.globalonlinewebsitesolutions.com",base_url(),$row['image']);
				$row['image_url']= str_replace("http://www.globalonlinewebsitesolutions.com",base_url(),$row['image_url']);
				
				if(!empty($row['image_alt']) || !empty($row['image_width']) || !empty($row['image_height']) || !empty($row['image_border']) || !empty($row['image_hspace']) || !empty($row['image_vspace']) || !empty($row['image_alignment']))
				{
					$user_style = 'style="';

					if(!empty($row['image_size_type']) && $row['image_size_type']=='selected_size')
					{
						$image_size = explode("_",$row['image_selected_size']);
						
							$user_style .= 'width:'.$image_size[0].'px;';
						
							$user_style .= 'height:'.$image_size[1].'px;';
						
					}
					else
					{
						//Check If ratio selected
						if(!empty($row['image_cons_opt']) && $row['image_cons_opt'] == 'ratio')
						{
						
							if(!empty($row['image_width']))
							{
								$user_style .= 'width:'.$row['image_width'].'px;';
							}							
						}else
						{
							if(!empty($row['image_width']))
							{
								$user_style .= 'width:'.$row['image_width'].'px;';
							}
							if(!empty($row['image_height']))
							{
								$user_style .= 'height:'.$row['image_height'].'px;';
							}
						
						
						}
					
					}					
/*					if(!empty($row['image_width']))
					{
						$user_style .= 'width:'.$row['image_width'].'px;';
					}
					if(!empty($row['image_height']))
					{
						$user_style .= 'height:'.$row['image_height'].'px;';
					}*/
					if(!empty($row['image_border']))
					{
						$user_style .= 'border:'.$row['image_border'].'px solid;';
					}
					if(!empty($row['image_hspace']))
					{
						$user_style .= 'margin-top:'.$row['image_hspace'].'px; margin-bottom:'.$row['image_hspace'].'px;';
					}
					if(!empty($row['image_vspace']))
					{
						$user_style .= 'margin-left:'.$row['image_vspace'].'px; margin-right:'.$row['image_vspace'].'px;';
					}
					if(!empty($row['image_alignment']) )
					{
						$user_style .= 'float:'.$row['image_alignment'].';';
					}
					
					$user_style .= '"';                             		
				}
				
				if(!empty($row['image_url']) ||!empty($row['image_target']))
				{
					$user_anchor_open = '<a href="'.$row['image_url'].'"';
					
					if(!empty($row['image_target']))
					{
						$user_anchor_open .= 'target="'.$row['image_target'].'">';
					}
					else
					{
						$user_anchor_open .= '>';
					}
					$user_anchor_close = '</a>';
				}
				
				if($row['type']=="para")
				{
					$content .= '<div style="clear:both;position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$row['data'].'</div>';    
				}
					// Added By Mohsin 8 March 2012
				if($row['type']=="doc_menu")
				{
					// http://globalonlinewebsitesolutions.com/home/globalon/public_html/stage/
					$dwld_link = str_replace("/home/globalon/public_html/stage/",base_url(),$row['data']);
					$link_name = explode("/",$row['data']);
					
					$content .= "<h2>Download detailed document<a href=' ".$dwld_link." '> ".$link_name[7]."</a></h2>"; 
				}
					// Added By Mohsin 8 March 2012
				if($row['type']=="textarea")
				{
					$content .= '<div style="position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$row['data'].'</div>';    
				}
				
				if($row['type'] == "image")
				{
					
					
					$image = $working_directory."/media/uploads/".$row['image'];
					if(file_exists($image))
					{
						$image_src = $image_path.$row['image'];
					}
					else
					{
						
						$image_src = $row['image'];
					}
					
					$content .= '<div style="clear:both;height:auto;">'.$user_anchor_open.'<img '.$user_style.' src="'.$image_src.'" />'.$user_anchor_close.'</div>';    
				}
				
				if($row['type']=="video")
				{
					preg_match("/(<iframe[^<]+<\/iframe>)/",$row['data'],$matches);
					
					//echo "<pre>";
					//print_r($matches);
					//exit;
	
					if(empty($matches))
					{
						//Video File
						$player_html = '<script type="text/javascript" src="'.base_url().'js/jwplayer.js"></script><div id="mediaplayer_'.$row['id'].'">JW Player goes here</div>';
						$player_html = $player_html.'<script type="text/javascript">jwplayer("mediaplayer_'.$row['id'].'").setup({flashplayer: "'.base_url().'js/player.swf",file: "'.$image_path.$row['data'].'",image: "preview.jpg"});</script>';
						
						
						$content .= '<div style="clear:both;position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$player_html.'</div><br>';    	
					}
					else
					{
						//Video is Ifram
						$content .= '<div style="clear:both;position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$row['data'].'</div><br>';    	
					}
					
				}
				
				if($row['type']=="image-para")
				{
					
					$image = $working_directory."/media/uploads/".$row['image'];
					if(file_exists($image))
					{
						$image_src = $image_path.$row['image'];
					}
					else
					{
						
						$image_src = $row['image'];
					}
					if(!empty($row['image']))
					{
					
					$content .= '<div style="clear:both;height:auto;"><p>'.$user_anchor_open.'<img '.$user_style.' src="'.$image_src.'" />'.$user_anchor_close.$row['data'].'</p></div>';
					}
					else
					{
						$content .= '<div style="clear:both;height:auto;"><p>'.$row['data'].'</p></div>';
					}
				}
				if($row['type']=="para-image")
				{
					$image = $working_directory."/media/uploads/".$row['image'];
					if(file_exists($image))
					{
						$image_src = $image_path.$row['image'];
					}
					else
					{
						
						$image_src = $row['image'];
					}
					
					$content .= '<div style="clear:both;height:auto;"><p>'.$user_anchor_open.'<img '.$user_style.' src="'.$image_src.'" />'.$user_anchor_close.$row['data'].'</p></div>';
				}
			}
			
			//echo $content;exit;
			return $content;            
		}
		else
		{
			$content = str_replace("http://www.globalonlinewebsitesolutions.com",base_url(),$content);
			
			return $content;
		}
	}
}
?>