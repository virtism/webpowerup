<?php
class UsersController extends CI_Controller {
	
	function UsersController()
	{
		$error = false;
		$customerArray = array(
			'userId'=>'','username' => '','password' => '','phone' => '','email' => ''
			);
		$result='';
		$client_site = "";
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Template'); 
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		$this->load->Model('RolesModel');   
		$this->load->Model('PackageModel');
		$this->load->Model('SitesModel');
		$this->load->Model('Menus_Model');   
		$this->load->library('session');    
		$this->output->cache(0);  // caches
		$this->template->set_template('gws'); 
		
		$this->load->library('form_validation');
		$this->load->library('antispam');

		 /*   session_unset();
			if(!session_start())
			{
			   session_start();
			}
		  */     
	}
	function index()
	{
		//$this->load->view('login');	
		 $this->template->write_view('content','login');
		 $this->template->render(); 
		 
	}
	
	//Numaan 08/09/2011
	//checks that user has logged-in Or not
	function check_login()
	{
		//checks if session user_info is set
		$user_info = $this->session->userdata('user_info');
		$user_role = $this->session->userdata('user_role');
		/*
		echo "<pre>";
		print_r($user_role);
		exit;
		*/
		
		if($user_info=='' && $user_role=='')
		{
			//go to login controller
			//$this->index();
			redirect('administrator/index');
		}
		else
		{
			//ok, let go
			return true;
		}   
		 
	}
	//end
	
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
	
	//loads myaccount.php(view)
	function myaccount()
	{
		//confirm user is logged in
		$this->checkLogin();
		
		$data['message'] = "";
		$this->template->write_view('content', 'myaccount', $data);
		$this->template->render(); 
	}
	
