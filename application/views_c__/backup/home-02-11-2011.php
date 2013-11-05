
<?

//echo "<pre>";
//print_r($_SESSION["user_info"]);
//print_r($modules);

//exit;
?>
							<div id="dashboard">
											<div id="welcomenote">
												   Welcome Danial, What would you like to do?
											</div>
											<div id="dbemailbox">
												   <div id="toproundedbox">
																<img src="<?=base_url()?>css/gws/images/dashboardtoprounded.png" />
													</div>
													
													<div id="midforbox">
															<div id="headingemail">
																	Emails
															</div>
															<div id="dbemailtxtarea">
																	<div id="checkemail">
																			<a href="javascript: void(0);">Check Email</a>
																	</div>
																	<div id="compose">
																			<a href="javascript: void(0);">Compose Email</a>
																	</div>
																	<div id="configacc">
																			<a href="javascript: void(0);">Configure Account</a>
																	</div>
																	<div id="addacc">
																			<a href="javascript: void(0);">Add an Account</a>
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
																		<a href="javascript: void(0);">Create a blog post</a>
																</div>
																<div id="privatepage">
																		<a href="javascript: void(0);">Create a private page</a>
																</div>
																<div id="contactpage">
																		<a href="javascript: void(0);">Create a contact page</a>
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
																Members & Forms
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
																		<a href="javascript: void(0);">Create a poll</a>
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
																	Clients
															</div>
															<div id="dbclinttxtarea">
																	<div id="searchclient">
																			<!--<a href="javascript: void(0);">Search for clients & Members</a>   -->
																			<a  href="<?=base_url().index_page()?>customers/">Search for clients/Customers</a>
																	</div>
																	<div id="invoice">
																			<a href="javascript: void(0);">Create Invoices</a>
																	</div>
																	<div id="vccreatest" style="text-decoration: underline;">
																			<a href="<?=base_url().index_page()?>support_ticket/">View/ Create support tickets</a>
																	</div>
																	<div id="addncr">
																			<a href="javascript: void(0);">Add note to client's record</a>
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
																	Members & Groups
															</div>
															<div id="dbmsgtxtarea">
																	<div id="creategroup">
																			<a href="javascript: void(0);">Users</a>
																	</div>
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
																	</div>
																	<div id="createautoresponder" style="text-decoration: underline;">
																			<a href="<?=base_url().index_page()?>Autoresponders_Management/">Create auto responder</a>
																	</div>
																	<div id="videochat">
																			<a href="javascript: void(0);">Video Chat with clients</a>
																	</div>
																	<div id="whiteboard">
																			<a href="javascript: void(0);">White Board with chat</a>
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
																	   <a style="text-decoration: underline;" href="<?=base_url().index_page()?>orders/">Manage Orders</a> 
																</div>
															   <div id="manageorder" style="text-decoration: underline;">
																	   
															   </div>
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
																<a href="javascript: void(0);">Create a photo gallery</a>
														</div>
														<div id="createslide" style="text-decoration: underline">
																<a href="<?=base_url().index_page()?>site_slides/create/<?=$_SESSION['site_id']?>">Create a slide show</a>
														</div>
														<div id="videogallery">
																<a href="javascript: void(0);">Create a video gallery</a>
														</div>
                                                        <div id="videogallery" style="text-decoration: underline;">
                                                                <a href="<?=base_url().index_page()?>SiteController/create_logo/<?=$_SESSION['site_id']?>">Create a Site Logo</a>
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
																		<div id="linea">
																				<div id="profset">
																						<a href="javascript: void(0);">Profile</a>
																				</div>
																				<div id="wtr">
																						<a href="javascript: void(0);">Website traffic report</a>
																				</div>
																				<div id="seo">
																						<a href="javascript: void(0);">Search engine optimization</a>
																				</div>
																		 </div>
																		 <div id="lineb">
																				<div id="accupgrade">
																						<a href="javascript: void(0);">Account upgrade</a>
																				</div>
																				<div id="thrdparty">
																						<a href="javascript: void(0);">3rd party Configuration</a>
																				</div>
																		 </div>
																		 <div id="linec">
																				<div id="mafandbup">
																						<a href="javascript: void(0);">Manage files and Bulk upload</a>
																				</div>
																				<div id="affiliates">
																						<a href="javascript: void(0);">Create Affiliates for your Website</a>
																				</div>
																		 </div>
																</div>
														</div> 
														<div id="botroundedsetting">
																<img src="<?=base_url()?>css/gws/images/setingdashboardbotround.png" />
														</div>       
											</div>
																
							</div>
							 
							

							
<!--
<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td colspan="3"><h1>SiteBuilder Home</h1></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td>
				
				<b>Navigation</b><br>       <br>
				<? 
				 for($i=0; $i<count($modules);$i++ )
				 {
					 if($modules[$i]["module_id"] == 1)
					 {
							?>
					<a href="<?=base_url().index_page()?>SiteController/sitebuilder/"><?=$modules[$i]["module_name"]?></a>  <br>
				<? 
					 }
					 else
					 {
							?>
					<a href='javascript: alert("In progress")'><?=$modules[$i]["module_name"]?></a><br>
				<?  
					 }
				
				 }
				?>	
			</td>
			<td>
				Main
			</td>
			<td>
				Right
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" align="center">Listing of User Sites Here</td>
		</tr>
</table>
-->
