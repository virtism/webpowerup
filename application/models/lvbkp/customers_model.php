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
        $this->site_id = '';
    }
    
        function do_login($site_id='')
    {
        
        //print_r($_POST);
        $this->site_id = $site_id;
        $this->db->where('site_id', $this->site_id);
        //$this->db->where('customer_login', trim($this->input->post('email')));
        $this->db->where('customer_email', trim($this->input->post('email')));
        $this->db->where('customer_password', trim($this->input->post('password')));
        $query = $this->db->get('ec_customers');
        
        if($query->num_rows == 1)
        {
            $userDate = $query->result();
            
              $logging = array();
            foreach($userDate[0] as $key => $val)
            {
                $logging[$key] = $val; 
            }
            
            $_SESSION["login_info"] = $logging ;
           // $user_id =$userDate[0]->user_id;  
            
           // $rowSites = $this->sitesmodel->get_all_sites_by_user($user_id);
            
          //  $_SESSION["site_info"] = $rowSites; 
            

            
            return true; 
            //exit;  
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
 
   function getAllCustomers($site_id=NULL,$search_param=NULL){
     $data = array();  
     $this->site_id = $site_id; 
     if(!empty($search_param) || $search_param != NULL)
     {
         $this->db->where($search_param['search_by'], $search_param['search_value']);
     }
     $this->db->where('site_id', $this->site_id);
     $Q = $this->db->get('ec_customers');
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
 
    function addCustomer($site_id='')
    {
        $this->site_id = $site_id;
         $data = array(
                        'site_id' => trim($site_id),
                        'customer_login' => trim($this->input->post('email')),
                        'customer_gender' => trim($this->input->post('gender')),
                        'customer_fname' => $this->input->post('f_name'),
                        'customer_lname' => $this->input->post('last_name'),
                        'customer_company' => $this->input->post('company'),
                        'customer_url' => $this->input->post('url'),
                        'customer_email' => $this->input->post('email'),
                        'membershipid' => $this->input->post('pending_membershipid'),
                        'group_code' => $this->input->post('group_code'),
                        'customer_password' => $this->input->post('passconf')
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
         $data = array(
                        'customer_login' => trim($this->input->post('email')),
                        'customer_gender' => trim($this->input->post('gender')),
                        'customer_fname' => $this->input->post('f_name'),
                        'customer_lname' => $this->input->post('last_name'),
                        'customer_company' => $this->input->post('company'),
                        'customer_url' => $this->input->post('url'),
                        'customer_email' => $this->input->post('email'),
                        'membershipid' => $this->input->post('pending_membershipid'),
                        'group_code' => $this->input->post('group_code')
                        
                        );
      $this->db->where('customer_id',intval($this->input->post('customer_id')));
      $this->db->where('site_id',intval($this->site_id));
      $this->db->update('ec_customers',$data);
      return true;   
 
    }
     function change_password($site_id='' , $customer_id=''){
         
                           $this->site_id = $site_id;
                           $this->$customer_id = $customer_id;
         $data = array(
                        'customer_password' => $this->input->post('passconf')
                        );
      $this->db->where('customer_id',intval($this->input->post('customer_id')));
      $this->db->where('site_id',intval($this->site_id));
      $this->db->where('customer_password',trim($this->input->post('old_pass')));
      $this->db->update('ec_customers',$data);
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

    function getAllAddress($site_id='' , $customer_id= '' ){
     $data = array();
    // $this->db->where('customer_email', trim($this->input->post('email'))); 
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
 
 
}// 
 
?>
