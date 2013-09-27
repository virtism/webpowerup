<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
	@import "<?=base_url()?>css/bluemaster/css/reset.css";
	@import "<?=base_url()?>css/bluemaster/css/style.css";
</style><!--BlueMaster Template-->

	<script src="<?=base_url()?>css/bluemaster/png/png-fix.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/bluemaster/png/png.js" type="text/javascript"></script>

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
<meta name="Robots" content="index,follow" />

<title><?=$title?></title>

<?php
	//$page_header = 'Slideshow';
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
					fx: 'shuffle' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
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
<body style="<?=$strBodyStyle?>">
	<!--- Login-bar Starts Here--->
	<div id="login-bar">
  		<div class="login-bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td width="68%"><br />
			<ul>
			<?php	  
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
							$strLink = base_url().index_page().$other_top_navigation[$a]['link'];
						}
					
			?>
						<li><a  class="li_style"  href="<?=$strLink?>"><?=$other_top_navigation[$a]['title']?></a></li>   
			<?php   
					}
				}
				else
				{
					$other_top_navigation = '';
				}	
			?>
			
			
			</ul>
			</td>
			<td width="32%"><br />
				<div class="icons">
				<img src="<?=base_url()?>css/bluemaster/images/icon1.png" alt="" />
				<img src="<?=base_url()?>css/bluemaster/images/icon2.png" alt="" />
				<img src="<?=base_url()?>css/bluemaster/images/icon3.png" alt="" />
				<input type="text" onfocus="if (this.value == 'Search Keywords') {this.value=''}" onblur="if(this.value == '') { this.value='Search Keywords'}" value="Search Keywords" name="Search Keywords" class="search" />
				</div>  
			</td>
			</tr>
			</table>
  		</div>
	</div>
		<!--- Login-bar Ends Here--->

	<?php
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
	
<div id="container" style="<?=$background_color?>"><!--Main Outer container div of body starts Here-->
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
		<div id="wrapper">	<!--Start of a Main wrapper of a body-->
			
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
						$strStyle = 'style="background-color:#'.$header_background.'"';        
					} 
				}   
				?>
				
				<?php
				if($page_header=='Other')
				{
					?>
					<div id="header" <?=$css_header_id?>>
						<?=$logo?>
							<div id="menu">
								<ul>
									<?=$menu?>
								</ul><br clear="all" />
							</div>
					</div>
					<img src="<?=$header_image?>" style="width:960px;margin: auto;" />
				<?php       
				}
				else if($page_header=='Slideshow')
				{
					?> 
					<div id="header" <?=$css_header_id?>>
						<?=$logo?>
							<div id="menu">
								<ul>
									<?=$menu?>
								</ul><br clear="all" />
							</div>
					</div>
					<div class="clear" style="clear:both;"></div>
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
					<!--header-->
				<div id="header" <?=$css_header_id?>>
						<?=$logo?>
						<div id="menu">
							<ul>
								<?=$menu?>
							</ul><br clear="all" />
						</div>
				</div>
				<!--/header--><br clear="all" />
				<?php
				}
				?>
				
	 <div id="mid" style="<?=$strStyle?>">		 
			
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
					<div class="clear"> </div><!--Main slider starts at top of content--> 
						<div class="top_slider_div">
							 <?=$top_slider?><!--Main slider starts at top of content-->
						</div>
					<div class="clear"> </div>
			 <?
				}
			?>  
					<!---content-->	
			<div id="contents" style="<?=$strStyle?>">	
			
						<!--Main contents of the body will come here-->
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
		//		if(isset($left_menus) && sizeof($left_menus) == 0 )	// This statement runs in live view
				if(isset($sidebar) && strlen($sidebar) < 2 )	// This statement runs in local view
				{
					$strStyle .= ' width:890px;';           
					$style .= ' width:auto;';
				}
				
				?>
					<!--		If sidebar is not published its length is always 2 That is how we can make logic to expand the logic....-->
					<div class="left_col" style="<?=$strStyle?>">
						
						<div class="inner_pages" style="<?=$strStyle?>">
						
							<?=$content?> 
							<?php //echo "Page Uploaded..."; ?>
							<?php //echo sizeof($sidebar); ?>
							<?php //echo strlen($sidebar); ?>
					
						</div>
					
					</div>	
					
					<? 
		//			if(isset($sidebar) && sizeof($sidebar) > 0 )	// This statement runs in live view
					if(isset($sidebar) && strlen($sidebar) > 2 )	// This statement runs in local view
					{
					?> 
						<div class="right_col">
						<!--Side Bar wil come here-->
							<?=$sidebar?>
						</div>
					<? 
					}
					?>	
			  <!--content-->     
						<div class="clear" style="clear:both;"></div>
			
			</div>	<!--- Div Contents Ends Here--->
			</div>	<!--- Mid Div Ends Here--->

		</div>	<!--- Div Wrapper Ends Here--->
					
		<!--- HERE WAS FOOTER CONTENT CURRENTLY PLACED IN applications/views/bluemaster/footer.php --->
			<div id="footer_new">
				<div class="footer">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="footer_links">
				<tr>
					<td width="60%"><p><?=$footer?></p></td>
					<td width="40%">
						<div class="footer_menu">
							<ul>
								<?=$menu?>
							</ul><br clear="all" />
						</div>
					 </td>
				  </tr>
				</table>
				</div>
			</div>	<!--Foooter Ends Here-->

	</div>	<!--DIV Background Shine Ends Here-->

<!--Warpper-->
</div>
</body>
</html>