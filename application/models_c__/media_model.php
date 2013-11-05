<?php

class Media_Model extends CI_Model{
	//Constructor
	function Media_Model(){
		parent::__construct();
		$this->load->database();     
	}
	
	//This Function store the image in the DB for User Image Gallery.
	function store_image_to_db($image_name)
	{
		$new_image_data = array(
				'user_id' => $_SESSION["user_info"]["user_id"],
				'image_name' => $image_name
			);
		
		$user_id = $this->db->insert('users_media', $new_image_data);
		$id = $this->db->insert_id();
		
	}
	
	//This function will return the images against the User.
	function get_images_by_user_id($user_id)
	{
		$qry = "SELECT * FROM users_media WHERE user_id = '".$user_id."' ";
		$records = $this->db->query($qry);
		
		if($records)
		{
			$image_gallery = $records->result_array();
			return $image_gallery;
		}
		return false;	
	}     

}
?>
