<?php
class Home extends CI_Controller
{
    function Home()
    {
        parent::__construct();
        
        //load template library for gws_admin template
        $this->load->library('Template');
        
        //set views gws_admin/template.php as template
        $this->template->set_template('gws_admin');
        
        //load session library for using sessions
        $this->load->library('session');
        
        //load URL helper
        $this->load->helper('url');
    } 
    
    //checks that user has logged-in Or not
    function check_login()
    {
        //checks if session user_info is set
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        
        if($user_info=='' && $user_role=='')
        {
            //go to login controller
            redirect('administrator/index');
        }
        else
        {
            //ok, let go
            return;
        }   
         
    }   
    
    function index()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/members_groups/index');
        
        //display the template with its regions written above
        $this->template->render();    
    }
}
?>
