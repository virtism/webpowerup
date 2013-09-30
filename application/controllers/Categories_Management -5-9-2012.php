<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
    session_start(); } 
class Categories_Management extends CI_Controller {
    var $site_id;
    
    function __construct()
    {
        parent::__construct();
        // Check for access permission
       // check('Categories');
        $this->load->helper('url');
		$this->load->helper('custom_helper');
        $this->load->library('form_validation');
        $this->load->library('Template');
		$this->load->library('session');
        $this->template->set_template('gws');
        $this->load->model('Categories_model');
        $this->load->helper('security');
        $this->site_id = $_SESSION['site_id'];
        //echo  $this->site_id.'>>>>>>>'; exit();
       // print_r($_SESSION); exit();
 
    }
 
    function index(){
		
		is_login();
		$link = substr(uri_string(),1);
		$category_link = base_url().$link;
		$this->session->set_userdata("category_link", $category_link); 
		
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Categories' );
	
        $data['title'] = "Manage Categories";
        $data['categories'] = $this->Categories_model->getAllCategories($this->site_id);
        $data['module'] = 'Categories_Management';
        //$this->load->view('ecommerce/Ecommerce_Category_Manage',$data);
        $this->template->write_view('content','ecommerce/Ecommerce_Category_Manage',$data);
        $this->template->render();
    }
 
    function create(){
 
 		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Categories', $this->session->userdata("category_link") ); 
		$this->breadcrumb->add_crumb('Create');
		
        if ($this->input->post('action') && $this->input->post('action') == 'create_category'){
            $this->Categories_model->addCategory($this->site_id);
            $string = $this->input->post('name');
            //$folder = createdirname($string);
            //$folder = 'assets/images/'.$folder;
            //create_path($folder);
 
            // we used to use like this. $this->session->set_flashdata('message','Category created');
            // now we are using Bep's flashMsg function to show messages.
           // flashMsg('success',$this->lang->line('userlib_category_created'));
            redirect('Categories_Management/index','refresh');
        }else{
            $data['title'] = "Create Category";
            $data['categories'] = $this->Categories_model->getTopCategories($this->site_id);
            $data['module'] = 'Categories_Management';
            //$this->load->view('ecommerce/Ecommerce_Category_add',$data);
            $this->template->write_view('content','ecommerce/Ecommerce_Category_add',$data);
            $this->template->render();
        }
    }
 
    function edit($id=0)
	{
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Categories', $this->session->userdata("category_link") ); 
		$this->breadcrumb->add_crumb('Edit');
   		//echo "i m here<pre>";
		//print_r($_REQUEST);
		/*print_r($_POST);
		exit;*/
		//if(isset($_REQUEST["action"]) && $_REQUEST["action"] == 'edit_category')
		if($this->input->post('action') && $this->input->post('action') == 'edit_category')
		{
	
       		$this->Categories_model->updateCategory($id,$this->site_id);
            redirect('Categories_Management/index','refresh');
        }
		else
		{
           // echo "i m here in else part controler";
		//	exit;
			//$id = $this->uri->segment(4);
            $data['title'] = "Edit Category";
            // $data['main'] = 'admin_cat_edit';
            $data['category'] = $this->Categories_model->getCategory($id,$this->site_id);
            $data['categories'] = $this->Categories_model->getTopCategories($this->site_id); 
            if (!count($data['category'])){
                redirect('Categories_Management/index','refresh');
            }
            $data['module'] = 'Categories_Management';
            //$this->load->view('ecommerce/Ecommerce_Category_Edit',$data);
            $this->template->write_view('content','ecommerce/Ecommerce_Category_Edit',$data);
            $this->template->render();
        }
    }
	
    function delete($id){
 
        $cat = $this->Categories_model->getCategory($id,$this->site_id);
        $string = $cat['cat_name'];
        //$catname = createdirname($string);
        //$catname = 'assets/images/'.$catname;
        //recursive_remove_directory($catname, $empty=FALSE);
 
        // $orphans = $this->Categories_model->checkOrphans($id);
        // if (count($orphans)){
        //    $this->session->set_userdata('orphans',$orphans);
        //     redirect('Categories_Management/reassign/'.$id,'refresh');
        //}else{
            
            //$this->Categories_model->deleteCategory($id);
            $this->Categories_model->deleteCategory_soft($id);
 
         
            redirect('Categories_Management/index','refresh');
       // }
    }
 
    function export(){
        $this->load->helper('download');
        $csv = $this->Categories_model->exportCsv();
        $name = "category_export.csv";
        force_download($name,$csv);
     }
 
    function reassign($id=0){
        if ($_POST){
            $this->load->module_model('products','MProducts');
            $this->MProducts->reassignProducts();
            $id = $this->input->post('id');
            $this->Categories_model->deleteCategory($id); // this is not working at the moment.
 
            flashMsg('success',$this->lang->line('userlib_category_reassigned'));
            redirect('Categories_Management/admin/index','refresh');
        }else{
            //$id = $this->uri->segment(4);
            $data['category'] = $this->Categories_model->getCategory($id,$this->site_id);
            $data['title'] = "Reassign Products";
            $data['main'] = 'admin_cat_reassign';
            $data['Categories_Management'] = $this->Categories_model->getCategoriesDropDown();
            // Set breadcrumb
            $this->bep_site->set_crumb($this->lang->line('userlib_category_reassign'),'Categories_Management/admin/reassign');
 
            $this->load->vars($data);
            $this->load->view('dashboard');
        }
    }
 
    function changeCatStatus($id){
        //$id = $this->uri->segment(4);
        $this->Categories_model->changeCatStatus($id,$this->site_id);
 
        redirect('Categories_Management/index','refresh');
    }
 
    function _remove_path($folder){
 
        $files = glob( $folder . DIRECTORY_SEPARATOR . '*');
        foreach( $files as $file ){
            if($file == '.' || $file == '..'){continue;}
            if(is_dir($file)){
                $this->_remove_path( $file );
            }else{
                unlink( $file );
            }
        }
        rmdir( $folder );
    }
 
}//end class
?>