<?php
class Invoice_Model extends CI_Model
{
    function Invoice_Model()
    {
        parent::__construct();
    }
    
    function save_invoice_info($inovice_date)
    {
       
        /*$username, $inovice_date, $payment_ters, $due_date, $fname, $lname, $email, $pnumber, $saddress, $country, $state, $city, $customer_type, $customers*/
       if($inovice_date['customer_id'])
	   {
		   $this->db->insert('invoice', $inovice_date);
			$insert_id = $this->db->insert_id();
			return $insert_id;
	   }
	   return false;
    }
    
    function save_each_invoice_product_info($invoice_id, $product_id, $description, $unit_cost, $quantity, $discount, $taxone, $taxtwo, $price, $product_type)
    {
       if($product_id)
	   {
	    $qry_invoice = "INSERT INTO invoice_products(invoice_id, product_id, description, unit_cost, quantity, discount, taxone, taxtwo, price, product_type) 
        VALUES(".$this->db->escape($invoice_id).", ".$this->db->escape($product_id).", ".$this->db->escape($description).", ".$this->db->escape($unit_cost).", ".$this->db->escape($quantity).", ".$this->db->escape($discount).", ".$this->db->escape($taxone).", ".$this->db->escape($taxtwo).", ".$this->db->escape($price).", ".$this->db->escape($product_type).")"; 
		
      
        $qry_invoice_res = $this->db->query($qry_invoice);
			return true;      
		}
        return false;
    }
	
    function get_country()
	{
		$qry = "SELECT countries_id,countries_name FROM countries";
		$rslt = $this->db->query($qry);        
		$array = $rslt->result_array();        
		return $array;
	}
	
	function get_states()
	{
		$qry = "SELECT zone_code, zone_name FROM zones WHERE zone_country_id = 38";
		$rslt = $this->db->query($qry);        
		$array = $rslt->result_array();        
		return $array;
	}
	
	function delete_invoice($invoice_id)
	{
		$this->db->query("DELETE FROM invoice WHERE invoice_id =".$invoice_id);        
	}
		
    function get_all_invoices_by_site($site_id)
	{
		$qry = "SELECT i.*, c.customer_name, c.customer_fname, c.customer_lname, c.customer_email  FROM invoice i, ec_customers c WHERE i.customer_id = c.customer_id	AND  i.site_id =".$site_id." order by invoice_id desc";
		
	/*	join query with invoice and customers*/
	
	//SELECT * FROM invoice, ec_customers WHERE invoice.customer_id = ec_customers.customer_id	
	
	
		$rslt = $this->db->query($qry);        
		$array = $rslt->result_array();        
		return $array;
	}
	
	function getstates_by_country_id($country_id)
	{
		$qry = "SELECT zone_code, zone_name FROM zones WHERE zone_country_id = ".$country_id;
		$rslt = $this->db->query($qry);        
		$array = $rslt->result_array();        
		return $array;
	}
	
	
    function save_slideshow_roles_info($slide_id, $role_id)
    {
        $qry = "INSERT INTO slides_roles_xref(slide_id, role_id)
        VALUES(".$this->db->escape($slide_id).", ".$this->db->escape($role_id).")";   
        
        $rslt = $this->db->query($qry);
        
        return true;
    }
    