	//gets post values from frmMyAccount in myaccount.php(view) 
	//update user info in users table
	function updateUserInfo()
	{
		
		$this->checkLogin();
		
		if(isset($_POST['user_id']))
		{
			/*echo "<pre>";
			print_r($_POST);
			exit();*/
			$this->UsersModel->updateUserInfo();   
			$data['message'] = "Your information has been successfully updated.";
			$this->template->write_view('content', 'myaccount', $data);
			$this->template->render();  
		}
		else
		{
			//No Data Posted, Go back to myaccount.php(view)
			$data['message'] = "";
			$this->template->write_view('content', 'myaccount');
			$this->template->render(); 
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
	
		$this->load->view('signup');	
		//$this->template->write_view('content','signup');
		//$this->template->render();	
		
	}
	function login()
	{
		//print_r($_SESSION);
	  //  exit;
		$data['error_message'] = '';
		$data['user_login'] = '';        
		if(isset($_POST["action"]) && $_POST["action"] == "doLogin")
		{
			//echo $this->UsersModel->do_login();
			//$boolFlag = $this->UsersModel->do_login();
			//echo "flag:".$boolFlag;exit; 
			if($this->UsersModel->do_login())
			{
				
			   if($this->UsersModel->user_sites_check($_SESSION['user_info']['user_id']))
			   {
					redirect('SiteController/sitebuilder/'); 
			   }
			   else
			   {
				  //$this->template->write_view('content','login',$data);
				  //$this->template->render(); 
				  redirect('SiteController/creatnewsite/');
			   }
				
				
			   
				
				
//				if(isset($_POST["request_from"]))
//				{
//					redirect('SiteController/sitehome');
//                    echo " SiteController/sitehome .......... here";
//				}
//				else
//				{
//					redirect('UsersController/adminhome');	
//                    echo " UsersController/adminhome .......... here";
//				}
				
				//echo "<pre>";
			//print_r($_SESSION);
			//exit;
				//$this->adminhome();
				
			}
			else
			{
				//echo "going here";exit;
				$user_login = $this->input->post('user_login');
				$user_password = $this->input->post('user_password');
				
				if($user_login == '' || $user_password == '')
				{
					$data['error_message'] = "Please enter User ID and / or Password to continue.";    
				}
				else
				{
					$data['user_login'] = $this->input->post('user_login');
					$data['error_message'] = 'Invalid User ID and / or Password combination.';    
				}
				
				$this->template->write_view('content', 'login', $data);
				$this->template->render(); 
			//
				//redirect('SiteController/login', $data); 
			}
			//echo "<pre>";
			//print_r($_POST);
			//exit;
		}
		else
		{ 
			//echo "Invalid UserId &/or Password combination.";
			$request_from =  $this->uri->segment(3) ;  
			$data["request_from"] = "";      
			if($request_from == "sitelogin")
			{
				$data["request_from"] = $request_from;
			} 
			$this->template->write_view('content','login',$data);
			$this->template->render(); 
			//$this->load->view('login',$data);		
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
		//Mudassar
		//$this->load->view("user_management");
		//end
		
		
		//Numaan 08/09/2011
		
		//confirm that user has logged-in    
		$this->check_login();
		
		$this->template->set_template('gws_admin'); 
		$this->template->write_view('sidebar', 'gws_admin/sidebar');
		$this->template->write_view('content', 'user_management');
		$this->template->render();
		//end
			
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
		//Numaan 08/09/2011
		//confirm that user has logged-in    
		$this->check_login();
		//end
		
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
				//Mudassar
				//$this->load->view("newuser",$data);
				//end
				
				//Numaan 08/09/2011
				$this->template->set_template('gws_admin'); 
				$this->template->write_view('sidebar', 'gws_admin/sidebar');
				$this->template->write_view('content', 'newuser', $data);
				$this->template->render();
				//end
			}
			else
			{
				
				
				$user_id = $this->UsersModel->register();
				if(!empty($user_id))
				{
					$data["successMsg"] = "User Created Successfully."	  ;
					
					//Mudassar
					//$this->load->view("success",$data);	
					//end
					
					//$this->template->write_view('content',"success",$data);
					//$this->template->render();
					
					//Numaan 08/09/2011
					$this->template->set_template('gws_admin'); 
					$this->template->write_view('sidebar', 'gws_admin/sidebar');
					$this->template->write_view('content', 'success', $data);
					$this->template->render();
					//end
				}
					
			}
			
			
			
		}
		else
		{
			
			//Mudassar
			/*
			$this->template->write_view('content',"newuser",$data);
			$this->template->render();	
			*/
			//end
			//$this->load->view("newuser",$data);
			
			//Numaan 08/09/2011
			$this->template->set_template('gws_admin'); 
			$this->template->write_view('sidebar', 'gws_admin/sidebar');
			$this->template->write_view('content', 'newuser', $data);
			$this->template->render();
			//end		
			
		}
		
		
	}
	
	// signup step 1 process 
	 function signup_step1()
	{
		
		if($this->input->post('action') && $this->input->post('action') == "doSignUp")
		{
			//echo "keeera pe reha ee.";
			//            print_r($_POST);
			//            exit;
			$this->UsersModel->do_login();
		}
		
		 $data['packges'] = $this->PackageModel->get_all_package();
		
	   // print_r($data);
		 //$this->load->view('signup_step1', $data);  

		$this->template->write_view('content','signup_step1', $data);
		$this->template->render();    
		
	}
	
	function isUserLoginExist()
	{
		$user_login = $this->input->post('user_login');
		$boolFlag = 'FALSE';
		
		if($this->UsersModel->isUserLoginExist()==TRUE)
		{
			$boolFlag = 'TRUE';
		} 
		echo $boolFlag;   
	}
	function isUserEmailExist()
	{
		$user_email = $this->input->post('user_email');
		$boolFlag = 'FALSE';
		
		if($this->UsersModel->isUserEmailExist()==TRUE)
		{
			$boolFlag = 'TRUE';
		} 
		echo $boolFlag;        
	}
	
