<?php //print displayStatus();?>
<h2><?php echo $title;?></h2>
<p><?php echo anchor("customers/customer_registration", "Create new customer");?>
<?php

    $attributes = array('class' => 'contact', 'id' => 'customer_search' ,  'name' => 'customer_search',  'onsubmit'=>'javascript: return checkRegFormFields(this);' );
    echo form_open(base_url().'index.php/customers',$attributes);
    echo form_hidden('action','search');

    
    $search_value = array('name'=>'search_value','id'=>'search_value','size'=>'85' , 'maxlength' => '64', 'value' => set_value('search_value','')); 
    $sort_by = array('' => 'Select One' ,'customer_fname' => 'First Name' , 'customer_lname'=>'Last Name', 'customer_email'=>'Mail ID', 'group_code'=>'Gruop Code');
?> 
<div style="margin: 0px 0px 10px 0px;">
<table width="100%" border="0">
  <tr>
    <td width="105">
    <?php echo form_dropdown('sort_by',$sort_by, 1,'' ) ?>
    <!-- <select name="sort_by" size="1">
          <option value="customer_fname">First Name</option>
          <option value="customer_lname">Last Name</option>
          <option value="customer_email"> Mail ID</option>
          <option value="group_code"> Gruop Code</option>
          &nbsp;
        </select> -->
    </td>
    <td width="381"><label>
       <!-- <input type="text" name="textfield" style="width:480px;" /> -->
        <?php echo form_input($search_value) ?>
    </label></td>
    <td width="104"><label>
      <input type="submit" name="Submit" value="Search Now" />
    </label></td>
  </tr>
<!--  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>-->
</table>
</div>

<?php
 
if (count($customers)){
    echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>Customer ID</th>\n<th>First name</th><th>Last name</th><th>Email</th><th>Membership ID</th><th>Group Code</th><th>Actions</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    foreach ($customers as $key => $list){
        echo "<tr valign='top'>\n";
        echo "<td align='center'>".$list['customer_id']."</td>\n";
        echo "<td align='center'>".$list['customer_fname']."</td>\n";
        echo "<td align='center'>".$list['customer_lname']."</td>\n";
        echo "<td align='center'>".$list['customer_email']."</td>\n";
      //  echo "<td align='center'>".$list['membershipid']."</td>\n";
        echo "<td align='center'>".$list['group_name']."</td>\n"; 
        echo "<td align='center'>".$list['group_code']."</td>\n";
        echo "<td align='center'>";
        echo anchor('customers/edit/'.$list['customer_id'],'edit');
        echo " | ";
        echo anchor('customers/delete/'.$list['customer_id'],'delete');
        echo "</td>\n";
        echo "</tr>\n";
    }
    echo "</tbody>\n</table>";
}
else
{
    echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>Customer ID</th>\n<th>First name</th><th>Last name</th><th>Email</th><th>Membership ID</th><th>Group Code</th><th>Actions</th>\n";  
    echo "</tr>\n</thead>\n<tbody>\n";
        echo "<tr valign='top'>\n";
        echo "<td align='center' colspan='8' style= 'color:red;'>Sorry ! No Customer Record Found. </td>\n";
        echo "</td>\n";
        echo "</tr>\n";
   
    echo "</tbody>\n</table>";  
    
}
?>