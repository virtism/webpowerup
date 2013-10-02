<div id="welcome">
    <?php 
   if(isset($_SESSION['user_info']))
   {
        if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
        {
   ?>
   <a href="<?=base_url().index_page()?>UsersController/myaccount">My Account</a>
   <?php 
        }
   }
   else
   {
   ?> 
   <a href="<?=base_url().index_page()?>UsersController/signup_step1">Sign Up</a>
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
    <a href="<?=base_url().index_page()?>UsersController/logout">logout</a>
   <?php 
        }
   }
   else
   {
   ?> 
    <a href="<?=base_url().index_page()?>UsersController/login/sitelogin">login</a>
   <?php
   }
   ?>
</div>


<div id="homesmall">
    <form name="homesmallbtn">
    <input type="button" id="bluelogin" style="cursor: pointer;" onclick="document.location = '<?=base_url().index_page()?>SiteController/sitebuilder/';" />
    </form>
</div>
<!--
  <a href="<?=base_url().index_page()?>SiteController/sitebuilder/">Home</a> 
  |
  <?php 
   
   if(isset($_SESSION['user_info']))
   {
        if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
        {
   ?>
        <a href="<?=base_url().index_page()?>SiteController/sitehome">My Account</a>
        |
        <a href="<?=base_url().index_page()?>UsersController/logout">Sign Out</a>
   <?php 
        }
   }
   else
   {
   ?>
        <a href="<?=base_url().index_page()?>SiteController/login">Login</a>
        |
        <a href="<?=base_url().index_page()?>UsersController/signup_step1">Sign Up</a>
<?php 
}
?>  
-->
