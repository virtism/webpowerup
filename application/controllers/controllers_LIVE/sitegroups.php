<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SiteGroups extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Template');  
		
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		//$this->load->Model('RolesModel'); 
		//$this->load->Model('PackageModel'); 
		$this->load->Model('Groups_Model'); 
		$this->load->Model('Menus_Model');  
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
		$this->checkLogin();
		
		$site_id = $_SESSION["site_id"];
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$groups = $this->Groups_Model->get_all_site_gropus($site_id);
		$groups_customer_count = $this->Groups_Model->get_all_site_gropus_user_count($site_id);		
		if(isset($groups_customer_count))
		{
			$data['groups_customer_count'] = $groups_customer_count;
		}
		$data['groups_array'] = $groups;
		$this->template->write_view('content','site_groups/home',$data);
		// Render the template
		$this->template->render();

	}
	
	/*
	 This function will be used in new site/vistor sign-up group creation.
	
	*/
	function new_site_group()
	{
		
		$this->checkLogin();
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$permsions = $this->Groups_Model->get_all_sitegroup_permission();
		$data['permissions_array'] = $permsions;
				
		$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
		$data['menus_array'] = $menus;
		
		$this->template->write_view('content','site_groups/site_new_group',$data);
		// Render the template
		$this->template->render();	
	}
	
	// Call to Model to perform CRUD operations for creation of new group.
	function do_creat_site_group()
	{
		$site_id = $_SESSION["site_id"];
		
		$created = $this->Groups_Model->insert_site_group($site_id);
		
		if($created)
		{
			if(isset($_SESSION['age_group_path']) && !empty($_SESSION['age_group_path']))
			{
				 redirect($_SESSION['age_group_path']);				
			}
			redirect("sitegroups/index");
		}
		else
		{
			echo "got error";
		}
	
	}
	
	// view - landing page for Admin Site Groups
	function creat_admin_group()
	{
		$this->checkLogin();
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		//$permsions = $this->Groups_Model->get_all_sitegroup_permission();
		//$data['permissions_array'] = $permsions;
				
		$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
		$data['menus_array'] = $menus;
		
		$this->template->write_view('content','site_groups/admin_new_group',$data);
		// Render the template
		$this->template->render();		
	}
	
	function status_group($group_id)
	{
		if(isset($group_id))
		{
			$status['action_text'] = $this->Groups_Model->status_group($group_id);
		}	
		redirect("/sitegroups/index");
	}
	
	function edit_group($group_id)
	{
		
		$this->checkLogin();
		if(isset($group_id))
		{
			$data['group_id'] = $group_id;
			$data['data'] = $this->Groups_Model->get_edit_group($group_id);	
			$permsions = $this->Groups_Model->get_all_sitegroup_permission();
			$data['permissions_array'] = $permsions;
			$menus = $this->Menus_Model->get_all_site_menus($_SESSION["site_id"]);
			$data['menus_array'] = $menus;
			$this->template->write_view('content','site_groups/site_update_group',$data);
			// Render the template
			$this->template->render();	
		}
	}
	
	function do_update_site_group()
	{
		
		/*echo "<pre>";
		print_r($_REQUEST);
		exit;*/
		$site_id = $_SESSION["site_id"];
		if(isset($_REQUEST['group_id']))
		{
			$created = $this->Groups_Model->do_update_site_group($_REQUEST['group_id'], $site_id);		
			if($created)
			{
				redirect("sitegroups/index");
			}
			else
			{
				echo "got error";
			}
		}
	}
}