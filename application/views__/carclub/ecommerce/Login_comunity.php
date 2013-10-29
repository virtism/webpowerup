<?php
 if(isset($log_in) && $log_in =='Myshop' ){
    $attributes = array('class' => 'contact', 'id' => 'registerform' ,  'name' => 'registerform',  'onsubmit'=>'javascript:void(0);' );
    echo form_open('MyAccount/login',$attributes);
    echo form_hidden('action','do_login');
    echo form_hidden('log_in','Myshop');
    
    $email = array('name'=>'email','id'=>'email', 'class' => 'input-required input-email' ,'size'=>'32' , 'maxlength' => '128' , 'value' => set_value('email','email@example.com')); 
    $password = array('name' => 'password', 'id' => 'passwd1', 'class' => 'input-required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',''));    
 
?>
	 <div class="slider_box">
        <div class="forgot_passwrd">
            <label><?php echo $title;?></label>
            <br clear="all" />
            <ul>
              <li>
                <label>Email * :</label>
                 <?php echo form_input($email); ?>
              </li>
              <li>
                <label>Password * :</label>
                 <?php echo form_password($password); ?>
              </li>
              <li>
                <label>&nbsp;</label>
                 <?php echo form_submit('submit','Login >>'); ?> 
              </li>
              <li>
                <label>&nbsp;</label>
                <a href="<?=base_url().index_page()?>/MyAccount/Password_Recovery" class="forgot_pass" style="display: none;">Forgot Password?</a> </li>
              <li> If you do not have an account, you can easily &nbsp; <a href="<?=base_url().index_page()?>/MyAccount/register" style="color:#EC981F; text-decoration:underline;">Register</a> </li>
            
		  <?php  echo form_close(); }else{  ?> 
		       <li>
			   <label>Invalid User Name or passowrd !</label>
				</li>
			</ul>
	   <div style="margin: 10px 0px 10px 20px;">     
    	If you do not have an account, you can easily &nbsp; <a href="<?=base_url().index_page()?>/MyAccount/register" style="color:#EC981F; text-decoration:underline;">Register</a>
  
 	 </div>



<?php } ?> 

        </div>
      </div>
