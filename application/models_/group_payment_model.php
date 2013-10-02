<?php
class Group_payment_model extends CI_Model{
	//Constructor for this model
	function Group_payment_model(){
		parent::__construct(); 
		$this->load->library('Paypal_Lib');
	}
	// UNCOMMENT ALL THE BELOW LINES WHEN SSL OPTION IS TURNED ON
	//function save_payment()
//	{
//		if ( $this->paypal_lib->validate_ipn() )
//		{
//			
//		
//		
//		$txn_id = $_POST['txn_id'];
//		$payment_gross = $_POST['payment_gross'];
//		$payment_status = $_POST['payment_status'];
//		$item_id = $_POST['item_number'];
//		$payment_date = $_POST['payment_date'];
//		$payer_email = $_POST['payer_email']; 	//the email used to pay 
//		$payer_id = $_POST['payer_id'];
//		$payer_status = $_POST['payer_status'];
//		$tax = $_POST['tax'];
//		$receiver_email = $_POST['receiver_email'];
//		$receipt_id = $_POST['receiver_id'];
//		$customer_name = $_POST['first_name']." ".$_POST['last_name'];
//		$address_city = $_POST['address_city'];
//		
//		$custom = $_POST['custom'];
//		$customData = explode("-",$custom);
//		
//		$site_id = $customData[1];
//		$member_id = $customData[3];
//		$discount_value = $customData[5];
//		
//		$data = array(
//		   'site_id' =>  $site_id,
//		   'customer_id' =>  $member_id,
//		   'txn_id' => $txn_id,
//		   'payment_gross' => $payment_gross,
//		   'discount' => $discount_value,
//		   'payment_status' => $payment_status,
//		   'item_id' => $item_id,
//		   'payment_date' => $payment_date,
//		   'payer_email' => $payer_email,
//		   'payer_id' => $payer_id,
//		   'payer_status' => $payer_status,
//		   'tax' => $tax,
//		   'receiver_email' => $receiver_email,
//		   'receipt_id' => $receipt_id,
//		   'customer_name' => $customer_name,
//		   'address_city' => $address_city
//		);
//		
//		$r = $this->db->insert('group_customer_payment', $data); 
//		
//		if ($r)
//		{
//			return true;
//		}
//		}
//		else
//		{
//			return false;
//		}
//		//die();
//	}
//	
//	function save_upgradable_group_payment()
//	{
//		
//		if ( $this->paypal_lib->validate_ipn() )
//		{
//		
//			$txn_id = $_POST['txn_id'];
//		$payment_gross = $_POST['payment_gross'];
//		$payment_status = $_POST['payment_status'];
//		$item_id = $_POST['item_number'];
//		$payment_date = $_POST['payment_date'];
//		$payer_email = $_POST['payer_email']; 	//the email used to pay 
//		$payer_id = $_POST['payer_id'];
//		$payer_status = $_POST['payer_status'];
//		$tax = $_POST['tax'];
//		$receiver_email = $_POST['receiver_email'];
//		$receipt_id = $_POST['receiver_id'];
//		$customer_name = $_POST['first_name']." ".$_POST['last_name'];
//		$address_city = $_POST['address_city'];
//		
//		$custom = $_POST['custom'];
//		$customData = explode("-",$custom);
//		
//		$site_id = $customData[1];
//		$member_id = $customData[3];
//		$current_group_id = $customData[5];
//		$discount_value = $customData[7];
//		
//		$data = array(
//		   'site_id' =>  $site_id,
//		   'customer_id' =>  $member_id,
//		   'txn_id' => $txn_id,
//		   'payment_gross' => $payment_gross,
//		   'discount' => $discount_value,
//		   'payment_status' => $payment_status,
//		   'item_id' => $item_id,
//		   'payment_date' => $payment_date,
//		   'payer_email' => $payer_email,
//		   'payer_id' => $payer_id,
//		   'payer_status' => $payer_status,
//		   'tax' => $tax,
//		   'receiver_email' => $receiver_email,
//		   'receipt_id' => $receipt_id,
//		   'customer_name' => $customer_name,
//		   'address_city' => $address_city
//		);
//		
//		$r = $this->db->insert('group_customer_payment', $data); 
//		
//		if ($r)
//		{
//			return $customData;
//		}
//		}
//		else
//		{
//			return false;
//		}
//		//die();
//	}


	
	function save_payment()
	{
		
			
		
		
		$txn_id = $_POST['txn_id'];
		$payment_gross = $_POST['payment_gross'];
		$payment_status = $_POST['payment_status'];
		$item_id = $_POST['item_number'];
		$payment_date = $_POST['payment_date'];
		$payer_email = $_POST['payer_email']; 	//the email used to pay 
		$payer_id = $_POST['payer_id'];
		$payer_status = $_POST['payer_status'];
		$tax = $_POST['tax'];
		$receiver_email = $_POST['receiver_email'];
		$receipt_id = $_POST['receiver_id'];
		$customer_name = $_POST['first_name']." ".$_POST['last_name'];
		$address_city = $_POST['address_city'];
		
		$custom = $_POST['custom'];
		$customData = explode("-",$custom);
		
		$site_id = $customData[1];
		$member_id = $customData[3];
		$discount_value = $customData[5];
		
		$data = array(
		   'site_id' =>  $site_id,
		   'customer_id' =>  $member_id,
		   'txn_id' => $txn_id,
		   'payment_gross' => $payment_gross,
		   'discount' => $discount_value,
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
		
		$r = $this->db->insert('group_customer_payment', $data); 
		
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
	
	function save_upgradable_group_payment()
	{
		
		
			$txn_id = $_POST['txn_id'];
		$payment_gross = $_POST['payment_gross'];
		$payment_status = $_POST['payment_status'];
		$item_id = $_POST['item_number'];
		$payment_date = $_POST['payment_date'];
		$payer_email = $_POST['payer_email']; 	//the email used to pay 
		$payer_id = $_POST['payer_id'];
		$payer_status = $_POST['payer_status'];
		$tax = $_POST['tax'];
		$receiver_email = $_POST['receiver_email'];
		$receipt_id = $_POST['receiver_id'];
		$customer_name = $_POST['first_name']." ".$_POST['last_name'];
		$address_city = $_POST['address_city'];
		
		$custom = $_POST['custom'];
		$customData = explode("-",$custom);
		
		$site_id = $customData[1];
		$member_id = $customData[3];
		$current_group_id = $customData[5];
		$discount_value = $customData[7];
		
		$data = array(
		   'site_id' =>  $site_id,
		   'customer_id' =>  $member_id,
		   'txn_id' => $txn_id,
		   'payment_gross' => $payment_gross,
		   'discount' => $discount_value,
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
		
		$r = $this->db->insert('group_customer_payment', $data); 
		
		if ($r)
		{
			return $customData;
		}
		
		else
		{
			return false;
		}
		//die();
	}
}
?>