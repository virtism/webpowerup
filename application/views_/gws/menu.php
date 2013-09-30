<div id="welcome">
    <?php 
	//echo $this->uri->segment(1);
   if(isset($_SESSION['user_info']))
   {
        if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
        {
   ?>
   <a href="<?=base_url()?>index.php/UsersController/myaccount">My Account</a>
   <?php 
        }
   }
   else
   {
   ?> 
  	 <a href="<?=base_url()?>index.php/UsersController/signup_step1"><img style="border: none;" src="<?=base_url()?>css/gws/images/sign_up.png" /></a>
   <?php
   }
   ?>
   <!--
   Hello 
   <?php 
   if(isset($_SESSION['user_info']))
   {
        if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
        {
            echo $_SESSION['user_info']['user_fname'];
   ?>
   <?php 
        }
   }
   else
   {
   ?>
   Guest
   <?php
   }?>
   -->
</div>

<div id="login">
    <?php 
   if(isset($_SESSION['user_info']))
   {
        if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
        {
   ?>
    <a href="<?=base_url()?>index.php/UsersController/logout">logout</a>
   <?php 
        }
   }
   else
   {
   ?> 
    <a href="<?=base_url()?>index.php/UsersController/login/sitelogin"><img style="border: none;" src="<?=base_url()?>css/gws/images/sign_in.png" /></a>
   <?php
   }
   ?>
</div>


<div id="homesmall">
    <form name="homesmallbtn" class="gws_form">
    <input type="button" id="bluelogin" style="cursor: pointer;" onclick="document.location = '<?=base_url()?>index.php/SiteController/sitebuilder/';" />
    </form>
</div>
<!--
  <a href="<?=base_url()?>index.php/SiteController/sitebuilder/">Home</a> 
  |
  <?php 
   
   if(isset($_SESSION['user_info']))
   {
        if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
        {
   ?>
        <a href="<?=base_url()?>index.php/SiteController/sitehome">My Account</a>
        |
        <a href="<?=base_url()?>index.php/UsersController/logout">Sign Out</a>
   <?php 
        }
   }
   else
   {
   ?>
        <a href="<?=base_url()?>index.php/SiteController/login">Login</a>
        |
        <a href="<?=base_url()?>index.php/UsersController/signup_step1">Sign Up</a>
<?php 
}
?>  
-->
