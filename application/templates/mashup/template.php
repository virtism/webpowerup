<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="<?=base_url()?>js/jquery.min.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title?></title>
<?=$_scripts?><!--Mashup Template-->
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
				
				
				
			}); // ready end
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
<?	  
	//This is For Top Navigation Reg Form/Shop/Help Center/Login/logout
	//echo '<pre>';print_r($other_top_navigation);
    
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
				$strLink = base_url().index_page().$other_top_navigation[$a]['link'];
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
     <div style="float:left" class="logo">
					<?=$logo?>
				 </div>
				 <!--Closing the Logo div here-->  
				 
		<?php
		//echo $header_image;die();
		$strStyle = '';
		if($page_header=='Other' || $page_header=='Slideshow' && $header_background!='Default')
		{
			//$strBackgroundColor = '#'.$header_background;
			if($header_background == 'Image')
			{
				$strStyle = 'style="background-image:url('."'".base_url().'media/ckeditor_uploads/'.$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id'].'/images/headers_background/'.$header_background_image."'".'); background-repeat: repeat; background-position: center top;"';
			}   
			else
			{
				$strStyle = 'style=" padding-top: 0px; background-color:#'.$header_background.'"';        
			} 
		}   
		if($page_header=='Other')
		{
?>     
			<div class="topinfonlogo" <?=$strStyle?>>
					<img src="<?=base_url()?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/images/headers/<?=$header_image?>" style="height:198px; width:100%; margin: auto;" /> 
			</div>    
<?php  } 
		else if($page_header=='Slideshow'){ ?> 
			<div class="slideshow">
				<?php  foreach($header_image->result_array() as $rowImage) { ?>
                    <img style="height:198px; width:100%; margin: auto; padding-top: 11px;" src="<?=base_url()?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/images/headers/<?=$rowImage["header_image"]?>" />  
                <?php }  ?>
			</div>
				<?php } ?>
                
		<?php
        if(isset($main_slideshows)) //We are starting the slider patches here ,While other come from file "all common/content"
        {	
        ?>      
        <div class="clear"> </div> 
                <div class="top_slider_div">
                    <?=$top_slider?>
                </div> 
        <div class="clear"> </div>
        <?php 
        } ?>        
		<?php		
		if($menu_bg_style=="")
		{
		
		$menu_bg_style .= 'style=" background:#FFF;"';
		} 
		$menu_bg_full = '';
		if(isset($color_scheme['primary_color']) && $color_scheme['default'] == "Custome"){ 
		
		$menu_bg_full = 'style=" background:#'.$color_scheme['primary_color'].';"';
		} 
		
		?>
				
			<div id="<?=$css_header_id?>" <?=$menu_bg_style?> >
				<!--Div Menu Starts Here-->
				<div id="menu"  <?=$menu_bg_full?> >
					<ul>
						<?=$menu?>
					</ul>
					<br clear="all" />
				</div><!--DIV MENU Ends Here-->
		   
				<input type="hidden" disabled="disabled" id="786" value="temp">  
				
		
			</div><!--closing the header code here -->	
			<!--content Starts Here-->
