<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SignUp Form</title>

 <!-- Validation  -->
 <script src="<?=base_url()?>js/validation/jquery.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/validation/jquery.validate.js" type="text/javascript"></script>

 <script type="text/javascript">
$.validator.setDefaults({
    submitHandler: function() { submit(); }
});

$().ready(function() {
    // validate the comment form when it is submitted
    $("#commentForm").validate();
    
    // validate signup form on keyup and submit
    $("#signupForm").validate({
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
    
    // propose username by combining first- and lastname
    $("#username").focus(function() {
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        if(firstname && lastname && !this.value) {
            this.value = firstname + "." + lastname;
        }
    });
    
    //code to hide topic selection, disable for demo
    var newsletter = $("#newsletter");
    // newsletter topics are optional, hide at first
    var inital = newsletter.is(":checked");
    var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
    var topicInputs = topics.find("input").attr("disabled", !inital);
    // show when newsletter is checked
    newsletter.click(function() {
        topics[this.checked ? "removeClass" : "addClass"]("gray");
        topicInputs.attr("disabled", !this.checked);
    });
});
</script>

<script language="javascript" type="text/javascript">
function isValidEmail(email)
{
   return (email.indexOf(".") > 2) && (email.indexOf("@") > 0);
}

function checkUserLogin(user_login)
{
    var login_mesg = document.getElementById('login_mesg');
    var dataString = 'user_login='+user_login;
    if(user_login != ""){
        //alert(user_email);
        $.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>UsersController/isUserLoginExist/",
        data: dataString,
        success: function(data){
                //alert(data);
                if(data == 'TRUE')
                {
                    submitFlag = false;
                    //login_mesg.innerHTML = '<label class="error">This user login already exist.</font>';
                    login_mesg.innerHTML = '<code>This user login is already in use.</code>';     
                }
                else{
                    submitFlag = true;     
                    //login_mesg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
                    login_mesg.innerHTML = '<code style="color: green;">This user login is available.</code>';
                }
            }
        });
    }        
}
function checkUserEmail(user_email)
{
    var email_mesg = document.getElementById('email_mesg');
    var dataString = 'user_email='+user_email;
    if(user_email != "" && isValidEmail(user_email)==true){
        //alert(user_email);
        $.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>UsersController/isUserEmailExist/",
        data: dataString,
        success: function(data){
                //alert(data);
                if(data == 'TRUE')
                {
                    submitFlag = false;
                    //email_mesg.innerHTML = '<label class="error">This user email already exist.</font>';
                    email_mesg.innerHTML = '<code>This user email is already in use.</code>';     
                }
                else{
                    submitFlag = true;     
                    //email_mesg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
                    email_mesg.innerHTML = '<code style="color: green;">This user email is available.</code>';
                }
            }
        });
    }
}
function setEmail(user_email)
{
    document.getElementById('email_mesg').innerHTML='&nbsp';  
    return;  
}
function setLogin(user_login)
{
    document.getElementById('login_mesg').innerHTML='&nbsp';  
    return;    
}
</script>

<style type="text/css">
/*
#commentForm { width: 500px; }
#commentForm label { width: 250px; }
#commentForm label.error, #commentForm input.submit { margin-left: 253px; }
#signupForm { width: 670px; }
#signupForm label.error {
    margin-left: 10px;
    width: auto;
    display: inline;
    color: red;
    font-style: italic;
    font-size: 12px;
}
#newsletter_topics label.error {
    display: none;
    margin-left: 103px;
}
*/
</style>

 <!-- end Validation  -->   
  
 </head>
<body>
<!--

<? //echo $msg;?>

<fieldset>
<legend> <b> Signup Process </b> </legend>
 
 <h2>Step 2 : </h2> 
  </fieldset> 
<fieldset>
<legend>User Information</legend>
<p><div class="error_msg" style="color: red; font: 12px;" align="center"> <?php echo validation_errors(); ?> </div></p> 
<?php
  
   $attributes = array('method' => 'post', 'id' => 'signupForm' , 'name' => 'user', 'class' => 'cmxform');
    echo form_open(base_url().index_page().'UsersController/signup_step3', $attributes); 
    
    echo form_hidden('action','step3');
    echo form_hidden('package',$package);
  
  
    
 $user_fname = array('name' => 'user_fname','id' => 'user_fname', 'class' => 'required' , 'size' => '30', 'value' => set_value('user_fname','')); 
 $user_lname = array('name' => 'user_lname','id' => 'user_lname','class' => 'required ' , 'size' => '30', 'value' => set_value('user_lname','')); 
 $user_password = array('name' => 'user_password','id' => 'user_password','class' => 'required' , 'size' => '30', 'value' => set_value('user_password','')); 
 $user_password_confirm = array('name' => 'user_password_confirm','id' => 'user_password_confirm','class' => 'required' , 'size' => '30', 'value' => set_value('user_password_confirm',''));    
 $user_email = array('onFocus' => "setEmail(this)", 'onBlur' => 'checkUserEmail(this.value)', 'id' => 'user_email', 'name' => 'user_email','id' => 'user_email','class' => 'required email' , 'size' => '30', 'value' => set_value('user_email','')); 
 $user_email_confirm = array('name' => 'user_email_confirm','id' => 'user_email_confirm','class' => 'required email' , 'size' => '30', 'value' => set_value('user_email_confirm','')); 
 $verification = array('name' => 'verification','id' => 'verification', 'size' => '30', 'value' => set_value('verification',''));    
 $log_in = array('onFocus' => 'setLogin(this)', 'onBlur' => 'checkUserLogin(this.value)', 'id' => 'log_in', 'name' => 'log_in','id' => 'log_in', 'size' => '30','class' => 'required ' , 'value' => set_value('log_in',''));  
    
    
