<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Webpowerup{
	
	var $obj;
	
	public function __construct()
	{
		
		$obj =& get_instance();
		$obj->load->library('Template'); 
		$obj->template->set_template('webpowerup'); 
		$obj->load->model("SitesModel");
		$obj->load->helper('url');
		
	}

	public function initialize_template()
	{
	    
		$obj =& get_instance();
		$obj->template->write('title','Webpowerup');  
	  	//$obj->template->write_view('header','webpowerup/header');
		$data['conferences'] = $obj->SitesModel->get_sites_all_conferences();
		$obj->template->write_view('header','webpowerup/header',$data,true);
		$obj->template->write('leftColumn',1);
		$obj->template->write_view('UserInfo','webpowerup/UserInfo');
		// create left menu
		$data = $this->menu_fix();
		$obj->template->write_view('SwitchMenu','webpowerup/SwitchMenu',$data);
		$obj->template->write_view('contentTop','webpowerup/contentTop');
		$obj->template->write_view('footer','webpowerup/footer');
	}
	
	public function refresh_region($regions) // array must be pass as a peremiter containing region name.
	{
		$obj =& get_instance();
		if($regions)
		{
			foreach($regions as $region)
			{
				switch($region){
					
					case "header":
						$obj->template->write_view('header','webpowerup/header',"",true);
						break;
					case "UserInfo":
						$obj->template->write_view('UserInfo','webpowerup/UserInfo',"",true);
					case "SwitchMenu":
						$obj->template->write_view('SwitchMenu','webpowerup/SwitchMenu',"",true);
					case "contentTop":
						$obj->template->write_view('contentTop','webpowerup/contentTop',"",true);
					case "footer":
						$obj->template->write_view('footer','webpowerup/footer',"",true);
					default:
						break;
				}
			}
		}
	}
	
	private function menu_fix()
	{
		$obj =& get_instance();
		
		$obj->load->model("blog_model");
		$data['blog'] = $obj->blog_model->check_site_blog_exist();
		
		return $data;
	}
	
	public function hide_left_menu() // hide the left menu and user info top of menu
	{
		$obj =& get_instance();
		$obj->template->write('leftColumn',0,true);
	}
	
	public function show_left_menu() // show the left menu and user info top of menu
	{
		$obj =& get_instance();
		$obj->template->write('leftColumn',1,true);
	}
	
	public function hide_top_content() // disk space avalible & average band with area
	{
		$obj =& get_instance();
		$obj->template->write('contentTop',"",true);
	}
	
	public function show_top_content() // disk space avalible & average band with area
	{
		$obj =& get_instance();
		$obj->template->write_view('contentTop','webpowerup/contentTop');
	}

	
}



?>