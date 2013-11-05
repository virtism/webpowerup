<!-- HEADER IMAGE AREA START --> 

<?php
if($page_header=="Other")
{
?>
<div id="tpl_header">
    <img src="<?=$header_image?>" style="width: 100%;" />
</div>
<?php
//exit; 
}
else if($page_header=="Slideshow")
{
?>
<div id="tpl_header" class="slideshow">
    <?php 
    foreach($header_image->result_array() as $rowImage)
    {
    ?>
    <img style="width: 100%;" src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />    
    <?php
    }
    ?>
</div> 
<?php
}
else
{
    //load default header image        
}
//exit;
?>
    
<!-- HEADER IMAGE AREA END -->