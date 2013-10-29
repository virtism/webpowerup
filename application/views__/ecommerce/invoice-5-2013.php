<style>
.addRowAlign
{
	 height: auto !mportant; 
	 line-height: 40px;
	  padding: 5px 0; 
	  vertical-align: middle;
}
.abc{
	
	display: block;
	overflow: auto;
	height: 100px;
	
	}
</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
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
				//NFInit();
				//alert("success");
			}
		});
		//NFFix();
}
function new_customers()
{
	$("#groups_customres").hide();
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
				$("#customers_detail").html(data);					
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
	
	function get_ajax_product_data(number)
	{
		var product_id = document.getElementById('product'+number).value;		
		var path =  "<?=base_url().index_page()?>invoice/get_ajax_product_data/";
		var title = $('#product'+number).attr('title');
		var dataString = "product_id = "+product_id+"&title = "+title;  
		alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				//	$("#invoice_table").html(data);
				//$("#invoice_table").show();
				var payment = $.trim( data );
				$("#ucost"+number).val(payment);				//alert("#ucost"+$number);
				//$("#taxone1"+number).val(payment);
				//$("#customers_detail").show();
				//$("#state_option").html(data);
				//alert("success");
			}
		});	
		
			get_ajax_product_tax(number);
	}
	
	function get_ajax_product_tax(number)
	{
		var product_id = document.getElementById('product'+number).value;		
		var path =  "<?=base_url().index_page()?>invoice/get_ajax_product_tax/";
		var dataString = "product_id = "+product_id;
		//alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
					//$("#invoice_table").html(data);
				//$("#invoice_table").show();
				var payment = $.trim( data );
				//$("#ucost"+number).val(payment);				//alert("#ucost"+$number);
				$("#taxone"+number).val(payment);
				//$("#customers_detail").show();
				//$("#state_option").html(data);
				//alert("success");
			}
		});	
		get_ajax_product_desc(number);	
	}
	
	function get_ajax_product_desc(number)
	{
		var product_id = document.getElementById('product'+number).value;		
		var path =  "<?=base_url().index_page()?>invoice/get_ajax_product_desc/";
		var dataString = "product_id = "+product_id;
		//alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
					//$("#invoice_table").html(data);
				//$("#invoice_table").show();
				var payment = $.trim( data );
				//$("#ucost"+number).val(payment);				//alert("#ucost"+$number);
				$("#description"+number).val(payment);
				//$("#customers_detail").show();
				//$("#state_option").html(data);
				//alert("success");
			}
		});		
	}
	
	function get_ajax_category_products(number)
	{
		var category_id = document.getElementById('category_service'+number).value;
		//alert(category_id);
		var path =  "<?=base_url().index_page()?>invoice/get_ajax_category_products/";
		var dataString = "category_id = "+category_id+"&row_id="+number;
		//alert(dataString);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				NFDo('stop');
				$("#product_dropdown"+number).html(' ');
				$("#product_dropdown"+number).html(data);
				NFDo('start');
				//NFFix();				
				//$("#ucost"+$number).val(data);
				//alert(data);
				//$("#customers_detail").show();
				//$("#state_option").html(data);
				//alert("success");
			}
		});
	}
	
		
	function get_ajax_product_type(number)
	{
		var product_type = document.getElementById('prodcut_service'+number).value;
		//alert(product_type);
		var path =  "<?=base_url().index_page()?>invoice/get_ajax_product_type/";
		var dataString = "product_id = "+product_type+"&row_id="+number;
		//alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				NFDo('stop');
				$("#product_dropdown"+number).html(' ');
				$("#product_dropdown"+number).html(data);
				NFDo('start');
				//NFFix();				
				//$("#ucost"+$number).val(data);
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
function calculation(count)
{
	//alert(count);
	//alert(document.getElementById('invoice_table').rows.length);
	//var count = document.getElementById('invoice_table').rows.length;
	var subtotal = 0;
	var totalDiscount = 0;
	var totaltax = 0;
	var tax      = 0;
	var total    = 0;
	var subtax   = 0;
    var subPrice = 0;
	var unit_price = 0;
	var after_discount = 0;
	var after_tax_1 = 0;
	var after_tax_2 = 0;
	var each_total = 0;
	var total_quantity = 0;
	var total_withot_charges = 0;
	var each_product_price = 0;
	var total_discounted_value = 0;
	var tax_value_each_row = 0;
	var discounted_value_each_row = 0;
	var net_total = 0;
	//count        = count - 2*j;
	for(var i = 1; i<=count; i++)
	{
		//alert(count);
		//debugger;
		if (!isNaN(document.getElementById('ucost'+i).value))
		{
			unit_price = parseInt(document.getElementById('ucost'+i).value);
			total_quantity = parseInt(document.getElementById('quantity'+i).value);
		}
		
		// Calculate Discount
		if (!isNaN(document.getElementById('discount'+i).value))
		{ 
			discount = Number(document.getElementById('discount'+i).value);
			var disc =  discount*(0.01)*unit_price;
			after_discount = unit_price - disc;
			each_total += after_discount;
			//Calculate total discount
			totalDiscount+=disc*total_quantity;
			//Discounted total
			total_discounted_value+=after_discount*total_quantity;
			discounted_value_each_row+=after_discount
			
		}
		
		//Calculate Tax 1
		if (!isNaN(document.getElementById('taxone'+i).value) && document.getElementById('taxone'+i).value !=0)
		{ 
			taxone = Number(document.getElementById('taxone'+i).value);
			totaltax += taxone*(0.01)*discounted_value_each_row;
			after_tax_1 = taxone*(0.01)*each_total;
			each_total +=after_tax_1;
			//alert(totaltax);
			//item_total = item_total + taxone*(0.01)*item_total;
			
		}
		
		//Calculate Tax 2
		if (!isNaN(document.getElementById('taxtwo'+i).value) && document.getElementById('taxtwo'+i).value !=0)
		{ 
			taxtwo = Number(document.getElementById('taxtwo'+i).value);
			totaltax += taxtwo*(0.01)*(totaltax+discounted_value_each_row);
			after_tax_2 = taxtwo*(0.01)*each_total;
			each_total +=after_tax_2;
		}
		
		
		if (!isNaN(document.getElementById('quantity'+i).value) && each_total!=0)
		{
			 
			 each_product_price =  each_total*total_quantity ;
			 total_withot_charges += total_quantity * unit_price;
		}
		else
		{
			 
			 each_product_price = total_quantity * unit_price ;
			 total_withot_charges += total_quantity * unit_price;
		}
		
		
		// Set total of each item
		if(!isNaN(roundNumber(each_product_price,2)))
		{
			document.getElementById('price'+i).value = roundNumber(each_product_price,2);
			net_total += each_product_price;
		}else
		{
			document.getElementById('price'+i).value = roundNumber(0,2);
			net_total += each_product_price;
		}
		
		
		each_total = 0;
		totaltax = totaltax*total_quantity;
		tax_value_each_row += totaltax;
		//alert();
		discounted_value_each_row = 0;
		totaltax = 0;
		
		//if (!isNaN(document.getElementById('price'+i).value)) subPrice += Number(document.getElementById('price'+i).value)  ;	
			//subtotal = subtotal+total;//document.getElementById('price'+i).value; 
		
	}
	
	//actual_subtotal = roundNumber((subtotal  - totalDiscount),2);
	/*if(isNaN(actual_subtotal))
	{
		document.getElementById('subtotal').innerHTML =  roundNumber(0,2);
		$('#hidden_subtotal').val(0);
	}
	else
	{
		document.getElementById('subtotal').innerHTML =  roundNumber((subtotal  - totalDiscount),2);
		$('#hidden_subtotal').val(subtotal  - totalDiscount);
	}*/
	
	// Set Discounted sub total without any calculation
	actual_total = roundNumber(total_discounted_value,2);
	if(isNaN(actual_total))
	{
		document.getElementById('total').innerHTML = roundNumber(0,2);
		$('#hidden_subtotal').val(0);
	}
	else
	{
		document.getElementById('total').innerHTML = roundNumber(actual_total,2);
		$('#hidden_subtotal').val(actual_total);
	}
	
	
	// Set Net total
	actual_total = roundNumber(net_total,2);
	if(isNaN(actual_total))
	{
		document.getElementById('net_total').innerHTML = roundNumber(0,2);
		$('#hidden_total').val(0);
	}
	else
	{
		document.getElementById('net_total').innerHTML = roundNumber(actual_total,2);
		$('#hidden_total').val(actual_total);
	}
	
	// Set all discount 
	/*actual_discount = roundNumber(totalDiscount,2);
	if(isNaN(actual_discount))
	{
		document.getElementById('total_discount').innerHTML = roundNumber(0,2);
		$('#hidden_total_discount').val(totalDiscount);
	}
	else
	{
		document.getElementById('total_discount').innerHTML =  roundNumber(totalDiscount,2);
		$('#hidden_total_discount').val(totalDiscount);
	}*/
	
	// Set total tax
	actual_tax = roundNumber(tax_value_each_row,2);
	if(isNaN(actual_tax))
	{
		document.getElementById('total_tax').innerHTML = roundNumber(0,2);
		$('#hidden_total_tax').val(actual_tax);
	}
	else
	{
		document.getElementById('total_tax').innerHTML = roundNumber(actual_tax,2);
		$('#hidden_total_tax').val(actual_tax);
	}
	
	//exit();
					
}

//Fucntion will create new row and append in table

	var numImages = 0;
	$(document).ready(function() {
		$('#addnewrow').click(function(){
			
			numImages++;
					
			 /*var html = '<ul class="TableData" id= "row'+numImages+'"><li style="width:160px !important; min-width:160px !important;" ><table id="invoice_table" onclick="calculation('+numImages+')"  width="100%" class="invoiceOthersTbl"><tr ><td ><div style=" float:left; width:auto; position:relative; margin-top:10px;"><select size="1" style="width:150px" name="prodcut_service'+numImages+'"  id="prodcut_service'+numImages+'" ><option value="0">Select</option><option value="Digital" >Digital Products</option><option value="Meeting" >Video Conference</option></select></div></td><td > <div style=" float:left; margin-left:40px; position:relative; margin-top:10px;" id="product_dropdown'+numImages+'" ><select style="width:155px" size="1" onchange="get_ajax_product_data('+numImages+')" id="product'+numImages+'" name="product'+numImages+'" ><? foreach($products as $key => $product){ echo "<option value=".$key.">".$product."</option>";} ?></select></div></td><td class="addRowAlign" >Description</td><td class="addRowAlign"  colspan="2"><input  type="text" size="30" id="description'+numImages+'" value="" name="description'+numImages+'" /></td><td class="addRowAlign" ><a href="javascript:void(0)" class="DeleteAction deleteRow"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button" onclick="delete_row('+numImages+')"/></a></td></tr></li><li><tr ><td >Unit Cost</td><td ><input type="text" size="2" id="ucost'+numImages+'" name="ucost'+numImages+'" /></td><td >Quantity</td><td ><input type="text" size="2" id="quantity'+numImages+'" name="quantity'+numImages+'" /></td><td>Discount (%)</td><td style="padding-right:10px;"><input type="text" size="2" id="discount'+numImages+'" name="discount'+numImages+'" /></td></tr><tr ><td>Tax 1 (%)</td><td><input type="text" size="2" id="taxone'+numImages+'" name="taxone'+numImages+'" /></td><td>Tax 2 (%)</td><td><input type="text" size="2" id="taxtwo'+numImages+'" name="taxtwo'+numImages+'" /></td><td   valign="middle">Price</td><td ><input type="text" size="2" id="price'+numImages+'" name="price'+numImages+'" /></td></tr></table></li></ul>';*/
			
			
				    var html = '<ul class="TableData" id= "row'+numImages+'"><li style="width:160px !important; min-width:160px !important;" ><table id="invoice_table" onclick="calculation('+numImages+')"  width="100%" class="invoiceOthersTbl"><tr ><td ><div style=" float:left; width:auto; position:relative; margin-top:10px;"><select size="1" style="width:150px" name="prodcut_service'+numImages+'"  id="prodcut_service'+numImages+'" ><option value="0">Select</option><option value="Digital" >Digital Products</option><option value="Meeting" >Video Conference</option><option value="Webinar" >Webinar</option></select></div></td><td ><div style=" float:left; width:auto; position:relative; margin-top:10px;" id="category_dropdown'+numImages+'"><select size="1" style="width:150px" name="category_service'+numImages+'"  id="category_service'+numImages+'"    onchange="get_ajax_category_products('+numImages+')"><option value="0">Select Category</option><? foreach($categories as $cat => $category){ echo "<option value=".$category['cat_id'].">".$category['cat_name']."</option>";}?></select></div></td><td colspan="2" > <div style=" float:left; margin-left:40px; position:relative; margin-top:10px;" id="product_dropdown'+numImages+'" ><select style="width:155px" size="1" onchange="get_ajax_product_data('+numImages+')" title="Digital" id="product'+numImages+'" name="product'+numImages+'" ><? foreach($products as $key => $product){ echo "<option value=".$key.">".$product."</option>";} ?></select></div></td><td class="addRowAlign" ><a href="javascript:void(0)" class="DeleteAction deleteRow"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button" onclick="delete_row('+numImages+')"/></a></td></tr></li><li><tr><td  class="addRowAlign" >Description</td><td class="addRowAlign"  colspan="2"><input  type="text" size="30" id="description'+numImages+'" value="" name="description'+numImages+'" /></td></tr></li><li><tr ><td >Unit Cost</td><td ><input type="text" size="2" id="ucost'+numImages+'" name="ucost'+numImages+'" /></td><td >Quantity</td><td ><input type="text" size="2" id="quantity'+numImages+'" name="quantity'+numImages+'" /></td><td>Discount (%)</td><td style="padding-right:10px;"><input type="text" size="2" id="discount'+numImages+'" name="discount'+numImages+'" /></td></tr><tr ><td>Tax 1 (%)</td><td><input type="text" size="2" id="taxone'+numImages+'" name="taxone'+numImages+'" /></td><td>Tax 2 (%)</td><td><input type="text" size="2" id="taxtwo'+numImages+'" name="taxtwo'+numImages+'" /></td><td   valign="middle">Price</td><td ><input type="text" size="2" id="price'+numImages+'" name="price'+numImages+'" /></td></tr></table></li></ul><input type="hidden" id="product_type'+numImages+'" name="product_type'+numImages+'" />';
				
			$('#invoiceRow').append(html); 
			NFFix();
			
			document.getElementById('count').value = numImages;
			
			
		});
	});

</script>
<script>
	
	 function validate()
     {

		var flagSubmit = true;
		if(document.getElementById('inovice_date').value=='')
		{
			alert("Please enter invoice date.");
			document.getElementById('inovice_date').focus;
			flagSubmit = false;
		}
		else
		{
			var count = document.getElementById('invoice_table').rows.length;
			for(var i = 1; i<count; i++)
			{
				var product_value = document.getElementById('product'+i).value;
				if(product_value==0)
				{
					alert("Please select product/services.");
					flagSubmit = false;
				}
			}
		}
		/*else if(document.getElementById('password').value=='')
		{
			alert("Please enter password.");
			flagSubmit = false;
		}
		else if(document.getElementById('password_conform').value=='')
		{
			alert("Please conform  password.");
			flagSubmit = false;
		}
		else if(document.getElementById('password_conform').value!=document.getElementById('password').value)
		{
			alert("Password does not match.");
			flagSubmit = false;
		}
		
		var len = document.room_form.customers.length;
		var i = 0;
		var chosen = '';
		
			for (i = 0; i < len; i++)
			{
				if (document.room_form.customers[i].selected)
				{
					 chosen = document.room_form.customers[i].value;
				}
			}
			if(chosen =="")
			{
				alert("Please select Customer(s) allowed to access this room.");
				flagSubmit = false;
			}*/
        //flagSubmit = true; 
		return flagSubmit;
        
    }     
</script>

<!--	new script 	-->
<script type="text/javascript">
$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	if(id == "recurring_yes")
	{
		$("#recurringInvoice").fadeIn();
		//alert('sfsfsfds');
		NFFix();
	}
	if(id == "recurring_no")
	{
		$("#recurringInvoice").fadeOut();
	}
	
	
});
/*$(document).ready(function(e) {
    
	$("#customer_type").click(function(e) {
	
        get_all_site_customers();
    });
	
	$("#new_customer").click(function(e) {
			
			new_customers();
		});
	
});*/

