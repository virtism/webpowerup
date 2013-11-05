<!--		CHECK TRAIL AND SHOW COUNTER		-->
<?php
/*function time_ago($date,$time)
{
	$days = abs(ceil((strtotime($date)-strtotime("now"))/86400));
	if ($days > 0) $timepast = $days." days";
	if ($days == 1) $timepast = $days." day";
	return $days;
}
*/
/*function time_ago($date,$time) 
{
  $days = abs(ceil((strtotime($date)-strtotime("now"))/86400));
	
  $hours = abs(ceil((strtotime($date)-strtotime("now"))/3600));
  
   // $datetime1 = new DateTime($date);
    $datetime2 = new DateTime();
    $interval = $date->diff($datetime2);
    echo $interval->format(' %D days, %H Hours, %I minutes, %S seconds');
	
 $minutes = abs(ceil((strtotime($date)-strtotime("now"))/60));
	
  //return $day = $days.':'.$hours.':'.$minutes;
  $day = $days;
  echo "hello<br>";
  echo $day.'<br>';
  echo $hours;
  exit();
  //return $days;
} */

function get_time_difference( $start, $end )
{
	
/*	$start	=	sql_time_format($start);
	$end	=	sql_time_format($end);
*/	
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!=-1 && $uts['end']!=-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff = $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff);            
            return( array('days'=>$days,'hours'=>$hours, 'mint'=>$minutes, 'sec'=>$diff) );
        }
		else
        {
            echo "Check Out date/time is Invalid <br> User must have forgot to check Out:&nbsp;&nbsp;";
        }
       /* else
        {
            trigger_error( "Check Out date/time is earlier than the Check In date/time <br> User must have forgot to check Out", E_USER_WARNING );
        }*/
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

 $exp_date = $_SESSION['user_info']['user_trail_end_date'];
  $now_date = date("Y-m-d h:i:s");

//exit();
//$days = time_ago($exp_date,$now_date); 
$day = abs(ceil((strtotime($exp_date)-strtotime("now"))/86400));
 $hour = $day *24;
$mint = $hour *60;
$secnd = $mint *60;

/*echo $secnd;
exit();*/
/*$d = $day * 24 * 60 * 60 * 1000;
$H = $hour *60*60*1000;
$m = $mint 60*1000;
$s = $secnd * 1000;
$time = $d+$H+$m+$s;*/

$days = get_time_difference($now_date,$exp_date);
$time = ($days['days']*24*60*60*1000)+($days['hours']*60*60*1000)+($days['mint']*60*1000)+($days['sec']*1000);
/*echo $time;
echo "<pre>";
print_r($days);
exit();*/
if($days > 0)
{
?>
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <link rel="stylesheet" href="<?=base_url()?>js/countdown/jquery.countdown.css" />
    <script src="<?=base_url()?>js/countdown/jquery.countdown.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(function(){
        
        var note = $('#note'),
            ts = new Date(2012, 0, 1),
            newYear = true;
        
        if((new Date()) > ts){
            // The new year is here! Count towards something else.
            // Notice the *1000 at the end - time must be in milliseconds
            ts = (new Date()).getTime() + <?=$time?> ;// * 24 * 60 * 60 * 1000;
		
            newYear = false;
        }
            
        $('#countdown').countdown({
            timestamp	: ts,
            callback	: function(days, hours, minutes, seconds){
                
                var message = "";
                
                message += days + " day" + ( days==1 ? '':'s' ) + ", ";
                message += hours + " hour" + ( hours==1 ? '':'s' ) + ", ";
                message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " and ";
                message += seconds + " second" + ( seconds==1 ? '':'s' ) + " <br />";
                
                if(newYear){
                    message += "left until the new year!";
                }
                else {
                    message += "left to 10 days from now!";
                }
                
                note.html(message);
            }
        });
        
    });
    </script>
    
    
    <div id="countdown"></div>
    <!--<p id="note"></p>-->
<?php
} ?>

<!--		CHECK TRAIL AND SHOW COUNTER END	-->
<?
		if(isset($domain) && $domain ==1)
		{
			echo "<img height ='32' width = '32' src=".base_url()."images/tick.png"." />&nbsp;&nbsp;<span>Your domain is activated.</span>";
			
		}
		else if(isset($domain) && $domain ==0)
		{
			echo "<img style='float:left; padding-top:3px;' height ='32' width = '32' src=".base_url()."images/cross.png"." />&nbsp;&nbsp;<span style=' display: inline-block;    margin: 10px 0 0;'>Your domain is not active it will take 12 to 24 hours to activate for further inquery please contact at <a href='mailto:support@webpowerup.com'>support@webpowerup.com.</a></span>";
			
		}			
				
?>
<div id="dashboard">				
				<div>
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
									
									<div id="privatepage">
											<a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$_SESSION['site_id']?>/private">Create a private page</a>
									</div>
                                    
                                    <div id="blogpost">
											<!-- if blog don't exist 	-->
                                            <?php 
											// echo count($blog); die();
											if(count($blog) > 0)
											{ ?>
                                            	<a href="<?=base_url().index_page()?>blog_managment/blog/<?=$blog['id'];?>">Manage your blog post</a>
                                            <?php 
											}
											else
											{ ?>
												<a href="<?=base_url().index_page()?>blog_managment/create_blog">Create your blog post</a>
                                            <?php
											} ?>
											<!-- if blog exist 	-->
                                            
                                            
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
                                           &nbsp;/&nbsp;<a href="<?=base_url().index_page()?>Registration_Froms/details">Details<a href="<?=base_url().index_page()?>Registration_Froms/">
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
										<?php /*?><div id="msgautoresponder" style="text-decoration: underline;">
												<a href="<?=base_url().index_page()?>Autoresponders_Management/">Autoresponders</a>
										</div>
<?php */?>
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
												<a href="<?=base_url().index_page()?>autoresponders_management/index/<?=$_SESSION['site_id']?>">Create Autoresponder</a>
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
										<a style="text-decoration: underline;"  href="<?=base_url().index_page()?>orders/">Manage Orders</a> | <a style="text-decoration: underline;" href="<?=base_url().index_page()?>Shipping_Management/index/<?=$_SESSION['site_id']?>/0">Manage Shipping</a> 
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
									<a style="text-decoration: underline;"  href="<?=base_url().index_page()?>video_gallery/index/<?=$_SESSION['site_id']?>">Create a video gallery</a>
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