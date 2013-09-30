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
       
		 $query_str = "INSERT INTO newsletter(news_subject,news_body,news_recipient_group,news_date_created,site_id) VALUES (?,?,?,?,?)";
         $this->db->query($query_str, $data);
    
         
         
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

                $output .='     <tr '.$style.'>
                          <td>'.$items->news_subject.'</td> 
                          <td>'.$items->news_body.'</td>
                          <td>'.$items->news_recipient_group.'</td>
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
    function update_newsletter ($reg_form_data = array())
    {
      /* $query_str = "UPDATE contact_manage SET
       contact_name = $contact_data[1] ,
       contact_country  = $contact_data[2],
       contact_state  = $contact_data[3],
       contact_city  = $contact_data[4],
       contact_address = $contact_data[5],
       contact_zip  = $contact_data[6],
       contact_position  = $contact_data[7],
       contact_phone  = $contact_data[8],
       contact_fax  = $contact_data[9],
       contact_google_code  = $contact_data[10],
       contact_extra_info  = $contact_data[11],
       contact_publish  = $contact_data[12]
       WHERE  contact_id= $contact_data[0]";  
       $q = $this->db->query($query_string);
       redirect(base_url().'index.php/Contact_Management');      */
       
       $update['news_subject'] = $reg_form_data[1];
       $update['news_body'] = $reg_form_data[2];
       $update['news_recipient_group'] = $reg_form_data[3]; 
      // $update['news_date_created'] = $reg_form_data[4]; 

        
      // $where
       
      // $this->db->where($where);
       $this->db->where('news_id', $reg_form_data[0]);
       $this->db->update('newsletter', $update);

       
        
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
				$c = $this->db->query("SELECT * FROM  `ec_customers` WHERE membershipid = ".$group);
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
		$query_string = "SELECT * FROM newsletter WHERE news_id = $letter_id ";
        $q = $this->db->query($query_string); 
        $data = array ();
        $data =$q->result_array();
		$subject = $data[0]['news_subject'];
       	$body = $data[0]['news_body'];
		$customer_data = $this->get_all_site_gropus_user_count($data[0]['news_recipient_group'], $site_id);
		/*echo "<pre>";
		print_r($customer_data);
		exit;*/
		

		$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		//$customer_mail = implode(',',$customer_data);
		//$this->email->to($customer_mail); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 
		//$send = $this->email->send();
		foreach($customer_data as $mail)
		{
			$this->email->from('help@gws.com', 'Your Name');
			$this->email->subject($subject);
			$this->email->message($body);	
			$this->email->to($mail); 
			$send = $this->email->send();			
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
}
?>