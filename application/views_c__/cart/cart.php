<?php //echo "hskjdhfkd"; exit;?>
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
		var total = 0;
		var i = 1;
		var country_id = document.getElementById('country').value;
		var state_id = document.getElementById('state').value;
		//var total_weight = document.getElementById('total_weight').value;		
		var total_products = document.getElementById('total_products').value;		
		//alert(total_products);
		for(i=1; i<=total_products; i++)
		{
			//alert(i);
			(function(i) {
			var product_wight = document.getElementById('product_wight_'+i).value;
			var shipping_rate = document.getElementById('shipping_rate_'+i).value;
			var path =  "<?=base_url().index_page()?>MyShop/ajax_call_shipping_rates/";
			var dataString = "country_id="+country_id+"&state_id="+state_id+"&total_weight="+product_wight;
		
			$.ajax({
				url: path, 
				data: dataString,
				type:'POST', 
				success: function(data){
				
					$("#shipping_rate_"+i).html('');
					$("#shipping_rate_"+i).html(data);
					//var hidden_total = document.getElementById('hidden_total').value;
					var sub_total = Number($("#pro_sub_total_"+i).html()) + Number(data);
					$("#pro_sub_total_"+i).html(sub_total);
					document.getElementById('shipping_'+i).value = data;
					calculate_total(i);	
				}
				
				});
			})(i);		
			
		}
		//total = Number(total) + Number(hidden_total);
		
		
	}
	function calculate_total(n){ 
	//alert(n);
		var total = 0;
		for(var i=1; i<=n; i++)
		{
			total = total + Number($("#pro_sub_total_"+i).html());
			//$('#shipping_'+i).val('10');
			
			//alert(document.getElementById('shipping_').value);
		
		}
		
		$("#grand_sub_total").html(total);
		$("#grand_total").html('<strong ><br/>'+total+'</strong>');
		document.getElementById('hidden_total').value = total;
		//$('.payable_amount').val(total);		
	
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
<h2>My Cart</h2><br />
<?php 
$total_weight=0;

?>

<?php if(!$this->cart->contents()):

	echo 'You don\'t have any items yet.';

else:

?>


 <?php if($this->config->item('seo_url') == 'On'){?>
         <?php echo form_open('http://'.$_SERVER['SERVER_NAME'].'MyShop/update_cart');
         $tax_product = 0;
         ?>
 <?php }else{?>
         <?php echo form_open('MyShop/update_cart');
         $tax_product = 0;
         ?>
 <?php }?>
<?php /*?><table width="500">
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
														echo "<option value=".$country['countries_id'].">".$country['countries_name']."</option>";
													}
													?>													
											</select>											
										</td>
									</tr>
									<tr>
										<td>State/Province</td>
										<td id="state_option">
											<select id="state" name="state" style="opacity: 1;" onChange="get_ajax_shipping_rates()">
														<option value="select" >Select</option>
													<? foreach($states as $state) 
													{
														$state['zone_name'] = str_replace(" ","-",$state['zone_name']);
														echo "<option value=".$state['zone_name'].">".$state['zone_name']."</option>";
													}
													?>													
											</select>	
										</td>
									</tr>						
</table><?php */?>
<!--<br clear="all" />
<br clear="all" />
<br clear="all" />-->
<table width="100%" cellpadding="0" cellspacing="0" >

	<thead>

		<tr>

			<td><b>Qty</b></td>

			<td><b>Item Description</b></td>

			<td><b>Item Price</b></td>

			<!--<td>Weight(in kg)</td>-->
			
			<td><b>Tax</b></td>
			
		   <!-- <td>Shipping</td>-->
			
			<td><b>Sub-Total</b></td>

		</tr>

	</thead>

	<tbody>

		<?php $i = 1; 
				$grand_total = 0;
		?>
<? //echo "<pre>";print_r($this->cart->contents());  ?>
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
			
			<?php /*?><td><input type="hidden"  id="product_wight_<?=$i?>" value="<?php  echo $this->cart->format_number($items['weight']); ?>" /><?php  echo $this->cart->format_number($items['weight']); ?></td><?php */?>
			
			<td><?php  if(isset($items['is_taxable']) && $items['is_taxable']=='Yes'){  echo $this->cart->format_number($items['tax'])."%"; }?></td>
			<?php /*?><td><div id='shipping_rate_<?=$i?>' align="center"></div></td><?php */?>
			<td><div id="pro_sub_total_<?=$i?>"><?php  if(isset($items['is_taxable']) && $items['is_taxable']=='Yes'){  echo $pro_sub_total = $this->cart->format_number($items['subtotal'] + (($items['tax']/100)*$items['subtotal']));} else{ echo $pro_sub_total = $this->cart->format_number($items['subtotal']) ;}?></div></td>
			

		</tr>
		<?  
				$tax_product += (($items['tax']/100)*$items['subtotal']); 
				$grand_total += $items['subtotal'] + (($items['tax']/100)*$items['subtotal']);
				
			?>
		<?php 
		//echo "<pre>";
		//print_r($items);
		   /*if($items['is_free'] == 'No')
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
			
			}*/
			
		  $i++;   

		endforeach; 
		
		//echo $tax_product +=$this->cart->format_number((($items['tax']/100)*$items['subtotal'])).'===================' ;
			//	echo $this->cart->format_number($grand_total).'-----------------';
				//echo $pro_sub_total.'*****';
				//exit; 
		?>
<input type="hidden" name="total_products" id="total_products" value="<?=$i-1?>" />
			<? 
			//echo "<pre>";print_r($items);exit;
			//$grand_total = $this->cart->total();

			//echo $customer_group_data[0]['discount_type']."sfsdfsfd";
			
		//echo "sdfsfsdfsdfsdfsdfsdfsdf____________".$this->cart->total()."--------------".$customer_group_data[0]['discount_type'];
	 /*?>	if(isset($customer_group_data[0]['discount_type']) && $customer_group_data[0]['discount_type'] != "None" && $customer_group_data[0]['discount_type'] != "")

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
		 ?><?php */?>
   
		<tr>

			<td></td>
			<td></td>
			<td></td>
			<td><strong><br />Total Tax:</strong></td>
		   <?php /*?> <input type="hidden" name="total_weight" id="total_weight" value="<? echo $total_weight; ?>" /><?php */?>
			<td align="left"><strong><br /><? if(isset($tax_product) && $tax_product !=''){ echo '$';}?><? echo $this->cart->format_number($tax_product); ?><strong></td>
	   </tr> 
	   <tr>
			<td></td>
			<td></td>
			<td></td>
			<td ><strong><br />Total:</strong></td>
			 <input type="hidden" name="hidden_total" id="hidden_total" value="<? echo $grand_total; ?>" />
			<td ><strong ><br/><div id="grand_sub_total">$<? echo $grandtotal =  $this->cart->format_number($grand_total);  ?> </div><strong> </td>
			
		</tr>
 <tr>
			<td></td>
			<td></td>
			<td></td>
			<td ><strong><br />Net Total:</strong></td>
			<td id="grand_total"><strong ><br/>$<? echo $this->cart->format_number($grand_total); ?> <strong> </td>
			
		</tr>
	</tbody>

</table>



<input class="myButton" type="submit" value="Update your Cart" name="Update your Cart" />
<?php //echo form_submit('', 'Update your Cart');?>
<?php if($this->config->item('seo_url') == 'On'){?>
    <?php echo anchor('http://'.$_SERVER['SERVER_NAME'].'MyShop/empty_cart', 'Empty Cart', 'class="empty"');  //echo anchor('MyShop', 'Continue Shopping'); ?>
<?php }else{?>
    <?php echo anchor('MyShop/empty_cart', 'Empty Cart', 'class="empty"');  //echo anchor('MyShop', 'Continue Shopping'); ?>
<?php }?>
  </form>
<? echo form_close();
 echo form_open('MyShop/index');
 ?>
 <br />
 <input class="myButton" type="submit" value="Add more Products" name="Add more Products" />
 <?
 //echo form_submit('', 'Add more Products');
 echo form_close();
 ?>


<?php 


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
	<?php if($this->config->item('seo_url') == 'On')
    {?>
        <input type="hidden" name="return" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'];?>/MyShop/empty_cart">
        <input type="hidden" name="cancel_return" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'];?>/MyShop">
    <?php 
    }
    else
    {
    ?>   
        <input type="hidden" name="return" value="<?=base_url().index_page()?>MyShop/empty_cart">
        <input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>MyShop">
    <?php }?>
	<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">	

<?php
//echo "<pre>"; print_r($items);exit;
	$i = 1; 
	//echo "<pre>";
//print_r($this->cart->contents());
	foreach($this->cart->contents() as $items): ?>
		<input type="hidden" name="item_name_<?=$i?>" value="<?=$items['name']?>">
		<input type="hidden" name="quantity_<?=$i?>" value="<?=$items['qty']?>">
		<input type="hidden" name="amount_<?=$i?>" value="<?=$items['price']?>">
		<input type="hidden" name="shipping_<?=$i?>" id="shipping_<?=$i?>" value="" >
		<input type="hidden" name="tax_<?=$i?>" value="<?=$items['price']*($items['tax']/100)?>">
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
<? if(isset($_SESSION['login_info']['customer_id']) && !empty($_SESSION['login_info']['customer_id']))
	{ ?>

		<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">

<?   } else
	{?>
	
		<a  class="myButton" href="<?=base_url()?>MyAccount/login" >Please Login Before Checkout</a>
	
	<? }?>
	<p><small>If the quantity is set to zero, the item will be removed from the cart.</small></p>

</form>
<? }?>