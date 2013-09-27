<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title.'	i am working here'?></title>
<?=$_scripts?>
<?=$_styles?>
<style type="text/css">
	@import "<?=base_url()?>css/mashup/reset.css";
	@import "<?=base_url()?>css/mashup/style.css";
</style>
<script src="<?=base_url()?>css/mashup/png-fix.js" type="text/javascript"></script>
<script src="<?=base_url()?>css/mashup/png.js" type="text/javascript"></script>
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
	// echo $strBodyStyle; exit; 
?>
<body <?=$strBodyStyle?>>
<div id="login-bar" style="background:#000; width:100%">
  <div class="login-bar">
    <ul>
      <li><a href="#">Login</a></li>
      <li><a href="#">Register</a></li>
      <li><a href="#">Logout</a></li>
    </ul>
  </div>
</div>
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
<div id="container" <?=$background_color?>>
<?php
	if(!isset($background_image))
	{
		$background_image = '';    
	}
	$strStyle = "";
	if($background_image!="" && $background_area=='page' && $background_style=='stretch')
	{
		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat  background-position:center top;";
	}
	else if($background_image!="" && $background_area=='page' && $background_style=='tile')
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
  <div id="backgroundshine" style="<?=$strStyle?>">
	<div id="wrapper">
		 <br><br> 
<?php
		$strStyle = '';
		if($page_header=='Other' || $page_header=='Slideshow' && $header_background!='Default')
		{
			//$strBackgroundColor = '#'.$header_background;
			if($header_background == 'Image')
			{
				$strStyle = 'style="background-image:url('."'".$header_background_image."'".'); background-repeat: repeat; background-position: center top;"';
			}   
			else
			{
				$strStyle = 'style=" padding-top: 11px; background-color:#'.$header_background.'"';        
			} 
		}   

		if($page_header=='Other')
		{
?>     
			<div class="topinfonlogo" <?=$strStyle?>>
					<img src="<?=$header_image?>" style="height:198px; width:100%; margin: auto;" /> 
			</div>    
<?php  } else if($page_header=='Slideshow'){ ?> 
			<div class="slideshow">
<?php  foreach($header_image->result_array() as $rowImage) { ?>
			<img style="height:198px; width:100%; margin: auto; padding-top: 11px;"  src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />  
<?php }  ?>
			</div>
<?php }if($menu_bg_style==""){
				
				$menu_bg_style .= 'style=" background:#FFF;"';
				} ?>
				
			<div id="<?=$css_header_id?>" <?=$menu_bg_style?>>
				<!--Div Menu Starts Here-->
				<div id="menu">
					<ul>
						<?=$menu?>
					</ul>
					<br clear="all" />
				</div><!--DIV MENU Ends Here-->
		   
				<input type="hidden" disabled="disabled" id="786" value="temp">  

				 <div class="logo" <?=$strStyle?>>
					<?=$logo?>
				 </div>
				 <!--Closing the Logo div here-->  
				 <br clear="all" />	
		
			</div><!--closing the header code here -->	
			<!--content Starts Here-->
<div id="mid">			
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
			
			<div id="content2" style="<?=$strStyle?>">
			
					
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
			<div class="col-1">
				<div class="side_bar">
					<?=$sidebar?>
				</div>
			</div>
			<!--Side Bars End here-->
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
				$strStyle .= ' width:896px; padding: 10px 0px 0px 5px;';
				$style .= ' width:auto;';
			}
?>
	
			<div class="col2" style=" <?=$strStyle?>">				
				<?=$content?>
			</div>
			<div class="clear"></div>
			</div><!--Content get End Here-->
	</div><!--Mid div Ends Here requuired tom move the slider freely-->
		</div>
		<!--Main Wrapper of the body ends here-->
       <div id="footer">
	   <!--footer starts here-->
	   	 <div class="footer">
			<p> <?=$footer?> </p>
	  	 </div>
		</div>
		<!--Footer Ends here-->		
	</div>
   <!--backgroundshine div getting close here-->
 </div>
 <!--Main outer container div after the body is closing here-->
</body>
</html>
