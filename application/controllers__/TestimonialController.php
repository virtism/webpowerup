<?
class TestimonialController extends CI_Controller {
	
	function TestimonialController()
	{
		$error = false;
		$customerArray = array(
			'userId'=>'','username' => '','password' => '','phone' => '','email' => '');
		$result='';
		$client_site = "";
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
	function index()
	{
		$this->load->view('testimonial_home');	
	}
	function creat_new()
	{
	//	echo "zxzxx";exit;
		$this->load->view('testimonial_new');	
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
		$this->load->view('signup');	
	}
	function login()
	{
		if(isset($_POST["action"]) && $_POST["action"] == "doLogin")
		{
			if($this->UsersModel->do_login())
			{
			
				if(isset($_POST["request_from"]))
				{
					redirect('SiteController/sitehome');
				}
				else
				{
					redirect('UsersController/adminhome');	
				}
				
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
			$request_from =  $this->uri->segment(3) ;  
			$data["request_from"] = "";      
			if($request_from == "sitelogin")
			{
				$data["request_from"] = $request_from;
			}
			$this->load->view('login',$data);		
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
			 
		//echo "<pre>";
		//print_r($data);
		//exit;
		$request_from =  $this->uri->segment(3) ;        
		if($request_from == "sitesignup"){
		
			$packages = $this->PackageModel->get_all_package();
			$data["request_from"] = $request_from;
			$data["packages"] = $packages;
			
			
		}
		
		
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