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
	<script src="<?=base_url()?>css/hosting/js/cufon-yui.js" type="text/javascript"></script>
	<script src="<?=base_url()?>css/hosting/js/cufon-replace.js" type="text/javascript"></script>
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
											
<body id="page4" style="<?=$strBodyStyle?>" onLoad="new ElementMaxHeight();">

<div class="tail-top3">

	<!-- header -->

	<header>	<!--Header Section Starts Here-->
		<div class="container">
			<div class="header-box">
				<div class="left">
					<div class="right">
						<nav>
							<ul>
								<li class="current"><?=$menu?></li>
							</ul>
						</nav>
						<div id="logo" style="padding:10px 0 0 20px;"><?=$logo?></div>
					</div>
				</div>
			</div>
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
			
			<form action="" id="login-form">
				<fieldset>
					<span class="text">
						<input type="text" value="Username" onFocus="if(this.value=='Username'){this.value=''}" onBlur="if(this.value==''){this.value='Username'}">
					</span>
					<span class="text">
						<input type="password" value="Password" onFocus="if(this.value=='Password'){this.value=''}" onBlur="if(this.value==''){this.value='Password'}">
					</span>
					<a href="#" class="login" onClick="document.getElementById('login-form').submit()"><span><span>Login</span></span></a>
					<span class="links"><a href="#">Forgot Password?</a><br/><a href="#">Register</a></span>
				</fieldset>
			</form>
		</div>
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
	
	
	<section id="content"><!--<div class="ic">More Website Templates at TemplateMonster.com!</div>-->
		
		<div class="container" style="<?=$background_color?>">
		
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
		
			<div class="inside" style="<?=$strStyle?>"> <!--Working As <div id="backgroundshine"> in Other templates i.e. Florist-->
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
							<img src="<?=base_url()?>css/hosting/images/slogan-bg.jpg" alt="" />
						<?php
					}
					?>
				 <!--This is the DIV from where Header-Images comes(Image defined in style.css) -->
					<!--<div class="inside">
						<h2><span>Your Domain Name</span> Helps the World  to Find You</h2>
						<p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.</p>
					</div>-->
				</div>
				<ul class="banners wrapper">
					<li><a href="#">Basic  &nbsp; <b>$9.95</b></a></li>
					<li><a href="#">Economy  &nbsp; <b>$14.95</b></a></li>
					<li><a href="#">Deluxe  &nbsp; <b>$19.95</b></a></li>
					<li><a href="#">Unlimited  &nbsp; <b>$24.95</b></a></li>
				</ul>
				
				<!--<div class="wrapper row-1">
					<div class="box col-1 maxheight">
						<div class="border-right maxheight">
							<div class="border-bot maxheight">
								<div class="border-left maxheight">
									<div class="left-top-corner maxheight">
										<div class="right-top-corner maxheight">
											<div class="right-bot-corner maxheight">
												<div class="left-bot-corner maxheight">
													<div class="inner">
														<h3>Basic Plan</h3>
														<ul class="info-list">
															<li><span>Disk space</span>300 Gb</li>
															<li><span>Monthly transfer</span>3000 Gb</li>
															<li><span>FTP accounts</span>25</li>
															<li><span>Email boxes</span>1000</li>
															<li><span>Free domains</span>1</li>
														</ul>
														<span class="price">$ 9.95 p/m</span>
														<div class="aligncenter"><a href="#" class="link1"><span><span>Learn More</span></span></a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box col-2 maxheight">
						<div class="border-right maxheight">
							<div class="border-bot maxheight">
								<div class="border-left maxheight">
									<div class="left-top-corner maxheight">
										<div class="right-top-corner maxheight">
											<div class="right-bot-corner maxheight">
												<div class="left-bot-corner maxheight">
													<div class="inner">
														<h3>Economy Plan</h3>
														<ul class="info-list">
															<li><span>Disk space</span>500 Gb</li>
															<li><span>Monthly transfer</span>5000 Gb</li>
															<li><span>FTP accounts</span>50</li>
															<li><span>Email boxes</span>2500</li>
															<li><span>Free domains</span>2</li>
														</ul>
														<span class="price">$ 14.95 p/m</span>
														<div class="aligncenter"><a href="#" class="link1"><span><span>Learn More</span></span></a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box col-3 maxheight">
						<div class="border-right maxheight">
							<div class="border-bot maxheight">
								<div class="border-left maxheight">
									<div class="left-top-corner maxheight">
										<div class="right-top-corner maxheight">
											<div class="right-bot-corner maxheight">
												<div class="left-bot-corner maxheight">
													<div class="inner">
														<h3>Deluxe Plan</h3>
														<ul class="info-list">
															<li><span>Disk space</span>800 Gb</li>
															<li><span>Monthly transfer</span>8000 Gb</li>
															<li><span>FTP accounts</span>70</li>
															<li><span>Email boxes</span>3000</li>
															<li><span>Free domains</span>3</li>
														</ul>
														<span class="price">$ 19.95 p/m</span>
														<div class="aligncenter"><a href="#" class="link1"><span><span>Learn More</span></span></a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box col-4 maxheight">
						<div class="border-right maxheight">
							<div class="border-bot maxheight">
								<div class="border-left maxheight">
									<div class="left-top-corner maxheight">
										<div class="right-top-corner maxheight">
											<div class="right-bot-corner maxheight">
												<div class="left-bot-corner maxheight">
													<div class="inner">
														<h3>Unlimited Plan</h3>
														<ul class="info-list">
															<li><span>Disk space</span>Unlimited</li>
															<li><span>Monthly transfer</span>Unlimited</li>
															<li><span>FTP accounts</span>Unlimited</li>
															<li><span>Email boxes</span>Unlimited</li>
															<li><span>Free domains</span>Unlimited</li>
														</ul>
														<span class="price">$ 24.95 p/m</span>
														<div class="aligncenter"><a href="#" class="link1"><span><span>Learn More</span></span></a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>-->
				
				<div class="inside1" style="<?=$strStyle?>">
				
					<div class="wrap row-2" style="<?=$strStyle?>">	<!--Acting as Mid DIV-->
						
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
						
						<article class="col-1">
							<? 
					//		if(isset($left_menus) && sizeof($left_menus) > 0 )
					//		{
					//			if(isset($sidebar) && sizeof($sidebar) > 0 )
					//			{
								?> 
									<?php //echo $left_menus; ?>
									<h2>Solutions</h2>
									<ul class="solutions">
										<li><img src="images/icon1.gif">
											<p>Quickly and easily create a Web Page</p>
											<a href="#"><b>Read More</b></a></li>
										<li><img src="images/icon2.gif">
											<p>Share documents any time, any where</p>
											<a href="#"><b>Read More</b></a></li>
										<li><img src="images/icon3.gif">
											<p>24/7 Real Person Customer Support</p>
											<a href="#"><b>Read More</b></a></li>
										<li><img src="images/icon4.gif">
											<p>Online Account Management Tools</p>
											<a href="#"><b>Read More</b></a></li>
									</ul>
									<? 
						//		}
									?>	
									<?php //echo $leftbar; ?> 
								<? 
						//	}
							?>		
						</article>
						
						<!--This is Content DIV-->
						
						<article class="col-2" style="<?=$strStyle?>"> 	<!--Acting as div id="contents"-->
						
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
							if(isset($left_menus) && sizeof($left_menus) == 0 )
							{
								$strStyle .= ' width:824px;';           
								$style .= ' width:auto;';
							}
						?>
							<h2>Ideal Solutions</h2>
							<div class="img-box"><img src="images/4page-img.jpg">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloreque laudantium, totam rem aperiam, eaque ipsa quae.</div>
							<p>Lnventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem eaque ipsa quae sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
							<p class="p1">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur vero eos et accusamus et iusto.</p>
							<a href="#" class="link2"><span><span>Read More</span></span></a> 
									<? //echo $content; ?>
							
						</article>	<!--article class="col-2" Ends Here-->
							
						<!--This is Right Bar-->
							
						<article class="col-3">
							<h2>Showcase</h2>
							<ul class="list1">
								<li><a href="#">Sed ut perspiciatis unde</a></li>
								<li><a href="#">Omnis iste natus error sit volupta</a></li>
								<li><a href="#">Tem accusantium doloreque</a></li>
								<li><a href="#">Laudantiumtotam rem aperiam</a></li>
								<li><a href="#">Eaque ipsa quae</a></li>
								<li><a href="#">Lnventore veritatis et quasi</a></li>
								<li><a href="#">Architecto beatae vitae</a></li>
								<li><a href="#">Dicta sunt explicabo</a></li>
								<li><a href="#">Nemo enim ipsam voluptatem</a></li>
								<li><a href="#">Quia voluptas sit aspernatur</a></li>
								<li><a href="#">Aut odit aut fugit, sed quia</a></li>
								<li><a href="#">Consequuntur magni</a></li>
							</ul>
							<a href="#" class="link2"><span><span>More Solutions</span></span></a> </article>
							
						<div class="clear"></div>
						
					</div>	<!--div class="wrap row-2" Ends Here-->
				
				</div>	<!--div class="inside1" Ends Here-->
			
			</div>	<!--div class="inside" Ends Here--> <!--All Content Comes Here-->
			
		</div>	<!--div class="container" Ends Here-->

	</section>

