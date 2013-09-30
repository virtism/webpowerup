<script type="text/javascript">
/*$.validator.setDefaults({
    submitHandler: function() { alert("submitted!"); }
});   */
$(document).ready(function() {
    
	// validate signup form on keyup and submit
    $("#registerform").submit(function(){
		
		var submitFlag = 1;
		
		if ( $("#fname").val() == "" )
		{
			alert("Please enter first name");
			submitFlag = 0;
		}
		else if ( $("#lname").val()== "" )
		{
			alert("Please enter first name");
			submitFlag = 0;
		}
		
		if ( submitFlag == 1)
		{
			return true;
		}
		return false;
		
	});
     
    
    
});
</script>
<style type="text/css">
/*#registerform { width: 500px; }
#registerform label { width: 250px; }  */
#registerform label.error, #commentForm input.submit { margin-left: 0px; color:red; }
#signupForm { width: 670px; }
#signupForm label.error {
    margin-left: 10px;
    width: auto;
    display: inline;
}
#newsletter_topics label.error {
    display: none;
    margin-left: 103px;
}
</style>
<h2><?php echo $title;?></h2>
<p class="register-note">
           The form below allows you to create a profile which is necessary to place orders. 
           Do not forget that this information is essential to use our services correctly.
             <br>
            <br>
        
        The fields marked with <span class="data-required">*</span> are mandatory.
</p>
<div style="float:left;width:65%;">
	<?php
    $attributes = array('class' => 'contact', 'id' => 'registerform' ,  'name' => 'registerform',  'onsubmit'=>'javascript: return checkRegFormFields(this);' );
    echo form_open($path.'MyAccount/account',$attributes);
    echo form_hidden('action','updat_account');
    echo form_hidden('customer_id',$customer['customer_id']);
   // echo form_hidden('tag_tab',$tag_tab);
    
    $f_name = array('name'=>'fname','id'=>'fname' , 'maxlength' => '32' ,'class' => 'required', 'value' => set_value('f_name',$customer['customer_fname'])); 
    $last_name = array('name'=>'lname','id'=>'lname' , 'maxlength' => '32' , 'class' => 'required','value' => set_value('last_name',$customer['customer_lname'])); 
    $company = array('name'=>'company','id'=>'company','size'=>'32' , 'maxlength' => '32' ,'class' => 'optional', 'value' => set_value('company',$customer['customer_company']));   
    $url = array('name'=>'url','id'=>'url','size'=>'32' , 'maxlength' => '64' ,'class' => 'optional url', 'value' => set_value('url',$customer['customer_url']));      
    $email = array('name'=>'email','id'=>'email', 'class' => 'required email' ,'size'=>'32' ,'readonly'=>"readonly", 'maxlength' => '128' , 'value' => set_value('email',$customer['customer_email'])); 
    $group_code = array('name'=>'group_code','id'=>'group_code','size'=>'32' , 'value' => set_value('group_code',$customer['group_code'])); 
  //  $post_code = array('name' => 'post_code', 'id' => 'post_code', 'size'=>'32' , 'value' => set_value('group_code',$customer['password']));     
  //  $password = array('name' => 'password', 'id' => 'passwd1', 'class' => 'input-required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',$customer['password']));    
  //  $passconf = array('name' => 'passconf', 'id' => 'passwd2', 'class' => 'input-required', 'size'=>'32' , 'maxlength' => '64', 'value' => set_value('f_name',$customer['password']));    
?> 
   
<table cellspacing="1" summary="Register" class="" style="margin-left: 20px; width:65%;">
                    <tbody>
                        
            <tr>
                <td class="register-section-title" colspan="3">
                    <div>
                        <label>Personal information</label>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td ><span style="width:75px !important; display:block;">First name</span></td>
                <td class="data-required">*</td>
                <td >
                    <?php echo form_input($f_name) ?>
                </td>
            </tr>
            <tr>
                <td class="data-name">Last name</td>
                <td class="data-required">*</td>
                <td>
                    <?php echo form_input($last_name) ?>
                </td>
            </tr>
           <!-- <tr>
                <td class="data-name"><label for="company">Company</label></td>
                <td>&nbsp;</td>
                <td>
                    <?php echo form_input($company) ?>
                </td>
            </tr>
            <tr>
                <td class="data-name"><label for="url">Web site</label></td>
                <td>&nbsp;</td>
                <td>
                    <?php echo form_input($url) ?>
                </td>
            </tr>      -->   
            <tr>
            <td class="register-section-title" colspan="3">
                <div>
                    <label>Account information</label>
                </div>
            </td>
        </tr>
    
    <tr>
        <td class="data-name"><label for="email">Email</label></td>
        <td class="data-required">*</td>
        <td>
            <?php echo form_input($email) ?>
            <div style="display: none;" class="note-box" id="email_note">Make sure you enter a valid email address because the store will send you notifications to this address.</div>
        </td>
    </tr>
    
    
                    

 
