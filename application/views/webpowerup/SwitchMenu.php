<?php 


// $site_id = ( isset($_SESSION["site_id_menu"]) ) ? $_SESSION["site_id_menu"] : $_SESSION["site_id"] ;
if ( !isset($_SESSION["site_id"]) ) 
{
	$site_id = 0;
}
else
{
	$site_id = $_SESSION["site_id"];
}
?>
<div class="SwitchMenu">
    <ul id="masterdiv">
        <li>
        <a href="<?=base_url().index_page();?>SiteController/sitebuilder/" class="mainMenu">
        <img src="<?=base_url();?>images/webpowerup/MainMenu.png" alt="menu"/>
        </a>
        </li>
        <li>
        	<a href="#" class="mainmenu submenuheader"><span class="asideIconWebPages">Web Pages</span></a>
            <ul class="submenu">
                    <li><a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$site_id?>"><span>Create A Page</span></a></li>
                <li><a href="<?=base_url().index_page()?>pagesController/basic_info/<?=$site_id?>/private"><span>Create A Private Page</span></a></li>
                <li><a href="<?=base_url().index_page()?>SiteController/contact_management/<?=$site_id?>"><span>Create A Contact Page</span></a></li>
                <li><a href="<?=base_url().index_page()?>pagesController/index/<?=$site_id?>/0"><span>Manage Web Pages</span></a></li>
                <li><a href="<?=base_url().index_page()?>pagesController/private_pages/<?=$site_id?>/0"><span>Manage Private Web Pages</span></a></li>
				 <li><a href="<?=base_url().index_page()?>menusController/index/<?=$site_id?>/0"><span>Manage Menus</span></a></li>
				<li><a href="<?=base_url().index_page()?>menusController/createMenu/<?=$site_id?>"><span>Create A Menu</span></a></li>
                <li> 
                <?php 
				// echo count($blog); die();
				if(count($blog) > 0)
				{ ?>
					<a href="<?=base_url().index_page()?>blog_managment/blog/<?=$blog['id'];?>"><span>Manage Your Blog Post</span></a>
				<?php 
				}
				else
				{ ?>
					<a href="<?=base_url().index_page()?>blog_managment/create_blog"><span>Create A Blog Post</span></a>
				<?php
				} ?>
                </li>
            </ul>
        </li>
        
        <li>
        	<a href="#" class="mainmenu submenuheader"><span class="asideIconForms">Forms</span></a>
            <ul class="submenu">                
                <li><a href="<?=base_url().index_page()?>Registration_Froms/"><span>Create A Registration Form</span></a></li>
                <li><a href="<?=base_url().index_page()?>Promotional_Boxes_Management/"><span>Create Promotional Ads</span></a></li>
                <!--<li><a href="#"><span>Create a poll(UC)</span></a></li>   -->            
            </ul>
        </li>
        
      	<li>
        	<a href="#" class="mainmenu submenuheader"><span class="asideIconCommunications">Communications</span></a>
            <ul class="submenu">
                <li><a href="<?=base_url().index_page()?>Newsletter_Management/"><span>Create/Send newsletter</span></a></li>
                <li><a href="<?=base_url().index_page()?>autoresponders_management/index/<?=$site_id?>"><span>Create auto responder</span></a></li>               
                <li><a href="<?=base_url().index_page()?>room_management/index/"><span>Create meeting room</span></a></li>
                 <li><a href="<?=base_url().index_page()?>webinar_controller/index/<?=$site_id?>"><span>Webinar Management</span></a></li>
            </ul>
        </li>
      	
         <li>
        	<a href="#" class="mainmenu submenuheader"><span class="asideIconPhoto">Photo &amp; Slide Show</span></a>
            <ul class="submenu">
           		<li><a href="<?=base_url().index_page()?>site_slides/index/<?=$site_id?>/0"><span>Manage Slideshow(s)</span></a></li>
                <li><a href="<?=base_url().index_page()?>gallery_management/index/<?=$site_id?>"><span>Manage Photo Gallery</span></a></li>
                <?php /*?><li><a href="<?=base_url().index_page()?>site_slides/create/<?=$site_id?>"><span>Create Slideshow(s)</span></a></li><?php */?>
                
                <li><a href="<?=base_url().index_page()?>video_gallery/index/<?=$site_id?>"><span>Manage Video Gallery</span></a></li>
                
            </ul>
        </li>
      
      
      	<li>
        	<a href="#" class="mainmenu submenuheader" style="border-color:#d0dae3;"><span class="asideIconDesign">Design &amp; Configuration</span></a>
            <ul class="submenu">
            	<li><a href="<?=base_url().index_page()?>SiteController/change_site_template/<?=$site_id?>"><span>Change Template</span></a></li>
                <li><a href="<?=base_url().index_page()?>font_setting/index/<?=$site_id?>"><span>Set Menu Font</span></a></li>
                <li><a href="<?=base_url().index_page()?>SiteController/create_logo/<?=$site_id?>"><span>Upload A Site Logo</span></a></li>
                <li><a href="<?=base_url().index_page()?>scheme_settings/index/<?=$site_id?>"><span>Color Scheme Management</span></a></li>
                <li><a href="<?=base_url().index_page()?>FooterController/index/<?=$site_id?>"><span>Footer Managment</span></a></li>
                <?php /*?><li><a href="#"><span>Contact Form Management</span></a></li><?php */?>
            </ul>
        </li>
        <li>
        	<a href="#" class="mainmenu submenuheader"><span class="asideIconMembers">Members</span></a>
            <ul class="submenu">
                <li><a href="<?=base_url().index_page()?>customers/"><span>Create Members/Search for Members</span></a></li>
               
               <!-- <li><a href="#"><span>Add note to client's record(UC) </span></a></li>-->
            </ul>
        </li>
        
        <li>
        <a href="#" class="mainmenu submenuheader"><span class="asideIconGroups">Groups</span></a>
            <ul class="submenu">
                <li><a href="<?=base_url().index_page()?>sitegroups/index"><span>Groups</span></a></li>
                <li><a href="javascript:void(0)"><span>Access Levels (UC)</span></a></li>
                <!--<li><a href="autoresponder-management.php"><span>Autoresponders</span></a></li>-->
            </ul>
        </li>
        
        <li>
        <a href="#" class="mainmenu submenuheader"><span class="asideIconSupport">Support Ticket</span></a>
            <ul class="submenu">
                <li><a href="<?=base_url().index_page()?>support_ticket/index/<?=$site_id?>"><span>View/ Create support tickets</span></a></li>
            </ul>
        </li>
        
         <li>
        <a href="#" class="mainmenu submenuheader"><span class="asideIconStore">Your Store</span></a>
            <ul class="submenu">
                <li><a href="<?=base_url().index_page()?>Categories_Management/"><span>Manage Catagories </span></a></li>
                <li><a href="<?=base_url().index_page()?>Products_Management/"><span>Manage Products</span></a></li>
                <li><a href="<?=base_url().index_page()?>orders/"><span>Manage Orders</span></a></li>
				 <li><a href="<?=base_url().index_page()?>invoice/invoice_managment_view"><span>Create Invoices</span></a></li>
                <?php /*?><li><a href="<?=base_url().index_page()?>Shipping_Management/index/<?=$site_id?>/0"><span>Manage Shipping</span></a></li><?php */?>
                <li><a href="<?=base_url().index_page()?>shop/"><span>Store Settings</span></a></li>
            </ul>
        </li>
        <li>
        <a href="#" class="mainmenu submenuheader"><span class="asideIconHelp">Help Center / FAQ</span></a>
            <ul class="submenu">
                <li><a href="<?=base_url().index_page()?>help_center/topics_home"><span>Help Center</span></a></li>
                <li><a href="<?=base_url().index_page()?>help_center/questions_home"><span>Questions and Answers</span></a></li>
            </ul>
        </li>
        <li>
        <a href="#" class="mainmenu submenuheader"><span class="asideIconSettings">Settings and Account Info</span></a>
            <ul class="submenu">
                <li><a href="#"><span>Profile(UC) </span></a></li>
                <li><a href="#"><span>Website traffic report (UC)</span></a></li>
                <li><a href="#"><span>Search engine optimization (UC) </span></a></li>
                <li><a href="#"><span>Account upgrade (UC)</span></a></li>
                <li><a href="<?=base_url().index_page()?>thirdpartyintegration/"><span>3rd party Configuration</span></a></li>
                <li><a href="#"><span>Manage files and Bulk upload (UC)</span></a></li>
                <li><a href="#"><span>Create Affiliates for your Website (UC)</span></a></li>
            </ul>
        </li>
        <li>
        <a href="#" class="mainmenu submenuheader"><span class="asideIconSettings">Affiliate</span></a>
            <ul class="submenu">
            <li><a href="<?=base_url().index_page()?>wpuadmin_signup/memberOfAffiliate/"><span>Affiliate Member</span></a></li>
            <li><a href="<?=base_url().index_page()?>wpuadmin_signup/affiliate/<?=$site_id?>"><span>Affiliate Registration</span></a></li>
            </ul>
        </li>
        <br/>
    </ul>
</div>