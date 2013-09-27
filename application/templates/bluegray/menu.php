<!--            <li id="current"><a href="index.html">Home</a></li>
            <li><a href="index.html">Archives</a></li>
            <li><a href="index.html">Downloads</a></li>
            <li><a href="index.html">Services</a></li>
            <li><a href="index.html">Support</a></li>
            <li><a href="index.html">About</a></li>   -->
          <?
    //$roles = $this->RolesModel->get_all_roles();
    //echo "<pre>";
    //print_r($roles);
    //
    
   ?>
    <li>
    <a href="<?=base_url()?>index.php/SiteController/sitebuilder/">Home</a>
    </li>

   <?php 
   
   if(isset($_SESSION['user_info']))
   {
         if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)
         {
         
   ?>
   <li> 
   <a href="<?=base_url()?>index.php/UsersController/logout">Sign Out</a>
   </li> 
   <li>
   <a href="<?=base_url()?>index.php/SiteController/sitehome">My Account</a>
   </li>
 <?php 
      }
   }
   else
   {
     //  echo 'I am here ...........................<><><><><><><><><><><><><><><><><>' ;
       
       ?>
   <li> 
   <a href="<?=base_url()?>index.php/SiteController/login">Login</a>
   </li> 
   <li>
   <a href="<?=base_url()?>index.php/UsersController/signup_step1">Sign Up</a>
   </li>
   
 <?php 
     
   }
   ?>