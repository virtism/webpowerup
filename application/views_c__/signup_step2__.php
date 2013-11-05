<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SignUp Form</title>

 <!-- Validation  -->
 <script src="<?=base_url()?>js/validation/jquery.js" type="text/javascript"></script>
 <script src="<?=base_url()?>js/jquery.meiomask.js" type="text/javascript"></script>
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
        url: "<?=base_url()?>index.php/UsersController/isUserLoginExist/",
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
        url: "<?=base_url()?>index.php/UsersController/isUserEmailExist/",
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

<?
//echo "<pre>";
//print_r($package_info);
//exit;
?>
<form id="signupForm" class="cmxform" name="user" method="post" accept-charset="utf-8" action="<?=base_url().index_page()?>UsersController/signup_step3" onsubmit="return form_submit()">
<!--<form id="signupForm" class="cmxform" name="user" method="post" accept-charset="utf-8" action="<?=base_url().index_page()?>payment_processing/index">-->
    <fieldset>
        <input type="hidden" value="step3" name="action">
		<input type="hidden" name="request_from" value="signup" />
        <input type="hidden" value="<?=$package?>" name="package">
        
        <label>Sign up - Step 2</label>
        
		<div class="section" id="payment_msg_row" style="display:none">
            <label>&nbsp;</label>
            <div id="payment_msg">
			
            </div>
        </div>
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
            <label>Payment Information</label>
            <div>
				Plan  : <?=$package_info["package_name"]?><br />
				Price : <font style="color:green">$<?=$package_info["package_fixed_price"]?></font>
            </div>
			<input type="hidden" name="price" value="<?=$package_info["package_fixed_price"]?>" />
        </div>
		
		<div class="section">
			<label>Payment Gateway</label>
			<div>
				<input type="radio" style="opacity:1;" name="payment_gateway" id="payment_gateway" value="paypal" checked="checked" onclick="show_cc_row(this.value);" /> PayPal <br />
				<input type="radio" style="opacity:1;" name="payment_gateway" id="payment_gateway" value="authorize" onclick="show_cc_row(this.value);" /> Authorize.Net <br />
				
			</div>
			
		</div>
		<!--<div class="section" id="paypal_row" style="display:block">
			<label>PayPal Payment </label>
			<div>
				<input type="button" value="Pay Now" />
			</div>
			
		</div>-->
		<div class="section" id="authorize_row" style="display:none">
				<?=$cc_fields?>
			
		</div>
        <div class="section" id="row_authorize" style="display:none">
            <div>
                <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="CONTINUE" />
            </div>
        </div>
		<input type="hidden" value="paypal" id="selected_cc_method" />
	</form>
		<div class="section" id="paypal_row">
			<div>
				<?
				//	echo "<pre>";
					//print_r($_SESSION);
					
				?>
				<form action="<?=$this->paypal_lib->paypal_url?>" method="post" >
					<input type="hidden" name="cmd" value="_xclick">
					<!--<input type="hidden" name="upload" value="1">-->
					<input type="hidden" name="business" value="musman_1310921532_biz@virtism.com">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="rm" value="2">   
					<input type="hidden" name="return" value="<?=base_url().index_page()?>UsersController/sign_up_success">
					<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>MyShop">
					<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
					<input type="hidden" name="item_name" value="Charged Amount for Plan <?=$package_info["package_name"]?>">
					<input type="hidden" name="item_number" value="786">
					<input type="hidden" name="quantity" value="1">
					<input type="hidden" name="amount" value="<?=$package_info["package_fixed_price"]?>">
					<input type="hidden" name="custom" value="777">
				
					
					<!--<input type="hidden" name="discount_rate_cart" value="<?=$customer_group_data[0]['discount_value']?>">  -->
					
					<!--<input type="hidden" name="item_name_<?=$i?>" value="<?=$items['name']?>">
					<input type="hidden" name="item_number_<?=$i?>" value="<?=$i?>">
					<input type="hidden" name="quantity_<?=$i?>" value="<?=$items['qty']?>">
					<input type="hidden" name="amount_<?=$i?>" value="<?=$items['price']?>">
					<input type="hidden" name="discount_amount_cart" value="<?=$customer_group_data[0]['discount_value']?>">  -->
					
					
					<input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					
				</form>
			</div>
      </div>
	</fieldset>	 
</body>
</html>
<script type="text/javascript">

function form_submit()
{
	payment_type_2 = $('#selected_cc_method').val();
	valid = cc_feild_validation();
	if(payment_type_2 == "authorize" && valid != "")
	{
		$('#payment_msg_row').show();
		$('#payment_msg').html(valid);
		$('#payment_msg').css('color','red');
		return false;	
	}
	
	$('#payment_msg_row').hide();
	$('#payment_msg').html('');
	
	$("#signupForm").submit();
	
	return true;
	//alert(valid);
}
function show_cc_row(val)
{
  if(val == "paypal")
  {
  	$('#selected_cc_method').val('paypal');
	$('#authorize_row').hide();
	$('#row_authorize').hide();
	$('#paypal_row').show();
	
  }
  else if(val == "authorize")
  {
  	$('#selected_cc_method').val('authorize');
	$('#paypal_row').hide();
	$('#authorize_row').show();
	$('#row_authorize').show();
	load_CC_Mask();
  } 
}
function load_CC_Mask(cc_type)
{
	if(cc_type=="Amex")
	{ 
		document.getElementById("credit_card").value = "";
		document.getElementById("security_code").value = "";
		jQuery('#credit_card').setMask({mask:"9999 999999 99999"});
		jQuery('#security_code').setMask({mask:"9999"});
	}
	else
	{
		document.getElementById("credit_card").value = "";
		document.getElementById("security_code").value = "";
		jQuery('#credit_card').setMask({mask:"9999 9999 9999 9999"});
		jQuery('#security_code').setMask({mask:"999"});
	}	
}
function loadMask()
{
	jQuery('#zip').setMask({mask:"99999"});
	jQuery('#contact_number').setMask({mask:"999-999-9999"});
	jQuery('#middile').setMask({mask:"a"});
	jQuery('#country_code').setMask({mask:"GGGG"});
}
function cc_feild_validation()
{
	flag = true;
	var str_msg = ""; 
	if($('#card_holder').val() == "")
	{
		flag = false;
		str_msg += "Card Holder Name is Empty<br>";
		
	}
	if($('#credit_card').val() == "")
	{
		flag = false;
		str_msg += "Credit Card Number is Empty<br>";
	}
	if($('#security_code').val() == "")
	{
		flag = false;
		str_msg += "Security Code Number is Empty<br>";
	}
	if($('#month').val() == "")
	{
		flag = false;
		str_msg += "Month is Empty<br>";
	}
	if($('#year').val() == "")
	{
		flag = false;
		str_msg += "Year is Empty<br>";
	}
	
	
	
	return str_msg;
}

</script>