</script>

<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/Invoice.png" alt="Invoice"/>
        <span>Create An Invoice ( What! Is This? )</span>
    </h1>
    
</div>

<div class="PageDetail">
<p>
This wizard allows you to create an order in your online store.
</p>
<p>
Follows the nubered items below to create the order. For help with a specific item, place your cursor over the blue help icon 
that is located deside the title of each item. Also, you can right-click anywhere on the page choose "Apply" to save your progress.
</p>
<?php 
if(isset($user_name))
{ ?>
	<h3>Biller: <?=$user_name?></h3>
<?php 
} ?>
</div>

<div class="form">
<div style="width:760px;overflow:none;">

     <form class="niceform" onsubmit=" return validate()" action="<?=base_url().index_page()?>invoice/create_invoice"  enctype="multipart/form-data" method="post" id="form" >
    <?php 
	if(isset($user_name))
	{ ?>
     <input type='hidden' name='main_username' id='main_username' value="<?=$user_name?>">
    <?php 
	} ?>
     
            <div class="RightColumnHeading">
                <h1>
                    <img src="<?=base_url();?>images/webpowerup/Information.png" alt="Information"/>
                    <span>Customer Information</span>
                </h1>
            </div>
            <div class="PageDetail">
            <h2>Customer Type </h2>
            </div>
            
            <div class="DoubleColumn">
                
                <div class="ColumnA">
                    <ul>
                     <li> 
                     <input type="radio" value="existing" name="customer_type"   id="customer_type"/>
                        <label class="NewsletterLabel">Existing Customer </label>
                        <br><br>                         
                        <div  id="groups_customres" style="position:relative;" ></div>
                     </li>
                     <li id="new_customer">
                     <input type="radio" checked="checked" value="new_customer" name="customer_type" id="new_customer"/>
                     <label class="NewsletterLabel">New Customer</label>
                     </li>
                    </ul>
                </div>
                
                <div class="ColumnB">
                    <ul>
                    <li> <label class="NewsletterLabel">Invoice Date : <span class="star">* </span> </label>
                     <input type="text" id="inovice_date" name="inovice_date" size="20" />
                     </li>
                     <li>
                     <label class="NewsletterLabel">Payment Terms :</label>
                     <input type="text" id="payment_ters" name="payment_ters" size="20" /></li>
                     <li>
                     <label class="NewsletterLabel">Due Date :</label>
                     <input type="text" id="due_date" name="due_date" size="20" /></li>
                     
                     <li>
                        <label class="NewsletterLabel">Paid:</label>
                        <label class="check_label">Yes</label>
                        <input type="radio" id="status_paid" value="yes" name="status" />
                        <label class="check_label">No</label>
                        <input type="radio" id="status_due"  checked="checked" value="no" name="status" /> 
                	</li>
                     
                    </ul>
                </div>
                
            </div>
            
            <div class="RightColumnHeading">
                <h1>
                    <img src="<?=base_url();?>images/webpowerup/Detail.png" alt="Detail"/>
                    <span>Customer Detail</span>
                </h1>
            </div>
            
             <div id="customers_detail" class="DoubleColumn">
                
                <div class="ColumnA">
                    <ul>
                    <li> <label class="NewsletterLabel">First Name:</label>
                     <input type="text" id="fname" name="fname" size="20" />
                     </li>
                     <li>
                     <label class="NewsletterLabel">Last Name:</label>
                     <input type="text" id="lname" name="lname" size="20" /></li>
                     <li>
                     <label class="NewsletterLabel">Company:</label>
                     <input type="text" id="company" name="company" size="20" /></li>
                     <li>
                     <label class="NewsletterLabel">Email:</label>
                     <input type="text" id="email" name="email" size="20" /></li>
                     <li>
                     <label class="NewsletterLabel">Phone Number:</label>
                     <input type="text" id="pnumber" name="pnumber" size="20" /></li>
                    </ul>
                </div>
                
                <div class="ColumnB">
                    <ul>
                    <li> <label class="NewsletterLabel">Street address: </label>
                     <input type="text" id="saddress" name="saddress" size="20" />
                     </li>
                     <li>
                     <label class="NewsletterLabel">Country:</label>
                     
                     <div  style="position:relative; float:left; height:40px !important;">
                     <select id="country" name="country" style="width:150px;" size="1" class="" >
							<? foreach($countries as $country) 
                            {
                                echo "<option  value=".$country['countries_id'].">".$country['countries_name']."</option>";
                            }
                            ?>													
                     </select>
                     </div>
                     
                     </li>
                     <li>
                     <label class="NewsletterLabel">State/Province:</label>
                     
                     <div id="state_option" style="position:relative; float:left; height:40px !important; ">
                     <select id="state" name="state" style="width:150px;" size="1">
							<? foreach($states as $state) 
                            {
                                echo "<option value=".$state['zone_code'].">".$state['zone_name']."</option>";
                            }
                            ?>													
                    </select>
                    </div>
                  	
                     </li>
                     <li>
                     <label class="NewsletterLabel">City:</label>
                     <input type="text" id="city" name="city" size="20" /></li>
                     <li>
                     <label class="NewsletterLabel">ZIP/Postal Code:</label>
                     <input type="text" id="zcode" name="zcode" size="20" /></li>
                    </ul>
                </div>
                
            </div>
            
            <div class="RightColumnHeading">
                <h1>
                    <img src="<?=base_url();?>images/webpowerup/Product.png" alt="Product"/>
                    <span>Product & Services</span>
                </h1>
                
                <div style="padding-right:15px;" class="RightSideButton">
                    <a href="javascript: void(0)" id="addnewrow" >
                        <img src="<?=base_url();?>images/webpowerup/New.png" alt="Add"/>
                    </a>
            	</div>
            
            </div>
            <style>
			.DataGrid2 ul li{
				min-width:auto !important;
				max-width:auto !important;
				width:auto !important;
			}
			</style>
            <div class="DataGrid2">
                <ul class="TableHeader">
                    <li style="width:160px !important; min-width:160px !important; min-width:160px !important;">Product/Service</li>
                    <li >Options</li>
                    <li class="Serial">Description</li>
                    <li class="Serial">Unit Cost</li>
                    <li class="Serial">Quantity</li>
                    <li class="Serial">Discount (%)</li>
                    <li class="Serial">Tax 1 (%)</li>
                    <li class="Serial">Tax 2 (%)</li>
                    <li style="padding-left:5px;" class="Serial">Price</li>
                </ul>
                
                <span id="invoiceRow">    
                   
                    
                    
                </span>
            </div>
            
            <div class="DoubleColumn">
                
                <div class="ColumnA">
                </div>
                
                <div class="ColumnB">
                    <ul>
                    <li> 
                    <label class="NewsletterLabel">Discounted Total:</label>
                    <label class="RightAlignText"><div id="total">0.00</div></label>
                    <input  type="hidden" value="" id="hidden_subtotal" name="subtotal"/>
                    </li>
                    
                     <li style="display:none"> 
                    <label class="NewsletterLabel">Total Discount:</label>
                    <label class="RightAlignText"><div id="total_discount">0.00</div></label>
                    <input type="hidden" id="hidden_total_discount"  name="total_discount"/>
                    </li>
                    
                    
                    <li> 
                    <label class="NewsletterLabel">Total Tax:</label>
                    <label class="RightAlignText"><div id="total_tax">0.00</div></label>
                    <input type="hidden" id="hidden_total_tax"  name="total_tax"/>
                    </li>
                    
                    
                    
                    <li> 
                    <label class="NewsletterLabel">Total:</label>
                    <label class="RightAlignText"><div id="net_total">0.00</div></label>
                    <input type="hidden" id="hidden_total" value="" name="total"/>
                    </li>
                    
                   <!-- <li>
                    <input type="checkbox" name="checkbox" id="p" /> 
                    <label class="check_label">Allow clint to make partial payment for this invoice</label>
                    </li>-->
                    
                    </ul>
                </div>
                
            </div>
            
            <div class="DoubleColumn">
                
                <div class="ColumnA">
                <ul>
                <li>
                    <label class="NewsletterLabel">Recurring Invoice:</label>
                    
                    <label class="check_label">Yes</label>
                    <input type="radio" id="recurring_yes" value="yes" name="recuring" />
                    <label class="check_label">No</label>
                    <input type="radio" id="recurring_no"  checked="checked" value="no" name="recuring" /> 
                    
                </li>
                <li>
                    <label class="NewsletterLabel">Notes:</label>
                </li>
                </ul>
                </div>
                
                <div class="ColumnB">
                </div>
                
            </div>
            
            <div class="DoubleColumn" id="recurringInvoice" style="display:none;">
                
                <div class="ColumnA">
                    <ul>
                        <li> 
                        <label class="NewsletterLabel">Recurring Title:</label>
                        <input type="text" id="recurring_username" name="recurring_username" size="20" >
                        </li>
                        
                        <li> 
                        <label class="NewsletterLabel">Purchase Order No:</label>
                        <input type="text" id="recurring_order_number" name="recurring_order_number" size="20" >
                        </li>
                        
                        <li> 
                        <label class="NewsletterLabel">Email biller after each recurrence:</label>
                        <input type="text" id="recurring_biller_email" name="recurring_biller_email" size="20" >
                        </li>
                        
                        <li> 
                        <label class="NewsletterLabel">Email customer after each recurrence:</label>
                        <input type="text" id="recurring_customer_email" name="recurring_customer_email" size="20" >
                        </li>
                    </ul>
                </div>
                
                <div class="ColumnB">
                    <ul>
                        <li> 
                        <label class="NewsletterLabel">Start Date: (YYYY-MM-DD)</label>
                        <input type="text" id="recurring_start_date" name="recurring_start_date" size="20" >
                        </li>
                        
                        <li> 
                            <label class="NewsletterLabel">Occurrences:  <span class="star">* </span> </label>
                            <div id="" style="position:relative; float:left; height:40px !important;">
                            <select id="recurring_occurrences" name="recurring_occurrences" style="width:150px;" size="1" >
                                <option value="0" >Select</option>
                                <option value="bi-weekly">Bi-Weekly</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>                           
                            </select>
                            </div>
                        </li>
                        
                        <li> 
                            <div style="float:right;" >
                            <input type="radio" name="rec_end_date_type" value="use_end_date"  checked="checked" />
                            <label class="check_label">End Date: (YYYY-MM-DD)</label>
                            <input id="recurring_end_date" name="recurring_end_date" style="width:50px;" type="text" size="10" />
                            
                            <br><br><br>
                            <input  type="radio" name="rec_end_date_type" value="permanent" />
                            <label class="check_label">Permanent</label>
                            </div>
                        </li>
                        
                    
                    </ul>
                </div>
                
            </div>
            
            <div class="DoubleColumn">
                
                <div class="ColumnA">
                <ul>
                    <li>
                        <label class="NewsletterLabel">Terms & Conditions:</label>
                    </li>
                    <li>
                        <textarea name="termsconditions" rows="10" cols="35"></textarea>
                    </li>
                    <li>
                        
                        <input type="checkbox" value="yes" name="quote" checked="checked" />
                        <label class="check_label">Save as Quote</label>
                    </li>
                </ul>
                </div>
                
                <div class="ColumnB">
                <ul>
                    <li>
                        <label class="NewsletterLabel">Invoice Notes:</label>
                    </li>
                    <li>
                        <textarea name="invoicenotes" rows="10" cols="35"></textarea>
                    </li>
                </ul>
                </div>
                
            </div>
            
            <div class="ButtonRow">
                            
                <button type="submit" >
                    <img src="<?=base_url();?>images/webpowerup/InvoiceGreen.png" alt="InvoiceGreen"/>
                </button>
               <input type="hidden" id="count" name="numInvoice" value="1" />
             </div>
                            
     </form>
</div>
</div>