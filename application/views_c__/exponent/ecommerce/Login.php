<?php
 if(isset($log_in) && $log_in =='Myshop' ){
    $attributes = array('class' => 'contact', 'id' => 'registerform' ,  'name' => 'registerform',  'onsubmit'=>'javascript:void(0);' );
    echo form_open('MyAccount/login',$attributes);
    echo form_hidden('action','do_login');
    echo form_hidden('log_in','Myshop');
    
    $email = array('name'=>'email','id'=>'email', 'class' => 'input-required input-email' ,'size'=>'32' , 'maxlength' => '128' , 'value' => set_value('email','email@example.com')); 
    $password = array('name' => 'password', 'id' => 'passwd1', 'class' => 'input-required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',''));    
 
?>

 <div class="register"  id="main">


<h2><?php echo $title;?></h2>

<input type="hidden" value="do_login" name="action">

<input type="hidden" value="Myshop" name="log_in">
<table cellspacing="0" cellpadding="0"  width="100%" class="registerform">
<tbody><tr>
<td class="data-name"><label for="username">Email *</label></td>
<td class="data-required">&nbsp;</td>
<td>
<!--<input type="text" value="email@example.com" size="30" class="input-email" name="username" id="username"> -->
<?php echo form_input($email); ?></td>
</tr>

<tr>
<td class="data-name"><label for="password">Password *</label></td>
<td class="data-required">&nbsp;</td>
<td>
<!--<input type="password" value="" maxlength="64" size="30" name="password" id="password">-->
<?php echo form_password($password); ?>
</td>
</tr>

<tr>
<td></td>
<td></td>
<td class="mdsr"><?php echo form_submit('submit','Login >>'); ?></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td><a href="http://10.1.1.50/gws/index.php/MyAccount/Password_Recovery" title="Forgot password?" style="color:#000; text-decoration:underline; display:none;">Forgot password?</a>
</td>
</tr>

</tbody></table>

<div style="color: #000;text-transform:capitalize">
If you do not have an account, you can easily&nbsp;<a style="color: #000; text-decoration:underline; text-transform:capitalize;" href="<?=base_url().index_page()?>/MyAccount/register">register here</a>

</div>
<?php  echo form_close(); }else{  ?>
<label>Invalid User Name or passowrd !</label>

  <div style="margin: 10px 0px 10px 20px;">     
    	If you do not have an account, you can easily &nbsp; <a href="<?=base_url().index_page()?>/MyAccount/register" style="color:#EC981F; text-decoration:underline;">Register</a>
		</div>
<?php } ?>		
</div>