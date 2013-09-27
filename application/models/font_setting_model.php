<?php
@session_start();
class Font_setting_model extends CI_Model{
    //Constructor for this model
   // var $site_id;  
   // var $user_id;
    function Menus_Model(){
        parent::__construct(); 
        $this->load->database();        
    }
	
	function font_exist($site_id)
    {
        $font_id = 0;
		$rows = array();
		$this->db->where('site_id',$site_id);
		$query = $this->db->get('menus_font');
		if ($query->num_rows() > 0){
			
			$row = $query->row_array(); 
		    $font_id = $row['id'];
			
		} 
		return $font_id; 
    }
	
	function get_font_title($site_id)
	{
		$this->db->where('site_id',$site_id);
		$q = $this->db->get('menus_font');
		if ($q->num_rows() > 0)
		{
			$row = $q->row_array(); 
			$font = $row['font'];
		}
		else
		{
			$font = "default";
		}
		return $font;
		
	}
	
	function save_font($site_id)
	{
		
		if ( $this->font_exist($site_id) == 0 )
		{
			 $data = array(
                    'site_id' =>  $site_id,
					"font" => $this->input->post('font')
             );   
             $this->db->insert('menus_font', $data); 
             return true;
		}
		else if ($this->input->post('font') == "default")
		{
			$this->delete_menu_font_by_site_id($site_id);
			return true;
		}
		else
		{
			 $data = array(
                    "font" => $this->input->post('font')
             );   
			 $this->db->where('site_id', $site_id);
             $this->db->update('menus_font', $data); 
             return true;
		}
		return false;
	}
	
	function delete_menu_font_by_site_id($site_id)
	{
		$this->db->where('site_id', $site_id);
		$r = $this->db->delete('menus_font');
		return $r;
	}
    

    
    
    
   
    
}
?>
