<?php
class Groups_Model extends CI_Model{
	//Constructor for this model
	function Groups_Model(){
		parent::__construct(); 
		$this->load->database();
	}
	
	private function get_permission_id_by_value($value)
	{
		$qry = "SELECT id FROM groups_permission WHERE value = '".$value."'";
		$result = $this->db->query($qry);
		$data = $result->result_array();
		return $data[0]["id"];	
	}
	
	function get_group_by_id($group_id)
	{
		$qry = "SELECT * FROM groups WHERE id =".$group_id." AND is_deleted = 'No' AND is_disabled = 'No'";
		$result = $this->db->query($qry);
		return $result->result_array();
	}
	
	function get_all_site_gropus_suctomer_view($site_id)
	{
		$qry = "SELECT gp.id,gp.group_name FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' ";
		$result = $this->db->query($qry);
		return $result->result_array();
	}
	function get_all_site_gropus_customer_view_by_group_type($site_id,$group_type)
	{
		
		$qry = "SELECT gp.id, gp.group_code,gp.group_name FROM groups gp,groups_sites_xref gpref WHERE  gp.id = gpref.group_id AND group_type = '$group_type' AND gpref.site_id = '".$site_id."'";
		
		$result = $this->db->query($qry);
		return $result->result_array();
	}
	
	function get_group_members_count($group_id)
	{
		$int_count = array();
		$c = $this->db->query("SELECT COUNT( group_id ) as count FROM  `ec_customers_group_xref` WHERE group_id = ".$group_id);
		$int_count = $c->result_array();
		
		//echo "<pre>";
		//print_r($int_count);
		
		if(count($int_count > 0))
		{
			return $int_count[0]["count"];
		}
		else
		{
			return 0;
		}
		return false;
	}
	
	
	
	function get_all_site_gropus_user_count($site_id)
	{
		$count = '';
		$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' ";
		$result = $this->db->query($qry);
		$records = $result->result_array();
		$count = array();
		if(isset($records))
		{
			foreach($records as $record)
			{
				$c = $this->db->query("SELECT COUNT( membershipid ) FROM  `ec_customers` WHERE membershipid = ".$record['id']);
				$int_count = $c->result_array();			
				if(isset($int_count[0]['COUNT( membershipid )']) && !empty($int_count[0]['COUNT( membershipid )']))
				{
					$count[$record['id']] = $int_count[0]['COUNT( membershipid )'];
				}
			}		
			return $count;
		}
		return $count;
	}	
	function get_all_site_gropus($site_id)
	{
		//echo $site_id; die();
		$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' ";
		$result = $this->db->query($qry);
		return $result->result_array();
	}
    
