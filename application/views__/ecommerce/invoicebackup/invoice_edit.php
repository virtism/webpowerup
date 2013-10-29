<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style>
.main-heading
{
	color:#FF0000;
}
.help
{
	font-weight:bold;
	font-size:16px;
}
#groups_customres
{
	
}
.groups_customres #customers
{
	opacity:1;
}
</style>
<title>Invoice</title>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
$(function() {
$( "#inovice_date" ).datepicker();
});
$(function() {
$( "#due_date" ).datepicker();
});
$(function() {
$( "#recurring_start_date" ).datepicker();
});
$(function() {
$( "#recurring_end_date" ).datepicker();
});
//get all site customers registerd or groups
function get_all_site_customers()
{
		
		var path =  "<?=base_url().index_page()?>invoice/ajax_call_customers/";
		var dataString = 'data';
		//alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#groups_customres").html(data);
				$("#groups_customres").show();
				//alert("success");
			}
		});
}
function new_customers()
{
	$("#groups_customres").hide();
}
</script>
<script>
//getting ajax call for customer detail
	function get_customer_detail()
	{
		var customer_id = document.getElementById('customers').value;
		var path =  "<?=base_url().index_page()?>invoice/ajax_call_customers_detail/";
		var dataString = "customer_id = "+customer_id;
		//alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#customers_detail").html(' ');
				//alert(data);
				//$("#customers_detail").show();
				$("#customers_detail").html("<table id='customers_detail'  width='100%'>"+data+"</table>");
				//alert("success");
			}
		});
	}
// getting ajax call for state on base of country selected	
	function get_ajax_states()
	{
		var country_id = document.getElementById('country').value;
		var path =  "<?=base_url().index_page()?>invoice/ajax_call_states/";
		var dataString = "country_id = "+country_id;
		//alert( path);
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
	
	function get_ajax_product_data($number)
	{
		var product_id = document.getElementById('product'+$number).value;
		
		var path =  "<?=base_url().index_page()?>invoice/get_ajax_product_data/";
		var dataString = "product_id = "+product_id;
		//alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#ucost"+$number).val(data);
				//alert(data);
				//$("#customers_detail").show();
				//$("#state_option").html(data);
				//alert("success");
			}
		});		
	}
		
	function delete_row(row)
	{
		$('#row'+row).remove();
	}
	function recurring_block(flag)
	{
		var data = flag;
		var falg = $('#'+data).val();
		if(falg=='yes')
		{
			$('#recurring-block').show();
		}
		else
		{
			$('#recurring-block').hide();
		}
	}
</script>


<script>

//Calculation Invoice
function roundNumber(number,decimals) {
  var newString;// The new rounded number
  decimals = Number(decimals);
  if (decimals < 1) {
    newString = (Math.round(number)).toString();
  } else {
    var numString = number.toString();
    if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
      numString += ".";// give it one at the end
    }
    var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
    var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
    var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
    if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
      if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
        while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
          if (d1 != ".") {
            cutoff -= 1;
            d1 = Number(numString.substring(cutoff,cutoff+1));
          } else {
            cutoff -= 1;
          }
        }
      }
      d1 += 1;
    } 
    if (d1 == 10) {
      numString = numString.substring(0, numString.lastIndexOf("."));
      var roundedNum = Number(numString) + 1;
      newString = roundedNum.toString() + '.';
    } else {
      newString = numString.substring(0,cutoff) + d1.toString();
    }
  }
  if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
    newString += ".";
  }
  var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
  for(var i=0;i<decimals-decs;i++) newString += "0";
  //var newNumber = Number(newString);// make it a number if you like
  return newString; // Output the result to the form field (change for your purposes)
}



//Calculation Invoice
function calculation()
{
	//alert(document.getElementById('invoice_table').rows.length);
	var count = document.getElementById('invoice_table').rows.length;
	var subtotal = 0;
	var discount = 1;
	
	for(var i = 1; i<count; i++)
	{
		var item_total = document.getElementById('quantity'+i).value * document.getElementById('ucost'+i).value ;
		
		// Calculate Discount
		if (!isNaN(document.getElementById('discount'+i).value))
		{ 
			discount = Number(document.getElementById('discount'+i).value);
			item_total = item_total - discount*(0.01)*item_total;
		}
		
		//Calculate Tax 1
		if (!isNaN(document.getElementById('taxone'+i).value))
		{ 
			taxone = Number(document.getElementById('taxone'+i).value);
			item_total = item_total + taxone*(0.01)*item_total;
		}
		
		//Calculate Tax 2
		if (!isNaN(document.getElementById('taxtwo'+i).value))
		{ 
			taxtwo = Number(document.getElementById('taxtwo'+i).value);
			item_total = item_total + taxtwo*(0.01)*item_total;
		}
		
		document.getElementById('price'+i).value = roundNumber(item_total,2);
		
		
		if (!isNaN(document.getElementById('price'+i).value)) subtotal += Number(document.getElementById('price'+i).value);		
		//subtotal = subtotal+document.getElementById('price'+i).value; 
		//alert(i);
	}
	//alert(subtotal);
	document.getElementById('subtotal').innerHTML = roundNumber(subtotal,2);
	document.getElementById('total').innerHTML =  roundNumber(subtotal,2);
	$('#hidden_subtotal').val(subtotal);
  	$('#hidden_total').val(subtotal);
				
}

