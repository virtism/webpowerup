<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
	session_start(); }  
class Ticket extends CI_Controller {
	var $site_id;  
	var $flage_step;
	var $customer_id;
	function __construct()
	{
		parent::__construct();
		$this->load->model('orders_model');
		$this->load->model('Categories_model');
		$this->load->model('product_model');
		$this->load->model('customers_model');
		$this->load->model('Groups_Model');
		$this->load->model('cart_model'); // Load our cart model for our entire class
		$this->load->model('shop_model');  
		$this->load->model('support_ticket_model'); //ticket model
		$this->load->model("Site_Model");
		$this->load->model("Video_Gallery_Model");
		$this->load->library('cart');
        $this->load->library('session');
		$this->load->library('template');
		$this->load->library('my_template_menu');
		$this->load->helper('url');      
		$this->load->helper('html');
		$this->load->helper('security');
		
		//$this->site_id = $_SESSION['site_id'];   
		
		//$this->site_id = $this->uri->segment(3, 0);
		
		if(isset($_SESSION['login_info']['site_id']))
		{
			$this->site_id = $_SESSION['login_info']['site_id'];
		}
		else
		{
			$this->site_id = $this->uri->segment(3, 0);
		}
		
		$this->temp_name =  $this->my_template_menu->set_get_template($this->site_id); 
 
	}
	

 
   function index()
   {
	  	$this->is_login();
		 
		$site_user_id = "" ;
		
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
		
		$page_background = $rowHomepage["page_background"]; 
		$page_start_date = $rowHomepage["page_start_date"];  
		$page_end_date = $rowHomepage["page_end_date"];  
		$page_access = $rowHomepage["page_access"];
		
		$_SESSION['site_id'] = $this->site_id;
		
		 if(trim($page_title) == 'Home')
		 {
		   $data['ishome'] = 'ok';  
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
			$data['background_image'] = $b