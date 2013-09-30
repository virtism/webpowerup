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

//-->
</script>   
<!-- end javascriptts add/remove  -->
<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->
</head>
<body>
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
 <?php
   $attributes = array( 'id' => 'edit_product' , 'name' => 'edit_product', 'enctype' => 'multipart/form-data');
    echo form_open(base_url().'index.php/Products_Management/edit', $attributes); 
    echo form_hidden('product_id',$product['product_id']);  
    echo form_hidden('action','edit_product'); 
       
   $pd_name = array('name' => 'product_name', 'id' => 'product_name','size' => '30', 'value' => set_value('product_name',$product['product']) );
   $ptice = array('name'=>'price','id'=>'price','size'=>20 , 'value' => set_value('price',$product['list_price'])); 
   $ptice_tax = array('name'=>'price_tax','id'=>'price_tax','size'=>12 , 'value' => set_value('price_tax',$product['tax'])); 
   $digital_max_download = array('name'=>'digital_max_download','id'=>'digital_max_download','size'=>12 , 'value' => set_value('digital_max_download','')); 
   $digital_download_expire = array('name'=>'digital_download_expire','id'=>'digital_download_expire','size'=>12 , 'value' => set_value('digital_download_expire','')); 
   $digital_download_url = array('name'=>'digital_download_url','id'=>'digital_download_url','size'=>50, 'value' => set_value('digital_download_url','')); 
   
   $qty_in_stock = array('name'=>'qty_in_stock','id'=>'qty_in_stock','size'=>'18', 'value' => set_value('qty_in_stock',$product['qty_in_stock'])); 
   $low_avail_limit = array('name'=>'low_avail_limit','id'=>'low_avail_limit','size'=>'18', 'value' => set_value('low_avail_limit',$product['low_avail_limit'])); 
   $min_order_qty = array('name'=>'min_order_qty','id'=>'min_order_qty','size'=>'18', 'value' => set_value('min_order_qty',$product['min_amount'])); 
   $pd_return_time = array('name'=>'pd_return_time','id'=>'pd_return_time','size'=>'18', 'value' => set_value('pd_return_time',$product['return_time'])); 
   
   $weight_lbs = array('name'=>'weight_lbs','id'=>'weight_lbs','size'=>'18', 'value' => set_value('weight_lbs',$product['weight_lbs'])); 
   $shipping_freight = array('name'=>'shipping_freight','id'=>'shipping_freight','size'=>'18', 'value' => set_value('shipping_freight',$product['shipping_freight'])); 
   
   $box_length = array('name'=>'box_length','id'=>'box_length','size'=>'6', 'value' => set_value('box_length',$product['box_length'])); 
   $box_height = array('name'=>'box_height','id'=>'box_height','size'=>'6', 'value' => set_value('box_height',$product['box_height'])); 
   $box_width = array('name'=>'box_width','id'=>'box_width','size'=>'6', 'value' => set_value('box_width',$product['box_width'])); 
   $items_per_box = array('name'=>'items_per_box','id'=>'items_per_box','size'=>'18', 'value' => set_value('items_per_box',$product['items_per_box'])); 
   
   $length = array('name'=>'length','id'=>'length','size'=>'18', 'value' => set_value('length',$product['length'])); 
   $height = array('name'=>'height','id'=>'height','size'=>'18', 'value' => set_value('height',$product['height'])); 
   $width = array('name'=>'width','id'=>'width','size'=>'18', 'value' => set_value('width',$product['width'])); 
   $weight = array('name'=>'weight','id'=>'weight','size'=>'18', 'value' => set_value('weight',$product['weight'])); 
   
   $taxable_yes = array('name' => 'taxable_rd','id' => 'taxable', 'value' => 'Yes', 'checked' => set_radio('taxable_rd', 'Yes', FALSE), 'onclick' => "showMe('tax', this)" );  
   $taxable_no = array( 'name' => 'taxable_rd','id' => 'taxable', 'value' => 'No', 'checked' => set_radio('taxable_rd', 'No',TRUE) , 'onclick' => "hideMe('tax', this)"  );   
   
   $permision_every = array( 'name' => 'access_permision','id' => 'access_permision', 'value' => 'Everyone', 'checked' => set_radio('taxable_rd', 'Everyone',TRUE) , 'onclick' => "hideMe('roles', this)"  );   
   $permision_register = array( 'name' => 'access_permision','id' => 'access_permision', 'value' => 'Registered', 'checked' => set_radio('taxable_rd', 'Registered',FALSE) , 'onclick' => "hideMe('roles', this)"  );   
   $permision_other = array( 'name' => 'access_permision','id' => 'access_permision', 'value' => 'Other', 'checked' => set_radio('taxable_rd', 'Other',FALSE) , 'onclick' => "showMe('roles', this)"  );   
   
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
                                                                                                                                     
   $short_desc = array('name'=>'short_desc','id'=>'short_desc','rows'=>5, 'cols'=>'40','value'  => set_value('full_desc', $product['short_desc']));
   $full_desc = array('name'  => 'full_desc', 'id' => 'ck_content','value'  => set_value('full_desc', $product['full_desc']));
   
   $min_qty = array('name' => 'min_qty','id' => 'min_qty', 'size' => '30', 'value' => set_value('min_qty',$product['product']));
   $discount_rate = array('name' => 'discount_rate','id' => 'discount_rate', 'size' => '30', 'value' => set_value('discount_rate',$product['product']));
   $min_qty_rate = array('name' => 'min_qty_rate','id' => 'min_qty_rate', 'size' => '30', 'value' => set_value('min_qty_rate',$product['product']));
   
   $title_tag = array('name'=>'title_tag','id'=>'title_tag','rows'=>5, 'cols'=>'40', 'value' => set_value('min_qty_rate',$product['meta_title']));
   $meta_key = array('name'=>'meta_key','id'=>'meta_key','rows'=>5, 'cols'=>'40', 'value' => set_value('min_qty_rate',$product['meta_keywords']));
   $meta_desc = array('name'=>'meta_desc','id'=>'meta_desc','rows'=>5, 'cols'=>'40', 'value' => set_value('min_qty_rate',$product['meta_description']));
   
   
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
<!--<div class="row" id="div1" style="display:none"> -->
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
        <p><label for='parent'>Category</label><br/> <?php echo form_dropdown('parentid',$categories, $product['category_id'] , 'size="1" multiple="MULTIPLE" style=" width:240px; height:140px;"') ?></p> 
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

  <div style="float: left; margin-left: 10px; clear: both; display: none; " > 
        <p><strong>Create Product Slide Show </strong></p> 

                <table width="100%" height="50" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
            <tr bgcolor="#F3F3F3">
                <td width="5%" align="center">&nbsp;  </td> 
                <td width="20%" align="center"> Image Title </td>
                <td width="22%" align="center"> Image Decription</td>
                <td width="25%" colspan="2" align="center">Image</td>
                
                 <!--<td width="36%"> DELETE</td>  -->
            </tr>
            <tr>
             <td colspan="5">     <table width="100%" border="0" cellspacing="1" cellpadding="3" id="tblAddImageFiels">
                      <tr>
                        <td width="5%" align="center"><input type="checkbox" name="image[1][check]" id="check" /></td>
                        <td width="25%" align="center"><input name="image[1][title]" type="text" id="title" size="20" value="" /></td>
                        <td width="30%" align="center"><input name="image[1][desc]" type="text" id="desc" size="25" value="" /></td>
                        <td width="40%" colspan="2" align="center"><input type="file" name="galaryImg_1" /></td>
                        
                      <!--  <th width="214"> <input type="button" value="Delete" onclick="deleteRowOne(this.parentNode.parentNode.rowIndex)"> </th> -->
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
<?php 
  if ($product['product_type'] != 'Regular')
  {
?> 
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
<?php
  } 
