
<script language="javascript" type="text/javascript">
function validatePassword()
{
	
    var current = document.getElementById('txtCurrentPass');
    
    var newpass = document.getElementById('txtNewPassword');
    //alert(newpass);
    
    var confirm = document.getElementById('txtConfirmPass');
    //alert(newpass.value.length);      return false;
    if(parseInt(current.value.length)<5)
    {
        alert("Password length should be greater than 5 characters");
        return false;
    }
    if(parseInt(newpass.value.length)<5)
    {
        alert("New Password length should be greater than 5 characters");
        return false;    
    }
    if(parseInt(confirm.value.length)<5)
    {
        alert("New Password length should be greater than 5 characters");
        return false;    
    }
    if(newpass.value!=confirm.value)
    {
        alert("New and Confirm Passwords donot match.");
        return false;        
    }
    if(submitFlag == false)
    {
        alert("Please enter your correct Current Password.");
        return false;
    }
    else
    {
        return true;          
    }
       
}
submitFlag = false;
$('#txtCurrentPass').live("blur",  function() { 

	
    var password = document.getElementById('txtCurrentPass');
    var password_mesg = document.getElementById('password_mesg');
	//alert(password);
    if(password.value != "")
    {
        //alert(user_email);
        dataString = "password="+password.value;
		var path =  "<?=base_url().index_page()?>UsersController/isUserPassword/";
        $.ajax({
        type: "POST",
        url: path,
        data: dataString,
        success: function(data){
                //alert(data);
                if(data == 'TRUE')
                {
                    submitFlag = true;
                    //password_mesg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
                    password_mesg.innerHTML = '<code style="color: green">Correct!</code>';
					//alert( submitFlag);
                }
                else
                {
                    submitFlag = false;     
                    //password_mesg.innerHTML = "<label style='color:red;font-size:12px;font:italic;margin-left:10px;'>Incorrect!</label>";
                    password_mesg.innerHTML = '<code>Incorrect!</code>';
                }
            }
        });
    }
});
</script>
<div class="RightColumnHeading">
    <h1>
        <span>Change Password</span>
    </h1>
</div>
<div class="clr"></div>
<div style="float:left;" id="password_mesg">
<?php
if($message!='')
{
    echo '<label class="error" style="color: green; margin-left:200px; margin-top:10px;">'.$message.'</label>';   
}
?>
</div>

<div class="form">
<form id="frmChangePassword" name="frmChangePassword" method="post" action="<?=base_url().index_page()?>UsersController/updatePassword" onsubmit="return validatePassword()" class="niceform">
    
        
        
        <dl>
       <dt>
             <label for="" class="NewsletterLabel">Current Password</label>
       </dt>
       <dd>
            
            <input type="text" id="txtCurrentPass" name="txtCurrentPass"  maxlength="30" size="55"  />
       </dd>
	   </dl>
       
        <dl>
        <dt>
             <label for="" class="NewsletterLabel">New Password</label>
        </dt>
        <dd>
            <input type="text" id="txtNewPassword" name="txtNewPassword" maxlength="30" size="55"  />
        </dd>
        </dl>

    	<dl>
           <dt>
                 <label for="" class="NewsletterLabel">Confirm New Password</label>
           </dt>
           <dd>
                <input type="text" id="txtConfirmPass" name="txtConfirmPass" maxlength="30" size="55"  />
           </dd>
    	</dl>
        
       <dl>
       <dt>
             
       </dt>
       <dd>
       <div class="ButtonRow" style="padding:0; width:auto;">
    
        <button type="submit">
            <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="Save"/>
        </button>
    
        </div>
       </dd>
      </dl>
    
</form>
</div>

<script>
   /* var password = document.getElementById('txtCurrentPass');
    password.value = "";
    password.focus();*/
</script>