<?php
  class Registration_Forms_Model extends CI_Model {
      
    function __construct()
    {
                // Call the Model constructor  
        parent::__construct();
       
    }
    
     // method to save form fields values
     function form_fields_value_save ($field_value, $id)
     {
           $values_ary = array($id,$field_value);
            $query_str = "INSERT INTO fields_options(field_id,option_value) VALUES (?,?)";
           $this->db->query($query_str,$values_ary );   
         
     }
    
    
    // method used to save user registration information 
      function add_registration_form($reg_form_data = array(),$items) 
      {
          //$hash_pass = sha1($user_password);
          //echo "<pre>";
        // print_r($values_ary);
            $values_ary = array($reg_form_data['form_title'],$reg_form_data['form_intro'],$reg_form_data['form_thank_u'],$reg_form_data['form_menu'],$reg_form_data['form_menu_parent'],$reg_form_data['form_menu_item_text'],$reg_form_data['form_permissions'],$reg_form_data['form_payment_required'],$reg_form_data['form_complete_action'],$reg_form_data['form_publish'],$reg_form_data['form_email_to'],$reg_form_data['form_make_survey']);
            $query_str = "INSERT INTO registration_form(form_title,form_intro,form_thank_u,form_menu,form_menu_parent,form_menu_item_text,form_permissions,form_payment_required,form_complete_action,form_publish,form_email_to,form_make_survey) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
           $this->db->query($query_str,$values_ary );
          

          // $id = $this->getLastInserted('registration_form','form_id');
              $id = $this->db->insert_id();
          // adding dynamic manues  
          foreach($items as $key => $item)
            {   //  is_array($items)
                
                $title = $item['title'];
                $type = $item['type'];
                $required = '';
               
                if (array_key_exists('required', $item))
                {
                    $required ='Yes';
                }else
                {
                   $required = 'No';
                }
                
                $order =$item['order'];
                 if(!$item['order'])
                 {
                   $order = '0'; 
                 }
                $name ="field_".rand(0,9);
                $new_item = array ($id,$title,$name,$type,$required,$order ); 
              
               $query = "INSERT INTO fields(form_id,field_title,field_name,field_type,field_required,field_sequence) VALUES (?,?,?,?,?,?)";
               $this->db->query($query,$new_item ); 
                     
            }
           
      } 
      
      // last id find
     /*
      function getLastInserted($table, $id) {
        $query = "SELECT max($id) as $id from $table ";
            $result = $this->db->query($query);
            $row = $result->row_array();
            return $row[$id];
       }
        */
       
       
       
      // save form fields data 
      function save_form_fields_data($item)
      {
       
       foreach($items as $key => $item)
            {   //  is_array($items)
                
                $title = $item['title'];
                $type = $item['type'];
                
                if( is_array($item['required'])){
                    if($item['required']=='on'){
                      $required ='Yes';  
                    }else{
                        $required = 'No';}
                }else {
                   $required = 'No'; 
                 }
                $order =$item['order'];
                 if(!$item['order']){
                   $order = '0'; 
                }
                $name ="field_".rand(0,9);
                $new_item = array ($id,$title,$name,$type,$required,$order ); 
              
             //  $query = "INSERT INTO fields(form_id,field_title,field_name,field_type,field_required,field_sequence) VALUES (?,?,?,?,?,?)";
              // $this->db->query($query,$new_item ); 
                     
            }
       
       
       
          
          
      }   

    // method to genrate menu dropdown  
    function menu_list ()
    {
        $this->db->from($this->menu);
        $this->db->order_by('id');
        $result = $this->db->get();
        $return = array();
        if($result->num_rows() > 0){
                $return[''] = 'please select';
                foreach($result->result_array() as $row){
                $return[$row['id']] = $row['menu_id'];
                    }
                }
        return $return;
        
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
    
    // method to show contact page data 
    function registration_form_data ($page_id)
    {
        $query_string = "SELECT * FROM registration_form WHERE form_id = $page_id  AND form_publish ='1' ";

        $items = $this->db->query($query_string);
        $row = $items->row_array();  // values by array
        $reg_form_data = array();
        $reg_form_data['form_id'] = $row['form_id'];
        $reg_form_data['form_title'] = $row['form_title'];
        $reg_form_data['form_intro'] = $row['form_intro'];
        $reg_form_data['form_thank_u'] = $row['form_thank_u'];
        $reg_form_data['form_menu'] = $row['form_menu'];
        $reg_form_data['form_menu_parent'] = $row['form_menu_parent'];
        $reg_form_data['form_menu_item_text'] = $row['form_menu_item_text'];
        $reg_form_data['form_permissions'] = $row['form_permissions'];
        $reg_form_data['form_payment_required'] = $row['form_payment_required'];
        $reg_form_data['form_complete_action'] = $row['form_complete_action'];
        $reg_form_data['form_publish'] = $row['form_publish'];
        $reg_form_data['form_email_to'] = $row['form_email_to'];
        $reg_form_data['form_make_survey'] = $row['form_make_survey']; 
        
        return $reg_form_data; 

    }
    
    // Registration Form Fields 
    function registration_form_fields($page_id)
    {
        $query_string = "SELECT * FROM fields WHERE form_id = $page_id  AND field_delete ='0' order by field_sequence ASC";
         $dataset = $this->db->query($query_string);
         
          if($dataset->num_rows() > 0) {
            $output = array();
            $index = 0;
            foreach($dataset->result() as $items)
            {
             
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;

               if ($items->field_type == 'Check Boxes'){
                    $output[$index]['id'] = '<input id="'.$items->field_id.'" type="hidden" name="field['.$index.'][id]" value = "'.$items->field_id.'" >';
                    $output[$index]['label'] =  $items->field_title;
                    $output[$index]['field'] =  '<input id="check" type="checkbox" name="field['.$index.'][value]" >';
                    $output[$index]['required'] =  $items->field_required; 
                   
                   
               }else if($items->field_type == 'Radio Buttons'){
                    $output[$index]['id'] = '<input id="'.$items->field_id.'" type="hidden" name="field['.$index.'][id]" value = "'.$items->field_id.'" >';  
                    $output[$index]['label'] =  $items->field_title;
                    $output[$index]['field'] =  '<input id="" type="radio" value="" name="field['.$index.'][value]" >';
                    $output[$index]['required'] =  $items->field_required;    
                   
               }else if($items->field_type == 'Single-Line Text' ) {
                    $output[$index]['id'] = '<input id="'.$items->field_id.'" type="hidden" name="field['.$index.'][id]" value = "'.$items->field_id.'" >'; 
                    $output[$index]['label'] =  $items->field_title;
                    $output[$index]['field'] =  '<input type="text" id="" value="" name="field['.$index.'][value]">'; 
                    $output[$index]['required'] =  $items->field_required; 
                   
               }else if ($items->field_type == 'Multi-Line Text'){
                    $output[$index]['id'] = '<input id="'.$items->field_id.'" type="hidden" name="field['.$index.'][id]" value = "'.$items->field_id.'" >'; 
                    $output[$index]['label'] =  $items->field_title;
                    $output[$index]['field'] =  '<textarea id="" name="field['.$index.'][value]" title="'.$items->field_title.'"></textarea>';   
                    $output[$index]['required'] =  $items->field_required;
               }
               $index++;          
            }

        return $output;
        }   
        
    } 
    

    
    // method to show all contact 
    function show_all_forms()
    {
        $query_string = "SELECT * FROM registration_form WHERE form_delete = 0  ";
        $q = $this->db->query($query_string);
        
        if($q->num_rows() > 0) {
            $output = '';
            foreach($q->result() as $items)
            {
             
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;


                $output .='     <tr>
                          <td>'.$items->form_title.'</td> 
                          <td>'.$items->form_menu.'</td>
                          <td>'.$items->form_menu_item_text.'</td>
                          <td>'.$items->form_permissions.'</td>
                          <td>'.$items->form_payment_required.'</td>
                          <td>'.$items->form_complete_action.'</td>
                          <td>'.$items->form_publish.'</td>
                          <td>'.$items->form_email_to.'</td>
                          <td>'.$items->form_make_survey.'</td>  
                          <td><div style="color:blue;"> <a href=" '. base_url().'index.php/Registration_Froms/view_registration_form/'.$items->form_id.' " >   View</a>|<a  href=" '. base_url().'index.php/Edit_Registration_Form/index/'.$items->form_id.' " > Edit </a>|<a href= "'. base_url().'index.php/Registration_Froms/delete_form/'.$items->form_id.'" > Delete </a></div></td>
                         </tr>';
            }

        return $output;
        }   
        
    }
    
    // Method to delete softly contact data
    function delete_form_soft($page_id)
    {
       $query_string = "UPDATE registration_form SET form_delete = 1 WHERE form_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().'index.php/Registration_Froms'); 
    }
    
    // Method to delete Hard contact data
    function delete_form_hard($page_id)
    {
       $query_string = "DELETE FROM registration_form WHERE form_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().'index.php/Registration_Froms'); 
    }
    
    // Method to get selected id data 
    function get_form_data($rec_id)
    {
       $query_string = "SELECT * FROM registration_form WHERE form_id= $rec_id ";
       $q = $this->db->query($query_string); 
       $data = array ();
       $data =$q->result_array();
       return $data;
    }
    
    //fetch form fields
    function get_form_fields($rec_id)
    {
      $query_string = "SELECT * FROM fields WHERE form_id = $rec_id  AND field_delete ='0' order by field_sequence ASC";
       $q = $this->db->query($query_string); 
       $data = array ();
       $data =$q->result_array();
       return $data;  
        
        
    }
    
    //Method to edit contact data
    function edit_registration_form ($reg_form_data = array())
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
       
       $update['form_title'] = $reg_form_data[1];
       $update['form_intro'] = $reg_form_data[2];
       $update['form_thank_u'] = $reg_form_data[3]; 
       $update['form_menu'] = $reg_form_data[4]; 
       $update['form_menu_parent'] = $reg_form_data[5]; 
       $update['form_menu_item_text'] = $reg_form_data[6]; 
       $update['form_permissions'] = $reg_form_data[7]; 
       $update['form_payment_required'] = $reg_form_data[8]; 
       $update['form_complete_action'] = $reg_form_data[9]; 
       $update['form_publish'] = $reg_form_data[10]; 
       $update['form_email_to'] = $reg_form_data[11]; 
       $update['form_make_survey'] = $reg_form_data[12]; 
        
      // $where
       
      // $this->db->where($where);
       $this->db->where('form_id', $reg_form_data[0]);
       $this->db->update('registration_form', $update);

       
        
    }
     function edit_registration_form_fields($reg_form_field = array(),$new_id)
    {

         $update =  $reg_form_field;
      // $where
       
      // $this->db->where($where);
       $this->db->where('field_id', $new_id);
       $this->db->update('fields', $update);
  
    }
    

    
}
?>
