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
<a href="<?=$strLink?>" class="logo">
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
		<img src="<?php echo base_url();?>css/mashup/images/logo.gif" alt="Mash up logo" />
	<?php
	}
	?>
</a>