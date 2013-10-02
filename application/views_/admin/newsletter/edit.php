
<!--start Ckeditor and ckfinder files-->
<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<!--end Ckeditor and ckfinder files-->

<h1>Edit  Newsletter </h1>

<p align="center"><h2>Put data in fields ...</h2></p>

<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p>
 <?php
 
    $attributes = array('class' => 'contact', 'id' => 'reg_form' , 'name' => 'reg_form');
    echo form_open(base_url().index_page().'administrator/newsletter/edit_newsletter', $attributes); 
    echo form_hidden('id',$values[0]['news_id']);  
    
        
   $subject = array('name' => 'subject','id' => 'subject', 'size' => '40', 'value' => set_value('subject',$values[0]['news_subject']));
   $body = array('name'  => 'body', 'id' => 'ck_content','value'  => set_value('body', $values[0]['news_body']));
   $send_yes = array('name' => 'send_now', 'id' => 'send_now','value' => '1','checked' => set_radio('send_now', '1', TRUE)); 
   $send_no = array('name' => 'send_now', 'id' => 'send_now','value' => '0','checked' => set_radio('send_now', '0', FALSE)); 
   
   
   $user_gruop_options = array('Register Users'  => 'Register Users', 'Free Users'  => 'Free Users', 'Clients'  => 'Clients' );
      
    
?>
<fieldset>
<legend>Newsletter Subject</legend>
         <?php echo form_input($subject); ?> 

</fieldset>  
<fieldset>
<legend>Newsletter Body</legend>
         <?php echo form_textarea($body); ?>  <br />
          <?php echo display_ckeditor($ck_data['ckeditor']); ?> 

</fieldset> 
<fieldset>
<legend>Newsletter Recipients Group</legend>
    <?php 
        $default = '';                
     switch ($values[0]['news_recipient_group'])
            {
            case 'Register Users':
                  $default = 'Register Users'; 
                  break;
            case 'Free Users':
                   $default = 'Free Users';
                  break;
            case 'Registered Users':
                   $default = 'Registered Users';
                  break;
            case 'Clients':
                   $default = 'Clients';
                  break;

            }
      ?>
         <?php echo form_dropdown('user_group', $user_gruop_options, $default); ?>  <br />
          

</fieldset> 
  
 




<fieldset>
<legend>Send Now ?</legend>
  <p>
    <?php  echo form_radio($send_no); ?> No  <br />                     
    <?php  echo form_radio($send_yes); ?> Yes <br />
    
  </p>


</fieldset>


          <?php echo form_submit(array('name' => 'save'),'Save'); ?> 
          <?php echo form_button(array('name' => 'cancel'),'Cancel'); ?>
 
<?php echo form_close();?>
