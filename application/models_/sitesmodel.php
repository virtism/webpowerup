<?php
@session_start();
class SitesModel extends CI_Model {
	
		function SitesModel(){
		parent::__construct(); 
		$this->load->database();
		$this->load->database('Menus_Model');        
	}
	

	function creat_new_site()
	{
		if(isset($_SESSION["user_info"]["user_id"]))
		{
			//echo "<pre>";
			//print_r($_POST);
			//exit;
			
			$insertSiteArray = array(
					'user_id' => $_SESSION["user_info"]["user_id"],
					'package_id' => $_POST["package_id"],
					'site_name' => $_POST["site_name"],
					'site_url' => $_POST["site_url"],
					'site_description' => $_POST["site_description"],
					'site_status' => $_POST["site_status"],
					'site_create_date' => date('Y-m-d h:i:s')
					);
			/*echo "<pre>";
			print_r($insertSiteArray);
			exit;*/
			
			$insert = $this->db->insert('sites', $insertSiteArray);
			$site_id = $this->db->insert_id(); 	
			$this->db->query("INSERT INTO menus(menu_name ,menu_position ,menu_published ,menu_status ,menu_start ,menu_end ,menu_pages ,menu_access, menu_order, site_id, parent_menu, is_default) VALUES ('User Menu', 'Left', 'Yes', 'Active', '', '', 'All', 'Registered', 2, ".$this->db->escape($site_id).",0,1)");	
			return $site_id;
			
		}
		
	}
	
	function get_all_sites_by_user($user_id)
	{
		$qry = "SELECT * FROM sites WHERE site_status != 'Deleted' AND user_id = '".$user_id."'";
		
		$query = $this->db->query($qry);
		$sitesArray = $query->result_array();
		return $sitesArray;
	}

	
	function get_all_sites()
	{
		$qry = "SELECT * FROM sites WHERE site_status != 'Deleted'";
		$query = $this->db->query($qry);	
		$sitesArray = $query->result_array();
		return $sitesArray; 
	}
	
	// method to get all sites of specific users 
	function get_all_sites_spec($user_id)
	{
		$qry = "SELECT * FROM sites WHERE user_id = $user_id AND site_status != 'Deleted'";
		$query = $this->db->query($qry);    
		$sitesArray = $query->result_array();
		return $sitesArray; 
	}
	
	function get_site_by_id($site_id)
	{
		$qry = "SELECT * FROM sites WHERE site_id = '".$site_id."'";
		$query = $this->db->query($qry);	
		$sitesArray = $query->result_array();
		return $sitesArray;	
	}
	
