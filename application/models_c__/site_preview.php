<?php
class Site_Preview extends CI_Model
{
    function Site_Preview()
    {
        parent::__construct();
    }
    
    function get_all_sites_by_user($user_id)
    {
        $qry = "SELECT * FROM sites WHERE site_status != 'Deleted' AND user_id = '".$user_id."'";
        $query = $this->db->query($qry);
        $sitesArray = $query->result_array();
        return $sitesArray;
    }
    
    //gets site's template name for the db
    //returns site's  template name to site_preview
    function getSiteTemplate($site_id)
    {
        $qrySiteTemplate = "SELECT temp_name FROM system_templates stp JOIN sites_templates_xref stx ON stx.temp_id = stp.temp_id WHERE stx.site_id =".$this->db->escape($site_id)." LIMIT 1";
        //echo $qrySiteTemplate;exit;
        $rsltSiteTemplate = $this->db->query($qrySiteTemplate);
        
        if($rsltSiteTemplate->num_rows()>0)
        {
            $rowSiteTemplate = $rsltSiteTemplate->result_array();
		    $temp_name = $rowSiteTemplate[0]['temp_name'];
            return $temp_name;
        }
        else
        {
            return 'winglobal';
        }
            
    }

}
?>
