<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Access_Levels extends CI_Controller {



	function __construct()

	{

		parent::__construct();

		$this->load->helper('url');

		$this->load->library('Template');  

		

		//$this->load->view('signup');	

		$this->load->database();

		//$this->load->library('pagination');

		$this->load->Model('UsersModel');

		$this->load->Model('Access_Model'); 

		$this->load->Model('System_Modules'); 

		

		$this->load->library('session'); 

			

		$this->output->cache(0);  // caches 

		$this->template->set_template('gws');  

		//$this->template->render($region = NULL, $buffer = FALSE, $parse = FALSE)  ;    

	}

	//checks that user has logged-in Or not

	private function checkLogin()

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

	//end



	function index()

	{
			$link = substr(uri_string(),1);
		$access_link = base_url().$link;
		$this->session->set_userdata("access_link", $access_link); 
		
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
        $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
        $this->breadcrumb->add_crumb('Access Levels' );
		
		$this->checkLogin();

		$site_id = $_SESSION["site_id"];

		

		$userData = $this->UsersModel->get_user_by_id(); 

		$data['userData'] = $userData;

		

		$access_levels = $this->Access_Model->get_all_access_levels_by_site_id($site_id);

		$data["access_levels_array"] = $access_levels;

																				  

		$this->template->write_view('content','site_groups/access_home',$data);

		// Render the template

		$this->template->render();

	}

	

	function new_access_level()

	{
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Access Levels', $this->session->userdata("access_link") );
		$this->breadcrumb->add_crumb('New'); 
		//echo "dsad";exit;

		$this->checkLogin();

		

		$site_id = $_SESSION["site_id"];

		

		$userData = $this->UsersModel->get_user_by_id(); 

		$data['userData'] = $userData;

		

		$access_levels = $this->Access_Model->get_all_access_levels_by_site_id($site_id);

		$data["access_levels_array"] = $access_levels;

		

		$this->template->write_view('content','site_groups/new_access',$data);

		// Render the template

		$this->template->render();

	}

	

	function new_access_level_step_2()

	{

		//echo "dsad";exit;

		$this->checkLogin();

	

		$data["access_name"] = $_REQUEST["access_name"];

		$data["description"] = $_REQUEST["description"];

		$data["profile_selector"] = $_REQUEST["profile_selector"];

		  

		$site_id = $_SESSION["site_id"];

		

		if($_REQUEST["profile_selector"] == "base")

		{

			$new_level = $this->Access_Model->creat_new_access_level();

			if($new_level)

			{

				redirect("access_levels/index");

			}

			else

			{

				echo "got some erro access_level model";	

			}

		}

		else

		{                                                      

			//all system modules 

			$modules = $this->System_Modules->get_all_modules();

			$data["system_modules"] = $modules;

			

			

			$userData = $this->UsersModel->get_user_by_id(); 

			$data['userData'] = $userData;

	

			$this->template->write_view('content','site_groups/new_access_permission',$data);

			// Render the template

			$this->template->render();

		}

	}

	

	function do_create_access_level()

	{

		$new_level = $this->Access_Model->creat_new_access_level();

		

		if($new_level)

		{

			redirect("access_levels/index");

		}

		else

		{

			echo "got some erro access_level model";	

		}

		

		

	}

	

	function do_delete($access_id)

	{
//		$access_id = $this->uri->segment(3);

		$delete = $this->Access_Model->soft_del_access_level($access_id);

		if($delete)

		{

			redirect("access_levels/index");

		}

		else

		{

			echo "got some erro access_level model";	

		}

		

		 

	}

			  

}

