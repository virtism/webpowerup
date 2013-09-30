<h2><?php echo $title;?></h2>
<?php

 
if ( $view_all_order_history){
 
    echo '<table id="tablesorter_product" class="tablesorter" border="1" cellspacing="0" cellpadding="3" width="100%">';
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>Order ID</th>\n<th>Customer Name</th><th>Email</th><th>Discount</th><th>Total</th><th>Receipt#</th><th>Order Date</th><th>City</th><th>Payment Status</th><th>Download Product</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
	$id_counter = 1;
    foreach ($view_all_order_history as $key => $list){
		$product_link = '';
		
        echo "<tr valign='top'>\n";
        //echo "<td align='center'>".$list['order_id']."</td>\n";
		echo "<td align='center'>".$id_counter++."</td>\n";
        echo "<td align='center'>".$list['customer_name']."</td>\n";
        ///echo "<td align='center'>".$list['customer_last_name']."</td>\n";
        echo "<td align='center'>".$list['payer_email']."</td>\n";
        //echo "<td align='center'>".$list['payment_gross']."</td>\n";
		echo "<td align='center'>".$list['discount']."</td>\n";
		echo "<td align='center'>".$list['payment_gross']."</td>\n";
 		echo "<td align='center'>".$list['receipt_id']."</td>\n";
        // echo "<td align='center'>".$list['category_id']."</td>\n";
       // echo "<td align='center'>".$list['phone_number']."</td>\n";
        echo "<td align='center'>".$list['payment_date']."</td>\n";
        //echo "<td align='center'>".$list['delivery_date']."</td>\n";
        echo "<td align='center'>".$list['address_city']."</td>\n";
		echo "<td align='center'>".$list['payment_status']."</td>\n";
		if(isset($list['site_id']) && isset($list['customer_id']) && $list['download_link']!=0)
		{
			$product_link = ($list['download_link']*2)."/".($list['customer_id']*2)."/".($list['site_id']*2);
			echo "<td align='center'><a target='_blank' href='".base_url()."MyShop/download/".$product_link."'>Download</a></td>\n";
		}        
        echo "</tr>\n";
    }

    echo "</tbody></table>";
    echo form_close();
}else
{
   
	echo "<div > Sorry! No Order Record Found. </div>";
    
    
}

?>