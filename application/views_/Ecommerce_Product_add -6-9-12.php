<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ecommerce : <?=$title?> </title>
    
<!--javascripts add /roemove     -->
<script type="text/javascript"> 
    <!-- 
    function showMe (it, box) { 
      var vis = (box.checked) ? "block" : "none"; 
      document.getElementById(it).style.display = vis;
    } 
    function hideMe (it, box) { 
      var vis = (box.checked) ? "none" : "block"; 
      document.getElementById(it).style.display = vis;
    } 
    //--> 
</script>  
<!-- end javascriptts add/remove  -->
<!--javascripts add /roemove     -->
 <script language="Javascript" type="text/javascript">
                             <!--
  
 function addImageRow(tableID) {
 
            var table = document.getElementById(tableID); 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount); 
            var colCount = table.rows[0].cells.length;               
            var newRowCount = table.rows.length;
            var ary_index = newRowCount;
            //  alert(colCount);
            for(var i=0; i<5; i++) {
                var newcell = row.insertCell(i);
                  //alert(table.rows[0].cells[i].innerHTML);
                    // alert(table.rows[0].cells[i].innerHTML);
            //     table.rows[0].cells[0].innerHTML ='';
                if (i=='2'){
                     newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                     //  alert(table.rows[0].cells[i].innerHTML); 
                // newcell.innerHTML = '<select name="'+'image['+ary_index+'][type]'+'" id="type"><option value="Single-Line Text">Single-Line Text </option><option value="Multi-Line Text">Multi-Line Text</option><option value="Check Boxes">Check Boxes</option><option value="Radio Buttons">Radio Buttons</option></select>';
                 }else{
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                 }
               //alert ( table.rows[0].type);
             //  alert ( newcell.childNodes[0].name);
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) { 
                    case "text":
                            newcell.childNodes[0].value = "";
                           // alert(newcell.innerHTML);
                          if(newcell.childNodes[0].name == "image[1][title]"){
                             newcell.childNodes[0].name =  'image['+ary_index+'][title]';
                          }else if(newcell.childNodes[0].name == "image[1][desc]"){
                             newcell.childNodes[0].name =  'image['+ary_index+'][desc]';  
                          }
                          else if(newcell.childNodes[0].name == "attribute[1][title]"){
                             newcell.childNodes[0].name =  'attribute['+ary_index+'][title]';  
                          }else if(newcell.childNodes[0].name == "attribute[1][desc]"){
                             newcell.childNodes[0].name =  'attribute['+ary_index+'][desc]';  
                          }
                          
                            break;
                    case "checkbox": 
                    newcell.childNodes[0].checked = false; 
                    
                    if(newcell.childNodes[0].name == "image[1][check]"){
                        
                             newcell.childNodes[0].name =  'image['+ary_index+'][check]';
                          }else if(newcell.childNodes[0].name == "image[1][required]"){
                             newcell.childNodes[0].value = "1";
                             newcell.childNodes[0].name =  'image['+ary_index+'][required]';  
                          }else if(newcell.childNodes[0].name == "attribute[1][check]"){
                             newcell.childNodes[0].name =  'attribute['+ary_index+'][check]';  
                          }
                            break;
                    case "select-one":
                           // newcell.innerHTML='<input type="text" id="txtItemName'+countItems+'" name="txtItemName'+countItems+'" value="" />';
                            break; 
                    case "file":
                        //  alert(newcell.childNodes[0].name);
                         // newcell.childNodes[0].name =  'items['+ary_index+'][image]';
                          newcell.childNodes[0].name =  'galaryImg_'+ary_index;   
                        //  newcell.childNodes[0].name =  'attribute['+ary_index+'][image]';   
                }
            }
