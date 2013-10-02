<?php
class System_Modules extends CI_Model{
	//Constructor for this model
	function System_Modules(){
		parent::__construct(); 
		$this->load->database();        
	}
	
	function get_all_modules()
	{
		$qry = "SELECT * FROM modules";

		$query = $this->db->query($qry);
		$modules = $query->result_array(); 	
		
		return $modules;
	}
	
	
}

?>
