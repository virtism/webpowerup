<?php

class Gallery_Model extends CI_Model

{

    function Gallery_Model()

    {

        parent::__construct();

    }

    

    function save_gallery_info($gallery_data)

    {

       

	  /* echo "<pre>";

	   print_r($gallery_data);

	   exit();*/

	    $this->db->insert('galleries', $gallery_data);

        $gallery_id = $this->db->insert_id();

        return $gallery_id;        

    }

    

    function save_galleries_image_info($gallery_image_info)

    {

	

        $this->db->insert('gallery_images', $gallery_image_info);

       //$gallery_id = $this->db->insert_id();

		return true;      

    }

    
	function get_user_login_id($site_id)
	{
		$qry = $this->db->query("SELECT users.user_login, users.user_id
								FROM users
								INNER JOIN sites ON users.user_id = sites.user_id
								WHERE site_id =".$site_id.""
								);
		 $result = $qry->result_array();

    	 return $result;    
	  	
    }
	
    function save_gallery_pages_info($gallery_id, $page_id)

    {
        $qry = "INSERT INTO gallery_pages_xref(gallery_id, page_id) VALUES(".$this->db->escape($gallery_id).", ".$this->db->escape($page_id).")";
        $rslt = $this->db->query($qry); 
        /*$data['page_id']        = $page_id;
        $this->db->where('gallery_id', $gallery_id);
        $this->db->update('galleries', $data);*/
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

        $qry_gallery_images = "SELECT gall.* FROM gallery_images gall  
		                       JOIN  galleries gls ON gall.gallery_id = gls.gallery_id 									                               WHERE gall.gallery_image_status='Active'
							   AND   gls.gallery_type = 'image'
							   AND gall.gallery_id=".$this->db->escape($gallery_id)."";

        $rslt_gallery_images = $this->db->query($qry_gallery_images);

        $array_gallery_images = $rslt_gallery_images->result_array();

	

        return $array_gallery_images;

    }

    function get_gallries($site_id)