//                var newRowCount = table.rows.length;
//                      var ary_index = newRowCount; 
//                for(var i=1; i<=newRowCount; i++){
//                    table.rows[i].cells[2].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][title]' );
//                    table.rows[i].cells[3].getElementsByTagName('select').item(0).setAttribute('name','items['+ary_index+'][type]');
//                    table.rows[i].cells[4].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][required]');
//                    table.rows[i].cells[5].getElementsByTagName('input').item(0).setAttribute('name','items['+ary_index+'][order]');
//                }    
                                                 
            

        }
 
        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            //  alert('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
            }
            }catch(e) {
                alert(e);
            }
        }

 function deleteRowOne(i){
    document.getElementById('tblAddFiels').deleteRow(i)
}

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
//-->
</script>   
<script>

	
	$(document).ready(function(){
		$('#add_tabs').click(function(){
		var numImages = Number($('#tab_container li').length);
		numImages++;			
		var html ='<li style="padding-top:5px;" id="tab_container_li'+numImages+'"><div id="tab'+numImages+'" class="tabs"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="92%"><label class="surveys">ATTRIBUTE PANAL</label></td><td width="4%"><a href="javascript:void(0)" onClick="hide_panel('+numImages+')" class="minus"><img src="<?=base_url()?>images/minus.png" /></a></td><td width="4%"><a href="javascript:void(0)" onClick="show_panel('+numImages+')" class="plus"><img src="<?=base_url()?>images/plus.png"/></a></td></tr></table></div><div style="display:none;"  id="pannel'+numImages+'"><table width="99%" border="0" cellspacing="0" cellpadding="0" class="heading_table"><tr><td >Attribute Name:</td><td ><input type="text" name="title'+numImages+'" id="title'+numImages+'"  class="large" /></td></tr></table><table id="attribute_table'+numImages+'" width="99%" border="0" cellspacing="0" cellpadding="0" class="heading_table"><tr><td style="padding-bottom:5px;" colspan="3"><a id="addattrow" href="javascript:void(0)" onClick="addAttRow('+numImages+')">Add Option</a> | <a href="javascript:void(0)" onClick="deleteAttRow('+numImages+')" id="remove">Remove Option</a></td></tr><tr class="title-tr"><td width="40%" >Attribute Option Name</td><td width="37%" >Price Status</td><td width="23%" >Price</td></tr><tr><td><input  type="text" name="att_name'+numImages+'_1" /></td><td><input  type="text" name="att_price'+numImages+'_1" /></td><td><select name="att_price_option'+numImages+'_1" ><option>Same Price</option><option>Less</option><option>Add</option></select><input type="hidden" id="sub_att'+numImages+'" name="sub_att'+numImages+'" value="1"/></td></tr></table></div></li>';
				   
			$('ul#tab_container').append(html); 
			document.getElementById('main_att').value = numImages;
		});
		
		$('#delete_tabs').click(function(){
			//alert('sdfsdf');
		var numImages = Number($('#tab_container li').length);
		if(numImages > 1) {
        	$('li:last').remove();
        	numImages--;
			document.getElementById('main_att').value = numImages;
			document.getElementById('main_att').value = numImages;
    	}

		});
		
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
		
		//alert(row_number);
		var count = $("#attribute_table"+row_number+" tr").length;
		//alert(count);
		tr_count = count-2;
		tr_count++;
		var del = row_number+'_'+tr_count;
		//del = "'"+del+"'";			
		var html ='<tr class="option_tr" id="'+del+'"><td><input  type="text" name="att_name'+del+'" /></td><td><input  type="text" name="att_price'+del+'" /></td><td><select name="att_price_option'+del+'" ><option>Same Price</option><option>Less</option><option>Add</option></select><input type="hidden" id="sub_att'+row_number+'" name="sub_att'+row_number+'" value="'+tr_count+'" /></td></tr>';
		   // alert("#attribute_table"+row_number);
		$("#attribute_table"+row_number).append(html); 
			//document.getElementById('sub_att').value = row_number;
	}

</script>



<!-- end javascriptts add/remove  -->

<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->

<script type="text/javascript">

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
#create_edit{

 -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #EEEEEE;
    border-color: #CCCCCC #E7E7E7 #FFFFFF;
    border-radius: 4px 4px 4px 4px;
    border-style: solid;
    border-width: 1px;
    color: #6F6F6F;
    font-family: inherit;
    font-size: 12px;
    font-style: inherit;
    font-weight: 100;
    margin-bottom: 18px;
    outline: 0 none;
    padding: 4px;
    vertical-align: baseline;
}
.tabs {
    background: #E9E9E9;
    border: 1px solid #E9E9E9;
    height: 30px;
    padding: 9px 0 0 15px;
    width: 485px;
}
.minus{
    display: block;
    height: 15px;
    width: 15px;
}
.plus {
    display: block;
    height: 15px;
    width: 15px;
}
#pannel1{
	display:none;
}
.heading_table
{
	padding-top:10px;
}
.heading_table tr td input.large{
width:99% !important;
}
.heading_table tr td input{
width:150px !important;
}

