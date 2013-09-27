<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Room_Model extends CI_Model{
 
    function __construct()
    {
       // Call the Model constructor  
        parent::__construct();
    }
 

	function create_room($room_data)
	{	
		
		$save = $this->db->insert('room', $room_data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	} 
	
	
	function save_existing_users($rid)
	{
		if(isset($_POST['group_total']))
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
						   $qry = "INSERT INTO room_existing_attendie SET existing_att_id = ".$existing_id.", room_rid = ".$rid."";
						   $result = $this->db->query($qry);
						 
						 }
					  }
				}//if
			 }//for
		}//if
	
	}
	
	function save_edit_existing_users($rid)
	{
		$qry = "DELETE FROM room_existing_attendie WHERE room_rid = ".$rid."";
		$q = $this->db->query($qry);
		if(isset($_POST['group_total']))
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
						   $qry = "INSERT INTO room_existing_attendie SET existing_att_id = ".$existing_id.", room_rid = ".$rid."";
						   $result = $this->db->query($qry);
						 
						 }
					 }
				}
			 }
		}
		 return $rid;	
	}
	
	 function show_all_rooms($site_id)
     {
        $query_string = "SELECT * FROM room WHERE site_id =".$site_id;
        $q = $this->db->query($query_string);
		
        if($q->num_rows() > 0) {
            $output = '';
			$irow=0;
            foreach($q->result() as $items)
            {
			
				$irow++;
			 if($irow%2=='0'){
			    $style = 'style="background:#f6f6f6;"';
			 }else{
			    $style = 'style="background:#fff;"';
			 }
			
               
                $output .='<tr '.$style.'>
                          <td>'.$items->name.'</td> 
                          <td>'.$items->topic.'</td>
                          <td>'.$items->reg_date_start.'</td>
                          <td><div style="color:blue;"><a  target="_blank" href="'.base_url().'broadcast/GWSWhiteboard.html#roomID='.$items->room_rid.'&attendee_id='.($items->presenter_id*2).'">Start Meeting</a> | <a href=" '.base_url().index_page().'room_management/edit_room/'.$items->id.' " >   Edit</a> | <a  onclick="return deleteRoom();" href=" '.base_url().index_page().'room_management/delete_room/'.$items->id.' " >  Delete </a> | <a  href=" '.base_url().index_page().'room_management/send_invitation/'.$items->id.' " >  Send Invitation Mail </a></div></td>
                         </tr>';
						/* $i++;*/
					 /*?> <a href=" '. base_url().'index.php/Newsletter_Management/view_newsletter/'.$items->news_id.' " >   View</a>|<?php */
            }
        return $output;
        }   
    }
	function save_edit_room($room_data, $room_id)
	{
		$this->db->where('id', $room_id);
		$saved = $this->db->update('room', $room_data);
		
		return $saved; 
	}
		
	function delete_room($room_id)
	{
		 $this->db->where('id', intval($room_id));
         $delete = $this->db->delete('room');
		 return $delete;
	}
	
	function edit_room($room_id)
	{
		$q = '';
		$query_string = "SELECT * FROM room where id = ".$room_id;
        $q = $this->db->query($query_string);
        if($q->num_rows() > 0)
		{
			return  $q = $q->result();
		}
	return false;
	}
	
	/*function get_all_site_gropus_user_email($customers_id)
	{
				
		if(isset($customers_id)&& !empty($customers_id))
		{
			$customers = explode(',',$customers_id);		
			foreach($customers as $customer)
			{
					$c = $this->db->query("SELECT * FROM  `ec_customers` WHERE customer_id = ".$customer);
					$customer_email = $c->result_array();							
					foreach($customer_email as $email_id)
					{
						$email_ids[$email_id['customer_id']] = $email_id['customer_email'];
						
					}
			}
			
			return $email_ids;				
		}
		return ;
	}*/
	
	function get_all_site_gropus_user_email($rid)
	{
		$qry = "SELECT ec.customer_email,ec.customer_id
                FROM ec_customers ec
                JOIN room_existing_attendie r ON ec.customer_id = r.existing_att_id
                WHERE r.room_rid =".$rid."";
		
		$q = $this->db->query($qry);
		$result = $q->result_array();
		return $result;
	
		
	}
	
	function check_customer_meeting($site_id, $customer_id)
	{
		$q = '';
		$exist = 0;
		//echo $customer_id;
       
        $select_customer = "SELECT * FROM room_existing_attendie  WHERE existing_att_id = ".$customer_id."";
         $qcustomer = $this->db->query($select_customer);
         if($qcustomer->num_rows() > 0)
         {
             $qcustomer_data = $qcustomer->result_array();
           $query_string = "SELECT * FROM room WHERE room_rid = ".$qcustomer_data[0]['room_rid']." AND reg_date_start >='".date('Y-m-d h-i-s')."'";  
                $q = $this->db->query($query_string);
                if($q->num_rows() > 0)
                {
                    $room_data = $q->result_array();
                    /*for($i = 0; $i<count($room_data); $i++)
                    {
                        $room_users = explode(',', $room_data[$i]['customers']);
                        $exist = in_array($customer_id,$room_users);
                        if($exist)
                        {
                            $exist++;
                        }
                        //print_r($room_users);
                    }
        */            return $room_data;            
                }
         }
		
        
		return false;
	}
	
	
	
	function get_user_rooms($site_id, $customer_id)
	{
		$q = '';
		$exist = 0;
		//echo $customer_id;exit;
		$query_string = "SELECT * FROM room INNER JOIN room_existing_attendie ON room.room_rid = room_existing_attendie.room_rid WHERE room_existing_attendie.existing_att_id = ".$customer_id." AND room.reg_date_start >='".date('Y-m-d h-i-s')."'";
        $q = $this->db->query($query_string);
        if($q->num_rows() > 0)
		{
			$room_data = $q->result_array();
			//echo "<pre>";
			//print_r($room_data);exit;
			/*$count = 0;
			for($i = 0; $i<count($room_data); $i++)
			{
				$room_users = explode(',', $room_data[$i]['customers']);
				$exist = in_array($customer_id,$room_users);				
				if($exist)
				{
					
					$room_array[] = $room_data[$i];					
				}
				//print_r($room_users);
			
			}*/
			
			return $room_data;
		}
		return false;
	}
	function get_all_rooms($site_id)
    {
		 $query = "SELECT * FROM room WHERE site_id =".$site_id;
		 $r = $this->db->query($query);
		 
		 if( $r->num_rows() > 0)
		 {
			 $rooms = $r->result_array();
			 return $rooms;
		 }
		 return false;
		 
	}
	
	function get_all_meeting_user($rid)
	{
		 $qry = "SELECT ec.customer_email,ec.customer_id
                FROM ec_customers ec
                JOIN room_existing_attendie r ON ec.customer_id = r.existing_att_id
                WHERE r.room_rid =".$rid."";
		
		/*$qry = "SELECT e.existing_att_id
                FROM  room_existing_attendie e
                JOIN room r ON r.room_rid = e.room_rid
                WHERE r.id =".$rid."";*/
		
		$q = $this->db->query($qry);
		$result = $q->result_array();
		return $result;
	
		
	}
	
	function get_site_gropus_customer_by_site_id($site_id, $type=0,$webinar_call = 0)
	{
			$group_data = array();
			$data = '';	
			$i = '';		
			$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' AND gp.is_disabled = 'No' AND gp.is_deleted = 'No' ";
			$Q = $this->db->query($qry);
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
			
			$groups_array[$i]['group_name']='Registered Users';
			$groups_array[$i]['id']=time();
			$groups_array[$i]['users'] = $this->get_site_registered_user_by_site_id($site_id);
			
			
			return $groups_array;
	}
	
	function get_site_registered_user_by_site_id($site_id, $type=0,$webinar_call = 0)
	{
		$Q = $this->db->query("SELECT c.customer_id, c.customer_login, c.customer_name, c.customer_email
                               FROM  `ec_customers` AS c
                               WHERE c.site_id =".$site_id."");
			$data = array();				   
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
	
	function save_private_attendies($new_users, $site_id, $rid)
	{
		//echo "<pre>";print_r($new_users);exit;
		$customer_ids = '';
		foreach($new_users as $users)
			{
		
				$Q = $this->db->query("SELECT * FROM  `ec_customers` WHERE  `customer_email` ='".trim($users)."' AND  `site_id` =".trim($site_id));
				$result_query = $Q->result_array();
				//echo "<pre>";print_r($result_query);exit;
				 if(count($result_query)>0)
				 {
					$qry = "INSERT INTO room_existing_attendie SET existing_att_id = ".$result_query[0]['customer_id'].", room_rid = ".$rid."";
				   	$result = $this->db->query($qry);	
				 }
				 else
				 {
							$password = rand(100000,999999);
							$data = array(
							'site_id' => trim($site_id),
							'customer_login' => trim($users),
							'customer_email' => trim($users),
							'membershipid' => 0,
							'customer_password' => md5($password),
							'registered_date' =>  date('Y-m-d h-i-s')
							);
							$this->db->insert('ec_customers',$data);
							$customer_ids[] = $this->db->insert_id();							
							$qry = "INSERT INTO room_existing_attendie SET existing_att_id = ".$this->db->insert_id().", room_rid = ".$rid."";
				   			$result = $this->db->query($qry);
							
							//*** E-mail to Customer Login Info **//
							
							$message = '';
                    		$message .=  "Congratulation !  \n\n Your signup process copmlete \n \n";
                    		$message .=  ' 
                                  
                                    +---------------------------------------------+ 
                                    | Login Mail: '.$data['customer_login'].'                       |
                                    | Password: '.$password.'                     |
                                    +---------------------------------------------+
                                  
                                  ';
							$message .= "\nThanks for using Our Services 
										\n ";
							$message .= 'http://www.webpowerup.com/';
							$this->load->library('email');							
							$this->email->from('admin@webpowerup.com', 'WebpowerUp');
							$this->email->to($data['customer_login']);
							$this->email->cc('noreply@webpowerup.com');
						   // $this->email->bcc('them@their-example.com');
							$this->email->subject('Signup | System Confirmation Mail');
							$this->email->message($message);
							$this->email->send();
							
				}
			}
			
			
			return $customer_ids;
	}
	
	function check_private_meeting_exist($site_id, $customer_id)
	{
		$query_string = "SELECT * FROM private_meeting WHERE site_id = ".$site_id." AND customer_id = ".$customer_id;
		$q = $this->db->query($query_string);
		if($q->num_rows() > 0)
		{
			return $room_data = $q->result_array();
			//echo "<pre>"; print_r($room_data); exit;
		}
		
		return false;
	}
	
	function insert_user_private_meeting_record($site_id, $customer_id, $meeting_id)
	{
		//$qry_private_meeting = "INSERT INTO private_meeting SET site_id = ".$site_id.", customer_id = ".$customer_id.", room_id = ".$meeting_id."";
		$qry_meeting_att = "INSERT INTO room_existing_attendie SET existing_att_id = ".$customer_id.", room_rid = ".$meeting_id."";
		
		//$this->db->query($qry_private_meeting);	
		$this->db->query($qry_meeting_att);		
		return true;
	}
	
	
	function getCustomer($id){
	  $data = array();
	  $options = array('customer_id' => intval($id));
	  $Q = $this->db->get_where('ec_customers',$options,1);
	  if ($Q->num_rows() > 0){
		$data = $Q->row_array();
	  }
	 // $Q->free_result();
	  return $data;
	}
	
}  
?>