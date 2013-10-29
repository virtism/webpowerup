<?php
class Webinar_Model extends CI_Model{
	
	//Constructor for this model
	function Webinar_Model(){
		parent::__construct(); 
		$this->load->database();        
		$this->load->helper('date');
	}
	
	function creat_new_webinar($site_id)
	{
		/*echo "<pre>";
		print_r($_REQUEST);
		exit;*/
		$this->$site_id = $site_id;
		$groupids = '';
		$current_time = date("Y-m-d H:i:s", time());  
		if(isset($_REQUEST["group_access"]))
		{
			$groupids = $_REQUEST["group_access"]; 
		}
		
		//Dynamic feilds
		$items = $_REQUEST["items"];
		
		//default_formfeilds
		$default_form_fields = $_REQUEST["default_items"];
		
		$webinar_data = array(
							'site_id' => $site_id,
							'title' => $_REQUEST["title"],
							'email_to' => $_REQUEST["email_to"],
							'webinar_access' => $_REQUEST["webinar_access"],
							'create_date' => $current_time,
							'start_date' =>$_REQUEST["start_time"],
							'start_time' =>$_REQUEST["webinar_date"],
							'form_intro' => $_REQUEST["ck_content"],
							'form_thank_u' => $_REQUEST["ck_content_2"] 
							
							);
							
		$webinar = $this->db->insert('webinar', $webinar_data);
		$webinar_id = $this->db->insert_id();	
		
		//Webinar Access Level Management
		if($_REQUEST["webinar_access"]== "Other")
		{
			if(isset($_REQUEST["group_access"]) && (count($_REQUEST["group_access"]) > 0))
			{
				foreach($_REQUEST["group_access"] as $key => $val)
				{
					$items_data = array ($webinar_id,$val,$site_id); 
					$query = "INSERT INTO access_levels_webinar_groups_xref(webinar_id,group_id,site_id) VALUES (?,?,?)";
					$this->db->query($query,$items_data);
				}	
			}
		}
		
		
		// adding dynamic manues  
		foreach($items as $key => $item)
		{   //  is_array($items)
			
			$title = $item['title'];
			$type = $item['type'];
			$required = '';
			$is_default = 0;
		   
			if (array_key_exists('required', $item))
			{
				$required = 'Yes';
			}else
			{
			   $required = 'No';
			}
			
			$order = $item['order'];
		
			if(!$item['order'])
			{
				$order = '0'; 
			}
		
			$name ="field_".rand(0,9);
			$new_item = array ($webinar_id,$title,$name,$type,$required,$order,$is_default ); 
		  
			$query = "INSERT INTO webinar_fields(webinar_id,field_title,field_name,field_type,field_required,field_sequence,is_default) VALUES (?,?,?,?,?,?,?)";
			$this->db->query($query,$new_item ); 
				 
		}
		// adding default fields  
		foreach($default_form_fields as $key => $item)
		{   //  is_array($items)
			
			$title = $item['title'];
			$type = $item['type'];
		   
			$required = '';
			$is_default = 1;
		   
			if (array_key_exists('required', $item))
			{
				$required = 'Yes';
			}else
			{
			   $required = 'No';
			}
			
			$order = $item['order'];
		
			if(!$item['order'])
			{
				$order = '0'; 
			}
			
			$deleted = 0; 
			
			if(!$item['active'])
			{
				$deleted = 1;
			}
		
			$name ="field_".rand(0,9);
			$new_item = array ($webinar_id,$title,$name,$type,$required,$order,$deleted,$is_default ); 
		  
			$query = "INSERT INTO webinar_fields(webinar_id,field_title,field_name,field_type,field_required,field_sequence,field_delete,is_default) VALUES (?,?,?,?,?,?,?,?)";
			$this->db->query($query,$new_item ); 
				 
		}
		
		// Webinar To menu Linking
		
		if(isset($_REQUEST["menu_id"]) && (count($_REQUEST["menu_id"]) > 0 ))
		{
			foreach($_REQUEST["menu_id"] as $key => $val)
			{
				$items = array ($webinar_id,$val,$site_id); 
			  	$query = "INSERT INTO webinar_menus_xref(webinar_id,menu_id,site_id) VALUES (?,?,?)";
				$this->db->query($query,$items); 
			}	
		}
		//END
		
		
		
		
		//add new customers
		$new_customers_id = array();
		if(isset($_REQUEST['non_group']) && !empty($_REQUEST['non_group']))
		{
			$new_users = explode(',', $_REQUEST['non_group']);
			foreach($new_users as $users)
			{
				$Q = $this->db->query("SELECT * FROM  `ec_customers` WHERE  `customer_email` ='".trim($users)."' AND  `site_id` =".trim($site_id));
				 if ($Q->num_rows() == 0)
				 {
						$data = array(
							'site_id' => trim($site_id),
							'customer_login' => trim($users),
							'customer_email' => trim($users),
							'membershipid' => 0,
							'customer_password' => rand (80000000,99999999)
							);
							$this->db->insert('ec_customers',$data);
							$this->customer_id = $this->db->insert_id();
							$data_xref = array(
							'customer_id' => trim($this->customer_id),
							'site_id' => trim($site_id)
							);
							$this->db->insert('ec_customers_site_xref',$data_xref);
							$new_customers_id[] =  $this->customer_id;     	
				}
			}
		}
		
	
		//Send mail to webinar users
		
		$this->send_mail_attendee($webinar_id, $_REQUEST["title"], $_REQUEST["ck_content"],$_REQUEST["start_time"], $_REQUEST["webinar_date"], $groupids,  $_REQUEST["webinar_access"], $site_id, $new_customers_id);
		
		return $webinar_id ;	
	}
	
	
	function get_user_by_group_id($id=0)
	{
			$rows = array();
			$gruop_id = 0;
			$this->db->select('customer_id,customer_email,customer_fname,customer_lname');
			$this->db->where('membershipid',intval($id));
			$query = $this->db->get('ec_customers');
		  	return $query->result_array(); 
	}
	
	
	 function get_all_customer_by_site_id($id, $all_user=0){
	  $data = array();
	  
	  if(isset($all_user) && $all_user == 1)
	  {
	  	$Q = $this->db->query('SELECT * FROM  `ec_customers` WHERE  `site_id` ='.$id);
	  }
	  else if(isset($all_user) && $all_user != 1 && $all_user != 0)
	  {
	 	 $Q = $this->db->query('SELECT * FROM  `ec_customers` WHERE  `customer_id` ='.$id. ' AND  `site_id` ='.$all_user);
	  }
	  else
	  {
	  	$Q = $this->db->query('SELECT * FROM  `ec_customers` WHERE  `site_id` ='.$id.' AND  `membershipid` =0');
	  }
	  
	  if ($Q->num_rows() > 0){
		$data = $Q->result_array();
	  }
	/*echo "<pre>";
	print_r($data);
	exit;*/
	  return $data;
	}
	//Send email function
	function send_mail_attendee($webinar_id, $title, $content, $start_time, $start_date, $group_ids='', $webinar_access, $site_id, $new_customers_id)
		{
				
			//common data
			$message = "<table width='600' border='0'><tr><td>Webinar Title: </td><td>".$title."</td></tr><tr><td>Start Date & Time:</td><td>".$start_date." & ".$start_time."</td></tr><tr><td>Message</td><td>".$content."</td></tr></table>";
			$subject = $title;
			$body = $message;
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);	
			//echo "<pre>";
			$all_customer = array();
			
			
			
