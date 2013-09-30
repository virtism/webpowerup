<?php

echo form_open(base_url().'Shipping_Management/');
$weight = array('name'=>'weight','id'=>'weight','size'=>'20', 'value' => set_value('weight_lbs','0.00')); 
   $shipping_freight = array('name'=>'shipping_freight','id'=>'shipping_freight','size'=>'18', 'value' => set_value('shipping_freight','0.00')); 
   
   $box_length = array('name'=>'box_length','id'=>'box_length','size'=>'6', 'value' => set_value('box_length','0.00')); 
   $box_height = array('name'=>'box_height','id'=>'box_height','size'=>'6', 'value' => set_value('box_height','0.00')); 
   $box_width = array('name'=>'box_width','id'=>'box_width','size'=>'6', 'value' => set_value('box_width','0.00')); 
   $items_per_box = array('name'=>'items_per_box','id'=>'items_per_box','size'=>'18', 'value' => set_value('items_per_box','')); 
    $free_shipping = array('No' => 'No', 'Yes' => 'Yes');
   
   $weight_type = array('Kilos' => 'Kilos', 'Tonnes' => 'Tonnes', 'Tons' => 'Tons', 'Lbs' => 'Lbs');
   $use_weight_for_shipping = array('name' => 'use_weight_for_shipping', 'id' => 'use_weight_for_shipping', 'value' => 'Yes','checked' => TRUE,  'style' => 'margin:10px' , 'onclick' => "switchPDims(this)"); 
   $separate_box = array('name' => 'separate_box', 'id' => 'separate_box', 'value' => 'Yes','checked' => TRUE,  'style' => 'margin:10px' , 'onclick' => "switchPDims(this)"); 
   
  
    
?>
<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>
<div style="float: left; margin-left: 10px; clear: both;" > 
       <table>
	     <tr>
              <td colspan="3"><h2>Shipping Management</h2></td>
           </tr>
           <tr>
              <td colspan="3"></td>
           </tr>
           <tr> 
              <td >Total Weight:</td>
              <!--<td width="890%" class="ProductDetails">  <input type="text" name="weight" size="18" value="0.00" />  </td>  -->
              <td >  <?php echo form_input($weight);?></td>
			 <td><?  echo form_dropdown('weight_type',$weight_type); ?>  </td>
			  
           </tr>

           <tr> 
              <td >Free shipping:</td>
              <td > <?php echo form_dropdown('free_shipping',$free_shipping) ?>  </td>
         
           </tr>

           <tr>
              <td >Shipping freight ($):</td>
              <!--<td class="ProductDetails"> <input type="text" name="shipping_freight" size="18" value="0.00" />  </td> -->
              <td > <?php  echo form_input($shipping_freight) ?> </td>
           </tr>

           <tr>
              <td >Use the Weight of this product for shipping cost calculation:</td>
              <!--<td class="ProductDetails">  <input type="checkbox" name="small_item" value="Y" checked="checked" onclick="javascript: switchPDims(this);" />    </td>-->
              <td >  <?php echo form_checkbox($use_weight_for_shipping);  ?>           </td>
           </tr>

		   <td align="center" colspan="2">
  			 <!--<div style="float: left; margin-left: 100px; clear: both; margin-bottom: 30px;" > --> 
                <?php echo form_submit(array('name' => 'save'),'Make Shipping'); ?> 
                <?php // echo form_button(array('name' => 'cancel'),'Cancel'); ?>
           <!-- </div>--> 
           <?php echo form_close();?>   
          </td>
		  </tr>
          
      </table>
 </div>
