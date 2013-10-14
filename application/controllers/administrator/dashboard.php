<?php
class Dashboard extends CI_Controller
{
    //constructor for Administrator controller 
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('auth_info') == "")
         {
            redirect('administrator/login/');;   
         }
    }
    
    
    function index()
    {
        $data['left_bar'] = 'dashboard';
        $this->load->view('s_admin/dashboard' , $data);
    }
    function logout()
    {
        $this->session->sess_destroy();
        redirect('administrator/'); 
        
    }
}
?>