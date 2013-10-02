<?php
class Siteusers_model extends CI_Model
{
    //Constructor for this model
    function Siteusers_model(){
        parent::__construct();
        $this->load->database();     
    }    
    
    function getSiteUsers()
    {
        $site_id = $_SESSION['site_id'];
        
        
        echo $site_id;exit;
    }
    
}  
?>
