<?php
 if(!session_start()){
    session_start();
}
  class Newsletter_Management extends CI_Controller{
  
      
      function __construct()
      {
          
        parent::__construct();

        $this->load->database();

        $this->load->helper('url');
        $this->load->library('Template');
        $this->load->library('session');
        $this->load->model('Newsletter_Model');		
		$this->load->library('Webpowerup');
		//Check user Login
		$this->load->library('check_user_login');
        $this->check_user_login->checkLogin();
		$this->webpowerup->initialize_template();
		      
      }
      
    //Numaan 08/09/2011
    //checks that user has logged-in Or not
    function check_login()
    {
        //checks if session user_info is set
        $user_info = $this->session->userdata('user_info');
        $user_role = $this->session->userdata('user_role');
        
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
    //end

      function index()
      { 
	  
		$news_link = current_url();
		$this->session->set_userdata("news_link", $news_link);		
		$this->breadcrumb->clear();
        $this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
        $this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
        $this->breadcrumb->add_crumb('Newsletter Management' );			  
		$show_data['newsletter']                = $this->Newsletter_Model->get_all_newsletter();
        $show_data['newsletter_group']         = $this->Newsletter_Model->get_newsletter_groups('', $_SESSION['site_id']);	
        //echo '<pre>'; print_r($show_data['newsletter_group']); exit;		
		$this->template->write_view('content','newsletter/Newsletter_Management_View',$show_data);
		$this->template->render();
      
      }
   
      // view individual contact page description 
     function  view_newsletter ()
     {
        
        $page_id = $this->uri->segment(3);
        //$page_id.">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
        if(!$page_id){$page_id = 1;}
        $data_fetch= array ();

        $data_fetch = $this->Newsletter_Model->get_newsletter($page_id);

        //$data['left_menu'] = $this->Newsletter_Model->left_menu();
        //$data['right_menu'] = $this->Newsletter_Model->right_menu(); 

        $data['news_id'] = $data_fetch['news_id'];
        $data['news_subject'] = $data_fetch['news_subject'];
        $data['news_body'] = $data_fetch['news_body'];
        $data['news_recipient_group'] = $data_fetch['news_recipient_group'];
        $data['news_date_created'] = $data_fetch['news_date_created'];
        $data['news_date_sent'] = $data_fetch['news_date_sent'];
	
		$this->template->write_view('content','Newsletter_View',$data);
		$this->template->render();
	
     }
     
      // method to soft delete contact
      function delete_newsletter()
      {
      	$page_id = $this->uri->segment(3);
        $contact_data = $this->Newsletter_Model->delete_hard($page_id);
      }
      
      function delete_newsletter_group($group_id)
      {
         $this->Newsletter_Model->delete_newsletter_group($group_id, $_SESSION['site_id']);
         redirect(base_url().index_page().'Newsletter_Management');   
      }
      
      // method to send newsletter throughh admin
      
      function send_newsletter_admin ($letter_id)
      {
		$result = $this->Newsletter_Model->send_newsletter_to_selected($letter_id, $_SESSION['site_id']);
		if($result)
		{
			$this->session->set_flashdata('success', 'News Letter Sent Successfully!');
			redirect('Newsletter_Management');
		}
		/*$rec_id = $this->uri->segment(3);     
         echo  $rec_id;*/
      }
  }
?>