<div class= "products" style="  width: 618px ! important; padding: 15px 0px 190px 15px;">
<? if(isset($cat_title))
	{  
		echo '<h1 style="font-size:18px; margin-top: -15px;">'.$cat_title.'</h1>'; 
	}
?>
		<?
		
		 if(isset($category_image))
		{ 
				$cat_iamge_path = base_url()."media/ckeditor_uploads/".$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']."/ecommerce/".$category_image;   
				
		?>
					<img style="margin-top:5px; margin-left: 0px;" src="<?php echo $cat_iamge_path ?>" border="0" alt=""  />
		<?
		}	
		?>

<?php
if (count($products)<1){
	if($ishome == 'yes')
	{
		echo '<h2 style="margin-top: -12px; margin-left: -12px;">Please Select a category !</h2>';
	}
	else
	{
		echo '<p>No Product in this category !</p>'; 
	}  
					}
?>

<div style="padding: 15px;"> 
<?php  if ($view == 'List View' ){ 
   
	echo "<ul>";
	
	 foreach($products as $p): ?>
	<li>
		<h3><a style="text-decoration: none;" href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><?php echo $p['product']; ?></a></h3>
		<?php if ($p['image']){ ?>
		 <a href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><img src="<?php echo base_url(); ?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/ecommerce/<?=$img_path_thumb?>/<?php echo $p['image']; ?>" border="0" alt="" width="116px" height="125px" /> </a> 
		<?php }else{ ?> 
		 <a href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><img src="<?php echo base_url(); ?>media/ecommerce/no-image.png" border="0" alt="" width="116px" height="125px" /> </a> 
		<?php } ?> 
		<small>$<?php echo $p['list_price']; ?></small>
			<fieldset>
				<label>Quantity</label>
				<?php 
					$attributes = array('name' => 'shopping_cart', 'id' => 'shopping_cart');
					echo form_open(base_url().index_page().'/MyShop/add_cart_item', $attributes); 
					echo form_input('quantity', '1', 'maxlength="2"'); 
					echo form_hidden('product_id', $p['product_id']);
					if(isset($p['products_attributes_url']) && !empty($p['products_attributes_url']))
					{
						echo form_submit('add', 'Add To Cart');//echo "<a target='_blank' href=".$p['products_attributes_url']." >Download Here</a>";
					}
					else if(isset($p['products_attributes_filename']) && !empty($p['products_attributes_filename']))
					{
						
						echo form_submit('add', 'Add To Cart');//echo "<a target='_blank' href=".base_url()."media/ecommerce/downloadproducts/".$p['products_attributes_filename'].">Download Here</a>";
					}
					else
					{
						echo form_submit('add', 'Add To Cart');
					}
				
				?>
 
				<?php echo anchor(base_url().index_page().'/MyShop/detail/'.$p['product_id'], 'Detail View'); ?>  
		   <?php echo form_close(); 
		   ?>  
		   

			</fieldset>

	</li>
	<?php endforeach;?>
</ul>
<?php 
}
else if($view == 'Grid View' )
{  
	 foreach($products as $p): 
	
	?>
<div style="float:left;  width:160px; height: auto;"><!--ForEach Start Div -->	
	<div style="font-size:14px; width:auto; text-align:center; height: auto;"> <h3><a style="text-decoration: none;" href="<?=base_url().index_page()?>/MyShop/detail/<?=$p['product_id']?>" ><?php echo $p['product']; ?></a></h3>   </div>
	<div style=" width:auto; text-align:center;">
		<?php if ($p['image']){ ?>
		 <a href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><img src="<?php echo base_url(); ?>media/ckeditor_uploads/<?=$_SESSION['user_info']['user_login'].'_'.$_SESSION['user_info']['user_id']?>/ecommerce/<?=$img_path_thumb?>/<?php echo $p['image']; ?>" border="0" alt="" width="116px" height="125px" /> </a> 
		<?php }else{ ?> 
		 <a href="<?=base_url().index_page()?>MyShop/detail/<?=$p['product_id']?>" ><img src="<?php echo base_url(); ?>media/ecommerce/no-image.png" border="0" alt="" width="116px" height="125px" /> </a> 
		<?php } ?> 
	 </div>
	<div style=" font-size:12px; width:auto; text-align:center;"><strong>Price : </strong> <?php echo $p['list_price']; ?></div>
	<div style=" font-size:14px; width:auto; text-align:center;"> 
		<?php 
			$attributes = array('name' => 'shopping_cart', 'id' => 'shopping_cart');
			echo form_open(base_url().index_page().'/MyShop/add_cart_item', $attributes); 
		   ?>
			<div>
				<label>Quantity :
				<?php echo form_input('quantity', '1', 'maxlength="2" size= "3" '); ?>  </label>
				<?php echo form_hidden('product_id', $p['product_id']); ?>
				<?php 
					if(isset($p['products_attributes_url']) && !empty($p['products_attributes_url']))
					{
						echo form_submit('add', 'Add To Cart');//echo "<a target='_blank' href=".$p['products_attributes_url']." >Download Here</a>";
					}
					else if(isset($p['products_attributes_filename']) && !empty($p['products_attributes_filename']))
					{
						
						echo form_submit('add', 'Add To Cart');//echo "<a target='_blank' href=".base_url()."media/ecommerce/downloadproducts/".$p['products_attributes_filename'].">Download Here</a>";
					}
					else
					{
						echo form_submit('add', 'Add To Cart');
					}
				?>
			</div>    
				
				<?php echo anchor(base_url().index_page().'MyShop/detail/'.$p['product_id'], 'Detail View'); ?>  
		   <?php echo form_close(); 
		   ?>  
		</div>
	</div> <!--ForEach End Div -->	
	
<?php endforeach;
	} ?>
</div>


<div style="min-width:125px; height: 28px; float: left; margin: 100px 0 20px;"> 
<?php
	if(count($products)>0)
	{ 
	  echo $this->pagination->create_links();
	}
 ?>  

	</div>
</div>