.title-tr td
{
	text-align:left;
}
#tab_container
{
	list-style:none;
	margin:0;
	padding:0;
}
.option_tr td
{

	padding-top:5px;
}
#create_edit{
}
</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
$(function() {
$( "#digital_download_expire" ).datepicker();
});
</script>
</head>
<body>
<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
 <?php
 
   $attributes = array( 'id' => 'add_product' , 'name' => 'add_product', 'onSubmit' => 'return validate()'   ,'enctype' => 'multipart/form-data');
   if(isset($invoice_create_time) && $invoice_create_time==1)
   {
		$invoice_create_time = 2;
   }
    echo form_open(base_url().'/Products_Management/create/'.$invoice_create_time, $attributes); 
    echo form_hidden('action','product_add');  
       
   $pd_name = array(
                        'name' => 'product_name',
                        'id' => 'product_name',
                         'size' => '30',
                          'value' => set_value('product_name','')
                          );
   
   
   $ptice = array('name'=>'price','id'=>'price','size'=>20 , 'value' => set_value('price','')); 
   $ptice_tax = array('name'=>'price_tax','id'=>'price_tax','size'=>12 , 'value' => set_value('price_tax','')); 
   $digital_max_download = array('name'=>'digital_max_download','id'=>'digital_max_download','size'=>12 , 'value' => set_value('digital_max_download','')); 
   $digital_download_expire = array('name'=>'digital_download_expire','id'=>'digital_download_expire','size'=>12 , 'value' => set_value('digital_download_expire','')); 
   $digital_download_url = array('name'=>'digital_download_url','id'=>'digital_download_url','size'=>50, 'value' => set_value('digital_download_url','')); 
   
   $qty_in_stock = array('name'=>'qty_in_stock','id'=>'qty_in_stock','size'=>'18', 'value' => set_value('qty_in_stock','1000')); 
   $low_avail_limit = array('name'=>'low_avail_limit','id'=>'low_avail_limit','size'=>'18', 'value' => set_value('low_avail_limit','10')); 
   $min_order_qty = array('name'=>'min_order_qty','id'=>'min_order_qty','size'=>'18', 'value' => set_value('min_order_qty','1')); 
   $pd_return_time = array('name'=>'pd_return_time','id'=>'pd_return_time','size'=>'18', 'value' => set_value('pd_return_time','0')); 
   
   $weight_lbs = array('name'=>'weight_lbs','id'=>'weight_lbs','size'=>'18', 'value' => set_value('weight_lbs','0.00')); 
   $shipping_freight = array('name'=>'shipping_freight','id'=>'shipping_freight','size'=>'18', 'value' => set_value('shipping_freight','0.00')); 
   
   $box_length = array('name'=>'box_length','id'=>'box_length','size'=>'6', 'value' => set_value('box_length','0.00')); 
   $box_height = array('name'=>'box_height','id'=>'box_height','size'=>'6', 'value' => set_value('box_height','0.00')); 
   $box_width = array('name'=>'box_width','id'=>'box_width','size'=>'6', 'value' => set_value('box_width','0.00')); 
   $items_per_box = array('name'=>'items_per_box','id'=>'items_per_box','size'=>'18', 'value' => set_value('items_per_box','')); 
   
   $length = array('name'=>'length','id'=>'length','size'=>'18', 'value' => set_value('length','')); 
   $height = array('name'=>'height','id'=>'height','size'=>'18', 'value' => set_value('height','')); 
   $width = array('name'=>'width','id'=>'width','size'=>'18', 'value' => set_value('width','')); 
   $weight = array('name'=>'weight','id'=>'weight','size'=>'18', 'value' => set_value('weight','')); 
   
   $taxable_yes = array('name' => 'taxable_rd','id' => 'taxable', 'value' => 'Yes', 'checked' => set_radio('taxable_rd', 'Yes', FALSE), 'onclick' => "showMe('tax', this)" );  
   $taxable_no = array( 'name' => 'taxable_rd','id' => 'taxable', 'value' => 'No', 'checked' => set_radio('taxable_rd', 'No',TRUE) , 'onclick' => "hideMe('tax', this)"  );   
   
   $permision_every = array( 'name' => 'access_permision','id' => 'access_permision1', 'value' => 'Everyone', 'checked' => set_radio('taxable_rd', 'Everyone',TRUE) , 'onclick' => "hideMe('roles', this)"  );   
   $permision_register = array( 'name' => 'access_permision','id' => 'access_permision2', 'value' => 'Registered', 'checked' => set_radio('taxable_rd', 'Registered',FALSE) , 'onclick' => "hideMe('roles', this)"  );   
   $permision_other = array( 'name' => 'access_permision','id' => 'access_permision3', 'value' => 'Other', 'checked' => set_radio('taxable_rd', 'Other',FALSE) , 'onclick' => "showMe('roles', this)"  );   
   
   $uplaod_img_yes = array( 'name' => 'image_rd','id' => 'image_rd', 'value' => 'Yes', 'checked' => set_radio('image_rd', 'Yes',FALSE) , 'onclick' => "showMe('img', this)"  );   
   $uplaod_img_no = array( 'name' => 'image_rd','id' => 'image_rd', 'value' => 'No', 'checked' => set_radio('image_rd', 'No',TRUE) , 'onclick' => "hideMe('img', this)"  );   
   
   $digital_pro_yes = array( 'name' => 'digital_pro','id' => 'digital_pro', 'value' => 'Digital', 'checked' => set_radio('digital_pro', 'Yes',FALSE) , 'onclick' => "showMe('digital_product', this)"  );   
   $digital_pro_no = array( 'name' => 'digital_pro','id' => 'digital_pro', 'value' => 'Regular', 'checked' => set_radio('digital_pro', 'No',TRUE) , 'onclick' => "hideMe('digital_product', this)"  );   
    
   $allow_yes = array('name' => 'member_allow','id' => 'taxable', 'value' => 'Automatically', 'checked' => set_radio('member_allow', 'Yes', TRUE) );  
   $allow_no = array( 'name' => 'member_allow','id' => 'taxable', 'value' => 'Custome', 'checked' => set_radio('member_allow', 'No',FALSE));
   
   $sku_yes = array('name' => 'sku_allow','id' => 'sku', 'value' => 'Automatically', 'checked' => set_radio('sku_allow', 'Automatically', TRUE) );  
   $sku_no = array( 'name' => 'sku_allow','id' => 'sku', 'value' => 'Custome', 'checked' => set_radio('sku_allow', 'Custome',FALSE));
   
   $publish_yes = array('name' => 'publish','id' => 'publish', 'value' => 'Yes', 'checked' => set_radio('sku_allow', 'Yes', TRUE) );  
   $publish_no = array( 'name' => 'publish','id' => 'publish', 'value' => 'No', 'checked' => set_radio('sku_allow', 'No',FALSE));
                                                                                                                                     
   $short_desc = array('name'=>'short_desc','id'=>'short_desc','rows'=>5, 'cols'=>'40');
   $full_desc = array('name'  => 'full_desc', 'id' => 'ck_content','value'  => set_value('full_desc', ''));
   
   $min_qty = array('name' => 'min_qty','id' => 'min_qty', 'size' => '30', 'value' => set_value('min_qty',''));
   $discount_rate = array('name' => 'discount_rate','id' => 'discount_rate', 'size' => '30', 'value' => set_value('discount_rate',''));
   $min_qty_rate = array('name' => 'min_qty_rate','id' => 'min_qty_rate', 'size' => '30', 'value' => set_value('min_qty_rate',''));
   
   $title_tag = array('name'=>'title_tag','id'=>'title_tag','rows'=>5, 'cols'=>'40');
   $meta_key = array('name'=>'meta_key','id'=>'meta_key','rows'=>5, 'cols'=>'40');
   $meta_desc = array('name'=>'meta_desc','id'=>'meta_desc','rows'=>5, 'cols'=>'40');
   
   
   $group = array('name'=>'grouping','id'=>'group','size'=>50);  
   $image = array('name'=>'product_image','id'=>'image','size'=>40);
   $digital_product = array('name'=>'digital_product','id'=>'digital_product','size'=>40);
   
   $options_acess_level = array('1' => 'Page Manager', '2' => 'User Manager', '3' => 'Site User', '4' => 'Administrator');
   $options = array('Active' => 'Active', 'Inactive' => 'Inactive');
   $options_gruop = array('0' => 'Gruop A', '1' => 'Gruop B' , '2' => 'Gruop C' ,'3' => 'Gruop D');
   $tax_param = array('$' => '$', '%' => '%');
   $free_shipping = array('No' => 'No', 'Yes' => 'Yes');
   
   $us_dimensions_for_shipping = array('name' => 'us_dimensions_for_shipping', 'id' => 'us_dimensions_for_shipping', 'value' => 'Yes','checked' => TRUE,  'style' => 'margin:10px' , 'onclick' => "switchPDims(this)"); 
   $separate_box = array('name' => 'separate_box', 'id' => 'separate_box', 'value' => 'Yes','checked' => TRUE,  'style' => 'margin:10px' , 'onclick' => "switchPDims(this)"); 
    
