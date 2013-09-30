<script type="text/javascript">
/*$.validator.setDefaults({
	submitHandler: function() {
	 alert("submitted!");
	 $("form:registerform").submit();
	  $('#registerform').submit();
	}
}); */

$.validator.setDefaults({
	submitHandler: function() {
		//alert(submitFlag);
		if(submitFlag){
			
			submit();
		}
		return false;
	}
});

$().ready(function() {
	// validate the comment form when it is submitted
   // $("#registerform").validate();
	
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
			passconf: {
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
			passconf: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			},
			email: "Please enter a valid email address",
			agree: "Please accept our policy"
		}
	});

	

});
function gp_code_load(val)
{
	if(val=="gpCode")
	{
		$('#gp_drop_down').hide();
		$('#gp_custom_code').show();	
	}
	else if(val=="gpCode")
	{
		
	}
	
}
function show_group_code()
{
	$('#group_code_field').show();
}

function hide_group_code(val)
{
	if(val == 0 && val != "")
	{
		$('#group_code_field').show();
	}
	else
	{
		$('#group_code_field').hide();
	}
}

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
					//alert('Invalid Code');  
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
<?php

	$attributes = array('class' => 'contact', 'id' => 'registerform' ,  'name' => 'registerform' );
	echo form_open(base_url().index_page().'MyAccount/register',$attributes);
	echo form_hidden('action','addCustomer');
   // echo form_hidden('tag_tab',$tag_tab);
	
	$f_name = array('name'=>'f_name','id'=>'f_name','size'=>'32' , 'maxlength' => '32','class' => 'required',  'value' => set_value('f_name','')); 
	$last_name = array('name'=>'last_name','id'=>'last_name','size'=>'32' , 'maxlength' => '32' ,'class' => 'required',  'value' => set_value('last_name','')); 
	$company = array('name'=>'company','id'=>'company','size'=>'32' , 'maxlength' => '32' ,  'value' => set_value('company',''));   
	$url = array('name'=>'url','id'=>'url','size'=>'32' , 'maxlength' => '32' ,'class' => 'optional url',  'value' => set_value('url',''));      
	$email = array('name'=>'email','id'=>'email', 'class' => 'required email' ,'size'=>'32' , 'maxlength' => '128' ,'onblur'=>"checkEmail(this.value)" ); 
	$group_code = array('name'=>'group_code','id'=>'group_code','size'=>'32' , 'onblur'=>"checkGroupCode(this.value)");
	$post_code = array('name' => 'post_code', 'id' => 'post_code', 'size'=>10);     
	$password = array('name' => 'password', 'id' => 'password', 'class' => 'required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',''));    
	$passconf = array('name' => 'passconf', 'id' => 'passconf', 'class' => 'required',  'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',''));    
?> 
  <div id="content">
	<div class="top_area">
	  <div class="slider_box">
		<div class="register" id="main">
			   <h2><?php echo $title;?></h2>
			  <p class="the_form_below">The form below allows you to create a profile which is necessary to place orders.
				Do not forget that this information is essential to use our services correctly.</p>
			  <p class="the_form_below">The fields marked with <span class="data-input_field">*</span> are mandatory. </p>
				<input type="hidden" value="addCustomer" name="action" />
				<table cellspacing="0" cellpadding="0"  width="100%" class="registerform">
				  <tbody>
					<tr>
					  <td colspan="3" class="register-section-title"><div>
						  <h3>Personal information</h3>
						</div></td>
					</tr>
					<tr>
					  <td width="33%"><label>Gender *</label></td>
					  <td width="67%" colspan="" class="fieldValue"><input type="radio" name="gender"  value="Male" />
						Male
						<input type="radio" name="gender" value="Female" checked="checked" />
						&nbsp;&nbsp;Female&nbsp;</td>
					</tr>
					<tr>
					  <td class="data-name"><label for="firstname">First name *</label></td>
					  <td><?php echo form_input($f_name) ?></td>
					</tr>
					<tr>
					  <td class="data-name"><label for="lastname">Last name *</label></td>
					  <td width="67%"><?php echo form_input($last_name) ?></td>
					</tr>
					<tr>
					  <td class="data-name"><label for="company">Company</label></td>
					  <td><?php echo form_input($company) ?></td>
					</tr>
					<tr>
					  <td class="data-name"><label for="url">Web site</label></td>
					  <td><?php echo form_input($url) ?></td>
					</tr>
					<tr>
					  <td colspan="3" class="register-section-title"><div>
						  <h3>Account information</h3>
						</div></td>
					</tr>
					<tr>
					  <td class="data-name"><label for="email">Email *</label></td>
					  <td width="67%"><?php echo form_input($email) ?>
						<div style="color: #000; font-size: 10px; font-weight: bold;" id="email_id">Make sure you enter a valid email address</div></td>
					</tr>
				  </tbody>
				</table>
				<table cellspacing="0" cellpadding="0" width="100%" class="registerform">
				  <tbody>
					<tr>
					  <td width="390" class="data-name"><label>Sign up for membership</label></td>
					  <td width="703">
					  <select class="input_field" id="gp_drop_down" name="pending_membershipid" onchange="hide_group_code(this.value)">
						  <option value=""> None</option>
						  <option value="0">Group Code</option>
			 <? 
				 for($i = 0; $i<count($membership); $i++){ 
			 
			 ?>
						  <option value="<?=$membership[$i]['id']?>"><?=$membership[$i]['group_name']?></option>
			<? 
														 }
			?>
					  </select>
					  </td>
					</tr>
					<tr style="display: none;" id="group_code_field">
					  <td class="data-name"><label>Group Code</label></td>
					  <td><input type="text" onblur="checkGroupCode(this.value)" size="32" id="group_code" value="" name="group_code" />
						<!--<span style="color: #B3B6BF; font-size: 8px; font-weight: bold;">Use your Code</span>-->
						<div style="color: #B3B6BF; font-size: 8px; font-weight: bold;" id="code_id">Use your Code </div></td>
					</tr>
					<tr style="display:none;">
					  <td><input type="hidden" name="password_is_modified" id="password_is_modified" value="N" /></td>
					</tr>
					<tr>
					  <td class="data-name"><label for="passwd1">Password *</label></td>
					  <td><?php echo form_password($password) ?><!-- <input type="password" value="" maxlength="64" size="32" class="input-input_field" name="passwd1" id="passwd1"> --></td>
					</tr>
					<tr>
					  <td class="data-name"><label for="passwd2">Confirm password *</label></td>
					  <td><?php echo form_password($passconf) ?>
						<!--<input type="password" value="" maxlength="64" size="32" class="input-input_field" name="passwd2" id="passwd2">-->
						<span class="validate-mark">
						<!--<img width="15" height="15" alt="" src="/myclinic/skin/common_files/images/spacer.gif">-->
						</span></td>
					</tr>
					<tr>
					  <td style="padding-left: 208px;" colspan="3" class="register-newbie-note"><strong style="color:#000; font-size:12px; text-transform:capitalize !important;">I accept the </strong><a style="color:#000;text-transform:capitalize !important;" href="#" onclick="javascript:popupOpen(this.href, '', {width:800,height:600}); return false;" target="_blank">"Terms &amp; Conditions"</a></td>
					</tr>
					<tr>
					  <td style="padding-left: 202px;" colspan="3" class="register-newbie-note">
					  <?php   echo form_submit('submit','Continue');?>
					  </td>
					</tr>
				  </tbody>
				</table>
			  <?php echo form_close();?>
			</div>
	  </div>
	  <br clear="all" />
	  <br clear="all" />
	 </div>
	</div>