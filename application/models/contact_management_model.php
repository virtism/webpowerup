<?php
class Contact_Management_Model extends CI_Model {

      

    function __construct()

    {

                // Call the Model constructor  

        parent::__construct();

       

    }

    

    // method used to save user registration information 

      function add_contact_data($contact_data = array()) 

      {

          //$hash_pass = sha1($user_password);

          //echo "<pre>";

//         print_r($contact_data);

         

           $query_str = "INSERT INTO contact_manage(contact_name,contact_country,contact_state,contact_city,contact_address,contact_zip,contact_position,contact_phone,contact_fax,contact_google_code,contact_extra_info,contact_publish) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

           $this->db->query($query_str, array($contact_data['contact_name'],$contact_data['contact_country'],$contact_data['contact_state'],$contact_data['contact_city'],$contact_data['contact_address'],$contact_data['contact_zip'],$contact_data['contact_position'],$contact_data['contact_phone'],$contact_data['contact_fax'],$contact_data['contact_google_code'],$contact_data['contact_extra_info'],$contact_data['contact_publish']));

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

    function contact_page_data ($page_id)

    {

        $query_string = "SELECT * FROM contact_manage WHERE contact_id = $page_id  AND contact_publish ='1' AND contact_delete = 0";



        $items = $this->db->query($query_string);

        $row = $items->row_array();  // values by array

        $contact_data = array();

        $contact_data['contact_id'] = $row['contact_id'];

        $contact_data['contact_name'] = $row['contact_name'];

        $contact_data['contact_country'] = $row['contact_country'];

        $contact_data['contact_state'] = $row['contact_state'];

        $contact_data['contact_city'] = $row['contact_city'];

        $contact_data['contact_address'] = $row['contact_address'];

        $contact_data['contact_zip'] = $row['contact_zip'];

        $contact_data['contact_position'] = $row['contact_position'];

        $contact_data['contact_phone'] = $row['contact_phone'];

        $contact_data['contact_fax'] = $row['contact_fax'];

        $contact_data['contact_google_code'] = $row['contact_google_code'];

        $contact_data['contact_extra_info'] = $row['contact_extra_info'];

        

        return $contact_data; 



    }

    

    // method to show all contact 

    function show_all_contact()

    {

        $query_string = "SELECT * FROM contact_manage WHERE contact_delete = 0  ";

        $q = $this->db->query($query_string);

        

        if($q->num_rows() > 0) {

            $output = '';

            foreach($q->result() as $items)

            {

             

//            foreach ($q->result_array() as $row) {

//                $data[] = $row;





                $output .='     <tr>

                          <td>'.$items->contact_name.'</td> 

                          <td>'.$items->contact_country.'</td>

                          <td>'.$items->contact_state.'</td>

                          <td>'.$items->contact_city.'</td>

                          <td>'.$items->contact_zip.'</td>

                          <td>'.$items->contact_phone.'</td>

                          <td>'.$items->contact_fax.'</td>

                          <td>'.$items->contact_publish.'</td>

                          <td><div style="color:blue;"> <a href=" '. base_url().'index.php/Contact_Management/view_Contact_page/'.$items->contact_id.' " >   View</a>|<a  href=" '. base_url().'index.php/Edit_Contact/index/'.$items->contact_id.' " > Edit </a>|<a href= "'. base_url().'index.php/Contact_Management/delete_contact/'.$items->contact_id.'" > Delete </a></div></td>

                         </tr>';

            }



        return $output;

        }   

        

    }

    

    // Method to delete softly contact data

    function delete_contact_soft($page_id)

    {

       $query_string = "UPDATE contact_manage SET contact_delete = 1 WHERE contact_id= $page_id  ";



        $q = $this->db->query($query_string); 

        redirect(base_url().'index.php/Contact_Management'); 

    }

    

    // Method to delete Hard contact data

    function delete_contact_hard($page_id)

    {

       $query_string = "DELETE FROM contact_manage WHERE contact_id= $page_id  ";



        $q = $this->db->query($query_string); 

        redirect(base_url().'index.php/Contact_Management'); 

    }

    

    // Method to get selected id data 

    function get_contact_data($rec_id)

    {

       $query_string = "SELECT * FROM contact_manage WHERE contact_id= $rec_id ";

       $q = $this->db->query($query_string); 

       $data = array ();

       $data =$q->result_array();

       return $data;

    }

    

    //Method to edit contact data

    function edit_contact_data ($contact_data = array())

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

       

       $update['contact_name'] = $contact_data[1];

       $update['contact_country'] = $contact_data[2];

       $update['contact_state'] = $contact_data[3]; 

       $update['contact_city'] = $contact_data[4]; 

       $update['contact_address'] = $contact_data[5]; 

       $update['contact_zip'] = $contact_data[6]; 

       $update['contact_position'] = $contact_data[7]; 

       $update['contact_phone'] = $contact_data[8]; 

       $update['contact_fax'] = $contact_data[9]; 

       $update['contact_google_code'] = $contact_data[10]; 

       $update['contact_extra_info'] = $contact_data[11]; 

       $update['contact_publish'] = $contact_data[12]; 

        

      // $where

       

      // $this->db->where($where);

       $this->db->where('contact_id', $contact_data[0]);

       $this->db->update('contact_manage', $update);



       

        

    }

   		// This function will check either form exists in contact_form_management with current site-id 
    function check_contact_form($site_id)
    {
        $query_string = "SELECT * FROM contact_management_form WHERE site_id = '".$site_id."' ";

		$items = mysql_query($query_string);
		
		if(mysql_num_rows($items) > 0)
		{		
			while($row = mysql_fetch_assoc($items))
			{
				$data_array = $row;
			}
		}
		
		$data_array['flag'] = mysql_num_rows($items);     
       	return $data_array;
    }	
 		
		// This function will add new row in contact_form_management
	function add_contact_form($site_id,$data_array)
	{
       $query_string = "INSERT INTO contact_management_form (site_id, caption_Name, caption_Subject, caption_EmailTo, caption_Message, publish)
VALUES ('".$site_id."', '".$data_array[0]."', '".$data_array[1]."', '".$data_array[2]."', '".$data_array[3]."' , '".$data_array[4]."') ";

        $q = $this->db->query($query_string); 
        redirect('SiteController/sitehome/'.$site_id); 
	}

		// This function will update contact_form_management in database
	function update_contact_form($site_id,$data_array)
	{
       $query_string = "UPDATE contact_management_form SET caption_Name = '".$data_array[0]."' , caption_Subject = '".$data_array[1]."' , caption_EmailTo = '".$data_array[2]."' , caption_Message = '".$data_array[3]."' , publish = '".$data_array[4]."' WHERE site_id = '".$site_id."' ";

        $q = $this->db->query($query_string); 
        redirect('SiteController/sitehome/'.$site_id); 
	}     



    

}

?>