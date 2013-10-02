<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SignUp Form</title>

 <!-- Validation  -->
<script src="<?=base_url()?>js/validation/jquery.validate.js" type="text/javascript"></script>

 <script type="text/javascript">
$.validator.setDefaults({
    submitHandler: function() { submit(); }
});

$().ready(function() {
    // validate the comment form when it is submitted
    $("#commentForm").validate();
    
    // validate signup form on keyup and submit
    $("#frmMyAccount").validate({
        rules: {
            user_fname: "required",
            user_lname: "required"
            /*user_password: {
                minlength: 5
            },
            user_password_confirm: {
                minlength: 5,
                equalTo: "#user_password"
            }*/
        },
        messages: {
            user_fname: "Please enter your firstname",
            user_lname: "Please enter your lastname",
            /*user_password: {
                minlength: "Your password must be at least 5 characters long"
            },
            user_password_confirm: {
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            }*/
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
	
	$("#cancleAcc").click(function(){
		if( confirm("This will remove your account. Are you sure you wan to continue?") )
		{
			return true;
		}
		else
		{
			return false;
		}
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
                    login_mesg.innerHTML = '<label class="error">This user login already exist.</font>';     
                }
                else{
                    submitFlag = true;     
                    login_mesg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
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
                    email_mesg.innerHTML = '<label class="error">This user email already exist.</font>';     
                }
                else{
                    submitFlag = true;     
                    email_mesg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
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
#frmMyAccount { width: 670px; }
#frmMyAccount label.error {
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
<legend> <b> My Account </b> </legend>
 
 <h2>Edit / Update Your Personal Information </h2> 
  </fieldset> 
<fieldset>
<legend>User Information</legend>
<p><div class="error_msg" style="color: red; font: 12px;" align="center"> <?php echo validation_errors(); ?> </div></p> 
<?php
  
 $attributes = array('method' => 'post', 'id' => 'frmMyAccount' , 'name' => 'frmMyAccount', 'class' => 'cmxform');
 echo form_open(base_url().index_page().'UsersController/updateUserInfo', $attributes); 
    
 echo form_hidden('user_id', $_SESSION['user_info']['user_id']);
     
 $user_fname = array('name' => 'user_fname','id' => 'user_fname', 'class' => 'required' , 'size' => '30', 'value' => set_value('user_fname',$_SESSION['user_info']['user_fname'])); 
 $user_lname = array('name' => 'user_lname','id' => 'user_lname','class' => 'required ' , 'size' => '30', 'value' => set_value('user_lname',$_SESSION['user_info']['user_lname'])); 
 $user_password = array('name' => 'user_password','id' => 'user_password', 'size' => '30', 'value' => set_value('user_password','')); 
 $user_password_confirm = array('name' => 'user_password_confirm','id' => 'user_password_confirm','size' => '30', 'value' => set_value('user_password_confirm',''));    
 $verification = array('name' => 'verification','id' => 'verification', 'size' => '30', 'value' => set_value('verification',''));    
 
    
?>
<table cellpadding="2" cellspacing="0" border="0" width="96%">
    
    <tr>
        <td colspan="2">
                <h1> Edit Information Here  </h1>
        </td>
    </tr>
    <tr>
        <td width="170">
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
                <label><?=$_SESSION['user_info']['user_login']?></label> 
        </td>
    </tr>
    <tr>
        <td>
              <label for="user_email">  Email :       </label>
        </td>
        <td>
                <label><?=$_SESSION['user_info']['user_email']?></label>
        </td>
    </tr>
    <tr>
        <td>
             <a href="<?=base_url().index_page()?>UsersController/changePassword">Change Password</a>
        </td>
        <td>
            &nbsp;    
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <br />
            <input type="button" value="Back" onclick="javascript: history.go(-1);" /> 
            <?php echo form_submit(array('name' => 'next', 'class' => 'submit'),'Continue'); ?> 
            <?php // echo form_button(array('name' => 'cancel'),'Cancel'); 
            if(!isset($message))
            {
                $message = '';
            }
            ?>
            <label style="color:green;font-size:12px;font:italic"><?=$message?></label>
        </td>
    </tr>

</table>
 
</form>

</fieldset>  
-->

<form action="<?=base_url().index_page()?>UsersController/updateUserInfo" method="post" id="frmMyAccount" name="frmMyAccount" class="cmxform">
    
    <fieldset>
        <input type="hidden" name="user_id" value="<?=$_SESSION['user_info']['user_id']?>" />
    
        <label>My Account Details</label>
        
        <div class="section">
            <label>First Name <span class="required">&nbsp;</span></label>
            <div><input id="user_fname" class="required" type="text" maxlength="30" value="<?=$_SESSION['user_info']['user_fname']?>" name="user_fname" />
            <?php
            if($message!='')
            {
                echo '<label class="error" style="color: green">First Name updated.</label>';    
            }
            ?>
            </div>
        </div>
        
        <div class="section">
            <label>Last Name <span class="required">&nbsp;</span></label>
            <div><input id="user_lname" class="required " type="text" maxlength="30" value="<?=$_SESSION['user_info']['user_lname']?>" name="user_lname">
            <?php
            if($message!='')
            {
                echo '<label class="error" style="color: green">Last Name updated.</label>';    
            }
            ?>
            </div>
        </div>
        
        <div class="section">
            <label>User Login</label>
            <div><?=$_SESSION['user_info']['user_login']?>
            </div>
        </div>
        
        <div class="section">
            <label>Email Address</label>
            <div><?=$_SESSION['user_info']['user_email']?>
            </div>
        </div>
        
        <div class="section">
            <label>Password</label>
            <div><a href="<?=base_url().index_page()?>UsersController/changePassword">Change Password</a>
            </div>
        </div>
        
        <div class="section">
            <label></label>
            <div><a id="cancleAcc" href="<?=base_url().index_page()?>UsersController/suspend_account">Cancle Account</a>
            </div>
        </div>
        
        <div class="section">
            <div>
                <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="NEXT" />
            </div>
        </div>
        
    </fieldset>
</form>
</body>
</html>