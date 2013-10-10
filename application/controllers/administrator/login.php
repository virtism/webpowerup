<?php
class Login extends CI_Controller
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
         if($this->session->userdata('auth_info') != "")
         {
            redirect('administrator/Dashboard/');;   
         }
        $this->load->model('Affiliate_Model');
        $this->load->model('admin/Admin_model');
        
        $this->load->helper(array('form', 'url'));
        
        $this->load->library('form_validation');
    }

    function index()
    {
        $data['title']                  = 'Super Admin Login';
        $login                          = $this->input->post('login');
        $password                       = $this->input->post('password');
        
        $this->form_validation->set_rules('login', 'Login', 'trim|required'); 
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('s_admin/index', $data);
        }
        else
        {
            $get_result                 = $this->Admin_model->adminLogin($login, md5($password));
            $count                      = count($get_result) ;
            if($count == 0)
            {
                $this->session->set_flashdata('unregister', 'Please Enter Correct "Email" And Password');
                redirect('administrator/Login/');  
            }
                
           if($count>0)
           {
                $auth_array['auth_info'] = $get_result;
                $this->session->set_userdata($auth_array);
                redirect('administrator/Dashboard/');
           }
        }
    }
}
?>
