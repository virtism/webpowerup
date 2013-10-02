<script src="http://code.jquery.com/jquery-latest.js"></script>
<style type="text/css">
ul.ppt {
	position: relative;
}

.ppt li {
	list-style-type: none;
	position: absolute;
	top: 0;
	left: 0;
}

.ppt img {
	border: 1px solid #e7e7e7;
	padding: 5px;
	background-color: #ececec;
}
</style>
<script type="text/javascript">
	function get_attrib_price(id)
	{
		//alert(id);
		var attrib_id = document.getElementById('attrib'+id).value;
		var text_box_id = document.getElementById('price'+id).value;
	
		var path =  "<?=base_url().index_page()?>MyShop/ajax_get_attrib_price/";
	//	var dataString = "country_id="+country_id+"&state_id="+state_id+"&total_weight="+total_weight;
		//var dataString = attrib_id;
		//alert(id);
		var dataString = "attrib_id="+attrib_id;
		$.ajax({
			url: path, 
			data: dataString,
			type:'POST', 
			dataType: "json",
			success: function(data){
			var hidden_total = document.getElementById('hidden_price').value;
			//	$("#grand_total").html(' ');
			
			
			var option_status =data.option_status;
			var option_price =data.option_price;
			//alert(option_price);
		
				var	$total = 0;
				//$("#customers_detail").show();
				if(option_status == 'Add')
				{
			     	//$total = Number(hidden_total)+Number(option_price);
					document.getElementById('price'+id).value ='+'+option_price ;
				}
			    if(option_status == 'Less')
				{
			     	//$total = Number(hidden_total)-Number(option_price);
					document.getElementById('price'+id).value ='-'+option_price ;
				}
				if(attrib_id == 0 || option_status == 'Same Price')
				{
				  	//$total = hidden_total;
					document.getElementById('price'+id).value ='' ;
				}
				
				//$("#price").html('<strong ><br/>Price : </strong>'+$total);
				//alert("success");
			}
		});	
	}
	
	function update_price(limit)
	{
		//alert(limit);
		var total = 0;
		var hidden_total = Number(document.getElementById('hidden_price').value);
		for(var i = 1; i <= limit; i++)
		{
			total +=  Number(document.getElementById('price'+i).value);
			$("#price").html('<strong ><br/>Price : </strong>'+(hidden_total+total));
			document.getElementById('total_price').value = hidden_total+total;
			//alert(total);
		}
		
			
    }
</script>
<div style=" margin-top: 0px; " align="left">
    <h1 style=" font-size:18px; margin-left: 15px;"><?=$product['product']?></h1>
    <br />
    <div align="center" style="height:450px; width:300px;">
    
    <?php if ($product['image']){ ?>
        <img style="max-width:472px; max-height:580px " src="<?php echo base_url(); ?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/ecommerce/<?=$img_path_full?>/<?php echo $product['image']; ?>" border="0" alt="" />
    <?php }
	else if(isset($product['gallery_imges']) && !empty($product['gallery_imges']))
		{
			//echo "<pre>";print_r($p['gallery_imges']);
		?>
			<ul class="ppt">
            <? for($i = 0; $i< count($product['gallery_imges']);  $i++){?>
				
                <li><img src="<?php echo base_url(); ?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/ecommerce/<?=$img_path_full?>/<?=$product['gallery_imges'][$i]['image']?>" /></li>
            <? } ?>
	
    		</ul>
	
	<? }else{ ?> 
         <img style="max-width:472px; max-height:580px " src="<?php echo base_url(); ?>media/ecommerce/no-image3.jpg" border="0" alt=""  /> 
    <?php } ?>
    
    
   <!--<img  src="<?php echo base_url(); ?>media/ecommerce/<?=$img_path_full?>/<?=$product['image']?> "  border="0" alt="" />   -->
    </div>
	<br clear="all" />
    <br clear="all" />
    <input type="hidden" name="hidden_price" id="hidden_price" value="<?=$product['list_price']?>" />
    <div align="left" style=" margin-left: 5px;" id="price"> <strong>Price : </strong> <?=$product['list_price']?> </div>
	<br />
    <div align="left" style=" margin-left: 5px;">  <strong>Description : </strong> <?=$product['full_desc']?>   </div><br />
    <div align="left" style=" margin-left: 5px;">
    <table width="350">
    <? 
	//echo '-----------------'.count($attributes);
	//echo "<pre>";print_r($attributes);exit;
	for($i = 0; $i<count($attributes); $i++){
		if(isset($attributes[$i]['attribute_title']) && isset($attributes[$i]['att'][0]['option_name']) && $attributes[$i]['att'][0]['option_name'] != "" && $attributes[$i]['attribute_title'] != ""){?>
    <tr>
        <td style=" font-weight:bold; width:100px;"><?=ucfirst($attributes[$i]['attribute_title'])?></td>
        <td style="width:100px;">
        <select name="attrib[]" id="attrib<?=$i+1?>" onchange="get_attrib_price(<?=$i+1?>)">
        <option value="0">Option</option>
        <? for($j = 0; $j<count($attributes[$i]['att']); $j++){?>
        <option value="<?=$attributes[$i]['att'][$j]['option_id']?>"><?=$attributes[$i]['att'][$j]['option_name']?></option>
        <? }?>
        </select>
        
        </td>
        <td style="padding-left:10px;"><input type="text" id="price<?=$i+1?>" name="price<?=$i+1?>" size="5" /></td>
    </tr>
  
    <? } }?>
      <tr>
        <td><input type="button" id="button<?=$i+1?>" name="button<?=$i+1?>" value="Update" onclick="update_price(<?=$i+1?>)" /></td>
    </tr>
    </table>
    </div>
	
    <div style="margin-left: 5px;" align="left">
     <fieldset>
                <label>Quantity</label>
           <?php 
            $attributes = array('name' => 'shopping_cart', 'id' => 'shopping_cart');
            echo form_open(base_url().index_page().'MyShop/add_cart_item', $attributes); 
           ?>
           <input type="hidden" name="total_price" id="total_price" value="<?=$product['list_price']?>" />
                <?php echo form_input('quantity', '1', 'maxlength="2" , size="6"'); ?>
                <?php echo form_hidden('product_id', $product['product_id']); ?>
                <?php echo form_submit('add', 'Add To Cart'); ?>
                <?php // echo anchor(base_url().index_page().'MyShop/detail/'.$product['product_id'], 'Detail View'); ?>  
           <?php echo form_close(); 
           ?>  
           

            </fieldset>
      </div>
</div>
<br/><br/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
$('.ppt li:gt(0)').hide();
$('.ppt li:last').addClass('last');
var cur = $('.ppt li:first');

function animate() {
	cur.fadeOut( 1000 );
	if ( cur.attr('class') == 'last' )
		cur = $('.ppt li:first');
	else
		cur = cur.next();
	cur.fadeIn( 1000 );
}


$(function() {
	setInterval( "animate()", 3000 );
} );
</script>