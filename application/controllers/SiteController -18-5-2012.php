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
		
		$this->load->library('session');

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

        $this->load->model('Footer_Model');

		

		$this->load->Model('PackageModel'); 

		$this->load->Model('SitesModel'); 

        $this->load->Model('Site_Model');

		$this->load->Model('templates');    
		
		$this->load->model('Contact_Management_Model');      

		//$this->load->Controller("UsersController");

		$this->output->cache(0);  // caches

		//$this->template->load('template','template');  

	}

	

	//verifies if user is logged in

	//if not: redirect to login screen

	function checkLogin()

	{

		//checks if session user_info is set
		/*echo "<pre>";
		print_r($_SESSION);
		exit;*/
		
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
		
	
		// create dash board link
		$link = substr(uri_string(),1);
		$dashboardLink = base_url().$link;
		$this->session->set_userdata("dashboard_link", $dashboardLink);
		
		/*	~N	*/
			/* N~ */
		 $this->breadcrumb->clear();
		 $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		 $this->breadcrumb->add_crumb('Dashboard');

		$package_id = $this->UsersModel->get_package_by_user_id($_SESSION["user_info"]["user_id"]);

		$packages = $this->PackageModel->get_package_by_id($package_id); 

		$modules = $this->PackageModel->get_all_modules_by_package_id($package_id);

		

		$data["packages"] = $packages;

		$data["modules"] = $modules;

		$data['user_fname'] = $_SESSION['user_info']['user_fname'];

        $data['current_site'] = $this->SitesModel->get_sites_spec($_SESSION['user_info']['user_id'],$_SESSION['site_id']);

		//$this->load->view("home",$data);
		$site_domain = $this->Site_Model->get_site_domain_name($site_id);
		//echo '----'.$site_domain[0]['domain'];
		if(isset($site_domain[0]['domain']) && !empty($site_domain[0]['domain']))
		{
			$result = dns_get_record($site_domain[0]['domain']);
			/*echo "<pre>";
			print_r($result);
			exit;*/
			
			if(empty($result))
			{
				$data['domain'] = 0;
			}
			else
			{
				if(in_array($site_domain[0]['domain'], $result[0]))
				{
					$data['domain'] = 1;
				}
				else
				{
					$data['domain'] = 0;
				}
			}
		}
		else
		{
			$result = '';		
		
		}
		
		//echo "<pre>";
		//print_r($site_domain);

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

        // sahil babu

        $_SESSION['current_site_info'] = '';

		

		//$sites = $this->SitesModel->get_all_sites();
		/*echo "<pre>";
		print_r($_SESSION);
		exit;*/
		$sites = $this->SitesModel->get_all_sites_spec($_SESSION['user_info']['user_id']);

		$data["allSites"] = $sites;

		//$this->load->view("site_builder_home",$data);

		//$footer_content = $this->Footer_Model->create_footer($sites[0]['site_id']);

		$this->template->write_view('content','site_builder_home',$data);

		$this->template->render();
		
		/*	N~	*/
		$link = substr(uri_string(),1);
		$mainPageLink = base_url().$link;
		$this->session->set_userdata("mainPage_link", $mainPageLink); 
		/*	~N	*/

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

		   /*  echo "<pre>";
			print_r($_POST);
			exit;  */

		if($this->input->post('action') && $this->input->post('action') == "site_setup_stp2")

		{

				// fetch the form value into array

				$data = array ();  

				$data['site_title'] = $this->input->post('site_title');

				$data['type_of_site'] = $this->input->post('type_of_site');

				$data['site_category'] = $this->input->post('site_category');

                $data['site_domain'] = $this->input->post('site_domain'); 

				$data['user_login'] = $_SESSION["user_info"]["user_id"];

				$data['domain'] = $this->input->post('domain'); 
				
						 $domain = $data['site_domain'];
						$data['site_domain'] = str_replace(" ","-",$data['site_domain']);
				        $domain = str_replace(" ","-",$domain);

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

				$get_value['domain'] = $this->input->post('domain');

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

					  redirect(base_url().index_page().'SiteController/sitebuilder');  



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
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Create Logo' );
		
        $this->checkLogin();

        $data['site_id'] = $site_id;
		
		$logo = $this->Site_Model->get_logo_image($site_id);
		
		$data['logo'] = $logo;
		
		$data['error'] = $this->session->userdata('rsp_logo_error');

        $this->template->write_view('content','create_logo', $data);

        $this->template->render();    

    }

    

    //saves / uploads site's logo file/image

    function save_logo($site_id)
	{

        $this->checkLogin(); 

        if($_FILES["logo_image"]["tmp_name"]!="")

        {     
		      
			$fileName = $this->input->post("code").$_FILES['logo_image']['name'];
			
            $config['file_name'] = str_replace(" ","_",$fileName);

            $config['upload_path'] = './headers/';            

            $config['allowed_types'] = 'gif|jpg|png'; 
		
            $this->upload->initialize($config);
			
			
			if ( $this->upload->do_upload("logo_image"))
			{
				$file_name = $config['file_name'];
				// if upload then create thumbnail
				$logoInfo = getimagesize($_FILES['logo_image']['tmp_name']);
				//echo "<pre>";	print_r($logoInfo);	die();
				$image_width = $logoInfo[0];
				$image_height = $logoInfo[1];
				
				
				$config_resize['image_library'] = 'gd2';
				$config_resize['source_image'] = "./headers/".$file_name;
				$config_resize['new_image'] = './headers/';
				$config_resize['quality'] = "100%";
				$config_resize['create_thumb'] = TRUE;
				$config_resize['maintain_ratio'] = TRUE;
				$config_resize['width'] = 150;
				$config_resize['height'] = 100;
				
				$this->load->library('image_lib', $config_resize); 
				
				$this->image_lib->resize();
					
				
				
				$name = explode(".",$file_name);
				$thumbnail_name = $name[0]."_thumb.".$name[1];
				
				$this->Site_Model->save_logo($site_id, $file_name, $thumbnail_name );
				
				
				$response = "Logo have been uploaded successfully";
				$this->session->set_userdata('rsp_logo_error', 0);
	
			}
			
            else

			{
				$response = $this->upload->display_errors();
				$this->session->set_userdata('rsp_logo_error', 1);
			}
			
			echo '<script type="text/javascript"> 
				
					hideBusy();
					
				</script>';
			
			
			$this->session->set_flashdata('rsp_logo', $response);
			
			redirect('SiteController/create_logo/'.$site_id);
                        

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
	//Function to chaneg the template of Site
	function change_site_template($site_id)
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") );
		$this->breadcrumb->add_crumb('Template');
		
		$this->checkLogin(); 
		
		if($this->input->post('action') && $this->input->post('action') == "do_change_template")
		{
			$this->Pages_Model->set_site_template($site_id, $this->input->post('template_select')); 
			$home_page_data = $this->Pages_Model->fetch_homepage_data($site_id, $this->input->post('template_select'));
			$page_id = $this->Pages_Model->fetch_home_page_id($site_id);
		
			
			// junaid 4-23-2012  client has suggest to comment default home page
			//$this->Pages_Model->update_home_page_data($home_page_data, $page_id);   
			
			
			redirect('SiteController/sitehome/'.$site_id);
			
		}     
		
		$data['site_id'] = $site_id;
		
		$templates = $this->templates->get_all_templates(); 
		$data['templates'] = $templates;  
		
		$data["current_template_id"] =  $this->Site_Model->getSiteTemplate_id($site_id);
		
		$this->template->write_view('content','all_common/change_template', $data);
		
		$this->template->render();
		
	}
	
	function contact_management($site_id)
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") );
		$this->breadcrumb->add_crumb('Contact Form');
		
		$this->checkLogin(); 
		
		if($this->input->post('action') && $this->input->post('action') == "save_contact_form")
		{
			$data_array[] = $this->input->post('txtcap1');
			$data_array[] = $this->input->post('txtcap2');
			$data_array[] = $this->input->post('txtcap3');
			$data_array[] = $this->input->post('txtcap4');
			if($this->input->post('cf_publish') == "Yes")
			{
				$publish = $this->input->post('cf_publish');
			}
			else
			{
				$publish = "No";
			}
			$data_array[] = $publish;
			$this->Contact_Management_Model->add_contact_form($site_id, $data_array);    
			redirect('SiteController/sitehome/'.$site_id);
			
		}
		
		if($this->input->post('action') && $this->input->post('action') == "update_contact_form")
		{
			$data_array[] = $this->input->post('txtcap1');
			$data_array[] = $this->input->post('txtcap2');
			$data_array[] = $this->input->post('txtcap3');
			$data_array[] = $this->input->post('txtcap4');
			if($this->input->post('cf_publish') == "Yes")
			{
				$publish = $this->input->post('cf_publish');
			}
			else
			{
				$publish = "No";
			}
			$data_array[] = $publish;
			$this->Contact_Management_Model->update_contact_form($site_id, $data_array);    
			redirect('SiteController/sitehome/'.$site_id);
			
		}		     

		$data['site_id'] = $site_id;
		$data['data_array'] = $this->Contact_Management_Model->check_contact_form($site_id);
		
		$this->template->write_view('content','contact_form/contact_management', $data);
		$this->template->render();
		
	}

}		

?>