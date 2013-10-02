<!--	older script 	-->
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
	
	function get_ajax_product_data(number)
	{
		var product_id = document.getElementById('product'+number).value;		
		var path =  "<?=base_url().index_page()?>invoice/get_ajax_product_data/";
		var dataString = "product_id = "+product_id;
		//alert( path);
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
		
	function get_ajax_product_type($number)
	{
		var product_type = document.getElementById('prodcut_service'+$number).value;		
		//alert(product_type);
		var path =  "<?=base_url().index_page()?>invoice/get_ajax_product_type/";
		var dataString = "product_id = "+product_type+"&row_id="+$number;
		//alert( path);
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			success: function(data){
				$("#product_dropdown"+$number).html(' ');
				$("#product_dropdown"+$number).html(data);
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
function calculation()
{
	//alert(document.getElementById('invoice_table').rows.length);
	var count = document.getElementById('invoice_table').rows.length;
	var subtotal = 0;
	var discount = 1;
	var totaltax = 0;
	var tax      = 0;
	var total    = 0;
	var subtax   = 0;
	for(var i = 1; i<count; i++)
	{
		var item_total = document.getElementById('quantity'+i).value * document.getElementById('ucost'+i).value ;
		
		// Calculate Discount
		if (!isNaN(document.getElementById('discount'+i).value))
		{ 
			discount = Number(document.getElementById('discount'+i).value);
			var disc =  discount*(0.01)*item_total;
			total = item_total - disc;
		}
		
		//Calculate Tax 1
		if (!isNaN(document.getElementById('taxone'+i).value) && document.getElementById('taxone'+i).value !=0)
		{ 
			tax = 0;
			taxone = Number(document.getElementById('taxone'+i).value);
			totaltax = totaltax + taxone;
			tax = taxone*(0.01)*item_total;
			total = item_total + tax;
			//item_total = item_total + taxone*(0.01)*item_total;
			
		}
		
		//Calculate Tax 2
		if (!isNaN(document.getElementById('taxtwo'+i).value) && document.getElementById('taxtwo'+i).value !=0)
		{ 
			tax = 0;
			taxtwo = Number(document.getElementById('taxtwo'+i).value);
			totaltax = totaltax + taxone;
			tax = taxtwo*(0.01)*item_total;
			//item_total = item_total + taxtwo*(0.01)*item_total;
			total = item_total + tax;
		}
		
		document.getElementById('price'+i).value = roundNumber(item_total,2);
		
		subtax += tax;
		if (!isNaN(document.getElementById('price'+i).value)) subtotal += Number(document.getElementById('price'+i).value) +tax ;		
		//subtotal = subtotal+document.getElementById('price'+i).value; 
		//alert(i);
	}
	//alert(subtotal);
	document.getElementById('subtotal').innerHTML = roundNumber(subtotal,2);
	document.getElementById('total_tax').innerHTML = roundNumber(subtax,2);
	document.getElementById('total').innerHTML =  roundNumber(subtotal,2);
	$('#hidden_subtotal').val(subtotal);
	$('#hidden_total_tax').val(subtax);
  	$('#hidden_total').val(subtotal);
				
}

//Fucntion will create new row and append in table

	var numImages = 1;
	$(document).ready(function() {
		$('#addnewrow').click(function(){
		
			numImages++;			
			var html ='<tr id= "row'+numImages+'"><td><a onclick="delete_row('+numImages+')" href="javascript: void(0);"><img  src="<?=base_url()?>/images/remove.png" /></a></td><td><select name="prodcut_service'+numImages+'" onchange="get_ajax_product_type('+numImages+')"  style="opacity: 1; font-size:10px;" id="prodcut_service'+numImages+'"><option value="0">Select</option><option value="Regular" >Products</option><option value="Digital" >Digital Products</option><option value="Meeting" >Video Conference</option></select></td><td id="product_dropdown'+numImages+'"><select onchange="get_ajax_product_data('+numImages+')" id="product'+numImages+'" name="product'+numImages+'" style="opacity: 1; font-size:10px;"><? foreach($products as $key => $product){ echo "<option value=".$key.">".$product."</option>";}	?></select></td><td><input id="description'+numImages+'" name="description'+numImages+'" type="text" /></td><td><input id="ucost'+numImages+'" name="ucost'+numImages+'" type="text" /></td><td><input id="quantity'+numImages+'" name="quantity'+numImages+'" type="text" /></td><td><input id="discount'+numImages+'" name="discount'+numImages+'" type="text" /></td><td><input id="taxone'+numImages+'" name="taxone'+numImages+'" type="text" /></td><td><input id="taxtwo'+numImages+'" name="taxtwo'+numImages+'" type="text" /></td><td><input id="price'+numImages+'" name="price'+numImages+'" type="text" /></td></tr>';
		   
			$('table#invoice_table').append(html); 
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
	}
	if(id == "recurring_no")
	{
		$("#recurringInvoice").fadeOut();
	}
	
	
});


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
if(isset($invoice_info[0]['username']))
{ ?>
	<h3>Biller: <?= $invoice_info[0]['username'];?></h3>
	<input type='hidden' name='main_username' id='main_username' value="<?=$invoice_info[0]['username']?>">
<?php 
} ?>
</div>

<div class="form">
     <form class="niceform" onsubmit=" return validate()" action="<?=base_url().index_page()?>invoice/edit_invoice_data"   enctype="multipart/form-data" method="post" id="form" >
    <?php 
	if(isset($user_name))
	{ ?>
     <input type='hidden' name='main_username' id='main_username' value="<?=$user_name?>">
    <?php 
	} ?>
     
            <div class="RightColumnHeading">
                <h1>
                    <img src="<?=base_url();?>images/webpowerup/Information.png" alt="Information"/>
                    <span>Cutomer Information</span>
                </h1>
            </div>
            <div class="PageDetail">
            <h2>Customer Type </h2>
            </div>
            
            <div class="DoubleColumn">
                
                <div class="ColumnA">
                    <ul>
                     <li> 
                     <input type="hidden" name="hidden_customer" value="<?php if(isset($invoice_info[0]['customer_id'])){  echo $invoice_info[0]['customer_id'];   }  ?>"/>
												<input type="hidden" name="invoice_id" value="<?php if(isset($invoice_info[0]['invoice_id'])){  echo $invoice_info[0]['invoice_id'];   }  ?>"/>
                                                
                                                
                     <input type="radio" value="existing" name="customer_type" id="customer_type" onclick="get_all_site_customers()" <?php if($invoice_info[0]['customer_type']=='existing'){ echo 'checked' ; }  ?> />
                        <label class="NewsletterLabel">Existing Customer </label>
                        <br><br>
                        <div style="opacity: 1;" id="groups_customres" class="groups_customres"></div>
                     </li>
                     <li>
                     
                     <input type="radio" <?php if($invoice_info[0]['customer_type']=='new_customer'){ echo 'checked' ; }  ?> value="new_customer" name="customer_type" id="new_customer" onclick="new_customers()" />
                     <label class="NewsletterLabel">New Customer</label>
                     </li>
                    </ul>
                </div>
                
                <div class="ColumnB">
                    <ul>
                    <li> <label class="NewsletterLabel">Invoice Date : <span class="star">* </span> </label>
                     <input type="text" id="inovice_date" name="inovice_date" size="20" value="<?php if(isset($invoice_info[0]['invoice_date'])){  echo $invoice_info[0]['invoice_date'];   }  ?>" />
                     </li>
                     <li>
                     <label class="NewsletterLabel">Payment Terms :</label>
                     <input type="text" id="payment_ters" name="payment_ters" size="20" value="<?php if(isset($invoice_info[0]['payment_term'])){  echo $invoice_info[0]['payment_term'];   }  ?>" /></li>
                     <li>
                     <label class="NewsletterLabel">Due Date :</label>
                     <input type="text" id="due_date" name="due_date" size="20" value="<?php if(isset($invoice_info[0]['due_date'])){  echo $invoice_info[0]['due_date'];   }  ?>" /></li>
                    </ul>
                </div>
                
            </div>
            
            <div class="RightColumnHeading">
                <h1>
                    <img src="<?=base_url();?>images/webpowerup/Detail.png" alt="Detail"/>
                    <span>Cutomer Detail</span>
                </h1>
            </div>
            
             <div class="DoubleColumn">
                
                <div class="ColumnA">
                    <ul>
                    <li> <label class="NewsletterLabel">First Name:</label>
                     <input type="text" id="fname" name="fname" size="20" value="<?php if(isset($customer_detail['customer_fname'])){  echo $customer_detail['customer_fname'];   }  ?>" />
                     </li>
                     <li>
                     <label class="NewsletterLabel">Last Name:</label>
                     <input type="text" id="lname" name="lname" size="20" value="<?php if(isset($customer_detail['customer_lname'])){  echo $customer_detail['customer_lname'];   }  ?>" /></li>
                     <li>
                     <label class="NewsletterLabel">Company:</label>
                     <input type="text" id="company" name="company" size="20" value="<?php if(isset($customer_detail['customer_company'])){  echo $customer_detail['customer_company'];   }  ?>" /></li>
                     <li>
                     <label class="NewsletterLabel">Email:</label>
                     <input type="text" id="email" name="email" size="20" value="<?php if(isset($customer_detail['customer_email'])){  echo $customer_detail['customer_email'];   }  ?>" /></li>
                     <li>
                     <label class="NewsletterLabel">Phone Number:</label>
                     <input type="text" id="pnumber" name="pnumber" size="20" value="<?php if(isset($customer_book['address_book_phone'])){  echo $customer_book['address_book_phone'];   }  ?>" /></li>
                    </ul>
                </div>
                
                <div class="ColumnB">
                    <ul>
                    <li> <label class="NewsletterLabel">Street address: </label>
                     <input type="text" id="saddress" name="saddress" size="20" value="<?php if(isset($customer_book['address_book_country'])){  echo $customer_book['address_book_country'];}?>" />
                     </li>
                     <li>
                     <label class="NewsletterLabel">Country:</label>
                     
                     <div id="" style="position:relative; float:left; height:40px !important;">
                     <select id="country" name="country" style="width:150px;" size="1" >
							<? foreach($countries as $country) 
                            {
                                echo "<option value=".$country['countries_id'].">".$country['countries_name']."</option>";
                            }
                            ?>													
                     </select>
                     </div>
                     
                     </li>
                     <li>
                     <label class="NewsletterLabel">State/Province:</label>
                     
                     <div id="" style="position:relative; float:left; height:40px !important; ">
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
                     <input type="text" id="city" name="city" size="20" value="<?php if(isset($customer_book['address_book_city'])){  echo $customer_book['address_book_city'];}?>" /></li>
                     <li>
                     <label class="NewsletterLabel">ZIP/Postal Code:</label>
                     <input type="text" id="zcode" name="zcode" size="20" value="<?php if(isset($customer_book['address_book_zipcode'])){  echo $customer_book['address_book_zipcode'];}?>" /></li>
                    </ul>
                </div>
                
            </div>
            
            <div class="RightColumnHeading">
                <h1>
                    <img src="<?=base_url();?>images/webpowerup/Product.png" alt="Product"/>
                    <span>Product & Services</span>
                </h1>
                
                <div class="RightSideButton">
                    <a href="javascript: void(0)" onclick="addMenuItem()" >
                        <img src="<?=base_url();?>images/webpowerup/AddMenuItem.png" alt="Add"/>
                    </a>
            	</div>
            
            </div>
            
            <div class="DataGrid2">
                <ul class="TableHeader">
                    <li style="width:160px !important; min-width:160px !important; min-width:160px !important;">Product/Service</li>
                    <li class="Serial">Options</li>
                    <li class="Serial">Description</li>
                    <li class="Serial">Unit Cost</li>
                    <li class="Serial">Quantity</li>
                    <li class="Serial">Discount (%)</li>
                    <li class="Serial">Tax 1 (%)</li>
                    <li class="Serial">Tax 2 (%)</li>
                    <li class="Serial">Price</li>
                </ul>
                    
                <ul class="TableData">
                    <li style="width:160px !important; min-width:160px !important; min-width:160px !important;" >
                    <div style=" float:left; width:auto; position:relative; margin-top:10px;">
                        <select size="1" name="selectdrop" id=""  style="width:150px"> 
                            <option value="0" >Select</option>
							<option value="Regular">Products</option>
							<option value="Digital">Digital Products</option>
							<option value="Meeting">Video Conference</option>
                        </select>
                        </div>
                    </li>
                    <li class="Serial"><a href="#" class="activelink"> Create Product</a></li>
                    <li class="Serial"><input type="text" name="" id="" size="2" /></li>
                    <li class="Serial"><input type="text" name="" id="" size="2" /></li>
                    <li class="Serial"><input type="text" name="" id="" size="2" /></li>
                    <li class="Serial"><input type="text" name="" id="" size="2" /></li>
                    <li class="Serial"><input type="text" name="" id="" size="2" /></li>
                    <li class="Serial"><input type="text" name="" id="" size="2" /></li>
                    <li class="Serial"><input type="text" name="" id="" size="2" /></li>
                </ul>
            </div>
            
            <div class="DoubleColumn">
                
                <div class="ColumnA">
                </div>
                
                <div class="ColumnB">
                    <ul>
                    <li> 
                    <label class="NewsletterLabel">Subtotal:</label>
                    <label class="RightAlignText"><div id="subtotal"><?php if(isset($invoice_info[0]['subtotal'])){  echo round($invoice_info[0]['subtotal'],2);}else{ echo "0.00"; }?></div><input  type="hidden" value="<?php if(isset($invoice_info[0]['subtotal'])){  echo round($invoice_info[0]['subtotal'],2);}?>" id="hidden_subtotal" name="hidden_subtotal"/></label>
                    </li>
                    
                    <li> 
                    <label class="NewsletterLabel">Total Tax:</label>
                    <label class="RightAlignText"><div id="total_tax"><?php if(isset($invoice_info[0]['total_tax'])){  echo round($invoice_info[0]['total_tax'],2);}else{ echo "0.00"; }?></div><input type="hidden" id="hidden_total_tax"  name="total_tax"/></label>
                    </li>
                    
                    <li> 
                    <label class="NewsletterLabel">Total:</label>
                    <label class="RightAlignText"><?php if(isset($invoice_info[0]['subtotal'])){  echo round($invoice_info[0]['subtotal'],2);}else{ echo "0.00"; }?></div><input type="hidden" id="hidden_total" value="<?php if(isset($invoice_info[0]['subtotal'])){  echo round($invoice_info[0]['subtotal'],2);}?>" name="hidden_total"/></label>
                    </li>
                    
                    <li>
                    <input type="checkbox" name="checkbox" id="p" /> 
                    <label class="check_label">Allow clint to make partial payment for this invoice</label>
                    </li>
                    
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
                        <input type="text" id="recurring_username" name="recurring_username" size="20" value="<?php if(isset($invoice_info[0]['recurring_username'])){  echo $invoice_info[0]['recurring_username'];   }  ?>" >
                        </li>
                        
                        <li> 
                        <label class="NewsletterLabel">Purchase Order No:</label>
                        <input type="text" id="recurring_order_number" name="recurring_order_number" size="20" value="<?php if(isset($invoice_info[0]['recurring_order_number'])){  echo $invoice_info[0]['recurring_order_number'];   }  ?>" >
                        </li>
                        
                        <li> 
                        <label class="NewsletterLabel">Email biller after each recurrence:</label>
                        <input type="text" id="recurring_biller_email" name="recurring_biller_email" size="20" value="<?php if(isset($invoice_info[0]['recurring_biller_email'])){  echo $invoice_info[0]['recurring_biller_email'];   }  ?>" >
                        </li>
                        
                        <li> 
                        <label class="NewsletterLabel">Email customer after each recurrence:</label>
                        <input type="text" id="recurring_customer_email" name="recurring_customer_email" size="20" value="<?php if(isset($invoice_info[0]['recurring_customer_email'])){  echo $invoice_info[0]['recurring_customer_email'];   }  ?>" >
                        </li>
                    </ul>
                </div>
                
                <div class="ColumnB">
                    <ul>
                        <li> 
                        <label class="NewsletterLabel">Start Date: (YYYY-MM-DD)</label>
                        <input type="text" id="recurring_start_date" name="recurring_start_date" size="20" value="<?php if(isset($invoice_info[0]['recurring_start_date'])){  echo $invoice_info[0]['recurring_start_date'];   }  ?>" >
                        </li>
                        
                        <li> 
                            <label class="NewsletterLabel">Occurrences:  <span class="star">* </span> </label>
                            <div id="" style="position:relative; float:left; height:40px !important;">
                            <select id="recurring_occurrences" name="recurring_occurrences" style="width:150px;" size="1"  >
                                <option value="0" >Select</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>                           
                            </select>
                            </div>
                        </li>
                        
                        <li> 
                            <div >
                            <input type="radio" name="rec_end_date_type" value="use_end_date"  <?  if($invoice_info[0]['rec_end_date_type']!='permanent'){?> checked="checked"<? }?>  />
                            <label class="check_label">End Date: (YYYY-MM-DD)</label>
                            <input id="recurring_end_date" name="recurring_end_date" type="text" size="10" value="<?php if(isset($invoice_info[0]['recurring_end_date'])){  echo $invoice_info[0]['recurring_end_date'];   }  ?>" />
                            
                            <br><br><br>
                            <input type="radio" name="rec_end_date_type" value="permanent" <?  if($invoice_info[0]['rec_end_date_type']=='permanent'){?> checked="checked"<? }?> />
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
                        <textarea name="termsconditions" rows="10" cols="35"><?php if(isset($invoice_info[0]['terms_conditions'])){  echo $invoice_info[0]['terms_conditions'];}?></textarea>
                    </li>
                    <li>
                        <label class="NewsletterLabel">Recurring Invoice:</label>
                        
                        <input type="radio" value="yes" name="quote" checked="checked" />
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
                        <textarea name="invoicenotes" rows="10" cols="35"><?php if(isset($invoice_info[0]['invoice_notes'])){  echo $invoice_info[0]['invoice_notes'];}?></textarea>
                    </li>
                </ul>
                </div>
                
            </div>
            
            <div class="ButtonRow">
                            
                <button type="submit" >
                    <img src="<?=base_url();?>images/webpowerup/InvoiceGreen.png" alt="InvoiceGreen"/>
                </button>
               
             </div>
                            
     </form>
</div>