<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Payment Page</title>
 <script src="<?=base_url()?>js/validation/jquery.js" type="text/javascript"></script>
 <script src="<?=base_url()?>js/jquery.meiomask.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/validation/jquery.validate.js" type="text/javascript"></script>
</head>
<body>	

<form  action="<?=base_url().index_page()?>UsersController/sign_up_success" onsubmit="return form_submit()" enctype="multipart/form-data" method="post" id="form" >
 <input type="hidden" value="step3" name="action">
		<input type="hidden" name="request_from" value="signup" />
       
	<fieldset>
	<div class="section" id="payment_msg_row" style="display:none">
            <label>&nbsp;</label>
            <div id="payment_msg">
			
            </div>
        </div>
	
	<div class="section">
    		<?php
				
			if($package_info[0]["package_fixed_price"] > 0)
			{ ?>
				<label>Payment Gateway</label>
			<div class="section" id="payment_msg_row" style="display:none">
            <label>&nbsp;</label>
        	</div>
			<div>
				<input type="radio" style="opacity:1;" name="payment_gateway" id="payment_gateway" value="paypal" checked="checked" onclick="show_cc_row(this.value);" /> PayPal <br />
				<input type="radio" style="opacity:1;" name="payment_gateway" id="payment_gateway" value="authorize" onclick="show_cc_row(this.value);" /> Authorize.Net <br />
			</div>
			<?php } ?>
            <?php 
            if( $package_info[0]["package_fixed_price"] <= 0)
            { ?>
                <label>Payment</label>
                <div class="section" id="payment_msg_row" style="display:none">
                <label>&nbsp;</label>
                </div>
                <div>
                    You have selected a free package.<br />
                    No Payment is required.<br />
                </div>
            <?php
			} ?>
            <div class="section" id="authorize_row" style="display:none">
                    <?=$cc_fields?>
                
            </div>
			<?php 

            if( $package_info[0]["package_fixed_price"] <= 0)
            {
                $style = " display:block; ";
            }
            else
            {
                $style = " display:none; ";
            }
            ?>
            <div class="section" id="row_authorize" style=" <?=$style?>">
                <div>
                    <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="CONTINUE" />
                </div>
            </div>
            <input type="hidden" value="paypal" id="selected_cc_method" />
            <input type="hidden" name="customer_id" value="<?=$custom_id?>">
            <input type="hidden" name="price" value="<?=$package_info[0]["package_fixed_price"]?>">
     </div>
</fieldset>
</form>
<div class="section" id="paypal_row">
			<div>
				<?
					
					// echo "<pre>";	print_r($package_info[0]['package_fixed_price']);	echo "</pre>";
					
				?>
                <?php
				
				if($package_info[0]["package_fixed_price"] > 0)
				{
				?>
				<form action="<?=$this->paypal_lib->paypal_url?>" method="post" >
					<input type="hidden" name="cmd" value="_xclick">
					<!--<input type="hidden" name="upload" value="1">-->
					<input type="hidden" name="business" value="numan_1333967536_biz@virtism.com">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="rm" value="2">   
					<input type="hidden" name="return" value="<?=base_url().index_page()?>UsersController/package_update_success">
					<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>UsersController/upgrade_package">
					<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
					<input type="hidden" name="item_name" value="Charged Amount for Plan <?=$package_info[0]["package_name"]?>">
					<input type="hidden" name="item_number" value="<?=$package?>">
					<input type="hidden" name="quantity" value="1">
					<input type="hidden" name="amount" value="<?=$package_info[0]["package_fixed_price"]?>">
					<input type="hidden" name="custom" value="<?=$custom_id?>">
					<!--<input type="hidden" name="on0" value="usman">
					<input type="hidden" name="os0" value="999999">-->
					
					<input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					
			   </form>
               <?php
				} ?>
               
			</div>
      </div>
	  

 		
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
	$('#payment_msg').html(' ');
	
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
	$('#payment_msg').html(' ');
	
	$('#payment_msg_row').hide();
	
  }
  else if(val == "authorize")
  {
  	$('#selected_cc_method').val('authorize');
	$('#paypal_row').hide();
	$('#authorize_row').show();
	$('#row_authorize').show();
//	$('#payment_msg').html(' ');
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
