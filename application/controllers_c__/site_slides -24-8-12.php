<?php

if(!session_start()){

	session_start();

}

class Site_slides extends CI_Controller

{ 

	//Constructor Definition

	function Site_slides(){

		parent::__construct(); 

		$this->load->helper('url');   

		$this->load->library('upload'); 

		$this->load->library('Template');

		$this->load->library('upload');

		$this->load->library('session');

		$this->load->library('pagination'); 

		//$this->load->library('image_lib');

		$this->template->set_template('gws');    

		$this->load->model("Menus_Model");

		$this->load->model("PackageModel");

		$this->load->model("Slideshow_Model");  

		$this->load->model("Site_Preview");	

		$this->load->model("Groups_Model");     

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

		$this->breadcrumb->add_crumb('Create');

		//confirm that user has logged in

		$this->checkLogin();

		

		$data['site_id'] = $site_id;

		$data['pages'] = $this->Menus_Model->getPages($site_id);        

		$data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id); 

		$data['modules'] = $this->PackageModel->get_site_package_modules($site_id);

		$data['template_name'] = $this->Site_Preview->getSiteTemplate($site_id);

		$this->template->write_view('content', 'slides/create', $data);   

		

		$this->template->render();

	}

	

	function save_slider_info($site_id)

	{

		$numImages = $this->input->post('numImages');

		/*echo "<pre>";

		print_r($_POST);

		exit;*/

		if(!isset($_POST))

		{

			$this->create($site_id);    

		}

		

		//save slideshow info

		$slide_width = $this->input->post('slide_width');

		$slide_height = $this->input->post('slide_height');

		$caption_option = $this->input->post('slide_dec_position');

		$slide_title = $this->input->post('slider_title');

		$slide_description = $this->input->post('slider_description');

		$slide_position = $this->input->post('slide_position');

		$slide_published = $this->input->post('slide_published');

		$slide_access = $this->input->post('slide_access');

		$slide_pages = $this->input->post('slide_pages'); 

		$slide_groups = $this->input->post('slide_groups');

		

		

		$slide_id = $this->Slideshow_Model->save_slideshow_info($slide_title, $slide_description,$caption_option, $slide_width, $slide_height, $slide_position, $slide_published, $slide_pages, $slide_access, $site_id,$slide_groups);

		

		//save slideshow images info

		$image_files = array();

/*		echo '<pre>';  print_r($_FILES); echo '</pre>';

		exit();*/

		/*echo '<pre>';  print_r($_POST); echo '</pre>';

		exit();*/

		// echo $numImages; die();

		for($i=1; $i<= intval($numImages); $i++)

		{

			$file_info = array ();

			$config = array ();

			$config_resize = array ();

				

			if($_FILES['slide_image'.$i]['tmp_name']!='')

			{

				$time = rand(1000,9999); 



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

					

			   }			   

			   if(isset($_POST['slide_title'.$i]) &&  $_POST['slide_title'.$i] == 'Title')

			   {

			   		$slide_title = '';

			   }

			   else

			   {

			   		$slide_title = $_POST['slide_title'.$i];

			   }

			   if(isset($_POST['slide_description'.$i]) &&  $_POST['slide_description'.$i] == 'Description')

			   {

			   	$slide_description = '';

			   }

			   else

			   {

			   	$slide_description = $_POST['slide_description'.$i];

			   }

				

				$config['file_name'] = $slide_image;

				

				$image_upload_path_thumb = "media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images/";

				$image_upload_path = "media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/images/";

				

				$config['upload_path'] = $image_upload_path;           
				if(!is_dir($config['upload_path']))
				  {
					 mkdir($config['upload_path'],0777,true);
				  }
				$config['allowed_types'] = 'gif|jpg|png|ico|img|jpeg|JPG|PNG|GIF'; 

				$config['remove_spaces'] = TRUE; 

				$config['max_size']    = '10240';

			  



				$this->upload->initialize($config);

				$this->upload->do_upload("slide_image".$i);



				$file_info = $this->upload->data();

				/*$upload_error = array('error' => $this->upload->display_errors());

				echo '<pre>';  print_r($upload_error); echo '</pre>';*/

				

				

				if($file_info){  

				    // echo '<pre>';  print_r($file_info); echo '</pre>'; die();

					

					$this->load->library('image_lib'); 

					

					$thumb_widths = array(25,200,$slide_width);

					$thumb_heights = array(25,150,$slide_height);

					

					$j = 0;

					for($j = 0; $j < 3; $j++)

					{

						$config_resize['source_image'] = $file_info['full_path'];

						$config_resize['new_image'] = $image_upload_path_thumb;

						$config_resize['maintain_ratio'] = FALSE;

						$config_resize['create_thumb'] = TRUE;

					   // $config_resize['master_dim'] = "auto";

						$config_resize['thumb_marker'] = "_thumb".$j;

					 

						$config_resize['width'] = trim($thumb_widths[$j]);  

						$config_resize['height'] = trim($thumb_heights[$j]);     

					 

					   // $this->load->library('image_lib', $config_resize);

					   // $resize_img = $this->image_lib->resize();

					   // $this->image_lib->clear();

						$this->image_lib->initialize($config_resize);

						$resize_img = $this->image_lib->resize();

						//echo $this->image_lib->display_errors();

						$this->image_lib->clear();

						

						

						

						

						

						

						

						

					}

					

					$image_name = explode(".",$slide_image);

					$ext = $image_name[1];

					$name = $image_name[0];

					$slide_image = $image_upload_path_thumb.$name."_thumb2.".$ext;

					//save slideshow image info

					$this->Slideshow_Model->save_slideshow_image_info($slide_id, $slide_image, $slide_image_url,$slide_title,$slide_description, $target);

					

				   // exit();        

				}  

				//  echo '<pre>';  print_r($resize_img);  echo '</pre>';  

				  

				

																

			}

			

		}     

		

		//save slideshow display pages

		if($slide_pages == 'Other')

		{

			for($i=0; $i<sizeof($_POST['slide_pages_list']); $i++)

			{

				$page_id = $_POST['slide_pages_list'][$i];

				$this->Slideshow_Model->save_slideshow_pages_info($slide_id, $page_id);        

			}    

		}

		

		//save slideshow roles

		if($slide_access == 'Other')

		{

			for($i=0; $i<sizeof($_POST['slide_roles_list']); $i++)

			{

				$role_id = $_POST['slide_roles_list'][$i];

				$this->Slideshow_Model->save_slideshow_roles_info($slide_id, $role_id);        

			}    

		}

		//exit(); 

		return true;       

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

	function index($site_id, $from)

	{

		$slide_link = current_url();

		$this->session->set_userdata("slide_link", $slide_link); 

		

		$this->breadcrumb->clear();

        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );

		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 

		$this->breadcrumb->add_crumb('Manage Slideshows' );

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

				

		$data["records"] = $this->Slideshow_Model->get_all_site_slides($from, $data["pageLimit"], $site_id);

		

		$data["slides_list"] = $this->Slideshow_Model->get_all_slides($site_id);

		

		$data["numRecords"] = $data["records"]->num_rows();

		

		$data["from"] = $from;        

		

		$data["totalRecords"] = $this->Slideshow_Model->totalSlides($site_id); 

		

		$config = array(

			'uri_segment' => 4,

			'base_url' => base_url().index_page().'site_slides/index/'.$site_id."/",

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

		

		$this->template->write_view('content','slides/index', $data);

		

		$this->template->render();    

	}

	

	//published slide(s) of a site

	function publishSlide($site_id)

	{

		//confirm that user has logged in

		$this->checkLogin();

		

		if($this->input->post("chkSlide"))

		{            

			$this->Slideshow_Model->publishSlides($this->input->post("chkSlide"));

			redirect("site_slides/index/".$site_id."/0");

		}          

	}

	

	//unpublishes slide(s) of a site

	function unpublishSlide($site_id)

	{

		//confirm that user has logged in

		$this->checkLogin();

		

		if($this->input->post("chkSlide"))

		{            

			$this->Slideshow_Model->unpublishSlides($this->input->post("chkSlide"));

			redirect("site_slides/index/".$site_id."/0");

		}          

	}

	//tashes slide(s) of a site

	function trashSlide($site_id)

	{

		//confirm that user has logged in

		$this->checkLogin();

		

		if($this->input->post("chkSlide"))

		{            

			$this->Slideshow_Model->deleteSlides($this->input->post("chkSlide"));

			redirect("site_slides/index/".$site_id."/0");

		}          

	}

	

	function edit($site_id, $slide_id)

	{

		

	    $this->breadcrumb->clear();

        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );

		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 

		$this->breadcrumb->add_crumb('Manage Slideshows', $this->session->userdata("slide_link") ); 

		$this->breadcrumb->add_crumb('Edit');

		//confirm that user has logged in

		$this->checkLogin();

		

		//prepare the data for display

		$data['pages'] = $this->Menus_Model->getPages($site_id);        

		$data['roles'] = $this->Menus_Model->getRoles(); 

		

		$row = $this->Slideshow_Model->get_slide_info_by_id($slide_id);

		

		$data['site_id'] = $row['site_id']; 

		$data['slide_id'] = $row['slide_id'];     

		$data['slide_title'] = $row['slide_title'];

		$data['slide_description'] = $row['slide_description'];

		$data['template_name'] = $this->Site_Preview->getSiteTemplate($site_id);

		$data['slide_position'] = $row['slide_position'];

		$data['slide_published'] = $row['slide_published'];

		$data['slide_width'] = $row['slide_width'];

		$data['slide_height'] = $row['slide_height'];

		$data['caption_position'] = $row['caption_position'];

		

		$data['slide_pages'] = $row['slide_pages'];

		if($row['slide_pages'] == 'Other')

		{

			$array_slideshow_display_pages = $this->Slideshow_Model->get_slideshow_display_pages($slide_id);

			

			$slide_display_pages = array();

			

			foreach($array_slideshow_display_pages as $row_slideshow_display_pages)

			{

				array_push($slide_display_pages, $row_slideshow_display_pages['page_id']);      

			}  

			

			$data['slide_display_pages'] = $slide_display_pages;

		

		}

		else

		{

			$data['slide_display_pages'] = '';    

		}

		

		$data['slide_access'] = $row['slide_access'];

		if($row['slide_access'] == 'Other')

		{

			$slide_groups = $this->Slideshow_Model->get_slideshow_groups($slide_id,$site_id);

			$data['current_slide_groups'] = $slide_groups;    

		}

		else

		{

			$data['slide_access_roles'] = '';

		}

		

		$data['slide_images'] = $this->Slideshow_Model->get_slideshow_images($slide_id);

		$data['groups'] = $this->Groups_Model->get_all_site_gropus($site_id);

		

		//fill content area with this view

		$this->template->write_view('content','slides/edit', $data);

		

		//render the template

		$this->template->render();          

		

	}

	

	function edit_slider_info($site_id, $slide_id)

	{

		

		/*echo "I am Here ...";

		exit();

		confirm that user has logged in*/

		/*echo "<pre>";

		print_r($_POST);

		exit;*/

		

		$this->checkLogin();

		

		if(!isset($_POST))

		{

			//go to edit screen

			$this->edit($site_id, $slide_id);

		}

		

		$slide_width = $this->input->post('slide_width');

		$slide_height = $this->input->post('slide_height');

		$caption_option = $this->input->post('slide_dec_position');

		$slide_title = $this->input->post('slider_title');

		$slide_description = $this->input->post('slider_description');

		$slide_position = $this->input->post('slide_position');

		$slide_published = $this->input->post('slide_published');  

		$slide_pages = $this->input->post('slide_pages');

		$slide_access = $this->input->post('slide_access');

		$slide_groups = $this->input->post('slide_groups');

		

		$this->Slideshow_Model->edit_slide($slide_id, $slide_title, $slide_description,$caption_option, $slide_width, $slide_height, $slide_position, $slide_published, $slide_pages, $slide_access,$slide_groups);

		

		//delete slider display pages information

		$this->Slideshow_Model->delete_slide_pages_info($slide_id);

		//insert new slider display info

		if($slide_pages == 'Other')

		{

			for($i=0; $i<sizeof($_POST['slide_pages_list']); $i++)

			{

				$page_id = $_POST['slide_pages_list'][$i];

				$this->Slideshow_Model->save_slideshow_pages_info($slide_id, $page_id);        

			}    

		}

		

		//delete slider display pages information

		$this->Slideshow_Model->delete_slide_access_info($slide_id);

		//insert new slider display info

		if($slide_access == 'Other')

		{

			for($i=0; $i<sizeof($_POST['slide_roles_list']); $i++)

			{

				$role_id = $_POST['slide_roles_list'][$i];

				$this->Slideshow_Model->save_slideshow_roles_info($slide_id, $role_id);        

			}        

		}

		

		//save/upload slideshow images info

		$numImages = $this->input->post('numImages');		

		$image_files = array(); 

		

		for($i=1; $i<= intval($numImages); $i++)

		{

			

			$file_info = array ();

			$config = array ();



			$config_resize = array ();

			

			if(isset($_FILES['slide_image'.$i]['tmp_name']) && $_FILES['slide_image'.$i]['tmp_name']!='')

			{

				

				$rand = rand(1000,9999);

				$filename = str_replace("thumb","_fixed",$_FILES['slide_image'.$i]['name']); 

				$slide_image = $rand.$filename;

							

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

				if(isset($_POST['slide_title'.$i]) &&  $_POST['slide_title'.$i] == 'Title')

				{

					$slide_title = '';

				}

				else

				{

					$slide_title = $_POST['slide_title'.$i];

				}

				if(isset($_POST['slide_description'.$i]) &&  $_POST['slide_description'.$i] == 'Description')

				{

					$slide_description = '';

				}

				else

				{

					$slide_description = $_POST['slide_description'.$i];

				}

				$target = $_POST['slide_target'.$i];

				

				// die($slide_image);

				

				$image_upload_path_thumb = "media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/_thumbs/Images/";

				$image_upload_path = "media/ckeditor_uploads/".$_SESSION['user_info']['user_login']."_".$_SESSION['user_info']['user_id']."/images/";

				

				$config['file_name'] = $slide_image;

				$config['upload_path'] = $image_upload_path; 
				if(!is_dir($config['upload_path']))
				  {
				     mkdir($config['upload_path'],0777,true);
				  }

				$config['allowed_types'] = 'gif|jpg|png|ico|img|jpeg|JPG|PNG|GIF|JPEG'; 

				$config['remove_spaces'] = TRUE; 

				$config['max_size']    = '10240';

				

				$this->upload->initialize($config);

				$this->upload->do_upload("slide_image".$i);

				$file_info = $this->upload->data();

				

				if($file_info)

				{  

					// echo '<pre>';  print_r($file_info); echo '</pre>'; die();

					

					$this->load->library('image_lib'); 

					$thumb_widths = array(25,200,$slide_width);

					$thumb_heights = array(25,150,$slide_height);

					

					$j = 0;

					for($j = 0; $j < 3; $j++)

					{

						$config_resize['source_image'] = $file_info['full_path'];

						$config_resize['new_image'] = $image_upload_path_thumb;

						$config_resize['maintain_ratio'] = FALSE;

						$config_resize['create_thumb'] = TRUE;

					   // $config_resize['master_dim'] = "auto";

						$config_resize['thumb_marker'] = "_thumb".$j;

					 

						$config_resize['width'] = trim($thumb_widths[$j]);  

						$config_resize['height'] = trim($thumb_heights[$j]);     

					 

					   // $this->load->library('image_lib', $config_resize);

					   // $resize_img = $this->image_lib->resize();

					   // $this->image_lib->clear();

						$this->image_lib->initialize($config_resize);

						$resize_img = $this->image_lib->resize();

						//echo $this->image_lib->display_errors();

						$this->image_lib->clear();

					}

					

					$image_name = explode(".",$slide_image);

					$ext = $image_name[1];

					$name = $image_name[0];

					$slide_image = $image_upload_path_thumb.$name."_thumb2.".$ext;

					//save edited slideshow image info

					$this->Slideshow_Model->save_slideshow_image_info($slide_id, $slide_image, $slide_image_url,$slide_title,$slide_description, $target);

				   

				}

  

				

				

			}

		}

		

		//create images thumbs

		$this->load->library('image_lib');

		

		//select previous slideshow dimensions adjustment

		$image_dim = $this->Slideshow_Model->get_slider_dimension($slide_id);

		if($image_dim['width']>0 && $image_dim['height']>0)

		{

			$image_width = $image_dim['width'];

			$image_height = $image_dim['height'];    

		}

		return true;  

	}

	

	function edit_slide($site_id, $slide_id)

	{

		

		$this->edit_slider_info($site_id, $slide_id);

		

		redirect(base_url().index_page().'site_slides/index/'.$site_id.'/0');

		

	}

	

	function edit_slide_fancybox($site_id, $slide_id)

	{

		

		$this->edit_slider_info($site_id, $slide_id);

		

		$this->load->view('slides/fancy_close');

		

	}

		

	

	function delete_slide_image_info($slide_image_id)

	{

		//confirm user has logged in

		$this->checkLogin();

		

		$this->Slideshow_Model->delete_slide_image_info($slide_image_id);

		

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