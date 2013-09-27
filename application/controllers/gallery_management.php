<?php
if(!session_start()){
	session_start();
}
class Gallery_Management extends CI_Controller
{ 
	//Constructor Definition
	function Gallery_Management(){
		parent::__construct(); 
		$this->load->helper('url');   
		$this->load->library('upload'); 
		$this->load->library('Template');
		$this->load->library('upload');
		$this->load->library('session');
		$this->load->library('pagination'); 
		$this->load->model("Menus_Model");
		$this->load->model("Groups_Model"); 
		$this->load->model("PackageModel");
		$this->load->model("Site_Preview");
		$this->load->model("Gallery_Model");
		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
			    
	}
	
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
	
	function create($site_id)
	{
		
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Gallery', $this->session->userdata("gallery_link") );
		$this->breadcrumb->add_crumb('Create');
		//confirm that user has logged in
		
		
		
		$this->checkLogin();
		
		$data['site_id'] = $site_id;
		$data['pages'] = $this->Menus_Model->getPages($site_id);        
		$data['roles'] = $this->Menus_Model->getRoles(); 
		$data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
		//print_r($data['groups']);
		
		//Gallery Template		
		$data['gallery_templates'] = $this->Gallery_Model->get_all_gallery_tamplates();
		//print_r($data['gallery_templates']);exit;
		//Gallery Template
		
		$data['modules'] = $this->PackageModel->get_site_package_modules($site_id);
		$data['template_name'] = $this->Site_Preview->getSiteTemplate($site_id);
		$this->template->write_view('content', 'gallery/create', $data);   
		
		$this->template->render();
	}
	
