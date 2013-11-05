<?php

class PagesModel extends CI_Model {

	function is_already_exist()
	{
		$this->db->where('role_name', $this->input->post('role_name'));
		$query = $this->db->get('roles');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function creat_page()
	{
		$page_id = 1; 
		if(isset($_POST["page_id"]))
		{
			$page_id = $_POST["page_id"]; 
		}
			 //echo "asas";
		$insertPageArray = array(
								'site_id' => $page_id,
								'page_title' => $_POST["page_title"],
								'page_seo_url' => $_POST["page_seo_url"],
								'page_code' => $_POST["page_code"],
								'page_seo_url' => $_POST["page_seo_url"],
								'page_create_date' => "NOW()",
								'page_seo_url' => $_POST["page_seo_url"]
								);
			//echo "<pre>";
			//print_r($insertPageArray);
			//exit;
		
		$insert = $this->db->insert('pages', $insertPageArray);
		$page_id = $this->db->insert_id(); 
		
		$insertContentArray = array(
																'page_id' => $page_id,
																'page_content' => mysql_escape_string($_POST["page_content"])
																);
		$insert2 = $this->db->insert('page_content', $insertContentArray);
																
			 
		 
		return $insert;
	}
	
	function get_role_by_id($id)
	{
		$this->db->where('role_id', $id);    
		$query = $this->db->get('roles');
		return $query->result(); 
		
	}
	function get_page_data_by_id($id)
	{
		$qry = "SELECT * FROM pages p,page_content pc WHERE p.page_id = '".$id."' AND p.page_id = pc.page_id ";

		$query = $this->db->query($qry);
		$page_data = $query->result_array(); 
		return $page_data; 
		
	}
	function get_all_pages()
	{
		$query = $this->db->get('pages');
		
		$allPages = $query->result_array();
		return $allPages; 
	}

    function get_pages_dropdown($site_id=0)
    {
             $data = array();
			 $this->uri->segment(4,0);
            // $this->db->where('page_status', 'Published');
             $this->db->where('site_id', $site_id);
			 $this->db->where("page_parent",0);
			 $this->db->where("page_id != ",$this->uri->segment(4,0));
           //  $this->db->order_by('cat_name','asc');
             $Q = $this->db->get('pages');
             if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                        $data[$row['page_id']] = $row['page_title'];
                    }
                }
            $Q->free_result();
            return $data;
    }
	
	function get_pages_normal_dropdown($site_id=0)
    {
             $data = array();
			 $this->uri->segment(4,0);
            // $this->db->where('page_status', 'Published');
             $this->db->where('site_id', $site_id);
			 $this->db->where("page_parent",0);
			 $this->db->where("page_type","Normal");
			 $this->db->where("page_id != ",$this->uri->segment(4,0));
           //  $this->db->order_by('cat_name','asc');
             $Q = $this->db->get('pages');
             if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                        $data[$row['page_id']] = $row['page_title'];
                    }
                }
            $Q->free_result();
            return $data;
    }

    
}
?>