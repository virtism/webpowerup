<?php
class wpuadmin_dashboard extends Front_Controller
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Affiliate_Model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    if($this->session->userdata('auth-info')=="")
     {
        redirect('wpuadmin/wpuadmin_signup/');  
     }
        
    }
    function index()
    {
        
        $data['left_bar']                   =  'dashboard';
        $this->load->view('affiliate_view/dashboard',$data); 
    
    }
    function logout()
    {
        $this->session->unset_userdata('auth-info');
        redirect('wpuadmin/wpuadmin_signup'); 
    }
    function edit_affiliate()
    {
        $data['left_bar']                   = 'dashboard';
        $affiliate_info                     = $this->session->userdata('auth-info');
        $data['affiliate_info']             = $this->Affiliate_Model->get_admin($affiliate_info['login'],$affiliate_info['id']);
        //echo '<pre>';print_r($data['affiliate_info']); exit;
        $this->load->view('affiliate_view/affiliate_edit_pro',$data);
        
    }
    function list_of_member()
    {
        $data['left_bar']                   = 'dashboard';
        $affiliate_info                     = $this->session->userdata('auth-info');
        $data['listings']                   = $this->Affiliate_Model->get_affiliate_member($affiliate_info['id']);
        //echo '<pre>';print_r($data['listings']); exit;
        $this->load->view('affiliate_view/list_of_member', $data);
        
    }
    function check_password($user_id)
    {
        $password                           =  md5($this->input->post('password'));
        $test                               = $this->Affiliate_Model->checkAffiliatePassword($user_id , $password);
        echo $test;
        
    }
    function change_password()
    {
        $password                           = md5($this->input->post('affiliate_password'));
        $test                               = $this->Affiliate_Model->checkAffiliatePassword($this->input->post('affiliate_pro_id'), $password);

        if($test == 'correct'){
        if($this->input->post('affiliate_pro_id') != '')
        {
            $save['user_id']                = $this->input->post('affiliate_pro_id');
            $save['user_password']          = md5($this->input->post('new_affiliate_password'));
        } 
         $this->Affiliate_Model->insert_affiliate($save);
         $this->session->set_flashdata('change_passrowd', 'Password Is Changed Successfully');
         redirect('wpuadmin/wpuadmin_dashboard');
        }
        else
        {
            $this->session->set_flashdata('password_error', 'Please Enter The Correct Old Password');
            redirect('wpuadmin/wpuadmin_dashboard/edit_affiliate'); 
            
        }
        
    }
}