    function addCustomer($customer_data)
	{
		
		
		$checkcustomer = $this->checkCustomerByEmailId($customer_data['site_id'], $this->input->post('email'));
		if(count($checkcustomer)>0)
		{
			return  $checkcustomer[0]['customer_id'];
		}
		else
		{
			
			$customer_pass = mt_rand(10000000, 99999999);
			$customer_data['customer_password'] = md5($customer_pass);
			$this->db->insert('ec_customers',$customer_data);
			
			
			  $customer_id = $this->db->insert_id();
			//Send mail after adding new Customer
			if($customer_id)
			{
				$message = '';
				$message .=  "Congratulation !  \n\n Your signup process complete \n ";
				$message .=  " \n
							  
								# ------------------------ 
								# Login Mail: ".$customer_data['customer_email']." 
								# Password: ".$customer_pass."
								# ------------------------ 
							  \n
							  ";
				$message .= "Thanks for using Our Services 
							\n ";
				 $message .= 'http://www.webpowerup.com';
				
				$this->load->library('email');
				
				$this->email->from('web@webpowerup.net', 'WebpowerUp');
				$this->email->to($customer_data['customer_email']);
				$this->email->subject('Signup | System Confirmation Mail');
				$this->email->message($message);
				$this->email->send();
				
			}
			
			
			
			return  $customer_id;
		}
		
	}
	
	
	function checkCustomerByEmailId($site_id, $e)
	 {
		//echo $site_id."--".$e;
		$numrow = 0;
		
		//echo "select * from ec_customers where customer_login = '".$e."' AND site_id =".$site_id;
		$Q = $this->db->query("select * from ec_customers where customer_login = '".$e."' AND site_id =".$site_id);
		if ($Q->num_rows() > 0){
			
			$array = $Q->result_array();		
			return $array;
		}else{
			$numrow =array();
			return $numrow;
		}
	 } 
	
	
	function address_book_data($data)
	{
		  /*echo "<pre>";
		  print_r($data);
		  exit;*/
		  
		  $this->db->insert('ec_address_book',$data);		  
	}
	
	function get_invoice($invoice_id)
	{
		//$qry = "SELECT * FROM invoice WHERE invoice_id = ".$invoice_id."";
		$qry = "SELECT * FROM invoice, invoice_products WHERE invoice.invoice_id = invoice_products.invoice_id AND invoice.invoice_id = ".$invoice_id;
		$rslt = $this->db->query($qry);
		$array = $rslt->result_array();		
		return $array;
	}
	
	// EDIT SECTION
	
	function aditCustomer($customer_data)
	{
		$this->db->set($customer_data);
		$this->db->where('customer_id',$customer_data['customer_id']);
		$this->db->update('ec_customers');	
		
	}
	
	function update_invoice_status($invoice_id, $payment_status)
	{
		if($payment_status=='Pending')
		{
			$payment_status = 'Paid';
		}
		else if($payment_status=='Completed')
		{
			$payment_status = 'Paid';
		}
		//echo "UPDATE invoice SET status = $payment_status WHERE invoice_id = $invoice_id";exit;
		$this->db->query("UPDATE invoice SET status = '".$payment_status."' WHERE invoice_id = $invoice_id");
		
	}
	
	function adit_book_data($customer_book_data)
	{
		$qry = "SELECT * FROM ec_address_book WHERE customer_id = ".$customer_book_data['customer_id'];
		$rslt = $this->db->query($qry);        
		
		if($rslt->num_rows() > 0)
		{
			$this->db->set($customer_book_data);
			$this->db->where('customer_id',$customer_book_data['customer_id']);
			$this->db->update('ec_address_book');		
		}
		else
		{
			$this->db->insert('ec_address_book',$customer_book_data);
		}	
		
	}
	
	function edit_invoice_info($inovice_data)
	{
		$this->db->set($inovice_data);
		$this->db->where('invoice_id',$inovice_data['invoice_id']);
		$this->db->update('invoice');		
	}
	
	function edit_each_invoice_product_info($product_data)
	{
		/*echo "<pre>";
		print_r($product_data);exit;*/
		/*$qry = "SELECT * FROM invoice_products WHERE product_id = ".$product_data['product_id']." AND invoice_id = ".$product_data['invoice_id'];
		$rslt = $this->db->query($qry);        		
		if($rslt->num_rows() > 0)
		{
			$this->db->set($product_data);
			$this->db->where('product_id',$product_data['product_id']);
			$this->db->where('invoice_id',$product_data['invoice_id']);
			$this->db->update('invoice_products');	
		}
		else
		{*/
		
			//$this->db->query("DELETE FROM invoice WHERE invoice_id =".$invoice_id);    
			$this->db->query("DELETE FROM invoice_products WHERE  product_id =".$product_data['product_id']." AND invoice_id = ".$product_data['invoice_id']);   
			$this->db->insert('invoice_products',$product_data);
		//}		
	}

	function get_user_invoices($site_id, $cid)
	{
		$q = "SELECT * FROM invoice WHERE customer_id = '".$_SESSION['login_info']['customer_id']."' "; 
		$r = mysql_query($q);
		if(mysql_num_rows($r) > 0)
		{
			return 1;
		}
		else
		{
			return 0;
		}		
	}
	
