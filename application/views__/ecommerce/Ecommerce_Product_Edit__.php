<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
$(function() {
$( "#digital_download_expire" ).datepicker();
});
</script>

<script type="text/javascript">

// validation
function validate()
{
    var len = document.add_product.group_access.length;	
	var page_access = document.getElementById('access_permision3');
	var other = document.getElementById('access_permision3').checked;
	var len_cat = document.add_product.parentid.length;	
	var i = 0;
	var chosen = '';
	var chosen_cat = '';		
	if(other)
	{
		for (i = 0; i < len; i++)
		{
			if (document.add_product.group_access[i].selected)
			{
				 chosen = document.add_product.group_access[i].value;
			}
		}
		if(chosen =="")
		{
			alert("Please select Group(s) allowed to access this page");
			return false;
		}
		if(page_access.checked==true && role_id.value=="")
		{
			alert("Please select Role(s) allowed to access this page");
			return false;
		}
	}
	else if(len_cat>=0)
	{
		
		chosen_cat = document.add_product.parentid.value;					 
		if(chosen_cat =="")
			{
				alert("Please select/create category first.");
				return false;
			}
		/*if(len_cat>0)
		{	
			for (i = 0; i < len_cat; i++)
			{
				if (document.add_product.parentid[i].selected)
				{
					 chosen_cat = document.add_product.parentid[i].value;					 
				}
			}
			if(chosen_cat =="")
			{
				alert("Please select/create category first.");
				return false;
			}		
		}
		else
		{
				alert("Please select/create category first.");
				return false;
		}*/
	}	
    else
    {
        return true;    
    }  
}


