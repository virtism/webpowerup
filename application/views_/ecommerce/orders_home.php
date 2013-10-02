<script type="text/javascript">

$(document).ready(function(e) {  
	$(".DataGrid2 ul:odd").addClass("TableData");
	$(".DataGrid2 ul:even").addClass("TableData AlterRow");
	$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});


</script>



<div class="RightColumnHeading">
    <h1>
        <span>Manage Orders</span>
    </h1>
</div>
<div class="clr"></div>



<div class="DataGrid2">
    <ul>
        <li class="Serial">Order ID</li>
        <li>Customer Name</li>
        <!--<li>Email</li>-->
        <li>Discount</li>
        <li>Total</li>
        <li>Order Date & City</li>
        <!--<li>City</li>-->
        <li>Payment Status</li>
        <li class="Actions">Action</li>
	</ul>

	<?php
    if (count($orders))
    {
       $id_counter = 1;
	   foreach ($orders as $key => $list)
        { 
		?>

       <ul>
            <li class="Serial"><?=$id_counter++?></li>
            <li><?=$list['customer_name'];?></li>
            <?php /*?><li>
            <label title="<?=$list['payer_email'];?>">
			<?php 
			$dots = (strlen($list['payer_email']) > 8 ) ? "..." : "" ;
			echo substr($list['payer_email'],0,8).$dots; 
			?>
            </label>
            </li><?php */
			?>
            <li><?=$list['discount'];?></li>
            <li><?=$list['payment_gross'];?></li>
            <li><?=$list['payment_date'];?> <br /> <?=$list['address_city'];?></li>
            <!--<li></li>-->
            <li><?=$list['payment_status'];?></li>
            <li class="Actions">
            <a href="<?=site_url();?>orders/paid/<?=$list['order_id'];?>">paid</a>
            &nbsp;|&nbsp;
            <a href="<?=site_url();?>orders/delivered/<?=$list['order_id'];?>">delivered</a>
            &nbsp;|&nbsp;
            <a href="<?=site_url();?>orders/pending/<?=$list['order_id'];?>">pending</a>    
            </li>
        </ul>
	<?php 
		}
	}
	 else
	 { ?>
		<ul class="TableData">
			<li>
			<span class="NoData">
			Sorry! No Record Found.
			</span>
			</li>
		</ul>
	 <?php 
	 } ?>
</div>