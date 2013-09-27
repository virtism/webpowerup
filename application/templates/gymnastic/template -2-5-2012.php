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
<meta name="Author" content="WebPowerUp! www.webpowerup.com" />
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
//echo $strBodyStyle;exit; 
?>
<body <?=$strBodyStyle?>>


<?

//Code to Prefill BG color after image end
if(isset($color_after_image) && $background_area == "page" )
{
$background_color = 'style="background-color : #'.$color_after_image.';"';
}
else
{
$background_color = 'style="background-color : white;"';
}
//echo $background_color;
?>

<div id="container" <?=$background_color?> >

<!--<div id="container" >-->
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
//Color Control For Header Area and menu BG	
	$css_header_id = "header_area";
	$menu_bg_style = "";
	
	if($strStyle != "")
	{
		$css_header_id = "header_area_bg";
		$menu_bg_style = 'style="background-color:#307D99;"';
	}
	
?>

<div id="backgroundshine" style="<?=$strStyle?>" >
	<div id="<?=$css_header_id?>">
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
		$strStyle = 'style=" padding-top: 11px; background-color:#'.$header_background.'"';        
	} 
}   
?>  

 <?php
if($page_header=='Other')
{
?>     
		<div class="topinfonlogo" <?=$strStyle?>>
				
				<!---With fix Height--->
				<?php /*?><img src="<?=$header_image?>" style="width:960px;margin: auto;" /> <?php */?>
				
				<!---With Actual Height--->
				<img src="<?=$header_image?>" style="margin: auto;" /> 
		</div>    
		
		
		  
 <?php       }
else if($page_header=='Slideshow')
{
?> 

		<div class="slideshow" >
		   <?php 
				foreach($header_image->result_array() as $rowImage)
				{
		   ?>
			<!--<img src="<?=base_url(); ?>css/gymnastic/images/bigimage.png" /> -->
			<img style="margin: auto; padding-top: 11px;"  src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />  
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
		<div class="menu_nav" <?=$menu_bg_style?> >
        
		  <?=$menu?> 
		
        	</div>
		</div>
	</div>
	<!--EOF Header Area -->	
   <!--<div class="clear"> </div>-->
   
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
		
		
       <input type="hidden" disabled="disabled" id="786" value="temp">      
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
		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat; ";
	}
    $style =" style= "; 
    if($_SESSION["is_menu"]== 0)
                {
                    $strStyle .= ' width:auto;';
                    
                     $style .= ' width:auto;';
                }
	?>
			
			
			<div class="inner-content" style="<?=$strStyle?>">
			   
			   
			   <div class="welcomebox" <?=$style?>>
				<?=$content?>  
			   </div> 
			</div>
		</div>
	   <!--<div class="body_btm">&nbsp;</div> -->
       <br id="clearfix">
	</div>
	<div class="clear"> </div>   

	<div id="footer">
		<?php  $this->load->view('gymnastic/footer');  ?> 
	</div>
</div>
</div>
</body>
</html>
