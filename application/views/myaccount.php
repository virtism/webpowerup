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

</style>
 
<div class="RightColumnHeading">
    <h1>
        <span>My Account Details</span>
    </h1>
</div>
<div class="clr"></div>

<div class="form">
	<form action="<?=base_url().index_page()?>UsersController/updateUserInfo" method="post" id="frmMyAccount" name="frmMyAccount" class="niceform">
    <input type="hidden" name="user_id" value="<?php if($user !=""){echo $user['0']['user_id'];}else{echo $_SESSION['user_info']['user_id'];}?>" />
    
    
    <dl>
       <dt>
             <label for="" class="NewsletterLabel">First Name</label>
             
       </dt>
       <dd> 
            <input type="text" id="user_fname" name="user_fname" maxlength="30" value="<?php if($user !=""){echo $user['0']['user_fname'];}else{echo $_SESSION['user_info']['user_fname'];}?>" size="55"  />

       </dd>
	</dl>
     <dl>
       <dt>
             <label for="" class="NewsletterLabel">Last Name</label>
             
       </dt>
       <dd>
            <input type="text" name="user_lname" id="user_lname" maxlength="30" value="<?php if($user !=""){echo $user['0']['user_lname'];}else{echo $_SESSION['user_info']['user_lname'];}?>" size="55"  />
       </dd>
	</dl>
    
    <dl>
       <dt>
           <label for="" class="NewsletterLabel">User Login</label>
       </dt>
       <dd>
       		<?php if($user !=""){echo $user['0']['user_login'];}else{echo $_SESSION['user_info']['user_login'];}?>
       </dd>
	</dl>
    
    <dl>
       <dt>
            <label for="" class="NewsletterLabel">Email Address</label>
       </dt>
       <dd>
       		<?php if($user !=""){echo $user['0']['user_email'];}else{echo $_SESSION['user_info']['user_email'];}?>
       </dd>
	</dl>
    
    <dl>
       <dt>
            <label for="" class="NewsletterLabel">Password</label>
       </dt>
       <dd>
       		<a href="<?=base_url().index_page()?>UsersController/changePassword/<?php if($user !=""){echo $user['0']['user_id'];}?>">Change Password</a>
       </dd>
	</dl>
    
    <dl>
       <dt>&nbsp;
            
       </dt>
       <dd>
       		<a id="cancleAcc" href="<?=base_url().index_page()?>UsersController/suspend_account">Cancle Account</a>
       </dd>
	</dl>
    <div class="ButtonRow">
    
        <button type="submit">
            <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="Save"/>
        </button>
    
    </div>
</form>
</div>


        
       