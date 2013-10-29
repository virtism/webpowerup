<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



 class shop_model extends CI_Model{

 

    function __construct()

    {

       // Call the Model constructor  

        parent::__construct();

		

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


 

     function on_store($id){

          if($this->site_store_exists($id)){

                $require = "'Yes'"; 

                $this->db->where('site_id',intval($id));

                $this->db->set('required', $require, FALSE);

                $this->db->update('site_store_xref');

          }

          else {

                $data = array(

                'required' =>  'Yes',

                'site_id' => intval($id)

                 );

 

                $this->db->insert('site_store_xref', $data);

           }

           return true;

     }

 

      function off_store($id){

          

          if($this->site_store_exists($id)){

                $require = "'No'";

                $this->db->where('site_id',intval($id));

                $this->db->set('required', $require, FALSE);

                $this->db->update('site_store_xref');

          }

          else {

                $data = array(

                'required' =>  'No',

                'site_id' => intval($id)

                 );

 

                $this->db->insert('site_store_xref', $data);

           }

           return true;

     }

     

     

     

 

     function site_store_exists($id=0)

     {

            $this->db->select('site_id');

            $this->db->where('site_id',intval($id));

            $Q = $this->db->get('site_store_settings');

            if ($Q->num_rows() > 0){

                return TRUE;

                

            }else{

                return FALSE;

            }

            $Q->free_result(); 

         

         

     }

     

     

     //** 3-19-2012 adding paypal id

    function set_store($id=0, $data)
	{
   		$store_exist =  $this->site_store_exists($id);
		if(!isset($store_exist) || $store_exist=='')
		{
			$this->put_store_settings($id);
		}
			$this->db->where('site_id', intval($id));  
			$this->db->update('site_store_settings', $data);
		
		return true;  
    }

	 

     function put_store_settings($id=0)

     {

        $data = array(

                'required' =>  'No',

                'site_id' => intval($id)

                 );

 

                $this->db->insert('site_store_settings', $data);

                return true;  

         

         

         

     }

   

     function get_store_settings($id=0)

     {

          

            $rows = array();

            $query = $this->db->get_where('site_store_settings', array('site_id' => intval($id)));  

            $rows = $query->result_array();

           // $package_id = $rows[0]; 

         //  print_r($rows[0]); exit();

          //  echo  $package_id.'>>>>>>>>>>';  exit();

          if(array_key_exists(0,$rows)){

           return  $rows[0]; 

          }else

          

           return  $rows;

     }

 

 

     function deleteOrderItem($id){

            $this->db->where('order_item_id', intval($id));

            $this->db->delete('ec_order_item');

     }

 

     function deleteOrder($id){

            $this->db->where('order_id', intval($id));

            $this->db->delete('ec_order');

     }

 

     function checkOrphans($id){

            $data = array();

            $this->db->select('order_item_id,name');

            $this->db->where('order_id',intval($id));

            $Q = $this->db->get('ec_order_item');

            if ($Q->num_rows() > 0){

                return TRUE;

            }else{

                return FALSE;

            }

            $Q->free_result();

     }

 

     function findParent($order_item_id){

          $this->db->where('order_item_id', $order_item_id);

          $data= array (); 

          $Q = $this->db->get('ec_order_item');

                if ($Q->num_rows() > 0){

                    foreach ($Q->result_array() as $row){

                        $data[] = $row;

                    }

                }

           $Q->free_result();

           return $data;

     }

 

     function findsiblings($order_id){

          $this->db->where('order_id', $order_id);

          $data= array (); 

          $Q = $this->db->get('ec_order_item');

                if ($Q->num_rows() > 0){

                    foreach ($Q->result_array() as $row){

                        $data[] = $row;

                    }

                }

           $Q->free_result();

           return $data;

     }

	 

	function save_order_record($order_array)

	 {

	 	

		

		 if(!empty($order_array))

		 {

			 $this->db->insert('ec_order', $order_array);

			 return true;  			

		}

	 

	 } 

	 

	 

	 function get_paypal_id_of_store_of_site($site_id)

	 {

		 

		 $this->db->where("site_id",$site_id);

		 $r = $this->db->get('site_store_settings',1);

		 

		 if ($r->num_rows() == 1){

			 

			 $row = $r->result_array();

			 $paypal_id = $row[0]['paypal_id'];

			 return $paypal_id;

			 

		 }

		 return "";



	 }
	function updateUserInfo($user_id)
	 {
		$user_fname = 	$this->input->post('fname');
		$user_lname = 	$this->input->post('lname');
		$company 	=	$this->input->post('company');
		$pnumber 	= 	$this->input->post('pnumber');
		$saddress 	= 	$this->input->post('saddress');
		$country 	= 	$this->input->post('country');
		$state 		= 	$this->input->post('state');
		$city 		= 	$this->input->post('city');
		$zcode 		= 	$this->input->post('zcode');
		
		
		//$qryUpdateUserInfo = "UPDATE users SET user_fname=".$this->db->escape($user_fname).", user_lname=".$this->db->escape($user_lname)." WHERE user_id=".$this->db->escape($user_id);
		
		$data = array(

                'user_fname' =>  $user_fname,

                'user_lname' =>  $user_lname,

                'company' =>  $company,

                'pnumber' =>  $pnumber,

	 			'street_address' => $saddress,
				
				'country' =>  $country,
				
				'state' =>    $state,
				
				'city' =>  	  $city,
				
				'zcode' =>    $zcode
				  
                 );
		
		//print_r($data);
		$this->db->where('user_id', intval($user_id));  
		$this->db->update('users', $data);
		
		return;
		
	}
 

}// 

 

?>