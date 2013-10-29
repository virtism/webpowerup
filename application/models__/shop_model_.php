<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class shop_model extends CI_Model{
 
    function __construct()
    {
       // Call the Model constructor  
        parent::__construct();
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
     
     
     
 
     function site_store_exists($id)
     {
            $this->db->select('site_id');
            $this->db->where('site_id',intval($id));
            $Q = $this->db->get('site_store_xref');
            if ($Q->num_rows() > 0){
                return TRUE;
                
            }else{
                return FALSE;
            }
            $Q->free_result(); 
         
         
     }
     
     
     function set_store($id)
     {
        $data = array(
                'required' =>  trim($this->input->post('required')),
                'product_view' =>  trim($this->input->post('product_view')),
                'product_per_page' =>  trim($this->input->post('product_per_page')),
                'link_per_page' =>  trim($this->input->post('link_per_page')),
                'site_id' => intval($id)
                 );
 
                $this->db->update('site_store_settings', $data);
                return true;  
         
         
         
     }
   
     function get_store_settings($id='')
     {
          
            $rows = array();
            $query = $this->db->get_where('site_store_settings', array('site_id' => intval($id)));  
            $rows = $query->result_array();
           // $package_id = $rows[0]; 
         //  print_r($rows[0]); exit();
          //  echo  $package_id.'>>>>>>>>>>';  exit();
           return  $rows[0]; 
         
         
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
