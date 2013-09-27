<script type="text/javascript">
</script>

<style>
.trial_group{
	list-style:disc;
	margin:10px;
	padding:0 0 0 20px;
}

</style>


<?php 
if($groups)
{ ?>


<h2>Trial Ended</h2>
<br />


Your trial period is expired.<br />
<div class="trial_group">
	<?php 
	
	foreach($groups as $group)
	{ ?>
		
        <div>
		<?=$group['name'];?>
        
        </div>
        
        <div style="margin:0 0 20px 0; ">
        <?php
		
			// Generate Paypal button 
			
			$return = site_url()."group_managment/group_trail_payment/";  
			$cancle_return = current_url();
			$business = $group['button']['payPal_id'];
			$item_name = $group['button']['item_name'];
			$item_number = $group['button']['item_number'];
			$amount = $group['button']['amount'];
			$custom = $group['button']['custom'];
		?>
        <form action="<?=$this->paypal_lib->paypal_url?>" method="post" id="paypalForm" class="niceform" >
			<input type="hidden" name="cmd" value="_xclick">
			<!--<input type="hidden" name="upload" value="1">-->
			<input type="hidden" name="business" value="<?=$business?>">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="rm" value="2">   
			<input type="hidden" name="return" value="<?=$return?>">
			<input type="hidden" name="cancel_return" value="<?=$cancle_return?>">
			<input type="hidden" name="notify_url" value="<?=site_url();?>paypal/ipn">      
			<input type="hidden" name="item_name" value="<?=$item_name?>">
			<input type="hidden" name="item_number" value="<?=$item_number?>">
			<input type="hidden" name="quantity" value="1">
			<input type="hidden" name="amount" id="price" value="<?=$amount?>">
			<input type="hidden" name="custom" value="<?=$custom?>">
			<input id="btnPaypal" style="margin:10px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
		</form>
            	
        </div>
    <?php
	}
	?>
    
   
</div>

<?php
} ?>