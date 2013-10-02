<?php 
session_start();
class Blog extends CI_Controller
{
	var $site_id;
	var $blog_id;
	var $page_id;
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->load->library('template');
		$this->load->library('my_template_menu');
		
		$this->load->model('Promotional_Boxes_Model');
		$this->load->model("Site_Model");
		$this->load->model("usersmodel");
		$this->load->model("Slideshow_Model"); 
		$this->load->model('Footer_Model'); 
		$this->load->model('customers_model');
		$this->load->model("blog_model");
		$this->load->model("Video_Gallery_Model");
		$this->load->helper('url');    
		
		
	}
	
	function check_blog_status($blog_id)
	{
		$status = $this->blog_model->get_blog_status($blog_id);
		if ($status == "Published")
		{
			return true;
		}
		else
		{
			redirect("UsersController/login/sitelogin");
		}
	}
	
	function index($site_id,$page_id,$blog_id)
	{	
		$this->site_id = $this->uri->segment(3);
		$this->page_id = $this->uri->segment(4);
		$this->blog_id = $this->uri->segment(5);
		$data['site_id'] = $this->site_id;
		$data['page_id'] = $this->page_id;
		$site_id = $this->site_id;
		$_SESSION['site_id'] = $site_id; 
		
		
		$rsltPage = $this->Site_Model->getSitePage($site_id, $page_id);
		$rowPage = $rsltPage->row_array();
 
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
		$page_users = $rowPage["page_users"];
		$page_groups = $rowPage["page_groups"];
 
		$data['page_id2'] = $page_id; 
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes'; 
		   // $data['page_title'] =  $page_title;
		 }else
		 {
			 $data['ishome'] = 'no';
			 // $data['page_title'] =  '';
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
		
		$page_title = $data['page_title'];
		$this->template->write('title', $page_title);
		
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
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
		$is_seo_enabled = $this->config->item('seo_url'); 
	   /***********	Basic Menu Start		************/
		
		$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
		  
		$dataMenu = $top_site_menu_basic;
		
		$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
		
		$data['menu'] =  $top_site_menu_basic;
		
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
		
		
		if(isset($temp_name) && $temp_name != 'intro_template')
		 {
			$this->template->write_view('menu', $temp_name.'/menu', $data);  
		 }
		//$this->template->write_view('menu', $temp_name.'/menu', $data);
		
		
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
				else if ($page_groups != "" && $page_users != "") 
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
		 /////////////////////////////////////////////////////////////
		 //						Page Content
		 /////////////////////////////////////////////////////////////
		 
		 // page content data //
		 
		 $blog = $this->blog_model->get_blog_info_by_id($blog_id);
		 $data['blog'] = $blog;
		 
		 $year = $this->uri->segment(6,0);
		 if ($year == 0)
		 {
			
			 $posts = $this->blog_model->get_all_publish_blog_post($blog_id);
			 $data['posts'] = $posts;
		 }
		 else
		 {
			 
			 $posts = $this->blog_model->get_all_publish_blog_post_by_year($blog_id,$year);
			 $data['posts'] = $posts;
		 }
		 
		 
		 
		 $blog_years = $this->blog_model->blog_timeLine($blog_id);
		 $data['blog_years'] = $blog_years;
		 $data['blog_id'] = $blog_id;
		 // page content data //
		 
		$this->template->write_view('content','blog/front/blog_content', $data); 
		
		
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
		
		if(isset($Regions['leftbar']))
		//case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
		{
			//echo "doesnot exist";
			//echo "<pre>"; print_r($_SESSION); exit;
			$data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
			// echo "<pre>";	print_r($data['left_menus']);	echo "</pre>";
			
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
			 $data['page_title'] = $rowPage["page_title"];
			$data['left_menus_type'] = 'site'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}
		
		if(isset($Regions['rightbar']))
		{   
			$data['right_menus'] = $this->my_template_menu->getRightbar($site_id, $page_id);
			// 28 March - Mohsin
			
			// echo "<pre>"; print_r($data['right_menus']); echo "</pre>";
			
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
		
		$this->template->render(); 
	
	}
	
	function post($blog_id,$post_id)
	{
		$blog = $this->blog_model->get_blog_by_id($blog_id);
		$page_id = $blog['page_id'];
		$site_id = $blog['site_id'];
		$_SESSION['site_id'] = $site_id;
		
		$rsltPage = $this->Site_Model->getSitePage($site_id, $page_id);
		$rowPage = $rsltPage->row_array();
 
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
		$page_users = $rowPage["page_users"];
		$page_groups = $rowPage["page_groups"];
 
		$data['page_id2'] = $page_id; 
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'yes'; 
		   // $data['page_title'] =  $page_title;
		 }else
		 {
			 $data['ishome'] = 'no';
			 // $data['page_title'] =  '';
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
		
		$page_title = $data['page_title'];
		$this->template->write('title', $page_title);
		
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
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
		
		$is_seo_enabled = $this->config->item('seo_url'); 
		$data['color_scheme'] = $this->Menus_Model->get_scheme_color($site_id);
	   /***********	Basic Menu Start		************/
		
		$top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id,$is_seo_enabled);
		  
		$dataMenu = $top_site_menu_basic;
		
		$top_site_menu_basic = $this->Menus_Model->make_menu_top_old($dataMenu,'preview',$is_seo_enabled,$temp_name); 	// menu without style
		
		$data['menu'] =  $top_site_menu_basic;
		
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
		
		
		if(isset($temp_name) && $temp_name != 'intro_template')
		 {
			$this->template->write_view('menu', $temp_name.'/menu', $data);  
		 }
		//$this->template->write_view('menu', $temp_name.'/menu', $data);
		
		
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
				else if ($page_groups != "" && $page_users != "") 
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
		 /////////////////////////////////////////////////////////////
		 //						Page Content
		 /////////////////////////////////////////////////////////////
		 
		 // page content data //
		 
		 
		 
		 if(isset($_SESSION['login_info']['customer_id']))
		 {
			 $data['customer_logged_in'] = 1;
		 }
		 else
		 {
			 $data['customer_logged_in'] = 0;
		 }
		 
		 $post = $this->blog_model->get_post_details_by_id($post_id);
		 $data['post'] = $post;
		 
		 $blog_years = $this->blog_model->blog_timeLine($blog_id);
		 $data['blog_years'] = $blog_years;
		 $data['blog_id'] = $blog_id;
		
		 $this->load->model("post_comment_model");
		 $comments = array();
		 $comments_only = $this->post_comment_model->get_approved_comment($post_id);
		 if($comments_only)
		 {
			 foreach($comments_only as $comment)
			 {
				
				 $replys = $this->post_comment_model->get_approved_reply_of_comment($comment['id']);
				
				 if($replys)
				 {
					$comment["replies"] =  $replys;
				 }
				 $comments[] = $comment;
			 }
			 
		 }
		 
		 $data['comments'] = $comments;
		 // page content data //
		 
		$this->template->write_view('content','blog/front/post_detail', $data); 
		
		
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
		
		if(isset($Regions['leftbar']))
		//case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
		{
			//echo "doesnot exist";
			//echo "<pre>"; print_r($_SESSION); exit;
			$data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
			// echo "<pre>";	print_r($data['left_menus']);	echo "</pre>";
			
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
			 $data['page_title'] = $rowPage["page_title"];
			$data['left_menus_type'] = 'site'; 
			$this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
		}
		
		if(isset($Regions['rightbar']))
		{   
			$data['right_menus'] = $this->my_template_menu->getRightbar($site_id, $page_id);
			// 28 March - Mohsin
			
			// echo "<pre>"; print_r($data['right_menus']); echo "</pre>";
			
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
		
		$this->template->render(); 
	
	}
	
	
	function comment()
	{
		 if(isset($_SESSION['login_info']['customer_id']) )
		 {
		 	$user_id = $_SESSION['login_info']['customer_id'];
		 }
		 else 
		 {
			 $user_id = 0;
		 }
		 $email = $this->input->post("email");
		 $name = $this->input->post("name");
		 $post_id = $this->input->post("post");
		 $blog_id = $this->input->post("blog");
		 $message = $this->input->post("message");
		 $date = date("Y-m-d H:i:s");
		 $status = "unapprove";
		 
		 $this->load->model("post_comment_model");
		 $r = $this->post_comment_model->insert_comment($user_id,$post_id,$message,$date,$status,$email,$name);
		 
		 if($r == 1)
		 {
			 $msg = "Comment posted successfully. Please wait for admin approval.";
		 }
		 else if ($r == 2)
		 {
			 $msg = "You are banned from commenting";
		 }
		 else
		 {
			 $msg = "comment not posted successfully";
		 }
		 $this->session->set_flashdata("rspComment",$msg);
		 
		 redirect("blog/post/".$blog_id."/".$post_id);
 
		 
	}
	
	function reply()
	{
		 if(isset($_SESSION['login_info']['customer_id']) )
		 {
		 	$user_id = $_SESSION['login_info']['customer_id'];
		 }
		 else 
		 {
			 $user_id = 0;
		 }
		 
		 $comment_id = $this->input->post("comment_id");
		 $email = $this->input->post("email");
		 $name = $this->input->post("name");
		 $post_id = $this->input->post("post");
		 $blog_id = $this->input->post("blog");
		 $message = $this->input->post("message");
		 $date = date("Y-m-d H:i:s");
		 $status = "unapprove";
		 
		 $this->load->model("post_comment_model");
		 $r = $this->post_comment_model->insert_reply($comment_id,$user_id,$post_id,$message,$date,$status,$email,$name);
		 
		 if($r == 1)
		 {
			 $msg = "Comment posted successfully. Please wait for admin approval.";
		 }
		 else if ($r == 2)
		 {
			 $msg = "You are banned from commenting";
		 }
		 else
		 {
			 $msg = "comment not posted successfully";
		 }
		 $this->session->set_flashdata("rspComment",$msg);
		 
		 redirect("blog/post/".$blog_id."/".$post_id);
 
		 
	}
	
	
	
}
?>