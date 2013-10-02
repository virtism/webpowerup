<?php
    if(!isset($mode))
    {
        $mode = '';    
    }
    if($mode == 'edit')
    {
        $strLink = 'javascript: void(0);';     
    }
    else
    {
         $strLink = base_url().index_page().'site_preview/site/'.$site_id;   
    }
    if(!isset($site_name)){
        $site_name="SiteBuilder";
    }
?>
<h1><a href="<?=$strLink?>"><?=$site_name?> <small>put your slogan here</small></a></h1>