	function is_already_exist()
	{
		$this->db->where('role_name', $this->input->post('role_name'));
		$query = $this->db->get('roles');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function creat_page()
	{
			 //echo "asas";
		$insertPageArray = array(
					'site_id' => '1',
					'page_title' => $_POST["page_title"],
					'page_seo_url' => $_POST["page_seo_url"],
					'page_code' => $_POST["page_code"],
					'page_seo_url' => $_POST["page_seo_url"],
					'page_create_date' => "NOW()",
					'page_seo_url' => $_POST["page_seo_url"]
					);
		
		$insert = $this->db->insert('pages', $insertPageArray);
		$page_id = $this->db->insert_id(); 
		
		$insertContentArray = array(
																'page_id' => $page_id,
																'page_content' => mysql_escape_string($_POST["page_content"])
																);
		$insert2 = $this->db->insert('page_content', $insertContentArray);
																
			 
		 
		return $insert;
	}
	
	function get_role_by_id($id)
	{
		$this->db->where('role_id', $id);    
		$query = $this->db->get('roles');
		return $query->result(); 
		
	}
	function get_page_data_by_id($id)
	{
		$qry = "SELECT * FROM pages p,page_content pc WHERE p.page_id = '".$id."' AND p.page_id = pc.page_id ";

		$query = $this->db->query($qry);
		$page_data = $query->result_array(); 
		return $page_data; 
		
	}
	function get_all_pages()
	{
		$query = $this->db->get('pages');
		
		$allPages = $query->result_array();
		return $allPages; 
	}
	
	// method to get pakage id by user id 
	function get_pakage_id_by_user_id($user_id)
	{
		$qry = "SELECT package_id FROM user_packages_xref WHERE user_id = '".$user_id."'";
		$query = $this->db->query($qry);    
		$pkgArray = $query->result_array();
		
		return $pkgArray[0]['package_id'];      
		
	}
	
	
   // save site info through sign up wizard  
	function creat_new_site_by_signup($get_value,$user_id)
	{  
			$trial_start_date = date('Y-m-d H:i:s');
			$this->load->helper("date_helper");
			$end_date = add_month_to_date($trial_start_date);
			
			$site_domain = str_replace("http://","",$get_value["site_domain"]);
			$insertSiteArray = array(
					'user_id' => $user_id,
					'package_id' => $get_value["package"],
				 //   'site_name' => $get_value["site_name"],
				 //   'site_url' => $get_value["site_url"],
				 //   'site_description' => $get_value["site_description"],
				 //   'site_status' => $get_value["site_status"],
				 	'domain' => $get_value["domain"],
					'site_create_date' => $trial_start_date,
					'site_expire_date' => $end_date,
					'site_name' => $get_value["site_title"],
					'site_type' => $get_value["type_of_site"],
					'site_category' => $get_value["site_category"],
					'site_url' => $get_value["site_domain"],
					'site_domain' => $site_domain
					);
		
			$insert = $this->db->insert('sites', $insertSiteArray);
			$site_id = $this->db->insert_id();     
			
			
			
			$template_array_data = array (
						'site_id' =>  $site_id,
						'temp_id' => $get_value["template_select"] 
						);
			
				$this->db->insert('sites_templates_xref',$template_array_data)  ;
		   
		   $package_id = $this->Menus_Model->get_user_package($user_id);
		   if($package_id == '3')
		   {
			  $store_setting_data = array (
						'site_id' =>  $site_id
						
						);
			
				$this->db->insert('site_store_settings',$store_setting_data)  ;
			}
			$this->db->query("INSERT INTO menus(menu_name ,menu_position ,menu_published ,menu_status ,menu_start ,menu_end ,menu_pages ,menu_access, menu_order, site_id, parent_menu, is_default) VALUES ('User Menu', 'Left', 'Yes', 'Active', '', '', 'All', 'Registered', 2, ".$this->db->escape($site_id).",0,1)");	
			 return $site_id;   
			 //return true;
			
	}
	
	function update_expire_status_of_all_site($user_id)
	{
		$query = "SELECT * FROM sites WHERE user_id = '$user_id' ";
		$r = $this->db->query($query);
		$n = $r->num_rows();
		if ($n > 0)
		{
			foreach($r->result_array() as $site)
			{
				//echo strtotime($site['site_expire_date'])."<br>";
				
				if( $site['site_id'] != 113 && strtotime($site['site_expire_date']) != "-62169966000")
				{
					$now_date = strtotime(date("Y-m-d H:i:s"));
					$end_date = strtotime($site['site_expire_date']);
					$diff = $end_date - $now_date;
					if($diff < 0 )
					{
						$this->db->where("site_id",$site['site_id']);
						$data = array("expire_status" => 1);
						$this->db->update("sites",$data);
					}
				}
			}
		}
	}
	
	function check_site_date_end($site_id)
	{
		$qry = "SELECT site_expire_date FROM sites WHERE site_id = '".$site_id."' ";
		$r = $this->db->query($qry);
		$row = $r->row_array(); 
		$exp_date = $row["site_expire_date"];
		if($exp_date != "0000-00-00 00:00:00")
		{
			$this->load->helper("date_helper");
			$expire = is_date_expired($exp_date);
			if($expire)
			{
				return true;
			}
		}
		return false;
	}
	
	// method to check domain name already exist
	  function  domain_exists ($domain)
	{
	   $query_string = "SELECT site_url FROM sites where site_url = ?"; 
	   $result = $this->db->query($query_string,$domain);
	   if ($result->num_rows() > 0){
		   // true
		   return true;
	   }else{
		   // false
		   return false;
	   }
		
	}
   // This function is used to delete the site from listing only      
	function do_soft_delete($site_id)
	{
		$qry = "UPDATE sites SET site_status = 'Deleted' WHERE site_id = '".$site_id."'";
		$this->db->query($qry);
		return true;
				
	}
    
    function get_sites_spec($user_id,$site_id)
    {
        $qry = "SELECT * FROM sites WHERE user_id = $user_id AND  site_id=$site_id ";
        $query = $this->db->query($qry);    
       // $sitesArray = $query->result_array();
        if($query->num_rows == 1)
        {
            $Data = $query->result();
            $current_site_info = array ();
            
            foreach($Data[0] as $key => $val)
            {
                $current_site_info[$key] = $val; 
            }
            
            $_SESSION["current_site_info"] = $current_site_info;
            
           // print_r($_SESSION["site_info"]);exit;
            
            return true; 
        
        }
        
        
        
        
        
        
        
        
        
        
        return $sitesArray; 
    }
	
	function expire_users_site($user_id,$site_id = 0)
	{
		
		$data = array(
               'expire_status' => 1
            );
			
		if($site_id == 0)
		{
			$this->db->where('user_id', $user_id);
		}
		else
		{
			$this->db->where('user_id', $user_id);
			$this->db->where('site_id', $site_id);
		}

		
		$this->db->update('sites', $data); 
	}
	
	function save_payment($site_id)
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
		$member_id = $_REQUEST['custom'];
		
		$data = array(
		   'site_id' =>  $site_id,
		   'user_id' =>  $member_id,
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
		
		$r = $this->db->insert('site_payments', $data); 
		
		if ($r)
		{
			return true;
		}
		else
		{
			return false;
		}
		//die();
	}
	
	function update_site_after_payment($site_id)
	{
		$query = "SELECT site_expire_date FROM sites WHERE site_id = '$site_id' "; 
		$r = $this->db->query($query);
		$row = $r->row_array();
		$exp_date = $row['site_expire_date'];
		$this->load->helper("date_helper");
		$new_exp_date = add_month_to_date($exp_date);
		
		
		$this->db->where("site_id",$site_id);
		$data = array(
			"expire_status" => 0,
			"site_expire_date" => $new_exp_date
		);
		
		$r = $this->db->update("sites",$data);
		if($r)
		{
			return true;
		}
		return false;
	}
	
	function get_sites_all_conferences()
	{
	
	 
	 if(isset($_SESSION['site_id']) && $_SESSION['site_id']!='' && $_SESSION['site_id']!=0)
	 {	
		  $site_id = $_SESSION['site_id'];	
	  if(isset($site_id) && trim($site_id)!='' && $site_id!=0)
		{	
		 
			 
			 $now_date = date("m/d/Y");
			 $query = "SELECT * 
					   FROM  `room` 
					   WHERE  `site_id` =".$site_id."
					   AND  `reg_date_start` >= '".$now_date."'";
					   
			 $r = $this->db->query($query);
			 $row = $r->row_array();				   
			 return $r->num_rows;
		}
		return;
	 }
	 
	 else
	 {
	   return;	 
	 }
			   
	}


}
?>