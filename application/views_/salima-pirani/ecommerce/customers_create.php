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
		url: "<?=base_url()?>index.php/customers/code_exist/"+group_code,
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
		url: "<?=base_url()?>index.php/customers/email_exist/<?=time();?>",
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
	echo form_open(base_url().index_page().'/MyAccount/register',$attributes);
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
        <div class="login">
            <p>
              <label>Personal information</label>
            </p>
            <h2><?php echo $title;?></h2>
            <p class="the_form_below">The form below allows you to create a profile which is necessary to place orders. Do not forget that this information is essential to use our services correctly. </p>
            <p class="the_form_below">The fields marked with * are mandatory.</p>
            <ul>
              <li>
                <label>Gender: *</label>
                <div class="tabdljj"> <span class="gender">
                  <input type="radio" name="gender" class="input_field" value="Male">
                  <p class="p1">Male</p>
                  </span> <span class="gender">
                  <input type="radio" class="input_field" name="gender" value="Female" checked="checked">
                  <p class="p1">Female</p>
                  </span> </div>
              </li>
              <li>
                <label>First name 	*</label>
                <?php echo form_input($f_name) ?>
              </li>
              <li>
                <label>Last name 	*</label>
                <?php echo form_input($last_name) ?>
              </li>
              <li>
                <label>Company:</label>
                <?php echo form_input($company) ?>
              </li>
              <li>
                <label>Web site:</label>
                <?php echo form_input($url) ?>
              </li>
            </ul>
            <ul >
              <li>
                <h2>Account information</h2>
              </li>
              <li>
                <label>Email:</label>
                <?php echo form_input($email) ?>
                <br clear="all" />
                <div style="color: #000000; font-size: 9px; font-weight: normal; margin: 0 0 0 189px; text-transform: none;" id="email_id">
					Make sure you enter a valid email address
				</div>
              </li>
              <li>
                <label>Sign up for membership:</label>
                <select id="gp_drop_down" name="pending_membershipid" onChange="hide_group_code(this.value)">
                  <option value=""> None</option>
                  <option value="0">Group Code</option>
                  <? for($i = 0; $i<count($membership); $i++){ ?>
				<option value="<?=$membership[$i]['id']?>"><?=$membership[$i]['group_name']?></option>
			<? } ?>
                </select>
              </li>
              <li>
                <label>Password: *</label>
                <?php echo form_password($password) ?>
              </li>
              <li>
                <label>Confirm Password: *</label>
                <?php echo form_password($passconf) ?>
              </li>
              <li>
                <div class="acccept">I Accept &nbsp; <a href="#" onclick="javascript:popupOpen(this.href, '', {width:800,height:600}); return false;" style="color:#EC981F; font-size:12px; text-decoration:underline; text-transform: none;"  target="_blank">Terms &amp; Conditions</a></div>
              </li>
              <li class="btn_submit">
                <label>&nbsp;</label>
                <?php   echo form_submit('submit','Continue'); ?>
              </li>
            </ul>
         <?php echo form_close();?>
        </div>
     
    
 
