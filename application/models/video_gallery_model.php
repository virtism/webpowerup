<?php
class Video_Gallery_Model extends CI_Model
{
    function Video_Gallery_Model()
    {
        parent::__construct();
    }
    
    function save_gallery_info($gallery_data)
    {
        $this->db->insert('galleries', $gallery_data);
        $gallery_id = $this->db->insert_id();
        return $gallery_id;        
    }
    
    function save_galleries_image_info($gallery_image_info)
    {
        $this->db->insert('gallery_images', $gallery_image_info);
        $gallery_id = $this->db->insert_id();
		return $gallery_id;     
    }
    
    function save_gallery_pages_info($gallery_id, $page_id)
    {
        $qry = "INSERT INTO gallery_pages_xref(gallery_id, page_id) VALUES(".$this->db->escape($gallery_id).", ".$this->db->escape($page_id).")";
        $rslt = $this->db->query($qry);
        return true;
    }
    
    function save_gallery_roles_info($gallery_id, $group_id)
    {
        $qry = "INSERT INTO gallery_groups_xref(gallery_id, group_id) VALUES(".$this->db->escape($gallery_id).", ".$this->db->escape($group_id).")";   
        
        $rslt = $this->db->query($qry);        
        return true;
    }
    
    function get_gallery_images($gallery_id)
    {
        $qry_gallery_images = "SELECT gall.* FROM gallery_images gall  JOIN  galleries gls ON gall.gallery_id = gls.gallery_id WHERE gall.gallery_image_status='Active' AND gall.gallery_id=".$this->db->escape($gallery_id);
        $rslt_gallery_images = $this->db->query($qry_gallery_images);
        $array_gallery_images = $rslt_gallery_images->result_array();
        return $array_gallery_images;
    }
	
	function get_all_gallery_data($site_id, $page_id)
	{
		
		$rslt_gallery = '';
		$array_rslt_gallery = array();
		if(isset($site_id) && $site_id!=0)
		{
			$qry_gallery = "SELECT * FROM gallery_images g
			JOIN galleries gl ON g.gallery_id = gl.gallery_id
			WHERE site_id = ".$site_id." 
			AND gl.gallery_published='Yes' 
			AND gl.gallery_status = 'Active'
			AND g.gallery_image_status = 'Active' 
			AND gl.gallery_type = 'video'";	
			$rslt_gallery = $this->db->query($qry_gallery);
			$array_rslt_gallery = $rslt_gallery->result_array();	
			//echo "<pre>";print_r($array_rslt_gallery);exit;	
		
		}
		
		foreach($array_rslt_gallery as $result)
		{
			if(isset($result['gallery_pages']) && $result['gallery_pages']=='All')
			{
				 $array_rslt = $array_rslt_gallery;
			}
			else
			{
					$qry = "SELECT * FROM gallery_images g
					JOIN gallery_pages_xref gpx ON g.gallery_id = gpx.gallery_id
					JOIN galleries gl ON g.gallery_id = gl.gallery_id
					WHERE gl.gallery_published = 'Yes'
					AND gl.gallery_status = 'Active'
					AND g.gallery_image_status = 'Active' 
					AND gl.gallery_type = 'video'
					AND gpx.page_id=".$this->db->escape($page_id)."";	
					$rslt = $this->db->query($qry);
					$array_rslt = $rslt->result_array();
			
			} 
		}
		
	 // echo "<pre>";print_r($array_rslt);exit;
		return $array_rslt;	

	}
	
    function get_gallries($site_id)
    {
        //select slideshows of all pages at slide position

       $qry_gallery = "SELECT * FROM galleries WHERE gallery_type = 'video' AND site_id=".$this->db->escape($site_id);
	   $gallery_records = $this->db->query($qry_gallery);
       $record = $gallery_records->result_array();
    	return $record;     
    }
    
    function get_all_site_slides($from, $intPageLimit, $site_id)
    {
        $qry_all_site_slides = "SELECT * FROM slides 
        WHERE site_id=".$this->db->escape($site_id)." AND slide_status NOT IN ('Deleted') 
        ORDER BY slide_id DESC LIMIT ".$from.", ".$intPageLimit;
        
        $rslt_all_site_slides = $this->db->query($qry_all_site_slides);
        
        return $rslt_all_site_slides;
    }
    
    function get_all_slides($site_id)
    {
        $qry__all_slides = "SELECT * FROM slides 
        WHERE site_id=".$this->db->escape($site_id)." AND slide_status NOT IN ('Deleted') 
        ORDER BY slide_id DESC";
        
        $rslt_all_slides = $this->db->query($qry__all_slides);
        
        return $rslt_all_slides;
    }
    
    function totalGallery($site_id)
    {
        $qry_total_site_slides = "SELECT * FROM slides 
        WHERE slide_id=".$this->db->escape($site_id)." AND slide_status NOT IN ('Deleted')";
        
        $rslt_total_site_slides = $this->db->query($qry_total_site_slides);
        
        return $rslt_total_site_slides->num_rows();
    }
    
    function publishGallery($gallery_id)
    {
        $data = array(
               'gallery_published' => "Yes",
               'gallery_modified_date' => date('Y-m-d h:i:s'),               
            );     
        for( $i=0; $i<sizeof($gallery_id); $i++)
        {
            $this->db->where('gallery_id', $gallery_id[$i]);
            $this->db->update('galleries', $data); 
        }
        return TRUE;
    }
    
