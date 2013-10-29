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
		exit();*/
		//echo $_REQUEST["group_count_access_level"];exit;
		include_once(realpath("./").'/tokbox/flex_session_for_server.php');
		$this->$site_id = $site_id;
		$groupids = '';
		if(isset($_REQUEST["show_us_intl"]) && $_REQUEST["show_us_intl"]=='intl')
		{
			$time_zone_offset = $_REQUEST['time_zone_intl'];
		}
		else if(isset($_REQUEST["show_us_intl"]) && $_REQUEST["show_us_intl"]=='us')
		{
			$time_zone_offset = $_REQUEST['time_zone_us'];
		}
		else
		{
			$time_zone_offset = '';
		}
		//echo $time_zone_offset;exit;
		$current_time = date("Y-m-d h:i:s A");  
		//$date_tz = date('Y-m-d h:i:s A',time()-$_REQUEST["hidden_time_zone"]*3600);
		
		if(isset($_REQUEST["group_access"]))
		{
			$groupids = $_REQUEST["group_access"]; 
		}
		
		//Dynamic feilds
		$items = $_REQUEST["items"];
		
		//default_formfeilds
		$default_form_fields = $_REQUEST["default_items"];
		//$webinar_rid = rand(10000000,99999999);
		$webinar_rid = time();
		$webinar_date = '';
		if(isset($_REQUEST['webinar_date']))
			{
				$newDate = date("Y-m-d", strtotime($_REQUEST['webinar_date']));
				$webinar_date = $newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts').' '.$this->input->post('ampm');
				$timezone = new DateTimeZone($_REQUEST["hidden_time_zone"]);
				$offset = $timezone->getOffset(new DateTime("now")); 
				$offset_value =  ($offset < 0 ? '' : '+').round($offset/3600);
				//echo strtotime($webinar_date).'------'.$offset_value."<br>";
				//echo "------------------".strtotime($webinar_date)+$offset_value*3600 ."------------------";
				
				$date_tz = date('Y-m-d h:i A',strtotime($newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts'))-($offset_value*3600));				
				
			}
			//echo $webinar_data;exit;
		$webinar_data = array(
							'site_id' => $site_id,
							'presenter_id' => $_SESSION['user_info']['user_id'],
							'title' => $_REQUEST["title"],
							'email_to' => $_REQUEST["email_to"],
							'webinar_access' => $_REQUEST["webinar_access"],
							'create_date' => $current_time,
							'start_date' =>$webinar_date,
							'start_time' =>$_REQUEST["webinar_date"],
							'form_intro' => $_REQUEST["ck_content"],
							'form_thank_u' => $_REQUEST["ck_content_2"],
							'webinar_rid' => $webinar_rid,
							'server_start_time' => $date_tz,
							'time_zone_offset'	=>	$time_zone_offset,
							'webinar_session_id' => $this->db->escape_str($session_f_php)
							
							);
							
		$webinar = $this->db->insert('webinar', $webinar_data);
		$webinar_id = $this->db->insert_id();	
		
		if(empty($_POST['only_invite']) && $_POST['webinar_access']=='Other')
		{
		
			for($i = 0; $i<=$_POST['group_total']-1; $i++)
			{
				
				if(isset($_POST['user_count_'.($i)]))
				{
					 for($j = 1; $j<=$_POST['user_count_'.($i)]; $j++)
					 {
						 $a = $_POST['group_count_'.$i];
						 if(isset($_POST["child_".$a."_".$j]) && sizeof($_POST["child_".$a."_".$j]) > 0 && $_POST["child_".$a."_".$j] != false)
						 {						   
						   $existing_id = $_POST["child_".$a."_".$j];
						   $qry = "INSERT INTO webinar_existing_attendie SET existing_att_id = ".$existing_id.", webinar_rid = ".$webinar_rid."";
						   $result = $this->db->query($qry);
						 
						 }
					 }
					
				}
				if(isset($_POST['group_'.$i]))
				{
					 $query = "INSERT INTO access_levels_webinar_groups_xref(webinar_id,group_id,site_id) VALUES (".$webinar_id.",".$_POST['group_'.$i].",".$site_id.")";
					 $this->db->query($query);
				 }
			 }
		}
		
		//OLD Webinar Access Level Management
		/*if($_REQUEST["webinar_access"]== "Other")
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
		}*/
		
		
		
		
		// adding dynamic manues  
		foreach($items as $key => $item)
		{   //  is_array($items)
			if(isset($item['title']) && !empty($item['title']))
			{
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
			
				if(isset($item['type']) && $item['type'] == 'Radio Buttons')
					{
					  $name = "radio";	
					}
					else
					{
					  $name =$item['title'];
					}
				$new_item = array ($webinar_id,$title,$name,$type,$required,$order,$is_default ); 
			  
				$query = "INSERT INTO webinar_fields(webinar_id,field_title,field_name,field_type,field_required,field_sequence,is_default) VALUES (?,?,?,?,?,?,?)";
				$this->db->query($query,$new_item ); 
				$id2 = $this->db->insert_id();
				 
				if (array_key_exists('type', $item) && $type == 'Single-Line Text')
				{   
					if(isset($_POST['text_datatype'][$key]))
					{
						$this->form_fields_value_save($_POST['text_datatype'][$key], $id2);
					}	
				}
				
				if (array_key_exists('type', $item) && $type == 'Multi-Line Text')
				{
					
	
					if(isset($_POST['textarea'][$key]))
					{
					  $textarea = implode(",", $_POST['textarea'][$key]);
					  $this->form_fields_value_save($textarea, $id2);
						
					}
				}
				
				
				if (array_key_exists('type', $item) && $type == 'Check Boxes')
				{
					if(isset($_POST['checkbox_items'][$key]))
					{
						for($i = 0; $i < count($_POST['checkbox_items'][$key]); $i++)
						{
						  $this->form_fields_value_save($_POST['checkbox_items'][$key][$i]['title'], $id2);
						}
					}
				}
				
				if (array_key_exists('type', $item) && $type == 'Radio Buttons')
				{
					if(isset($_POST['radio_items'][$key]))
					{
						for($i = 0; $i < count($_POST['radio_items'][$key]); $i++)
						{
						  $this->form_fields_value_save($_POST['radio_items'][$key][$i]['title'], $id2);
						}
					}
				}
			}
				 
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
			//$this->db->query($query,$new_item ); 
		    
						 
		}
		//exit;
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
							'customer_password' => md5(rand (80000000,99999999)),
							'registered_date' =>  date('Y-m-d h-i-s')
							);
							$this->db->insert('ec_customers',$data);
							$this->customer_id = $this->db->insert_id();							
							//$this->customer_id = $this->customer_id * 2;
							$data_xref = array(
							'customer_id' => trim($this->customer_id),
							'site_id' => trim($site_id)
							);
							
							
							$private_customer_save = array(
							'webinar_rid' => $webinar_rid, 
							'existing_att_id' => trim($this->customer_id)							
							);
							
							
							$this->db->insert('ec_customers_site_xref',$data_xref);
							$this->db->insert('webinar_existing_attendie',$private_customer_save);
							$new_customers_id[] =  $this->customer_id;     	
				}
			}
		}
		
		$qry = "SELECT ec.customer_email,ec.customer_id
                FROM ec_customers ec
                JOIN webinar_existing_attendie w ON ec.customer_id = w.existing_att_id
                WHERE w.webinar_rid =".$webinar_rid."";
		
		$q = $this->db->query($qry);
		$result = $q->result_array();
	     
		//Send mail to webinar users
		$user_email_access = $_REQUEST["webinar_access"];
		if(!empty($_POST['only_invite']) && $_POST['only_invite']=='only')
		{
			$user_email_access = $_POST['only_invite'];
		}
		$this->send_mail_attendee($webinar_id, $_REQUEST["title"], $_REQUEST["ck_content"], $webinar_date, $result,  $user_email_access, $site_id, $new_customers_id, $webinar_rid);
		
		return $webinar_id ;	
	}
	
	 function form_fields_value_save($field_value, $id)
     {
         
		   $values_ary = array($id,$field_value);
            $query_str = "INSERT INTO webinar_fields_options(field_id,option_value) VALUES (?,?)";
           $this->db->query($query_str,$values_ary );   
         
     }
	
	function save_edit_existing_users($id)
	{
		
		/*echo "<pre>";
		print_r($_REQUEST);
		exit;*/
		$qry = "SELECT site_id, webinar_rid FROM webinar where id=".$id."";
		$qry = $this->db->query($qry);
		$q   = $qry->result_array();
		/*echo "<pre>";
		print_r($q);
		exit;*/
	    $webinar_rid = $q[0]['webinar_rid'];
		$site_id = $q[0]['site_id'];
		
		
		if(empty($_POST['only_invite']) && $_POST['webinar_access']=='Other')
		{
		
			$qry = "DELETE FROM webinar_existing_attendie WHERE webinar_rid = ".$webinar_rid."";
			$q = $this->db->query($qry);	
			for($i = 0; $i<=$_POST['group_total']-1; $i++)
			{
				if(isset($_POST['user_count_'.($i)]))
				{ 
					 for($j = 1; $j<=$_POST['user_count_'.($i)]; $j++)
					 {
						 $a = $_POST['group_count_'.$i];
						 if(isset($_POST["child_".$a."_".$j]) && sizeof($_POST["child_".$a."_".$j]) > 0 && $_POST["child_".$a."_".$j] != false)
						 {
						   $existing_id = $_POST["child_".$a."_".$j];
						   $qry = "INSERT INTO webinar_existing_attendie SET existing_att_id = ".$existing_id.", webinar_rid = ".$webinar_rid."";
						   $result = $this->db->query($qry);				 
						 }
					 }
				}
			 }
		} 
		 
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
							'customer_password' =>  md5(rand (80000000,99999999)),
							'registered_date' =>  date('Y-m-d h-i-s')
							);
							$this->db->insert('ec_customers',$data);
							$this->customer_id = $this->db->insert_id();							
							//$this->customer_id = $this->customer_id * 2;
							$data_xref = array(
							'customer_id' => trim($this->customer_id),
							'site_id' => trim($site_id)
							);
							$private_customer_save = array(
							'webinar_rid' => $webinar_rid, 
							'existing_att_id' => trim($this->customer_id)							
							);
							
							$this->db->insert('ec_customers_site_xref',$data_xref);
							$this->db->insert('webinar_existing_attendie',$private_customer_save);
							$new_customers_id[] =  $this->customer_id;     	
				}
			}
		}
		
		$qry = "SELECT ec.customer_email,ec.customer_id
                FROM ec_customers ec
                JOIN webinar_existing_attendie w ON ec.customer_id = w.existing_att_id
                WHERE w.webinar_rid =".$webinar_rid."";
		
		$q = $this->db->query($qry);
		$result = $q->result_array();
	     
		//Send mail to webinar users
		if(isset($_REQUEST['webinar_date']))
			{
				$newDate = date("Y-m-d", strtotime($_REQUEST['webinar_date']));
				$webinar_date = $newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts').' '.$this->input->post('ampm');
			}
		
		$user_email_access = $_REQUEST["webinar_access"];
		if(!empty($_POST['only_invite']) && $_POST['only_invite']=='only')
		{
			$user_email_access = $_POST['only_invite'];
		}
		//print_r($new_customers_id);exit;
		$this->send_mail_attendee($id, $_REQUEST["title"], $_REQUEST["ck_content"], $webinar_date, $result,  $user_email_access, $site_id, $new_customers_id, $webinar_rid);
		 //echo $webinar_rid;exit;
		 
		 return $webinar_rid;
	
	}
	
    function get_form_fields($id)
    {
      $query_string = "SELECT * FROM webinar_fields_options o
				       JOIN  webinar_fields f
				       ON f.id = o.field_id
				       WHERE f.webinar_id = ".$id."
					   AND field_delete ='0' 
					   order by field_sequence ASC";
       $q = $this->db->query($query_string); 
       $data = array ();
       $data =$q->result_array();
       return $data;  
        
        
    }
	
	function get_form_fields_options($id)
	{
		
		 $record = array();
		 $index = 0;
		 $query = "SELECT * FROM webinar_fields_options o
				   JOIN  webinar_fields f
				   ON f.id = o.field_id
				   WHERE f.webinar_id = ".$id."
				   AND f.field_type = 'Single-Line Text'";
		
	    $row = $this->db->query($query);
		$record['single_line'] = $row->result_array();
		
		 $query = "SELECT * FROM webinar_fields_options o
				   JOIN  webinar_fields f
				   ON f.id = o.field_id
				   WHERE f.webinar_id = ".$id."
				   AND f.field_type = 'Multi-Line Text'";
	    $row = $this->db->query($query);
		$record['Multi_line'] = $row->result_array();
		
		 $query = "SELECT * FROM webinar_fields_options o
				   JOIN  webinar_fields f
				   ON f.id = o.field_id
				   WHERE f.webinar_id = ".$id."
				   AND f.field_type = 'Radio Buttons'";
	    $row = $this->db->query($query);
		$record['Radio_Buttons'] = $row->result_array();
		 $query = "SELECT * FROM webinar_fields_options o
				   JOIN  webinar_fields f
				   ON f.id = o.field_id
				   WHERE f.webinar_id = ".$id."
				   AND f.field_type = 'Check Boxes'";
	    $row = $this->db->query($query);
		$record['Check_Boxes'] = $row->result_array();
	
	    return $record;	 
				   
	}
	
	function get_user_by_group_id($id=0)
	{
			$rows = array();
			$gruop_id = 0;
			/*$this->db->select('customer_id,customer_email,customer_fname,customer_lname');
			$this->db->where('membershipid',intval($id));*/
			$query = $this->db->query("SELECT ec_customers . * , ec_customers_group_xref.group_id
FROM ec_customers
LEFT JOIN ec_customers_group_xref ON ec_customers.customer_id = ec_customers_group_xref.customer_id
WHERE ec_customers.customer_id =".intval($id)."
OR ec_customers_group_xref.group_id =".intval($id)."");
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
	function send_mail_attendee($webinar_id, $title, $content, $start_date, $group_ids='', $webinar_access, $site_id, $new_customers_id, $webinar_rid)
		{
	
			//common data
			$message = "<table width='600' border='0'><tr><td>Webinar Title: </td><td>".$title."</td></tr><tr><td>Start Date & Time:</td><td>".$start_date."</td></tr><tr><td>Message</td><td>".$content."</td></tr></table>";
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
				$qry = "INSERT INTO webinar_existing_attendie SET existing_att_id = ".$_SESSION['user_info']['user_id'].", webinar_rid = ".$webinar_rid."";
				$result = $this->db->query($qry);
				$body = $message."<b>Presenter Meeting Email</b><br/><a href='".base_url().index_page()."broadcast/GWSWhiteboard.html#webinarID=".$webinar_rid."&attendee_id=".($_SESSION['user_info']['user_id']*2)."'>Join Webinar</a>";
				$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');				
				$this->email->subject($subject);
				$this->email->message($body);	
				$this->email->to($_SESSION['user_info']['user_email']); 
				$send = $this->email->send();
				$body = '';
			
			//echo $webinar_access;exit;
			if(isset($webinar_access) && $webinar_access == 'Other')
			{		
		
						//Group users	
			
						foreach($group_ids as $id => $mail)
						{
							//$id_messg = '';
							//$dear = "Dear <b>".$customer_rec[$i]['customer_fname']." ".$customer_rec[$i]['customer_lname']."!</b><br><br><br>";
							$body = $message."<br/><a href='".base_url().index_page()."broadcast/GWSWhiteboard.html#webinarID=".$webinar_rid."&attendee_id=".($mail['customer_id']*2)."'>Join Webinar</a>";					
							//$body .= $id_messg;
							$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');
							$this->email->subject($subject);
							$this->email->message($body);	
							$this->email->to($mail['customer_email']); 
							$send = $this->email->send();
							$body = '';			
					
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
					$dear = "Dear <b>".$customer_rec[$i]['customer_fname']." ".$customer_rec[$i]['customer_lname']."!</b><br><br><br>";
					$body = $dear.$message."<br/><a href='".base_url().index_page()."broadcast/GWSWhiteboard.html#webinarID=".$webinar_rid."&attendee_id=".$customer_rec[$i]['customer_id']* 2 ."'>Join Webinar</a>";
					$qry = "INSERT INTO webinar_existing_attendie SET existing_att_id = ".$customer_rec[$i]['customer_id'].", webinar_rid = ".$webinar_rid."";
					$result = $this->db->query($qry);
					$all_customer[] = $customer_rec[$i]['customer_id'];
					$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');
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
					
					if(empty($customer_rec[$i]['customer_fname']))
					{
						$dear = "<b>Webinar Invitation Please Join!</b><br>";
					}
					else
					{
						$dear = "Dear <b>".$customer_rec[$i]['customer_fname']." ".$customer_rec[$i]['customer_lname']."!</b><br>";
					}
					$body = $dear.$message."<br/><a href='".base_url().index_page()."broadcast/GWSWhiteboard.html#webinarID=".$webinar_rid."&attendee_id=".$customer_rec[$i]['customer_id']* 2 ."'>Join Webinar</a>";
					$qry = "INSERT INTO webinar_existing_attendie SET existing_att_id = ".$customer_rec[$i]['customer_id'].", webinar_rid = ".$webinar_rid."";
					$result = $this->db->query($qry);
					$all_customer[] = $customer_rec[$i]['customer_id'];
					$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');
					$this->email->subject($subject);
					$this->email->message($body);
					$this->email->to($customer_rec[$i]['customer_email']);
				 	$send = $this->email->send();
					$body = '';
					
				}			
			}
			else if(isset($webinar_access) && $webinar_access == 'only')
			{	
			
				for($i = 0; $i<count($new_customers_id); $i++)
				{
					//echo $new_customers_id[$i];
					$customer_rec = $this->get_all_customer_by_site_id($new_customers_id[$i], $site_id);
					//print_r($customer_rec);
					//echo "<pre>";
					if(empty($customer_rec[$i]['customer_fname']))
					{
						$dear = "<b>Webinar Invitation Please Join!</b><br>";
					}
					else
					{
						$dear = "Dear <b>".$customer_rec[$i]['customer_fname']." ".$customer_rec[$i]['customer_lname']."!</b><br>";
					}
					$body = $dear.$message."<br/><a href='".base_url().index_page()."broadcast/GWSWhiteboard.html#webinarID=".$webinar_rid."&attendee_id=".$customer_rec[$i]['customer_id']* 2 ."'>Join Webinar</a>";
					$qry = "INSERT INTO webinar_existing_attendie SET existing_att_id = ".$customer_rec[$i]['customer_id'].", webinar_rid = ".$webinar_rid."";
					$result = $this->db->query($qry);
					$all_customer[] = $customer_rec[$i]['customer_id'];
					$this->email->from('join_meeting@webpowerup.com', 'WebpowerUp');
					$this->email->subject($subject);
					$this->email->message($body);
					$this->email->to($customer_rec[$i]['customer_email']);
				 	$send = $this->email->send();
					$body = '';
					//exit;
				}
			}
			//echo print_r($new_customers_id);exit;				
			//print_r($all_customer);
			//exit;			
			return true;
		
		
		}
		
	function get_all_meeting_user($rid)
	{
		$qry = "SELECT e.existing_att_id
                FROM  webinar_existing_attendie e
                JOIN webinar w ON w.webinar_rid = e.webinar_rid
                WHERE w.id =".$rid."";
		
		$q = $this->db->query($qry);
		$result = $q->result_array();
		return $result;
	
		
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
			/*$query_string = "SELECT * FROM webinar_fields_options o
				       JOIN  webinar_fields f
				       ON f.id = o.field_id
				       WHERE f.webinar_id = ".$webinar_id."
					   AND field_delete ='0' 
					   order by field_sequence ASC";*/			
		}
		//echo $query_string;exit; 
		
		 $dataset = $this->db->query($query_string);
		 //echo "<pre>";print_r($dataset->result());exit;
		 
		  if($dataset->num_rows() > 0) {
			$output = array();
			$index = 0;
			$child_radio =array();
			$child_box =array();
			foreach($dataset->result() as $items)
			{
			
			//echo "<pre>";print_r($dataset->result());exit;

			   if ($items->field_type == 'Check Boxes'){
			   
			   		$query_radio = "SELECT * FROM webinar_fields_options o JOIN  webinar_fields f  ON f.id = o.field_id WHERE f.webinar_id = ".$items->webinar_id." AND o.field_id = ".$items->id." AND f.field_type = 'Check Boxes'";
					$row = $this->db->query($query_radio);
					$checkboxes = $row->result_array();
					//echo "<pre>";print_r($record['radio']);exit;
					$child_index = 0;
					$output[$index]['label'] = $items->field_title;
					$output[$index]['field_id'] = $items->id;
					$output[$index]['required'] =  $items->field_required;
					foreach($checkboxes as $boxes)
					{
						
						$child_box[$child_index]['id'] = '<input id="'.$boxes['field_id'].'" type="hidden" name="field['.$child_index.'][name]" value = "'.$boxes['option_value'].'" >';
						$child_box[$child_index]['label'] =  $boxes['option_value'];
						$child_box[$child_index]['field'] =  '<input id="check" type="checkbox" name="field['.$child_index.'][value]" >';
						$child_index++;
				   }
				   $output[$index]['options'] = $child_box;	
				    
			   }else if($items->field_type == 'Radio Buttons'){
			   		
			   		$query_box = "SELECT * FROM webinar_fields_options o JOIN  webinar_fields f  ON f.id = o.field_id WHERE f.webinar_id = ".$items->webinar_id." AND o.field_id = ".$items->id." AND f.field_type = 'Radio Buttons'";
					
					$row = $this->db->query($query_box);
					$radios = $row->result_array();
					$child_index = 0;
					$output[$index]['label'] =  $items->field_title;
					$output[$index]['field_id'] = $items->id;
					$output[$index]['required'] = $items->field_required;
					foreach($radios as $radio)
					{
						
						$child_radio[$child_index]['id'] = '<input id="'.$radio['field_id'].'" type="hidden" name="field['.$child_index.'][name]" value = "'.$radio['option_value'].'" >';
						$child_radio[$child_index]['label'] =  $radio['option_value'];
						$child_radio[$child_index]['field'] = '<input id="" type="radio" value="" name="field['.$radio['field_id']."_radio".']" >';
						$child_index++;
						
				   }
				   $output[$index]['options'] = $child_radio;
					//echo "<pre>";print_r($output);exit;
					/*$output[$index]['id'] = '<input id="'.$items->id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >';  
					$output[$index]['label'] =  $items->field_title;
					$output[$index]['field'] =  '<input id="" type="radio" value="" name="field['.$index.'][value]" >';
					$output[$index]['required'] =  $items->field_required; */   
				   
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
			//echo "<pre>";print_r($output);exit;
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
			$data[$i]["fields"] = $custom_field_array;
			
			
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
		/*echo "<pre>";
		print_r($_REQUEST);
		exit;*/
		$current_time = date("Y-m-d h:i:s A", time());
		
		$machinedatetime = explode('GMT',$_REQUEST['machine_time']);		
		//current time of user machine
		//echo "<br>".date('Y-m-d h:i A',strtotime($machinedatetime[0]))."<br>";
		//current time of user machine
		if(isset($_REQUEST["show_us_intl"]) && $_REQUEST["show_us_intl"]=='intl')
		{
			$time_zone_offset = $_REQUEST['time_zone_intl'];
		}
		else if(isset($_REQUEST["show_us_intl"]) && $_REQUEST["show_us_intl"]=='us')
		{
			$time_zone_offset = $_REQUEST['time_zone_us'];
		}
		else
		{
			$time_zone_offset = '';
		}
		$webinar_date = '';
		if(isset($_REQUEST['webinar_date']))
			{
				$newDate = date("Y-m-d", strtotime($_REQUEST['webinar_date']));
				$webinar_date = $newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts').' '.$this->input->post('ampm');//echo "<br>";
				//echo "<br>".$_REQUEST["hidden_time_zone"]."<br>";
				//$date_tz = date('Y-m-d h:i A',strtotime($webinar_date)-$_REQUEST["hidden_time_zone"]*3600);
				//echo $_REQUEST["hidden_time_zone"];
				$timezone = new DateTimeZone($_REQUEST["hidden_time_zone"]);//echo "<br>";
				$offset = $timezone->getOffset(new DateTime("now"));
				//echo $timezone->getName(); 
			 	$offset_value =  ($offset < 0 ? '' : '+').round($offset/3600);
				//echo strtotime($webinar_date).'****'.$offset_value."<br>";
				//echo "------------------".strtotime($webinar_date)+$offset_value*3600 ."------------------";
				//echo "<br>".($offset_value*3600)."---";
			 	$date_tz = date('Y-m-d h:i A',strtotime($newDate.' '.$this->input->post('r_hours').':'.$this->input->post('r_minuts'))-($offset_value*3600));
			}
		
		$webinar_data = array(
							 //'site_id' => $site_id,
							'title' => $_REQUEST["title"],
							'presenter_id' => $_SESSION['user_info']['user_id'],
							'email_to' => $_REQUEST["email_to"],
							'webinar_access' => $_REQUEST["webinar_access"],
							'create_date' => $current_time,
							'start_date' =>$webinar_date,
							'start_time' =>$_REQUEST["webinar_date"],
							'form_intro' => $_REQUEST["ck_content"],
							'server_start_time' => $date_tz,
							'time_zone_offset'	=>	$time_zone_offset,
							'form_thank_u' => $_REQUEST["ck_content_2"]
							);
							
		$webinar = $this->db->update('webinar', $webinar_data,  array('id' => $webinar_id));
		if($webinar)
		{
			
			//Access Level Updation
			/*if($_POST["webinar_access"] == "Other")
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
				
				
			}*/
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
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
			
			if(isset($_REQUEST["items"]) && !empty($_REQUEST["items"]))
			{			
				$items = $_REQUEST["items"];
				//print_r($items);exit;			  
				foreach($items as $key => $item)
				{   //  is_array($items)
					
					if(isset($item['title']) && !empty($item['title']))
					{
						if(isset($item)){
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
						$id2 = $this->db->insert_id();
					 
					if (array_key_exists('type', $item) && $type == 'Single-Line Text')
					{   
						if(isset($_POST['text_datatype'][$key]))
						{
							$this->form_fields_value_save($_POST['text_datatype'][$key], $id2);
						}	
					}
					
					if (array_key_exists('type', $item) && $type == 'Multi-Line Text')
					{
						
						if(isset($_POST['textarea'][$key]))
						{
						  $textarea = implode(",", $_POST['textarea'][$key]);
						  $this->form_fields_value_save($textarea, $id2);
							
						}
					}
					
					
					if (array_key_exists('type', $item) && $type == 'Check Boxes')
					{
						if(isset($_POST['checkbox_items'][$key]))
						{
							for($i = 0; $i < count($_POST['checkbox_items'][$key]); $i++)
							{
							  $this->form_fields_value_save($_POST['checkbox_items'][$key][$i]['title'], $id2);
							}
						}
					}
				}
				if (array_key_exists('type', $item) && $type == 'Radio Buttons')
				{
					if(isset($_POST['radio_items'][$key]))
					{
						for($i = 0; $i < count($_POST['radio_items'][$key]); $i++)
						{
						  $this->form_fields_value_save($_POST['radio_items'][$key][$i]['title'], $id2);
						}
					}
				}
			  }
			}
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
		
		
			return $webinar_id;
		}
		
	}
	
	 function form_fields_value_update($field_value, $id)
     {
        $query_str = "UPDATE webinar_fields_options SET option_value = '".$field_value."' WHERE field_id = ".$id."";
        $this->db->query($query_str);   
         
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
						'customer_password' =>  md5(rand (80000000,99999999)),
						'registered_date' =>  date('Y-m-d h-i-s')
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

	function check_customer_webinar($site_id, $attendee_id)
	{
		$q = '';
		$exist = 0;
		//echo $customer_id;
		$query_string = "SELECT * FROM webinar INNER JOIN webinar_existing_attendie ON webinar.webinar_rid = webinar_existing_attendie.webinar_rid WHERE webinar_existing_attendie.existing_att_id = ".$attendee_id." AND webinar.start_date >='".date('Y-m-d h-i-s')."'";
        $q = $this->db->query($query_string);
        if($q->num_rows() > 0)
		{
			$webinar_data = $q->result_array();
			/*for($i = 0; $i<count($webinar_data); $i++)
			{
				$webinar_users = explode(',', $webinar_data[$i]['attendee_id']);
				$exist = in_array($attendee_id,$webinar_users);
				if($exist)
				{
					$exist++;
				}
				//print_r($room_users);
			}*/
			return $webinar_data;			
		}
		return false;
	}
	
	function get_user_webinar($site_id, $attendee_id)
	{
		$q = '';
		$exist = 0;
		//echo $customer_id;exit;
			$query_string = "SELECT * FROM webinar INNER JOIN webinar_existing_attendie ON webinar.webinar_rid = webinar_existing_attendie.webinar_rid WHERE webinar_existing_attendie.existing_att_id = ".$attendee_id." AND webinar.is_deleted = 0 AND webinar.site_id = $site_id AND webinar.start_date >='".date('Y-m-d h-i-s')."'";
        $q = $this->db->query($query_string);
        if($q->num_rows() > 0)
		{
			$webinar_data = $q->result_array();
			//echo "<pre>";
			//print_r($room_data);exit;
			$count = 0;
			/*for($i = 0; $i<count($webinar_data); $i++)
			{
				$webinar_users = explode(',', $webinar_data[$i]['attendee_id']);
				$exist = in_array($attendee_id,$webinar_users);				
				if($exist)
				{
					
					$webinar_array[] = $webinar_data[$i];					
				}
				//print_r($room_users);
			
			}*/
			
			return $webinar_data;
		}
		return false;
	}
	
	function get_site_gropus_customer_by_site_id($site_id, $type=0,$webinar_call = 0)
	{
			$group_data = array();
			$data = '';			
			$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' AND gp.is_disabled = 'No' AND gp.is_deleted = 'No' ";
			$Q = $this->db->query($qry);
			$i = 0;
			if ($Q->num_rows() > 0)
			{
				$groups_array = $Q->result_array();			
				$i = 0;
			   foreach ($groups_array as $row)
			   {
					//echo "<pre>";	print_r($row);	echo "</pre>";die();
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
							$member_array[$record['customer_id']] = $record['customer_email'];
						}
							$groups_array[$i]['users'] = $member_array;
							$member_array 			   = array();
													
					 }
					 else
					 {
						 //no customers registered to this group
						$groups_array[$i]['users'] = 0;
					 }
					 $i++;				
			   }			  
			}			
			if(isset($i))
			{
				$groups_array[$i]['group_name']='Registered Users';
				$groups_array[$i]['id']=time();
				$groups_array[$i]['users'] = $this->get_site_registered_user_by_site_id($site_id);
			}			
			
			return $groups_array;
	}
	
	function get_site_registered_user_by_site_id($site_id, $type=0,$webinar_call = 0)
	{
		$data = '';
		$Q = $this->db->query("SELECT c.customer_id, c.customer_login, c.customer_name, c.customer_email
                               FROM  `ec_customers` AS c
                               WHERE c.site_id =".$site_id."");
							   
		if($Q->num_rows() > 0)
		{
		  	$row = $Q->result_array();
			foreach($row as $result)
			{
				$qry = $this->db->query("SELECT * 
                                         FROM ec_customers_group_xref 
                                         WHERE customer_id = ".$result['customer_id']."");
				$qry = $qry->result_array();
				if(!$qry)
				{
					$data[$result['customer_id']] = $result['customer_login'];
				}
			}
			return $data;
		}
	}
	
	function getAllTimeZone()
	{
		//$data = array();
		$qry = $this->db->query("SELECT * FROM time_zone_locations");
				$qry = $qry->result_array();
				if($qry)
				{
					return $qry;
				}
			
			return $qry;
	}
	
	
}
?>