<!--   <tr style="display:none;"><td><input type="hidden" value="N" id="password_is_modified" name="password_is_modified"></td></tr>
   <tr>
      <td class="data-name"><label for="passwd1">Password</label></td>
      <td class="data-required">*</td>
      <td>
          <?php echo form_password($password) ?>
      </td>
   </tr>
   <tr>
      <td class="data-name"><label for="passwd2">Confirm password</label></td>
      <td class="data-required">*</td>
      <td>
          <?php echo form_password($passconf) ?>
          
          <span class="validate-mark"> <img width="15" height="15" alt="" src="/myclinic/skin/common_files/images/spacer.gif"></span>
      </td>
   </tr> -->                 
   <tr>
      <td class="register-newbie-note" colspan="3" style="padding-left: 162px;;">
          I accept the <a target="_blank" onclick="javascript:popupOpen(this.href, '', {width:800,height:600}); return false;" href="#">"Terms &amp; Conditions"</a>
      </td>
   </tr>                     
   <tr>                      
      <td class="button-row center" colspan="3" align="center" style="padding: 20px 0px 20px 0px;">
          <div class="center">
                <!--<button title="Submit" type="submit" class="button main-button">
              <span class="button-right"><span class="button-left">Submit</span></span>
              </button> -->
              <?php   echo form_submit('submit','Continue'); ?> 
          </div>
      </td>                      
   </tr>
  </tbody>
</table>
<?php
 
echo form_close();
 if($this->config->item('seo_url') == 'On')
	{
		
		$path = 'http://'.$_SERVER['SERVER_NAME'].'/';			
	}
	else
	{
		$path =  base_url().index_page();
	}
?>
</div>


<div style="float:left;width:35%;">
  <h2>My Account</h2>
  <div class="contentText">
    <ul class="accountLinkList">
      <li><span class=""></span><a href="<?=$path?>MyAccount/account">My account information.</a></li>
      <li><span class=""></span><a href="<?=$path?>MyAccount/AddressBook"> my address book.</a></li>
      <li><span class=""></span><a href="<?=$path?>MyAccount/password_change">Change  password.</a></li>
      
      <li><span class=""></span><a href="<?=$path?>group_managment/">Edit Groups</a></li>
      
      <?php
	  if($private_page_exist)
	  { ?>
      <li><span class=""></span><a href="<?=$path?>MyAccount/private_pages">Private Pages</a></li>
      <?php
	  } ?>
      
      
    </ul>
  </div>
 <? //print_r($_SESSION['login_info']); ?>
  <?php if(isset($order_exist) && $order_exist >0){ ?>
	  <h2>My Orders</h2>  
	  <div class="contentText">
		<ul class="accountLinkList">
		  <li><span class=""></span><a href="<?=$path?>orders/order_site_list">View the orders I have made.</a></li>			
		</ul>
	  </div>
<? } ?>
<!--  <h2>E-Mail Notifications</h2>
  <div class="contentText">
    <ul class="accountLinkList">
      <li><span class=""></span><a href="#">Subscribe or unsubscribe from newsletters.</a></li>
      <li><span class=""></span><a href="#"> my product notification list.</a></li>
    </ul>
  </div>    -->
  
  <?php if(isset($invoice_exist) && $invoice_exist == 1){ ?>
    <h2>Invoices</h2>
	<div class="contentText">	
		<ul class="accountLinkList">
		 	<li><span class=""></span><a href="<?=$path?>MyAccount/invoices">Invoices</a></li>		 
		</ul>
	</div>
  
<?php } ?>
  
 <?php if(($tickets_exist) ) { ?>
    <h2>Tickets</h2>
	<div class="contentText">	
		<ul class="accountLinkList">
		 	<li><span class=""></span><a href="<?=$path?>ticket/my_ticket">My Ticket.</a></li>		 
		</ul>
	</div>
  
<?php } ?>
  <?php if(isset($room_exist) && $room_exist > 0) { ?>
    <h2>Video Conference</h2>
	<div class="contentText">	
		<ul class="accountLinkList">
		 	<li><span class=""></span><a href="<?=$path?>room_management/user_rooms/">Meeting List</a></li>		 
		</ul>
	</div>
  
<?php } ?>
<?php if(isset($webinar_exist) && $webinar_exist > 0) { ?>
    <h2>Webinars</h2>
	<div class="contentText">	
		<ul class="accountLinkList">
		 	<li><span class=""></span><a href="<?=$path?>webinar_site/user_webinar/">webinar List</a></li>		 
		</ul>
	</div>
  
<?php } ?>
</div>




