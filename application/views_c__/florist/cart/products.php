<div class="products">

<? if(isset($cat_title))

	{  

		echo "<h1>".$cat_title."</h1>"; 

	}

?>

		<? if(isset($category_image))

		{ 

				$cat_iamge_path = base_url()."media/ecommerce/".$category_image.".jpg";

				if (@fclose(@fopen("$cat_iamge_path", "r")))

				{	

		?>

					<img style="margin-top:5px;" src="<?php echo $cat_iamge_path ?>" border="0" alt=""  />

		<? 	

				} 

		}	

		?>



      <?php

    if (count($products)<1){

        if($ishome == 'yes') {

             echo ' <fieldset>

                <label>Please Select a category!</label>  

          </fieldset> ';

        }else{

         echo ' <fieldset>

                <label>No Product in this category !</label>  

          </fieldset> '; }  }?>

</div>

<?php  if ($view == 'List View' ){ 

   

    echo "<ul>";

     foreach($products as $p): ?>

	<li>

		<h3><a style="text-decoration: none;" href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><?php echo $p['product']; ?></a></h3>

		<?php if ($p['image']){ ?>

         <a href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><img src="<?php echo base_url(); ?>media/ecommerce/<?=$img_path_thumb?>/<?php echo $p['image']; ?>" border="0" alt="" width="116px" height="125px" /> </a> 

        <?php }else{ ?> 

         <a href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><img src="<?php echo base_url(); ?>media/ecommerce/no-image.png" border="0" alt="" width="116px" height="125px" /> </a> 

        <?php } ?> 

		<small>&euro;<?php echo $p['list_price']; ?></small>

			<fieldset>

				<label>Quantity</label>

           <?php 

            $attributes = array('name' => 'shopping_cart', 'id' => 'shopping_cart');

            echo form_open(base_url().index_page().'MyShop/add_cart_item', $attributes); 

           ?>

				<?php echo form_input('quantity', '1', 'maxlength="2"'); ?>

				<?php echo form_hidden('product_id', $p['product_id']); ?>

				<?php echo form_submit('add', 'Add To Cart'); ?>

                <?php echo anchor(base_url().index_page().'MyShop/detail/'.$p['product_id'], 'Detail View'); ?>  

           <?php echo form_close(); 

           ?>  

           



			</fieldset>



	</li>

	<?php endforeach;?>

</ul>

<?php }else if ($view == 'Grid View' ){  



     foreach($products as $p): 

    

    ?>

<div style="float:left;  width:160px; height: auto;">

    <div style="font-size:14px; width:auto; text-align:center; height: auto;"> <h3><a style="text-decoration: none;" href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><?php echo $p['product']; ?></a></h3>   </div>

    <div style=" width:auto; text-align:center;">

        <?php if ($p['image']){ ?>

         <a href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><img src="<?php echo base_url(); ?>media/ecommerce/<?=$img_path_thumb?>/<?php echo $p['image']; ?>" border="0" alt="" width="116px" height="125px" /> </a> 

        <?php }else{ ?> 

         <a href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><img src="<?php echo base_url(); ?>media/ecommerce/no-image.png" border="0" alt="" width="116px" height="125px" /> </a> 

        <?php } ?> 

     </div>

    <div style=" font-size:12px; width:auto; text-align:center;"><strong>Price : </strong> <?php echo $p['list_price']; ?></div>

    <div style=" font-size:14px; width:auto; text-align:center;"> 

        <?php 

            $attributes = array('name' => 'shopping_cart', 'id' => 'shopping_cart');

            echo form_open(base_url().index_page().'MyShop/add_cart_item', $attributes); 

           ?>

            <div>

                <label>Quantity :

                <?php echo form_input('quantity', '1', 'maxlength="2" size= "3" '); ?>  </label>

                <?php echo form_hidden('product_id', $p['product_id']); ?>

                <?php echo form_submit('add', 'Add To Cart'); ?>

            </div>    

                

                <?php echo anchor(base_url().index_page().'MyShop/detail/'.$p['product_id'], 'Detail View'); ?>  

           <?php echo form_close(); 

           ?>  

    </div>

</div>



<?php endforeach;

} ?>



<div style="min-width:400px; height: 28px; float: right;"> 

<?php

    if(count($products)>0)

    { 

      echo $this->pagination->create_links();

    }

 ?>  

</div> 