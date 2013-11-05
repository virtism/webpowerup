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
        $this->checkLogin();
        
        $data['site_id'] = $site_id;
        $data['pages'] = $this->Menus_Model->getPages($site_id);        
        $data['roles'] = $this->Menus_Model->getRoles(); 
        $data['modules'] = $this->PackageModel->get_site_package_modules($site_id);
        
        $this->template->write_view('content', 'slides/create', $data);   
        
        $this->template->render();
    }
    
    function create_slide($site_id)
    {
        $this->checkLogin();
        /*
        echo '<pre>';
        print_r($_POST);
        exit;
        */
        $numImages = $this->input->post('numImages');
        $time = date('his');
        
        if(!isset($_POST))
        {
            $this->create($site_id);    
        }
        
        //save slideshow info
        $slide_title = $this->input->post('slide_title');
        $slide_description = $this->input->post('slide_description');
        $slide_destination = $this->input->post('slide_destination');
        if($slide_destination == 'page')
        {
            $slide_destination_value = $this->input->post('slide_page');        
        }
        else if($slide_destination == 'module')
        {
            $slide_destination_value = $this->input->post('slide_module');    
        }
        else
        {
            $slide_destination_value = $this->input->post('slide_url');    
        }
        $slide_position = $this->input->post('slide_position');
        $slide_published = $this->input->post('slide_published');
        $slide_access = $this->input->post('slide_access');
        $slide_pages = $this->input->post('slide_pages'); 
        $slide_id = $this->Slideshow_Model->save_slideshow_info($slide_title, $slide_description, $slide_destination, $slide_destination_value, $slide_position, $slide_published, $slide_pages, $slide_access, $site_id);
        
        
        //save slideshow images info
        for($i=1; $i<=$numImages; $i++)
        {
            if($_FILES['slide_image'.$i]['tmp_name']!='')
            {
                $slide_image = $time.$_FILES['slide_image'.$i]['name'];
                $config['file_name'] = $slide_image;
                $config['upload_path'] = './slideshows/';            
                $config['allowed_types'] = 'gif|jpg|png';                       
            
                $this->upload->initialize($config);
                $this->upload->do_upload("slide_image".$i);
                
                //save slideshow image info
                $this->Slideshow_Model->save_slideshow_image_info($slide_id, $slide_image);
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
        
        //redirect(base_url().'index.php/site_slides/create/'.$site_id);
        redirect(base_url().'index.php/SiteController/sitehome/'.$site_id);  
    }
}
?>