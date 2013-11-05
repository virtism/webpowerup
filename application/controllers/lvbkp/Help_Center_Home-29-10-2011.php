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
        //$this->site_id = $_SESSION['site_id'];
        
		if(isset($_SESSION['user_info']['user_id'])) {
        $this->user_id = $_SESSION['user_info']['user_id']; 
        }
		if(isset($_SESSION["site_id"]))
		{
		   	$site_id = $_SESSION["site_id"];
			$this->site_id = $site_id;
		}
		else if(isset($_REQUEST["site_id"]))
		{
			$site_id = $_REQUEST["site_id"];
			$this->site_id = $site_id;
		}
		   
        $this->temp_name =  $this->my_template_menu->set_get_template($this->site_id); 
 
    }

  function index($topic_id=0)
  {
           
		//   $site_id = $_REQUEST["site_id"];
		
		
		  // echo $this->site_id.'<><><><><><><>'; 
          // exit();
          $data = array ();
          
          
        $rsltHomepage = $this->Site_Model->getHomepage($this->site_id);
        $rowHomepage = $rsltHomepage->row_array();
        
		//echo "<pre>";
		//print_r($rowHomepage);
		//exit;
        
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
          
          
          $top_site_menu_basic =  $this->Menus_Model->top_navigation_default($this->site_id);
          $other_top_navigation =  $this->Menus_Model->top_navigation_eshop($this->site_id,$this->user_id);  
         // $this->template->write('title', 'Online Shop');
          $data['site_id']=$this->site_id;
          $this->template->write_view('logo', $this->temp_name.'/logo', $data);
          $this->template->write('description', 'online product store'); 
          $this->template->write('keywords', 'online product store , Eshop,Ecommerce'); 
          $data["site_name"] = '';  
           
           
            

          $menu_data['menu'] =  $top_site_menu_basic;
          $menu_data['other_top_navigation'] =  $other_top_navigation; 
          
          $this->template->write_view('menu', $this->temp_name.'/menu', $menu_data);
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
        else
        {  
            $data['left_menus'] = $this->my_template_menu->getLeftbar($this->site_id, $page_id);
            $data['left_menus_type'] = 'site'; 
            $this->template->write_view('leftbar', $this->temp_name.'/leftbar', $data); 
            
            $data['right_menus'] = $this->my_template_menu->getRightbar($this->site_id, $page_id);
            $this->template->write_view('rightbar', $this->temp_name.'/rightbar', $data);     
        }   
            
            
            
            
          
        $this->template->write_view('content','shiptime/Help_Center',$data);
        $this->template->render();
        

  }

  
 
}//end class
?>