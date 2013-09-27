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
											
<body id="page1" style="<?=$strBodyStyle?>" onLoad="new ElementMaxHeight();">

<div class="tail-top">

<!-- header -->

	<header>
		<div class="container">
			<div class="header-box">
				<div class="left">
					<div class="right">
						<nav>
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
											$strLink = base_url().index_page().$other_top_navigation[$a]['link'];
										}
									
										?>
										<li class="current">
										<a href="<?=$strLink?>"><?=$other_top_navigation[$a]['title']?></a>
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
						</nav>
						<h1><a href="index.html"><span>Smart</span>Net</a></h1>
					</div> <!--div class="right" Ends Here-->
				</div>	<!--div class="left" Ends Here-->
			</div>	<!--div class="header-box" Ends Here-->
			
			<span class="top-info">24/7 Sales &amp; Support	+ 1 800 234 5678  &nbsp; l  &nbsp; <a href="#">Hot Deals</a> &nbsp; l &nbsp; <a href="#">Search</a></span>
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
		</div>	<!--div class="container" Ends Here-->
	</header>

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

<!-- content -->

	<section id="content">
		<div class="ic">More Website Templates at TemplateMonster.com!</div>
	
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
		
			<div id="faded2">
				<ul class="slides2">
					<li><img src="images/slide-title1.gif"><a href="#"><span><span>Learn More</span></span></a></li>
				</ul>
				<ul class="pagination2">
					<li><a href="#" ><span>Web Hosting</span><small>Get more information</small></a></li>
					<li><a href="#" ><span>Broadband</span><small>Get more information</small></a></li>
					<li><a href="#" ><span>Email Hosting</span><small>Get more information</small></a></li>
					<li><a href="#" ><span>Dedicated</span><small>Get more information</small></a></li>
				</ul>
			</div>	<!--div id="faded2" Ends Here-->
			
			<div class="inside">
				<div class="wrapper row-1">
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
				</div>
				<div class="inside1">
					<div class="wrap row-2">
						<div class="col-1">
							<h2>Solutions</h2>
							<ul class="solutions">
								<li><img src="images/icon1.gif"><p>Quickly and easily create a Web Page</p><a href="#"><b>Read More</b></a></li>
								<li><img src="images/icon2.gif"><p>Share documents any time, any where</p><a href="#"><b>Read More</b></a></li>
								<li><img src="images/icon3.gif"><p>24/7 Real Person Customer Support</p><a href="#"><b>Read More</b></a></li>
								<li><img src="images/icon4.gif"><p>Online Account Management Tools</p><a href="#"><b>Read More</b></a></li>
							</ul>
						</div>
						<article class="col-2">
							<h2>Register Domain Name</h2>
							<form action="" id="domain-form">
								<div class="img-box"><img src="images/1page-img.jpg">
									<div class="extra-wrap">
										<fieldset>
											<span class="text">
												<input type="text" value="enter domain name" onFocus="if(this.value=='enter domain name'){this.value=''}" onBlur="if(this.value==''){this.value='enter domain name'}">
											</span>
											<ul class="checkboxes wrapper">
												<li><input type="checkbox"><label>.mx</label></li>
												<li><input type="checkbox"><label>.net</label></li>
												<li><input type="checkbox"><label>.com</label></li>
												<li><input type="checkbox"><label>.eu</label></li>
												<li class="alt"><input type="checkbox"><label>.us.com</label></li>
												<li><input type="checkbox"><label>.us.com</label></li>
												<li><input type="checkbox"><label>.info</label></li>
												<li><input type="checkbox"><label>.mobi</label></li>
												<li><input type="checkbox"><label>.co.uk</label></li>
												<li class="alt"><input type="checkbox"><label>.tv</label></li>
											</ul>
										</fieldset>
									</div>
								</div>
								<div class="wrapper">
									<a href="#" class="link2 fleft" onClick="document.getElementById('domain-form').submit()"><span><span>Check  Domain</span></span></a>
									<ul class="links fleft">
										<li><a href="#">Renew a domain</a></li>
										<li><a href="#">Transfer a domain</a></li>
										<li><a href="#">WHOIS</a></li>
									</ul>
								</div>
							</form>
							<h2>Your Domain Name Helps the World  to Find You</h2>
							<p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet.</p>
							<p>Voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
							<a href="#" class="link2"><span><span>Read More</span></span></a>
						</article>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
		<!--div class="container" Ends Here-->
	</section>
</div>	<!--div class="tail-top" Ends Here-->

<!-- aside -->

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
								<li><a href="#">FAQs</a></li>
								<li><a href="#">Users Guides</a></li>
								<li><a href="#">Report Spam</a></li>
							</ul>
							<ul class="list col-5">
								<li>About</li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Security Center</a></li>
								<li><a href="#">Company Info</a></li>
								<li><a href="#">News Center</a></li>
								<li><a href="#">Customer Testimonials</a></li>
								<li><a href="#">Whats New</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</aside>

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