<?php
/*if(!session_start()){
    session_start();
}*/
  class Autoresponders_Model extends CI_Model {
      
    function __construct()
    {
                // Call the Model constructor  
        parent::__construct();
       
    }
    
     // method to save news letter data
     function save_autoresponder($data)
     {
        /* $query_str = "INSERT INTO autoresponders(respond_name,respond_group,respond_send_immediately,respond_send_value,respond_send_key,respond_send_after,respond_from_addrress,respond_to_address,respond_subject,respond_message_body,respond_active,site_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
         $this->db->query($query_str, $data);*/
		 $this->db->insert('autoresponders', $data); 
    		return true;
         
         
     }
    
         // method to show all contact 
    function show_all_autoresponder()
    {
        $query_string = "SELECT * FROM autoresponders WHERE respond_delete = 0  AND site_id =".$_SESSION['site_id'];
        $q = $this->db->query($query_string);
        
        if($q->num_rows() > 0) {
            $output = '';
            foreach($q->result() as $items)
            {
             
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;


                if($items->respond_send_immediately == 'Yes'){
                    $when_to_send =  'Immediately After User Signup';    
                }else{
                    $when_to_send = $items->respond_send_value .' '. $items->respond_send_key . ' After '.$items->respond_send_after;
                }
                if($items->respond_active == '1'){
                    $respond_active =  'Yes';    
                }else{
                    $respond_active =  'No';
                }
				$output .='     <tr>
                          <td>'.$items->respond_name.'</td> 
                          <td>'.$items->respond_group.'</td>
                          <td>'.$when_to_send.'</td>
                          <td>'.$respond_active.'</td>
                          <td><div style="color:blue;"> <a  href=" '. base_url().index_page().'Edit_Autoresponder/index/'.$_SESSION['site_id'].'/'.$items->respond_id.' " > Edit </a>|<a href= "'. base_url().index_page().'autoresponders_management/delete_autoresponder/'.$_SESSION['site_id'].'/'.$items->respond_id.'" > Delete </a></div></td>
                         </tr>';
						 
				
				//NOTE: Autoresponder View Link Commented 
				/*?><a href=" '. base_url().index_page().'autoresponders_management/view_autoresponder/'.$_SESSION['site_id'].'/'.$items->respond_id.' " >   View</a>|<?php */
            }

        return $output;
        }   
        
    }
    
    // method to fetch row for edit 
    function get_autoresponder_data($rec_id)
    {
       $query_string = "SELECT * FROM autoresponders WHERE respond_id = $rec_id ";
       $q = $this->db->query($query_string); 
       $data = array ();
       $data =$q->result_array();
       return $data;
    }
	
	function get_autoresponder_by_group_id($group_id)
    {
       $query_string = "SELECT * FROM autoresponders WHERE respond_group = $group_id AND respond_send_immediately = 'Yes' AND respond_active = 1";
       $q = $this->db->query($query_string); 
       $data = array ();
       $data = $q->result_array();
       return $data;
    }
	
         // Method to delete softly contact data
    function delete_soft($page_id)
    {
       $query_string = "UPDATE autoresponders SET respond_delete = 1 WHERE respond_id= $page_id  ";

        $q = $this->db->query($query_string); 
		return true;
        //redirect(base_url().'index.php/Autoresponders_Management'); 
    }
    
    // Method to delete Hard contact data
    function delete_hard($page_id)
    {
       $query_string = "DELETE FROM autoresponders WHERE respond_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().index_page().'Autoresponders_Management'); 
    }
    
     //Method to edit contact data
    function update_autoresponder ($data = array())
    {
      
       $this->db->where('respond_id', $data['respond_id']);
       $this->db->update('autoresponders', $data); 
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
    function autoresponder_data($rec_id)
    {
       $query_string = "SELECT * FROM autoresponders WHERE respond_id = $rec_id ";   
       $items = $this->db->query($query_string);
        $row = $items->row_array();  // values by array
        $data = array();
       $data['respond_id'] = $row['respond_id'];
       $data['respond_name'] = $row['respond_name'];
       $data['respond_group'] = $row['respond_group'];
       $data['respond_send_immediately'] = $row['respond_send_immediately'];
       $data['respond_send_value'] = $row['respond_send_value'];
       $data['respond_send_key'] = $row['respond_send_key'];
       $data['respond_send_after'] = $row['respond_send_after'];
       $data['respond_from_addrress'] = $row['respond_from_addrress'];
       $data['respond_to_address'] = $row['respond_to_address'];
       $data['respond_subject'] = $row['respond_subject'];
       $data['respond_message_body'] = $row['respond_message_body']; 
       $data['respond_active'] = $row['respond_active']; 
       return $data;
    }
	
	//By site_id
	function autoresponder_data_site_id($site_id)
    {
       $query_string = "SELECT * FROM autoresponders WHERE site_id = $site_id and respond_send_value = 0 and respond_send_immediately ='Yes'";   
       $items = $this->db->query($query_string);
        $data = $items->result_array();  // values by array
        
       return $data;
    }
	
	
	
	//Get site groups by site id
	function dropdown_site_gropus_by_site_id($site_id)
	{
			$data = array();
			$data[0] = 'Registered Users'; 
			$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' ";
			 
			 /*echo $qry;
			 exit;*/
			 $Q = $this->db->query($qry);
			 if ($Q->num_rows() > 0){
			   foreach ($Q->result_array() as $row){
				 $data[$row['id']] = $row['group_name'];
			   } 
			}
			$Q->free_result();
			return $data;
	}
	
	function get_customers_by_group_id($group_id)
	{
		$qry = "SELECT customer_login, customer_name, customer_email FROM ec_customers, ec_customers_group_xref WHERE ec_customers.customer_id = ec_customers_group_xref.customer_id AND ec_customers_group_xref.group_id =".$group_id;
			 
			 $Q = $this->db->query($qry);
			 $data = $Q->result_array();
			 return $data;
	}
	
	function get_all_autoresponder() 
	{
		/*$this->db->where("respond_delete",0);
		$this->db->where("site_id",$_SESSION['site_id']);
		$r = $this->db->get("autoresponders");*/
		
		$q = "
			SELECT *,g.id,g.group_name FROM autoresponders a
			JOIN groups g
			ON a.respond_group = g.id
			WHERE a.respond_delete = '0'
			AND a.site_id = ".$_SESSION['site_id'];
		$r = $this->db->query($q);
		
		if($r->num_rows() > 0)
		{
			$autos = $r->result_array();
			return $autos;
		}
		return false;
	}
	
    
}
?>
