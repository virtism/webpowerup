<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title?></title><!--Comunity Template-->
<style type="text/css">
@import "<?php echo base_url()?>css/comunity/reset.css";
@import "<?php echo base_url()?>css/comunity/style.css";
</style>
<script src="<?php echo base_url()?>css/comunity/png-fix.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>css/comunity/png.js" type="text/javascript"></script>
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
	$strBodyStyle = 'style="background-color:#FFFFFF;"';
	} 
?>
<body <?=$strBodyStyle?>>
<div id="login-bar">
  <div class="login-bar">
    <ul>
<?	  
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
	if(isset($color_after_image) && $background_area == "page" )
	{
		$background_color = 'style="background-color : #'.$color_after_image.';"';
	}
	else
	{
		$background_color = 'style="background-color : white;"';
	}
?>
<!--Main Container div starts here closing in the end of before body-->
	<div id="container" <?=$background_color?>>

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

	$css_header_id = "header_area";
	$menu_bg_style = "";
	
	if($strStyle  != "")
	{
		$css_header_id = "header_area_bg";
		//$menu_bg_style = 'style="background-color:#307D99;"';
	}
?>
		<div id="backgroundshine" style="<?=$strStyle?>" >
		<br /><br />
			<div id="wrapper" >
				<div id="<?=$css_header_id?>">
				<img src="<?=base_url()?>css/comunity/images/service_time.png" alt="" class="services" style="float:right;  margin: -30px 0 0;" />
				<a href="#"><img style="float:right; margin: 42px -162px 0 0;" class="services" alt="" src="<?=base_url()?>css/comunity/images/icons.png" /></a>

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
	if($page_header!='Slideshow' && $page_header!='Other')
	{
	?>
			<div id="logo" <?=$strStyle?>>
				<?=$logo?>  
			</div>
		  
<?php
	}else{
?>  

			<div id="logo" <?=$strStyle?>>
				<?=$logo?>  
			</div>
		  
<?php }?>
	

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
					<img style="width:1000px; height:250px; margin: auto; padding-top: 11px;"  src="<?=base_url()?>headers/<?=$rowImage["header_image"]?>" />  
		   <?php
				}
		   ?>
					</div>
					
		
 <?php
}
?>  
		  <div id="menu" <?=$menu_bg_style?>>

             <ul class="lefr">
        
                <li><?=$menu?></li>
        
             </ul>
        
            <!--Munu div Ends Here-->      
    
            <br clear="all" />

   		</div>
		 <!--Header to ends Here-->
	</div>
  <!--content-->
  	<?php
    if(isset($main_slideshows) )
{
    
?>      
        <div class="clear"> </div> 
			<div class="slider">
				 <?=$top_slider?>
			</div>
        <!--<div class="clear"> </div>-->
 <?
}
?> 		
   <?php
	$strStyle = "";
	/*echo $background_area."<br/>";
	echo $background_style;
	exit();*/
	if($background_image!="" && $background_area=='menu with content' && $background_style=='stretch')
	{
		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";  
		
	}
	else if($background_image!="" && $background_area=='menu with content' && $background_style=='tile')
	{
		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";
	}
	?>
	<div class="top_area" style=" <?=$strStyle?>">        
	<div id="contents" style=" <?=$strStyle?>">
  			
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
	else if ($background_image!="" && $background_area=='both' && $background_style=='stretch')
	{

		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat";    

	}
	else if($background_image!="" && $background_area=='both' && $background_style=='tile')

	{

		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat;";

	}
   
?>
<div class="col_left"><!--Main contents of the body will come here-->
<?=$content?>


</div><!--Main content Div Get Ends Here-->

<?
if(isset($left_menus) && sizeof($left_menus) > 0 )
{
?>
<div class="col_right"><!--Side Bar wil come here-->
<?=$leftbar?>
</div><!--/content-->
<?
}
?>
	 	  
	 		 	  
		 </div><!--Top-area to end Here-->
			<br clear="all" />
	</div> <!--content div Ends here-->
			<br clear="all" />		
			<br clear="all" />
			</div>
			<!--Main Wrapper Div Ends Here-->
		</div>
		<!--Closing the above shinebackground Div Here-->
	</div>
	<!--Closing the main container div here-->
	 <div class="footer"><!--Footer Div Starts Here-->
	    <div id="footer">
    		<?=$footer?> 
		   	 <div>
				<ul>
				   <?php //echo $menu; ?>
				</ul>
 			 </div>
  	  </div>
   </div><!--Footer Div Ends Here-->
</body>
</html>