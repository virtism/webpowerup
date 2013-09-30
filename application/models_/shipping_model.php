<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start(); 
 class Shipping_model extends CI_Model{
	//  var $shipping_id;
	  var $site_id;
	  var $shipping_id;
	  var $weight;
	  var $freight;
	  var $price_per_kg;
	function __construct()
	{
	   // Call the Model constructor  
		parent::__construct();
		$this->shipping_id = '';
		$this->site_id = '';
	}

	function do_shipping($site_id='')
	{
	/*	echo '<pre>';
	print_r($_POST);
	exit;*/
		$price_per_kg =0;
		$weight=$this->input->post('weight');
		$freight=$this->input->post('shipping_freight');
		$id = $this->input->post('product_id');
		if($weight!=0)
		{	
		   $price_per_kg = $freight/$weight;	
		}
		$weight_type = $this->input->post('weight_type');
		$is_free = $this->input->post('free_shipping');
	
		 $data = array(
						'site_id' 			 => trim($site_id),
						'weight'			 => trim($weight),
						'weight_type' 		 => trim($this->input->post('weight_type')),
						'is_free'			 => $this->input->post('free_shipping'),
						'shipping_freight'	 => trim($freight),
						'cost_calc_check' 	 => $this->input->post('use_weight_for_shipping'),
						'price_per_kg' 		 => trim($price_per_kg)
						);
		
		$q = $this->db->insert('shiping',$data);
		
	}
	
	function save_shiping($site_id)
	{
	
		$qry = "SELECT * FROM tbl_shipping WHERE site_id = ".$site_id."";
		$result = $this->db->query($qry);
		if($result->num_rows() > 0)
		{
		  return;
		}
		else
		{
			 $i = 1;
			 
			 $data = array(
							'site_id'    =>  trim($site_id),
							'ship_id'    =>  $i
						   );
						   $i++;
			 $q = $this->db->insert('tbl_shipping',$data);
		 }			   
	}
	
	/*function save_shipping_rate($site_id='')
	{
	
		$shipping_rate_name = $_POST['shipping_rate_name'];
		$min_range          = $_POST['min_range'];
		$max_range          = $_POST['max_range'];
		$rate               = $_POST['rate'];

		 $data = array(
						'site_id' 			 => trim($site_id),
						'shipping_rate_name' => trim($shipping_rate_name),
						'min_range' 		 => trim($min_range),
						'max_range'			 => trim($max_range),
						'rate'	 => trim($rate)
						);
		
		$q = $this->db->insert('shipping_rates',$data);	
	}*/
	
	function save_shipping_rate($site_id='')
	{
	  /*echo "<pre>";
	  print_r($_POST);	 
	  exit();*/
	  //$rel_id;
	  /*$qry = "SELECT * FROM tbl_shipping WHERE site_id = ".$site_id."";
	  $result = $this->db->query($qry);
	  $result = $result->result_array();*/
	  $data = array( 'site_id' => $site_id, 'country_id' => $_POST['country_shipping']);
	  $shipping_rates = $this->db->insert('tbl_shipping',$data);	
	  $ship_id = $this->db->insert_id();
	  $data = array(
	                  'site_id' => $site_id,
					  'ship_id' => $ship_id,
	                  'country' => $_POST['country_shipping'],
	                  'state'   => $_POST['state']
					  );
	  $shipping_location = $this->db->insert('country_states',$data);	
	  $shipping_location_id = $this->db->insert_id();
	  /*$qry = "SELECT * FROM country_states WHERE country = '".$_POST['country']."' AND state = '".$_POST['state']."'";
	  $result = $this->db->query($qry);*/
	  
	  /*if($result->num_rows() > 0)
	  {
	    $result = $result->result_array();
	    $shipping_state_id = $result[0]['shipping_state_id'];
	  }*/
	  
	  /*$qry = "SELECT * FROM country_states WHERE country = '".$_POST['country']."' AND state = '".$_POST['state']."'";
	  $result = $this->db->query($qry);
	  if($result->num_rows() < 1)
	  {
		   $country_states = $this->db->insert('country_states',$data);
		   $shipping_state_id = $this->db->insert_id();
	  }*/
		$shipping_rate_name = $_POST['shipping_rate_name'];
		$min_range          = $_POST['min_range'];
		$max_range          = $_POST['max_range'];
		$rate               = $_POST['rate'];

		 $data = array(
						'site_id' 			 => trim($site_id),
						'shipping_state_id'	 => trim($shipping_location_id),
						'shipping_rate_name' => trim($shipping_rate_name),
						'min_range' 		 => trim($min_range),
						'max_range'			 => trim($max_range),
						'rate'				 => trim($rate),
						'state'				 => $_POST['state']
						);
		
		$shipping_rates = $this->db->insert('shipping_rates',$data);
		return true;
	}
	function show_shipping($from, $intPageLimit, $site_id)
	{                
		return $this->db->query("SELECT * FROM shipping_rates WHERE site_id=".$this->db->escape($site_id)."  ORDER BY range_id ASC LIMIT ".$from.", ".$intPageLimit);
	}
	
	function edit_shipping_rate($site_id,$ship_id)
	{

		if(isset($ship_id))

		 {

		 	$result = "SELECT * FROM shipping_rates WHERE shipping_id = ".$ship_id." AND site_id=".$this->db->escape($site_id)."";

			$result = $this->db->query($result);

			$result = $result->result_array(); 		

			return $result;

		 }	

	}
	
	function update_shipping_rate($site_id,$ship_id)
	{
	
		$shipping_rate_name = $_POST['shipping_rate_name'];
		$min_range          = $_POST['min_range'];
		$max_range          = $_POST['max_range'];
		$rate               = $_POST['rate'];

		 $data = array(
						'site_id' 			 => trim($site_id),
						'shipping_rate_name' => trim($shipping_rate_name),
						'min_range' 		 => trim($min_range),
						'max_range'			 => trim($max_range),
						'rate'	 => trim($rate)
						);
		$this->db->where('site_id', $site_id);
		$this->db->where('shipping_id', $ship_id);
		$q = $this->db->update('shipping_rates',$data);	
	}
	
	function delete_shipping_range($range_id)
	{
		$qry_del_ship = "DELETE FROM shipping_rates WHERE range_id=".$this->db->escape($range_id);
		$rslt_del_ship = $this->db->query($qry_del_ship);
		return true;
	}
	
	function delete_shipping($arrShipId)
	{
		for( $i=0; $i<sizeof($arrShipId); $i++)
		{
			$Ship_id = $arrShipId[$i];

			$qry_del_ship = "DELETE FROM shipping_rates WHERE shipping_id=".$this->db->escape($Ship_id)."";
			
			$rslt_del_ship = $this->db->query($qry_del_ship);
		}
		return true;
	
  }
  
  function get_countries()
  {
    $qry = "SELECT * FROM countries ORDER BY  `countries_id` ASC "; 
	$result = $this->db->query($qry);
	
    $result = $result->result_array(); 	
	
	return $result;
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
	
	function getstates_by_country_id($country_id)
	{
		
		$qry = "SELECT zone_code, zone_name
                FROM zones, countries
                WHERE countries.countries_id = zones.zone_country_id
                 AND countries.countries_id = '".$country_id."'";
		
		$rslt = $this->db->query($qry);        
		$array = $rslt->result_array();   
		 
		return $array;
	}
	
	function get_all_country_states($site_id)
	{
	 
		$country_states = array();
		$query_country = $this->db->query("SELECT * FROM  tbl_shipping, countries WHERE tbl_shipping.country_id = countries.countries_id AND tbl_shipping.site_id = ".$site_id." GROUP BY country_id");
		$country_result = $query_country->result_array();
		//echo "<pre>";print_r($country_result);
		for($i = 0; $i< count($country_result); $i++)
		{
		
			
			$query_states = $this->db->query("SELECT * FROM  country_states WHERE country =".$country_result[$i]['country_id']."  AND site_id = ".$country_result[$i]['site_id']." GROUP BY state");
			$country_states[$country_result[$i]['countries_name']] = $query_states->result_array();		
			
		}
		
		//echo "<pre>";print_r($country_states);	
		$counter = 0;
		foreach($country_states as $key => $value)
		{
			//echo "<pre>";print_r($value);
			for($i = 0; $i< count($value); $i++)
			{
				
				$query_ranges = $this->db->query("SELECT * FROM  shipping_rates WHERE state ='".$value[$i]['state']."'  AND site_id = ".$site_id);
				//echo "SELECT * FROM  shipping_rates WHERE state ='".$value[$i]['state']."'  AND site_id = ".$site_id;
				$country_states[$key][$i]['state_ranges'] = $query_ranges->result_array();
				
			}
			//echo "<pre>";print_r($country_states);exit;
			
		}
				//echo "<pre>";print_r($country_states);exit;
		
		
		return $country_states;
			//echo "<pre>";print_r($country_states);exit;
		
		//return $country_states_ship;
		//echo "<pre>";print_r($qry);exit;
		//$data = array();
		/*
		for($i = 0; $i< count($qry); $i++)
		{
			
			$query2 = $this->db->query("SELECT * FROM  shipping_states, countries WHERE shipping_states.shipping_state_id = ".$qry[$i]['shipping_state_id']);
			
			$qry2 = $query2->result_array();
			//print_r($qry2);
			//echo "<pre>";print_r($qry2[0]['countries_name']);
			//echo "<pre>";print_r($qry[$i]['state'])."<br>";
			$conntry_states[$i] = array(
									'ship_id'    	=> $qry[$i]['ship_id'],
									'range_id'    	=> $qry2[0]['range_id'],
									'name'    		=> $qry2[0]['shipping_rate_name'],
									'min_range'    	=> $qry2[0]['min_range'],
									'max_range'    	=> $qry2[0]['max_range'],
									'rate'    		=> $qry2[0]['rate'],
									'country'    	=> $qry2[0]['countries_name'],
									'state'	     	=> $qry[$i]['state'],
									
									);
		}
		//echo "<pre>";print_r($conntry_states);exit;
		if(isset($conntry_states))
		return $conntry_states;*/
		
		return '';
		
	}
	
	function get_all_country_rates($site_id)
	{
	 
		$this->db->where('site_id',$site_id);
		$query = $this->db->get('tbl_shipping');
		$qry = $query->result_array();
		//echo "<pre>";print_r($qry);exit;
		if(isset($qry[0]['ship_id']) && !empty($qry[0]['ship_id']))
		{
			$ship_id = $qry[0]['ship_id'];
			$this->db->where('ship_id',$ship_id);
			$query1 = $this->db->get('country_states');
			$qry1 = $query1->result_array();
			
			$data = array();
			for($i = 0; $i < $query1->num_rows; $i++)
			{
			 $this->db->where('shipping_state_id',$qry1[$i]['shipping_state_id']);
			 $query2[$i] = $this->db->get('shipping_rates');
			 $qry2[$i] = $query2[$i]->result_array();
				 for($j = 0; $j <= ($query2[$i]->num_rows) - 1; $j++)
				 {
					$data[$i][$j] = array(
								  'range_id'  => $qry2[$i][$j]['range_id'],
								  'rate_name'  => $qry2[$i][$j]['shipping_rate_name'],
								  'min_range'  => $qry2[$i][$j]['min_range'],
								  'max_range'  => $qry2[$i][$j]['max_range'],
								  'rate'       => $qry2[$i][$j]['rate']
								  );		 
					
				 }	 
		
			}
			return $data;	
		}
		//echo "<pre>";print_r($data);exit;
		return '';	
	}
  
  function save_countries($country)
  {
    
	$query_string = "SELECT * FROM shipping_countries WHERE site_id=".$country[1]."";
	$q = $this->db->query($query_string);
	if($q->num_rows() > 0)
	{
	   /*$this->db->where('site_id', $country[2]);
	   $this->db->update('shipping_rates',$country);*/
	  $qry = "UPDATE `shipping_countries` SET  `source` =  '".$country[2]."',
`destination` =  '".$country[3]."' WHERE  site_id=".$country[1]."";
	  $this->db->query($qry);
	}
	else
	{
		$qry="INSERT INTO shipping_countries(site_id,source,destination) values(?,?,?)";
		$q = $this->db->query($qry, $country);
	}
	
  }
}
 
?>