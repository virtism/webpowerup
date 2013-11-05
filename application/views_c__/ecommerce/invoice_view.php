<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice View </title>
	<style>
    	.invoice_view
		{
			color:#000000;	
		}
    </style>
</head>
<body>
<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>
<h1>Invoice View </h1>
<a href="JavaScript:window.print();">Print this page</a>
<fieldset>
<legend>Invoice Details</legend>
<table width="99%" border="0" class="invoice_view" style="padding-left:5px;">
	<tr>
		<td style="padding-left:5px;">
			<table width="400" style="border:1px solid #666666;">
				<tr>
					<td>Invoice ID </td><td><?php  echo $invoice_info[0]['invoice_id']; ?></td>
				</tr>
				<tr>
					<td>Username</td><td><?php echo $admin_details[0]['user_fname'].' '.$admin_details[0]['user_lname']; ?></td>  
				</tr>
				<tr>
				<td>Company</td><td><?=$admin_details[0]['company']?></td>  
				</tr>
				<tr>
				<td>Address</td><td><?=$admin_details[0]['street_address'].', '.$admin_details[0]['city'].' '.$admin_details[0]['country'].', '.$admin_details[0]['state'].', '.$admin_details[0]['pnumber']?></td>  
				</tr>
				<tr>
					<td>Invoice Date</td><td><?php echo $invoice_info[0]['invoice_date'];  ?></td>  
				</tr>
				<tr>
					<td>Due Date </td><td><?php echo $invoice_info[0]['due_date']; ?></td>  </tr>
				<tr>
				<tr>
					<td>Type </td><td><?php if($invoice_info[0]['quote']=='yes'){ echo "Quote";}else{ echo "Invoice";}?></td>
				</tr>
				
			</table>	
		</td>
		<td align="right">
			<table  width="200" style="border:1px solid #666666;">
				<tr>
					<td colspan="2"><b>Customer Detail</b></td>  
				</tr>				
				<tr>
					<td colspan="2">Bill To: </td>  
				</tr>				
				<tr>
					<td>Name </td><td><?php  echo $customer_detail['customer_fname']." ".$customer_detail['customer_lname']; ?></td>
				</tr>
				<tr>
					<td>Company</td><td><?php echo $customer_detail['customer_company']; ?></td>  
				</tr>
				<tr>
					<td>Email</td><td><?php echo $customer_detail['customer_email'];  ?></td>  
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding-top:25px;" colspan="2">
			<table  id="invoice_table" width="100%" border="0">
				  <tr>
					<th scope="col">Product/Service</th>
					<th scope="col">Description</th>
					<th scope="col">Unit Cost</th>
					<th scope="col">Quantity</th>
					<th scope="col">Discount</th>
					<th scope="col">Tax 1</th>
					<th scope="col">Tax 2</th>
					<th scope="col">Price</th>
				  </tr>
				  <? for($i = 0; $i<$count; $i++)
				  {?>
				  <tr align="center">
				  	<td><?php if(isset($product_detail[$i]['product'])) { echo $product_detail[$i]['product']; } ?></td>
					<td><?php if(isset($invoice_info[$i]['description'])) { echo $invoice_info[$i]['description']; } ?></td>
					<td><?php if(isset($product_detail[$i]['list_price'])) { echo $product_detail[$i]['list_price']; } ?></td>
					<td><?php if(isset($invoice_info[$i]['quantity'])) { echo $invoice_info[$i]['quantity']; } ?></td>
					<td><?php if(isset($invoice_info[$i]['discount'])) { echo $invoice_info[$i]['discount']."%"; } ?></td>
					<td><?php if(isset($invoice_info[$i]['taxone'])) { echo $invoice_info[$i]['taxone']."%"; } ?></td>
					<td><?php if(isset($invoice_info[$i]['taxtwo'])) { echo $invoice_info[$i]['taxtwo']."%"; } ?></td>
					<td><?php if(isset($invoice_info[$i]['price'])) { echo $invoice_info[$i]['price']; } ?></td>
				  </tr>
				  <? } ?>
			</table>
		</td>	
	</tr>
	<tr>
		<td style="padding-top:20px; padding-right:10px;" colspan="2">
			<table align="right"> 
			  <tr>
				<td ><label>Subtotal: </label></td>
				<td ><div id="subtotal"><?php echo $invoice_info[0]['subtotal'];?></div></td>
			  </tr>
			  <tr>
				<td  style="font-weight:bold;"><label>Net Total: </label></td>
				<td  style="font-weight:bold;"><div id="total"><?php echo $invoice_info[0]['total'];?></div></td>
			  </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" >
			<strong>Terms & Conditions</strong>
			<br>
			<?php  echo $invoice_info[0]['terms_conditions']; ?>
			<br>
		</td>			
	</tr>
	<tr>
		<td align="left" >
			<br>		
			<strong>Invoice Notes</strong>
			<br>
			<?php  echo $invoice_info[0]['invoice_notes']; ?>
		</td>
	</tr>
</table>
</fieldset>

</body>
</html>