</div>

<!-- aside Starts Here-->	<!-- Content Above Footer Comes Here-->

<aside>
	<div class="container">
		<div class="inside">
			<div class="line-ver1">
				<div class="line-ver2">
					<div class="line-ver3">
						<div class="wrapper line-ver4">
							<ul class="list col-1">
								<li>Account Manager</li>
								<li><a href="#">My Account</a></li>
								<li><a href="#">My Renewals</a></li>
								<li><a href="#">My Upgrades</a></li>
								<li><a href="#">Account Settings</a></li>
								<li><a href="#">Customer Information</a></li>
								<li><a href="#">Order History</a></li>
							</ul>
							<ul class="list col-2">
								<li>Shopping</li>
								<li><a href="#">Offer Disclaimers</a></li>
								<li><a href="#">Domain Search</a></li>
								<li><a href="#">Product Catalog</a></li>
								<li><a href="#">Producr Advisor</a></li>
								<li><a href="#">Gift Cards</a></li>
								<li><a href="#">Mobile</a></li>
							</ul>
							<ul class="list col-3">
								<li>Resources</li>
								<li><a href="#">Webmail</a></li>
								<li><a href="#">WHOIS search</a></li>
								<li><a href="#">ICANN Confirmation</a></li>
								<li><a href="#">Affiliates</a></li>
								<li><a href="#">Connect with Us</a></li>
								<li><a href="#">Gadgets / Widgets</a></li>
							</ul>
							<ul class="list col-4">
								<li>Help and Support</li>
								<li><a href="#">Support &amp; Sales</a></li>
								<li><a href="#">Billing Support</a></li>
								<li><a href="#">Email Our Support Team</a></li>
								<li><a href="#">FAQ’s</a></li>
								<li><a href="#">User’s Guides</a></li>
								<li><a href="#">Report Spam</a></li>
							</ul>
							<ul class="list col-5">
								<li>About</li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Security Center</a></li>
								<li><a href="#">Company Info</a></li>
								<li><a href="#">News Center</a></li>
								<li><a href="#">Customer Testimonials</a></li>
								<li><a href="#">What’s New</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</aside>

<!-- aside Ends Here-->

<!-- footer -->

<footer>
	<div class="container">
		<div class="inside">
			<?=$footer?>
		</div>
	</div>
</footer>


<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>