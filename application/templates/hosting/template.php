<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">

<style type="text/css">
	@import "<?=base_url()?>css/hosting/css/reset.css";
	@import "<?=base_url()?>css/hosting/css/layout.css";
	@import "<?=base_url()?>css/hosting/css/style.css";
</style><!--Hosting Template-->

	<script src="<?=base_url()?>css/hosting/js/maxheight.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/hosting/js/jquery-1.4.2.min.js" type="text/javascript"></script>
	<!--<script src="<?=base_url()?>css/hosting/js/cufon-yui.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/hosting/js/cufon-replace.js" type="text/javascript"></script>-->
	<script src="<?=base_url()?>css/hosting/js/Myriad_Pro_300.font.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/hosting/js/Myriad_Pro_400.font.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/hosting/js/jquery.faded.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/hosting/js/jquery.jqtransform.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/hosting/js/script.js" type="text/javascript"></script>

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

		<?php 
			$strBodyStyle = '';
			if($page_header=='Slideshow' || $page_header=='Other')
			{
				$strBodyStyle = 'style="background: none;"';
			} 
		?>
		
	<script type="text/javascript">
		$(function(){
			$("#faded").faded({
				speed: 500,
				crossfade: true,
				autoplay: 10000,
				autopagination:false
			});
			
			$('#domain-form').jqTransform({imgPath:'jqtransformplugin/img/'});
		});
	</script>
<!--[if lt IE 7]>
<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
<![endif]-->
<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
</head>		<!--Head Tag Ends Here-->
										
											<!--Page Body Starts Here-->
											<!--This is HTML5 Template-->
											
<body id="page1" style="<?=$strBodyStyle?>">

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
				//$menu_bg_style = 'style="background-color:#307D99;"';
			}	
		?>

<div class="tail-top3" style="<?=$strStyle?>">	<!--$strStyle Here will give Background to whole Page-->
												<!--All Content except Footer resides in this DIV-->
	<!-- header -->

	<header>	<!--Header Section Starts Here-->
		<div class="container">
			<span class="top-info">
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
							$strLink = base_url().index_page().$other_top_navigation[$a]['link'];
						}
					
						?>
						<li style="display:inline;"><a href="<?=$strLink?>"><?=$other_top_navigation[$a]['title']?></a></li>  |    
					<?php   
					}
				}
				else
				{
					$other_top_navigation = '';
				}	
				?>
			</span>
			
			<div class="header-box">
				<div class="left">
					<div class="right">
						<nav>
							<ul>
								<li class="current"><?=$menu?></li>
							</ul>
						</nav>
						<div id="logo" style="padding:10px 0 0 5px;"><?=$logo?></div>
					</div>
				</div>
			</div>
			
		</div>	<!--<div class="container" Ends Here-->
	</header> <!--Header Sections Ends Here-->
	
	<!-- content -->
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
	
	<section id="content_page" style="<?=$background_color?>">
		
		<div class="container" style="<?=$background_color?>">
		
			<div class="inside"> <!--Working As <div id="backgroundshine"> in Other templates i.e. Florist-->
														<!--All Content Comes Here Including Header-->
				<div id="slogan" class="bot-indent1" <?=$css_header_id?>> <!--Working As <div id="header"> in Other templates i.e. Florist-->
			
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
							<!--If we set an Image as Header, This condition will be true-->
					<?php
					if($page_header=='Other')	
					{
						?>
							<img src="<?=$header_image?>" style="width:960px;margin: auto;" />
						<?php       
					}
						?>
							<!--If we set a Slideshow as Header, This condition will be true-->
						<?php
					if($page_header=='Slideshow')
					{
						?> 
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
							<!--If we set a Nothing as Header, This condition will be true-->
						<?php
					if($page_header!='Slideshow' && $page_header!='Other')
					{
						?>
						<?php
					}
					?>
				</div>				
							
				<div class="inside1">
				
					<div class="wrap row-2" style="<?=$strStyle?>">	<!--$strStyle variable removed from here--><!--Acting as Mid DIV-->
						
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
						<!--This is Left Bar-->
						<div id="mux" style="<?=$strStyle?>">		
								
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
										$style =" style= "; 
							//		 // if both side menu is present
									if ( (isset($left_menus) && sizeof($left_menus) > 0 ) && (isset($right_menus) && sizeof($right_menus) > 0) ) 
									{
										$strStyle .= ' width:550px;';
									}
									else if ( (isset($left_menus) && sizeof($left_menus) > 0 ) || (isset($right_menus) && sizeof($right_menus) > 0) )
									{
										$strStyle .= ' width:770px;';
									}
									else
									{
										$strStyle .= ' width:980px;';
									}
								?>
								
								<!--This is Content DIV-->

								<?php
							
										if(isset($left_menus) && sizeof($left_menus) > 0 )
										{
										?> 
											<div class="col_left" style="float:left;" >
                                                <div class="side_bar">
                                                    <ul class="list1">
                                                        <?=$leftbar?>
                                                    </ul>
                                                </div>
                                            </div><!--Side Bars End here-->		
										<? 
										}
									?>
								<div class="col_right" style=" <?=$strStyle?>"> 	<!--Acting as div id="contents"-->
									<?php echo $content;?>
								</div>	<!--article class="col-2" Ends Here-->
                                
                                <?php
							
										if(isset($right_menus) && sizeof($right_menus) > 0 )
										{
										?> 
											<div class="col_left" style="float:right;" >
                                                <div class="side_bar">
                                                 <ul class="list1">
                                                    <?=$rightbar?>
                                                    </ul>
                                                </div>
                                            </div><!--Side Bars End here-->		
										<? 
										}
									?>
		
								<div class="clear"></div>
							
						</div>	<!--<div id="mux" Ends Here-->		
						
					</div>	<!--div class="wrap row-2" Ends Here-->
				
				</div>	<!--div class="inside1" Ends Here-->
			
			</div>	<!--div class="inside" Ends Here--> <!--All Content Comes Here-->
			
		</div>	<!--div class="container" Ends Here-->

	</section>

</div>

<!-- footer -->		<div class="clear" style="clear:both;"></div>

<footer>
	<div class="container">
		<div id="footer_wrapper" style="min-height:50px; padding:10px 0 10px 0;">
			<div id="footer_text" style="margin:0 auto; float:left; width:500px;">
				<?=$footer?>
			</div>
			<div id="footer_menu" style="margin:0 auto; float:left; width:400px;">
				<ul><li class="no_bg" style=" display:inline;"><?php //echo $menu; ?></li></ul>	
			</div>
		</div>		
	</div>
</footer>

<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>