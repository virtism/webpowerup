<?php

class Thirdpartyintegration extends CI_Controller { // Our Cart class extends the Controller class

	var $site_id;
       
    function __construct()
    {
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
		$this->load->library('session');
		$this->load->model('orders_model');
        $this->load->model('Categories_model');
        $this->load->model('product_model');
        $this->load->model('customers_model');
        $this->load->model('shop_model');
        $this->load->helper('security');
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
		//Check user Login
		$this->load->library('check_user_login');
        $this->check_user_login->checkLogin();
        if(is_int($_SESSION["site_id"]))
		{
			$this->site_id = $_SESSION['site_id'];
		}
		else
		{
			$this->site_id = $_SESSION['site_id'];
		}
 
    }
 
  function index()
  {
   
     $this->breadcrumb->clear();
	 $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
	 $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
	 $this->breadcrumb->add_crumb('Store Settings' );
    // echo $this->site_id; 
    $data['title'] = "Store Settings";
    //$data['customers'] = $this->customers_model->getAllCustomers();
    $data['module'] = 'shop';
    $data['site_id'] = $this->site_id;
    $data['message'] = '';
    $data['store_settings'] = $this->shop_model->get_store_settings($this->site_id);
   // print_r($data['store_settings']);  exit();       
    $this->template->write_view('content','thirdparty/thirdparty_main.php',$data);
    $this->template->render();
  }
	
}	
?>