			//Group users	
			if(isset($webinar_access) && $webinar_access == 'Other')
			{		
			
						foreach($group_ids as $gid)
						{
							$customer_rec = $this->get_user_by_group_id($gid);
							//print_r($customer_rec);
							for($i = 0; $i<count($customer_rec); $i++)
							{
								if(empty($customer_rec[$i]['customer_fname']))
								{
									$dear = "<b>Webinar Invitation Please Join!</b><br>";
								}
								else
								{
									$dear = "Dear <b>".$customer_rec[$i]['customer_fname']." ".$customer_rec[$i]['customer_lname']."!</b><br>";
								}
								$body = $dear.$message."<br/><a href='http://www.webpowerup.ca/broadcast/GWSWhiteboard.html#webinarID=".$webinar_id."&attendee_id=".$customer_rec[$i]['customer_id']."'>Join Meeting</a>";
								$all_customer[] = $customer_rec[$i]['customer_id'];
								$this->email->from('join_meeting@webpowerup.ca', 'Global Online Website Solutions');
								$this->email->subject($subject);
								$this->email->message($body);
								$this->email->to($customer_rec[$i]['customer_email']);
								$send = $this->email->send();
								$body = '';
							}
						}
						
			}
			else if(isset($webinar_access) && $webinar_access == 'Registered')
			{
				//echo "<pre>";
				$customer_rec = $this->get_all_customer_by_site_id($site_id);
				//print_r($customer_rec);
				//exit;
				for($i = 0; $i<count($customer_rec); $i++)
				{
					if(empty($customer_rec[$i]['customer_fname']))
						{
							$dear = "<b>Webinar Invitation Please Join!</b><br>";
						}
						else
						{
							$dear = "Dear <b>".$customer_rec[$i]['customer_fname']." ".$customer_rec[$i]['customer_lname']."!</b><br>";
						}
					$body = $dear.$message."<br/><a href='http://www.webpowerup.ca/broadcast/GWSWhiteboard.html#webinarID=".$webinar_id."&attendee_id=".$customer_rec[$i]['customer_id']."'>Join Meeting</a>";
					$all_customer[] = $customer_rec[$i]['customer_id'];
					$this->email->from('join_meeting@webpowerup.ca', 'Global Online Website Solutions');
					$this->email->subject($subject);
					$this->email->message($body);
					$this->email->to($customer_rec[$i]['customer_email']);
					$send = $this->email->send();
					$body = '';
					
				}
			}
			else if(isset($webinar_access) && $webinar_access == 'Everyone')
			{
				
				$customer_rec = $this->get_all_customer_by_site_id($site_id, '1');
				/*echo "<pre>";
				print_r($customer_rec);
				exit;*/
				for($i = 0; $i<count($customer_rec); $i++)
				{
					if (!in_array($customer_rec[$i]['customer_id'], $new_customers_id)) 
					{
					
						if(empty($customer_rec[$i]['customer_fname']))
						{
							$dear = "<b>Webinar Invitation Please Join!</b><br>";
						}
						else
						{
							$dear = "Dear <b>".$customer_rec[$i]['customer_fname']." ".$customer_rec[$i]['customer_lname']."!</b><br>";
						}
						$body = $dear.$message."<br/><a href='http://www.webpowerup.ca/broadcast/GWSWhiteboard.html#webinarID=".$webinar_id."&attendee_id=".$customer_rec[$i]['customer_id']."'>Join Meeting</a>";
						$all_customer[] = $customer_rec[$i]['customer_id'];
						$this->email->from('join_meeting@webpowerup.ca', 'Global Online Website Solutions');
						$this->email->subject($subject);
						$this->email->message($body);
						$this->email->to($customer_rec[$i]['customer_email']);
						$send = $this->email->send();
						$body = '';
					}
					
				}
			
			}
			if(!empty($new_customers_id))
			{
				for($i = 0; $i<count($new_customers_id); $i++)
				{
					
					$customer_rec = $this->get_all_customer_by_site_id($new_customers_id[$i], $site_id);
					//print_r($new_customers_id);exit;
					/*echo '<pre>';
					print_r($customer_rec);
					exit;*/
					//$dear = "Dear <b>".$customer_rec[$i]['customer_fname']." ".$customer_rec[$i]['customer_lname']."!</b><br>";
					$dear = "<b>Webinar Invitation Please Join!</b><br><table><tr><td>Username: </td><td>".$customer_rec[$i]['customer_email']."</td></tr><tr><td>Password: </td><td>".$customer_rec[$i]['customer_password']."</td></tr></table>";
					$body = $dear.$message."<br/><a href='http://www.webpowerup.ca/broadcast/broadcast/GWSWhiteboard.html#webinarID=".$webinar_id."&attendee_id=".$customer_rec[$i]['customer_id']."'>Join Meeting</a>";
					$all_customer[] = $customer_rec[$i]['customer_id'];
					$this->email->from('join_meeting@webpowerup.ca', 'Global Online Website Solutions');
					$this->email->subject($subject);
					$this->email->message($body);
					$this->email->to($customer_rec[$i]['customer_email']);
					$send = $this->email->send();
					$body = '';
					
				}
			}
			
