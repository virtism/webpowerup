<?php
class wpuadmin_signup extends CI_Controller
{
    var $site_id;
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('custom_helper');
        $this->load->library('form_validation');
        
        $this->load->library('session');
        $this->load->library('Template');
        $this->load->library('upload');   
        
          
        //$this->load->view('signup');    
        $this->load->database();
        //$this->load->library('pagination');
        $this->load->Model('UsersModel');
        $this->load->Model('RolesModel');  
        $this->load->Model('Menus_Model');    
        $this->load->Model('PagesModel');
        $this->load->model('shop_model'); 
        $this->load->Model('Pages_Model');
        $this->load->Model('Affiliate_Model');
        $this->load->model('Footer_Model');
        
        $this->load->Model('PackageModel'); 
        $this->load->Model('SitesModel'); 
        $this->load->Model('Site_Model');
        $this->load->Model('templates');    
        
        $this->load->model('Contact_Management_Model');      
        //$this->load->Controller("UsersController");
        $this->output->cache(0);  // caches
        
        
        // initializing template ...
        $this->load->library('Webpowerup');
        $this->webpowerup->initialize_template();
        
        $this->firephp->log($_SESSION);
        $this->checkLogin();
        
    }
    function checkLogin()
    {
        //checks if session user_info is set
        /*echo "<pre>";
        print_r($_SESSION);
        exit;*/
        
        if(!$_SESSION['user_info']['user_id'] && $_SESSION['user_info']['user_id'] == NULL)
        {
            //go to login controller
            redirect("UsersController/login/sitelogin");
        }
        else
        {
            //ok, let go
            
            $user_trial_end = $this->PackageModel->check_user_trial_end($_SESSION['user_info']['user_id']);
            $status = $this->UsersModel->get_status($_SESSION['user_info']['user_id']);
            
            if($status == "Suspend")
            {
                redirect("UsersController/upgrade_package");
            }
            if($user_trial_end)
            {
                redirect("UsersController/upgrade_package");
            }
            
        }
    }
    
    function affiliate($site_id='')
    {
        //echo '<pre>';print_r($_SESSION); exit;
        //checks user login
    
       
       $_SESSION['site_id']= $site_id;
        
        $data['current_site'] = $this->SitesModel->get_sites_spec($_SESSION['user_info']['user_id'],$_SESSION['site_id']);
        // echo "<pre>";    print_r($_SESSION); echo "</pre>";
        $this->template->write_view('SwitchMenu','webpowerup/SwitchMenu',"",true);
        $this->template->write_view('header','webpowerup/header',"",true);
        // echo "<pre>";    print_r($_SESSION); echo "</pre>";
        
        $this->checkLogin();
        $expire = $this->sitesmodel->check_site_date_end($_SESSION['site_id']);
        if($expire)
        {
            redirect("SiteController/site_expire_payment");
        }
        
    
         // create dash board link
         $dashboardLink = current_url();
         $this->session->set_userdata("dashboard_link", $dashboardLink);
        
        
         $this->breadcrumb->clear();
         $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
         $this->breadcrumb->add_crumb('Dashboard');
        $package_id = $this->UsersModel->get_package_by_user_id($_SESSION["user_info"]["user_id"]);
        $packages = $this->PackageModel->get_package_by_id($package_id); 
        $modules = $this->PackageModel->get_all_modules_by_package_id($package_id);
        
        $data["packages"] = $packages;
        $data["modules"] = $modules;
        $data['user_fname'] = $_SESSION['user_info']['user_fname'];
        $data['current_site'] = $this->SitesModel->get_sites_spec($_SESSION['user_info']['user_id'],$_SESSION['site_id']);
        //$this->load->view("home",$data);
        $site_domain = $this->Site_Model->get_site_domain_name($site_id);
        //echo '----'.$site_domain[0]['domain'];
        if(isset($site_domain[0]['domain']) && !empty($site_domain[0]['domain']))
        {
            //$result = dns_get_record($site_domain[0]['domain']);
            /*echo "<pre>";
            print_r($result);
            exit;*/
            
            if(empty($result))
            {
                $data['domain'] = 0;
            }
            else
            {
                if(in_array($site_domain[0]['domain'], $result[0]))
                {
                    $data['domain'] = 1;
                }
                else
                {
                    $data['domain'] = 0;
                }
            }
        }
        else
        {
            $result = '';        
        
        }
        $this->template->write_view('content','affiliate_signup',$data);
        $this->template->render();
    }
    function ChangeToAffiliate()
    {
        //print_r($_POST);exit;
        if($this->input->post('bcaffilate') == "No")
        {
            $save = array();
            $save['user_id'] = $this->input->post('user_id');
            $save['user_role'] = '';
            $this->Affiliate_Model->ChangeToAffilate($save);
            $_SESSION['user_info']['user_role'] = '';  
            redirect("SiteController/sitehome/".$_SESSION['site_id']);
        }
        if($this->input->post('bcaffilate') == "Yes")
        {
            $save = array();
            $save['user_id'] = $this->input->post('user_id');
            $save['user_role'] = 'affiliate';
            $this->Affiliate_Model->ChangeToAffilate($save);
            $_SESSION['user_info']['user_role'] = 'affiliate';  
            redirect("SiteController/sitehome/".$_SESSION['site_id']);
        }
    }
    function memberOfAffiliate()
    {
        $member = $this->Affiliate_Model->get_affiliate_member($_SESSION['user_info']['user_id']);
       // echo '<pre>'; print_r($member); exit;
                $link = substr(uri_string(),1);
        $group_link = base_url().$link;
        $this->session->set_userdata("group_link", $group_link); 
        
        $this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
        $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
        $this->breadcrumb->add_crumb('Groups'); 
       
        $this->checkLogin();
        
        
        
        $site_id = $_SESSION["site_id"];
        
        $userData = $this->UsersModel->get_user_by_id(); 
        $data['userData'] = $userData;
        
        $data['members'] = $this->Affiliate_Model->get_affiliate_member($_SESSION['user_info']['user_id']);
        
        //Going to fetch members count
    


        

        $this->template->write_view('content','affiliate_member_listing',$data);
        // Render the template
        $this->template->render();
    }
    
}
?>
