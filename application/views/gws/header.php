        <?php
     	if(isset($_SESSION['user_info']['user_id']))
        {
            $strHomehref = base_url()."index.php/SiteController/sitebuilder/";    
        }
        else
        {
            $strHomehref = base_url()."index.php/UsersController/login/sitelogin";    
        }
        ?>		
	
	
    
	  <?php 
//echo "<pre>";
//echo $_SESSION['user_info']['user_id'];
//print_r($_SESSION);
//echo $_SESSION['current_site_info']["site_id"];exit;


		   if(isset($_SESSION['user_info']))
		   {
				if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
				{
		   ?>
					
     <div style="float:right; width:auto" class="top_nav">
      <ul>
					<li><a href="<?=base_url().index_page()?>SiteController/sitebuilder/">Home</a></li>
       
	
    
					<?php /*?><li><a class="red_link" href="<?=base_url().index_page()?>SiteController/sitebuilder/">Manage A Different Site</a></li><?php */?>
					<? if(isset($_SESSION['current_site_info']["site_id"]) && $_SESSION['current_site_info']["site_id"]!= NULL) 
					{?>
						<?php /*?><li><a target="_blank" href="<?=base_url().index_page()?>site_preview/site/<?=$_SESSION['current_site_info']["site_id"]?>">Preview</a></li><?php */?>
						<li><a target="_blank" href="http://<?=$_SESSION['current_site_info']['site_domain'].'.webpowerup.ca'?>">Preview</a></li>
						<li><a href="<?=base_url().index_page()?>SiteController/sitehome/<?=$_SESSION['current_site_info']["site_id"]?>">Manage</a></li>
					<? }
				}
		 	}
		 else
		 {
		 ?><div  class="top_nav">
      <ul>
					<li><a href="<?=base_url().index_page()?>" >Home</a></li>
					<li><a href="<?=base_url()?>aboutus.html">About Us</a></li>
        <li><a href="features.html" class="features_list">Features</a> <div class="features" >
      <div class="features_top"></div>
      <div class="features_center">
        <ul>
          <li><a href="<?=base_url()?>webinar.html"><img src="<?=base_url()?>css/gws_new/images/webinar.png" alt="" />
            <label>Webinar</label>
            </a></li>
          <li><a href="<?=base_url()?>members.html"><img src="<?=base_url()?>css/gws_new/images/membership.png" alt="" />
            <label>Membership</label>
            </a></li>
          <li><a href="<?=base_url()?>e-commerce.html"><img src="<?=base_url()?>css/gws_new/images/ecommerce.png" alt="" />
            <label>E-Commerce</label>
            </a></li>
          <li><a href="#"><img src="<?=base_url()?>css/gws_new/images/help_desk.png" alt="" />
            <label>Help Desk </label>
            </a></li>
          <li><a href="#"><img src="<?=base_url()?>css/gws_new/images/drop.png" alt=""  style="margin-top:11px;"/>
            <label>Drag-n-Drop</label>
            </a></li>
          <li><a href="<?=base_url()?>registeration_forms.html"><img src="<?=base_url()?>css/gws_new/images/registration.png" alt="" />
            <label>Registration Form</label>
            </a></li>
          <li><a href="<?=base_url()?>video_conferencing.html"><img src="<?=base_url()?>css/gws_new/images/video_conferencing.png" alt="" style="margin-top:11px;"/>
            <label>Video Conferencing</label>
            </a></li>
          <li><a href="<?=base_url()?>newletter.html"><img src="<?=base_url()?>css/gws_new/images/news_letter.png" alt="" />
            <label>Newsletter</label>
            </a></li>
        </ul><br clear="all" />
      </div>
      <div class="features_bottom"></div>
    </div></li>
        <li><a href="<?=base_url()?>contact.html">Contact Us</a></li>
		</ul> 
    </div>
		 <?		
				
		 }
		   if(isset($_SESSION['user_info']))
		   {
				if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
				{
		   ?>
				<li><a href="<?=base_url().index_page()?>UsersController/myaccount" >My Account</a></li>
				
      <li><a href="<?=base_url().index_page()?>UsersController/logout">Logout</a></li>
	 

		<? 		} 
			}
			else
			{
				
		?> 		
			
			
			 <div class="signin_signup"> <a href="<?=base_url().index_page()?>UsersController/signup_step1" class="singup">Sign Up</a> <a href="#" class="add_contact"></a> <a href="<?=base_url().index_page()?>UsersController/login/sitelogin" class="singin">Log In</a> </div>
		<?php
				
			}
		?>
	</div>
	</div>