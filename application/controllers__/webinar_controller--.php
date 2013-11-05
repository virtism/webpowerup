<?
if(!session_start()){
	session_start();
}
class webinar_controller extends CI_Controller {
	 var $site_id; 
	function webinar_controller()
	{
		parent::__construct();
	
		$this->load->helper('url'); //You should autoload this one ;)
        $this->load->helper('ckeditor');
		$this->load->library('form_validation');
		$this->load->library('Template');
		$this->load->library('upload');  
		$this->load->library('session'); 
		
		$this->load_asset_form(); 
		  
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		
		$this->load->Model('Webinar_Model');
		$this->load->model('Room_Model');  
		$this->load->Model('templates');
		$this->load->Model('Groups_Model');
		$this->load->Model('customers_model');
		$this->load->Model('Pages_Model');
		$this->load->Model('Menus_Model');		
				  
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
		
		$this->output->cache(0);  // caches
		
	}
	
	//verifies if user is logged in
	//if not: redirect to login screen
	function checkLogin()
	{
		//checks if session user_info is set
		if(!$_SESSION['user_info']['user_id'] && $_SESSION['user_info']['user_id'] == NULL)
		{
			//go to login controller
			redirect("UsersController/login/sitelogin");
		}
		else
		{
			//ok, let go
			return;
		}
	}
	
	//Main Page
	function index($site_id)
	{
		 
		$link = substr(uri_string(),1);
		$webinar_link = base_url().$link;
		$this->session->set_userdata("webinar_link", $webinar_link); 
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Webinar Management' );
		
		$this->checkLogin();
		$data["site_id"] = $site_id;
		
		//All Webinars
		$all_webinars = $this->Webinar_Model->get_all_webinars($site_id);
		$data["all_webinars"] = $all_webinars;
		
		 
		$this->template->write_view('content','webinar/home',$data);
		$this->template->render();
		 
	}

	//Creat New Webinar
	function new_webinar($site_id)
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Webinar Management', $this->session->userdata("webinar_link") ); 
		$this->breadcrumb->add_crumb('New' );
		
		$this->checkLogin();
		
		$data["site_id"] = $site_id;

		if(isset($_POST["action"]) && $_POST["action"] == "do_save")
		{
			
			$insert_data = $this->Webinar_Model->creat_new_webinar($site_id);
			
			if($insert_data)
			{
				redirect("webinar_controller/index/".$site_id);
			}
		}
		
		$data["title"] = "New Webinar";
		$data["mode"] = "new"; 

		$data["webinar_info"] = array();
		
		/* $count = $this->customers_model->getAllCustomersCountBySiteID($site_id);
		 if($count>0)
		 {
		 	$data['group_users'] = $this->Groups_Model->get_site_gropus_customer_by_site_id($site_id, 'multi');	  	
		 }*/
		 /*else
		 {
		 	$data[''] =  "<a style='padding-left:16px;' href=".base_url()."index.php/customers/customer_registration/1>Create Customer</a>";
		 }*/
		 $data['groups_users'] = $this->Room_Model->get_site_gropus_customer_by_site_id($site_id);	
		//$data['regestered_users'] = $this->Room_Model->get_site_registered_user_by_site_id($site_id);	
		
		//$data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
	/*	$data['groups'] = $this->Groups_Model->dropdown_site_gropus_by_site_id($site_id);
		$data['users'] = $this->Groups_Model->dropdown_site_users($site_id);*/
	
		$data['menus'] = $this->Menus_Model->getAllMenus($data['site_id']);
		//$data['ck_data'] = $this->ck_data;
		 
		
		$this->template->write_view('content','webinar/creat_webinar',$data);
		$this->template->render();	
	}
	
	
	//Webinar Groups Home Page
	function webinar_groups($site_id)
	{
		$this->checkLogin();

		$data["site_id"] = $site_id ;
		$this->template->write_view('content','webinar/webinar_groups',$data);
		$this->template->render();	
	}
	
	//New Webinar Screen
	function new_webinar_group($site_id)
	{
		$this->checkLogin();
		
		$data["site_id"] = $site_id ; 
		
		$this->template->write_view('content','webinar/creat_webinar_groups',$data);
		$this->template->render();	
	}
	
	//Delete Webinar
	function do_delete_webinar($webinar_id)
	{
		$delete = $this->Webinar_Model->soft_delete_webinar($webinar_id);
		if($delete)
		{
			redirect("webinar_controller/index/".$_SESSION["site_id"]);
		}
	}
	
	//Edit Webinar
	function do_edit_webinar($webinar_id)
	{
		$this->checkLogin();
		
		$data["site_id"] = $_SESSION["site_id"];

		if(isset($_POST["action"]) && $_POST["action"] == "do_edit")
		{
			
			$edit_data = $this->Webinar_Model->do_edit_webinar($webinar_id);
		
			if($edit_data)
			{
				redirect("webinar_controller/index/".$_SESSION["site_id"]);
			}
		}
		
		$webinar_data = $this->Webinar_Model->get_webinar_data($webinar_id);
		$data["webinar_info"] = $webinar_data[0];
		
		
		
		$data["webinar_id"] = $webinar_id;
		
		$data["title"] = "Edit Webinar";
		$data["mode"] = "edit"; 
		
		//$data['groups'] = $this->Groups_Model->get_all_site_gropus($_SESSION["site_id"]);
		$data['groups'] = $this->Groups_Model->dropdown_site_gropus_by_site_id($_SESSION["site_id"]);
		$data['users'] = $this->Groups_Model->dropdown_site_users($_SESSION["site_id"]);
		$data['menus'] = $this->Menus_Model->getAllMenus($data['site_id']);
		// $data['ck_data'] = $this->ck_data;
			
		$this->template->write_view('content','webinar/creat_webinar',$data);
		$this->template->render();	
		
	}
	
	function load_asset_form ()
      {
       
 
 
        //Ckeditor's configuration
        $this->ck_data['ckeditor'] = array(
 
            //ID of the textarea that will be replaced
            'id'     =>     'ck_content',
            'path'    =>    'ckeditor',
 
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
 
        $this->ck_data['ckeditor_2'] = array(
 
            //ID of the textarea that will be replaced
            'id'     =>     'ck_content_2',
            'path'    =>    'ckeditor',
 
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
	
}		
?>