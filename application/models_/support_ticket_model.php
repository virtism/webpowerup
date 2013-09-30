<?php
  class support_ticket_model extends CI_Model{
      
       function __construct()
	   {
		  parent::__construct();
          $this->load->helper('date');
		  $this->load->library('email'); 
       }
      
      
      function add_ticket()
      {
          
		  
		  $t_open_date =  date("Y-m-d H:i:s");
		  $site_id = (isset ($_SESSION['site_id']) ) ? $_SESSION['site_id'] : 0 ;
 		  
		  
		  $q = "SELECT * FROM support_tickets WHERE t_site_id =".$site_id;
		  $r = $this->db->query($q);
		  $t_no = $r->num_rows();
		  
		  // $t_no = rand(0,1000);  // random ticket number
		 
		  if(isset($_SESSION["current_site_info"]['user_id']) )
		  {
				$t_owner = $_SESSION["current_site_info"]['user_id'];
		  }
		  else if( isset($_SESSION["user_info"]['user_id']) )
		  {
			  $t_owner = $_SESSION["user_info"]['user_id'];
		  }
		  else
		  {
		  		$t_owner = 0;
		  }
		  
          $data = array(
               't_no' =>  $t_no ,
			   "t_site_id" =>  $site_id,
			   "t_uid" => $this->input->post('t_uid'),
			   "t_owner" => $t_owner,
			   't_email' => $this->input->post('t_email'),
               't_subject' => $this->input->post('t_subject'),
			   "t_priority" => $this->input->post('t_priority'),
               't_department_id' => $this->input->post('t_department_id'),
			   "t_body" => $this->input->post('t_detail'), 
			   "t_open_date" => $t_open_date
            );

          $r = $this->db->insert('support_tickets', $data);
         
          if($r)
          {
              $dptID = $this->input->post('t_department_id');
			  
			 
              $q = $this->db->get_where("support_department", array('d_id' => $dptID) );
              if($q->num_rows() > 0)
              {
                  $row = $q->result_array();
                  $groupId = $row[0]['d_group_id'];
				  $depName = $row[0]['d_name'];
				  $notifications = $row[0]['d_email_notification'];
				  
				  $this->department_notification($notifications,$depName);        
              }
			  else
			  {
			  	  $groupId = 0;
			  }
              
			  if($groupId != 0)
			  {
				  $q2 = $this->get_all_group_members($groupId);
				  
				  //	echo "<pre>";		print_r($q2->result_array() );		die();
				  if($q2->num_rows() > 0)
				  {
					  foreach($q2->result() as $row )
					  {
						  $email = $row->customer_email;
						  if($email != "")
						  {
						  		$this->emailToDepartmentGroupMember($email);
						  }
					  }
					  //die();
				  }
			  }
			 
              
          }
		  
		  
		  
		  $this->emailToUser($this->input->post('t_email'));
		  $this->email_to_administrator();
		  
		  return $r;
      }
      function department_notification($notifications,$depName)
	  {
		  	$email_list = explode(",",$notifications);
			
		  	$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = "html";
			$this->email->initialize($config);
			
			$this->email->from('support@webpowerup.com', 'support@webpowerup.com');
			$this->email->to($email_list);
			$this->email->subject('Support Ticket');
			
			$ticket_id = $this->db->insert_id();
			$r = $this->get_ticket_by_id($ticket_id);
			if($r->num_rows() > 0)
			{
			
				foreach($r->result_array() as $row )
				{
					$ticketSub = $row['t_subject'];
					$ticketNum = $row['t_no'];
					$ticketDep_id = $row['t_department_id'];
				}
			}
			
			$email_msg = "A Ticket with subject: <strong>".$ticketSub."</strong> and ticket Number: <strong>".$ticketNum."</strong> ";
			$email_msg .= "have been assigned to <strong>".$depName."</strong> department";
			
			$this->email->message($email_msg);    
			
			$this->email->send();
	  }
	  function emailToUser($email)
      {
                
            $config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = "html";
			$this->email->initialize($config);
			
			$this->email->from('support@webpowerup.com', 'support@webpowerup.com');
			$this->email->to($email);
			$this->email->subject('Support Ticket');
			
			$ticket_id = $this->db->insert_id();
			$r = $this->get_ticket_by_id($ticket_id);
			if($r->num_rows() > 0)
			{
			
				foreach($r->result_array() as $row )
				{
					$ticketSub = $row['t_subject'];
					$ticketNum = $row['t_no'];
					$ticketDep_id = $row['t_department_id'];
				}
			}
			
			$email_msg = "You created a ticket \n";
			$email_msg .= "Your Ticket Number is ".$ticketNum." \n";
			
			$this->email->message($email_msg);    
			
			$this->email->send();
        
      }
		
      function emailToDepartmentGroupMember($email)
      {
		    
                
            $config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from('support@webpowerup.com', 'support@webpowerup.com');
			$this->email->to($email);
			$this->email->subject('Support Ticket');
			
			$email_msg = "A Ticket ";
			$email_msg .= "was assigned to your department";
			
			$this->email->message($email_msg);    
			
			$this->email->send();
        
      }
	  
	  function get_user_id_by($site_id)
	  {
			//$qry = 'SELECT user_id, FROM sites WHERE site_id ='.$this->db->escape($site_id);
			
			$this->db->where('site_id', $site_id); 
			$rslt = $this->db->get("sites");
			if($rslt->num_rows()>0)
			{
				$row = $rslt->row_array();
				$user_id = $row['user_id'];    
			}
			else
			{
				$user_id = '0';
			}
			return $user_id;		
	  }
	  
	  function get_user_email_by_id($user_id)
	  {
			
			$q = "SELECT user_email FROM users WHERE user_id = '$user_id' ";
			$r = $this->db->query($q);
			if($r->num_rows()>0)
			{
				$row = $r->row_array();
				$user_email = $row['user_email'];    
			}
			else
			{
				$user_email = "";
			}
			return $user_email;		
	  }
	
	  function email_to_administrator()
	  {
	  		$site_id = $_SESSION['site_id'];
			$user_id = $this->get_user_id_by($site_id);
			$user_email = $this->get_user_email_by_id($user_id);
			
			$ticket_id = $this->db->insert_id();
			$r = $this->get_ticket_by_id($ticket_id);
			

			if($r->num_rows() > 0)
			{
			
		
				foreach($r->result_array() as $row )
				{
					$ticketSub = $row['t_subject'];
					$ticketNum = $row['t_no'];
					$ticketDep_id = $row['t_department_id'];
				}
			}
			$depResult = $this->get_department_id($ticketDep_id);
			if($depResult->num_rows() > 0)
			{
				foreach($depResult->result_array() as $row )
				{
					$depName = $row['d_name'];
				}
			}
			
			
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from('support@webpowerup.com', 'support@webpowerup.com');
			$this->email->to($user_email);
			$this->email->subject('Support Ticket');
			
			$email_msg = "Ticket with subject: ".$ticketSub."";
			$email_msg .= " and ticket Number: ".$ticketNum."";
			$email_msg .= " have been assigned to ".$depName."";
			$email_msg .= " department.";
			
			$this->email->message($email_msg);    
			$this->email->send();

			//echo $this->email->print_debugger();
	  }  
	  
	  
	  function get_ticket_by_id($ticket_id)
	  {
		$this->db->where("t_id",$ticket_id);
		$query =$this->db->get('support_tickets');
		return $query;
	  }
	  
      function get_all_group_members($group_id)
      {
         /*
         $q = $this->db->get_where("ec_customers " , array( "membershipid " => $group_id) );
         return $q;
		 */
		 $query = "SELECT 
		 egx.customer_id,
		 egx.group_id,
		 c.customer_id,
		 c.customer_email
		 FROM ec_customers_group_xref AS egx
		 JOIN ec_customers AS c
		 ON c.customer_id = egx.customer_id
		 WHERE egx.group_id = '$group_id'
		 ";
		 $q = $this->db->query($query);
         return $q;
      }
	  
      function get_loggedInUser_ticket($ticket_closed_status = 0) 	// pass 0 for closed tickets and 1 for open ticket 
	  {
			$customer_id = ( isset($_SESSION["login_info"]["customer_id"]) ) ? $_SESSION["login_info"]["customer_id"] : 0 ;
			
			$site_id = ( isset($_SESSION['site_id']) ) ? $_SESSION['site_id'] : 0 ;
			
			$this->db->where('customer_id', $customer_id);
			$q = $this->db->get('ec_customers_group_xref');
			
			// echo "<pre>";	print_r($q);		die();
			
			if ($q->num_rows() > 0) // if customer group exist
			{
			    
				// echo "<pre>";	print_r($q->result_array() );	die();
				
				foreach( $q->result_array() as $row)
				{
					$group_ids[] = $row['group_id'];
				}
				
				$group_id = implode(",",$group_ids);
				// echo "<pre>";	print_r($group_id);
				
				
				$q = "SELECT 
					d.d_id 
					FROM support_department d
					JOIN groups g
					ON d.d_group_id = g.id
					WHERE d.d_group_id IN ($group_id)
					AND g.is_deleted = 'No' 
					AND g.is_disabled = 'No'
					";
				$r = $this->db->query($q);
				
				if ($r->num_rows() > 0) // if group department exist
				{
				
					foreach( $r->result_array() as $row)
					{
						$depIds[] = $row['d_id'];
					}
					//echo "<pre>";	print_r($depIds);
					$depId = implode(",",$depIds);
					//echo "<pre>";	print_r($depId);		die();
					
					$q = "SELECT 
					dep.d_id, 
					dep.d_name, 
					t.t_id, 
					t.t_no, 
					t.t_subject, 
					t.t_department_id, 
					t.t_deleted 
					FROM support_tickets AS t
					JOIN support_department AS dep 
					ON  t.t_department_id = dep.d_id
					WHERE t.t_site_id = '$site_id' 
					AND	dep.d_id IN ($depId)
					AND t.t_deleted = 0 
					AND t_closed = '$ticket_closed_status'
					";
					$r = $this->db->query($q);
					//echo "<pre>";	print_r($r->num_rows());		die();
					if( $r->num_rows() > 0 )	// if ticket exist
					{
						return $r;
					}
				} // end if group department exists
			} // end if group exists
					
			
			return false;	
			
	  }
	  
	  function get_ticket_created_by_users($ticket_closed_status)
	  {
		  $t_uid = ( isset($_SESSION["login_info"]["customer_id"]) ) ? $_SESSION["login_info"]["customer_id"] : 0 ;
		  $site_id = $_SESSION['site_id'];
		  $q = "SELECT 
		  		dep.d_id, 
				dep.d_name,
				t.t_id, 
				t.t_no, 
				t.t_subject, 
				t.t_department_id, 
				t.t_deleted 
				FROM support_tickets AS t
				JOIN support_department AS dep 
				ON  t.t_department_id = dep.d_id
				WHERE t.t_site_id = '$site_id' 
				AND t.t_deleted = 0 
				AND t.t_closed = '$ticket_closed_status'
				AND t.t_uid = '$t_uid'
				";
				$r = $this->db->query($q);
				//echo "<pre>";	print_r($r->num_rows());		die();
				if( $r->num_rows() > 0 )	// if ticket exist
				{
					return $r;
				}
	  }
	  	  
	  function is_ticket_exist()
	  {
		    $customer_id = $_SESSION["login_info"]["customer_id"];
			$this->db->where('customer_id', $customer_id);
			$q = $this->db->get('ec_customers_group_xref');
			
			
			if ($q->num_rows() > 0) // if customer exist
			{
			    
				//echo "<pre>";	print_r($q->result_array() );	die();
				$j = 0;
				$i = 0;
				$flag = 1;
				foreach ($q->result_array() as $row) 
				{	
					
					$groupId = $row['group_id'];
					/***	fetching group ***/ 
					$this->db->where('id', $groupId);
					$this->db->where('is_deleted', "No");
					$q = $this->db->get('groups');
					
					if ($q->num_rows() > 0) // if group exist in groups table
					{
						
						$this->db->where('d_group_id', $groupId);
						$this->db->where('d_deleted', 0);
						$q = $this->db->get('support_department');
						
						// echo "<pre>";	print_r($q->result_array());	
						
						if ($q->num_rows() > 0) // if support_department exist 
						{
						   if($j == 0)
						   {
								$whereClause = " WHERE ";
						   }
						   $j++;
						   
						   foreach( $q->result() as $row)
						   {
								$deptId = $row->d_id;
								if($i != 0 )
								{
									$whereClause .= "OR ";
								}
								$whereClause .= "  t_department_id = '$deptId' ";
								$i++;
						   }
						   
						}
						else
						{
							$whereClause = "WHERE t_deleted = 0 AND t_department_id = 0 ";
							
						}
					}
					
				} // end foreach
				
				
				
				$my_query = 
				"SELECT 
				dep.d_id, 
				dep.d_name, 
				t.t_id, 
				t.t_no, 
				t.t_subject, 
				t.t_department_id, 
				t.t_deleted 
				FROM support_tickets AS t
				INNER JOIN support_department AS dep 
				ON  t.t_department_id = dep.d_id
				".$whereClause." 
				ORDER BY t_id DESC
				";
				
				//echo "<pre>";	echo $my_query;
				
				$q2 = $this->db->query($my_query);
				
				if( $q2->num_rows() > 0 )
				{
					//die();
					return true;
				}
				
			   
			} // end if 
			
			return false;
	  }
	  
	  function get_department_by_id($id)
	  {
	  		$this->db->where('d_deleted', 0);
			$this->db->where('d_id', $id);
	  		$q = $this->db->get("support_department" );
			foreach( $q->result() as $dep )
			///echo $dep->d_id;
			//die();
			return $dep;
	  }
	  
	  function update_department()
	  {
	  	  $d_id = $this->input->post("d_id");
		  $d_group_id = $this->input->post("d_group_id");
		  
		  $data = array(
               'd_group_id' => $d_group_id,
          );

		  $this->db->where('d_id', $d_id);
		  $r = $this->db->update('support_department', $data);
		 
		  return $r;
	  }
      
	  function get_department_id($dep_id)
	  {
	  		$this->db->where("d_id",$dep_id);
			$this->db->where("d_deleted",0);
	  		$query =$this->db->get('support_department' );
			return $query;
	  }
	  
	  function get_all_department()
	  {
	  		$query =$this->db->get_where('support_department', array('d_deleted' => '0') );
			return $query;
	  }
	  
	  function get_all_department_by_site($site_id)
	  {
		$this->db->where("d_deleted",0);
		$this->db->where("d_site_id",$site_id);
		$query =$this->db->get('support_department');
		return $query;
	  }
	  function add_department()
	    {
			if(isset ($_SESSION['site_id']) )	
			{  
				$site_id = $_SESSION['site_id'];
				$d_owner = $_SESSION["current_site_info"]['user_id'];
			}
			
            $data = array(
			   'd_site_id' =>  $site_id ,
			   "d_group_id" =>  $this->input->post('d_group_id'),
			   "d_name" => $this->input->post('d_name'),
			   "d_email_notification" => $this->input->post('d_email_notification'),
			   'd_owner' => $d_owner
			);
			
			$this->db->insert("support_department",$data);
			
		} 
		
		
		function get_ticket_by_id_frontEnd($id)
	    {
			$this->db->where('t_deleted', 0);
			$this->db->where('t_id', $id);
	  		//$q = $this->db->get("support_tickets");
			$this->db->select('*');
			$this->db->from('support_tickets');
			$this->db->join('support_department', 'support_department.d_id = support_tickets.t_department_id');
			$q = $this->db->get();
			return $q;
	    }
		
		function get_backend_ticket($site_id)
		{
				 $query = "SELECT
				 support_tickets.t_site_id,
				 support_tickets.t_id, 
				 support_tickets.t_no,
				 support_tickets.t_subject,
				 support_tickets.t_department_id, 
				 support_tickets.t_priority, 
				 support_tickets.t_open_date, 
				 support_tickets.t_department_id,
				 support_department.d_id,
				 support_department.d_name
				 
				 FROM support_tickets 
				  
				 INNER JOIN support_department 
				 ON support_tickets.t_department_id = support_department.d_id 
				 
				 WHERE support_tickets.t_deleted='0' AND t_site_id = '$site_id' ORDER BY support_tickets.t_open_date DESC";
				 //support_tickets.t_closed='0' AND
				 $r = $this->db->query($query);
				 return $r;
				 
		}
		
		function get_backend_department($site_id)
		{
				  $query = "SELECT 
				  sd.d_id,
				  sd.d_name, 
				  sd.d_visibility, 
				  sd.d_users, 
				  sd.d_owner, 
				  users.user_fname, 
				  users.user_lname 
				  FROM support_department sd 
				  INNER JOIN users 
				  ON sd.d_owner = users.user_id 
				  WHERE d_site_id = '$site_id' AND sd.d_deleted = '0'";
				 
				  $r = $this->db->query($query);
				  return $r;
		}
		
		
		/******		comments 	******/
		
		function get_ticket_comment($id)
	    {
			$this->db->order_by("id","desc");
			$this->db->where('ticket_id', $id);
	  		//$q = $this->db->get("support_tickets");
			$this->db->select('*');
			$this->db->from('support_tickets_comments');
			$this->db->join('ec_customers', 'ec_customers.customer_id = ticket_comment.user_id' );
			$q = $this->db->get();
			return $q;
	    }
		
		/*
		function add_comment($ticket_id,$user_id)
		{
			$data = array(
               'ticket_id' =>  $ticket_id ,
			   'user_id' =>  $user_id ,
			   "description" => $this->input->post('comment_detail')
            );

			$r = $this->db->insert('ticket_comment', $data);
			if($r)
			{
				return 1;
			}
			return 0;
		}
		*/
		function get_ticket_detail($id)
	    {
			$q = "SELECT * FROM support_tickets 
			JOIN support_department 
			ON support_department.d_id = support_tickets.t_department_id
			WHERE t_deleted = 0 AND t_id = '$id' ";
			$r = $this->db->query($q);
			$n = $r->num_rows();
			if($n == 1) 
			{
				$row = $r->row_array();
				return $row;
			}
			return false;
	    }
		
		function reopen_ticket($id)
		{
			$data = array(
               't_closed' =>  0
            );
			
			$this->db->where("t_id",$id);
			$r = $this->db->update("support_tickets",$data);
			return $r;
			
		}
		function delete_ticket($id)
		{
			$r = $this->db->query("update support_tickets SET t_deleted='1' where t_id = $id");
			return true;
		}
		
		function delete_department($id)
		{
			$r = $this->db->query("update support_department SET d_deleted='1' where d_id = $id");
			return true;
		}
		/******		comments 	******/
		
		function add_comment($ticket_id,$related_id,$type,$description)
		{
			$date_created = date('Y-m-d h:i:s');
			$data = array(
				'ticket_id' => $ticket_id,
               'related_id' =>  $related_id ,
			   'type' =>  $type ,
			   "description" => $description,
			   "date_created" => $date_created
            );

			$r = $this->db->insert('support_tickets_comments', $data);
			if($r)
			{
				$this->comment_email_notification($ticket_id,$related_id,$type,$description);
				
				return true;
			}
			return false;
		}
		function comment_email_notification($ticket_id,$related_id,$type,$msg)
		{
			$emails_list = array();
			if ( $type == "user")
			{
				$site_id = $_SESSION['site_id'];
				$user_id = $this->get_user_id_by($site_id);
			}
			else
			{
				$user_id = $related_id;
			}
			
			// site admin email 
			$user_email = $this->get_user_email_by_id($user_id); 
			if($user_email)
			{
				$emails_list[] = $user_email; 
			}
			
			$r = $this->get_ticket_by_id($ticket_id);
			if($r->num_rows() > 0)
			{
				$row = $r->row_array();
				$ticketSub = $row['t_subject'];
				$ticketNum = $row['t_no'];
				$ticket_user_id = $row['t_uid'];
				// $ticketDep_id = $row['t_department_id'];
			}
			
			// ticket submitter email
			$sub_email = $this->get_ticket_submitter_email_by_id($ticket_user_id);
			if($sub_email)
			{
				$emails_list[] = $sub_email; 
			}
			
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = "html";
			$this->email->initialize($config);
			
			$this->email->from('support@webpowerup.com');
			$this->email->to($emails_list);
			$this->email->subject('Support Ticket');
			
			$email_msg = "Ticket Number: ".$row['t_no']."<br>";
			$email_msg .= "Ticket Subject: ".$row['t_subject']."<br><br>";
			$email_msg .= "Comment Detail<br> ".$msg."<br>";
			$email_msg .= "<br> Click <a href='".site_url()."ticket/ticket_detail/".$ticket_id."' >here</a> to see it<br> ";
			
			$this->email->message($email_msg);    
			$this->email->send();
		}
		
		function get_ticket_submitter_email_by_id($user_id)
		{
			if($user_id != 0 )
			{
				$q = "SELECT customer_email FROM ec_customers WHERE customer_id = '$user_id' ";
				$r = $this->db->query($q);
				if($r->num_rows() > 0)
				{
					$row = $r->row_array();
					$user_email = $row['customer_email'];
					return $user_email;   
				}
			}
			return false;
		}
		
		function delete_comment($id)
		{
			$this->db->where("id",$id);
			$r = $this->db->delete("support_tickets_comments");
			if($r)
			{
				return true;
			}
			return false;
		}
		
		function get_all_comment($id)
		{
			
			$this->db->where("ticket_id",$id);
			$r = $this->db->get("support_tickets_comments");
			$comments = $r->result_array();
			//echo "<pre>";	print_r($comments);	die();
			if ( $r->num_rows() > 0 )
			{
				foreach($comments as $key => $row) 
				{
				$new_comment[$key]['id'] = $row['id'];
				$new_comment[$key]['description'] = $row['description'];
				$new_comment[$key]['type'] = $row['type'];
				$new_comment[$key]['date_created'] = $row['date_created']; 
				if ( $row['type'] == "admin" )
				// get information from users table 
				{
					$user_id = $row['related_id'];
					$q = "SELECT 
							CONCAT(user_fname,' ',user_lname) as name,
							user_email as email 
							FROM users WHERE user_id = '$user_id' ";
					$admin = 1;
					
				}
				else if ( $row['type'] == "user" )
				// get information from ec_customer table
				{
					$customer_id = $row['related_id'];
					$q = "SELECT
							customer_id AS user_id, 
							CONCAT (customer_fname,' ',customer_lname) AS name,
							customer_email AS email 
							FROM ec_customers WHERE customer_id = '$customer_id' ";
					$admin = 0;
				}
				$r = $this->db->query($q);
				$user = $r->row_array();
				$new_comment[$key]["email"] = $user['email'];
				$new_comment[$key]["name"] = $user['name'];
				$new_comment[$key]["user_id"] = ($admin == 0) ? $user['user_id'] : 0 ;
			}
				return $new_comment;
			}
			return false;
			// echo "<pre>";	print_r($new_comment);	die();
			
		}
		
}
?>