?> 
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
                          <!--<td><input type="text" name="length" size="6" value="0.00" /></td> -->
                          <td> <?php echo form_input($box_length) ?> </td>
                          <td>&nbsp;x&nbsp;</td>
                          <!--<td> <input type="text" name="width" size="6" value="0.00" /> </td> -->
                          <td> <?php echo form_input($box_width) ?> </td>
                          <td>&nbsp;x&nbsp;</td>
                          <!--<td><input type="text" name="height" size="6" value="0.00" /></td> -->
                          <td><?php echo form_input($box_height) ?></td>
                          <td align="center" width="100%">&nbsp;</td>
                       </tr>
                  </table>
              </td>
            </tr>

           <tr>
              <td class="FormButton">Ship in a separate box:</td>
              <!--<td class="ProductDetails"> <input type="checkbox" name="separate_box" value="Y" onclick="javascript: switchSSBox(this);" />  </td>-->
              <td class="ProductDetails"> <?php echo form_checkbox($separate_box);  ?>   </td>
           </tr>

           <tr>
              <td class="FormButton" nowrap="nowrap">Quantity per shipping box:</td>
              <!--<td class="ProductDetails"> <input type="text" name="items_per_box" size="18" value="1" disabled="disabled" />  </td>-->
              <td class="ProductDetails"> <?php echo form_input($items_per_box) ?> </td>
           </tr>

           <tr>
              <td colspan="2"><hr /></td>
           </tr>
      </table>
 </div>
 
 <div style="float: left; margin-left: 10px; clear: both;" >
         <h2>Size &amp; Weight : </h2> <hr/>
        <p><label for='price'>Length : </label>   <?php echo form_input($length) ?> cm
           <label for='price' style="margin-left: 20px;">Weight : </label>  <?php echo form_input($weight) ?> g
        </p>
        <p><label for='price'>Width :  </label>   <?php echo form_input($width) ?> cm  </p> 
        <p><label for='price'>Height : </label>   <?php echo form_input($height) ?>  cm </p> 
        <p> <hr> </p> 

 
 
 </div>  
 
 <div style="float: left; margin-left: 10px; clear: both;" > 
         <h2>Product Attributes : </h2> <hr/>


        <!--<div style="margin-bottom: 10px; margin-left: 25px; float: left;">   -->  
          
            <table width="100%" height="50" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                            <tr bgcolor="#F3F3F3">
                            <td width="6%" align="center" >&nbsp;  </td> 
                            <td width="47%" align="center" > Attribute Title</td>
                            <td width="47%" align="center" >Attribute Values</td>
                            </tr>
                            <tr>
                              <td  colspan="3" >
                                   <table width="100%" border="0" cellspacing="1" cellpadding="3" id="tblAddrows">  
