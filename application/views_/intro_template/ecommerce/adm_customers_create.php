 <script src="<?=base_url()?>js/validation/jquery.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/validation/jquery.validate.js" type="text/javascript"></script>

 <script type="text/javascript">
$.validator.setDefaults({
    submitHandler: function() {
        if(submitFlag){
            submit();
        }
    }
});

$().ready(function() {
    // validate the comment form when it is submitted
   // $("#commentForm").validate();
    
    // validate signup form on keyup and submit
    $("#registerform").validate({
        rules: {
            user_fname: "required",
            user_lname: "required",
            log_in: "required", 
            user_password: {
                required: true,
                minlength: 5
            },
            user_password_confirm: {
                required: true,
                minlength: 5,
                equalTo: "#user_password"
            },
            user_email: {
                required: true,
                email: true
            },
            user_email_confirm: {
                required: true,
                email: true,
                equalTo: "#user_email"  
            }
        },
        messages: {
            user_fname: "Please enter your firstname",
            user_lname: "Please enter your lastname",
            log_in: "Please enter your Login Name",
            user_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            user_password_confirm: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            user_email: "Please enter a valid email address",
            user_email_confirm:{
                required: "Please provide a email",
                email: "Please enter a valid email address",
                equalTo: "Please enter the same email as above"
            }
        }
    });
    

});
</script>

<script language="javascript" type="text/javascript">

function checkGroupCode(group_code)
{
    var msg = document.getElementById('code_id');
    var dataString = 'group_code='+group_code;
   // alert(group_code);
    if(group_code != ""){
       // alert(group_code);
        $.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>customers/code_exist/"+group_code,
        data: dataString,
        success: function(data){
              // alert(data);
                if(data  == 'TRUE')
                {
                    submitFlag = false;
                    //msg.innerHTML = '<label class="error">This user login already exist.</font>';
                    msg.innerHTML = '<code style="color: red;" >Invalid Code! Please put valid Group Code</code>';   
                    alert('Invalid Code');  
                }
                else{
                    submitFlag = true;     
                    //msg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
                    msg.innerHTML = '<code style="color: green;">Valid Code.</code>';
                  //  alert('Valid Code'); 
                }
            }
        });
    }        
}
function checkEmail(user_mail)
{
    var msg_email = document.getElementById('email_id');
    var dataString = 'user_login='+user_mail;
    if(user_mail != ""){
       // alert(user_mail);
        $.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>customers/email_exist/<?=time();?>",
        data: dataString,
        success: function(data){
              // alert(data);
                if(data  == 'TRUE')
                {
                    submitFlag = false;
                    //msg_email.innerHTML = '<label class="error">This user login already exist.</font>';
                    msg_email.innerHTML = '<code style="color: red;">This user Email is already in use.</code>';
                   // alert('Email is already in use');    
                        
                }
                else{
                    submitFlag = true;     
                    //msg_email.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
                    msg_email.innerHTML = '<code style="color: green;">This user login is available.</code>';
                   // alert('login is available');
                }
            }
        });
    }        
}

</script> 
<style type="text/css">
#commentForm { width: 500px; }
#commentForm label { width: 250px; }
#registerform label.error, #commentForm input.submit { margin-left: 0px; color:red; }
#signupForm { width: 670px; }
#signupForm label.error {
    margin-left: 10px;
    width: auto;
    display: inline;
}
#newsletter_topics label.error {
    display: none;
    margin-left: 103px;
}
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

    $attributes = array('class' => 'contact', 'id' => 'registerform' ,  'name' => 'registerform',  'onsubmit'=>'javascript: return checkRegFormFields(this);' );
    echo form_open(base_url().index_page().'customers/customer_registration',$attributes);
    echo form_hidden('action','addCustomer');
   // echo form_hidden('tag_tab',$tag_tab);
    
    $f_name = array('name'=>'f_name','id'=>'f_name','size'=>'32' , 'maxlength' => '32','class' => 'required' , 'value' => set_value('f_name','')); 
    $last_name = array('name'=>'last_name','id'=>'last_name','size'=>'32' , 'maxlength' => '32' ,'class' => 'required' , 'value' => set_value('last_name','')); 
    $company = array('name'=>'company','id'=>'company','size'=>'32' , 'maxlength' => '32' , 'value' => set_value('company',''));   
    $url = array('name'=>'url','id'=>'url','size'=>'32' , 'maxlength' => '32' , 'value' => set_value('url',''));      
    $email = array('name'=>'email','id'=>'email', 'class' => 'required email' ,'size'=>'32' , 'maxlength' => '128' ,'onblur'=>"checkEmail(this.value)" ); 
    $group_code = array('name'=>'group_code','id'=>'group_code','size'=>'32' , 'onblur'=>"checkGroupCode(this.value)"); 
    $post_code = array('name' => 'post_code', 'id' => 'post_code', 'size'=>10,'class' => 'optional');     
    $password = array('name' => 'password', 'id' => 'passwd1', 'class' => 'required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',''));    
    $passconf = array('name' => 'passconf', 'id' => 'passwd2', 'class' => 'required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',''));    