$("div.NFRadio").live("click",function(){
	var id = $(this).next("input").attr("id");
	
	
	if(id == "access_permision2" || id == "access_permision1")
	{
		$('#roles').fadeOut();
	}
	if(id == "access_permision3")
	{
		$('#roles').fadeIn();
		NFFix();
	}
	
	if(id == "image_rd1")
	{
		$('#img').fadeIn();
		NFFix();
	}
	if(id == "image_rd2" )
	{
		$('#img').fadeOut();
	}
	
	// taxable yes no
	if( id == "taxable_rd2" )
	{
		$('#taxableDiv').fadeOut();
	}
	if(id == "taxable_rd1")
	{
		$('#taxableDiv').fadeIn();
		NFFix();
	}
	
	// digital product yes no
	if( id == "digital_pro2" )
	{
		$('#DigOptDiv').fadeOut();
	}
	if(id == "digital_pro1")
	{
		$('#DigOptDiv').fadeIn();
		NFFix();
	}
	
});

	
// ADD REMOVE PRODUCT SLIDE SHOW 	
var i = 1;
var totalRow = i;
$(document).ready(function(e) {
	
	
	// PRODUCT ATTRIBUTES 
	$('#add_tabs').click(function(){
		var numImages = Number($('#tab_container li').length);
		numImages++;			
		var html ='<li style="padding-top:5px;" id="tab_container_li'+numImages+'"><div id="tab'+numImages+'" class="tabs"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr style="background:#F3F4F8; height:35px; line-height:35px; " ><td width="92%"><strong>ATTRIBUTE PANAL</strong></td><td width="4%"><a href="javascript:void(0)" onClick="hide_panel('+numImages+')" class="minus"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a></td><td width="4%"><a href="javascript:void(0)" onClick="show_panel('+numImages+')" class="plus"><img src="<?=base_url();?>images/webpowerup/show.png"/></a></td></tr></table></div><div style="display:none;"  id="pannel'+numImages+'"><table width="99%" border="0" cellspacing="0" cellpadding="0" class="heading_table"><tr><td ><strong>Attribute Name:</strong></td><td ><input type="text" name="title'+numImages+'" id="title'+numImages+'"  size="40" /></td></tr></table><table id="attribute_table'+numImages+'" width="99%" border="0" cellspacing="0" cellpadding="0" class="heading_table"><tr><td style="padding-bottom:5px;" colspan="3"><a id="addattrow" href="javascript:void(0)" onClick="addAttRow('+numImages+')">Add Option</a>|<a href="javascript:void(0)" onClick="deleteAttRow('+numImages+')" id="remove">Remove Option</a></td></tr><tr class="title-tr"><td width="40%" >Attribute Option Name</td><td width="37%" >Price Status</td><td width="23%" >Price</td></tr><tr class="attOptTR"><td><input  type="text" name="att_name'+numImages+'_1" size="20" /></td><td><input  type="text" name="att_price'+numImages+'_1" size="20" /></td><td><div style="position:relative; "><select size="1" name="att_price_option'+numImages+'_1" style="width:150px;" ><option>Same Price</option><option>Less</option><option>Add</option></select></div><input type="hidden" id="sub_att'+numImages+'" name="sub_att'+numImages+'" value="1"/></td></tr></table></div></li>';
			   
			$('ul#tab_container').append(html); 
			NFFix();
			document.getElementById('main_att').value = numImages;
			NFFix();
		});
		
		$('#delete_tabs').click(function(){
			//alert('sdfsdf');
		var numImages = Number($('#tab_container li').length);
		if(numImages > 4) {
        	$('#tab_container li:last-child').remove();
        	numImages--;
			document.getElementById('main_att').value = numImages;
			document.getElementById('main_att').value = numImages;
    	}

	});
	// PRODUCT ATTRIBUTES
	
	
	// ADD ROW DYNAMICALLY
    $("#addSlideShow").click(function(){
		
		i++;
		var html = '<ul class="TableData"><li><input type="text" name="image['+i+'][title]" id="" size="15" /></li><li><input type="text" name="image['+i+'][desc]" id="" size="15" /></li><li class="imagefield"><input type="file" name="galaryImg_'+i+'" id="" /></li><li class="Actions"><a class="DeleteAction"><img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/> </a></li></ul>';		

		$("#slideShowItems").append(html);
		NFFix();
		totalRow++;	
		return false;
	});
	
	
	// tab initial setting
	var onloadTab = 0; // 0 to hide 1 to display
	if(onloadTab == 1)
	{
		$(".tab").show();
	}
	else
	{
		$(".tab").hide();
	}
	
	
	// 1 st tab show hide 
	$("#show1").click(function(e) {
        $("#tab1").slideDown();
		NFFix();
    });
	
	$("#hide1").click(function(e) {
        $("#tab1").slideUp();
    });
	// 1 st tab show hide 
	
	// all tab except 1 st
	$(".show").click(function(e) {
		var findTab = $(this).parent().parent().next("div.tab");
        $(findTab).slideDown();
		NFFix();
    });
	
	$(".hide").click(function(e) {
		var findTab = $(this).parent().parent().next("div.tab");
        $(findTab).slideUp();
    });
	// all tab except 1 st
	
});
	
// REMOVE ROW DYNAMICALLY
$(".DeleteAction").live("click",function(){
	
	if ( totalRow <= 1 )
	{
		alert("Cannot delete all rows");
	}
	else
	{	
		$(this).parent().parent().remove();
		totalRow--;
	}
	return false;
});
	
	


</script>
<script>

	
function deleteAttRow(row)
{
	var count = $("#attribute_table"+row+" tr").length;
	var req_row_count = $("#attribute_table"+row+" tr").length-2;
	
	if(count > 3) {
		$("#"+row+"_"+req_row_count).remove();
	}
}
function addAttRow(row_number){
	
	
	var count = $("#attribute_table"+row_number+" tr").length;
	//alert(count);
	tr_count = count-2;
	tr_count++;
	var del = row_number+'_'+tr_count;
	//del = "'"+del+"'";			
	var html ='<tr class="attOptTR" id="'+del+'"><td><input  type="text" name="att_name'+del+'" /></td><td><input  type="text" name="att_price'+del+'" /></td><td><div style="position:relative; "><select size="1" style="width:150px;" name="att_price_option'+del+'" ><option>Same Price</option><option>Less</option><option>Add</option></select></div><input type="hidden" id="sub_att'+row_number+'" name="sub_att'+row_number+'" value="'+tr_count+'" /></td></tr>';
	   // alert("#attribute_table"+row_number);
	$("#attribute_table"+row_number).append(html); 
	NFFix();
		//document.getElementById('sub_att').value = row_number;
}	



