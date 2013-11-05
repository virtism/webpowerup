<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SignUp Form</title>
<?
//echo base_url();exit;
?>
</head>
<body>
<? //echo $msg;?>



<fieldset>
<legend>Step 1 :</legend> 
<p><div class="error_msg" align="center"> <?php echo validation_errors(); ?> </div></p> 
<?php
   
   $attributes = array('method' => 'post', 'id' => 'user' , 'name' => 'user');
    echo form_open(base_url().index_page().'UsersController/signup_step4', $attributes); 
    
    echo form_hidden('action','step4');
    echo form_hidden('package',$package);
    echo form_hidden('user_fname',$user_fname);
    echo form_hidden('user_lname',$user_lname);
    echo form_hidden('log_in',$log_in);
    echo form_hidden('user_password',$user_password);
    echo form_hidden('user_email',$user_email);
  
  
    
 $site_title = array('name' => 'site_title','id' => 'site_title', 'size' => '40', 'value' => set_value('site_title','')); 
 $site_domain = array('name' => 'site_domain','id' => 'site_domain', 'size' => '40', 'value' => set_value('site_domain','')); 

 $type_of_site = array('Portfolio'  => 'Portfolio', 'Blog'  => 'Blog', 'Portal'  => 'Portal' ); 
 $site_category = array('Business'  => 'Business', 'IT'  => 'IT', 'Services'  => 'Services' );   
    
    
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">

    <tr>
        <td width="150px">
                Enter Your Website Title : 
        </td>
        <td>
                <?php echo form_input($site_title); ?> 
        </td>
    </tr>
    <tr>
        <td>
                Type Of Site : 
        </td>
        <td>
                <?php echo form_dropdown('type_of_site', $type_of_site, 'Portfolio'); ?>
        </td>
    </tr>
    <tr>
        <td>
                Category : 
        </td>
        <td>
                <?php echo form_dropdown('site_category', $site_category, 'Business'); ?>
        </td>
    </tr>
        
</table>
</fieldset> 
 
 <fieldset>
<legend>Step 2 :</legend>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    
   
   <tr>
        <td>
                Enter Your Website Domain : 
        </td>
        <td>
            <?php echo form_input($site_domain); ?>    
        </td>
    </tr>

</table>

<p>
            <input type="button" value="Back" onclick="javascript: history.go(-1);" />
          
            <?php echo form_submit(array('name' => 'next'),'Continue'); ?> 
            <?php //echo form_button(array('name' => 'cancel'),'Cancel'); ?>  

</p>
</fieldset>  
</form>


</body>
</html>