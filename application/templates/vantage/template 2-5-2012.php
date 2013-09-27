<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>  
<?=$_scripts?>
<?=$_styles?>
<style type="text/css">
div#menu ul 
{
	list-style: none;
	padding: 0;
	margin: 0;
}
div#menu li 
{
	float: left;
	position: relative;
}
div#menu ul ul li 
{
	width: 150px;
}
div#menu ul#nav li a 
{
	display: block;
	
}
div#menu li ul 
{
	display: none;
	position: absolute;
	width:150px;
	top: 0;
	left: 0;
	margin-left:-1px;
}
div#menu li>ul 
{
	top: auto;
	left: auto;
	
}
div#menu li:hover ul, div.menu_nav li.over ul 
{
	display: block;
}

</style>
<?php
if(!isset($description))
{
	$description = "";    
}
?>
<meta name="Description" content="<?=$description?>" />
<?php
if(!isset($keywords))
{
	$keywords = "";    
}
?>
<meta name="Keywords" content="<?=$keywords?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="WebPowerUp! www.webpowerup.com" />
<meta name="Robots" content="index,follow" />
<title> <?=$title?> </title>


<link rel="stylesheet" href="<?=base_url(); ?>css/vantage/images/Orange.css" type="text/css" /> 
<?php
if(!isset($page_header))
{
	$page_header = '';
}
if($page_header=='Slideshow')
{
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.slideshow').cycle({
		fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});
</script>
<?php
}
?>
	
</head>
<?php

$strBodyStyle = '';
if($page_header=='Slideshow' || $page_header=='Other')
{
	$strBodyStyle = 'style="background: none;"';
}
?>
<body <?=$strBodyStyle?>>

<?php
$strStyle = '';
if($page_header=='Other' || $page_header=='Slideshow' && $header_background!='Default')
{
	//$strBackgroundColor = '#'.$header_background;
	if($header_background == 'Image')
	{
		$strStyle = 'style="background-image:url('."'".$header_background_image."'".'); background-repeat: repeat;"';
	}   
	else
	{
		$strStyle = 'style="background-color:#'.$header_background.'"';        
	} 
}
if($page_header=='Other')
{
?>
<div style="border-bottom:8px solid orange;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr <?=$strStyle?>>
		<td>&nbsp;</td>
		<td width="850">
			<img src="<?=$header_image?>" style="width:100%" />
		</td>
		<td>&nbsp;</td>
	</tr>
</table>         
</div>
<?php
}
else if($page_header=='Slideshow')
{
?>
<div style="border-bottom:8px solid orange">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr <?=$strStyle?>>
		<td>&nbsp;</td>
		<td width="850">
			<div class="slideshow">
				<?php 
				foreach($header_image->result_array() as $rowImage)
				{
				?>
				<img style="width: 100%;" src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />    
				<?php
				}
				?>
			</div>
		</td>
		<td>&nbsp;</td>
	</tr>
</table>         
</div>
<?php
}
?>

<!-- wrap starts here -->
<div id="wrap"> 
	<?php
	if($page_header!='Slideshow' && $page_header!='Other')
	{
	?>
	
	<div id="header">    
	   <?php  $this->load->view('vantage/logo');  ?>
	</div>  
	  
	<?php
	}
	?>
		
	<div id="menu">
		<ul>
		  <?php // $this->load->view('all_common/menu',$menu);
			// print_r(); exit();
		  ?>
		  <?=$menu?> 
		  <? //=$other_top_navigation?>
		</ul>
	</div>
	<?php
if(isset($main_slideshows) )
{
?>      
		<div class="clear"> </div> 
		<div class="top_slider_div">
			 <?=$top_slider?>
		</div>
		<!--<div class="clear"> </div>-->
 <?
}
?> 
	<!-- content-wrap starts here -->    
	<div id="content-wrap"> 
			
			<?php
			if(!isset($background_image))
			{
				$background_image = '';    
			}
			$strStyle = "";
			if($background_image!="" && $background_area=='page' && $background_style=='stretch')
			{
				$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    
			}
			else if($background_image!="" && $background_area=='page' && $background_style=='tile')
			{
				$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";
			}
			?>   
			<table border="0" width="100%" cellpadding="0" cellspacing="0" style="<?=$strStyle?>">
			<tr><td>
			
			<div id="sidebar">
				<?= $leftbar?>
			</div>        
	
				<?php
				$strStyle = "";
				if($background_image!="" && $background_area=='content' && $background_style=='stretch')
				{
					$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    
				}
				else if($background_image!="" && $background_area=='content' && $background_style=='tile')
				{
					$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";
				}
				?>  
				<div id="main" style="<?=$strStyle?>"> 
				
				<?php
				if(!isset($mode))
				{
					$mode = '';
				}
				/*
				if($mode=='edit')
				{
					$strHeader = '<div style="border:dotted 1px #CECECE;"><h2>'.$title.'
					<a class="edit_title" href="'.base_url().'index.php/page_editor/editPageTitle/'.$site_id.'/'.$page_id.'"><img style="border:none; cursor: pointer" src="'.base_url().'images/edit_icon.jpg" /></a></h2></div>';
				}
				else
				{
					$strHeader = '<h2>'.$title.'</h2>';    
				}
				*/
				?>
				
				<?=$content?>
								
			  </div>     
			
			<div id="sidebar">
				<?=$rightbar?>
			</div>          
	
			</td></tr>
			</table>
	<!-- content-wrap ends here -->    
	</div>
	
<!-- wrap ends here -->
</div>        

<!-- footer starts here -->        
		<div id="footer">
			 <?php  //$this->load->view('vantage/footer');  ?>
			 <?=$footer?>    
		</div>    
<!-- footer ends here -->    

</body>
</html>