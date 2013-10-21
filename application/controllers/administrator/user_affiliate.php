<?
class user_affiliate extends CI_Controller{
    
    function user_affiliate()
    {
        parent::__construct();
        if($this->session->userdata('auth_info') == "")
         {
            redirect('administrator/login/');;   
         }

    }
    function all_subAdmin()
    {
        $data['left_bar']                   = 'subadmin';
        $data['sub_admins'] = $this->UsersModel->get_user_by_id();
        $this->load->view('s_admin/sub_admin' , $data);
    }
    function affiliate()
    {
        
        $data['left_bar']                   = 'affiliate';  
        $data['affiliates'] = $this->Admin_model->get_affiliate();
        $this->load->view('s_admin/affiliate_list' , $data);
    }
    function get_affiliate_member($affiliate_id)
    {
        $data['left_bar']                   = 'affiliate';
        $data['affiliate_members']          = $this->Admin_model->get_affiliate_member($affiliate_id);
        $this->load->view('s_admin/affiliate_member', $data);
        
    }
}?>