	function save_gallery_info($site_id)
	{
		$numImages = $this->input->post('numImages');
		$_SESSION['numImages'] = $numImages;
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		if(!isset($_POST))
		{
			$this->create($site_id);    
		}
		
		//save gallery info
		$gallery_data = array();
		$gallery_data['gallery_title'] = $this->input->post('slider_title');
		$gallery_data['gallery_description'] = $this->input->post('slider_description');
	  	$gallery_data['template_options'] = $this->input->post('template_options');
	  	$gallery_data['gallery_styles'] = $this->input->post('gallery_styles');		
		$gallery_data['gallery_published'] = $this->input->post('slide_published');
		$gallery_data['gallery_open'] = $this->input->post('open_gallery');
		$gallery_data['gallery_status'] = "Active";
		$gallery_data['gallery_type'] = "image";
		$gallery_data['gallery_access'] = $this->input->post('slide_access');
		$gallery_data['gallery_pages'] = $this->input->post('slide_pages'); 
		$gallery_data['site_id'] = $site_id;
		
		$gallery_id = $this->Gallery_Model->save_gallery_info($gallery_data);
		//exit;
		//save gallery images info
		$image_files = array();
		//echo '<pre>';  print_r($_FILES); echo '</pre>';
		//exit();
		/*echo '<pre>';  print_r($_POST); echo '</pre>';
		exit();*/
		/*$path 	= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/galleries'; 
		if(!is_dir($path))
		{
			mkdir($path,0777,true);
		}*/
		for($i=1; $i<= intval($numImages); $i++)
		{
			$file_info 		= array ();
			$config 		= array ();
			$config_resize 	= array ();
			
			
			if(!empty($_FILES['slide_image'.$i]['name']))
			{
				
			   $target 			= $_POST['slide_target'.$i];
			   $slide_image_url = $_POST['slide_image_url'.$i];			   
			   if(isset($slide_image_url)&& $slide_image_url!="URL" && !empty($slide_image_url))
			   {
			   		$pos = strpos($slide_image_url, "http://");
					if($pos === false)
					{
						$slide_image_url = "http://".$slide_image_url;
					}
				
			   }	
			   	
					   
			    $slide_title 			= $_POST['slide_title'.$i];
			    $slide_description 		= $_POST['slide_description'.$i];
				
				//$config['file_name'] 	= $slide_image;
				$config['encrypt_name'] = true;			
				$config['upload_path'] 	= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/galleries/full';             	/*if(!is_dir($config['upload_path']))
				{
					mkdir($config['upload_path'],0777,true);
				}*/
				$config['allowed_types'] 	= 'gif|jpg|png|ico|img|jpeg|jpe'; 
				$config['remove_spaces'] 	= TRUE; 
				$config['max_size']   		= '10240';			   
				$this->upload->initialize($config);
				$this->upload->do_upload("slide_image".$i);			 
				$file_info 	= $this->upload->data();
				
				
				if($file_info)
				{  				   
					$this->load->library('image_lib'); 
					$config_resize['source_image'] 		= $file_info['full_path'];
					$config_resize['new_image'] 		= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/galleries/middle/';
					/*if(!is_dir($config_resize['new_image']))
					{
						mkdir($config_resize['new_image'],0777,true);
					}*/
					$config_resize['maintain_ratio'] 	= TRUE;
					$config_resize['width'] 			= 400;  
					$config_resize['height'] 			= 300;
					$this->image_lib->initialize($config_resize);
					$resize_img = $this->image_lib->resize();
					$this->image_lib->clear();
					
					
					
					
					$config_resize['source_image'] 		= $file_info['full_path'];
					$config_resize['new_image'] 		= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/galleries/thumb/';
					/*if(!is_dir($config_resize['new_image']))
					{
						mkdir($config_resize['new_image'],0777,true);
					}*/
					$config_resize['maintain_ratio'] 	= FALSE;
					$config_resize['width'] 			= 28;  
					$config_resize['height'] 			= 28;
					$this->image_lib->initialize($config_resize);
					$resize_img = $this->image_lib->resize();
					$this->image_lib->clear();
					
				}  
										  
					
				
				$gallery_image_info['gallery_id'] 			= $gallery_id;
				$gallery_image_info['gallery_image'] 		= $file_info['file_name'];
				$gallery_image_info['gallery_image_url'] 	= $slide_image_url;
				$gallery_image_info['gallery_title'] 		= $slide_title;
				$gallery_image_info['gallery_description'] 	= $slide_description;
				$gallery_image_info['gallery_image_status'] = 'Active';				
				$gallery_image_info['target'] 				= $target;
				
				//echo "<pre>";print_r($gallery_image_info);exit;
				
				$this->Gallery_Model->save_galleries_image_info($gallery_image_info);
			}
		}     
		
		//save slideshow display pages
		$gallery_pages = $this->input->post('slide_pages');
		if(isset($gallery_pages)&&$gallery_pages == 'Other')
		{
			for($i=0; $i<sizeof($_POST['slide_pages_list']); $i++)
			{
				$page_id = $_POST['slide_pages_list'][$i];
				$this->Gallery_Model->save_gallery_pages_info($gallery_id, $page_id);        
			}    
		}
		
		//save slideshow roles
		$gallery_access = $this->input->post('slide_access');
		if(isset($gallery_access)&&$gallery_access == 'Other')
		{
			for($i=0; $i<sizeof($_POST['slide_roles_list']); $i++)
			{
				$role_id = $_POST['slide_roles_list'][$i];
				$this->Gallery_Model->save_gallery_roles_info($gallery_id, $role_id);
			}    
		}
		redirect("gallery_management/index/".$site_id);
	}
	
	function create_slide($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();		
		$this->save_slider_info($site_id);		
		redirect(base_url().index_page().'site_slides/index/'.$site_id.'/0'); 
		
	}
	
	function create_slide_fancy($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		$this->save_slider_info($site_id);
		
		//redirect(base_url().index_page().'site_slides/index/'.$site_id.'/0');  
		$this->load->view('slides/fancy_close');
	}
	
