<?php
  class Business_Reviews_Model extends CI_Model {
       
    function __construct()
    {
                // Call the Model constructor  
        parent::__construct();
       
    }
    
     // method to save news letter data
     function save_review($data)
     {
         $query_str = "INSERT INTO business_reviews(review_reviews,review_rating,review_date,review_submitter,monial_id) VALUES (?,?,?,?,?)";
         $this->db->query($query_str, $data);
    
         
         
     }
    
         // method to show all contact 
    function show_all_newsletter()
    {
        $query_string = "SELECT * FROM newsletter WHERE news_delete = 0  ";
        $q = $this->db->query($query_string);
        
        if($q->num_rows() > 0) {
            $output = '';
            foreach($q->result() as $items)
            {
             
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;
                $link='';
            if($items->news_date_sent == '' || $items->news_date_sent == 'NULL'){
              $link='<a href=" '. base_url().'index.php/Newsletter_Management/send_newsletter_admin/'.$items->news_id.' " >   [Click Here To Send]</a>|';  
            }

                $output .='     <tr>
                          <td>'.$items->news_subject.'</td> 
                          <td>'.$items->news_body.'</td>
                          <td>'.$items->news_recipient_group.'</td>
                          <td>'.$items->news_date_created.'</td>
                          <td>'.$items->news_date_sent.'</td>
                          <td><div style="color:blue;">'.$link. '<a href=" '. base_url().'index.php/Newsletter_Management/view_newsletter/'.$items->news_id.' " >   View</a>|<a  href=" '. base_url().'index.php/Edit_Newsletter/index/'.$items->news_id.' " > Edit </a>|<a href= "'. base_url().'index.php/Newsletter_Management/delete_newsletter/'.$items->news_id.'" > Delete </a></div></td>
                         </tr>';
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
        redirect(base_url().'index.php/Newsletter_Management'); 
    }
    
    // Method to delete Hard contact data
    function delete_hard($page_id)
    {
       $query_string = "DELETE FROM newsletter WHERE news_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().'index.php/Newsletter_Management'); 
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
            $left_menu_data .= '<li><a href="'. base_url().'index.php/Contact_Management_User/get_value/'.$row->menu_id.'"> '.$row->menu_name.' </a></li>';
          
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
            $right_menu_data .= '<li><a href="'. base_url().'index.php/Contact_Management_User/get_value/'.$row->menu_id.'" > '.$row->menu_name.' </a></li>';
          
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

    
}
?>
