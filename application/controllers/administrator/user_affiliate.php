<?
class user_affiliate extends CI_Controller{
    
    function user_affiliate()
    {
        
        $packageArray = array();
        
        parent::__construct();
        $this->load->helper('url');
        //$this->load->view('signup');    
        $this->load->database();
        //$this->load->library('pagination');
        $this->load->Model('UsersModel');
        $this->load->Model('RolesModel'); 
        $this->load->Model('PackageModel');
         $this->load->model('admin/Admin_model');    
        
        //load session library for using sessions
        $this->load->library('session');
        
        //load template library for gws_admin template
        $this->load->library('Template');
        
        //set views gws_admin/template.php as template
        $this->template->set_template('gws_admin');
          
        $this->output->cache(0);  // caches
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