	//loads slides/index.php view for slides management
	function index($site_id,$from=1)
	{
		
		$link = substr(uri_string(),1);
		$gallery_link = base_url().$link;
		$this->session->set_userdata("gallery_link", $gallery_link); 
		
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Gallery' );
		//confirm that user has logged in
		$this->checkLogin();
		
		$data = array ();
		$data["search_page_title"] = ""; 
		
		if($this->session->userdata("ses_showPageLimit"))
		{
			$data["pageLimit"] = $this->session->userdata("ses_showPageLimit");
		}
		else
		{
			$data["pageLimit"] = 5;
		}
		
		if($this->input->post("numRecords"))
		{            
			$this->session->set_userdata("ses_showPageLimit", $this->input->post("numRecords"));
			$data["pageLimit"] = $this->session->userdata("ses_showPageLimit");
		}        
		
		$data['site_id'] = $site_id;
		$data['from'] = $from;	
		$data["records"] = $this->Gallery_Model->get_gallries($site_id);
		$data["numRecords"] = count($data["records"]);
		$data["totalRecords"] = count($data["records"]); 
				
		$config = array(
			'uri_segment' => 4,
			'base_url' => base_url().'gallery_management/index/'.$site_id."/",
			'per_page' => $data["pageLimit"],
			'first_link' => 'First',
			'next_link' => 'Next',
			'last_link' => 'Last',
			'next_link' => 'Next',
			'prev_link' => 'Previous',
			'display_pages' => TRUE,
			'num_links' => 2,
			'total_rows' => $data["totalRecords"]
		);
		
		$this->pagination->initialize($config); 
		$data["paging"] = $this->pagination->create_links();		
		$this->template->write_view('content','gallery/gallery_list', $data);
		$this->template->render();    
	}
	
	//published Gallery(s) of a site
	function publishGallery($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		if($this->input->post("chkSlide"))
		{            
			$this->Gallery_Model->publishGallery($this->input->post("chkSlide"));
			redirect("gallery_management/index/".$site_id."/0");
		}          
	}
	
	//unpublishes slide(s) of a site
	function unpublishGallery($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		if($this->input->post("chkSlide"))
		{            
			$this->Gallery_Model->unpublishGallery($this->input->post("chkSlide"));
			redirect("gallery_management/index/".$site_id."/0");
		}          
	}
	//tashes slide(s) of a site
	function trashGallery($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		if($this->input->post("chkSlide"))
		{            
			$this->Gallery_Model->deleteGallery($this->input->post("chkSlide"));
			redirect("gallery_management/index/".$site_id."/0");
		}          
	}
	
	function edit($site_id, $gallery_id)
	{
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Manage Gallery', $this->session->userdata("gallery_link") );
		$this->breadcrumb->add_crumb('Edit');
		//confirm that user has logged in
		$this->checkLogin();
		
		//prepare the data for display
		$data['pages'] 	= $this->Menus_Model->getPages($site_id);        
		$data['roles'] 	= $this->Menus_Model->getRoles(); 
		$data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
		$row = $this->Gallery_Model->get_gallery_info_by_id($gallery_id);
		//echo "<pre>";print_r($row);exit;
		/*echo "<pre>";
		print_r($data['groups']);
		exit;*/
		$data['site_id'] 				= $row['site_id']; 
		$data['gallery_id']			 	= $row['gallery_id'];     
		$data['gallery_title'] 			= $row['gallery_title'];
		$data['gallery_description'] 	= $row['gallery_description'];
		$data['template_options'] 		= $row['template_options'];
		$data['gallery_published'] 		= $row['gallery_published'];
		$data['gallery_styles'] 		= $row['gallery_styles'];
		$data['gallery_pages'] 			= $row['gallery_pages'];
		
		if($row['gallery_pages'] == 'Other')
		{
			$array_gallery_display_pages = $this->Gallery_Model->get_gallery_display_pages($gallery_id);
			
			$gallery_display_pages = array();
			
			foreach($array_gallery_display_pages as $row_gallery_display_pages)
			{
				array_push($gallery_display_pages, $row_gallery_display_pages['page_id']);      
			}  
			
			$data['gallery_display_pages'] = $gallery_display_pages;
		
		}
		else
		{
			$data['gallery_display_pages'] = '';    
		}
		/*echo "<pre>";
		print_r($data['gallery_display_pages']);
		exit;*/
		$data['gallery_access'] = $row['gallery_access'];
		if($row['gallery_access'] == 'Other')
		{
			$array_slideshow_access_roles = $this->Gallery_Model->get_slideshow_access_roles($gallery_id);
			
			$slide_access_roles = array();
			
			foreach($array_slideshow_access_roles as $row_slideshow_access_roles)
			{
				array_push($slide_access_roles, $row_slideshow_access_roles['role_id']);      
			}  
			
			$data['gallery_access_roles'] = $slide_access_roles;    
		}
		else
		{
			$data['gallery_access_roles'] = '';
		}
		$data['gallery_images'] = $this->Gallery_Model->get_gallery_images($gallery_id);
		$data['counter'] = count($data['gallery_images']);
		
		$data['gallery_templates'] = $this->Gallery_Model->get_all_gallery_tamplates();
		
		$template_opt = $this->Gallery_Model->get_gallery_template_option($data['template_options']);
		
		$data['template_option_name'] = $template_opt['template_name'];
	
		//echo "<pre>";print_r($data);exit;
		
		//fill content area with this view
		$this->template->write_view('content','gallery/edit', $data);
		//render the template
		$this->template->render();          
	}
	