	function get_site_gropus_customer_by_site_id($site_id, $type=0,$webinar_call = 0)
	{
			$group_data = array();
			$data = '';
			$data = "<select name='customer' id='customer'  size='1'  style='width: 250px;'> ><option value=''>Select</option>";			
			
			$qry = "SELECT gp.* FROM groups gp,groups_sites_xref gpref WHERE gp.id = gpref.group_id AND gpref.site_id = '".$site_id."' AND gp.is_disabled = 'No' AND gp.is_deleted = 'No' ";
			 $Q = $this->db->query($qry);
			 
			 $all_customers = $this->db->query("SELECT customer_id, customer_login, customer_name, customer_email FROM  `ec_customers` WHERE   site_id= ".$site_id);
			 $all_site_customers = $all_customers->result_array();
			 /*echo "<pre>";
			 print_r($all_site_customers);
			  print_r($Q->result_array());
			 exit;*/
			if ($Q->num_rows() > 0){
				 
			   foreach ($Q->result_array() as $row)
			   {
					//echo "<pre>";	print_r($row);	echo "</pre>";die();
					
					
					//$data .= "<optgroup id=\" ".$row['id']."\" label=\"".$row['group_name']."\">";
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
					WHERE cgx.group_id = ".$row['id']);
					//fetching customer for Group
					 $int_count = $c->result_array();
					 if ($c->num_rows() > 0)
					 {
						foreach($int_count as $record)
						{
							//customers registered to this group
							$data .= "<option value=".$record['customer_id'].">";					
							$data .= $record['customer_email'];					
							$data .= "</option>";
							
						}	
					 }
					 else
					 {
						 //no customers registered to this group
						$data .= "<option value='0'>";					
						$data .= "No Customer Found";					
						$data .= "</option>";							
					 }
					//$data .= "</optgroup>";
			   }
			  
			}
			if($all_customers->num_rows()>0)
			{
				//$data .= "<optgroup id='1' label='Registered' >";
				foreach($all_site_customers as $customer)
				{
					//customers registered to this group
					$data .= "<option value=".$customer['customer_id'].">";					
					$data .= $customer['customer_email'];					
					$data .= "</option>";
				}
				//$data .= "</optgroup>";
			}
			else if($all_customers->num_rows() == 0 && $Q->num_rows() == 0) 
			{
						//No Data Grops Created yet
						$data .= "<option value=''>Select</option>";					
						//$data .= "<optgroup label='No Customer Exists' ></optgroup>";	
			}
			$data .= "</select>";
			return $data;	
	}
	
	function getAllCustomers($site_id=NULL,$search_param=NULL){
	// echo '<pre>'print_r($_SESSION);exit;
	
	 if(empty($this->site_id)){
	 
	 	$this->site_id = $site_id; 
	 } 
	 if(!empty($search_param) && $search_param != NULL)
	 {
		 //echo print_r($search_param);exit;
		//$this->db->where($search_param['search_by'], $search_param['search_value']);
		$this->db->like($search_param['search_by'], $search_param['search_value']);
		$this->db->where('invoice.site_id', $this->site_id);
		$this->db->join('invoice', 'ec_customers.customer_id = invoice.customer_id','left');
		$re = $this->db->get('ec_customers');
		//echo "---------<pre>";print_r($re->result_array());exit;
		if ($re->num_rows() > 0)
		{
	   		return $re->result_array();
	 	}
			
	 }
		return false;		
	}
	
	
	function getWebinarsDropdown_invoice($site_id)
	{
		$data = array();
		$qry = "SELECT id, title FROM webinar WHERE site_id = '".$site_id."' AND is_deleted = '0'";
		$result = $this->db->query($qry);
		if ($result->num_rows() > 0){
			foreach ($result->result_array() as $row){
				$data[$row['id']] = $row['title'];
			}
		}
		
		return $data; 
	}
	
	
	function getMeetingsDropdown_invoice($site_id)
    {
		 $data = array();
		 $query = "SELECT id, name FROM room WHERE site_id =".$site_id;
		 $r = $this->db->query($query);
		 
		 if( $r->num_rows() > 0)
		 {
			 foreach ($r->result_array() as $row){
				$data[$row['id']] = $row['name'];
			}
		 		 
		 }
		 return $data;
		 
	}
	
	
	
}
?>