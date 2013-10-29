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
     // print_r($_SESSION);   exit();
    //   echo $uri_segments.'>>>>>>>>>>';   exit();
	}
    
    

    

    

    
	//Used to show Site's Preview(homepage)
	function site($site_id)
	{
		//echo "<pre>";
		//echo $_SESSION['user_info']['user_id'];
		//print_r($_SESSION['user_info']);
		//exit();
        
		$rsltHomepage = $this->Site_Model->getHomepage($site_id);
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
        $this->template->add_js('js/jquery-1.5.1.min.js');
        $this->template->add_js('js/jquery.cycle.all.js');
        $this->template->add_js('js/arial.js');
        $this->template->add_js('js/radius.js');
        $this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
        $this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
        
        //exit;
        //print_r($arrayRegions['header']);exit;
		//$this->template->set_template('vantage');
        
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $site_id; 
		
		$this->template->write('title', $page_title);
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
            $this->template->write_view('sidebar', $temp_name.'/sidebar', $data); 
        }
        else
        //case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
        {
            //echo "doesnot exist";
            $data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
            $data['left_menus_type'] = 'site'; 
            $this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
            
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
	    
		$this->template->render();   
		
	}
    
    //used to preview Page(s) of the Site's Preview
	function page($site_id, $page_id)
	{
        $rsltPage = $this->Site_Model->getSitePage($site_id, $page_id);
		$rowPage = $rsltPage->row_array();
		
		//$rsltHomepage = $this->Site_Model->getHomepage($site_id);
		//$rowHomepage = $rsltHomepage->row_array();
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
        
        $page_background = $rowPage["page_background"];
        $data['page_background'] = $page_background; 
		$page_start_date = $rowPage["page_start_date"];  
		$page_end_date = $rowPage["page_end_date"];  
		$page_access = $rowPage["page_access"];
        
 
		
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
		/*
        echo "<pre>";
        print_r($data);
        exit;
        */
        
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
        
        $this->template->add_js('js/jquery-1.5.1.min.js');
        $this->template->add_js('js/jquery.cycle.all.js');
        $this->template->add_js('js/arial.js');
        $this->template->add_js('js/radius.js');
        $this->template->add_js('js/fancybox/jquery.fancybox-1.3.4.js');
        $this->template->add_js('js/fancybox/jquery.mousewheel-3.0.4.pack.js');
        
        
		$pageMenus["page_id"] = $page_id;
		$pageMenus["site_id"] = $site_id; 
		
		$this->template->write('title', $page_title);
		$this->template->write_view('logo', $temp_name.'/logo');
		$this->template->write('description', $page_desc); 
		$this->template->write('keywords', $page_keywords); 
        
        $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($site_id);
        if(isset($_SESSION['user_info']['user_id']))
        {
            $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($site_id,$_SESSION['user_info']['user_id']); 
            $data['other_top_navigation'] =  $other_top_navigation;      
        }
       
        // print_r($top_site_menu_basic); exit(); 
        $data['menu'] =  $top_site_menu_basic;
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
			
		$this->template->write_view('content','all_common/content', $data); 
		//15092011
        //$data['header_background'] = '';
        //$this->template->write_view('header', 'all_common/header', $data);
        
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
        else
        //case: template with leftbar & rightbar regions to show left menus in leftbar and right menus in rightbar regions respectively
        {
            //echo "doesnot exist";
            $data['left_menus'] = $this->my_template_menu->getLeftbar($site_id, $page_id);
            $data['left_menus_type'] = 'site'; 
            $this->template->write_view('leftbar', $temp_name.'/leftbar', $data); 
            
            $data['right_menus'] = $this->my_template_menu->getRightbar($site_id, $page_id);
            $this->template->write_view('rightbar', $temp_name.'/rightbar', $data);     
        }
        /*
        echo "<pre>";
        print_r($data);
        exit;
        */
		$this->template->render();       
	} 
	
	function get_page_content($page_id)
	{   
		$result = $this->Site_Model->get_page_content($page_id);
        $count = 1;
		if($result->num_rows()>0)
		{
			$content = "";
			foreach($result->result_array() as $row)
			{
				if($row['type']=="para")
				{
					$content .= '<div style="position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;"><p>'.$row['data'].'</p></div>';    
				}
				if($row['type']=="textarea")
				{
					$content .= '<div style="position:relative;top:'.$row['y'].'px;left:'.$row['x'].'px;"><textarea>'.$row['data'].'</textarea></div>';    
				}
                if($row['type']=="image")
                {
                    $image_path = base_url()."media/uploads/";
                    $content .= '<div><img src="'.$image_path.$row['data'].'" /></div>';    
                }
			}
			return $content;            
		}
		else
		{
			return "&nbsp;";
		}
	}
}
?>
