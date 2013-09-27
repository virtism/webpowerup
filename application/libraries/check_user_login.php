<?php

	class Check_user_login
	{
		var $obj;
		var $area;

		public function __construct()
		{   
			$obj =& get_instance(); 
			// Do something with $params
			$obj->load->database();
			$obj->load->library('session');    
			$obj->load->helper('url');   
			$obj->load->library('form_validation');       
			$obj->load->helper('html'); 
			$obj->load->library('template');
			
		}
		
		function checkLogin()
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
	
}	
?>