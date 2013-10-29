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
		$this->load->model('Footer_Model');
		$this->load->model("Slideshow_Model");  
		$this->load->library('pagination');
		$this->load->library('session');    
		$this->load->helper('url');   
		$this->load->library('form_validation');       
		$this->load->helper('html'); 
		$this->load->library('template');
		
		
		$this->load->library('my_template_menu');
		
	  // $uri_segments =  parse_str($_SERVER['QUERY_STRING'],$_GET);
	   $uri_segments =  uri_string();
	   $pieces = explode("/", $uri_segments);
	   
	  $_SESSION['site_id']= end($pieces);
	  
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
		$rsltHomepage = $this->Site_Model->getHomepage($site_id);
		$footer_content = $this->Footer_Model->get_footer_content($site_id);
		if(isset($footer_content)&&!empty($footer_content)){
        $data["footer_content"] = $footer_content["content"];
        }
		
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
		
		$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
		$this->template->add_css($color_scheme_css,'embed'); 
		
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
		$pageMenus["site_id"] = $site_id; 
		
		//$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		//$this->template->write('header', $header);
		//$this->template->write('background', $background);
		
		
		 $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id);
		 if(isset($_SESSION['user_info']['user_id']))
		 {
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($site_id,$_SESSION['user_info']['user_id']); 
			$data['other_top_navigation'] =  $other_top_navigation;   
		 }
		 
		 //print_r($other_top_navigation); exit(); 
		 $data['menu'] =  $top_site_menu_basic;
		 
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
		
        $data['main_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'main');
        $this->template->write_view('top_slider','all_common/top_slider', $data);
        
		$data['top_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'top');
		$data['bottom_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'bottom');  
		$data['left_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'left');  
		$data['right_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'right');
        
		$this->template->write_view('content','all_common/content', $data); 
		$this->template->write_view('header', 'all_common/header', $data);
		
		//get page regions
		$Regions = $this->template->regions;
		
		//see what region(s) are defined for menus: either Sidebar or Leftbar & Rightbar
		if(isset($Regions['sidebar']))
		//case: template with a sidebar region to show menus
		{
			//echo "exist";
			$data['menus'] = $this->my_template_menu->getSidebar($site_id, $page_id);
			
			//echo "<pre>";
			//print_r($data['menus']);
			//exit;
			
			
			$this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
		}
		else if(isset($Regions['leftbar']))
		//case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
		{
			//echo "doesnot exist";
			$data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
			$data['left_menus_type'] = 'site'; 
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
	function page($site_id, $page_id)
	{
		$_SESSION['site_id'] = $site_id; 
		$rsltPage = $this->Site_Model->getSitePage($site_id, $page_id);
		$rowPage = $rsltPage->row_array();
		
	//	echo "<pre>";
	//	print_r($rowPage);
		//exit;
	  
		$data["mode"] = '';
		$data["site_id"] = $rowPage["site_id"];
		$data["page_id"] = $rowPage["page_id"];
		
		$page_status = $rowPage["page_status"];
		$page_id = $rowPage["page_id"];       
		$data["site_name"] = $rowPage["site_name"];
		$page_title = $rowPage["page_title"];
		$page_desc = $rowPage["page_desc"]; 
		$page_keywords = $rowPage["page_keywords"];
		$page_header = $rowPage["page_header"];
		$data['page_header'] = $page_header;
		
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
			$data["color_after_image"] = $rowBackgroundImage['color_after_image'];
		}
		
		//get site template
		$temp_name =  $this->my_template_menu->set_get_template($site_id); 
		
		$color_scheme_css =  $this->my_template_menu->set_site_color_scheme($site_id);
		$this->template->add_css($color_scheme_css,'embed');
		
		$this->template->add_js('js/jquery-1.5.1.min.js');
		$this->template->add_js('js/jquery.cycle.all.js');
		$this->template->add_js('js/arial.js');
		$this->template->add_js('js/radius.js');
		$this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
		$this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
		
		$this->template->add_js('js/nivo-slider/jquery.nivo.slider.pack.js'); 
		$this->template->add_css('js/nivo-slider/nivo-slider.css'); 
		
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $site_id; 
		
		//$this->template->write('title', $page_title);
		
		$data['logo_image'] = $this->Site_Model->get_logo_image($site_id);
		
		$this->template->write_view('logo', $temp_name.'/logo', $data);
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		
		$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id);
		if(isset($_SESSION['user_info']['user_id']))
		{
			$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($site_id, $_SESSION['user_info']['user_id']); 
			$data['other_top_navigation'] =  $other_top_navigation;      
		}
	   
		$data['menu'] =  $top_site_menu_basic;
		
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
				if($this->Pages_Model->isPageforUser($page_id, $user_id) == TRUE)
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
		
        $data['main_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'main');
        $this->template->write_view('top_slider','all_common/top_slider', $data);
        
		$data['top_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'top');
		$data['bottom_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'bottom');  
		$data['left_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'left');  
		$data['right_slideshows'] = $this->Slideshow_Model->get_slideshow($site_id, $page_id, 'right');
         
		 
		$this->template->write_view('content','all_common/content', $data); 
		
		//get page regions
		$Regions = $this->template->regions;
		
		//see what region(s) are defined for menus: either Sidebar or Leftbar & Rightbar
		if(isset($Regions['sidebar']))
		//case: template with a sidebar region to show menus
		{
			//echo "exist";
			$data['menus'] = $this->my_template_menu->getSidebar($site_id, $page_id);
			$this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
		}
		else if(isset($Regions['leftbar']))
		//case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
		{
			//echo "doesnot exist";
			$data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
			$data['left_menus_type'] = 'site'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}else if(isset($Regions['rightbar'])){   
			$data['right_menus'] = $this->my_template_menu->getRightbar($site_id, $page_id);
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
		
		$content = '<div><h2>'.$page_title.'</h2></div>';
		
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
		
		$content = '<div style="height:auto"><h2>'.$page_title.'</h2></div>';
		
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
					$content .= '<div style="clear:both;position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$row['data'].'</div>';    
				}
				if($row['type']=="textarea")
				{
					$content .= '<div style="position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;">'.$row['data'].'</div>';    
				}
				if($row['type'] == "image")
				{
					
					
				//	echo $user_style."<br>";
					
					$content .= '<div style="clear:both;height:auto;">'.$user_anchor_open.'<img '.$user_style.' src="'.$image_path.$row['image'].'" />'.$user_anchor_close.'</div>';    
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
}
?>
