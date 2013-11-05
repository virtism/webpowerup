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
		$this->load->helper('security');
        $this->load->library('form_validation');
        $this->load->library('Template');
		$this->load->library('session');
		$this->load->library('upload');   
		$this->load->library('Webpowerup');
		//Check user Login
		$this->load->library('check_user_login');
        $this->check_user_login->checkLogin();
        $this->load->model('orders_model');
        $this->load->model('Categories_model');
        $this->load->model('product_model');
        $this->load->model('customers_model');
        $this->load->model('shop_model');
		$this->load->Model('UsersModel');
		$this->load->model("Invoice_Model");
       
		
		$this->webpowerup->initialize_template();
		
        if(is_numeric($_SESSION["site_id"]))
		{
			$this->site_id = $_SESSION['site_id'];
		}
		else if(is_int($this->uri->segment(2)))
		{
			$this->site_id = $this->uri->segment(2);
		}
 
    }
 
  function index($site_id = '')
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
	$data['user_data'] = $this->UsersModel->get_user_details_by_user_id($_SESSION['user_info']['user_id']);
	$data['countries'] = $this->Invoice_Model->get_country();
	$data['states'] = $this->Invoice_Model->get_states();
	//echo "<pre>"; print_r($data);  exit();       
	$this->template->write_view('content','ecommerce/Store_Home',$data);
	$this->template->render();
  }
 
  function enable_store ()
  {
      
     if( $this->shop_model->on_store($this->site_id))
     {
            $data['message'] = 'Your Store Active.';
			$data['store_settings'] = $this->shop_model->get_store_settings($this->site_id);
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
  
  function ajax_call_states($country_id=0)
  {
		$country_id = $_REQUEST['country_id'];
		$states = $this->Invoice_Model->getstates_by_country_id($country_id);
		if(empty($states))
		{
			// echo '<input type="text" id="state1" name="state" size="20" />';
			echo "";
		}
		else
		{
			
			//echo '<div  style="position:relative;">';
			echo   '<select class="none" id="state2" name="state" style="width:150px;" size="1">';
				foreach($states as $state) 
				{
					echo "<option value=".$state['zone_code'].">".$state['zone_name']."</option>";
				}
																	
			 echo '</select>';
			 //echo '</div>';	
			
			
		}
	}
  
  
  function settings()
  {
    //echo "<pre>";print_r($_REQUEST);//print_r($_FILES);exit;
	if ($this->input->post('action') && $this->input->post('action') == "setStore")
    {
        //
		//$this->checkLogin();
		
		//Set Publish Value
		if(isset($_POST['logo_check']) && $_POST['logo_check'] == "Yes")
		{
				$publish = $_POST['logo_check'];
		}
		else
		{
				$publish = "No";
		}//End 
		//echo $publish;exit;
        if($_FILES["logo_image"]["tmp_name"]!="")
        {     
		      
			$fileName = $this->input->post("code").$_FILES['logo_image']['name'];
			
			$config['file_name'] = str_replace(" ","_",$fileName);
			$config['upload_path'] 	= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/logo/'; 
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'],0777);
			} 
		              
            $config['allowed_types'] = 'gif|jpg|ico|jpeg|png|GIF|JPG|JPEG|PNG'; 
		
            $this->upload->initialize($config);
			if ($this->upload->do_upload("logo_image"))
			{
				$file_name = $config['file_name'];
				// if upload then create thumbnail
				$logoInfo = getimagesize($_FILES['logo_image']['tmp_name']);
				//echo "<pre>";	print_r($logoInfo);	die();
				$image_width = $logoInfo[0];
				$image_height = $logoInfo[1];
				
				
				$config_resize['image_library'] = 'gd2';
				$config_resize['source_image'] = $config['upload_path'].$file_name;
				$config_resize['new_image'] = $config['upload_path'];
				$config_resize['quality'] = "100%";
				$config_resize['create_thumb'] = TRUE;
				$config_resize['maintain_ratio'] = TRUE;
				$config_resize['width'] = 150;
				$config_resize['height'] = 100;
				
				$this->load->library('image_lib', $config_resize); 
				
				$this->image_lib->resize();
					
				
				
				$name = explode(".",$file_name);
				$thumbnail_name = $name[0]."_thumb.".$name[1];
				$response = "Logo have been uploaded successfully";
				$this->session->set_userdata('rsp_logo_error', 0);
	
			}
			
            else
			{
			
				$response = $this->upload->display_errors();
				$this->session->set_userdata('rsp_logo_error', 1);
				
			}
			$this->session->set_flashdata('rsp_logo', $response);
		}
		else
		{
				$fileName = trim($this->input->post('hidden_filename'));
		}
		
		$data = array(

                'required' =>  trim($this->input->post('required')),

                'product_view' =>  trim($this->input->post('product_view')),

                'product_per_page' =>  trim($this->input->post('product_per_page')),

                'link_per_page' =>  trim($this->input->post('link_per_page')),

	 			'paypal_id' =>  trim($this->input->post('required_paypal')),
				
				'store_logo' =>  $fileName,
				
				'publish' =>  $publish
				  

                 );
		
		
		//print_r($data);exit; 
		//echo $this->site_id;exit;
		$this->shop_model->updateUserInfo($this->input->post("user_id"));
		$this->shop_model->set_store($this->site_id, $data);
		redirect('shop/index','refresh');
    } 
  }
  
 
}//end class
?>