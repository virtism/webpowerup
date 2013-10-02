<?php
  class Registration_Forms_Model extends CI_Model {
      
    function __construct()
    {
                // Call the Model constructor  
				
        parent::__construct();
       
    }
    
     // method to save form fields values
     function form_fields_value_save($field_value, $id)
     {
         
		   $values_ary = array($id,$field_value);
            $query_str = "INSERT INTO fields_options(field_id,option_value) VALUES (?,?)";
           $this->db->query($query_str,$values_ary );   
         
     }
	 
	 function form_fields_value_update($field_value, $id)
     {
            $query_str = "UPDATE fields_options SET option_value = '".$field_value."' WHERE field_id = ".$id."";
           $this->db->query($query_str);   
         
     }
   
    function delete_field($id)
	{
		  $this->db->where('field_id', $id);
		  $r = $this->db->delete('fields'); 
		  if($r)
		  {
			  return true;
		  }
		  return false;
	}
	
	function delete_field_by_webinar_id($id)
	{
		  $this->db->where('field_id', $id);
		  $r = $this->db->delete('fields_options'); 
		  if($r)
		  {
			  return true;
		  }
		  return false;
	}
    
    // method used to save user registration information 
      function add_registration_form($reg_form_data = array(),$items) 
      {
  			//die($reg_form_data['form_menu_page']);
  
			if(!empty($reg_form_data['group_access']))
			{
				$group_comma_separated = implode(",", $reg_form_data['group_access']);										
			}
			else
			{
				$group_comma_separated = "0";
			}
            $values_ary = array($reg_form_data['form_title'],$reg_form_data['site_id'],$reg_form_data['form_intro'],$reg_form_data['form_thank_u'],$reg_form_data['form_menu'],$reg_form_data['form_menu_page'],$reg_form_data['form_menu_parent'],$reg_form_data['form_menu_item_text'],$reg_form_data['form_permissions'],$group_comma_separated,$reg_form_data['form_payment_required'],$reg_form_data['form_payment_qty'],$reg_form_data['form_complete_action'],$reg_form_data['form_publish'],$reg_form_data['form_email_to'],$reg_form_data['form_make_survey']);
            $query_str = "INSERT INTO registration_form(form_title,site_id,form_intro,form_thank_u,menu_id,page_id,form_menu_parent,form_menu_item_text,form_permissions,group_id,form_payment_required,pyment_qty,form_complete_action,form_publish,form_email_to,form_make_survey) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			//die($query_str);
			
           $this->db->query($query_str,$values_ary );
           $id = $this->db->insert_id();
		  //*****Query for relation form and groups****//
		  
		  if(!empty($reg_form_data['group_access']))
		  {
		  	foreach($reg_form_data['group_access'] as $group_id)
			{
				$query_str = "INSERT INTO access_levels_reg_form_groups_xref(form_id,group_id,site_id) VALUES (".$id.",".$group_id.",".$reg_form_data['site_id'].")";
				$this->db->query($query_str);		
			}
		  }		  
		  // $id = $this->getLastInserted('registration_form','form_id');     
		  
		  if($id)
		  {
			  if($reg_form_data['form_complete_action'] == "Redirect URL" )
			  {
				  $data = array(
				  	"form_redirect_to" => $this->input->post("form_redirect_to")
				  );
				  $this->db->where("form_id",$id);
				  $this->db->update("registration_form",$data);
			  }
		  }
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
              
               $query = "INSERT INTO fields(form_id,field_title,field_name,field_type,field_required,field_sequence) VALUES (?,?,?,?,?,?)";
              $this->db->query($query,$new_item ); 
                     
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
		$reg_form_data['site_id'] = $row['site_id']; 
       // $reg_form_data['form_menu'] = $row['form_menu'];
        $reg_form_data['form_menu_parent'] = $row['form_menu_parent'];
        $reg_form_data['form_menu_item_text'] = $row['form_menu_item_text'];
        $reg_form_data['form_permissions'] = $row['form_permissions'];
        $reg_form_data['form_payment_required'] = $row['form_payment_required'];
        $reg_form_data['form_complete_action'] = $row['form_complete_action'];
        $reg_form_data['form_publish'] = $row['form_publish'];
        $reg_form_data['form_email_to'] = $row['form_email_to'];
        $reg_form_data['form_make_survey'] = $row['form_make_survey']; 
		$reg_form_data['form_redirect_to'] = $row['form_redirect_to']; 
        
		
        return $reg_form_data; 

    }
	
    function get_fields_options($field_id)
	{
		// echo $field_id;die();
		$this->db->where("field_id",$field_id);
		$r = $this->db->get("fields_options");
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
	
    // Registration Form Fields 
    function registration_form_fields($form_id)
    {
        $query_string = "SELECT * FROM fields f
						 WHERE form_id = $form_id 
						 order by field_sequence ASC";
         $dataset = $this->db->query($query_string);
         
         
		  if($dataset->num_rows() > 0) {
            $output = array();
            $index = 0;
            foreach($dataset->result() as $items)
            {
  
          	   
				// CHECK BOX
               if ($items->field_type == 'Check Boxes') 
			   {
				   
                    $output[$index]['id'] = ' <input id="'.$items->field_id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >';
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
					$field_id = $items->field_id;
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
                    $output[$index]['id'] = '<input id="'.$items->field_id.'" type="hidden" name="field['.$index.'][name]" value = "'.trim($items->field_title).'" >';  
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
					$field_id = $items->field_id;
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
			   else if($items->field_type == 'Single-Line Text' ) {
                    $output[$index]['id'] = '<input id="'.$items->field_id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >'; 
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
                   
               }
			   // MULTI LINE TEXT
			   else if ($items->field_type == 'Multi-Line Text')
			   {
				    
                    $output[$index]['id'] = '<input id="'.$items->field_id.'" type="hidden" name="field['.$index.'][name]" value = "'.$items->field_title.'" >'; 
                    $output[$index]['label'] =  $items->field_title;
					
					$field_id = $items->field_id;
					/*echo "<pre>";	print_r($field_id);	die();
					$options = $this->get_fields_options($field_id);
					echo "<pre>";	print_r($options);	die();*/
					if($options)
					{
						foreach($options as $opt)
						{
							$textbox = (explode(",",$opt['option_value']));
						}
						
						$cols = $textbox[0];
						$rows = $textbox[1];
						
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
			/*echo "<pre>";
			print_r($output);
			exit;*/
        return $output;
        }   
        
    } 
    

    
    // method to show all contact 
    function show_all_forms($site_id=0)
    {
        $query_string = "SELECT * FROM registration_form WHERE form_delete = 0  AND  site_id=$site_id  ";
   //  exit();
        $q = $this->db->query($query_string);
        
        if($q->num_rows() > 0) {
            $output = '';
            $count_form = 0;
			foreach($q->result() as $items)
            {
             $count_form++;
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;
                         $payment_required = ($items->form_payment_required ==1 ? 'Yes' : 'No');
                         $form_publish = ($items->form_publish ==1 ? 'Yes' : 'No');
                         $make_survey = ($items->form_make_survey ==1 ? 'Yes' : 'No');
					if($count_form%2==0)
					{
						$class = 'even';
					}
					else
					{
						$class = 'odd';
					}

              
                $output .='<tr class='.$class.'>
                          <td>'.$items->form_title.'</td> 
                          <td>'.$items->form_permissions.'</td>
                          <td>'.$payment_required.'</td>
                          <td>'.$items->form_complete_action.'</td>
                          <td>'.$form_publish.'</td>
                          <td>'.$items->form_email_to.'</td>
                          <td>'.$make_survey.'</td>  
                          <td><div style="color:blue;white-space:nowrap;"><a  href=" '. base_url().index_page().'Edit_Registration_Form/index/'.$items->form_id.' " > Edit </a>|<a id="delete_form" href= "'. base_url().index_page().'Registration_Froms/delete_form/'.$items->form_id.'"  onclick="return deleteForm();"> Delete </a></div></td></tr>';
						 
		//*** This link fro view form  ***//
		
		/*<a href=" '. base_url().'index.php/Registration_Froms/view_registration_form/'.$items->form_id.' " >   View</a>|*/
						 
            }

        return $output;
        }   
        
    }
	
    
    // Method to delete softly contact data
    function delete_form_soft($page_id)
    {
       $query_string = "UPDATE registration_form SET form_delete = 1 WHERE form_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().index_page().'Registration_Froms'); 
    }
    
    // Method to delete Hard contact data
    function delete_form_hard($page_id)
    {
       $query_string = "DELETE FROM registration_form WHERE form_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().index_page().'Registration_Froms'); 
    }
    
    // Method to get selected id data 
    function get_form_data($rec_id)
    {
       $query_string = "SELECT * FROM registration_form WHERE form_id= $rec_id ";
	   $q = $this->db->query($query_string); 
       $data = array ();
       $data =$q->result_array();
	   
	   //****This is join query getting results from both tables registration_form , menus
	   /*$query_string_allDataWith_menu_name = "SELECT registration_form . * , menus.menu_name 
	   										  FROM registration_form, menus
											  WHERE registration_form.form_id =".$data[0]['form_id']."
											  AND menus.menu_id =".$data[0]['menu_id'];*/
											 
		$query_string_menu_name = $this->db->query("SELECT menu_name FROM menus WHERE menu_id =".$data[0]['menu_id']); 		
		$query_string_menu_name_array =$query_string_menu_name->result_array();
		if(isset($query_string_menu_name_array[0]['menu_name']))
		{
	   		$data[0]['form_menu'] = $query_string_menu_name_array[0]['menu_name'];
		}
		
		
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
	
	function get_form_fields_options($rec_id)
	{
		
		 $record = array();
		 $index = 0;
		 $query = "SELECT * FROM fields_options o
				   JOIN  fields f
				   ON f.field_id = o.field_id
				   WHERE form_id = ".$rec_id."
				   AND field_type = 'Single-Line Text'";
		
	    $row = $this->db->query($query);
		$record['single_line'] = $row->result_array();
		
		 $query = "SELECT * FROM fields_options o
				   JOIN  fields f
				   ON f.field_id = o.field_id
				   WHERE form_id = ".$rec_id."
				   AND field_type = 'Multi-Line Text'";
	    $row = $this->db->query($query);
		$record['Multi_line'] = $row->result_array();
		
		 $query = "SELECT * FROM fields_options o
				   JOIN  fields f
				   ON f.field_id = o.field_id
				   WHERE form_id = ".$rec_id."
				   AND field_type = 'Radio Buttons'";
	    $row = $this->db->query($query);
		$record['Radio_Buttons'] = $row->result_array();
		 $query = "SELECT * FROM fields_options o
				   JOIN  fields f
				   ON f.field_id = o.field_id
				   WHERE form_id = ".$rec_id."
				   AND field_type = 'Check Boxes'";
	    $row = $this->db->query($query);
		$record['Check_Boxes'] = $row->result_array();
	
	    return $record;	 
				   
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
       $update['menu_id'] = $reg_form_data[4]; 
	  
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
     function edit_registration_form_fields($update,$field_id)
    {
      
		//echo "<pre>";	print_r($update);	die();
		
		if( $field_id != 0 )
		{
			$this->db->where('field_id', $field_id );
			$this->db->update('fields', $update);
			
		}
		else
		{
			$this->db->insert('fields', $update);
			$field_id = $this->db->insert_id();
		}
		return $field_id;
	
    }
    
    function get_Form($fm_id=0)
    {
        $data = array();
        //$options = array('product_id' => intval($id));
        // $Q = $this->db->get_where('ec_products_attributes',$options,1);
        $this->db->where('form_id',intval($fm_id)); 
        $Q = $this->db->get('registration_form');

        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){ 
                $data[] = $row;
            }
         
             $Q->free_result(); 
			 // echo '<pre>';  print_r($data); exit;
             return $data[0];
        }
       

        $Q->free_result(); 
        return $data;
    }   
	
	//Save user form data
	function save_form_data($form_values_arr, $form_id)
	{
		$data = array("form_id"=>$form_id);
		$this->db->insert("registration_form_submits",$data);
		$submit_id = $this->db->insert_id();
		
		 $final_array = array_values($form_values_arr);
		 $total = count($final_array);			 
		 for($i=0; $i<$total; $i++)
		 {
			$query = "INSERT INTO registration_form_data(submit_id,form_id,form_field_name,form_field_value) VALUES ('$submit_id',".$form_id.",".$this->db->escape($final_array[$i]['name']).",".$this->db->escape($final_array[$i]['value']).")";
			$this->db->query($query);
		 } 
	}
	
	function get_all_form($site_id)
	{
		 $query = "SELECT * FROM registration_form WHERE form_delete = 0  AND  site_id=$site_id  ";
		 $r = $this->db->query($query);
		 $n = $r->num_rows();
		 if($n > 0)
		 {
			 $result = $r->result_array();
			 return $result;
		 }
		 return false;
	}
	
	function get_all_form_submits_old($form_id)
	{
		 $query = "SELECT * FROM registration_form_data WHERE form_id = '$form_id' GROUP BY form_field_name ";
		 $r = $this->db->query($query);
		 $field_number = $r->num_rows();
		 
		 $query = "SELECT * FROM registration_form_data WHERE form_id = '$form_id' ";
		 $r = $this->db->query($query);
		 $n = $r->num_rows();
		 $this->firephp->log($r->result_array());
		 if($n > 0)
		 {
			 $result = $r->result_array();
			 //echo "<pre>";	print_r($result);	echo "</pre>";
			
			 $j = 1;
			 $i = 0;
			 // $this->firephp->log($field_number);
			 foreach($result as $rwo)
			 {
				
				 $submits[$i][] = $rwo;
				 if($j < $field_number)
				 {
					 $j++; 
				 }
				 else
				 {
					 $i++;
					 $j=1;
				 }
				 
			 }
			 $this->firephp->log($submits);
			 
			 return $submits;
		 }
		 return false;
	}
	
	function get_all_form_submits_for_export($form_id)
	{
		 
		 $query = "SELECT form_field_name,form_field_value FROM registration_form_data WHERE form_id = '$form_id' ";
		 $r = $this->db->query($query);
		 $n = $r->num_rows();
		 if($n > 0)
		 {
			 $result = $r->result_array();
			 return $result;
		 }
		 return false;
	}
	
	function get_all_form_submits($form_id)
	{
		 $query = "SELECT * FROM registration_form_data WHERE form_id = '$form_id' GROUP BY submit_id ";
		 $r = $this->db->query($query);
		 $n = $r->num_rows();
		
		 if($n > 0)
		 {
			 $submits = $r->result_array();
			 //$submits = array_unique($submits);
//			 echo "<pre>";print_r($submits);exit;
			 /*?> foreach($submits as $submit)
			 {
	//echo "<pre>";print_r($submit);
				$query = "SELECT c.customer_fname,c.customer_lname, c.customer_email FROM ec_customers c JOIN registration_form_customer_submits  rfc ON  c.customer_id = rfc.customer_id WHERE rfc.form_id = ".$submit['form_id']." GROUP BY rfc.form_id";
				 $r_cust = $this->db->query($query);
				 $n_cust = $r_cust->num_rows();
				
				 if($n_cust > 0)
				 {
					 $submits_cust = $r_cust->result_array();
					 $array_merge ($submits_cust, $submit);
					 echo "<pre>";print_r($submits_cust);
				 }
			  */
			 
			 //}
			 
			 
			 
			 return $submits;
		 }
		 return false;
	}
	
	
	
	
	
	function get_form_submits_detail($submit_id)
	{
		$this->db->where("submit_id",$submit_id);
		$r = $this->db->get("registration_form_data");
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
		$r = $this->db->delete("registration_form_data");
		if($r)
		{
			return true;
		}
		return false;
	}
	
	function get_form_by_page_id($page_id)
	{
		$this->db->where("page_id",$page_id);
		$this->db->where("form_delete",0);
		$r = $this->db->get("registration_form");
		$n = $r->num_rows();
		if ($n > 0)
		{
			$submit = $r->result_array();
			return $submit;
		}
		return false;
		
	}
	
	function save_form_payment()
	{
		$txn_id = $_REQUEST['txn_id'];
		$payment_gross = $_REQUEST['payment_gross'];
		$payment_status = $_REQUEST['payment_status'];
		$item_id = $_REQUEST['item_number'];
		$payment_date = $_REQUEST['payment_date'];
		$payer_email = $_REQUEST['payer_email']; 	//the email used to pay 
		$payer_id = $_REQUEST['payer_id'];
		$payer_status = $_REQUEST['payer_status'];
		$tax = $_REQUEST['tax'];
		$receiver_email = $_REQUEST['receiver_email'];
		$receipt_id = $_REQUEST['receiver_id'];
		$customer_name = $_REQUEST['address_name'];
		$address_city = $_REQUEST['address_city'];
		
		$customer_id = $_REQUEST['custom'];
		
		$data = array(
		   'customer_id' =>  $customer_id, 
		   'txn_id' => $txn_id,
		   'payment_gross' => $payment_gross,
		   'payment_status' => $payment_status,
		   'item_id' => $item_id,
		   'payment_date' => $payment_date,
		   'payer_email' => $payer_email,
		   'payer_id' => $payer_id,
		   'payer_status' => $payer_status,
		   'tax' => $tax,
		   'receiver_email' => $receiver_email,
		   'receipt_id' => $receipt_id,
		   'customer_name' => $customer_name,
		   'address_city' => $address_city
		);
		
		$r = $this->db->insert('registration_form_payments', $data);  
		
		if ($r)
		{  
			return true;
		}
		
		return false;
		
	}
	
	function if_customer_paid_for_the_form($item_id,$customer_id)
	{
		$this->db->where("customer_id",$customer_id);
		$this->db->where("item_id",$item_id);
		$r = $this->db->get("registration_form_payments");
		$n = $r->num_rows();
		if ($n > 0)
		{
			return true;
		}
		return false;
	}
	
	function if_customer_submitted_the_form($form_id, $customer_id)
	{
		$this->db->where("customer_id",$customer_id);
		$this->db->where("form_id",$form_id);
		$r = $this->db->get("registration_form_customer_submits");
		$n = $r->num_rows();
		if ($n > 0)
		{
			return true;
		}
		return false;
	}
	function save_form_customer_submits($form_id,$customer_id)
	{
		$data = array(
			'customer_id' =>  $customer_id,
			'form_id' => $form_id
		);
		$r = $this->db->insert('registration_form_customer_submits', $data); 
	}
}
?>