//Fucntion will create new row and append in table

	var numImages = <?=$count?>;
	
	$(document).ready(function() {
		$('#addnewrow').click(function(){
		
			numImages++;	
			//Create new row		
			var html ='<tr id= "row'+numImages+'"><td><a onclick="delete_row('+numImages+')" href="javascript: void(0);"><img  src="<?=base_url()?>/images/remove.png" /></a></td><td><select onchange="get_ajax_product_data('+numImages+')" id="product'+numImages+'" name="product'+numImages+'" style="opacity: 1;"><? foreach($products as $key => $product){ echo "<option value=".$key.">".$product."</option>";}	?></select></td><td><input id="description'+numImages+'" name="description'+numImages+'" type="text" /></td><td><input id="ucost'+numImages+'" name="ucost'+numImages+'" type="text" /></td><td><input id="quantity'+numImages+'" name="quantity'+numImages+'" type="text" /></td><td><input id="discount'+numImages+'" name="discount'+numImages+'" type="text" /></td><td><input id="taxone'+numImages+'" name="taxone'+numImages+'" type="text" /></td><td><input id="taxtwo'+numImages+'" name="taxtwo'+numImages+'" type="text" /></td><td><input id="price'+numImages+'" name="price'+numImages+'" type="text" /></td></tr>';
		   
			$('table#invoice_table').append(html); 
			document.getElementById('count').value = numImages;
		});
	});