function show_panel(id)
{
	//alert(id);
	$("#pannel"+id).slideDown();
}
function hide_panel(id)
{
	$("#pannel"+id).slideUp();
}


</script>	


<style>
.heading_table
{
	
	padding-top:10px;
	background:#FFFFFF;
}
.smallText{
	font-size:12px;
	font-weight:normal;
	vertical-align:middle !important;
	line-height:45px !important;
	height:45px !important;
	
}

.attOptTR td{
	vertical-align:middle !important;

	line-height:45px !important;
	height:45px !important;
	
}
#attributes_options{
	padding:10px;
}

</style>





<div class="form">
<div class="RightColumnHeading">
    <h1 class="createroom">
        <img src="<?=base_url();?>images/webpowerup/AddNewProducts.png" alt="Add New Products"/>
        <span>Add New Products</span>
    </h1>
    <div class="RightSideButton">
    	<a href="javascript:void(0)" id="show1"><img src="<?=base_url();?>images/webpowerup/show.png" /></a>&nbsp;<a href="javascript:void(0)" id="hide1"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
    </div>
</div>
        

<?php

   if(isset($invoice_create_time) && $invoice_create_time==1)
   {
		$invoice_create_time = 2;
   }
?>

<form action="<?=site_url()?>Products_Management/edit/" method="post" name="add_product" id="add_product" class="niceform" enctype="multipart/form-data">
<input type="hidden" name="action" value="edit_product" />
<input type="hidden" name="product_id" value="<?=$product['product_id'];?>" />
<input type="hidden" id="main_att" name="main_att" value="1"/>
<input type="hidden" id="sub_att1" name="sub_att1" value="1"/>
 
         <fieldset>
         
             <div id="tab1" class="tab">
                <dl>
                    <dt><label for="email" class="NewsletterLabel">Product Name :</label></dt>
                    <dd><input type="text" name="product_name" id="product_name" size="55" value="<?=$product['product']?>" /></dd>
                </dl>
                
                 <dl>
                    <dt><label for="email" class="NewsletterLabel">Short Description :</label></dt>
                    <dd><textarea name="short_desc" id="short_desc" rows="10" cols="42"><?=$product['short_desc']?></textarea></dd>
                </dl>
                
                <dl>
                    <dt><label for="email" class="NewsletterLabel">Title Tag :</label></dt>
                    <dd><textarea name="title_tag" id="title_tag" rows="10" cols="42"><?=$product['meta_title']?></textarea></dd>
                </dl>
                
                 <dl>
                    <dt><label for="email" class="NewsletterLabel">Meta Keywords :</label></dt>
                    <dd><textarea name="meta_key" id="meta_key" rows="10" cols="42"><?=$product['meta_keywords']?></textarea></dd>
                </dl>
                
                <dl>
                    <dt><label for="email" class="NewsletterLabel">Meta Description :</label></dt>
                    <dd><textarea name="meta_desc" id="meta_desc" rows="10" cols="42"><?=$product['meta_description']?></textarea></dd>
                </dl>
             </div>
            
            <div class="RightColumnHeading">
                <h1 class="createroom">
                    <span>Detail Description</span>
                </h1>
                
                <div class="RightSideButton">
                    <a href="javascript:void(0)" class="show"><img src="<?=base_url();?>images/webpowerup/show.png"  /></a>&nbsp;<a href="javascript:void(0)" class="hide"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
                </div>
            </div>
            
            <div class="tab">
            	<dl>
                <dt><label class="NewsletterLabel">Long Description :</label></dt>
                <dd><textarea name="full_desc" id="full_desc" rows="10" cols="42"><?=$product['full_desc'];?></textarea></dd>
            </dl>
            </div>
            
            
            <div class="RightColumnHeading">
                <h1 class="createroom">
                    <span>Price</span>
                </h1>
                <div class="RightSideButton">
                    <a href="javascript:void(0)" class="show"><img src="<?=base_url();?>images/webpowerup/show.png"  /></a>&nbsp;<a href="javascript:void(0)" class="hide"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
                </div>
            </div>
            
            <div class="tab">
            	<dl>
                <dt><label for="email" class="NewsletterLabel">Price :</label></dt>
                <dd><input type="text" name="price" id="price" size="55" value="<?=$product['list_price'];?>" /></dd>
            </dl>
            
            <dl>
                <dt><label for="color" class="NewsletterLabel">Taxable : </label></dt>
                <dd>
                <?php
				
				
				?>
                    <label class="check_label">No</label>
                    <input type="radio" name="taxable_rd" id="taxable_rd2" value="No" <?php echo ( $product['free_tax'] == "No") ? 'checked="checked"' : '' ; ?> />
                    <label class="check_label">Yes</label>
                    <input type="radio" name="taxable_rd" id="taxable_rd1" value="Yes" <?php echo ( $product['free_tax'] == "Yes") ? 'checked="checked"' : '' ; ?> />
                    <br /><br />
                    <?php $display = ( $product['free_tax'] == "Yes") ? 'style="display:block;"' : 'style="display:none;"' ; ?>
                    <div id="taxableDiv" <?=$display?> >
                    	<div style="float:left;">
                    	<input type="text" name="price_tax" id="price_tax" size="25" value="<?=$product['tax'];?>" />
                        </div>
                        <div style="position:relative; float:left; margin:0 0 0 15px;">
                        	 <select size="1" name="tax_param" style="width:100px;"> 
                                <option value="$">$</option>
								<option value="%">%</option>
                             </select>
                        </div>
                        
                    </div>
                    
              </dd>
            </dl>
            </div>
            
            
            <div class="RightColumnHeading">
                <h1 class="createroom">
                    <span>Category</span>
              </h1>
              <div class="RightSideButton">
                    <a href="javascript:void(0)" class="show"><img src="<?=base_url();?>images/webpowerup/show.png"  /></a>&nbsp;<a href="javascript:void(0)" class="hide"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
                </div>
            </div>
            
            <div class="tab">
           		 <dl>
                <dt>
              <label for="email" class="NewsletterLabel">Category :</label></dt>
                <dd>
                <?php
				if ( count($categories) > 0 ) 
				{ ?>
                <div  style=" position:relative;" >
                <select size="1" name="parentid" id="parentid"  style="width:360px;"> 
                	   <?php
					   foreach($categories as $key => $val )
					   { ?>
                       		<option <?php echo ( $key == $product['category_id'] ) ? 'selected="selected"' : "" ; ?> value="<?=$key?>"><?=$val?></option>
                       <?php
					   } ?>
                </select>
                </div>
                <?php 
				} ?> 
                </dd>
            </dl>
            
            <dl>
                <dt><label for="color" class="NewsletterLabel">Group Code : </label></dt>
                <dd>
                    <div style="float:left; width:100%"><label class="check_label">Which group can see this product ?</label></div>
                   
                    
    				
                   
                    <input type="radio" name="access_permision" id="access_permision1" value="Everyone" <?php echo ( $product['permission'] == "Everyone" ) ? 'checked="checked"' : '' ; ?> />
                    <label class="check_label">Everyone</label>
                    <input type="radio" name="access_permision" id="access_permision2" value="Registered" <?php echo ( $product['permission'] == "Registered" ) ? 'checked="checked"' : '' ; ?> />
                    <label class="check_label">All Registered Users</label>
                    <input type="radio" name="access_permision" id="access_permision3" value="Other" <?php echo ( $product['permission'] == "Other" ) ? 'checked="checked"' : '' ; ?> />
                    <label class="check_label">Only Users With a Certain Access Level</label>
                    <br><br>
                    <?php $display = ( $product['permission'] == "Other") ? 'block' : 'none' ; ?>
                    <div style="display: <?=$display;?>; margin:5px 5px 5px 5px; float:left;" id="roles" > 
                        <div  style=" position:relative; float:left;" >
                        <select size="4" name="group_access[]" id="group_access" multiple="multiple" style="width:360px;"> 
                            <?
                            foreach($groups as $group)
                            {
                            ?>
                            <option value="<?=$group['id']?>"><?=$group['group_name']?></option>
                            <? 	
                            } ?>
                        </select>
                        </div>
                    </div>
                </dd>
            </dl>
            </div>
            
            <div class="RightColumnHeading">
                <h1 class="createroom">
                    <span>Image</span>
                </h1>
                <div class="RightSideButton">
                    <a href="javascript:void(0)" class="show"><img src="<?=base_url();?>images/webpowerup/show.png"  /></a>&nbsp;<a href="javascript:void(0)" class="hide"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
                </div>
            </div>
            
            
            <div class="tab">
            	<dl>
                    <dt><label for="color" class="NewsletterLabel"></label></dt>
                    <dd>
                        <label class="check_label">None</label>
                        <input type="radio" name="image_rd" id="image_rd2" value="No" <?php echo ( $product['permission'] == "No" ) ? 'checked="checked"' : '' ; ?> />
                        <label class="check_label">Upload a new image</label>
                        <input type="radio" name="image_rd" id="image_rd1" value="Yes" <?php echo ( $product['permission'] == "Yes" ) ? 'checked="checked"' : '' ; ?> />
                        
                        <br><br>
                        <div id="img" style="display:none;">
                            <input type="file" name="product_image" id="image">
                        </div>
                        
                    </dd>
                </dl>
            </div>
            
               <div class="RightColumnHeading">
                <h1 class="createroom">
                    <span>Create Product Slide Show</span>
                </h1>
                <div class="RightSideButton">
                    <a href="javascript:void(0)" class="show"><img src="<?=base_url();?>images/webpowerup/show.png"  /></a>&nbsp;<a href="javascript:void(0)" class="hide"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
                </div>
            </div>
         <div class="tab">  
         	 <div class="DataGrid2">
          <ul class="TableHeader">
              <li>Image Title</li>
              <li>Image Description </li>
              <li class="imagefield">Image</li>
              <li class="Actions">Action</li>
          </ul>
           
           
           <span id="slideShowItems">   
              <ul class="TableData">
                  <li>
                      <input type="text" name="image[1][title]" id="" size="15" /> 
                  </li>
                  
                   <li>
                      <input type="text" name="image[1][desc]" id="" size="15" /> 
                  </li>
                  <li class="imagefield">
                      <input type="file" name="galaryImg_1" id="" />
                  </li>
                  <li class="Actions">
                       <a class="DeleteAction" >
                          <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/> 
                       </a>
                   </li>
              </ul>
           </span>
          </div>
        
            <ul class="TableData AlterRow AddFieldRow">
            <li>
              <div class="AddMoreField">
                  <a href="#" id="addSlideShow">
                  <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="AddMoreField"/>
                  Add Image
                  </a>
               </div> 
            </li>
            </ul>
         </div>
        
        

            
            <div class="RightColumnHeading">
                <h1 class="createroom">
                    <span>Digital Product</span>
                </h1>
                <div class="RightSideButton">
                    <a href="javascript:void(0)" class="show"><img src="<?=base_url();?>images/webpowerup/show.png"  /></a>&nbsp;<a href="javascript:void(0)" class="hide"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
                </div>
            </div>
            
            <div class="tab">
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                    <label class="check_label">Yes</label>
                    <input type="radio" name="digital_pro" id="digital_pro1" value="Digital" />
                    <label class="check_label">No</label>
                    <input type="radio" name="digital_pro" id="digital_pro2" value="Regular" checked="checked" />
                </dd>
            </dl>
            
            <!-- digital product yes option -->
            <div id="DigOptDiv" style="display:none;">
            	<dl>
                    <dt>
                        <label class="NewsletterLabel">Maximum Dowloads </label>
                    </dt>
                    <dd>
                        <input type="text" name="digital_max_download" id="digital_max_download" size="55" />
                    </dd>
                </dl>
                <dl>
                    <dt>
                        <label class="NewsletterLabel"># 0f Days Download Expire </label>
                    </dt>
                    <dd>
                        <input type="text" name="digital_download_expire" id="digital_download_expire" class="hasDatepicker" size="55" />
                    </dd>
                </dl>
                <dl>
                    <dt>
                        <label class="NewsletterLabel">Product File URL </label>
                    </dt>
                    <dd>
                        <input type="text" name="digital_download_url" id="digital_download_url" size="55" />
                    </dd>
                </dl>
                <dl>
                    <dt>
                        <label class="NewsletterLabel">Product File URL </label>
                    </dt>
                    <dd>
                        <input type="file" name="digital_product" id="digital_product" size="55" />
                    </dd>
                </dl>
            </div>
            <!-- digital product yes option -->
                   
            <dl>
                <dt><label for="email" class="NewsletterLabel">Quantity in stock (items) :</label></dt>
                <dd><input type="text" name="qty_in_stock" id="qty_in_stock"  size="55" value="<?=$product['qty_in_stock'];?>" /></dd>
            </dl>     
              
            <dl>
                <dt><label for="email" class="NewsletterLabel">Low Limit in Stock :</label></dt>
                <dd><input type="text" name="low_avail_limit" id="low_avail_limit" size="55"  value="<?=$product['low_avail_limit'];?>" /></dd>
            </dl> 
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Minimum order quantity :</label></dt>
                <dd><input type="text" name="min_order_qty" id="min_order_qty" size="55" value="<?=$product['min_amount'];?>" /></dd>
            </dl>
            <dl>
                <dt><label for="email" class="NewsletterLabel">Product return time (days) :</label></dt>
                <dd><input type="text" name="pd_return_time" id="pd_return_time" size="55" value="<?=$product['return_time'];?>" /></dd>
            </dl>
            
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Weight (lbs) :</label></dt>
                <dd><input type="text" name="weight_lbs" id="weight_lbs" size="55" value="<?=$product['weight_lbs'];?>" /></dd>
            </dl> 
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Free shipping :</label></dt>
                <dd>
                    <label class="check_label">Yes</label>
                    <input type="radio" name="free_shipping" id="free_shipping1" value="Yes" <?php echo ($product['free_shipping'] == 'Yes') ? 'checked="checked"' : '' ; ?> />
                    <label class="check_label">No</label>
                    <input type="radio" name="free_shipping" id="free_shipping2" value="No" <?php echo ($product['free_shipping'] == 'No') ? 'checked="checked"' : '' ; ?> />
                </dd>
            </dl> 
            <dl>
                <dt><label for="email" class="NewsletterLabel">Shipping freight ($) :</label></dt>
                <dd><input type="text" name="shipping_freight" id="shipping_freight" size="55" value="<?=$product['shipping_freight'];?>" /></dd>
            </dl>      
            <dl>
                <dt><label for="email" class="NewsletterLabel"></label></dt>
                <dd>
                    <label class="check_label">Use the dimensions of  this product for shipping cost calculation:</label>
                    <input type="checkbox" name="us_dimensions_for_shipping" id="us_dimensions_for_shipping" value="Yes" <?php echo ($product['use_dimensions'] == 'Yes') ? 'checked="checked"' : '' ; ?> />
                </dd>
            </dl>
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Shipping box dimensions (inches) :</label></dt>
                <dd>
                    <div style=" display:inline; float:left;">
                    <label class="check_label">Legth</label>
                    <input type="text" name="box_length" id="box_length" value="<?=$product['box_length'];?>" size="15" />
                    </div>
                    
                    <div style=" display:inline; float:left;">
                    <label class="check_label">Width</label>
                    <input type="text" name="box_width" id="box_width" value="<?=$product['box_width'];?>" size="15" />
                    </div>
                    
                    <div style=" display:inline; float:left;">
                    <label class="check_label">Height</label>
                    <input type="text" name="box_height" id="box_height" value="<?=$product['box_height'];?>" size="15" />
                    </div>
                </dd>
            </dl> 
            
            <dl>
                <dt><label for="email" class="NewsletterLabel"></label></dt>
                <dd>
                    <label class="check_label">Ship in a separate box :</label>
                    <input type="checkbox" name="separate_box" id="separate_box" value="Yes" <?php echo ($product['separate_box'] == 'Yes') ? 'checked="checked"' : '' ; ?> />
                </dd>
            </dl>
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Quantity per shipping box :</label></dt>
                <dd><input type="text" name="items_per_box" id="items_per_box" size="55" value="<?=$product['items_per_box'];?>" /></dd>
            </dl>
            </div>
            
            <div class="RightColumnHeading">
                <h1 class="createroom">
                    <span>Size & Weight</span>
                </h1>
                <div class="RightSideButton">
                    <a href="javascript:void(0)" class="show"><img src="<?=base_url();?>images/webpowerup/show.png"  /></a>&nbsp;<a href="javascript:void(0)" class="hide"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
                </div>
            </div>
            <div class="tab">
                <dl>
                    <dt><label for="email" class="NewsletterLabel">Cm Length :</label></dt>
                    <dd><input type="text" name="length" id="length" size="55" value="<?=$product['length'];?>" /></dd>
                </dl>
                <dl>
                    <dt><label for="email" class="NewsletterLabel">Cm Width :</label></dt>
                    <dd><input type="text" name="width" id="width" size="55" value="<?=$product['width'];?>" /></dd>
                </dl>
                <dl>
                    <dt><label for="email" class="NewsletterLabel">Cm Height :</label></dt>
                    <dd><input type="text" name="height" id="height" size="55" value="<?=$product['height'];?>" /></dd>
                </dl>
                <dl>
                    <dt><label for="email" class="NewsletterLabel">Cm Weight:</label></dt>
                    <dd><input type="text" name="weight" id="weight" size="55" value="<?=$product['weight'];?>" /></dd>
                </dl>
            </div>
            
            <div class="RightColumnHeading">
                <h1 class="createroom">
                    <span>Product Attributes</span>
                </h1>
                <div class="RightSideButton">
                    <a href="javascript:void(0)" class="show"><img src="<?=base_url();?>images/webpowerup/show.png"  /></a>&nbsp;<a href="javascript:void(0)" class="hide"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a>
                </div>
            </div>
            
	<div class="tab">

        <div id="attributes_options">
        <a id="add_tabs" href="javascript:void(0)">Add More Tab</a> | <a id="delete_tabs"  href="javascript:void(0)">Delete Tab</a>
        
            <ul id="tab_container">
                    <li id="tab_container_li1">
                        <div id="tab1" class="tabs">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr  style="background:#F3F4F8; height:35px; line-height:35px; ">
                                <td width="92%" class="smallText"><strong>ATTRIBUTE PANAL</strong></td>
                                <td width="4%"><a href="javascript:void(0)" onClick="hide_panel(1)"   class="minus"><img src="<?=base_url();?>images/webpowerup/hide.png" /></a></td>
                                <td width="4%"><a href="javascript:void(0)" onClick="show_panel(1)" class="plus"><img src="<?=base_url();?>images/webpowerup/show.png"/></a></td>			
                              </tr>
                            </table>
                        </div>	 
                            <div  id="pannel1">
                            <table width="99%" border="0" cellspacing="0" cellpadding="0" class="heading_table">
                              <tr>
                                <td align="left" valign="top"><strong>Attribute Name</strong></td>
                                <td ><input type="text" name="title1" id="title1" size="40" /></td>
                              </tr>
                            </table>		
                            <table id="attribute_table1" width="99%" border="0" cellspacing="0" cellpadding="0" class="heading_table">
                              <tr >
                                <td style="padding-bottom:5px;" colspan="3">
                                    <a id="addattrow" href="javascript:void(0)" onClick="addAttRow(1)">Add Option</a> | 
                                    <a href="javascript:void(0)"  onClick="deleteAttRow(1)" id="remove">Remove Option</a>
                                </td>
                              </tr>
                              
                              <tr class="">
                                <td width="40%" >Attribute Option Name</td>
                                <td width="37%" >Price</td>
                                <td width="23%" >Price Status</td>
                              </tr>
                              
                              <tr id="1_1" class="attOptTR">
                                <td >
                                    <input  type="text" name="att_name1_1" size="20" />
                                    </td>
                                <td ><input  type="text" name="att_price1_1" size="20" /></td>
                                <td >
                                <div style="position:relative; ">
                                    <select size="1" name="att_price_option1_1" style="width:150px;" >
                                        <option>Same Price</option>
                                        <option>Less</option>
                                        <option>Add</option>
                                    </select>
                                    </div>
                                <input type="hidden" id="sub_att1" name="sub_att1" value="1"/>
                                </td>
                              </tr>
                            </table>
                            </div>
                    </li>
            </ul>
        
        </div>

            
         <!--   <dl>
                <dt><label for="email" class="NewsletterLabel">Attribute Name :</label></dt>
                <dd><input type="text" name="" id="" size="55" /></dd>
            </dl>
            <div class="DataGrid2">
           <ul class="TableData AlterRow AddFieldRow">
                <li>
                 <div class="AddMoreField">
                    <a href="#">
                    <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="AddMoreField"/>
                    Add Option
                    </a>
                    <a href="#">
                    <img src="<?=base_url();?>images/webpowerup/AddMoreField.png" alt="AddMoreField"/>
                    Remove Option
                    </a>
                 </div>
                </li>
            </ul> 
            
             <ul class="TableHeader">
            <li>Attribute Option Name</li>
            <li>Price </li>
            <li class="imagefield">Price Status</li>
        </ul>
            
        <ul class="TableData">
            <li>
                <input type="text" name="" id="" size="19" /> 
            </li>
            
             <li>
                <input type="text" name="" id="" size="19" /> 
            </li>
            <li class="imagefield">
                <input type="file" name="fileupload" id="" />
            </li>
            
        </ul>-->
             
         
             
       
                                
            
             <dl>
                <dt><label for="color" class="NewsletterLabel" >Product SKU :</label></dt>
                <dd>
                    <label class="check_label">Automatically Generate a SKU</label>
                    <input type="radio" name="sku_allow" id="sku_allow1" value="Automatically" <?php echo ($product['sku'] == 'Automatically') ? 'checked="checked"' : '' ; ?> />
                    <label class="check_label">Use a Custome SKU</label>
                    <input type="radio" name="sku_allow" id="sku_allow2" value="Custome" <?php echo ($product['sku'] == 'Custome') ? 'checked="checked"' : '' ; ?> />
                </dd>
            </dl>
            
            <dl>
                <dt><label for="gender" class="NewsletterLabel">Add to Group After Purchase : </label></dt>
                <dd>
                    <div style=" float:left; width:100%; position:relative;">
                    <select size="1" name="pending_membershipid" id="pending_membershipid"  style="width:360px"> 
                        <option value=""> None</option>
                        <option value="0">Group Code</option>
                        <? for($i = 0; $i<count($membership); $i++){ ?>
                        	<option value="<?=$membership[$i]['id']?>"><?=$membership[$i]['group_name']?></option>
                        <? } ?> 
                    </select>
                    </div>
                    
                   
                </dd>
            </dl>
            
             <dl>
                <dt><label for="color" class="NewsletterLabel">Publish : </label></dt>
                <dd>
                    <label class="check_label">Yes</label>
                    <input type="radio" name="publish" id="publish1" value="Yes" <?php echo ($product['publish'] == 'Yes') ? 'checked="checked"' : '' ; ?> checked="checked" />
                    <label class="check_label">No</label>
                    <input type="radio" name="publish" id="publish2" value="No" <?php echo ($product['publish'] == 'No') ? 'checked="checked"' : '' ; ?> />
                </dd>
            </dl>
		
       </div>        
                          
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                    <div class="ButtonRow">
                        <a href="<?=site_url();?>Products_Management/">
                        	<img alt="CancelButton" src="<?=base_url();?>images/webpowerup/CancelRed.png">
						</a>
                        <button type="submit" >
                            <img src="<?=base_url();?>images/webpowerup/SaveGreen.png" alt="Add Green"/>
                        </button>
                       
                     </div>
                     
                </dd>
            </dl>

             
            
        </fieldset>
        
 </form>
 </div>