?>
<h1> <?=$title?></h1>

<div id="create_edit">
<div class="row" id="div1" style="display:block;">

 <div style="float: left; margin-left: 20px;" >
 
          <p><label for='catname'>Product Name</label><br/> <?php echo form_input($pd_name); ?> </p>
          <p><label for='short'>Short Description</label><br/>   <?php echo form_textarea($short_desc); ?>  </p>
          
          
</div>
 <div style="float: left; margin-left: 20px;" >

            <p><label for='short'>Title Tage :</label><br/>   <?php echo form_textarea($title_tag); ?>  </p> 
            <p><label for='short'>META Keywords</label><br/>   <?php echo form_textarea($meta_key); ?>  </p> 
             <p><label for='short'>META Description</label><br/>   <?php echo form_textarea($meta_desc); ?>  </p>  
 
</div>      
 <div style="float: left; margin-left: 10px; clear: both;" >  
        
              <h2> Detail Description </h2> <hr/> 
              <p><label for='long'>Long Description</label><br/>
              <?php echo form_textarea($full_desc); ?>  
              <?php //echo display_ckeditor($ck_data['ckeditor']); ?> 
              </p>
                         
 </div> 
 <div style="float: left; margin-left: 10px; clear: both;" >
         <h2>Price : </h2> <hr/>
         <p><label for='price'>Price</label><br/>   <?php echo form_input($ptice) ?>  </p>
         <p><label for='price'>Taxable : </label></p>      
         <p> <?php  echo form_radio($taxable_yes); ?> Yes </p>
           <div id='tax' style=" display: none;">
              <p><label for='catname'> Tax : </label> <?php echo form_input($ptice_tax); ?> <?php echo form_dropdown('tax_param',$tax_param) ?> </p> 
           </div>                    
         <p>  <?php  echo form_radio($taxable_no); ?> No </p>  
          
 
 </div>  
 <div style="float: left; margin-left: 10px; clear: both;" > 
         <h2>Category : </h2> <hr/>
        <p><label for='parent'>Category</label><br/> <?php echo form_dropdown('parentid',$categories, 0 , 'size="1" id="parentid"  multiple="MULTIPLE" style=" width:240px; height:140px;"') ?></p> 
        <p><label for='price'><strong>Which group can see this product ?</strong></label><br/> </p>
        <p><label> <?php  echo form_radio($permision_every); ?> Everyone </label> </p> 
        <p><label> <?php  echo form_radio($permision_register); ?> All Registered Users </label> </p> 
        <p><label> <?php  echo form_radio($permision_other); ?>Only Users With a Certain Access Level &nbsp; </label></p> 
        <p style="">
            <div style="display: none;" name="roles" id="roles" > 
                <?php /*?> <?php echo form_dropdown('options_acess_level',$options_acess_level, 0 , 'size="1" multiple="MULTIPLE" style=" width:240px; height:96px; margin-left:25px; margin-bottom:10px;"') ?><?php */?>
				<select name="group_access[]" id="group_access" multiple="multiple" style="width:240px; margin-top:10px;margin-bottom:10px; padding-left:5px; height:96px; opacity: 1; filter: alpha(opacity = 100)">
				<?
				foreach($groups as $group)
                	{
				?>
						<option value="<?=$group['id']?>"><?=$group['group_name']?></option>
				<? 	} ?>
				   </select>
				
            </div>
        <p/>
 </div>   
 
 <div style="float: left; margin-left: 10px; clear: both;" >  
        
              <h2> Image </h2> <hr/>
              <p><label> <?php  echo form_radio($uplaod_img_yes); ?> Upload a new image &nbsp; </label> </p> 
              <div id='img' style=" display: none;"><p style="margin-left: 26px;"> <?php echo form_upload($image) ?></p> </div> 
              <p><label> <?php  echo form_radio($uplaod_img_no); ?> None &nbsp; </label> </p> 
             
 </div>               

  <div style="float: left; margin-left: 10px; clear: both; " > 
        <p><strong>Create Product Slide Show </strong></p> 

            <table width="100%" height="50" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
				<tr bgcolor="#F3F3F3">
					<td width="5%" align="center">&nbsp;  </td> 
					<td width="20%" align="center"> Image Title </td>
					<td width="22%" align="center"> Image Decription</td>
					<td width="25%" colspan="2" align="center">Image</td>
				</tr>
				<tr>
				 <td colspan="5">     
				 <table width="100%" border="0" cellspacing="1" cellpadding="3" id="tblAddImageFiels">
						  <tr>
							<td width="5%" align="center"><input type="checkbox" name="image[1][check]" id="check" /></td>
							<td width="25%" align="center"><input name="image[1][title]" type="text" id="title" size="20" value="" /></td>
							<td width="30%" align="center"><input name="image[1][desc]" type="text" id="desc" size="25" value="" /></td>
							<td width="40%" colspan="2" align="center"><input type="file" name="galaryImg_1" /></td>
						  </tr>
				 </table>
				 </td> 
				</tr>
           <tr bgcolor="#F3F3F3">
                <td colspan="5"></td>
           </tr> 
       </table> 
	         
      <div style="margin-bottom: 10px; margin-left: 25px;">     
            <INPUT type="button" value="Add Image" onClick="addImageRow('tblAddImageFiels')" /> &nbsp; 
            <!--<INPUT type="button" value="Delete Selected Row" onclick="deleteRow('tblAddFiels')" />--> 
            <INPUT type="button" value="Delete Selected" onClick="deleteRow('tblAddImageFiels')" /> 
      </div>       
    
  </div> 
  
 <div style="float: left; margin-left: 10px; clear: both;" >  
           <h2> Digital Product </h2> <hr/> 
           <p> <label> <?php  echo form_radio($digital_pro_yes); ?> Yes &nbsp;  </label> </p>
               <div id='digital_product' style=" display: none;">
                
                <p><label for='catname'>Maximum Dowloads : </label> <?php echo form_input($digital_max_download); ?> </p>
                <p><label for='catname'># 0f Days Download Expire : </label> <?php echo form_input($digital_download_expire); ?> </p>
                <p><label for='catname'> Product File URL : </label> <?php echo form_input($digital_download_url); ?> </p>
                <p style="margin-left: 26px;"><label for='catname'> Product File URL </label> <?php echo form_upload($digital_product) ?></p> 
             </div> 
           <p><label> <?php  echo form_radio($digital_pro_no); ?> No &nbsp;  </label> </p> 
