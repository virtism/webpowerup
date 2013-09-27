<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
	@import "<?=base_url()?>css/castleton/reset.css";	
	@import "<?=base_url()?>css/castleton/style.css";
</style>
	<script src="<?=base_url()?>css/castleton/png-fix.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/castleton/png.js" type="text/javascript"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=$_scripts?><!--Castleton Template-->
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
	<div id="login-bar">
	  <div class="login-bar">
		<ul>
<?	  
	//This is For Top Navigation Reg Form/Shop/Help Center/Login/logout
	if(!empty($other_top_navigation) || count ($other_top_navigation) > 0 )
	{
		for($a=0; $a<count($other_top_navigation); $a++)
		{
			if($mode=='edit')
			{
				$strLink = 'javascript: void(0);';    
			}
			else
			{
				$strLink = base_url().index_page().$other_top_navigation[$a]['link'].'/';
			}
		
			?>
			<li>
			<a  class="li_style"  href="<?=$strLink?>"><?=$other_top_navigation[$a]['title']?></a>
			</li>   
		<?php   
		}
	}
	else
	{
		$other_top_navigation = '';
	}	
?>

		</ul>
	  </div>
	</div>
<?
		/*****Code to Prefill BG color after image end*****/
	if(isset($color_after_image) && $background_area == "page" )
	{
		$background_color = 'style="background-color : #'.$color_after_image.';"';
	}
	else
	{
		$background_color = 'style="background-color : white;"';
	}
?>
<div id="container" <?=$background_color?>><!--Main Outer container div of body starts Here-->
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
	else if ($background_image!="" && $background_area=='both' && $background_style=='stretch')
	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}
	else if($background_image!="" && $background_area=='both' && $background_style=='tile')

	{

		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";

	}
		//Color Control For Header Area and menu BG	
		$css_header_id = "header_area";
		$menu_bg_style = "";
	
	if($strStyle  != "")
	{
		$css_header_id = "header_area_bg";
		$menu_bg_style = 'style="background-color:#307D99;"';
	}	
?>
	<div id="backgroundshine" style="<?=$strStyle?>" ><!--Inner Backgroundshine div starts Here-->
		<div id="wrapper">
		  <div id="header <?=$css_header_id?>"><!--header-->
		   <div id="top"><!--Top div required to use for the header backgrougd color, image, slider, Logo, menu bg color-->
<?php
		$strStyle = '';
if($page_header=='Other' || $page_header=='Slideshow' && $header_background!='Default')
{
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
		<div class="topinfonlogo" <?=$strStyle?>><!--Header Image div starts here-->
				<img src="<?=$header_image?>" style="width:960px;margin: auto;" /> 
		</div><!--Header Image div Ends here-->
<?php       
	}
	else if($page_header=='Slideshow')
	{
?> 
		<script type="text/javascript">
$(document).ready(function() {
	$('.slideshow').cycle({
		fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});
</script>
		<div class="slideshow" ><!--Header slider Begins Here-->
<?php 
	foreach($header_image->result_array() as $rowImage)
	{
?>
	  <img style="width:960px; height:125px; margin: auto; padding-top: 11px;"  src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" /> <?php
	}
?>
		</div><!--Header slider Ends Here-->
		
<?php
	}
?> 
<?php
	if($page_header!='Slideshow' && $page_header!='Other')
	{
?>
		<div class="topinfonlogo" <?=$strStyle?>><!--Div to display a logo starts here-->
			<div id="logo">
			   <?=$logo?>  
			</div>
		</div><!--Div to display a logo Ends here-->
<?php
	}
?> 
<!--      	   
   <div class="right_content_he" style="border: 1px solid #99FF66;">
		<p style=" color: #060606;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 30px;
	margin: 67px 9px 0 0;">888.888.5555</p>
		</div>
		-->
		<br clear="all" />
	<div id="menu" <?=$menu_bg_style?>><!--Menu div Starts Here-->
	  <ul>
		<?=$menu?>
	  </ul>
	  
	  <input type="text" value="Search Site" class="search" />
	  <br clear="all" />
	  </div><!--Menu div Ends Here-->
	</div><!--Top header div get ends here-->
  </div><!--/header-->
<?php
		$strStyle = "";
	if($background_image!="" && $background_area=='menu with content' && $background_style=='stretch')
	{
		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat;"; 
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
			<div class="top_slider_div">
				 <?=$top_slider?><!--Main slider starts at top of content-->
			</div>
 <?
	}
?>        
  <div id="contents" style="<?=$strStyle?>"><!--content-->
<? 
	if(isset($left_menus) && sizeof($left_menus) > 0 )
	{
?>		
		<div class="col_left"> 
		  <?//=$sidebar?>
		  <?=$leftbar?>
		 </div>
<?
	}
?>
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
	else if($background_image!="" && $background_area=='both' && $background_style=='stretch')
	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}
	else if($background_image!="" && $background_area=='both' && $background_style=='tile')

	{

		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat; ";

	}
		$style =" style= "; 
	if(isset($left_menus) && sizeof($left_menus) == 0 )
	{
		$strStyle .= ' width:952px;';           
		$style .= ' width:auto;';
	}
?>
		 
		<div id="contents" style="<?=$strStyle?>">
		  <?=$content?>
		</div>
		 
 
  
  

<div class="clear"></div>
  </div>
</div>

  <!--Foooter-->
  <div id="footer">
	<div class="footer">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		 <tr>
			 <td width="46%"><?=$footer?></td>
			 <td width="54%">
	 <div class="footer_menu active">
		<ul>
			<?php // echo $menu; ?>
		</ul>
	</div>
		   </td>
		  </tr>
		</table>
	 </div>
	</div>
  <!--Foooter-->


 <!--Warpper-->
  </div><!--backgroundshine ends Here-->
 </div><!--Main Outer div gets end here-->
</body>
</html>
