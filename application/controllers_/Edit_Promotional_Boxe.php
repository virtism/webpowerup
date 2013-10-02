<?php
if(!session_start()){
    session_start();
}
  class Edit_Promotional_Boxe extends CI_Controller{
  
      public $ck_data     =     array(); 
      
      function __construct()
      {
          
          parent::__construct();
          
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('Template');
		$this->load->library('session');
        
		// call load_asset_form
		$this->load_asset_form(); 
		$this->load->model('Promotional_Boxes_Model');  
		$this->load->model('product_model');      
		$this->load->model('Menus_Model'); 
		$this->load->model('PagesModel');
		$this->load->model('Groups_Model');
		$this->site_id = $_SESSION['site_id']; 
		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();		
      }
      
      function index()
      { 
    	
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Promotional Boxes Management', $this->session->userdata("promotion_link") );
		$this->breadcrumb->add_crumb('Edit');
		
        $rec_id = $this->uri->segment(3);
		$data['pages'] = $this->Menus_Model->getPages($this->site_id);
        $data['values']= $this->Promotional_Boxes_Model->get_promotional_boxe($rec_id);
		$data['products'] = $this->product_model->getProducts_new_promotion($this->site_id);  
        
		$data['groups'] = $this->Groups_Model->get_all_site_gropus($this->site_id);
		$this->template->write_view('content','promotional_box/Edit_Promotional_Boxe_View',$data);
		$this->template->render();
 
      }
      
      // method load_asset_form used to load ckeditor and ckfinder
      function load_asset_form ()
      {
        $this->load->helper('url'); //You should autoload this one ;)
        $this->load->helper('ckeditor');
 
 
        //Ckeditor's configuration
        $this->ck_data['ckeditor'] = array(
 
            //ID of the textarea that will be replaced
            'id'     =>     'ck_content',
            'path'    =>    'js/ckeditor',
 
            //Optionnal values
            'config' => array(
                'toolbar'     =>     "Full",     //Using the Full toolbar
                'width'     =>     "550px",    //Setting a custom width
                'height'     =>     '100px',    //Setting a custom height
 
            ),
 
            //Replacing styles from the "Styles tool"
            'styles' => array(
 
                //Creating a new style named "style 1"
                'style 1' => array (
                    'name'         =>     'Blue Title',
                    'element'     =>     'h2',
                    'styles' => array(
                        'color'     =>     'Blue',
                        'font-weight'     =>     'bold'
                    )
                ),
 
                //Creating a new style named "style 2"
                'style 2' => array (
                    'name'     =>     'Red Title',
                    'element'     =>     'h2',
                    'styles' => array(
                        'color'         =>     'Red',
                        'font-weight'         =>     'bold',
                        'text-decoration'    =>     'underline'
                    )
                )                
            )
        );
 
     
       
      }  // end  load_asset_form
      
      // method used for contact save data 
 function edit_promotional_boxe ()
      { 
       
		//echo "<pre>"; print_r($_REQUEST); exit;
		$this->load->library('');  
		$this->load->library('form_validation'); 
		$data = array();
		$data[0] = $this->input->post('id');
		$data[1] = $this->input->post('title');
		if($this->input->post('show_title')== '1')
		{
			$data[2] = 'Yes';   
		}
		else
		{
			$data[2] = 'No';
		}
		$data[3] = $this->input->post('products');		
		$data[4] = $this->input->post('position');			  
		if($this->input->post('position')=='top' )
		{
			$data[5] = $this->input->post('top_input');  
		}
		else if($this->input->post('position')=='left')
		{
			$data[5] = $this->input->post('left_input');  
		}
		else if($this->input->post('position')=='right')
		{
			$data[5] = $this->input->post('right_input');  
		}
		else if($this->input->post('position')=='bottom')
		{
			$data[5] = $this->input->post('bottom_input'); 
		}
		else
		{
			$data[5] = "";
		}
		$data[6] = $this->input->post('publish'); 
		if($this->input->post('display_page') == 1)
		{
			$data[7] = $this->input->post('display_page');  
		}else
		{
			$data[7] =  $this->input->post('page');
		}
		if($this->input->post('permissions') == 'Level of Access')
		{
		 	$data[8] = 'Level of Access'; 
		 	$group_id = $this->input->post('options_acess_level');
		}
		else
		{
		 	$data[8] = $this->input->post('permissions'); 
		}
		$data[9] = $this->input->post('content');
		$data[10] = $this->site_id;
		$d['data']= $data; 
		if(isset($group_id))
		{
			$d['group_id']= $group_id;
		}
		else
		{
			$d['group_id']= '';
		}		
		//echo "<pre>"; print_r($d); exit;
		$this->Promotional_Boxes_Model->update_promotional_boxe($d, $this->site_id);
		redirect('/Promotional_Boxes_Management'); 		
      }     
  }
?>