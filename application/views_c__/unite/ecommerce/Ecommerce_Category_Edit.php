<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ecommerce : Category Update </title>
    
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

<h1>Edit Category </h1>
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>

<form action="<?=base_url()?>index.php/Categories_Management/edit" name="reg_form" id="reg_form" class="contact" enctype="multipart/form-data" method="post">
	<input type="hidden" name="action" value="edit_category">
	<input type="hidden" name="id" value="<?=$category['cat_id']?>">
	
	
 <?php
   //$attributes = array('class' => 'contact', 'id' => 'reg_form' , 'name' => 'reg_form', 'enctype' => 'multipart/form-data');
   // echo form_open(base_url().'index.php/Categories_Management/edit', $attributes); 
   // echo form_hidden('id',$category['cat_id']); 
    //echo form_hidden('action','edit_category');  
	
	
	
	
   $cat_name = array('name' => 'cat_name','id' => 'cat_name', 'size' => '30', 'value' => set_value('cat_name',$category['cat_name']));
   $short_desc = array('name'=>'short_desc','id'=>'short_desc','rows'=>5, 'cols'=>'40','value'  => set_value('long_desc', $category['shortdesc']));
   $long_desc = array('name'  => 'long_desc', 'id' => 'ck_content','value'  => set_value('long_desc', $category['longdesc']));
   $image = array('name'=>'cat_image','id'=>'image','size'=>50);  
   $options = array('Active' => 'Active', 'Inactive' => 'Inactive');
   $member_options = array('1' => 'All Members', '2' => 'Ristrict Members', '3' => 'Registers Members');     
?>

<div id="create_edit">
<fieldset>
<legend> Create Category</legend>
          <p><label for='catname'>Category Name</label><br/> <?php echo form_input($cat_name); ?> </p>
          <p><label for='short'>Short Description</label><br/>   <?php echo form_textarea($short_desc); ?>  </p> 
          <p><label for='long'>Long Description</label><br/>
          <?php echo form_textarea($long_desc); ?>  
          <?php //echo display_ckeditor($ck_data['ckeditor']); ?> 
          </p>
          <p><label for='uimage'>Upload Image</label><br/> <?php echo form_upload($image) ?> </p>   
          <p><label for='members'>Status</label><br/> <?php echo form_dropdown('members',$member_options,$category['member_id']) ?> </p>  
          <p><label for='status'>Status</label><br/> <?php echo form_dropdown('status',$options, $category['status']) ?> </p>
          <p><label for='parent'>Category Parent</label><br/> <?php echo form_dropdown('parentid',$categories, $category['parentid']) ?></p>
</fieldset>  
          <?php echo form_submit(array('name' => 'save'),'Update Category'); ?> 
          <?php // echo form_button(array('name' => 'cancel'),'Cancel'); ?>
          
</div> 
<?php //echo form_close();?>
</form>




</body>
</html>