?>
<table cellpadding="2" cellspacing="0" border="0" width="96%">
    
    <tr>
        <td colspan="2">
                <h1> Put Information Here  </h1>
        </td>
    </tr>
    <tr>
        <td width="155">
               <label for="user_fname"> First Name :  </label>
        </td>
        <td >
                <?php echo form_input($user_fname); ?> 
        </td>
    </tr>
    <tr>
        <td>
              <label for="user_lname">  Last Name :    </label>
        </td>
        <td>
                <?php echo form_input($user_lname); ?> 
        </td>
    </tr>
    <tr>
        <td>
              <label for="log_in">  User Login :   </label>
        </td>
        <td>
                <?php echo form_input($log_in); ?>
                <span id="login_mesg">&nbsp;</span> 
        </td>
    </tr>
    <tr>
        <td>
              <label for="user_password">  Password :      </label>
        </td>
        <td>
                <?php echo form_password($user_password); ?> 
        </td>
    </tr>
        <tr>
        <td>
             <label for="user_password_confirm">   Confirm Password :      </label>
        </td>
        <td>
                <?php echo form_password($user_password_confirm); ?> 
        </td>
    </tr>
    <tr>
        <td>
              <label for="user_email">  Email :       </label>
        </td>
        <td>
                <?php echo form_input($user_email); ?>
                <span id="email_mesg">&nbsp;</span>
        </td>
    </tr>
    <tr>
        <td>
            <label for="user_email_confirm">    Confirm Email : </label>
        </td>
        <td>
                <?php echo form_input($user_email_confirm); ?>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <br /> 
            <input type="button" value="Back" onclick="javascript: history.go(-1);" />
          
            <?php echo form_submit(array('name' => 'next', 'class' => 'submit'),'Continue'); ?> 
            <?php // echo form_button(array('name' => 'cancel'),'Cancel'); ?>
        </td>
    </tr>

</table>
 
</form>

 
</fieldset>  
-->

<form id="signupForm" class="cmxform" name="user" method="post" accept-charset="utf-8" action="<?=base_url().index_page()?>UsersController/signup_step3">
    <fieldset>
        <input type="hidden" value="step3" name="action">
        <input type="hidden" value="<?=$package?>" name="package">
        
        <label>Sign up - Step 2</label>
        
        <div class="section">
            <label>First Name <span class="required">&nbsp;</span></label>
            <div><input id="user_fname" class="required" type="text" maxlength="30" value="" name="user_fname" />
            </div>
        </div>
        
        <div class="section">
            <label>Last Name <span class="required">&nbsp;</span></label>
            <div><input id="user_lname" class="required " type="text" maxlength="30" value="" name="user_lname" />
            </div>
        </div>
        
        <div class="section">
            <label>User Login <span class="required">&nbsp;</span></label>
            <div><input id="log_in" class="required " type="text" maxlength="30" onblur="checkUserLogin(this.value)" onfocus="setLogin(this)" value="" name="log_in" />
            <label id="login_mesg"></label>
            </div>
        </div>
        
        <div class="section">
            <label>Password <span class="required">&nbsp;</span></label>
            <div><input id="user_password" class="required" type="password" maxlength="30" value="" name="user_password" />
            </div>
        </div>
        
        <div class="section">
            <label>Confirm Password <span class="required">&nbsp;</span></label>
            <div><input id="user_password_confirm" class="required" type="password" maxlength="30" value="" name="user_password_confirm" />
            </div>
        </div>
        
        <div class="section">
            <label>Email <span class="required">&nbsp;</span></label>
            <div><input id="user_email" class="required email" type="text" maxlength="30" onblur="checkUserEmail(this.value)" onfocus="setEmail(this)" value="" name="user_email" />
            <label id="email_mesg"></label>
            </div>
        </div>
        
        <div class="section">
            <label>Confirm Email <span class="required">&nbsp;</span></label>
            <div><input id="user_email_confirm" class="required email" type="text" maxlength="30" value="" name="user_email_confirm">
            </div>
        </div>
        
        <div class="section">
            <div>
                <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="CONTINUE" />
            </div>
        </div>
        
    </fieldset>
</form>
</body>
</html>