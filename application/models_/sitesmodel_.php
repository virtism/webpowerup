<?php

class SitesModel extends CI_Model {
	
		function SitesModel(){
		parent::__construct(); 
		$this->load->database();
		$this->load->database('Menus_Model');        
	}
	

	function creat_new_site()
	{
		if(isset($_SESSION["user_info"]["user_id"]))
		{
			//echo "<pre>";
			//print_r($_POST);
			//exit;
			
			$insertSiteArray = array(
					'user_id' => $_SESSION["user_info"]["user_id"],
					'package_id' => $_POST["package_id"],
					'site_name' => $_POST["site_name"],
					'site_url' => $_POST["site_url"],
					'site_description' => $_POST["site_description"],
					'site_status' => $_POST["site_status"],
					'site_create_date' => date('Y-m-d h:i:s')
					);
			/*echo "<pre>";
			print_r($insertSiteArray);
			exit;*/
			
			$insert = $this->db->insert('sites', $insertSiteArray);
			$site_id = $this->db->insert_id(); 	
			
			return $site_id;
			
		}
		
	}
	
	function get_all_sites_by_user($user_id)
	{
		$qry = "SELECT * FROM sites WHERE site_status != 'Deleted' AND user_id = '".$user_id."'";
		
		$query = $this->db->query($qry);
		$sitesArray = $query->result_array();
		return $sitesArray;
	}

	
	function get_all_sites()
	{
		$qry = "SELECT * FROM sites WHERE site_status != 'Deleted'";
		$query = $this->db->query($qry);	
		$sitesArray = $query->result_array();
		return $sitesArray; 
	}
	
	// method to get all sites of specific users 
	function get_all_sites_spec($user_id)
	{
		$qry = "SELECT * FROM sites WHERE user_id = $user_id AND site_status != 'Deleted'";
		$query = $this->db->query($qry);    
		$sitesArray = $query->result_array();
		return $sitesArray; 
	}
	
	function get_site_by_id($site_id)
	{
		$qry = "SELECT * FROM sites WHERE site_id = '".$site_id."'";
		$query = $this->db->query($qry);	
		$sitesArray = $query->result_array();
		return $sitesArray;	
	}
	
	function is_already_exist()
	{
		$this->db->where('role_name', $this->input->post('role_name'));
		$query = $this->db->get('roles');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function creat_page()
	{
			 //echo "asas";
		$insertPageArray = array(
					'site_id' => '1',
					'page_title' => $_POST["page_title"],
					'page_seo_url' => $_POST["page_seo_url"],
					'page_code' => $_POST["page_code"],
					'page_seo_url' => $_POST["page_seo_url"],
					'page_create_date' => "NOW()",
					'page_seo_url' => $_POST["page_seo_url"]
					);
		
		$insert = $this->db->insert('pages', $insertPageArray);
		$page_id = $this->db->insert_id(); 
		
		$insertContentArray = array(
																'page_id' => $page_id,
																'page_content' => mysql_escape_string($_POST["page_content"])
																);
		$insert2 = $this->db->insert('page_content', $insertContentArray);
																
			 
		 
		return $insert;
	}
	
	function get_role_by_id($id)
	{
		$this->db->where('role_id', $id);    
		$query = $this->db->get('roles');
		return $query->result(); 
		
	}
	function get_page_data_by_id($id)
	{
		$qry = "SELECT * FROM pages p,page_content pc WHERE p.page_id = '".$id."' AND p.page_id = pc.page_id ";

		$query = $this->db->query($qry);
		$page_data = $query->result_array(); 
		return $page_data; 
		
	}
	function get_all_pages()
	{
		$query = $this->db->get('pages');
		
		$allPages = $query->result_array();
		return $allPages; 
	}
	
	// method to get pakage id by user id 
	function get_pakage_id_by_user_id($user_id)
	{
		$qry = "SELECT package_id FROM user_packages_xref WHERE user_id = '".$user_id."'";
		$query = $this->db->query($qry);    
		$pkgArray = $query->result_array();
		
		return $pkgArray[0]['package_id'];      
		
	}
	
	
   // save site info through sign up wizard  
	function creat_new_site_by_signup($get_value,$user_id)
	{  
			$insertSiteArray = array(
					'user_id' => $user_id,
					'package_id' => $get_value["package"],
				 //   'site_name' => $get_value["site_name"],
				 //   'site_url' => $get_value["site_url"],
				 //   'site_description' => $get_value["site_description"],
				 //   'site_status' => $get_value["site_status"],
					'site_create_date' => date('Y-m-d h:i:s'),
					'site_name' => $get_value["site_title"],
					'site_type' => $get_value["type_of_site"],
					'site_category' => $get_value["site_category"],
					'site_url' => $get_value["site_domain"]
					);
		
			$insert = $this->db->insert('sites', $insertSiteArray);
			$site_id = $this->db->insert_id();     
			
			
			
			$template_array_data = array (
						'site_id' =>  $site_id,
						'temp_id' => $get_value["template_select"] 
						);
			
				$this->db->insert('sites_templates_xref',$template_array_data)  ;
		   
		   $package_id = $this->Menus_Model->get_user_package($user_id);
		   if($package_id == '3')
		   {
			  $store_setting_data = array (
						'site_id' =>  $site_id
						
						);
			
				$this->db->insert('site_store_settings',$store_setting_data)  ;
			}
				
			 return $site_id;   
			 //return true;
			
	}
	
	// method to check domain name already exist
	  function  domain_exists ($domain)
	{
	   $query_string = "SELECT site_url FROM sites where site_url = ?"; 
	   $result = $this->db->query($query_string,$domain);
	   if ($result->num_rows() > 0){
		   // true
		   return true;
	   }else{
		   // false
		   return false;
	   }
		
	}
   // This function is used to delete the site from listing only      
	function do_soft_delete($site_id)
	{
		$qry = "UPDATE sites SET site_status = 'Deleted' WHERE site_id = '".$site_id."'";
		$this->db->query($qry);
		return true;
				
	}

}
?>