	function edit_gallery_info($site_id, $gallery_id)
	{
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		//confirm that user has logged in
		$this->checkLogin();
		if(!isset($_POST))
		{
			//go to edit screen
			$this->edit($site_id, $gallery_id);
		}
		
	
        //save gallery info
		$gallery_data = array();
		//$gallery_data['gallery_id'] = $gallery_id;
		$gallery_data['gallery_title'] 			= $this->input->post('slider_title');
		$gallery_data['gallery_description'] 	= $this->input->post('slider_description');
	  	$gallery_data['template_options'] 		= $this->input->post('template_options');
	  	$gallery_data['gallery_styles'] 		= $this->input->post('gallery_styles');		
		$gallery_data['gallery_published'] 		= $this->input->post('slide_published');
		$gallery_data['gallery_open'] 			= $this->input->post('open_gallery');
		$gallery_data['gallery_status'] 		= "Active";
		$gallery_data['gallery_access'] 		= $this->input->post('slide_access');
		$gallery_data['gallery_pages'] 			= $this->input->post('slide_pages'); 
		$gallery_data['site_id'] 				= $site_id;
		
		$this->Gallery_Model->edit_gallery($gallery_data, $gallery_id);
		
		//delete slider display pages information
		$this->Gallery_Model->delete_gallery_pages_info($gallery_id);
		
		//insert new slider display info
		if($gallery_data['gallery_pages'] == 'Other')
		{
			for($i=0; $i<sizeof($_POST['slide_pages_list']); $i++)
			{
				$page_id = $_POST['slide_pages_list'][$i];
				$this->Gallery_Model->save_gallery_pages_info($gallery_id, $page_id);        
			}    
		}
		
		//delete slider display pages information
		$this->Gallery_Model->delete_gallery_access_info($gallery_id);
		//insert new slider display info
		if($gallery_data['gallery_access'] == 'Other')
		{
			for($i=0; $i<sizeof($_POST['slide_roles_list']); $i++)
			{
				$role_id = $_POST['slide_roles_list'][$i];
				$this->Gallery_Model->save_gallery_roles_info($gallery_id, $role_id);        
			}        
		}
	
		
		//save/upload slideshow images info
		$numImages = $this->input->post('numImages');		
		$image_files = array(); 
		//$ImagesNum +=$_SESSION['numImages']
		//echo "<pre>"; print_r($_POST); exit;
		for($i =1 ; $i<= intval($numImages); $i++)
		{
		
			$file_info 		= array ();
			$config 		= array ();
			$config_resize 	= array ();
			$target 			= $_POST['slide_target'.$i];
			$slide_image_url = $_POST['slide_image_url'.$i];			   
			if(isset($slide_image_url)&& $slide_image_url!="URL" && !empty($slide_image_url)){
				$pos = strpos($slide_image_url, "http://");
				if($pos === false){
					$slide_image_url = "http://".$slide_image_url;
				}	
			}				   
			$slide_title 			= $_POST['slide_title'.$i];
			$slide_description 		= $_POST['slide_description'.$i];
			$image_id = '';
			if(isset($_POST['slide_id'.$i]) && !empty($_POST['slide_id'.$i])){
			$image_id 				= $_POST['slide_id'.$i];		  
			}

			if(!empty($_FILES['slide_image'.$i]['name']))
			{
				
				//$config['file_name'] 	= $slide_image;
				$config['encrypt_name'] = true;			
				$config['upload_path'] 	= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/galleries/full';             	/*if(!is_dir($config['upload_path']))
				{
					mkdir($config['upload_path'],0777,true);
				}*/
				$config['allowed_types'] 	= 'gif|jpg|png|ico|img|jpeg|jpe'; 
				$config['remove_spaces'] 	= TRUE; 
				$config['max_size']   		= '10240';			   
				$this->upload->initialize($config);
				$this->upload->do_upload("slide_image".$i);			 
				$file_info 	= $this->upload->data();
				
				
					if($file_info)
					{  				   
						$this->load->library('image_lib'); 
						$config_resize['source_image'] 		= $file_info['full_path'];
						$config_resize['new_image'] 		= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/galleries/middle/';
						/*if(!is_dir($config_resize['new_image']))
						{
							mkdir($config_resize['new_image'],0777,true);
						}*/
						$config_resize['maintain_ratio'] 	= TRUE;
						$config_resize['width'] 			= 400;  
						$config_resize['height'] 			= 300;
						$this->image_lib->initialize($config_resize);
						$resize_img = $this->image_lib->resize();
						$this->image_lib->clear();
						
						
						
						
						$config_resize['source_image'] 		= $file_info['full_path'];
						$config_resize['new_image'] 		= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/galleries/thumb/';
						/*if(!is_dir($config_resize['new_image']))
						{
							mkdir($config_resize['new_image'],0777,true);
						}*/
						$config_resize['maintain_ratio'] 	= FALSE;
						$config_resize['width'] 			= 28;  
						$config_resize['height'] 			= 28;
						$this->image_lib->initialize($config_resize);
						$resize_img = $this->image_lib->resize();
						$this->image_lib->clear();
						
					} 
					
					$gallery_image_info['gallery_image'] 		= $file_info['file_name'];
										  
				}
				
				$gallery_image_info['gallery_id'] 			= $gallery_id;				
				$gallery_image_info['gallery_image_url'] 	= $slide_image_url;
				$gallery_image_info['gallery_title'] 		= $slide_title;
				$gallery_image_info['gallery_description'] 	= $slide_description;
				$gallery_image_info['gallery_image_status'] = 'Active';				
				$gallery_image_info['target'] 				= $target;
				
				//echo "<pre>";print_r($gallery_image_info);
				
				$this->Gallery_Model->edit_galleries_image_info($gallery_image_info, $image_id);
		
		}
		//exit;
		return true;  
	}
	
