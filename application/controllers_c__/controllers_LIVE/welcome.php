<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Template');  
		
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		$this->load->Model('RolesModel'); 
		$this->load->Model('PackageModel'); 
        $this->load->Model('Menus_Model');   
        $this->load->library('session');     
		$this->output->cache(0);  // caches 
		$this->template->set_template('gws');  
		//$this->template->render($region = NULL, $buffer = FALSE, $parse = FALSE)  ;    
	}

	function index()
	{
		  
	  
	   //$basic['template'] = 'rss_template.php';
	 //$rss['regions'] = array('name', 'items');
	 //$this->template->set_template('rss');


		//	$this->template->write('content', 'You one ');
// $this->template->write('content', 'bad mother...');
 // $content region = "You one bad mother..."

 //$this->template->write('content', "Shut'yo mouth!");
 // $content region = "Shut'yo mouth!"
		$userData = $this->UsersModel->get_user_by_id(); 
		// echo "<pre>";
		// print_r($userData);
		// exit;
		 $data['userData'] = $userData;
	//$this->load->view('welcome_message', $data);
	 $this->template->write_view('content','welcome_message',$data);
// Write to $title
	//  $this->template->write('title', 'Welcome to the Template Library Docs!');
	  
	  // Write to $content
	 // $this->template->write_view('content', 'welcome_message',$data);
	  
	  // Write to $sidebar
	//  $this->template->write_view('sidebar', 'common/sidebar');
	  
	  // Render the template
	  $this->template->render();

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */