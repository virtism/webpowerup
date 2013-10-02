<?php

class templates extends CI_Model {

	function get_all_templates()
	{
		$qry = "SELECT * FROM system_templates WHERE status != 'Deleted'";
		$query = $this->db->query($qry);	
		$templatesArray = $query->result_array();
		return $templatesArray; 
	}
	
	function get_working_template()
	{
		$qry = "SELECT * FROM system_templates 
		WHERE 
		status != 'Deleted'
		AND temp_id IN (7)
		";
		$query = $this->db->query($qry);	
		$templatesArray = $query->result_array();
		return $templatesArray; 
	}
}
?>