<?php
class Page extends CI_Controller
{
    function Page()
    {
        parent::__construct(); 
        $this->load->model("Pages_Model");
        $this->load->model("Menus_Model");
        $this->load->library('pagination');
        $this->load->library('session');    
        $this->load->helper('url');   
        $this->load->library('form_validation');        
        $this->load->helper('html'); 
        $this->load->library('upload');        
    }
    
    function isPageAlready($page_title)
    {
        $page_title = str_replace("%20", " ", $page_title);
        
        $boolExist = $this->Pages_Model->isPageAlready($page_title);
        if($boolExist)
        {
            echo "True";
        }    
        else
        {
            echo "False";
        } 
    }
    
    function basic_info()
    {
        $data['menus'] = $this->Menus_Model->getAllMenus();                
        $data['roles'] = $this->Menus_Model->getRoles();
        $this->load->view("page/create/basic_info", $data);   
    }
    
    function editor_board()
    {   
        $data['menus'] = $this->Menus_Model->getAllMenus();                
        $data['roles'] = $this->Menus_Model->getRoles();
        
        if(sizeof($_POST)<1)
        {
            redirect("page/basic_info", $data);
        }   
        
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        
        $this->form_validation->set_rules('page_title', 'Page Title', 'required');
        
        $this->form_validation->set_rules('item_name', 'Menu Link Name', 'required');
        
        $page_access = $this->input->post("page_access");
        if($page_access == "Other")
        {
            $this->form_validation->set_rules('role_id[]', 'Page Access', 'required');        
        }
        
        if ($this->form_validation->run() == FALSE)
        {
            
            $this->load->view("page/create/basic_info", $data);         
        }
        else
        {
            $this->load->view("page/create/editor_board");       
        }        
        
    }
    
    function layout_desc()
    {        
        if(sizeof($_POST)<1)  
        {
            redirect("page/basic_info");     
        }
           
        $this->load->view("page/create/layout_desc");   
    }
}
?>
