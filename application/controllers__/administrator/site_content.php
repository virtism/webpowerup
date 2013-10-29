<?php
class Site_content extends CI_Controller
{
    function Site_content()
    {
        parent::__construct();
        if($this->session->userdata('auth_info') == "")
         {
            redirect('administrator/login/');;   
         }
        
    }    


    function index()
    {
        $data['left_bar'] = 'site_content';
        $this->load->view('s_admin/site_content', $data);
    }
    
    /*function index()
    {
        //confirm that user has logged-in
        //$this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/site_content/index');
        
        //display the template with its regions written above
        $this->template->render();    
    }*/
}
?>
