<?php

class Slideshow_Model extends CI_Model

{

    function Slideshow_Model()

    {

        parent::__construct();

    }

    

    function save_slideshow_info($slide_title, $slide_description, $caption_option, $slide_width, $slide_height, $slide_position, $slide_published, $slide_pages, $slide_access, $site_id,$slide_groups)

    {

       /*echo $slide_title. $slide_description. $slide_width. $slide_height. $slide_position. $slide_published. $slide_pages. $slide_access.$site_id;

       exit();*/

	  

	   if($slide_access == "Other")

	   {

		   $slide_groups = implode(",",$slide_groups);

	   }

	   else

	   {

		   $slide_groups = "";

	   }

	    

       $qry = "INSERT INTO slides(slide_title, slide_description, caption_position, slide_width, slide_height, slide_position, slide_published, slide_pages, slide_access, site_id, slide_status, slide_modified_date,slide_groups) 

        VALUES(".$this->db->escape($slide_title).", ".$this->db->escape($slide_description).",".$this->db->escape($caption_option).", ".$this->db->escape($slide_width).", ".$this->db->escape($slide_height).", ".$this->db->escape($slide_position).",

        ".$this->db->escape($slide_published).", ".$this->db->escape($slide_pages).", ".$this->db->escape($slide_access).",

        ".$this->db->escape($site_id).", 'Active', ".$this->db->escape(date('Y-m-d h:i:s')).", ".$this->db->escape($slide_groups).")";

        

        $rslt = $this->db->query($qry);

        

        $slide_id = $this->db->insert_id();

        

        return $slide_id;

        

    }

    

	function get_slideshow_groups($slide_id,$site_id)

	{

		$query = "SELECT slide_id,site_id,slide_groups FROM slides WHERE site_id = '$site_id' AND slide_id  = '$slide_id' ";

		

		$r = $this->db->query($query);

        

        $slide = $r->row_array();

		$slide_groups = $slide['slide_groups'];

		return $slide_groups;

	}

	

    function save_slideshow_image_info($slide_id, $slide_image, $slide_image_url,$slide_title,$slide_description,$target)

    {

        $qry_slide_image = "INSERT INTO slide_images(slide_image, slide_image_url, slide_title, slide_description, target, slide_image_status) 

        VALUES(".$this->db->escape($slide_image).", ".$this->db->escape($slide_image_url).", ".$this->db->escape($slide_title).", ".$this->db->escape($slide_description).", ".$this->db->escape($target).", 'Active')"; 

        

        $rslt_slide_image = $this->db->query($qry_slide_image);

        

        $slide_image_id = $this->db->insert_id();

        

        $qry_slide_image_xref = "INSERT INTO slides_slide_images_xref(slide_id, slide_image_id)

        VALUES(".$this->db->escape($slide_id).", ".$this->db->escape($slide_image_id).")";

        

        $rslt_slide_image_xref = $this->db->query($qry_slide_image_xref);

        

        return true;      

    }

    

    function save_slideshow_pages_info($slide_id, $page_id)

    {

        $qry = "INSERT INTO slides_pages_xref(slide_id, page_id)

        VALUES(".$this->db->escape($slide_id).", ".$this->db->escape($page_id).")";

        

        $rslt = $this->db->query($qry);

        

        return true;

    }

    

    function save_slideshow_roles_info($slide_id, $role_id)

    {

        $qry = "INSERT INTO slides_roles_xref(slide_id, role_id)

        VALUES(".$this->db->escape($slide_id).", ".$this->db->escape($role_id).")";   

        

        $rslt = $this->db->query($qry);

        

        return true;

    }

    

    function get_slideshow_images($slide_id)

    {

        $qry_slide_images = "SELECT sli.slide_image_id, sli.slide_image, sli.slide_title, sli.slide_description, sli.slide_image_url, sli.target FROM slide_images sli 

        JOIN slides_slide_images_xref six ON sli.slide_image_id=six.slide_image_id 

        JOIN slides sld ON sld.slide_id=six.slide_id

        WHERE sli.slide_image_status='Active' AND sld.slide_id=".$this->db->escape($slide_id);

        

        $rslt_slide_images = $this->db->query($qry_slide_images);

        

        $array_slide_images = $rslt_slide_images->result_array();

        

        return $array_slide_images;

    }

    function get_slideshow($site_id, $page_id, $slide_position)

