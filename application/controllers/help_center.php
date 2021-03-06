<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help_Center extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Template');  
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		$this->load->Model('Help_Center_Model'); 
		//$this->load->Model('PackageModel'); 
		$this->load->library('session'); 
		$this->load->library('upload'); 	
		$this->output->cache(0);  // caches 
		
		$this->load->library('Webpowerup');
		$this->webpowerup->initialize_template();
	   
	}
	//checks that user has logged-in Or not
	private function checkLogin()
	{
		//checks if session user_info is set
		if(!$_SESSION['user_info']['user_id'] && $_SESSION['user_info']['user_id'] == NULL)
		{
			//go to login controller
			redirect("UsersController/login/sitelogin");
		}
		else
		{
			//ok, let go
			return;
		}
	}
	//end

	function topics_home()
	{
		$link = substr(uri_string(),1);
		$help_link = base_url().$link;
		$this->session->set_userdata("help_link", $help_link); 
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Help Center' );
		
		$this->checkLogin();
		
		$site_id = $_SESSION["site_id"];
		
		$topics = $this->Help_Center_Model->get_all_topics($site_id); 
		$data['topics_array'] = $topics;
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$this->template->write_view('content','help_center/topics_home',$data);
		// Render the template
		$this->template->render();
	}
	
	function questions_home()
	{
		$link = substr(uri_string(),1);
		$question_link = base_url().$link;
		$this->session->set_userdata("question_link", $question_link); 
		
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Questions & Answers' );
		
		$this->checkLogin();
		
		$site_id = $_SESSION["site_id"];
		
		$questions = $this->Help_Center_Model->get_all_question($site_id); 
		$data['questions_array'] = $questions;
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$this->template->write_view('content','help_center/questions_home',$data);
		// Render the template
		$this->template->render();
	}
	

	/*
	 This function will be used in new site/vistor sign-up group creation.
	*/
	
	function create_new_topic()
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Help Center', $this->session->userdata("help_link") ); 
		$this->breadcrumb->add_crumb('New');
		
		$this->checkLogin();
		
		$action = "New";
		$data["action"] = $action;
		
		$site_id = $_SESSION["site_id"];
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$data["topic_array"][0] = array();
		
		
		$this->template->write_view('content','help_center/new_topic',$data);
		// Render the template
		$this->template->render();
		
	}
	
	function create_new_question()
	{
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb('Main', $this->session->userdata("mainPage_link") );
		$this->breadcrumb->add_crumb('Dashboard', $this->session->userdata("dashboard_link") ); 
		$this->breadcrumb->add_crumb('Questions & Answers', $this->session->userdata("question_link") ); 
		$this->breadcrumb->add_crumb('New');
		
		$this->checkLogin();
		
		$action = "New";
		$data["action"] = $action;
		
		$site_id = $_SESSION["site_id"];
		
		$topics = $this->Help_Center_Model->get_all_topics($site_id);
		$data["all_topics_array"] = $topics; 
					
		
		$this->template->write_view('content','help_center/new_questions',$data);
		// Render the template
		$this->template->render();
		
	}
	
	function edit_topic($topic_id)
	{
		$action = "Update";
		$data["action"] = $action;
		
		$site_id = $_SESSION["site_id"];
		
		$userData = $this->UsersModel->get_user_by_id(); 
		$data['userData'] = $userData;
		
		$topic_data = $this->Help_Center_Model->get_topic_by_id($topic_id);
		$data["topic_array"] = $topic_data;
		
		$this->template->write_view('content','help_center/new_topic',$data);
		// Render the template
		$this->template->render();
		
	}
	
	function edit_question($question_id)
	{
		$action = "Update";
		$data["action"] = $action;
		
		$site_id = $_SESSION["site_id"];
		
		$question_data = $this->Help_Center_Model->get_question_by_id($question_id);
		$data["question_array"] = $question_data;
		
		$topics = $this->Help_Center_Model->get_all_topics($site_id);
		$data["all_topics_array"] = $topics; 
		
		$this->template->write_view('content','help_center/new_questions',$data);
		// Render the template
		$this->template->render();
		
	}
	
	/*
	 This function will be used in new topic creation for help center
	
	*/
	function do_creat_topic()
	{
		$site_id = $_SESSION["site_id"];

		$this->Help_Center_Model->do_creat_new_topic($site_id);
		redirect("help_center/topics_home");
	}
	
	function do_creat_question()
	{
		$site_id = $_SESSION["site_id"];
		$this->Help_Center_Model->do_creat_new_question($site_id);
		redirect("help_center/questions_home");
	} 
	
	function delete_topic($topic_id)
	{
		$this->Help_Center_Model->do_delete_topic($topic_id);
		redirect("help_center/topics_home");
	}  
	
	function delete_question($question_id)
	{
		$this->Help_Center_Model->do_delete_question($question_id);
		redirect("help_center/questions_home");
	} 
    
    // user side view 
    // edited by sahil babu
    

    
    
    
    
           
}