<div id="mid">			
<?php
	//echo "<br />";
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
	
	
	//If Left menu 0 Expand Content Area
	//echo sizeof($left_menus);exit;
	
	///		Left Side 		///
	if( (isset($left_menus) && sizeof($left_menus) > 0) || ( isset($left_menus_Pbox) && sizeof($left_menus_Pbox) > 0) )
	{ ?>      			
				<div class="col-1">
					<div class="side_bar">
						<?=$leftbar?>
					</div>
				</div><!--Side Bars End here-->			
	<?php
	} 
	///		Left Side 		///  
	
	
			
		$strStyle = "";
	if($background_image!="" && $background_area=='content' && $background_style=='stretch')
	{
		$strStyle = "background-image:url('".$background_image."'); background-size: 100%; background-repeat: no-repeat"; 
	}
	else if($background_image!="" && $background_area=='content' && $background_style=='tile')
	{
		$strStyle = "background-image:url('".$background_image."'); background-repeat:repeat; ";
	}
	
	/*$style =" style= "; 
	if(isset($left_menus) && sizeof($left_menus) == 0 )// && sizeof($left_menus)==0 )// || isset($_SESSION["$left_menus"])== 0 )
	{
		$strStyle .= ' width:882px; padding: 10px 0px 0px 5px;';
		$style .= ' width:auto;';
	}*/
	/*
	if(!empty($right_menus_Pbox))
	{
		$right_menus = $right_menus_Pbox;
	}*/
	/*
	if(!empty($left_menus_Pbox))
	{
		$left_menus = $left_menus_Pbox;
	}
	*/
	
	
	if ( (isset($left_menus) && sizeof($left_menus) > 0 ) && (isset($right_menus) && sizeof($right_menus) > 0)) // if both side menu is present
	{
		$strStyle .= ' width:543px;';
	}
	else if( ( isset($left_menus_Pbox) && sizeof($left_menus_Pbox) > 0) && ( isset($right_menus_Pbox) && sizeof($right_menus_Pbox) > 0) ) // if both side promotional box is present
	{
		$strStyle .= ' width:543px;';
	}
	else if ( ((isset($left_menus) && sizeof($left_menus) > 0) && (isset($right_menus_Pbox) && sizeof($right_menus_Pbox) > 0)) || ( (isset($right_menus) && sizeof($right_menus) > 0) && (isset($left_menus_Pbox) && sizeof($left_menus_Pbox) > 0) ) ) // if one side menu and one side promotional box is present
	{
		$strStyle .= ' width:543px;';
	}
	
	
	else if ( (isset($left_menus) && sizeof($left_menus) > 0 ) || (isset($right_menus) && sizeof($right_menus) > 0) || ( isset($left_menus_Pbox) && sizeof($left_menus_Pbox) > 0) || ( isset($right_menus_Pbox) && sizeof($right_menus_Pbox) > 0) )
	{
		$strStyle .= ' width:620px;';
	}
	else
	{
		$strStyle .= ' width:882px; padding: 10px 0px 0px 0px;';		
	}
	
	

			
			// When right bar is enabled then CSS wset as
			$right_set = '';
		 	if(isset($right_menus) && sizeof($right_menus) > 0 )
            {
            	$right_set = 'overflow: hidden;';
				?>
				<style>
					#ccleft
					{
						width:290px !important;
																		
					}
				
				</style>
				
				<?
			
			}			
     	
            ?>
            
			<!-- <	MIDDLE CONTAINER >	-->
			<div style="padding-bottom:50px; <? if($strStyle=='') { echo "width: auto !important;";} else{echo $strStyle;}?>  <?=$right_set?> " class="col2">
				<?=$content?>
			</div>
            
            
			<?php 
            ///		Right Side 		///
            if( ( isset($right_menus) && sizeof($right_menus) > 0 ) || ( isset($right_menus_Pbox) && sizeof($right_menus_Pbox) > 0) )
            {
            
                ?>		
            
                   
            
                  <div class="col_1" style="float:right;"><!--Side Bar wil come here-->
            
                        <div class="side_bar">
            
                            <?=$rightbar?>
            
                        </div>
            
                   </div><!--/content-->
            
            <?php 
            }
            ///		Right Menu End 	/// 
            ?>
			<div class="clear"></div>
            
		 </div><!--Content get End Here-->
         
		
	   </div><!--Mid div Ends Here requuired tom move the slider freely-->
		</div><!--Main Wrapper of the body ends here-->
		<div class="clear"></div>
	   	
       
       <div id="footer" ><!--footer starts here-->
       
        <div class="footer">
			<?=$footer?> 
		 </div>
	   </div><!--Footer Ends here-->
       		
	 </div><!--backgroundshine div getting close here-->
   </div><!--Main outer container div after the body is closing here-->
</body>
</html>