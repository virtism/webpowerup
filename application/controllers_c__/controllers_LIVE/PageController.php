<?php
class PageController extends CI_Controller {
	
	function PageController()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Template');
		$this->template->set_template('winglobal'); 
		//$this->load->view('signup');	
		$this->load->database();
		//$this->load->library('pagination');
		$this->load->Model('UsersModel');
		$this->load->Model('RolesModel');   
		$this->load->Model('PagesModel');
		$this->load->Model('SitesModel');
		
		$this->output->cache(0);  // caches
	}
	
	
	function creatpage()
	{
		 $site_id =  $this->uri->segment(3) ;
		 if(!empty($site_id))
		 {
			$siteInfo = $this->SitesModel->get_site_by_id($site_id);	 
			$data["siteInfo"] = $siteInfo;
		 }
		 $roles = $this->RolesModel->get_all_roles();
		 $data["roles"] = $roles;
		 //$this->load->view("new_page",$data);
		 
		 $this->template->write_view('content','new_page',$data);
		 $this->template->render(); 
		 
	}
	function do_creat_new_page()
	{
		//	echo "<pre>";
		//	print_r($_POST);
		//	exit;
		if(isset($_POST["action"]) && $_POST["action"] == "creatNewPage")
		{
			//echo "<pre>";
			//print_r($_POST);
			if($this->PagesModel->creat_page() )
			{
				if(isset($_POST["site_id"]))
				{
					redirect('SiteController/success?success=1');    	
				}
				else
				{
					redirect('PageController/success?success=1');    	
				}
			}
		}
		
	}
	function success()
	{
		//if($_GET["success"])
		$msg = "Page Saved Successfully";   
		$data["successMsg"] = $msg;
		
		$this->load->view("success",$data);
	} 
	
		
}		
?>