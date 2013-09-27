<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <style type="text/css">
	@import "<?php echo base_url()?>css/carclub/reset.css";
	@import "<?php echo base_url()?>css/carclub/style.css";
  </style><!--Car Club-->
   <script src="<?php echo base_url()?>css/carclub/png-fix.js" type="text/javascript"></script>
   <script src="<?php echo base_url()?>css/carclub/png.js" type="text/javascript"></script>
   <!--<script src="<?php echo base_url()?>jquery/jquery.cycle.all.min" type="text/javascript"></script>-->
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
				$strLink = base_url().$other_top_navigation[$a]['link'].'/';
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
//Code to Prefill BG color after image end
	if(isset($color_after_image) && $background_area == "page" )
	{
		$background_color = 'style="background-color : #'.$color_after_image.';"';
	}
	else
	{
		$background_color = 'style="background-color : black;"';
	}
//echo $background_color;
?>
<div id="container" <?=$background_color?>>
  <!--Main outer container div starts here to control the color after image at background-->
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
	
	if($strStyle  != "")
	{
		$css_header_id = "header_area_bg";
		$menu_bg_style = 'style="background-color:#307D99;"';
	}
		
?>
<div id="backgroundshine" style="<?=$strStyle?>"> 
 <div id="wrapper">
  <!--header-->
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
			<img src="<?=$header_image?>" style="width:960px;margin: auto;" /> 
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
			
			<img style="width:960px; height:125px; margin: auto; padding-top: 11px;"  src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />  
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
			<?=$logo?>  
		</div>
	</div>
<?php
	}
?>    
			<div class="clear"> </div>
    	<div id="menu" <?=$menu_bg_style?>><!--main menus above the side bar and content area-->
      			<ul>
	    		<?=$menu?>
      			</ul>
      		<br clear="all" />
    	</div>
	</div>
	<!--End of a top div here-->
  </div>
  <!--Header Div Ends Here-->
  		<!--Mid dive starts-->
  	<div id="mid">
  <!--Banner--> 	
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
    if(isset($main_slideshows))
	{  
?>      
        <div class="clear"> </div> 
        <div class="top_slider_div">
             <?=$top_slider?>
        </div>
        <!--<div class="clear"> </div>-->
<?php
	}
?>       
  <div id="banner" style=" <?=$strStyle?> ">
    <!-- Main content areas to come here contents -->
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
	$padding=" style= ";
    $style =" style= "; 
    if(isset($left_menus) && sizeof($left_menus) == 0 )
                {
                    $strStyle .= ' width:995px;';
                    
                     $style .= ' width:auto;';
					 
					 $padding.= 'padding:0px !important;'; 
                }
?>
    <div class="left_banner" style="<?=$strStyle?>">
	   		<?=$content?>	
	</div>
	 <!--Content area ends here-->
	 
	 
<? 
  	if(isset($left_menus) && sizeof($left_menus) > 0 )
	{
?>		 
    <div  <?=$padding?>>
		<?//=$sidebar?>
     	<?=$leftbar?>			
    </div>
	
<?
	}	
?>
<br clear="all" />
  </div>
  <!--End of a  Banner-->
  <br clear="all" />
  	</div>
  	<!--End of a Mid div Here-->
  <!--content-->
  <br clear="all" />
  <br clear="all" />
   
  <!--/content-->
  <!--Foooter-->
  <div class="footer"><!--Main footer of the car club come here-->
     <?=$footer?>
  </div>
  <!--Foooter Ends-->
 </div>
<!--Warpper Ends-->
</div>
<!--Main backshine div Ends Here-->
</div>
<!--Main outer container div Ends Here-->
</body>
</html>
