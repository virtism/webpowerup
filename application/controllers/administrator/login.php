<?php
//class definition for Administrator controller
class Login extends CI_Controller
{
    //constructor for Administrator controller 
    function Login()
    {
        //parent constructor
        parent::__construct();
        
        //load html helper functions
        $this->load->helper('html');
        
        //load template library for gws_admin template
        $this->load->library('Template');
        
        //set views gws_admin/template.php as template
        $this->template->set_template('gws_admin');
        
        //load Admin_model for DB interaction
        $this->load->model('admin/Admin_model');
        
        //load session library for using sessions
        $this->load->library('session');
        
        //load URL helper
        $this->load->helper('url');
    }
        
    //this function loads login screen(view) of administrator
    function index()
    {
        //get user session info
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        
        //go to admin_home if user has already logged-in
        if($user_info!='' && $user_role!='')
        {
            //go to Admin Home
            redirect('administrator/dashboard');
        }
        
        //load jquery & jquery-validation plugin
        $this->template->add_js('js/jquery-1.5.min.js', 'import', FALSE);
        $this->template->add_js('js/validation/jquery.validate.js', 'import', FALSE);
        
        //load inline javascripts witten in $scripts variable
        //$scripts = 'window.alert("hello world")';
        //$this->template->add_js($scripts, 'embed', FALSE);
        
        $data['user_login'] = '';
        $data['message'] = '';
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/login', $data);
        
        //display the template with its regions written above
        $this->template->render();           
    }
    
    //this function is called when user provides login details(user_login & password)
    function verify()
    {
        $user_login = $this->input->post('user_login');
        $user_password = $this->input->post('user_password');
        
        if(!isset($user_login))
        {
            //go to login screen
            $this->index();    
        }   
        else
        {
            //check user login-credentials
            $boolLogin = $this->Admin_model->isUser($user_login, $user_password);
            
            if($boolLogin == TRUE)
            {
                //write user_info in Session
                $this->session->set_userdata('user_role', 'Administrator');
                
                $rsltUserInfo = $this->Admin_model->getUserInfo();
                $user_info['user_info'] = $rsltUserInfo->row_array();
                $this->session->set_userdata($user_info);
                
                //go to Admin Home
                redirect('administrator/dashboard/');
                
            }    
            else
            {
                //go to login screen with invalid login message
                
                //prefill user_login field
                $data['user_login'] = $user_login;
                $data['message'] = 'Invalid User Login and/or Password combination.';
                
                //write admin/login(view) in content region in gws_admin/template.php(view)
                $this->template->write_view('content', 'admin/login', $data);
                
                //display the template with its regions written above
                $this->template->render();
            }
            
        }     
    }
    
}
?>