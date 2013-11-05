<script type="text/javascript">
$(function() {
$("#EmailIcon").fancybox({
			maxWidth	: 600,
			maxHeight	: 600,
			fitToView	: false,
			width		: '70%',
			height		: '70%',
			autoSize	: false,
			closeClick	: false,
			openEffect	: 'none',
			closeEffect	: 'none'
		});
		
		$("#iconProfile").fancybox({
			maxWidth	: 600,
			maxHeight	: 600,
			fitToView	: false,
			width		: '70%',
			height		: '70%',
			autoSize	: false,
			closeClick	: false,
			openEffect	: 'none',
			closeEffect	: 'none'
		});

});

function emailPopup()
{


var display = document.getElementById('emailpopup');
display.style.display="block";
}

function closeEmailPopup()
{
	var display = document.getElementById('emailpopup');
	display.style.display="none";	
	$.fancybox.close();
}



function profilePopup()
{


var display = document.getElementById('profilePopup');
display.style.display="block";
}

function closeProfilePopup()
{
	var display = document.getElementById('profilePopup');
	display.style.display="none";	
	$.fancybox.close();
}
</script>

<div class="HundredPercent">
    <div id="CompanyLogo"> <a href="<?=base_url()?>" target="_self"><img src="<?=base_url()?>images/webpowerup/CompanyLogo.png" alt="logo"/></a>
</div>

    <div id="Nav" >
    <!--Menu Started-->
        <ul id="nav-one" class="dropmenu">
        	<?php
			if(isset($_SESSION['user_info']))
			{
				if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
				{
					?>
                    <li><a href="#" class="iconSettings">Settings</a>
                    
                        <div>
                            <ul>
                                <li><a href="#profilePopup" onclick="profilePopup()" class="iconProfile" id="iconProfile">View profile</a></li>
                                <li><!--<span class="message">5</span>--><a href="<?=base_url().index_page()?>UsersController/myaccount" class="iconSettings">Settings</a></li>
                                <li><a href="#" class="iconInviteFriends">Invite friends</a></li>
                                <li><a href="<?=base_url().index_page()?>help_center/topics_home" class="iconHelp">Help Center</a></li>
                                <li class="none"><a href="<?=base_url().index_page()?>UsersController/logout" class="iconLogout">Logout</a></li>
                            </ul>
                        </div>
               
			
            </li>
                    <?php
					if(isset($_SESSION['current_site_info']["site_id"]) && $_SESSION['current_site_info']["site_id"]!= NULL) 
					{
						if($this->config->item('seo_url')=='On'){
				 	?>
					<li><a target="_blank" href="http://<?=$_SESSION['current_site_info']['site_domain'].'.webpowerup.ca'?>" class="iconPreview">Preview</a></li>
					<? } 
					else
					{ ?>
                   <li><a target="_blank" href="<?=base_url().index_page()?>site_preview/site/<?=$_SESSION['current_site_info']["site_id"]?>">Preview</a></li>
                   <? } ?>
                    <li><? if(isset($conferences) && $conferences > 0){?><span class="message"><? echo $conferences;}?></span><a href="<?=base_url().index_page()?>room_management/index/" class="iconConference">Conference Call</a></li>
                    <li><a href="<?=base_url().index_page()?>support_ticket/" class="iconSupport">Support Ticket</a></li>
                    <li><a href="#emailpopup" onclick="emailPopup()"; class="iconEmail" id="EmailIcon">Email</a></li>
                    <li><a href="<?=base_url().index_page()?>orders/" class="iconOrders">New Orders</a></li>
                    <?php 
					} ?>
                    
            <?php 
				}
			} 
			else
			{
			?>
            <div style="text-align:right;">
            	<a href="<?=base_url().index_page()?>UsersController/signup_step1" ><img src="<?=base_url()?>images/webpowerup/sign_up.png" alt="" /></a>
                &nbsp;&nbsp;&nbsp;&nbsp;
				<a href="<?=base_url().index_page()?>UsersController/login/sitelogin" ><img src="<?=base_url()?>images/webpowerup/sign_in.png" alt="" /></a>
            </div>
			<?php	
			}
			?>
        </ul>
    <!--Menu Ends Here-->
    </div>
	
</div>
<div style="display:none;" >
<div id="emailpopup">
<h1 style="color:#000000">This Feature is coming soon</h1><br/>
<a href="#" class="fncy-custom-close">
<input type="button" value="close" onClick="closeEmailPopup()"/></a>
</div>
</div>
</div>
<div style="display:none;" >
<div id="profilePopup">
<h1 style="color:#000000">This Feature is coming soon</h1><br/>
<a href="#" class="fncy-custom-close">
<input type="button" value="close" onClick="closeProfilePopup()"/></a>
</div>
</div>