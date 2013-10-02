<?php
class User_payment_model extends CI_Model{
	//Constructor for this model
	function __construct(){
		parent::__construct(); 
		
	}
	
	function save_payment()
	{
		
		// echo "<pre>";	print_r($_REQUEST); 	die();
		
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
		
		$r = $this->db->insert('user_package_payments', $data); 
		
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
	
	
}
?>