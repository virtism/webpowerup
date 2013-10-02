<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Creat A Testimonial </title>
    
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

<h1> Creat A Testimonial </h1>

<p align="center"><h2>Put data in fields ...</h2></p>
<div id="default">
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
 <?php
 
    $attributes = array('class' => 'contact', 'id' => 'reg_form' , 'name' => 'reg_form');
    echo form_open(base_url().index_page().'Create_Testimonial/create_testimonial', $attributes); 
        
   
   $publish_yes = array('name' => 'publish', 'id' => 'publish','value' => '1','checked' => set_radio('publish', '1', TRUE)); 
   $publish_no = array('name' => 'publish', 'id' => 'publish','value' => '0','checked' => set_radio('publish', '0', FALSE)); 

   $form_demo_menu_rd = array('name' => 'form_main_menu', 'id' => 'form_main_menu','value' => 'Demo Menu','checked'  => set_radio('form_main_menu', '0'));          
   $form_main_menu_rd = array('name' => 'form_main_menu', 'id' => 'form_main_menu','value' => 'Main Menu','checked'  => set_radio('form_main_menu', '0',TRUE)); 
   $form_user_menu_rd = array('name' => 'form_main_menu', 'id' => 'form_main_menu','value' => 'User Menu', 'checked' => set_radio('form_main_menu', '0'));    
   
   $dont_creat_link = array('name' => 'form_main_menu', 'id' => 'form_main_menu','value' => 'Dont Create Link', 'checked' => set_radio('form_main_menu', '1',FALSE));   
   
   $options_parent = array(
                  '1'  => 'Home',
                  '2'  => 'About us',
                  '3'  => 'About Company',
                  '4'  => 'None',
                ); 
                 
     $body = array('name'  => 'body', 'id' => 'ck_content','value'  => set_value('body','<p>put  Information here ...</p>'));       
?>

<fieldset>
<legend>Publish Testinomial Page </legend>
  <p>
    <?php  echo form_radio($publish_no); ?> No  <br />                     
    <?php  echo form_radio($publish_yes); ?> Yes <br />
    
  </p>


</fieldset>

<fieldset>
<legend>Select A Menu</legend>
 <p>
    <?php  echo form_radio($form_main_menu_rd); ?> Main Menu  <br />                     
    <?php  echo form_radio($form_user_menu_rd); ?> User Menu  <br />
    <?php  echo form_radio($form_demo_menu_rd); ?> Demo Menu  <br />
  <?php echo form_radio($dont_creat_link); ?> None (Do not create a link) just show me link after page save  <br />
 Parent Item : <?php echo form_dropdown('parent', $options_parent, '4');  ?>  (Use None If you are Unsure )<br />
  
 </p>
</fieldset> 
<fieldset>
<legend>Create Your Page Below</legend>
         <?php echo form_textarea($body); ?>  <br />
         <?php echo display_ckeditor($ckeditor); ?>

</fieldset> 

          <?php echo form_submit(array('name' => 'save'),'Save'); ?> 
          <?php echo form_button(array('name' => 'cancel'),'Cancel'); ?>
 
<?php echo form_close();?>
</div>
</body>
</html>