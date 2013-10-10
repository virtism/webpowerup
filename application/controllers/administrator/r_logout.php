<?php
class Logout extends CI_Controller
{
    function Logout()
    {
        parent::__construct();
        
        //load session library for using sessions
        $this->load->library('session');
        
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
            redirect('administrator/');
        }
        else
        {
            //ok, let go
            return;
        }   
         
    }
    
    function index()
    {
        //confirm that the user has logged-in
        $this->check_login();
        
        //destroy session
        $this->session->sess_destroy();
        
        //take user to admin/login(view)
        redirect('administrator/');    
    }
}
?>