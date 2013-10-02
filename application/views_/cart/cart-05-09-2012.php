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
$total_shipping=0;
?>

<?php if(!$this->cart->contents()):

	echo 'You don\'t have any items yet.';

else:

?>



<?php echo form_open('MyShop/update_cart');



	

 ?>

<table width="100%" cellpadding="0" cellspacing="0">

	<thead>

		<tr>

			<td>Qty</td>

			<td>Item Description</td>

			<td>Item Price</td>

			<td>Weight</td>
			
			<td>Shipping /kg</td>
			
			<td>Sub-Total</td>

		</tr>

	</thead>

	<tbody>

		<?php $i = 1; ?>

		<?php foreach($this->cart->contents() as $items): ?>

		<? 
		/*echo '<pre>';
		print_r($items);*/ 
		?>

		<?php echo form_hidden('rowid[]', $items['rowid']); ?>

		<tr <?php if($i&1){ echo 'class="alt"'; }?>>

			<td>

				<?php echo form_input(array('name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>

			</td>

			

			<td><?php echo $items['name']; ?></td>

			

			<td><?php echo $this->cart->format_number($items['price']); ?></td>
			
			<td><?php  echo $this->cart->format_number($items['weight']); ?></td>
			
			<td><?php  echo $this->cart->format_number($items['price_per_kg']); 
			
			$shiping=$items['weight']*$items['price_per_kg']*$items['qty'];
			$total=$items['subtotal']+$shiping;
			$total_shipping+=$shiping;
			
			
			?></td>

			<td><?php echo $this->cart->format_number($total); ?></td>

		</tr>

		<?php 

		  $i++;   

		endforeach; ?>

			<? 

			$grand_total = $this->cart->total()+$total_shipping;

			//echo $customer_group_data[0]['discount_type']."sfsdfsfd";

		if(isset($customer_group_data[0]['discount_type']) && $customer_group_data[0]['discount_type'] != "None" && $customer_group_data[0]['discount_type'] != "")

		{

			

			if($customer_group_data[0]['discount_type'] == "Percentage")

			{

				$dis_amount = ($customer_group_data[0]['discount_value']/100) * ($this->cart->total());			

				$grand_total = $this->cart->total()+$total_shipping - $dis_amount;				

				$dis_value = $customer_group_data[0]['discount_value']."%";

			}

			else if($customer_group_data[0]['discount_type'] == "Fixed")

			{

				$dis_amount = $customer_group_data[0]['discount_value'];			

				$grand_total = $this->cart->total()+$total_shipping - $dis_amount;

				$dis_value = $customer_group_data[0]['discount_value'];

			}		

		?>

		<tr>

			<td></td>

			<td></td>

			<td class="border-top"><strong>Sub Total:</strong></td>

			<td class="border-top"><?php echo $this->cart->format_number($this->cart->total()+$total_shipping); ?></td>

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

		

		<? } ?>

		<tr>

			<td></td>

			<td></td>
			<td></td>
			<td></td>

			<td ><strong><br />Total:</strong></td>

			<td ><strong><br /><? echo $this->cart->format_number($grand_total); ?><strong></td>

		</tr>

	</tbody>

</table>



<p><?php echo form_submit('', 'Update your Cart'); echo anchor('MyShop/empty_cart', 'Empty Cart', 'class="empty"');  //echo anchor('MyShop', 'Continue Shopping'); ?> </p>

<p><small>If the quantity is set to zero, the item will be removed from the cart.</small></p>

<?php 

	echo form_close();

	

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