<?php
  class Newsletter_Model extends CI_Model {
      
    function __construct()
    {
                // Call the Model constructor  
        parent::__construct();
       
    }
    
     // method to save news letter data
     function save_newsletter($data)
     {
		
         $this->db->insert('newsletter', $data);
		 $insert_id = $this->db->insert_id();		 
		 return true;
    
     }
    
	
	// explode id's pass table name and show coloumb
	//	get_table_multiple_id("id1,id2,id3","table_name","col_name_1,col_name_2")
	function get_table_multiple_id($whereColumb,$ids,$tablename,$selectColumbs)
	{
		//$columbsArray = implode(",",$columbsArray);
		//$arrayRes = array();
		if ($tablename != "" && $ids != "")
		{
             $arrayRes = array();
			$query = "SELECT $selectColumbs ";
			$query .= "FROM $tablename ";
			$query .= "WHERE $whereColumb IN ( $ids ) ";
			$r = $this->db->query($query);
			foreach ($r->result_array() as $row)
			{
				$arrayRes[] = $row['group_name'];
				
			}
			$arrayRes = implode(",",$arrayRes);
			return $arrayRes;
		}
	}
	
         // method to show all contact 
    function show_all_newsletter()
    {
		
		
		$site_id = $_SESSION['site_id'];
        $query_string = "SELECT * FROM newsletter WHERE news_delete = 0 AND site_id = '".$site_id."' ";
        $q = $this->db->query($query_string);
        
        if($q->num_rows() > 0) {
            $output = '';
			$i=0;
            foreach($q->result() as $items)
            {
			 if($i%2=='0'){
			    
				$style = 'style="background:#f6f6f6;"';
			 
			 }else{
			 
			 	$style = 'style="background:#fff;"';
			 }
             
                $link='';
            if($items->news_date_sent == '' || $items->news_date_sent == 'NULL'){
              $link='<a href=" '. base_url().index_page().'Newsletter_Management/send_newsletter_admin/'.$items->news_id.' " >   [Click Here To Send]</a>|';  
            }
$groups =   $this->get_table_multiple_id("id",$items->news_recipient_group,"groups","group_name,id");
if(isset($groups) && sizeof($groups) >0)
   {
	   $group = $groups;
   }
   else 
   {
	 $group = 'registered User';   
   }
                $output .='     <tr '.$style.'>
                          <td>'.$items->news_subject.'</td> 
                          <td>'.$items->news_body.'</td>
                          <td>'.  $groups .  ' Regestered Users</td>
                          <td>'.$items->news_date_created.'</td>
                          <td>'.$items->news_date_sent.'</td>
                          <td><div style="color:blue;">'.$link. '<a  href=" '. base_url().index_page().'Edit_Newsletter/index/'.$items->news_id.' " > Edit </a>|<a onClick="return do_delete()" href= "'. base_url().index_page().'Newsletter_Management/delete_newsletter/'.$items->news_id.'" > Delete </a></div></td>
                         </tr>';
						 /*?> <a href=" '. base_url().'index.php/Newsletter_Management/view_newsletter/'.$items->news_id.' " >   View</a>|<?php */
						 $i++;
            }
        return $output;
        }   
        
    }
    
    // method to fetch row for edit 
    function get_newsletter_data($rec_id)
    {
       $query_string = "SELECT * FROM newsletter WHERE news_id = $rec_id ";
       $q = $this->db->query($query_string); 
       $data = array ();
       $data =$q->result_array();
       return $data;
    }
         // Method to delete softly contact data
    function delete_soft($page_id)
    {
       $query_string = "UPDATE newsletter SET news_delete = 1 WHERE news_id= $page_id  ";
        $q = $this->db->query($query_string); 
        redirect(base_url().index_page().'Newsletter_Management'); 
    }
    
    // Method to delete Hard contact data
    function delete_hard($page_id)
    {
       $query_string = "DELETE FROM newsletter WHERE news_id= $page_id  ";
        $q = $this->db->query($query_string); 
        redirect(base_url().index_page().'Newsletter_Management'); 
    }
    
    
    
     //Method to edit contact data
    function update_newsletter ($reg_form_data = array(),$site_id)
    {
       
       $this->db->where('news_id', $reg_form_data['news_id']);
       $this->db->update('newsletter', $reg_form_data);
       /* if(isset($_POST['type']) && $_POST['type'] == 1)
		 {
			 $this->send_newsletter_to_selected($reg_form_data['news_id'], $site_id);
		 }*/
		 return true;
    }
    
   // method to show left menue 
    function left_menu()
    {
         $query_string = "SELECT * FROM menus where menu_position = 'Left'  AND menu_published ='Yes'  AND menu_status = 'Active'";
        $items = $this->db->query($query_string);
        $left_menu_data ="<ul>";
        foreach ($items->result() as $row)
        {
           // $left_menu_data .= $row->menu_id;
           // $left_menu_data .= $row->menu_name;
            $left_menu_data .= '<li><a href="'. base_url().index_page().'Contact_Management_User/get_value/'.$row->menu_id.'"> '.$row->menu_name.' </a></li>';
          
        }
        $left_menu_data .="</ul>";      
       return   $left_menu_data;
    }
    
    // method to show right menue 
    function right_menu()
    {
        $query_string = "SELECT * FROM menus where menu_position = 'Right'  AND menu_published ='Yes'  AND menu_status = 'Active'";
        $items = $this->db->query($query_string);
        $right_menu_data ="<ul>";
        foreach ($items->result() as $row)   // values by object
        {
           // $left_menu_data .= $row->menu_id;
           // $left_menu_data .= $row->menu_name;
            $right_menu_data .= '<li><a href="'. base_url().index_page().'Contact_Management_User/get_value/'.$row->menu_id.'" > '.$row->menu_name.' </a></li>';
          
        }
        $right_menu_data .="</ul>";      
       return   $right_menu_data;  
        
        
    } 
        // Method to get selected id data 
    function get_newsletter($rec_id)
    {
       $query_string = "SELECT * FROM newsletter WHERE news_id = $rec_id ";   
       $items = $this->db->query($query_string);
        $row = $items->row_array();  // values by array
        $data = array();
       $data['news_id'] = $row['news_id'];
       $data['news_subject'] = $row['news_subject'];
       $data['news_body'] = $row['news_body'];
       $data['news_recipient_group'] = $row['news_recipient_group'];
       $data['news_date_created'] = $row['news_date_created'];
       $data['news_date_sent'] = $row['news_date_sent'];
       return $data;
    }
	
	function get_all_site_gropus_user_count($groups, $site_id)
	{
				
		$groups = explode(',',$groups);
		foreach($groups as $group)
		{
				$c = $this->db->query("SELECT * FROM  `ec_customers` WHERE membershipid = ".$group." OR customer_id = ".$group."");
				$customer_email = $c->result_array();							
				foreach($customer_email as $email_id)
				{
					$email_ids[] = $email_id['customer_email'];
				}
		}
		return $email_ids;				
	}	
	
	function send_newsletter_to_selected($letter_id, $site_id)
	{
		$query_string = "SELECT * FROM newsletter WHERE news_id = ".$letter_id." ";
        $q = $this->db->query($query_string); 
        $data = array ();
        $data =$q->result_array();
		$subject = $data[0]['news_subject'];
       	$body = $data[0]['news_body'];
		$from = $data[0]['from'];
		if(is_array($data[0]['news_recipient_group']))
		{
		
			$user_gruop = explode($data[0]['news_recipient_group']);
		}
		else
		{
			$user_gruop = array($data[0]['news_recipient_group']);
		}
				
		
		/*echo "<pre>";
		print_r($data);
		exit;*/
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		foreach($user_gruop as $group_id)
		{
			$customers = $this->get_site_gropus_customer_by_group_id($group_id);		
			foreach($customers as $mail)
			{
				$this->email->from($from, 'WebpowerUp');
				$this->email->subject($subject);
				$this->email->message($body);	
				$this->email->to($mail); 
				$send = $this->email->send();			
			}
		}
		$current = date("Y-m-d  H:i:s", time());
		$query_string = "UPDATE newsletter SET news_date_sent = '".$current."' WHERE news_id = $letter_id";
		$q = $this->db->query($query_string);
		return true;	
	}
	
	 function send_newsletter($data)
     {
         	$this->load->library('email');
			$subject = $data[1];
			$body = $data[2];
			$user_gruop = $data[3];
            $this->email->from('your@example.com', 'Your Name');
            $this->email->to('someone@example.com'); 
            $this->email->cc('another@another-example.com'); 
            $this->email->bcc('them@their-example.com'); 
            $this->email->subject('Email Test');
            $this->email->message('Testing the email class.');    
            $this->email->send();
            echo $this->email->print_debugger();    
      }
	  
	  function get_all_newsletter()
	{
		$site_id = $_SESSION['site_id'];
        $query = "SELECT * FROM newsletter WHERE news_delete = 0 AND site_id = '".$site_id."' ";
		$r = $this->db->query($query);	
		if ( $r->num_rows() > 0 )
		{
			$newsletter = $r->result_array();
			foreach($newsletter as $key => $data)
			{
				$groups = explode(',',$data['news_recipient_group']);
				foreach($groups as $group_id)
				{
					$c = $this->db->query("SELECT id,group_name FROM `groups` WHERE id = ".$group_id);
					$group_data = $c->result_array();					
					//print_r($group_data);exit;
					$group_names[] = $group_data[0]['group_name'];
				}
				$newsletter[$key]['group_names'] = $group_names;
				$group_names = array();
					//print_r($group_names);exit;
			}			
			//echo "<pre>";print_r($newsletter);exit;
			return $newsletter;
		}
		return false;
	} 
	
	
	function get_site_gropus_customer_by_group_id($group_id)
		{
					
					$groups_array = array();
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
					WHERE cgx.group_id = ".$group_id);
					//fetching customer for Group
					$int_count = $c->result_array();
					//print_r($int_count);exit;
					if ($c->num_rows() > 0)
					 {
						
						foreach($int_count as $record)
						{
							//customers registered to this group							
							$member_array[$record['customer_id']] = $record['customer_email'];
						}
							//$groups_array[$i]['users'] = $member_array;
													
					 }
					 else
					 {
						 //no customers registered to this group
						$groups_array[$i]['users'] = 0;
					 }
			//$groups_array[$i]['users'] = $this->get_site_registered_user_by_site_id($site_id);
			//echo "<pre>";print_r($member_array);exit;
			return $member_array;
	}
    
 ////////////////////////////////////////this section is for news letter group/////////////////////////////   
    function save_newsletter_group($data)
     {
         if($data['newsgroup_id'] != "")
         {
            $this->db->where('newsgroup_id', $data['newsgroup_id']);
            $this->db->update('newslettergroups', $data);   
         }
         else
         {
            $this->db->insert('newslettergroups', $data);
         }        
         return true;
    
     }
     
     function get_newsletter_groups ($id = false, $site_id)
     {
         if($id != ''){
         $this->db->where_in('newsgroup_id', $id);
         }
         $this->db->where('newsgroup_site_id',$site_id);
         $result = $this->db->get('newslettergroups');
         return $result->result();
         
     }
     function get_newsletter_groups_all ($id = false, $site_id)
     {
         if($id != ''){
         $this->db->where_in('newsgroup_id', $id);
         }
         $this->db->where('newsgroup_page', 'no');
         $this->db->where('newsgroup_site_id',$site_id);
         $result = $this->db->get('newslettergroups');
         return $result->result();
         
     }
     
     function save_group_NLuser($data)
     {
         
       $this->db->insert('user_entry_newslettergroup', $data);
       return true;   
     }
     
     function get_userBy_NLgroup($id , $site_id)
     {
         $this->db->where('newsgroup_id',$id);
         $this->db->where('site_id',$site_id); 
         $result            = $this->db->get('user_entry_newslettergroup');
         return $result->result();
          
     }
     
    function delete_newsletter_group($id, $site_id)
    {
        $this->db->where('newsgroup_id',$id);
        $this->db->where('newsgroup_site_id',$site_id);
        $this->db->delete('newslettergroups');
    }
    
    function delete_NLgroup_user($id , $site_id)
    {
        $this->db->where('id',$id);
        $this->db->where('site_id',$site_id);
        $this->db->delete('user_entry_newslettergroup');
    } 
    
}
?>
