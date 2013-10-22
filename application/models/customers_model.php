<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@session_start(); 
 class customers_model extends CI_Model{
	  var $customer_id;
	  var $site_id;
	function __construct()
	{
	   // Call the Model constructor  
		parent::__construct();
		
		$this->customer_id = '';
		
		if(!isset($this->site_id) && empty($this->site_id))
		{
	 		$this->site_id = ''; 
	 	}
	}
	
	function do_login($site_id='')
	{
	 
		//print_r($_POST);
		$email = trim($this->input->post('email'));
		$pwd   = $this->input->post('password');
		$pwd   = md5($pwd);
		
		
		$this->site_id = $site_id;
		$this->db->where('site_id', $this->site_id);
		//$this->db->where('customer_login', trim($this->input->post('email')));
		$this->db->where('customer_email', $email);
		$this->db->where('customer_password', $pwd);
		$query = $this->db->get('ec_customers');
		$s = $query->result();
		//echo "<pre>";print_r($s);
		if($query->num_rows == 1)
		{
			$userDate = $query->result();
			$row = $query->row_array();
			$customer_id = $row['customer_id'];
			$group_id = $this->get_customer_last_group_id($customer_id);
			if($group_id != 0)
			{
				$_SESSION['customer_group_id'] = $group_id;
				
			}
			$logging = array();
			foreach($userDate[0] as $key => $val)
			{
				$logging[$key] = $val;
			}
			
			$_SESSION["login_info"] = $logging ;
			
			return true; 				
		}
		else
		{ 
			return false;
		}
		
	}
	
	function check_group_paid($group_id)
	{
		if(isset($group_id))
		 {
			//$result = "SELECT * FROM `groups` inner join  groups_payments_details on groups.id = groups_payments_details.group_id  where groups.id =".$group_id;
			//$result = "SELECT * FROM `groups` Left outer join  groups_payments_details on groups.id = groups_payments_details.group_id  where groups.id =".$group_id;
            $result = "SELECT * FROM `groups` Left outer join  groups_payments_details on groups.id = groups_payments_details.group_id Left outer join ec_customers_group_xref on groups.id = ec_customers_group_xref.group_id where groups.id =".$group_id;
			$result = $this->db->query($result);
			$result = $result->result_array(); 		
			return $result;
		 }	
	}
	
	function get_customer_group_xref($customer_id)
	{
		$query = "
		SELECT * FROM ec_customers_group_xref
		WHERE customer_id = '$customer_id'
		ORDER BY id DESC LIMIT 1
		";
		$r = $this->db->query($query);
		$row = $r->row_array();
		return $row;
		
	}
	
	function recurring_delete_customer_group_xref($customer_id, $group_id = 0)
	{
			
			$select_query = "
			SELECT * FROM ec_customers_group_xref
			WHERE customer_id = '$customer_id'
			AND group_id = '$group_id'
			ORDER BY id DESC LIMIT 1";
			$r_select = $this->db->query($select_query);
			$result_array = $r_select->result_array();
			$data = array(
			   'customer_id' => $result_array[0]['customer_id'] ,
			   'group_id' => $result_array[0]['group_id']
			);
			$this->db->insert('ec_customers_expired_group_xref',$data);
			$delete_query = "
			Delete  FROM ec_customers_group_xref
			WHERE customer_id = '$customer_id'
			AND group_id = '$group_id'
			ORDER BY id DESC LIMIT 1";
			$r = $this->db->query($delete_query);
			if($r)
			{
				return true;
			}
			
			return false;
	}
		
	function get_customer_last_group_id($customer_id, $group_id = 0)
	{
		
		if($group_id == 0)
		{
			$query = "
			SELECT * FROM ec_customers_group_xref
			WHERE customer_id = '$customer_id'
			ORDER BY id DESC LIMIT 1";
		}
		else
		{
			$query = "
			SELECT * FROM ec_customers_group_xref
			WHERE customer_id = '$customer_id'
			AND group_id = '$group_id'
			ORDER BY id DESC LIMIT 1";
		}			
		
		$r = $this->db->query($query);
		if($r->num_rows() == 1)
		{
			$row = $r->row_array();
			$group_id = $row['group_id'];
			return $group_id;
		}
		return 0;
		
	}
	
	function get_customer_group_page($group_id)
	{
		$query = "SELECT id,group_page_id  
		FROM groups 
		WHERE id =".$group_id."
		AND is_disabled =  'No' ";
		$r = $this->db->query($query);
		$row = $r->row_array();	
		return $row["group_page_id"];
	}
	
   function Recover_Password($mail,$password,$site_id)
   {
   	    $this->site_id = $site_id;
		$pwd = md5($password);
	 $qry = "UPDATE ec_customers SET customer_password ='".$pwd."' 
								   WHERE customer_login ='".$mail."'
								   AND site_id = ".$site_id."";
		$query = $this->db->query($qry);
		
		 if (sizeof($query) > 0)
		 {
		    return true ;
	     }
		 else
		 {
		    return false;	 
		 }		
   }
   function getCustomer($id){
	  $data = array();
	  $options = array('customer_id' => intval($id));
	  $Q = $this->db->get_where('ec_customers',$options,1);
	  if ($Q->num_rows() > 0){
		$data = $Q->row_array();
	  }
	  $Q->free_result();
	  return $data;
	}
	//get customer Group ID
	function getCustomerGroupID($id)
	{
		$qry = "SELECT membershipid FROM ec_customers WHERE customer_id = '".$id."' AND status = 'Y'";
		$result = $this->db->query($qry);
	 	$data = $result->result_array();
	
		return $data[0]["membershipid"];
	}
 
   function getCustomerByEmail($e){
	  $data = array();
	  $options = array('email' => $e);
	  $Q = $this->db->getwhere('ec_customers',$options,1);
	  if ($Q->num_rows() > 0){
		$data = $Q->row_array();
	  }
	  $Q->free_result();
	  return $data;
	}
 
 /*  function getAllCustomers($site_id=NULL,$search_param=NULL){
	 $data = array();  
	 $this->site_id = $site_id; 
	 
	 if(!empty($search_param) || $search_param != NULL)
	 {
		// $this->db->where($search_param['search_by'], $search_param['search_value']);
		 $this->db->like($search_param['search_by'], $search_param['search_value']); 
	 }
	$this->db->where('site_id', $this->site_id);
	$this->db->join('groups', 'groups.id = ec_customers.membershipid');
	$Q = $this->db->get('ec_customers');
	$Q = "SELECT *
	FROM ec_customers
	INNER JOIN groups ON ec_customers.membershipid = groups.id
	WHERE site_id = '".$site_id."' ";
	$rslt = $this->db->query($Q);
	echo $Q;
	exit;
	
//	$Q = "SELECT *
//	FROM ec_customers
//	INNER JOIN groups ON ec_customers.membershipid = groups.id
//	WHERE ec_customers.customer_id =177";
	
//	$Q = "SELECT * FROM ec_customers
//	INNER JOIN groups 
//	WHERE groups.id = ec_customers.membershipid
	AND site_id = '".$site_id."' ";
	 
	 if ($rslt->num_rows() > 0){
	   foreach ($rslt->result_array() as $row){
		 $data[] = $row;
	   }
	 }
	 $rslt->free_result();
	 return $data;
	}*/
	
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
		$this->db->where('site_id', $this->site_id);
		$this->db->join('ec_customers_group_xref', 'ec_customers.customer_id = ec_customers_group_xref.customer_id','left');
		$re = $this->db->get('ec_customers');
		if ($re->num_rows() > 0)
		{
	   		$i = 0;
			foreach ($re->result_array() as $rows)
			{
		 		$data_search[$i] = $rows;
				$data_search[$i]['all_groups'] = $this->get_all_groups_of_member($rows['customer_id']);
				$i++;
			}
	 	}
		//echo "---------<pre>";print_r($data_search);exit;
	 }
	
	if(isset($data_search) && count($data_search)>0)
	{
			$combile_array['search_result'] = $data_search;
	}
	 
	 $Q = $this->db->query("SELECT ec_customers.* ,ec_customers_group_xref.group_id FROM ec_customers LEFT JOIN ec_customers_group_xref ON ec_customers.customer_id = ec_customers_group_xref.customer_id WHERE ec_customers.site_id =".$_SESSION['site_id']." GROUP BY ec_customers.customer_login");
	 if ($Q->num_rows() > 0){
	 $i = 0;
	   foreach ($Q->result_array() as $row){
	   //echo "<pre>";print_r($this->get_all_groups_of_member($row['customer_id']));
	   	
		 $data[$i] = $row;
		 $data[$i]['all_groups'] = $this->get_all_groups_of_member($row['customer_id']);
		 $i++;
	   }
	 }
   
	 $Q->free_result();
	 if(isset($data))
	 {
	 	$combile_array['customers'] = $data;
		return $combile_array;
	 }
	 //echo"---<pre>";print_r($combile_array);exit;
	 return false;
	
	}
	
	
	function getAllUsers($site_id=NULL,$search_param=NULL)
	{
	 $data = array();  
	 $this->site_id = $site_id; 
	 
	 if(!empty($search_param) || $search_param != NULL)
	 {
		// $this->db->where($search_param['search_by'], $search_param['search_value']);
		 $this->db->like($search_param['search_by'], $search_param['search_value']); 
	 }
	 
	// $this->db->where('site_id', $this->site_id);
	// $this->db->where('membershipid', 0);
	 //$this->db->or_where('membershipid', 'NULL');
	 $where = "site_id = ".$this->site_id." AND ec_customers_group_xref.group_id =  'NULL'";
	 $this->db->where($where);
     $this->db->join('ec_customers_group_xref', 'ec_customers.customer_id = ec_customers_group_xref.customer_id');
	 $this->db->order_by("ec_customers.customer_id", "desc");
	 $Q = $this->db->get('ec_customers');
	 
	// $Q="SELECT * FROM ec_customers WHERE site_id=".$this->site_id." AND  membershipid = 0";
	 if ($Q->num_rows() > 0){
	   foreach ($Q->result_array() as $row){
		 $data[] = $row;
	   }
	 }
	 $Q->free_result();
	 
	 return $data;
	}
 
   function getCustomers(){
	 $data = array();
	 return $this->db->get('ec_customer');
	}
	
	 function getAllCustomersCountBySiteID($site_id=NULL,$search_param=NULL)
	 {
		 $customer_count = '';
		 $data = array();  
		 $this->site_id = $site_id; 
		 $this->db->where('site_id', $this->site_id);
		 $Q = $this->db->get('ec_customers');
		 $customer_count = $Q->result_array();
		 $customer_count = count($customer_count);
		 return $customer_count;
	 }
 
	function addCustomer($site_id='')
	{
	$this->site_id = $site_id;
		$membershipid  = 0;
		if($this->input->post('group_code')== NULL || $this->input->post('group_code') == 'root'){
			$gruop_CODE = 'N/A';
		}else{
		   $gruop_CODE = $this->input->post('group_code');
		}		
		if($this->input->post('pending_membershipid') == '0'){
			$membershipid =  $this->fetch_memberID_ByCode($gruop_CODE);
		}else{
			$membershipid = $this->input->post('pending_membershipid');
		}
		if(empty($membershipid))
		{
			$membershipid = 0;
		}
		if($this->checkCustomerByEmailId($this->site_id, $this->input->post('email')))
		{
			return  false;
		}
		
	 $data = array(
						'site_id' => trim($site_id),
						'customer_login' => trim($this->input->post('email')),
						'customer_fname' => $this->input->post('fname'),
						'customer_lname' => $this->input->post('lname'),
						'customer_email' => $this->input->post('email'),
						'customer_password' => md5($this->input->post('password')),
						'registered_date' =>  date('Y-m-d h-i-s')
						);

		  $this->db->insert('ec_customers',$data);
		  $this->customer_id = $this->db->insert_id();
		  
		  $data_xref = array(
						'customer_id' => trim($this->customer_id),
						'site_id' => trim($this->site_id)
						);
		  
		  $this->db->insert('ec_customers_site_xref',$data_xref);
		  return $this->customer_id;     
		  
	}
	
	function address_book_ad($sit_id= '' , $customer_id='')
	{
		$this->site_id = $sit_id;
		$this->customer_id = $customer_id;
		 $data = array(
					   // 'site_id' => trim($site_id),
						'customer_id' => trim($this->customer_id),
						'address_book_fname' => trim($this->input->post('f_name')),
						'address_book_lname' => trim($this->input->post('last_name')),
						'address_book_address' => $this->input->post('address'),
						'address_book_city' => $this->input->post('city'),
						'address_book_state' => $this->input->post('state'),
						'address_book_country' => $this->input->post('country'),
						'address_book_zipcode' => $this->input->post('post_code'),
						'address_book_phone' => $this->input->post('phone'),
						'address_book_fax' => $this->input->post('fax'),
						'default_shiping' => 'Yes',
						'default_billing' => 'Yes'
						
						);
		  $this->db->insert('ec_address_book',$data);
		  $this->customer_id = $this->db->insert_id();
		  return $this->customer_id; 
	}
	
	
 
   function checkCustomer($e){
		$numrow = 0;
		$this->db->select('customer_id');
		$this->db->where('email',db_clean($e));
		$this->db->limit(1);
		$Q = $this->db->get('ec_customers');
		if ($Q->num_rows() > 0){
			$numrow = TRUE;
			return $numrow;
		}else{
			$numrow = FALSE;
			return $numrow;
		}
	}
	
	
	 function checkCustomerByEmailId($site_id, $e)
	 {
		//echo $site_id."--".$e;
		$numrow = 0;
		
		//$this->db->limit(1);
		$Q = $this->db->query("select * from ec_customers where customer_login = '".$e."' AND site_id =".$site_id);
		if ($Q->num_rows() > 0){
			$numrow = TRUE;
			return $numrow;
		}else{
			$numrow = FALSE;
			return $numrow;
		}
	 } 
 
   function verifyCustomer($e,$pw){
		$this->db->where('email',db_clean($e,50));
		$this->db->where('password', db_clean(dohash($pw),16));
		$this->db->limit(1);
		$Q = $this->db->get('ec_customer');
		if ($Q->num_rows() > 0){
			$row = $Q->row_array();
			$_SESSION['customer_id'] = $row['customer_id'];
			$_SESSION['customer_first_name'] = $row['customer_first_name'];
			$_SESSION['customer_last_name'] = $row['customer_last_name'];
			$_SESSION['phone_number'] = $row['phone_number'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['address'] = $row['address'];
			$_SESSION['city'] = $row['city'];
			$_SESSION['post_code'] = $row['post_code'];
		}else{
			// $_SESSION['customer_id'] = 0; // this will eliminate error
		}
	}
 
   function updateCustomer($site_id='' , $customer_id=''){
		 $this->site_id = $site_id;		 
		// $this->$customer_id = $customer_id;
		if($this->input->post('group_code')== NULL || $this->input->post('group_code') == 'root'){
			$gruop_CODE = 'N/A';
		}else{
			$gruop_CODE = $this->input->post('group_code');
		}
		if($this->input->post('pending_membershipid') == '0'){
			$membershipid =  $this->fetch_memberID_ByCode($gruop_CODE);
		}else{
			$membershipid = $this->input->post('pending_membershipid');
		}
 		
		if ($this->input->post('action') && $this->input->post('action') == 'updat_Customer')
		{
			$data = array(
						'customer_fname' => $this->input->post('fname'),
						'customer_lname' => $this->input->post('lname'),												
						'customer_email' => $this->input->post('email'),
						'customer_password' => md5($this->input->post('password'))
						);
						
						 // #### send mail #### //
                    $message = '-------------------
					
You are receiving this email because someone has requested a change of password.
					
If you did not wish to change your password, please login with the new one here and reset your password back.
					
Login Mail: '.$this->input->post('email').' 
Password: '.$this->input->post('password').' 

Please do not reply to this email, as it was sent from an unmonitored account.

http://www.webpowerup.com/

--------------';
					
                    $this->load->library('email');
                    $this->email->from('admin@webpowerup.com', 'WebpowerUp');
                    $this->email->to($this->input->post('email'));
                    //$this->email->cc('noreply@webpowerup.com');
                    // $this->email->bcc('them@their-example.com');
                    $this->email->subject('Signup | System Confirmation Mail');
                    $this->email->message($message);
                    $this->email->send();
					
		}
		else
		{
			
		 $data = array(
						'customer_login' => trim($this->input->post('email')),
						'customer_gender' => trim($this->input->post('gender')),
						'customer_fname' => $this->input->post('fname'),
						'customer_lname' => $this->input->post('lname'),
						'customer_company' => $this->input->post('company'),
						'customer_url' => $this->input->post('url'),
						'customer_email' => $this->input->post('email'),
						'membershipid' => $membershipid,
						'group_code' => $gruop_CODE						
						);
		}
						//echo "<pre>"; print_r($_REQUEST);	print_r($data);exit;
	  $this->db->where('customer_id',intval($this->input->post('customer_id')));
	  $this->db->where('site_id',intval($this->site_id));
	  $this->db->update('ec_customers',$data);
	  return true;   
 
	}
	 function change_password($site_id='' , $customer_id=''){
		 
				//print_r($_REQUEST	);
						   $this->site_id = $site_id;
						   $this->$customer_id = $customer_id;
		 $data = array(
						'customer_password' => md5($this->input->post('passconf'))
						);
	  $this->db->where('customer_id',intval($this->input->post('customer_id')));
	  $this->db->where('site_id',intval($this->site_id));
	  $this->db->where('customer_password', trim($this->input->post('old_pass')));
	  $this->db->update('ec_customers',$data);
	  //exit;
	  return true;   
 
	}
 
   function deleteCustomer($id){
		$this->db->where('customer_id', intval($id));
		$this->db->delete('ec_customers');
	}
 
   function checkOrphans($id){
		$data = array();
		$this->db->where('customer_id',intval($id));
		$Q = $this->db->get('ec_order');
		if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $key=>$row){
			 $data[$key] = $row;
		   }
		$Q->free_result();
		return $data;
		}
 
 }
 
   function changeCustomerStatus($id){
		// getting status
		$userinfo = array();
		$userinfo = $this->getUser($id);
		$status = $userinfo['status'];
		if($status =='active'){
			$data = array('status' => 'inactive');
			$this->db->where('id', intval($id));
			$this->db->update('ec_customers', $data);
		}else{
			$data = array('status' => 'active');
			$this->db->where('id', intval($id));
			$this->db->update('ec_customers', $data);
	}
 }
	function getAllAddress($site_id=0, $customer_id= 0){
	 $data = array();
	// $this->db->where('customer_email', trim($this->input->post('email'))); 
	//echo '----------'.$customer_id;
	 $this->db->where('customer_id', trim($customer_id)); 
	 $Q = $this->db->get('ec_address_book');
	 if ($Q->num_rows() > 0){
	   foreach ($Q->result_array() as $row){
		 $data[] = $row;
	   }
	 }
	 $Q->free_result();
	 return $data;
	}
	function getAllInvoices($site_id='' , $customer_id= '' )
	{
		 $data = array();
		// $this->db->where('customer_email', trim($this->input->post('email'))); 
		 $this->db->where('customer_id', trim($customer_id)); 
		 $Q = $this->db->get('invoice');
		 if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $row){
			 $data[] = $row;
		   }
		 }
		 $Q->free_result();
		 return $data;
	}
	
	function get_invoice($invoice_id)
	{
		//$qry = "SELECT * FROM invoice WHERE invoice_id = ".$invoice_id;
		$array = array();
		$qry = "SELECT * FROM invoice, invoice_products WHERE invoice.invoice_id = invoice_products.invoice_id AND invoice.invoice_id = ".$invoice_id;
		$rslt = $this->db->query($qry);
		$array = $rslt->result_array();		
		return $array;
	}
	
	function code_check($code = '')
	{
		$this->db->select('group_code');
		$this->db->where('group_code',trim($code));
		$this->db->where('is_deleted','No');
		$this->db->where('is_disabled','No');
		
		$this->db->limit(1);
		$Q = $this->db->get('groups');
		if ($Q->num_rows() > 0){
		   return true; 
		}else{
			return false;  
		}
	}
 
		function email_check($email = '',$site_id='')
	{
		$this->db->select('customer_email');
		$this->db->where('customer_email',trim($email));
		$this->db->where('site_id',trim($site_id));
		$this->db->limit(1);
		$Q = $this->db->get('ec_customers');
		if ($Q->num_rows() > 0){
		   // echo 'DB true part'; exit();
		   return true; 
		}else{
			 
		   // echo 'DB False part'; exit(); 
			return false; 
		}
	}
	
	function email_exist_for_edit($email = '',$site_id='', $previous_email)
	{
		
		if($email == $previous_email || $this->email_check($email,$site_id) == false )
		{
			return false; 
		}
		else
		{
			return true; 
		}
	}
	
	function fetch_memberID_ByCode($Code='')
	{
		$rows = array();
		$this->db->select('id');
		// $this->db->where('user_id',intval($id));
		// $Q = $this->db->get('user_packages_xref');
		$query = $this->db->get_where('groups', array('group_code' => trim($Code)));  
		if ($query->num_rows() > 0){ 
			$Data = $query->result_array();
			// print_r($Data[0]["required"]); exit();  
			if(array_key_exists(0,$Data)){
			   return $Data[0]["id"];
			}else
			{
				return false;   
			}
		}
	}
	
	function get_customer_private_page($site_id,$data)
	{
	  
	   $result = array();
	   for($i = 0; $i < sizeof($data); $i++)
	   {
		   $qry = $this->db->query("SELECT page_id ,page_users
										   FROM pages 
										   WHERE page_users = ".$data[$i]['customer_id']."");
		   $result[$i] = $qry->result_array();
	   }
	   
	 
	   return $result;
	}
	
	function get_all_groups_by_customer_id($cid)
	{
		$this->db->where("customer_id",$cid);
		$r = $this->db->get("ec_customers_group_xref");
		if ( $r->num_rows() > 0 )
		{
			$group_ids = $r->result_array();
			return $group_ids;
		}
		return false;
	}
	
	//Get all groups of any customer
	function get_all_groups_of_member($member_id)
	{
		$query =  "SELECT g.id, g.group_name, g.payment_method, g.is_deleted,
		cgr.id AS relationID, cgr.customer_id , cgr.group_id
		FROM groups AS g
		JOIN ec_customers_group_xref AS cgr
		ON cgr.group_id = g.id
		WHERE cgr.customer_id = '$member_id'
		";
		
		$r = $this->db->query($query);
		$groups =  $r->result_array();
		if(count($groups)>0)
		{
			return $groups;
		}
		else
		{
			return false;
		}
	}
}// 
?>