<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ecommerce : Category Add </title>
    
     <!--javascripts add /roemove     -->
<script type="text/javascript"> 
    <!-- 
    function showMe (it, box) { 
      var vis = (box.checked) ? "block" : "none"; 
      document.getElementById(it).style.display = vis;
    } 
    function hideMe (it, box) { 
      var vis = (box.checked) ? "none" : "block"; 
      document.getElementById(it).style.display = vis;
    } 
    //--> 
</script>  
<!-- end javascriptts add/remove  -->

<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->
</head>
<body>

<h1>Create Category </h1>



<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
 <?php
 
   $attributes = array('class' => 'form', 'id' => 'cat_add' , 'name' => 'cat_add', 'enctype' => 'multipart/form-data');
    echo form_open(base_url().'index.php/Categories_Management/create', $attributes); 
    
    echo form_hidden('action','create_category');  
    
        
   $cat_name = array('name' => 'cat_name','id' => 'cat_name', 'size' => '30', 'value' => set_value('cat_name',''));
   $short_desc = array('name'=>'short_desc','id'=>'short_desc','rows'=>5, 'cols'=>'40');
   $long_desc = array('name'  => 'long_desc', 'id' => 'ck_content','value'  => set_value('long_desc', ''));
   $image = array('name'=>'cat_image','id'=>'image','size'=>50); 
   
   $options = array('Active' => 'Active', 'Inactive' => 'Inactive');
   $member_options = array('1' => 'All Members', '2' => 'Ristrict Members', '3' => 'Registers Members');
   $uplaod_img_yes = array( 'name' => 'image_rd','id' => 'image_rd', 'value' => 'Yes', 'checked' => set_radio('image_rd', 'Yes',FALSE) , 'onclick' => "showMe('img', this)"  );   
   $uplaod_img_no = array( 'name' => 'image_rd','id' => 'image_rd', 'value' => 'No', 'checked' => set_radio('image_rd', 'No',TRUE) , 'onclick' => "hideMe('img', this)"  );   
   
    
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
<!--          <p><label for='uimage'>Upload Image</label><br/> <?php echo form_upload($image) ?> </p> -->
         <div style=" margin-left: 10px; clear: both;" >  
        
              <h2> Image </h2> <hr/>
              <p><label> <?php  echo form_radio($uplaod_img_yes); ?> Upload a new image &nbsp; </label> </p> 
              <div id='img' style=" display: none;"><p style="margin-left: 26px;"> <?php echo form_upload($image) ?></p> </div> 
              <p><label> <?php  echo form_radio($uplaod_img_no); ?> None &nbsp; </label> </p> 
             
         </div> 

          <p><label for='members'>Status</label><br/> <?php echo form_dropdown('members',$member_options) ?> </p>  
          <p><label for='status'>Status</label><br/> <?php echo form_dropdown('status',$options) ?> </p>
          
          <p><label for='parent'>Category Parent</label><br/> <?php echo form_dropdown('parentid',$categories) ?></p>
          
</fieldset>  


  
 






          <?php echo form_submit(array('name' => 'save'),'Create Category'); ?> 
          <?php // echo form_button(array('name' => 'cancel'),'Cancel'); ?>
          
</div> 
<?php echo form_close();?>





</body>
</html>
