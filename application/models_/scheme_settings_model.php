<?php
@session_start();
class Scheme_Settings_Model extends CI_Model{
    //Constructor for this model
   // var $site_id;  
   // var $user_id;
    function Menus_Model(){
        parent::__construct(); 
        $this->load->database();        
    }
    
  
    
    function setting_exist ($site_id=0)
    {
       //  echo '<pre>';  print_r($_POST); echo 'I am here ';  echo '</pre>'; exit();
        //echo $id.'>>>>>>>>>>>>>';
            $rows = array();
            $scheme_id = 0;
            $this->db->select('scheme_id');
            $this->db->where('site_id',intval($site_id));
            //$this->db->where('menu_id',intval($id));
            $query = $this->db->get('menu_color');
            //$query = $this->db->get_where('user_packages_xref', array('user_id' => intval($id)));  
             if ($query->num_rows() > 0){
               $row = $query->result_array(); 
                        $scheme_id = $row[0]['scheme_id'];
             } 
             
         // echo $gruop_id.': >>>>>>>>>>>>>>>> '; exit();
          return $scheme_id; 
    }
    function change_color_scheme($site_id=0)
    {
       $scheme_id = $this->setting_exist($site_id);   
      if($scheme_id)
      { 
         // echo  $scheme_id.'>>>>>>>>>>>>>>'; exit();
           
        $data = array(
            //'site_id' =>  intval($this->input->post('cat_name')),
           // 'menu_id' =>  intval($this->input->post('short_desc')),
            'primary_color' =>  $this->input->post('primary_color'),
            'secondary_color' =>  $this->input->post('secondary_color'),
            'tertiary_color' =>  $this->input->post('tertiary_color'),
            'primary_txt' => $this->input->post('primary_text'),
            'secondary_txt' => $this->input->post('secondary_text'),
            'tertiary_txt' => $this->input->post('tertiary_text'),
            'default' => 'Custome'

         );  
         $this->db->where('scheme_id', intval($scheme_id));
         $this->db->update('menu_color', $data);
         return true; 
      }
      else
      {
          //echo  $scheme_id.'$$$$$$$$$$$$$$'; exit();
         $data = array(
                    'site_id' =>  intval($site_id),
                  //  'menu_id' =>  intval($this->input->post('short_desc')),
                    'primary_color' =>  $this->input->post('primary_color'),
                    'secondary_color' =>  $this->input->post('secondary_color'),
                    'tertiary_color' =>  $this->input->post('tertiary_color'),
                    'primary_txt' => $this->input->post('primary_text'),
                    'secondary_txt' => $this->input->post('secondary_text'),
                    'tertiary_txt' => $this->input->post('tertiary_text'),
                    'default' => 'Custome'
              
             );   
             $this->db->insert('menu_color', $data); 
             return true;
      } 
      return false;        
    }
    
    function get_scheme_color ($site_id=0)
    {
       //  echo '<pre>';  print_r($_POST); echo 'I am here ';  echo '</pre>'; exit();
        //echo $id.'>>>>>>>>>>>>>';
            $rows = array();
            $scheme = array();
           // $this->db->select('scheme_id');
            $this->db->where('site_id',intval($site_id));
            //$this->db->where('menu_id',intval($id));
            $query = $this->db->get('menu_color');
            //$query = $this->db->get_where('user_packages_xref', array('user_id' => intval($id)));  
             if ($query->num_rows() > 0){
               $row = $query->result_array(); 
                        $scheme = $row[0];
                      //  $scheme = $scheme[0];
             } 
             
         // echo $gruop_id.': >>>>>>>>>>>>>>>> '; exit();
          return $scheme; 
    }
    
    
   function update_scheme ($site_id=0)
    {

           
        $data = array(
            'default' => $this->input->post('option')

         );  
         $this->db->where('site_id', intval($site_id));
       if($this->db->update('menu_color', $data)){
         return true; }
       else{
         return false; }
     
    }
    
    
    
   
    
}
?>
