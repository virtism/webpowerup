<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
// getting ajax call for state on base of country selected	
	function get_ajax_states()
	{
		var country_id = document.getElementById('country').value;
		//country_id = country_id.replace("-"," ");
		var path =  "<?=base_url().index_page()?>MyShop/ajax_call_states/";
		var dataString = "country_id="+country_id;
		//alert( country_id);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#state_option").html(' ');
				//alert(data);
				//$("#customers_detail").show();
				$("#state_option").html(data);
				//alert("success");
			}
		});
	
	}
	
	function get_ajax_shipping_rates()
	{
		var country_id = document.getElementById('country').value;
		var state_id = document.getElementById('state').value;
		var total_weight = document.getElementById('total_weight').value;
		//country_id = country_id.replace("-"," ");
		//var dataString = new array();
		var path =  "<?=base_url().index_page()?>MyShop/ajax_call_shipping_rates/";
		var dataString = "country_id="+country_id+"&state_id="+state_id+"&total_weight="+total_weight;
	/*	dataString[1] = "state_id="+state_id;
		dataString[0] = "total_weight="+total_weight; */   
		//alert( country_id);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				var hidden_total = document.getElementById('hidden_total').value;
				$("#grand_total").html(' ');
				//alert(data);
				//$("#customers_detail").show();
				$total = Number(data)+Number(hidden_total);
				$("#grand_total").html('<strong ><br/>'+$total+'</strong>');
				//alert("success");
			}
		});
		
	
	}
	
	
</script>
<style>

.border-top

{

	border-top:#e2e2e2 solid 1px;	

	padding-bottom:5px;

}

.border-bottom

{

	border-bottom:#e2e2e2 solid 1px;		

	padding-top:5px;

}

.cart-price

{

	color:#EC981F;

}



</style>
<?php 
$total_weight=0;

?>

<?php if(!$this->cart->contents()):

	echo 'You don\'t have any items yet.';

else:

?>



<?php echo form_open('MyShop/update_cart');

 ?>
<table width="500">
<tr>
    <td colspan="2"><h1 style="padding: 0px;">Select Country and States for Shipping</h1></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
										<td>country: </td>
										<td>
											
											<select id="country" name="country" style="opacity: 1;" onChange="get_ajax_states()">
													<? foreach($countries as $country) 
													{
														$country['countries_name'] = str_replace(" ","-",$country['countries_name']);
														echo "<option value=".$country['countries_name'].">".$country['countries_name']."</option>";
													}
													?>													
											</select>											
										</td>
									</tr>
									<tr>
										<td>State/Province</td>
										<td id="state_option">
											<select id="state" name="state" style="opacity: 1;" onChange="get_ajax_shipping_rates()">
													<? foreach($states as $state) 
													{
														$state['zone_name'] = str_replace(" ","-",$state['zone_name']);
														echo "<option value=".$state['zone_name'].">".$state['zone_name']."</option>";
													}
													?>													
											</select>	
										</td>
									</tr>						
