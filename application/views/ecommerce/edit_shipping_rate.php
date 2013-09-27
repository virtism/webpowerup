<?php

echo form_open(base_url().index_page().'Shipping_Management/update_shipping/'.$records[0]['site_id'].'/'.$records[0]['shipping_id']);
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
	  <input type="text" name="shipping_rate_name" id="shipping_rate_name" value="<? echo $records[0]['shipping_rate_name'];?>" />
	  
	  
	  <br clear="all" /><br clear="all" />
	   <hr style="height:5px; border-color:#999999; border-style:dashed; border-width:1px solid;"></hr><br clear="all" />
<h3>Weight Range</h3>
	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%">From:</td>
    <td width="50%"><input type="text" name="min_range" id="min_range" value="<? echo $records[0]['min_range'];?>" /></td>
    <td width="10%">kg</td>
  </tr>
   <tr>
    <td width="10%">To:</td>
    <td width="50%"><input type="text" name="max_range" id="max_range" value="<? echo $records[0]['max_range'];?>" /></td>
    <td width="10%">kg</td>
  </tr>
</table><br clear="all" />
 <hr style="height:5px; border-color:#999999; border-style:dashed; border-width:1px solid;"></hr><br clear="all" />
  <h3>Rate</h3>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr>
    <td width="4%">$</td>
    <td width="78%"><input type="text" name="rate" id="rate" value="<? echo $records[0]['rate'];?>" /></td>
    <td width="18%">CAD</td>
  </tr>
  
</table>  
 <hr style="height:5px; border-color:#999999; border-style:dashed; border-width:1px solid;"></hr><br clear="all" />
 
 <input type="submit" value="Update" />
	   </div>
	   
 </div>
