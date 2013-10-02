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
	
	<div class="nav">
      
	  <ul>
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
					
					<li><a class="red_link" href="<?=base_url().index_page()?>SiteController/sitebuilder/">Home</a></li>
					
					<?php /*?><li><a class="red_link" href="<?=base_url().index_page()?>SiteController/sitebuilder/">Manage A Different Site</a></li><?php */?>
					<? if(isset($_SESSION['current_site_info']["site_id"]) && $_SESSION['current_site_info']["site_id"]!= NULL) 
					{?>
						<?php /*?><li><a target="_blank" href="<?=base_url().index_page()?>site_preview/site/<?=$_SESSION['current_site_info']["site_id"]?>">Preview</a></li><?php */?>
											<li><a target="_blank" href="http://<?=$_SESSION['current_site_info']['site_domain'].'.webpowerup.com'?>">Preview</a></li>
						<li><a href="<?=base_url().index_page()?>SiteController/sitehome/<?=$_SESSION['current_site_info']["site_id"]?>">Manage</a></li>
					<? }
				}
		 	}
		 else
		 {
		 ?>
					<li><a href="<?=$strHomehref?>" ><img src="<?=base_url()?>css/gws/images/home.png" alt="" /></a></li>
		 <?		
				
		 }
		   if(isset($_SESSION['user_info']))
		   {
				if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
				{
		   ?>
					<li><a href="<?=base_url().index_page()?>UsersController/myaccount" ><?php /*?><img style="border: none;" src="<?=base_url()?>css/gws/images/my-acount.png" /><?php */?>My Account</a></li>
					<li><a href="<?=base_url().index_page()?>UsersController/logout" ><?php /*?><img style="border: none;" src="<?=base_url()?>css/gws/images/logout.png" /><?php */?>Logout</a></li>

		<? 		} 
			}
			else
			{
				
		?> 		
			<li><a href="<?=base_url().index_page()?>UsersController/signup_step1" ><img src="<?=base_url()?>css/gws/images/sign_up.png" alt="" /></a></li>
			<li><a href="<?=base_url().index_page()?>UsersController/login/sitelogin" ><img src="<?=base_url()?>css/gws/images/sign_in.png" alt="" /></a></li>
		<?php
				
			}
		?>
		</ul><br clear="all" />
    </div>