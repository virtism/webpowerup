<?php
@session_start();
class Footer_Model extends CI_Model{
	//Constructor for this model
   // var $site_id;  
   // var $user_id;
	function Menus_Model(){
		parent::__construct(); 
		$this->load->database();        
	}
	
	
	//function create_footer($site_id)
	function update_footer_content($content,$site_id)
	{
		$rows = array();
		$this->db->where('site_id',intval($site_id));
		$query = $this->db->get('page_footer');
		if($query->num_rows() > 0)
		{
			 $qry = "UPDATE page_footer SET  content = ".$this->db->escape($content)." WHERE site_id = ".intval($site_id);
	   		 $records = $this->db->query($qry);
			 if($records)
			 {
				  return true;
			 }
			 else
			 {
				 return false; 
			 }
		}
		else
		{
			$qry = "INSERT INTO page_footer (site_id, content) VALUES (".intval($site_id).",".$this->db->escape($content).")";
			$this->db->query($qry);    
			return true;         
		}       
	}

	function get_footer_content ($site_id)
	{
			 //echo '<pre>';  print_r($site_id); echo 'I am here ';  echo '</pre>'; exit();
			$footer_content = "";
			$rows = array();
			$this->db->where('site_id',intval($site_id));
			$query = $this->db->get('page_footer');
			if ($query->num_rows() > 0){
			   $row = $query->result_array(); 
			   $footer_content = $row[0];
			 }
			 return $footer_content;
	}
	
   /*function update_footer_content($content,$site_id)
	{
	   
	   
	   $qry = "UPDATE page_footer SET  content = ".$this->db->escape($content)." WHERE site_id = ".intval($site_id);
	   $records = $this->db->query($qry);
	   if($records){
		  return true;
	   }
	   else{
		 return false; 
	   }
	}   */
}
?>