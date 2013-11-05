<?php //print displayStatus();?>
<h2><?php echo $title;?></h2>
<p><?php echo anchor("Products_Management/create", "Create new product");?> | <?php echo anchor("Products_Management/export","Export");?></p>
 
<?php
echo form_open_multipart("Products_Management/import");
$data = array('name' => 'csvfile', 'size'=>15);
echo form_upload($data);
echo form_hidden('csvinit',true);
echo form_submit('submit','IMPORT');
echo form_close();
?>
 
<?php
/* We not using this CI flashmsg
if ($this->session->flashdata('message')){
    echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
} */

if (count($products)){
    echo form_open("Products_Management/batchmode");
    echo "<p>Category: ". form_dropdown('category_id',$categories);
    echo "&nbsp;";
    $data = array('name'=>'grouping','size'=>'10');
    echo "Grouping: ". form_input($data);
    echo form_submit("submit","batch update");
    echo "</p>";
    echo '<table id="tablesorter_product" class="tablesorter" border="1" cellspacing="0" cellpadding="3" width="100%">';
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>&nbsp;</th><th>Product ID</th>\n<th>Name</th><th>Product Code</th><th>Grouping</th><th>Publish</th><th>Category Name</th><th>Price</th><th>Actions</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    foreach ($products as $key => $list){
        echo "<tr valign='top'>\n";
        echo "<td align='center'>".form_checkbox('product_id[]',$list['product_id'],FALSE)."</td>";
        echo "<td align='center'>".$list['product_id']."</td>\n";
        echo "<td align='center'>".$list['product']."</td>\n";
        echo "<td align='center'>".$list['product_code']."</td>\n";
        echo "<td align='center'>".$list['group']."</td>\n";
 
        echo "<td align='center'>";
        echo anchor('Products_Management/changeProductStatus/'.$list['product_id'],$list['publish'], array('class' => $list['publish']));
        echo "</td>\n";
 
        // echo "<td align='center'>".$list['category_id']."</td>\n";
        echo "<td align='center'>".$list['CatName']."</td>\n";
        echo "<td align='center'>".$list['list_price']."</td>\n";
        echo "<td align='center'>";
        echo anchor('Products_Management/edit/'.$list['product_id'],'edit');
        echo " | ";
        echo anchor('Products_Management/delete/'.$list['product_id'],'delete');
        echo "</td>\n";
        echo "</tr>\n";
    }
    echo "</tbody></table>";
    echo form_close();
}
   
?>