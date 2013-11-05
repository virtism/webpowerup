<?php
class Design_config extends CI_Controller
{
    function Design_config()
    {
        parent::__construct();
        
         if($this->session->userdata('auth_info') == "")
         {
            redirect('administrator/login/');;   
         }
    }  

    function index()
    {
        $data['left_bar']               = 'design_congif'; 
        $this->load->view('s_admin/design_config' , $data);
    } 
    
    /*function index()
    {
        //confirm that user has logged-in
        //$this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/design_config/index');
        
        //display the template with its regions written above
        $this->template->render();            
    }*/ 
}
?>
