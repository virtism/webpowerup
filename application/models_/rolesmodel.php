<?php

class RolesModel extends CI_Model {

	function is_already_exist()
	{
		$this->db->where('role_name', $this->input->post('role_name'));
		$query = $this->db->get('roles');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function creat_role()
	{
		
		$new_role_data = array(
						'role_name' => $this->input->post('permission_name'),
						'role_description' => $this->input->post('role_description'),
					);
		
		$insert = $this->db->insert('roles', $new_permission_data);
		return $insert;
	}
	
	function get_role_by_id($id)
	{
		$this->db->where('role_id', $id);    
		$query = $this->db->get('roles');
		return $query->result(); 
		
	}
	function get_user_roles_by_user_id($id)
	{
		$qry = "SELECT urx.*,r.* FROM user_role_xref urx,roles r WHERE urx.user_id = '".$id."' AND urx.role_id = r.role_id ";

		$query = $this->db->query($qry);
		$roles = $query->result_array(); 
		return $roles; 
		
	}
	function get_all_roles()
	{
		$query = $this->db->get('roles');
		
		$allRoles = $query->result_array();
		return $allRoles; 
	}

}
?>