<?
class PackageController extends CI_Controller {
	
	function PackageController()
	{
		$error = false;
		$customerArray = array(
			'userId'=>'','username' => '','password' => '','phone' => '','email' => '');
		$result='';
		
		$packageArray = array();
		
		parent::__construct();
		$this->load->helper('url');
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		$this->load->Model('RolesModel'); 
		$this->load->Model('PackageModel');     
		$this->output->cache(0);  // caches
	}
	// Controller Name : Package Controller 
	//Input New 
	//Edit
	
	
	function index()
	{
		$qry = "SELECT * FROM packages WHERE package_status != 'Deleted'";

		$query = $this->db->query($qry);
		$packages = $query->result_array(); 
		$data["packages"] = $packages;
		$this->load->view('package_home',$data);	   
	}
	
	function addnew()
	{
		$qry = "SELECT * FROM modules";

		$query = $this->db->query($qry);
		$modules = $query->result_array(); 
		$data["modules"] = $modules;
		$data["packageArray"] = array();
	 
		$this->load->view('new_package',$data);
		
	}
	
	function editPackage($package_id)
	{
		//	echo  $this->uri->segment(3);exit;
		$package_id =  $this->uri->segment(3) ;
		$packageArray = $this->PackageModel->get_package_by_id($package_id);
		$moduleArray = $this->PackageModel->get_all_modules_by_package_id($package_id);
		 $qry = "SELECT * FROM modules";

		$query = $this->db->query($qry);
		$modules = $query->result_array(); 
		$data["modules"] = $modules;
		$data["action"] = "edit";
		$data["moduleArray"] = $moduleArray;
		$data["packageArray"] = $packageArray;
		$this->load->view("new_package",$data);
		
			 
	}
	
	function deletePackage()
	{
		$package_id =  $this->uri->segment(3) ; 
				 
		//echo $package_id;
		$this->PackageModel->do_delete_package_by_id($package_id);
		
	//	exit;
	}
	
	
	
	function package_management()
	{
		if($_POST["action"] == "creatNewPackage")
		{
			$this->PackageModel->creat_new_package();
			
		}
		else if($_POST["action"] == "editPackage")
		{
			$this->PackageModel->do_edit_package();  	
		}
		
	}
	
	
	function signup()
	{
		if(isset($_POST["action"]) && $_POST["action"] == "doSignUp")
		{
			//echo "keeera pe reha ee.";
			//print_r($_POST);
			//exit;
			$this->UsersModel->do_login();
		}
		$this->load->view('package_home');	
	}
	function login()
	{
		if(isset($_POST["action"]) && $_POST["action"] == "doLogin")
		{
			if($this->UsersModel->do_login())
			{
			
				redirect('UsersController/adminhome');
				//echo "<pre>";
			//print_r($_SESSION);
			//exit;
				//$this->adminhome();
				
			}
			//echo "<pre>";
			//print_r($_POST);
			//exit;
		}
		else
		{
			$this->load->view('login');		
		}
		
	}
	function adminhome()
	{
				$userRoles = $this->RolesModel->get_user_roles_by_user_id($_SESSION["user_info"]["user_id"]);
				 
				$data["user_info"] = $_SESSION["user_info"];
				$data["user_roles"] = $userRoles;
				$this->load->view("admin_home",$data);
	}
	function user_manager()
	{
		$this->load->view("user_management");	
	}
	function page_manager()
	{
		$this->load->view("page_management");	
	}
	
	function newuser()
	{
			 $roles = $this->RolesModel->get_all_roles();
			$data["roles"] = $roles;
		
		if(isset($_POST["action"]) && $_POST["action"] == "creatNewUser")
		{
			

			
			if($this->UsersModel->if_user_login_exists())
			{
				$error = true;
				$data["errosMsg"] = "User with this login is already exists."; 
				$this->load->view("newuser",$data);
			}
			else
			{
				
				
				$user_id = $this->UsersModel->register();
				if(!empty($user_id))
				{
					$data["successMsg"] = "User Created Successfully."	  ;
					$this->load->view("success",$data);	
				}
					
			}
			
		}
		else
		{
			
			$this->load->view("newuser",$data);		
		}
		
		
	}
	
	
		
}		
?>