<?php
if(!session_start()){
	session_start();
}
class PagesController extends CI_Controller{
	
	//Constructor Definition
	function PagesController(){
		parent::__construct(); 
		$this->load->model("Pages_Model");
		$this->load->model("Menus_Model");
		$this->load->library('pagination');
		$this->load->library('session');    
		$this->load->helper('url');   
		$this->load->library('form_validation');        
		$this->load->helper('html'); 
		$this->load->library('upload'); 
		$this->load->library('Template');
		$this->template->set_template('gws');        
	}
	
   function ajax_content_add()
	{  
			$data = array ();  
		   if (isset($_POST) )
			{
				$data['page_id'] =  trim($_POST['page_id']);
				$data['element_id'] = trim($_POST['element_id']);
				$data['data'] = trim($_POST['data']);
				$data['pos_top'] = trim($_POST['pos_top']);
				$data['pos_left'] = trim($_POST['pos_left']);
				$Field = explode("_", $data['element_id']);
				$data['type'] =  $Field[0];
				$data['id'] =  $Field[1];
			  
				
			  if($this->Pages_Model->check_elementID_exist($data))
			   {
				  $this->Pages_Model->ajax_content_data_update($data);  
			   }else
			   { 
				  $this->Pages_Model->ajax_content_data_add($data);   
			   }
			  
			 // print_r($data);
			//  echo $page_id.">>>>>";
			  return true;
							 
		   }
		return false;   
	 }
	 
	 
	   function ajax_content_image_save()
	{  
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
			$data = array ();
			$image = array ();  
		   if (isset($_POST) )
			{
				$data['page_id'] =  trim($_POST['page_id']);
				$data['element_id'] = trim($_POST['element_id']);
				$data['src'] = trim($_POST['src']);
				$image =  explode("/", $data['src']);
				$data['image'] =  end($image);
				$data['pos_top'] = trim($_POST['pos_top']);
				$data['pos_left'] = trim($_POST['pos_left']);
				$Field = explode("_", $data['element_id']);
				$data['type'] =  'image';
				$data['id'] =  $Field[1];
				$data['img_id'] =  'image_'.$data['id'];
				/*
				echo "<pre>";
				print_r($data);
				exit; */
			   //echo $this->Pages_Model->check_img_exist($data); 
			   //echo  $data['image']; exit;
			  if($this->Pages_Model->check_img_exist($data))
			   {
				  $this->Pages_Model->ajax_content_img_update($data);  
			  }else
			   { 
				   if($data['image']!='na.jpg')
				   {
						$this->Pages_Model->ajax_content_img_add($data);       
				   }
			   }
			  
			// print_r($data);
			
			  return true;
							 
		   }
		return false;   
	 } 
	
	 
	function ajax_content_delete()
	{  
			$data = array (); 
			// print_r($data);  
		   if (isset($_POST) )
			{
				$data['page_id'] =  trim($_POST['page_id']);
				$data['element_id'] = trim($_POST['element_id']);
				
				$this->Pages_Model->ajax_content_data_delete($data); 
				return true;   
			}
			  
			 // print_r($data);
			//  echo $page_id.">>>>>";
			  return false;  
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
	// (START) Intro: This Code is to Create A Page in 3 Steps 
	
	//loads Step-1 View(page/create/basic_info) of Page Creation if user is logged in 
	function basic_info($site_id)
	{
		//checks user login
		$this->checkLogin();
		
		if(isset($_POST['page_id']))
		{
			$data['action'] = 'edit';
			$data['site_id'] = $site_id;
			$data['page_id'] = $this->input->post('page_id');
			$page_id = $this->input->post('page_id');  
			$result = $this->Pages_Model->pageInfo($page_id);
			$row = $result->row_array();
			$data['page_title'] = $row['page_title'];
			$data['item_name'] = $this->input->post('item_name');
			$data['page_seo_url'] = $row['page_seo_url'];
			$data['page_keywords'] = $row['page_keywords'];   
			$data['page_desc'] = $row['page_desc']; 
			
			//delete page menu & access info
			$item_id = $_POST['item_id'];
			$this->Pages_Model->delete_page_menu_access_info($page_id, $item_id);
			 
		}
		else
		{
			$data['action'] = 'add'; 
			$data['site_id'] = $site_id;
			$data['page_id'] = '';
			$data['page_title'] = '';
			$data['item_name'] = '';
			$data['page_seo_url'] = '';
			$data['page_keywords'] = '';   
			$data['page_desc'] = '';    
		}
		//prepares data
		//$data['site_id'] = $site_id;
		//$data['page_id'] = '';
		//$data['page_title'] = '';
		//$data['item_name'] = '';
		//$data['page_seo_url'] = '';
		//$data['page_keywords'] = '';
		//$data['page_desc'] = ''; 
		//if(!isset($page_id))
		//{
			//echo "page_id is not set";
			//$data['action'] = "add"; 
			//$data['menus'] = $this->Menus_Model->getAllMenus($site_id);                
			//$data['roles'] = $this->Menus_Model->getRoles();
			//$this->load->view("page/create/basic_info", $data);
			//writes view: page/create/basic_info to content region of template with $data
			//$this->template->write_view('content','page/create/basic_info', $data);
			//write the complete template    
		//}
		//else
		//{        
			//echo "page_id is set";
			//exit;
			/*$data['page_id'] = $page_id; 
			$result = $this->Pages_Model->pageInfo($page_id);
			if($result->num_rows()>0)
			{
				$data['action'] = 'update';
				$row = $result->row_array();
				
				$data['page_title'] = $row['page_title'];
				$data['page_seo_url'] = $row['page_seo_url'];  
				$data['page_keywords'] = $row['page_keywords'];
				$data['page_desc'] = $row['page_desc'];
				
			}
			else
			{
				//echo "invalid page_id";      
				$data['action'] = 'add'; 
			}*/
			
		//}
		
				/*
				echo "<pre>";
				print_r($data); 
				echo "</pre>";
				//exit;   
				*/
		$this->template->write_view('content','page/create/basic_info', $data);         
		$this->template->render();   
	}
	
	//performs form validation
	//adds page record in DB
	//loads Step-2 View(page/create/page_menu) of Page Creation(menu selection & access desc)
	//menus_model used (functions: getAllMenus, getRoles)
	function create_page()
	{
		//checks user login
		$this->checkLogin();
		//prepares data 
		$data['site_id'] =  $this->input->post("site_id"); 
		$data['item_name'] =  $this->input->post("item_name"); 
		$item_name =  $this->input->post("item_name");
		$site_id = $data['site_id'];
		
		//go to page/create/basic_info.php view on direct access of the controller/view
		if(sizeof($_POST)<1)
		{
			$this->template->write_view('content','page/create/basic_info', $data);
			$this->template->render();
		}   
		
		//set error message html tag
		$this->form_validation->set_error_delimiters('<label class="error">', '</label>');
		
		//set form validation rules
		$this->form_validation->set_rules('page_title', 'Page Title', 'required');
		$this->form_validation->set_rules('item_name', 'Menu Link Text', 'required');
		$this->form_validation->set_rules('page_seo_url', 'Page URL', 'required');
		
		//performs form validation
		if ($this->form_validation->run() == FALSE)
		{
			//incorrect form validation case
			//loads page/create/basic_info view with error messages
			$data['action'] = 'add';
			$data['page_id'] = '';
			
			$data['page_title'] = $this->input->post('page_title');
			$data['item_name'] = $this->input->post('item_name');
			$data['page_seo_url'] = $this->input->post('page_seo_url');
			$data['page_keywords'] = $this->input->post('page_keywords');   
			$data['page_desc'] = $this->input->post('page_desc');
			
			$this->template->write_view('content','page/create/basic_info', $data);
			$this->template->render();   
			//$this->load->view("page/create/basic_info", $data);         
		}
		else
		{
			//form validation passed
			//load page/create/page_menu view after preparing $data
			$page_id = $this->Pages_Model->addPage();
			$data['page_id'] = $page_id;
			$data['site_id'] = $site_id;
			$data['menus'] = $this->Menus_Model->getAllMenus($data['site_id']);                
			$data['roles'] = $this->Menus_Model->getRoles();
			
			//fill content region of template with page/create/page_menu.php view
			//$this->template->write_view('content','page/create/page_menu', $data);
			//$this->template->render();
			$_SESSION['item_name'] = $item_name;
			redirect("pagesController/page_menu/".$site_id."/".$page_id);       
			//$this->load->view("page/create/editor_board");       
		}       
	}
	
	function edit_basic_info($site_id)
	{
		//confirm user is logged in 
		$this->checkLogin(); 
		//echo "<pre>";
		//print_r($_POST);exit;
		if(isset($_POST['page_id']))
		{
			//set error message html tag
			$this->form_validation->set_error_delimiters('<label class="error">', '</label>');
			
			//set form validation rules
			$this->form_validation->set_rules('page_title', 'Page Title', 'required');
			$this->form_validation->set_rules('item_name', 'Menu Link Text', 'required');
			$this->form_validation->set_rules('page_seo_url', 'Page URL', 'required');
		
			//performs form validation
			if ($this->form_validation->run() == FALSE)
			{
				//incorrect form validation case
				//loads page/create/basic_info view with error messages
				$data['action'] = 'edit';
				$data['site_id'] = $this->input->post('site_id');     
				$data['page_id'] = $this->input->post('page_id'); 
				
				$data['page_title'] = $this->input->post('page_title');
				$data['item_name'] = $this->input->post('item_name');
				$data['page_seo_url'] = $this->input->post('page_seo_url');
				$data['page_keywords'] = $this->input->post('page_keywords');   
				$data['page_desc'] = $this->input->post('page_desc');
				
				$this->template->write_view('content','page/create/basic_info', $data);
				$this->template->render();   
				//$this->load->view("page/create/basic_info", $data);         
			}
			else
			{
				//form validation passed
				//load page/create/page_menu view after preparing $data
				$this->Pages_Model->edit_basic_info();
				$page_id = $this->input->post('page_id');
				$item_name = $this->input->post('item_name');
				
				$_SESSION['item_name'] = $item_name;
				redirect('pagesController/page_menu/'.$site_id.'/'.$page_id);       
			}    
		}   
		else
		{
			redirect('pagesController/basic_info/'.$site_id);    
		} 
	}
	
	function DeleteBasicInfo($site_id)
	{
		if(isset($_POST['page_id']))
		{
			$page_id = $_POST['page_id'];
			$this->Pages_Model->delete_page($page_id);
			redirect('pagesController/index/'.$site_id."/0");
		}
	}
	
	//Defines Step-2 View(page/create/page_menu) of Page Creation
	//Also perform form Validation
	function page_menu($site_id, $page_id)
	{
		//confirm user is logged in 
		$this->checkLogin(); 
		
		$item_name = $_SESSION['item_name'];
		/*$data['site_id'] =  $this->input->post("site_id"); 
		
		$data['menus'] = $this->Menus_Model->getAllMenus($data['site_id']);                
		$data['roles'] = $this->Menus_Model->getRoles();
		
		if(sizeof($_POST)<1)
		{
			$this->template->write_view('content','page/create/basic_info', $data);
			$this->template->render();
		}   
		
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->form_validation->set_rules('page_title', 'Page Title', 'required');
		
		$this->form_validation->set_rules('item_name', 'Menu Link Name', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->template->write_view('content','page/create/basic_info', $data);
			$this->template->render();   
			//$this->load->view("page/create/basic_info", $data);         
		}
		else
		{
			$page_id = $this->Pages_Model->addPage();
			$data['page_id'] = $page_id;
			$this->template->write_view('content','page/create/menu_info', $data);
			$this->template->render();   
			//$this->load->view("page/create/editor_board");       
		}*/
		
		if(isset($_POST['page_id']))
		{
			//prepare the $data
			$data['action'] =  'edit'; 
			$data['site_id'] =  $site_id;
			$data['page_id'] = $page_id; 
			$data['item_id'] = $this->input->post('item_id');
			$data['page_access'] = $this->input->post('page_access');
			$data['menus'] = $this->Menus_Model->getAllMenus($data['site_id']);                
			$data['roles'] = $this->Menus_Model->getRoles(); 
			//$item_name = str_replace("%20", " ", $item_name);
			$data['item_name'] = $item_name;         
		}
		else
		{
			//prepare the $data
			$data['action'] =  'add';  
			$data['site_id'] =  $site_id;
			$data['page_id'] = $page_id; 
			$data['menus'] = $this->Menus_Model->getAllMenus($data['site_id']);                
			$data['roles'] = $this->Menus_Model->getRoles(); 
			//$item_name = str_replace("%20", " ", $item_name);
			$data['item_name'] = $item_name; 
		}
		//fills content region of template with page/create/page_menu with $data
		$this->template->write_view('content','page/create/page_menu', $data);
		$this->template->render();      
	}
	
	//saves page menu & access information in db
	//addressed in page/create/page_menu.php(view) 
	//form of page/create/page_menu.php view posts here.
	function save_page_menu()
	{
		//confirm user is logged in 
		$this->checkLogin(); 
		
		$site_id = $this->input->post('site_id');
		$page_id = $this->input->post('page_id');
		
		//calls page_model function to save page's menu and access information
		$item_id = $this->Pages_Model->save_page_access_menu_info();
		
		//call editor_boad function of controller
		redirect("pagesController/editor_board/".$site_id."/".$page_id."/".$item_id);           
	}
	
	function edit_page_menu()
	{
		//confirm user is logged in 
		$this->checkLogin(); 
		
		$site_id = $this->input->post('site_id');
		$page_id = $this->input->post('page_id');
		$item_id = $this->input->post('item_id');
		
		//delete the old content in case it has been saved.
		$this->Pages_Model->delete_pagecontent_editorboard();
		
		//calls page_model function to save page's menu and access information
		$item_id = $this->Pages_Model->edit_page_access_menu_info($site_id, $page_id, $item_id);
		
		//call editor_boad function of controller
		redirect("pagesController/editor_board/".$site_id."/".$page_id."/".$item_id);    
	}
	
	//loads Step-3 View(page/create/editor_board.php) of Page Creation
	//drag n drop goes here at this view
	//addressed by save_page_menu function of this controller
	function editor_board($site_id, $page_id, $item_id)
	{   
		//$data['site_id'] =  $this->input->post("site_id");
		$data['site_id'] =  $site_id;
		$data['page_id'] =  $page_id;
		$data['item_id'] =  $item_id;
		$data['page_access'] = $this->Pages_Model->get_page_access($page_id);    
		
		//load CK Editor's file(s)
		$this->template->add_js('ckeditor/ckeditor.js');
		
		//load edit mode
		if(isset($_POST['page_id']))
		{
			//prepares the $data
			$data['action'] = 'edit';
			$data['content'] = $this->Pages_Model->get_page_content($page_id); 
		}
		else
		{
			//prepares the $data
			$data['action'] = '';
			$data['content'] = '';
		}
		
		//writes content region of template with page/create/editor_board view with $data
		$this->template->write_view('content','page/create/editor_board', $data);
		
		$this->template->render();   
		/*$this->checkLogin(); 
		$data['site_id'] =  $this->input->post("site_id"); 
		
		$data['menus'] = $this->Menus_Model->getAllMenus($data['site_id']);                
		$data['roles'] = $this->Menus_Model->getRoles();
		
		if(sizeof($_POST)<1)
		{
			$this->template->write_view('content','page/create/basic_info', $data);
			$this->template->render();
		}   
		
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->form_validation->set_rules('page_title', 'Page Title', 'required');
		
		$this->form_validation->set_rules('item_name', 'Menu Link Name', 'required');
		
		$page_access = $this->input->post("page_access");
		if($page_access == "Other")
		{
			$this->form_validation->set_rules('role_id[]', 'Page Access', 'required');        
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->template->write_view('content','page/create/basic_info', $data);
			$this->template->render();   
			//$this->load->view("page/create/basic_info", $data);         
		}
		else
		{
			$this->template->write_view('content','page/create/editor_board', $data);
			$this->template->render();   
			//$this->load->view("page/create/editor_board");       
		}*/        
		
	}
	
	function save_pagecontent_editorboard()
	{
		$site_id = $_POST['site_id'];
		$page_id = $_POST['page_id'];
		$item_id = $_POST['item_id'];
		//save page content from editor board
		$this->Pages_Model->save_pagecontent_editorboard();
		
		//go to page layout desc(view)
		redirect('pagesController/layout_desc/'.$site_id.'/'.$page_id.'/'.$item_id);
		
	}
	
	function edit_pagecontent_editorboard()
	{
		//delete the old content
		$this->Pages_Model->delete_pagecontent_editorboard();
		
		//add the new content
		$this->save_pagecontent_editorboard();
	}
	
	//loads Step-4 View of Page Creation
	function layout_desc($site_id, $page_id, $item_id)
	{   
		$this->checkLogin(); 
		$data['site_id'] =  $site_id;
		$data['page_id'] =  $page_id;
		$data['item_id'] =  $item_id;   
		$this->template->add_js('js/jscolor/jscolor.js');
	   
		$this->template->write_view('content','page/create/layout_desc', $data);
		$this->template->render();   
		//$this->load->view("page/create/layout_desc");   
	}
	
	function save_upload_page_layout_desc()
	{
		$this->checkLogin();
		//echo dirname( __FILE__ );exit;
		/*
		echo "<pre>";
		print_r($_FILES);
		exit;
		*/
		//echo base_url()."headerbackgrounds/";exit;
		//echo $_SERVER['DOCUMENT_ROOT']."/gws/headerbackgrounds";exit;
		//mkdir($_SERVER['DOCUMENT_ROOT']."/gws/headerbackgrounds", 0777);exit;
		$data['site_id'] =  $this->input->post("site_id");
		$site_id =  $this->input->post("site_id");
		$page_id =  $this->input->post("page_id");
		  
		$page_header = $this->input->post("page_header");
		if($page_header == "Other" && $_FILES["header_image"]["tmp_name"]!="")
		{            
			$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image']['name'];
			$config['upload_path'] = './headers/';            
			$config['allowed_types'] = 'gif|jpg|png';                       
			$this->upload->initialize($config);
			
			$this->upload->do_upload("header_image");            
		}
		
		if($page_header == "Slideshow")
		{
			$numHeaderImages = $this->input->post("numHeaderImages");            
		  
			for($i=1;$i<=$numHeaderImages;$i++)
			{
				if($_FILES['header_image_'.$i]['tmp_name']!="")
				{
					$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image_'.$i]['name'];
					$config['upload_path'] = './headers/';            
					$config['allowed_types'] = 'gif|jpg|png';                       
				
					$this->upload->initialize($config);
					$this->upload->do_upload("header_image_".$i);        
				}
			}
		} 
		
		$header_background = $this->input->post("header_background");
		if($header_background == "Image" && $_FILES["header_background_image"]["tmp_name"]!=""){            
			$config['file_name'] = "bg_".$this->input->post("DateTime").$_FILES['header_background_image']['name'];
			$config['upload_path'] = './headers/';            
			$config['allowed_types'] = 'gif|jpg|png';                       
			$this->upload->initialize($config);
			
			$this->upload->do_upload("header_background_image");
			//echo "uploaded";exit;        
		}
		//echo $this->upload->display_errors();exit;
		
		$page_background = $this->input->post("page_background");
		if($page_background == "Other" && $_FILES["background_image"]["tmp_name"]!=""){            
			$config['file_name'] = $this->input->post("DateTime").$_FILES['background_image']['name'];
			$config['upload_path'] = './backgrounds/';            
			$config['allowed_types'] = 'gif|jpg|png';                       
			$this->upload->initialize($config);
			
			$this->upload->do_upload("background_image"); 
		}
		
		$this->Pages_Model->save_upload_page_layout_desc();
		
		//$this->index($site_id, 0);
		redirect("pagesController/success/".$page_id."/".$site_id);
		
	}
	
	// (END) Intro: This Code is to Create A Page in 3 Steps
	
	//checks if page_id is assigned role_id
	//returns true or false
	function isPageRole($page_id, $role_id)
	{
		if($this->Pages_Model->isPageRole($page_id, $role_id))
		{
			return true;    
		}   
		else
		{
			return false;    
		} 
	}
	
	//checks if page_title already exist
	//returns True or False
	function isPageAlready($site_id)
	{
		$page_title = $this->input->post('page_title');
		//$page_title = str_replace("%20", " ", $page_title);
		$boolExist = $this->Pages_Model->isPageAlready($site_id, $page_title);
		if($boolExist)
		{
			echo "True";
		}    
		else
		{
			echo "False";
		} 
	}
	
	//checks if page title already exist on page update(info) page
	//returns True or False
	function isPageUpdateExist($site_id, $page_id, $page_title)
	{
		$page_title = str_replace("%20", " ", $page_title);
		
		$boolExist = $this->Pages_Model->isPageUpdateExist($site_id, $page_id, $page_title);
		if($boolExist)
		{
			echo "True";
		}    
		else
		{
			echo "False";
		} 
	}
	
	//Deletes header from DB with this id
	function deleteHeader($id)
	{
		$this->Pages_Model->deleteHeader($id);
		
	}
	
	//Updates Page Information(details) posted from "Page Information" page
	function updatePage(){
			   
		if($_POST){            
			//print_r($_POST);  exit();
			$site_id = $this->input->post("site_id");
			$page_header = $this->input->post("page_header");
			$DateTime = $this->input->post("DateTime");
			$numHeaderImages = $this->input->post("numHeaderImages"); 
			if($page_header == "Other" && isset($_FILES["header_image"]["tmp_name"])){            
				//$this->form_validation->set_rules('header_image', 'Header Image', 'callback_header_image');
				$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image']['name'];  
				$config['upload_path'] = './headers/';            
				$config['allowed_types'] = 'gif|jpg|png';                       
				$this->upload->initialize($config);
				
				$this->upload->do_upload("header_image");            
			}
			//echo $numHeaderImages;exit;
			if($page_header == "Slideshow"){ 
				
				for($i=1; $i<=$numHeaderImages;$i++)
				{
					//echo $_FILES["header_image_".$i]["name"];exit;
					if(isset($_FILES["header_image_".$i]["tmp_name"]))
					{
						$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image_'.$i]['name']; 
						//echo $config['file_name'];exit;             
						$config['upload_path'] = './headers/';            
						$config['allowed_types'] = 'gif|jpg|png';                       
						$this->upload->initialize($config);
						
						$this->upload->do_upload("header_image_".$i);            
					}    
				}
			}
			
			$page_background = $this->input->post("page_background");
			if($page_background == "Other" && isset($_FILES["background_image"]["tmp_name"])){                           
				//$this->form_validation->set_rules('background_image', 'Back Ground Image', 'callback_background_image');
				$config['file_name'] = $this->input->post("DateTime").$_FILES['background_image']['name'];   
				$config['upload_path'] = './backgrounds/';            
				$config['allowed_types'] = 'gif|jpg|png';                       
				$this->upload->initialize($config);
				
				$this->upload->do_upload("background_image");       
			}            
			
			$this->Pages_Model->updatePage(); 
			redirect("pagesController/index/".$site_id."/0");       
		}
		else{
			redirect("pagesController/index/".$site_id."/0");
		}    
	}
	
	//fetches page information from DB
	function showPageInfo($site_id, $id){
		//echo base_url()."headers/img1.jpg";
		$this->checkLogin(); 
				
		$data['id'] = $id;
		$data['site_id'] = $site_id;
		$data['menus'] = $this->Menus_Model->getAllMenus($site_id);                
		$data['roles'] = $this->Menus_Model->getRoles(); 
		
		$result = $this->Pages_Model->pageInfo($id); 
		$row = $result->row_array();
		
		$data["page_title"] = $row["page_title"];
		$data["page_show_title"] = $row["page_show_title"];
		
		$data["page_header"] = $row["page_header"];  
		
		$data["header_image"] = ""; 
		if($data["page_header"] == "Other"){
			$resultHeader = $this->Pages_Model->getHeaderInfo($id);
			$rowHeader = $resultHeader->row_array(); 
			$data["header_image"] = $rowHeader["header_image"];       
		}
		if($data["page_header"] == "Slideshow")
		{
			$data["header_image"] = $this->Pages_Model->getHeaderInfo($id);            
		}  
			
		$data["page_background"] = $row["page_background"];
		
		$data["background_image"] = "";
		if($data["page_background"] == "Other"){
			$resultBackground = $this->Pages_Model->getBackgroundInfo($id);
			$rowBackground = $resultBackground->row_array(); 
			$data["background_image"] = $rowBackground["background_image"]; 
			$data["background_area"] = $rowBackground["background_area"];  
			$data["background_style"] = $rowBackground["background_style"];       
		}
		 
		$data["page_start_date"] = $row["page_start_date"];  
		$data["page_end_date"] = $row["page_end_date"]; 
		
		$data["page_keywords"] = $row["page_keywords"];
		$data["page_desc"] = $row["page_desc"];
		
		$data["page_access"] = $row["page_access"];  
		$data["page_status"] = $row["page_status"];
		
		$rsltPageItem = $this->Pages_Model->getPageItem($id);
		
		if($rsltPageItem->num_rows()>0)
		{
			$rowPageItem = $rsltPageItem->row_array(); 
			$data["item_name"] = $rowPageItem["item_name"];
			$data["item_id"] = $rowPageItem["item_id"]; 
		}
		else
		{
			$data["item_name"] = "";
			$data["item_id"] = "";      
		}         
		
		//$rsltPageContent = $this->Pages_Model->getPageContent($id);
		//$rowPageContent = $rsltPageContent->row_array(); 
		//$data["page_content"] = $rowPageContent["page_content"];       
		$data["page_content"] = "";       
		//$this->load->view("pageInfoView", $data);  
		$this->template->write_view('content','pageInfoView', $data);
		$this->template->render();
	}
	
	/*function scheduled_dates($page_end_date){
		$page_start_date = strtotime($this->input->post("page_start_date"));        
		$page_end_date = strtotime($page_end_date);
		
		if($page_start_date>$page_end_date){            
			$this->form_validation->set_message('scheduled_dates', 'The %s date must be greater than Start Date.');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}*/
	
	/*function header_image($str)
	{        
	  
		if($_FILES["header_image"]["tmp_name"]=="")
		{
			$this->form_validation->set_message('header_image', 'The %s field is required.');
			return FALSE;
		}
		else
		{
			$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image']['name'];
			$config['upload_path'] = './headers/';            
			$config['allowed_types'] = 'gif|jpg|png';                       
			$this->upload->initialize($config);
			
			$this->upload->do_upload("header_image");             
			
			if($this->upload->display_errors() != ""){
				echo $this->upload->display_errors();exit;   
				$this->form_validation->set_message('header_image', "Invalid %s: ".$this->upload->display_errors());
				return FALSE;     
			}
			else
			{
				return TRUE;
			}
		}
	}*/
	
	/*function background_image($str){
		if($_FILES["background_image"]["tmp_name"]== ""){
			$this->form_validation->set_message('background_image', 'The %s field is required.');
			return FALSE;
		}
		else{
			$config['file_name'] = $this->input->post("DateTime").$_FILES['background_image']['name'];
			$config['upload_path'] = './backgrounds/';            
			$config['allowed_types'] = 'gif|jpg|png';                       
			$this->upload->initialize($config);
			
			$this->upload->do_upload("background_image");
			
			if($this->upload->display_errors() != ""){
				$this->form_validation->set_message('background_image', "Invalid %s: ".$this->upload->display_errors());
				return FALSE;     
			}
			else{
				return TRUE;
			}
		}
	}*/  
	
	//create a new page and uploads images(header, background, slideshow) 
	//performs form validation
	function addPage(){          
		 
		//echo "<pre>";
		//print_r($_POST);
		//print_r($_FILES["header_image"]);  
		//exit();      
		$this->checkLogin(); 
		/* 
		$site_id =  $this->input->post("site_id"); 
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$page_access = $this->input->post("page_access");
		if($page_access == "Other")
		{
			$this->form_validation->set_rules('role_id[]', 'Page Access', 'required');        
		}
		
		
		$page_header = $this->input->post("page_header");
		if($page_header == "Other" && $_FILES["header_image"]["tmp_name"]!="")
		{            
			$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image']['name'];
			$config['upload_path'] = './headers/';            
			$config['allowed_types'] = 'gif|jpg|png';                       
			$this->upload->initialize($config);
			
			$this->upload->do_upload("header_image");            
		}
		
		if($page_header == "Slideshow")
		{
			$numHeaderImages = $this->input->post("numHeaderImages");            
		  
			for($i=1;$i<=$numHeaderImages;$i++)
			{
				if($_FILES['header_image_'.$i]['tmp_name']!="")
				{
					$config['file_name'] = $this->input->post("DateTime").$_FILES['header_image_'.$i]['name'];
					$config['upload_path'] = './headers/';            
					$config['allowed_types'] = 'gif|jpg|png';                       
				
					$this->upload->initialize($config);
					$this->upload->do_upload("header_image_".$i);        
				}
			}
		} 
		
		$page_background = $this->input->post("page_background");
		if($page_background == "Other" && $_FILES["background_image"]["tmp_name"]!=""){            
			$config['file_name'] = $this->input->post("DateTime").$_FILES['background_image']['name'];
			$config['upload_path'] = './backgrounds/';            
			$config['allowed_types'] = 'gif|jpg|png';                       
			$this->upload->initialize($config);
			
			$this->upload->do_upload("background_image");        
		}        
		
		$this->form_validation->set_rules('page_title', 'Page Title', 'required'); 
		
		$sameas_page_title = $this->input->post("sameas_page_title");
		if($sameas_page_title != "Yes")
		{
			$this->form_validation->set_rules('item_name', 'Item Name', 'required');     
		}   
		
		$page_status = $this->input->post("page_status");
		if($page_status == "Schedule")
		{
			$this->form_validation->set_rules('page_start_date', 'Start Date', 'required');
			$this->form_validation->set_rules('page_end_date', 'End Date', 'required|callback_scheduled_dates');                         
		}       
			
		if ($this->form_validation->run() == FALSE)
		{
			$data['menus'] = $this->Menus_Model->getAllMenus();                
			$data['roles'] = $this->Menus_Model->getRoles();
			
			if($page_header == "Other"){
				$header_upload = true;
			}
			else{
				$header_upload = false;
			}
			
			if($page_background == "Other"){
				$background_upload = true;
			}
			else{
				$background_upload = false;
			}
			
			$this->load->view("addPageView", $data);                
		}
		else{  */          
			$page_id = $this->Pages_Model->addPage();
			
			//redirect("pagesController/success/".$page_id."/".$site_id);
			redirect("pagesController/menu_info/".$page_id."/".$site_id);   
		//} 
					   
		//exit;
		//$header_image = "header_image";
		//echo $this->upload->do_upload($header_image); exit();          
	}
	
	//takes to create_page_success.php after page create
	function success($page_id, $site_id)
	{
		$this->checkLogin(); 
		
		$data["page_id"] = $page_id;
		$data["site_id"] = $site_id;  
		$this->template->write_view('content','create_page_success', $data);
		$this->template->render();
		//$this->load->view("create_page_success", $data);   
	}
	
	//shows user the create page form
	function addPageForm(){
		$this->checkLogin(); 
		
		$data['menus'] = $this->Menus_Model->getAllMenus();                
		$data['roles'] = $this->Menus_Model->getRoles();        

		$this->load->view("addPageView", $data);
	}
	
	//shows search results on page search
	function searchPage($site_id, $from){
		
		$this->checkLogin(); 
		
		$page_title = $this->input->post("page_title");
		$data["search_page_title"] = $page_title;        
		if($this->session->userdata("ses_showPageLimit")){
			$data["pageLimit"] = $this->session->userdata("ses_showPageLimit");
		}
		else{
			$data["pageLimit"] = 3;
		}
		
		if($this->input->post("numRecords")){            
			$this->session->set_userdata("ses_showPageLimit", $this->input->post("numRecords"));
			$data["pageLimit"] = $this->session->userdata("ses_showPageLimit");
		}        
		$data['site_id'] = $site_id;
		$data["records"] = $this->Pages_Model->searchPages($from, $data["pageLimit"], $page_title, $site_id);
		$data["pages_list"] = $this->Pages_Model->getAllPages($site_id);
		
		$data["numRecords"] = $data["records"]->num_rows();
		$data["from"] = $from;        
		$data["totalRecords"] = $this->Pages_Model->totalSearchPages($page_title); 
		
		$config = array(
			'uri_segment' => 4,
			'base_url' => base_url().index_page().'pagesController/searchPage/'.$site_id."/",
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
		
		/*$config['uri_segment'] = 4;                
		$config['base_url'] = base_url().index_page().'pagesController/searchPage/'.$site_id."/";
		$config['per_page'] = $data["pageLimit"];     
		
		
		$config['first_link'] = 'First';        
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';   
		$config['prev_link'] = 'Previous';
		$config['display_pages'] = TRUE; 
		$config['num_links'] = 2;          
		$config['total_rows'] = $data["totalRecords"];*/       
		$this->pagination->initialize($config);

		$data["paging"] = $this->pagination->create_links();
		$this->template->write_view('content','viewPages', $data);
		$this->template->render();    
			  
		//$this->load->view("viewPages", $data);
	}
	
	//sets page as homepage in a site
	function setAsHomepage($site_id){
		
		if($this->input->post("page_id_home"))
		{            
			$this->Pages_Model->setAsHomepage($site_id, $this->input->post("page_id_home"));
		}
		redirect("pagesController/index/".$site_id."/0"); 
	}
	//published page(s) of a site
	function publishPage($site_id){
		if($this->input->post("chkPage"))
		{            
			$this->Pages_Model->publishPages($this->input->post("chkPage"));
		}
		redirect("pagesController/index/".$site_id."/0");             
	}
	
	//unpublishes page(s) of a site
	function unpublishPage($site_id){
		if($this->input->post("chkPage")){            
			$this->Pages_Model->unpublishPages($this->input->post("chkPage"));
		}          
		redirect("pagesController/index/".$site_id."/0");  
	}
	//tashes page(s) of a site
	function trashPage($site_id)
	{
		if($this->input->post("chkPage"))
		{            
			$this->Pages_Model->deletePages($this->input->post("chkPage"));
		}         
		redirect("pagesController/index/".$site_id."/0");    
	}
	
	function index($site_id, $from){ 
	 
		$this->checkLogin();
		$data = array ();
		//$data['site_id']='';
		//print_r($_SESSION["site_info"]);
		//$data['site_id'] = $_SESSION['site_info']['site_id'];
		
		//print_r($data['site_id']); 
		
		$data["search_page_title"] = ""; 
			
		if($this->session->userdata("ses_showPageLimit")){
			$data["pageLimit"] = $this->session->userdata("ses_showPageLimit");
		}
		else{
			$data["pageLimit"] = 10;
		}
		
		if($this->input->post("numRecords")){            
			$this->session->set_userdata("ses_showPageLimit", $this->input->post("numRecords"));
			$data["pageLimit"] = $this->session->userdata("ses_showPageLimit");
		}        
		
		$data['site_id'] = $site_id;
				
		$data["records"] = $this->Pages_Model->showPages($from, $data["pageLimit"], $site_id);
		$data["pages_list"] = $this->Pages_Model->getAllPages($site_id);
		
		$data["numRecords"] = $data["records"]->num_rows();
		$data["from"] = $from;        
		$data["totalRecords"] = $this->Pages_Model->totalPages($site_id); 
		
		$config = array(
			'uri_segment' => 4,
			'base_url' => base_url().index_page().'pagesController/index/'.$site_id."/",
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
		
		/*$config['uri_segment'] = 4;        
		$config['base_url'] = base_url().index_page().'pagesController/index/'.$site_id."/";
		$config['per_page'] = $data["pageLimit"];     
		
		$config['first_link'] = 'First';        
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';   
		$config['prev_link'] = 'Previous';
		$config['display_pages'] = TRUE; 
		$config['num_links'] = 2;          
		$config['total_rows'] = $data["totalRecords"];*/       
		$this->pagination->initialize($config); 

		$data["paging"] = $this->pagination->create_links();  
		
		$this->template->write_view('content','viewPages', $data);
		$this->template->render();    
		//$this->load->view("viewPages", $data);
	}
	
	
	
	//loads page_basic(view) for update
	/* 14/sep/2011
	function edit_page_basic_info($page_id)
	{
		//checks user login
		$this->checkLogin();
		
		$data['action'] = 'edit'; 
		$data['site_id'] = $site_id;
		$data['page_id'] = $page_id;
		
		$result = $this->Pages_Model->pageInfo($page_id);
		$row = $result->row_array();
			
		$data['page_title'] = $row['page_title'];
		$data['page_seo_url'] = $row['page_seo_url'];  
		$data['page_keywords'] = $row['page_keywords'];     
		$data['page_desc'] = $row['page_desc'];    
	
		$rsltPageItemName = $this->Pages_Model->pageItemName($page_id);
		if($rsltPageItemName->num_rows()>0)
		{
			$rowPageItemName = $rsltPageItemName->row_array();  
			$data['item_name'] = $rowPageItemName['item_name'];    
		}
		else
		{
			$data['item_name'] = '';        
		}
		  
		$this->template->write_view('content','page/create/basic_info', $data);         
		$this->template->render();            
	}
	*/
	
	function deleteMenuInfo($menu_id)
	{
		//confirm that user has logged in 
		$this->checkLogin();
		
		//delete menu info from db
		$this->Pages_Model->deleteMenuInfo($menu_id);
		
		return;
	}
	
	function deleteContentInfo($id)
	{
		//confirm that user has logged in 
		$this->checkLogin();
		
		//delete menu info from db
		$this->Pages_Model->deleteContentInfo($id);
		
		return;    
	}
	
	function updatePageContent($site_id, $page_id)
	{
		//echo sizeof($_POST['content']);exit;
		
		
		
		 $this->Pages_Model->update_page_content($page_id,$site_id);    
		
		/*for($i=0; $i<sizeof($_POST['content']); $i++)
		{
			$id = $_POST['content_id'][$i];
			$data = $_POST['content'][$i];
			$type = $_POST['content_type'][$i];
			
			if($id!="")
			{
				//update content
				$this->Pages_Model->update_page_content($page_id, $id, $data, $type);
			}    
			else
			{
				//add new content
				$this->Pages_Model->add_page_content($page_id, $data, $type);
			}
		}                */
		
		//go back to page in edit mode called page editor
		redirect('page_editor/index/'.$site_id.'/'.$page_id);
	}
	
}
?>