    function unpublishGallery($gallery_id)
    {
        $data = array(
               'gallery_published' => "No",
               'gallery_modified_date' => date('Y-m-d h:i:s'),                              
            );     
         for( $i=0; $i<sizeof($gallery_id); $i++)
         {
            $this->db->where('gallery_id', $gallery_id[$i]);
            $this->db->update('galleries', $data); 
         }
        return TRUE;
    }
    
    function deleteGallery($gallery_id)
    {
       for( $i=0; $i<sizeof($gallery_id); $i++)
         {
            $this->db->where('gallery_id', $gallery_id[$i]);
            $this->db->delete('galleries'); 
			$this->db->where('gallery_id', $gallery_id[$i]);
		    $this->db->delete('gallery_images');
         }
        
        //slide images status as In Active
       /* for( $i=0; $i<sizeof($arr_slide_id); $i++ )
        {
            $qry_set_slide_image_status = "UPDATE slide_images 
            SET slide_image_status='Inactive' 
            WHERE slide_image_id 
            IN(SELECT slide_image_id FROM slides_slide_images_xref WHERE slide_id=".$this->db->escape($arr_slide_id[$i]).")";
            
            $rslt_set_slide_image_status = $this->db->query($qry_set_slide_image_status);
        }*/
        
        return TRUE;
    }
    
    function get_gallery_info_by_id($gallery_id)
    {
        $qry = "SELECT * FROM galleries WHERE gallery_id=".$this->db->escape($gallery_id);
        
        $rslt = $this->db->query($qry);
        
        $row = $rslt->row_array();
        
        return $row;
    }
    
    function edit_gallery($gallery_data, $gallery_id)
    {
		$this->db->where('gallery_id', $gallery_id);
		$this->db->update('galleries', $gallery_data);         
        return true;
    }
	
	 function edit_galleries_image_info($gallery_image_info, $gallery_id)
    {
		
		/*$this->db->where('gallery_id', $gallery_id);
		$this->db->update('gallery_images', $gallery_image_info);   */   
		$this->db->insert('gallery_images', $gallery_image_info);
        $gallery_id = $this->db->insert_id();   
        return true;
    }
    
    function delete_gallery_pages_info($gallery_id)
    {
        $qry = "DELETE FROM gallery_pages_xref WHERE gallery_id=".$this->db->escape($gallery_id);          
        $rslt = $this->db->query($qry);        
        return true;         
    }
    
    function delete_gallery_access_info($gallery_id)
    {
        $qry = "DELETE FROM gallery_groups_xref WHERE gallery_id=".$this->db->escape($gallery_id);  
        $rslt = $this->db->query($qry);        
        return true;    
    }
    
    function delete_video_info($video_id)
    {
        //soft delete : change status to deleted
        $qry = "UPDATE gallery_images SET gallery_image_status='Deleted' WHERE gallery_image_id=".$this->db->escape($video_id);
        
        $rslt = $this->db->query($qry);
        
        return true;
        
    }
    
    function get_gallery_display_pages($gallery_id)
    {
        $qry = "SELECT page_id FROM gallery_pages_xref WHERE gallery_id=".$this->db->escape($gallery_id);
        $rslt = $this->db->query($qry);
        $array_rslt = $rslt->result_array();
        return $array_rslt;
    }
    
    function get_slideshow_access_roles($slide_id)
    {
        $qry = "SELECT role_id FROM slides_roles_xref WHERE slide_id=".$this->db->escape($slide_id);        
        $rslt = $this->db->query($qry);        
        $array_rslt = $rslt->result_array();        
        return $array_rslt;    
    }
    
    function save_slide_image_url($slide_image_id, $slider_image_url, $slider_image_title, $slider_image_desc)
    {
        $qry = "UPDATE slide_images SET slide_image_url=".$this->db->escape($slider_image_url).", slide_title=".$this->db->escape($slider_image_title).", slide_description=".$this->db->escape($slider_image_desc)." 
        WHERE slide_image_id=".$this->db->escape($slide_image_id);
        
        $rslt = $this->db->query($qry);
        
        return true;
        
    }
    
    function get_slider_dimension($slide_id)
    {
        $qry = "SELECT sli.slide_image 
        FROM slide_images sli JOIN slides_slide_images_xref six ON sli.slide_image_id=six.slide_image_id 
        WHERE six.slide_id=".$this->db->escape($slide_id)." AND slide_image_status='Active' ORDER BY sli.slide_image_id ASC LIMIT 1";
        
        $rslt = $this->db->query($qry);
        
        $size['width'] = 0;
        $size['height'] = 0;   
        
        if($rslt->num_rows()>0)
        {
            $row = $rslt->row_array();
            $image_file = './slideshows/'.$row['slide_image'];
            if(file_exists($image_file))
            {
                $image_dim = getimagesize($image_file);
                $size['width'] = $image_dim[0];
                $size['height'] = $image_dim[1];
            }
        }
        
        return $size;
    }
    
    function delete_slider_info($slide_id)
    {
        $qry_del_slide_info = "UPDATE slides SET slide_status='Deleted' WHERE slide_id=".$this->db->escape($slide_id);
        
        $rslt_del_slide_info = $this->db->query($qry_del_slide_info);
        
        return true;
        
    }
	
	function get_user_of_site($site_id)
	{
	 
	 if(!empty($site_id))
	 {
	 
		  $qry = $this->db->query("SELECT users.user_login,users.user_id
							FROM users
							INNER JOIN sites 
							ON sites.user_id=users.user_id
							WHERE sites.site_id = ".$site_id."");
		  
	 		return $array_rslt = $qry->result_array();
		}
		return false; 
	}
}
?>