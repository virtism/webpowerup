<?php
class Site extends CI_Controller{
    function Site(){
        parent::__construct(); 
        $this->load->model("Menus_Model");
        $this->load->model("Pages_Model");
        $this->load->model("Site_Model");
        //$this->load->library('pagination');
        $this->load->library('session');    
        $this->load->helper('url');   
        //$this->load->library('form_validation');       
        $this->load->helper('html'); 
        //$this->load->library('ajax');  
        $this->load->library('template');                      
    }
    function index()
    {
        $this->template->render();
    }
    function editPage($site_id, $page_id)
    {
        $this->load->view("page_edit_dynamic");
    }
    
    function url($site_id)
    {
        $rsltHomepage = $this->Site_Model->getHomepage($site_id);
        $rowHomepage = $rsltHomepage->row_array();
        $data["site_id"] = $rowHomepage["site_id"];
        $data["page_id"] = $rowHomepage["page_id"];
        $data["page_status"] = $rowHomepage["page_status"];
        $page_id = $rowHomepage["page_id"];       
        $data["site_name"] = $rowHomepage["site_name"];
        $data["page_title"] = $rowHomepage["page_title"];
        $data["page_desc"] = $rowHomepage["page_desc"]; 
        $data["page_keywords"] = $rowHomepage["page_keywords"];
        $data["page_header"] = $rowHomepage["page_header"];
        $data["page_background"] = $rowHomepage["page_background"]; 
        $data["page_start_date"] = $rowHomepage["page_start_date"];  
        $data["page_end_date"] = $rowHomepage["page_end_date"];  
        $data["page_access"] = $rowHomepage["page_access"];
        
        if($data["page_header"] == "Default")
        {
            $data["header_image"] = base_url()."headers/default.jpg";        
        }
        else if($data["page_header"] == "Other")
        {
            $data["header_image"] = base_url()."headers/".$this->Site_Model->getHeaderImage($page_id);
        }
        else if($data["page_header"] == "Slideshow")
        {
            //Slideshow header of page will go here.
            $data["header_image"] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
        } 
        
        if($data["page_background"] == "Default")
        {
            $data["background_image"] = base_url()."backgrounds/default.jpg";        
        }
        else if($data["page_background"] == "Other")
        {
            $data["background_image"] = base_url()."backgrounds/".$this->Site_Model->getBackgroundImage($page_id);
        }
        
        $data["page_content"] = $this->Site_Model->getPageContent($page_id);
        $this->load->view("page_view", $data);    
    }
    function page($site_id, $page_id)
    {
        $rsltPage = $this->Site_Model->getSitePage($site_id, $page_id);
        $rowPage = $rsltPage->row_array();
        $data["site_id"] = $site_id; 
        $data["page_id"] = $page_id;   
        $data["page_status"] = $rowPage["page_status"];
        $data["site_name"] = $rowPage["site_name"];
        $data["page_title"] = $rowPage["page_title"];
        $data["page_desc"] = $rowPage["page_desc"]; 
        $data["page_keywords"] = $rowPage["page_keywords"];
        $data["page_header"] = $rowPage["page_header"];
        $data["page_background"] = $rowPage["page_background"];
        $data["page_start_date"] = $rowPage["page_start_date"];
        $data["page_end_date"] = $rowPage["page_end_date"];
        $data["page_access"] = $rowPage["page_access"];        
        
        if($data["page_header"] == "Default")
        {
            $data["header_image"] = base_url()."headers/default.jpg";        
        }
        else if($data["page_header"] == "Other")
        {
            $data["header_image"] = base_url()."headers/".$this->Site_Model->getHeaderImage($page_id);
        }
        else if($data["page_header"] == "Slideshow")
        {
            //Slideshow header of page will go here.
            $data["header_image"] = $this->Site_Model->getSlideshowHeaderImgs($page_id);
        }
        
        if($data["page_background"] == "Default")
        {
            $data["background_image"] = base_url()."backgrounds/default.jpg";        
        }
        else if($data["page_background"] == "Other")
        {
            $data["background_image"] = base_url()."backgrounds/".$this->Site_Model->getBackgroundImage($page_id);
        }
        
        $data["page_content"] = $this->Site_Model->getPageContent($page_id);
        
        $this->load->view("page_view", $data);        
    }    
}
?>
