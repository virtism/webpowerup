<?php
//created by Numaan on 06/Sep/2011

//start session if not started
if(!session_start()){
    session_start();
}

class Services extends CI_Controller
{
    function Services()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->template->set_template('gws'); 
        $this->load->database();
        
        $this->output->cache(0);  // caches
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
    
    //index screen to show services created by this user
    function index()
    {
        //confirm user has logged in
        $this->checkLogin();
        
        //loads services/index(view) in content region of the template
        $this->template->write_view('content','services/index');
        $this->template->render();        
    }
    
    //this function loads add_service(view)
    function add_service()                
    {
        //confirm user has logged in
        $this->checkLogin();
            
        //loads services/index(view) in content region of the template
        $this->template->write_view('content','services/add_service');
        $this->template->render();
        
    }
}
?>