	//  signup step 2 process 
	function signup_step2()
	{
		if($this->input->post('action') && $this->input->post('action') == "doSignUp")
		{
			$this->UsersModel->do_login();
			
		}
		else if($this->input->post('action') == "step2")
		{
		   $get_package_value = array ();  
		   $path= realpath( getcwd() ); 
		   
		   $configs = array(
					'img_path' => $path.'/captcha/',
					'img_url' => base_url() . 'captcha/',
					'img_height' => '50',
				);            
			//$captcha = $this->antispam->get_antispam_image($configs);

			//print_r ($captcha);
//            exit();
			//$_SESSION['captchaWord'] = $captcha['word'];
			 $captcha['image'] = base_url().'captcha/captcha_ci.png';    
					 
			$get_package_value['captcha'] = $captcha;
			
			
		   // echo getcwd();       
		   // print ($_SERVER['DOCUMENT_ROOT']);
			
			$get_package_value['action'] = $this->input->post('action');
			$get_package_value['package'] = $this->input->post('package_select');
			//print_r($get_package_value);
			   // exit ();
			//$this->load->view('signup_step2',$get_package_value);    
			$this->template->write_view('content','signup_step2',$get_package_value);
			$this->template->render(); 
		}

	}
	
	//  signup step 3 process 
	function signup_step3()
	{
		
		if($this->input->post('action') && $this->input->post('action') == "doSignUp")
		{
			$this->UsersModel->do_login();
			
		}
		else if($this->input->post('action') == "step3")
		{
			
			$this->load->helper(array('form', 'url')); 
			$this->load->library('form_validation'); 
			
			
			// fetch the form value into array
			$get_value = array ();  
			
			$get_value['action'] = $this->input->post('action');
			if($this->input->post('package')=='' || $this->input->post('package')== NULL)
			{
			 $get_value['package'] = 1;   
			}
			else
			{
			 $get_value['package'] = $this->input->post('package');   
			}
			 
			$get_value['user_fname'] = $this->input->post('user_fname');
			$get_value['user_lname'] = $this->input->post('user_lname');
			$get_value['log_in'] = $this->input->post('log_in');
			$get_value['user_password'] = $this->input->post('user_password');
			$get_value['user_email'] = $this->input->post('user_email');
						  $email     = $get_value['user_email'];
						  $log_in     = $get_value['log_in'];
			
			
			 $this->form_validation->set_rules('user_fname', 'User First Name : ', 'required');
			 $this->form_validation->set_rules('user_lname', 'User Last Name : ', 'required');
			 $this->form_validation->set_rules('user_password', 'User Password', 'trim|required|matches[user_password_confirm]'); 
			 $this->form_validation->set_rules('user_email', 'User Email', 'trim|required|valid_email|matches[user_email_confirm]|callback_email_not_exist');
			 $this->form_validation->set_rules('log_in', 'User login', 'trim|required|callback_login_not_exist'); 
			 //$this->form_validation->set_rules('user_email', 'User Email', 'trim|required|valid_email|callback_email_not_exist');
			
			if ($this->form_validation->run() == FALSE)
			{
				 // error in form validation 
				// $this->load->view('signup_step2',$get_value);
				 $this->template->write_view('content','signup_step2',$get_value);
				 $this->template->render(); 
				 
			}
			else
			{ 

				$user_id = $this->UsersModel->do_signup ($get_value);
			   // $this->SitesModel->creat_new_site_by_signup ( $get_value,$user_id);
				//redirect(base_url().'index.php/UsersController/login/sitelogin');  
				
				//$this->load->view('signup_step3',$get_value);    
				$this->template->write_view('content','signup_success');
				$this->template->render(); 
			}
		}

	}
		// method to check email already exist or not 
		function  email_not_exist($email)
	  {
		  //echo $email.">>>>>>>>>";
		  // exit();
		  $this->form_validation->set_message('email_not_exist','This %s email already exists. Please try another.');
		  
		 if($this->UsersModel->email_exists($email)){
		   return false;  
		 }else{
			 return true;
		 }
	  }
	  
