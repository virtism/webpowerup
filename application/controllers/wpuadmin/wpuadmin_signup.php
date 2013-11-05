<?php
class wpuadmin_signup extends Front_Controller
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Affiliate_Model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if($this->session->userdata('auth-info')!="")
         {
            redirect('wpuadmin/wpuadmin_dashboard');   
         }
        
    }
    function index ()
    {
        //$data['title']          = 'Login Page'; // Capitalize the first letter
        $login                  = $this->input->post('login');
        $password               = $this->input->post('password');
        $get_result             = $this->Affiliate_Model->admin_login($login, $password);
        $count                  = count($get_result) ;
        
        $this->form_validation->set_rules('login', 'Login', 'trim|required'); 
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
         if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('affiliate_view/index');
        }
        else{
        if($count == 0)
        {
            
            $this->session->set_flashdata('unregister', 'Please Enter Correct "Email" And Password');
            redirect('wpuadmin/wpuadmin_signup/');  
        }
            
       if($count>0)
       {
           
            
            $info_array          = array('id'=>$get_result['0']->user_id ,'login'=> $login, 'password'=>$password, 'name'=>$get_result['0']->user_fname , 'user_role'=>$get_result['0']->user_role , 'status'=>$get_result['0']->user_status );
            $auth_array          = array('auth-info'=>$info_array);
            $this->session->set_userdata($auth_array);
            redirect('wpuadmin/wpuadmin_dashboard');
          
       }
        }
       
    
    }
    
    function calculate_trail_end_date($start_date)
    {
     $date = strtotime(  $start_date. " +1 Month");
     $end_date = date("Y-m-d H:i:s",$date);
     return $end_date;
    }
    function signup()
    {
        //print_r($_POST); exit;
        //$this->load->view('affiliate_view/index');

        $this->form_validation->set_rules('affiliate_login', 'Login', 'required|is_unique[users.user_login]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('affiliate_view/sign_up_affiliate');
        }
        else{
            if($this->input->post('submit')){
            $save                               = array();
            $trial_start_date                   = date('Y-m-d H:i:s');
            $trial_end_date                     = $this->calculate_trail_end_date($trial_start_date);  
            $save['user_email']                 = $this->input->post('affiliate_email');
            $save['user_password']              = md5($this->input->post('affiliate_password')); 
            $save['user_login']                 = $this->input->post('affiliate_login'); 
            $save['company']                    = $this->input->post('affiliate_company');
            $save['user_fname']                 = $this->input->post('affiliate_name');
            $save['user_trail_start_date']      = $trial_start_date;
            $save['user_trail_end_date']        = $trial_end_date;
            $save['user_role']                  = 'affiliate';
            $save['user_status']                = 'Active';
            $what = $this->Affiliate_Model->insert_affiliate($save);
            
            if($what == 'success')
                {
                    //echo ' i am in seccuss'; exit;
                    $affiliate_email            = $this->input->post('affiliate_email');
                    $affiliate_company          = $this->input->post('affiliate_company');
                    $affiliate_name             = $this->input->post('affiliate_name');
                    $affiliate_login            = $this->input->post('affiliate_login');
                    $this->send_mail_to_admin($affiliate_email,$affiliate_company, $affiliate_name,$affiliate_login);
                    $this->session->set_flashdata('new_user', 'Register Successfully Please Login');
                    redirect('wpuadmin/wpuadmin_signup/');
                }
            if($what == 'error')
                {
                    //echo ' i am in error'; exit;
                    $this->session->set_flashdata('error', 'Please Enter The Email and User Login That is Not Already Use');
                    redirect('wpuadmin/wpuadmin_signup/signup'); 
                    
                }
            }
        } 
          
    }
    
    function send_mail_to_admin($affiliate_email,$affiliate_company, $affiliate_name,$affiliate_login)
    {
        //$email   = $this->input->post('user_email');
        //$password = $this->input->post('user_password');
        //$login = $this->input->post('log_in');
            $message = '';
            $message .= "New Affiliate Register ";
            $message .= "
            
            +---------------------------------------------+
              Email         : ".$affiliate_email."\n                      
              Company       : ".$affiliate_company." \n
              Name          : ".$affiliate_name."\n                      
              Login Name    : ".$affiliate_login."\n                    
            +---------------------------------------------+
            
            ";
            
            //$message .= "\n We recommend you first taking a tour of our functions and features here at
            //www.webpowerup.com/tour \n";
            
            //$message .= "\n If you require any help, we have a series of help videos that show you how to manage your site. \n";
            
            //$message .= " Thanks for using Our Services\n ";
            
            //$message .= "WebPowerUp! Team \n www.webpowerup.com";
            $this->load->library('email');
            $this->email->from('web@webpowerup.net', 'WebPowerUp!');
            $this->email->to('qasim_online_now@yahoo.com');
            $this->email->bcc('khalil.junaid@gmail.com');
            $this->email->subject('New Affiliate');
            $this->email->message($message);
            $this->email->send();
            return true;
        
    }
}
?>
