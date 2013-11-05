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
		$this->load->helper('custom_helper');
		$this->load->library('session');
        $this->load->library('Template');
        $this->template->set_template('gws');
        $this->load->model('Footer_Model');
        $this->load->helper('security');
        $this->site_id = $_SESSION['site_id'];
		$this->load->library('email');
        //$this->user_id = $_SESSION['user_info']['user_id'];
		$this->load->model('Contact_Management_Model');
        
      
 
    }
    function index(){
        // Setting variables
		is_login();
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Footer Content' ); 
		
		
		
        $site_id = $_SESSION['site_id'];
        
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
            $data["site_id"] = $footer_content["site_id"];
            $data["content"] = $footer_content["content"];        
        }
        //echo "<pre>";
        //print_r($footer_content);
        //exit;
        
        $this->template->write_view('content','all_common/footer_content', $data); 
        $this->template->render();   
            
    }
    function update_footer()
    {
		$site_id = $_SESSION['site_id'];
        //echo '<pre>';  print_r($_POST); echo 'I am here ';  echo '</pre>'; exit();
        $footer_content = $this->Footer_Model->update_footer_content($_REQUEST['content'], $this->site_id);
        if($footer_content){
        redirect(base_url().index_page().'site_preview/site/'.$site_id);      
        }    
     }
	 function send_conatct_email()
	 {
		$site_id = $_SESSION['site_id'];
	 	$data = $this->Contact_Management_Model->check_contact_form($site_id);
		$email_to = $data['caption_EmailTo'];
		//$email_to = $this->config->item('contact_mail_to');
		$email_from = $_REQUEST["email"];
		$body = $_REQUEST["msg"];
		$subject = "Contact Us";
		
		$full_name = $_REQUEST["name"];
			
		$config['mailtype'] = 'text';
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		
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
	 	
		//echo "<pre>";print_r($_REQUEST);exit;
		$site_id = $_SESSION['site_id'];
		//$page_id = $_SESSION['page_id'];
	 	$data = $this->Contact_Management_Model->check_contact_form($site_id);
		
		$email_to = $data['caption_EmailTo'];
		//$email_to = $this->config->item('contact_mail_to');
		$name = $_POST['txtcap1'];
		$email_from = $_POST['email_from'];
		$subject = $_POST["txtcap2"];
		$message = "Name: ".$_POST['txtcap1']."\n\nE-mail From:".$_POST["email_from"]."\n\nMessage:".$_POST["message"];
		
		$config['mailtype'] = 'text';
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		
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
			redirect('contact-us.html');
		}
		else
		{
			echo "ERROR: We are trying to solve ASAP...";
		}
		
	 }		 
    
}  
?>