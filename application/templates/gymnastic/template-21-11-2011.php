<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="<?=base_url(); ?>css/gymnastic/Stylesheet.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?=$_scripts?>
<?=$_styles?>
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
<meta name="Author" content="Mudassar Ali Sahil - sahil_bwp@yahoo.com - +92 334 6862971" />
<meta name="Robots" content="index,follow" />
<title><?=$title?></title>


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




<div id="container" >
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



<div id="backgroundshine" style="<?=$strStyle?>" >
	<div id="top">
	
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
?>  

 <?php
if($page_header=='Other')
{
?>     
		<div class="topinfonlogo" <?=$strStyle?>>
				<img src="<?=$header_image?>" style="width:960px; height:144px;" /> 
		</div>    
		
		
		  
 <?php       }
else if($page_header=='Slideshow')
{
?> 

		<div class="slideshow"  >
		   <?php 
				foreach($header_image->result_array() as $rowImage)
				{
		   ?>
			<!--<img src="<?=base_url(); ?>css/gymnastic/images/bigimage.png" /> -->
			<img style="width:960px; height:144px;"  src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />  
		   <?php
				}
		   ?>
		</div>
		
 <?php
}
?> 
 <?php
	if($page_header!='Slideshow' && $page_header!='Other')
	{
	?>
  <div class="topinfonlogo" <?=$strStyle?>>
			<div id="logo">
				<?php // $this->load->view('gymnastic/logo');  ?>  
				<?=$logo?>  
			</div>
			<div class="smallinfotop">
				<div class="toplinea">
					sit amet, consectetuer adipiscing elit, nonummy.
				</div>
				<div class="toplineb">
					Lamet, consectetuer adipiscing elit, nonummy.
				</div>
				<div class="toplineb">
					Lorem amet, sed diam nonummy.
				</div>
			</div>
		</div>
	
		<?php
	}
	?>    

	  

	
		<div class="clear"> </div>
		<div class="menu_nav">
				
			<ul>
			  <?php // $this->load->view('all_common/menu',$menu);
			// print_r(); exit();
		  ?>
		  <?=$menu?> 
		  <?//$other_top_navigation?> 
				
			</ul>
		

		   
		
<!--        <div class="nevibuttona">
				<div class="leftroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonleftround.png" />
				</div>
				<div class="midnevibtn">
					<div class="titlemidnevibtn">
						<a href="template.html">Home</a>
					</div>
				</div>
				<div class="rightroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonrightround.png" />
				</div>
			</div>
			<div class="empty">
			</div>
			<div class="nevibuttona">
				<div class="leftroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonleftround.png" />
				</div>
				<div class="midnevibtn">
					<div class="titlemidnevibtn">
						<a href="template.html">Anything</a>
					</div>
				</div>
				<div class="rightroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonrightround.png" />
				</div>
			</div>
			<div class="empty">
			</div>
			<div class="nevibuttona">
				<div class="leftroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonleftround.png" />
				</div>
				<div class="midnevibtn">
					<div class="titlemidnevibtn">
						<a href="template.html">About</a>
					</div>
				</div>
				<div class="rightroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonrightround.png" />
				</div>
			</div>
			<div class="empty">
			</div>
			<div class="nevibuttona">
				<div class="leftroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonleftround.png" />
				</div>
				<div class="midnevibtn">
					<div class="titlemidnevibtn">
						<a href="template.html">Events</a>
					</div>
				</div>
				<div class="rightroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonrightround.png" />
				</div>
			</div>
			<div class="empty">
			</div>
			<div class="nevibuttona">
				<div class="leftroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonleftround.png" />
				</div>
				<div class="midnevibtn">
					<div class="titlemidnevibtn">
						<a href="template.html">Activities</a>
					</div>
				</div>
				<div class="rightroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonrightround.png" />
				</div>
			</div>
			<div class="empty">
			</div>
			<div class="nevibuttona">
				<div class="leftroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonleftround.png" />
				</div>
				<div class="midnevibtn">
					<div class="titlemidnevibtn">
						<a href="template.html">FAQs</a>
					</div>
				</div>
				<div class="rightroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/navigationnormalbuttonrightround.png" />
				</div>
			</div>
			<div class="empty">
			</div>
			<div class="nevibuttona">
				<div class="leftroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/fbbuttonnevileftroound.png" />
				</div>
				<div class="midnevibtn">
					<div class="titlemidnevibtnfb">
						<img src="<?=base_url(); ?>css/gymnastic/images/fbbuttonnevimid.png" />
					</div>
				</div>
				<div class="rightroundnevibtn">
					<img src="<?=base_url(); ?>css/gymnastic/images/fbbuttonnevirightround.png" />
				</div>
			</div> -->
		</div>
	</div>

   <div class="clear"> </div>
   
	<div id="mid">
	<!--<div class="body_tp">&nbsp;</div> -->
<!--        <div class="bigimage">
			<img src="<?=base_url(); ?>css/gymnastic/images/bigimage.png" />
			 
		</div>--> 
		
   <?php
	$strStyle = "";
	if($background_image!="" && $background_area=='menu with content' && $background_style=='stretch')
	{
		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    
	}
	else if($background_image!="" && $background_area=='menu with content' && $background_style=='tile')
	{
		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";
	}
	?>        
		
		
		<div class="main-content" style="<?=$strStyle?>" >
			<div class="sidebar">
			<?=$sidebar?>
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
			
			
			<div class="inner-content" style="<?=$strStyle?>">
			   <?
			   $style = "";
				if($_SESSION["is_menu"]== 0)
				{
					$style = 'style="width:920px;"';	
				}
					
				
			   ?>
			   
			   <div class="welcomebox" <?=$style?>>
				<?=$content?>  
			   </div> 
			</div>
		</div>
	   <!--<div class="body_btm">&nbsp;</div> -->
	</div>
	<div class="clear"> </div>   

	<div id="footer">
		<?php  $this->load->view('gymnastic/footer');  ?> 
	</div>
</div>
</div>
</body>
</html>
