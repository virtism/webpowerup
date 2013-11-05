<script type="text/javascript">
/*$.validator.setDefaults({
    submitHandler: function() { alert("submitted!"); }
});   */

$().ready(function() {
    // validate the comment form when it is submitted
    $("#registerform").validate();
    
    // validate signup form on keyup and submit
    $("#registerform").validate({
        rules: {
            firstname: "required",
            lastname: "required",
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
            topic: {
                required: "#newsletter:checked",
                minlength: 2
            },
            agree: "required"
        },
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy"
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

<style type="text/css">
/*#registerform { width: 500px; }
#registerform label { width: 250px; }  */
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
    echo form_open(base_url().'index.php/MyAccount/account',$attributes);
    echo form_hidden('action','updat_account');
    echo form_hidden('customer_id',$customer['customer_id']);
   // echo form_hidden('tag_tab',$tag_tab);
    
    $f_name = array('name'=>'f_name','id'=>'f_name','size'=>'32' , 'maxlength' => '32' ,'class' => 'required', 'value' => set_value('f_name',$customer['customer_fname'])); 
    $last_name = array('name'=>'last_name','id'=>'last_name','size'=>'32' , 'maxlength' => '32' , 'class' => 'required','value' => set_value('last_name',$customer['customer_lname'])); 
    $company = array('name'=>'company','id'=>'company','size'=>'32' , 'maxlength' => '32' ,'class' => 'optional', 'value' => set_value('company',$customer['customer_company']));   
    $url = array('name'=>'url','id'=>'url','size'=>'32' , 'maxlength' => '64' ,'class' => 'optional url', 'value' => set_value('url',$customer['customer_url']));      
    $email = array('name'=>'email','id'=>'email', 'class' => 'required email' ,'size'=>'32' ,'readonly'=>"readonly", 'maxlength' => '128' , 'value' => set_value('email',$customer['customer_email'])); 
    $group_code = array('name'=>'group_code','id'=>'group_code','size'=>'32' , 'value' => set_value('group_code',$customer['group_code'])); 
  //  $post_code = array('name' => 'post_code', 'id' => 'post_code', 'size'=>'32' , 'value' => set_value('group_code',$customer['password']));     
  //  $password = array('name' => 'password', 'id' => 'passwd1', 'class' => 'input-required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',$customer['password']));    
  //  $passconf = array('name' => 'passconf', 'id' => 'passwd2', 'class' => 'input-required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',$customer['password']));    
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
                <td class="fieldValue" colspan=""><input type="radio" value="Male" name="gender" <?php if ($customer['customer_gender'] == 'Male' ){echo 'checked = true';} ?> >&nbsp;&nbsp;Male&nbsp;&nbsp;<input type="radio" value="Female" name="gender" <?php if ($customer['customer_gender'] == 'Female' ){echo 'checked = true';} ?> >&nbsp;&nbsp;Female&nbsp;</td>
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
            <div style="display: none;" class="note-box" id="email_note">Make sure you enter a valid email address because the store will send you notifications to this address.</div>
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
         <?php /*?> <?php echo form_dropdown('pending_membershipid',$membership, 1,'onchange="hide_group_code(this.value)"' ) ?><?php */?>
		  <select onchange="hide_group_code(this.value)"  name="pending_membershipid" >
		 	<? for($i = 0; $i<count($membership); $i++){ ?>
				<option value="<?=$membership[$i]['id']?>"><?=$membership[$i]['group_name']?></option>
			<? } ?>
		 </select>
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
           <!--<input type="text" size="32" name="group_code" id="group_code"> -->
           <?php echo form_input($group_code) ?>
           <span style="color: #B3B6BF; font-size: 8px; font-weight: bold;">Use your Code</span>
      </td>
   </tr>
<!--   <tr style="display:none;"><td><input type="hidden" value="N" id="password_is_modified" name="password_is_modified"></td></tr>
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
          
          <span class="validate-mark"> <img width="15" height="15" alt="" src="/myclinic/skin/common_files/images/spacer.gif"></span>
      </td>
   </tr> -->                 
   <tr>
      <td class="register-newbie-note" colspan="3" style="padding-left: 162px;;">
          I accept the <a target="_blank" onclick="javascript:popupOpen(this.href, '', {width:800,height:600}); return false;" href="#">"Terms &amp; Conditions"</a>
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