</script>
</head>
<body>
<div>
<form  action="<?=base_url().index_page()?>invoice/edit_invoice_data"  enctype="multipart/form-data" method="post" id="form" >

	<h1 class="main-heading">Edit an Invoice</h1>
	<fieldset>
	<p>This wizard allows you to create an order in your online store.<br /><br />Follows the nubered items below to create the order. For help with a specific item, place your cursor over the blue help icon that is located deside the title of each item. Also, you can right-click anywhere on the page choose "Apply" to save  your progress.</p>
	<table width="100%">
		<tr>
			<td>
					<? 
					/*echo "<pre>";
					print_r($invoice_info);
					echo $invoice_info[0]['username'];
					exit;*/
						if(isset($invoice_info[0]['username']))
						{
							echo "<b style='font-size:16px; font-weight:bold;'>Biller: ".$invoice_info[0]['username']."</b>";
							echo "<input type='hidden' name='main_username' id='main_username' value=".$invoice_info[0]['username'].">";
						}
					?>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td><p class="help" style="float:left;">Customer Information</p></td>
						<?php /*?><td> <img  src="<?=base_url()?>/images/q.png" /></td><?php */?>
					</tr>
				</table>				
			</td>
		</tr>
		<tr>
			<td >
				<table width="100%">
					<tr>
						<td>
							<fieldset style="width:400px;">
								<legend style="font-weight:bold;">Customer Type</legend>
									<table border="0" align="left" cellpadding="2" cellspacing="3" bgcolor="#F9F9F9">
										<tr>
											<td>
												<span><input type="radio"  value="existing" <?php if($invoice_info[0]['customer_type']=='existing'){ echo 'checked' ; }  ?>   name="customer_type"  id="customer_type" style="opacity: 1;" onclick="get_all_site_customers()" > Existing Customer</span>
												<input type="hidden" name="hidden_customer" value="<?php if(isset($invoice_info[0]['customer_id'])){  echo $invoice_info[0]['customer_id'];   }  ?>"/>
												<input type="hidden" name="invoice_id" value="<?php if(isset($invoice_info[0]['invoice_id'])){  echo $invoice_info[0]['invoice_id'];   }  ?>"/>
											</td>
										</tr>
										<tr>
											<td>
												<div style="opacity: 1;" id="groups_customres" class="groups_customres"></div>
											</td>
										</tr>
										<tr>
											<td>
												<span><input type="radio" value="new_customer"  name="customer_type" id="new_customer" style="opacity: 1;" onclick="new_customers()" <?php if($invoice_info[0]['customer_type']=='new_customer'){ echo 'checked' ; }  ?>  /> New Customer</span>
												
											</td>
										</tr>
									</table>						
							</fieldset>
						</td>
						<td>
							<table align="right">
								<tr>
									<td><span class="required">&nbsp;</span>Inovice Date: </td>
									<td><input id="inovice_date" name="inovice_date" type="text" value="<?php if(isset($invoice_info[0]['invoice_date'])){  echo $invoice_info[0]['invoice_date'];   }  ?>" /></td>
								</tr>
								<tr>
									<td>Payment Terms: </td>
									<td><input id="payment_ters" name="payment_ters" type="text" value="<?php if(isset($invoice_info[0]['payment_term'])){  echo $invoice_info[0]['payment_term'];   }  ?>" /></td>
								</tr>
								<tr>
									<td>Due Date: </td>
									<td><input id="due_date" name="due_date" type="text" value="<?php if(isset($invoice_info[0]['due_date'])){  echo $invoice_info[0]['due_date'];   }  ?>"/></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>	
		</tr>
		<tr>
			<td>
				<fieldset>
					<legend style="font-weight:bold;">Customer Details</legend>
					<table id="customers_detail"  width="100%">
						<tr>
							<td>
								<table >
									<tr>
										<td>First Name: </td>
										<td><input id="fname" name="fname" type="text"  value="<?php if(isset($customer_detail['customer_fname'])){  echo $customer_detail['customer_fname'];   }  ?>" /></td>
									</tr>
									<tr>
										<td>Last Name: </td>
										<td><input id="lname" name="lname" type="text" value="<?php if(isset($customer_detail['customer_lname'])){  echo $customer_detail['customer_lname'];   }  ?>" /></td>
									</tr>
									<tr>
										<td>Company: </td>
										<td><input id="company" name="company" type="text" value="<?php if(isset($customer_detail['customer_company'])){  echo $customer_detail['customer_company'];   }  ?>"/></td>
									</tr>
									<tr>
										<td>Email: </td>
										<td><input id="email" name="email" type="text" value="<?php if(isset($customer_detail['customer_email'])){  echo $customer_detail['customer_email'];   }  ?>"/></td>
									</tr>
									<tr>
										<td>Phone Number: </td>
										<td><input id="pnumber" name="pnumber" type="text" value="<?php if(isset($customer_book['address_book_phone'])){  echo $customer_book['address_book_phone'];   }  ?>"/></td>
									</tr>
								</table>
							</td>
							<td>
								<table align="right">
									<tr>
										<td>Street Address: </td>
										<td><input id="saddress" name="saddress" type="text" value="<?php if(isset($customer_book['address_book_country'])){  echo $customer_book['address_book_country'];}?>"/></td>
									</tr>
									<tr>
										<td>country: </td>
										<td>
											<select id="country" name="country" style="opacity: 1;" onchange="get_ajax_states()">
													<? foreach($countries as $country) 
													{
														echo "<option value=".$country['countries_id'].">".$country['countries_name']."</option>";
													}
													?>													
											</select>											
										</td>
									</tr>
									<tr>
										<td>State/Province</td>
										<td id="state_option">
											<!--<input id="state" name="state" type="text" />-->
											<select id="state" name="state" style="opacity: 1;">
													<? foreach($states as $state) 
													{
														echo "<option value=".$state['zone_code'].">".$state['zone_name']."</option>";
													}
													?>													
											</select>	
										</td>
									</tr>
									<tr>
										<td>City: </td>
										<td><input id="address_book_city" name="address_book_city" type="text" value="<?php if(isset($customer_book['address_book_city'])){  echo $customer_book['address_book_city'];}?>"/></td>
									</tr>
									<tr>
										<td>ZIP/Postal Code: </td>
										<td><input id="address_book_zipcode" name="address_book_zipcode" type="text" value="<?php if(isset($customer_book['address_book_zipcode'])){  echo $customer_book['address_book_zipcode'];}?>"/></td>
									</tr>
								</table>
						   </td>
						</tr>
					</table>
				</fieldset>
			 </td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td><p class="help" style="float:left;">Product & Services</p></td>
						<?php /*?><td> <img  src="<?=base_url()?>/images/q.png" /></td><?php */?>
					</tr>
				</table>				
			</td>
		</tr>
		<tr>
			<td>
			<fieldset>
				<table onclick="calculation()" id="invoice_table" width="100%" border="0">
				  <tr>
					<th scope="col">&nbsp;</th>
					<th scope="col">Product/Service</th>
					<th scope="col">Description</th>
					<th scope="col">Unit Cost</th>
					<th scope="col">Quantity</th>
					<th scope="col">Discount (%)</th>
					<th scope="col">Tax 1 (%)</th>
					<th scope="col">Tax 2 (%)</th>
					<th scope="col">Price</th>
				  </tr>
				  <?php for($i=0; $i <$count; $i++){ $j = $i+1; ?>
				  <tr>
					<td><img  src="<?=base_url()?>/images/remove.png" /></td>
					<td>					
					<select id="product<?=$j?>" name="product<?=$j?>" onchange="get_ajax_product_data(<?=$j?>)" style="opacity: 1;">
						<? foreach($products as $key => $product) 
						{
							if($invoice_info[$i]['product_id']==$key)
							{
								echo "<option selected value=".$key.">".$product."</option>";
							}
							else
							{
								echo "<option value=".$key.">".$product."</option>";
							}
						}
						?>						
					</select>			
					</td>
					<td>
						<input id="description<?=$j?>" name="description<?=$j?>" type="text"  value="<?php if(isset($invoice_info[$i]['description'])){  echo $invoice_info[$i]['description'];}?>"/>
					</td>
					<td>
						<input class="cost" id="ucost<?=$j?>" name="ucost<?=$j?>" type="text" value="<?php if(isset($invoice_info[$i]['unit_cost'])){  echo trim($invoice_info[$i]['unit_cost']);}?>"/>
					</td>
					<td>
						<input class="qty" id="quantity<?=$j?>" name="quantity<?=$j?>" type="text" value="<?php if(isset($invoice_info[$i]['quantity'])){  echo $invoice_info[$i]['quantity'];}?>"/>
					</td>
					<td>
						<input id="discount<?=$j?>" name="discount<?=$j?>" type="text" value="<?php if(isset($invoice_info[$i]['discount'])){  echo $invoice_info[$i]['discount'];}?>"/>
					</td>
					<td>
						<input id="taxone<?=$j?>" name="taxone<?=$j?>" type="text" value="<?php if(isset($invoice_info[$i]['taxone'])){  echo $invoice_info[$i]['taxone'];}?>"/>
					</td>
					<td><input id="taxtwo<?=$j?>" name="taxtwo<?=$j?>" type="text" value="<?php if(isset($invoice_info[$i]['taxtwo'])){  echo $invoice_info[$i]['taxtwo'];}?>"/></td>
					<td><input class="price" id="price<?=$j?>" name="price<?=$j?>" type="text" value="<?php if(isset($invoice_info[$i]['price'])){  echo $invoice_info[$i]['price'];}?>"/>
					</td>
				  </tr>
				  <? }?>
				  </table>
				  <table width="100%" border="0" onclick="calculation()">
				  <tr>
						<td colspan="4"><input id="addnewrow" name="addnewrow" value="Add New Row"  type="button" /></td>
						<td colspan="5"  align="right">
							<table align="right">
							  <tr>
								<td colspan="4"><label>Subtotal: </label></td>
								<td colspan="5"><div id="subtotal"><?php if(isset($invoice_info[0]['subtotal'])){  echo round($invoice_info[0]['subtotal'],2);}else{ echo "0.00"; }?></div><input  type="hidden" value="<?php if(isset($invoice_info[0]['subtotal'])){  echo round($invoice_info[0]['subtotal'],2);}?>" id="hidden_subtotal" name="hidden_subtotal"/></td>
							  </tr>
							  <tr>
								<td colspan="4"><label>Total: </label></td>
									<td colspan="5" ><div id="total"><?php if(isset($invoice_info[0]['subtotal'])){  echo round($invoice_info[0]['subtotal'],2);}else{ echo "0.00"; }?></div><input type="hidden" id="hidden_total" value="<?php if(isset($invoice_info[0]['subtotal'])){  echo round($invoice_info[0]['subtotal'],2);}?>" name="hidden_total"/></td>
							  </tr>
							  <tr>
								<td colspan="4" style="font-weight:bold;"><strong>Net Balance: </strong></td>
								<td colspan="5" style="font-weight:bold;"><strong>0.00 <input type="hidden" name="net_total"/></strong></td>
							  </tr>
							  <tr>
								<td colspan="9" ><input name="checkbox"  type="checkbox" id="p" style="opacity: 1;" />
									<small style="padding-left:5px;">Allow clint to make partial payment for this invoice</small></td>
							  </tr>
							</table>
						</td>
				  </tr>			  
			 </table>				
			</fieldset>			
			</td>
		</tr>
		<tr>
			<td>
				<fieldset>
				<legend style="font-weight:bold;">Recurring Invoice</legend>
					<? //echo "----".$invoice_info[0]['recurring']; ?>
					<span><input onclick="recurring_block('recurring_yes')" type="radio" id="recurring_yes" value="yes" name="recuring" <? $show = '';  if($invoice_info[0]['recurring']=='yes'){?> checked="checked"<? }?>  style="opacity: 1;"> YES</span>&nbsp;
					<span><input onclick="recurring_block('recurring_no')" type="radio" id="recurring_no"  <?  if($invoice_info[0]['recurring']!='yes'){?> checked="checked"<? }?>  value="no" name="recuring"   style="opacity: 1;"> NO</span>
					<table id="recurring-block" <?  if($invoice_info[0]['recurring']!='yes'){ ?> style="display:none;"<? }?> width="100%">
						<tr>
							<td>
								<table >
									<tr>
										<td>Recurring Title: </td>
										<td><input id="recurring_username" name="recurring_username" type="text" value="<?php if(isset($invoice_info[0]['recurring_username'])){  echo $invoice_info[0]['recurring_username'];   }  ?>"/></td>
									</tr>
									<tr>
										<td>Purchase Order No: </td>
										<td><input id="recurring_order_number" name="recurring_order_number" type="text" value="<?php if(isset($invoice_info[0]['recurring_order_number'])){  echo $invoice_info[0]['recurring_order_number'];   }  ?>"/></td>
									</tr>
									<tr>
										<td><span class="required">&nbsp;</span>Occurrences: </td>
										<td><input id="recurring_occurrences" name="recurring_occurrences" type="text" value="<?php if(isset($invoice_info[0]['recurring_occurrences'])){  echo $invoice_info[0]['recurring_occurrences'];   }  ?>"/><br/>(Enter 0 to bill forever)</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>									
								</table>
							</td>
							<td>
								<table align="right">
									<tr>
										<td>Start Date: (YYYY-MM-DD) </td>
										<td><input id="recurring_start_date" name="recurring_start_date" type="text" value="<?php if(isset($invoice_info[0]['recurring_start_date'])){  echo $invoice_info[0]['recurring_start_date'];   }  ?>"/></td>
									</tr>
									<tr>
										<td>End Date: (YYYY-MM-DD) </td>
										<td><input id="recurring_end_date" name="recurring_end_date" type="text" value="<?php if(isset($invoice_info[0]['recurring_end_date'])){  echo $invoice_info[0]['recurring_end_date'];   }  ?>"/></td>
									</tr>
									<tr>
										<td>Email biller after each recurrence: </td>
										<td><input id="recurring_biller_email" name="recurring_biller_email" type="text" value="<?php if(isset($invoice_info[0]['recurring_biller_email'])){  echo $invoice_info[0]['recurring_biller_email'];   }  ?>"/></td>
									</tr>
									<tr>
										<td>Email customer after each recurrence: </td>
										<td><input id="recurring_customer_email" name="recurring_customer_email" type="text" value="<?php if(isset($invoice_info[0]['recurring_customer_email'])){  echo $invoice_info[0]['recurring_customer_email'];   }  ?>"/></td>
									</tr>									
								</table>
						   </td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<fieldset>
					<legend style="font-weight:bold;">Notes</legend>
					<table  width="100%">
						<tr>
							<td><label>Terms & Conditions</label></td>
							<td><label>Invoice Notes</label></td>
						</tr>
						<tr>
							<td><textarea name="termsconditions" rows="5" cols="5"><?php if(isset($invoice_info[0]['terms_conditions'])){  echo $invoice_info[0]['terms_conditions'];}?></textarea></td>
							<td><textarea name="invoicenotes" rows="5" cols="5"><?php if(isset($invoice_info[0]['invoice_notes'])){  echo $invoice_info[0]['invoice_notes'];}?></textarea></td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td><p class="help" style="float:left;">Save As Draft</p></td>
						<?php /*?><td> <img  src="<?=base_url()?>/images/q.png" /></td><?php */?>
					</tr>
				</table>				
			</td>
		</tr>
		<tr>
			<td>
				<fieldset>
					<legend style="font-weight:bold;">Recurring Invoice</legend>
					<span style="font-weight:bold;"><input type="radio" <?php if($invoice_info[0]['quote']=='yes'){ echo 'checked' ; }  ?> value="yes" name="quote"  style="opacity: 1;">SAVE AS QUOTE</span>
				</fieldset>
			</td>
		</tr>
	</table>
	<input id="create" name="create" value="Save As Draft"  type="submit" />
	<input type="hidden" id="count" name="numInvoice" value="1" />
	</fieldset>	
</form>	
</div>
</body>
</html>