	function edit_gallery($site_id, $gallery_id)
	{
		
        $this->edit_gallery_info($site_id, $gallery_id);		
		redirect("gallery_management/index/".$site_id);		
	}
	
	function edit_slide_fancybox($site_id, $slide_id)
	{
		
		$this->edit_slider_info($site_id, $slide_id);
		
		$this->load->view('slides/fancy_close');
		
	}
		
	
	function delete_slide_image_info()
	{
		//confirm user has logged in
		
		$slider_image_id = $_REQUEST['slider_image_id'];
		//echo $slider_image_id;
		
		$this->checkLogin();
		$this->Gallery_Model->delete_slide_image_info($slider_image_id);		
		return true;
		
	}
	
	function save_slide_image_url($slider_image_id)
	{
		//confirm user has logged in
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		exit();*/
		$this->checkLogin();
		
		$slider_image_url = $this->input->post('slider_image_url');
		$slider_image_title = $this->input->post('slider_image_title');
		$slider_image_desc = $this->input->post('slider_image_desc');
		
		$this->Slideshow_Model->save_slide_image_url($slider_image_id, $slider_image_url, $slider_image_title, $slider_image_desc);
		
		return true;
		
	}
	
	function delete_slider_info($slide_id)
	{
		//confirm user has logged in
		$this->checkLogin();
		
		$this->Slideshow_Model->delete_slider_info($slide_id);
		
		return true;    
	}
}
?>