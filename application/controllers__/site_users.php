<?php
//session starter
if(!session_start()){
    session_start();
}

//class definition for this controller
class Site_users extends CI_Controller
{
    //constructor for this controller
    function Site_users()
    {
        parent::__construct();
        
        //code ignitor helpers 
        $this->load->library('pagination');
        $this->load->library('session');    
        $this->load->helper('url');   
        $this->load->helper('html');
        
        //code igniter helper for using templates 
        $this->load->library('Template');
        $this->template->set_template('gws');
         
        //load model of this controller
        $this->load->model("Siteusers_model");
    }
    
    //checks user has logged-in
    function check_login()
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
    
    //loads site's user management(view)
    function index()
    {
        //confirm that user has logged-in to access this page
        $this->check_login();
        
        //get all users of this site
        $this->Siteusers_model->getSiteUsers();
        
        //write content region of the template
        $this->template->write_view('content', 'site_users/index');    
        
        //display the template with its regions     
        $this->template->render(); 
            
    }
    
    //loads create user's screen / view
    function create()
    {
        //confirm that user has logged-in to access this page
        $this->check_login();
        
        //write content region of the template
        $this->template->write_view('content', 'site_users/create');    
        
        //display the template with its regions     
        $this->template->render();    
    }
    
    //create's a user & redirect to users management screen / view
    function create_user()
    {
        
    }
}  
?>