    {

        //select slideshows of all pages at slide position



       $qry_gallery = "SELECT * FROM galleries  WHERE  gallery_type = 'image' AND site_id=".$this->db->escape($site_id);

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

	

	function edit_galleries_image_info($gallery_image_info, $image_id='')
    {
		if(!empty($image_id))
		{
			$this->db->where('gallery_image_id', $image_id);
			$this->db->update('gallery_images', $gallery_image_info);
		}
		else
		{
			$this->db->insert('gallery_images', $gallery_image_info);	
		}
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

    

    function delete_slide_image_info($slide_image_id)

    {

        //soft delete : change status to deleted

		

         $qry = "DELETE FROM  gallery_images  WHERE gallery_image_id=".$this->db->escape($slide_image_id);

        

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

	

	//Get Gallery Templates

	function get_all_gallery_tamplates()

	{

		$qry_gallery = "SELECT * FROM galleries_templates";

		$gallery_records = $this->db->query($qry_gallery);

		$record = $gallery_records->result_array();

		return $record;     		

	}

	

	

	//Get number of gallries against a page

	function gallery_count($page_id)

	{

		$query = "Select count(*) from gallery_pages_xref  where page_id = ".$page_id;

		$rslt = $this->db->query($query);

		$array_rslt = $rslt->result_array();		

		return $array_rslt[0]['count(*)'];

	

		//print_r($array_rslt);

	}

	

	

	//Get Gallery For Front Site
    /*function get_all_gallery_data($site_id = 0, $page_id)
    {
      
        $this->db->select('*');
        $this->db->from('galleries');
        $this->db->join('galleries_templates' , 'galleries_templates.id = galleries.template_options');
        $this->db->where('galleries.gallery_type','image');
        $this->db->where('galleries.site_id',$site_id);
        $find = $this->db->get();
        $test_array = $find->result_array();
        foreach($test_array as $test_arrays)
        {

              if($test_arrays['gallery_pages'] == 'All')
              {
                    $this->db->select('*');
                    $this->db->from('galleries');
                    $this->db->join('galleries_templates' , 'galleries_templates.id = galleries.template_options');
                    $this->db->where('galleries.gallery_type','image');
                    $this->db->where('galleries.site_id',$site_id);
                    $this->db->where('galleries.gallery_pages','All');
                    $rslt = $this->db->get();
                    $array_rslt = $rslt->result_array(); 
              }
              else if($test_arrays['gallery_pages'] == 'Other')
              {
                    $this->db->select('*');
                    $this->db->from('galleries');
                    $this->db->join('gallery_pages_xref', 'galleries.gallery_id = gallery_pages_xref.gallery_id');
                    $this->db->join('galleries_templates' , 'galleries_templates.id = galleries.template_options');
                    $this->db->where('galleries.gallery_type','image');
                    $this->db->where('galleries.site_id',$site_id);
                    $rslt = $this->db->get();
                    $array_rslt = $rslt->result_array(); 
              } 
            $final_array[] = $array_rslt;   
        }
        
        return $final_array;
    }*/
    
    function get_all_gallery_data($site_id, $page_id)
    {
        
        $rslt_gallery = '';
        $array_rslt_gallery = array();
        if(isset($site_id) && $site_id!=0)
        {
            $qry_gallery = "SELECT * FROM galleries g
                            JOIN galleries_templates gt ON gt.id = g.template_options
                            WHERE 
                            g.gallery_type = 'image' 
                            AND
                            g.gallery_status = 'Active'
                            AND
                            g.gallery_published = 'Yes' 
                            AND
                            g.site_id=".$this->db->escape($site_id).""
                            ;    
            $rslt_gallery = $this->db->query($qry_gallery);
            $array_rslt_gallery = $rslt_gallery->result_array();
        }
        
        foreach($array_rslt_gallery as $result)
        { 
            if($result['gallery_pages']=='All')
            {
                 $array_rslt = $array_rslt_gallery;
            }
            else
            {
                $qry = "SELECT * FROM galleries g
                        JOIN gallery_pages_xref gpx ON g.gallery_id = gpx.gallery_id
                        JOIN galleries_templates gt ON gt.id = g.template_options
                        WHERE 
                        g.gallery_type = 'image' 
                        AND
                        g.gallery_status = 'Active'
                        AND
                        g.gallery_published = 'Yes' 
                        AND
                        gpx.page_id=".$this->db->escape($page_id)."";    
                $rslt = $this->db->query($qry);
                $array_rslt = $rslt->result_array();
            
            } 
        }
        return $array_rslt;    
    }
    
	//function get_all_gallery_data($site_id = 0, $page_id)

	//{

			

		
		/*$qry = "SELECT * FROM  galleries g  

		JOIN  gallery_pages_xref gpx  ON g.gallery_id = gpx.gallery_id 

		JOIN  gallery_images gall ON gall.gallery_id = g.gallery_id  

		JOIN  galleries_templates gt ON gt.id = g.template_options

		JOIN  galleries_templates_files gtf ON gtf.template_id = gt.id		  

		WHERE gpx.page_id=".$this->db->escape($page_id);

        $rslt = $this->db->query($qry);

        $array_rslt = $rslt->result_array();		

		foreach($array_rslt as $key => $value) if($key&1) unset($array_rslt[$key]);

		$array_rslt = array_values($array_rslt);

		//echo "<pre>";print_r($array_rslt);exit;		

        return $array_rslt;*/

		

		/*$qry = "SELECT * FROM galleries g

		JOIN gallery_pages_xref gpx ON g.gallery_id = gpx.gallery_id        

		JOIN galleries_templates gt ON gt.id = g.template_options

		WHERE 
		g.gallery_type = 'image' AND
		g.site_id=".$this->db->escape($site_id);	
        
       // echo $qry;---gpx.page_id=".$this->db->escape($page_id);    	

        $rslt = $this->db->query($qry);

        $array_rslt = $rslt->result_array();

		return $array_rslt;

		

	}*/

	function get_gallery_template_files($template_id)

	{

			$qry_gallery_files = "SELECT * FROM galleries_templates_files WHERE  template_id=".$this->db->escape($template_id);

			$rslt_gallery_files = $this->db->query($qry_gallery_files);

			$array_gallery_files = $rslt_gallery_files->result_array();

        	return $array_gallery_files;

	}



	function get_gallery_images_template($gallery_id)

	{

			$qry_gallery_images = "SELECT * FROM gallery_images WHERE  gallery_id=".$this->db->escape($gallery_id)."";

			$rslt_gallery_images = $this->db->query($qry_gallery_images);

			$array_gallery_images = $rslt_gallery_images->result_array();

        	return $array_gallery_images;

	}

	

	function get_gallery_template_option($template_option)

	{

		$query = "SELECT template_name FROM galleries_templates WHERE id = '$template_option' ";

		$r = $this->db->query($query);

		if ($r->num_rows() == 1)

		{

			$row = $r->row_array();

			return $row;

		}

		return false;

	}

}

?>