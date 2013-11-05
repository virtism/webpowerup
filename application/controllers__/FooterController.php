<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!session_start()){
    session_start(); }  
class FooterController extends CI_Controller {
    var $site_id;  
    var $user_id;  

    function __construct()
    {
        parent::__construct();
        
        $this->load->helper('url');
		$this->load->library('session');
        $this->load->library('Template'); 
		//Check user Login
		$this->load->library('check_user_login');
		$this->load->library('session');
        $this->check_user_login->checkLogin();       
        $this->load->model('Footer_Model');
        $this->load->helper('security');
         if(isset($_SESSION["site_id"]) && is_numeric($_SESSION["site_id"]))
		{
			$this->site_id = $_SESSION['site_id'];
		}
		else
		{
			//$this->site_id = $_SESSION['site_id_custom'];
			$this->site_id = '';
			$this->site_id = $this->uri->segment(3);
			$_SESSION['site_id'] = $this->uri->segment(3);
		}
		$this->load->library('email');
        //$this->user_id = $_SESSION['user_info']['user_id'];
		$this->load->model('Contact_Management_Model');
		
		// initializing template ...
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
		
        
    }
    function index(){
        // Setting variables
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Footer Content' ); 
		
		
		
        $site_id = $this->site_id;
        
        $data["site_id"] = "";
        $data["content"] = "";        
        
//    echo $site_id;exit;
        $footer_content = $this->Footer_Model->get_footer_content($site_id);
        if(empty($footer_content))
        {
            /*$this->Footer_Model->create_footer($site_id);
            $footer_content = $this->Footer_Model->get_footer_content($site_id);
            $data["site_id"] = $footer_content["site_id"];
            $data["content"] = $footer_content["content"];*/
            $data["content"] = '';
        }
        else
        {
           	$session_data = $this->session->all_userdata();
			$data["site_id"] = $footer_content["site_id"];
            $data["content"] = $footer_content["content"];
			if(isset($session_data["status"]))
			{
				$data["status"] = $session_data["status"];
				$this->session->unset_userdata('status');
			}
			
			       
        }
        //echo "<pre>";
        //print_r($footer_content);
        //exit;
        
        $this->template->write_view('content','all_common/footer_content', $data); 
        $this->template->render();   
            
    }
	
    function update_footer($site_id = 0)
    {
		if(isset($site_id) && $site_id!=0)
		{
			$this->site_id = $site_id;
		}
        $footer_content = $this->Footer_Model->update_footer_content($_REQUEST['content'], $this->site_id);
        if($footer_content)
		{
        	$this->session->set_userdata('status','ok');
			redirect(base_url().index_page().'FooterController/index/'.$site_id);      
        }    
     }
	 
	 function send_conatct_email()
	 {
		$site_id 	= $_SESSION['site_id'];
	 	$data 		= $this->Contact_Management_Model->check_contact_form($site_id);
		$email_to 	= $data['caption_EmailTo'];
		//$email_to = $this->config->item('contact_mail_to');
		$email_from = $_REQUEST["email"];
		$body 		= $_REQUEST["msg"];
		$subject 	= "Contact Us";		
		$full_name 	= $_REQUEST["name"];
			
		$config['mailtype'] 	= 'text';
		$config['protocol'] 	= 'sendmail';
		$config['charset'] 		= 'utf-8';
		$config['wordwrap'] 	= TRUE;
		
		$this->email->initialize($config);
		//$send = $this->email->send();
		$this->email->from($email_from, $full_name);
		$this->email->subject($subject);
		$this->email->message($body);
		$this->email->to($email_to);
		
		$send = $this->email->send();
	
		if($send)
		{
			echo "Email has been sent. We will contact you soon.";
		}
		else
		{
			echo "ERROR: We are trying to solve ASAP...";
		}
		
	 }
	 
	 function conatct_form_email()
	 {
	 	
		//echo '<pre>'; print_r($_SERVER['HTTP_REFERER']);exit;
		//echo "<pre>";print_r($_POST);exit;
		$site_id 	= $_SESSION['site_id'];
		//$page_id = $_SESSION['page_id'];
	 	$data 		= $this->Contact_Management_Model->check_contact_form($site_id);
		$email_to 	= $data['caption_EmailTo'];
		//$email_to = $this->config->item('contact_mail_to');
		$name 		= $_POST['txtcap1'];
		$email_from = $_POST['email_from'];
		$subject 	= $_POST["txtcap2"];
		$message 	= "Name: ".$_POST['txtcap1']."\n\nE-mail From:".$_POST["email_from"]."\n\nMessage:".$_POST["message"];
		
		$config['mailtype'] 	= 'text';
		$config['protocol'] 	= 'sendmail';
		$config['charset'] 		= 'utf-8';
		$config['wordwrap'] 	= TRUE;
		
		$this->email->initialize($config);
		//$send = $this->email->send();
		$this->email->from($email_from, $name);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->to($email_to);		
		$send = $this->email->send();
		
		if($send)
		{
			$_SESSION['mail_sent'] = 1;
			$this->session->set_userdata('message', 'Email has been sent successfully.');
			//echo $this->session->userdata('message');exit;
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			
			$this->session->set_userdata('message', 'Please enter valid email.');
			//echo $this->session->userdata('error');exit;
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	 }		 
    
}  
?>