<?php
if(!session_start()){
	session_start();
}
class Video_Gallery extends CI_Controller
{ 
	//Constructor Definition
	function Video_Gallery(){
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
		$this->load->model("Video_Gallery_Model");
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
	
	function create_video_gallery($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		$data['site_id'] = $site_id;
		$data['pages'] = $this->Menus_Model->getPages($site_id);        
		$data['roles'] = $this->Menus_Model->getRoles(); 
		$data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
		/*print_r($data['groups']);
		echo "hello ahmed";*/
		
		$data['modules'] = $this->PackageModel->get_site_package_modules($site_id);
		$data['template_name'] = $this->Site_Preview->getSiteTemplate($site_id);
		$this->template->write_view('content', 'video_gallery/create_video_gallery', $data);   
		
		$this->template->render();
	}
	
	function save_gallery_info($site_id)
	{
		$numImages = $this->input->post('numImages');
		
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
		$gallery_data['gallery_open'] = $this->input->post('gallery_open');
		$gallery_data['gallery_status'] = "Active";
		$gallery_data['gallery_access'] = $this->input->post('slide_access');
		$gallery_data['gallery_pages'] = $this->input->post('slide_pages'); 
		$gallery_data['site_id'] = $site_id;
		
		$gallery_id = $this->Video_Gallery_Model->save_gallery_info($gallery_data);
		//exit;
		//save gallery images info
		$image_files = array();
		/*echo '<pre>';  print_r($_FILES); echo '</pre>';
		exit();*/
		/*echo '<pre>';  print_r($_POST); echo '</pre>';
		exit();*/
		
		for($i=1; $i<= intval($numImages); $i++)
		{
			$file_info = array ();
			$config = array ();
			$config_resize = array ();
			$array_thumb_size = array(0 => 28, 1 => 300, 2 => 200 , 3 => 150);
			if($_FILES['slide_image'.$i]['tmp_name']!='')
			{
				$time = date('his'); 

			   $slide_image = $time.$_FILES['slide_image'.$i]['name'];
			   $target = $_POST['slide_target'.$i];
			   $slide_image_url = $_POST['slide_image_url'.$i];			   
			   if(isset($slide_image_url)&& $slide_image_url!="URL" && !empty($slide_image_url))
			   {
			   		$pos = strpos($slide_image_url, "http://");
					if($pos === false)
					{
						$slide_image_url = "http://".$slide_image_url;
					}
					/*else
					{
						echo "found";
						exit;
					}*/
			   }			   
			   $slide_title = $_POST['slide_title'.$i];
			   $slide_description = $_POST['slide_description'.$i];
				
				$config['file_name'] = $slide_image;
				$config['upload_path'] = './galleries/';            
				$config['allowed_types'] = 'mp4|m4v|mov|avi|flv|wmv|swf';
				$config['remove_spaces'] = TRUE; 
				$config['max_size']    = '10240';			   

				$this->upload->initialize($config);
				$this->upload->do_upload("slide_image".$i);
			  //  $this->image_lib->clear(); 
				$file_info = $this->upload->data();
				/*$upload_error = array('error' => $this->upload->display_errors());
				echo '<pre>';  print_r($upload_error); echo '</pre>';*/
				for($j=0; $j < count($array_thumb_size); $j++)
				{
					if($file_info)
					{  				   
						$this->load->library('image_lib'); 
						$config_resize['source_image'] = $file_info['full_path'];
						$config_resize['new_image'] = './galleries/';
						$config_resize['maintain_ratio'] = TRUE;
						$config_resize['create_thumb'] = TRUE;
						$config_resize['thumb_marker'] = "_thumb";
						$config_resize['width'] = $array_thumb_size[$j];  
						$config_resize['height'] = 471;
						$this->image_lib->initialize($config_resize);
						$resize_img = $this->image_lib->resize();
						$this->image_lib->clear();  
					}  
					//echo '<pre>';  print_r($resize_img);  echo '</pre>';  
					  
					array_push($image_files, $file_info['full_path']); 
					$image_path = $file_info['file_path'];
					if($i==1)
					{
						$image_width = $file_info['image_width'];
						$image_height = $file_info['image_height'];
					}
					
					//save slideshow image info
					$slide_image_name_parts = explode('.', $slide_image);
					$slide_image_name_parts[0] .= '_thumb_'.$array_thumb_size[$j];
					$slide_image = $slide_image_name_parts[0].'.'.$slide_image_name_parts[1];
					
					$config['file_name'] = $slide_image;
					$this->upload->initialize($config);
					$this->upload->do_upload("slide_image".$i);              
					$file_info = $this->upload->data();
					$slide_image = $time.$_FILES['slide_image'.$i]['name'];
					
				}
				
				$gallery_image_info['gallery_id'] = $gallery_id;
				$gallery_image_info['gallery_image'] = $slide_image;
				$gallery_image_info['gallery_image_url'] = $slide_image_url;
				$gallery_image_info['gallery_title'] = $slide_title;
				$gallery_image_info['gallery_description'] = $slide_description;
				$gallery_image_info['gallery_image_status'] = 'Active';				
				$gallery_image_info['target'] = $target;
				
				$this->Video_Gallery_Model->save_galleries_image_info($gallery_image_info);
			}
		}     
		
		//save slideshow display pages
		$gallery_pages = $this->input->post('slide_pages');
		if(isset($gallery_pages)&&$gallery_pages == 'Other')
		{
			for($i=0; $i<sizeof($_POST['slide_pages_list']); $i++)
			{
				$page_id = $_POST['slide_pages_list'][$i];
				$this->Video_Gallery_Model->save_gallery_pages_info($gallery_id, $page_id);        
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
	function index($site_id,$from=0)
	{
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
		$data["records"] = $this->Video_Gallery_Model->get_gallries($site_id);
		$data["numRecords"] = count($data["records"]);
		$data["totalRecords"] = count($data["records"]); 
				
		$config = array(
			'uri_segment' => 4,
			'base_url' => base_url().index_page().'video_gallery/index/'.$site_id."/",
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
		$this->template->write_view('content','video_gallery/gallery_list', $data);
		$this->template->render();    
	}
	
	function view_gallery($site_id, $gallery_id)
	{
		
		$data['rows'] = $this->Video_Gallery_Model->get_gallery_images($gallery_id);
		/*echo '<pre>';
		print_r($row);exit;*/
		$this->template->write_view('content','video_gallery/video_gallery_view', $data);
		$this->template->render();   
	}	
	//Video Index Page with Light Box
	function upload_video_page()
	{
		$this->template->add_js('js/jwplayer.js'); 		
		$data["counter"] = '';
		//$control_counter =  $counter ; 
		//$data["counter"]  = $control_counter;		
		//echo $control_counter; 
		$this->load->view('video_gallery/upload_video_page',$data);	   
	}
	
	
	
	function video_upload($site_id)
	{
		
		// echo "<pre>";	print_r($_POST);	exit;
		
		$gallery_data = array();
		$numImages = $this->input->post('numImages');
		$gallery_data['gallery_title'] = $this->input->post('slider_title');
		$gallery_data['gallery_description'] = $this->input->post('slider_description');
	  	$gallery_data['template_options'] = $this->input->post('template_options');
	  	$gallery_data['gallery_styles'] = $this->input->post('gallery_styles');		
		$gallery_data['gallery_published'] = $this->input->post('slide_published');
		$gallery_data['gallery_open'] = $this->input->post('gallery_open');
		$gallery_data['gallery_status'] = "Active";
		$gallery_data['gallery_access'] = $this->input->post('slide_access');
		$gallery_data['gallery_pages'] = $this->input->post('slide_pages'); 
		$gallery_data['gallery_type'] = 'video'; 		
		$gallery_data['site_id'] = $site_id;
		
		$gallery_id = $this->Video_Gallery_Model->save_gallery_info($gallery_data);
		
		
		
		for($i=1; $i<= intval($numImages); $i++)
		{
			$file_info = array ();
			$config = array ();
			$config_resize = array ();
			if($_FILES['slide_image'.$i]['tmp_name']!='')
			{
				$time = date('his'); 

			   $slide_image = rand(100000,9999999).$_FILES['slide_image'.$i]['name'];
			   $target = $_POST['slide_target'.$i];
			   $slide_image_url = $_POST['slide_image_url'.$i];			   
			   if(isset($slide_image_url)&& $slide_image_url!="URL" && !empty($slide_image_url))
			   {
			   		$pos = strpos($slide_image_url, "http://");
					if($pos === false)
					{
						$slide_image_url = "http://".$slide_image_url;
					}
					/*else
					{
						echo "found";
						exit;
					}*/
			   }			   
			   $slide_title = $_POST['slide_title'.$i];
			   $slide_description = $_POST['slide_description'.$i];
				$slide_image = str_replace(" ","-",$slide_image);
				$config['file_name'] = $slide_image;
				$config['upload_path'] 	= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/videos'; 
				if(!is_dir($config['upload_path']))
				{
				 	mkdir($config['upload_path'],0777,true);
				}
				$config['allowed_types'] = 'mp4|m4v|mov|avi|flv|wmv|swf';
				$config['remove_spaces'] = TRUE; 
				$config['max_size']    = '10240';			   

				$this->upload->initialize($config);
				$this->upload->do_upload("slide_image".$i);
				$file_info = $this->upload->data();
				
				
				$gallery_image_info['gallery_id'] = $gallery_id;
				$gallery_image_info['gallery_image'] = $slide_image;
				$gallery_image_info['gallery_image_url'] = $slide_image_url;
				$gallery_image_info['gallery_title'] = $slide_title;
				$gallery_image_info['gallery_description'] = $slide_description;
				$gallery_image_info['gallery_image_status'] = 'Active';				
				$gallery_image_info['target'] = $target;
				
				$this->Video_Gallery_Model->save_galleries_image_info($gallery_image_info);
				
			}
		}
		
			//save slideshow display pages
		$gallery_pages = $this->input->post('slide_pages');
		if(isset($gallery_pages)&&$gallery_pages == 'Other')
		{
			for($i=0; $i<sizeof($_POST['slide_pages_list']); $i++)
			{
				$page_id = $_POST['slide_pages_list'][$i];
				$this->Video_Gallery_Model->save_gallery_pages_info($gallery_id, $page_id);        
			}    
		}
		

		
		//save slideshow roles
		$gallery_access = $this->input->post('slide_access');
		if(isset($gallery_access)&&$gallery_access == 'Other')
		{
			for($i=0; $i<sizeof($_POST['slide_roles_list']); $i++)
			{
				$role_id = $_POST['slide_roles_list'][$i];
				$this->Video_Gallery_Model->save_gallery_roles_info($gallery_id, $role_id);
			}    
		}
		
			redirect('video_gallery/index/'.$site_id);
	}
	
	
	//published Gallery(s) of a site
	function publishGallery($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		if($this->input->post("chkSlide"))
		{            
			$this->Video_Gallery_Model->publishGallery($this->input->post("chkSlide"));
			redirect('video_gallery/index/'.$site_id);
		}          
	}
	
	//unpublishes slide(s) of a site
	function unpublishGallery($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		if($this->input->post("chkSlide"))
		{            
			$this->Video_Gallery_Model->unpublishGallery($this->input->post("chkSlide"));
			redirect('video_gallery/index/'.$site_id);
		}          
	}
	//tashes slide(s) of a site
	function trashGallery($site_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		if($this->input->post("chkSlide"))
		{            
			$this->Video_Gallery_Model->deleteGallery($this->input->post("chkSlide"));
			redirect('video_gallery/index/'.$site_id);
		}          
	}
	
	function edit($site_id, $gallery_id)
	{
		//confirm that user has logged in
		$this->checkLogin();
		
		//prepare the data for display
		$data['pages'] = $this->Menus_Model->getPages($site_id);        
		$data['roles'] = $this->Menus_Model->getRoles(); 
		$data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);
		$row = $this->Gallery_Model->get_gallery_info_by_id($gallery_id);
		/*echo "<pre>";
		print_r($data['groups']);
		exit;*/
		$data['site_id'] = $row['site_id']; 
		$data['gallery_id'] = $row['gallery_id'];     
		$data['gallery_title'] = $row['gallery_title'];
		$data['gallery_description'] = $row['gallery_description'];
		$data['template_options'] = $row['template_options'];
		$data['gallery_published'] = $row['gallery_published'];
		$data['gallery_styles'] = $row['gallery_styles'];
		$data['gallery_pages'] = $row['gallery_pages'];
		
		if($row['gallery_pages'] == 'Other')
		{
			$array_gallery_display_pages = $this->Video_Gallery_Model->get_gallery_display_pages($gallery_id);
			
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
			$array_slideshow_access_roles = $this->Video_Gallery_Model->get_slideshow_access_roles($gallery_id);
			
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
		$data['gallery_images'] = $this->Video_Gallery_Model->get_gallery_images($gallery_id);
		
		/*echo "<pre>";
		print_r($data);
		exit();*/
		
		//fill content area with this view
		$this->template->write_view('content','video_gallery/edit', $data);
		//render the template
		$this->template->render();          
	}
	
	function edit_gallery_info($site_id, $gallery_id)
	{
		/*echo '<pre>'; 
		print_r($_FILES); 
		exit();*/
		
		$numImages = $this->input->post('numImages');
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
		$gallery_data['gallery_open'] = $this->input->post('gallery_open');
		$gallery_data['gallery_status'] = "Active";
		$gallery_data['gallery_access'] = $this->input->post('slide_access');
		$gallery_data['gallery_pages'] = $this->input->post('slide_pages'); 
		$gallery_data['site_id'] = $site_id;
		
		$this->Video_Gallery_Model->edit_gallery($gallery_data, $gallery_id);
		//exit;
		//save gallery images info
		$image_files = array();
		/*echo '<pre>'; 
		 print_r($_FILES); 
		exit();*/
		/*echo '<pre>';  print_r($_POST); echo '</pre>';
		exit();*/
		$gallery_pages = $this->input->post('slide_pages');
		//echo count($_POST['slide_pages_list']);exit;
		if(isset($gallery_pages)&&$gallery_pages == 'Other')
		{
			
			if(count($_POST['slide_pages_list'])>0)
			{
				$this->Video_Gallery_Model->delete_gallery_pages_info($gallery_id);
			}
			
			for($i=0; $i<sizeof($_POST['slide_pages_list']); $i++)
			{
				$page_id = $_POST['slide_pages_list'][$i];
				$this->Video_Gallery_Model->save_gallery_pages_info($gallery_id, $page_id);        
			}    
		}
		//echo intval($numImages);
		for($i=1; $i<= intval($numImages); $i++)
		{
			$file_info = array ();
			$config = array ();
			$config_resize = array ();
			$array_thumb_size = array(0 => 28, 1 => 300, 2 => 200 , 3 => 150);
			if(isset($_FILES['slide_image'.$i]['tmp_name']) && $_FILES['slide_image'.$i]['tmp_name']!='')
			{
				$time = date('his'); 

			   $slide_image = $time.$_FILES['slide_image'.$i]['name'];
			   $target = $_POST['slide_target'.$i];
			   $slide_image_url = $_POST['slide_image_url'.$i];			   
			   if(isset($slide_image_url)&& $slide_image_url!="URL" && !empty($slide_image_url))
			   {
			   		$pos = strpos($slide_image_url, "http://");
					if($pos === false)
					{
						$slide_image_url = "http://".$slide_image_url;
					}
					/*else
					{
						echo "found";
						exit;
					}*/
			   }			   
			    $slide_title = $_POST['slide_title'.$i];
			    $slide_description = $_POST['slide_description'.$i];
				$slide_image = str_replace(" ","-",$slide_image);
				$config['file_name'] = $slide_image;
				$config['upload_path'] 	= realpath('.').'/media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/videos';            
				$config['allowed_types'] = 'mp4|m4v|mov|avi|flv|wmv|swf';
				$config['remove_spaces'] = TRUE; 
				$config['max_size']    = '10240';
				$this->upload->initialize($config);
				$this->upload->do_upload("slide_image".$i);
				$file_info = $this->upload->data();
				$gallery_image_info['gallery_id'] = $gallery_id;
				$gallery_image_info['gallery_image'] = $slide_image;
				$gallery_image_info['gallery_image_url'] = $slide_image_url;
				$gallery_image_info['gallery_title'] = $slide_title;
				$gallery_image_info['gallery_description'] = $slide_description;
				$gallery_image_info['gallery_image_status'] = 'Active';				
				$gallery_image_info['target'] = $target;
				
				$this->Video_Gallery_Model->edit_galleries_image_info($gallery_image_info,$gallery_id);
			}
		}   
		
		return true;  
	}
	
	function edit_gallery($gallery_id, $site_id)
	{
		$this->edit_gallery_info($site_id, $gallery_id);		
		redirect("video_gallery/index/".$site_id);		
	}
	
	function edit_slide_fancybox($site_id, $slide_id)
	{
		
		$this->edit_slider_info($site_id, $slide_id);
		
		$this->load->view('slides/fancy_close');
		
	}
		
	
	function delete_video_info($slide_image_id)
	{
		//confirm user has logged in
		$this->checkLogin();
		
		$this->Video_Gallery_Model->delete_video_info($slide_image_id);
		
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