<?php 
//  echo '<pre>';
//  print_r($attribute_data);
//  print_r($digital);
     for ($i=0; $i<count($attribute_data); $i++){ 
 ?>                                
                                              <tr>
                                                <td width="6%" align="center"><input type="checkbox" name="attribute[1][check]" id="check" /></td>
                                                <td width="47%" align="center"><input name="attribute[<?=$i?>][title]" type="text" id="title" size="20" value="<?=$attribute_data[$i]['attribute_title']?>" /></td>
                                                <td width="47%" align="center"><input name="attribute[<?=$i?>][desc]" type="text" id="order" size="20"  value="<?=$attribute_data[$i]['attribute_values']?>" /> 
                                                <input name="attribute_id[<?=$i?>]" type="hidden"   value="<?=$attribute_data[$i]['attribute_id']?>" />
                                                </td>
                                              
                                              </tr>
 <?php 
     }
 ?>
                                              
                                   </table>
                               </td>   
                            </tr>

                           <tr bgcolor="#F3F3F3">
                           <td colspan="3">        </td>
                           </tr> 
              </table>
            
        <!--</div>  -->

        
        <!--<div style="margin-bottom: 10px; margin-left: 25px; float: left;">  -->   
            <!--<INPUT type="button" value="Add Attribute" onclick="addImageRow('tblAddrows')" /> &nbsp; 
            <INPUT type="button" value="Delete Selected" onclick="deleteRow('tblAddrows')" /> -->
        <!--</div>  -->
 </div>       
 
  <div style="float: left; margin-left: 10px; clear: both;" >  
        <h2>Product SKU </h2> <hr/> 
         
         
         <p><label> <?php  echo form_radio($sku_yes); ?>  Automatically Generate a SKU  </label></p>
         <p><label> <?php  echo form_radio($sku_no); ?>  Use a Custome SKU  </label></p>
         <!--<p><label><input type="radio" value="Yes" name="image_rd" > Automatically Generate a SKU  </label></p>  
         <p><label><input type="radio" value="Yes" name="image_rd" > Use a Custome SKU  </label></p> -->
            
 </div> 
 
  <div style="float: left; margin-left: 10px; clear: both;" >  
        <h2>Add To Gruop After Perchase </h2> <hr/> 
         <p> <?php echo form_dropdown('group',$options_gruop) ?> </p>
         
            
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
          <?php echo form_submit(array('name' => 'save'),'Update Product'); ?> 
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

<div class="row" id="div4" style="display:none">

</div>

 

 
 </div>
 


      
      
           













</body>
</html>
