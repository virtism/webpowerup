<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class orders_model extends CI_Model{
 
    function __construct()
    {
       // Call the Model constructor  
        parent::__construct();
    }
 

     function getAllOrders(){
        $this->db->from('ec_order');
        $this->db->join('ec_customer', 'ec_order.customer_id = ec_customer.customer_id');
        $Q = $this->db->get();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data[] = $row;
        }
        $Q->free_result();
        return $data;
        }
     }
 
     function getOrders(){
         $Q = $this->db->get('ec_order');
         return $Q;
     }
 
     function ordersToComplete(){
        $Q = $this->db->get_where('ec_order', array('delivery_date' => 0));
        return $Q;
 
     }
 
    function getOrderDetails($id){
         $this->db->select('ec_order_item.order_item_id,ec_order_item.order_id,ec_order_item.product_id,
                           ec_order_item.quantity,ec_order_item.price,ec_products.pd_name,
                           ec_order.order_date, ec_order.delivery_date, ec_order.payment_date');
         $this->db->from('ec_order_item');
         $this->db->join('ec_products', 'ec_products.pd_id = ec_order_item.product_id');
         $this->db->join('ec_order', 'ec_order.order_id = ec_order_item.order_id');
         $this->db->where('ec_order_item.order_id', intval($id));
         $Q = $this->db->get();
 
         $data= array ();
         if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                 $data[] = $row;
               }
         }
         $Q->free_result();
         return $data;
 
    }
 

     function format_currency($number){
         return number_format($number,2,'.',',');
     }
 
     function enterorder($totalprice){
 
          $data = array (
              'customer_last_name' => db_clean($this->input->post('customer_last_name')),
              'customer_first_name' => db_clean($this->input->post('customer_first_name')),
              'phone_number' => db_clean($this->input->post('telephone')),
              'email' => db_clean($this->input->post('email')),
              'address' => db_clean($this->input->post('shippingaddress')),
              'city' => db_clean($this->input->post('city')),
              'post_code' => db_clean($this->input->post('post_code'))
          );
 
            $e = $this->input->post('email');
            $numrow = $this->MCustomers->checkCustomer($e);
            if ($numrow == TRUE){
                // if there is email in db, then update the details
                $this->db->where('email', $e);
                $this->db->update('ec_customer',$data);
                // get the customer_id
                $customer_details = $this -> MCustomers->getCustomerByEmail($e);
                $customer_id = $customer_details['customer_id'];
            }else{
                // no email entry, then insert the details
                $this->db->insert('ec_customer',$data);
                // get the customer_id
                $customer_id = $this->db->insert_id();
            }
 
          $data = array (
               'customer_id'=> $customer_id,
               'total' => $totalprice
          );
          $this->db->set('order_date', 'NOW()', FALSE);
          $this->db->insert('ec_order', $data);
          $order_id = $this->db->insert_id();
          $cart = $_SESSION['cart'];
          foreach ($cart as $id => $product){
                $data = array(
                        'order_id' => $order_id,
                        'product_id'=> $id ,
                        'quantity' => $product['count'],
                        'price'=> $product['price']
                );
          $this->db->insert('ec_order_item', $data);
                }
     }
 
     function setpayment($id){
          $this->db->where('order_id', intval($id));
          $this->db->set('payment_date', 'NOW()', FALSE);
          $this->db->update('ec_order');
     }
 
      function setdelivery($id){
          $this->db->where('order_id', intval($id));
          $this->db->set('delivery_date', 'NOW()', FALSE);
          $this->db->update('ec_order');
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
 
}// 
 
?>
