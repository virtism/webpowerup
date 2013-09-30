<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Management </title>
<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->
</head>
<body>

<h1>Contact Management </h1>

<p align="center"><h2>ADD A CONTACT</h2></p>

<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
 <?php
 
    $attributes = array('class' => 'contact', 'id' => 'contact_form');
    echo form_open(base_url().index_page().'Add_Contact/save_contact', $attributes); 
        
    $contact_name = array(
              'name'        => 'contact_name',
              'id'          => 'contact_name',
            //  'maxlength'   => '100',
             // 'size'        => '50',
           //   'style'       => 'width:15%',
              'value'       => set_value('contact_name','Contact Name')
            );
     $contact_country = array(
              'name'        => 'contact_country',
              'id'          => 'contact_country',
             // 'maxlength'   => '100',
             // 'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('contact_country','Contact Country')
            );
    $contact_state = array(
              'name'        => 'contact_state',
              'id'          => 'contact_state',
            //  'maxlength'   => '100',
             // 'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('contact_state','Contact State')
            );
    $contact_city = array(
              'name'        => 'contact_city',
              'id'          => 'contact_city',
             // 'maxlength'   => '100',
             // 'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('contact_city','Contact City')
            );
   $contact_address = array(
              'name'        => 'contact_address',
              'id'          => 'contact_address',
            //  'maxlength'   => '100',
           //   'size'        => '50',
            //  'style'       => 'width:15%',
              'value'       => set_value('contact_address','Contact Address')
            );                                                             
   $contact_zip = array(
              'name'        => 'contact_zip',
              'id'          => 'contact_zip',
           //   'maxlength'   => '100',
             // 'size'        => '50',
            //  'style'       => 'width:15%',
              'value'       => set_value('contact_zip','Contact ZIP/Postal')
            );
   $contact_position = array(
              'name'        => 'contact_position',
              'id'          => 'contact_position',
            //  'maxlength'   => '100',
           //   'size'        => '50',
            //  'style'       => 'width:15%',
              'value'       => set_value('contact_position','Contact Position')
            );
   $contact_phone = array(
              'name'        => 'contact_phone',
              'id'          => 'contact_phone',
            //  'maxlength'   => '100',
           //   'size'        => '50',
            //  'style'       => 'width:15%',
              'value'       => set_value('contact_phone','Contact Phone')
            );
   $contact_fax = array(
              'name'        => 'contact_fax',
              'id'          => 'contact_fax',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('contact_fax','Contact Fax')
            );  
   $contact_google_code = array(
              'name'        => 'contact_google_code',
              'id'          => 'contact_google_code',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('contact_google_code','Contact Google Code')
            );
   $contact_extra_info = array(
              'name'        => 'contact_extra_info',
              'id'          => 'ck_content',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => set_value('contact_extra_info','<p>Contact Extra Information</p>')
            );
   $contact_publish_yes = array(
              'name'        => 'contact_publish',
              'id'          => 'contact_publish',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => '1',
              'checked'     => set_radio('contact_publish', '1', TRUE)
            );  
   $contact_publish_no =       array(
              'name'        => 'contact_publish',
              'id'          => 'contact_publish',
            //  'maxlength'   => '100',
            //  'size'        => '50',
             // 'style'       => 'width:15%',
              'value'       => '0',
              'checked'     => set_radio('contact_publish', '0',FALSE)
            );  
            
    $main_menu_chk = array(
                'name'        => 'main_menu_chk',
                'id'          => 'main_menu_chk',
                'value'       => 'main',
                'checked'     => TRUE,
                'style'       => 'margin:10px',
                ); 
    $category_menu_chk = array(
                'name'        => 'category_menu_chk',
                'id'          => 'category_menu_chk',
                'value'       => 'category',
                'checked'     =>'',
                'style'       => 'margin:10px',
                );
     $default_menu_chk = array(
                'name'        => 'default_menu_chk',
                'id'          => 'default_menu_chk',
                'value'       => 'default',
                'checked'     => '',
                'style'       => 'margin:10px',
                );
                
     $dont_creat_link = array(
              'name'        => 'dont_creat_link',
              'id'          => 'dont_creat_link',
            //  'maxlength'   => '100',
            //  'size'        => '50',
            //  'style'       => 'width:15%',
              'value'       => '1',
              'checked'     => set_radio('dont_creat_link', '1',FALSE)
            );  
            
     $options_parent = array(
                  '1'  => 'Home',
                  '2'  => 'About us',
                  '3'  => 'About Company',
                  '4'  => 'None',
                );
         
    
     $contact_exist_title = array(
              'name'        => 'contact_exist_title',
              'id'          => 'contact_exist_title',
            //  'maxlength'   => '100',
            //  'size'        => '50',
            //  'style'       => 'width:15%',
              'value'       => set_value('contact_fax','Contact Us')
            );     

      $options_menu = array(
                  '1'  => 'Main Menu',
                  '2'  => 'Demo 2',
                  '3'  => 'User Menu',
                );
      $publish_chk = array(
                'name'        => 'publish_chk',
                'id'          => 'publish_chk',
                'value'       => '1',
                'checked'     => TRUE,
                'style'       => 'margin:10px',
                );           
    
?>
<fieldset>
<legend>Contact Name</legend>
         <?php echo form_input($contact_name); ?> 

</fieldset>  
<fieldset>
<legend>Contact Details</legend>
          <?php echo form_input($contact_country); ?> <br />  
          <?php echo form_input($contact_state); ?>   <br />
          <?php echo form_input($contact_city); ?>    <br />
          <?php echo form_input($contact_address); ?> <br />
          <?php echo form_input($contact_zip); ?>     <br />
          <?php echo form_input($contact_position); ?><br />
          <?php echo form_input($contact_phone); ?>   <br />
          <?php echo form_input($contact_fax); ?>     <br />
          <?php echo form_input($contact_google_code); ?>    <br />
          <?php echo form_textarea($contact_extra_info); ?>  <br />
          <?php echo display_ckeditor($ckeditor); ?>
</fieldset>

<fieldset>
<legend>Select A Menu</legend>
 <p>
  <?php echo form_checkbox($main_menu_chk);  ?>   Main Menu   <br />                     
  <?php echo form_checkbox($category_menu_chk);  ?> Category Menu  <br />
  <?php echo form_checkbox($default_menu_chk);  ?>  Default Menu  <br />
  <?php echo form_radio($dont_creat_link); ?> None (Do not create a link) just show me link after page save  <br />
 Parent Item : <?php echo form_dropdown('parent', $options_parent, '4');  ?>  (Use None If you are Unsure )<br />
  The link text that will be displayed in the menu(s) Selected in the previous step.
 </p>
</fieldset>  
  
<fieldset>
<legend>Existing Menu Links to the Contact Page</legend>
    <fieldset>
    <p>Title  <?php echo form_input($contact_exist_title); ?>
       Menu     <?php echo form_dropdown('menu', $options_menu, '1');  ?>
       Published ? <?php echo form_checkbox($publish_chk);  ?>  </p>
    </fieldset>
</fieldset>

<fieldset>
<legend>Publish</legend>
        <p> <?php  echo form_radio($contact_publish_yes); ?> Yes     <br />
            <?php  echo form_radio($contact_publish_no); ?>   No  </p> 
          
          
</fieldset>
          <?php echo form_submit(array('name' => 'register'),'Save'); ?> 
          <?php echo form_button(array('name' => 'cancel'),'Cancel'); ?>
 
<?php echo form_close();?>
</body>
</html>