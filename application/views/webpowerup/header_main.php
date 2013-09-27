<div class="HundredPercent">
    <div id="CompanyLogo"> <a href="index.php" target="_self"><img src="<?=base_url()?>images/webpowerup/CompanyLogo.png" alt="logo"/></a>
</div>

    <div id="Nav">
    <!--Menu Started-->
        <ul id="nav-one" class="dropmenu">
        	<?php
            if(isset($_SESSION['current_site_info']["site_id"]) && $_SESSION['current_site_info']["site_id"]!= NULL) 
			{ ?>
            <li><a href="http://<?=$_SESSION['current_site_info']['site_domain'].'.webpowerup.com'?>" class="iconPreview">Preview</a></li>
            
            <li><span class="message">2</span><a href="#" class="iconConference">Conference Call</a></li>
            <li><a href="#" class="iconSupport">Support Ticket</a></li>
            <li><span class="message">23</span><a href="#" class="iconEmail">Email</a></li>
            <li><a href="#" class="iconOrders">New Orders</a></li>
            <li><a href="#" class="iconSettings">Settings</a>
            <?php 
			}
            if(isset($_SESSION['user_info']))
			{
				if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
				{
				?>
            
                <div>
                    <ul>
                        <li><a href="#" class="iconProfile">View profile</a></li>
                        <li><a href="#" class="iconSettings">Settings</a></li>
                        <li><a href="#" class="iconInviteFriends">Invite friends</a></li>
                        <li><a href="#" class="iconHelp">Help Center</a></li>
                        <li class="none"><a href="<?=base_url().index_page()?>UsersController/logout" class="iconLogout">Logout</a></li>
                    </ul>
                </div>
                <?php
				} 
			} ?>
            </li>
        </ul>
    <!--Menu Ends Here-->
    </div>
	
</div>