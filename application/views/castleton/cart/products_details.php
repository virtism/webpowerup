<div style=" margin-top: 0px;" align="left">
    <h1 style=" font-size:18px; margin-left: 15px;"><?=$product['product']?></h1>
    <br />
    <div align="center">
    
    <?php if ($product['image']){ ?>
        <img style="max-width:472px; max-height:580px " src="<?php echo base_url(); ?>media/ecommerce/<?=$img_path_full?>/<?php echo $product['image']; ?>" border="0" alt="" />
    <?php }else{ ?> 
         <img style="max-width:472px; max-height:580px " src="<?php echo base_url(); ?>media/ecommerce/no-image3.jpg" border="0" alt=""  /> 
    <?php } ?>
    
    
   <!--<img  src="<?php echo base_url(); ?>media/ecommerce/<?=$img_path_full?>/<?=$product['image']?> "  border="0" alt="" />   -->
    </div>
	<br />
    <div align="left" style=" margin-left: 5px;"> <strong>Price : </strong> <?=$product['list_price']?> </div>
	<br />
    <div align="left" style=" margin-left: 5px;">  <strong>Description : </strong> <?=$product['full_desc']?>   </div>
	<br />
    <div style="margin-left: 5px;" align="left">
     <fieldset>
                <label>Quantity</label>
           <?php 
            $attributes = array('name' => 'shopping_cart', 'id' => 'shopping_cart');
            echo form_open(base_url().index_page().'MyShop/add_cart_item', $attributes); 
           ?>
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