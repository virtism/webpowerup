<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
	session_start();
}
  
class Help_Center_Home extends CI_Controller {
   
	var $site_id;
	var $temp_name;
	var $user_id;
	var $page_id;
	   
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('Template');
		$this->template->set_template('shiptime');
		$this->load->model('Help_Center_Model');
		$this->load->model("Site_Model"); 
		$this->load->helper('security');
		$this->load->library('my_template_menu');  
		
		if(is_numeric($_SESSION["site_id"]))
		{
			$this->site_id = $_SESSION['site_id'];
		}
		else
		{
			$this->site_id = $_SESSION['site_id_custom'];
		}
		
		if(isset($_SESSION['user_info']['user_id'])) {
		$this->user_id = $_SESSION['user_info']['user_id']; 
		}
		$this->temp_name =  $this->my_template_menu->set_get_template($this->site_id); 
 
	}

  function index($topic_id=0)
  {
		   //echo $this->site_id.'<><><><><><><>'; 
		  // exit();
		  $data = array ();
		  
		  
	   // $_SESSION['site_id'] = $site_id;
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
		   
		   
		 $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
		
		 $site_user_id = 0 ;
		 
		 if(isset($_SESSION['user_info']['user_id']))
		 {
			$site_user_id = $_SESSION['user_info']['user_id'];
		 }

		$other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id, $site_user_id); 
		$data['other_top_navigation'] =  $other_top_navigation;               

		  $data['menu'] =  $top_site_menu_basic;
		  
		 $color_scheme_css =  $this->my_template_menu->set_site_color_scheme($this->site_id);
		 $this->template->add_css($color_scheme_css,'embed');
		  
		  $this->template->write_view('menu', $this->temp_name.'/menu', $data);
		  
		  
		  
		$data["left_menus_type"] = '';                                
		$data['title'] = "Store Settings";
		$data['module'] = 'shop';
		$data['message'] = ''; 
		 
		
		$my_css= ' .handcursor{ cursor:hand;  cursor:pointer;  } .switchgroup1{ margin:4px 0px 8px 36px; } ';
		$this->template->add_js('js/validation/jquery.js');    
		$this->template->add_js('js/mootool/expand/switchcontent.js');    
		$this->template->add_css('css/shiptime/shiptime.css'); 
		$this->template->add_css($my_css,'embed'); 
		// $this->template->add_js($my_js, 'embed');

		
		 $data['topics'] = $this->Help_Center_Model->fetch_all_topics($this->site_id);
		 if ( $topic_id!= 0 ){
			$data['faqs'] = $this->Help_Center_Model->fetch_faqs_spec($topic_id);
			$data['topic_name'] = $this->Help_Center_Model->fetch_topic_name($topic_id);
		 }else
		 {
			$data['faqs'] = $this->Help_Center_Model->fetch_faqs($this->site_id); 
			$data['topic_name'] = 'Most frequently Asked Questions';
		 }
		 /* echo '<pre>';
			print_r($data['topics']);
			exit();
			*/
		$Regions = $this->template->regions;
		
		if(isset($Regions['sidebar']))
		{
		  $data['menus'] = $this->my_template_menu->getSidebar($this->site_id, $page_id);  
		  $this->template->write_view('sidebar', $this->temp_name.'/sidebar', $data); 
		   
		}
		
		 if(isset($Regions['leftbar']))
		{  
			$data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
			
			$data['private_page_users'] =  $this->Menus_Model->get_private_users_Pages($this->site_id);
			$data['left_menus_type'] = 'site'; 
			
			$this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
		
			
		}
		 if(isset($Regions['rightbar']))
		{
			$data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
			$this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     	
		}   
			
			
			
			
		  
		$this->template->write_view('content','shiptime/Help_Center',$data);
		$this->template->render();
		

  }

  
 
}//end class
?>