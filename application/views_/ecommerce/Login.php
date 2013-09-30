<h2><?php echo $title;?></h2>



<?php
// echo "----".$this->uri->segment(3);
$site_id_from_url = '';
$site_id_from_url = $this->uri->segment(3);
 if(isset($log_in) && $log_in =='Myshop' ){

    $attributes = array('class' => 'contact', 'id' => 'registerform' ,  'name' => 'registerform',  'onsubmit'=>'javascript:void(0);' );
	
    echo form_open('MyAccount/login/'.$site_id_from_url,$attributes);

    echo form_hidden('action','do_login');

    echo form_hidden('log_in','Myshop');

    

    $email = array('name'=>'email','id'=>'email', 'class' => 'input-required input-email' ,'size'=>'32' , 'maxlength' => '128' , 'value' => set_value('email','email@example.com')); 

    $password = array('name' => 'password', 'id' => 'passwd1', 'class' => 'input-required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',''));    

 

?>

  <table cellspacing="0" summary="Authentication" class="data-table" style="margin: 20px 0px 0px 0px;">

    <tbody><tr> 

      <td class="data-name"><label for="username">Email</label></td>

      <td class="data-required">*</td>

      <td>

        <!--<input type="text" value="email@example.com" size="30" class="input-email" name="username" id="username"> -->

        <?php echo form_input($email) ?>

      </td>

    </tr>



    <tr> 

      <td class="data-name"><label for="password">Password</label></td>

      <td class="data-required">*</td>

      <td>

        <!--<input type="password" value="" maxlength="64" size="30" name="password" id="password">-->

        <?php echo form_password($password) ?> 

      </td>

    </tr>



    

    

    <tr> 

      <td colspan="2">&nbsp;</td>

      <td class="button-row">

                <div class="center" style="margin: 20px 40px 20px 40px;">

              <?php   echo form_submit('submit','Login >>'); ?> 

    </div>



</td>

    </tr>

    

        

          <tr>

        <td colspan="2">&nbsp;</td>

        <td>

        

    





  

    <a title="Forgot password?" href="<?=base_url().index_page()?>MyAccount/Password_Recovery" class="simple-button"><span>Forgot password?</span></a>



  

</td>

      </tr>

    

  </tbody></table>

  

 <div style="margin: 0px 0px 10px 20px;">     

    If you do not have an account, you can easily<br><a class="Button" href="<?=base_url().index_page()?>MyAccount/register">register here</a>

  

</div>

<?php  echo form_close(); }else{  ?> 



   <div style="margin: 0px 0px 10px 20px;">     

    Invalid User Name or passowrd !

  

   </div>



   <div style="margin: 10px 0px 10px 20px;">     

    If you do not have an account, you can easily<br><a class="Button" href="<?=base_url().index_page()?>MyAccount/register">register here</a>

  

  </div>







<?php } ?> 