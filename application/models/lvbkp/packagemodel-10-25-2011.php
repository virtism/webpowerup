<?php
@session_start();
class PackageModel extends CI_Model {
	
	function creat_new_package()
	{
			//echo "<pre>";
			//print_r($_POST);
			//exit;
			
			$new_package_data = array(
				'package_name' => $this->input->post('package_name'),
				'package_description' => $this->input->post('package_description'),
				'package_status' => $this->input->post('package_status'),			
				'package_fixed_price ' => $this->input->post('package_price')					
			);
		
		$package_id = $this->db->insert('packages ', $new_package_data);
		$package_id = $this->db->insert_id();
		
		foreach($_POST["module_id"] as $key => $val)
		{
			 $qry = "INSERT INTO package_module_xref(package_id,module_id) VALUES('".$package_id."','".$val."') ";
			 $query = $this->db->query($qry);
		}
		
		
	}
	
	function get_package_by_id($package_id)
	{
		$qry = "SELECT * FROM packages WHERE package_id = '".$package_id."'";
		$query = $this->db->query($qry);
		return $query->result_array(); 
			
	}
										  
	function package_info_by_user_id($user_id)
	{
		$qry = "SELECT package_id FROM user_packages_xref WHERE user_id = '".$user_id."' ";
		$query = $this->db->query($qry); 
		$packageData = $query->result_array();
		$package_id = $packageData[0]["package_id"];
		
		$package_info = $this->get_package_by_id($package_id);
		return $package_info;
	}
	
	function get_all_package()
	{
		$qry = "SELECT * FROM packages ";
		$query = $this->db->query($qry);
		return $query->result_array(); 
			
	}
	
	function get_all_modules_by_package_id($package_id)
	{
		$qry = "SELECT package_module_xref .*,modules .* FROM package_module_xref,modules WHERE package_module_xref.package_id = '".$package_id."' AND  package_module_xref.module_id = modules .module_id";
		//echo $qry;exit; 
		$query = $this->db->query($qry);
		return $query->result_array();
	}
	
	function do_edit_package()
	{
		
		 $qryUpadte = "UPDATE packages SET package_name = '".$_POST["package_name"]."',package_description = '".$_POST["package_description"]."', package_status = '".$_POST["package_status"]."',package_fixed_price = '".$_POST["package_price"]."' WHERE package_id = '".$_POST["package_id"]."' " ;
		 $this->db->query($qryUpadte);
		 
		 $qry = "DELETE from package_module_xref WHERE package_id = '".$_POST["package_id"]."'";
		 $this->db->query($qry);
		 
		 foreach($_POST["module_id"] as $key => $value)
		 {
				$qry = "INSERT INTO package_module_xref(package_id,module_id) VALUES('".$_POST["package_id"]."','".$value."') ";
			 $query = $this->db->query($qry);
		 }
		 
		 //redirect('PackageController/index');   
         redirect('administrator/packages/index');   
	}
	
	function do_delete_package_by_id($package_id)
	{
		$qry = "UPDATE packages set package_status = 'Deleted' WHERE package_id = '".$package_id."'";
		$this->db->query($qry);
		 //redirect('PackageController/index'); 
         redirect('administrator/packages/index');    
	}
	
	
	function do_login()
	{
		
		$this->db->where('user_login', $this->input->post('user_login'));
		$this->db->where('user_password', $this->input->post('user_password'));
		$query = $this->db->get('users');
		
		if($query->num_rows == 1)
		{
			$userDate = $query->result();
			
			foreach($userDate[0] as $key => $val)
			{
				$userInfo[$key] = $val; 
			}
			
			//echo "<pre>";
			//print_r($userInfo);
			$_SESSION["user_info"] = $userInfo;
			
			 return true; 
			//exit;  
		}
		else
		{
			return false;
		}
		
	}
	function if_user_login_exists()
	{
		$this->db->where('user_login', $this->input->post('user_login'));
		$this->db->where('user_password', $this->input->post('user_password'));
		$query = $this->db->get('users');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function register()
	{
			
		$new_user_data = array(
				'user_fname' => $this->input->post('user_fname'),
				'user_lname' => $this->input->post('user_lname'),
				'user_email' => $this->input->post('user_email'),			
				'user_login' => $this->input->post('user_login'),
				'user_password' => $this->input->post('user_password')						
			);
		
		$user_id = $this->db->insert('users', $new_user_data);
		$user_id = $this->db->insert_id();
																			
		//if(isset($this->input->post('user_role')))
		{
			foreach($this->input->post('user_role') as $key => $val)
			{
				//$this->$db->query("INSERT INTO user_role_xref(user_id,role_id)VALUES('".$user_id."','".$val."')");
				$arrayUserRole = array('user_id' => $user_id,'role_id' => $val);
				$this->db->insert('user_role_xref', $arrayUserRole);
				
			}
		}
				
		return $user_id;
	}
	
	function if_user_email_exists()
	{
		$this->db->where('email',$this->input->post('email'));
		$query = $this->db->get('membership');
		
		if($query->num_rows == 1)
		{
			return true;
		}
	}
	function get_user_by_id()
	{
		//Will return all data of Users
		$query = $this->db->get('users');
		return $query->result(); 
		
	}
	function set_status()
	{
		//Will Update Status Deleted Active Pending etc
	}
	
}
?>
