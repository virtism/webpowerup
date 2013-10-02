<?php
if(!session_start()){
	session_start(); }
class Site_preview extends CI_Controller
{
	var $site_id;
	
	function Site_Preview()
	{	
		$cf_html = "";
		$content = ""; 
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
		$this->load->model("Gallery_Model");
		$this->load->model("Video_Gallery_Model");
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->library('form_validation');       
		$this->load->library('template');
		$this->load->library('my_template_menu');
		$this->load->helper('url');   
		$this->load->helper('html');
		$this->load->library('Paypal_Lib'); 
		
	  // $uri_segments =  parse_str($_SERVER['QUERY_STRING'],$_GET);
	  // $uri_segments =  uri_string();
	  // $pieces = explode("/", $uri_segments);
	   
	  //$_SESSION['site_id']= end($pieces);
	  
	//  print_r($_SESSION);   exit();
	//   echo $uri_segments.'>>>>>>>>>>';   exit();
	}
	
	//Used to show Site's Preview(homepage)
	function site($site_id='')
	{
		/*echo "<pre>";
		echo $_SESSION['user_info']['user_id'];
		print_r($_SESSION['user_info']);
		exit();*/  
       // DebugBreak(); 
		$footer_content = '';
		$_SESSION['site_id'] = $site_id;
		$_SESSION['site_id_custom'] = $site_id;
		$site_user_id = 0 ;
		$data["admindetail"] = $this->Site_Model->getSiteAdmindetail($site_id);
		if( $data['admindetail'] != 0)
		{
			$_SESSION['user_info']['user_id'] = $data["admindetail"]['user_id'];
			$_SESSION['user_info']['user_login'] = $data["admindetail"]['user_login'];
		}
		
		// echo "<pre>";	print_r($data["admindetail"]);	echo "</pre>";
		/*
		if(isset($_SESSION['user_info']['user_id']))
		{
			$site_user_id = $_SESSION['user_info']['user_id'];
		}
		
		$rsltHomepage = $this->Site_Model->getHomePage2($site_id);		
		$footer_content = $this->Footer_Model->get_footer_content($site_id);
		$rowHomepage = array();
		$rowHomepage = $rsltHomepage[0];
		
		
		$data["mode"] = '';
		$data["site_id"] = $rowHomepage["site_id"];
		$data["page_id"] = $rowHomepage["page_id"];
		if(isset($footer_content)&&!empty($footer_content)){
		$data["footer_content"] = $footer_content["content"];
		}
		$page_status = $rowHomepage["page_status"];
		$page_id = $rowHomepage["page_id"];       
		$data["site_name"] = $rowHomepage["site_name"];
        $data["site_url"] = $rowHomepage["site_url"]; 
		$page_title = $rowHomepage["page_title"];
		$data['page_title'] = $rowHomepage["page_title"];
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
		
		$data['page_id2'] = $page_id; 
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes'; 
		   $data['page_title'] =  $page_title;
		 
		 }else
		 {
			 $data['ishome'] = 'no';
			 $data['page_title'] =  '';
	
		 }
		 
		 $data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id); 
		
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
			$data['header_background_image'] = $this->Pages_Model->getHeaderBackgroundImage($page_id);         
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
			$background_path = base_url()."media/ckeditor_uploads/".$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']."/images/background/";
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
		
		
		$site = $this->Site_Model->get_site_domain_name($site_id);
		$page_title = $site[0]['site_name'];
		
		
		$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$logo_view = $this->Site_Model->check_logo_image($site_id);
		
		if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
		{
		  $this->template->write_view('logo', $temp_name.'/logo', $data);
		}
		
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		
		//SEO URLs
		$is_seo_enabled = $this->config->item('seo_url'); 
		 
		$data['is_seo_enabled'] = $this->config->item('seo_url');
		 /***********	Basic Menu Start		************/
		
		$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
		  
		$dataMenu = $top_site_menu_basic;
		
		
		
		$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
		
		
		$data['menu'] =  $top_site_menu_basic;	
		
		/***********	Basic Menu End		************/
		 /***********	Ohter Menu Start		************/
		 
		$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($site_id,$site_user_id); 
		
		//echo '<pre>';print_r($other_top_navigation);	die();
		
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
		 $data['adv_menu'] 		=  $top_site_menu_advance;
		
		 /***********	Advance Menu End		************/
		 
		/* echo "<pre>";
		 print_r($data['adv_menu']);
		 exit;*/
		 //echo $temp_name ;exit;
		 if(isset($temp_name) && $temp_name != 'intro_template')
		 {
			$this->template->write_view('menu', $temp_name.'/menu', $data);  
		 }
		
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
			$data['content'] = $this->get_page_content($page_id, $temp_name);
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
		
		/***********	SLIDESHOW START		************/
		
		// echo $temp_name;
		$data['temp_name'] = $temp_name;
		$data['main_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Main');
	
		$this->template->write_view('top_slider','all_common/top_slider', $data);
				
		$group_ids = array();
		if(isset($_SESSION['login_info']['customer_id']))
		{
			$group_ids = $this->Menus_Model->get_group_id_by_customer_id($_SESSION['login_info']['customer_id']);
		}
		
		
		
		$position = array("Top","Right","Left","Bottom");
		$total_position = count($position);
		
		//$data['top_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Top');
		//$data['bottom_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Bottom');  
		//$data['left_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Left');  
		//$data['right_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Right');
		
		// get all slide shows by their position 
		foreach ( $position as $pos )
		{
			$top_slideshows = $this->Slideshow_Model->get_slideshow($site_id, $page_id, $pos);
			$new_slideshow = array();
		
			// echo "<pre>"; print_r($top_slideshows);	echo "</pre>";  
			
			
			foreach($top_slideshows as $slideshow)
			{
				if($slideshow['slide_access'] == "Everyone")
				{
					$new_slideshow[] = $slideshow;
				}
				else if($slideshow['slide_access'] == "Registered")
				{
					if(isset($_SESSION['login_info']['customer_id']))
					{
						$new_slideshow[] = $slideshow;
					}
				}
				else if($slideshow['slide_access'] == "Other")
				{
					if ($slideshow['slide_groups'] != "")
				{
					$slide_group_id = explode(",",$slideshow['slide_groups']);
				}
				else
				{
					$slide_group_id = array(); 
				}
				
				if ( count($slide_group_id) > 0 )
				{
					if ($group_ids)
					{
						foreach($group_ids as $id)
						{
							if(in_array($id,$slide_group_id) )
							{
								$new_slideshow[] = $slideshow; 
								break;
							}
						}
					}
				}
				else
				{
					$new_slideshow[] = $slideshow;
				}
				}
				
			}
			if(count($new_slideshow) > 0 )
			{
				$pos_new = strtolower($pos);
				$index =  $pos_new."_";
				$data[$index.'slideshows'] = $new_slideshow;
			}
		}
			
		
		/***********	SLIDESHOW END		************/
		
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
		if(isset($Regions['leftbar']))
		//case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
		{
			//echo "doesnot exist";			
			$data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
			
			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($site_id);
			
			
			//$data['left_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($site_id);		 			
			//echo "<pre>"; print_r($data['left_menus']); exit;
			
			if(isset($_SESSION['customer_group_id']))
			{
				//$customer_group_pages =  $this->Site_Model->customerGroupPages($site_id, $page_id, $_SESSION['customer_group_id']);
			}	
			$data['left_menus_type'] = 'site';
			//$data['left_menus'] = "";
			
			//To Check Access level and Page Checking Under Sub Menu
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}
		if(isset($Regions['rightbar']))
		{   
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
			else if(isset($_SESSION["site_id"]) && is_numeric($_SESSION["site_id"]))
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
		if($page_id != "")
		{
			$_SESSION['page_id'] = $page_id;
		}
		$data["admindetail"] = $this->Site_Model->getSiteAdmindetail($site_id);	
		if( $data['admindetail'] != 0)
		{
			$_SESSION['user_info']['user_id'] = $data["admindetail"]['user_id'];
			$_SESSION['user_info']['user_login'] = $data["admindetail"]['user_login'];
		}	
		$rsltPage = $this->Site_Model->getSitePage($site_id, $page_id);
		$rowPage = $rsltPage->row_array();
		
		/*echo "<pre>";
		print_r($rowPage);
		exit;*/
		
		if(isset($rowPage['page_title']) && $rowPage['page_title'] == "Contact Us")
		{	
			$message_success = '';
			if(isset($_SESSION['mail_sent']) && $_SESSION['mail_sent']==1)
			{
				$message_success = '<p style = "color:green;">Thank you, your message has been sent successfully!</p>';
				$_SESSION['mail_sent'] = '';
			}
			$cf_view = $this->Contact_Management_Model->check_contact_form($site_id);
		
			if(isset($cf_view['publish']) && $cf_view['publish'] == "Yes")
			{
				global $cf_html;
				//echo "im being called";
				$action = base_url().index_page()."FooterController/conatct_form_email";
				
				$cf_html = "$message_success<br><form action='".$action."' method='post' id='cf_generate' name='cf_generate'>
			
				<table align='center'>
				<tr>
				<td><label>".$cf_view['caption_Name']."</label></td>
				<td ><input type='text' name='txtcap1' value='' /></td>
				</tr>
				<tr>
				<td><label>Email</label></td>
				<td ><input type='text' name='email_from' value='' /></td>
				</tr>
								
				<tr>
				<td><label>".$cf_view['caption_Subject']."</label></td>
				<td ><input type='text' name='txtcap2' value='' /></td>
				</tr>
				
				<tr>
				<td><label>".$cf_view['caption_Message']."</label></td>
				<td><div class=textarea><textarea rows=5 cols=37   name=message></textarea></td>
				</tr>
	
				<tr>
				<td></td>
				<td style='padding-top:25px;'><input  type='submit' value='Send Message' class=submit/></td>
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
		$data['page_title'] = $rowPage["page_title"];
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
		$page_type = $rowPage["page_type"];
		$page_users = $rowPage["page_users"];
		$page_groups = $rowPage["page_groups"];
 
		$data['page_id2'] = $page_id; 
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes'; 
		   $data['page_title'] =  $page_title;
		 }else
		 {
			 $data['ishome'] = 'no';
			 $data['page_title'] =  '';
		 }
		
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
		
		if($header_background=='Image')
		{
			$data['header_background_image'] = $this->Pages_Model->getHeaderBackgroundImage($page_id);         
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
		
		
		
		$site = $this->Site_Model->get_site_domain_name($site_id);
		$page_title = $site[0]['site_name']." ".$page_title;
		$this->template->write('title', $page_title);
		
		$image_path = '';
		$result = $this->Video_Gallery_Model->get_user_of_site($_SESSION['site_id']);
	
		$image_path = base_url().'media/ckeditor_uploads/'.$result[0]['user_login'].'_'.$result[0]['user_id'].'/logo/';
		
		$data['path'] = $image_path;
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$logo_view = $this->Site_Model->check_logo_image($site_id);
		
		if(isset($logo_view ['publish']) && $logo_view['publish'] == "Yes")
		{
		  $this->template->write_view('logo', $temp_name.'/logo', $data);
		}
		
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		
		$is_seo_enabled = $this->config->item('seo_url');
		$data['is_seo_enabled'] = $this->config->item('seo_url');
	   /***********	Basic Menu Start		************/
		
		$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
		  
		$dataMenu = $top_site_menu_basic;
		
		$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
		
		$data['menu'] =  $top_site_menu_basic;
		
		/*echo "<pre>";
		print_r($dataMenu );
		exit;*/
		
		/***********	Basic Menu End		************/
		
		
		
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
		
		/*echo "<pre>";
		print_r($data);
		exit;*/
		/*if(isset($page_not_in_menu) && !empty($page_not_in_menu))
		{
			echo "sasasas";exit;
			
			foreach($page_not_in_menu as $key => $val)
			{
				unset($top_site_menu_basic[$val]);
			}
		}	*/
		
		
		//28 March - Mohsin
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
		$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
		
		if(isset($temp_name) && $temp_name != 'intro_template')
		 {
			$this->template->write_view('menu', $temp_name.'/menu', $data);  
		 }
		//$this->template->write_view('menu', $temp_name.'/menu', $data);
		
		
		/******** Private Page Flags  *********/
		
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
			
			if($date_today >= $page_start_date && $date_today <= $page_end_date )
			{
				$flag_page_status = TRUE;        
			}            
		}
		   
		/***********	Page Access Level 			************/
		
		$page_groups = $page_groups;
		$page_users = $page_users;
		
		$flag_page_access = FALSE;
		
		if($page_access == "Registered")
		{
			if(isset($_SESSION['login_info']))
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
		
			if(isset($_SESSION['login_info']['customer_id']))
			{
				
				if( $page_type == "Normal")
				{
					/*
					$page_groups_id = explode(",",$page_groups);  
					$group_id = $this->Menus_Model->get_group_id_by_customer_id($_SESSION['login_info']['customer_id']);
					if($page_groups != "" && ( $page_users == "" || $page_users == NULL) ) // for only groups
					{
						if($group_id)
						{
							foreach($group_id as $id )
							{
								if ( in_array($id,$page_groups_id) )
								{
									$flag_page_access = TRUE;
									break;
								}
							}
						}
					}
					*/ 
					if ($page_users != "") 
					{
						$page_users_id = explode(",",$page_users);
						$member_id = $_SESSION['login_info']['customer_id'];
						if ( in_array($member_id,$page_users_id) )
						{
							$flag_page_access = TRUE;
						}
						
					}
					else
					{
						$flag_page_access = FALSE;    
					}
				}
				else if ($page_type == "Group")
				{
					$flag_page_access = TRUE;
				}
				else if ($page_type == "private")
				{
					$flag_page_access = ($_SESSION['login_info']['customer_id'] == $page_users) ? TRUE : FALSE ;
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
			$data['content'] = $this->get_page_content($page_id, $temp_name); 
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
		/***********	Page Access Level End		************/
		
		/***********	SLIDESHOW START		************/
		
		
		$data['temp_name'] = $temp_name;
		$data['main_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Main');
		$this->template->write_view('top_slider','all_common/top_slider', $data);
			
		$group_ids = array();
		if(isset($_SESSION['login_info']['customer_id']))
		{
			$group_ids = $this->Menus_Model->get_group_id_by_customer_id($_SESSION['login_info']['customer_id']);
		}
		
		
		
		$position = array("Top","Right","Left","Bottom");
		$total_position = count($position);
		
		//$data['top_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Top');
		//$data['bottom_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Bottom');  
		//$data['left_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Left');  
		//$data['right_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'Right');
		
		// get all slide shows by their position 
		foreach ( $position as $pos )
		{
			
			$top_slideshows = $this->Slideshow_Model->get_slideshow($site_id, $page_id, $pos);
			
			
			$new_slideshow = array();
			
			// echo "<pre>"; print_r($top_slideshows);	echo "</pre>";  
			
			
			foreach($top_slideshows as $slideshow)
			{
				if($slideshow['slide_access'] == "Everyone")
				{
					$new_slideshow[] = $slideshow;
				}
				else if($slideshow['slide_access'] == "Registered")
				{
					if(isset($_SESSION['login_info']['customer_id']))
					{
						$new_slideshow[] = $slideshow;
					}
				}
				else if($slideshow['slide_access'] == "Other")
				{
					if ($slideshow['slide_groups'] != "")
				{
					$slide_group_id = explode(",",$slideshow['slide_groups']);
				}
				else
				{
					$slide_group_id = array(); 
				}
				
				if ( count($slide_group_id) > 0 )
				{
					if ($group_ids)
					{
						foreach($group_ids as $id)
						{
							if(in_array($id,$slide_group_id) )
							{
								$new_slideshow[] = $slideshow; 
								break;
							}
						}
					}
				}
				else
				{
					$new_slideshow[] = $slideshow;
				}
				}
				
			}
			if(count($new_slideshow) > 0 )
			{
				$pos_new = strtolower($pos);
				$index =  $pos_new."_";
				$data[$index.'slideshows'] = $new_slideshow;
			}
		}
			
		/***********	SLIDESHOW END		************/
		
		 
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
			//echo "<pre>"; print_r($data['left_menus']); exit;
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
			//echo "<pre>"; print_r($data['private_page_users']); exit;
			$data['left_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($site_id,$page_id);
			//echo "<pre>"; print_r($data['private_page_users']); echo "</pre>";
			if(isset($_SESSION['customer_group_id']))
			{
				//$customer_group_pages =  $this->Site_Model->customerGroupPages($site_id, $page_id, $_SESSION['customer_group_id']);
			}			
			 $data['page_title'] = $rowPage["page_title"];
			$data['left_menus_type'] = 'site'; 
			// $data['left_menus_type'] = 'myshop'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}
		 // echo "<pre>"; print_r($data['left_menus']); exit;   
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
			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($site_id);
			//$data['right_menus_Pbox'] = $this->Promotional_Boxes_Model->getLeftPromotionalBox($site_id,$page_id);
			$data['right_menus_type'] = 'site'; 		
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
	
	function create_gallery_html($gallery_data, $temp_name)
	{
		
		//echo "<pre>";print_r($gallery_data);echo "</pre>";
		$gallery_html = '';		
		$thumb_image_js_file_included = 0;
		for($i =0; $i<count($gallery_data); $i++)
		{
			$gallery_data_template_files = $this->Gallery_Model->get_gallery_template_files($gallery_data[$i]['id']);
			// echo "<pre>";	print_r($gallery_data_template_files);		echo "</pre>";
			//Start Include Js & Css files
			
			for($j = 0; $j<count($gallery_data_template_files); $j++)
			{
					if(isset($gallery_data_template_files[$j]['file_type']) && $gallery_data_template_files[$j]['file_type'] == 'css')
					{
						$gallery_html .= '<link type="text/css" rel="stylesheet" href="'.base_url().'galleries_templates/'.$gallery_data_template_files[$j]['folder_name'].'/css/'.$temp_name."/".$gallery_data_template_files[$j]['files'].'" />';	
					}
					else if(isset($gallery_data_template_files[$j]['file_type']) && $gallery_data_template_files[$j]['file_type'] == 'js')
					{
						// thumbnail jquery file inclue only one 
						if ( $gallery_data_template_files[$j]['files'] == "simple_thumbs.js") 
						{
							
							if( $thumb_image_js_file_included == 0 )
							{
								$gallery_html .= '<script type="text/javascript" src="'.base_url().'galleries_templates/'.$gallery_data_template_files[$j]['folder_name'].'/js/'.$gallery_data_template_files[$j]['files'].'"></script>';	
							}
							$thumb_image_js_file_included++;
						}
						else
						{
							$gallery_html .= '<script type="text/javascript" src="'.base_url().'galleries_templates/'.$gallery_data_template_files[$j]['folder_name'].'/js/'.$gallery_data_template_files[$j]['files'].'"></script>';	 
						}
						
					}			
				
			}
			//echo "<pre>";print_r($gallery_data_template_files);exit;
			//End Include Js & Css files
			
			
			//Start Gallery Images
			
			$gallery_images = $this->Gallery_Model->get_gallery_images($gallery_data[$i]['gallery_id']);
		
			$image_path = base_url()."media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/galleries/middle/";
			$result = $this->Video_Gallery_Model->get_user_of_site($_SESSION['site_id']);
	
			$image_path = base_url().'media/ckeditor_uploads/'.$result[0]['user_login'].'_'.$result[0]['user_id'].'/galleries/middle/';
			//echo "<pre>";print_r($gallery_images);exit;
			if(isset($gallery_data[$i]['folder_name']) && $gallery_data[$i]['folder_name'] == 'imageflow')
			{
				//echo "<pre>";print_r($gallery_images);exit;
				$gallery_html .= '<div id="myImageFlow" class="imageflow">';
				for($j = 0; $j<count($gallery_images); $j++)
				{
					if(isset($gallery_images[$j]['gallery_image']))
					{
						//$image_exp = explode('.',$gallery_images[$j]['gallery_image']);
						//$image_name = $image_exp[0].'_thumb_150.'.$image_exp[1];
						$image_name = $gallery_images[$j]['gallery_image'];
					}
					$target = ($gallery_images[$j]['target'] == '1' ? "_blank" : "");
					$url = ($gallery_images[$j]['gallery_image_url'] ? $gallery_images[$j]['gallery_image_url'] : "");				
					//$user_login_id = $this->Gallery_Model->get_user_login_id($_SESSION['site_id']);		
			
					$gallery_html .= '<img src="'.$image_path.$image_name.'" longdesc="'.base_url().'galleries/full/'.$image_name.'"  alt="Image '.$j.'" />';
				}
				$gallery_html .= '</div><br style="clear:both;"/>';				
			}
			else if(isset($gallery_data[$i]['folder_name']) && $gallery_data[$i]['folder_name'] == 'simple_thumbs')
			{
				/*
				if left and right exist on page fix gallery
				*/ 
				$css_fix = "";
				if( isset($_SESSION['site_id']) && isset($_SESSION['page_id']) )
				{
					$left_menus = $this->my_template_menu->getLeftbar($_SESSION['site_id'], $_SESSION['page_id']);
					if( count($left_menus)) 
					{
						$css_fix = 'style=" left:7% !important; " ';
					}
					$right_menus = $this->my_template_menu->getRightbar($_SESSION['site_id'], $_SESSION['page_id']);
					if( count($right_menus))
					{
						$css_fix = 'style=" left:7% !important; " ';
					}
				}
				
				$gallery_html .='<div class="simpleThumb" id="thumbGallery'.$i.'" '.$css_fix.'><div id="large_image_holder" ><ul id="large_images">'; 
				$j=0;
				for($j = 0; $j<count($gallery_images); $j++)
				{
					if(isset($gallery_images[$j]['gallery_image']))
					{
						/*$image_exp = explode('.',$gallery_images[$j]['gallery_image']);
						$image_name = $image_exp[0].'_thumb_150.'.$image_exp[1];*/
						$image_name = $gallery_images[$j]['gallery_image'];
					}
					
					$target = ($gallery_images[$j]['target'] == '1' ? "_blank" : "");
					
					if(empty($gallery_images[$j]['gallery_image_url']) || $gallery_images[$j]['gallery_image_url']=='URL')
					{
						$url = 'javascript:void(0);';
					}
					else
					{
						$url = $gallery_images[$j]['gallery_image_url'];
					}
					
					
					$gallery_html .= '<li><a  target="'.$target.'" href="'.$url.'"><img src="'.$image_path.'middle/'.$image_name.'" alt="Image '.$i.$j.'" /></a></li>';
					
				}
				$gallery_html .= '</ul></div>';
				$gallery_html .= '<ul id="thumb_holder">';
				$j=0;
				for($j = 0; $j<count($gallery_images); $j++)
				{
					if(isset($gallery_images[$j]['gallery_image']))
					{
						/*$image_exp = explode('.',$gallery_images[$j]['gallery_image']);
						$image_name = $image_exp[0].'_thumb.'.$image_exp[1];*/
						$image_name = $gallery_images[$j]['gallery_image'];
					}
					$gallery_html .= '<li><a  href="javascript:void(0);" name="thumbGallery'.$i.'" ><img id="thumbSelected" src="'.$image_path.'thumb/'.$image_name.'" alt="Image '.$i.$j.'" /></a></li>';
				}
				$gallery_html .= '</ul></div><br clear="all"/>';
			}
		
			
			//End Gallery Images
		}
		//echo "<pre>";print_r($gallery_data);exit;
		return  $gallery_html;
		
		//echo  realpath('./');
		//Gallery Image
	
	}
	
	function create_group_button($button)
	{
		
	   // echo "<pre>";	print_r($_SESSION);		echo "</pre>";
	   
	   if (!isset($_SESSION['login_info']['customer_id']))
	   {
		   $link = base_urL().index_page()."MyAccount/register/".$_SESSION['site_id'];
	   }
	   else if(isset($_SESSION['login_info']['customer_id']))
	   {
		   $link = base_urL().index_page()."group_managment/new_group";
	   }
	   
		// die();
		
		// ['login_info']['customer_id']
		$output = "<div class=\"group_join_content_button\">";
		$output.= "<a href=\" ".$link." \">";
		$output.= "JOIN GROUP NOW";
		$output.= "</a>";
		
		$output.= "</div>";
		
		return $output;
	}
	
	function create_video_html($video_gallery_data,$site_id)
	{
		
		
		$video_html ='';
		$video_html .= '<link type="text/css" rel="stylesheet" href="http://www.webpowerup.com/video_gallery/stylesheets/style.css" />';
			$video_html .=  '<script type="text/javascript" src="http://gettopup.com/releases/latest/top_up-min.js"></script>';
			$video_html .=   '<script type="text/javascript">
	  TopUp.addPresets({
		"#images a": {
		  fixed: 0,
		  group: "images",
		  modal: 0,
		  title: "Example"
		},
		"#movies": {
		  resizable: 1
		}
	  });
	</script>';
	$result = $this->Video_Gallery_Model->get_user_of_site($site_id);
	
	$image_path = base_url().'media/ckeditor_uploads/'.$result[0]['user_login'].'_'.$result[0]['user_id'].'/videos/';

			 for($i = 0; $i < count($video_gallery_data); $i++)
			 {
				 if($video_gallery_data[$i]['template_options'] == 0 || $video_gallery_data[$i]['template_options'] == 1)
				 {
				   $layout = '';	 
				 }
				 if($video_gallery_data[$i]['template_options'] == 2)
				 {
				   $layout = 'layout = quicklook';	 
				 }
				 if($video_gallery_data[$i]['template_options'] == 3)
				 {
				   $layout = 'effect = clip';	 
				 }
				 if($video_gallery_data[$i]['template_options'] == 4)
				 {
				   $layout = 'type = flash';
				 }
				 $video_html .= '<a href="'.$image_path.$video_gallery_data[$i]['gallery_image'].'" toptions="width = 600, height = 400, '.$layout.', group = 1, title = '.$video_gallery_data[$i]['gallery_title'].'">
		<img width="130" height="100" src="http://www.webpowerup.com/video_gallery/images/icon.png"/>
	  </a>';
			 }
			 return $video_html;
	}
	
	function get_reg_form_html($page_id) // function which return registeration form HTML 
	{
		$this->load->model("registration_forms_model","form");
		$forms = $this->form->get_form_by_page_id($page_id);
		
		$form_html = "";
		if($forms)
		{
			$i = 1;
			foreach( $forms as $row )
			{
				$data['form_data'] = $this->form->registration_form_data($row['form_id']); 
				$data['form_fields'] = $this->form->registration_form_fields($row['form_id']);  
				$data['form_detail'] = $this->form->get_Form($row['form_id']);
				$data['thml_fixer'] = 1;
				$data['form_number'] = $i;
				$data['is_loggedin'] = ( isset($_SESSION['login_info']['customer_id']) ) ? true : false; 
				$form_html .= "<div style=\"clear:both;\">";			
				$form_html .= $this->load->view('Registration_Froms_View_User', $data , true);
				$form_html .= "</div>";
				$i++;
			}
		}
		return $form_html;
		
		
	}
	
	function get_page_content($page_id, $temp_name='')
	{   
		$result = $this->Site_Model->get_page_content($page_id);		
		$count = 1;
		$content = "";  
		//$temp_name =  $this->my_template_menu->set_get_template($_SESSION['site_id']);
		/*if(isset($temp_name) && $temp_name == 'intro_template')
		 {
			$content = '<div   style="  height:auto"></div>';
		 }*/
		$page_title = $this->Pages_Model->get_page_title($page_id);	
		$rsltPage = $this->Site_Model->getSitePage($_SESSION['site_id'], $page_id);
		$rowPage = $rsltPage->row_array();
		$coment = $rowPage["is_comments"];
		$fb_url = "http://".$rowPage['site_domain'].".webpowerup.com/site_preview/page/".$_SESSION['site_id']."/".$page_id;
		$page_title_status = $rowPage["page_title_status"];
		//$content = '<div   style="  height:auto"><h2>'.$page_title.'</h2></div>';
		if(isset($page_title_status))
		{
			if($page_title_status == 'Published' || $page_title_status == '')
			{
				$content .= '<div   style="  height:auto"><h2>'.$page_title.'</h2></div>';
			}
		}
		global $cf_html;
		$content .= $cf_html;
		//Gallery Image
		//$gallery_data = $this->Gallery_Model->gallery_count($page_id);		
		
		$gallery_data = $this->Gallery_Model->get_all_gallery_data($_SESSION['site_id'], $page_id);
		
		// echo "<pre>";	print_r($gallery_data); echo "</pre>";exit;
		//$gallery_data = $this->Gallery_Model->get_all_gallery_data($page_id);
		
		if(count($gallery_data)>0)
		{
			$content .= $this->create_gallery_html($gallery_data, $temp_name);
		}
		
		
		
		$video_gallery_data = $this->Video_Gallery_Model->get_all_gallery_data($_SESSION['site_id'], $page_id);
	  // echo "<pre>";	print_r($video_gallery_data); echo "</pre>";
	   if(isset($video_gallery_data) && count($video_gallery_data)>0)
		{
			$content .= $this->create_video_html($video_gallery_data,$_SESSION['site_id']);
		}
		
		
		// REGISTRATION FORM 
		$content .= $this->get_reg_form_html($page_id);
			
			
		//Gallery Image
		$video_content = '';
		
		if($result->num_rows()>0)
		{
		
			$image_path = base_url()."media/uploads/";
			$working_directory = getcwd();
			/*echo "<pre>";
			print_r($result->result_array());exit;*/
			foreach($result->result_array() as $row)
			{
				
				$user_style = "" ;
				$user_anchor = "";
				$user_anchor_close = "";
				$user_anchor_open = "";
				$row['data'] = str_replace("http://www.webpowerup.com",base_url(),$row['data']);
				$row['image']= str_replace("http://www.webpowerup.com",base_url(),$row['image']);
				$row['image_url']= str_replace("http://www.webpowerup.com",base_url(),$row['image_url']);
				
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
						if(!empty($row['image_cons_opt']) && $row['image_cons_opt'] == 'ratio' && $_SESSION['img_cons'] == "true")
						{
						
							if(!empty($row['image_width']))
							{
								$user_style .= 'width:'.$row['image_width'].'px;';
							}							
						}
						else if(!empty($row['image_size_type']) && $row['image_size_type']=='default_size')
						{
						
												
						}
						else
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
						if($row['image_alignment']=='center')
						{
							 $user_style .= 'display: block; margin:auto; src="person.gif;';
						}
						else
						{
							 
							 $user_style .= 'float:'.$row['image_alignment'].';';	 
						}
						
					}
					
					$user_style .= '"';                             		
				}
				
				if(!empty($row['image_target']) ||!empty($row['image_target']))
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
					$content .= '<div style="clear:both;position:relative;min-width:690px;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$row['data'].'</div>';    
				}
					// Added By Mohsin 8 March 2012
				if($row['type']=="doc_menu")
				{
					// http://webpowerup.com/home/globalon/public_html/stage/
					$dwld_link = str_replace("/var/www/",base_url(),$row['data']);
					$dwld_link_explode = explode('*',$dwld_link);
					if(empty($dwld_link_explode[0]))
					{
						$dwld_link_explode[0] = $dwld_link;
					}	
					
					$link_name = explode("/",$row['data']);
					//echo $dwld_link[0];exit;
					$doc_dis = '';
					if(isset($link_name[7]))
					{
						$explode_from_starick = explode('*',$link_name[7]);
					}
					else
					{
						$explode_from_starick = explode('*',$row['data']);
						
					}
					$doc_name = $explode_from_starick[0];
					if(isset($explode_from_starick[1]))
					{
						$doc_dis = $explode_from_starick[1];
						
					}				
					
					if(isset($row['image_target']) && $row['image_target']=='_blank')
					{
					$content .= "$doc_dis<a target=".$row['image_target']."  href=' ".$dwld_link_explode[0]." '> ".$doc_name."</a>"; 
					}else
					{
					//$content .= "$doc_dis<a  href=' ".$dwld_link." '> ".$link_name[7]."</a>";
					$content .= "$doc_dis<a  href=' ".$dwld_link_explode[0]." '> ".$doc_name."</a>";
					}
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
						
						$image_src = str_replace('_thumbs/Images','images',$row['image']);
						$image_src = str_replace('_thumb.','.',$image_src);
						$image_src = str_replace('/s/Images','/images',$image_src);
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
						
						if($row['video_align']=='bottom')
						{
							$video_content .= '<div style="clear:both;position:relative;left:'.$row['x'].'px;bottom:0;">'.$player_html.'</div><br>'; 
						}
						else
						{
						
							$content .= '<div style="clear:both;position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;float:'.$row['video_align'].'">'.$player_html.'</div><br>';    	
						}
						
						
					}
					else
					{
						//Video is Ifram
						if($row['video_align']=='bottom')
						{
							
							$video_content .= '<div style="clear:both;position:relative;left:'.$row['x'].'px;bottom:0px">'.$player_html.'</div><br>';    	
						}
						else
						{
						
							$content .= '<div style="clear:both;position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;float:'.$row['video_align'].'">'.$row['data'].'</div><br>';    				}
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
						
						$image_src = str_replace('_thumbs/Images','images',$row['image']);
						$image_src = str_replace('_thumb.','.',$image_src);
						$image_src = str_replace('/s/Images','/images',$image_src);
					}
					if(!empty($row['image']))
					{
					
						$content .= '<div style="clear:both;height:auto;min-width:690px;"><p>'.$user_anchor_open.'<img '.$user_style.' src="'.$image_src.'" />'.$user_anchor_close.$row['data'].'</p></div>';
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
						
						$image_src = str_replace('_thumbs/Images','images',$row['image']);
						$image_src = str_replace('_thumb.','.',$image_src);
						$image_src = str_replace('/s/Images','/images',$image_src);
					}
					
					$content .= '<div style="clear:both;height:auto;min-width:690px;"><p>'.$user_anchor_open.'<img '.$user_style.' src="'.$image_src.'" />'.$user_anchor_close.$row['data'].'</p></div>';
				}
			}
			//echo $content;exit;
			if(!empty($video_content))
			{				
				
				$content .=	$video_content;				
			}
			
			// GROUP JOIN BUTTON 
			$group_buttons = $this->Pages_Model->get_join_group_button_by_page_id($page_id);
			
			if($group_buttons)
			{
				foreach($group_buttons as $button)
				{
					$content .= $this->create_group_button($button);
				}
			}
			if(isset($coment) && $coment == 1)
			{
				$content .= '<div style=" width:470px; position:relative; padding-top:10px; border-top:2px solid; border-top-color:#f1f1f1;"><div class="fb-comments" data-href='.$fb_url.' data-num-posts="10" data-width="470"></div></div>';	
			
			}
			
			
			
			return $content;            
		}	
		else
		{
			
			// GROUP JOIN BUTTON 
			$group_buttons = $this->Pages_Model->get_join_group_button_by_page_id($page_id);
			
			if($group_buttons)
			{
				foreach($group_buttons as $button)
				{
					$content .= $this->create_group_button($button);
				}
			}
			if(isset($coment) && $coment == 1)
			{
				$content .= '<div style=" width:470px; position:relative; padding-top:10px; border-top:2px solid; border-top-color:#f1f1f1;"><div class="fb-comments" data-href='.$fb_url.' data-num-posts="10" data-width="470"></div></div>';	
			
			}
			
			$content = str_replace("http://www.webpowerup.com",base_url(),$content);
			if(isset($coment) && $coment == 1)
				{
					
				 $content .= '<div class="fb-comments" data-href='.$fb_url.' data-num-posts="10" data-width="470"></div>';
?>

<script>
  window.fbAsyncInit = function() {
	FB.init({
	  appId      : '293519274018980', // App ID
	  //channelUrl : '<?=base_url().index_page();?>blog_managment/blog/<?=$blog_id?>', // Channel File
	  status     : true, // check login status
	  cookie     : true, // enable cookies to allow the server to access the session
	  xfbml      : true  // parse XFBML
	});

	// Additional initialization code here
  };

  // Load the SDK Asynchronously
  
	(function(d){
		 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		 if (d.getElementById(id)) 
	
	{return;}
		 js = d.createElement('script'); js.id = id; js.async = true;
		 js.src = 
	
	"//connect.facebook.net/en_US/all.js";
		 ref.parentNode.insertBefore(js, ref);
	   }(document));
</script>
<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
<?
				}
				
			return $content;
		}
	}
}
?>