			$save_ids = implode(',',$all_customer);
			$data = array('attendee_id' =>$save_ids);
			$this->db->where('id', $webinar_id);
			$this->db->update('webinar', $data); 			
			//print_r($all_customer);
			//exit;			
			
			return true;
		
		
		}
		
	//get Webinar data for site 
	function get_webinar_form_data($webinar_id)
	{
		$query_string = "SELECT * FROM webinar WHERE id = '".$webinar_id."' ";
		$items = $this->db->query($query_string);
		$row = $items->row_array();  // values by array

		return $row; 

	}
	
	//Webinar Form Feilds
	/*
	-- Method 
	-- => Default : Will fetch all defualt feilds
	-- => Custom will fetch all Custom field
	
	*/
	function webinar_form_fields($webinar_id,$method)
	{
		
		if($method == "default")
		{
			$query_string = "SELECT * FROM webinar_fields WHERE webinar_id = $webinar_id  AND field_delete ='0' AND is_default = '1' order by field_sequence ASC";		
		}
		else
		{
			$query_string = "SELECT * FROM webinar_fields WHERE webinar_id = $webinar_id  AND field_delete ='0' AND is_default = '0' order by field_sequence ASC";			
		}
		//echo $query_string;exit; 
		
		 $dataset = $this->db->query($query_string);
		 
		 
		  if($dataset->num_rows() > 0) {
			$output = array();
			$index = 0;
			foreach($dataset->result() as $items)
			{
			
			//echo $items["id"] ;exit;
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;
				//echo "<pre>";	print_r($items); 
				//echo $items->id;
			//	exit;

			   if ($items->field_type == 'Check Boxes'){
					$output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >';
					$output[$index]['label'] =  $items->field_title;
					$output[$index]['field'] =  '<input id="check" type="checkbox" name="field['.$index.'][value]" >';
					$output[$index]['required'] =  $items->field_required; 
				   
				   
			   }else if($items->field_type == 'Radio Buttons'){
					$output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >';  
					$output[$index]['label'] =  $items->field_title;
					$output[$index]['field'] =  '<input id="" type="radio" value="" name="field['.$index.'][value]" >';
					$output[$index]['required'] =  $items->field_required;    
				   
			   }else if($items->field_type == 'Single-Line Text' ) {
					$output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >'; 
					$output[$index]['label'] =  $items->field_title;
					$output[$index]['field'] =  '<input type="text" id="" value="" name="field['.$index.'][value]">'; 
					$output[$index]['required'] =  $items->field_required; 
				   
			   }else if ($items->field_type == 'Multi-Line Text'){
					$output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >'; 
					$output[$index]['label'] =  $items->field_title;
					$output[$index]['field'] =  '<textarea id="" name="field['.$index.'][value]" title="'.$items->field_title.'"></textarea>';   
					$output[$index]['required'] =  $items->field_required;
			   }
			   $index++;          
			}
			//exit;
		return $output;
		}   
		
	}
	
	//Get All Webinar Agains Site
	function get_all_webinars($site_id)
	{
		$qry = "SELECT * FROM webinar WHERE site_id = '".$site_id."' AND is_deleted = '0'";
		$result = $this->db->query($qry);
		return $result->result_array(); 
	}
	
	//Delete Webinar
	function soft_delete_webinar($webinar_id)
	{
		$qry = "UPDATE webinar SET is_deleted = '1' WHERE id = '".$webinar_id."'";
		$result = $this->db->query($qry);
		//return $result->result_array(); 
		return true;
	}
	
	//Webinar Edit Case Data Pull
	
	function get_webinar_data($webinar_id)
	{
		$qry = "SELECT * FROM webinar WHERE id = '".$webinar_id."' AND is_deleted = '0'";
		$result = $this->db->query($qry);
		$data = $result->result_array();
			
		for($i=0; $i<count($data);$i++)
		{
			
			if($data[$i]["webinar_access"] == "Other")
			{
				$groups_array = $this->get_groups_info($data[$i]["id"]);
				$data[$i]["groups_info"] = $groups_array;
			}
			
			//Get Menus Information for Webinar
			$menus_array = $this->get_menus_info($data[$i]["id"]);
			$data[$i]["menus_info"] = $menus_array;
			
			
			//Webinar Default Feilds Info 
			$default_field_array = $this->get_webinar_feilds_info($data[$i]["id"],'Default');
			$data[$i]["defualt_fields_info"] = $default_field_array;
			
			//Webinar Default Feilds Info 
			$custom_field_array = $this->get_webinar_feilds_info($data[$i]["id"],'Custome');
			$data[$i]["custom_fields_info"] = $custom_field_array;
			
			
		}
		
		return $data; 
	}
	
	//Webinar Feilds Information Assigned to Webinar
	
	function get_webinar_feilds_info($webinar_id,$type = "Default")
	{
		if($type == "Default")
		{
			$qry = "SELECT 
						wf.* 
					FROM 
						webinar_fields wf
					WHERE 
						wf.webinar_id = '".$webinar_id."'
					AND	
						wf.is_default = '1'
					AND 
						wf.field_delete = '0'	
					";
		}
		else
		{
			$qry = "SELECT 
						wf.* 
					FROM 
						webinar_fields wf
					WHERE 
						wf.webinar_id = '".$webinar_id."'
					AND	
						wf.is_default = '0'
					AND 
						wf.field_delete = '0'	
					";
		}			
		
		//echo $qry;exit;			
		$result = $this->db->query($qry);
		$data = $result->result_array();
		//echo "<pre>";
		//print_r($data);
		//exit;
		return $data; 
	}
	
	//Get Assigned Menus for this Webinar
	function get_menus_info($webinar_id)
	{
		$qry = "SELECT 
					mn.* 
				FROM 
					menus mn ,webinar_menus_xref access_levels
				WHERE 
					mn.menu_id = access_levels.menu_id
				AND	
					access_levels.webinar_id = '".$webinar_id."'
				";
					
		$result = $this->db->query($qry);
		$data = $result->result_array();
		return $data; 
			
	}
	
	//Get Assigned Groups for This Webinar
	function get_groups_info($webinar_id)
	{
		$qry = "SELECT 
					gp.* 
				FROM 
					groups gp ,access_levels_webinar_groups_xref access_levels
				WHERE 
					gp.id = access_levels.group_id
				AND	
					access_levels.webinar_id = '".$webinar_id."'
				";
					
		$result = $this->db->query($qry);
		$data = $result->result_array();
		return $data; 
	}
	
	function do_edit_webinar($webinar_id)
	{
		$site_id = $_SESSION["site_id"]; 
		//echo "<pre>";
		//print_r($_REQUEST);
		//exit;
		$current_time = date("Y-m-d H:i:s", time());
		
		$webinar_data = array(
						'title' => $_POST["title"],
						'email_to' => $_POST["email_to"],
						'webinar_access' => $_POST["webinar_access"],
						'modified_date' => $current_time,
						'form_intro' => $_POST["ck_content"],
						'form_thank_u' => $_POST["ck_content_2"] 
						
						);
							
		$webinar = $this->db->update('webinar', $webinar_data,  array('id' => $webinar_id));
		if($webinar)
		{
			
			//Access Level Updation
			if($_POST["webinar_access"] == "Other")
			{
				//Delete Old References
				$this->delete_access_levels($webinar_id);
				
				if(isset($_REQUEST["group_access"]) && (count($_REQUEST["group_access"]) > 0))
				{
					foreach($_REQUEST["group_access"] as $key => $val)
					{
						$items_data = array ($webinar_id,$val,$site_id); 
						$query = "INSERT INTO access_levels_webinar_groups_xref(webinar_id,group_id,site_id) VALUES (?,?,?)";
						$this->db->query($query,$items_data);
					}	
				}
				
				
			}
			
			//Menu Updation Deleteting old refernces
			$this->delete_menus($webinar_id);
			
			// Webinar To menu Linking
		    if(isset($_REQUEST["menu_id"]) && (count($_REQUEST["menu_id"]) > 0 ))
			{
				foreach($_REQUEST["menu_id"] as $key => $val)
				{
					$items = array ($webinar_id,$val,$site_id); 
					$query = "INSERT INTO webinar_menus_xref(webinar_id,menu_id,site_id) VALUES (?,?,?)";
					$this->db->query($query,$items); 
				}	
			}
			//END
			
			// Updating dynamic manues
			//Delete old References
			$this->delete_dynamic_fields($webinar_id);
			
			$items = $_REQUEST["items"];
			  
			foreach($items as $key => $item)
			{   //  is_array($items)
				
				$title = $item['title'];
				$type = $item['type'];
				$required = '';
				$is_default = 0;
			   
				if (array_key_exists('required', $item))
				{
					$required = 'Yes';
				}else
				{
				   $required = 'No';
				}
				
				$order = $item['order'];
			
				if(!$item['order'])
				{
					$order = '0'; 
				}
			
				$name ="field_".rand(0,9);
				$new_item = array ($webinar_id,$title,$name,$type,$required,$order,$is_default ); 
			  
				$query = "INSERT INTO webinar_fields(webinar_id,field_title,field_name,field_type,field_required,field_sequence,is_default) VALUES (?,?,?,?,?,?,?)";
				$this->db->query($query,$new_item ); 
					 
			}
			
		
			//default_formfeilds
			$default_form_fields = $_REQUEST["default_items"];
			foreach($default_form_fields as $key => $item)
			{   //  is_array($items)
				
				$title = $item['title'];
				$type = $item['type'];
			   
				$required = '';
				$is_default = 1;
			   
				if (array_key_exists('required', $item))
				{
					$required = 'Yes';
				}else
				{
				   $required = 'No';
				}
				
				$order = $item['order'];
			
				if(!$item['order'])
				{
					$order = '0'; 
				}
				
				$deleted = 0; 
				
				if(!$item['active'])
				{
					$deleted = 1;
				}
			
				$name ="field_".rand(0,9);
				$new_item = array ($webinar_id,$title,$name,$type,$required,$order,$deleted,$is_default ); 
			  
				$query = "INSERT INTO webinar_fields(webinar_id,field_title,field_name,field_type,field_required,field_sequence,field_delete,is_default) VALUES (?,?,?,?,?,?,?,?)";
				$this->db->query($query,$new_item ); 
					 
			}
		
		
			 
			
			
			return true;
		}
		
	}
	
	//Get Webinars by Menu ID
	/*function get_all_webinars_by($menu_id)
	{
		
	}*/
	
	
	//Deletion of Access levels for Edit Case
	private function delete_access_levels($webinar_id)
	{
		$qry = "DELETE FROM access_levels_webinar_groups_xref WHERE webinar_id = '".$webinar_id."'";
		$result = $this->db->query($qry);
		return true;
	} 
	
	//Deletion of Menus for Edit Case
	private function delete_menus($webinar_id)
	{
		$qry = "DELETE FROM webinar_menus_xref WHERE webinar_id = '".$webinar_id."'";
		$result = $this->db->query($qry);
		return true;
	}
	
	//
	private function delete_dynamic_fields($webinar_id)
	{
		$qry = "DELETE FROM webinar_fields WHERE webinar_id = '".$webinar_id."'";
		$result = $this->db->query($qry);
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
	
  
  //===== individual site  Access levels ======//
  //===== by : mudassar ali      ===== //
	
   function promotional_box_access($user_id=0, $site_id=0, $page_id=0)
   {
		 $this->user_id = $user_id;
		 $this->page_id = $page_id;
		 $this->site_id = $site_id;
		 
		 
	   
	   
	   
   } 
   
   function get_user_gruop($user_id=0)
   {
			$return_value  = array();
			$this->db->select('customer_id,membershipid,group_code');
		   // $this->db->where('user_id',intval($id));
		   // $Q = $this->db->get('user_packages_xref');
			$query = $this->db->get_where('ec_customers', array('customer_id' => intval($user_id)));  
			$Data = $query->result_array();
		   // print_r($Data[0]["required"]); exit();  
			if(array_key_exists(0,$Data)){
				  $return_value['membershipid'] = $Data[0]['membershipid'];
				  $return_value['group_code'] = $Data[0]['group_code'];
			}
			else
			{
					return false;   
			}
	   
   }
   
   function add_customer_by_webinar($site_id='')
	{
		$new_users = explode(',', $_REQUEST['non_group']);
		foreach($new_users as $users)
		{
			$data = array(
						'site_id' => trim($site_id),
						'customer_login' => trim($new_users),
						'customer_email' => trim($new_users),
						'membershipid' => 0,
						'customer_password' => rand (80000000,99999999)
						);
		 	$this->db->insert('ec_customers',$data);
		  	$this->customer_id = $this->db->insert_id();
			$data_xref = array(
						'customer_id' => trim($this->customer_id),
						'site_id' => trim($site_id)
						);
			$this->db->insert('ec_customers_site_xref',$data_xref);
			return $this->customer_id;     
		}
		
		
	}
}
?>