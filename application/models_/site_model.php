<?php
class Site_Model extends CI_Model{
	function Site_Model()
	{
		parent::__construct();
		$this->load->database();
		
	}
	
	function get_all_sites_by_user($user_id)
	{
		$qry = "SELECT * FROM sites WHERE site_status != 'Deleted' AND user_id = '".$user_id."'";
		$query = $this->db->query($qry);
		$sitesArray = $query->result_array();
		return $sitesArray;
	}
	
	function get_site_domain_name($site_id)
	{
		$qry = "SELECT * FROM sites WHERE  site_id = '".$site_id."'";
		$query = $this->db->query($qry);
		$sitedimain = $query->result_array();
		return $sitedimain;
	}
	
	function get_site_title($site_id)
	{
		$q = "SELECT * FROM sites WHERE  site_id = '".$site_id."'";
		$r = $this->db->query($q);
		if( $r->num_rows() > 0 ) 
		{
			$site = $r->row_array();
			$site_name = $site['site_name'];
			return $site_name;
		}
		return "";
	}
	function getHomePage2($site_id)
	{
		$qry = "SELECT * FROM pages pgs JOIN sites sts ON pgs.site_id=sts.site_id WHERE sts.site_id=".$this->db->escape($site_id)." AND pgs.page_ishomepage='Yes'";
		$query = $this->db->query($qry);
		$sitePage = $query->result_array();
		return $sitePage;
	}
	
	
	function getHomepage($site_id)
	{
		return $this->db->query("SELECT * FROM pages pgs JOIN sites sts ON pgs.site_id=sts.site_id WHERE sts.site_id=".$this->db->escape($site_id)." AND pgs.page_ishomepage='Yes'");
	}
	
	function getSitePage($site_id, $page_id)
	{
		//echo "<pre>"; print_r($_SESSION);
		//echo "SELECT * FROM pages pgs JOIN sites sts ON pgs.site_id=sts.site_id WHERE sts.site_id=".$this->db->escape($site_id)." AND pgs.page_id=".$this->db->escape($page_id);exit();
		return $this->db->query("SELECT * FROM pages pgs JOIN sites sts ON pgs.site_id=sts.site_id WHERE sts.site_id=".$this->db->escape($site_id)." AND pgs.page_id=".$this->db->escape($page_id));
	}
	
