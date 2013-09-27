<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Auth
{
	var $obj;
	var $area;
	function __construct()
	{
	
		$obj =& get_instance(); 
		// Do something with $params
		
		$obj->load->database();
		
				
		$obj->load->library('session');    
		$obj->load->helper('url');   		  
		$obj->load->helper('html'); 
		$obj->load->model("SitesModel");
		$obj->load->model("UsersModel");
	}
	
	
	/*
	this function does the logging in.
	*/
	function get_site_admin_by_site_id($site_id)
	{
		$obj =& get_instance(); 
		$result = $obj->SitesModel->get_site_by_id($site_id);
		return $result[0];
		
	}
	
	function get_admin_details_by_id($user_id)
	{
	
		$obj =& get_instance(); 
		$result = $obj->UsersModel->get_user_details_by_user_id($user_id);		
		return $result[0];
		
	}
	
	
	
}