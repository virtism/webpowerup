<?php
  class Promotional_Boxes_Model extends CI_Model {
      
    function __construct()
    {
                // Call the Model constructor  
        parent::__construct();
       
    }
    
     // method to save news letter data
     function save_promotional_boxe($data_array)
     {
         $query_str = "INSERT INTO promotional_boxes(box_title,box_show_title,box_product,box_position,box_order,box_publish,box_display_page,box_permissions,box_content,site_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
         $this->db->query($query_str, $data_array['data']);
     	 $last_insert_id = $this->db->insert_id();
		 if(!empty($data_array['group_id']))
		 {
			 foreach($data_array['group_id'] as $group)
			 {
				
				$this->db->query("INSERT INTO  access_levels_box_groups_xref(box_id, group_id) VALUES(".$last_insert_id.", ".$group.")");
			 }
		 }
	 }    
         // method to show all contact 
    function show_all_promotional_boxe()
    {	
		$site_id = $_SESSION['site_id'];
        
		$query_string = "SELECT * FROM promotional_boxes WHERE box_delete = 0 AND site_id = '".$site_id."' ";
        $q = $this->db->query($query_string);
        
        if($q->num_rows() > 0) {
            $output = '';
			$count_tr = 0;
            foreach($q->result() as $items)
            {
             $count_tr++;
//            foreach ($q->result_array() as $row) {
//                $data[] = $row;
					if($count_tr%2==0)
					{
						$class = 'even';
					}
					else
					{
						$class = 'odd';
					}

                $output .='<tr class='.$class.'>
                          <td>'.$items->box_title.'</td> 
                          <td>'.$items->box_show_title.'</td>
                          <td>'.$items->box_product.'</td>
                          <td>'.$items->box_position.'</td> 
                          <td>'.$items->box_order.'</td>
                          <td>'.$items->box_publish.'</td>
                          <td>'.$items->box_display_page.'</td>
                          <td>'.$items->box_permissions.'</td>
                          <td><div style="color:blue;white-space: nowrap; "><a  href=" '. base_url().index_page().'Edit_Promotional_Boxe/index/'.$items->box_id.' " > Edit </a>|<a onClick="return do_delete()" href= "'. base_url().index_page().'Promotional_Boxes_Management/delete_promotional_boxe/'.$items->box_id.'" > Delete </a></div></td>
                         </tr>';
						 /** This is box view link commented no neet for this yet**/
						 /*?> <a href=" '. base_url().'index.php/Promotional_Boxes_Management/view_promotional_boxe/'.$items->box_id.' " >   View</a>|<?php */
						 
            }

       return $output;
        }   
        
    }
	
	function get_user_group_id ($id=0)
	{
		//echo $id.'>>>>>>>>>>>>>';
			$rows = array();
			$gruop_id = 0;
			$this->db->select('membershipid,group_code');
			$this->db->where('customer_id',intval($id));
			$query = $this->db->get('ec_customers');
			//$query = $this->db->get_where('user_packages_xref', array('user_id' => intval($id)));  
			 if ($query->num_rows() > 0){
			   foreach ($query->result_array() as $row ){
				 // echo '%%%%%'.$row['membershipid'].'%%%';
				   if($row['membershipid'] != 0 || $row['membershipid'] != 'N/A' ){
						$gruop_id = $row['membershipid'];
				   }
				}
			 } 
			 
		 // echo $gruop_id.': >>>>>>>>>>>>>>>> '; exit();
		  return $gruop_id; 
	}
	
	function is_box_group($box_id, $group_id)
	{

		$result = $this->db->query('select * from access_levels_box_groups_xref where box_id='.$box_id.' and group_id = '.$group_id);
		$data = $result->result_array();
		if(count($data) > 0)
		{
			return true;
		}
		return false;				
	}
	 function getProduct($id=''){
		// getting info of single product.
		$data = array();
		$options = array('product_id' => intval($id));
		$Q = $this->db->get_where('ec_products',$options,1);
		if ($Q->num_rows() > 0){
			$data = $Q->row_array();
		}
		$Q->free_result();
		return $data;
	}
	 function getSiteNameById($site_id){
        $data = array();
        $raw_name = '';
        $site_name = '';
        $this->db->select('site_name');
        $options = array('site_id' =>intval($site_id));
        $Q = $this->db->get_where('sites',$options,1);
        $data = $Q->result_array();
        if(isset($data[0]['site_name'])){
		$raw_name = $data[0]['site_name'];
		}
        $site_name = str_replace(' ','_',strtolower(trim($raw_name))); 
        return $site_name;
    }
	function getCategory($cat_id='',$site_id=''){
		$data = array();
		$cat_name = '';
	    $this->db->select('cat_name');
		$options = array('cat_id' =>intval($cat_id),'site_id' =>intval($site_id));
		$Q = $this->db->get_where('ec_category',$options,1);
	    $data = $Q->result_array();
		if(isset($data[0]['cat_name']))
		{
			$cat_name = $data[0]['cat_name'];
		}	
		return $cat_name;   
 	}
	function getLeftPromotionalBox($site_id,$page_id = 1)
	{
			
			if(!empty($page_id))
			$query_string = "SELECT * FROM promotional_boxes WHERE site_id =".$site_id." AND box_display_page = ".$page_id." AND box_publish = 1 AND  box_delete = 0 order by box_order";
			
			$query_without_page = "SELECT * FROM promotional_boxes  WHERE box_delete = 0 AND box_publish = 1 AND  box_display_page = 1 AND site_id = ".$site_id;
		 	$without_page = $this->db->query($query_without_page);
		 	$result1 = $without_page->result_array();
		 	
        	$query = $this->db->query($query_string);
			$result2 = $query->result_array();
			$total_boxea = array_merge($result1, $result2);
			$data = array();
			$rows = array();
			
			if (count($total_boxea) > 0)
			{
			
			   foreach ($total_boxea as $row )
			   {
				   if($row['box_permissions'] == 'Level of Access')
				   {
						if(isset($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']))
						{	
							$group_id = $this->get_user_group_id($_SESSION['login_info']['customer_id']);
							$box_group = $this->is_box_group($row['box_id'],$group_id);
							if($box_group)
							{
								$names['sit_name'] = $this->getSiteNameById($site_id);		
								if($row['box_product'] != 0)
								{
									$product = $this->getProduct($row['box_product']);
									$names['cat_name'] = str_replace(' ','_',strtolower(trim($this->getCategory($product['category_id'],$site_id))));
									$data[] = array_merge($product, $row,$names);
								}
								else
								{
									//Content Box Only
										$data[] = $row['box_content'];		
								}	
							}
						}   
				   }
				   else if($row['box_permissions'] == 'Registered Users')
				   {
						if(isset ($_SESSION['login_info']) && isset ($_SESSION['login_info']['customer_id']) )
						{
							if($_SESSION['user_info']['user_id'])
							{
								$names['sit_name'] = $this->getSiteNameById($site_id);		
								if($row['box_product'] != 0)
								{
									$product = $this->getProduct($row['box_product']);
									$names['cat_name'] = str_replace(' ','_',strtolower(trim($this->getCategory($product['category_id'],$site_id))));
									$data[] = array_merge($product, $row,$names);		
								}
								else
								{
									//Content BOX
										$data[] = $row['box_content'];		
								}					
							}
						}  

				   }
				   else if($row['box_permissions'] == 'Every One')
				   {
						$names['sit_name'] = $this->getSiteNameById($site_id);		
						
						if($row['box_product'] != 0)
						{
							$product = $this->getProduct($row['box_product']);
							$names['cat_name'] = str_replace(' ','_',strtolower(trim($this->getCategory($product['category_id'],$site_id))));
							$data[] = array_merge($product, $row,$names);			
						}
						else
						{	
							//Content Box Only
							//$product = $this->getProduct($row['box_product']);
							//$names['cat_name'] = str_replace(' ','_',strtolower(trim($this->getCategory($product['category_id'],$site_id))));
							$data[] = $row;			

						}
							
				   }
				}
			 }
			//$query->free_result();
			//echo "<pre>";print_r($data);exit;
			return $data;
	}	
    // method to fetch row for edit 
    function get_promotional_boxe ($rec_id)
    {
       $query_string = "SELECT * FROM promotional_boxes WHERE box_id = $rec_id ";
       $q = $this->db->query($query_string); 
       $data = array ();
       $data =$q->result_array();
       return $data;
    }
         // Method to delete softly contact data
    function delete_soft($page_id)
    {
       $query_string = "UPDATE promotional_boxes SET box_delete = 1 WHERE box_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().index_page().'Promotional_Boxes_Management'); 
    }
    
    // Method to delete Hard contact data
    function delete_hard($page_id)
    {
       $query_string = "DELETE FROM promotional_boxes WHERE box_id= $page_id  ";

        $q = $this->db->query($query_string); 
        redirect(base_url().index_page().'Promotional_Boxes_Management'); 
    }
    
     //Method to edit contact data
    function update_promotional_boxe ($data = array())
    {
       
	   //echo "<pre>"; print_r($data); 
	   $update['box_id'] = $data['data'][0];	   
	   $update['box_title'] = $data['data'][1];
       $update['box_show_title'] = $data['data'][2];
       $update['box_product'] = $data['data'][3]; 
       $update['box_position'] = $data['data'][4]; 
       $update['box_order'] = $data['data'][5];
       $update['box_publish'] = $data['data'][6]; 
       $update['box_display_page'] = $data['data'][7]; 
       $update['box_permissions'] = $data['data'][8]; 
       $update['box_content'] = $data['data'][9];
	   $update['site_id'] = $data['data'][10];
       $this->db->where('box_id', $data['data'][0]);
       $this->db->update('promotional_boxes', $update);	   
	   
	   /** DELETE **/	   
	   $this->db->query("DELETE FROM access_levels_box_groups_xref WHERE box_id =".$data['data'][0]);
	   
	   if(!empty($data['group_id']))
		{
		   foreach($data['group_id'] as $group)
		   {
				/** UPDATE **/
				//$this->db->query("UPDATE  access_levels_box_groups_xref  SET group_id = ".$group." WHERE box_id = ".$data['data'][0]);
				
				/** INSERT **/
				$this->db->query("INSERT INTO  access_levels_box_groups_xref(box_id, group_id) VALUES(".$data['data'][0].", ".$group.")");				   			}
		}   
    }    
       // method to show left menue 
    function left_menu()
    {
         $query_string = "SELECT * FROM menus where menu_position = 'Left'  AND menu_published ='Yes'  AND menu_status = 'Active'";

        $items = $this->db->query($query_string);
        $left_menu_data ="<ul>";
        foreach ($items->result() as $row)
        {
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
    function show_promotional_boxe($rec_id)
    {
       $query_string = "SELECT * FROM promotional_boxes WHERE box_id = $rec_id "; 
       $items = $this->db->query($query_string);
        $row = $items->row_array();  // values by array
        $data = array();
       $data['box_id'] = $row['box_id'];
       $data['box_title'] = $row['box_title'];
       $data['box_show_title'] = $row['box_show_title'];
       $data['box_product'] = $row['box_product'];
       $data['box_position'] = $row['box_position'];
       $data['box_order'] = $row['box_order'];
       $data['box_publish'] = $row['box_publish'];
       $data['box_display_page'] = $row['box_display_page'];
       $data['box_permissions'] = $row['box_permissions'];
       $data['box_content'] = $row['box_content'];
       return $data;
    }
    function get_all_promotional_box()
	 {
		 $site_id = $_SESSION['site_id'];
		 $query_with_page = "
		 SELECT 
		 pb.box_id,
		 pb.box_title,
		 pb.box_show_title,
		 pb.box_product,
		 pb.box_position,
		 pb.box_order,
		 pb.box_publish,
		 pb.box_display_page,
		 pb.box_permissions,
		 pb.box_content,
		 pb.box_delete,
		 pb.site_id,
		 p.page_id,
		 p.page_title
		 FROM promotional_boxes AS pb
		 JOIN pages AS p 
		 ON pb.box_display_page = p.page_id
		 WHERE pb.box_delete = 0 AND pb.site_id = '".$site_id."'";
		 $query_without_page = "SELECT * FROM promotional_boxes  WHERE box_delete = 0 AND box_display_page = 1 AND site_id = ".$site_id;
		 
		 $with_page = $this->db->query($query_with_page);
		 $without_page = $this->db->query($query_without_page);
		//print_r($without_page->result_array());
		 $result1 = $with_page->num_rows();
		 $result2 = $without_page->num_rows();
		 $result = '';
		
		 if($result1 > 0 && $result2> 0)
		 {
			$result = array_merge($with_page->result_array(),  $without_page->result_array());
			//echo "<pre>";print_r($result);exit;
		 }
		 else
		 {	
		 	
			if(!empty($result1) && $result1 !=0)
			{
				
				$result = $with_page->result_array();
				
				
				
			}
			else if(isset($result2))
			{
				 
				$result = $without_page->result_array();
				 
				 
			}
		 	
		 	
		 }
		 
		 //print_r($result);exit;
		 return $result;
	 }
}
?>