	   // method to check login name already exist or not 
		function  login_not_exist($log_in)
	  {
		  //echo $email.">>>>>>>>>";
		  // exit();
		  $this->form_validation->set_message('login_not_exist','This %s login Name already exists. Please try another.');
		  
		 if($this->UsersModel->login_exists($log_in)){
		   return false;  
		 }else{
			 return true;
		 }
	  }
	
	 //  signup step 4 process 
	function signup_step4()
	{
		
		if($this->input->post('action') && $this->input->post('action') == "doSignUp")
		{
			$this->UsersModel->do_login();
			
		}
		else if($this->input->post('action') == "step4")
		{
			
			$this->load->helper(array('form', 'url')); 
			$this->load->library('form_validation'); 
			
				// fetch the form value into array
				$get_user_value = array (); 
				$get_value = array ();  
				
				//$get_value['action'] = $this->input->post('action');
				$get_value['package'] = $this->input->post('package'); 
				$get_value['user_fname'] = $this->input->post('user_fname');
				$get_value['user_lname'] = $this->input->post('user_lname');
				$get_value['log_in'] = $this->input->post('log_in');
				$get_value['user_password'] = $this->input->post('user_password');
				$get_value['user_email'] = $this->input->post('user_email');
				
				$get_value['site_title'] = $this->input->post('site_title');
				$get_value['type_of_site'] = $this->input->post('type_of_site');
				$get_value['site_category'] = $this->input->post('site_category');
				$get_value['site_domain'] = $this->input->post('site_domain'); 
			
			
			 //$this->form_validation->set_rules('user_fname', 'User First Name : ', 'required');
			 $this->form_validation->set_rules('user_password', 'User Password', 'trim|required'); 
			
			if ($this->form_validation->run() == FALSE)
			{
				 // error in form validation 
				 //$this->load->view('signup_step3');
				 $this->template->write_view('content','signup_step3',$get_value);
				 $this->template->render();
			}
			else
			{ 

			
				$user_id = $this->UsersModel->do_signup ( $get_value);
				$this->SitesModel->creat_new_site_by_signup ( $get_value,$user_id);
				redirect(base_url().'index.php/UsersController/login/sitelogin');  
			   //print_r($get_package_value);
			   //exit ();
			   //$this->load->view('signup_step3',$get_value);    
			   // $this->template->write_view('content','signup_step4',$get_value);
			   // $this->template->render(); 
			}
		}

	}
	
	// method to logout 
	function logout ()
	{
		//@@@@ For Only PHP Session @@@//
		
			session_unset();
			session_destroy();
		  //  $_SESSION[] = array();
			//$_SESSION['user_info'] = array();
		   redirect(base_url().'index.php/UsersController/login/sitelogin'); 
		//---------------------------------------------------------------------//
		
		//######## For Using Codeigniter Session Class ####### //
		
	   /* $this->session->sess_destroy();
		$this->session->unset_userdata('is_logged_in');
		redirect(base_url().'index.php/UsersController/login/sitelogin');   */
		
	}
	
	function changePassword()
	{
		//confirm user is logged in
		$this->checkLogin();
		
		//load view
		$data['user_id'] = $_SESSION['user_info']['user_id'];
		$data['message'] = ''; 
		$this->template->write_view('content', 'changePassword', $data);
		$this->template->render();    
	}
	function updatePassword()
	{
		$this->UsersModel->updatePassword();
		$data['message'] = 'Your password has been changed successfully.';
		$this->template->write_view('content', 'changePassword', $data);
		$this->template->render();      
	}
	
	//checks if the password is correct for this logged in user, form posted from changePassword.php (view)
	function isUserPassword()
	{
		$boolFlag = $this->UsersModel->isUserPassword();
		if($boolFlag == TRUE)
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}
		return;
	}
		
}		

?>