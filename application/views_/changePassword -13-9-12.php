<head>
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
function checkUserPassword()
{
    var password = document.getElementById('txtCurrentPass');
    var password_mesg = document.getElementById('password_mesg');
    if(password.value != "")
    {
        //alert(user_email);
        dataString = "password="+password.value;
        $.ajax({
        type: "POST",
        url: "<?=base_url().index_page()?>UsersController/isUserPassword/",
        data: dataString,
        success: function(data){
                //alert(data);
                if(data == 'TRUE')
                {
                    submitFlag = true;
                    //password_mesg.innerHTML = "<label style='color:green;font-size:12px;font:italic;margin-left:10px;'>OK!</label>";
                    password_mesg.innerHTML = '<code style="color: green">Correct!</code>';
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
}

</script>
</head>
<!--
<h3>Change Password</h3>
<form id="frmChangePassword" name="frmChangePassword" method="post" action="<?=base_url().index_page()?>UsersController/updatePassword" onsubmit="return validatePassword()">
<table border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <label for="txtCurrentPass">Current Password:</label>
        </td>
        <td>
            <input type="password" id="txtCurrentPass" name="txtCurrentPass" class="required" minlength="5" onblur="checkUserPassword()"  />
            <span id="password_mesg">&nbsp;</span>
        </td>
    </tr>
    <tr>
        <td>
            <label for="txtNewPassword">New Password:</label>
        </td>
        <td>
            <input type="password" id="txtNewPassword" name="txtNewPassword" class="required" minlength="5"   />
            
        </td>
    </tr>
    <tr>
        <td>
            <label for="txtConfirmPass">Confirm New Password:</label>
        </td>
        <td>
            <input type="password" id="txtConfirmPass" name="txtConfirmPass" class="equalto" />
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
        <td>
            <input type="submit" value="Submit" />
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
        <td>
            <label style="color:green;font-size:12px;"><?=$message?></label>
        </td>
    </tr>
</table>
</form>
-->

<form id="frmChangePassword" name="frmChangePassword" method="post" action="<?=base_url().index_page()?>UsersController/updatePassword" onsubmit="return validatePassword()">
    
    <fieldset>
    
        <label>Change Password</label>
        
        <div class="section">
            <label>Current Password <span class="required">&nbsp;</span></label>
            <div>
                <input type="password" id="txtCurrentPass" name="txtCurrentPass" class="required" minlength="5" onblur="checkUserPassword()" maxlength="30"  />
                <label id="password_mesg">
                <?php
                if($message!='')
                {
                    echo '<label class="error" style="color: green">'.$message.'</label>';   
                }
                ?>
                </label>
            </div>
        </div>
        
        <div class="section">
            <label>New Password <span class="required">&nbsp;</span></label>
            <div>
                <input type="password" id="txtNewPassword" name="txtNewPassword" class="required" minlength="5" maxlength="30"   />
            </div>
        </div>
        
        <div class="section">
            <label>Confirm New Password <span class="required">&nbsp;</span></label>
            <div>
                <input type="password" id="txtConfirmPass" name="txtConfirmPass" class="equalto" maxlength="30" />
            </div>
        </div>
        
        <div class="section">
            <div>
                <input type="submit" value="Submit" />
            </div>
        </div>
        
    </fieldset>
    
</form>

<script>
    var password = document.getElementById('txtCurrentPass');
    password.value = "";
    password.focus();
</script>