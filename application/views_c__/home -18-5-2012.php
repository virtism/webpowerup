<div id="dashboard">
				<div id="welcomenote">
					    <?
							$user_greeting = "Guest";
							//echo "<pre>";
						//	print_r($_SESSION);
							if(isset($_SESSION["user_info"]["user_fname"]) && !empty($_SESSION["user_info"]["user_fname"]))
							{
								$user_greeting = $_SESSION["user_info"]["user_fname"]; 	
							}
							if(isset($_SESSION["user_info"]["user_lname"]) && !empty($_SESSION["user_info"]["user_lname"]))
							{
								$user_greeting .= " ".$_SESSION["user_info"]["user_lname"];
							}
							
						  ?>
						  
						   Welcome <?=$user_greeting?>, What would you like to do?
<br />
<?php echo($this->breadcrumb->output()); ?>
<br />

				</div>
				<div id="dbemailbox">
					   <div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						
						<div id="midforbox">
								<div id="headingemail">
										Design & Configuration
								</div>
								<div id="dbemailtxtarea">
										<div id="checkemail">
												<a href="<?=base_url().index_page()?>scheme_settings/index/<?=$_SESSION['site_id']?>">Color Scheme Management</a><br/>
										</div>
                                        
                                        <div id="setFont" style="margin-bottom: 15px;">
                                        <a href="<?=base_url().index_page()?>font_setting/index/<?=$_SESSION['site_id']?>">Set Menu Font</a>
                               			</div>
                                        
										<div id="compose">
												<a href="<?=base_url().index_page()?>FooterController/index/<?=$_SESSION['site_id']?>">Footer Managment</a> 
										</div>
										<div id="configacc">
												<a href="<?=base_url().index_page()?>SiteController/change_site_template/<?=$_SESSION['site_id']?>">Change Template</a> 
										</div>
                                        <div id="addacc">
                                        <a href="<?=base_url().index_page()?>SiteController/contact_management/<?=$_SESSION['site_id']?>">Contact Form Management</a>
                                </div>
                                
                                
										
								</div>  
						</div>
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				</div>
				
				<div id="dbwebpagebox">
						<div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						
						<div id="midforbox">
								<div id="headingwebpage">
										Web Pages
								</div>
								<div id="dbwebpagetxtarea">
									<div id="createwebpage" style="text-decoration: underline;">
											<a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$_SESSION['site_id']?>">Create a Page</a>
									</div>
									<div id="webpageformembers" style="text-decoration: underline;">
											<a href="<?=base_url().index_page()?>pagesController/index/<?=$_SESSION['site_id']?>/0">Manage Web Pages</a>
									</div>
									<div id="blogpost">
											<a href="javascript: void(0);">Create a blog post(UC)</a>
									</div>
									<div id="privatepage">
											<a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$_SESSION['site_id']?>/private">Create a private page</a>
									</div>
									<div id="contactpage">
											<a href="javascript: void(0);">Create a contact page(UC)</a>
									</div>
								</div>  
						</div>
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				</div>
				
				<div id="dbmandfbox">
						<div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						<div id="midforbox">
								<div id="headingmandf">
									 Forms
								</div>
								<div id="dbmandftxtarea">
									<div id="createmenu" style="text-decoration: underline;">
											<a href="<?=base_url().index_page()?>menusController/createMenu/<?=$_SESSION['site_id']?>">Create a Menu</a> 
									</div>
									<div id="createregform" style="text-decoration: underline;">
											<a href="<?=base_url().index_page()?>menusController/index/<?=$_SESSION['site_id']?>/0">Manage Menus</a> 
									</div>
									<div id="createregform" style="text-decoration: underline;">
										   <a href="<?=base_url().index_page()?>Registration_Froms/">Create a Registration form</a>
									</div>
									<div id="createpoll">
											<a href="javascript: void(0);">Create a poll(UC)</a>
									</div>
									<div id="promotionalads" style="text-decoration: underline;">
											<a href="<?=base_url().index_page()?>Promotional_Boxes_Management/">Promotional Ads</a>
									</div>
								</div>  
						</div>
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				</div>
				
				<div id="dbclientbox">
						<div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						<div id="midforbox">
								<div id="headingclients">
										Members
								</div>
								<div id="dbclinttxtarea">
										<div id="searchclient">
												<!--<a href="javascript: void(0);">Search for clients & Members</a>   -->
												<a  href="<?=base_url().index_page()?>customers/">Create Members/Search for Members </a>
										</div>
										<div id="invoice">
												<a style="text-decoration: underline;" href="<?=base_url().index_page()?>invoice/invoice_managment_view">Create Invoices</a>
										</div>
										
										<div id="addncr">
												<a href="javascript: void(0);">Add note to client's record(UC)</a>
										</div>
								</div>  
						</div>
						<div id="botroundedbox">
								   <img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				</div>
				
				<div id="dbmsgbox">
						<div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						<div id="midforbox">
								<div id="headingmsg">
										Groups
								</div>
								<div id="dbmsgtxtarea">
										
										<div id="private">
												<a href="<?=base_url().index_page()?>sitegroups/index">Groups</a>
										</div>
										<div id="private">
												<a href="<?=base_url().index_page()?>access_levels/index">Access Levels</a>
										</div>
										<div id="msgautoresponder" style="text-decoration: underline;">
												<a href="<?=base_url().index_page()?>Autoresponders_Management/">Autoresponders</a>
										</div>
								</div>  
						</div>
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				</div>
				
				<div id="dbcommunibox">
						<div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						<div id="midforbox">
								<div id="headingcommuni">
										Communications
								</div>
								<div id="dbcommunitxtarea">
										<div id="newsletter" style="text-decoration: underline;">
												<a href="<?=base_url().index_page()?>Newsletter_Management/">Create/ send newsletter</a>
												<!--<a href="javascript: void(0);">Create/ send newsletter</a>-->
										</div>
										<div id="createautoresponder" style="text-decoration: underline;">
												<a href="<?=base_url().index_page()?>Autoresponders_Management/">Create auto responder</a>
										</div>
										<div id="whiteboard">
												<a href="<?=base_url().index_page()?>webinar_controller/index/<?=$_SESSION["site_id"]?>">Webinar Management</a>
										</div>
										<div id="videochat">
												<a style="text-decoration:underline;" href="<?=base_url().index_page()?>room_management/index/">Create Meeting Room</a>
										</div>
								</div>  
						</div>
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				</div>
				
				<div id="dbcalenderbox">
						<div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						
						<div id="midforbox">
								<div id="headingcalender">
										Help Center / FAQ
								</div>
								<div id="dbcalendertxtarea">
										<div id="createevent">
												<a href="<?=base_url().index_page()?>help_center/topics_home">Topics</a>
										</div>
										<div id="cappoint">
												<a href="<?=base_url().index_page()?>help_center/questions_home">Questions and Answers</a>
										</div>
								</div>  
						</div>
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				</div>
				
				<div id="dbyourstorebox">
						<div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
									
						</div>
						<div id="midforbox">
							<div id="headingyourstore">
									Your Store
							</div>
							<div id="dbyourstoretxtarea">
							
									<div id="addproduct" style="text-decoration: underline;">
									   <a href="<?=base_url().index_page()?>shop/">Store Settings</a>       
									</div>

									<div id="addcatagory" >
										   <a style="text-decoration: underline;" href="<?=base_url().index_page()?>Categories_Management/">Manage Catagories</a> | <a style="text-decoration: underline;" href="<?=base_url().index_page()?>Products_Management/">Manage Products</a> 
									</div>
									<div id="manageorder" >
