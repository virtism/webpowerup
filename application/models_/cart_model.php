<?php 
class Cart_model extends CI_Model{
 
    function __construct()
    {
       // Call the Model constructor  
        parent::__construct();
        $this->load->library('cart');
    }

	// Function to retrieve an array with all product information
	function retrieve_products(){
		$query = $this->db->get('ec_products');
		return $query->result_array();
	}
	
	function get_rates_by_country_id($country_id,$state_id,$total_weight)
	{
		//echo "SELECT  shipping_rates.rate FROM shipping_rates INNER JOIN country_states ON country_states.state = shipping_rates.state WHERE country_states.country = ".$country_id." AND country_states.state = '".$state_id."' AND shipping_rates.site_id =".$this->site_id." AND ".$total_weight." >= shipping_rates.min_range AND ".$total_weight."<= shipping_rates.max_range LIMIT 1";
		/*echo "SELECT  shipping_rates.rate FROM shipping_rates INNER JOIN country_states ON country_states.shipping_state_id = shipping_rates.shipping_state_id WHERE  shipping_rates.site_id =".$this->site_id."  AND country_states.state = '".$state_id."'  AND ".$total_weight." >= shipping_rates.min_range AND ".$total_weight."<= shipping_rates.max_range LIMIT 1";*/

		$rate = $this->db->query("SELECT  shipping_rates.rate FROM shipping_rates INNER JOIN country_states ON country_states.shipping_state_id = shipping_rates.shipping_state_id WHERE   shipping_rates.site_id =".$this->site_id."  AND country_states.state = '".$state_id."' AND ".$total_weight." >= shipping_rates.min_range AND ".$total_weight."<= shipping_rates.max_range LIMIT 1");
		$rate = $rate->result_array();
		return $rate;
		
	}
	
	function get_attribute_price($option_id)
	{
	  	$price = $this->db->query("SELECT *
								   FROM `ec_products_attributes_options`
								   WHERE option_id =".$option_id."");
		$price = $price->result_array();
		return $price;
	}
	// Updated the shopping cart
	function validate_update_cart(){
		
			
		
		// Get the total number of items in cart
		$total = $this->cart->total_items();
		
		// Retrieve the posted information
		$item = $this->input->post('rowid');
	    $qty = $this->input->post('qty');

		// Cycle true all items and update them
		for($i=0;$i < $total;$i++)
		{
			// Create an array with the products rowid's and quantities. 
			$data = array(
               'rowid' => $item[$i],
               'qty'   => $qty[$i],
            );
            
            // Update the cart with the new information
			$this->cart->update($data);
		}

	}
	
	// Add an item to the cart
	function validate_add_cart_item(){
	
	
		$id = $this->input->post('product_id'); // Assign posted product_id to $id
		$cty = $this->input->post('quantity'); // Assign posted quantity to $cty
		$price = $this->input->post('total_price');
	
		
		$this->db->where('product_id', $id); // Select where id matches the posted id
		$query = $this->db->get('ec_products', 1); // Select the products where a match is found and limit the query by 1
		
		$this->db->where('site_id',$this->site_id);
		$query2 = $this->db->get('shipping_rates'); 
		$qry = $query2->result_array();
		
		$shipping_rates = array();
		 if($query2->num_rows > 0)
		 {
	
		// foreach ($qry as $row2)
		for($i = 0; $i <= ($query2->num_rows)-1; $i++)
			 {
			  $shipping_rates[$i] = array(
			    'shipping_id'        => $qry[$i]['shipping_id'],
				'site_id'            => $qry[$i]['site_id'],
				'shipping_rate_name' =>$qry[$i]['shipping_rate_name'],
				'min_range' => $qry[$i]['min_range'],
				'max_range' => $qry[$i]['max_range'],
				'rate' =>$qry[$i]['rate']
			   );
			   
			   	 			
			 }
		
		 }

		if($query->num_rows > 0)
		{
			if(isset($_POST['update']))
			{
		    foreach ($query->result() as $row)
			 {
			
		
			    $data = array(
               		'id'      => $id,
               		'qty'     => $cty,
               		'price'   => $price,
               		'name'    => $row->product,
					'weight'  => $row->weight,
					'is_free' => $row->free_shipping,
					'shipping_rates' =>$shipping_rates
            	);
			 
				$this->cart->insert($row); 

				return TRUE;
			  } 
			}
			if(isset($_POST['add']))
			{
		    foreach ($query->result() as $row)
			 {
			
				/*if(isset($row->free_tax) && $row->free_tax=='Yes')
				{
					echo $product_price = $row->list_price-(($row->tax/100)*$row->list_price);exit;
				}
				else
				{
					$product_price = $row->list_price;
				}*/
			    $data = array(
               		'id'      => $id,
               		'qty'     => $cty,
               		'price'   => $row->list_price,
               		'name'    => $row->product,
					'weight'  => $row->weight,
					'is_free' => $row->free_shipping,
					'shipping_rates' =>$shipping_rates,
					'tax' => $row->tax,
					'is_taxable' => $row->free_tax
					
            	);
				//echo "<pre>";print_r($query->result());exit;
				$this->cart->insert($data); 

				return TRUE;
			  } 
			}
		// Nothing found! Return FALSE!	
		}else{
			return FALSE;
		}
	}
	
	
	
	// Needed?
	//function cart_content(){
	//	return $this->cart->total();
	//}

}


/* End of file cart_model.php */
/* Location: ./application/models/cart_model.php */