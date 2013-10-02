<script src="<?=base_url()?>js/validation/jquery.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/validation/jquery.validate.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/validation/jquery.validate2.js" type="text/javascript"></script>
 <script type="text/javascript">
$.validator.setDefaults({
    submitHandler: function() {
        if(submitFlag){
            submit();
        }
    }
});
$(document).ready(function() {
    // validate the comment form when it is submitted
   // $("#commentForm").validate();
    
    // validate signup form on keyup and submit
    $("#registerform").validate({
        rules: {
            fname: "required",
            lname: "required",
            user_password: {
                required: true,
                minlength: 5
            },
            password: {
				required: true,
				minlength: 5
			},
			passconf: {
				required: true,
				minlength: 5,
				equalTo: "#passwd1"
			},
            email: {
                required: true,
                email: true
            }
            
        },
        messages: {
            fname: "Please enter your firstname",
            lname: "Please enter your lastname",
           
            user_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            user_password_confirm: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            
        }
    });
    
});
</script>
<script language="javascript" type="text/javascript">
/*
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
*/
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
div.errorSignup{
	clear: both;
    color: #FF0000;
    float: left;
    font-size: 11px;
    left: -4px;
    position: absolute;
    top: 40px;
    width: 100%;
}
</style>



<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url()?>images/webpowerup/Detail.png" alt="Customer Registration"/>
        <span>Customer Edit </span>
    </h1>
        
    </div>
    
    <div class="PageDetail">
    <p>
    The form below allows you to create a profile which is necessary to place orders. Do not forget that this information is 
essential to use our services correctly. 
    </p>
    <p>
    The fields marked with * are mandatory. 
    </p>
    </div>
    
    <div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url()?>images/webpowerup/4.png" alt="Personal Information"/>
        <span>Personal Information</span>
    </h1>
        
</div>
        
        
<div class="form">
   <form class="niceform" action="<?=base_url().index_page()?>customers/edit" id="registerform" name="registerform" method="post" onsubmit="javascript: return checkRegFormFields(this);">
   <input type="hidden" name="action" value="updat_Customer" />
   <input type="hidden" name="customer_id" value="<?=$customer['customer_id'];?>" />
    <dl>
           <dt>
                 <label  class="NewsletterLabel">First Name <span class="star">*</span></label>
           </dt>
           <dd>
                <!--<input type="text" name="page_title" id="" size="55" />-->
                <div>
                	<input id="fname" name="fname" value="<?=$customer['customer_fname'];?>" maxlength="30" size="55"  />    
                </div>
           </dd>
    </dl>
    
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Last Name <span class="star">*</span></label>
           </dt>
           <dd>
                <!--<input type="text" name="page_title" id="" size="55" />-->
                <input id="lname" name="lname" value="<?=$customer['customer_lname']?>" maxlength="30" size="55"  />    
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Email <span class="star">*</span></label>
           </dt>
           <dd>
                <!--<input type="text" name="page_title" id="" size="55" />-->
                <input value="<?=$customer['customer_email'];?>" maxlength="30" size="55" name="email" id="email"  />
                <!--onblur="checkEmail(this.value)"-->
                <!--<div id="email_id" style="clear:left; width:370px; color: #B3B6BF; font-size: 8px; font-weight: bold;" >Make sure you enter a valid email address</div>-->
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Password <span class="star">*</span></label>
           </dt>
           <dd>
                <!--<input type="text" name="page_title" id="" size="55" />-->
                <input type="password" name="password" id="passwd1" value="" maxlength="30" size="55"  />    
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label  class="NewsletterLabel">Confirm Password</label>
           </dt>
           <dd>
                <!--<input type="text" name="page_title" id="" size="55" />-->
                <? //$customer['customer_password'];?>
                <input type="password" name="passconf" id="passwd2" value="" maxlength="30" size="55"  />    
           </dd>
    </dl>
    
    <dl>
           <dt>&nbsp;
           </dt>
           <dd>
                <input type="button" value="Back" onclick="window.location = '<?=base_url().index_page();?>customers' " /> 
                &nbsp;&nbsp;
                <input type="submit" name="submit" value="Continue" /> 
           </dd>
    </dl>


	</form>
</div> 