</table>
<br clear="all" />
<br clear="all" />
<br clear="all" />
<table width="100%" cellpadding="0" cellspacing="0" onclick="get_ajax_shipping_rates()">

	<thead>

		<tr>

			<td>Qty</td>

			<td>Item Description</td>

			<td>Item Price</td>

			<td>Weight(in kg)</td>
			
			
			<td>Sub-Total</td>

		</tr>

	</thead>

	<tbody>

		<?php $i = 1; ?>

		<?php foreach($this->cart->contents() as $items): ?>

		<? 
	/*	echo '<pre>';
		print_r($items); 
		echo $items['shipping_rates'][0]['min_range'];
		echo count($items['shipping_rates']);
		echo $items['shipping_rates'][1]['rate'];
		exit();*/
		?>

		<?php echo form_hidden('rowid[]', $items['rowid']); ?>

		<tr <?php if($i&1){ echo 'class="alt"'; }?>>

			<td>

				<?php echo form_input(array('name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>

			</td>


			<td><?php echo $items['name']; ?></td>

			
			<? $items['weight'] = $items['weight'] * $items['qty']; ?>
			<td><?php echo $this->cart->format_number($items['price']); ?></td>
			
			<td><?php  echo $this->cart->format_number($items['weight']); ?></td>

			<td><?php echo $this->cart->format_number($items['subtotal']); ?></td>

		</tr>

		<?php 
		
		   if($items['is_free'] == 'No')
			{
			   $total_weight =$total_weight + $items['weight'];
			}
			else
			{
			  $total_weight = '0';
			}
			
			$rate = 0;
			$msg = '';
			
			if(isset($total_weight) && $total_weight != 0 && $total_weight < $items['shipping_rates'][0]['min_range'])
			{
			  $msg = "weight not in range"; 
			}
			if(isset($total_weight) && $total_weight != 0 && $total_weight > $items['shipping_rates'][count($items['shipping_rates'])-1]['max_range'])
		    {
			  $msg = "weight not in range";
		    }
			for($j = 0; $j < count($items['shipping_rates']); $j++)
			{
			
			 if($total_weight >= $items['shipping_rates'][$j]['min_range'])
			  {
			    if($total_weight <= $items['shipping_rates'][$j]['max_range'])
				{
			       $rate = $items['shipping_rates'][$j]['rate'];
				}
			  }
			
			}
			
		  $i++;   

		endforeach; ?>

			<? 

			$grand_total = $this->cart->total();

			//echo $customer_group_data[0]['discount_type']."sfsdfsfd";

		if(isset($customer_group_data[0]['discount_type']) && $customer_group_data[0]['discount_type'] != "None" && $customer_group_data[0]['discount_type'] != "")

		{

			

			if($customer_group_data[0]['discount_type'] == "Percentage")

			{

				$dis_amount = ($customer_group_data[0]['discount_value']/100) * ($this->cart->total());			

				$grand_total = $this->cart->total() - $dis_amount;				

				$dis_value = $customer_group_data[0]['discount_value']."%";

			}

			else if($customer_group_data[0]['discount_type'] == "Fixed")

			{

				$dis_amount = $customer_group_data[0]['discount_value'];			

				$grand_total = $this->cart->total() - $dis_amount;

				$dis_value = $customer_group_data[0]['discount_value'];

			}		

		?>

		<tr>

			<td></td>

			<td></td>

			<td class="border-top"><strong>Sub Total:</strong></td>

			<td class="border-top"><?php echo $this->cart->format_number($this->cart->total()); ?></td>

		</tr>

		<tr>

			<td></td>

			<td></td>

			<td><strong>Discount Value: ( <?=$dis_value?> )</strong></td>			

			<td><? echo $this->cart->format_number($dis_amount);?></td>

		</tr>

		<tr>

			<td></td>

			<td></td>

			<td class="border-bottom"><strong>Discounted Subtotal: </strong></td>

			<td class="border-bottom"><? echo $this->cart->format_number($grand_total); ?></td>

		</tr>

		

		<? }
		 ?>
   
		<tr>

			<td></td>
			<td></td>
			<td></td>
			<td><strong><br />Total Items Weight:</strong></td>
            <input type="hidden" name="total_weight" id="total_weight" value="<? echo $total_weight; ?>" />
			<td align="left"><strong><br /><? echo $this->cart->format_number($total_weight); ?><strong></td>
	   </tr> 
       <tr>
       		<td></td>
			<td></td>
			<td></td>
			<td ><strong><br />Total:</strong></td>
             <input type="hidden" name="hidden_total" id="hidden_total" value="<? echo ($grand_total+$rate); ?>" />
			<td><strong ><br/><? echo $this->cart->format_number($grand_total+$rate); ?> <strong> </td>
			
		</tr>
 <tr>
       		<td></td>
			<td></td>
			<td></td>
			<td ><strong><br />Net Total:</strong></td>
			<td id="grand_total"><strong ><br/><? echo $this->cart->format_number($grand_total+$rate); ?> <strong> </td>
			
		</tr>
	</tbody>

</table>



<input class="myButton" type="submit" value="Update your Cart" name="Update your Cart" /><?php //echo form_submit('', 'Update your Cart');?> <? echo anchor('MyShop/empty_cart', 'Empty Cart', 'class="empty"');  //echo anchor('MyShop', 'Continue Shopping'); ?> </form>
<? echo form_close();
 echo form_open('MyShop/index');
 ?>
 <br />
 <input class="myButton" type="submit" value="Add more Products" name="Add more Products" />
 <?
 //echo form_submit('', 'Add more Products');
 echo form_close();
 ?>
<p><small>If the quantity is set to zero, the item will be removed from the cart.</small></p>

<?php 


	

	

	/*$this->paypal_lib->add_field('business', 'musman_1310921532_biz@virtism.com');

	

	$this->paypal_lib->add_field('return', site_url('MyShop/empty_cart'));

	$this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));

	$this->paypal_lib->add_field('notify_url', site_url('paypal/ipn'));

	

	$this->paypal_lib->add_field('cmd', '_cart');

	$this->paypal_lib->add_field('upload', '1');

	

	$this->paypal_lib->add_field('item_name_1', 'Item Name 1');

	$this->paypal_lib->add_field('item_number_1', '123');

	$this->paypal_lib->add_field('amount_1', '4.00');

	

	$this->paypal_lib->add_field('item_name_2', 'Item Name 2');

	$this->paypal_lib->add_field('item_number_2', '231');

	$this->paypal_lib->add_field('amount_2', '2.00');

	 

	$this->paypal_lib->image('button_01.gif');

	

	echo $this->paypal_lib->paypal_form();

	//echo $this->paypal_lib->dump();                 */

	endif;

	
if($this->cart->contents() ) { 	

?>                         



<form action="<?=$this->paypal_lib->paypal_url?>" method="post">
	<input type="hidden" name="cmd" value="_cart">
	<input type="hidden" name="upload" value="1">
	
	<!---  Paypal Info From Database 3-19-2012 --->
<?php /*?>	<input type="hidden" name="business" value="<?=$this->config->item('paypal_bussines'); ?>"><?php */?>
	<input type="hidden" name="business" value="<?=$store_info['paypal_id']?>">
	<!---  Paypal Info From Database 3-19-2012 --->
	
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="rm" value="2">   
	<input type="hidden" name="return" value="<?=base_url().index_page()?>MyShop/empty_cart">
	<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>MyShop">
	<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">	

<?php

	$i = 1; 

	foreach($this->cart->contents() as $items): ?>
		<input type="hidden" name="item_name_<?=$i?>" value="<?=$items['name']?>">
		<input type="hidden" name="quantity_<?=$i?>" value="<?=$items['qty']?>">
		<input type="hidden" name="amount_<?=$i?>" value="<?=$items['price']?>">
		<input type="hidden" name="item_number_<?=$i?>" value="<?=$items['id']?>">
		
<?php 

	 $i++;   

	 endforeach;
	$j = 1; 
	$product_id = array();
	foreach($this->cart->contents() as $items): 
	$product_id[] = $items['id'];
	$j++;   
	endforeach; 
	$ids = implode(",", $product_id);
?>
	
	
	<input type="hidden" name="custom" value="<?=$ids?>">
					

<?
	 if(isset($customer_group_data[0]['discount_type']) && $customer_group_data[0]['discount_type'] != "None" && $customer_group_data[0]['discount_type'] != "")

	 {

		if($customer_group_data[0]['discount_type'] == "Percentage") 

		 {

			 ?>

			   <input type="hidden" name="discount_rate_cart" value="<?=$customer_group_data[0]['discount_value']?>">  
			   

			 <?

		 

		 }

		 else if($customer_group_data[0]['discount_type'] == "Fixed")

		 {

			?>

			  <input type="hidden" name="discount_amount_cart" value="<?=$customer_group_data[0]['discount_value']?>">  

			<? 

		 } 

	 }

?>



<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">



</form>
<? }?>