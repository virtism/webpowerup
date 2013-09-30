<?php
class Help_Center_Model extends CI_Model{
	//Constructor for this model
	function Help_Center_Model(){
		parent::__construct(); 
		$this->load->database();        
	}
	
	function do_creat_new_question($site_id)
	{

		$current_time = date("Y-m-d H:i:s", time()); 
		 
		//echo "<pre>";
		//print_r($_REQUEST);
		//exit;
		
		if($_REQUEST["action"] == "Update")
		{
			
			$question_data = array(
									'site_id' => $site_id,
									'question_title' => $_REQUEST["question_title"],
									'description' => $_REQUEST["description"],                           
									'create_date' => $current_time,
									'is_faq' => (isset($_REQUEST["is_faq"])) ? 1 : 0   
							);
							
			$this->db->where('id ', $_REQUEST["question_id"]);
			$topic_id = $this->db->update('help_center_question ', $question_data);
			
			$str_qry = "DELETE FROM help_center_question_topics_xref WHERE question_id = '".$_REQUEST["question_id"]."'";
			$this->db->query($str_qry);
			
			foreach($_REQUEST["topic_id"] as $key => $val)
			{
				$qry = "INSERT INTO help_center_question_topics_xref(topic_id,question_id) VALUES('".$val."','".$_REQUEST["question_id"]."')";
				$this->db->query($qry);
				
			}					
							
		}
		else
		{
			
			
			$is_faq = ( $_POST["is_faq"] == 1 ) ? 1 : 0;
			
			$question_data = array(
								'site_id' => $site_id,
								'question_title' => $_REQUEST["question_title"],
								'description' => $_REQUEST["description"],                           
								'create_date' => $current_time,
								'is_faq' => $is_faq
							);
							
			$question_id = $this->db->insert('help_center_question', $question_data);
			$question_id = $this->db->insert_id();							
			
			
			foreach($_REQUEST["topic_id"] as $key => $val)
			{
				$qry = "INSERT INTO help_center_question_topics_xref(topic_id,question_id) VALUES('".$val."','".$question_id."')";
				$this->db->query($qry);
			}	
		}
		
		return true;
	}

	function do_creat_new_topic($site_id)
	{
		//echo "<pre>";
	//	print_r($_REQUEST);
		//print_r($_FILES);
		
		//exit;
		
		if($_FILES['topic_icon']['name'] != "")
		{
			$file_name = time().str_replace(" ","_",strtolower($_FILES['topic_icon']['name']));
		
			$config['file_name'] = $file_name;
			$config['upload_path'] = './media/help_center/icons/';            
			
			$config['allowed_types'] = 'gif|jpg|png';                       
			$this->upload->initialize($config);

			if($this->upload->do_upload("topic_icon"))          
			{
		
			}	
		}
		
		
		$current_time = date("Y-m-d H:i:s", time());
		
		
		
		if($_REQUEST["action"] == "Update")
		{
			$topic_data = array(
								'site_id' => $site_id,
								'topic_title' => $_REQUEST["topic_title"],
								'description' => $_REQUEST["description"],                           
								'create_date' => $current_time  
							);
							
			if($_FILES['topic_icon']['name'] != "")
			{
				$iamge_array = array(
									'image_name' => $file_name
									);
				$topic_data = array_merge($topic_data,$iamge_array)	;
									
			}
			$this->db->where('id ', $_REQUEST["topic_id"]);
			$topic_id = $this->db->update('help_center_topics ', $topic_data);
		}
		else
		{
			$topic_data = array(
								'site_id' => $site_id,
								'topic_title' => $_REQUEST["topic_title"],
								'image_name' => $file_name,
								'description' => $_REQUEST["description"],                           
								'create_date' => $current_time  
							);
							
		
			$topic_id = $this->db->insert('help_center_topics ', $topic_data);
			$topic_id = $this->db->insert_id();		
		}
		
		
		
		return true;
	}
	
	/*
	  This function will load all Site Gruops.
	*/
	function get_all_topics($site_id=0)
	{
		//Not completedddddddddddd
		$str_query = "SELECT * FROM help_center_topics WHERE site_id = '".$site_id."' AND is_deleted = '0'";
		$result = $this->db->query($str_query);
		return $result->result_array(); 
	}
	
