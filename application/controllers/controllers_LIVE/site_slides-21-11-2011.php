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
        //confirm that user has logged in
        $this->checkLogin();
        
        $data['site_id'] = $site_id;
        $data['pages'] = $this->Menus_Model->getPages($site_id);        
        $data['roles'] = $this->Menus_Model->getRoles(); 
        $data['modules'] = $this->PackageModel->get_site_package_modules($site_id);
        
        $this->template->write_view('content', 'slides/create', $data);   
        
        $this->template->render();
    }
    
    function save_slider_info($site_id)
    {
        $numImages = $this->input->post('numImages');
        
        if(!isset($_POST))
        {
            $this->create($site_id);    
        }
        
        //save slideshow info
        $slide_title = $this->input->post('slide_title');
        $slide_description = $this->input->post('slide_description');
      
        $slide_position = $this->input->post('slide_position');
        $slide_published = $this->input->post('slide_published');
        $slide_access = $this->input->post('slide_access');
        $slide_pages = $this->input->post('slide_pages'); 
        
        $slide_id = $this->Slideshow_Model->save_slideshow_info($slide_title, $slide_description, $slide_position, $slide_published, $slide_pages, $slide_access, $site_id);
        
        //save slideshow images info
        $image_files = array();
        /*echo '<pre>';  print_r($_FILES); echo '</pre>';
        exit();*/
        
        for($i=1; $i<= intval($numImages); $i++)
        {
            
            $file_info = array ();
            $config = array ();
            $config_resize = array ();
            if($_FILES['slide_image'.$i]['tmp_name']!='')
            {
                $time = date('his'); 

                $slide_image = $time.$_FILES['slide_image'.$i]['name'];
                 
                $slide_image_url = $_POST['slide_image_url'.$i];
                
                $config['file_name'] = $slide_image;
                $config['upload_path'] = './slideshows/';            
                $config['allowed_types'] = 'gif|jpg|png|ico|img|jpeg|jpe'; 
                $config['remove_spaces'] = TRUE; 
                $config['max_size']    = '10240';
               // $config['max_width']  = '0';
               // $config['max_height']  = '0'; 
                /*$config['max_height']  = '768'; 
                $config['max_width']  = '1024';*/

                $this->upload->initialize($config);
                $this->upload->do_upload("slide_image".$i);
              //  $this->image_lib->clear(); 
                $file_info = $this->upload->data();
                
                /*$upload_error = array('error' => $this->upload->display_errors());
                echo '<pre>';  print_r($upload_error); echo '</pre>';*/
                
                if($file_info){  
                   // echo '<pre>';  print_r($file_info); echo '</pre>';
                    $this->load->library('image_lib'); 
                     
                    $config_resize['source_image'] = $file_info['full_path'];
                    // $config_resize['new_image'] = $file_info['file_path'];
                    $config_resize['new_image'] = './slideshows/';
                    $config_resize['maintain_ratio'] = TRUE;
                    $config_resize['create_thumb'] = TRUE;
                    $config_resize['master_dim'] = "auto";
                    $config_resize['thumb_marker'] = "_thumb";
                    $config_resize['width'] = 628;
                    $config_resize['height'] = 471;
                   // $this->load->library('image_lib', $config_resize);
                   // $resize_img = $this->image_lib->resize();
                    $this->image_lib->clear();
                    
                    $this->image_lib->initialize($config_resize);
                   $resize_img = $this->image_lib->resize();
                  //  echo $this->image_lib->display_errors();
                  //  $this->image_lib->clear();  
                    
                   // exit();        
                }  
                //  echo '<pre>';  print_r($resize_img);  echo '</pre>';  
                  
                array_push($image_files, $file_info['full_path']); 
                $image_path = $file_info['file_path'];
                if($i==1)
                {
                    $image_width = $file_info['image_width'];
                    $image_height = $file_info['image_height'];
                }

                //save slideshow image info
                $slide_image_name_parts = explode('.', $slide_image);
                $slide_image_name_parts[0] .= '_thumb';
                $slide_image = $slide_image_name_parts[0].'.'.$slide_image_name_parts[1];
                $this->Slideshow_Model->save_slideshow_image_info($slide_id, $slide_image, $slide_image_url);
                                 
            }
            
        }
        
           
        //create images thumbs
        /*$this->load->library('image_lib');
        
        for($i=0; $i<sizeof($image_files); $i++)
        {
            $config_resize['source_image'] = $image_files[$i];
            $config_resize['new_image'] = $image_path; 

            $config_resize['maintain_ratio'] = TRUE;
            $config_resize['create_thumb'] = TRUE;
            $config_resize['thumb_marker'] = "_thumb"; 
            $config_resize['width'] = $image_width;
            $config_resize['height'] = $image_height;

            $this->image_lib->clear();

            $this->image_lib->initialize($config_resize);

            $this->image_lib->resize(); 
        }*/
        
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
        
        redirect(base_url().'index.php/site_slides/index/'.$site_id.'/0');  
        
    }
    
    function create_slide_fancy($site_id)
    {
        //confirm that user has logged in
        $this->checkLogin();
        
        $this->save_slider_info($site_id);
        
        //redirect(base_url().'index.php/site_slides/index/'.$site_id.'/0');  
        $this->load->view('slides/fancy_close');
    }
    
    //loads slides/index.php view for slides management
    function index($site_id, $from)
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
                
        $data["records"] = $this->Slideshow_Model->get_all_site_slides($from, $data["pageLimit"], $site_id);
        
        $data["slides_list"] = $this->Slideshow_Model->get_all_slides($site_id);
        
        $data["numRecords"] = $data["records"]->num_rows();
        
        $data["from"] = $from;        
        
        $data["totalRecords"] = $this->Slideshow_Model->totalSlides($site_id); 
        
        $config = array(
            'uri_segment' => 4,
            'base_url' => base_url().'index.php/site_slides/index/'.$site_id."/",
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
        $data['slide_position'] = $row['slide_position'];
        $data['slide_published'] = $row['slide_published'];
        
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
            $array_slideshow_access_roles = $this->Slideshow_Model->get_slideshow_access_roles($slide_id);
            
            $slide_access_roles = array();
            
            foreach($array_slideshow_access_roles as $row_slideshow_access_roles)
            {
                array_push($slide_access_roles, $row_slideshow_access_roles['role_id']);      
            }  
            
            $data['slide_access_roles'] = $slide_access_roles;    
        }
        else
        {
            $data['slide_access_roles'] = '';
        }
        
        $data['slide_images'] = $this->Slideshow_Model->get_slideshow_images($slide_id);
        
        //fill content area with this view
        $this->template->write_view('content','slides/edit', $data);
        
        //render the template
        $this->template->render();          
        
    }
    
    function edit_slider_info($site_id, $slide_id)
    {
        //confirm that user has logged in
        $this->checkLogin();
        
        if(!isset($_POST))
        {
            //go to edit screen
            $this->edit($site_id, $slide_id);
        }
        
        $slide_title = $this->input->post('slide_title');
        $slide_description = $this->input->post('slide_description');
        $slide_position = $this->input->post('slide_position');
        $slide_published = $this->input->post('slide_published');  
        $slide_pages = $this->input->post('slide_pages');
        $slide_access = $this->input->post('slide_access');
        
        $this->Slideshow_Model->edit_slide($slide_id, $slide_title, $slide_description, $slide_position, $slide_published, $slide_pages, $slide_access);
        
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
            if($_FILES['slide_image'.$i]['tmp_name']!='')
            {
                $time = date('his'); 
                $slide_image = $time.$_FILES['slide_image'.$i]['name']; 
                $slide_image_url = $_POST['slide_image_url'.$i];
                $config['file_name'] = $slide_image;
                $config['upload_path'] = './slideshows/';            
                $config['allowed_types'] = 'gif|jpg|png|ico|img|jpeg|jpe'; 
                $config['remove_spaces'] = TRUE; 
                $config['max_size']    = '10240';
                $this->upload->initialize($config);
                $this->upload->do_upload("slide_image".$i);
                $file_info = $this->upload->data();
                if($file_info){  
                    $this->load->library('image_lib');    
                    $config_resize['source_image'] = $file_info['full_path'];
                    $config_resize['new_image'] = './slideshows/';
                    $config_resize['maintain_ratio'] = TRUE;
                    $config_resize['create_thumb'] = TRUE;
                    $config_resize['master_dim'] = "auto";
                    $config_resize['thumb_marker'] = "_thumb";
                    $config_resize['width'] = 628;
                    $config_resize['height'] = 471;
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config_resize);
                    $resize_img = $this->image_lib->resize();
        
                  } 
  
                array_push($image_files, $file_info['full_path']); 
                $image_path = $file_info['file_path'];
                
                if($i==1)
                {
                    $image_width = $file_info['image_width'];
                    $image_height = $file_info['image_height'];
                }  
                
                //save slideshow image info
                $slide_image_name_parts = explode('.', $slide_image);
                $slide_image_name_parts[0] .= '_thumb';
                $slide_image = $slide_image_name_parts[0].'.'.$slide_image_name_parts[1];
                $this->Slideshow_Model->save_slideshow_image_info($slide_id, $slide_image, $slide_image_url);
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
        
        /*for($i=0; $i<sizeof($image_files); $i++)
        {
            $config_resize['source_image'] = $image_files[$i];
            $config_resize['new_image'] = $image_path; 
            
            $config_resize['maintain_ratio'] = TRUE;
            $config_resize['create_thumb'] = TRUE;
            $config_resize['thumb_marker'] = "_thumb";
            $config_resize['width'] = $image_width;
            $config_resize['height'] = $image_height;
        
            $this->image_lib->clear();
        
            $this->image_lib->initialize($config_resize);
        
            $this->image_lib->resize(); 
        }               */
        /*
        echo '<pre>';
        print_r($image_dim);
        exit;
        */  
        return true;  
    }
    
    function edit_slide($site_id, $slide_id)
    {
        
        $this->edit_slider_info($site_id, $slide_id);
        
        redirect(base_url().'index.php/site_slides/index/'.$site_id.'/0');
        
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
        $this->checkLogin();
        
        $slider_image_url = $this->input->post('slider_image_url');
        
        $this->Slideshow_Model->save_slide_image_url($slider_image_id, $slider_image_url);
        
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
