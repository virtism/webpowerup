<script>
  $(document).ready(function(){
	  
	  
	  $("#btnPaypal").click(function(){
			
			var submit_flag = 0
			
			$("#rsp").html("");
			$("#rsp").slideUp("fast");
			
			
			var gCode = $("#code").val();
			
			if(gCode == "")		// if field is empty
			{
				
				$("#price").val(120);
				$('#paypalForm').submit();
			}
			else		// if proper code is enter
			{
				$.ajax({
				type: 'POST',
				url: "<?=base_url().index_page()?>PackageController/get_group_code_price",
				data: "code="+gCode,
				success: function(data){
					// alert(data);
					
					if(data == 0)
					{
						
						$("#price").val(data);
						$('#paypalForm').attr("action","<?=base_url().index_page()?>UsersController/package_update_success");
						$('#paypalForm').submit();
						
					}
					else if(data != "error")
					{
						$("#price").val(data);
						$('#paypalForm').submit();
					}
					else
					{
						
						$("#rsp").addClass("error");
						$("#rsp").html("The code you entered was incorrect. Please enter the proper code");
						$("#rsp").slideDown("fast");
					}
				}
				
				});
			}
			return false;
		  
	  });
	  
		
	  	
  });
  
function set_paypal_price(code)
{
	
}
			
</script>
<style>
/***********/
/*	RESPONSE CSS	*/
#rsp{
	display:none;
	width:auto;
	padding:15px 15px 15px 15px;
	margin:15px 0px 0px 0px;
}
#rsp2{
	width:auto;
	padding:15px 15px 15px 15px;
	margin:15px 0px 0px 0px;
}
#code{
	height:25px;
	width:230px !important;
}
.info 
{
color: #00529B;
background-color: #BDE5F8;
}
.success 
{
color: #4F8A10;
background-color: #DFF2BF;
}
.warning 
{
color: #9F6000;
background-color: #FEEFB3;
}
.error 
{
color: #D8000C;
background-color: #FFBABA;
}
/***********/
</style>

<div id="content_container_subpages">
  <div id="contents">
  <h2>
  	<?php 
	if ($status != "Suspend")
	{
		echo "Your account has been expired :(";
	}
	else
	{
		echo "Your account is suspended";
	}
	?>
  </h2>
    <div class="content_details_subpage">
	<div class="expire_banner">
	<div class="data"><label class="webcomes">WebPowerUp comes with a series of tools to help <br />
	you with getting your messages across.</label>
	  <div class="clear"></div>
</div>
	
	</div>
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="about_table">
  <tr>
    <td valign="top"><br />
	<img src="<?=base_url()?>css/gws_new/images/paypal.jpg" alt=""  style="padding:0 0 0 0; float:left; "/><label class="about_label">Unlock your account at paypal<br />
    </label>
	<br />
	<p>Dear User ___________ your account is no longer active.</p>
<p>	This may be because your Trial period has come to an end or you have canceled your account.
<br />
if you feel this is a mistake, please contact us
</p> 

	<label class="tips">Activate Your Account</label>


	<p>If you have a code enter it in the box below and simply click on the Active button below. Follow the payment steps. Your business will have all the tools necessary to be successful and engaging!</p> 

	<br />
 
    <input type="text" name="code" id="code" />
    
    <div id="rsp">
    </div>
    <br />
    <?php
	
	?>
    <form action="<?=$this->paypal_lib->paypal_url?>" method="post" id="paypalForm" >
    <input type="hidden" name="cmd" value="_xclick">
    <!--<input type="hidden" name="upload" value="1">-->
    <input type="hidden" name="business" value="numan_1333967536_biz@virtism.com">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="rm" value="2">   
    <input type="hidden" name="return" value="<?=base_url().index_page()?>UsersController/package_update_success">
    <input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>UsersController/upgrade_package">
    <input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
    <input type="hidden" name="item_name" value="Charged Amount for Plan">
    <input type="hidden" name="item_number" value="2">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="amount" id="price" value="">
    <input type="hidden" name="custom" value="<?=$customer?>">
    <!--<input type="hidden" name="on0" value="usman">
    <input type="hidden" name="os0" value="999999">-->
    
    <input id="btnPaypal" style="width:220px;" type="image" src="<?=base_url();?>images/activate.jpg" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
    
    </form>
    <br />
     <?php
	if ($status != "Suspend")
	{
		if ($extension < $allowed_extension)
		{ ?>
		<strong>OR</strong>
		<br /><br />
   
			<a href="<?=base_url().index_page()?>UsersController/extend_account/"><strong>Extend your account for 15 days</strong></a>	
		<?php 
		}
		else
		{ ?>
			
			<div id="rsp2" class="warning">You dont have any more extension left.</div>
			
		<?php 
		}
	}
	else
	{ ?>
		<div id="rsp2" class="info">Your account is suspended. if you feel this is a mistake, please <a href="<?=base_url();?>css/gws_new/contact.php">contact us  </a></div>
	<?php 
	} ?>
	</td>
   
  </tr>
</table>

	
	
	</div>
  </div>
  <br clear="all" />
  <br clear="all" />
  <br clear="all" />
</div>