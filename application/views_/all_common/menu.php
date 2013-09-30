   <?

	//$roles = $this->RolesModel->get_all_roles();

	//echo "<pre>";

	//print_r($roles);

	//

	

   ?>

	<li>

	    <a href="<?=base_url().index_page()?>SiteController/sitebuilder/">Home</a>

	</li>



   <?php 

     //print_r($menu); exit();  

   if(isset($_SESSION['user_info']))

   {

		 if(isset($_SESSION['user_info']['user_id']) && $_SESSION['user_info']['user_id']!= NULL)

		 {

         

   ?>

   <li> 

        <a href="<?=base_url().index_page()?>UsersController/logout">Sign Out</a>

   </li> 

   <li>

        <a href="<?=base_url().index_page()?>UsersController/myaccount">My Account</a>

   </li>

 <?php 

	  }

   }

   else

   {

     //  echo 'I am here ...........................<><><><><><><><><><><><><><><><><>' ;

       

       ?>

   <li> 

        <a href="<?=base_url().index_page()?>SiteController/login">Login</a>

   </li> 

   <li>

        <a href="<?=base_url().index_page()?>UsersController/signup_step1">Sign Up</a>

   </li>

   

 <?php 

	 

   }

   ?>