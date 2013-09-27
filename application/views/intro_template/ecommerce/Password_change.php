<script type="text/javascript">
/*$.validator.setDefaults({
    submitHandler: function() {  alert("submitted!"); }
});*/

$().ready(function() {
    // validate the comment form when it is submitted
    $("#pass_change").validate();
    
    // validate signup form on keyup and submit
    $("#pass_change").validate({
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            passconf: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            passconf: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });


});
</script>

<style type="text/css">
/*#registerform { width: 500px; }
#registerform label { width: 250px; }  */
#pass_change label.error, #commentForm input.submit { margin-left: 0px; color:red; }

</style> 
<h2><?php echo $title;?></h2>
<p class="register-note">

           The form below allows you to create a profile which is necessary to place orders. 
           Do not forget that this information is essential to use our services correctly.
             <br>
            <br>
        
        The fields marked with <span class="data-required">*</span> are mandatory.

</p>
<?php

    $attributes = array('id' => 'pass_change' ,  'name' => 'pass_change');
    echo form_open(base_url().index_page().'MyAccount/password_change',$attributes);
    echo form_hidden('action','change_pass');
    echo form_hidden('customer_id',$customer['customer_id']);   
    echo form_hidden('old_pass',$customer['customer_password']);  
     $password_current = array('name' => 'password_current', 'id' => 'passwd1',  'size'=>'32' , 'maxlength' => '64', 'value' => set_value('password_current',''));     
    $password = array('name' => 'password', 'id' => 'password', 'class' => 'required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('password',''));    
    $passconf = array('name' => 'passconf', 'id' => 'passconf', 'class' => 'required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('passconf',''));    
?> 

   
<table cellspacing="1" summary="Register" class="data-table register-table" style="margin-left: 20px;">
                    <tbody>
 
            <tr>
                <td class="register-section-title" colspan="3">
                    <div>
                        <label>Change Password </label>
                    </div>
                </td>
            </tr>




<table class="data-table register-table" cellspacing="1" summary="Register" style="margin-left: 20px;" >
 <tbody>

 <tr style="display:none;"><td><input type="hidden" value="N" id="password_is_modified" name="password_is_modified"></td></tr>
   <tr>
      <td class="data-name"><label for="passwd1">Current Password </label></td>
      <td class="data-required">*</td>
      <td>
          <?php echo form_password($password_current) ?>
      </td>
   </tr>
   <tr>
      <td class="data-name"><label for="passwd2"> password</label></td>
      <td class="data-required">*</td>
      <td>
          <?php echo form_password($password) ?>
          
          <span class="validate-mark"> <!--<img width="15" height="15" alt="" src="/myclinic/skin/common_files/images/spacer.gif">--></span>
      </td>
   </tr>  
      <tr>
      <td class="data-name"><label for="passwd2">Confirm password</label></td>
      <td class="data-required">*</td>
      <td>
          <?php echo form_password($passconf) ?>
          
          <span class="validate-mark"> <!--<img width="15" height="15" alt="" src="/myclinic/skin/common_files/images/spacer.gif">--></span>
      </td>
   </tr>                               
   <tr>                      
      <td class="button-row center" colspan="3" align="center" style="padding: 20px 0px 20px 0px;">
          <div class="center">
                <!--<button title="Submit" type="submit" class="button main-button">
              <span class="button-right"><span class="button-left">Submit</span></span>
              </button> -->
              <?php   echo form_submit('submit','Continue'); ?> 
          </div>
      </td>                      
   </tr>
  </tbody>
</table> 
<?php
 
echo form_close();
 
?>