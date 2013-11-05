<?
if(!session_start()){
	session_start();
}
class SiteController extends CI_Controller {
	 var $site_id; 
	function SiteController()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('Template');
        $this->load->library('upload');   
		$this->template->set_template('gws'); 
		  
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		$this->load->Model('RolesModel');  
		$this->load->Model('Menus_Model');    
		$this->load->Model('PagesModel');
		$this->load->model('shop_model'); 
		$this->load->Model('Pages_Model');
		
		$this->load->Model('PackageModel'); 
		$this->load->Model('SitesModel'); 
        $this->load->Model('Site_Model');
		$this->load->Model('templates');          
		//$this->load->Controller("UsersController");
		$this->output->cache(0);  // caches
		//$this->template->load('template','template');  
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
	
	function index()
	{
		$allpages = $this->PagesModel->get_all_pages();
		$data["pages"] = $allpages;
		$this->load->view("site_home",$data);
		 
	}
	
	
	
	function loadpage($page_id)
	{
		$page_id =  $this->uri->segment(3) ;
		$page_data = $this->PagesModel->get_page_data_by_id($page_id);
		$allpages = $this->PagesModel->get_all_pages();
		
		$data["pages"] = $allpages;
		$data["pageData"] = $page_data;
		
		$this->load->view("content_data",$data);
		 
	}

	function success()
	{
		//if($_GET["success"])
		$msg = "Page Saved Successfully";   
		$data["successMsg"] = $msg;
		
		$this->load->view("success",$data);
	}
	
	function signup()
	{
		 //$this->load->view("site_signup");
		 $data["client_site"] = 1;
		 redirect("UsersController/newuser/sitesignup",$data);
	}
	
	function login()
	{
		 $data["client_site"] = 1;
		 redirect("UsersController/login/sitelogin",$data);
	}
	
	function sitehome($site_id='')
	{
		//checks user login
	   
	   $_SESSION['site_id']= $site_id;
		
	   //  echo $_SESSION['site_id'].'>>>>>>>>>>>>>>>>>>>>>>>>>>>'; exit;  
		
		$this->checkLogin();
		
		$package_id = $this->UsersModel->get_package_by_user_id($_SESSION["user_info"]["user_id"]);
		$packages = $this->PackageModel->get_package_by_id($package_id); 
		$modules = $this->PackageModel->get_all_modules_by_package_id($package_id);
		
		$data["packages"] = $packages;
		$data["modules"] = $modules;
		$data['user_fname'] = $_SESSION['user_info']['user_fname'];
		//$this->load->view("home",$data);
        $this->template->write_view('content','home',$data);
		$this->template->render();
		
	}
	
	// method for user sites manage
		function sitehome_manage()
	{
		//$package_id = $this->UsersModel->get_package_by_user_id($_SESSION["user_info"]["user_id"]);
//        $packages = $this->PackageModel->get_package_by_id($package_id); 
//        $modules = $this->PackageModel->get_all_modules_by_package_id($package_id);

			$this->SitesModel->get_all_sites_by_user ($_SESSION["user_info"]["user_id"]); 
	   
		$data["packages"] = $packages;
		$data["modules"] = $modules;
		
		//$this->load->view("home",$data);

		$this->template->write_view('content','home',$data);
		$this->template->render();
		
	}
	
	function sitebuilder()
	{
		//checks user login
		$this->checkLogin();
		
		//$sites = $this->SitesModel->get_all_sites();
		$sites = $this->SitesModel->get_all_sites_spec($_SESSION['user_info']['user_id']);
		$data["allSites"] = $sites;
		//$this->load->view("site_builder_home",$data);
		
		$this->template->write_view('content','site_builder_home',$data);
		$this->template->render();
	}
	
	function sitemanagement()
	{
		$site_id = $this->uri->segment(3) ; 
		$siteInfo = $this->SitesModel->get_site_by_id($site_id);
		$data["siteInfo"] = $siteInfo;

		//$this->load->view('site_management',$data); 
		
		$this->template->write_view('content','site_management',$data);
		$this->template->render();    
		
	}
	function creatnewsite()
	{
		$templates = $this->templates->get_all_templates();
		
		$packages = $this->PackageModel->get_all_package();
		
		$data["packages"] = $packages;
		$data["templates"] = $templates;
		
		$packageInfo = $this->PackageModel->package_info_by_user_id($_SESSION["user_info"]["user_id"]);
		$data["packageInfo"] = $packageInfo;
			
		if(isset($_POST["action"]) && $_POST["action"] == "creatNewSite")
		{

			
			$this->SitesModel->creat_new_site();
			redirect("SiteController/sitebuilder");			
				
		}
		else
		{

			//$this->load->view("new_site",$data);
			
			$this->template->write_view('content','new_site',$data);
			$this->template->render();	
		}
		
		
	} 
	
