<?php
  class Testimonial_Model extends CI_Model {
    //   Reviews and Testimonies
    function __construct()
    {
                // Call the Model constructor  
        parent::__construct();
       
    }
    
     // method to save news letter data
     function save_testimonial($data)
     {
         $query_str = "INSERT INTO testimonies (monial_publish,monial_menu,monial_parent,monial_page_body) VALUES (?,?,?,?)";
         $this->db->query($query_str, $data);
    
         
         
     }
    
         // method to show all Testimonial 
    function show_all_testimonies()
    {
        
        $query_string = "SELECT * FROM testimonies WHERE monial_delete = 0  ";
        $q = $this->db->query($query_string);
        
        if($q->num_rows() > 0) {
            $output = '';
            foreach($q->result() as $items)
            {
             
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;
                $publish='No';
            if($items->monial_publish == '1' ){
              $publish='Yes';  
            }

                $output .='     <tr>
                          <td>'.$publish.'</td> 
                          <td>'.$items->monial_menu.'</td>
                          <td>'.$items->monial_parent.'</td>
                          <td colspan="3">'.$items->monial_page_body.'</td>
                         <td><div style="color:blue;"> <a href=" '. base_url().'index.php/Testimonial_Reviews_Management/index/'.$items->monial_id.' " >   Manage </a>|<a  href=" '. base_url().'index.php/Testimonial_Management/view_testimonial/'.$items->monial_id.' " > View </a></div></td> 
                         </tr>';
            }

        return $output;
        }   
        
    }
    
// method to show Selected Testimonial 
    function show_selected_testimonies($id='')
    {
        
        $query_string = "SELECT * FROM testimonies  WHERE monial_id = $id  ";
        $q = $this->db->query($query_string);
       // $items = $q->result();
          $items = $q->row(); 

            $output = '';
            
            $publish='No';
            if($items->monial_publish == '1' ){
              $publish='Yes';  
            }

                $output ='<tr>
                          <td>'.$publish.'</td> 
                          <td>'.$items->monial_menu.'</td>
                          <td>'.$items->monial_parent.'</td>
                          <td colspan="3">'.$items->monial_page_body.'</td>
                      <!--   <td><div style="color:blue;"> <a href=" '. base_url().'index.php/Testimonial_Reviews_Management/index/'.$items->monial_id.' " >   Manage </a>|<a  href=" '. base_url().'index.php/Testimonial_Management/view_testimonial/'.$items->monial_id.' " > View </a></div></td>  -->
                         </tr>';
             
                return $output;  
    }
    
    
    
    // show business reviews 
    function show_all_reviews($id)
    {
        $query_string = "SELECT * FROM business_reviews WHERE review_delete = 0  AND monial_id = $id ";
        $q = $this->db->query($query_string);
        
        $output = '';
        
        if($q->num_rows() > 0) {
            
            $i=1;
            
             foreach($q->result() as $items)
            {
             
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;
                
                $view = 'Approve'; 
                if($items->review_approve != 'Approve' ){
                    $view = 'Unapprove'; 
                }
                 $approve='<a href=" '. base_url().'index.php/Testimonial_Reviews_Management/approve_unapprove_reviews/'.$items->review_id.'/'.$items->monial_id.' " > '.$view .' </a>|'; 
        
                            $output .='<tr bgcolor="#F9F9F9">
                           <td><input type="checkbox" class="noborder" name="check_list'.$i.'" id="check_list'.$i.'" value="'.$items->review_id.'" > </td>
                           <td>'.$items->review_reviews.'</td>
                           <td>'.$items->review_rating.'</td>
                           <td > '.$items->review_date.'</td>
                           <td >'.$items->review_submitter.'</td> 
                           <td>'.$approve.' <!-- <a  href=" '. base_url().'index.php/Edit_Newsletter/index/'.$items->review_id.' " > Edit </a>| --> <a href= "'. base_url().'index.php/Testimonial_Management/delete_testmonial/'.$items->review_id.'" > Delete </a> </th>
                           </tr>';
                           $i++;
            }
            
             $output  .= '<input type="hidden" name="totalcheckbox" id="totalcheckbox" value="'.$i.'"/>';
            
            
            
        }  
            return $output;                
        
    }
    
    
    // method to delete selected  reviews
    function  delete_review_soft ($rec_id)
    {
        
        $query_string = "UPDATE business_reviews SET review_delete = 1 WHERE review_id= $rec_id  ";

        $q = $this->db->query($query_string); 
      //  redirect(base_url().'index.php/Testimonial_Management'); 
  
    } 
 
        // method to delete selected  reviews
    function  delete_review_hard ($rec_id)
    {
        
        $query_string = "DELETE FROM business_reviews WHERE review_id= $rec_id  ";
        $q = $this->db->query($query_string);   
       //  redirect(base_url().'index.php/Testimonial_Management'); 
        
    } 
   
   
    // Method to appprove unapprove business reviews
    function change_status($page_id)
    {
       
      $data=  $this->get_review_selected($page_id);
     // print_r($data);
       $change_value = "'Approve'"; 
       if($data['review_approve']=='Approve'){
         $change_value = "'Unapprove'";  
       }
       
      $query_string = "UPDATE business_reviews SET review_approve = $change_value WHERE review_id= $page_id  ";  
       $this->db->query($query_string);  
 //        $update = array ();
//       $update['review_approve'] = $change_value; 
//       $this->db->where('review_id', $page_id);
//       $this->db->update('business_reviews', $update);

      // redirect(base_url().'index.php/Testimonial_Management'); 
    }
    
    
   //method to  get review
    function get_review_selected ($rec_id)
    {
     $query_string = "SELECT * FROM business_reviews WHERE review_id = $rec_id ";
       $dataset = $this->db->query($query_string); 
       $row = $dataset->row_array();
      // print_r($row); exit;
       return $row;
        
    }
    
    
        // Method to appprove unapprove business reviews
    function approve_review($page_id)
    {
       
//      $data=  $this->get_review($page_id);
//      
       $change_value = "'Approve'"; 
//       if($data[0]['review_approve']=='Approve'){
//         $change_value = "'Unapprove'";  
//       }
       
      $query_string = "UPDATE business_reviews SET review_approve = $change_value WHERE review_id= $page_id  ";  
       $this->db->query($query_string);  

    }
    
    
    //method to  get review
    function get_review ($rec_id)
    {
           $query_string = "SELECT * FROM business_reviews WHERE monial_id = $rec_id  AND review_approve = 'Approve' ";
       $dataset = $this->db->query($query_string); 
       
       $output = array();
       if($dataset->num_rows() > 0) {
             
        
                   $index = 0;
            foreach($dataset->result() as $items)
            {
                    $output[$index]['review_id'] =  $items->review_id; 
                    $output[$index]['monial_id'] =  $items->monial_id; 
                    $output[$index]['review_reviews'] = $items->review_reviews;
                    $output[$index]['review_rating'] =  $items->review_rating;
                    $output[$index]['review_date'] =   $items->review_date ;
                    $output[$index]['review_submitter'] =  $items->review_submitter; 
                    $output[$index]['review_approve'] =  $items->review_approve; 
                    $output[$index]['review_delete'] =  $items->review_delete; 

            
               $index++;          
            }
       }

        return $output; 
        
        
        
    }
    
    //method to  get testimonial
    function get_testimonial($rec_id)
    {
       $query_string = "SELECT * FROM testimonies WHERE monial_id = $rec_id ";
       $q = $this->db->query($query_string); 
       return  $row =$q->row_array();
      // print_r($row);
       //row_array
//       $data['monial_id'] = $row['monial_id'];
//       $data['monial_publish'] = $row['monial_publish'];
//       $data['monial_menu'] = $row['monial_menu'];
//       $data['monial_page_body '] = $row['monial_page_body '];
//       return $data;   
        
        
        
    } 
    

         // Method to delete softly contact data
    function delete_soft($page_id)
    {
       $query_string = "UPDATE testimonies SET monial_delete = 1 WHERE monial_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().'index.php/Testimonial_Management'); 
    }
    
    // Method to delete Hard contact data
    function delete_hard($page_id)
    {
       $query_string = "DELETE FROM testimonies WHERE monial_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().'index.php/Testimonial_Management'); 
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
       
       $update['monial_publish'] = $reg_form_data[1];
       $update['monial_menu'] = $reg_form_data[2];
       $update['monial_parent'] = $reg_form_data[3]; 
       $update['monial_page_body'] = $reg_form_data[4]; 

        
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
       $query_string = "SELECT * FROM testimonies WHERE monial_id = $rec_id ";   
       $items = $this->db->query($query_string);
        $row = $items->row_array();  // values by array
        $data = array();
       $data['monial_page_body'] = $row['monial_publish'];
       $data['monial_page_body'] = $row['monial_menu'];
       $data['monial_page_body'] = $row['monial_parent'];
       $data['monial_page_body'] = $row['monial_page_body'];
       
       return $data;
    }

    
}
?>
