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
        
       $this->db->insert('invoice', $inovice_date);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
        
    }
    
    function save_each_invoice_product_info($invoice_id, $product_id, $description, $unit_cost, $quantity, $discount, $taxone, $taxtwo, $price)
    {
        $qry_invoice = "INSERT INTO invoice_products(invoice_id, product_id, description, unit_cost, quantity, discount, taxone, taxtwo, price) 
        VALUES(".$this->db->escape($invoice_id).", ".$this->db->escape($product_id).", ".$this->db->escape($description).", ".$this->db->escape($unit_cost).", ".$this->db->escape($quantity).", ".$this->db->escape($discount).", ".$this->db->escape($taxone).", ".$this->db->escape($taxtwo).", ".$this->db->escape($price).")"; 
       
        $qry_invoice_res = $this->db->query($qry_invoice);
        return true;      
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
		$qry = "SELECT zone_code, zone_name FROM zones";
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
		$this->db->insert('ec_customers',$customer_data);
		return  $this->db->insert_id();
	}
	
	function address_book_data($data)
	{
		  $this->db->insert('ec_address_book',$data);		  
	}
	
	function get_invoice($invoice_id)
	{
		//$qry = "SELECT * FROM invoice WHERE invoice_id = ".$invoice_id;
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
		//echo "<pre>";
		//print_r($product_data);
		$qry = "SELECT * FROM invoice_products WHERE product_id = ".$product_data['product_id']." AND invoice_id = ".$product_data['invoice_id'];
		$rslt = $this->db->query($qry);        		
		if($rslt->num_rows() > 0)
		{
			$this->db->set($product_data);
			$this->db->where('product_id',$product_data['product_id']);
			$this->db->where('invoice_id',$product_data['invoice_id']);
			$this->db->update('invoice_products');	
		}
		else
		{
			$this->db->insert('invoice_products',$product_data);
		}		
	}
}
?>
