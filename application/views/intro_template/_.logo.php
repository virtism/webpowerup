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
?>

<a href="<?=$strLink?>">
    <?php
    if(!isset($logo_image))
    {
        $logo_image = '';    
    }
    if($logo_image!='')
    {
    ?>
        <img src="<?=base_url(); ?>headers/<?=$logo_image?>" alt="Your Company Logo" />  
               
    <?php
    }
    else
    {
    ?>
        <img src="<?=base_url(); ?>css/gymnastic/images/logo.png" alt="Your Company Logo" />
    <?php
    }
    ?>
</a>
<!--<span id="logo-text"><a href="./">&nbsp;</a></span> -->
<!--<span class="orange"><?=$site_name?></span> -->