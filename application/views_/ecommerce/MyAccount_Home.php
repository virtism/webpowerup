<div class="grid_16 push_4" id="bodyContent">
<div class="contentContainer">
  <h2>My Account</h2>
  <div class="contentText">
    <ul class="accountLinkList">
      <li><span class=""></span><a href="<?=base_url().index_page()?>MyAccount/account">My account information.</a></li>
      <li><span class=""></span><a href="<?=base_url().index_page()?>MyAccount/AddressBook"> my address book.</a></li>
      <li><span class=""></span><a href="<?=base_url().index_page()?>MyAccount/password_change">Change  password.</a></li>
      
      <li><span class=""></span><a href="<?=base_url().index_page()?>group_managment/">Edit Groups</a></li>
      
      <?php
	  if($private_page_exist)
	  { ?>
      <li><span class=""></span><a href="<?=base_url().index_page()?>MyAccount/private_pages">Private Pages</a></li>
      <?php
	  } ?>
      
      
    </ul>
  </div>
 <? //print_r($_SESSION['login_info']); ?>
  <?php if(isset($order_exist) && $order_exist >0){ ?>
	  <h2>My Orders</h2>  
	  <div class="contentText">
		<ul class="accountLinkList">
		  <li><span class=""></span><a href="<?=base_url().index_page()?>orders/order_site_list">View the orders I have made.</a></li>			
		</ul>
	  </div>
<? } ?>
  <h2>E-Mail Notifications</h2>
  <div class="contentText">
    <ul class="accountLinkList">
      <li><span class=""></span><a href="#">Subscribe or unsubscribe from newsletters.</a></li>
      <li><span class=""></span><a href="#"> my product notification list.</a></li>
    </ul>
  </div>
  
  <?php if(isset($invoice_exist) && $invoice_exist == 1){ ?>
    <h2>Invoices</h2>
	<div class="contentText">	
		<ul class="accountLinkList">
		 	<li><span class=""></span><a href="<?=base_url().index_page()?>MyAccount/invoices">Invoices</a></li>		 
		</ul>
	</div>
  
<?php } ?>
  
 <?php if(($tickets_exist) ) { ?>
    <h2>Tickets</h2>
	<div class="contentText">	
		<ul class="accountLinkList">
		 	<li><span class=""></span><a href="<?=base_url().index_page()?>ticket/my_ticket">My Ticket.</a></li>		 
		</ul>
	</div>
  
<?php } ?>
  <?php if(isset($room_exist) && $room_exist > 0) { ?>
    <h2>Video Conference</h2>
	<div class="contentText">	
		<ul class="accountLinkList">
		 	<li><span class=""></span><a href="<?=base_url().index_page()?>room_management/user_rooms/">Meeting List</a></li>		 
		</ul>
	</div>
  
<?php } ?>
<?php if(isset($webinar_exist) && $webinar_exist > 0) { ?>
    <h2>Webinars</h2>
	<div class="contentText">	
		<ul class="accountLinkList">
		 	<li><span class=""></span><a href="<?=base_url().index_page()?>webinar_site/user_webinar/">webinar List</a></li>		 
		</ul>
	</div>
  
<?php } ?>
</div>
</div>