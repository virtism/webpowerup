<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>


</head>
<body>
<?

//echo "<pre>";
//print_r($_SESSION["user_info"]);
//print_r($modules);

//exit;
?>
                        <div id="dashboard">
                                    <div id="welcomenote">
                                            Welcome <?=$user_fname?>, What would you like to do?
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
                                                           Check Email
                                                    </div>
                                                    <div id="compose">
                                                            Compose Email
                                                    </div>
                                                    <div id="configacc">
                                                            Configure Account
                                                    </div>
                                                    <div id="addacc">
                                                            Add an Account
                                                    </div>
                                                    <img class="mail_icon" src="<?=base_url()?>css/gws/images/mailingicon.png">
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
                                                        Web Sites
                                                  </div>
                                                  <div id="dbwebpagetxtarea">
                                                        <div id="createwebpage">
                                                                <a href="<?=base_url().index_page()?>SiteController/sitebuilder/">Manage Web Sites</a>
                                                        </div>
                                                        <div id="webpageformembers">
                                                                <a href="<?=base_url().index_page()?>SiteController/creatnewsite/">Create a New Web Site</a>
                                                        </div>
                                                        <div id="blogpost">
                                                                Manage Web Sites
                                                        </div>
                                                        <div id="privatepage">
                                                                Create a private page
                                                        </div>
                                                        <div id="contactpage">
                                                                Create a contact page
                                                        </div>
                                                         
                                                        <img class="webpage_icon" src="<?=base_url()?>css/gws/images/webpageicon.png">
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
                                                    <div id="createmenu">
                                                            Create a menu
                                                    </div>
                                                    <div id="createregform">
                                                           <a href="<?=base_url().index_page()?>Registration_Froms/"> Create a Registration form  </a>
                                                    </div>
                                                    <div id="createpoll">
                                                            Create a poll
                                                    </div>
                                                    <div id="promotionalads">
                                                         <a href="<?=base_url().index_page()?>Promotional_Boxes_Management/">   Promotional Ads   </a>
                                                    </div>
                                                    <img class="mandf_icon" src="<?=base_url()?>css/gws/images/registrformicon.png">
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
                                                                Search for clients & Members
                                                        </div>
                                                        <div id="invoice">
                                                                Create Invoices
                                                        </div>
                                                        <div id="vccreatest">
                                                                <a href="<?=base_url().index_page()?>support_ticket/">View/ Create support tickets </a>
                                                        </div>
                                                        <div id="addncr">
                                                                Add note to client's record
                                                        </div>
                                                        <img class="client_icon" src="<?=base_url()?>css/gws/images/membericon.png">
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
                                                        Membership Group
                                                    </div>
                                                    <div id="dbmsgtxtarea">
                                                        <div id="creategroup">
                                                                Create/ edit a group
                                                        </div>
                                                        <div id="private">
                                                                Create a private page
                                                        </div>
                                                        <div id="msgautoresponder">
                                                                <a href="<?=base_url().index_page()?>Autoresponders_Management/"> Create an auto responder </a>
                                                        </div>
                                                        <img class="msg_icon" src="<?=base_url()?>css/gws/images/membershipicon.png">
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
                                                        <div id="newsletter">
                                                          <a href="<?=base_url().index_page()?>Newsletter_Management/">  Create/ send newsletter  </a>
                                                        </div>
                                                        <div id="createautoresponder">
                                                              <a href="<?=base_url().index_page()?>Autoresponders_Management/">  Create auto responder  </a>
                                                        </div>
                                                        <div id="videochat">
                                                                Video Chat with clients
                                                        </div>
                                                        
                                                        <div id="whiteboard">
                                                                White Board with chat
                                                        </div>
                                                        <img class="communi_icon" src="<?=base_url()?>css/gws/images/communicationsicon.png">
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
                                                        Calender & Appointments
                                                </div>
                                                <div id="dbcalendertxtarea">
                                                    <div id="createevent">
                                                            Create an Event
                                                    </div>
                                                    <div id="cappoint">
                                                            Create & view appointments
                                                    </div>
                                                    <img class="calender_icon" src="<?=base_url()?>css/gws/images/calandericon.png">
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
                                                        <div id="addproduct">
                                                               <a href="<?=base_url().index_page()?>Products_Management/"> Add a Product </a>
                                                        </div>
                                                        <div id="addcatagory">
                                                               <a href="<?=base_url().index_page()?>Categories_Management/"> Add a Catagory </a>
                                                        </div>
                                                        <div id="manageorder">
                                                             <a href="javascipt:void(0)">   Manage Order  </a>
                                                        </div>
                                                        <img class="ystore_icon" src="<?=base_url()?>css/gws/images/storeicon.png">
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
                                                                Create a photo gallery
                                                        </div>
                                                        <div id="createslide">
                                                                Create a slide show
                                                        </div>
                                                        <div id="videogallery">
                                                                Create a video gallery
                                                        </div>
                                                        <img class="photoshow_icon" src="<?=base_url()?>css/gws/images/photosicon.png">
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
                                                                        Profile
                                                                    </div>
                                                                    <div id="wtr">
                                                                        Website traffic report
                                                                    </div>
                                                                    <div id="seo">
                                                                        Search engine optimization
                                                                    </div>
                                                                </div>
                                                                <div id="lineb">
                                                                    <div id="accupgrade">
                                                                        Account upgrade
                                                                    </div>
                                                                    <div id="thrdparty">
                                                                        3rd party Configuration
                                                                    </div>
                                                                 </div>
                                                                 <div id="linec">
                                                                    <div id="mafandbup">
                                                                        Manage files and Bulk upload
                                                                    </div>
                                                                    <div id="affiliates">
                                                                        Create Affiliates for your Website
                                                                    </div>
                                                                 </div>
                                                                 <img class="setting_icon" src="<?=base_url()?>css/gws/images/settings.png">
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


</body>
</html>