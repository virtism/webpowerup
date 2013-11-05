<?php

echo form_open(base_url().index_page().'Shipping_Management/save_shipping_rate');
?>
<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>
<div style="float: left; margin-left: 10px; clear: both;" > 
       
	 <style>
	 .shipping_rate{
	width:500px;
	 }
	  .shipping_rate table tr td{
	  padding:0 10px 10px 10px;
	  }
	 </style>  
	   <h2>Shipping Rate</h2><br clear="all" />
	  <div class="shipping_rate"> <h3>Shipping Rate Name</h3>
	  <input type="text" name="shipping_rate_name" id="shipping_rate_name" onfocus="if (this.value == '0.1-2') {this.value=''}" onblur="if(this.value == '') { this.value='0.1-2'}" value="0.1-2" />
	  
	  
	  <br clear="all" /><br clear="all" />
	   <hr style="height:5px; border-color:#999999; border-style:dashed; border-width:1px solid;"></hr><br clear="all" />
<h3>Weight Range</h3>
	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%">From:</td>
    <td width="50%"><input type="text" name="min_range" id="min_range" onfocus="if (this.value == '0.1') {this.value=''}" onblur="if(this.value == '') { this.value='0.1'}" value="0.1" /></td>
    <td width="10%">kg</td>
  </tr>
   <tr>
    <td width="10%">To:</td>
    <td width="50%"><input type="text" name="max_range" id="max_range" onfocus="if (this.value == '2') {this.value=''}" onblur="if(this.value == '') { this.value='2'}" value="2" /></td>
    <td width="10%">kg</td>
  </tr>
</table><br clear="all" />
 <hr style="height:5px; border-color:#999999; border-style:dashed; border-width:1px solid;"></hr><br clear="all" />
  <h3>Rate</h3>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr>
    <td width="4%">$</td>
    <td width="78%"><input type="text" name="rate" id="rate" value="" /></td>
    <td width="18%">CAD</td>
  </tr>
  
</table>  
 <hr style="height:5px; border-color:#999999; border-style:dashed; border-width:1px solid;"></hr><br clear="all" />
 
 <input type="submit" value="Save" />
	   </div>
	   
 </div>
