<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SignUp Form</title>

 <!-- Validation  -->
 <script src="<?=base_url()?>js/validation/jquery.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/validation/jquery.validate2.js" type="text/javascript"></script>

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
			code: "required", 
            user_password: {
                required: true,
                minlength: 5
            },
            user_password_confirm: {
                required: true,
                minlength: 5,
                equalTo: "#user_password"
            },
			code: { 
				required:true,
				
			},
			captcha:
			{
				required: true,
                equalTo: "#code"
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
			
			code:"Please enter image code",
			
			captcha:
			{
				equalTo:"Please enter correct image code",
			},			
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
<script type="application/javascript" >
	
	$(document).ready(function(e) {
        
		$("#user_email").blur(function(){
			var val = $(this).val();
			checkUserEmail(val);
		});
		
		$("#user_email").focus(function(){
			var val = $(this).val();
			setEmail(val)
		});
		
		$("#log_in").blur(function(e) {
			var val = $(this).val();
            checkUserLogin(val);
        });
		
		$("#log_in").focus(function(e) {
			var val = $(this).val();
            setLogin(val);
        });
		
    });
</script>
<!--/*$("img.NFCheck").live("blur",function(){
	var id = $(this).next("input").attr("id");
	if(id == "setting")
	{
		$("#div1").toggle("fade");
	}
});

$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	if(id == "custom" || id == "default")
	{
		var value = $("#"+id).val();
		change_color_scheme(value);
	}
});*/-->

<style type="text/css">
.mainContentDiv{
	width:650px;
	clear:both;
	margin:0 auto;
	margin-top:25px;
	color:#4E4E4E;
}
.mainContentDiv label{
	height:30px;
	line-height:30px;
}
.clr{
	clear:both;
}
div.errorSignup{
	/*border:red 1px solid;*/
	position:absolute;
	left:380px;
	width:100%;
	
	
	
}
</style>

 <!-- end Validation  -->   

<div class="RightColumnHeading">
    <h1>
        <span>Sign Up</span>
    </h1>
</div>
<div class="clr"></div>


<div class="mainContentDiv">



<form id="signupForm" name="user" method="post" accept-charset="utf-8" action="<?=base_url().index_page()?>UsersController/register_process" class="niceform">
    <fieldset>
        <input type="hidden" value="register" name="action">
        
        <div style="clear:left;">
            <label >First Name</label>
             <div>
             	<input type="text" maxlength="30" value="" name="user_fname" size="55" />
             </div>
        </div>
        
        
        <div style="clear:left;">
            <label for="user_login">Last Name</label>
             <div>
             	<input type="text" maxlength="30" value="" name="user_lname" size="55" />
             </div>
        </div>
       
         
            <div style="clear:left;">
            <label for="login_mesg">User Login</label>
             <div>
             	<input id="log_in" type="text" maxlength="30"  value="" name="log_in" size="55" />
             </div>
             <div id="login_mesg" style="padding:5px;"></div>
       		</div>
            
        
       		 <div style="clear:left;">
            <label>Password</label>
             <div>
             	<input id="user_password" type="password" maxlength="30" value="" name="user_password" size="55" />
             </div>
       		</div>
            
            
             <div style="clear:left;">
            <label >Confirm Password</label>
             <div>
             	<input id="user_password_confirm" type="password" maxlength="30" value="" name="user_password_confirm" size="55" />
             </div>
       		</div>
           
        
         <div style="clear:left;">
            <label >Email</label>
             <div>
             	 <input id="user_email"  type="text" maxlength="30"  value="" name="user_email" size="55" />
            <label id="email_mesg"></label>
             </div>
             <div id="email_mesg" style="padding:5px;"></div>
       		</div>
        
        
           
         <div style="clear:left;">
            <label >Confirm Email</label>
             <div>
             	 <input id="user_email_confirm" type="text" maxlength="30" value="" name="user_email_confirm"size="55" > 
             </div>
       	  </div>   
        <div style="clear:left;">
            <label >Please Enter the image below</label>
             <div>
             	<input id="code" name="code" id="code" type="text" value="" />
                    <span id="Info"></span>
                    <span style="padding-left:10px;" id="Loading">
                    <?=$captcha_data['image'];?>
                    <input type="hidden" name="captcha" id="captcha" value="<?=$captcha_data['word'];?>"/>
                    </span>
             </div>
       	  </div>
        
           
           
        <div style="clear:left; padding:20px 0 0 0;">
            <div > 
                <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="CONTINUE" />
            </div>
		</div>
            
        
    </fieldset>
</form>
</div>