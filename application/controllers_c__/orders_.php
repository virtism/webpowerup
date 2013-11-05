<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class orders extends CI_Controller {
    
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
        $this->load->helper('security');
 
    }
 
 
   function index(){
 
        $data['title'] = "Manage Orders";
        $data['products'] = $this->product_model->getAllProducts();
        $data['categories'] = $this->Categories_model->getCategoriesDropDown();
        $data['orders'] = $this->orders_model->getAllOrders();
        $data['module'] = 'orders';
        
        //$this->load->view('ecommerce/Ecommerce_Category_Manage',$data);
        $this->template->write_view('content','ecommerce/orders_home',$data);
        $this->template->render();
 
    }
 
    function details($id){
 
        $data['title'] = "Order Details";

        $data['products'] = $this->product_model->getAllProducts();
        $data['categories'] = $this->Categories_model->getCategoriesDropDown();
        $data['orderdetails'] = $this->orders_model->getOrderDetails($id);

        $data['module'] = 'orders';
        //$this->load->view($this->_container,$data);
        $this->template->write_view('content','ecommerce/orders_details',$data);
        $this->template->render();
    }
 
    function paid($id){
        $this->orders_model->setpayment($id);
        
        redirect('orders/');
    }
 
    function delivered($id){
        $this->orders_model->setdelivery($id);

        redirect('orders/');
    }  
 
    function deleteitem($order_id, $order_item_id){
        $order_id = $this->uri->segment(4);
        $order_item_id = $this->uri->segment(5);
 
        if (count($this->orders_model->findsiblings($order_id)) < 2){
            $this->orders_model->deleteOrder($order_id);
            $this->orders_model->deleteOrderItem($order_item_id);
            
            redirect('orders/index','refresh');
        }else{
            $this->orders_model->deleteOrderItem($order_item_id);
            
            redirect('orders/details/'.$order_id,'refresh');
        }
    }
 
}//end class
?>