	function get_all_question($site_id)
	{
		$str_query = "SELECT * FROM help_center_question WHERE site_id = '".$site_id."' AND is_deleted = '0'";
		$result = $this->db->query($str_query);
		return $result->result_array(); 
	}
	
	function get_topic_by_id($topic_id)
	{
		$str_query = "SELECT * FROM help_center_topics WHERE id = '".$topic_id."'";
		$result = $this->db->query($str_query);
		return $result->result_array(); 
	}
	
	function get_question_by_id($question_id)
	{
		$str_query = "SELECT * FROM help_center_question WHERE id = '".$question_id."'";
		$result = $this->db->query($str_query);
		$question_array = $result->result_array();
		
		$topic_2_question =  $this->get_topics_by_question_id($question_id);
		//echo "<pre>";
		//print_r($topic_2_question);
		
		//print_r($question_array);
		
		if(!empty($topic_2_question))
		{
			$question_array[0]["topics"] = $topic_2_question;
		}
		//print_r($question_array);                         
		//exit; 
		
		
		return $question_array; 
			
	}
	
	private function get_topics_by_question_id($question_id)
	{
		$str_query = "SELECT * FROM help_center_question_topics_xref WHERE question_id = '".$question_id."'";
		$result = $this->db->query($str_query);
		return $result->result_array(); 	
		
	}
	
	function do_delete_topic($topic_id)
	{
		$str_query = "UPDATE help_center_topics SET is_deleted = '1' WHERE id = '".$topic_id."'";
		$result = $this->db->query($str_query);
		return true;
	}
	
	function do_delete_question($question_id)
	{
		$str_query = "UPDATE help_center_question SET is_deleted = '1' WHERE id = '".$question_id."'";
		$result = $this->db->query($str_query);
		return true;	
	}
	
    //  method get_all_topics to fetch 
    function fetch_all_topics($site_id = 0)
    {
          $data = array ();
          $this->db->where ('is_deleted','0');
          $this->db->where ('site_id', trim($site_id));
          $Q = $this->db->get('help_center_topics');
          if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                        $data[] = $row;
                    }
                }
            $Q->free_result();
            
/*            echo '<pre>';
            print_r($data);
            exit(); */
            return $data;
        
    }   
    function fetch_faqs_spec($topic_id=0)
    {   
        $data = array ();
          $this->db->where ('topic_id',$topic_id);
         // $this->db->where ('site_id', $sit_id);
          $Q = $this->db->get('help_center_question_topics_xref');
          if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                        $data[] = $this->fetch_question($row['question_id']);
                    }
                }
            $Q->free_result();
            
/*          echo '<pre>';
            print_r($data);
            exit(); */
            return $data;
        
    }
     function fetch_faqs($site_id=0)
    {
        
         $data = array ();
         $this->db->where ('is_faq','1');
         $this->db->where ('is_deleted', '0');
         $this->db->where ('site_id', trim($site_id)); 
          $Q = $this->db->get('help_center_question');
          if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                        $data[] = $row;
                    }
                }
            $Q->free_result();
            return $data;
        
    }
    
    
        function fetch_question($id=0)
    {
        
        $data = array ();
          $this->db->where ('id',trim($id));
          $this->db->where ('is_deleted','0');
         // $this->db->where ('site_id', $sit_id);
          $Q = $this->db->get('help_center_question');
          if ($Q->num_rows() > 0){
               foreach ($Q->result_array() as $row){
                        $data[] = $row;
                    }
                }
            $Q->free_result();
            
           if(array_key_exists(0,$data)){ 
                return $data[0];
           }else{
              return $data;
           }
        
    }    
    function fetch_topic_name($id=0)
    {
        
        $data = '';
        $this->db->select('topic_title');
          $this->db->where ('id',trim($id));
          $Q = $this->db->get('help_center_topics');
          if ($Q->num_rows() > 0){
              $row= $Q->result_array();
                        $data = $row[0]['topic_title'];
                }
            $Q->free_result();
             return $data;
    }                      
    
    

}
?>