		 //  Creat site  step 2 process 
	function creatnewsite_step2()
	{
		       
		if($this->input->post('action') && $this->input->post('action') == "site_setup_stp2")
		{
				// fetch the form value into array
				$data = array ();  
				$data['site_title'] = $this->input->post('site_title');
				$data['type_of_site'] = $this->input->post('type_of_site');
				$data['site_category'] = $this->input->post('site_category');
                $data['site_domain'] = $this->input->post('site_domain'); 
				$data['user_login'] = $_SESSION["user_info"]["user_id"];
						 $domain = $data['site_domain'];
				
			 $this->form_validation->set_rules('site_title', 'Website Title', 'trim|required');
			 //$this->form_validation->set_rules('type_of_site', 'Type Of Site : ', 'trim|required');
			//$this->form_validation->set_rules('site_category', 'Category', 'trim|required'); 
			 $this->form_validation->set_rules('site_domain', 'Website Domain', 'trim|required|callback_doamin_not_exist'); 
			 //$this->form_validation->set_rules('user_email', 'User Email', 'trim|required|valid_email|callback_email_not_exist');
			
			if ($this->form_validation->run())
			{ 
				$templates = $this->templates->get_all_templates(); 
				$data['templates'] = $templates;  
                /*echo '<pre>';
                print_r($data['templates']);
				 exit();  */
				$this->template->write_view('content','new_site_step2',$data);
				$this->template->render();      
			}else
			{
			  $this->template->write_view('content','new_site',$data);
			  $this->template->render();
				
			} 

				
			
		}

	}
	
		 //  Creat site  step 3 process 
	function creatnewsite_step3()
	{
		
		if($this->input->post('action') && $this->input->post('action') == "site_setup_stp3")
		{

				// fetch the form value into array
				$get_value = array ();  
				$get_value['site_title'] = $this->input->post('site_title');
				$get_value['type_of_site'] = $this->input->post('type_of_site');
				$get_value['site_category'] = $this->input->post('site_category');
				$get_value['site_domain'] = $this->input->post('site_domain'); 
				
				$get_value['template_select'] = $this->input->post('template_select'); 

				$user_id = $_SESSION['user_info']['user_id']; 
				$pakge_id = $this->SitesModel->get_pakage_id_by_user_id($user_id); 
				
				$get_value['package'] = $pakge_id; 
				
				$site_id = $this->SitesModel->creat_new_site_by_signup( $get_value,$user_id);
				$this->site_id = $site_id;
				$this->shop_model->put_store_settings($this->site_id);
																					 
				 if($site_id>0)
				 {    
					  //echo "yeeh data have ben saved ... !";             
					  //create main menu & pages of the site
					  $this->Pages_Model->create_main_and_footer_menus_and_pages($site_id);
					  redirect(base_url().'index.php/SiteController/sitebuilder');  

				 }

		}

	}
	
	
	// ----- method to check domain name already exist or not 
	function  doamin_not_exist($domain)
	  {  
		  $this->form_validation->set_message('doamin_not_exist','This <b> %s </b>already taken by another. Please try another.');
		  
		 if($this->SitesModel->domain_exists($domain))
		 {
		   return false;  
		 }else
		 {
			 return true;
		 }
	  }
	// This function is used to delete the site from listing only 
	  function soft_delete($site_id)
	  {
		$this->SitesModel->do_soft_delete($site_id);
		redirect('SiteController/sitebuilder');
		  
	  }
      
    //loads create logo view/screen
    function create_logo($site_id)
    {
        $this->checkLogin();
        
        $data['site_id'] = $site_id;
        $data['success_mesg'] = '';
        $data['fail_mesg'] = ''; 
        
        $this->template->write_view('content','create_logo', $data);
        
        $this->template->render();    
    }
    
    //saves / uploads site's logo file/image
    function save_logo($site_id)
    {
        $this->checkLogin(); 
        
        if($_FILES["logo_image"]["tmp_name"]!="")
        {            
            $config['file_name'] = $this->input->post("code").$_FILES['logo_image']['name'];
            $config['upload_path'] = './headers/';            
            $config['allowed_types'] = 'gif|jpg|png';                       
            $this->upload->initialize($config);
            
            $this->upload->do_upload("logo_image");
            
            $file_name = $config['file_name'];
            $this->Site_Model->save_logo($site_id, $file_name);
            
            redirect('SiteController/create_logo_success/'.$site_id);
                        
        }
        else
        {
            redirect('SiteController/logo_error/'.$site_id);        
        }
    }
    
	function create_logo_success($site_id)
    {
        $this->checkLogin(); 
        
        $data['site_id'] = $site_id;
        $data['success_mesg'] = 'Logo created successfully.';   
        $data['fail_mesg'] = ''; 
        
        $this->template->write_view('content','create_logo', $data);
        
        $this->template->render();            
    }
    
    
    function logo_error($site_id)
    {
        $this->checkLogin(); 
        
        $data['site_id'] = $site_id;
        $data['success_mesg'] = '';        
        $data['fail_mesg'] = 'Error occured in image upload, please try again.'; 
        $this->template->write_view('content','create_logo', $data);
        
        $this->template->render();    
    }
}		
?>
