<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
    session_start();
}
  
class shop extends CI_Controller {
   
    var $site_id;
       
    function __construct()
    {
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
        $this->template->set_template('gws');
        $this->load->model('orders_model');
        $this->load->model('Categories_model');
        $this->load->model('product_model');
        $this->load->model('customers_model');
        $this->load->model('shop_model');
        $this->load->helper('security');
        $this->site_id = $_SESSION['site_id'];
 
    }
 
  function index()
  {
    // echo $this->site_id; 
    $data['title'] = "Store Settings";
    $data['customers'] = $this->customers_model->getAllCustomers();
    $data['module'] = 'shop';
    $data['site_id'] = $this->site_id;
    $data['message'] = '';
    $data['store_settings'] = $this->shop_model->get_store_settings($this->site_id);
   // print_r($data['store_settings']);  exit();       
    $this->template->write_view('content','ecommerce/Store_Home',$data);
    $this->template->render();
  }
 
  function enable_store ()
  {
      
     if( $this->shop_model->on_store($this->site_id))
     {
            $data['message'] = 'Your Store Active.';
            redirect('shop/index',$data);
         
     }  
    
      
  }
  function disable_store ()
  {
     
      
     if($this->shop_model->off_store($this->site_id))
     {
          $data['message'] = 'Your Store DeActivate.';
          redirect('shop/index',$data);
         
     }
      
      
  }
  function settings()
  {
    if ($this->input->post('action') && $this->input->post('action') == "setStore")
    {
          $this->shop_model->set_store($this->site_id); 
          redirect('shop/index','refresh');
        
    }  
      
      
      
  }
  
 
}//end class
?>