</div>   
<div style="float: left; margin-left: 10px; clear: both;" >  
    <table width="100%" >
        <tr>
           <td colspan="2"><hr /></td>
        </tr>
        <tr> 
           <td width="200" class="FormButton" nowrap="nowrap">Quantity in stock (items):</td>
           <!--<td width="890%" class="ProductDetails"> <input type="text" name="avail" size="18" value="1000" />  </td>-->
           <td width="890%" class="ProductDetails"> <?php echo form_input($qty_in_stock); ?> </td>
        </tr>
        <tr> 
           <td class="FormButton" nowrap="nowrap">Low limit in stock:</td>
           <!--<td class="ProductDetails"> <input type="text" name="low_avail_limit" size="18" value="10" /> </td> -->
           <td class="ProductDetails"> <?php echo form_input($low_avail_limit); ?> </td>
        </tr>
        <tr>
           <td class="FormButton" nowrap="nowrap">Minimum order quantity:</td>
           <!--<td class="ProductDetails"><input type="text" name="min_amount" size="18" value="1" /></td> -->
           <td class="ProductDetails"><?php echo form_input($min_order_qty); ?></td>
        </tr>
        <tr> 
           <td class="FormButton" nowrap="nowrap">Product return time (days):</td>
           <!--<td class="ProductDetails"><input type="text" name="return_time" size="18" value="" /></td> -->
           <td class="ProductDetails"><?php echo form_input($pd_return_time); ?></td>
        </tr>
        <tr>
           <td colspan="2"><hr /></td>
        </tr>
 </table>
 </div>
 <div style="float: left; margin-left: 10px; clear: both;" > 
       <table width="100%" >
           <tr>
              <td colspan="2"><hr /></td>
           </tr>
           <tr> 
              <td width="200" nowrap="nowrap" class="FormButton">Weight (lbs):</td>
              <!--<td width="890%" class="ProductDetails">  <input type="text" name="weight" size="18" value="0.00" />  </td>  -->
              <td width="890%" class="ProductDetails">  <?php echo form_input($weight_lbs) ?> </td>
           </tr>

           <tr> 
              <td class="FormButton" nowrap="nowrap">Free shipping:</td>
              <td class="ProductDetails"> <?php echo form_dropdown('free_shipping',$free_shipping) ?>  </td>
              <!--<td class="ProductDetails">
                  <select name="free_shipping">
                    <option value='N'>No</option>
                    <option value='Y'>Yes</option>
                  </select> 
              </td>    -->
           </tr>

           <tr>
              <td class="FormButton" nowrap="nowrap">Shipping freight ($):</td>
              <!--<td class="ProductDetails"> <input type="text" name="shipping_freight" size="18" value="0.00" />  </td> -->
              <td class="ProductDetails"> <?php echo form_input($shipping_freight) ?> </td>
           </tr>

           <tr>
              <td class="FormButton">Use the dimensions of this product for shipping cost calculation:</td>
              <!--<td class="ProductDetails">  <input type="checkbox" name="small_item" value="Y" checked="checked" onclick="javascript: switchPDims(this);" />    </td>-->
              <td class="ProductDetails">  <?php echo form_checkbox($us_dimensions_for_shipping);  ?>           </td>
           </tr>

           <tr>
              <td class="FormButton" nowrap="nowrap">Shipping box dimensions (inches):</td>
              <td class="ProductDetails">
                  <table cellpadding="0" cellspacing="1" border="0" width="100%">
                       <tr>
                          <td colspan="2">Length</td>
                          <td colspan="2">Width</td>
                          <td colspan="3">Height</td>
                       </tr>
                       <tr>
                          <td> <?php echo form_input($box_length) ?> </td>
                          <td>&nbsp;x&nbsp;</td>
                          <td> <?php echo form_input($box_width) ?> </td>
                          <td>&nbsp;x&nbsp;</td>
                          <td><?php echo form_input($box_height) ?></td>
                          <td align="center" width="100%">&nbsp;</td>
                       </tr>
                  </table>
              </td>
            </tr>
           <tr>
              <td class="FormButton">Ship in a separate box:</td>
              <td class="ProductDetails"> <?php echo form_checkbox($separate_box);  ?>   </td>
           </tr>

           <tr>
              <td class="FormButton" nowrap="nowrap">Quantity per shipping box:</td>
              <td class="ProductDetails"> <?php echo form_input($items_per_box) ?> </td>
           </tr>

           <tr>
              <td colspan="2"><hr /></td>
           </tr>
      </table>
 </div>
 <div style="float: left; margin-left: 10px; clear: both;" >
         <h2>Size &amp; Weight : </h2> <hr/>
        <p><label for='price'>Length : cm </label>   <?php echo form_input($length) ?> </p> 
        <p><label for='price'>Width : cm  </label>   <?php echo form_input($width) ?>  </p> 
        <p><label for='price'>Height : cm </label>   <?php echo form_input($height) ?>  </p> 
		<p><label for='price'>Weight : kg </label>  <?php echo form_input($weight) ?> </p>
        <p> <hr> </p> 
 </div>  
 <div id="attribute_tabs" style="float: left; margin-left: 10px; clear: both;" > 
         <h2>Product Attributes : </h2><a id="add_tabs" href="javascript:void(0)">Add More Tab</a> | <a id="delete_tabs"  href="javascript:void(0)">Delete Tab</a><hr/>
        <!--<div style="margin-bottom: 10px; margin-left: 25px; float: left;">   -->  
          <input type="hidden" id="main_att" name="main_att" value="1"/>
	   <ul id="tab_container">
			<li id="tab_container_li1">
				<div id="tab1" class="tabs">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="92%"><label class="surveys">ATTRIBUTE PANAL</label></td>
						<td width="4%"><a href="javascript:void(0)" onClick="hide_panel(1)"   class="minus"><img src="<?=base_url()?>images/minus.png" /></a></td>
						<td width="4%"><a href="javascript:void(0)" onClick="show_panel(1)" class="plus"><img src="<?=base_url()?>images/plus.png"/></a></td>			
					  </tr>
					</table>
				</div>	 
				<div  id="pannel1">
				<table width="99%" border="0" cellspacing="0" cellpadding="0" class="heading_table">
				  <tr>
					<td >Attribute Name:</td>
					<td ><input type="text" name="title1" id="title1"  class="large" /></td>
				  </tr>
				</table>		
				<table id="attribute_table1" width="99%" border="0" cellspacing="0" cellpadding="0" class="heading_table">
				  <tr >
					<td style="padding-bottom:5px;" colspan="3">
						<a id="addattrow" href="javascript:void(0)" onClick="addAttRow(1)">Add Option</a> | 
						<a href="javascript:void(0)"  onClick="deleteAttRow(1)" id="remove">Remove Option</a>
					</td>
				  </tr>
				  <tr class="title-tr">
					<td width="40%" >Attribute Option Name</td>
					<td width="37%" >Price</td>
					<td width="23%" >Price Status</td>
				  </tr>
				  <tr id="1_1">
					<td><input  type="text" name="att_name1_1" /></td>
					<td><input  type="text" name="att_price1_1" /></td>
					<td>
						<select name="att_price_option1_1" >
							<option>Same Price</option>
							<option>Less</option>
							<option>Add</option>
						</select>
                         <input type="hidden" id="sub_att1" name="sub_att1" value="1"/>
					</td>
				  </tr>
				</table>
				</div>
			</li>
		</ul>
		
		
		 <?php /*?> <table id="attribute_table" width="100%" border="0">
			  <tr id="row1">
				<td><img  src="<?=base_url()?>/images/remove.png" /></td>
				<td> Attribute Title</td></td>
				<td  ><input name="title1" type="text" id="title" size="20" value="" /></td>
				<td style="padding-left:5px;" ><a id="addattrow" href="javascript:void(0)" onClick="addAttRow(1)">Add Attributes</a></td>
			  
			  </tr>
		  </table>
		  <input id="addnewrow" name="addnewrow" value="Add New Row"  type="button" /><?php */?>
            <?php /*?><table width="100%" height="50" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                            <tr bgcolor="#F3F3F3">
                            <td width="5%" align="center" >&nbsp;  </td> 
                            <td width="25%" align="center" > Attribute Title</td>
                            <td width="70%" align="center" >Attribute Values</td>
                            </tr>
                            <tr>
                              <td  colspan="3" >
                                   <table width="100%" border="0" cellspacing="1" cellpadding="3" id="tblAddrows">
									  <tr>
										<td width="5%" align="center"><input type="checkbox" name="attribute[1][check]" id="check" /></td>
										<td width="25%" align="center"><input name="attribute[1][title]" type="text" id="title" size="20" value="" /></td>
										<td width="40%" align="center"><input name="attribute[1][desc]" type="text" id="order" size="20"  value="" /></td>
										<td align="right" width="30%"><a href="javascript:void(0)" onClick="deleteAttRow(1)" >Delete</a> |<a id="addattrow" href="javascript:void(0)" onClick="addAttRow(1)">Add</a></td>
																					  
									  </tr>
									  <tr>
									  	<td style="padding-left:50px;" colspan="3">
											<table  id="att_table"  width="100%">
												<tr>
													<td  align="center"><input type="checkbox" name="att_check1" id="check" /></td>
													<td ><input  type="text" name="att_name1" /></td>
													<td >
														<select name="att_price_option1" >
														<option>Same Price</option>
														<option>Less</option>
														<option>Add</option>
														</select>
													</td>
													<td >$<input type="text" name="att_price1" /></td>												
												</tr>
											</table>
										</td>									  
									</tr>
                                   </table>
                               </td>   
                            </tr>
                           <tr bgcolor="#F3F3F3">
                           <td colspan="3">        </td>
                           </tr> 
              </table><?php */?>           
       
 </div>       
 
  <div style="float: left; margin-left: 10px; clear: both;" >  
        <h2>Product SKU </h2> <hr/> 
         
         
         <p><label> <?php  echo form_radio($sku_yes); ?>  Automatically Generate a SKU  </label></p>
         <p><label> <?php  echo form_radio($sku_no); ?>  Use a Custome SKU  </label></p>
         <!--<p><label><input type="radio" value="Yes" name="image_rd" > Automatically Generate a SKU  </label></p>  
         <p><label><input type="radio" value="Yes" name="image_rd" > Use a Custome SKU  </label></p> -->
            
 </div> 
 
  <div style="float: left; margin-left: 10px; clear: both;" >  
        <h2>Add To Group After Purchase </h2> <hr/> 
         <p> 
		 <?php /*echo form_dropdown('group',$options_gruop);
		 echo '<pre>';
		 print_r($options_gruop);
		 print_r($data);*/		 
		  ?><select onChange="hide_group_code(this.value)"  name="pending_membershipid" id="gp_drop_down" >

			<option value=""> None</option>

			<option value="0">Group Code</option>

	

			<? for($i = 0; $i<count($membership); $i++){ ?>

				<option value="<?=$membership[$i]['id']?>"><?=$membership[$i]['group_name']?></option>

			<? } ?>

		 </select> </p>
         
            
 </div>
 
  <div style="float: left; margin-left: 10px; clear: both;" >  
        <h2>Publish </h2> <hr/> 
         
         <p><label> <?php  echo form_radio($publish_yes); ?>  Yes </label></p>
         <p><label> <?php  echo form_radio($publish_no); ?>   No </label></p>
         <!--
         <p><label><input type="radio" value="Yes" name="image_rd" > Yes</label></p>
         <p><label><input type="radio" value="Yes" name="image_rd" > No </label></p>
         <p><label for='status'>Status</label><br/> <?php // echo form_dropdown('status',$options) ?> </p>    -->
            
 </div> 
  
 
    <div style="float: left; margin-left: 10px; clear: both; margin-bottom: 30px;" >  
          <?php echo form_submit(array('name' => 'save'),'Add Product'); ?> 
          <?php // echo form_button(array('name' => 'cancel'),'Cancel'); ?>
    </div> 
 <?php echo form_close();?>   
 </div>  
 
  
<div class="row" id="div2" style="display:none">
  <fieldset>
<legend>Bundle Products </legend>
 Bundle Products Bundle Products
 
      
 </fieldset>
</div>
<div class="row" id="div3" style="display:none">
 <fieldset>
<legend> Digital Products</legend>

</fieldset>
</div>

<div class="row" id="div4" style="display:none"></div>
</div>

</body>
</html>