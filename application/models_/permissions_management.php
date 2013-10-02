<?php

class Permissions_Management extends CI_Model {

	function is_already_exist()
	{
		$this->db->where('permission_name', $this->input->post('permission_name'));
		$query = $this->db->get('permissions');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function creat_permission()
	{
		
		$new_permission_data = array(
						'permission_name' => $this->input->post('permission_name'),
						'permission_description' => $this->input->post('permission_description'),
					);
		
		$insert = $this->db->insert('permissions', $new_permission_data);
		return $insert;
	}
	
	function get_permission_by_id($id)
	{
		//Will return all data of Users
		
		$this->db->where('permission_id', $id);    
		$query = $this->db->get('permissions');
		return $query->result(); 
		
	}
	function get_all_permissions()
	{
		$query = $this->db->get('permissions');
		return $query->result(); 
	}
	
}
?>