?> 

   
<table cellspacing="1" summary="Register" class="data-table register-table" style="margin-left: 20px;">
                    <tbody>

                        
            <tr>
                <td class="register-section-title" colspan="3">
                    <div>
                        <label>Personal information</label>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="fieldKey">Gender</td>
                <td class="data-required">*</td>  
                <td class="fieldValue" colspan=""><input type="radio" value="Male" name="gender" class="required">&nbsp;&nbsp;Male&nbsp;&nbsp;<input type="radio" value="Female" name="gender" class="required">&nbsp;&nbsp;Female&nbsp;</td>
            </tr>

            <tr>
                <td class="data-name"><label for="firstname">First name</label></td>
                <td class="data-required">*</td>
                <td>
                    <?php echo form_input($f_name) ?>
                </td>
            </tr>
            <tr>
                <td class="data-name"><label for="lastname">Last name</label></td>
                <td class="data-required">*</td>
                <td>
                    <?php echo form_input($last_name) ?>
                </td>
            </tr>
            <tr>
                <td class="data-name"><label for="company">Company</label></td>
                <td>&nbsp;</td>
                <td>
                    <?php echo form_input($company) ?>
                </td>
            </tr>
            <tr>
                <td class="data-name"><label for="url">Web site</label></td>
                <td>&nbsp;</td>
                <td>
                    <?php echo form_input($url) ?>
                </td>
            </tr>         
            <tr>
            <td class="register-section-title" colspan="3">
                <div>
                    <label>Account information</label>
                </div>
            </td>
        </tr>
    
    <tr>
        <td class="data-name"><label for="email">Email</label></td>
        <td class="data-required">*</td>
        <td>
            <?php echo form_input($email) ?>
            <div  id="email_id" style="color: #B3B6BF; font-size: 8px; font-weight: bold;" >Make sure you enter a valid email address</div> 
        </td>
    </tr>

    
    
                    
    <script type="text/javascript">
        $(document).ready(function(){
                
                    $('#group_code_field').hide();
        });
    
    
        function show_group_code()
        {
            $('#group_code_field').show();
        }
        function hide_group_code(val)
        {
            
            if(val == 0)
            {
                $('#group_code_field').show();
            }
            else
            {
                $('#group_code_field').hide();
            }
        }
    </script>



<table class="data-table register-table" cellspacing="1" summary="Register" style="margin-left: 20px;" >
 <tbody>
   <tr>
      <td class="data-name">Sign up for membership</td>
      <td></td>
      <td>
          <?php echo form_dropdown('pending_membershipid',$membership, 1,'onchange="hide_group_code(this.value)"' ) ?>
          <!--<select name="pending_membershipid" onchange="hide_group_code(this.value)">
                <option value="">Not member</option>
                <option value="2">Wholesale</option>
                <option value="6">Merged</option>
                <option value="9">SalesMember</option>
                <option value="0">Other</option>
          </select> -->                       
      </td>
   </tr>     
   <tr id="group_code_field" style="display: none;">
      <td class="data-name"> Group Code </td>
      <td> </td>
      <td> 
           <?php echo form_input($group_code) ?>
           <!--<span style="color: #B3B6BF; font-size: 8px; font-weight: bold;">Use your Code</span>-->
            <div  id="code_id" style="color: #B3B6BF; font-size: 8px; font-weight: bold;" >Use your Code </div>
            
      </td>
   </tr>
   <tr style="display:none;"><td><input type="hidden" value="N" id="password_is_modified" name="password_is_modified"></td></tr>
   <tr>
      <td class="data-name"><label for="passwd1">Password</label></td>
      <td class="data-required">*</td>
      <td>
          <?php echo form_password($password) ?>
      </td>
   </tr>
   <tr>
      <td class="data-name"><label for="passwd2">Confirm password</label></td>
      <td class="data-required">*</td>
      <td>
          <?php echo form_password($passconf) ?>
          <span class="validate-mark"><!--<img width="15" height="15" alt="" src="/myclinic/skin/common_files/images/spacer.gif">--></span>
      </td>
   </tr>                  
                   
   <tr>                      
      <td class="button-row center" colspan="3" align="center" style="padding: 20px 0px 20px 0px;">
          <div class="center">

              <?php   echo form_submit('submit','Continue'); ?> 
          </div>
      </td>                      
   </tr>
  </tbody>
</table>
<?php
 
echo form_close();
 
?>
