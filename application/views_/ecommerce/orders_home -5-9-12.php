<div >
	<?php echo($this->breadcrumb->output()); ?>
</div>
<h2><?php echo $title;?></h2>
<?php
/*echo "<pre>";
print_r($orders);*/
//exit;
 
if (count($orders)){
 
    echo '<table id="tablesorter_product" class="tablesorter" border="1" cellspacing="0" cellpadding="3" width="100%">';
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>&nbsp;</th><th>Order ID</th>\n<th>Customer Name</th><th>Email</th><th>Discount</th><th>Total</th><th>Order Date</th><th>City</th><th>Payment Status</th><th>Change Payment Status</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    foreach ($orders as $key => $list){
        echo "<tr valign='top'>\n";
        echo "<td align='center'>".form_checkbox('p_id[]',$list['order_id'],FALSE)."</td>";
        echo "<td align='center'>".$list['order_id']."</td>\n";
        echo "<td align='center'>".$list['customer_name']."</td>\n";
        ///echo "<td align='center'>".$list['customer_last_name']."</td>\n";
        echo "<td align='center'>".$list['payer_email']."</td>\n";
        //echo "<td align='center'>".$list['payment_gross']."</td>\n";
		echo "<td align='center'>".$list['discount']."</td>\n";
		echo "<td align='center'>".$list['payment_gross']."</td>\n";
 
        // echo "<td align='center'>".$list['category_id']."</td>\n";
       // echo "<td align='center'>".$list['phone_number']."</td>\n";
        echo "<td align='center'>".$list['payment_date']."</td>\n";
        //echo "<td align='center'>".$list['delivery_date']."</td>\n";
        echo "<td align='center'>".$list['address_city']."</td>\n";
		echo "<td align='center'>".$list['payment_status']."</td>\n";
        echo "<td align='center'>";
        echo anchor('orders/paid/'.$list['order_id'],'paid');
        echo " | ";
        echo anchor('orders/delivered/'.$list['order_id'],'delivered');
		echo " | ";
        echo anchor('orders/pending/'.$list['order_id'],'pending');
        //echo " | ";
       // echo anchor('orders/details/'.$list['order_id'],'details');
        echo "</td>\n";
        echo "</tr>\n";
    }

    echo "</tbody></table>";
    echo form_close();
}else
{
    echo '<table id="tablesorter_product" class="tablesorter" border="1" cellspacing="0" cellpadding="3" width="100%">';
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>&nbsp;</th><th>Order ID</th>\n<th>First name</th><th>Last name</th><th>Email</th><th>Total</th><th>Telephone</th><th>Order Date</th><th>Delivery Date</th><th>Payment Date</th><th>City</th><th>Actions</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";  
    echo "<tr valign='top'>\n";
        echo "<td align='center' colspan='12' style= 'color:red;'>Sorry ! No Order Record Found. </td>";
        echo "</td>\n";
        echo "</tr>\n";
    
    
    
    echo "</tbody></table>";
    
}

?>