	function getHeaderImage($page_id)
	{
		$rsltHeaderImage = $this->db->query("SELECT header_image FROM headers hdr JOIN pages_headers_xref phx ON phx.header_id=hdr.header_id
		JOIN pages pgs ON pgs.page_id=phx.page_id WHERE pgs.page_id=".$this->db->escape($page_id)." AND hdr.is_header='Yes'");
		$rowHeaderImage = $rsltHeaderImage->row_array();
		return $rowHeaderImage["header_image"];
	}
	
	function getSlideshowHeaderImgs($page_id)
	{
		$rsltSlideshowHeaderImgs = $this->db->query("SELECT header_image FROM headers hdr JOIN pages_headers_xref phx ON phx.header_id=hdr.header_id
		JOIN pages pgs ON pgs.page_id=phx.page_id WHERE pgs.page_id=".$this->db->escape($page_id)." AND hdr.is_header='No'");
		
		return $rsltSlideshowHeaderImgs; 
	}
	
	function getBackgroundImage($page_id)
	{
		$rsltBackgroundImage = $this->db->query("SELECT * FROM backgrounds bkg JOIN pages_backgrounds_xref pbx ON pbx.background_id=bkg.background_id
		JOIN pages pgs ON pgs.page_id=pbx.page_id WHERE pgs.page_id=".$this->db->escape($page_id));
		return $rsltBackgroundImage;
		//return $rowBackgroundImage["background_image"];
	}
	
	function getPageContent($page_id)
	{
		$rsltPageContent = $this->db->query("SELECT page_content FROM page_content WHERE page_id=".$this->db->escape($page_id));   
		$rowPageContent = $rsltPageContent->row_array(); 
		return $rowPageContent["page_content"];
	}
	
	function get_page_content($page_id)
	{
		$qryPageContent = "SELECT * FROM page_content_controls WHERE page_id=".$this->db->escape($page_id);
		return $this->db->query($qryPageContent);
		
	}
	
	//gets site's template name for the db
	//returns site's  template name to site_preview controller's site function
	function getSiteTemplate($site_id)
	{
		$qrySiteTemplate = "SELECT temp_name FROM system_templates stp JOIN sites_templates_xref stx ON stx.temp_id=stp.temp_id WHERE stx.site_id=".$this->db->escape($site_id)." LIMIT 1";
		//echo $qrySiteTemplate;exit;
		$rsltSiteTemplate = $this->db->query($qrySiteTemplate);
		
		if($rsltSiteTemplate->num_rows()>0)
		{
			$rowSiteTemplate = $rsltSiteTemplate->row_array();
			/*echo "<pre>";
			print_r($rowSiteTemplate);
			exit;*/
			$temp_name = $rowSiteTemplate['temp_name'];
			//echo "Template found";exit;
		}
		else
		{
			//Sets this(winglobal) as default template on the website incase no template is found in DB corresponding to this website.
			//echo "Template not found";exit;
			$temp_name = 'winglobal';
		}
		//echo $temp_name;exit;
		return $temp_name;
	}
	/*
	function getTemplateName($temp_id)
	{
		$qry = "SELECT temp_name FROM system_templates WHERE temp_id=".$this->db->escape($temp_id); 
		$rslt = $this->db->query($qry);
		$row = $rslt->row_array();
		return $row['temp_name'];   
	}
	*/
	
	function logo_exist($site_id)
	{
		$qry = 'SELECT logo_id FROM logos WHERE site_id='.$this->db->escape($site_id);
		$rslt = $this->db->query($qry);
		if($rslt->num_rows()>0)
		{
			$row = $rslt->row_array(); 
			return $row['logo_id'];   
		}
		else
		{
			return false;
		}
	}
	
	function save_logo($site_id, $logo_image ,$thumbnail_name)
	{
		
		$logo_id = $this->logo_exist($site_id);
		if($logo_id)
		{
			$this->delete_logo_files($site_id);
			$qry = 'UPDATE logos SET 
			logo_image ='.$this->db->escape($logo_image).',
			thumbnail_name ='.$this->db->escape($thumbnail_name).'	
			WHERE site_id='.$this->db->escape($site_id).'';
        }   
		else
		{
			$qry = 'INSERT INTO logos( site_id, logo_image, thumbnail_name) VALUES( '.$this->db->escape($site_id).','.$this->db->escape($logo_image).', '.$this->db->escape($thumbnail_name).')';
		} 
		
        $rslt = $this->db->query($qry);
        return true;
	}
    function get_logo_image($site_id)
    {
		
        $qry = 'SELECT thumbnail_name,site_id FROM logos WHERE site_id='.$this->db->escape($site_id).'';
        $rslt = $this->db->query($qry);
		if($rslt->num_rows()>0)
        {
            $row = $rslt->row_array();
            $logo_image = $row['thumbnail_name'];   
        }
        else
        {
            $logo_image = '';
        }
        return $logo_image;
    }
	
	 function check_logo_image($site_id)
    {
        $q = "SELECT * FROM logos WHERE site_id = '$site_id' ";

		$r = $this->db->query($q);
		
		$array = array();
		if( $r->num_rows() > 0)
		{		
			$array = $r->result_array();
			$array['flag'] = $r->num_rows();
			return $array;
		}
		return $array;
    }
	
	function update_publish($site_id,$publish)
	{
		$qry = "SELECT publish FROM logos WHERE site_id=".$this->db->escape($site_id)." ";
		$rslt = $this->db->query($qry);
		if($rslt->num_rows()>0)
        {
           $qry = 'UPDATE logos SET 
			publish ='.$this->db->escape($publish).'
			WHERE site_id='.$this->db->escape($site_id);   
        }
	/*	else
		{
			$qry = 'INSERT INTO logos( site_id, logo_image, thumbnail_name, publish) VALUES( '.$this->db->escape($site_id).','.$this->db->escape($logo_image).', '.$this->db->escape($thumbnail_name).', '.$this->db->escape($publish).' )';
		}*/
		
			
			$rslt = $this->db->query($qry);
            redirect('SiteController/sitehome/'.$site_id);
			
	}
		
	function delete_logo_files($site_id)
	{
		
		$this->db->where('site_id', $site_id);
		$r = $this->db->get("logos");
		$row = $r->row_array();
		$row['thumbnail_name'];
		$row['logo_image'];
		
		$files = array( "headers/".$row['logo_image'],"headers/".$row['thumbnail_name'] );
		
		//die(print_r($files));
		
		foreach($files as $file)
		{
			unlink($file);
		}
		return true;
		
	}
	
	function get_user_id_by($site_id)
	{
		$qry = 'SELECT user_id FROM sites WHERE site_id ='.$this->db->escape($site_id);
		$rslt = $this->db->query($qry);
		if($rslt->num_rows()>0)
		{
			$row = $rslt->row_array();
			$user_id = $row['user_id'];    
		}
		else
		{
			$user_id = '0';
		}
		return $user_id;		 
	}
	//return site id by Domain
	function get_site_id_by_domain($domain_name)
	{ 
		
		$qry = 'SELECT site_id FROM sites WHERE site_domain ='.$this->db->escape($domain_name);
		//echo $qry;exit; 
		$rslt = $this->db->query($qry);
		if($rslt->num_rows()>0)
		{
			$row = $rslt->row_array();
			$site_id = $row['site_id'];    
		}
		else
		{
			$site_id = '0';
		}
		return $site_id;
	}
	function getSiteTemplate_id($site_id)
	{
		$qrySiteTemplate = "SELECT stp.temp_id FROM system_templates stp JOIN sites_templates_xref stx ON stx.temp_id=stp.temp_id WHERE stx.site_id=".$this->db->escape($site_id)." LIMIT 1";
		//echo $qrySiteTemplate;exit;
		$rsltSiteTemplate = $this->db->query($qrySiteTemplate);
		
		if($rsltSiteTemplate->num_rows()>0)
		{
			$rowSiteTemplate = $rsltSiteTemplate->row_array();
			//echo "<pre>";
			//print_r($rowSiteTemplate);
			//exit;
			$temp_id = $rowSiteTemplate['temp_id'];
			//echo "Template found";exit;
		}
		
		//echo $temp_name;exit;
		return $temp_id;
	}
	function getSiteAdmindetail($site_id)
	{
		$qry = 'SELECT user_id FROM sites WHERE site_id ='.$this->db->escape($site_id);
		$rslt = $this->db->query($qry);
		if($rslt->num_rows()>0)
		{
			$row = $rslt->row_array();
			$qry_admin = 'SELECT user_id, user_login FROM users WHERE user_id ='.$this->db->escape($row['user_id']);
			$rslt_admin = $this->db->query($qry_admin);
			$row_admin = $rslt_admin->row_array();
		}
		else
		{
			$row_admin = '0';
		}
		return $row_admin;		
	}
		
}
?>