    {

        //select slideshows of all pages at slide position
	


       $qry_all_pages_slideshows = "SELECT * FROM slides 

        WHERE site_id=".$this->db->escape($site_id)." AND slide_pages='All' AND  slide_status='Active' AND  slide_position=".$this->db->escape($slide_position)." AND slide_published='Yes'";

        $rslt_all_pages_slideshows = $this->db->query($qry_all_pages_slideshows);

        

        $array_all_pages_slideshows = $rslt_all_pages_slideshows->result_array();

          /*echo "<pre>";

          print_r($array_all_pages_slideshows);

          echo "<pre>";*/ 

          

        

        //select all pages slideshow images

        for($i=0; $i<sizeof($array_all_pages_slideshows); $i++)

        {

            $array_all_pages_slideshows[$i]["slide_images"] = $this->get_slideshow_images($array_all_pages_slideshows[$i]['slide_id']);    

        }

        

        //select slideshows of this page at slide position

         $qry_this_page_slideshows = "SELECT *  FROM slides sld

        JOIN slides_pages_xref spx ON spx.slide_id=sld.slide_id 

        WHERE sld.site_id=".$this->db->escape($site_id)." AND sld.slide_pages='Other' AND spx.page_id=".$this->db->escape($page_id)." 

        AND sld.slide_position=".$this->db->escape($slide_position)." AND sld.slide_status='Active' AND sld.slide_published='Yes'";
		
        $rslt_this_page_slideshows = $this->db->query($qry_this_page_slideshows);

        

        $array_this_page_slideshows = $rslt_this_page_slideshows->result_array(); 

       /*  echo "<pre>";

          print_r($array_this_page_slideshows);
			exit();*/
          //echo "<pre>";*/

            

        //select this page slideshow images

        for($i=0; $i<sizeof($array_this_page_slideshows); $i++)

        {

            $array_this_page_slideshows[$i]["slide_images"] = $this->get_slideshow_images($array_this_page_slideshows[$i]['slide_id']);    

        }

        

        

        /*echo '<pre>';

        print_r(array_merge($array_all_pages_slideshows, $array_this_page_slideshows));

        */

        

        

        return array_merge($array_all_pages_slideshows, $array_this_page_slideshows);

        

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

    

    function totalSlides($site_id)

    {

        $qry_total_site_slides = "SELECT * FROM slides 

        WHERE slide_id=".$this->db->escape($site_id)." AND slide_status NOT IN ('Deleted')";

        

        $rslt_total_site_slides = $this->db->query($qry_total_site_slides);

        

        return $rslt_total_site_slides->num_rows();

    }

    

    function publishSlides($arr_slide_id)

    {

        $data = array(

               'slide_published' => "Yes",

               'slide_modified_date' => date('Y-m-d h:i:s'),               

            );     

        for( $i=0; $i<sizeof($arr_slide_id); $i++)

        {

            $this->db->where('slide_id', $arr_slide_id[$i]);

            $this->db->update('slides', $data); 

        }

        return TRUE;

    }

    

    function unpublishSlides($arr_slide_id)

    {

        $data = array(

               'slide_published' => "No",

               'slide_modified_date' => date('Y-m-d h:i:s'),                              

            );     

        for( $i=0; $i<sizeof($arr_slide_id); $i++ )

        {

            $this->db->where('slide_id', $arr_slide_id[$i]);

            $this->db->update('slides', $data); 

        }

        return TRUE;

    }

    

    function deleteSlides($arr_slide_id)

    {

        $data = array(

               'slide_status' => "Deleted",

               'slide_modified_date' => date('Y-m-d h:i:s'),                              

            );     

        for( $i=0; $i<sizeof($arr_slide_id); $i++ )

        {

            $this->db->where('slide_id', $arr_slide_id[$i]);

            $this->db->update('slides', $data); 

        }

        

        //slide images status as In Active

        for( $i=0; $i<sizeof($arr_slide_id); $i++ )

        {

            $qry_set_slide_image_status = "UPDATE slide_images 

            SET slide_image_status='Inactive' 

            WHERE slide_image_id 

            IN(SELECT slide_image_id FROM slides_slide_images_xref WHERE slide_id=".$this->db->escape($arr_slide_id[$i]).")";

            

            $rslt_set_slide_image_status = $this->db->query($qry_set_slide_image_status);

        }

        

        return TRUE;

    }

    

    function get_slide_info_by_id($slide_id)

    {

        $qry = "SELECT * FROM slides WHERE slide_id=".$this->db->escape($slide_id);

        

        $rslt = $this->db->query($qry);

        

        $row = $rslt->row_array();

        

        return $row;

    }

    

    function edit_slide($slide_id, $slide_title, $slide_description,$caption_option, $slide_width, $slide_height, $slide_position, $slide_published, $slide_pages, $slide_access,$slide_groups)

    {

		

		if($slide_access == "Other")

		{

		   $slide_groups = implode(",",$slide_groups);

		}

		else

		{

		   $slide_groups = "";

		}

	   

        $qry = "UPDATE slides SET slide_title=".$this->db->escape($slide_title).", slide_description=".$this->db->escape($slide_description).",caption_position=".$this->db->escape($caption_option).", slide_width=".$this->db->escape($slide_width).", slide_height=".$this->db->escape($slide_height).", 

        slide_position=".$this->db->escape($slide_position).", slide_published=".$this->db->escape($slide_published).",  

        slide_pages=".$this->db->escape($slide_pages).", slide_access=".$this->db->escape($slide_access)."

		, slide_groups=".$this->db->escape($slide_groups)."  

        WHERE slide_id=".$this->db->escape($slide_id);

        

        $this->db->query($qry);

        

        return true;

    }

    

    function delete_slide_pages_info($slide_id)

    {

        $qry = "DELETE FROM slides_pages_xref WHERE slide_id=".$this->db->escape($slide_id);  

        

        $rslt = $this->db->query($qry);

        

        return true;

          

    }

    

    function delete_slide_access_info($slide_id)

    {

        $qry = "DELETE FROM slides_roles_xref WHERE slide_id=".$this->db->escape($slide_id);  

        

        $rslt = $this->db->query($qry);

        

        return true;    

    }

    

    function delete_slide_image_info($slide_image_id)

    {

        //soft delete : change status to deleted

        $qry = "UPDATE slide_images SET slide_image_status='Deleted' WHERE slide_image_id=".$this->db->escape($slide_image_id);

        

        $rslt = $this->db->query($qry);

        

        return true;

        

    }

    

    function get_slideshow_display_pages($slide_id)

    {

        $qry = "SELECT page_id FROM slides_pages_xref WHERE slide_id=".$this->db->escape($slide_id);

        

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

}

?>