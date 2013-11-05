<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*if(!session_start()){
    session_start(); }  */
class color_scheme extends CI_Controller {
     var $site_id;
    function __construct()
    {
        parent::__construct();
        // Check for access permission
       // check('Categories');
 
        $this->load->model('product_model');
        $this->load->model('categories_model');
        
        $this->load->helper('security');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
        $this->template->set_template('gws');
       // $this->site_id = $_SESSION['site_id'];
    }
 
   function index(){
        // Setting variables
        $data['title'] = "Manage Products";
      //  $data['products'] = $this->product_model->getAllProducts($this->site_id);
      //  $data['categories'] = $this->categories_model->getCategoriesDropDown($this->site_id);
        $data['module'] = 'Products_Management';
        //$this->load->view('ecommerce/Ecommerce_Product_Home',$data);
        $this->template->add_js('js/validation/jquery.js');  
        
        $this->template->write_view('content','color_pic_menu',$data);
        $this->template->render();
    }

}//end class
?>