    function dropdown_site_gropus()
    {
            $site_id = $_SESSION['site_id'];
			$data = array();
            $data[0] = 'By Group Code';      
            	$data[0] = 'By Group Code';
			//$qry = "SELECT * FROM groups WHERE is_deleted = 'No' AND site_id = '".$site_id."' "; 
			 $qry = "SELECT *
					FROM groups
					INNER JOIN groups_sites_xref ON groups.id = groups_sites_xref.group_id
					WHERE groups_sites_xref.site_id = '".$site_id."'
					ORDER BY group_id ASC "; 
             $Q = $this->db->query($qry);
             if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                 $data[$row['id']] = $row['group_name'];
               } 
            }
            $Q->free_result();
            return $data;
    }
	
	/*
	  This function will load all Permissions for Site Gruops.
	*/
	function get_all_sitegroup_permission()
	{
		$str_query = "SELECT * FROM groups_permission WHERE deleted = 'No'";
		$result = $this->db->query($str_query);
		return $result->result_array(); 
	}
	function add_group_intro_page($site_id = "",$page_groups = "",$page_title = "",$content_page = "")
	{
		
		
		 
		 // group id 
		
		 
		$page_show_title = "Yes";
		$page_seo_url = "";
		$page_code = $site_id.":".$page_title;
		$page_ishomepage = "No";     
		$page_create_date = date('Y-m-d h:i:s');
		$page_modified_date = date('Y-m-d h:i:s'); 
		
		$page_access = "Other";
		$page_status = "Published";
		$page_header = "Default";
		$private_page = "";
		$private = "";
		$users_string = "";
		
		$header_background = 'Default';		
		$page_keywords = "";
		$page_desc = "";
		$page_background = "Default";
		$page_start_date = "";
		$page_end_date = "";
		$page_type = "Group";
		//$menu_id = $this->input->post("menu_id");
		
		
		$this->db->query("INSERT INTO pages
			(site_id, 
			page_title,
			page_show_title, 
			page_default, 
			page_seo_url, 
			page_code,
			page_type, 
			page_ishomepage, 
			page_header, 
			header_background, 
			page_keywords, 
			page_desc, 
			page_background, 
			page_start_date, 
			page_end_date, 
			page_create_date, 
			page_modified_date, 
			page_access, 
			page_status,
			page_privacy,
			page_groups 
			) 
			
			VALUES(
			".$this->db->escape($site_id).",
			".$this->db->escape($page_title).", 
			".$this->db->escape($page_show_title).", 
			'Not Default',  
			".$this->db->escape($page_seo_url).", 
			".$this->db->escape($page_code).", 
			".$this->db->escape($page_type).",
			".$this->db->escape($page_ishomepage).",
			".$this->db->escape($page_header).", 
			".$this->db->escape($header_background).", 
			".$this->db->escape($page_keywords).",
			".$this->db->escape($page_desc).", 
			".$this->db->escape($page_background).", 
			".$this->db->escape($page_start_date).",
			".$this->db->escape($page_end_date).", 
			".$this->db->escape($page_create_date).", 
			".$this->db->escape($page_modified_date).",
			".$this->db->escape($page_access).", 
			".$this->db->escape($page_status).", 
			".$this->db->escape($private).", 
			".$this->db->escape($page_groups)."
			)");
		
		$page_id = $this->db->insert_id();
		
		
		
		/*---------		Group intro page content 		--------*/
		$field_name = "para_1";
		$type = "para";
		
		$content_data = array(
						'field_name' => $field_name,
						'type' => $type,
						'page_id' => $page_id,
						
						'data' => $content_page
						);
							
		$this->db->insert('page_content_controls ', $content_data);
		/*---------		Group intro page content 		--------*/
		
		//	$page_groups // group id
		$data = array(
               'group_page_id' => $page_id,
        );
		$this->db->where('id', $page_groups);
		$this->db->update('groups', $data); 
		
		
		return $page_id;
	}
	
	
	function update_group_intro_page($group_id,$content_page)
	{
		
		$query = "SELECT group_page_id,id  FROM groups WHERE id = '$group_id' ";
		$r = $this->db->query($query);
		$row = $r->row_array();
		$page_id = $row['group_page_id'];
		
		$query = "SELECT page_id,id  FROM page_content_controls WHERE page_id = '$page_id' ";
		$r = $this->db->query($query);
		$row = $r->row_array();
		$content_id = $row['id'];
		
		/*---------		Group intro page content 		--------*/
		$field_name = "para_1";
		$type = "para";
		
		$content_data = array(
			'data' => $content_page
			);
							
		$this->db->where('id', $content_id);
		$r = $this->db->update('page_content_controls', $content_data); 
		if($r)
		{
			return $page_id;
		}
		else 
		{
			return false;
		}
	}
	/*************************/
	/*
	  This function will Creates new Group.
	*/
	function insert_site_group($site_id)
	{
		
		//echo "<pre>";	print_r($_POST['checkbox_items']); //die();
		//echo "<pre>";	print_r($_POST['radio_items']); die();
		//echo "<pre>";	print_r($_POST); die();
		
		
		$group_code = $_REQUEST["group_code"] ;
		
			
		if($_REQUEST["group_code"] == "custom")
		{
			$group_code = $_REQUEST["custome_code"];  	
		}
	
	$group_link = ""; 
	$group_menu_id = ""; 
	$group_page_id = "" ;
	$fixed_price = "";
	$group_discount = "";
	$group_discount_type = "";
	$recurring_payment = '';
	
	
	
	if(isset($_REQUEST["recurion_permanent"]) && !empty($_REQUEST["recurion_permanent"]))
	{
		$recurring_payment = "Yes";
	}
	else
	{
		$recurring_payment = "No";
	}
	
	if($_REQUEST["on_registration"] == "Yes")
	{
		$group_type = "Registration";
	}
	else if($_REQUEST["on_registration"] == "Link")
	{
		$group_type = "Link";
		$group_link = "Link Will be later";
	}
	else if($_REQUEST["on_registration"] == "Menu")
	{
		$group_type = "Menu";
		$group_menu_id = $_REQUEST["menu_id"] ;
			
	}
	
	if($_REQUEST["intro_page"] == "group_page")
	{
		$group_page_id = $_REQUEST["page_id"];
	}
	
	
	// WE are keeping the paymnet information in the one the table if payment type is One-type the group table only 
	if($_REQUEST["payment_type"] == "One-Time")
	{
		$fixed_price = $_REQUEST["one_time_price"];	
	}
	else if($_REQUEST["payment_type"] == "Recursion")
	{
		$fixed_price = $_REQUEST["recurion_price"];	
	}
	else  if($_REQUEST["payment_type"] == "Trial")
	{
		$fixed_price = $_REQUEST["trial_price"];	
	}
		
	if($_REQUEST["is_discount"] != "None")
	{
		$group_discount = $_REQUEST["discount"];
		$group_discount_type = $_REQUEST["discount_type"];
		
		
	}  
	 
		$current_time = date("Y-m-d H:i:s", time());
		
		$group_data = array(
							'group_name' => $_REQUEST["group_name"],
							'group_code' => $group_code,
							'discount_value' => $group_discount,
							'discount_type' => $group_discount_type,						  
							'notify_emails' => $_REQUEST["notify_emails"],
							'payment_method' => $_REQUEST["payment_type"],
							'recurssion_payment' => $recurring_payment,			
							'group_type' =>  $group_type,
							'group_link' => $group_link,
							'group_menu_id' => $group_menu_id,
							'fixed_price' => $fixed_price,
							'group_page_id' => $group_page_id,
							'creat_date' => $current_time  
							);
							
		$group_id = $this->db->insert('groups ', $group_data);
		$group_id = $this->db->insert_id();	
		
		$group_site_xref = array(
									'site_id' => $site_id,
									'group_id' => $group_id 
									
								);
								
		$group_xref = $this->db->insert('groups_sites_xref ', $group_site_xref);						
						
	/* group intro page */
	if($_REQUEST["intro_page"] == "custom")
	{
		/* 	group intro page add here */
		$this->add_group_intro_page($site_id, $group_id, $_REQUEST["group_name"], $_REQUEST["page_content"] );
		
	}
	
	/*
		This Area controls the group payemnets and other payement methods
	*/
	
	$payment_details = array();
	
	switch($_REQUEST["payment_type"])
	{
		case 'Recursion' :
			$payment_details = array(
										'group_id' => $group_id,
										'price' => $_REQUEST["recurion_price"],
										'payment_cycle' => $_REQUEST["rec_cycle"], 
										'payment_cycle_type' => $_REQUEST["rec_cycle_type"],
										'duration' => $_REQUEST["rec_duration"],
										'duration_type' => $_REQUEST["rec_duration_type"]
									); 
			break;
		case 'Trial' :
			$payment_details = array(
										'group_id' => $group_id,
										'duration' => $_REQUEST["trial_duration"],
										'duration_type' => $_REQUEST["trial_duration_type"], 
										'price' => $_REQUEST["trial_price"],
										'payment_cycle' => $_REQUEST["trial_cycle"],
										'payment_cycle_type' => $_REQUEST["trial_payment_type"]
							); 
			break;
	}
	
	if(!empty($payment_details))
	{
		$group_payment_details = $this->db->insert('groups_payments_details ', $payment_details);		
	}
	//End
	/*
	  Permissions for Group  
	*/		
		if($_REQUEST["fb_login"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('fb_login');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);
		}
		if($_REQUEST["upload_file"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('upload_file');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);
		}
		if($_REQUEST["trouble_tickets"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('trouble_tickets');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);
		}
		if($_REQUEST["post_comment"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('post_comment');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);
		}
		if($_REQUEST["notification"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('notification');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);
		}
		if($_REQUEST["reward_points"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('reward_points');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);
		}
		if($_REQUEST["testimonies"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('testimonies');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);
		}
		
		/* Adding custom fields */
			$items = $_REQUEST["items"];
			// echo "<pre>"; print_r($items );	exit;
			foreach($items as $key => $item)
            {   //  is_array($items)
                
                $title = $item['title'];
                $type = $item['type'];
                
                if(isset($item['required']))
				{
                    if($item['required']==1)
					{
                      $required ='Yes';  
                    }
					else
					{
                        $required = 'No';
					}
                }
				else 
				{
                   $required = 'No'; 
                }
                $order =$item['order'];
                 if(!$item['order']){
                   $order = '0'; 
                }
				if(isset($item['type']) && $item['type'] == 'Radio Buttons')
				{
				  $name = "radio";	
				}
				else
				{
                  $name =$item['title'];
				}
                $new_item = array ($group_id,$title,$name,$type,$required,$order ); 
       
               $query = "INSERT INTO group_fields(group_id,field_title,field_name,field_type,field_required,field_sequence) VALUES (?,?,?,?,?,?)";
               $this->db->query($query,$new_item ); 
               $field_id = $this->db->insert_id();
			   $checkbox_items = $_POST['checkbox_items'];	
			   $radio_items = $_POST['radio_items'];
			   $textarea = $_POST['textarea'];
			   
			   $options = false;
			   if($type == "Multi-Line Text")
			   {
				   $options = $textarea[$key];
			   }
			   else if($type == "Check Boxes")
			   {
				   $options = $checkbox_items[$key];
			   }
			   else if($type == "Radio Buttons")
			   {
				   $options = $radio_items[$key]; 
			   }
			   
			   if($options)
			   {
				   foreach ( $options as $opt_val)
				   {
						$q = "INSERT INTO group_fields_options(field_id,option_value) VALUES ('$field_id','$opt_val')";
						$this->db->query($q); 
				   }
			   }
			       
            }
		
	/*
	  End
	*/	
	
	
	/*
	  Upgradabels for Group  start  
	*/
	if($_POST["is_upgradable"] == 1 )
	{
		$upgradable_group_ids = $_POST['upgradable_groups'];
		$this->add_upgradable_group($group_id,$upgradable_group_ids);
	}
	//End
	
	$button_page_id = $_POST['group_join_button_page_id'];
	
	$this->add_join_group_button_to_page($button_page_id,$group_id);
	
	return true;							
	}
	
	function add_join_group_button_to_page($button_page_id,$group_id)
	{
		$data = array(
		
			   'page_id' =>  $button_page_id,
			   'group_id' => $group_id 

			);
			$this->db->insert('group_button_page_id', $data); 
	}
	
	/* This function will update group 	*/
	function add_upgradable_group($group_id,$upgradable_group_ids)
	{
		foreach($upgradable_group_ids as $id)
		{
			$data = array(
			   'group_id' =>  $group_id,
			   'upgradable_group_id' => $id 
			);
			
			$this->db->insert('group_upgradable', $data); 
		}
	}
	
    function update_upgradable_group($group_id,$upgradable_group_ids)
	{
		$is_upgradable = $this->input->post("is_upgradable");
		if($is_upgradable == 0 )
		{
	
			$this->db->where('group_id', $group_id);
			$this->db->delete('group_upgradable');
	
		}
		else if ($is_upgradable == 1)
		{
			$this->db->where('group_id', $group_id);
			$this->db->delete('group_upgradable');
	
			foreach($upgradable_group_ids as $id)
	
			{
	
				$data = array(
	
				   'group_id' =>  $group_id,
	
				   'upgradable_group_id' => $id 
	
				);
				
				$this->db->insert('group_upgradable', $data); 
	
			}
		}
		
	}
	
	/* This function will update group 	
	*/
	function do_update_site_group($group_id, $site_id)
	{
		
		
		/*echo "<pre>";
		print_r($_REQUEST);
		exit;*/
		$group_code = $_REQUEST["group_code"];		
		if($_REQUEST["group_code"] == "custom")
		{
			$group_code = $_REQUEST["custome_code"];  	
		}	
		$group_link = ""; 
		$group_menu_id = ""; 
		$group_page_id = "" ;
		$fixed_price = "";
		$group_discount = "";
		$group_discount_type = "";
		$recurring_payment = '';
		
		if(isset($_REQUEST["recurion_permanent"]) && !empty($_REQUEST["recurion_permanent"]))
		{
			$recurring_payment = "Yes";
		}
		else
		{
			$recurring_payment = "No";
		}
	
		if($_REQUEST["on_registration"] == "Yes")
		{
			$group_type = "Registration";
		}
		else if($_REQUEST["on_registration"] == "Link")
		{
			$group_type = "Link";
			$group_link = "Link Will be later";
		}
		else if($_REQUEST["on_registration"] == "Menu")
		{
			$group_type = "Menu";
			$group_menu_id = $_REQUEST["menu_id"] ;
				
		}
	
		if($_REQUEST["intro_page"] == "group_page")
		{
			$group_page_id = $_REQUEST["page_id"];
		}
		else if($_REQUEST["intro_page"] == "custom")
		{
		
			/* 	group intro page add here */
			$content_page = $_REQUEST["page_content"];
			$page_id = $this->update_group_intro_page($group_id,$content_page);
			
			
			$group_page_id = $page_id;
			
		}
	
		// WE are keeping the paymnet information in the one the table if payment type is One-type the group table only 
		if($_REQUEST["payment_type"] == "One-Time")
		{
			$fixed_price = $_REQUEST["one_time_price"];	
		}
		else if($_REQUEST["payment_type"] == "Recursion")
		{
			$fixed_price = $_REQUEST["recurion_price"];	
		}
		else  if($_REQUEST["payment_type"] == "Trial")
		{
			$fixed_price = $_REQUEST["trial_price"];	
		}
		if($_REQUEST["is_discount"] != "None")
		{
			$group_discount = $_REQUEST["discount"];
			$group_discount_type = $_REQUEST["discount_type"];		
		}  
		$current_time = date("Y-m-d H:i:s", time());
		$group_data = array(
							'group_name' => $_REQUEST["group_name"],
							'group_code' => $group_code,
							'discount_value' => $group_discount,
							'discount_type' => $group_discount_type,						  
							'notify_emails' => $_REQUEST["notify_emails"],
							'payment_method' => $_REQUEST["payment_type"],
							'recurssion_payment' => $recurring_payment,
							'group_type' =>  $group_type,
							'group_link' => $group_link,
							'group_menu_id' => $group_menu_id,
							'fixed_price' => $fixed_price,
							'group_page_id' => $group_page_id,
							'creat_date' => $current_time  
							);
		$this->db->where('id', $group_id);
		$this->db->update('groups', $group_data); 
		
		$group_site_xref = array(
									'site_id' => $site_id,
									'group_id' => $group_id 
								);
		//$group_xref = $this->db->insert('groups_sites_xref ', $group_site_xref);
		
		$this->db->where('group_id', $group_id);
		$this->db->update('groups_sites_xref', $group_site_xref);
		if($_REQUEST["intro_page"] == "custom")
		{
			$group_content = array(
									'group_id' => $group_id,
									'page_content' => $_REQUEST["page_content"]
									);
			//$group_content = $this->db->insert('groups_pages_content ', $group_content);								
			$this->db->where('group_id', $group_id);
			$this->db->update('groups_pages_content', $group_content);
		}
	
		/*
			This Area controls the group payemnets and other payement methods
		*/
		$payment_details = array();
		switch($_REQUEST["payment_type"])
		{
			case 'Recursion' :
				$payment_details = array(
											'group_id' => $group_id,
											'price' => $_REQUEST["recurion_price"],
											'payment_cycle' => $_REQUEST["rec_cycle"], 
											'payment_cycle_type' => $_REQUEST["rec_cycle_type"],
											'duration' => $_REQUEST["rec_duration"],
											'duration_type' => $_REQUEST["rec_duration_type"]
										); 
			break;
			case 'Trial' :
				$payment_details = array(
											'group_id' => $group_id,
											'duration' => $_REQUEST["trial_duration"],
											'duration_type' => $_REQUEST["trial_duration_type"], 
											'price' => $_REQUEST["trial_price"],
											'payment_cycle' => $_REQUEST["trial_cycle"],
											'payment_cycle_type' => $_REQUEST["trial_payment_type"]
								); 
			break;
		}	
		if(!empty($payment_details))
		{
			$this->db->where('group_id', $group_id);
			$group_payment_details = $this->db->update('groups_payments_details ', $payment_details); 
			//$group_payment_details = $this->db->insert('groups_payments_details ', $payment_details);		
		}
		//End
		/*
		  Permissions for Group  
		*/
		$this->db->query("DELETE FROM groups_permission_xref WHERE group_id = ".$group_id);
		if($_REQUEST["fb_login"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('fb_login');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);			
		}
		if($_REQUEST["upload_file"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('upload_file');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);			
		}
		if($_REQUEST["trouble_tickets"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('trouble_tickets');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);			
		}
		if($_REQUEST["post_comment"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('post_comment');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);			
		}
		if($_REQUEST["notification"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('notification');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);			
			//$this->db->query("UPDATE groups_permission_xref SET permission_id = ".$permission_id." WHERE group_id = ". $group_id);
		}
		if($_REQUEST["reward_points"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('reward_points');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);			
		}
		if($_REQUEST["testimonies"] == "Yes")
		{
			$permission_id = $this->get_permission_id_by_value('testimonies');
			$qry = "INSERT INTO groups_permission_xref(group_id,permission_id)VALUES('".$group_id."','".$permission_id."')";
			$this->db->query($qry);			
		}
		
		$upgradable_group_ids = $_POST['upgradable_groups'];
		$this->update_upgradable_group($group_id,$upgradable_group_ids);
		
		$button_page_id = $_POST['group_join_button_page_id'];
		$this->edit_join_group_button_to_page($button_page_id,$group_id);
		
		
		/* Adding custom fields */
			$items = $_REQUEST["items"];
			// echo "<pre>"; print_r($_POST);	exit;
			$this->db->where('group_id', $group_id);
			$r = $this->db->delete('group_fields');
			foreach($items as $key => $item)
            {   //  is_array($items)
                
                $title = $item['title'];
                $type = $item['type'];
                
                if(isset($item['required']))
				{
                    if($item['required']==1)
					{
                      $required ='Yes';  
                    }
					else
					{
                        $required = 'No';
					}
                }
				else 
				{
                   $required = 'No'; 
                }
                $order =$item['order'];
                 if(!$item['order']){
                   $order = '0'; 
                }
				if(isset($item['type']) && $item['type'] == 'Radio Buttons')
				{
				  $name = "radio";	
				}
				else
				{
                  $name =$item['title'];
				}
                $new_item = array ($group_id,$title,$name,$type,$required,$order ); 
       			
				
               $query = "INSERT INTO group_fields(group_id,field_title,field_name,field_type,field_required,field_sequence) VALUES (?,?,?,?,?,?)";
               $this->db->query($query,$new_item ); 
               $field_id = $this->db->insert_id();
			   $checkbox_items = $_POST['checkbox_items'];	
			   $radio_items = $_POST['radio_items'];
			   $textarea = $_POST['textarea'];
			   
			   $options = false;
			   if($type == "Multi-Line Text")
			   {
				   $options = $textarea[$key];
			   }
			   else if($type == "Check Boxes")
			   {
				   $options = $checkbox_items[$key];
			   }
			   else if($type == "Radio Buttons")
			   {
				   $options = $radio_items[$key]; 
			   }
			   
			   if($options)
			   {
				   foreach ( $options as $opt_val)
				   {
						$q = "INSERT INTO group_fields_options(field_id,option_value) VALUES ('$field_id','$opt_val')";
						$this->db->query($q); 
				   }
			   }
			       
            }
		
	
		/*
		  End
		*/	
		return true;
	}	
	function edit_join_group_button_to_page($button_page_id,$group_id)
	{
		$this->db->where("group_id",$group_id);
		$r = $this->db->get('group_button_page_id');
		
		$n = $r->num_rows();
		if ($n > 0)
		{
			$data = array(
				   'page_id' =>  $button_page_id
			);
			
			$this->db->where("group_id",$group_id);
			$this->db->update('group_button_page_id', $data); 
		}
		else
		{
			$data = array(
		
			   'page_id' =>  $button_page_id,
			   'group_id' => $group_id 

			);
			$this->db->insert('group_button_page_id', $data);
		}
	}
	
	/*
	  This function will load all Site Gruops.
	*/
	function get_all_sitegroup()
	{
		//Not completedddddddddddd
		$str_query = "SELECT * FROM groups_permission WHERE deleted = 'No'";
		$result = $this->db->query($str_query);
		return $result->result_array(); 
	}
	
	/*
	  This function will load all Gruops Fields.
	*/
	function get_group_fields($group_id)
	{
		$str_query = "SELECT * FROM group_fields WHERE group_id =".$group_id;
		$result = $this->db->query($str_query);
		return $result->result_array();
	}	
	function get_group_custom_fields_admin_side($group_id)
	{
		
		$str_query = "SELECT * FROM group_fields WHERE group_id ='$group_id' AND field_delete = 0 ORDER BY field_sequence ASC ";
		$dataset = $this->db->query($str_query);
        //echo "<pre>";		print_r($dataset->result());	echo "</pre>";	die();
         
		  if($dataset->num_rows() > 0) 
		  {
			 
            $output = array();
            $index = 0;
            foreach($dataset->result() as $items)
            {
  				//echo "<pre>";		print_r($items);	echo "</pre>";	die();
          	   
				// CHECK BOX
               if ($items->field_type == 'Check Boxes') 
			   {
				   
                    $output[$index]['id'] = ' <input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >';
                    $output[$index]['label'] =  $items->field_title;
					$output[$index]['title'] = $items->field_title;
					
					if($items->field_required == "Yes")
					{
						 $required = ' class="required_custom_field" ';
						 
					}
					else
					{
						$required = '';
					}
					
					$output[$index]['field'] = "";
					// get checkbox options
					$field_id = $items->id;
					$options = $this->get_fields_options($field_id);
					if($options)
					{
						foreach($options as $option)
						{
							$output[$index]['field'] .=  '<td>'.$option['option_value'].' </td><td><input '.$required.' id="check-'.$option['option_id'].'" type="checkbox" name="field['.$index.'][value][]" value="'.$option['option_value'].'" ></td>';
						} 
					}
					
					
					
					
                    $output[$index]['required'] =  $items->field_required; 
                 	
                   
               }
			   // RADIO BUTTONS
			   else if($items->field_type == 'Radio Buttons'){
                    $output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.trim($items->field_title).'" >';  
                    $output[$index]['label'] =  $items->field_title;
					$output[$index]['title'] = $items->field_title;
					
					if($items->field_required == "Yes")
					{
						 $required = ' class="required_custom_field" ';
						 
					}
					else
					{
						$required = '';
					}
					
					$output[$index]['field'] = "";
					// get checkbox options
					$field_id = $items->id;
					$options = $this->get_fields_options($field_id);
					if($options)
					{
						foreach($options as $option)
						{
							$output[$index]['field'] .=  '<td>'.$option['option_value'].'  </td><td><input '.$required.' id="radio-'.$option['option_id'].'" type="radio" name="field['.$index.'][value]" value="'.$option['option_value'].'" ></td>';
							
						} 
					}
					
					
                    $output[$index]['required'] =  $items->field_required;    
                  
               }
			   // SINGLE LINE 
			   else if($items->field_type == 'Single-Line Text' ) 
			   {
                    $output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >'; 
                    $output[$index]['label'] =  $items->field_title;
					
					if($items->field_required == "Yes")
					{
						 $required = ' class="required_custom_field" ';
						 
					}
					else
					{
						$required = '';
					}
					
					$output[$index]['field'] =  '<td><input '.$required.' type="text" id="" value="" name="field['.$index.'][value]"></td>';
					
                    $output[$index]['required'] =  $items->field_required; 
                   
					//echo "<pre>";	print_r($output);	echo "</pre>";	 //die();
               }
			   // MULTI LINE TEXT
			   else if ($items->field_type == 'Multi-Line Text')
			   {
				    
                    $output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >'; 
                    $output[$index]['label'] =  $items->field_title;
					
					$field_id = $items->id;
					
					$options = $this->get_fields_options($field_id);
					
					if($options)
					{
						$cols = $options[0]['option_value'];
						$rows = $options[1]['option_value'];
					}
					else
					{
						$cols = 40;
						$rows = 5;
					}
					if($items->field_required == "Yes")
					{
						 $required = ' class="required_custom_field" ';
						 
					}
					else
					{
						$required = '';
					}
					
					$output[$index]['field'] =  '<td><textarea '.$required.' id="" name="field['.$index.'][value]" title="'.$items->field_title.'" rows="'.$rows.'" cols="'.$cols.'"></textarea></td>';  
					
					 
                    $output[$index]['required'] =  $items->field_required;
					
               }
			   
			   $output[$index]['name'] = "field[".$index."][value]";
			   $output[$index]['type'] = $items->field_type;
			   
               $index++;          
            }
			//echo "<pre>";	print_r($output);	echo "</pre>";	 //die();
			return $output;
        }
	 
	}
	
	function get_group_custom_fields($group_id) 
	{
		$str_query = "SELECT * FROM group_fields WHERE group_id ='$group_id' AND field_delete = 0 ORDER BY field_sequence ASC ";
		$dataset = $this->db->query($str_query);
        //echo "<pre>";		print_r($dataset->result());	echo "</pre>";	die();
         
		  if($dataset->num_rows() > 0) 
		  {
			 
            $output = array();
            $index = 0;
            foreach($dataset->result() as $items)
            {
  				//echo "<pre>";		print_r($items);	echo "</pre>";	die();
          	   
				// CHECK BOX
               if ($items->field_type == 'Check Boxes') 
			   {
				   
                    $output[$index]['id'] = ' <input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >';
                    $output[$index]['label'] =  $items->field_title;
					$output[$index]['title'] = $items->field_title;
					
					if($items->field_required == "Yes")
					{
						 $required = ' class="required_custom_field" ';
						 
					}
					else
					{
						$required = '';
					}
					
					$output[$index]['field'] = "";
					// get checkbox options
					$field_id = $items->id;
					$options = $this->get_fields_options($field_id);
					if($options)
					{
						foreach($options as $option)
						{
							$output[$index]['field'] .=  $option['option_value'].' <input '.$required.' id="check-'.$option['option_id'].'" type="checkbox" name="field['.$index.'][value][]" value="'.$option['option_value'].'" >&nbsp;';
						} 
					}
					
					
					
					
                    $output[$index]['required'] =  $items->field_required; 
                 	
                   
               }
			   // RADIO BUTTONS
			   else if($items->field_type == 'Radio Buttons'){
                    $output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.trim($items->field_title).'" >';  
                    $output[$index]['label'] =  $items->field_title;
					$output[$index]['title'] = $items->field_title;
					
					if($items->field_required == "Yes")
					{
						 $required = ' class="required_custom_field" ';
						 
					}
					else
					{
						$required = '';
					}
					
					$output[$index]['field'] = "";
					// get checkbox options
					$field_id = $items->id;
					$options = $this->get_fields_options($field_id);
					if($options)
					{
						foreach($options as $option)
						{
							$output[$index]['field'] .=  $option['option_value'].' <input '.$required.' id="radio-'.$option['option_id'].'" type="radio" name="field['.$index.'][value]" value="'.$option['option_value'].'" >&nbsp;';
						} 
					}
					
					
                    $output[$index]['required'] =  $items->field_required;    
                  
               }
			   // SINGLE LINE 
			   else if($items->field_type == 'Single-Line Text' ) 
			   {
                    $output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >'; 
                    $output[$index]['label'] =  $items->field_title;
					
					if($items->field_required == "Yes")
					{
						 $required = ' class="required_custom_field" ';
						 
					}
					else
					{
						$required = '';
					}
					
					$output[$index]['field'] =  '<input '.$required.' type="text" id="" value="" name="field['.$index.'][value]">';
					
                    $output[$index]['required'] =  $items->field_required; 
                   
					//echo "<pre>";	print_r($output);	echo "</pre>";	 //die();
               }
			   // MULTI LINE TEXT
			   else if ($items->field_type == 'Multi-Line Text')
			   {
				    
                    $output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >'; 
                    $output[$index]['label'] =  $items->field_title;
					
					$field_id = $items->id;
					
					$options = $this->get_fields_options($field_id);
					
					if($options)
					{
						$cols = $options[0]['option_value'];
						$rows = $options[1]['option_value'];
					}
					else
					{
						$cols = 40;
						$rows = 5;
					}
					if($items->field_required == "Yes")
					{
						 $required = ' class="required_custom_field" ';
						 
					}
					else
					{
						$required = '';
					}
					
					$output[$index]['field'] =  '<textarea '.$required.' id="" name="field['.$index.'][value]" title="'.$items->field_title.'" rows="'.$rows.'" cols="'.$cols.'"></textarea>';  
					
					 
                    $output[$index]['required'] =  $items->field_required;
					
               }
			   
			   $output[$index]['name'] = "field[".$index."][value]";
			   $output[$index]['type'] = $items->field_type;
			   
               $index++;          
            }
			//echo "<pre>";	print_r($output);	echo "</pre>";	 //die();
			return $output;
        }
	}
	function get_fields_options($field_id)
	{
		// echo $field_id;die();
		$this->db->where("field_id",$field_id);
		$r = $this->db->get("group_fields_options");
		$n = $r->num_rows();
		if( $n > 0 )
		{
			$options = $r->result_array();
			foreach( $options as $key => $row )
			{
				$opt[$key]['option_value'] = $row['option_value'];
				$opt[$key]['option_id'] = $row['option_id'];
			}
			
			return $opt;
		}
		return false;
	}
	
	function get_group_fields_required($group_id)
	{
		$str_query = "SELECT * FROM group_fields WHERE group_id ='$group_id' AND field_required = 'Yes' ";
		$result = $this->db->query($str_query);
		return $result->result_array();  
	}
	/*
	  This function will will check group is paid or free.
	*/
	function check_group_paid($group_id)
	{
		if(isset($group_id))
		 {
			//$result = "SELECT * FROM `groups` inner join  groups_payments_details on groups.id = groups_payments_details.group_id  where groups.id =".$group_id;
			$result = "SELECT * FROM `groups` Left outer join  groups_payments_details on groups.id = groups_payments_details.group_id  where groups.id =".$group_id;
			$result = $this->db->query($result);
			$result = $result->result_array(); 		
			return $result;
		 }	
	}
	
	
	function status_group($group_id)
	{
		 if(isset($group_id))
		 {
		 	$str_query = "SELECT is_disabled FROM groups WHERE id = ".$group_id;			
			$result = $this->db->query($str_query);
			$result = $result->result_array(); 		
			//echo "<pre>";
			//print_r($result[0]['is_disabled']);
			///exit;
			if($result[0]['is_disabled']=='Yes')
			{
				$updated = $this->db->query("UPDATE groups SET is_disabled = 'No' WHERE id = ".$group_id);				
				return "Disabled";
			}
			else
			{
				$updated = $this->db->query("UPDATE groups SET is_disabled = 'Yes' WHERE id = ".$group_id);				
				return "Enabled";
			}
		 }
	}
	
	function get_edit_group($group_id)
	{
		if(isset($group_id))
		 {
		 	$result = "SELECT * FROM groups left join  groups_payments_details on groups.id = groups_payments_details.group_id where groups.id = ".$group_id;
			
			$result = $this->db->query($result);
			$result = $result->result_array(); 		
			return $result;
		 }	
	}
	
	function get_group_page_content($group_page_id)
	{
		// echo $group_page_id;
		$query = "SELECT * FROM pages WHERE page_id = '$group_page_id' ";
		$r = $this->db->query($query);
		$row = $r->row_array();
		$page_type = $row['page_type'];
		if ( $page_type == "Group" )
		{
			$r = $this->db->query("SELECT * FROM page_content_controls WHERE page_id = '$group_page_id' ");
			if($r->num_rows() == 1)
			{
				$row = $r->row_array();
				$content = $row['data'];
			}
			else
			{
				$content = "";
			}
			
		}
		else
		{
			$content = "";
		}
		return $content;
		
	}
	function dropdown_site_users($site_id)
	{
	   $data = array();
	  // $data[0] = 'Registered Users';
	   $this->db->where('site_id',$site_id);
	  // $this->db->where('membershipid', 0);
	  //$this->db->or_where('membershipid', 'NULL');
	   $this->db->order_by("customer_id", "desc");
	   $Q = $this->db->get('ec_customers');
	    if ($Q->num_rows() > 0){
			   foreach ($Q->result_array() as $row){
				 $data[$row['customer_id']] = $row['customer_login'];
			   } 
			   
			  
			}
			 else
			   {
				  $data[0] = "No User Found";   
			   }
			   
			$Q->free_result();
			return $data;
	}
	function dropdown_site_gropus_by_site_id($site_id)
	{
			$data = array();
			$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' ";
			 $Q = $this->db->query($qry);
			 if ($Q->num_rows() > 0){
			   foreach ($Q->result_array() as $row){
				 $data[$row['id']] = $row['group_name'];
			   } 
              
			}
			 else
			   {
				  $data[0] = 'No Group Found';  
			   }
			$Q->free_result();
			return $data;
	}
	
	/*
		Get all Users and Groups by Site ID DROPDOWN
		- Site ID : For Site
		- Type : Single ,Multiple
		- Third Param is Optional and Used here to Webinar Call fetching only DropDoen Irrespective of any Js Function calling
	*/
	function get_site_gropus_customer_by_site_id($site_id, $type=0,$webinar_call = 0)
	{
$group_data = array();
			$data = '';
			if($type==='single' && $webinar_call != 1 )
			{
				 $data = "<select name='customers[]' onclick='get_customer_detail()' id='customers' >";
			}
			else if($type==='single' && $webinar_call == 1 )
			{
				$data = "<select name='customers[]' id='customers' ><option value=''>Select</option>";
			}
			
			else 
			{
				$data = "<select style='opacity:1;' name='customers[]' id='customers' multiple='MULTIPLE'>";
			}
			
			$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' AND gp.is_disabled = 'No' AND gp.is_deleted = 'No' ";
			 $Q = $this->db->query($qry);
			 
			 $all_customers = $this->db->query("SELECT customer_id, customer_login, customer_name, customer_email FROM  `ec_customers` WHERE  membershipid =1 and site_id= ".$site_id);
			 $all_site_customers = $all_customers->result_array();
			 /*echo "<pre>";
			 print_r($all_site_customers);
			 exit;*/
			if ($Q->num_rows() > 0){
				 
			   foreach ($Q->result_array() as $row)
			   {
					//echo "<pre>";	print_r($row);	echo "</pre>";die();
					
					
					$data .= "<optgroup id=\" ".$row['id']."\" label=\"".$row['group_name']."\">";
					$c = $this->db->query("
					SELECT 
					c.customer_id,
					c.customer_login,
					c.customer_name,
					c.customer_email, 
					cgx.customer_id,
					cgx.group_id
					FROM  ec_customers_group_xref AS cgx
					JOIN `ec_customers` AS c
					ON c.customer_id = cgx.customer_id
					WHERE cgx.group_id = ".$row['id']);
					//fetching customer for Group
					 $int_count = $c->result_array();
					 if ($c->num_rows() > 0)
					 {
						foreach($int_count as $record)
						{
							//customers registered to this group
							$data .= "<option value=".$record['customer_id'].">";					
							$data .= $record['customer_email'];					
							$data .= "</option>";
							
						}	
					 }
					 else
					 {
						 //no customers registered to this group
						$data .= "<option value='0'>";					
						$data .= "No Customer Found";					
						$data .= "</option>";							
					 }
					$data .= "</optgroup>";
			   }
			  
			}
			if($all_customers->num_rows()>0)
			{
				$data .= "<optgroup id='1' label='Registered' >";
				foreach($all_site_customers as $customer)
				{
					//customers registered to this group
					$data .= "<option value=".$customer['customer_id'].">";					
					$data .= $customer['customer_email'];					
					$data .= "</option>";
				}
				$data .= "</optgroup>";
			}
			else if($all_customers->num_rows() == 0 && $Q->num_rows() == 0) 
			{
						//No Data Grops Created yet
						$data .= "<option value=''>Select</option><optgroup label='No Customer Exists' >";					
						$data .= "</optgroup>";	
			}
			$data .= "</select>";
			return $data;	
	}
	
	
	/*	funtion to get the dropdown of upgradable groups of this site 	*/
	function get_group_upgradable_options($site_id)
	{
		//$this->db->where();
		
		$query =  "SELECT g.id, `group_name`, `group_id`, `site_id`
		FROM groups AS g
		JOIN groups_sites_xref
		ON groups_sites_xref.group_id = g.id
		WHERE site_id = '$site_id'
		";
		
		$r = $this->db->query($query);
		
		//echo "<pre>";	print_r($r);	die();
		return $r;
	}
	
	// 
	function get_group_upgradable_options_of_group($group_id,$site_id)
	{
		//$this->db->where();
		
		$query =  "SELECT g.id, `group_name`, `group_id`, `site_id`
		FROM groups AS g
		JOIN groups_sites_xref
		ON groups_sites_xref.group_id = g.id
		WHERE site_id = '$site_id'
		AND g.id != '$group_id'
		";
		
		$r = $this->db->query($query);
		
		//echo "<pre>";	print_r($r);	die();
		return $r;
	}
	
	function get_upgradable_groups($group_id)
	{
		
		$query =  "SELECT 
		g.id, 
		g.group_name, 
		group_upgradable.group_id
		
		FROM groups AS g
		
		JOIN group_upgradable
		ON group_upgradable.upgradable_group_id = g.id
		
		WHERE group_upgradable.group_id = '$group_id'
		";
		
		$r = $this->db->query($query);
		return $r;
	}
	
	function if_group_is_upgradable_option_of_another_group($group_id,$upgradable_group_id)
	{
		$query =  "
		SELECT 
		upgradable_group_id
		group_id
		FROM group_upgradable 
		WHERE group_id = '$group_id' 
		AND upgradable_group_id = '$upgradable_group_id'
		";
		$r = $this->db->query($query);
		
		if($r->num_rows() == 1)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	
	function get_all_groups_of_member($member_id)
	{
		$query =  "SELECT g.id, g.group_name, g.payment_method, g.is_deleted,
		cgr.id AS relationID, cgr.customer_id , cgr.group_id
		FROM groups AS g
		JOIN ec_customers_group_xref AS cgr
		ON cgr.group_id = g.id
		WHERE cgr.customer_id = '$member_id'
		";
		
		$r = $this->db->query($query);
		return $r;
	}
	
	function get_all_unjoined_groups($site_id,$member_id)
	{
		
		// get all subscribed groups
		$queryJoinedGroup = "SELECT * FROM ec_customers_group_xref	WHERE customer_id = '$member_id'";
		$groups = $this->db->query($queryJoinedGroup);
		$whereClause = "";
		if($groups->num_rows() > 0)
		{
			
			$i = 0;
			foreach( $groups->result_array() as $row )
			{
				$group_id = $row['group_id'];
				
				
				$whereClause .= " AND g.id != '$group_id' ";
				$i++;
			}
			
			
		}
		
		
		///////////Without Group CODE
		
		
		// get all site's group 
		$query =  "SELECT 
		g.id, 
		g.group_name, 
		g.payment_method, 
		g.is_deleted, 
		g.group_code,
		gsr.group_id, 
		gsr.site_id 
		FROM groups AS g 
		JOIN groups_sites_xref AS gsr 
		ON gsr.group_id = g.id 
		WHERE  gsr.site_id = '$site_id' 
		".$whereClause." AND group_type='Registration'";
		
		
		$r = $this->db->query($query);
		return $r;
	}	
	
	function set_autoresponder_by_group_id($group_id, $member_id)
    {
       $query_string = "SELECT * FROM autoresponders WHERE respond_group = $group_id  AND respond_active = 1";
       $q = $this->db->query($query_string); 
       $data = array ();
       $group_members = $q->result_array();
	   
	   foreach($group_members as $group_member)
		{
			
			$respond_comming_date = $this->calculate_trail_end_date(date("Y-m-d"), $group_member['respond_send_value']);
			$save_member_auto = array(
						'autorespond_id' 		=> $group_member['respond_id'] ,
						'group_id' 				=> $group_id ,
						'customer_id' 			=> $member_id,	
						'respond_comming_date' 	=> $respond_comming_date													
						);
						
			$this->db->insert('autorespond_email_record', $save_member_auto);
		} 
	   
       return true;
    }
	
	
	function add_member_to_singel_group($member_id)
	{
		
		
		//echo "<pre>";print_r($_REQUEST);exit;
		
		$group_id = $this->input->post("group_id");
		if($group_id == 0 ) // its a group code then 
		{
			$group_id = $this->input->post("group_id_by_code");
			
		}
		else
		{		
			$group_members = $this->set_autoresponder_by_group_id($group_id, $member_id);
			
		}
		
		$group_data = array(
							'group_id' => $group_id ,
							'customer_id' => $member_id
							);
				
		$r = $this->db->insert('ec_customers_group_xref', $group_data);
		if($r)
		{
			return 1;
		}
		return 0;
		
	}
	
	function add_member_to_group_after_payment($member_id,$group_id)
	{
		$group_data = array(
							'group_id' => $group_id,
							'customer_id' => $member_id
							);
							
		$group_members = $this->set_autoresponder_by_group_id($group_id, $member_id);
		$r = $this->db->insert('ec_customers_group_xref', $group_data);
		if($r)
		{
			return 1;
		}
		return 0;
		
	}
	
	
	function update_group($group_id,$member_id)
	{
		
		
		$group_data = array(
							'group_id' => $this->input->post("group_id"),
							'customer_id' => $member_id
							);
							
		$group_members = $this->set_autoresponder_by_group_id($group_id, $member_id);
		$r = $this->db->insert('ec_customers_group_xref', $group_data);
		if($r)
		{
			return 1;
		}
		
		
		
	}
	
	
	
	
	
	function upgrade_group($member_id)
	{
		$current_group_id = $this->input->post("current_group_id");
		$upgrade_group_id = $this->input->post("upgrade_group_id");
		
		$query = "SELECT group_id FROM ec_customers_group_xref WHERE customer_id = '$member_id' AND group_id = '$upgrade_group_id' ";
		$is_group = $this->db->query($query);
		$n = $is_group->num_rows();
		if ( $n == 0 )
		{
				
			$data = array(
				   'group_id' => $upgrade_group_id
				);
	
			$this->db->where('group_id', $current_group_id);
			$this->db->where('customer_id', $member_id);
			
			$this->db->update('ec_customers_group_xref', $data);
			
			//Delete Auto Responder Group Refrence
			$this->db->query("DELETE FROM autorespond_email_record  WHERE customer_id = '$member_id' AND group_id = '$current_group_id'");
			$this->set_autoresponder_by_group_id($upgrade_group_id, $member_id);
			
			
			$this->db->query($query);
			
			 
			return 1;
		}
		else if($n == 1)
		{
			return 2;
		}
		return 0;
	}
	
	function upgrade_group_after_payment($member_id, $upgrade_group_id, $current_group_id)
	{
		
		$query = "SELECT group_id FROM ec_customers_group_xref WHERE customer_id = '$member_id' AND group_id = '$upgrade_group_id' ";
		$is_group = $this->db->query($query);
		$n = $is_group->num_rows();
		
		if ( $n == 0 )
		{
				
			$data = array(
				   'group_id' => $upgrade_group_id
				);
	
			$this->db->where('group_id', $current_group_id);
			$this->db->where('customer_id', $member_id);
			
			$this->db->update('ec_customers_group_xref', $data); 
			return 1;
		}
		else if($n == 1)
		{
			return 2;
		}
		return 0;
	}
	
	function unsubsribe_group($member_id,$group_id)
	{
		$this->db->where('group_id', $group_id);
		$this->db->where('customer_id', $member_id);
		$r = $this->db->delete('ec_customers_group_xref');
		if ($r)
		return true;
	}
	
	function get_group_payment_status()
	{
		$group_id = $this->input->post("group_id");
		//die();
		
		$this->db->where('group_id', $group_id);
		$this->db->select('payment_method','group_id');
		$r = $this->db->get("groups");
		
		if($r->num_rows() == 1)
		{
			foreach ( $r->result_array() as $row)
			{
				$method = $row["payment_method"];
				$data = $method;
			}
			
		}
		else
		{
			$data = "";
		}
		return $data;
	}
	function get_group_id_by_group_Code($group_code)
	{
		// echo "<pre>";	print_r($r->result_array());	die();
		
		$site_id = ( isset($_SESSION['site_id']) ) ? $_SESSION['site_id'] : 0 ;
		$q = "SELECT 
			g.id,
			g.group_code 
			FROM groups g
			JOIN groups_sites_xref gsx
			ON gsx.group_id = g.id 
			WHERE gsx.site_id = '$site_id'
			AND g.group_code = '$group_code'
			";
		$r = $this->db->query($q);	
		//echo "<pre>";	print_r($r->result_array());	die();
		if($r->num_rows() > 0 )
		{
			$row = $r->row_array();
			$group_id = $row["id"];
			$data = $group_id;
			return $data;
		}
		return false;
		
	}
	function code_check($code = '')
	{
		$site_id = ( isset($_SESSION['site_id']) ) ? $_SESSION['site_id'] : 0 ;
		$code = trim($code);
		$q = "SELECT 
			g.group_code
			FROM groups g
			JOIN groups_sites_xref sg
			ON g.id = sg.group_id
			WHERE g.group_code = '$code'
			AND g.is_deleted = 'No'
			AND g.is_disabled = 'No'
			AND sg.site_id = '$site_id'
			";
		
		
		$r = $this->db->query($q);
		if ($r->num_rows() > 0){
		   return true; 
		}
		else{
			return false;  
		}
	}
	
	function add_member_to_free_group_registration($group_id)
	{
		$group_data = array(
							'group_id' => $group_id,
							'customer_id' => $this->input->post("customer_id")
							);
		
		$group_members = $this->set_autoresponder_by_group_id($group_id, $this->input->post("customer_id"));					
		$r = $this->db->insert('ec_customers_group_xref', $group_data);
		if($r)
		{
			return 1;
		}
		return 0;
		
	}
	function add_member_to_singel_group_registering()
	{
		$group_data = array(
							'group_id' => $this->input->post("pending_membershipid"),
							'customer_id' => $this->input->post("customer_id")
							);
		
		$group_members = $this->set_autoresponder_by_group_id($this->input->post("pending_membershipid"), $this->input->post("customer_id"));
		$r = $this->db->insert('ec_customers_group_xref', $group_data);
		if($r)
		{
			return 1;
		}
		return 0;
		
	}
	
	function get_multiple_group_members()
	{
		$groups_ids = $this->input->post("groups_ids");
		//echo $groups_ids;
		//$this->db->where_in('group_id', $groups_ids);
		
		$query = "SELECT  
		c.customer_login,
		c.customer_id AS cid, 
		cgx.group_id AS group_id,
		cgx.customer_id AS x_cid
		FROM 
		ec_customers_group_xref AS cgx
		JOIN ec_customers AS c 
		ON c.customer_id = cgx.customer_id
		WHERE cgx.group_id IN ($groups_ids)
		";
		//echo $query;
		$r = $this->db->query($query);
		//print_r( $r->result_array() );
		if($r->num_rows() > 0)
		{
			
			foreach($r->result_array() as $row )
			{
				$customer_id = $row["cid"];
				$cusomer_email = $row['customer_login'];
				
				$data[$customer_id] = $cusomer_email;
			}
			
			return $data;
		}
		return false;
		
		
	}
	
	function get_group_button_page_by_group_id($group_id)
	{
		
		$this->db->where('group_id',$group_id);
		$r = $this->db->get('group_button_page_id'); 
		
		if ($r->num_rows() > 0 )
		{
			$row = $r->row_array();
			return $row['page_id'];
		}
		return false;
	}
	
	function get_all_site_groups_with_button($site_id)
	{
		$query = "SELECT 
					gbp.group_id,
					gbp.page_id,
					g.group_name AS name,
					gsx.site_id AS site_id
					
					FROM group_button_page_id AS gbp
					
					JOIN groups_sites_xref AS gsx
					ON gbp.group_id = gsx.group_id
					
					JOIN groups AS g
					ON g.id = gbp.group_id
					
					WHERE   gsx.site_id = '$site_id' AND g.group_type='Registration' AND is_deleted = 'No' AND is_disabled = 'No' 
					";
		$r = $this->db->query($query);
		if ($r->num_rows() > 0 )
		{
			$r = $r->result_array();
			return $r;
		}
		return false;
	}
	function save_group_field_data($form_values_arr, $group_id)
	{
		
		$data = array("group_id"=>$group_id);
		$this->db->insert("group_fields_submits",$data);
		$submit_id = $this->db->insert_id();
		
	 $final_array = array_values($form_values_arr);
	 $total = count($final_array);			 
	 for($i=0; $i<$total; $i++)
	 {
		 $query = "INSERT INTO group_fields_data(submit_id,group_id,form_field_name,form_field_value) VALUES ('$submit_id',".$group_id.",".$this->db->escape($final_array[$i]['name']).",".$this->db->escape($final_array[$i]['value']).")";
		$this->db->query($query);
	 } 
	 
	 $this->email_notification_group_custom_filed($form_values_arr,$group_id);
	}
	
	function email_notification_group_custom_filed($fields,$group_id)
	{
		//echo "<pre>";	print_r($_REQUEST); 	die();
		if(isset($_SESSION['login_info']['customer_id']) && !empty($_SESSION['login_info']['customer_id']))
		{
			$customer_id = $_SESSION['login_info']['customer_id'];
		}
		else
		{
			$customer_id = $_REQUEST['customer_id'];
		}
		$q = "SELECT u.user_email, u.user_id,g.group_name
				FROM groups AS g
				JOIN groups_sites_xref gs ON g.id = gs.group_id
				JOIN sites AS s ON gs.site_id = s.site_id
				JOIN users AS u ON u.user_id = s.user_id
				WHERE g.id = '$group_id'
				GROUP BY u.user_id
				";
		$r = $this->db->query($q); 
		$row = $r->row_array();
		
		$q2 = "SELECT 
		CONCAT (customer_fname,' ',customer_lname) AS name,
		customer_email AS email 
		FROM ec_customers 
		WHERE customer_id = '$customer_id' ";
		$r2 = $this->db->query($q2);
		$row2 = $r2->row_array(); 
		$user_name = $row2['name'];
		$email = $row2['email'];
		// echo "<pre>";	print_r($row2); 	die();
		$site_admin = "";
		if($row)
		{
			$site_admin = $row['user_email'];
			$name = $row['group_name'];
		}
		
				
		$msg2 = '<table border="0">
					  <tr>
						<th colspan="2" scope="col" align="left">Group Information</th>
					  </tr>
					  <tr>
						<td>Group Name:</td>
						<td> '.$name.' </td>
					  </tr>
					  <tr height="10px">
						<td colspan="2">Group From was successfully submitted</td>
						<td>&nbsp;</td>
					  </tr>
				</table>';
				
		$msg = "";
		$msg .= '<table border="0">
					  <tr>
						<th colspan="2" scope="col" align="left">Group Information</th>
					  </tr>
					  <tr>
						<td>Group Name:</td>
						<td> '.$name.' </td>
					  </tr>
					  <tr height="10px">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>';
		//echo "<pre>";	print_r($fields); 	die();
		foreach($fields as $row)
		{			  
			$msg .= '<tr height="10px">
						<td>'.$row['name'].'</td>
						<td>'.$row['value'].'</td>
					  </tr>';
		}
		$msg .= '</table><br><br>';
		$msg3 = "";
		if(isset($user_name) || isset($email))
		{
			$msg3 .= '<table border="0">
						  <tr>
							<th colspan="2" scope="col" align="left">User Information</th>
						  </tr>
						  <tr>
							<td>Name:</td>
							<td> '.$user_name.' </td>
						  </tr>
						  <tr>
							<td>Email:</td>
							<td>'.$email.'</td>
						  </tr>
						</table>';
			$msg .= $msg3;
		
		}	
		
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailtype'] = "html";
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		
		$this->email->from('support@webpowerup.com');
		$this->email->subject('Webpowerup');
		
		$this->email->message($msg);   
		$this->email->to($site_admin);		
		$this->email->send();
		
		$this->email->message($msg2);   
		$this->email->to($customer_id);		
		$this->email->send();
	}
	
	
	function get_groups_by_site_id($site_id)
	{
			$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' ";
			 $r = $this->db->query($qry);
			 if ($r->num_rows() > 0)
			 {
			  	$groups = $r->result_array();
				return $groups;
			 }
			 return false;
	}
	
	function delete_group($group_id,$site_id)
	{
		
		
		// delete support ticket department of this group
		$this->db->where('d_group_id', $group_id);
		$this->db->delete('support_department'); 
		
		// delete customer relation of this group 
		$this->db->where('group_id', $group_id);
		$this->db->delete('ec_customers_group_xref'); 
		
		// delete site relation of this group 
		$this->db->where('group_id', $group_id);
		$this->db->delete('groups_sites_xref');
		
		// delete site relation of this group 
		$this->db->where('group_id', $group_id);
		$this->db->delete('groups_sites_xref');
		
		// delete group page
		$this->db->where('page_groups', $group_id);
		$this->db->where('site_id', $site_id);
		$this->db->delete('pages');
		
		// delete payment detail of this group 
		$this->db->where('group_id', $group_id);
		$this->db->delete('groups_payments_details');
		
		// delete permition of this group
		$this->db->where('group_id', $group_id);
		$this->db->delete('groups_permission_xref');
		
		// delete custom field of this group 
		$this->db->where('group_id', $group_id);
		$this->db->delete('group_fields');
		
		// delete groups field submited data
		$this->db->where('group_id', $group_id);
		$tbls = array("group_fields_data","group_fields_submits");
		$this->db->delete($tbls);
		
		//  finaly delete the group 
		$this->db->where('id', $group_id);
		$r = $this->db->delete('groups'); 
		
		
		return $r;
		 
	}
	
	function send_group_notification($customer_id,$group_id)
	{
		
		
		$q = "SELECT 
		CONCAT(customer_fname,customer_lname) AS name,
		customer_email AS email 
		FROM ec_customers 
		WHERE customer_id = '$customer_id' ";
		$r = $this->db->query($q);
		$row = $r->row_array();
		
		$q = "SELECT 
		group_name,
		notify_emails
		FROM groups
		WHERE id = '$group_id' ";
		
		$r = $this->db->query($q);
		$row2 = $r->row_array();
		
		$name = $row['name'];
		$email = $row['email'];
		$group = $row2['group_name'];
		
		
		if ( $row2['notify_emails'] != "" )
		{
			$msg = $name." has joined ".$group."<br><br>";
			$msg .= '<table border="0">
					  <tr>
						<th colspan="2" scope="col" align="left">User Information</th>
					  </tr>
					  <tr>
						<td>Name:</td>
						<td> '.$name.' </td>
					  </tr>
					  <tr>
						<td>Email:</td>
						<td>'.$email.'</td>
					  </tr>
					</table>';			
			$notify_emails = explode(",",$row2['notify_emails']);
			//echo "<pre>";print_r($notify_emails);exit;
			
			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailtype'] = "html";
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from('support@webpowerup.com');
			$this->email->subject('Webpowerup');
			$this->email->message($msg);   
			
			
			$this->email->to($notify_emails);		
			$this->email->send();
			
			
		}
		
		
		return true;
	}
	
	function get_all_form_submits($group_id)
	{
		 $query = "SELECT submit_id FROM group_fields_data WHERE group_id = '$group_id' GROUP BY submit_id ";
		 $r = $this->db->query($query);
		 $n = $r->num_rows();
		
		 if($n > 0)
		 {
			 $submits = $r->result_array();
			 return $submits;
		 }
		 return false;
	}
	function get_form_submits_detail($submit_id)
	{
		$this->db->where("submit_id",$submit_id);
		$r = $this->db->get("group_fields_data");
		$n = $r->num_rows();
		if ($n > 0)
		{
			$submit = $r->result_array();
			return $submit;
		}
		return false;
		
	}
	function form_submit_delete($submit_id)
	{
		$this->db->where("submit_id",$submit_id);
		$r = $this->db->delete("group_fields_data");
		if($r)
		{
			return true;
		}
		return false;
	}
	function get_all_form_submits_for_export($group_id)
	{
		 
		 $query = "SELECT form_field_name,form_field_value FROM group_fields_data WHERE group_id = '$group_id' ";
		 $r = $this->db->query($query);
		 $n = $r->num_rows();
		 if($n > 0)
		 {
			 $result = $r->result_array();
			 return $result;
		 }
		 return false;
	}
	
	function calculate_trail_end_date($start_date, $days)
	{
		
		$date = strtotime($start_date. " +".$days." Days");
		$end_date = date("Y-m-d",$date);
		
		return $end_date;
	}
}
?>