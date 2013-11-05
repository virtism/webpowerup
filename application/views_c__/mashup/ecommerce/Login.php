<?php
if(isset($log_in) && $log_in =='Myshop' ){
	$attributes = array('class' => 'contact', 'id' => 'registerform' ,  'name' => 'registerform',  'onsubmit'=>'javascript:void(0);' );
	
	if($this->config->item('seo_url') == 'On')
	{
		echo form_open('http://'.$_SERVER['SERVER_NAME'].'/'.'MyAccount/login',$attributes);
	}
	else
	{
		echo form_open('MyAccount/login',$attributes);
	}	
	
	echo form_hidden('action','do_login');
	echo form_hidden('log_in','Myshop');
	
	$email = array('name'=>'email','id'=>'email', 'class' => 'input-required input-email' ,'size'=>'32' , 'maxlength' => '128' , 'value' => set_value('email','email@example.com')); 
	$password = array('name' => 'password', 'id' => 'passwd1', 'class' => 'input-required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',''));    
	
	
	if($this->config->item('seo_url') == 'On')
	{
		
		$path = 'http://'.$_SERVER['SERVER_NAME'].'/';			
	}
	else
	{
		$path =  base_url().index_page();
	}
?>
 <b style="color:#00CC00;"> <? if($this->session->userdata('seccess_group')){ echo $this->session->userdata('seccess_group'); $this->session->unset_userdata('seccess_group');}?> </b> 
  <div id="content" style="margin-top: -20px;"> 
	<br clear="all" /> 
	<div class="right_side">
	  <div class="forgot_passwrd">
		  <label><?php echo $title;?></label>
		  <br clear="all" />
		  <ul>
			<li>
			  <label>Email *:</label>
			  <?php echo form_input($email); ?>
			</li>
			<li>
			  <label>Password *:</label>
			  <?php echo form_password($password); ?>
			</li>
			<li>
			  <label>&nbsp;</label>
              <input class="myButton" type="submit" name="submit" value="Login >>" />
			  <?php //echo form_submit('submit','Login >>'); ?>
			</li>
			<li>
			  <label>&nbsp;</label>
			  <a href="<?=$path?>MyAccount/Password_Recovery" class="forgot_pass">Forgot Password?</a> </li>
			<li> If you do not have an account, you can easily &nbsp; <a href="<?=$path?>myaccount/register.html" style="color:#EC981F; text-decoration:underline;">Register</a> </li>
		<?php  echo form_close(); }else{  ?> 
			<li>
			   <label>Invalid User Name or passowrd !</label>
		   </li>
		</ul>  
<?php } ?> 

	  </div><!--forgot_passwrd-->
	</div><!--right_side-->
  </div><!--content div end-->
  <br/><br/>
  