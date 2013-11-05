<?php

class Access_Model extends CI_Model{

	//Constructor for this model

	function Access_Model(){

		parent::__construct(); 

		$this->load->database();        

		$this->load->helper('date');

	}

	

	function creat_new_access_level()

	{

		//echo "<pre>";

		//print_r($_REQUEST);

		//exit;

		

		$access_type = 'New';

		

		if($_REQUEST["profile_selector"] == "base")

		{

			$access_type = 'Inherited';

		}

		

		$acces_data = array(

						'site_id' => $_SESSION["site_id"],

						'access_name' => $_REQUEST["access_name"],

						'description' => $_REQUEST["description"],

						'access_type' => $access_type,

						'create_date' => now()

						); 	

						

		$access_id = $this->db->insert('access_levels ', $acces_data);

		$access_id = $this->db->insert_id();					

		

//Linking to already existing profile.	

		if($_REQUEST["profile_selector"] == "base")

		{

			$link_2_accees_data = array(

											'access_id' => $access_id,

											'parent_access_id' => $_REQUEST["base_access_id"]

										);

										

			$access_2_access = $this->db->insert('access_2_access_xref ', $link_2_accees_data);

			$access_2_access = $this->db->insert_id();												

		}				

//End		



//New Profile Instertion and linkig to modules and permissions

		if($_REQUEST["profile_selector"] == "advance")

		{

			if(!empty($_REQUEST["module_id"]) && is_array($_REQUEST["module_id"]) && (count($_REQUEST["module_id"] > 0) ))

			{

				foreach($_REQUEST["module_id"] as $key => $val)

				{

					$mod_id = $val;

					$qry = "INSERT INTO access_levels_modules_xref(module_id,access_id) VALUES('".$mod_id."','".$access_id."')";

					$this->db->query($qry);

					

					if(is_array($_REQUEST["permissions"]) && (count($_REQUEST["permissions"][$mod_id] > 0)))

					{

						foreach($_REQUEST["permissions"][$mod_id] as $key_p => $val_p)

						{

							$qry_p = "INSERT INTO access_modules_permission_xref(module_id,permission_id,access_id) VALUES('".$mod_id."','".$val_p."','".$access_id."')";

							$this->db->query($qry_p);	

						}

					}

				}

			}

							

		}

		

		return true;	

	} 

//This function will get all the access levels against the site ID 

	function get_all_access_levels_by_site_id($site_id)

	{

		$qry = "SELECT * FROM access_levels WHERE site_id = '".$site_id."' AND is_deleted = '0'";

		$result = $this->db->query($qry);

		return $result->result_array(); 

	}	

//END



	function soft_del_access_level($access_id)

	{

		$qry = "UPDATE access_levels SET is_deleted = '1' WHERE id = '".$access_id."'";

		$result = $this->db->query($qry);

		

		if($result)

		{

			return true;

		}

		return false;

	}	

}

?>