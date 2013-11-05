<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
    session_start(); }  
class Products_Management extends CI_Controller {
     var $site_id;
    function __construct()
    {
        parent::__construct();
        // Check for access permission
       // check('Categories');
 
        $this->load->model('product_model');
        $this->load->model('categories_model');
        $this->load->model("Groups_Model"); 
        $this->load->helper('security');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Template');
        $this->template->set_template('gws');
        $this->site_id = $_SESSION['site_id'];
    }
 
   function index(){
        // Setting variables
        $data['title'] = "Manage Products";
        $data['products'] = $this->product_model->getAllProducts($this->site_id);
        $data['categories'] = $this->categories_model->getCategoriesDropDown($this->site_id);
        $data['module'] = 'Products_Management';
        //$this->load->view('ecommerce/Ecommerce_Product_Home',$data);
        $this->template->write_view('content','ecommerce/Ecommerce_Product_Home',$data);
        $this->template->render();
    }
 
    function create($invoice_create_time=0){

          $data['invoice_create_time']= $invoice_create_time;
		  if ($this->input->post('action') && $this->input->post('action') == 'product_add')
		   {
			  /*echo "<pre>";
			  print_r($_REQUEST);
			  exit;*/
			   $items_image = $this->input->post('image');
			   $items_attribute = $this->input->post('attribute');  
			   $product_id=$this->product_model->addProduct($this->site_id,$items_image,$items_attribute);
			 
			  if($invoice_create_time==2)
			  {
			  	redirect('invoice/index');
			  }
			  else
			  {
			  	 redirect('Products_Management/index','refresh');
			  }			  
			}else{
				// this must be the first time, so set variables
				$data['title'] = "Add New Product ";
				$data['categories'] = $this->categories_model->getCategoriesDropDown($this->site_id);
				$data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
				$data['module'] = 'Products_Management';
			    // $this->load->view('ecommerce/Ecommerce_Product_add',$data);
				$this->template->write_view('content','ecommerce/Ecommerce_Product_add',$data);
				$this->template->render();
			}
		}
 
    function edit($id=0){
        if ($this->input->post('action') && $this->input->post('action') == 'edit_product'){
            // fields filled up so,
            $this->product_model->updateProduct($this->site_id);
            redirect('Products_Management/index','refresh');
        }else{
            //$id = $this->uri->segment(4);
            $data['title'] = "Edit Product";
            // $data['main'] = 'admin_product_edit';
            $data['product'] = $this->product_model->getProduct($id);
            $data['attribute_data'] = $this->product_model->getProduct_attribute($id);
			//exit;
            $data['digital'] = $this->product_model->getProduct_digital($id);      
            $data['categories'] = $this->categories_model->getCategoriesDropDown($this->site_id);
			$data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
            if (!count($data['product'])){
                redirect('Products_Management/index','refresh');
            }
            $data['module'] = 'Products_Management';
           // $this->load->view('ecommerce/Ecommerce_Category_Edit',$data);
            $this->template->write_view('content','ecommerce/Ecommerce_Product_Edit',$data);
            $this->template->render();
        }
    }
 
    function delete($id){
        $this->product_model->deleteProduct_soft($id);
      //  $this->product_model->deleteProduct_hard($id);
        redirect('Products_Management/index','refresh');
    }
 
    function changeProductStatus($id){
        $this->product_model->changeProductStatus($id);
        redirect('Products_Management/index','refresh');
    }
 
    function batchmode(){
        $this->product_model->batchUpdate();
        redirect('Products_Management/index','refresh');
    }
 
    function export(){
        $this->load->helper('download');
        $csv = $this->product_model->exportCsv();
        $name = "product_export.csv";
        force_download($name,$csv);
 
    }
 
    function import(){
        if ($this->input->post('csvinit')){
            $data['csv'] = $this->product_model->importCsv();
            $data['title'] = "Preview Import Data";
            $data['module'] = 'Products_Management';
            $this->load->view($this->_container,$data);
 
        }elseif($this->input->post('csvgo')){
            if (eregi("finalize", $this->input->post('submit'))){
                $this->product_model->csv2db();
                $this->session->set_flashdata('message','CSV data imported');
            }else{
                $this->session->set_flashdata('message','CSV data import cancelled');
            }
            redirect('Products_Management/index','refresh');
        }
    }
 
}//end class
?>