<?php /*?>								<a style="text-decoration: underline;" href="<?=base_url().index_page()?>orders/">Manage Orders(UC)</a> 
<?php */?>																	  
										<a style="text-decoration: underline;"  href="<?=base_url().index_page()?>orders/">Manage Orders</a> | <a style="text-decoration: underline;" href="<?=base_url().index_page()?>Shipping_Management/">Manage Shipping</a> 

									</div>
								  <?php /*?> <div id="manageorder" style="text-decoration: underline;">
										 <a style="text-decoration: underline;" href="<?=base_url().index_page()?>invoice/invoice_managment_view">Invoices</a>    
								   </div><?php */?>
							</div>  
						</div>
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				</div>
				
				<div id="dbphotoshowbox">
						<div id="toproundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						<div id="midforbox">
							<div id="headingphotoshow">
									Photo & Slide Show
							</div>

							<div id="dbphotoshowtxtarea">
							<div id="photogallery">
								<a style="text-decoration: underline;" href="<?=base_url().index_page()?>gallery_management/index/<?=$_SESSION['site_id']?>">Create a photo gallery</a>
							</div>
							<div id="createslide">
									<u><a href="<?=base_url().index_page()?>site_slides/create/<?=$_SESSION['site_id']?>">Create</a></u>
									|
									<u><a href="<?=base_url().index_page()?>site_slides/index/<?=$_SESSION['site_id']?>/0">Manage</a></u>
									Slideshow(s)
							</div>
							<div id="videogallery">
									<a href="<?=base_url().index_page()?>video_gallery/index/<?=$_SESSION['site_id']?>">Create a video gallery</a>
							</div>
							<div id="videogallery" style="text-decoration: underline;">
									<a href="<?=base_url().index_page()?>SiteController/create_logo/<?=$_SESSION['site_id']?>">Create a Site Logo</a>
									<!--<a href="javascript: void(0);">Create a Site Logo(UC)</a>-->
							</div>
							</div>  
						
						</div>
						
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				
				</div>
				
				<div id="dbphotoshowbox2">
						<div id="toproundedbox2">
									<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
						</div>
						<div id="midforbox2">
							<div id="headingphotoshow">
									Tickets 
							</div>

							<div id="dbphotoshowtxtarea">
							
							<div id="vccreatest" style="text-decoration: underline;">
												<a href="<?=base_url().index_page()?>support_ticket/">View/ Create support tickets</a>
										</div>
							
							</div>  
						
						</div>
						
						<div id="botroundedbox">
									<img src="<?=base_url()?>css/gws/images/dashboardbotrounded.png" />
						</div>
				
				</div>
				
				<div id="dbsettingbox">
							<div id="settingtoprounded">
									<img src="<?=base_url()?>css/gws/images/setingdashboardtopround.png" />
							</div>
							
							<div id="settingmidbg">
									<div id="headingsetting">
										Settings and Account Information
									</div>
							
									<div id="settingmidtxt">
									<style type="text/css">
									#settingmidtxt a{
									padding:10px 0;
									
									display:block;
									}
									</style>
												<div style=" float: left;  width: 178px;">
<a href="javascript: void(0);">Profile(UC)</a>
													
															<a href="javascript: void(0);">Website traffic report (UC)</a>
													
													
															<a href="javascript: void(0);">Search engine optimization(UC)</a>
													
											
															<a href="javascript: void(0);">Account upgrade(UC)</a>
</div>
													
															<div style="float: right; width: 216px">
															<a href="javascript: void(0);">3rd party Configuration (UC)</a>
															
															
															<a href="javascript: void(0);">Manage files and Bulk upload (UC)</a>
													
															<a href="javascript: void(0);">Create Affiliates for your Website (UC)</a></div>

											 <div id="linec">
													
													
												<?php /*?><div id="meetingroom">
												
														<a href="<?=base_url().index_page()?>room_management/index/">Create Meeting Room</a>
												</div><?php */?>
											 </div>
									</div>
							</div> 
							<div id="botroundedsetting">
									<img src="<?=base_url()?>css/gws/images/setingdashboardbotround.png" />
							</div>       
				</div>
									
</div>