<h2>Invoices</h2>
<script>
function popUp(invoice_id) 
{
	var url = "<?=base_url().index_page()?>MyAccount/create_view_invoice/"+invoice_id;
    var  popupWindow = window.open(url,'','height=600,width=600,left=0,top=0,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=no');
}
</script>
<div id="invoice" style="">
<style type="text/css">
.th_style
{
width:80px;
background:#CCCCCC;
}
</style>
<?php
echo "<pre>";
//print_r($invoices);
$count = sizeof($invoices);
echo "</pre>";
if ($count > 0)
{
	?>
	
	<h1>My Invoices</h1>
	<table align="center">
	<th class="th_style">Serial</th>
	<th class="th_style">Invoice Id</th>
	<th class="th_style">Invoice Date</th>
	<th class="th_style">Due Date</th>
	<th class="th_style">Total Amount</th>
    <th class="th_style">Actions</th>
    <th class="th_style">Status</th>    
	<?php
	
	for($i=0; $i<$count; $i++)
	{
		?>
			<tr>
			<td><?php echo $i+1; ?></td>
			<td><?=$invoices[$i]['invoice_id']?></td>
			<td><?=$invoices[$i]['invoice_date']?></td>
			<td><?=$invoices[$i]['due_date']?></td>
			<td><?=$invoices[$i]['total']?></td>
            <td style="white-space:nowrap;">
            <? //echo "<pre>";print_r($customer_detail);?>
            	<a href="<?=base_url().index_page()?>MyAccount/create_view_invoice/<?=$invoices[$i]['invoice_id']?>">Print</a> |
                <a target="_blank" href="<?=base_url().index_page()?>MyAccount/create_pdf_invoice/<?=$invoices[$i]['invoice_id']?>">Pdf</a> | 
                <a onClick="popUp(<?=$invoices[$i]['invoice_id']?>)" href="javascript:void(0)">View</a><? if($invoices[$i]['quote']!='yes'){ ?> | 
               
                <form action="<?=$this->paypal_lib->paypal_url?>" method="post" id="payPalRegForm" >
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="<?=$payPal_id?>">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="rm" value="2">   
						<input type="hidden" name="return" value="<?=base_url().index_page()?>MyAccount/submit_payment/<?=$site_id?>/<?=$invoices[$i]['invoice_id']?>" >
						<input type="hidden" name="cancel_return" value="<?=base_url().index_page()?>MyAccount">
						<input type="hidden" name="notify_url" value="<?=base_url().index_page()?>paypal/ipn">      
						<input type="hidden" name="item_name" value="Charged Amount for Customer <?=$customer_detail['customer_fname'].' '.$customer_detail['customer_lname']?>">
						<!--  <input type="hidden" name="item_number" value="786"> -->
						<input type="hidden" name="quantity" value="1">
						<input type="hidden" name="amount" value="<?php if(isset($invoices[$i]['total'])){ echo '$'.$invoices[$i]['total'];}else if(isset($invoices[$i]['total'])){ echo '$'.$invoices[$i]['total']; }?>">
                        
						<input type="hidden" name="item_number" value="<?=$invoices[$i]['invoice_id']?>">
                        <input type="hidden" name="custom" value="<?=$invoices[$i]['customer_id']?>" />
                        <!-- <input style="width:60px;" type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">-->
                       
                       <a href="#" onclick="$(this).closest('form').submit();">Pay</a>
					</form>	
                    <? } ?>
            </td>
            <td align="center"><b><? if($invoices[$i]['quote']!='yes'){ echo $invoices[$i]['status']; }else { echo "Quote";}?></b></td>
			</tr>
		 <?php
	}
	?>
	</table>
<?php    
}
else
{
	echo "No invoices Generated on your behalf.";
}
?>
</div>