<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
    session_start(); }  
class scheme_settings extends CI_Controller {
    var $site_id;  
    var $user_id;  

    function __construct()
    {
        parent::__construct();
        
        $this->load->helper('url');
		$this->load->helper('custom_helper');
        $this->load->library('Template');
        $this->template->set_template('gws');
        $this->load->model('Scheme_Settings_Model');
        $this->load->helper('security');
        $this->site_id = $_SESSION['site_id'];
		$this->load->library('session');
        //$this->user_id = $_SESSION['user_info']['user_id'];
        
      
 
    }
    function index(){
		
		is_login();
        // Setting variables
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Scheme Settings' );
		
        $data['title'] = "Scheme Settings";
        //  $data['products'] = $this->product_model->getAllProducts($this->site_id);
        //  $data['categories'] = $this->categories_model->getCategoriesDropDown($this->site_id);
        $data['module'] = 'Products_Management';
        $data['scheme'] = $this->Scheme_Settings_Model->get_scheme_color($this->site_id);
        //print_r($data['scheme']);
        //$this->load->view('ecommerce/Ecommerce_Product_Home',$data);
        // $this->template->add_js('js/jscolor/jscolor.js');
        //  $this->template->add_js('js/jscolor/jscolor.js','import',TRUE);
        // $this->template->add_js('js/validation/jquery.js'); 

        $this->template->write_view('content','color_pic_menu',$data);
        $this->template->render();
    }
       function save_color_scheme()
    {
       // echo '<pre>';  print_r($_POST); echo 'I am here ';  echo '</pre>'; exit();
        
        if($this->Scheme_Settings_Model->change_color_scheme($this->site_id))
        {
           // echo 'TRUE';
           return true;
        }
        else
        {
            // echo 'FALSE';
            return false;
        }
        
        
    }      
    function change_scheme()
    {
      //  echo '<pre>';  print_r($_POST); echo 'I am here ';  echo '</pre>'; exit();
        
        if($this->Scheme_Settings_Model->update_scheme($this->site_id))
        {
           // echo 'TRUE';
           return true;
        }
        else
        {
            // echo 'FALSE';
            return false;
        }
        
        
    }
    
    
    
}  
?>
