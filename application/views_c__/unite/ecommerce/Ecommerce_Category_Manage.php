 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$title ?></title>
    
<!--javascripts add /roemove     -->
 <script language="Javascript" type="text/javascript">
<!--


//-->


</script>   
<!-- end javascriptts add/remove  -->

<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->
</head>
<body>

<h2><?php echo $title;?></h2>




<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
<fieldset>
<legend> <b><?php echo $title;?></b>  </legend> 

<p><?php echo anchor("Categories_Management/create", "Create new category");?> | <?php echo anchor("Categories_Management/export","Export");?></p> 

<div id="manage_cat">
<?php
    if (count($categories)){
    echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>ID</th>\n<th>Name</th><th>Status</th><th>Parent id</th><th>Actions</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    foreach ($categories as $key => $list){
        echo "<tr valign='top'>\n";
        echo "<td>".$list['cat_id']."</td>\n";
        echo "<td>".$list['cat_name']."</td>\n";
 
        echo "<td align='center'>";
        echo anchor('Categories_Management/changeCatStatus/'.$list['cat_id'],$list['status'], array('class' => $list['status']));
        echo "</td>\n";
 
        // echo "<td align='center'>".$list['status']."</td>\n";
 
        echo "<td align='center'>".$list['parentid']."</td>\n";
        echo "<td align='center'>";
        echo anchor('Categories_Management/edit/'.$list['cat_id'],'edit');
        echo " | ";
        echo anchor('Categories_Management/delete/'.$list['cat_id'],'delete', array('class' => 'delete_link'));
        echo "</td>\n";
        echo "</tr>\n";
    }
    echo "</tbody>\n</table>";
}

?>
          
</div> 
</fieldset> 





</body>
</html>
