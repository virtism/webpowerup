<?php
//class definition for Administrator controller
class Administrator extends CI_Controller
{
    //constructor for Administrator controller 
    function Administrator()
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
        $this->load->model('Admin_model');
        
        //load session library for using sessions
        $this->load->library('session');
        
        //load URL helper
        $this->load->helper('url');
        
        //load Newsletter_Model for Newsletter 
        $this->load->model('Newsletter_Model');   
    }
        
    //this function loads login screen(view) of administrator
    function index()
    {
        //get user session info
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        
        //go to admin_home if user has already logged-in
        /*
        echo "<pre>";
        print_r($user_role);
        exit;
        */
        if($user_info!='' && $user_role!='')
        {
            //go to Admin Home
            redirect('administrator/admin_home');
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
    function login()
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
                /*
                echo "<pre>";
                print_r($this->session);
                exit;
                */
                //go to Admin Home
                redirect('administrator/admin_home');      
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
    
    //checks that user has logged-in Or not
    function check_login()
    {
        //checks if session user_info is set
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        /*
        echo "<pre>";
        print_r($user_role);
        exit;
        */
        
        if($user_info=='' && $user_role=='')
        {
            //go to login controller
            //$this->index();
            redirect('administrator/index');
        }
        else
        {
            //ok, let go
            return;
        }   
         
    }
    
    //loads admin/admin_home(view)
    function admin_home()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/home');
        
        //display the template with its regions written above
        $this->template->render();       
    }
    
    
    //logouts the user logged-in
    function logout()
    {
        //confirm that the user has logged-in
        $this->check_login();
        
        //destroy session
        $this->session->sess_destroy();
        
        //take user to admin/login(view)
        redirect('administrator/index');
    }
    
    //loads admin/site_content_home(view)
    function site_content_home()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/site_content_home');
        
        //display the template with its regions written above
        $this->template->render();            
    }
    
    //loads admin/design_config_home(view) 
    function design_config_home()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/design_config_home');
        
        //display the template with its regions written above
        $this->template->render();        
    }
    
    //loads admin/members_groups_home(view) 
    function members_groups_home()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/members_groups_home');
        
        //display the template with its regions written above
        $this->template->render();       
    }
    
    //loads admin/newsletter_home(view) 
    function newsletter_home()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        //$this->template->write_view('content', 'admin/newsletter_home');
        
        $show_data['view_all_records'] = $this->Newsletter_Model->show_all_newsletter();
        $this->template->write_view('content','Newsletter_Management_View',$show_data);
        //$this->load->view('Newsletter_Management_View',$show_data); 
        
        //display the template with its regions written above
        $this->template->render();               
    }
                    
    //loads admin/ecommerce_home(view) 
    function ecommerce_home()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $this->template->write_view('content', 'admin/ecommerce_home');
        
        //display the template with its regions written above
        $this->template->render();        
    }
    
    function packages()
    {
        //confirm that user has logged-in
        $this->check_login();
        
        //write admin/login(view) in sidebar region in gws_admin/template.php(view)
        $this->template->write_view('sidebar', 'gws_admin/sidebar');
        
        //write admin/login(view) in content region in gws_admin/template.php(view)
        $qry = "SELECT * FROM packages WHERE package_status != 'Deleted'";

        $query = $this->db->query($qry);
        $packages = $query->result_array(); 
        $data["packages"] = $packages;
        $this->template->write_view('content', 'package_home', $data);
        
        //display the template with its regions written above
        $this->template->render();    
    }

    
}
?>
